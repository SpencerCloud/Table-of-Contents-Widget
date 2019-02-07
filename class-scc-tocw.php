<?php
/**
 * Set up widget class
 */

defined( 'ABSPATH' ) || exit;

/**
 * Set up widget class
 */

class SCC_TOC_Widget extends WP_Widget {
	/**
	 * Construct the widget
	 */
	function __construct() {
		$widget_ops = array(
			'classname' => 'scc_tocw',
			'description' => 'Table of Contents Widget - best used in sidebars',
		);

		parent::__construct( 'scc_tocw', 'Table of Contents', $widget_ops );

		$this->define();
	}

	/**
	 * Define field variables
	 */
	private function define() {

		/**
		 * Set fields in array to be used in form and update functions
		 */
		$this->fields = array(
			array(
				'name'			=> 'title',
				'label'			=> __( 'Title', 'scc-tocw' ),
				'default'		=> __( 'Table of Contents', 'scc-tocw' ),
				'type'			=> 'text',
			),
			array(
				'name'			=> 'scroll_to_offset',
				'label'			=> __( 'Scroll-To Offset (px)', 'scc-tocw' ),
				'description'	=> __( 'Number of pixels to offset from the top of the window when scrolling to a header.<br>This is often needed for themes with sticky headers.', 'scc-tocw' ),
				'default'		=> 0,
				'type'			=> 'number',
			),
			array(
				'name'			=> 'smooth_scroll_time',
				'label'			=> __( 'Smooth Scroll Time (ms)', 'scc-tocw' ),
				'description'	=> __( 'Number of milliseconds it takes to scroll to the heading.<br>Enter \'0\' for instantaneous scroll.<br>1000 milliseconds = 1 second', 'scc-tocw' ),
				'default'		=> 1000,
				'type'			=> 'number',
			),
		);

		/**
		 * Put publicy queryable post types in array to be used in form and update functions
		 */
		$this->public_post_types = get_post_types( array( 'public' => true ), 'objects' );

	}

	/**
	 * Get field values based on defaults or saved value
	 */
	private function get_field_value( $instance, $field, $field_name ) {

		// If this is the first instance, the array key will not exist
		if ( ! array_key_exists( $field_name, $instance ) ) {
			$value = $field['default'];
		} else {
			$value = $instance[$field_name];
		}

		return $value;

	}

	/**
	 * Form on widget editor screen
	 */
	public function form( $instance ) {

		foreach ( $this->fields as $field ) {
			$field_name = $field['name'];
			$value = $this->get_field_value( $instance, $field, $field_name );
			include dirname( __FILE__ ) . '/inc/form-fields-main.php';
		}
		include dirname( __FILE__ ) . '/inc/form-fields-post-types.php';

	}

	/**
	 * Save widget editor options
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		// Main fields
		foreach ( $this->fields as $field ) {
			$field_name = $field['name'];

			// If new value
			if ( null !== $new_instance[$field_name] ) {
				$instance[$field_name] = $new_instance[$field_name];
			}
		}

		// Post type fields
		foreach ( $this->public_post_types as $post_type ) {
			$post_type_name = $post_type->name;
			$instance[$post_type_name] = $new_instance[$post_type_name];
		}

		return $instance;

	}

	/**
	 * Enqueue widget script
	 */
	private function enqueue_widget_script() {

		wp_enqueue_script(
			'scc-tocw-script',
			plugins_url( 'toc-widget.js', __FILE__ ),
			array( 'jquery' ),
			filemtime( plugin_dir_path( __FILE__ ) . 'toc-widget.js' ),
			true
		);

	}

	/**
	 * Check against empty values for the widget variables
	 * This is a safeguard in case "0" values don't save
	 */
	private function check_script_var_empty_values( $var_string, $instance ) {

		error_log( print_r( $instance, true ) );

		if ( ! empty( $instance[$var_string] ) ) {
			$var_value = $instance[$var_string];
		} else {
			$var_value = 0;
		}

		return $var_value;

	}

