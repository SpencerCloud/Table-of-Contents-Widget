<?php
/*
 * Plugin Name: Table of Contents Widget
 * Description: An automatically generated table of contents for pages and posts that can be inserted into your theme's widget areas (works best in sidebars)
 * Version: 0.1
 * Author: Spencer Cloud
 * Author URI: https://spencercloud.com
 * Text Domain: scc-tocw
 */

defined( 'ABSPATH' ) || exit;

define( 'SCC_TOCW_PATH', dirname( __FILE__ ) );
define( 'SCC_TOCW_PLUGIN_FILE', __FILE__ );

include_once SCC_TOCW_PATH . '/functions.php';
include_once SCC_TOCW_PATH . '/class-scc-tocw.php';