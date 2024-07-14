<?php

function afzaliwp_wallet_set_cookie() {
	if (
		isset( $_GET[ 'use_balance' ] ) &&
		'1' === $_GET[ 'use_balance' ]
	) {
		setcookie( 'afzaliwp-wallet-use-balance', true, [
			'path' => '/'
		] );
	}
}

add_action( 'plugins_loaded', 'afzaliwp_wallet_set_cookie' );

function afzaliwp_use_wallet_button() {
	if ( isset( $_COOKIE[ 'afzaliwp-wallet-use-balance' ] ) ) {
		$cookie  = $_COOKIE[ 'afzaliwp-wallet-use-balance' ];
		$balance = get_user_meta( get_current_user_id(), 'afzaliwp_wallet_balance', true );
		if ( '1' === $cookie ) {
			?>
			<tr>
				<td><?php _e( 'Wallet balance to use: ' ); ?></td>
				<td><?php echo number_format( $balance ); ?></td>
			</tr>
			<?php
			return;
		}
	}
	?>
	<tr>
		<td><a href="?use_balance=1" class="button alt wp-element-button"><?php _e( 'Use Wallet Balance' ); ?></a></td>
		<td></td>
	</tr>
	<?php
}

add_action( 'woocommerce_review_order_after_cart_contents', 'afzaliwp_use_wallet_button' );

function afzaliwp_use_wallet_balance( \WC_Cart $cart ) {
	if ( isset( $_COOKIE[ 'afzaliwp-wallet-use-balance' ] ) ) {
		$balance = get_user_meta( get_current_user_id(), 'afzaliwp_wallet_balance', true );

		$cart->add_fee( __( 'Wallet Balance in use: ', 'afzaliwp-wallet' ), - $balance );
	}
}

add_action( 'woocommerce_cart_calculate_fees', 'afzaliwp_use_wallet_balance', 10, 1 );

function afzaliwp_wallet_order_processed( $order_id, $posted_data, \WC_Order $order ) {
	$order_total    = $order->get_total();
	$order_subtotal = $order->get_subtotal();

	$balance_used = floatval( $order_subtotal ) - floatval( $order_total );
	if ( $balance_used > 0 ) {
		$user_id = $order->get_customer_id();
		$balance = get_user_meta( $user_id, 'afzaliwp_wallet_balance', true );

		update_user_meta( $user_id, 'afzaliwp_wallet_balance', floatval( $balance ) - $balance_used );
	}

}

add_action( 'woocommerce_checkout_order_processed', 'afzaliwp_wallet_order_processed', 100, 3 );