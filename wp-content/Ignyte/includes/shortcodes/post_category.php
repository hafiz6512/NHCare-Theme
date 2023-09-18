<?php
add_shortcode('post_hero_banner', 'ignyte_hero_shortcode');
function ignyte_hero_shortcode($atts)
{
    extract(shortcode_atts(array(
        'category'      => '',
        'h3title'       => '',
        'leadin'        => '',
        'num_articles'  => '1',
        'readmore_text' => 'Read More',
    ), $atts));

    if ($category <> '')
        $args = array(
            'posts_per_page' => $num_articles,
            'category_name'  => $category,
            //'orderby'         => 'date',
            //'order'		   => 'DESC',
            'meta_key'       => 'newsbanner-checkbox',
            'meta_value'     => 'yes',
            'post_type'      => 'post',
            'post_status'    => 'publish');
    else
        $args = array(
            'posts_per_page' => $num_articles,
            'meta_key'       => 'newsbanner-checkbox',
            'meta_value'     => 'yes',
            'post_type'      => 'post',
            'post_status'    => 'publish');

    $post = get_posts($args);
    $return = "";
    $i = 0;
    foreach ($post as $p) {

        $category_detail = get_the_category($p->ID);//$post->ID
        $catid = true;
        $catlable = '';
        $labelclass = "bg-green";
        //print_r($category_detail);
        foreach ($category_detail as $cd) {
            $catmainid = $cd->term_id;
            $cat_data = get_option("taxonomy_$catmainid");
            $labelclass = $cat_data['labelclass'];
            if ($catid) {
                $catlable .= $cd->cat_name;
                $catid = false;
            } else {
                $catlable .= ' ' . $cd->cat_name;
            }
            break;
        }
        $title = apply_filters('the_title', $p->post_title);
        $excerpt = apply_filters('the_excerpt', $p->post_excerpt);
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'full');
        // $thumbnail =  get_attached_file( get_post_thumbnail_id($p->ID) );
        $tday = get_the_date("d", $p->ID);
        $tmonth = get_the_date("F", $p->ID);
        $tyear = get_the_date("Y", $p->ID);
        $image = $thumbnail[0];
        //var_dump(file_get_contents($thumbnail[0]));
        $meta_values = get_post_meta($p->ID);
        $fallback = $meta_values["ignyte-service-fallback-image"][0];


        $return .= '<div class="row top margin-0" >
            <div class="col-md-offset-1 col-md-11 bg-image"  style="background-image: url(' . $image . ');"></div>
            <div class="intro">
                <p class="' . $labelclass . ' news-tile">' . $catlable . '</p>
               <p class="small">
						   ' . pll__('Posted') . ' ' . $tmonth . ' '. $tday . ', '  . $tyear . '
						</p>
                <h2>' . $title . '</h2>
                <a class="btn arrow green" href="' . get_permalink($p->ID) . '">' . pll__('Read More') . '</a>

            </div>
        </div>
        ';
        $i++;
    }
    wp_reset_postdata();


    return $return;
}


