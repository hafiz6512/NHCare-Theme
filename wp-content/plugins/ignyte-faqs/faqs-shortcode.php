<?php
add_shortcode('all_faqs', 'ignyte_faqs_list_shortcode');

function ignyte_faqs_list_shortcode($atts)
{
    //var_Dump($atts);
    /* if using atts */
    extract(shortcode_atts(array(
        'orderby'      => 'post_date',
        'type' => '',
        'number_posts'=>'12'
    ), $atts));

    $status=true;
    global $wp;
    $pageurl= home_url( $wp->request );
    $tabbing='';
    $content='';

    $prevpage = 1;
    $defaultload = -1;
    $startloadjs=$number_posts;

    $currentLang = pll_current_language();
    $lslug=pll_current_language('slug');

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
                          'lang' => $lslug,
                          'posts_per_page' => $defaultload
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
                $content .= '<div id="' . $slug . '" class="tab-pane fade ' . $activeclasscont . ' loadingfaqs"  >
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
                <div class="col-md-10 col-xs-10 padding-0">
                    <h5>' . get_the_title() . '</h5>
                </div>
                <div class="col-md-1 col-xs-2 vh-center faq-btn" style="height:100%;">
                    <a href="javascript://"><i class="faq-plus border-red"></i></a></div>
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
                $content .= '<span class="paggertop"></span>';
                // if ($counter < $total_posts) {
                $display='block';
                if($total_posts==$startloadjs)
                {
                    $display='none';
                }
                $content .= '<input type="hidden" value="0" id="' . $slug . 'start"><input type="hidden" value="'.$total_posts.'" id="' . $slug . 'total">
        <div class="row page loadmore" data-parent="#' . $slug . '" style="display: '.$display.'">
            <div class="bottom-paginations">
                <p class="bottom-pagination">'.pll__('Showing').' ' .  $counter . ' '.pll__('of'). ' “' . $total_posts . ' '.pll__('Results'). '”.</p>
            </div>
            <div class="pagination-count center">
                <a class="btn hidden-text-btn icon red add-more load-more-provider" ><div class="hidden-text">SHOW MORE</div></a>
            </div>
        </div>';
                // }

                $content .= ' </div></div>';
            }
        }
    }

    $return ='  <div class="col-md-12"><ul class="nav nav-pills">'.$tabbing.' </ul></div>
<div class="col-md-12 padding-0 description">
    <div class="tab-content" id="allfaqdata">
        '.$content.'
    </div>
</div>
';
    $script="<style>
    .question {
        display:none;
    }
</style><script>
    jQuery(function () {
        var startfrom=".$startloadjs.";
        var increase=$startloadjs;
        // jQuery(\".job\").slice(0, startfrom).show();

        function loadmoredata(increase,parentid)
        {
            startfrom=jQuery(parentid+'start').val();
            taotalrac=jQuery(parentid+'total').val();
            jQuery(parentid+' .question:hidden').slice(0, increase).slideDown();
            if (jQuery(parentid+' .question:hidden').length == 0) {

                jQuery(parentid+' .loadmore').fadeOut('slow');
            }

            // taotalrac=startfrom+jQuery('#'+parentid+' .question:hidden').length;
            startfrom=parseInt(startfrom)+parseInt(increase);
            htmlString='<div class=\"bottom-paginations\"><p class=\"bottom-pagination\">".pll__('Showing')." '+startfrom+' ".pll__('of')."  “'+taotalrac+' ".pll__('Results')."”.</p></div>'+
        '<div class=\"pagination-count center\">'+
        '<a class=\"btn hidden-text-btn icon red add-more load-more-provider\" ><div class=\"hidden-text\">".pll__('Show More')."</div></a>'+
        '</div>';
            jQuery(parentid+' .loadmore').html (htmlString);
            jQuery(parentid+'start').val(startfrom);
            //jQuery(parentid+'total').val(taotalrac);
        }


        jQuery(\".loadingfaqs\").each(function(){
        //console.log($(this).text());
        pId=jQuery(this).attr('id')
        loadmoredata(increase,'#'+pId);

    });


    jQuery(\".loadmore\").on('click', function (e) {

    var parentdata=jQuery(this).attr('data-parent');
    //alert(parentdata);
    e.preventDefault();
    loadmoredata(increase,parentdata);
    });


    });


    jQuery(function(){
        var hash = window.location.hash;
        hash && jQuery('ul.nav.nav-pills a[href=\"' + hash + '\"]').tab('show');
        jQuery('ul.nav.nav-pills a').click(function (e) {
            //var scrollmem = jQuery('body').scrollTop();
            jQuery(this).tab('show');
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
    if($_GET['pp'])
    {
        $script .='<script>jQuery(document).ready(function () {
    // Handler for .ready() called.
    jQuery(\'html, body\').animate({
    scrollTop: jQuery(".paggertop").offset().top-300
}, 1000);
}); </script>';
    }

    return $return.$script;
}


