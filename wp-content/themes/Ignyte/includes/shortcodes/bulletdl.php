<?php
// Usage: [bulledtl title="" link="" url=""]
add_shortcode('bulletdl', 'bulletdl_shortcode');
function bulletdl_shortcode($atts, $content = null) {
	extract( shortcode_atts( array(
		'title' => '',
		'link' => '',
		'url' => ''
	), $atts ) );
	ob_start(); ?>
    
        <!-- //START individual dl bullet shortcode HTML: -->
        <li>
            <p class="dl-title"><?=$title?></span>
            <p class="dl-links"><a href="<?=$url?>"><?=$link?></a></p>
        </li>
        <!-- //END individual dl bullet shortcode HTML: -->

	<?  $html = ob_get_contents();
	ob_end_clean();
	return $html;
}