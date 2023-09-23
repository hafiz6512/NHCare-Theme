<?php
// Usage: [boardblocks name="" title="" affiliation="" url=""]
add_shortcode('CTA', 'cta_button_shortcode');
function cta_button_shortcode($atts, $content = null) {
	extract( shortcode_atts( array(
		'label' => '',
		'title' => '',
		'target' => '_blank',
		'url' => '',
        'type'=>'link',
        'icon'=>'yes'
	), $atts ) );
	ob_start(); ?>
	<!-- //START boardblock shortcode HTML: -->
    <?php   if($title=='')
    {
        $title=$label;
    }
     if($type=='pdf')
    {

        ?>
        <a class="btn red svg" href="<?php echo $url;?>" title="<?=$title;?>" target="<?php echo $target;?>"><?php echo $label;?> <?php if($icon=='yes') { ?><i class="pdf-icon"></i> <?php } ?></a>
 <?php   } else { ?>
        <a class="btn red svg" href="<?php echo $url;?>" title="<?=$title;?>" target="<?php echo $target;?>"><?php echo $label;?> <?php if($icon=="yes") { ?><i class="envelope-icon"></i><?php } ?></a>
        <?php } ?>


    <!-- //END boardblock shortcode HTML: -->
	<? 
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
}