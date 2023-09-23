<?php
ob_start();
function create_location_custom_post_type() {
	$labels = array(
		'name' => _x('Locations', 'post type general name'),
		'singular_name' => _x('Location', 'post type singular name'),
		'add_new' => _x('Add New', 'Location'),
		'add_new_item' => __('Add New Location'),
		'edit_item' => __('Edit Location'),
		'new_item' => __('New Location'),
		'view_item' => __('View Location'),
		'search_items' => __('Search Locations'),
		'not_found' =>  __('No Locations found'),
		'not_found_in_trash' => __('No Locations found in Trash'),
		'parent_item_colon' => '',
		'menu_name' => 'Locations'
	);

	register_post_type( 'ignyte_locations', array(
		'labels' => $labels,
		'capability_type' => 'page',
		'has_archive' => true,
		'hierarchical' => false,
		'query_var' => true,
		'public' => true,
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'rewrite' => array(
			'slug' => 'locations-list',
			'with_front' => true
		),
		'supports' => array(
			'title',
			'thumbnail',
			//'editor'
		),
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'menu_position' => 6
	));

}

add_action( 'init', 'create_location_custom_post_type', 0 );

function ignyte_locations_category_add_taxonomies() {
    register_taxonomy(
        'ignyte_locations_category',
        'ignyte_locations',
        array(
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'label' => __( 'Category' ),
            'rewrite' => array( 'slug' => 'ignyte_locations_category' ),
            'hierarchical' => true,
        )
    );
}
add_action( 'init', 'ignyte_locations_category_add_taxonomies' );

/// DEFINE META BOX
if (is_admin())
	add_action('admin_menu', 'ignyte_location_meta_box');

// This function tells WP to add a new "meta box"
function ignyte_location_meta_box() {
	add_meta_box(
		'ignyte_location_options', // id of the <div> we'll add
		'Location Options', //title
		'ignyte_location_box_contents', // callback function that will echo the box content
		'ignyte_locations', // where to add the box: on "post", "page", or "link" page
		'normal',										// placement on add/edit page
		'high'											// priority on add/edit page
	);
}
// This function echoes the content of our meta box
function ignyte_location_box_contents() {
	if($_GET['post']) {
		$custom_fields = get_post_custom($_GET['post']);
		foreach ( $custom_fields as $key => $value ) {
			$meta[$key] = $value[0];
		}
	}
	//var_dump($meta);
	echo '<input type="hidden" name="ignyte_location_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

	// Address
//	echo '<div class="input-group"><span class="input-group-addon">Address:</span>';
	echo '<input type="hidden" class="form-control" name="ignyte_location_address" id="ignyte_location_address" value="'.$meta["ignyte_location_address"].'" size="120"/>';
	//echo '</div>';
	?>

    <style>
        .main-sub-heading { color: #939393; font-size: 17px;
            font-weight: normal; padding-bottom:5px; }
        #ignyte_project_options .ui-sortable-handle { font-size: 19px;}
        #ignyte_project_options .sub-title {font-size: 13px;
            font-weight: 600;padding-bottom:5px; }
        .area12{
            height: 150px;
            padding: 10px;
            border: 2px solid #ddd;
        }
        .fulldata
        {
            width:90%;
            height: 200px;
            padding: 10px;
            border: 2px solid #ddd;
        }
        .delbut
        {
            background: red !important;
        }
        .main-div
        {
            float: left;
            width: 100%;
        }
        .main-div-left
        {
            float: left;
            width: 50%;
        }
        .desc
        {
            height: 55px !important;
        }
        .area1
        {
            height: 30px !important;
        }
        .area11
        {
            height: 160px !important;
        }
        #delk
        {
            padding: 14px;
        }
    </style>
    <div class="input-group"><span class="input-group-addon">Offering Type: </span>
        <?php
        $oftype='Full-Service';
        if($meta["offering-type"]!="") {
            $oftype=$meta["offering-type"];
        }?>
        <input type="radio" name="offering-type" value="Specialty" <?php if($oftype=='Specialty') { ?> checked="checked" <?php } ?>> Specialty
        <input type="radio" name="offering-type" value="Full-Service" <?php if($oftype=='Full-Service') { ?> checked="checked" <?php } ?>> Full Service
    </div><br/>
    <?php
	// Phone
	echo '<div class="input-group"><span class="input-group-addon">Long Name:</span><br/>';
	echo '<input class="form-control" name="ignyte_location_longname" id="ignyte_location_longname" value="'.$meta["ignyte_location_longname"].'" size="50"/>';
	echo '</div><br/>';
