<?php
function check_user_agent ( $type = NULL ) {
	$user_agent = strtolower ( $_SERVER['HTTP_USER_AGENT'] );
	if ( $type == 'bot' ) {
			// matches popular bots AND IE7
			if ( preg_match ( "/googlebot|adsbot|yahooseeker|yahoobot|msnbot|watchmouse|pingdom\.com|feedfetcher-google/", $user_agent ) ) {
					return true;
					// watchmouse|pingdom\.com are "uptime services"
			}
	} else if ( $type == 'browser' ) {
			// matches core browser types
			if ( preg_match ( "/mozilla\/|opera\//", $user_agent ) ) {
					return true;
			}
	} else if ( $type == 'mobile' ) {
			// matches popular mobile devices that have small screens and/or touch inputs
			// mobile devices have regional trends; some of these will have varying popularity in Europe, Asia, and America
			// detailed demographics are unknown, and South America, the Pacific Islands, and Africa trends might not be represented, here
			if ( preg_match ( "/phone|iphone|itouch|ipod|symbian|android|htc_|htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|^sie-|nintendo/", $user_agent ) ) {
					// these are the most common
					return true;
			} else if ( preg_match ( "/mobile|pda;|avantgo|eudoraweb|minimo|netfront|brew|teleca|lg;|lge |wap;| wap /", $user_agent ) ) {
					// these are less common, and might not be worth checking
					return true;
			}
	}
	return false;
}


/** Customize certain page template with meta box: 
$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
  // check for a template type
  if ($template_file == 'special-page.php') {
    add_meta_box("faq_meta", "FAQ Options", "faq_meta", "page", "normal", "low");
  }
  */
  
  
  
//PDF FUNCTIONS FOR CATEGORY PRESS RELEASES
  
add_action("admin_init", "pdf_init");
add_action('save_post', 'save_pdf_link');
function pdf_init(){
        add_meta_box("my-pdf-en", "English PDF Document", "pdf_link_en", "post", "normal", "low");
		add_meta_box("my-pdf-es", "Spanish PDF Document", "pdf_link_es", "post", "normal", "low");
        }
function pdf_link_en(){
        global $post;
        $custom  = get_post_custom($post->ID);
        $link    = $custom["pdf_en"][0];
        $count   = 0;
        ?><div class="link_header"><?
        $query_pdf_args = array(
                'post_type' => 'attachment',
                'post_mime_type' =>'application/pdf',
                'post_status' => 'inherit',
                'posts_per_page' => -1,
                );
        $query_pdf = new WP_Query( $query_pdf_args );
        $pdf = array();
        ?><select name="pdf_en">
        <option class="pdf_select" value="">SELECT pdf FILE</option>
        <? foreach ( $query_pdf->posts as $file) {
           if($link == $pdf[]= $file->guid){
              echo '<option value="'.$pdf[]= $file->guid.'" selected="true">'.$pdf[]= $file->guid.'</option>';
                 }else{
              echo '<option value="'.$pdf[]= $file->guid.'">'.$pdf[]= $file->guid.'</option>';
                 }
                $count++;
        }?>
        </select><br /></div>
        <p>Selecting a pdf file from the above list to attach to this post.</p>
        <div class="pdf_count"><span>Files:</span> <b><?=$count?></b></div>
		<script type="text/javascript">
		//<![CDATA[
			jQuery(function($)
			{
				function my_check_categories()
				{
					$('#my-pdf-en').hide();
		 
					$('#categorychecklist input[type="checkbox"]').each(function(i,e)
					{
						var id = $(this).attr('id').match(/-([0-9]*)$/i);
		 
						id = (id && id[1]) ? parseInt(id[1]) : null ;
		 
						if ($.inArray(id, [26,155]) > -1 && $(this).is(':checked'))
						{
							$('#my-pdf-en').show();
						}
					});
				}
				$('#categorychecklist input[type="checkbox"]').live('click', my_check_categories);
				my_check_categories();
			});
		 
		//]]>
		</script><?
}
function pdf_link_es(){
        global $post;
        $custom  = get_post_custom($post->ID);
        $link    = $custom["pdf_es"][0];
        $count   = 0;
        ?><div class="link_header"><?
        $query_pdf_args = array(
                'post_type' => 'attachment',
                'post_mime_type' =>'application/pdf',
                'post_status' => 'inherit',
                'posts_per_page' => -1,
                );
        $query_pdf = new WP_Query( $query_pdf_args );
        $pdf = array();
        ?><select name="pdf_es">
        <option class="pdf_select" value="">SELECT pdf FILE</option>
        <? foreach ( $query_pdf->posts as $file) {
           if($link == $pdf[]= $file->guid){
              echo '<option value="'.$pdf[]= $file->guid.'" selected="true">'.$pdf[]= $file->guid.'</option>';
                 }else{
              echo '<option value="'.$pdf[]= $file->guid.'">'.$pdf[]= $file->guid.'</option>';
                 }
                $count++;
        }?>
        </select><br /></div>
        <p>Selecting a pdf file from the above list to attach to this post.</p>
        <div class="pdf_count"><span>Files:</span> <b><?=$count?></b></div>
		<script type="text/javascript">
		//<![CDATA[
			jQuery(function($)
			{
				function my_check_categories()
				{
					$('#my-pdf-es').hide();
		 
					$('#categorychecklist input[type="checkbox"]').each(function(i,e)
					{
						var id = $(this).attr('id').match(/-([0-9]*)$/i);
		 
						id = (id && id[1]) ? parseInt(id[1]) : null ;
		 
						if ($.inArray(id, [26,155]) > -1 && $(this).is(':checked'))
						{
							$('#my-pdf-es').show();
						}
					});
				}
				$('#categorychecklist input[type="checkbox"]').live('click', my_check_categories);
				my_check_categories();
			});
		 
		//]]>
		</script>
		<?
}