add_shortcode('post_featured', 'ignyte_featured');
function ignyte_featured($atts)
{
    extract(shortcode_atts(array(
        'category'      => '',
        'h3title'       => '',
        'leadin'        => '',
        'num_articles'  => '3',
        'readmore_text' => 'Read More',
    ), $atts));

    if ($category <> '')
        $args = array(
            'posts_per_page' => $num_articles,
            'category_name'  => $category,
            //'orderby'         => 'date',
            //'order'		   => 'DESC',
            'meta_key'       => 'meta-checkbox',
            'meta_value'     => 'yes',
            'post_type'      => 'post',
            'post_status'    => 'publish');
    else
        $args = array(
            'posts_per_page' => $num_articles,
            'meta_key'       => 'meta-checkbox',
            'meta_value'     => 'yes',
            'post_type'      => 'post',
            'post_status'    => 'publish');

    $post = get_posts($args);
    $return = "";
    $i = 0;
    foreach ($post as $p) {

        $category_detail = get_the_category($p->ID);//$post->ID
        $catid = true;
        $catlable = '';
        $labelclass = "bg-green";
        foreach ($category_detail as $cd) {
            $catmainid = $cd->term_id;
            $cat_data = get_option("taxonomy_$catmainid");
            if ($cat_data['labelclass'] != '') {
                $labelclass = $cat_data['labelclass'];
            }
            if ($catid) {
                $catlable .= $cd->cat_name;
                $catid = false;
            } else {
                $catlable .= ' ' . $cd->cat_name;
            }
        }
        $title = apply_filters('the_title', $p->post_title);
        $excerpt = apply_filters('the_excerpt', $p->post_excerpt);
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'large');
        // $thumbnail =  get_attached_file( get_post_thumbnail_id($p->ID) );
        $tday = get_the_date("d", $p->ID);
        $tmonth = get_the_date("F", $p->ID);
        $tyear = get_the_date("Y", $p->ID);
        $image = $thumbnail[0];
        //var_dump(file_get_contents($thumbnail[0]));
        $meta_values = get_post_meta($p->ID);
        $fallback = $meta_values["ignyte-service-fallback-image"][0];

        $return .= '  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 bottom-60" onclick=" javascript:location.href=\'' . get_permalink($p->ID) . '\'" >
                    <div class="article">
                        <p class="' . $labelclass . ' news-tiles">' . $catlable . '</p>

                        <div class="article-image" style="background-image: url(' . $image . ');"></div>
                        <div class="feature-article">
                            <div class="date-wrap">
                                <p class="small">
                                   ' . pll__('Posted') . '  '. $tmonth . ', ' . $tday . ' '  . $tyear . '
                                   </p> </div>
                            <h5>' . $title . '</h5>
                            <!--<a class="icon" href="http://staging.nhcare.org/demo-testing-3/"><i class="fa fa fa-arrow-right border-green vh-center"></i></a>-->
                            <a class="btn green arrow" type="button" href="' . get_permalink($p->ID) . '"><span class="hidden-text">' . pll__('Read More') . '</span></a>

                        </div>
                    </div>
                </div>';
        $i++;
    }
    wp_reset_postdata();

    $return = ' <div class="col-md-offset-1 col-md-10 col-md-offset-1 col-sm-12 padding-0">' . $return . '</div>';

    return $return;
}