?>
   <div class="input-group"><span class="input-group-addon">Open at:</span><br/>
   </div><br/>
    <style>
        .main-table
        {
            width: 100%;
            font-size: 10px;
        }
        .main-table td
        {
            width: 14.28%;
        }
        .heading
        {
            background: lightgrey;
        }
        .timedate
        {
            width: 90%;
        }
    </style>
    <script>
        jQuery(document).ready(function($)
        {
             jQuery("body").hasClass("meta-box-sortables")
             {
             jQuery('.meta-box-sortables1 ,.meta-box-sortables2 , .meta-box-sortables13').sortable({
             opacity: 0.6,
             revert: true,
             cursor: 'move',
             handle: '.hndle'
             });
             }


        });
    </script>
    <table class="main-table" border="1">
        <tr class="heading">
            <td>Monday</td>
            <td>Tuesday</td>
            <td>Wednesday</td>
            <td>Thursday</td>
            <td>Friday</td>
            <td>Saturday</td>
            <td>Sunday</td>
        </tr>
        <tr>
            <?php for ($x = 1; $x <= 7; $x++) {

            ?>
            <td>
               <input type="checkbox" value="1" name="enableday<?php echo $x; ?>" <?php if($meta["enableday".$x]==1) { ?> checked="checked" <?php } ?>> Avilable <br/>
                <span>Open At (Ex- 7AM)</span> <br/>
                <input type="text" class="timedate" name="open<?php echo $x; ?>" value="<?php echo $meta["open".$x]; ?>" ><br/>
                <span>Close At (Ex- 8PM)</span> <br/>
                <input type="text" name="close<?php echo $x; ?>" class="timedate" value="<?php echo $meta["close".$x]; ?>" >
                <span>Lunch Time</span> <br/>
                <input type="text" name="lunch<?php echo $x; ?>" class="timedate" value="<?php echo $meta["lunch".$x]; ?>" >
              <br/>
                <span>Hide/show closed days?</span> <br/>
                <select name='hideshow<?php echo $x; ?>' class='timedate' >
                    <option value='1' <?php if($meta["hideshow".$x]==1) { ?> selected="selected" <?php } ?>>Show This Day</option>
                    <option value='2' <?php if($meta["hideshow".$x]==2) { ?> selected="selected" <?php } ?>>Hide This Day</option>
                </select>
            </td>
<?php } ?>
        </tr>
    </table> <br/>
<?php
    echo '<div class="input-group"><span class="input-group-addon">Description:</span><br/>';
    echo ' <textarea  rows="1" cols="40" style="width:80%" name="ignyte_location_description" class="area11" />'.$meta["ignyte_location_description"].'</textarea>';
    echo '</div><br/>';



    echo '<div class="input-group"><span class="input-group-addon">Phone No 1st:</span><br/>';
    echo '<input class="form-control" name="ignyte_location_phone1_label" placeholder ="1st Mobile Label" id="ignyte_location_phone1_label" value="'.$meta["ignyte_location_phone1_label"].'" size="30"/> ';

    echo ' <input class="form-control" name="ignyte_location_phone"  placeholder="1st Mobile Number" id="ignyte_location_phone" value="'.$meta["ignyte_location_phone"].'" size="30"/>';
    echo '</div><br/>';

    echo '<div class="input-group"><span class="input-group-addon">Phone No 2nd:</span><br/>';
    echo '<input class="form-control" name="ignyte_location_phone2_label" placeholder ="2nd Mobile Label" id="ignyte_location_phone2_label" value="'.$meta["ignyte_location_phone2_label"].'" size="30"/> ';

    echo ' <input class="form-control" name="ignyte_location_phone2"  placeholder="2nd Mobile Number" id="ignyte_location_phone2" value="'.$meta["ignyte_location_phone2"].'" size="30"/>';
    echo '</div><br/>';

/*
    echo '<div class="input-group"><span class="input-group-addon">ZipCode:</span><br/>';
    echo '<input class="form-control" name="ignyte_location_zip" id="ignyte_location_zip" value="'.$meta["ignyte_location_zip"].'" size="50"/>';
    echo '</div><br/><br/>';
*/
?>

    <div class="input-group"><span class="input-group-addon">Add Day/Date:</span><br/></div>
