<?php
add_shortcode('subnav', 'ignyte_subnav_shortcode');
function ignyte_subnav_shortcode($atts, $content = null) {
	extract( shortcode_atts( array(
		'subnav_title' => '',
		'id' => '',
		'class' => '',
	), $atts ) );
	ob_start(); ?>
        <div id="subnav_<?=$id?>"  class="Ignyte_subNavItem <?=$class?>">
        	<div class='menutitle' style='display:none;'><?=$subnav_title?></div>
            <? if ($content<>""){ echo do_shortcode($content); } ?>
        </div>
	<?  $html = ob_get_contents(); 
	ob_end_clean();
	return $html;
}