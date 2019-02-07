<?php

defined( 'ABSPATH' ) || exit;

/**
 * Register widget
 */

function scc_tocw_register_toc_widget() {
	register_widget( 'SCC_TOC_Widget' );
}
add_action( 'widgets_init', 'scc_tocw_register_toc_widget' );