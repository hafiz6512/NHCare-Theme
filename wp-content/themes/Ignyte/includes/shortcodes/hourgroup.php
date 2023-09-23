<?php
// Usage: [bulledtl title="" link="" url=""]
add_shortcode('hourgroup', 'ignyte_hourgroupl_shortcode');
function ignyte_hourgroupl_shortcode($atts, $content = null) {
	extract( shortcode_atts( array(
		'days' => '',
		'services' => '',
		'times' => ''
	), $atts ) );
	
	$services=explode(",",$services);
	$times=explode(",",$times);
	$max=max(count($services),count($times));
	ob_start(); ?>
    
    <!-- //START individual dl bullet shortcode HTML: -->
    <dl> 
        <dt><?=$days?></dt>
        <?php for ($i=0;$i<$max;$i++) {?>
            <dd  <?= $services[$i]=="" ? 'class="no-bullet"':'' ?> >
                <div class="row ">
                    <div class="col-xs-12 col-sm-6 service-name"><?=$services[$i]?></div>
                    <div class="col-xs-12 col-sm-6"><?=$times[$i]?></div>
                </div>
            </dd>
   	 	<?php } ?>
    </dl>
    <!-- //END individual dl bullet shortcode HTML: -->

	<?  $html = ob_get_contents();
	ob_end_clean();
	return $html;
}