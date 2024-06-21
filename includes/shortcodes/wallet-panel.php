<?php
add_shortcode( 'afzaliwp-wallet-panel', 'afzaliwp_wallet_panel_callback' );

function afzaliwp_wallet_panel_callback() {
	$data = [
		'sfdd', 'asdffda'
	];
	ob_start();
	include_once AFZ_WALLET_TPL_DIR . 'wallet-panel.php';
	return ob_get_clean();
}