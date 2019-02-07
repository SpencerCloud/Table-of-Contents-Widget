<?php
/**
 * Table of Contents Widget output on the front-end
 */

defined( 'ABSPATH' ) || exit;

echo '<div class="scc-tocw-wrapper">';

$prev_h_num = false;

// Post links to each header in widget space
foreach ( $headers as $header_num => $header ) {

	// Get header number (1, 2, 3, 4, 5, or 6)
	$h_num = intval( substr( $header['header_type'], 1 ) );

	// Indentation by adding <ol> tags
	if ( $prev_h_num ) {
		if ( $prev_h_num < $h_num ) {

			// Find number of ol tags to insert
			$indentations = $h_num - $prev_h_num;

			for ( $indent = $indentations; $indent > 0; $indent--) {
				echo '<ol>';
			}
		}
	}

	// Unindentation by adding </ol> tags
	if ( $prev_h_num ) {
		if ( $prev_h_num > $h_num ) {

			$deindentations = $prev_h_num - $h_num;

			for ( $deindent = $deindentations; $deindent > 0; $deindent--) {
				echo '</ol>';
			}
		}
	}

	// Display headers within <li> tags
	if ( 0 !== $header_num ) {
		echo '<li>';
	}

	?>
	<a href="#" class="scc-tocw-link" data-scc-tocw-id="<?php echo $header['header_id'] ?>">
		<?php echo $header['header_content'] ?>
	</a>
	<?php

	if ( 0 !== $header_num ) {
		echo '</li>';
	}

	// Runs on last header, to close original <ol> tag
	if ( count( $headers ) === $header_num ) {
		echo '</ol>';
	}

	$prev_h_num = $h_num;
}

?>
</div>
<?php
