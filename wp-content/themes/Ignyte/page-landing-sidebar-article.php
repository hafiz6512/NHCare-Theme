<? /**

 Template Name: Campaign Landing (Health Article)

*/

get_header();

$page_meta=get_post_meta( get_the_ID() ); 
$currentlang = get_bloginfo('language');
?>

<div id="page-wrap"> 

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<? if (isset($page_meta['ignyte_banner_image'][0]) && $page_meta['ignyte_banner_image'][0]<>"") { ?>

     <!-- Banner from custom image field (not featured image) -->
    <div class="banner-image" style="background-image:url(<?=$page_meta['ignyte_banner_image'][0]?>)">        

    </div> <!-- End banner image -->

    <? } ?>


    <div id="main-content">
      <div class="container">
    	<div class="row">
        
			<div class="col-sm-12 col-xs-12 col-md-4 col-md-push-8 col-lg-4 col-lg-push-8">
                <div id="sidebar">
                	<?php if ( function_exists ( dynamic_sidebar('articles-top-box') ) ) : ?>
                        	<?php dynamic_sidebar('articles-top-box'); ?>
                    <?php endif; ?>
                   <?php /** ?>
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
					<?php **/ ?>
                    <div class="hidden-xs hidden-sm">
                        <?php if ( function_exists ( dynamic_sidebar('services-bottom-box') ) ) : ?>
                                <?php //dynamic_sidebar('services-bottom-box'); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div> 
        	<!-- main column -->

        	<div class="col-xs-12 col-sm-12 col-md-8 col-md-pull-4 col-lg-8 col-lg-pull-4 main-column color-bl service-content">

            	<div class="lead-copy">
                        <h1 class="page-title"><?php the_title(); ?></h1>	
                </div>

				<?php the_content(); ?>


            </div>

            
            <!-- Custom Sidebar -->

           <div class="col-xs-12 visible-xs-block col-sm-12 visible-sm-block">
                <div id="sidebar">
                	<?php /** if ( function_exists ( dynamic_sidebar('services-top-box') ) ) : ?>
                        	<?php dynamic_sidebar('services-top-box'); ?>
                    <?php endif; ?>
                    <?php ?>
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
					 <?php **/ ?>
                    <?php if ( function_exists ( dynamic_sidebar('services-bottom-box') ) ) : ?>
                            <?php dynamic_sidebar('services-bottom-box'); ?>
                    <?php endif; ?>
                </div>
				
           </div>  

        </div> <!-- /.row -->
	  </div> <!-- /.container -->
    </div> <!-- /#main-content -->


    <?php if($page_meta["ignyte_bottom_shortcode_content"][0]!=""){ ?>

    <!-- If there are shortcodes / content blocks, this shows -->
     <div id="bottom-content">

     	<!-- Shortcodes / Content blocks would stack here -->
        <?php // echo apply_filters('the_content', get_post_meta($post->ID, 'ignyte_bottom_shortcode_content', true)); ?> 
        <?php echo do_shortcode($page_meta["ignyte_bottom_shortcode_content"][0]);?>

     </div> <!-- /#bottom-content -->

	<?php } ?>

<?php endwhile; else: ?>

    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

<?php endif; ?>


</div> <!-- /#page-wrap -->

<?php get_footer(); ?>