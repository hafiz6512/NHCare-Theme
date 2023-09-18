<? /**

Template Name: Services - Single Post

 */

get_header();

$page_meta   = get_post_meta( get_the_ID() );
$currentlang = get_bloginfo('language');
$id          = get_the_ID() ;
$tday        = get_the_date( "d", $id );
$tmonth      = get_the_date( "F", $id );
$tyear       = get_the_date( "Y", $id );
?>

    <div id="page-wrap">

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <?
            $imgurl = get_the_post_thumbnail_url(get_the_ID(), 'full');
           /* if (isset($page_meta['ignyte-service-meta-image'][0]) && $page_meta['ignyte-service-meta-image'][0]<>"") {
                $imgurl=$page_meta['ignyte-service-meta-image'][0];
            }*/

            $category_detail=get_the_category($id);//$post->ID
            $catid=true;
            $catlable='';
            $catname='';
            $labelclass="bg-green";
            foreach($category_detail as $cd){
                $catmainid=$cd->term_id;
                $cat_data 	= get_option("taxonomy_$catmainid");
                if($cat_data['labelclass']!="")
                {

                    $labelclass=$cat_data['labelclass'];
                }
                if($catid)
                {
                    $catlable .=$cd->cat_name;
                    $catname=$cd->cat_name;
                    $catid=false;
                }
                else {
                    $catlable .=' '.$cd->cat_name;
                }
                break;
            }
            ?>


            <div id="main-content">
                <div class="container-fluid">
                    <!-- Main editor page contents -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">

                            <section id="news-detail">
                                <div class="container">

                                    <div class="row top">
                                        <div class="col-md-offset-4 col-md-8 bg-image" <? if ($imgurl<>"") { ?> style="background-image:url(<?=$imgurl?>)" <?}?>></div>
                                        <div class="intro">
                                            <p class="<?php echo $labelclass; ?> news-tile"><?php echo $catlable; ?></p>
                                            <p class="small"><?php echo pll__('Posted');?>   <?php echo $tmonth.' '.$tday.',  '.$tyear; ?></p>

                                            <h1 class="page-heading"><?php echo get_the_title(); ?></h1>
                                            <?php echo do_shortcode('[print_blog_author]'); ?>
                                        </div>
                                    </div>

                                    <div class="row bottom">
                                        <div class="col-md-offset-1 col-md-7 col-sm-7 col-xs-12 left-content">
                                        <?php
                                        //remove_filter('the_content', 'wpautop');
                                        the_content();
                                        ?>
                                        </div>
                                        <div class="col-md-3 col-md-offset-1 col-sm-offset-1 col-sm-4 col-xs-12 right-sidebar">

                                            <?php if ( function_exists ( dynamic_sidebar('articles-top-box') ) ) : ?>
                                                <?php dynamic_sidebar('articles-top-box'); ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>


                                    <? echo do_shortcode('[post_news_related category="'.$catname.'" exclude="'.$id.'"]'); ?>

                                </div>

                            </section>
                        </div>
                    </div>
                </div> <!-- /.container-fluid -->
            </div> <!-- /#main-content -->



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