	/**
	 * Localize PHP variables to be read in JavaScript file
	 */
	private function localize_widget_script_vars( $instance ) {

		// Check for empty values and fix on vulnerable variables
		$scroll_to_offset = $this->check_script_var_empty_values( 'scroll_to_offset', $instance );
		$smooth_scroll_time = $this->check_script_var_empty_values( 'smooth_scroll_time', $instance );

		// Send widget options to script (localize)
		$scc_tocw_opts = array(
			'scrollToOffset'	=> $scroll_to_offset,
			'smoothScrollTime'	=> $smooth_scroll_time,
		);
		wp_localize_script( 'scc-tocw-script', 'sccTocwOpts', $scc_tocw_opts );

	}

	/**
	 * Load widget script
	 */
	private function load_widget_script( $instance ) {
		$this->enqueue_widget_script();
		$this->localize_widget_script_vars( $instance );
	}

	/**
	 * Load widget style
	 */
	private function load_widget_style() {
		wp_enqueue_style( 'scc-tocw-style', plugins_url( 'toc-widget.css', __FILE__ ) );
	}

	/**
	 * Load widget assets
	 */
	private function load_widget_assets( $instance ) {

		// Do not load script & style if widget is not on the page
		if ( is_active_widget( false, false, $this->id_base, true ) ) {
			$this->load_widget_script( $instance );
			$this->load_widget_style();
		}

	}

	/**
	 * Get widget headers from content
	 */
	private function get_post_headers() {

		$headers = [];

		// Get post title as header # 0 and insert as first header in array
		$post_title = get_post()->post_title;

		$headers[0] = array(
			'header_type'		=> 'h1',
			'header_content'	=> $post_title,
			'header_id'			=> 0,
		);

		$header_num = 1; // Post title is header # 0

		/**
		 * Get post_content headers and lay it out in the widget area
		 */
		$post_content = get_post()->post_content;

		if ( ! empty( $post_content ) ) {

			$doc = new DOMDocument();
			libxml_use_internal_errors( true ); // Ignore warnings for special tags like nav, section, etc
			$doc->loadHTML( $post_content );
			libxml_clear_errors(); // Put error reporting back to normal
			$elements = $doc->getElementsByTagName( '*' );

			foreach ($elements as $element_num => $element) {

				switch ( $element->tagName ) {
					case 'h1':
					case 'h2':
					case 'h3':
					case 'h4':
					case 'h5':
					case 'h6':

						// Add tag and content to array
						$headers[$header_num] = array(
							'header_type'		=> $element->tagName,
							'header_content'	=> $element->textContent,
							'header_id'			=> $header_num,
						);
						$header_num++;

						break;
				}

			}

		}

		return $headers;

	}

	/**
	 * Check for title and display
	 */
	private function display_widget_title( $args, $instance ) {

		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}

	}

	/**
	 * Localize header array - send headers from PHP to JS
	 * This can probably be combined somehow with the other localization function
	 */
	private function localize_header_array( $headers ) {

		$scc_tocw_page_elements = array(
			'phpHeaders' => $headers,
		);
		wp_localize_script( 'scc-tocw-script', 'sccTocwPageElements', $scc_tocw_page_elements );

	}

	/**
	 * Include widget frontend output file for widget function
	 */
	private function include_widget_frontend_output( $headers ) {
		include dirname( __FILE__ ) . '/inc/frontend-output.php';
	}

	/**
	 * Check if widget should be displayed
	 */
	private function widget_display_check( $instance ) {

		$display_widget = true;

		// Don't show if current post type isn't checked, or if archive page
		if ( 'on' !== $instance[get_post_type()] || false === is_single() ) {
			$display_widget = false;
		}

		return $display_widget;

	}

	/**
	 * Post widget content on frontend
	 */
	public function widget( $args, $instance ) {

		$display_widget = $this->widget_display_check( $instance );

		if ( false === $display_widget ) {
			return;
		}

		echo $args['before_widget'];
		$this->display_widget_title( $args, $instance );
		$this->load_widget_assets( $instance );
		$headers = $this->get_post_headers();
		$this->localize_header_array( $headers );
		$this->include_widget_frontend_output( $headers );
		echo $args['after_widget'];

	}
}