<div class="alltabcontent">
    <div class="sticky-tab">
        <span id="agendaday" class="button-primary content-agends" >Add Label/Description </span>
        <span id="agendaimedescription" class="button-primary content-agends" >Add Hours </span>
    </div>

    <div class="mainagenda" style="background:lightgrey; padding: 10px;margin-top: 10px ">
        <?php  // Start media from there
        $mediadata=$custom_fields['ignyte_project_media'][0];
        $data1=explode('~',$mediadata);
        //print_r($mediadata);?>
        <div class="frm_i imgupload-contain agentContent ">
            <input type="hidden" class="modi" value="0" />
            <input type="hidden" class="chk_fld" value="<?php echo '1'; ?>" />
            <input type="hidden" class="title_i" value="<?php echo '1' ?>" />
            <div class="img-up-row meta-box-sortables13 ui-sortable">

                <?php


$i_set=1;
                $i_set2=1;
                foreach($data1 as $d)
                {
                    $dat23=explode('==',$d);
                    $dat2=explode('|',$dat23[0]);

                    if($dat2[0]=="ignyte_project_media_date") {

                        ?>
                        <div id="delk" class="frm_field img-upload-box postbox" style="width: 100%;" >
                            <div class="container hndle">
                                <div class="close1 dashicons dashicons-minus" id="agentContent"></div>

                                <input type="hidden"   name="mediadata[]" value="ignyte_project_media_date"/>

                                <p>
                                    <textarea  rows="1" cols="40" style="width:80%" placeholder="Date Label" name="mediadata[]" class="area1" /><?php if(!empty($dat2[1])) echo esc_attr($dat2[1]); ?></textarea>
                                    <textarea  rows="5" cols="40" style="width:80%" placeholder="Date/Date" name="mediadata[]" class="area11" /><?php if(!empty($dat2[2])) echo esc_attr($dat2[2]); ?></textarea>
                                </p>

                                <div class="clearfix"></div>
                            </div>
                        </div>
                    <?php }

                    if($dat2[0]=="ignyte_project_media_st") {


                        $datsubcatlist=explode('hinit33',$d);
                        $datsubcatlist2=explode('hinit',$datsubcatlist[1]);
                         ?>
                        <div id="delk" class="frm_field img-upload-box postbox" style="width: 100%;" >
                            <div class="container hndle">
                                <div class="close1 dashicons dashicons-minus" id="agentContent"></div>
                                <!--<div class="moree dashicons dashicons-plus content-with-image-agenda"></div>-->
                                <input type="hidden"   name="mediadata[]" value="ignyte_project_media_st"/>

           <p> <textarea  rows="1" cols="40" style="width:80%" placeholder="Date Label" name="mediadata[]" class="area1" /><?php echo esc_attr($dat2[1]); ?></textarea>
</p>
                              <p>

                                  <?php  $headerdata="";
                                  $inner="";
                                  foreach($datsubcatlist2 as $datainner)
                                  {
                                      $dat223=explode('|',$datainner);
                                      if($dat223[1]!='')
                                      {

                                          $checkedfirst="";
                                          $checked2nd="";
                                          if($dat223[5]==1) {
                                              $checkedfirst = "selected='selected'";
                                          }
                                          if($dat223[5]==2) {
                                              $checked2nd="selected='selected'";
                                          }

                                          $headerdata.="<td>".$dat223[1]."</td>";
                                      $inner .="<td><input type='hidden'  name='mediadata[]' value='hinit'>
              <input type='hidden' value='".$dat223[1]."' name='mediadata[]'>
                <input type='text' class='timedate' placeholder='Open At (Ex- 7AM)' name='mediadata[]' value='".$dat223[2]."'><br/>
                   <input type='text' class='timedate' placeholder='Close At (Ex- 8PM) ' name='mediadata[]' value='".$dat223[3]."'><br/>
                    <input type='text' class='timedate' placeholder='Lunch Time' name='mediadata[]' value='".$dat223[4]."'><br/>
                   <select name='mediadata[]' class='timedate'>
                    <option value='1' ".$checkedfirst." >Show This Day</option>
                     <option value='2' ".$checked2nd.">Hide This Day</option>
                   </select>
</td>";
                                      }

                                  }
                                  ?>
                                  <input type='hidden'  name='mediadata[]' value='hinit33'>

                                <table class="main-table" border="1"> <tr class="heading"><?php echo $headerdata; ?></tr><tr><?php echo $inner; ?></tr></table>
                              </p>

                            </div>
                        </div>
                    <?php }
                    $i_set++; ?>
                <?php } ?>
            </div>
            <input class="page_id" type="hidden" name="page_id" value="<?php // echo ($post->ID)+1000; ?>" id="page_id"/>
            <input type="hidden" name="total" value="<?php echo $i_set-1; ?>" class="field12"/>
            <input type="hidden" name="totalsub" value="<?php echo $i_set2-1; ?>" class="field12-sub"/>
        </div>
    </div>
