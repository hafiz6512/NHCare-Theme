<?php
/*
Template Name: FullWidth Home
*/
get_header();
$page_meta = get_post_meta(get_the_ID());
?>

    <div id="page-wrap">

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <!-- If page has a slider at top -->
            <? if (isset($page_meta["ignyte_slider_category"][0]) && $page_meta["ignyte_slider_category"][0] <> "") { ?>
                <div class="slide-wrap-outer">
                    <?= do_shortcode("[ignyte_slider]"); ?>
                </div>
            <? } ?>
            <!-- Or if page has a banner at top -->
			<div class="container">
			<div class="banner-top">
				<div class="banner-image"  <? if (isset($page_meta['ignyte_banner_image'][0]) and $page_meta['ignyte_banner_image'][0] <> "") { ?>style="background-image:url(<?= $page_meta['ignyte_banner_image'][0] ?>)" <?php } ?> ></div>
					<div class="row">
						<!-- if banner has title -->
						<div class="grid">
						</div>
					 </div>
					 <div class="banner-content">
							<div class="row">
								<?php if ($page_meta["ignyte_banner_content"][0]) {
									echo $page_meta["ignyte_banner_content"][0];
								} ?>
								<?php if ($page_meta["ignyte_banner_content2"][0] ) {
									echo $page_meta["ignyte_banner_content2"][0];
								} ?>

							</div>
					</div>
				</div>
			</div>
			<div class="container">
			<div class="thepatterns home-bg-1"><div class="pattwrap">
				<div class="pattblock teal flip zoom"></div>
				</div>
			</div>
			</div>
            <div id="main-content">
                <?= apply_filters('the_content', $post->post_content); ?>



                <div class="container-fluid">
                    <!-- Main editor page contents -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <?//= apply_filters('the_content', $post->post_content); ?>
                            <?php //the_content(); ?>
                        </div>
                    </div>
                </div> <!-- /.container -->
            </div> <!-- /#main-content -->

            <?php if ($page_meta["ignyte_bottom_shortcode_content"][0] != "") { ?>
                <!-- If there are shortcodes / content blocks, this shows -->
                <div id="bottom-content">
                    <!-- Shortcodes / Content blocks would stack here -->
                    <?php // echo apply_filters('the_content', get_post_meta($post->ID, 'ignyte_bottom_shortcode_content', true)); ?>
                    <?php echo do_shortcode(get_post_meta($post->ID, 'ignyte_bottom_shortcode_content', true)); ?>
                </div> <!-- /#bottom-content -->
            <?php } ?>

        <?php endwhile;
        else: ?>

            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

        <?php endif; ?>

    </div> <!-- /#page-wrap -->
<?php get_footer(); ?>