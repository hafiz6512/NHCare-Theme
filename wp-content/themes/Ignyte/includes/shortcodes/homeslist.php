<?php
// Usage: [homeslist name="" designer="" company="" email="" content="" headshot="" pic1=""]
add_shortcode('homeslist', 'homeslist_shortcode');
function homeslist_shortcode($atts, $content = null) {
	
	$template_file = get_page_template_slug();
	extract( shortcode_atts( array(
		'name' => '',
		'headshot' => '',
		'designer' => '',
		'company' => '',
		'email' => '',
		'content' => '',
		'id' =>'',
		'subnav_title' =>'',
		'pic1' =>'',
	), $atts ) );

	ob_start(); ?>
    <? if ($id<>"" && $subnav_title<>""){ ?>
        <div id="subnav_<?=$id?>" class="homeslist Ignyte_subNavItem">
            <div class='menutitle' style='display:none;'><?=$subnav_title?></div>
    <? } else { ?>
        <div class="homeslist">
    <? } ?>
            <h4><?=$name?></h4>
            <div class="row">
            	<? if($headshot<>""){?>
                <div class="col-xs-4 col-sm-5 col-md-4 col-lg-3">
                    <div class="img-wrap">
                        <img class="img-circ" src="<?=$headshot?>">
                    </div>
                </div>
                <? } ?>
                <div class="col-xs-8 col-sm-7 col-md-8 col-lg-9">
                    <div class="des-info">
                        <span><strong><?=$designer?></strong></span>
                        <span><?=$company?></span>
                        <span><?=$email?></span>
                    </div>
                </div>
            </div>
            <p class="small"><?=$content?></p>
            <? if($pic1<>""){ ?>
           	 <img class="home-pic" src="<?=$pic1?>" width="280" height="200" />
            <? } ?>
        </div>
	<?  $html = ob_get_contents();
	ob_end_clean();
	return $html;
}
