/**
* Paste this code into functions.php
*/

// Add Shortcode
function custom_ajotka_shortcode( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'attribute' => '',
		),
		$atts,
		'custom-filter'
	);

}
add_shortcode( 'custom-ajotka-shortcode', 'custom_ajotka_shortcode' );
