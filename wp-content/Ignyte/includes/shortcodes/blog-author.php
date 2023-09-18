<?php

/**** BLOG POST AUTHOR ****/
add_shortcode('print_blog_author', 'print_blog_author');
function print_blog_author($atts, $content ){

		extract( shortcode_atts( array(
		'name' => '',
		'image' => '',
		'title' => ''
		), $atts ) );
		
		$authorid=get_the_author_meta( 'ID' );
		if($name=="")
			$name=get_the_author();
		if($image=="")
			$image=get_cupp_meta($authorid,"thumbnail");
		if($image=="")
			$image="/wp-content/uploads/2016/10/logo-1.png";
		if($title==""){
			$title="";
		}else{
			//$title="<span class='author-title'> ".$title."</span>";
		}
    $userdata = get_user_meta($authorid);

		$return='  <div class="row client">
                                                <div class="client-image" style="background-image:url('.$image.')"></div>
                                                <div class="posted-by">
                                                    <span class="small red">WRITTEN BY</span>
                                                    <h5>'.$userdata['first_name'][0].' '.$userdata['last_name'][0].'</h5>
                                                    <h6 class="uppercase">'.$userdata['description'][0].'</h6>
                                                </div>
                                            </div>';
		return $return;
}

?>