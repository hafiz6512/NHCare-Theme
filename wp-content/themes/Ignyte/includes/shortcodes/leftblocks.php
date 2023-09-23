<?php

// Usage: [[leftblocks title="" content="" cta="" button1="" link1="" button2="" link2="" image="name_of_image.ext" name="" nametitle="" color=""]

add_shortcode('leftblocks', 'leftblocks_shortcode');
function leftblocks_shortcode($atts, $content = null) {
	
	$template_file = get_page_template_slug();
	extract( shortcode_atts( array(
		'title' => '',
		'content' => '',
		'cta' => '',
		'button1' => '',
		'link1' => '',
		'button2' => '',
		'link2' => '',
		'image' => '',
		'name' => '',
		'nametitle' => '',
		'specialty' => '',
		'color' => '',
		'type' => '',
		'id' =>'',
		'subnav_title' =>'',
		'close_container' =>'',
	), $atts ) );


	if ($type!=""){
		$args = array(
		'posts_per_page'     => 1,
		'orderby'		   => 'rand',
		'post_type'       => $type,
		'meta_query' => array(
				array(
					'key' => 'ignyte-provider-meta-image',
					'value'   => "",
					'compare' => 'NOT IN'
				)
			),
		'post_status'     => 'publish');
		$post = get_posts($args);

		foreach ($post as $p) {
		
			$postMeta_values = get_post_meta($p->ID);
			//var_dump($postMeta_values);
			//$title = $postMeta_values["ignyte-provider-cta-title"][0];
			//$content = $postMeta_values["ignyte-provider-cta-content"][0];
			$image = $postMeta_values["ignyte-provider-meta-image"][0];
			$specialty = $postMeta_values["ignyte-provider-primary-service"][0];
			$name = $postMeta_values["ignyte-provider-displayed-name"][0];
			$nametitle = $postMeta_values["ignyte-provider-title"][0];
		}
	}
	ob_start(); ?>
		<? if ($close_container<>"" && $close_container<>"no") { ?>
            </div>
            </div>
            </div>
        <? } ?>
        <!-- //START left CTA shortcode HTML: -->
        <? if ($id<>"" && $subnav_title<>""){ ?>
        	<div id="subnav_<?=$id?>" class="cta left <?=$type?> <?=$color?> Ignyte_subNavItem" style="background-image:url(<?=$image?>);">
            	<div class='menutitle' style='display:none;'><?=$subnav_title?></div>
        <? } else { ?>
        	<div class="cta left <?=$type?> <?=$color?>" style="background-image:url(<?=$image?>);">
        <? } ?>
            <div class="container">
            	<div class="row">
                    <div class="col-sm-8 col-md-6">
                        <?= ($title!="")? '<h2>'.$title.'</h2>':''; ?>
                        <?= ($content!="")? '<p>'.$content.'</p>':''; ?>
                        <?= ($cta!="")? '<p class="p-large">'.$cta.'</p>':''; ?>
                        <?= ($link1!="")? '<a href="'.$link1.'" class="btn btn-cta">'.$button1.'</a>' :'' ; ?>
                        <br class="btn-sep" />
                        <?= ($link2!="")? '<a href="'.$link2.'" class="btn btn-cta">'.$button2.'</a>' :'' ; ?>
                    </div>
					
                    <? if($image<>"") { ?>
                        <div class="img-text">
                            <div class="img-text-inner">
                                <div class="table-cell">
                                    <?= ($name!="")? '<p class="name">'.$name.'</p>' :'' ; ?>
                                    <?= ($nametitle!="")? '<p class="job">'.$nametitle.'</p>' :'' ; ?>
                                    <?= ($specialty!="")? '<p class="specialty">'.$specialty.'</p>' :'' ; ?>
                                </div>
                            </div>
                        </div> 
                    <? } ?>
                </div>
            </div>
            
        </div>
        <!-- //END left CTA shortcode HTML: -->
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
	<?  $html = ob_get_contents();
	ob_end_clean();
	return $html;
}