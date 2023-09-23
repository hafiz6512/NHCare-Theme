<?php

/// DEFINE META BOX FOR SERVICES
if (is_admin())
	add_action('admin_menu', 'ignyte_provider_directory_service_meta_box');

// This function tells WP to add a new "meta box"
function ignyte_provider_directory_service_meta_box() {
	add_meta_box(
		'ignyte_provider_directory_service_options', // id of the <div> we'll add
		'Services', //title
		'ignyte_provider_directory_service_contents', // callback function that will echo the box content
		'ignyte_provider', // where to add the box: on "post", "page", or "link" page
		'side',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_provider_directory_service_contents() {
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	$selected_services=unserialize($meta["ignyte_services[]"]);
	//var_dump($meta);	
	echo '<input type="hidden" name="ignyte_provider_directory_service_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	?>
	<div class="input-group">
	<?php 
		$services=get_posts("post_type=ignyte_services&posts_per_page=-1");
		//var_dump($selected_services);
		foreach($services as $ser){
			if ($selected_services[$ser->ID]<>''){
				echo "<input type='checkbox' name='ignyte_services[".$ser->ID."]' CHECKED value='".$ser->post_title."'>".$ser->post_title."<br />";
			}else{
				echo "<input type='checkbox' name='ignyte_services[".$ser->ID."]' value='".$ser->post_title."'>".$ser->post_title."<br />";
			}
		}
	?>
   
	</div>
    
    <?php
}
// Hook things in, late enough so that add_meta_box() is defined
function ignyte_provider_directory_service_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_provider_directory_service_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$servicearray=$_POST["ignyte_services"];
	//var_dump($servicearray);
	$posts = get_posts(array('post_id' => $post_id));
	update_post_meta($post_id,'ignyte_services[]',$servicearray);


	
}
add_action( 'save_post', 'ignyte_provider_directory_service_save_post_data' );






/// DEFINE META BOX FOR LOCATIONS
if (is_admin())
	add_action('admin_menu', 'ignyte_provider_directory_location_meta_box');

// This function tells WP to add a new "meta box"
function ignyte_provider_directory_location_meta_box() {
	add_meta_box(
		'ignyte_provider_directory_location_options', // id of the <div> we'll add
		'Locations', //title
		'ignyte_provider_directory_location_contents', // callback function that will echo the box content
		'ignyte_provider', // where to add the box: on "post", "page", or "link" page
		'side',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_provider_directory_location_contents() {
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	$selected_locations=unserialize($meta["ignyte_locations[]"]);
	//var_dump($meta);	
	echo '<input type="hidden" name="ignyte_provider_directory_location_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	?>
	<div class="input-group">
	<?php 
		$locations=get_posts("post_type=ignyte_locations&posts_per_page=-1");
		//var_dump($selected_locations);
		foreach($locations as $loc){
			if ($selected_locations[$loc->ID]<>''){
				echo "<input type='checkbox' name='ignyte_locations[".$loc->ID."]' CHECKED value='".$loc->post_title."'>".$loc->post_title."<br />";
			}else{
				echo "<input type='checkbox' name='ignyte_locations[".$loc->ID."]' value='".$loc->post_title."'>".$loc->post_title."<br />";
			}
		}
	?>
   
	</div>
    
    <?php
}
// Hook things in, late enough so that add_meta_box() is defined
function ignyte_provider_directory_location_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_provider_directory_location_box_nonce'], basename( __FILE__ ) ) ) {
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
add_action( 'save_post', 'ignyte_provider_directory_location_save_post_data' );





/// DEFINE META BOX FOR Languages
if (is_admin())
	add_action('admin_menu', 'ignyte_provider_directory_language_meta_box');

// This function tells WP to add a new "meta box"
function ignyte_provider_directory_language_meta_box() {
	add_meta_box(
		'ignyte_provider_directory_language_options', // id of the <div> we'll add
		'Language', //title
		'ignyte_provider_directory_language_contents', // callback function that will echo the box content
		'ignyte_provider', // where to add the box: on "post", "page", or "link" page
		'side',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_provider_directory_language_contents() {
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	$selected_locations=unserialize($meta["ignyte_language[]"]);
	//var_dump($meta);	
	echo '<input type="hidden" name="ignyte_provider_directory_language_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	$doclanguages=unserialize($meta['ignyte_language[]']); 
	?>
	<div class="input-group">
		<?php 
		$languageList=array("English","Spanish","Portuguese","Chinese","Filipino","French","Hindi","Marathi","Telugu","Japanese","German","Russian","Javanese", "Bengali", "Punjabi", "Malay", "Vietnamese", "Korean", "Urdu", "Turkish", "Italian", "Persian", "Polish", "Pashto","Farsi", "Arabic","Medical Spanish","Taiwanese","Mandarin","Tagalong");
		
		foreach($languageList as $thisLanguage){
			if(array_search($thisLanguage,$doclanguages)>-1)
				echo "<input type='checkbox' CHECKED name='ignyte_language[]' value='".$thisLanguage."'>".$thisLanguage."<br />";
			else
				echo "<input type='checkbox' name='ignyte_language[]' value='".$thisLanguage."'>".$thisLanguage."<br />";
		}
		
		
        ?>
        
	</div>
    
    <?php
}
// Hook things in, late enough so that add_meta_box() is defined
function ignyte_provider_directory_language_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_provider_directory_language_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$locationarray=$_POST["ignyte_language"];
	//var_dump($locationarray);
	$posts = get_posts(array('post_id' => $post_id));
	update_post_meta($post_id,'ignyte_language[]',$locationarray);


	
}
add_action( 'save_post', 'ignyte_provider_directory_language_save_post_data' );




/// DEFINE META BOX FOR Gender
if (is_admin())
	add_action('admin_menu', 'ignyte_provider_directory_gender_meta_box');

// This function tells WP to add a new "meta box"
function ignyte_provider_directory_gender_meta_box() {
	add_meta_box(
		'ignyte_provider_directory_gender_options', // id of the <div> we'll add
		'Gender', //title
		'ignyte_provider_directory_gender_contents', // callback function that will echo the box content
		'ignyte_provider', // where to add the box: on "post", "page", or "link" page
		'side',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_provider_directory_gender_contents() {
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	$selected_locations=unserialize($meta["ignyte_gender[]"]);
	//var_dump($meta);	
	echo '<input type="hidden" name="ignyte_provider_directory_gender_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	
	$docgender=unserialize($meta['ignyte_gender[]']); 
	?>
	<div class="input-group">
		<?php 
		if(array_search("Man",$docgender)>-1)
        	echo "<input type='checkbox' CHECKED name='ignyte_gender[]' value='Man'>Male<br />";
		else
			echo "<input type='checkbox' name='ignyte_gender[]' value='Man'>Male<br />";

		if(array_search("Female",$docgender)>-1)
			echo "<input type='checkbox' CHECKED name='ignyte_gender[]' value='Female'>Female<br />";
		else
        	echo "<input type='checkbox' name='ignyte_gender[]' value='Female'>Female<br />";
        ?>
	</div>
    
    <?php
}
// Hook things in, late enough so that add_meta_box() is defined
function ignyte_provider_directory_gender_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_provider_directory_gender_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$locationarray=$_POST["ignyte_gender"];
	//var_dump($locationarray);
	$posts = get_posts(array('post_id' => $post_id));
	update_post_meta($post_id,'ignyte_gender[]',$locationarray);


	
}
add_action( 'save_post', 'ignyte_provider_directory_gender_save_post_data' );





/// DEFINE META BOX FOR OPTIONS
if (is_admin())
	add_action('admin_menu', 'ignyte_provider_option_meta_box');

// This function tells WP to add a new "meta box"
function ignyte_provider_option_meta_box() {
	add_meta_box(
		'ignyte_provider_options', // id of the <div> we'll add
		'Provider Options', //title
		'ignyte_provider_box_contents', // callback function that will echo the box content
		'ignyte_provider', // where to add the box: on "post", "page", or "link" page
		'normal',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_provider_box_contents() {
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	//var_dump($meta);	
	echo '<input type="hidden" name="ignyte_provider_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
	?>
    <div class="input-group">
    <label for="ignyte-provider-displayed-name" ><?php _e( 'Displayed Name', 'ignyte' )?></label>
        <br/>
	<input style="width: 90%" type="text" name="ignyte-provider-displayed-name" id="ignyte-provider-displayed-name" value="<?php if ( isset ( $custom_fields['ignyte-provider-displayed-name'] ) ) echo $custom_fields['ignyte-provider-displayed-name'][0]; ?>" />
     </div>
    <br/>
    <div class="input-group">
    <label for="ignyte-provider-title" ><?php _e( 'Occupation', 'ignyte' )?></label><br/>
	<input  style="width: 90%" type="text" name="ignyte-provider-title" id="ignyte-provider-title" value="<?php if ( isset ( $custom_fields['ignyte-provider-title'] ) ) echo $custom_fields['ignyte-provider-title'][0]; ?>" />
     </div><br/>
    <div class="input-group">
    <label for="ignyte-provider-primary-service" ><?php _e( 'Provider Since', 'ignyte' )?></label> <br/>
	<input style="width: 90%"  type="text" name="ignyte-provider-since" id="ignyte-provider-since" value="<?php if ( isset ( $custom_fields['ignyte-provider-since'] ) ) echo $custom_fields['ignyte-provider-since'][0]; ?>" />
    </div>
    <br/>
    <div class="input-group">
    <label for="ignyte-provider-specialties" ><?php _e( 'Specialties (Comma Separated)', 'ignyte' )?></label>
        <br/>
	<textarea style="width:100%;height:100px;" type="text" name="ignyte-provider-specialties" id="ignyte-provider-specialties"><?php if ( isset ( $custom_fields['ignyte-provider-specialties'] ) ) echo $custom_fields['ignyte-provider-specialties'][0]; ?></textarea>
    </div>
    
    <br/>
    
	<div class="input-group">
	<label for="ignyte-provider-meta-image" ><?php _e( 'Post Image', 'ignyte' )?> (Image for the CTAs)</label>
	<input type="text" name="ignyte-provider-meta-image" id="ignyte-provider-meta-image" value="<?php if ( isset ( $custom_fields['ignyte-provider-meta-image'] ) ) echo $custom_fields['ignyte-provider-meta-image'][0]; ?>" />
	<input type="button" id="ignyte-provider-meta-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'ignyte' )?>" /><br />
    <img style=" <?=$custom_fields['ignyte-provider-meta-image'] ? '':'display:none;'?> height:200px;" id="ignyte-provider-meta-image-src" src="<?=$custom_fields['ignyte-provider-meta-image'][0]?>" />
	</div>
    
    
    
    <script>
		jQuery(document).ready(function($){
			var custom_uploader;
			$('#ignyte-provider-meta-image-button').click(function(e) {
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
					$('#ignyte-provider-meta-image').val(attachment.url);
					$('#ignyte-provider-meta-image-src').attr("src",attachment.url);
					$('#ignyte-provider-meta-image-src').toggle();
				});
				//Open the uploader dialog
				custom_uploader.open();
			});
		});
    </script>
    
    <?php
}
// Hook things in, late enough so that add_meta_box() is defined
function ignyte_provider_option_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_provider_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
  $post_meta_array=array( "ignyte-provider-displayed-name","ignyte-provider-title","ignyte-provider-since","ignyte-provider-meta-image","ignyte-provider-specialties"  );
	foreach($post_meta_array as $post_this_meta) {
		$posts = get_posts(array(
			'post_id' => $post_id
		));
		//echo $post_id,'recipes_'.$post_this_meta,$_POST['recipes_'.$post_this_meta]."<br>";
		update_post_meta($post_id,$post_this_meta,$_POST[$post_this_meta]);
	}

	
}
add_action( 'save_post', 'ignyte_provider_option_save_post_data' );
