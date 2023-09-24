<? /**

 Template Name: Services - Single Post 

*/

get_header();

$page_meta=get_post_meta( get_the_ID() ); 

?>

<div id="page-wrap"> 

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<? if (isset($page_meta['ignyte-service-meta-image'][0]) && $page_meta['ignyte-service-meta-image'][0]<>"") { ?>

     <!-- Banner from custom image field (not featured image) -->
    <div class="banner-image" style="background-image:url(<?=$page_meta['ignyte-service-meta-image'][0]?>)">        

    </div> <!-- End banner image -->

    <? } ?>


    <div id="main-content" class="container service-content">
    	<div class="row">

        	<!-- main column -->

        	<div class="col-xs-12 col-sm-8 col-lg-8 main-column">

            	<div class="lead-copy">
                        <h1 class="page-title"><?php the_title(); ?></h1>	
                </div>

				<?php the_content(); ?>

                <!-- ** Waiting to find out if this button should be in template, or part of admin post content ** -->
                <a class="btn btn-green" href="">View More Health Services</a>

            </div>

            
            <!-- Custom Sidebar -->

            <?php get_sidebar(); ?>   

        </div> <!-- /.row -->

    </div> <!-- /#main-content.container -->


    <?php if($page_meta["ignyte_bottom_shortcode_content"][0]!=""){ ?>

    <!-- If there are shortcodes / content blocks, this shows -->
     <div id="bottom-content">

     	<!-- Shortcodes / Content blocks would stack here -->
        <?php echo apply_filters('the_content', get_post_meta($post->ID, 'ignyte_bottom_shortcode_content', true)); ?> 

     </div> <!-- /#bottom-content -->

	<?php } ?>

<?php endwhile; else: ?>

    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

<?php endif; ?>


</div> <!-- /#page-wrap -->

<?php get_footer(); ?>