</div>

    <style>
        .alltabcontent {
            border: 2px dashed rgba(114, 186, 94, 0.35);
            height: auto;
        }
        .sticky-tab {
            position: -webkit-sticky;
            position: sticky;
            top: 30px;
            z-index: 99999;
            background-color: gray;
            padding: 5px;
        }
        .mediaContent .fImg
        {
            background: gray !important;
            height: 100% !important;
            width: 100% !important;

        }
        .mediaContent .hndle
        {
            min-height: 150px;
        }
        .mainagenda
        {
            height: auto;
        }
    </style>

    <?php

}


add_action('admin_menu', 'ignyte_event_travel_description');
// This function tells WP to add a new "meta box"
function ignyte_event_travel_description() {
    add_meta_box(
        'ignyte_market_travel', // id of the <div> we'll add
        'Travel Google Map Detail', //title
        'ignyte_location_map', // callback function that will echo the box content
        'ignyte_locations', // where to add the box: on "post", "page", or "link" page
        'normal',										// placement on add/edit page
        'high'											// priority on add/edit page
    );
}
function ignyte_location_map()
{
    if ($_GET['post']) {
        $custom_fields = get_post_custom($_GET['post']);
    }
    ?>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD8j2K9aAc3sHRdKF91-JrUhoChlqHWKgI&sensor=false"></script> -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDAjm-EM7YIQirNQgJTchMW4c1ns3-49nU"></script>
    <style>
        .main-sub-heading { color: #939393; font-size: 17px;
            font-weight: normal; padding-bottom:5px; }
        #ignyte_project_options .ui-sortable-handle { font-size: 19px;}
        #ignyte_project_options .sub-title {font-size: 13px;
            font-weight: 600;padding-bottom:5px; }
        .area12{
            height: 150px;
            padding: 10px;
            border: 2px solid #ddd;
        }
        .fulldata
        {
            width:90%;
            height: 200px;
            padding: 10px;
            border: 2px solid #ddd;
        }
        .delbut
        {
            background: red !important;
        }

    </style>

    <?php $gllpLatitude=40.7127753;
    $gllpLongitude=-74.0059728;
    $gllpZoom=8;
    $gllpLocationName="";
    $searchLocation="";
    if($custom_fields['gllpLatitude'][0])
    {
        $gllpLatitude=$custom_fields['gllpLatitude'][0];
    }
    if($custom_fields['gllpLongitude'][0])
    {
        $gllpLongitude=$custom_fields['gllpLongitude'][0];
    }
    if($custom_fields['gllpZoom'][0])
    {
        $gllpZoom=$custom_fields['gllpZoom'][0];
    }
    if($custom_fields['gllpLocationName'][0])
    {
        $gllpLocationName=$custom_fields['gllpLocationName'][0];
        $searchLocation=$custom_fields['gllpLocationName'][0];
    }
    ?>
    <fieldset class="gllpLatlonPicker" style="width: 100%">
        <input type="text" class="gllpSearchField" name="searchLocation" value="<?php //echo $searchLocation; ?>" size="40">
        <input type="button" class="gllpSearchButton" value="search">
        <br/>
        <br/>
        <div class="gllpMap">Google Maps</div>