add_shortcode('allpost', 'ignyte_posts');
function ignyte_posts($atts)
{
    extract(shortcode_atts(array(
        'category'      => '',
        'h3title'       => '',
        'leadin'        => '',
        'totalpost'     => '6',
        'readmore_text' => 'Read More',
    ), $atts));

    $prevpage = 1;
    $defaultload = 2;
    $firstload = -1;

    $nextpage = $prevpage + 1;
    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $firstload);

    $post = get_posts($args);
    $totalres = count($post);
    $return = "";
    $i = 0;
    foreach ($post as $p) {

        $category_detail = get_the_category($p->ID);//$post->ID
        $catid = true;
        $catlable = '';
        $catslug = '';
        $labelclass = "bg-green";
        foreach ($category_detail as $cd) {
            $catmainid = $cd->term_id;
            $cat_data = get_option("taxonomy_$catmainid");
            if ($cat_data['labelclass'] != '') {
                $labelclass = $cat_data['labelclass'];
            }
            if ($catid) {
                $catlable .= $cd->cat_name;
                $catslug .= $cd->slug;
                $catid = false;
            } else {
                $catlable .= ' ' . $cd->cat_name;
                $catslug .= ' ' . $cd->slug;
            }
        }
        $title = apply_filters('the_title', $p->post_title);
        $excerpt = apply_filters('the_excerpt', $p->post_excerpt);
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'large');
        // $thumbnail =  get_attached_file( get_post_thumbnail_id($p->ID) );
        $tday = get_the_date("d", $p->ID);
        $tmonth = get_the_date("F", $p->ID);
        $tyear = get_the_date("Y", $p->ID);
        $image = $thumbnail[0];

        $finaldatefilter = get_the_date("Ymd", $p->ID);
        //var_dump(file_get_contents($thumbnail[0]));
        $meta_values = get_post_meta($p->ID);
        $fallback = $meta_values["ignyte-service-fallback-image"][0];


        $return .= '<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 grid-view element-item ' . $catslug . '" onclick=" javascript:location.href=\'' . get_permalink($p->ID) . '\'" data-ticks="' . $finaldatefilter . '">
					<div class="grid-post">
                    <p class="' . $labelclass . ' news-tiles">' . $catlable . '</p>
                    <div class="grid-image" style="background-image: url(' . $image . ');"></div>
                    <div class="grid-intro">
                        <div class="date-wrap">
                            <p class="small">
                                ' . pll__('Posted') . '  '. $tmonth . ' ' . $tday . ', '  . $tyear . '
                       </p> </div>
                         <h5 class="file-by">' . $title . '</h5>
                        <!--<a class="btn green" type="button"><span class="hidden-text">READ MORE</span><i class="fa fa-arrow-right"></i></a>!-->
                             <a class="btn green arrow" type="button" href="' . get_permalink($p->ID) . '"><span class="hidden-text">' . pll__('Read More') . '</span></a>
                      
                    </div>
					</div>
                </div>';
        $i++;
    }
    wp_reset_postdata();

    $category_detail2 = get_categories();//$post->ID
    $catfilter = "";
    foreach ($category_detail2 as $cd) {

        $catname = $cd->cat_name;
        $catslugl = $cd->slug;
        $catfilter .= ' <li class="isotopebutton" data-filter=".' . $catslugl . '" > <a  id="' . $catslugl . '" >' . $catname . '</a></li>';

    }

    $loadmore = '';
    $count_posts = wp_count_posts('post');
    $total_posts = $count_posts->publish;

    if ($totalres < $total_posts) {

        $loadmore = ' <div class="col-md-12 pagination-count center" id="load-more">
 <a class="btn hidden-text-btn icon green load-more-provider"><div class="hidden-text">' . pll__('Read More') . '</div></a></div>';
    }

    $return2 = '  <div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 col-xs-12 filter-values">
				<div class="row margin-0  mob-visible">
					<div class="col-lg-1 col-md-1 col-sm-1 col-xs-6 left-0">
						<span>' . pll__('Filters') . '</span>
					</div>
					<div class="col-lg-offset-0 col-lg-2 col-md-offset-0 col-md-2 col-sm-2 col-xs-6 sorting">
						<span>'.pll__("Sort by").'</span>
					</div>
				</div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-6 basic-filtering">
                    <span>' . pll__('Filters') . '</span>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-4 col-xs-6">
                    <ul id="filters" class="button-group-home" >
                        <li class="isotopebutton is-checked" data-filter="*"> <a    id="All" >' . pll__('All') . '</a></li>
                        ' . $catfilter . '
                    </ul>
                     <div class="dropdown filters mobile">
                        <button class="btn dropdown-toggle btn-blue form-control" type="button" id="mobilefilterbutton" data-toggle="dropdown"><span>' . pll__('All') . '</span></button>
            <ul class="dropdown-menu button-group-home" role="menu" id="mobilefilter">
             <li class="isotopebutton is-checked" data-filter="*"> <a    id="All" >' . pll__('All') . '</a></li>
                        ' . $catfilter . '
            </ul>
            </div>
              </div>
				<div class="col-lg-offset-0 col-lg-2 col-md-offset-0 col-md-2 col-sm-2 col-xs-6 sorting">
					<span>'.pll__("Sort by").'</span>
				</div>';

    $nwtoold = 'Newest to Oldest';
    $nwtoold2 = 'Oldest to Newest';
    $namez = 'A-Z';
    $namez2 = 'Z-A';
    //$yearbulk = 'Month Year Combos Asc';
    //$yearbulk2 = 'Month Year Combos Desc';
    $return2 .= '<div class="col-lg-2 col-md-2 col-sm-5 col-xs-6 padding-0">
        <div class="dropdown filters">
                        <button class="btn dropdown-toggle btn-blue form-control" type="button" id="gender-dropdown" data-toggle="dropdown"><span>' . $nwtoold . '</span></button>
            <ul class="dropdown-menu sort-button-group" role="menu" aria-labelledby="gender-dropdown" data-filter-group="all_shorts">
              <li role="presentation" data-sort-direction="desc" data-sort-desc="' . $nwtoold2 . '" data-sort-asc="' . $nwtoold . '" data-sort-value="original-order" class="short_li">' . $nwtoold2 . '</a>
                </li>
                <li role="presentation" data-sort-direction="asc" data-sort-desc="' . $namez2 . '" data-sort-asc="' . $namez . '" data-sort-value="fileby" class="short_li">' . $namez2 . '</a>
                </li>
                   <!--<li role="presentation" data-sort-direction="asc"  data-sort-desc="' . $yearbulk2 . '" data-sort-asc="' . $yearbulk . '" data-sort-value="filedate" class="short_li">' . $yearbulk . '</a>
                </li>-->
            </ul>';

    $return2 .= '<!-- <ul id="filters" class="button-group-home">
						<li class="most-recent-post padding-0"><a id="">Most Recent</a></li>
						<li class="most-recent-post padding-0"><a id="">Most Recent</a></li>
						<li class="most-recent-post padding-0"><a id="">Most Recent</a></li>
					</ul>-->
        </div>
				</div>
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <hr>

                </div>
            </div> 
            <div class="col-md-offset-1 col-md-10 col-md-offset-1 col-sm-12 col-xs-12 filter-grid padding-0 isotope">' . $return . '</div>' . $loadmore;


    $script = " <script>
     
        
    </script><script>
    jQuery(document).ready(function() {

   jQuery('#mobilefilter a').click(function(){
  //jQuery(\"p:first\").addClass(\"intro\");
  
   jQuery('#mobilefilterbutton').html('<span>'+jQuery(this).text()+'</span>');
});
        // init Isotope
        var initial_items = " . $totalpost . ";
        var next_items = " . $totalpost . ";
        var qsRegex;
        var grid = jQuery('.isotope').isotope({
            itemSelector: '.element-item',
            layoutMode: 'masonry',
            stamp: '.element-item--static',
              filter: function () {
                            var thisdata = jQuery(this);
                            var searchResult = qsRegex ? thisdata.text().match(qsRegex) : true;
                            //var buttonResult = buttonFilter ? thisdata.is(buttonFilter) : true;
                            return searchResult;
                        },
                          getSortData: {
            fileby:   '.file-by',
            filename: '.file-name',
            filedate: '[data-ticks]',
            filesize: function( itemElem ) {
                var filesize = jQuery( itemElem ).attr('data-filesize');
                return parseInt( filesize );
            }
        }
        });


// bind filter button click
        jQuery('.button-group-home').on('click', '.isotopebutton', function () {
            var filterValue = jQuery(this).attr('data-filter');
            // use filterFn if matches value
            grid.isotope({filter: filterValue});
            updateFilterCounts();
        });
        
        
        // bind sort button click
    jQuery('.sort-button-group').on( 'click', '.short_li', function() {
        /* Get the element name to sort */
        var sortValue = jQuery(this).attr('data-sort-value');

        /* Get the sorting direction: asc||desc */
        var direction = jQuery(this).attr('data-sort-direction');
            /* convert it to a boolean */
           var olderlable= jQuery(this).html();
            jQuery('#gender-dropdown').html('<span>'+olderlable+'</span>');
            
        var isAscending = direction;
        var isAscending = (direction == 'asc');
       var newDirection = (isAscending) ? 'desc' : 'asc';
        /* pass it to isotope */
        grid.isotope({ sortBy: sortValue, sortAscending: isAscending });
        jQuery(this).attr('data-sort-direction', newDirection);
        var newlabel = jQuery(this).attr('data-sort-'+newDirection);
       // alert(newlabel)
         jQuery(this).html(newlabel);
         
        updateFilterCounts();

    });
    
        function updateFilterCounts() {
            // get filtered item elements
            var itemElems = grid.isotope('getFilteredItemElements');
            var count_items = jQuery(itemElems).length;

            if (count_items > initial_items) {jQuery('#load-more').show();
            }
            else {
                jQuery('#load-more').hide();
            }
            if (jQuery('.element-item').hasClass('visible_item')) {
                jQuery('.element-item').removeClass('visible_item');
            }
            var index = 0;

            jQuery(itemElems).each(function () {
                if (index >= initial_items) {
                    jQuery(this).addClass('visible_item');
                }
                index++;
            });
            grid.isotope('layout');
            
        }
// change is-checked class on buttons
        jQuery('.button-group-home').each(function (i, buttonGroup) {
            var buttonGroup = jQuery(buttonGroup);
            buttonGroup.on('click', '.isotopebutton', function () {
                buttonGroup.find('.is-checked').removeClass('is-checked');
                jQuery(this).addClass('is-checked');
            });
        });

           // use value of search field to filter
                    var quicksearch = jQuery('.quicksearch').keyup(debounce(function () {
                        qsRegex = new RegExp(quicksearch.val(), 'gi');
                        grid.isotope();
                          updateFilterCounts();
                    }));
                    
        function showNextItems(pagination) {
            var itemsMax = jQuery('.visible_item').length;
            var itemsCount = 0;
            jQuery('.visible_item').each(function () {
                if (itemsCount < pagination) {
                    jQuery(this).removeClass('visible_item');
                    itemsCount++;
                }
            });
            if (itemsCount >= itemsMax) {
                jQuery('#load-more').hide();
            }
            grid.isotope('layout');
        }
// function that hides items when page is loaded
        function hideItems(pagination) {
            var itemsMax = jQuery('.element-item').length;
            var itemsCount = 0;
            jQuery('.element-item').each(function () {
                if (itemsCount >= pagination) {
                    jQuery(this).addClass('visible_item');
                }
                itemsCount++;
            });
            if (itemsCount < itemsMax || initial_items >= itemsMax) {
                jQuery('#load-more').hide();
            }
            grid.isotope('layout');
        }
        jQuery('#load-more').on('click', function (e) {
            e.preventDefault();
            showNextItems(next_items);
        });
        hideItems(initial_items);
        
        
                     function debounce(fn, threshold) {
                    var timeout;
                    threshold = threshold || 100;
                    return function debounced() {
                        clearTimeout(timeout);
                        var args = arguments;
                        var _this = this;

                        function delayed() {
                            fn.apply(_this, args);
                        }

                        timeout = setTimeout(delayed, threshold);
                    };
                }


    });

        function getmaxheight() {
            var heights = jQuery(\"div.isotopeSelector\").map(function () {
                    return jQuery(this).height();
                }).get(),

                maxHeight = Math.max.apply(null, heights);
            //alert(maxHeight);
            jQuery('.isotopeSelector').height(maxHeight+0);
        }
        //jQuery(window).resize(getmaxheight);
       // getmaxheight();

    </script>";


    return $return2 . $script;
}

