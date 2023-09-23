<?php
add_shortcode('close_container', 'ignyte_close_container_shortcode');
function ignyte_close_container_shortcode($atts, $content = null) {
	ob_start(); ?>
            </div>
            </div>
            </div>
	<?  $html = ob_get_contents(); 
	ob_end_clean();
	return $html;
}

add_shortcode('open_container', 'ignyte_open_container_shortcode');
function ignyte_open_container_shortcode($atts, $content = null) {
	$template_file = get_page_template_slug();
	extract( shortcode_atts( array(
		'id' => '',
		'class' => '',
	), $atts ) );
	ob_start(); ?>
         	<div id="<?=$id?>" class="container <?=$class?>">
            <div class="row">
            <? 
			if (strstr($template_file, 'page-fullwidth') || strstr($template_file, 'front-page')){ ?>
           		<div class="col-xs-12 col-sm-12">
			<? } else {?>
            	<div class="col-xs-12 col-sm-8">
            <? } ?>
	<?  $html = ob_get_contents(); 
	ob_end_clean();
	return $html;
}