<br/>
        <br/>
        Accurate Location: <input type="text" class="gllpLocationName" style="width: 90%" name="gllpLocationName" value="<?php echo $gllpLocationName; ?>" ><br/><br/>
        Latitude: <input type="text" class="gllpLatitude" name="gllpLatitude" value="<?php echo $gllpLatitude; ?>"/>
        Longitude <input type="text" class="gllpLongitude" name="gllpLongitude" value="<?php echo $gllpLongitude; ?>">
        <input type="hidden" class="gllpZoom" name="gllpZoom" value="<?php echo $gllpZoom; ?>">
        <input type="hidden" class="gllpElevation" size=12/>
    </fieldset>
    <br/>
    <div class="input-group"><span class="input-group-addon">Override Address:</span><br/>
        <textarea style="width: 60%; height: 100px" name="address2nd"><?php echo $custom_fields['address2nd'][0]; ?></textarea>
  </div>

    <br>

<?php   }

// Hook things in, late enough so that add_meta_box() is defined
function ignyte_location_save_post_data($post_id){
	if ( !wp_verify_nonce( $_POST['ignyte_location_box_nonce'], basename( __FILE__ ) ) ) {
		return;
	}
	if ( !current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$post_meta_array=array('ignyte_project_media','ignyte_location_phone2_label','ignyte_location_phone2','address2nd','ignyte_location_open_at','ignyte_location_description','offering-type','ignyte_location_longname','ignyte_location_address','ignyte_location_phone1_label','ignyte_location_phone','gllpLatitude','gllpLongitude',"gllpZoom",'gllpLocationName'
    ,'enableday1','open1','close1','lunch1','hideshow1','enableday2','open2','close2','lunch2','hideshow2','enableday3','open3','close3','lunch3','hideshow3','enableday4','open4','close4','lunch4','hideshow4','enableday5','open5','close5','lunch5','hideshow5','enableday6','open6','close6','lunch6','hideshow6',
    'enableday7','open7','close7','lunch7','hideshow7');

	foreach($post_meta_array as $post_this_meta) {
		$posts = get_posts(array(
			'post_id' => $post_id
		));
        if($post_this_meta=='ignyte_project_media')
        {
            $totalField='';
            $count=0;

            foreach(@$_POST['mediadata'] as $imgDes)
            {    $icon='';
                //if($imgDes!='')
                //  {
                if($count>0){
                    if($imgDes=="ignyte_project_media_st" or $imgDes=="ignyte_project_media_date" ) {
                        $icon='~';
                    }
                    else
                    {
                        $icon='|';
                    }
                }

                $imgDesFinel=checkSpecielIcon($imgDes);
                $totalField .=$icon.$imgDesFinel;

                $count++;

                //}
            }
            update_post_meta($post_id,$post_this_meta,$totalField);
        }
         else if($post_this_meta=='ignyte_location_address')
        {
            $totalField=$_POST['gllpLocationName'];
            update_post_meta($post_id,$post_this_meta,$totalField);
        }
        else {
            //echo $post_id,'recipes_'.$post_this_meta,$_POST['recipes_'.$post_this_meta]."<br>";
            update_post_meta($post_id, $post_this_meta, $_POST[$post_this_meta]);
        }
	}
}
add_action( 'save_post', 'ignyte_location_save_post_data' );

function checkSpecielIcon($data)
{
    $result=str_replace("|","&#124;",$data);
    $result=str_replace("~","&#126;",$result);
    return $result;
}
function map_cssjs() {

    // wp_register_script( 'googleapis', plugin_dir_url( __FILE__ ) . 'js/DAMIU_script.js', array( 'jquery' ));
    wp_enqueue_style ( 'query-gmaps-latlon-css', plugins_url( 'css/jquery-gmaps-latlon-picker.css', __FILE__ ), array());
    //Custom Editor
    wp_register_script('query-gmaps-latlon', plugin_dir_url( __FILE__ ) . 'js/jquery-gmaps-latlon-picker.js', array( 'jquery' ));

    // wp_enqueue_script('googleapis' );
    wp_enqueue_script('query-gmaps-latlon');
}
add_action( 'admin_enqueue_scripts', 'map_cssjs' );

function multuple_image() {

    wp_register_script( 'dmiu_script', plugin_dir_url( __FILE__ ) . 'js/DAMIU_script.js', array( 'jquery' ));
    wp_enqueue_style ( 'dmiu_style', plugins_url( 'js/plugin-style.css', __FILE__ ), array());
    //Custom Editor
    //End Custom Editor
    wp_localize_script(
        'dmiu_script',
        'WP_SPECIFIC',
        array(
            'upload_url' => '',
            'metabox_title' => '',
            'mediaSelector_title' =>'select your image',
            'mediaSelector_buttonText' =>'upload'
        )
    );
    wp_enqueue_script('dmiu_script' );

}
add_action( 'admin_enqueue_scripts', 'multuple_image' );




function ignyte_image_enqueue2() {
    global $typenow;
    if( $typenow == 'ignyte_locations' ) {
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
add_action( 'admin_enqueue_scripts', 'ignyte_image_enqueue2' );

add_action('admin_menu', 'ignyte_location_fallback_meta_box');

// This function tells WP to add a new "meta box"
function ignyte_location_fallback_meta_box() {
    add_meta_box(
        'ignyte_location_fallback_options', // id of the <div> we'll add
        'Small Map Image', //title
        'ignyte_location_fallback_meta_box_contents', // callback function that will echo the box content
        'ignyte_locations', // where to add the box: on "post", "page", or "link" page
        'side',										// placement on add/edit page
        'high'											// priority on add/edit page
    );
}
// This function echoes the content of our meta box
function ignyte_location_fallback_meta_box_contents() {
    if($_GET['post']) {
        $custom_fields = get_post_custom($_GET['post']);
        foreach ( $custom_fields as $key => $value ) {
            $meta[$key] = $value[0];
        }
    }
    //var_dump($meta);
    echo '<input type="hidden" name="ignyte_location_fallback_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    ?>
    <div class="input-group">
        <img style=" width:100%" id="ignyte-service-fallback-image-src" src="<?=$custom_fields['ignyte-service-fallback-image'][0]?>" /><br>
        <input type="hidden" name="ignyte-service-fallback-image" id="ignyte-service-fallback-image" value="<?php if ( isset ( $custom_fields['ignyte-service-fallback-image'] ) ) echo $custom_fields['ignyte-service-fallback-image'][0]; ?>" /><br/>
        <input type="button" id="ignyte-service-fallback-image-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'ignyte' )?>" />
    </div>
    <?php

}
// Hook things in, late enough so that add_fallback_meta_box() is defined
function ignyte_location_fallback_save_post_data($post_id){
    if ( !wp_verify_nonce( $_POST['ignyte_location_fallback_meta_box_nonce'], basename( __FILE__ ) ) ) {
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
add_action( 'save_post', 'ignyte_location_fallback_save_post_data' );


add_action('admin_menu', 'ignyte_location_directory_language_meta_box');

// This function tells WP to add a new "meta box"
function ignyte_location_directory_language_meta_box() {
    add_meta_box(
        'ignyte_location_directory_language_options', // id of the <div> we'll add
        'Old Language', //title
        'ignyte_location_directory_language_contents', // callback function that will echo the box content
        'ignyte_locations', // where to add the box: on "post", "page", or "link" page
        'side',										// placement on add/edit page
        'high'											// priority on add/edit page
    );
}
// This function echoes the content of our meta box
function ignyte_location_directory_language_contents() {
    if($_GET['post']) {
        $custom_fields = get_post_custom($_GET['post']);
        foreach ( $custom_fields as $key => $value ) {
            $meta[$key] = $value[0];
        }
    }
    $selected_locations=unserialize($meta["ignyte_language[]"]);
    //var_dump($meta);
    echo '<input type="hidden" name="ignyte_location_directory_language_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    $doclanguages=unserialize($meta['ignyte_language[]']);
    ?>
    <div class="input-group">
        <?php
        $languageList=array("English","Spanish","Portuguese","Chinese","Filipino","French","Hindi","Marathi","Telugu","Japanese","German","Russian","Javanese", "Bengali", "Punjabi", "Malay", "Vietnamese", "Korean", "Urdu", "Turkish", "Italian", "Persian", "Polish", "Pashto","Farsi", "Arabic","Medical Spanish","Taiwanese","Mandarin","Tagalong","Kurdish","American Sign","Gujarati","Dutch","Dental Spanish");

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
/*
// Hook things in, late enough so that add_meta_box() is defined
function ignyte_location_directory_language_save_post_data($post_id){
    if ( !wp_verify_nonce( $_POST['ignyte_location_directory_language_box_nonce'], basename( __FILE__ ) ) ) {
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
add_action( 'save_post', 'ignyte_location_directory_language_save_post_data' );
*/