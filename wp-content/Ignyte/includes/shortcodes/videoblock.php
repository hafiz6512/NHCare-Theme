<?php
add_shortcode('videoblock', 'ignyte_video_block');
function ignyte_video_block($atts, $content = null) {
	extract( shortcode_atts( array(
		'h2title' =>'',
		'leadin'=>'',
		'subnav_title' =>'',
		'id' => '',
		'v1' => '',
		'v2' => '',
		'v3' => '',
		'v4' => '',
		'v1_title' => '',
		'v2_title' => '',
		'v3_title' => '',
		'v4_title' => '',
		'channel' => '',
		'channel_text' => '',
	), $atts ) );
	ob_start(); ?>
    
 <? if($subnav_title<>"" && $id<>""){?>
	<div id="subnav_<?=$id?>" class="video-wrap Ignyte_subNavItem">
    	<div class='menutitle' style='display:none;'><?=$subnav_title?></div>
        <div class="container video-inner">
        	
   <? } else { ?>
	<div class="video-wrap">
        <div class="container video-inner"> 
   <? } ?>
            <div class="row">
                <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10 lead-copy">
                    <h2><?=$h2title?></h2>
                    <p><?=$leadin?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 video-block">
                    <p class="p-large"><?=$v1_title?></p>
                    <div class="frameblocker" id="<?=$v1?>"><iframe class="ytvideo" src="https://www.youtube.com/embed/<?=$v1?>?showinfo=0&autoplay=0&controls=0&enablejsapi=1&wmode=transparent" frameborder="0" allowfullscreen></iframe></div><? //wp_oembed_get($v1)?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 video-block">
                    <p class="p-large"><?=$v2_title?></p>
                    <div class="frameblocker" id="<?=$v2?>"><iframe class="ytvideo" src="https://www.youtube.com/embed/<?=$v2?>?showinfo=0&autoplay=0&controls=0&enablejsapi=1&wmode=transparent" frameborder="0" allowfullscreen></iframe></div><? //=wp_oembed_get($v2)?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 video-block">
                    <p class="p-large"><?=$v3_title?></p>
                    <div class="frameblocker" id="<?=$v3?>"><iframe class="ytvideo" src="https://www.youtube.com/embed/<?=$v3?>?showinfo=0&autoplay=0&controls=0&enablejsapi=1&wmode=transparent" frameborder="0" allowfullscreen></iframe></div><? //=wp_oembed_get($v3)?>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 video-block">
                    <p class="p-large"><?=$v4_title?></p>
                    <div class="frameblocker" id="<?=$v4?>"><iframe class="ytvideo" src="https://www.youtube.com/embed/<?=$v4?>?showinfo=0&autoplay=0&controls=0&enablejsapi=1&wmode=transparent" frameborder="0" allowfullscreen></iframe></div><? //=wp_oembed_get($v4)?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <a target="_blank" class="btn btn-green ch-btn" href="<?=$channel?>"><?=$channel_text?></a>
                </div>
            </div>
        </div>
    </div>
    <script>
    function playVideoAndPauseOthers(frame) {
		jQuery('iframe[src*="https://www.youtube.com/embed/"]').each(function() {
			var func = this === frame ? 'playVideo' : 'pauseVideo';
			this.contentWindow.postMessage('{"event":"command","func":"' + func + '","args":""}', '*');
		});
	}
	jQuery('.frameblocker').click( function(){
			id=jQuery(this).attr("id");
			
		} );

	
    </script>
    
    
	<?  $html = ob_get_contents();
	ob_end_clean();
	return $html;
}
?>