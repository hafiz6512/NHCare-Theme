<?php

add_shortcode('all_faqs', 'ignyte_faqs_list_shortcode');

function ignyte_faqs_list_shortcode($atts)
{
    //var_Dump($atts);
    /* if using atts */
    extract(shortcode_atts(array(
        'number_posts' => '2',
        'orderby'      => 'post_date',
        'type' => ''
    ), $atts));

    $status=true;
    global $wp;
    $pageurl= home_url( $wp->request );
    $tabbing='';
    $content='';

    $prevpage = 1;
    $defaultload = $number_posts;
    $firstload = $defaultload * $prevpage;
    if ($_GET['pp']) {

        $firstload = $defaultload * $_GET['pp'];
        $prevpage = $_GET['pp'];
    }
    $nextpage = $prevpage + 1;



    $custom_terms = get_terms('ignyte_faq_type');
    //print_r($custom_terms);
    foreach($custom_terms as $custom_term) {
        $term_meta = get_tax_meta($custom_term->term_id, 'showfrontend');
        wp_reset_query();
        if ($term_meta == 'on') {
            $args = array('post_type'      => 'ignyte_faqs',
                          'tax_query'      => array(
                              array(
                                  'taxonomy' => 'ignyte_faq_type',
                                  'field'    => 'slug',
                                  'terms'    => $custom_term->slug,
                              )
                          ),
                          'posts_per_page' => $firstload
            );

        $total_posts = $custom_term->count;
        $activeclass = "";
        $activeclasscont = '';
        $loop = new WP_Query($args);
        //$totalres = $loop->found_posts;
        if ($loop->have_posts()) {
            $slug = $custom_term->slug;
            if ($status) {
                $activeclass = 'active';
                $activeclasscont = 'in active';
                $status = false;
            }
            $tabbing .= '<li class="' . $activeclass . '"><a data-toggle="pill" href="#' . $slug . '">' . $custom_term->name . '</a></li>';
            $content .= '<div id="' . $slug . '" class="tab-pane fade ' . $activeclasscont . '">
                        <div class="col-md-1"></div>
                        <div class="col-md-11">';
            $counter = 0;
            while ($loop->have_posts()) : $loop->the_post();
                $id = get_the_ID();
                // $docmeta = get_post_meta($id);
                $url = wp_get_attachment_url(get_post_thumbnail_id($id));
                //echo '<a href="'.get_permalink().'">'.get_the_title().'</a><br>';
                $content .= '     <div class="question">
                                <div data-toggle="collapse" data-target="#faq' . $id . $slug . '" id="faq' . $id . $slug . 'p" class="career-list volunteer-list vh-center">
                                    <div class="col-md-10 padding-0">
                                        <h5>' . get_the_title() . '</h5>
                                    </div>
                                    <div class="col-md-1 vh-center" style="height:100%;">
                                        <a href="javascript://"><i class="fa fa-plus border-red vh-center"></i></a></div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div id="faq' . $id . $slug . '" class="collapse">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div id="job-description">
                                                <div class="row margin-0">
                                                 ' . get_the_content() . '
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                    </div>
                                </div>
                            </div>';
                $counter++;
            endwhile;


            //  echo $counter.'=='.$total_posts.'<br/>';
            if ($counter < $total_posts) {
                $content .= ' <div class="row page">
                    <div class="bottom-paginations">
                        <p class="bottom-pagination">Showing ' . $counter . ' of “' . $total_posts . ' Results”.</p>

                    </div>
                    <div class="pagination-count center">
						<a class="btn hidden-text-btn icon red add-more load-more-provider" href="' . $pageurl . '?pp=' . $nextpage . '/#' . $slug . '"><div class="hidden-text">SHOW MORE</div><i class="fa fa-arrow-right"></i></a>
					</div>
                </div>';
            }

            $content .= ' </div></div>';
        }
    }
    }

    $return ='  <div class="col-md-12"><ul class="nav nav-pills">'.$tabbing.' </ul></div>
             <div class="col-md-12 padding-0 description">
                <div class="tab-content">
                '.$content.'
                </div>
                </div>
            ';
$script="<script> 
jQuery(function(){
  var hash = window.location.hash;
  hash && jQuery('ul.nav.nav-pills a[href=\"' + hash + '\"]').tab('show'); 
  jQuery('ul.nav.nav-pills a').click(function (e) {
     jQuery(this).tab('show');
     //var scrollmem = jQuery('body').scrollTop();
     window.location.hash = this.hash;
  });
  
  
  jQuery('.career-list').click(function (e) {
     var thisId=jQuery(this).attr('data-target');
         setTimeout(function(){ 
           if(jQuery(thisId).hasClass('in'))
         {
            jQuery(thisId+'p').addClass('active');
            //alert('active');
         }
         else
             {
                 jQuery(thisId+'p').removeClass('active');
                 //alert('remove');
             }
              }, 400);
         
  });
    
});
</script>";

    return $return.$script;
}


