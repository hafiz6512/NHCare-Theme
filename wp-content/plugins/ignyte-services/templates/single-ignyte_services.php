<? /**

 Template Name: Services - Single Post

*/

get_header();

$page_meta = get_post_meta( get_the_ID() );
$currentlang = get_bloginfo('language');
$id = get_the_ID();
?>

<div id="page-wrap">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?
        $imgurl = get_the_post_thumbnail_url(get_the_ID(), 'full');
        if (isset($page_meta['ignyte-service-meta-image'][0]) && $page_meta['ignyte-service-meta-image'][0]<>"") {

        $imgurl=$page_meta['ignyte-service-meta-image'][0];
        }
        ?>


        <div id="main-content">
            <div class="container-fluid single-service">
                <!-- Main editor page contents -->
                <div class="row">
                    <div class="col-xs-12 col-sm-12">

                        <section class="service-detail">
                            <div class="container">

                                <div class="row top">
                                	<div class="col-md-8 right-content" <? if ($imgurl<>"") { ?> style="background-image:url(<?=$imgurl?>)" <? } ?>></div>
                                	<div class="col-md-4 left-content">
                                        <div class="row left-top">
                                            <p class="bg-green service-tile"><?php echo pll__("Services");?></p>

                                            <h1 class="page-heading"><?php echo get_the_title(); ?></h1>
                                            <p class="large"><?php echo get_the_excerpt(); ?></p>
                                            <h5><?php echo pll__("To make an appointment call");?> <a href="tel:1-833-867-4642" class="green">1-833-867-4642</a> or <a class="green" data-toggle="modal" data-target="#appointment-modal"><?php echo pll__("schedule online");?></a>.</h5>
                                        </div>
                                    </div>
                                </div>


                                <div class="row bottom">
                                    <div class="col-sm-offset-1 col-sm-7 left-content">
                                        <?php
                                            remove_filter('the_content', 'wpautop');
                                            the_content();
                                        ?>
                                    </div>

                                    <div class="col-sm-offset-1 col-sm-2 right-sidebar">
                                        <div class="content">

                                            <p><?php echo get_the_title(); ?> <?php echo pll__("is available at the following Neighborhood locations");?>:</p>
                                            <?php
                                                $locations = array_reverse(unserialize($page_meta["ignyte_locations[]"][0]), true);
                                                $locSingleUrl = home_url( '/locations-list/' );
                                                $locSingleEsUrl = home_url( '/es/locations-list/' );
                                                $locurl = '';

                                            if ($locations){ ?>
                                                <ul>
                                                    <? if ($currentlang=="es-ES" || $currentlang=="es"){?>
                                                        <?php
                                                            foreach($locations as $key=>$thisloc){
                                                            //$locurl = preg_replace('/\s+/', '-', $thisloc);
                                                            $newLocurl = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $thisloc);
                                                        ?>
                                                            <!-- <li><a href="/es/ubicaciones/?loc=<?=$locurl?>"><?=$thisloc?></a></li> -->
                                                            <li><a href="<?php echo $locSingleEsUrl . $newLocurl ?>"><?php echo $thisloc; ?></a></li>
                                                        <?php } ?>
                                                    <? }else{ ?>
                                                        <?php
                                                            foreach($locations as $key=>$thisloc){

                                                            //$locurl = preg_replace('/\s+/', '', $thisloc);
                                                            $newLocurl = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $thisloc);
                                                        ?>
                                                            <!-- <li><a href="/locations?loc=<?=$locurl?>"><?=$thisloc?></a></li> -->
                                                            <li><a href="<?php echo $locSingleUrl . $newLocurl; ?>"><?=$thisloc?></a></li>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </ul>
                                            <? } ?>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <div class="container-fluid">
                                <div class="row service-provider">
                                    <?php dynamic_sidebar('Services CTA');
                                        //echo do_shortcode( '[random-doctor]' ); ?>
                                </div>
                            </div>

                        </section>
                    </div>
                </div>
            </div> <!-- /.container -->
        </div> <!-- /#main-content -->

	<?php
    	//wp_reset_query();

        $parent = null;
    	$currentlang = get_bloginfo('language');
        switch($currentlang){
        	case "en-US":
        		$parent = get_the_title( "Health Services" );
        	break;
        	case "es-ES":
        		$parent = get_the_title( "Servicios" );
        	break;
        }

        // $parent_meta = get_post_meta( $parent->ID );
        if ($parent !== null && is_object($parent) && isset($parent->ID)) {
            $parent_meta = get_post_meta($parent->ID);
            if( $parent_meta["ignyte_bottom_services_shortcode_content"][0]!=""){
        }

	?>

     <div id="bottom-content">
        <?php echo do_shortcode(get_post_meta($parent->ID, 'ignyte_bottom_services_shortcode_content', true));?>
     </div> <!-- /#bottom-content -->

	<?php } ?>

<?php endwhile; else: ?>

    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

<?php endif; ?>


</div> <!-- /#page-wrap -->

<?php get_footer(); ?>