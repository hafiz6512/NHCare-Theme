<?php /** Slider Shortcode */
add_shortcode('ignyte_slider', 'ignyte_slider_shortcode');
function ignyte_slider_shortcode($atts, $content = null) {
	
	extract( shortcode_atts( array(
		'id' =>'',
		'subnav_title' =>'',
	), $atts ) );
	$currentlang = get_bloginfo('language');
    // query
	/* BEGIN 20131226, added taxonomy query to the slider to be able to have different sliders for the site */ 
	$page_meta_info=get_post_meta( get_the_ID() ); 
	$slider_category=$page_meta_info["ignyte_slider_category"];
	$template_file = $page_meta_info["_wp_page_template"];
	/* END 20131226*/ 
	$display=true;
	ob_start();
	if ($slider_category[0]!="")
		switch($slider_category[0]){
			case "no_slider":
				$display=false;
			break;
			case "pages":
				echo "//TODO, need to output page images and captions";
			break;
			
			case "Testimonials":
			
				$args = array(
					'post_type'        => 'ignyte_testimonials',
					'posts_per_page'   => -1,
					'post_status'      => 'publish',
					'orderby'          => 'post_date',
					'lang'			 => substr($currentlang,0,2),
					'order'            => 'ASC'
					);
			
			
			break;
			
			default:
				$args = array(
					'post_type'        => 'slideritems',
					'posts_per_page'   => -1,
					'post_status'      => 'publish',
					'orderby'          => 'post_date',
					'lang'			 => substr($currentlang,0,2),
					/* BEGIN 20131226, added taxonomy query to the slider to be able to have different sliders for the site */ 
					'tax_query' 		=> array(array('taxonomy'=>'slider_group',
														'field'=>'slug',
														'terms'=>$slider_category[0]
														)), /* END 20131226*/
					'order'            => 'ASC'
					);
		}
	else
		$args = array(
			'post_type'        => 'slideritems',
			'posts_per_page'   => -1,
			'post_status'      => 'publish',
			'orderby'          => 'title', 
			'order'            => 'ASC'
			);
	$slides = get_posts($args);
	$extra_imgclass="";
	if ($slider_category[0]=="Testimonials"){
		//$extra_imgclass="l-half-bg";
	}
	?>
    <? if ($id<>"" && $subnav_title<>""){ ?>
        <div id="subnav_<?=$id?>"  class="Ignyte_subNavItem"> <!-- A 'color' class will be added, based on color value, blue placeholder -->
            <div class='menutitle' style='display:none;'><?=$subnav_title?></div>
    <? } else { ?>
        <div > <!-- A 'color' class will be added, based on color value, blue placeholder -->
    <? } ?>
    <div id="slider-wrapper" class="slider">
		<div class="flexslider">
			<ul class="slides">
			<?php foreach( $slides as $k => $slide ) {
				
				
				if ($slider_category[0]=="Testimonials"){
					$caption = get_post_meta($slide->ID, 'ignyte_testimonial_right_content', true);
					$slide_title = get_post_meta($slide->ID, 'ignyte_testimonial_name_content', true);
				}else{
					$caption= $slide->post_content;
					$slide_title		= $slide->post_title;	
				}
				
				$url                = get_post_meta($slide->ID, 'slider_url', true);
				$url_link                = get_post_meta($slide->ID, 'ignyte_testimonial_url_link', true);
				$url_text                = get_post_meta($slide->ID, 'ignyte_testimonial_text_link', true);
				$sl_image_url       = wp_get_attachment_image_src( get_post_thumbnail_id($slide->ID), 'slider-post-thumbnail');
				$sl_small_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($slide->ID), 'slider-thumb');
				?>
				<li class="slide-img <?=$extra_imgclass?>" style="background-image:url(<?=$sl_image_url[0]?>);">
				  <div class="container">
                      <div class="row">
                          <div class="col-xs-12 visible-xs-block slide-mob-img" style="background-image:url(<?=$sl_image_url[0]?>);"></div>
                          <div class="col-xs-12 col-sm-6 col-sm-offset-6 slider-content gradient">
                              <div class="slide-table">
                                <!--<img src="<?//=$sl_image_url[0]?>" />-->
                                <? if ($caption) { ?>
                                    <div class="caption table-cell">
                                    	
                                        <? if ($slider_category[0]=="Testimonials"){ ?>
                                         	<p><?php echo stripslashes(htmlspecialchars_decode($caption)); ?></p>
                                            <p><strong>-<?=$slide_title?></strong></p>
                                            <?	if($url_text<>""){ ?>
												<a class="btn btn-blue" href="<?=$url_link?>"><?=$url_text?></a>
											<? } ?>
                                        <? }else{ ?>
                                        	<h2 class="alpha"><?=$slide_title?></h2>
                                         	<?php echo stripslashes(htmlspecialchars_decode($caption)); ?>
                                        <? } ?> 
                                    </div>
                                <?php } ?>
                              </div><!-- slide-table -->
                          </div>
                      </div><!-- row -->
				  </div><!-- container -->
				</li>
			<?php  }
			wp_reset_postdata();
			?>
			</ul>
            
            <!-- Scroll down arrow -->
            <!-- <div class="scroll-down"><div class="scroll-arrow"></div></div> -->
		</div><!-- .flexslider -->
		<script type="text/javascript">
           //jQuery(window).load(function(){ //they want the slider to start even when the images are not yet loaded
			jQuery(document).ready(function(){ 
              jQuery('.flexslider').flexslider({
                animation: "slide",
                useCSS: false,
                controlNav: true,
                directionNav: false,
                start: function(slider){
                  jQuery('body').removeClass('loading');
                }
              });
            });
        </script>
    </div><!-- .slider -->
    </div>
    
<?
	$slider = ob_get_contents();
	ob_end_clean();
	if ($display)
		return $slider;
} /** END ignyte_slider shortcode */
?>