add_shortcode('faqs', 'ignyte_faqs_shortcode');

function ignyte_faqs_shortcode($atts)
{
    //var_Dump($atts);
    /* if using atts */
    extract(shortcode_atts(array(
        'number_posts' => '5',
        'orderby'      => 'post_date',
        'type' => '',
        'Label'=>''
    ), $atts));

    $status=true;
    global $wp;
    $pageurl= home_url( $wp->request );
    $tabbing='';
    $content='';

    $prevpage = 1;
    $defaultload = $number_posts;
    $firstload = $defaultload * $prevpage;
    if ($_GET['pp']) {

        $firstload = $defaultload * $_GET['pp'];
        $prevpage = $_GET['pp'];
    }
    $nextpage = $prevpage + 1;

    $custom_term = get_term_by('slug',$type,'ignyte_faq_type');
    //print_r($custom_terms);
   // foreach($custom_terms as $custom_term) {
        wp_reset_query();
        $args = array('post_type' => 'ignyte_faqs',
                      'tax_query' => array(
                          array(
                              'taxonomy' => 'ignyte_faq_type',
                              'field' => 'slug',
                              'terms' => $custom_term->slug,
                          )
                      ),
                      'posts_per_page' => $firstload
        );

        $total_posts=$custom_term->count;
        $activeclass="";
        $activeclasscont='';
        $loop = new WP_Query($args);
        //$totalres = $loop->found_posts;
        if($loop->have_posts()) {
            $slug=$custom_term->slug;
            if($status)
            {
                $activeclass='active';
                $activeclasscont='in active';
                $status=false;
            }
            $tearmLabel=$custom_term->name;
            if($Label!='')
            {
                $tearmLabel=$Label;
            }
            $content .='<div class="col-md-offset-3 col-md-7 openings"><h2 class="red">'.$tearmLabel.'</h2>
                         <div class="col-md-12 content padding-0">';
            $counter=0;
            while($loop->have_posts()) : $loop->the_post();
                $id=get_the_ID();
                // $docmeta = get_post_meta($id);
                $url = wp_get_attachment_url(get_post_thumbnail_id($id));
                //echo '<a href="'.get_permalink().'">'.get_the_title().'</a><br>';
                $content .='     <div class="job">
                                <div data-toggle="collapse" data-target="#faq'.$id.$slug.'" id="faq'.$id.$slug.'p" class="career-list volunteer-list vh-center">
                                    <div class="col-md-10 padding-0">
                                        <h5>'.get_the_title().'</h5>
                                    </div>
                                    <div class="col-md-1 vh-center" style="height:100%;">
                                        <a href="javascript://"><i class="fa fa-plus border-red white vh-center"></i></a></div>
                                    <div class="col-md-1"></div>
                                </div>

                                <div id="faq'.$id.$slug.'" class="collapse">
                                    <div class="row">
                                        <div class="col-md-11">
                                            <div id="job-description">
                                                <div class="row margin-0">
                                                 '.get_the_content().'
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                        </div>
                                    </div>
                                </div>
                            </div>';
                $counter++;
            endwhile;


            //  echo $counter.'=='.$total_posts.'<br/>';
            if ($counter < $total_posts) {
                $content .= ' <div class="row page">
                    <div class="bottom-paginations">
                        <p class="bottom-pagination">Showing ' . $counter . ' of “' . $total_posts . ' Results”.</p>

                    </div>
                    <div class="pagination-count center">
						<a class="btn hidden-text-btn icon red add-more load-more-provider" href="'.$pageurl.'?pp='. $nextpage .'"><div class="hidden-text">SHOW MORE</div><i class="fa fa-arrow-right"></i></a>
					</div>
                </div>';
            }

            $content .=' </div></div>';
        }
   // }

    $return =' <div class="container">
            <div class="row"> '.$content.'</div></div> ';
    $script="<script> 
jQuery(function(){  
  jQuery('.career-list').click(function (e) {
     var thisId=jQuery(this).attr('data-target');
         setTimeout(function(){ 
           if(jQuery(thisId).hasClass('in'))
         {
            jQuery(thisId+'p').addClass('active');
            //alert('active');
         }
         else
             {
                 jQuery(thisId+'p').removeClass('active');
                 //alert('remove');
             }
              }, 400);
         
  });
    
});
</script>";

    return $return.$script;
}