function getvideo2slide($ids,$view_button_label)
{

    $return = "";
    $i = 0;
    $myArray = explode(',', $ids);

    $args = array(
        'posts_per_page' => 6,
        'post_type'      => 'post',
        //'lang'           => $slug,
        'post__in' => $myArray,
        'post_status'    => 'publish');
    $post = get_posts($args);
    foreach ($post as $p) {

        $category_detail = get_the_category($p->ID);//$post->ID
        $catid = true;
        $catlable = '';
        $labelclass = "bg-green";
        foreach ($category_detail as $cd) {
            $catmainid = $cd->term_id;
            $cat_data = get_option("taxonomy_$catmainid");
            if ($cat_data['labelclass'] != '') {
                $labelclass = $cat_data['labelclass'];
            }
            if ($catid) {
                $catlable .= $cd->cat_name;
                $catid = false;
            } else {
                $catlable .= ' ' . $cd->cat_name;
            }
        }

        $title2 = apply_filters('the_title', $p->post_title);
        $excerpt = apply_filters('the_excerpt', $p->post_excerpt);
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'medium');
        // $thumbnail =  get_attached_file( get_post_thumbnail_id($p->ID) );
        $tday = get_the_date("d", $p->ID);
        $tmonth = get_the_date("F", $p->ID);
        $tyear = get_the_date("Y", $p->ID);
        $image = $thumbnail[0];
        //var_dump(file_get_contents($thumbnail[0]));
        $meta_values = get_post_meta($p->ID);
        // $docmeta = get_post_meta($doc->ID);
        $fallback = $meta_values["ignyte-service-fallback-image"][0];
        $videoselect = $meta_values["video-checkbox"][0];
        //$svg[$i]=file_get_contents($thumbnail[0]);
        //$svg[$i]=file_get_contents($thumbnail);
        //  $thumbnail = get_the_post_thumbnail_url($p->ID, 'full');

        $return .= '<li>
        <p class="' . $labelclass . ' news-tiles">' . $catlable . '</p>';
        if ($videoselect == 'yes3') {
            $return .= '<div class="category-image" >';
            $return .= ' <video controls="" id="video1" data-mp4="true" poster="' . $image . '">
                        <source src="'.$meta_values["postmp4"][0].'" type="video/mp4">
                        <source src="'.$meta_values["postogv"][0].'" type="video/ogv">
                        <source src="'.$meta_values["postwebm"][0].'" type="video/webm">
                    </video></div>';
        }
        else {
            $return .= '<div onclick=" javascript:location.href=\'' . get_permalink($p->ID) . '\'" class="category-image" style="background-image: url(' . $image . ');"></div>';
        }
        $return .= '<div class="category-news" onclick=" javascript:location.href=\'' . get_permalink($p->ID) . '\'">
					<div class="date-wrap">
						<p class="small">
						   ' . pll__('Posted') . ' ' . $tmonth .' ' . $tday .  ', ' . $tyear . '
						</p>
					</div>
					<h5>' . $title2 .$videoselect. '</h5><p>' . $excerpt . '</p> 
					<a class="btn hidden-text-btn arrow" href="' . get_permalink($p->ID) . '"><div class="hidden-text">' . $view_button_label . '</div></a>
				</div>
                </li>';

        $i++;
    }
    wp_reset_postdata();
    return $return;
}
add_shortcode('post_category_news', 'ignyte_news_slider_shortcode');

