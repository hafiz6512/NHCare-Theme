<?php
function ignyte_all_faq_type_add_taxonomies() {
    register_taxonomy(
        'ignyte_faq_type',
        'ignyte_faqs',
        array(
            'show_ui' => true, //show in admin list li slist
            'show_admin_column' => true, // This is grid top part .
            'query_var' => true,
            'label' => __( 'Type' ),
            'rewrite' => array( 'slug' => 'resourse-faqs' ),
            'hierarchical' => true,
        )
    );
}
add_action( 'init', 'ignyte_all_faq_type_add_taxonomies' );


//Define meta data for the custom category
//require_once(IGNYTE_PROVIDER_DIRECTORY_PLUGIN_DIR."/includes/Tax-meta-class/Tax-meta-class.php");

require_once(IGNYTE_FAQS_PLUGIN_DIR."/Tax-meta-class/Tax-meta-class.php");
$config = array(
    'id' => 'demo_meta_box245',                         // meta box id, unique per meta box
    'title' => 'All Specialty',                      // meta box title
    'pages' => array('ignyte_faq_type'),                    // taxonomy name, accept categories, post_tag and custom taxonomies
    'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
    'fields' => array(),                             // list of meta fields (can be added by field arrays)
    'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => true                        //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
);
$my_meta = new Tax_Meta_Class($config);
//$my_meta->addText('subtitle',array('name'=> 'Subtitle '));
$my_meta->addCheckbox('showfrontend',array('name'=> 'Show On FAQs Tab'));
$my_meta->Finish();



function create_faqs_custom_post_type() {
	$labels = array(
		'name' => _x('FAQs', 'post type general name'),
		'singular_name' => _x('FAQs', 'post type singular name'),
		'add_new' => _x('Add New', 'FAQs'),
		'add_new_item' => __('Add New FAQs'),
		'edit_item' => __('Edit FAQs'),
		'new_item' => __('New FAQs'),
		'view_item' => __('View FAQs'),
		'search_items' => __('Search FAQs'),
		'not_found' =>  __('No FAQs found'),
		'not_found_in_trash' => __('No FAQs found in Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'FAQs'
	);
	
	register_post_type( 'ignyte_faqs', array(
		'labels' => $labels,
		'capability_type' => 'page',
		'has_archive' => true,
		'hierarchical' => false,
		'query_var' => true,
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'rewrite' => array(
			'slug' => 'faqslist',
			'with_front' => false
		),
		'supports' => array(
			'title',
			'thumbnail',
			'editor',
            'excerpt'
		),
		'show_ui' => true, 
		'show_in_menu' => true, 
		'show_in_nav_menus' => true,
		'menu_position' => 6
	));

}

add_action( 'init', 'create_faqs_custom_post_type', 0 );





add_filter( 'template_include', 'ignyte_faqs_template_check', 100 );
/**
 * Provide fall back template file for a custom post type single view.
 * @return void
 */
function ignyte_faqs_template_check( $template )
{
    // Our custom post type.
    $post_type = 'ignyte_faqs';
	
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
	if (is_archive()  && $post_type === get_post_type( $GLOBALS['post'] ) ){
		// return archive file
		return dirname( __FILE__ ) . "/templates/archive-$post_type.php";
	}
    return $template;
}







