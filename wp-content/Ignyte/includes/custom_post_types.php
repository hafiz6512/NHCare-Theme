<?php


/** Slider Custom Types*/
add_action( 'init', 'ignyte_slider_add_taxonomies' );

function ignyte_slider_add_taxonomies() {
	register_taxonomy(
		'slider_group',
		'slider_group',
		array(
			'label' => __( 'Slider Group' ),
			'rewrite' => array( 'slug' => 'slider_group' ),
			'hierarchical' => true,
		)
	);
}
add_action( 'init', 'register_ignyte_slider_item' );

function register_ignyte_slider_item() {

    $labels = array( 
        'name' => _x( 'Slider Items', 'Slider Items' ),
        'singular_name' => _x( 'Slider Item', 'Slider Item' ),
        'add_new' => _x( 'Add New', 'Slider Item' ),
        'add_new_item' => _x( 'Add New Slider Items', 'Slider Items' ),
        'edit_item' => _x( 'Edit Slider Items', 'Slider Items' ),
        'new_item' => _x( 'New Slider Items', 'Slider Items' ),
        'view_item' => _x( 'View Slider Items', 'Slider Items' ),
        'search_items' => _x( 'Search Slider Item', 'Slider Items' ),
        'not_found' => _x( 'No Slider Item found', 'Slider Items' ),
        'not_found_in_trash' => _x( 'No Slider Item found in Trash', 'Slider Items' ),
        'parent_item_colon' => _x( 'Parent Slider Items:', 'Slider Items' ),
        'menu_name' => _x( 'Slider Item', 'Slider Items' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => true,
        
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', 'revisions' ),
        'taxonomies' => array( 'slider_group' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 20,
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'page'
    );
	
	 register_post_type( 'Slider Items', $args );
   
}


/*** Awards **/
/*
function my_post_type_awards() {
	register_post_type( 'ignyte_awards',
		array( 
				'label'             => "Awards", 
				'public'            => true, 
				'show_ui'           => true,
				'show_in_nav_menus' => false,
				'menu_position'     => 5,
				'rewrite'           => array(
					'slug'       => 'award-view',
					'with_front' => FALSE,
				),
				'supports' => array(
						'title',
						'custom-fields',
						'thumbnail',
						'editor')
					) 
				);
}
add_action('init', 'my_post_type_awards');
*/