<?php
/*
Template Name: FullWidth Page Fluid
*/
 get_header(); 
 $page_meta=get_post_meta( get_the_ID() ); 
?>
<div id="page-wrap">

<!-- BEGIN - ADDED BY GREG -->
<section class="services careers volunteer">
<!-- END - ADDED BY GREG -->



<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
   <!-- if page has a banner at top -->



<?php /*?>	<? if (isset($page_meta['ignyte_banner_image'][0]) && $page_meta['ignyte_banner_image'][0]<>"") { ?>
    <div class="banner-image" style="background-image:url(<?=$page_meta['ignyte_banner_image'][0]?>)">
    	<? if (isset($page_meta['ignyte_banner_image_title'])) { ?>
            <!-- if banner has title -->
            <div class="banner-content">
                <div class="container">
                    <h2><?=$page_meta['ignyte_banner_image_title'][0]?></h2>
                </div>
            </div>
        <? } ?>
    </div> <!-- End banner image -->
	<? } ?><?php */?>



    <div id="main-content">
      <div class="container-fluid">

        <!-- Main editor page contents -->
        <div class="row">
        	<div class="col-xs-12 col-sm-12">
                    <?php

                    remove_filter('the_content', 'wpautop');
                    the_content(); ?>
            </div> 
        </div>
	  </div> <!-- /.container -->
    </div> <!-- /#main-content -->
    <?php if($page_meta["ignyte_bottom_shortcode_content"][0]!=""){ ?>
    <!-- If there are shortcodes / content blocks, this shows -->
     <div id="bottom-content">
     	<!-- Shortcodes / Content blocks would stack here -->
       <?php // echo apply_filters('the_content', get_post_meta($post->ID, 'ignyte_bottom_shortcode_content', true)); ?> 
        <?php echo do_shortcode(get_post_meta($post->ID, 'ignyte_bottom_shortcode_content', true));?>
     </div> <!-- /#bottom-content -->
	<?php } ?>
<?php endwhile; else: ?>

	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

<?php endif; ?>



<!-- BEGIN - ADDED BY GREG -->
</section>
<!-- END - ADDED BY GREG -->


</div> <!-- /#page-wrap -->
<?php get_footer(); ?>