add_shortcode('faqs', 'ignyte_faqs_shortcode');

function ignyte_faqs_shortcode($atts)
{
    //var_Dump($atts);
    /* if using atts */
    extract(shortcode_atts(array(
        'number_posts' => '12',
        'orderby'      => 'post_date',
        'type' => '',
        'label'=>''
    ), $atts));

    $status=true;
    global $wp;
    $pageurl= home_url( $wp->request );
    $tabbing='';
    $content='';
    $startloadjs=$number_posts;

    $firstload = -1;


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
        if($label!='')
        {
            $tearmLabel=$label;
        }
        $content .='<div class="col-md-offset-3 col-md-8 openings"><h2 class="col-md-12 col-xs-12 red">'.$tearmLabel.'</h2>
    <div class="col-md-12 col-xs-12 content padding-0">';
        $counter=0;
        while($loop->have_posts()) : $loop->the_post();
            $id=get_the_ID();
            // $docmeta = get_post_meta($id);
            $url = wp_get_attachment_url(get_post_thumbnail_id($id));
            //echo '<a href="'.get_permalink().'">'.get_the_title().'</a><br>';
            $content .='     <div class="job">
            <div data-toggle="collapse" data-target="#faq'.$id.$slug.'" id="faq'.$id.$slug.'p" class="career-list volunteer-list vh-center">
                <div class="col-md-11 col-xs-10 padding-0">
                    <h5>'.get_the_title().'</h5>
                </div>
                <div class="col-md-1 col-xs-2 vh-center faq-btn" style="height:100%;">
                    <a href="javascript://"><i class="faq-plus border-red white vh-center"></i></a></div>
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


        //  echo $counter.'=='.$total_posts.'<br/>'; <span class="paggertop"></span>
        $content .= '<span class="paggertop"></span>';
        //if ($counter < $total_posts) {
        $content .= ' <div class="row page loadmore">
            <div class="bottom-paginations">
                <p class="bottom-pagination">'.pll__('Showing').' '. $startloadjs . ' '.pll__('of'). ' “' . $total_posts . ' '.pll__('Results'). '”.</p>

            </div>
            <div class="pagination-count center">
                <a class="btn hidden-text-btn icon red add-more load-more-provider" ><div class="hidden-text">'.pll__('Show More').'</div></a>
            </div>
        </div>';
        // }

        $content .=' </div></div>';
    }
    // }

    $return =' <div class="container">
    <div class="row"> '.$content.'</div></div> ';
    $script="<style>
    .job {
        display:none;
    }
</style><script>
    jQuery(function () {
        var startfrom=".$startloadjs.";
        var increase=$startloadjs;
        // jQuery(\".job\").slice(0, startfrom).show();

        function loadmoredata(startfromvar,increase)
        {
            jQuery(\".job:hidden\").slice(0, increase).slideDown();
            if (jQuery(\".job:hidden\").length == 0) {
            jQuery(\".loadmore\").fadeOut('slow');
        }
        taotalrac=startfromvar+jQuery(\".job:hidden\").length;
        // startfrom=startfrom+increase;
        htmlString='<div class=\"bottom-paginations\"><p class=\"bottom-pagination\">".pll__('Showing')." '+startfromvar+' ".pll__('of')."  “'+taotalrac+' ".pll__('Results')."”.</p></div>'+
        '<div class=\"pagination-count center\">'+
        '<a class=\"btn hidden-text-btn icon red add-more load-more-provider\" ><div class=\"hidden-text\">".pll__('Show More')."</div></a>'+
        '</div>';
        jQuery('.loadmore').html (htmlString);
    }

    loadmoredata(startfrom,increase);


    jQuery(\".loadmore\").on('click', function (e) {
    startfrom=parseInt(startfrom)+parseInt(increase);
    //alert(startfrom+'=='+increase)
    e.preventDefault();
    loadmoredata(startfrom,increase);
    });

    });
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
    if($_GET['pp'])
    {
        $script .='<script>jQuery(document).ready(function () {
    // Handler for .ready() called.
    jQuery(\'html, body\').animate({
    scrollTop: jQuery(".paggertop").offset().top-300
}, 1000);
}); </script>';
    }


    return $return.$script;
}
