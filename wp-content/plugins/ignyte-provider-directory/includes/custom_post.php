<?php
function ignyte_all_specialty_add_taxonomies() {
    register_taxonomy(
        'ignyte_specialty',
        'ignyte_provider',
        array(
            'show_ui' => true, //show in admin list li slist
            'show_admin_column' => true, // This is grid top part .
            'query_var' => true,
            'label' => __( 'Specialty' ),
            'rewrite' => array( 'slug' => 'specialty' ),
            'hierarchical' => true,
        )
    );
}
add_action( 'init', 'ignyte_all_specialty_add_taxonomies' );

function ignyte_all_category_add_taxonomies() {
    register_taxonomy(
        'ignyte_category',
        'ignyte_provider',
        array(
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'label' => __( 'Category' ),
            'rewrite' => array( 'slug' => 'ignyte_category' ),
            'hierarchical' => true,
        )
    );
}
add_action( 'init', 'ignyte_all_category_add_taxonomies' );


//Define meta data for the custom category
require_once(IGNYTE_PROVIDER_DIRECTORY_PLUGIN_DIR."/includes/Tax-meta-class/Tax-meta-class.php");

$config = array(
    'id' => 'demo_meta_box2',                         // meta box id, unique per meta box
    'title' => 'All Specialty',                      // meta box title
    'pages' => array('ignyte_specialty'),                    // taxonomy name, accept categories, post_tag and custom taxonomies
    'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
    'fields' => array(),                             // list of meta fields (can be added by field arrays)
    'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false                        //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
);

function ignyte_all_lang_add_taxonomies() {
    register_taxonomy(
        'ignyte_lang',
        array('ignyte_provider','ignyte_locations'),
        array(
            'show_ui' => true, //show in admin list li slist
            'show_admin_column' => true, // This is grid top part .
            'query_var' => true,
            'label' => __( 'Language Spoken' ),
            'rewrite' => array( 'slug' => 'language' ),
            'hierarchical' => true,
        )
    );
}
add_action( 'init', 'ignyte_all_lang_add_taxonomies' );


$config = array(
    'id' => 'demo_meta_box2',                         // meta box id, unique per meta box
    'title' => 'Language Spoken',                      // meta box title
    'pages' => array('ignyte_lang'),                    // taxonomy name, accept categories, post_tag and custom taxonomies
    'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
    'fields' => array(),                             // list of meta fields (can be added by field arrays)
    'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
    'use_with_theme' => false                        //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
);


$my_meta = new Tax_Meta_Class($config);
//$my_meta->addText('team_role_subtitle',array('name'=> 'Subtitle '));
//$my_meta->addText('team_role_order',array('name'=> 'Order '));
//$my_meta->addImage('team_role_image',array('name'=> 'Image '));
$my_meta->Finish();

function create_provider_custom_post_type() {
	$labels = array(
		'name' => _x('Providers', 'post type general name'),
		'singular_name' => _x('Provider', 'post type singular name'),
		'add_new' => _x('Add New', 'Provider'),
		'add_new_item' => __('Add New Provider'),
		'edit_item' => __('Edit Provider'),
		'new_item' => __('New Provider'),
		'view_item' => __('View Provider'),
		'search_items' => __('Search Provider'),
		'not_found' =>  __('No Provider found'),
		'not_found_in_trash' => __('No Provider found in Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Providers'
	);

	register_post_type( 'ignyte_provider', array(
		'labels' => $labels,
		'capability_type' => 'page',
		'has_archive' => true,
		'hierarchical' => true,
		'query_var' => true,
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'rewrite' => array(
			'slug' => 'health-care-provider',
			'with_front' => true
		),
		'supports' => array(
			'title',
			'thumbnail',
			'editor'
		),
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'menu_position' => 6
	));

}

add_action( 'init', 'create_provider_custom_post_type', 0 );


include_once(IGNYTE_PROVIDER_DIRECTORY_PLUGIN_DIR.'/includes/meta_boxes.php');


add_filter( 'template_include', 'ignyte_provider_template_check', 100 );
/**
 * Provide fall back template file for a custom post type single view.
 * @return void
 */
function ignyte_provider_template_check( $template )
{
    // Our custom post type.
    $post_type = 'ignyte_provider';

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

    return $template;
}

/*

function wptutsplus_post_listing_column_resize() { ?>
    <style type="text/css">
        .widefat th.sortable {
            width: 65% !important;
        }
    </style>
<?php }
add_action( 'admin_enqueue_scripts', 'wptutsplus_post_listing_column_resize' );
*/