<?php
/**
 * Output main form fields on the widget editor interface
 */

defined( 'ABSPATH' ) || exit;

?>
<p>
	<label for="<?php esc_attr_e( $this->get_field_id( $field_name ) ) ?>">
		<?php echo $field['label'] . ':' ?>
	</label>

	<input
		class="widefat"
		id="<?php esc_attr_e( $this->get_field_id( $field_name ) ) ?>"
		name="<?php esc_attr_e( $this->get_field_name( $field_name ) ) ?>"
		type="<?php esc_attr_e( $field['type'] ) ?>"
		value="<?php esc_attr_e( $value ) ?>"
	>
</p>
<?php

// Optional description set in $field array in __construct()
if ( array_key_exists( 'description', $field ) ) {
	?>
	<p class="description"><?php echo $field['description'] ?></p>
	<?php
}
