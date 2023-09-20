<?php

// error_reporting(0);
// add_filter("gform_confirmation_anchor", create_function("","return false;"));

add_filter("gform_confirmation_anchor", function() {
    return false;
});



function add_noscript_tag($tag){
    $noScript = <<<END
<noscript>
This functionality is implemented using Javascript. It cannot work without it, etc...
</noscript>
END;

    return str_replace('</script>', '</script>'.$noScript, $tag);
}

// Hook it into WP
add_filter('script_loader_tag', 'add_noscript_tag');

// Clean up AUTOMATIC ps and brs from shortcode
add_filter('the_content', 'shortcode_empty_paragraph_fix');
function shortcode_empty_paragraph_fix($content)
{
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );
    $content = strtr($content, $array);
    return $content;
}

function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
    echo '<style type="text/css">
	  .attachment-266x266, .thumbnail img {
		   width: 100% !important;
		   height: auto !important;
	  }
	  </style>';
}
add_action('admin_head', 'fix_svg');

// Add support for featured images

add_theme_support( 'post-thumbnails' );
add_post_type_support( 'page', 'excerpt' );
add_theme_support( 'menus');
add_filter('widget_text', 'do_shortcode');


//Register custom posts

include_once("includes/custom_post_types.php");

//Include extra functions

include_once("includes/extra-functions.php");

//Register Shortcodes:

foreach (glob(get_template_directory()."/includes/shortcodes/*.php") as $filename){

    include_once($filename);

}


//Register classes:

foreach (glob(get_template_directory()."/includes/classes/*.php") as $filename){

    include_once($filename);

}

function ignyte_register_scripts(){

    // Register scripts
    wp_register_script( 'bootstrap-script', get_template_directory_uri() . '/includes/bootstrap/js/bootstrap-updated.js', array( 'jquery' ) );
    wp_register_script( 'flexslider-script', get_template_directory_uri() . '/includes/flexslider/jquery.flexslider.js', array( 'jquery' ) );
    wp_register_script( 'mmenu-script', get_template_directory_uri() . '/includes/mmenu/jquery.mmenu.min.js', array( 'jquery' ) );
    wp_register_script( 'mmenu-searchfield-script', get_template_directory_uri() . '/includes/mmenu/jquery.mmenu.searchfield.min.js', array( 'jquery' ) );
    wp_register_script( 'isinviewport-script', get_template_directory_uri() . '/includes/js/isInViewport.min.js', array( 'jquery' ) );
    wp_register_script( 'main-scripts', get_template_directory_uri() . '/includes/main-scripts.js', array( 'jquery' ) );
    wp_register_script( 'isotope', get_template_directory_uri() . '/includes/isotope.pkgd.min.js', array( 'jquery' ) );
    wp_register_script( 'jquery.mousewheel', get_template_directory_uri() . '/includes/js/jquery.mousewheel.min.js', array( 'jquery' ) );
    wp_register_script( 'custom-scrollbar', get_template_directory_uri() . '/includes/js/jquery.mCustomScrollbar.js', array( 'jquery' ) );
    // Enqueue CSS
    wp_enqueue_style( 'bootstrap-css', get_template_directory_uri() . '/includes/bootstrap/css/bootstrap.min.css');
    wp_enqueue_style( 'flexslider-css', get_template_directory_uri() . '/includes/flexslider/flexslider.css');
    wp_enqueue_style( 'jquery-mmenu-css', get_template_directory_uri() . '/includes/mmenu/jquery.mmenu.min.css');
    wp_enqueue_style( 'jquery-mmenu-searchfield-css', get_template_directory_uri() . '/includes/mmenu/jquery.mmenu.searchfield.css');
    wp_enqueue_style( 'jquery-mmenu-positioning-css', get_template_directory_uri() . '/includes/mmenu/jquery.mmenu.positioning.css');
    wp_enqueue_style( 'jquery-mCustomScrollbar', get_template_directory_uri() . '/includes/jquery.mCustomScrollbar.css');
    wp_enqueue_style( 'mmenu-css', get_template_directory_uri() . '/includes/mmenu/nav.css');
    wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style( 'custom-style', get_template_directory_uri() . '/custom-style.css', '', current_time( 'timestamp' ));

    //  enqueue scripts:

    wp_enqueue_script( 'bootstrap-script' );
    wp_enqueue_script( 'flexslider-script' );
    wp_enqueue_script( 'mmenu-script' );
    wp_enqueue_script( 'mmenu-searchfield-script' );
    wp_enqueue_script( 'isinviewport-script' );
    wp_enqueue_script( 'main-scripts' );
    wp_enqueue_script( 'isotope' );
    wp_enqueue_script( 'jquery.mousewheel' );
    wp_enqueue_script( 'custom-scrollbar' );

}

