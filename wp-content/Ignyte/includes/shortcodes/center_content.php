<?php
add_shortcode('center_content', 'ignyte_center_content_shortcode');
function ignyte_center_content_shortcode($atts, $content = null) {
	extract( shortcode_atts( array(
		'id' => '',
		'class' => '',
	), $atts ) );
	ob_start(); ?>
        <div id="<?=$id?>"  class="container <?=$class?>">
            <? if ($content<>""){ echo do_shortcode($content); } ?>
        </div>
	<?  $html = ob_get_contents(); 
	ob_end_clean();
	return $html;
}