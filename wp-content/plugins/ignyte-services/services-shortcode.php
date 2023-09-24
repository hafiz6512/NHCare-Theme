<?php

add_shortcode('service_list', 'ignyte_service_list_shortcode');

function ignyte_service_list_shortcode($atts)
{
    //var_Dump($atts);
    /* if using atts */
    $currentlang = get_bloginfo('language');
    $slug=pll_current_language('slug');
    extract(shortcode_atts(array(
        'number_posts' => '100',
        'order'        => 'ASC',
        'target'        => '',
        'orderby'      => 'post_date',
    ), $atts));
    $args = array(
        'posts_per_page' => $number_posts,
        //'orderby'         => $orderby,
        // 'order'		   => $order,
        'lang' => $slug,
        'post_type'      => 'ignyte_services',
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'location-model-checkbox',
                'compare' => 'NOT EXISTS' // doesn't work
            ),
            array(
                'key' => 'location-model-checkbox',
                 'value' => 'no',

            )
        ),
        'post_status'    => 'publish');
    $post = get_posts($args);
    $return = "";
    $i = 0;
    foreach ($post as $p) {

        $title = apply_filters('the_title', $p->post_title);
        $excerpt = apply_filters('the_excerpt', $p->post_excerpt);
        $meta_values = get_post_meta($p->ID);
        $fallback = $meta_values["ignyte-service-fallback-image"][0];
        //$svg[$i]=file_get_contents($thumbnail[0]);
       // $svg[$i]=file_get_contents($thumbnail);
        $thumbnail = get_the_post_thumbnail_url($p->ID, 'medium');
$return .='<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" onclick=" javascript:location.href=\'' . get_permalink($p->ID). '\'" >
                            <div class="service-grid" style="background-image:url('.$thumbnail.');">
                                <div class="content">
                                    <h5 class="green">'.$title.'</h5>
                                   '.$excerpt.'
                                    <div class="detail-btn">
                                        <a class="btn hidden-text-btn icon" href="' . get_permalink($p->ID) . '"><div class="hidden-text">VIEW MORE</div></a>
                                    </div>
                                </div>
                            </div>
                        </div>';


        $i++;
    }
    wp_reset_postdata();

    $return =' <div class="row">
                    <div class="col-md-offset-1 col-md-10 col-md-offset-1">
                    '.$return.'
                     </div>
                </div>';


    return $return ;
}


add_shortcode('service_slider', 'ignyte_service_slider_shortcode');

