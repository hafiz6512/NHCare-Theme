<?
add_shortcode('Contact-us-row', 'contact_info_shortcode');
function contact_info_shortcode( $atts ) {
	extract( shortcode_atts( array(
		'thetitle' => '',
		'thecontent' => '',
		'thefile' => '',
		'linkcontent' => 'click to download',
		'thetype' => '',
	), $atts ) );
    ob_start();
	?>
    <section id="contact" class="lgrey">
        <div class="container bottom-section">
            <div class="row">

                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 contact-section first">
                    <?php if ( function_exists ( dynamic_sidebar('contact_detail_1') ) ) { ?>

                        <?php dynamic_sidebar('contact_detail_1'); ?>
                    <? }?>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 contact-section second">
                    <?php if ( function_exists ( dynamic_sidebar('contact_detail_2') ) ) { ?>

                        <?php dynamic_sidebar('contact_detail_2'); ?>
                    <? }?>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12 contact-section third">
                    <?php if ( function_exists ( dynamic_sidebar('contact_detail_3') ) ) { ?>

                        <?php dynamic_sidebar('contact_detail_3'); ?>
                    <? }?>
                </div>
            </div>
        </div>
    </section>
    <?  $html2 = ob_get_contents();
    ob_end_clean();
    return $html2;
}
