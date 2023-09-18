<?php
/*
Template Name: Find a Location Page
*/
get_header();
$postid = get_the_ID();
$page_meta = get_post_meta($postid);
?>
    <div id="page-wrap">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <!-- if page has a banner at top -->
            <? if (isset($page_meta['ignyte_banner_image'][0]) && $page_meta['ignyte_banner_image'][0] <> "") { ?>
                <div class="banner-image" style="background-image:url(<?= $page_meta['ignyte_banner_image'][0] ?>)">
                    <? if (isset($page_meta['ignyte_banner_image_title'])) { ?>
                        <!-- if banner has title -->
                        <div class="banner-content">
                            <div class="container">
                                <h2><?= $page_meta['ignyte_banner_image_title'][0] ?></h2>
                            </div>
                        </div>
                    <? } ?>
                </div> <!-- End banner image -->
            <? } ?>
            <div id="main-content">
                <div class="container-fluid">
				<div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-offset-1 col-lg-5 page-left-content">
					<span><?php if ($page_meta["ignyte_title_content"][0] <> "") { ?>
                            <? $page_meta["ignyte_title_content"][0]; ?>
                        <?php } else { ?><?php the_title(); ?><?php } ?></span>
                            <?php if ($page_meta["ignyte_banner_content"][0]) {
                                echo $page_meta["ignyte_banner_content"][0];
                            } ?>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-5 col-lg-offset-1 page-right-content">
                            <?php if ($page_meta["ignyte_banner_content2"][0]) {
                                echo do_shortcode($page_meta["ignyte_banner_content2"][0]);
                            } ?>

                        </div>
                    </div>
				</div>
                    <!-- Main editor page contents -->
				<div class="row page-bottom-content">
                        <div class="col-xs-12 col-sm-12">                            
                            <?php the_content(); ?> 
                        </div>
                </div>
                </div> <!-- /.container -->
            </div> <!-- /#main-content -->

            <?php if ($page_meta["ignyte_bottom_shortcode_content"][0] != "") { ?>
                <!-- If there are shortcodes / content blocks, this shows -->
                <div id="bottom-content">
                    <!-- Shortcodes / Content blocks would stack here -->
                    <?php // echo apply_filters('the_content', get_post_meta($post->ID, 'ignyte_bottom_shortcode_content', true)); ?>
                    <?php echo do_shortcode(get_post_meta($postid, 'ignyte_bottom_shortcode_content', true)); ?>
                </div> <!-- /#bottom-content -->
            <?php } ?>
        <?php endwhile;
        else: ?>

            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

        <?php endif; ?>

    </div> <!-- /#page-wrap -->
<?php get_footer();
?>