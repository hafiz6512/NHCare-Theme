<?php
/*
Template Name: Sidebar Pushed Page
*/
 get_header();
 $page_meta=get_post_meta( get_the_ID() ); 
?>
<div id="page-wrap">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<div class="page-top-wrap">
		<? if (isset($page_meta['ignyte_banner_image'][0]) && $page_meta['ignyte_banner_image'][0]<>"") { ?>
    
        <div class="banner-image" style="background-image:url(<?=$page_meta['ignyte_banner_image'][0]?>)">
    
            <? if (isset($page_meta['ignyte_banner_image_title'][0]) && $page_meta['ignyte_banner_image_title'][0]<>"") { ?>
    
                <!-- if banner has title -->
    
                <div class="banner-content">
    
                    <div class="container">
    
                        <h2><?=$page_meta['ignyte_banner_image_title'][0]?></h2>
    
                    </div>
    
                </div>
    
            <? } ?>
    
        </div> <!-- End banner image -->
    </div> <!-- End page top wrap -->
	<? } ?>
    <div id="main-content">
      <div class="container">
    	<div class="row">
			
            <?php get_sidebar('desktop'); ?>
            
        	<!-- main column -->
        	<div class="col-xs-12 col-sm-12 col-md-8 col-md-pull-4 col-lg-8 col-lg-pull-4 main-column">
            	<div class="lead-copy">
					<?php if($page_meta["ignyte_title_content"][0]==""){ ?>
                        <h1 class="page-title"><?php the_title(); ?></h1>	
                    <?php }else{ 
                        echo $page_meta["ignyte_title_content"][0];
                    } ?>
                    <?php if($page_meta["ignyte_leadincontent_content"][0]!=""){ ?>
                        <!-- If has lead copy entered in the admin, then this shows -->
                        <!--<div class="lead-copy">-->
                        <p><?=$page_meta["ignyte_leadincontent_content"][0]?></p>
                        <!--</div>-->
                    <?php } ?>
                </div>
				<?php the_content(); ?>
            </div>
            <?php get_sidebar('mobile'); ?>   
        </div> <!-- /.row -->
      </div> <!-- .container -->
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
</div> <!-- /#page-wrap -->

<?php get_footer(); ?>