function save_pdf_link(){
        global $post;
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){ return $post->ID; }
        update_post_meta($post->ID, "pdf_en", $_POST["pdf_en"]);
		update_post_meta($post->ID, "pdf_es", $_POST["pdf_es"]);
}


add_action( 'admin_head', 'pdf_css' );
function pdf_css() {
        echo '<style type="text/css">
        .pdf_select{
                font-weight:bold;
                background:#e5e5e5;
                }
        .pdf_count{
                font-size:9px;
                color:#0066ff;
                text-transform:uppercase;
                background:#f3f3f3;
                border-top:solid 1px #e5e5e5;
                padding:6px 6px 6px 12px;
                margin:0px -6px -8px -6px;
                -moz-border-radius:0px 0px 6px 6px;
                -webkit-border-radius:0px 0px 6px 6px;
                border-radius:0px 0px 6px 6px;
                }
        .pdf_count span{color:#666;}
                </style>';
}
function pdf_file_url_en($id){
        global $wp_query;
        $custom = get_post_custom($id);
        return $custom['pdf_en'][0];
}
function pdf_file_url_es($id){
        global $wp_query;
        $custom = get_post_custom($id);
        return $custom['pdf_es'][0];
}
  
  
 
 
 
 
 
 
 

 
add_filter( 'post_gallery', 'my_post_gallery', 10, 2 );
function my_post_gallery( $output, $attr) {
    global $post, $wp_locale;

    static $instance = 0;
    $instance++;

    // We're trusting author input, so let's at least make sure it looks like a valid orderby statement
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
            unset( $attr['orderby'] );
    }

    extract(shortcode_atts(array(
        'order'      => 'ASC',
        'orderby'    => 'menu_order ID',
        'id'         => $post->ID,
        'itemtag'    => 'dl',
        'icontag'    => 'dt',
        'captiontag' => 'dd',
        'columns'    => 3,
        'size'       => 'thumbnail',
        'include'    => '',
        'exclude'    => ''
    ), $attr));

    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';

    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }

    if ( empty($attachments) )
        return '';

    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }

    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';

    $selector = "gallery-{$instance}";

    $output = apply_filters('gallery_style', "
        <style type='text/css'>
            #{$selector} {
                margin: auto;
            }
            #{$selector} .gallery-item {
                float: {$float};
                margin-top: 10px;
                text-align: center;
                width: {$itemwidth}%;           }
            #{$selector} img {
                border: 2px solid #cfcfcf;
            }
            #{$selector} .gallery-caption {
                margin-left: 0;
            }
        </style>
        <!-- see gallery_shortcode() in wp-includes/media.php -->
        <div id='$selector' class='gallery galleryid-{$id}'>");

    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
		$smallsizeurl = wp_get_attachment_image_src( $id ,'thumbnail');
		$fullsizeurl = wp_get_attachment_image_src( $id ,'full');
		$link = "<a href='".$fullsizeurl[0]."' class='gallery_view' data-image-url='".$fullsizeurl[0]."'><img width='150' height='150' src='".$smallsizeurl[0]."'></a>";
		
		//var_dump($biglink);
        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "
            <{$icontag} class='gallery-icon' >
                $link
            </{$icontag}>";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "
                <{$captiontag} class='gallery-caption'>
                " . wptexturize($attachment->post_excerpt) . "
                </{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
        if ( $columns > 0 && ++$i % $columns == 0 )
            $output .= '<br style="clear: both" />';
    }

    $output .= "
            <br style='clear: both;' />
        </div>\n";
		
	$output .= '<div id="gallery_image_mod" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
				<div class="modal-dialog modal-image-size">
				<div class="modal-content ">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
				<img id="gallery_image_mod_img" src="">
				</div>
				</div>
				</div>
				</div>
				<script>
				jQuery(".gallery_view").click(function(event) {
					if(jQuery(window).width()>767){
						event.preventDefault();	
						jQuery("#gallery_image_mod").modal("show");
						jQuery("#gallery_image_mod_img").attr("src", jQuery(this).attr("href"));
					}else{
						
					}
				});
				</script>';

    return $output;
}

 
	
	