add_action( 'wp_enqueue_scripts', 'ignyte_register_scripts' );

// Register Sidebars

if ( function_exists('register_sidebar') ){


    register_sidebar(array(
        'name'          => __( 'Quicklinks (Footer)', 'ignyte' ),
        'id'			=> 'quicklink_footer',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name'          => __( 'Call for Appointments (Desktop)', 'ignyte' ),
        'id'			=> 'desktop_phone',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name'          => __( 'Phone Number (Mobile) ', 'ignyte' ),
        'id'			=> 'mobile_phone',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(

        'name'          => __( 'Patient Feedback (Footer)', 'ignyte' ),

        'id'			=> 'contact_detail_1',

        'before_widget' => '',

        'after_widget' => '',

        'before_title' => '<h3>',

        'after_title' => '</h3>',

    ));
    register_sidebar(array(

        'name'          => __( 'Careers (Footer)', 'ignyte' ),

        'id'			=> 'contact_detail_2',

        'before_widget' => '',

        'after_widget' => '',

        'before_title' => '<h3>',

        'after_title' => '</h3>',

    ));
    register_sidebar(array(

        'name'          => __( 'Donate Now (Footer)', 'ignyte' ),

        'id'			=> 'contact_detail_3',

        'before_widget' => '',

        'after_widget' => '',

        'before_title' => '<h3>',

        'after_title' => '</h3>',

    ));

    register_sidebar(array(
        'name'          => __( 'Make an Appointment (Footer)', 'ignyte' ),
        'id'			=> 'footer-top-right',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __( 'Stay Connected (Footer)', 'ignyte' ),
        'id'			=> 'footer-newsletter-social',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __( 'Services CTA', 'ignyte' ),
        'id'			=> 'service_cta',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));


    register_sidebar(array(
        'name'          => __( 'Sidebar (News Details Pages)', 'ignyte' ),
        'id'			=> 'articles-top-box',
        //'before_widget' => '<div class="sb-header">',
        //'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __( 'Copyright (Footer)', 'ignyte' ),
        'id'			=> 'copyright_footer',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name'          => __( 'Employee Portal Link (Footer)', 'ignyte' ),
        'id'			=> 'employee_portal_footer',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));


}



// Register Menus

function ignyte_register_menus() {
    register_nav_menus(
        array(
            'top-nav' => __( 'Top Nav Menu' ),
            //'logged-top-nav' => __( 'Logged In Top Nav Menu' ),
            'main-nav' => __( 'Main Navigation' ),
            //'logged-main-nav' => __( 'Logged In Main Navigation' )
            'footer-nav' => __( 'Footer Navigation' ),
        )
    );
}
add_action( 'init', 'ignyte_register_menus' );
/*
	Example to add a button to the wordpress tinymce


function add_ignyte_button() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_ignyte_shortcodes');
     add_filter('mce_buttons', 'register_ignyte_button');
   }
}
function add_ignyte_shortcodes($plugin_array) {
   $plugin_array['thisplugin'] = get_bloginfo('template_url').'/includes/js/thisplugin.js';
   return $plugin_array;
}
function register_ignyte_button($buttons) {
   array_push($buttons, "thisplugin");
   return $buttons;
}

add_action('init', 'add_ignyte_button');

*/
if ( current_user_can( 'manage_options' ) ) {
    show_admin_bar( true );
}


function custom_posts_per_page($query) {
    if (is_category()) {
        $query->set('posts_per_page', -1);
    }
} //function

//this adds the function above to the 'pre_get_posts' action
add_action('pre_get_posts', 'custom_posts_per_page');


function sm_custom_meta() {
    add_meta_box( 'sm_meta', __( ' Posts Option', 'sm-textdomain' ), 'sm_meta_callback', 'post' );
}
function sm_meta_callback( $post ) {
    if($_GET['post']) {
        $custom_fields = get_post_custom($_GET['post']);
        foreach ( $custom_fields as $key => $value ) {
            $meta[$key] = $value[0];
        }
    }

    //$featured = get_post_meta( $post->ID );
    ?>

    <p>
    <div class="sm-row-content">
        <label for="meta-checkbox">
            <input type="checkbox" name="meta-checkbox" id="meta-checkbox" value="yes" <?php if ( isset ( $custom_fields['meta-checkbox'] ) ) checked( $custom_fields['meta-checkbox'][0], 'yes' ); ?> />
            <?php _e( 'Featured Post', 'sm-textdomain' )?>
        </label>
        <br/>
        <label for="meta-checkbox">
            <input type="checkbox" name="home-checkbox" id="home-checkbox" value="yes" <?php if ( isset ( $custom_fields['home-checkbox'] ) ) checked( $custom_fields['home-checkbox'][0], 'yes' ); ?> />
            <?php _e( 'Show on Home page News slider', 'sm-textdomain' )?>
        </label>

        <br/>
        <label for="meta-checkbox">
            <input type="checkbox" name="newsbanner-checkbox" id="newsbanner-checkbox" value="yes" <?php if ( isset ( $custom_fields['newsbanner-checkbox'] ) ) checked( $custom_fields['newsbanner-checkbox'][0], 'yes' ); ?> />
            <?php _e( 'Featured Hero Post on News page ', 'sm-textdomain' )?>
        </label>

        <br/>
        <br/>
        <label for="meta-checkbox">
            <input type="checkbox" name="video-checkbox" id="video-checkbox" value="yes" <?php if ( isset ( $custom_fields['video-checkbox'] ) ) checked( $custom_fields['video-checkbox'][0], 'yes' ); ?> />
            <?php _e( 'Video As Image', 'sm-textdomain' )?>
        </label>
        <br/>
        <label for="meta-checkbox">
            <?php _e( 'Video/mp4', 'sm-textdomain' )?>
        </label>
        <br/>
        <input type="text" value="<?php if ( isset ( $custom_fields['postmp4'] ) ) echo $custom_fields['postmp4'][0]; ?>" name="postmp4" style="width: 60%">
        <br/>
        <label for="meta-checkbox">
            <?php _e( 'Video/Ogv', 'sm-textdomain' )?>
        </label>
        <br/>
        <input type="text" value="<?php if ( isset ( $custom_fields['postogv'] ) ) echo $custom_fields['postogv'][0]; ?>" name="postogv" style="width: 60%">
        <br/>
        <label for="meta-checkbox">
            <?php _e( 'Video/Webm', 'sm-textdomain' )?>
        </label>
        <br/>
        <input type="text" value="<?php if ( isset ( $custom_fields['postwebm'] ) ) echo $custom_fields['postwebm'][0]; ?>" name="postwebm" style="width: 60%">

    </div>
    </p>

    <?php
}
add_action( 'add_meta_boxes', 'sm_custom_meta' );


/**
 * Saves the custom meta input
 */
function sm_meta_save( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'sm_nonce' ] ) && wp_verify_nonce( $_POST[ 'sm_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Checks for input and saves
    if( isset( $_POST[ 'meta-checkbox' ] ) ) {
        update_post_meta( $post_id, 'meta-checkbox', 'yes' );
    } else {
        update_post_meta( $post_id, 'meta-checkbox', '' );
    }
    if( isset( $_POST[ 'home-checkbox' ] ) ) {
        update_post_meta( $post_id, 'home-checkbox', 'yes' );
    } else {
        update_post_meta( $post_id, 'home-checkbox', '' );
    }
    if( isset( $_POST[ 'newsbanner-checkbox' ] ) ) {
        update_post_meta( $post_id, 'newsbanner-checkbox', 'yes' );
    } else {
        update_post_meta( $post_id, 'newsbanner-checkbox', '' );
    }
    if( isset( $_POST[ 'video-checkbox' ] ) ) {
        update_post_meta( $post_id, 'video-checkbox', 'yes' );
    } else {
        update_post_meta( $post_id, 'video-checkbox', '' );
    }
    if( isset( $_POST['postmp4'] ) ) {
        update_post_meta( $post_id, 'postmp4', $_POST[ 'postmp4' ] );
    }
    if( isset( $_POST['postogv'] ) ) {
        update_post_meta( $post_id, 'postogv', $_POST[ 'postogv' ] );
    }
    if( isset( $_POST['postwebm'] ) ) {

        update_post_meta( $post_id, 'postwebm', $_POST['postwebm'] );
    }


}
add_action( 'save_post', 'sm_meta_save' );




// Add the field to the Add New Category page
add_action( 'category_add_form_fields', 'pt_taxonomy_add_new_meta_field', 10, 2 );

function pt_taxonomy_add_new_meta_field() {
    // this will add the custom meta field to the add new term page
    ?>
    <div class="form-field">
        <label for="term_meta[labelclass]"><?php _e( 'Category Label Class', 'pt' ); ?></label>
        <input type="text" name="term_meta[labelclass]" id="term_meta[labelclass]" value="">
        <span class="description"><?php _e('Background Color Class (Default is bg-green) (bg-green, bg-grey, bg-red, bg-black, bg-blue, bg-white)'); ?></span>
    </div>
    <?php
}

// Add the field to the Edit Category page
add_action( 'category_edit_form_fields', 'pt_taxonomy_edit_meta_field', 10, 2 );

function pt_taxonomy_edit_meta_field($term) {

    // put the term ID into a variable
    $t_id = $term->term_id;

    // retrieve the existing value(s) for this meta field. This returns an array
    $term_meta = get_option( "taxonomy_$t_id" ); ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="term_meta[labelclass]"><?php _e( 'Category Label Class', 'pt' ); ?></label></th>
        <td>
            <input type="text" name="term_meta[labelclass]" id="term_meta[labelclass]" value="<?php echo esc_attr( $term_meta['labelclass'] ) ? esc_attr( $term_meta['labelclass'] ) : ''; ?>">
            <span class="description"><?php _e('Background Color Class (Default is bg-green) (bg-green, bg-grey, bg-red, bg-black, bg-blue, bg-white)'); ?></span>
        </td>
    </tr>
    <?php
}

// Save extra taxonomy fields callback function.
add_action( 'edited_category', 'pt_save_taxonomy_custom_meta', 10, 2 );
add_action( 'create_category', 'pt_save_taxonomy_custom_meta', 10, 2 );

function pt_save_taxonomy_custom_meta( $term_id ) {
    if ( isset( $_POST['term_meta'] ) ) {
        $t_id = $term_id;
        $term_meta = get_option( "taxonomy_$t_id" );
        $cat_keys = array_keys( $_POST['term_meta'] );
        foreach ( $cat_keys as $key ) {
            if ( isset ( $_POST['term_meta'][$key] ) ) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        // Save the option array.
        update_option( "taxonomy_$t_id", $term_meta );
    }
}
//pll__("Hours");
pll_register_string('Ignyte-Header', 'Search', 'Ignyte-Header');
pll_register_string('Ignyte-default-model', 'Close', 'Ignyte-default-model');
$locationarray=array('Hours','Locations','All Locations','Call Us','Find A Provider','GO','Services','Any Service','Filter Results','Zip Code','Currently Opend - Will Close AT','Currently Closed - Opens','Languages','Full Service Location','Specialty Location','Get Directions','Street Address','For life-threatening emergencies','Call','or go to the nearest hospital emergency room','Find A Doctor At This Location','Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday','Closed','Phone','View More','Address','Distance','5 Miles','10 Miles','20 Miles','50 Miles');
foreach($locationarray as $location)
{
    pll_register_string('Ignyte-LocationPage', $location, 'Ignyte-LocationPage');
}
$finddoctorarray=array('Search Provider Name','Type here ...','Show More','Results','Showing','of','Any Location','No Preference','Male','Female','Any Service','Education','Sorry, your search returned no results.','Provider Detail','Schedule an Appointment','Provider Since','Hobby/Fun Fact/Quote','Back to Results');
foreach($finddoctorarray as $doctor)
{
    pll_register_string('Ignyte-finddoctor', $doctor, 'Ignyte-finddoctor');
}
$servicvesarray=array('To make an appointment call','schedule online','is available at the following Neighborhood locations');
foreach($servicvesarray as $service)
{
    pll_register_string('Ignyte-service-detail', $service, 'Ignyte-service-detail');
}

$newsarray=array('Read More','Posted','Filter','All','Please Enter Email Address','Please Enter Valid Email Address');
foreach($newsarray as $news)
{
    pll_register_string('Ignyte-news-post', $news, 'Ignyte-news-post');
}
$searcharray=array('There are','results for','Sorry, we couldn’t find results for');
foreach($searcharray as $search)
{
    pll_register_string('Ignyte-search-result', $search, 'Ignyte-search-result');
}

// //disable yoast schema on locations
// function remove_location_schema() {
//     global $post;

//     //echo "<pre style='display:none'>".$post->post_type."</pre>";

//     if( is_singular() ) {
//         if( 'ignyte_locations' == $post->post_type ) {
            
//         add_filter( 'wpseo_json_ld_output', '__return_false' );
//         }
//     }
// }

// add_action( 'wp_head', 'remove_location_schema' );
add_filter('eTapPayment_sendIP', '__return_false');

