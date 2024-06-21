<?php
/**
 * Plugin Name:       AfzaliWP Wallet Plugin
 * Description:       A wallet plugin to accept payments and allow users to have balance on the website
 * Version:           0.1.0
 * Plugin URI:        https://afzaliwp.com/
 * Author:            Mohammad Afzali
 * Author URI:        https://afzaliwp.com/
 * Text Domain:       afzaliwp-wallet
 * Domain Path:       /languages
 *
 */

define( 'AFZ_WALLET_INC_DIR', __DIR__ . '/includes/' );
define( 'AFZ_WALLET_TPL_DIR', __DIR__ . '/template/' );
define( 'AFZ_WALLET_LANG_DIR', __DIR__ . '/languages/' );
define( 'AFZ_WALLET_ASSETS_DIR', __DIR__ . '/assets/' );
define( 'AFZ_WALLET_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets/' );

load_plugin_textdomain( 'afzaliwp-wallet', false, basename( dirname( __FILE__ ) ) . '/languages' );

require_once __DIR__ . '/includes/models/wallet.php';
require_once __DIR__ . '/includes/helper.php';
require_once __DIR__ . '/includes/load-assets.php';
require_once __DIR__ . '/includes/admin-menu.php';

//Loading shortcodes
if ( ! is_admin() ) {
	require_once __DIR__ . '/includes/shortcodes/load-shortcodes.php';
}

