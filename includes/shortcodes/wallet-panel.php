<?php
add_shortcode( 'afzaliwp-wallet-panel', 'afzaliwp_wallet_panel_callback' );

function afzaliwp_wallet_panel_callback() {
	$data = [];

	if ( isset( $_POST['afzaliwp-wallet-go-payment'] ) ) {
		$message = afzaliwp_wallet_create_payment(
			$_POST['afzaliwp-wallet-payment-amount'],
			'wallet increase'
		);
		$data['message'] = $message;
	}

	if ( ! isset( $_POST['afzaliwp-wallet-go-payment'] ) && isset( $_GET['Authority'] ) ) {
		$authority = esc_sql( $_GET['Authority'] );
		$response_message = afzaliwp_wallet_verify_payment($authority);
		$data['message'] = $response_message;
	}
	ob_start();
	include_once AFZ_WALLET_TPL_DIR . 'wallet-panel.php';
	return ob_get_clean();
}