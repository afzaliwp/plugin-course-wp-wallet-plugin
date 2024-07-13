<?php

function afzaliwp_wallet_get_gateway_info() {
	return [
		'merchant'    => '4ced0a1e-4ad8-4309-9668-3ea3ae8e8897',
		'request_url' => 'https://api.zarinpal.com/pg/v4/payment/request.json',
		'verify_url'  => 'https://api.zarinpal.com/pg/v4/payment/verify.json',
		'gateway_url' => 'https://www.zarinpal.com/pg/StartPay/',
	];
}

function afzaliwp_wallet_get_gateway_messages() {
	return [
		"-9"  => "خطای اعتبار سنجی",
		"-10" => "ای پی و یا مرچنت کد پذيرنده صحيح نيست",
		"-11" => "مرچنت کد فعال نیست لطفا با تیم پشتیبانی ما تماس بگیرید",
		"-12" => "تلاش بیش از حد در یک بازه زمانی کوتاه.",
		"-15" => "ترمینال شما به حالت تعلیق در آمده با تیم پشتیبانی تماس بگیرید",
		"-16" => "سطح تایید پذیرنده پایین تر از سطح نقره ای است.",
		"100" => "عملیات موفق",
		"-30" => "اجازه دسترسی به تسویه اشتراکی شناور ندارید",
		"-31" => "حساب بانکی تسویه را به پنل اضافه کنید مقادیر وارد شده واسه تسهیم درست نیست",
		"-32" => "درصد های وارد شده درست نیست",
		"-34" => "مبلغ از کل تراکنش بیشتر است",
		"-35" => "تعداد افراد دریافت کننده تسهیم بیش از حد مجاز است",
		"-40" => "اتوریتی نامعتبر است",
		"-50" => "مبلغ پرداخت شده با مقدار مبلغ در وریفای متفاوت است",
		"-51" => "پرداخت ناموفق",
		"-52" => "خطای غیر منتظره با پشتیبانی تماس بگیرید",
		"-53" => "اتوریتی برای این مرچنت کد نیست",
		"101" => "تراکنش وریفای شده"
	];

}

function afzaliwp_wallet_create_payment( $amount, $description ) {
	$info = afzaliwp_wallet_get_gateway_info();

	$payload = [
		'merchant_id'  => $info[ 'merchant' ],
		'amount'       => intval( $amount ) * 10,
		'description'  => $description,
		'callback_url' => 'https://plugin.local/my-wallet/',
		'metadata'     => [
			'mobile' => '09123456789',
			'email'  => 'a@b.com',
		],
		'mobile'       => '09125553223',
		'email'        => 'b@a.com',
	];

	$response = wp_remote_post( $info[ 'request_url' ], [
		'method'      => 'POST',
		'timeout'     => 45,
		'redirection' => 5,
		'httpversion' => '1.1',
		'body'        => json_encode( $payload ),
		'headers'     => [
			'Content-Type' => 'application/json',
			'Accept'       => 'application/json',
		],
	] );

	if ( is_wp_error( $response ) ) {
		return __( 'There is something wrong with the payment.', 'afzaliwp-wallet' );
	} else {
		$body = wp_remote_retrieve_body( $response );
		$body = json_decode( $body );

		if ( $body->data->code === 100 ) {
			afzaliwp_wallet_add(
				get_current_user_id(),
				$amount,
				'pending',
				$description,
				serialize( [
					'authority' => $body->data->authority,
					'status'    => 'NOK',
				] ),
			);

			wp_redirect( $info[ 'gateway_url' ] . $body->data->authority );

			return __( 'Waiting for the gateway.', 'afzaliwp-wallet' );
		}
	}
}

function afzaliwp_wallet_verify_payment( $authority ) {
	$info         = afzaliwp_wallet_get_gateway_info();
	$messages     = afzaliwp_wallet_get_gateway_messages();
	$payment_data = afzaliwp_wallet_get( 'payment_info', $authority, true );

	$payload = [
		'merchant_id' => $info[ 'merchant' ],
		'amount'      => intval( $payment_data[ 0 ]->amount ) * 10,
		'authority'   => $authority,
	];

	$response = wp_remote_post( $info[ 'verify_url' ], [
		'method'      => 'POST',
		'timeout'     => 45,
		'redirection' => 5,
		'httpversion' => '1.1',
		'body'        => json_encode( $payload ),
		'headers'     => [
			'Content-Type' => 'application/json',
			'Accept'       => 'application/json',
		],
	] );

	if ( is_wp_error( $response ) ) {
		return __( 'There is something wrong with the payment.', 'afzaliwp-wallet' );
	}

	$body = wp_remote_retrieve_body( $response );
	$body = json_decode( $body );

	afzaliwp_wallet_update(
		[
			'payment_info' => serialize(
				[
					'authority' => $authority,
					'status'    => ( 100 === $body->errors->code || 101 === $body->errors->code ) ? 'OK' : 'NOK',
				]
			),
			'status'       => ( 100 === $body->errors->code || 101 === $body->errors->code ) ? 'success' : 'Failed',
		],
		[
			'ID' => $payment_data[ 0 ]->ID,
		] );

	if ( 100 === $body->errors->code ) {
		$current_balance = floatval( get_user_meta( get_current_user_id(), 'afzaliwp_wallet_balance', true ) );

		update_user_meta( get_current_user_id(), 'afzaliwp_wallet_balance', intval( $payment_data[ 0 ]->amount ) + $current_balance );
	}

	return $messages[ $body->errors->code ];
}