function ignyte_news_slider_shortcode($atts)
{
    extract(shortcode_atts(array(
        'category'          => '',
        'leadin'            => '',
        'num_articles'      => '10',
        'title'             => 'Latest Neighborhood News',
        'all_button_label'  => 'View All News',
        'all_button_link'  => '/news/',
        'view_button_label' => 'VIEW MORE',
        'next_button_label' => 'NEXT',
        'prev_button_label' => 'PREVIOUS',
        'video_ids'=>''
    ), $atts));

    $currentlang = get_bloginfo('language');
    $slug = pll_current_language('slug');

    if ($category <> '')
        $args = array(
            'posts_per_page' => $num_articles,
            'category_name'  => $category,
            'post_type'      => 'post',
            'lang'           => $slug,
            'post_status'    => 'publish');
    else
        $args = array(
            'posts_per_page' => $num_articles,
            'post_type'      => 'post',
            'lang'           => $slug,
            'post_status'    => 'publish');
    if ($showhome != '') {
        $args['meta_key'] = 'home-checkbox';
        $args['meta_value'] = 'yes';
    }

    $post = get_posts($args);
    $return = "";
    $i = 0;
    foreach ($post as $p) {

        $category_detail = get_the_category($p->ID);//$post->ID
        $catid = true;
        $catlable = '';
        $labelclass = "bg-green";
        foreach ($category_detail as $cd) {
            $catmainid = $cd->term_id;
            $cat_data = get_option("taxonomy_$catmainid");
            if ($cat_data['labelclass'] != '') {
                $labelclass = $cat_data['labelclass'];
            }
            if ($catid) {
                $catlable .= $cd->cat_name;
                $catid = false;
            } else {
                $catlable .= ' ' . $cd->cat_name;
            }
        }

        $title2 = apply_filters('the_title', $p->post_title);
        $excerpt = apply_filters('the_excerpt', $p->post_excerpt);
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'large');
        // $thumbnail =  get_attached_file( get_post_thumbnail_id($p->ID) );
        $tday = get_the_date("d", $p->ID);
        $tmonth = get_the_date("F", $p->ID);
        $tyear = get_the_date("Y", $p->ID);
        $image = $thumbnail[0];
        // var_dump(file_get_contents($thumbnail[0]));
		$meta_values = get_post_meta($p->ID);
       // $docmeta = get_post_meta($doc->ID);
        $fallback = $meta_values["ignyte-service-fallback-image"][0];
        $videoselect = $meta_values["video-checkbox"][0];
        //$svg[$i]=file_get_contents($thumbnail[0]);
        //$svg[$i]=file_get_contents($thumbnail);
        //  $thumbnail = get_the_post_thumbnail_url($p->ID, 'full');

        $return .= '<li>
        <p class="' . $labelclass . ' news-tiles">' . $catlable . '</p>';
        if ($videoselect == 'yes3') {
            $return .= '<div class="category-image" >';
            $return .= ' <video controls="" id="video1" data-mp4="true" poster="' . $image . '">
                        <source src="'.$meta_values["postmp4"][0].'" type="video/mp4">
                        <source src="'.$meta_values["postogv"][0].'" type="video/ogv">
                        <source src="'.$meta_values["postwebm"][0].'" type="video/webm">
                    </video></div>';
        }
        else {
                $return .= '<div onclick=" javascript:location.href=\'' . get_permalink($p->ID) . '\'" class="category-image" style="background-image: url(' . $image . ');"></div>';
            }
            $return .= '<div class="category-news" onclick=" javascript:location.href=\'' . get_permalink($p->ID) . '\'">
					<div class="date-wrap">
						<p class="small">
						   ' . pll__('Posted') . ' ' . $tday . ' ' . $tmonth . ', ' . $tyear . '
						</p>
					</div>
					<h5>' . $title2 .$videoselect. '</h5><p>' . $excerpt . '</p> 
					<a class="btn hidden-text-btn arrow" href="' . get_permalink($p->ID) . '"><div class="hidden-text">' . $view_button_label . '</div></a>
				</div>
                </li>';


            $i++;
        }
        if($video_ids!='')
        {
            $return .=getvideo2slide($video_ids,$view_button_label);
        }
        wp_reset_postdata();
        $controller = '';
        for ($x = 0; $x <= $i; $x++) {
            $controller .= '<li><a></a></li>';
        }
        $allcontroller = '<div class="home-news">
