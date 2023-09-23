<?

// $template_file = get_template_file();
$template_file = get_page_template_slug();

/***Meta box extra content for pages***/
// Get information on the template being used for current page, based on this we will control the different meta boxes being displayed

// if ($_SERVER["REQUEST_METHOD"] == "POST"){
// 	$id = get_the_ID();
// 	$post_id = $_GET['post'] ? $_GET['post'] : $id ;
// 	$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
// }


/** Show meta box for slider options: */
if (is_admin())
	add_action('admin_menu', 'ignyte_leadincontent_meta_box');

	
// This function tells WP to add a new "meta box"
function ignyte_leadincontent_meta_box() {
	add_meta_box(
		'ignyte_leadincontent_options', // id of the <div> we'll add
		'Lead In Copy', //title
		'ignyte_leadincontent_box_contents', // callback function that will echo the box content
		'page', // where to add the box: on "post", "page", or "link" page
		'normal',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_leadincontent_box_contents() {
	
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	//var_dump($meta);	
	echo '<input type="hidden" name="ignyte_leadincontent_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';


	echo '<textarea name="ignyte_leadincontent_content" id="ignyte_slider_category" rows="5" cols="60" style="width:99%">'.$meta["ignyte_leadincontent_content"].'</textarea>';

}
// Hook things in, late enough so that add_meta_box() is defined
function ignyte_leadincontent_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_leadincontent_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$post_meta_array=array( "ignyte_leadincontent_content" );
	foreach($post_meta_array as $post_this_meta) {
		$posts = get_posts(array(
			'post_id' => $post_id
		));
		//echo $post_id,'recipes_'.$post_this_meta,$_POST['recipes_'.$post_this_meta]."<br>";
		update_post_meta($post_id,$post_this_meta,$_POST[$post_this_meta]);
	}
}
add_action( 'save_post', 'ignyte_leadincontent_save_post_data' );


if (is_admin())
	add_action('admin_menu', 'ignyte_bottom_shortcode_meta_box');

// This function tells WP to add a new "meta box"
function ignyte_bottom_shortcode_meta_box() {
	add_meta_box(
		'ignyte_bottom_shortcode_options', // id of the <div> we'll add
		'Bottom Shortcode Section', //title
		'ignyte_bottom_shortcode_box_contents', // callback function that will echo the box content
		'page', // where to add the box: on "post", "page", or "link" page
		'normal',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_bottom_shortcode_box_contents() {
	
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	//var_dump($meta);	
	echo '<input type="hidden" name="ignyte_bottom_shortcode_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';


	echo '<textarea name="ignyte_bottom_shortcode_content" id="ignyte_bottom_shortcode_content" rows="5" cols="60" style="width:99%">'.$meta["ignyte_bottom_shortcode_content"].'</textarea>';

}
// Hook things in, late enough so that add_meta_box() is defined
function ignyte_bottom_shortcode_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_bottom_shortcode_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$post_meta_array=array( "ignyte_bottom_shortcode_content" );
	foreach($post_meta_array as $post_this_meta) {
		$posts = get_posts(array(
			'post_id' => $post_id
		));
		//echo $post_id,'recipes_'.$post_this_meta,$_POST['recipes_'.$post_this_meta]."<br>";
		update_post_meta($post_id,$post_this_meta,$_POST[$post_this_meta]);
	}
}
add_action( 'save_post', 'ignyte_bottom_shortcode_save_post_data' );




if (is_admin())
	add_action('admin_menu', 'ignyte_title_meta_box');

// This function tells WP to add a new "meta box"
function ignyte_title_meta_box() {
	add_meta_box(
		'ignyte_title_options', // id of the <div> we'll add
		'Page Title (Placed at page top, allows HTML, if empty removes title)', //title
		'ignyte_title_box_contents', // callback function that will echo the box content
		'page', // where to add the box: on "post", "page", or "link" page
		'normal',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_title_box_contents() {
	
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	//var_dump($meta);	
	echo '<input type="hidden" name="ignyte_title_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

	echo '<textarea name="ignyte_title_content" id="ignyte_title_content" rows="1" cols="60" style="width:99%">'.$meta["ignyte_title_content"].'</textarea>';


}
// Hook things in, late enough so that add_meta_box() is defined
function ignyte_title_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_title_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$post_meta_array=array( "ignyte_title_content" );
	foreach($post_meta_array as $post_this_meta) {
		$posts = get_posts(array(
			'post_id' => $post_id
		));
		//echo $post_id,'recipes_'.$post_this_meta,$_POST['recipes_'.$post_this_meta]."<br>";
		update_post_meta($post_id,$post_this_meta,$_POST[$post_this_meta]);
	}
}
add_action( 'save_post', 'ignyte_title_save_post_data' );



/*** Meta box for slider ***/
		/** Show meta box for slider options: */
		if (is_admin())
			add_action('admin_menu', 'ignyte_slider_meta_box');
			
		// This function tells WP to add a new "meta box"
		function ignyte_slider_meta_box() {
			add_meta_box(
				'ignyte_slider_options', // id of the <div> we'll add
				'Slider Group', //title
				'ignyte_slider_box_contents', // callback function that will echo the box content
				'page', // where to add the box: on "post", "page", or "link" page
				'side',										// placement on add/edit page
				'high'											// priority on add/edit page
			);
		}
		// This function echoes the content of our meta box
		function ignyte_slider_box_contents() {
			
			if($_GET['post']) {
				$custom_fields = get_post_custom($_GET['post']);
				foreach ( $custom_fields as $key => $value ) {
					$meta[$key] = $value[0];
				}
			}
			//var_dump($meta);	
			echo '<input type="hidden" name="ignyte_slider_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
			
			//Prepare non dynamic values
			$categories=get_terms( 'slider_group' );
			$newItem["name"]="No Slider";
			$newItem["term_id"]="no_slider";
			$newItem2["name"]="Pages";
			$newItem2["term_id"]="pages";
			$newItem3["name"]="";
			$newItem3["term_id"]="";
			array_unshift ($categories,(object)$newItem2);
			array_unshift ($categories,(object)$newItem);
			array_unshift ($categories,(object)$newItem3);
		
			echo '<select name="ignyte_slider_category" id="ignyte_slider_category">';
			foreach ($categories as $category) {
				if (($meta["ignyte_slider_category"])==($category->name))
					echo '<option SELECTED value="'.$category->name.'" >', $category->name, '</option>';
				else
					echo '<option value="'.$category->name.'" >', $category->name, '</option>';
			}
			echo '</select>';
		}
		
		// Hook things in, late enough so that add_meta_box() is defined
		function ignyte_slider_save_post_data($post_id){
			if ( !wp_verify_nonce( $_POST['ignyte_slider_box_nonce'], basename( __FILE__ ) ) ) {
				return;
			}
			if ( !current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
			$post_meta_array=array( "ignyte_slider_category" );
			foreach($post_meta_array as $post_this_meta) {
				$posts = get_posts(array(
					'post_id' => $post_id
				));
				//echo $post_id,'recipes_'.$post_this_meta,$_POST['recipes_'.$post_this_meta]."<br>";
				update_post_meta($post_id,$post_this_meta,$_POST[$post_this_meta]);
			}
		}
		add_action( 'save_post', 'ignyte_slider_save_post_data' );
/*** End Meta box for slider ***/		
		
		
/*** Meta box for Image: ***/
		if (is_admin())
			add_action('admin_menu', 'ignyte_banner_meta_image_box');
		
		// This function tells WP to add a new "meta box"
		function ignyte_banner_meta_image_box() {
			add_meta_box(
				'ignyte_leadincontent_box_contents', // id of the <div> we'll add
				'Banner Options', //title
				'ignyte_banner_meta_image_options', // callback function that will echo the box content
				'page', // where to add the box: on "post", "page", or "link" page
				'normal',										// placement on add/edit page
				'high'											// priority on add/edit page
			);
		}
		// This function echoes the content of our meta box
		function ignyte_banner_meta_image_options() {
			if($_GET['post']) {
				$custom_fields = get_post_custom($_GET['post']);
				foreach ( $custom_fields as $key => $value ) {
					$meta[$key] = $value[0];
				}
			}
			//var_dump($meta);	
			echo '<input type="hidden" name="ignyte_banner_image_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
			?>

<style>
    .lrmain-div
    {
        height: auto;
        width: 100%;
        float: left;
    }
    .left-div
    {
        float: left;
        width: 49%;

    }
    .right-div
    {
        float: left;
        width: 49%;
        margin-left: 1%;

    }
</style>

            <div class="lrmain-div">
                <div class="left-div"> <label for="ignyte_banner_image_title" ><?php _e( 'Content Left', 'ignyte' )?></label> <br/>
                    <textarea  name="ignyte_banner_content" id="ignyte_banner_content"  rows="6" cols="60" style="width:99%; float: left"><?php if ( isset ( $custom_fields['ignyte_banner_content'] ) ) echo $custom_fields['ignyte_banner_content'][0]; ?></textarea>
                </div>
                <div class="right-div"> <label for="ignyte_banner_image_title" ><?php _e( 'Content Right', 'ignyte' )?></label> <br/>
                    <textarea  name="ignyte_banner_content2" id="ignyte_banner_content2"  rows="6" cols="60" style="width:99%; float: left"><?php if ( isset ( $custom_fields['ignyte_banner_content2'] ) ) echo $custom_fields['ignyte_banner_content2'][0]; ?></textarea>
                </div>
            </div>
            <br/>
                <label for="ignyte_banner_image" ><?php _e( 'Post Image', 'ignyte' )?></label>
                <input type="text" name="ignyte_banner_image" id="ignyte_banner_image" value="<?php if ( isset ( $custom_fields['ignyte_banner_image'] ) ) echo $custom_fields['ignyte_banner_image'][0]; ?>" />
                <input type="button" id="ignyte_banner_image_button" class="button" value="<?php _e( 'Choose or Upload an Image', 'ignyte' )?>" /><br />
                <img style=" <?=$custom_fields['ignyte_banner_image'] ? '':'display:none;'?> height:100px;" id="ignyte_banner_image_src" src="<?=$custom_fields['ignyte_banner_image'][0]?>" />
            <br/>



			<?php
		
		}		
		// Hook things in, late enough so that add_meta_box() is defined
		function ignyte_banner_image_save_post_data($post_id){
			if ( !wp_verify_nonce( $_POST['ignyte_banner_image_box_nonce'], basename( __FILE__ ) ) ) {
				return;
			}
			if ( !current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
			$post_meta_array=array( "ignyte_banner_image","ignyte_banner_content","ignyte_banner_content2" );
			foreach($post_meta_array as $post_this_meta) {
				$posts = get_posts(array(
					'post_id' => $post_id
				));
				//echo $post_id,'recipes_'.$post_this_meta,$_POST['recipes_'.$post_this_meta]."<br>";
				update_post_meta($post_id,$post_this_meta,$_POST[$post_this_meta]);
			}
		}
		add_action( 'save_post', 'ignyte_banner_image_save_post_data' );
	
		/**
		 * Loads the image management javascript
		 */
		function ignyte_banner_image_enqueue_js() {
			global $typenow;
			if( $typenow == 'page' ) {
				wp_enqueue_media();
		 
				// Registers and enqueues the required javascript.
				wp_register_script( 'ignyte_banner_image', get_template_directory_uri() . '/includes/js/ignyte-banner-image.js', array( 'jquery' ) );
				wp_localize_script( 'ignyte_banner_image', 'ignyte_banner_image',
					array(
						'title' => __( 'Choose or Upload an Image', 'ignyte' ),
						'button' => __( 'Use this image', 'ignyte' ),
					)
				);
				wp_enqueue_script( 'ignyte_banner_image' );
			}
		}
		add_action( 'admin_enqueue_scripts', 'ignyte_banner_image_enqueue_js' );
/*** End Meta box for Image: ***/




/** Show meta box for Custom Sidebar Template options: */
if (is_admin() && strstr($template_file, "page-custom-sidebar") ){
	add_action('admin_menu', 'ignyte_page_custom_sidebar_meta_box');
}

	
// This function tells WP to add a new "meta box"
function ignyte_page_custom_sidebar_meta_box() {
	add_meta_box(
		'ignyte_page_custom_sidebar_meta_box', // id of the <div> we'll add
		'Custom Sidebar', //title
		'ignyte_page_custom_sidebar_box_contents', // callback function that will echo the box content
		'page', // where to add the box: on "post", "page", or "link" page
		'side',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_page_custom_sidebar_box_contents() {
	
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	//var_dump($meta);	
	echo '<input type="hidden" name="ignyte_page_custom_sidebar_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

	echo 'Top Section: <textarea name="ignyte_page_custom_sidebar_top_content" id="ignyte_page_custom_sidebar_top_content" rows="5" cols="60" style="width:99%">'.$meta["ignyte_page_custom_sidebar_top_content"].'</textarea>';
	
	echo 'Mid Section: <textarea name="ignyte_page_custom_sidebar_mid_content" id="ignyte_page_custom_sidebar_mid_content" rows="5" cols="60" style="width:99%">'.$meta["ignyte_page_custom_sidebar_mid_content"].'</textarea>';
	
	echo 'Bottom Section: <textarea name="ignyte_page_custom_sidebar_bot_content" id="ignyte_page_custom_sidebar_bot_content" rows="5" cols="60" style="width:99%">'.$meta["ignyte_page_custom_sidebar_bot_content"].'</textarea>';

}
// Hook things in, late enough so that add_meta_box() is defined
function ignyte_page_custom_sidebar_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_page_custom_sidebar_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$post_meta_array=array( "ignyte_page_custom_sidebar_top_content" , "ignyte_page_custom_sidebar_mid_content" , "ignyte_page_custom_sidebar_bot_content" );
	foreach($post_meta_array as $post_this_meta) {
		$posts = get_posts(array(
			'post_id' => $post_id
		));
		//echo $post_id,'recipes_'.$post_this_meta,$_POST['recipes_'.$post_this_meta]."<br>";
		update_post_meta($post_id,$post_this_meta,$_POST[$post_this_meta]);
	}
}
add_action( 'save_post', 'ignyte_page_custom_sidebar_save_post_data' );






	//&& strstr($template_file,"page-custom-sidebar"

if (is_admin() && strstr($template_file,"page-fullwidth-services") )
	add_action('admin_menu', 'ignyte_bottom_services_shortcode_meta_box');
	
// This function tells WP to add a new "meta box"
function ignyte_bottom_services_shortcode_meta_box() {
		add_meta_box(
			'ignyte_bottom_services_shortcode_meta_box', // id of the <div> we'll add
			'Bottom Services Shortcode Section, for individual services', //title
			'ignyte_bottom_services_shortcode_box_contents', // callback function that will echo the box content
			'page', // where to add the box: on "post", "page", or "link" page
			'normal',										// placement on add/edit page
			'high'											// priority on add/edit page
		);

}
// This function echoes the content of our meta box
function ignyte_bottom_services_shortcode_box_contents() {
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	//var_dump($meta);	
	echo '<input type="hidden" name="ignyte_bottom_services_shortcode_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';


	echo '<textarea name="ignyte_bottom_services_shortcode_content" id="ignyte_bottom_services_shortcode_content" rows="5" cols="60" style="width:99%">'.$meta["ignyte_bottom_services_shortcode_content"].'</textarea>';
	
}
// Hook things in, late enough so that add_meta_box() is defined
function ignyte_bottom_services_shortcode_save_post_data($post_id){
	// if ( !wp_verify_nonce( $_POST['ignyte_bottom_services_shortcode_box_nonce'], basename( __FILE__ ) ) ) {
	// 	return;
	// }

	if ( isset( $_POST['ignyte_bottom_services_shortcode_box_nonce'] ) && wp_verify_nonce( $_POST['ignyte_bottom_services_shortcode_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}

	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$post_meta_array=array( "ignyte_bottom_services_shortcode_content" );
	foreach($post_meta_array as $post_this_meta) {
		$posts = get_posts(array(
			'post_id' => $post_id
		));
		//echo $post_id,'recipes_'.$post_this_meta,$_POST['recipes_'.$post_this_meta]."<br>";
		update_post_meta($post_id,$post_this_meta,$_POST[$post_this_meta]);
	}
}
add_action( 'save_post', 'ignyte_bottom_services_shortcode_save_post_data' );








/// DEFINE META BOX FOR FALLBACK OPTIONS
if (is_admin())
	add_action('admin_menu', 'ignyte_page_fallback_meta_box');

// This function tells WP to add a new "meta box"
function ignyte_page_fallback_meta_box() {
	add_meta_box(
		'ignyte_page_fallback_options', // id of the <div> we'll add
		'PNG Fallback Image', //title
		'ignyte_page_fallback_meta_box_contents', // callback function that will echo the box content
		'page', // where to add the box: on "post", "page", or "link" page
		'side',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_page_fallback_meta_box_contents() {
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	//var_dump($meta);	
	echo '<input type="hidden" name="ignyte_page_fallback_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	?>
	<div class="input-group">
		<img style=" <?=$custom_fields['ignyte_page_fallback_png'] ? '':'display:none;'?> height:200px;" id="ignyte_page_fallback_png-src" src="<?=$custom_fields['ignyte_page_fallback_png'][0]?>" /><br>
		<input type="text" name="ignyte_page_fallback_png" id="ignyte_page_fallback_png" value="<?php if ( isset ( $custom_fields['ignyte_page_fallback_png'] ) ) echo $custom_fields['ignyte_page_fallback_png'][0]; ?>" /><br/>
		<input type="button" id="ignyte_page_fallback_png-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'ignyte' )?>" />
	</div>
    
    <script>
		jQuery(document).ready(function($){
			var custom_uploader;
			$('#ignyte_page_fallback_png-button').click(function(e) {
				e.preventDefault();
				//If the uploader object has already been created, reopen the dialog
				if (custom_uploader) {
					custom_uploader.open();
					return;
				}
				//Extend the wp.media object
				custom_uploader = wp.media.frames.file_frame = wp.media({
					title: 'Choose Image',
					button: {
						text: 'Choose Image'
					},
					multiple: false
				});
				//When a file is selected, grab the URL and set it as the text field's value
				custom_uploader.on('select', function() {
					attachment = custom_uploader.state().get('selection').first().toJSON();
					$('#ignyte_page_fallback_png').val(attachment.url);
					$('#ignyte_page_fallback_png-src').attr("src",attachment.url);
					$('#ignyte_page_fallback_png-src').toggle();
				});
				//Open the uploader dialog
				custom_uploader.open();
			});
		});
    </script>
    
    <?php

}
// Hook things in, late enough so that add_fallback_meta_box() is defined
function ignyte_page_fallback_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_page_fallback_meta_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
  $post_meta_array=array( "ignyte_page_fallback_png"  );
	foreach($post_meta_array as $post_this_meta) {
		$posts = get_posts(array(
			'post_id' => $post_id
		));
		//echo $post_id,'recipes_'.$post_this_meta,$_POST['recipes_'.$post_this_meta]."<br>";
		update_post_meta($post_id,$post_this_meta,$_POST[$post_this_meta]);
	}

	
}
add_action( 'save_post', 'ignyte_page_fallback_save_post_data' );

