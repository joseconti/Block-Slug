<?php

/**
 * Block Slug
 *
 * @package Block Slug
 * @author José Conti
 * @copyright 2019 José Conti
 * @license GPL-3.0+
 *
 * Plugin Name: Block Slug
 * Plugin URI: https://github.com/joseconti/Block-Slug
 * Description: This plugin allow you to block the slug edit
 * Version: 1.0.0
 * Author: José Conti
 * Author URI: https://www.joseconti.com/
 * Tested up to: 5.2
 * WC requires at least: 3.0
 * WC tested up to: 3.6
 * Text Domain: block-slug
 * Domain Path: /languages/
 * Copyright: (C) 2017 José Conti.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

define( 'BLOCK_SLUG_VERSION', '1.0.0' );
define( 'BLOCK_SLUG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'BLOCK_SLUG_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'BLOCK_SLUG_INCLUDES', BLOCK_SLUG_PLUGIN_PATH . 'includes/' );

add_action( 'admin_init', 'block_slug_init' );

function block_slug_init() {
	include_once BLOCK_SLUG_INCLUDES . 'class-block-slug-admin-settings.php';
	include_once BLOCK_SLUG_INCLUDES . 'metabox.php';
	include_once BLOCK_SLUG_INCLUDES . 'functions.php';
}