<div class="container"><!--container start-->
                    <div class="row inner-padding"> <!--row start-->
                    <div class="col-sm-12 col-md-12 padding-0">
 <h2>' . $title . '</h2>
 </div>
</div><!--row close-->
</div><!--container close-->
</div>';

        $return = '   <div id="slider-wrapper-sec" class="slider"  style="opacity:0">
     ' . $allcontroller . '
         <div class="container-fluid"><!--container start-->
                    <div class="row inner-padding"><!--row start-->
                    <div class="flexslider-news">
        <ul class="slides">
            ' . $return . '
        </ul>
    </div>
	<div class="container">
	<div class="row">
		<div class="col-sm-12 col-md-offset-1 col-md-10">
			<div class="custom-navigation-news">
				<div class="flex-direction-nav">
					<div class="left-arrow"><a class="btn hidden-text-btn flex-prev chevron"><div class="hidden-text">' . $prev_button_label . '</div></a></div>
					<div class="right-arrow"><a class="btn hidden-text-btn flex-next chevron" ><div class="hidden-text">' . $next_button_label . '</div></a></div>
				</div>
			</div>
		</div>
		<div class="col-md-12 center absolute">
			<a href="'.$all_button_link.'" class="btn">' . $all_button_label . '</a>
	   </div>
   </div>
   </div>
    </div>
    </div>
