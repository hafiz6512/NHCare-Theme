<?php
// Usage: [centerblocks title="" content="" button="" link=""  color=""]
add_shortcode('centerblocks', 'centerblocks_shortcode');
function centerblocks_shortcode($atts, $content = null) {
	
	$template_file = get_page_template_slug();
	//var_dump($template_file);
	
	extract( shortcode_atts( array(
		'title' => '',
		'content' => '',
		'button' => '',
		'link' => '',
		'color' => '',
		'class' => '',
		'id' =>'',
		'subnav_title' =>'',
		'close_container' => '',
		'external'=>'',
		'hideforphone'=>''
	), $atts ) );
	
	if($hideforphone=="yes")
		$hideclass="hideforphone";
	ob_start(); ?>
    	<? if ($close_container<>"" && $close_container<>"no") { ?>
            </div>
            </div>
            </div>
        <? } ?>
            <!-- //START center CTA shortcode HTML: -->
            <? if ($id<>"" && $subnav_title<>""){ ?>
                <div id="subnav_<?=$id?>"  class="cta center <?=$color?> <?=$class?> Ignyte_subNavItem "> <!-- A 'color' class will be added, based on color value, blue placeholder -->
                    <div class='menutitle' style='display:none;'><?=$subnav_title?></div>
            <? } else { ?>
                <div  class="cta center <?=$color?> <?php echo $hideclass; ?>"> <!-- A 'color' class will be added, based on color value, blue placeholder -->
            <? } ?>
            
                <div class="container  ">
                    <div class="row">
                        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
                            <?= ($title!="")? '<h2>'.$title.'</h2>':''; ?>
                            <?= ($content!="")? '<p>'.$content.'</p>':''; ?>
                            <? if ($external<>"") { ?>
                            	<?= ($link!="")? '<div class="external"><a href="'.$link.'" class="btn btn-cta">'.$button.'</a></div>' :'' ; ?>
                            <? } else { ?>
                            	<?= ($link!="")? '<a href="'.$link.'" class="btn btn-cta">'.$button.'</a>' :'' ; ?>
                            <? } ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //END center CTA shortcode HTML: -->
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