<? /**

 Template Name: Services - Single Post 

*/

get_header();

$page_meta=get_post_meta( get_the_ID() ); 
$currentlang = get_bloginfo('language');
?>

<div id="page-wrap"> 

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<? if (isset($page_meta['ignyte-service-meta-image'][0]) && $page_meta['ignyte-service-meta-image'][0]<>"") { ?>

     <!-- Banner from custom image field (not featured image) -->
    <div class="banner-image" style="background-image:url(<?=$page_meta['ignyte-service-meta-image'][0]?>)">        

    </div> <!-- End banner image -->

    <? } ?>


    <div id="main-content">
      <div class="container">
    	<div class="row">
        
			<div class="hidden-xs hidden-sm col-md-4 col-md-push-8 col-lg-4 col-lg-push-8">
                <div id="sidebar">
                	<?php if ( function_exists ( dynamic_sidebar('services-top-box') ) ) : ?>
                        	<?php dynamic_sidebar('services-top-box'); ?>
                    <?php endif; ?>
                   
                     <div class="sb-middle">
						<?php if ( function_exists ( dynamic_sidebar('services-locations-box') ) ) : ?>
                                <?php dynamic_sidebar('services-locations-box'); ?>
                        <?php endif; ?>
                    	
                        <?php  
						$locations=array_reverse(unserialize($page_meta["ignyte_locations[]"][0]),true);
						if ($locations<>""){
							?>
							<ul>
                            	<? if ($currentlang=="es-ES"){?>
									<?php foreach($locations as $key=>$thisloc){ ?>
                                    <li><a href="/es/ubicaciones#loc_<?=$key?>"><?=$thisloc?></a></li>
                                    <?php } ?>
                                <? }else{ ?>
                                	<?php foreach($locations as $key=>$thisloc){ ?>
                                    <li><a href="/locations#loc_<?=$key?>"><?=$thisloc?></a></li>
                                    <?php } ?>
                                <?php } ?>
							</ul>
                        <? } ?>
                    </div>
                    <?php if ( function_exists ( dynamic_sidebar('services-bottom-box') ) ) : ?>
                            <?php dynamic_sidebar('services-bottom-box'); ?>
                    <?php endif; ?>
                </div>
            </div> 
        	<!-- main column -->

        	<div class="col-xs-12 col-sm-12 col-md-8 col-md-pull-4 col-lg-8 col-lg-pull-4 main-column color-bl service-content">

            	<div class="lead-copy">
                        <h1 class="page-title"><?php the_title(); ?></h1>	
                </div>

				<?php the_content(); ?>

                <p><a class="btn btn-green" href="<?=($currentlang=="es-ES")?"/es/health-services/":"/health-services/"?>"><?=($currentlang=="es-ES")?"Ver Más Servicios":"View More Health Services"?></a></p>

            </div>

            
            <!-- Custom Sidebar -->

           <div class="col-xs-12 visible-xs-block col-sm-12 visible-sm-block">
                <div id="sidebar">
                	<?php if ( function_exists ( dynamic_sidebar('services-top-box') ) ) : ?>
                        	<?php dynamic_sidebar('services-top-box'); ?>
                    <?php endif; ?>
                   
                    <div class="sb-middle">
                   		<h3>Locations</h3>
                        <p class="small">This service is offered at the following VCC medical centers. Please click on the link to view the days of the week and hours this service is offered.</p>
                        <?php  
						$locations=unserialize($page_meta["ignyte_locations[]"][0]);
						if ($locations<>""){
							?>
							<ul>
								<?php foreach($locations as $key=>$thisloc){ ?>
								<li><a href="/locations#loc_<?=$key?>"><?=$thisloc?></a></li>
								<?php } ?>
							</ul>
                        <? } ?>
                    </div>
                    <?php if ( function_exists ( dynamic_sidebar('services-bottom-box') ) ) : ?>
                            <?php dynamic_sidebar('services-bottom-box'); ?>
                    <?php endif; ?>
                </div>
           </div>  

        </div> <!-- /.row -->
	  </div> <!-- /.container -->
    </div> <!-- /#main-content -->


	<?php 
	//wp_reset_query();
 	
	$currentlang = get_bloginfo('language');
 switch($currentlang){
	case "en-US":
		$parent=get_page_by_title( "Health Services" );
	break;
	case "es-ES":
		$parent=get_page_by_title( "Servicios" );
	break;
 }
	$parent_meta=get_post_meta( $parent->ID );  
	
	?>

    <?php if($parent_meta["ignyte_bottom_services_shortcode_content"][0]!=""){ ?>

    <!-- If there are shortcodes / content blocks, this shows -->
     <div id="bottom-content">

     	<!-- Shortcodes / Content blocks would stack here -->
        <?php // echo apply_filters('the_content', get_post_meta($post->ID, 'ignyte_bottom_shortcode_content', true)); ?> 
        <?php echo do_shortcode(get_post_meta($parent->ID, 'ignyte_bottom_services_shortcode_content', true));?>

     </div> <!-- /#bottom-content -->

	<?php } ?>

<?php endwhile; else: ?>

    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

<?php endif; ?>


</div> <!-- /#page-wrap -->

<?php get_footer(); ?>