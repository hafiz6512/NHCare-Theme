<?php
// Usage: [dir_item name="" value=""]
add_shortcode('dir_item', 'dir_item_shortcode');
function dir_item_shortcode($atts, $content = null) {
	extract( shortcode_atts( array(
		'name' => '',
		'value' => '',
	), $atts ) );
	ob_start(); ?>
	<!-- //START directory list item: -->
	<div class="row dir-item">
		<div class="col-xs-6 col-sm-6 col-md-5">
        	<p><?=$name?></p>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-5">
        	<p><?=$value?></p>
        </div>
	</div>
	<!-- //END shortcode HTML: -->
	<? 
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
}