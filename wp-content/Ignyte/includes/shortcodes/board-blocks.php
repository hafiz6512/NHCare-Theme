<?php
// Usage: [boardblocks name="" title="" affiliation="" url=""]
add_shortcode('boardblocks', 'board_blocks_shortcode');
function board_blocks_shortcode($atts, $content = null) {
	extract( shortcode_atts( array(
		'name' => '',
		'title' => '',
		'affiliation' => '',
		'url' => ''
	), $atts ) );
	ob_start(); ?>
	<!-- //START boardblock shortcode HTML: -->
	<div class="col-xs-6 col-sm-6 col-md-3">
		<ul class="boardblock">
			<li><strong> <?=$name?> </strong></li>
			<li> <?=$title?> </li>
			<!-- <li><a href="<?=$url?>"> <?=$affiliation?> </a></li> -->
            <li><?=$affiliation?></li> 
		</ul>
	</div>
	<!-- //END boardblock shortcode HTML: -->
	<? 
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
}