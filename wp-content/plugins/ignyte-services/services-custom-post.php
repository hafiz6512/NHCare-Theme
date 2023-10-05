<?php
function create_services_custom_post_type() {
	$labels = array(
		'name' => _x('Health Services', 'post type general name'),
		'singular_name' => _x('Health Service', 'post type singular name'),
		'add_new' => _x('Add New', 'Health Service'),
		'add_new_item' => __('Add New Health Service'),
		'edit_item' => __('Edit Health Service'),
		'new_item' => __('New Health Service'),
		'view_item' => __('View Health Service'),
		'search_items' => __('Search Health Services'),
		'not_found' =>  __('No Health Services found'),
		'not_found_in_trash' => __('No Health Services found in Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Health Services'
	);

	register_post_type( 'ignyte_services', array(
		'labels' => $labels,
		'capability_type' => 'page',
		'has_archive' => true,
		'hierarchical' => false,
		'query_var' => true,
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'rewrite' => array(
			'slug' => 'health-services',
			'with_front' => true
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

add_action( 'init', 'create_services_custom_post_type', 0 );





add_filter( 'template_include', 'ignyte_services_template_check', 100 );
/**
 * Provide fall back template file for a custom post type single view.
 * @return void
 */
function ignyte_services_template_check( $template )
{
    // Our custom post type.
    $post_type = 'ignyte_services';

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


/**
 * Loads the image management javascript
 */
function ignyte_image_enqueue() {
    global $typenow;
    if( $typenow == 'ignyte_services' ) {
        wp_enqueue_media();

        // Registers and enqueues the required javascript.
        wp_register_script( 'meta-box-image', plugin_dir_url( __FILE__ ) . 'meta-box-image.js', array( 'jquery' ) );
        wp_localize_script( 'meta-box-image', 'meta_image',
            array(
                'title' => __( 'Choose or Upload an Image', 'ignyte' ),
                'button' => __( 'Use this image', 'ignyte' ),
            )
        );
        wp_enqueue_script( 'meta-box-image' );
    }
}
add_action( 'admin_enqueue_scripts', 'ignyte_image_enqueue' );




/// DEFINE META BOX FOR LOCATIONS
if (is_admin())
	add_action('admin_menu', 'ignyte_service_location_meta_box');

// This function tells WP to add a new "meta box"
function ignyte_service_location_meta_box() {
	add_meta_box(
		'ignyte_service_location_options', // id of the <div> we'll add
		'Service Locations', //title
		'ignyte_service_location_contents', // callback function that will echo the box content
		'ignyte_services', // where to add the box: on "post", "page", or "link" page
		'side',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_service_location_contents() {
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
    $postId=$_GET['post'];
    $post_language = wpml_get_language_information($postId);
    $language_code=$post_language['language_code'];
    $args = array(
        'posts_per_page' => -1,
        'post_type'      => 'ignyte_locations',
        'lang' => $language_code,
        'post_status'    => 'publish');

    $selected_locations = unserialize($meta["ignyte_locations[]"]);
	//var_dump($meta);
	echo '<input type="hidden" name="ignyte_service_location_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	?>
	<div class="input-group">
	<?php
		$locations=get_posts($args);
		//var_dump($locations);
		foreach($locations as $loc){
			$getLocationsPostName = str_replace(' - ', ' ', $loc->post_title);
			if (isset($selected_locations[$loc->ID]) && $selected_locations[$loc->ID] != ''){
				echo "<input type='checkbox' name='ignyte_locations[".$loc->ID."]' CHECKED value='".$getLocationsPostName."'>".$getLocationsPostName."<br />";
			}else{
				echo "<input type='checkbox' name='ignyte_locations[".$loc->ID."]' value='".$getLocationsPostName."'>".$getLocationsPostName."<br />";
			}
		}
	?>

	</div>

    <?php
}
// Hook things in, late enough so that add_meta_box() is defined
function ignyte_service_location_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_service_location_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$locationarray=$_POST["ignyte_locations"];
	//var_dump($locationarray);
	$posts = get_posts(array('post_id' => $post_id));
	update_post_meta($post_id,'ignyte_locations[]',$locationarray);



}
add_action( 'save_post', 'ignyte_service_location_save_post_data' );






/// DEFINE META BOX FOR OPTIONS
if (is_admin())
	add_action('admin_menu', 'ignyte_service_meta_box');

// This function tells WP to add a new "meta box"
function ignyte_service_meta_box() {
	add_meta_box(
		'ignyte_service_options', // id of the <div> we'll add
		'Service Options', //title
		'ignyte_service_box_contents', // callback function that will echo the box content
		'ignyte_services', // where to add the box: on "post", "page", or "link" page
		'normal',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_service_box_contents() {
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	//var_dump($meta);
	echo '<input type="hidden" name="ignyte_service_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	?>

    <div class="input-group">
        <input type="checkbox" name="home-checkbox" id="home-checkbox" value="yes" <?php if ( isset ( $custom_fields['home-checkbox'][0] ) ) checked( $custom_fields['home-checkbox'][0], 'yes' ); ?> />
        <?php _e( 'Show on Home', 'sm-textdomain' )?> </div>
    <br/>
    <div class="input-group">
        <input type="checkbox" name="location-model-checkbox" id="location-model-checkbox" value="yes" <?php if ( isset ( $custom_fields['location-model-checkbox'][0] ) ) checked( $custom_fields['location-model-checkbox'][0], 'yes' ); ?> />
        <?php _e( 'Show only in Location Modal', 'sm-textdomain' )?> </div>
    <br/>

    <div class="input-group">
        <label for="ignyte-ignyte_model_alternative-image" >Alternative Modal Label:</label> <br/>
        <textarea name="ignyte_model_alternative" style="height: 100px; width: 50%"><?php echo $custom_fields['ignyte_model_alternative'][0]; ?></textarea>
    </div>
    <br/>

  <?php /*  <div class="input-group">
        <label for="ignyte-service-meta-image" ><?php _e( 'Service Background  Label Class', 'ignyte' )?></label><br/>
        <input style="width: 70%" type="text" name="ignyte-service-class" id="ignyte-service-class" value="<?php if ( isset ( $custom_fields['ignyte-service-class'] ) ) echo $custom_fields['ignyte-service-class'][0]; ?>" />
        <br/><span class="description" style="font-size: 10px"><?php _e('Background Color Class (Default is bg-green) (bg-green, bg-grey, bg-red, bg-black, bg-blue, bg-white)'); ?></span>
    </div>
    <br/>
*/?>
    <div class="input-group">
	<label for="ignyte-service-meta-image" ><?php _e( 'Post Image', 'ignyte' )?></label>
	<input type="text" name="ignyte-service-meta-image" id="ignyte-service-meta-image" value="<?php if ( isset ( $custom_fields['ignyte-service-meta-image'] ) ) echo $custom_fields['ignyte-service-meta-image'][0]; ?>" />
	<input type="button" id="ignyte-service-meta-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'ignyte' )?>" /><br />
    <img style=" <?=$custom_fields['ignyte-service-meta-image'] ? '':'display:none;'?> height:200px;" id="ignyte-service-meta-image-src" src="<?=$custom_fields['ignyte-service-meta-image'][0]?>" />
	</div>


    <?php
	echo '<div class="input-group">';
	echo '<label for="ignyte-serviceignyte_bottom_shortcode_contentmeta-image" >Bottom Shortcode Content:</label>';
	echo '<textarea name="ignyte_bottom_shortcode_content" id="ignyte_bottom_shortcode_content" rows="5" cols="60" style="width:99%">'.$meta["ignyte_bottom_shortcode_content"].'</textarea>';
	echo '</div>';

}
// Hook things in, late enough so that add_meta_box() is defined
function ignyte_service_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_service_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
  $post_meta_array=array( "home-checkbox","location-model-checkbox","ignyte_model_alternative","ignyte_service_address","ignyte_service_phone","ignyte-service-meta-image","ignyte_bottom_shortcode_content"  );
	foreach($post_meta_array as $post_this_meta) {
		$posts = get_posts(array(
			'post_id' => $post_id
		));
		if($post_this_meta=='location-model-checkbox')
        {
            if($_POST[$post_this_meta]=='yes')
            {
                $val='yes';
            }
            else
            {
                $val='no';
            }
            update_post_meta($post_id, $post_this_meta,$val);
        }
        else {
            //echo $post_id,'recipes_'.$post_this_meta,$_POST['recipes_'.$post_this_meta]."<br>";
            update_post_meta($post_id, $post_this_meta, $_POST[$post_this_meta]);
        }
	}


}
add_action( 'save_post', 'ignyte_service_save_post_data' );




/// DEFINE META BOX FOR FALLBACK OPTIONS
if (is_admin())
	add_action('admin_menu', 'ignyte_service_fallback_meta_box');

// This function tells WP to add a new "meta box"
function ignyte_service_fallback_meta_box() {
	add_meta_box(
		'ignyte_service_fallback_options', // id of the <div> we'll add
		'PNG Fallback Featured Image', //title
		'ignyte_service_fallback_meta_box_contents', // callback function that will echo the box content
		'ignyte_services', // where to add the box: on "post", "page", or "link" page
		'side',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_service_fallback_meta_box_contents() {
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	//var_dump($meta);
	echo '<input type="hidden" name="ignyte_service_fallback_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	?>
	<div class="input-group">
		<img style=" <?=$custom_fields['ignyte-service-fallback-image'] ? '':'display:none;'?> height:200px;" id="ignyte-service-fallback-image-src" src="<?=$custom_fields['ignyte-service-fallback-image'][0]?>" /><br>
		<input type="text" name="ignyte-service-fallback-image" id="ignyte-service-fallback-image" value="<?php if ( isset ( $custom_fields['ignyte-service-fallback-image'] ) ) echo $custom_fields['ignyte-service-fallback-image'][0]; ?>" /><br/>
		<input type="button" id="ignyte-service-fallback-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'ignyte' )?>" />
	</div>
    <?php

}
// Hook things in, late enough so that add_fallback_meta_box() is defined
function ignyte_service_fallback_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_service_fallback_meta_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
  $post_meta_array=array( "ignyte-service-fallback-image"  );
	foreach($post_meta_array as $post_this_meta) {
		$posts = get_posts(array(
			'post_id' => $post_id
		));
		//echo $post_id,'recipes_'.$post_this_meta,$_POST['recipes_'.$post_this_meta]."<br>";
		update_post_meta($post_id,$post_this_meta,$_POST[$post_this_meta]);
	}


}
add_action( 'save_post', 'ignyte_service_fallback_save_post_data' );