</div>
';

        $script = ' <script type="text/javascript">
    (function() {
        // store the slider in a local variable
        var mainwindow2 = jQuery(window),
            flexslider = { vars:{} };

        // tiny helper function to add breakpoints
       
        mainwindow2.load(function() {
            jQuery(".flexslider-news").flexslider({
                animation: "slide",
                controlNav:false,
                directionNav: false,
                animationSpeed: 400,
                slideshow: false,
                // animationLoop: false,
                touch:true,
                move:1,
              itemMargin: 35,
                itemWidth: 395,
              minItems: 1, // use function to pull in initial value
                maxItems: 6,// use function to pull in initial value
                start: function (slider) {
                    jQuery("body").removeClass("loading");
                    jQuery("#slider-wrapper-sec").css("opacity", "1");
                    flexslider = slider;
                    //jQuery("#slider-wrapper-first").css("opacity", "1");
                    window.addCurrentSlidesClass(slider);
                    var totalslide=jQuery(".flexslider-news .slides li").length;
                      //alert(totalslide+"=="+getGridSize2());
                      
                      
                      jQuery(".flexslider-news .slides li").each(function(){
                    slider.addSlide(\'<li>\'+jQuery(this).context.innerHTML+\'</li>\', slider.count);
                    jQuery(".flexslider-news .slides").append(\'<li>\'+jQuery(this).context.innerHTML+\'</li>\');
                });
                   
                       
             
                },
                after: function (slider) {
                    window.addCurrentSlidesClass(slider);
                    /* if (!slider.playing) {
                     slider.play();

                     }*/
                },
                 end : function(slider){
                jQuery(".flexslider-news .slides li").each(function(){
                    slider.addSlide(\'<li>\'+jQuery(this).context.innerHTML+\'</li>\', slider.count);
                    jQuery(".flexslider-news .slides").append(\'<li>\'+jQuery(this).context.innerHTML+\'</li>\');
                });
            }


            });
        });

       
        jQuery(".custom-navigation-news .flex-prev").on("click", function(){
            jQuery(".flexslider-news").flexslider("prev")
            return false;
        });

        jQuery(".custom-navigation-news .flex-next").on("click", function(){
            jQuery(".flexslider-news").flexslider("next")
            return false;
        });




        window.addCurrentSlidesClass = function (slider) {
            //debugger;
            jQuery(".flexslider-news li").removeClass("active-slides");
            var startli = (slider.move * (slider.currentSlide));
            var endli = (slider.move * (slider.currentSlide + 1));

            for (i = startli + 1; i < endli; i++) {
                if (jQuery(window).width() > 500 ) {
                    jQuery(".flexslider-news li:nth-child(" + i + ")").addClass("active-slides");
                }
            }
        }

    }()); </script>';

        return $return . $script;
    }

    add_shortcode('post_news_related', 'ignyte_post_news_related_shortcode');
    function ignyte_post_news_related_shortcode($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'category'      => '',
            'h3title'       => '',
            'leadin'        => '',
            'exclude'       => '',
            'num_articles'  => '2',
            'number_posts'  => '2',
            'order'         => '',
            'orderby'       => 'date',
            'readmore_text' => 'Read More',
        ), $atts));

        if ($category <> '')
            $args = array(
                'posts_per_page' => $num_articles,
                'category_name'  => $category,
                'orderby'        => $orderby,
                'order'          => $order,
                'exclude'        => $exclude,
                'post_type'      => 'post',
                'post_status'    => 'publish');
        else
            $args = array(
                'posts_per_page' => $number_posts,
                'orderby'        => $orderby,
                'order'          => $order,
                'exclude'        => $exclude,
                'post_type'      => 'post',
                'post_status'    => 'publish');

        $post = get_posts($args);
        //var_dump($post);

        ob_start(); ?>

        <?php /*
    <? if ($h3title<>""){ ?><h3><?=$h3title?></h3><? } ?>
    <? if ($leadin<>""){ ?><p><?=$leadin?></p><? } ?>
*/ ?>

        <?
        $i = 0;
        foreach ($post as $p) {

            $content_post = get_post($p->ID);
            // $content = $content_post->post_content;
            // $content = get_the_excerpt($p->ID);
            //var_dump($content);

            //  $url= wp_get_attachment_url( get_post_thumbnail_id($p->ID));
            $url = get_the_post_thumbnail_url($p->ID, 'large');
            $id = $p->ID;
            $page_meta = get_post_meta($id);
            $currentlang = get_bloginfo('language');
            $tday = get_the_date("d", $id);
            $tmonth = get_the_date("F", $id);
            $tyear = get_the_date("Y", $id);

            $catt = get_term_by('name', $category, 'category');
            $labelclass = "bg-green";
            $catmainid = $catt->term_id;;
            $cat_data = get_option("taxonomy_$catmainid");
            if ($cat_data != "") {
                $labelclass = $cat_data['labelclass'];
            }


            ?>


            <div class="col-md-6 col-sm-6 col-xs-12 related-grid" onclick="javascript:location.href='<?= get_permalink($p->ID) ?>'">
                <div class="list-image" style="background-image:url(<?php echo $url; ?>)"></div>
                <div class="list-intro">
                    <p class="<?= $labelclass; ?> news-tiles"><?php echo $category; ?></p>

                    <div class="date-wrap">
                        <p class="small">
                            <?php echo pll__('Posted'); ?><?php echo $tmonth .' '.  $tday .', ' . $tyear; ?>
                        </p>
                    </div>
                    <h5><? echo get_the_title($p->ID); ?></h5>
                    <a class="btn arrow icon"></a>

                </div>
            </div>


            <?php $i++;
        } ?>


        <? $html = ob_get_contents();
        ob_end_clean();
        $tittle = '';
        if ($i > 0) {
            $tittle = ' <div class="row related-content-section"><div class="col-lg-offset-1 col-lg-11 col-md-12 col-sm-12 col-xs-12"><h5>' . pll__('Related content') . '</h5></div>';
        }

        return $tittle . '<div class="col-lg-offset-1 col-lg-11 col-md-12 col-sm-12 col-xs-12 padding-0">'. $html .'</div></div>';
    }