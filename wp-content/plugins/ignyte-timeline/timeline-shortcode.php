<?php
add_shortcode('ignyte_timeline', 'ignyte_timeline_shortcode');
function ignyte_timeline_shortcode($atts)
{
    extract(shortcode_atts(array(
        'number_posts' => '-1',
        'h2title'      => '',
        'leadin'       => '',
        'orderby'      => 'title',
        'id'           => '',
        'subnav_title' => '',
        'order'        => 'ASC',
    ), $atts));

    $currentlang = get_bloginfo('language');
    $lslug = pll_current_language('slug');
    $args = array(
        'numberposts' => $number_posts,
        'post_type'   => 'ignyte_timeline',
        'lang'        => $lslug,
        'post_status' => 'publish',
        'orderby' => 'publish_date',
        'order'   => 'DESC');
    $post = get_posts($args);
    $return = "";
    //$url= get_bloginfo('url');
    $datedot = '';
    $timelinedescription = '';
    $i = 0;
    $timelineselected = true;
    foreach ($post as $p) {
        $title = apply_filters('the_title', $p->post_title);
        $sslug = $p->post_name;
        $content = apply_filters('the_content', $p->post_content);
        $url = get_the_post_thumbnail_url($p->ID, 'full');
        $page_meta = get_post_meta($p->ID);
        $timlineactiveclass = '';
        if ($timelineselected) {
            $timlineactiveclass = 'selected';
            $timelineselected = false;
        }

        $sticky ='';
        $sticky .= ' <div class="nav-op"><a href="#' . $sslug . '">' . $title . '</a></div>';
        $return .= ' <div class="content thesection" id="' . $sslug . '">
                           <h5 class="red">' . $title . '</h5>';
        if ($url != "") {
            $return .= ' <div class="resources-image" style="background-image:url(' . $url . ');"></div>';
        }
        $return .= $content . '</div>';
        $datedot .= ' <li id="story-id-' . $p->ID . '" class="ht-dates-default"
                        data-date="story-id-' . $p->ID . '"><span
                            class="ctl-story-time ' . $timlineactiveclass . '"
                            data-date="story-id-' . $p->ID . '">' . $title . '</span></li>';

        //Description start
        $timelinedescription .= '<li id="story-id-' . $p->ID . '-content" data-date="story-id-' . $p->ID . '"
                        class="ht-default"> <div class="timeline-post white-post ht-content-default">';
        if ($page_meta["ignyte_project_casestudies_content"][0] != "") {
            $ii = 0;
            $data1 = explode('~', $page_meta['ignyte_project_casestudies_content'][0]);
            foreach ($data1 as $d) {
                $dat2 = explode('|', $d);
                if ($dat2[0] == "caseStudyBigImage") {
                    if ($dat2[1]) {

                        $timelinedescription .= '<h2  class="content-title"><a   title="' . $dat2[1] . '"   href="#">' . $dat2[1] . '</a></h2>';
                    }
                    $timelinedescription .= '<div class="ctl_info event-description full">';
                        if($dat2[2]!='') {
                           // $timelinedescription .= '<div class="full-width">  <a  title="' . $dat2[1] . '"  href="' . $dat2[2] . '"  class="ctl_prettyPhoto"><img  src="' . $dat2[2] . '" class="story-img wp-post-image" srcset="' . $dat2[2] . ' 843w, ' . $dat2[2] . ' 20w" sizes="(max-width: 843px) 100vw, 843px"/></a> </div>';
                           $timelinedescription .= '<div class="full-width">  <a  title="' . $dat2[1] . '"  href="' . $dat2[2] . '"  class="ctl_prettyPhoto"><img  src="' . $dat2[2] . '" class="story-img wp-post-image" /></a> </div>';

                        }
                      if($dat2[3]!='') { $timelinedescription .= ' <div class="content-details">' . $dat2[3] . '<p></div>'; }

                        $timelinedescription .= '  </div>';

                }
                if ($dat2[0] == "casstudiesvideo") {
                    if ($dat2[1]) {

                        $timelinedescription .= '<h2  class="content-title"><a   title="' . $dat2[1] . '"   href="#">' . $dat2[1] . '</a></h2>';
                    }
                    $timelinedescription .= '<div class="ctl_info event-description full">';
                    //if($dat2[2]!='' ) {
                        $timelinedescription .= '<div class="full-width"><video controls="" id="video1" data-mp4="true" poster="' . $dat2[2] . '">
                                <source src="' . $dat2[3] . '" type="video/mp4">
                                <source src="' . $dat2[4] . '" type="video/ogv">
                                <source src="' . $dat2[5] . '" type="video/webm">
                            </video> </div>';
                   // }
                    if($dat2[6]!='') { $timelinedescription .= ' <div class="content-details">' . $dat2[6] . '<p></div>'; }

                    $timelinedescription .= '  </div>';
                }
                if ($dat2[0] == "casestudy_textcontent") {
                    if ($dat2[1]) {

                        $timelinedescription .= '<h2  class="content-title"><a   title="' . $dat2[1] . '"   href="#">' . $dat2[1] . '</a></h2>';
                    }
                    $timelinedescription .= '<div class="ctl_info event-description full">';

                    if($dat2[2]!='') { $timelinedescription .= ' <div class="content-details">' . $dat2[2] . '<p></div>'; }

                    $timelinedescription .= '  </div>';
                }
                if ($dat2[0] == "casestudy_2col_images") {

                    $timelinedescription .= '<div class="ctl_info event-description full">';


                        $timelinedescription .= '  <div class="clt_gallery">
                                    <ul class="story-gallery">';

                    if($dat2[1]!='') {
                        $timelinedescription .= '<li><a class="ctl_prettyPhoto"
                                               rel="ctl_prettyPhoto[pp_gallery-' . $p->ID . ']"
                                               href="'.$dat2[1].'"><img
                                                class="gallery_images"
                                                src="'.$dat2[1].'" alt="'.$dat2[2].'"></a>
                                             </li>';
                    }
                    if($dat2[4]!='') {
                        $timelinedescription .= '<li><a class="ctl_prettyPhoto"
                                               rel="ctl_prettyPhoto[pp_gallery-' . $p->ID . ']"
                                               href="'.$dat2[4].'"><img
                                                class="gallery_images"
                                                src="'.$dat2[4].'" alt="'.$dat2[5].'"></a>
                                             </li>';
                    }


                    $timelinedescription .= ' </ul>
                                    <div style="clear:both"></div>
                                </div>';



                    $timelinedescription .= '  </div>';
                }
            }
            $timelinedescription .= '</div></li>';
        }
        $i++;
    }
    $return = ' <style>.timeline-stories video{ width: 100%}</style><div style="opacity:0"
         class="cool-timeline-horizontal light-timeline timeline-stories ht-default"
         id="ctl-horizontal-slider-5d79cd7cf3e7a"
         data-rtl="false"
         date-slider="ctl-h-slider-5d79cd7cf3e7a"
         data-nav="nav-slider-5d79cd7cf3e7a"
         data-items="0"
         data-start-on="0"
         data-autoplay="false">

        <div class="timeline-wrapper light-timeline-wrapper hori-items-1">
            <div class="clt_carousel_slider" dir="">
                <ul class="ctl_h_nav" id="nav-slider-5d79cd7cf3e7a">
                    ' . $datedot . '
                </ul>
            </div>
            <div class="clt_caru_slider" dir="">
                <ul class="ctl_h_slides" id="ctl-h-slider-5d79cd7cf3e7a">
                '.$timelinedescription.'
                </ul>
            </div>
        </div>
    </div>';

    $return .= "
<link rel='stylesheet' href='/wp-content/plugins/ignyte-timeline/css/slick.css' type='text/css' media='all'/>
<link rel='stylesheet'  href='/wp-content/plugins/ignyte-timeline/css/ignyte-timeline-horizontal.css' type='text/css' media='all'/>
<link rel='stylesheet' id='ctl_pp_css-css'  href='/wp-content/plugins/ignyte-timeline/css/prettyPhoto.css' type='text/css' media='all'/>
<script type='text/javascript'  src='/wp-content/plugins/ignyte-timeline/js/jquery.prettyPhoto.js'></script>
<script type='text/javascript'  src='/wp-content/plugins/ignyte-timeline/js/slick.min.js'></script>
        <script>

    jQuery(\"document\").ready(function(t) {
       t(\".cool-timeline-horizontal\").find(\"a[class^='ctl_prettyPhoto']\").prettyPhoto({
            social_tools: !1
        }), t(\".cool-timeline-horizontal\").find(\"a[rel^='ctl_prettyPhoto']\").prettyPhoto({
            social_tools: !1
        }), 
       t(\".cool-timeline-horizontal.ht-default\").each(function(o) {
            var i = \"#\" + t(this).attr(\"date-slider\"),
                a = \"#\" + t(this).attr(\"data-nav\"),
                e = t(this).attr(\"data-rtl\"),
                s = t(this).attr(\"data-autoplay\"),
                r = \"true\" == s,
                l = parseInt(t(this).attr(\"data-start-on\")),
                n = 3,
                c = \"true\" === e;
            t(i).slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                rtl: c,
                asNavFor: a,
                arrows: !1,
                dots: !1,
                autoplay: r,
                infinite: !1,
                initialSlide: l,
                adaptiveHeight: !0,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        centerPadding: \"10px\",
                        slidesToShow: 1
                    }
                }, {
                    breakpoint: 480,
                    settings: {
                        centerPadding: \"10px\",
                        slidesToShow: 1
                    }
                }]
            }), t(a).slick({
                slidesToShow: n,
                slidesToScroll: 1,
                asNavFor: i,
                dots: !1,
                infinite: !1,
                rtl: c,
                autoplay: r,
                nextArrow: '<button type=\"button\" class=\"prev inactive ctl-slick-next \"></button>',
                prevArrow: '<button type=\"button\" class=\"next ctl-slick-prev\"></button>',
                focusOnSelect: !0,
                adaptiveHeight: !0,
                initialSlide: l,
                responsive: [{
                    breakpoint: 768,
                    settings: {
                        arrows: !0,
                        centerPadding: \"10px\",
                        slidesToShow: 1
                    }
                }, {
                    breakpoint: 480,
                    settings: {
                        arrows: !0,
                        centerPadding: \"10px\",
                        slidesToShow: 1
                    }
                }]
            })
        })
        
   
   setTimeout(function(){
jQuery(\"#ctl-h-slider-5d79cd7cf3e7a .timeline-post\").each(function(){
   if (jQuery(this).height() > maxHeight) { maxHeight = jQuery(this).height(); }
});
//jQuery(\"#ctl-h-slider-5d79cd7cf3e7a .timeline-post\").height(maxHeight);
jQuery(\"#ctl-h-slider-5d79cd7cf3e7a li\").height(maxHeight);
//jQuery(\"#ctl-h-slider-5d79cd7cf3e7a .li\").css('min-height', maxHeight);
}, 1000);


//jQuery('#ctl-h-slider-5d79cd7cf3e7a li').css(\"height\", maxHeight);
//alert(maxHeight);
    });


</script>";

    $prepend = '';


    return $return.$prepend;
}

?>