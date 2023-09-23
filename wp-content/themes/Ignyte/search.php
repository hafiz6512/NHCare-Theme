<?php
/*
Template Name: Search Page
*/
get_header();

$page_meta = get_post_meta(get_the_ID());
$startloadjs = 6;
?>

    <div id="page-wrap">

        <!-- Or if page has a banner at top -->


        <div id="main-content" class="container">

            <div class="row">

                <!-- main column -->
                <div class="col-xs-12 col-sm-12 col-lg-12 main-column">

                    <div class="lead-copy">
                        <div class="row result-key">
                            <div class="col-md-offset-1 col-md-11">
                                <?php global $wp_query;
                                $total_posts = $wp_query->found_posts;
                                ?>
                                <span><?php echo pll__('There are'); ?> <?php echo $wp_query->found_posts; ?> <?php echo pll__('results for'); ?></span>
                                <h1 class="page-heading red"><?php printf(__('" %s "', 'Ignyte'), get_search_query()); ?></h1>
                            </div>
                        </div>
                        <div class="search-result-page">
                            <?php if ($total_posts > 0) { ?>
                                <div class="row bottom">
                                    <div class="col-md-offset-3 col-md-7">

                                        <? while (have_posts()) : the_post();
                                            ?>
                                            <div class="content searchli">
                                                <h5><?= the_title() ?></h5>
                                                <a href="<?= get_permalink() ?>" class="red"><?= get_permalink() ?></a>
                                                <p><?= str_replace('[...]', '', the_excerpt()); ?></p>
                                            </div>
                                            <?
                                        endwhile;
                                        ?>
                                    </div>
                                </div>

                                <div class="row page loadmore">
                                    <div class="bottom-paginations">
                                        <p class="bottom-pagination"><?php echo pll__('Showing') . ' ' . $startloadjs . ' ' . pll__('of') . ' “' . $total_posts . ' ' . pll__('Results'); ?>
                                            ”.</p>

                                    </div>
                                    <div class="pagination-count center">
                                        <a class="btn hidden-text-btn icon red add-more load-more-provider">
                                            <div class="hidden-text"><?php echo pll__('Show More'); ?></div>
                                        </a>
                                    </div>
                                </div>

                                <style>
                                    .searchli {
                                        display: none;
                                    }
                                </style>
                                <script>
                                    jQuery(function () {
                                        var startfrom =<?=$startloadjs;?>;
                                        var increase =<?=$startloadjs;?>;
                                        // jQuery(\".job\").slice(0, startfrom).show();

                                        function loadmoredata(startfromvar, increase) {
                                            jQuery(".searchli:hidden").slice(0, increase).slideDown();
                                            if (jQuery(".searchli:hidden").length == 0) {
                                                jQuery(".loadmore").fadeOut('fast');
                                            }
                                            taotalrac = <?php echo $total_posts; ?>;
                                            // startfrom=startfrom+increase;
                                            htmlString = '<div class="bottom-paginations"><p class="bottom-pagination"><?php echo pll__('Showing');?> ' + startfromvar + ' <?php echo pll__('of');?>  “' + taotalrac + ' <?php echo pll__('Results');?>”.</p></div>' +
                                                '<div class="pagination-count center">' +
                                                '<a class="btn hidden-text-btn icon red add-more load-more-provider" ><div class="hidden-text"><?php echo pll__('Show More');?></div></a>' +
                                                '</div>';
                                            jQuery('.loadmore').html(htmlString);
                                        }

                                        loadmoredata(startfrom, increase);


                                        jQuery(".loadmore").on('click', function (e) {
                                            taotalract = <?php echo $total_posts; ?>;
                                            older = parseInt(startfrom) + parseInt(increase);
                                            if (older > taotalract) {
                                                startfrom = older;
                                            }
                                            //alert(startfrom+'=='+increase)
                                            e.preventDefault();
                                            loadmoredata(startfrom, increase);
                                        });

                                    });

                                </script>
                            <?php }  else { ?>
                                <div class="center"><?php echo pll__('Sorry, we couldn’t find results for');?>
                                    <?php printf(__('" %s "', 'Ignyte'), get_search_query()); ?> </div>
                            <?php } ?>
                        </div>
                    </div>

                </div>


            </div> <!-- /.row -->
        </div> <!-- /#main-content.container -->


    </div> <!-- /#page-wrap -->

<?php get_footer(); ?>