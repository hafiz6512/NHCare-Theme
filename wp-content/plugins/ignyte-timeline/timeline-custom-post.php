<?php

function wpb_change_title_text( $title ){
    $screen = get_current_screen();

    if  ( 'ignyte_timeline' == $screen->post_type ) {
        $title = 'Enter Timeline Date';
    }

    return $title;
}

add_filter( 'enter_title_here', 'wpb_change_title_text' );
function create_timeline_custom_post_type() {
    $labels = array(
        'name' => _x('History Timeline', 'post type general name'),
        'singular_name' => _x('History Timeline', 'post type singular name'),
        'add_new' => _x('Add New', 'History Timeline'),
        'add_new_item' => __('Add New History Timeline'),
        'edit_item' => __('Edit History Timeline'),
        'new_item' => __('New History Timeline'),
        'view_item' => __('View History Timeline'),
        'search_items' => __('Search History Timeline'),
        'not_found' =>  __('No History Timeline found'),
        'not_found_in_trash' => __('No History Timeline found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'History Timeline'
    );

    register_post_type( 'ignyte_timeline', array(
        'labels' => $labels,
        'capability_type' => 'page',
        'has_archive' => true,
        'hierarchical' => false,
        'query_var' => true,
        'public' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'rewrite' => array(
            'slug' => 'timeline',
            'with_front' => false
        ),
        'supports' => array(
            'title',
            //'thumbnail',
           // 'editor',
           // 'excerpt'
        ),
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'menu_position' => 6
    ));

}

add_action( 'init', 'create_timeline_custom_post_type', 0 );





add_filter( 'template_include', 'ignyte_timeline_template_check', 100 );
/**
 * Provide fall back template file for a custom post type single view.
 * @return void
 */
function ignyte_timeline_template_check( $template )
{
    // Our custom post type.
    $post_type = 'ignyte_resources';

    // WordPress has already found the correct template in the theme.
    if ( FALSE !== strpos( $template, "/templates/single-$post_type.php" ) ){
        // return the template in theme  
        return $template;
    }
    // Send our plugin file.
    if ( is_singular() && $post_type === get_post_type( $GLOBALS['post'] ) ){
        // return plugin file
        return dirname( __FILE__ ) . "/templates/single-$post_type.php";
    }
    // Not our post type single view.

    // Handle Archive
    // WordPress has already found the correct template in the theme.
    if ( FALSE !== strpos( $template, "/templates/archive-$post_type.php" ) ){
        // return the template in theme  
        return $template;
    }
    return $template;
}






/// DEFINE META BOX FOR LOCATIONS
if (is_admin())
    add_action('admin_menu', 'ignyte_timeline_history');

// This function tells WP to add a new "meta box"
function ignyte_timeline_history() {
    add_meta_box(
        'ignyte_timeline_content_id', // id of the <div> we'll add
        'Timeline Option', //title
        'ignyte_timeline_content', // callback function that will echo the box content
        'ignyte_timeline', // where to add the box: on "post", "page", or "link" page
        'normal',										// placement on add/edit page
        'high'												// priority on add/edit page
    );
}

// This function echoes the content of our meta box
function ignyte_timeline_content() {
    if($_GET['post']) {
        $custom_fields = get_post_custom($_GET['post']);
        foreach ( $custom_fields as $key => $value ) {
            $meta[$key] = $value[0];
        }
    }
    //var_dump($meta);
    echo '<input type="hidden" name="ignyte_timeline_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    ?>
    <style>
        .alltabcontent {
            border: 2px dashed rgba(114, 186, 94, 0.35);
            height: auto;
        }
        .sticky-tab {
            position: -webkit-sticky;
            position: sticky;
            top: 30px;
            z-index: 99999;
            background-color: gray;
            padding: 5px;
        }
        .mediaContent .fImg
        {
            background: gray !important;
            height: 100% !important;
            width: 100% !important;

        }
        .mediaContent .hndle
        {
            min-height: 150px;
        }
        .mainagenda
        {
            height: auto;
        }
        .area1
        {
            height: 100px !important;
        }
    </style>

    <script>
        jQuery(document).ready(function($)
        {

             jQuery("body").hasClass("meta-box-sortables")
             {
             jQuery('.meta-box-sortables1 ,.meta-box-sortables2 , .meta-box-sortables13').sortable({
             opacity: 0.6,
             revert: true,
             cursor: 'move',
             handle: '.hndle'
             });
             }


        });
    </script>
   <div class="alltabcontent">
       <div class="sticky-tab">
    <span id="bigImage2" class="button-primary content-casestudy" id="bigImage">Add Image </span>
    <span id="casstudiesvideo" class="button-primary content-casestudy" id="casstudiesvideo">Add Video </span>
    <span id="casestudy_textcontent" class="button-primary content-casestudy">Add Content </span>
    <span id="casestudy_2col_images" class="button-primary content-casestudy">Add Left Right Image</span>

       </div>

<div class="mainagenda" style="background:lightgrey; padding: 10px;margin-top: 10px ">
    <?php  // Start Daynamic Image Uploader with title and desc
    $data1=explode('~',$meta['ignyte_project_casestudies_content']); ?>
    <div class="frm_i imgupload-contain casestudySection ">
        <input type="hidden" class="modi" value="0" />
        <input type="hidden" class="chk_fld" value="<?php echo '1'; ?>" />
        <input type="hidden" class="title_i" value="<?php echo '1' ?>" />
        <div class="img-up-row meta-box-sortables1 ui-sortable">
            <?php
            $i_set=1;
            foreach($data1 as $d)
            {
                $dat2=explode('|',$d);
                //print_r($dat2); ?>
                <?php
                if($dat2[0]=="caseStudyBigImage") {
                    ?>
                    <div id="delk" class="frm_field img-upload-box casStudiesBox postbox" >
                        <div class="container hndle">
                            <div class="close1 dashicons dashicons-minus" id="casestudySection"></div>
                            <input type="hidden" value="caseStudyBigImage" name="casestudiesdata[]">
                            <p><input type="text"  name="casestudiesdata[]"  class=" tt " value="<?php echo esc_attr($dat2[1]); ?>" placeholder="<?php _e('Title');?>" /></p>
                            <div class="img-box fImgs">
                                <img class="fImg" src="<?php if(esc_attr($dat2[2]) !=1) echo esc_attr($dat2[2]); ?>"  />
                            </div>
                            <input type="hidden" id="i<?php echo $i_set; ?>" class="img1"  name="casestudiesdata[]" value="<?php echo esc_attr($dat2[2]); ?>" size="50" />
                            <p>
                                <textarea placeholder="<?php _e('Text Content');?>" name="casestudiesdata[]" class="area1" value="<?php echo esc_attr($dat2[3]); ?>"/><?php if(!empty($dat2[3])) echo esc_attr($dat2[3]); ?></textarea>
                            </p>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <?php }?>
                <?php
                if($dat2[0]=="casstudiesvideo") {
                    ?>
                    <div id="delk" class="frm_field img-upload-box casStudiesBox postbox" >
                        <div class="container hndle" style="padding-bottom:50px;">
                            <div class="close1 dashicons dashicons-minus" id="casestudySection"></div>
                            <input type="hidden" value="casstudiesvideo" name="casestudiesdata[]">

                            <p><input type="text"  name="casestudiesdata[]"  class=" tt " value="<?php echo esc_attr($dat2[1]); ?>" placeholder="<?php _e('Title');?>" /></p>
                            <div class="img-box fImgs">
                                <img class="fImg" src="<?php if(esc_attr($dat2[2]) !=1) echo esc_attr($dat2[2]); ?>"  />
                            </div>
                            <input type="hidden" id="i<?php echo $i_set; ?>" class="img1"  name="casestudiesdata[]" value="<?php echo esc_attr($dat2[2]); ?>" size="50" />

                           <p> <input type="text" value="<?php echo esc_attr($dat2[3]); ?>" name="casestudiesdata[]" style="width: 80%" placeholder="Mp4 Video Url"><br/>
                                <input type="text" value="<?php echo esc_attr($dat2[4]); ?>" name="casestudiesdata[]" style="width: 80%" placeholder="Ogv Video Url"><br/>
                                <input type="text" value="<?php echo esc_attr($dat2[5]); ?>" name="casestudiesdata[]" style="width: 80%" placeholder="Webm Video Url">

                            </p>
                            <p>
                                <textarea placeholder="<?php _e('Text Content');?>" name="casestudiesdata[]" class="area1" value="<?php echo esc_attr($dat2[5]); ?>"/><?php if(!empty($dat2[6])) echo esc_attr($dat2[6]); ?></textarea>
                            </p>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <?php }?>



                <?php
                if($dat2[0]=="casestudy_textcontent") {
                    ?>
                    <div id="delk" class="frm_field img-upload-box casStudiesBox postbox">
                        <div class="container hndle">
                            <div class="close1 dashicons dashicons-minus" id="casestudySection"></div>
                            <input type="hidden" value="casestudy_textcontent" name="casestudiesdata[]">

                            <p><input type="text"  name="casestudiesdata[]" id="t<?php echo $i_set; ?>" class=" tt txt<?php echo $i_set; ?>" value="<?php echo esc_attr($dat2[1]); ?>" placeholder="<?php _e('Title');?>" /></p>
                            <p>
                                <textarea placeholder="<?php _e('Text Content');?>" name="casestudiesdata[]" class="area1" value="<?php echo esc_attr($dat2[2]); ?>"/><?php if(!empty($dat2[2])) echo esc_attr($dat2[2]); ?></textarea>
                            </p>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <?php }?>
                <?php
                if($dat2[0]=="casestudy_2col_images") {
                    ?>
                    <div id="delk" class="frm_field img-upload-box casStudiesBox postbox" >
                        <div class="container hndle">
                            <div style="width: 49%;float: left; margin-right: 1%">
                                <div class="close1 dashicons dashicons-minus" id="casestudySection"></div>
                                <input type="hidden" value="casestudy_2col_images" name="casestudiesdata[]">
                                <div class="img-box fImgs">
                                    <img class="fImg" src="<?php if(esc_attr($dat2[1]) !=1) echo esc_attr($dat2[1]); ?>" />
                                </div>
                                <input type="hidden" id="i<?php echo $i_set; ?>" class="img1"  name="casestudiesdata[]" value="<?php echo esc_attr($dat2[1]); ?>" size="50" />
                                <p><input type="text"  name="casestudiesdata[]" id="t<?php echo $i_set; ?>" class=" tt txt<?php echo $i_set; ?>" value="<?php echo esc_attr($dat2[2]); ?>" placeholder="<?php _e('Left Image Caption Title');?>" /></p>
                                <p>
                                    <textarea placeholder="<?php _e('Image Caption Text');?>" name="casestudiesdata[]" class="area1" value="<?php echo esc_attr($dat2[3]); ?>"/><?php if(!empty($dat2[3])) echo esc_attr($dat2[3]); ?></textarea>
                                </p>
                            </div>

                            <div style="width: 49%;float: left; margin-left: 1%">
                                <div class="img-box fImgs2">
                                    <img class="fImg2" src="<?php if(esc_attr($dat2[4]) !=1) echo esc_attr($dat2[4]); ?>" />
                                </div>
                                <input type="hidden" id="i<?php echo $i_set; ?>" class="img12"  name="casestudiesdata[]" value="<?php echo esc_attr($dat2[4]); ?>" size="50" />
                                <p><input type="text"  name="casestudiesdata[]" id="t<?php echo $i_set; ?>" class=" tt txt<?php echo $i_set; ?>" value="<?php echo esc_attr($dat2[5]); ?>" placeholder="<?php _e('Left Image Caption Title');?>" /></p>
                                <p>
                                    <textarea placeholder="<?php _e('Image Caption Text');?>" name="casestudiesdata[]" class="area1" value="<?php echo esc_attr($dat2[6]); ?>"/><?php if(!empty($dat2[6])) echo esc_attr($dat2[6]); ?></textarea>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php }?>

                <?php $i_set++; } ?>
        </div>
        <input class="page_id" type="hidden" name="page_id" value="<?php// echo ($post->ID)+1000; ?>" id="page_id"/>
        <input type="hidden" name="total" value="<?php echo $i_set-1; ?>" class="field11"/>
    </div>

    <?php /*  <p><?php wp_editor(get_post_field('post_content', $_GET['post']), 'postcontent' ); ?></p>*/ ?>
</div>
   </div>

    <?php
}

// Hook things in, late enough so that add_meta_box() is defined
function ignyte_timeline_save_post_data($post_id){
    if ( !wp_verify_nonce( $_POST['ignyte_timeline_box_nonce'], basename( __FILE__ ) ) ) {
        return;
    }
    if ( !current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    $post_meta_array=array("ignyte_project_casestudies_content");
    foreach($post_meta_array as $post_this_meta) {
        $posts = get_posts(array(
            'post_id' => $post_id
        ));
        if($post_this_meta=='ignyte_project_casestudies_content')
        {
            $totalField='';
            $count=0;

            foreach($_POST['casestudiesdata'] as $imgDes)
            {    $icon='';
                //if($imgDes!='')
                //  {
                if($count>0){
                    if($imgDes=="caseStudyBigImage" or  $imgDes=="casestudy_textcontent"  or $imgDes=="casestudy_2col_images" or $imgDes=="casstudiesvideo") { $icon='~';
                    }
                    else	{ $icon='|'; }
                }

                $imgDesFinel=checkSpecielIcon($imgDes);
                $totalField .=$icon.$imgDesFinel;
                $count++;

                //}
            }
            update_post_meta($post_id,$post_this_meta,$totalField);
        }
        else
        {
            update_post_meta($post_id,$post_this_meta,$_POST[$post_this_meta]);
        }
    }


}
add_action( 'save_post', 'ignyte_timeline_save_post_data' );