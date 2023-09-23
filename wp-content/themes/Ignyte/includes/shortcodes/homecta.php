<?php

add_shortcode('homecta4box', 'homecta4box_shortcode');
function homecta4box_shortcode($atts, $content = null) {
	
	$template_file = get_page_template_slug();
	extract( shortcode_atts( array(
		'page1' => '',
		'page1_title' =>'',
		'page2' => '',
		'page2_title' =>'',
		'page3' => '',
		'page3_title' =>'',
		'page4' => '',
		'page4_title' =>'',
		'close_container' =>'',
	), $atts ) );
	ob_start(); ?>
    	<? if ($close_container<>"" && $close_container<>"no") { ?>
            </div>
            </div>
            </div>
        <? } ?>
    
    <? if($page1<>"" && $page2<>"" && $page3<>"" && $page4<>""){ 
	
	$page1_contents=get_page_by_title($page1);
	$page1_meta = get_post_meta($page1_contents->ID);
	$page1_thumb=$page1_meta["ignyte_page_fallback_png"][0];
	$page1_svg=file_get_contents(wp_get_attachment_url( get_post_thumbnail_id($page1_contents->ID)));

	$page2_contents=get_page_by_title($page2);
	$page2_meta = get_post_meta($page2_contents->ID);
	$page2_thumb=$page2_meta["ignyte_page_fallback_png"][0];
	$page2_svg=file_get_contents(wp_get_attachment_url( get_post_thumbnail_id($page2_contents->ID)));
	
	$page3_contents=get_page_by_title($page3);
	$page3_meta = get_post_meta($page3_contents->ID);
	$page3_thumb=$page3_meta["ignyte_page_fallback_png"][0];
	$page3_svg=file_get_contents(wp_get_attachment_url( get_post_thumbnail_id($page3_contents->ID)));
	
	$page4_contents=get_page_by_title($page4);
	$page4_meta = get_post_meta($page4_contents->ID);
	$page4_thumb=$page4_meta["ignyte_page_fallback_png"][0];
	$page4_svg=file_get_contents(wp_get_attachment_url( get_post_thumbnail_id($page4_contents->ID)));
	//var_dump($page4_contents);
	?>
    <div class="home-cta-primary">
        <div class="container">
            <div class="row">
                
                    <a href="<?=get_permalink($page1_contents->ID)?>" class="col-xs-12 col-sm-6 col-md-3 service-list"> 
                    	<div class="img-wrap">
                        	<div class='table-cell'>
                            	<?=$page1_svg?>
                                <div class="svg-fallback" style="background-image:url(<?=$page1_thumb?>);"></div>
                            </div>
                        </div>
                        <div class='service-name'>
                            <div class='table-cell'>
                                <h2 class="epsilon"><? if ($page1_title<>"") { echo $page1_title; }else { echo $page1_contents->post_title; }?></h2>
                                <p><?=$page1_contents->post_excerpt?></p>
                            </div>
                        </div>
                    </a>
                
                    <a href="<?=get_permalink($page2_contents->ID)?>" class="col-xs-12 col-sm-6 col-md-3 service-list">
                    	<div class="img-wrap">
                        	<div class='table-cell'>
                            	<?=$page2_svg?>
                        		<div class="svg-fallback" style="background-image:url(<?=$page2_thumb?>);"></div>
                            </div>
                        </div>
                        <div class='service-name'>
                            <div class='table-cell'>
                                <h2 class="epsilon"><? if ($page2_title<>"") { echo $page2_title; }else { echo  $page2_contents->post_title; }?></h2>
                                <p><?=$page2_contents->post_excerpt?></p>
                            </div>
                        </div>
                    </a>

                    <a href="<?=get_permalink($page3_contents->ID)?>" class="col-xs-12 col-sm-6 col-md-3 service-list">
                        <div class="img-wrap">
                        	<div class='table-cell'>
                            	<?=$page3_svg?>
                            	<div class="svg-fallback" style="background-image:url(<?=$page3_thumb?>);"></div>
                            </div>
                        </div>
                        <div class='service-name'>
                            <div class='table-cell'>
                                <h2 class="epsilon"><? if ($page3_title<>"") { echo $page3_title; }else { echo  $page3_contents->post_title; }?></h2>
                        		<p><?=$page3_contents->post_excerpt?></p>
                            </div>
                        </div>
                    </a>
                
                    <a href="<?=get_permalink($page4_contents->ID)?>" class="col-xs-12 col-sm-6 col-md-3 service-list">
                         <div class="img-wrap">
                         	<div class='table-cell'>
                            	<?=$page4_svg?>
                            	<div class="svg-fallback" style="background-image:url(<?=$page4_thumb?>);"></div>
                            </div>
                        </div>
                        <div class='service-name'>
                            <div class='table-cell'>
                                <h2 class="epsilon"><? if ($page4_title<>"") { echo $page4_title; }else { echo  $page4_contents->post_title; }?></h2>
                        		<p><?=$page4_contents->post_excerpt?></p>
                            </div>
                        </div>
                    </a>
                
            </div>
        </div>
    </div>
    <? if ($close_container<>"" && $close_container<>"no") { ?>
            <div class="container">
            <div class="row">
            <? 
			if (strstr($template_file, 'page-fullwidth') || strstr($template_file, 'front-page')){ ?>
           		<div class="col-xs-12 col-sm-12">
			<? } else {?>
            	<div class="col-xs-12 col-sm-8">
            <? } ?>
         <? } ?> 
    <? } ?>
    
	<?  $html = ob_get_contents();
	ob_end_clean();
	return $html;
}