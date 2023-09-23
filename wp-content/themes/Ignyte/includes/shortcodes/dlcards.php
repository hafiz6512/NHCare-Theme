<?
add_shortcode('dlcard', 'dlcard_shortcode');
function dlcard_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'thetitle' => '',
		'thecontent' => '',
		'thefile' => '',
		'linkcontent' => 'click to download',
		'thetype' => '',
	), $atts ) );
	
	return "<div class=\"dlcard {$thetype}\"><h4>{$thetitle}</h4><p>{$thecontent}</p><div class=\"cardlink\"><a href=\"/wp-content/uploads/{$thefile}\">{$linkcontent}</a></div></div>";
}