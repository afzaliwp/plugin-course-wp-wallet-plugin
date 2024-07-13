<?php
add_action( 'admin_menu', function () {
	add_menu_page(
		__( 'AfzaliWP Wallet', 'afzaliwp-wallet' ),
		__( 'Wallet', 'afzaliwp-wallet' ),
		'manage_options',
		'afzaliwp-wallet',
		'afzaliwp_wallet_admin_menu_callback',
		'dashicons-money-alt',
		50
	);
} );

function afzaliwp_wallet_admin_menu_callback() {
	if ( isset( $_POST['afzaliwp-wallet-action-user'] ) ) {
		$current_balance = $_POST['current-user-current-balance'];
		$user_id = $_POST['current-user-id'];
		$balance_change = intval( $_POST['wallet-amount-to-change'] );
		$action = $_POST['wallet-action'];

		if ( 'increase' === $action ) {
			update_user_meta( $user_id, 'afzaliwp_wallet_balance', $current_balance + $balance_change );
		}
		if ( 'decrease' === $action ) {
			update_user_meta( $user_id, 'afzaliwp_wallet_balance', $current_balance - $balance_change );
		}
	}

	$data = [
		'users'         => afzaliwp_get_users(),
		'selected_user' => afzaliwp_get_selected_user(),
	];

	include_once AFZ_WALLET_TPL_DIR . 'admin-wallet.php';
}

function afzaliwp_get_users() {
	return get_users( [
		'orderby' => 'email',
	] );
}

function afzaliwp_get_selected_user() {
	if ( isset( $_POST[ 'afzaliwp-wallet-select-user' ] ) ) {
		$user = get_user_by( 'id', intval( $_POST[ 'wallet-user' ] ) );

		return [
			'ID'           => $user->ID,
			'email'        => $user->user_email,
			'display_name' => $user->display_name,
			'balance'      => floatval( get_user_meta( $user->ID, 'afzaliwp_wallet_balance', true ) ),
		];
	}

	return false;
}