function ignyte_service_slider_shortcode($atts)
{
    //var_Dump($atts);
    /* if using atts */
    ob_start();
    $currentlang = get_bloginfo('language');
    $slug=pll_current_language('slug');
    extract(shortcode_atts(array(
        'number_posts' => '10',
        'order'        => 'ASC',
        'target'        => '',
        'orderby'      => 'post_date',
        'title'         =>'Find The Healthcare Services You Need',
        'all_button_label'=>'View All Services',
        'view_button_label'  =>'VIEW MORE',
        'next_button_label'  =>'NEXT',
        'prev_button_label' =>'PREVIOUS'
    ), $atts));


    $args = array(
        'posts_per_page' => $number_posts,
        //'orderby'         => $orderby,
        // 'order'		   => $order,
        'post_type'      => 'ignyte_services',
        'meta_key' => 'home-checkbox',
        'meta_value' => 'yes',
        'lang' => $slug,
        'post_status'    => 'publish');

    $post = get_posts($args);
    $return = "";
    $i = 0;
    foreach ($post as $p) {

        $title2 = apply_filters('the_title', $p->post_title);
        $excerpt = apply_filters('the_excerpt', $p->post_excerpt);
        $thumbnail =  wp_get_attachment_image_src( get_post_thumbnail_id($p->ID) );
        $thumbnail =  get_attached_file( get_post_thumbnail_id($p->ID) );
        //var_dump($thumbnail);
        //var_dump(file_get_contents($thumbnail[0]));
        $meta_values = get_post_meta($p->ID);

        $fallback = $meta_values["ignyte-service-fallback-image"][0];
        //$svg[$i]=file_get_contents($thumbnail[0]);
        $svg[$i]=file_get_contents($thumbnail);
        $thumbnail = get_the_post_thumbnail_url($p->ID, 'medium');

        $return .= '<li class="service-slider" style="background-image:url('.$thumbnail.');"><div class="content"><h4 class="green">'.$title2.'</h4>'.$excerpt.'<a class="btn hidden-text-btn arrow" href="' . get_permalink($p->ID) . '"><div class="hidden-text">'.$view_button_label.'</div></a></div></li>';



        $i++;
    }
    wp_reset_postdata();

    $allcontroller = '<div id="service-slider"><div class="container"><!--container start-->
                    <div class="row inner-padding"> <!--row start-->
                    <div class=" col-md-offset-1 col-sm-12 col-md-11 padding-0">
 <h2>'.$title.'</h2>
 </div>
</div><!--row close-->
</div>';

    $return = '   <div id="slider-wrapper-first" class="slider"  style="opacity:0">
     ' . $allcontroller . '
         <div class="container-fluid"><!--container start-->
                    <div class="row inner-padding service-slider"><!--row start-->
                    <div class="flexslider-service">
        <ul class="slides">
            ' . $return . '
        </ul>
    </div>
	<div class="container">
	<div class="row" >
		<div class="col-sm-12 col-md-offset-1 col-md-10">
			<div class="custom-navigation-services">
				<div class="flex-direction-nav">
					<div class="left-arrow"><a class="btn hidden-text-btn flex-prev chevron"><div class="hidden-text">'.$prev_button_label.'</div></a></div>
					<div class="right-arrow"><a class="btn hidden-text-btn flex-next chevron" ><div class="hidden-text">'.$next_button_label.'</div></a></div>
				</div>
			</div>
		</div>
		<div class="col-md-12 center absolute">
			<a href="/services/" class="btn">'.$all_button_label.'</a>
		</div>
	</div>
	</div>
    </div>
    </div>
</div>
</div>';
    $script = ' <script type="text/javascript">
    (function() {
        // store the slider in a local variable
        var mainwindow = jQuery(window),
            flexslider = { vars:{} };



        mainwindow.load(function() {
            jQuery(".flexslider-service").flexslider({
                animation: "slide",
                controlNav:false,
                directionNav: false,
                animationSpeed: 400,
                slideshow: false,
                // animationLoop: false,
                touch:true,
                move:1,
                itemWidth: 330,
                itemMargin: 1,
                minItems: 1, // use function to pull in initial value
                maxItems: 9,// use function to pull in initial value
                start: function (slider) {
                    jQuery("body").removeClass("loading");
                    jQuery("#slider-wrapper-first").css("opacity", "1");
                    flexslider = slider;
                    //jQuery("#slider-wrapper-first").css("opacity", "1");
                    window.addCurrentSlidesClass(slider);

                },
                after: function (slider) {
                    window.addCurrentSlidesClass(slider);
                    /* if (!slider.playing) {
                     slider.play();

                     }*/
                },
                 end : function(slider){
                jQuery(".flexslider-service .slides li").each(function(){
                     var bg_url = jQuery(this).css(\'background-image\');
                      bg_url = /^url\(([\'"]?)(.*)\1\)$/.exec(bg_url);
                      bg_url = bg_url ? bg_url[2] : ""; // If matched, retrieve url, otherwise ""
                    slider.addSlide(\'<li class="service-slider" style="background-image: url(\'+bg_url+\');">\'+jQuery(this).context.innerHTML+\'</li>\', slider.count);

                    jQuery(".flexslider-service .slides").append(\'<li class="service-slider" style="background-image: url(\'+bg_url+\');">\'+jQuery(this).context.innerHTML+\'</li>\');
                });
            }


            });
        });


        jQuery(".custom-navigation-services .flex-prev").on("click", function(){
            jQuery(".flexslider-service").flexslider("prev")
            return false;
        });

        jQuery(".custom-navigation-services .flex-next").on("click", function(){
            jQuery(".flexslider-service").flexslider("next")
            return false;
        });




        window.addCurrentSlidesClass = function (slider) {
            //debugger;
            jQuery(".flexslider-service li").removeClass("active-slides");
            var startli = (slider.move * (slider.currentSlide));
            var endli = (slider.move * (slider.currentSlide + 1));

            for (i = startli + 1; i < endli; i++) {
                if (jQuery(window).width() > 500 ) {
                    jQuery(".flexslider-service li:nth-child(" + i + ")").addClass("active-slides");
                }
            }
        }

    }()); </script>';

    return $return . $script;
}

function wpb_rand_posts($atts) {

    extract(shortcode_atts(array(
        'title' => 'Amazing patient experiences begin with amazing providers',
        'description' => 'Our patients know that every time they walk through our doors, they can expect quality treatment from professionals who care.',
        'link_label' => 'Find a Doctor',
        'link' => '/find-a-doctor/',
    ), $atts));

    $currentlang = get_bloginfo('language');
    $slug=pll_current_language('slug');

    $args = array(
        'post_type' => 'ignyte_provider',
        'meta_key' => 'show_service',
        'meta_value' => 'yes',
        'lang' => $slug,
        'orderby'   => 'rand',
        'posts_per_page' => 1,
    );
    $string='';
    $the_query = get_posts( $args );

    foreach ($the_query as $doc) {
        $docmeta = get_post_meta($doc->ID);

            $imgurl = get_the_post_thumbnail_url($doc->ID, 'medium');

            $string= '<div class="container content">

						<div class="col-sm-7 col-md-12 absolute-content">
							<div class="col-md-offset-1 col-md-5 col-sm-offset-1 col-sm-11 provider-left padding-0">
								<h1 class="page-heading white">'.$title.'</h1>
								<p class="large white">'.$description.'</p>
								<p><a href="'.$link.'" class="btn white">'.$link_label.'</a>
								</p>
							</div>
							<div class="col-md-offset-3 col-md-2 col-sm-offset-1 col-sm-11 provider-right padding-0">
								<h5 class="white">'.$docmeta['ignyte-provider-displayed-name'][0] .'</h5>
								<p class="white">Neighborhood Healthcare</p>';
				if ($docmeta['ignyte-provider-since'][0] <> "") {
					$string.= '		<p class="white">Provider since '.$docmeta['ignyte-provider-since'][0].'</p>';
				}
				$string.= '	</div>
							<div class="col-md-1"></div>
						</div>
						<div class="providers-image" style="background-image:url('.$docmeta['ignyte-provider-meta-image'][0].');"></div>
					</div>';
        }

        /* Restore original Post Data */
        wp_reset_postdata();

    return $string;
}

add_shortcode('random-doctor','wpb_rand_posts');