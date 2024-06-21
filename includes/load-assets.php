<?php
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style(
		'afzaliwp-wallet-front-style',
		AFZ_WALLET_ASSETS_URL . 'front/front.css',
		'',
		time()
	);
} );

add_action( 'admin_enqueue_scripts', function () {
	wp_enqueue_style(
		'afzaliwp-wallet-admin-style',
		AFZ_WALLET_ASSETS_URL . 'admin/admin.css',
		'',
		time()
	);
} );