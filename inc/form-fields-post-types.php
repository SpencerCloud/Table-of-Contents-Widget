<?php
/**
 * Output generated post type fields on the widget editor interface
 */

defined( 'ABSPATH' ) || exit;

// Post type restriction settings - automatically gathered based on public post types
?>
<p>Show this widget on...</p>
<p>
	<?php foreach ( $this->public_post_types as $post_type ) {

		// error_log( print_r( $post_type, true ) );
		$post_type_name = $post_type->name;
		$post_type_label = $post_type->label;

		// If post type doesn't exist, checkbox default is on
		if ( ! empty( $instance[$post_type_name] ) ) {

			$instance[$post_type_name] = true;

		} else {

			$instance[$post_type_name] = false;

		} ?>

		<input
			id="<?php esc_attr_e( $this->get_field_id( $post_type_name ) ) ?>"
			name="<?php esc_attr_e( $this->get_field_name( $post_type_name ) ) ?>"
			class="checkbox"
			type="checkbox"
			<?php checked( $instance[$post_type_name] ) ?>
		>
		<label for="<?php esc_attr_e( $this->get_field_id( $post_type_name ) ) ?>">
			<?php esc_html_e( $post_type_label ) ?>
		</label>
		<br>

	<?php } ?>
</p>
<?php
