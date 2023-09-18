<?php
add_shortcode('awards', 'ignyte_awards_shortcode');
function ignyte_awards_shortcode( $atts ) {
	
	$template_file = get_page_template_slug();
	/* if using atts */
	extract( shortcode_atts( array(
		'number_posts' => '3',
		'h2title' =>'Awards',
		'id' =>'',
		'subnav_title' =>'',
		'close_container' => '',
	), $atts ) );
	$args = array(
	'posts_per_page'     => $number_posts,
	'orderby'         => 'rand',
	'post_type'       => 'ignyte_awards',
	'post_status'     => 'publish');
	$post = get_posts($args);
	$return="<ul>";
	foreach ($post as $p) {
		/*$title = apply_filters('the_title', $p->post_title);*/
		$meta_values = get_post_meta($p->ID);
		$thumbnail =  wp_get_attachment_image_src( get_post_thumbnail_id($p->ID) ,'medium');
		if($meta_values["ignyte_award_link"][0]<>"")
			$image= " <li><div class='aw-table'><div class='table-cell external'><a target=_blank href='".$meta_values["ignyte_award_link"][0]."'><img src='".$thumbnail[0]."' /></a></div></div></li>";
		else
			$image= " <li><div class='aw-table'><div class='table-cell'><img src='".$thumbnail[0]."' /></div></div></li>";
		$return.=$image;
	}

	$return.="</ul>";
	if ($close_container<>"" && $close_container<>"no"){ 
           $addbefore= "</div></div></div>";
		   $addafter='<div class="container"><div class="row">';
			if (strstr($template_file, 'page-fullwidth')){ 
			  $addafter.='<div class="col-xs-12 col-sm-12">';	
			 } else {
              $addafter.='<div class="col-xs-12 col-sm-8">';
             } 
	}
	if ($id<>"" && $subnav_title<>""){
		return $addbefore."<div id='subnav_".$id."' class='awardlist Ignyte_subNavItem'><div class='menutitle' style='display:none;'>".$subnav_title."</div><div class='container'><h2 class='alpha'>".$h2title."</h2>".$return."</div></div>".$addafter;
	}else{
		return $addbefore."<div class='awardlist'><div class='container'><h2 class='alpha'>".$h2title."</h2>".$return."</div></div>".$addafter;
	}
}


/***Meta box for slider***/
/** Show meta box for slider options: */
if (is_admin())
	add_action('admin_menu', 'ignyte_award_meta_box');
	
// This function tells WP to add a new "meta box"
function ignyte_award_meta_box() {
	add_meta_box(
		'ignyte_award_options', // id of the <div> we'll add
		'Award Options', //title
		'ignyte_award_box_contents', // callback function that will echo the box content
		'ignyte_awards', // where to add the box: on "post", "page", or "link" page
		'side',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_award_box_contents() {
	
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	//var_dump($meta);	
	echo '<input type="hidden" name="ignyte_award_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

	echo 'url to link to : <input type="text" name="ignyte_award_link" id="ignyte_award_link" value="'.$meta["ignyte_award_link"].'"/>';

}
// Hook things in, late enough so that add_meta_box() is defined
function ignyte_award_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_award_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$post_meta_array=array( "ignyte_award_link" );
	foreach($post_meta_array as $post_this_meta) {
		$posts = get_posts(array(
			'post_id' => $post_id
		));
		//echo $post_id,'recipes_'.$post_this_meta,$_POST['recipes_'.$post_this_meta]."<br>";
		update_post_meta($post_id,$post_this_meta,$_POST[$post_this_meta]);
	}
}
add_action( 'save_post', 'ignyte_award_save_post_data' );
