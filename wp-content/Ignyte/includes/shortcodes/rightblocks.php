<?php

// Usage: [rightblocks title="" content="" button1="" link1="" image="name_of_image.ext" color=""]

add_shortcode('rightblocks', 'rightblocks_shortcode');
function rightblocks_shortcode($atts, $content = null) {
	
	$template_file = get_page_template_slug();
	extract( shortcode_atts( array(
		'title' => '',
		'content' => '',
		'button1' => '',
		'link1' => '',
		'image' => '',
		'color' => '',
		'id' =>'',
		'subnav_title' =>'',
		'close_container' =>'',
	), $atts ) );

	ob_start(); ?>
		<? if ($close_container<>"" && $close_container<>"no") { ?>
            </div>
            </div>
            </div>
        <? } ?>
        <!-- //START Right CTA shortcode HTML: -->
        <? if ($id<>"" && $subnav_title<>""){ ?>
        	<div id="subnav_<?=$id?>" class="cta right <?=$color?> Ignyte_subNavItem">
            	<div class='menutitle' style='display:none;'><?=$subnav_title?></div>
        <? } else { ?>
        	<div class="cta right <?=$color?>">
        <? } ?>
         
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4">
                        	<img src="<?=$image?>" border="0" />
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                            <?= ($title!="")? '<h2>'.$title.'</h2>':''; ?>
                            <?= ($content!="")? '<p>'.$content.'</p>':''; ?>
                            <?= ($link1!="")? '<a href="'.$link1.'" class="btn btn-cta">'.$button1.'</a>' :'' ; ?>
                        </div>
                    </div>
                </div>
            </div>
        	<!-- //END Right CTA shortcode HTML: -->
		<? if ($close_container<>"" && $close_container<>"no") { ?>
            <div class="container">
            <div class="row">
            <? 
			if (strstr($template_file, 'page-fullwidth')){ ?>
           		<div class="col-xs-12 col-sm-12">
			<? } else {?>
            	<div class="col-xs-12 col-sm-8">
            <? } ?>
         <? } ?> 
	<?  $html = ob_get_contents();
	ob_end_clean();
	return $html;
}