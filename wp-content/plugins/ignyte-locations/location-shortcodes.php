<?php
add_shortcode('ignyte_location_search_form', 'ignyte_location_search_form_shortcode');
add_shortcode('ignyte_locations', 'ignyte_locations_shortcode');

function ignyte_location_search_form_shortcode($atts)
{
    ob_start();
    global $post;
    $currentlang = get_bloginfo('language');
    $lslug       = pll_current_language('slug'); ?>

    <div class="row location-search-controls margin-0">

        <span><?php echo pll__('Filter Results'); ?></span>

        <div class="input-icon">
            <input
                disabled='disabled'
                type="text" placeholder="<?php echo pll__("Zip Code"); ?>"
                min="3" maxlength="5"
                pattern="[0-9]{10}" class="quicksearch "
                value="" id="quicksearch"
                onkeypress="return isNumberKey(event)"
            >
            <span class="search-click"><?php echo pll__('GO'); ?></span>
        </div>

        <div class="dropdown filters">
            <button class="btn dropdown-toggle btn-blue form-control disabled" type="button" id="radius-dropdown"
                    data-toggle="dropdown">
                <span><?php echo pll__("Distance"); ?></span>
            </button>
            <ul class="dropdown-menu button-group" role="menu" aria-labelledby="specialty-dropdown"
                data-filter-group="all_distance">
                <li class="team_filter_li" data-filter="">
                    <a role="menuitem" tabindex="-1"
                       onclick="updatelabel('<?php echo pll__("Distance"); ?>',' <?php echo pll__("5 Miles"); ?>','radius-dropdown',5)"
                       href="javascript:void(0);">
                        <?php echo pll__("5 Miles"); ?>
                    </a>
                </li>
                <li role="presentation" class="team_filter_li" data-filter="">
                    <a role="menuitem" tabindex="-1"
                       onclick="updatelabel('<?php echo pll__("Distance"); ?>',' <?php echo pll__("10 Miles"); ?>','radius-dropdown',10)"
                       href="javascript:void(0);">
                        <?php echo pll__("10 Miles"); ?>
                    </a>
                </li>
                <li role="presentation" class="team_filter_li" data-filter="">
                    <a role="menuitem" tabindex="-1"
                       onclick="updatelabel('<?php echo pll__("Distance"); ?>','<?php echo pll__("20 Miles"); ?>','radius-dropdown',20)"
                       href="javascript:void(0);">
                        <?php echo pll__("20 Miles"); ?>
                    </a>
                </li>
                <li role="presentation" class="team_filter_li" data-filter="">
                    <a role="menuitem" tabindex="-1"
                       onclick="updatelabel('<?php echo pll__("Distance"); ?>','<?php echo pll__("50 Miles"); ?>','radius-dropdown',50)"
                       href="javascript:void(0);">
                        <?php echo pll__("50 Miles"); ?>
                    </a>
                </li>
            </ul>
            <input type="hidden" value="" name="zipdistence" id="zipdistence">
            <input type="hidden" value="0" name="errorstatus" id="errorstatus">
        </div>

        <div class="dropdown filters ">
            <?php $label = pll__('Services'); ?>
            <button class="btn dropdown-toggle btn-blue form-control" type="button" id="specialty-dropdown" data-toggle="dropdown">
                <span><?php echo $label; ?></span>
            </button>
            <ul class="dropdown-menu button-group" role="menu" aria-labelledby="specialty-dropdown"
                data-filter-group='all_services'>

                <?php
                    $specialties = query_posts(array(
                        'post_type'      => 'ignyte_services',
                        'posts_per_page' => '-1',
                        'lang'           => $lslug,
                        'meta_query'     => array(
                            'relation' => 'OR',
                            array(
                                'key'     => 'location-model-checkbox',
                                'compare' => 'NOT EXISTS' // doesn't work
                            ),
                            array(
                                'key'   => 'location-model-checkbox',
                                'value' => 'no',
                            )
                        ),
                    ) );
                ?>

                <li class="team_filter_li is-checked" data-filter="">
                    <a role="menuitem" tabindex="-1" onclick="removelabel('<?= $label; ?>','<?php echo pll__("Any Service"); ?>','specialty-dropdown')" href="javascript:void(0);"><?php echo pll__("Any Service"); ?></a>
                </li>

                <?php foreach ($specialties as $spec) {
                    $removespace = preg_replace('/\s+/', '', $spec->post_title);
                    $listclass = $spec->post_name . '-service';
                    ?>
                    <li role="presentation" class="team_filter_li" data-filter=".<?= $listclass ?>">
                        <a role="menuitem" tabindex="-1" onclick="updatelabel('<?= $label; ?>','<?= $spec->post_title; ?>','specialty-dropdown','')" href="javascript:void(0);"><?= $spec->post_title ?></a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="dropdown filters loc_filters">
            <?php
                $all_location_label = pll__('All Locations');
                $location_label = pll__('Locations');
                $nbl_label = pll__('Neighborhood Locations');
                $afl_label = pll__('Affiliate Locations');
            ?>

            <button class="btn dropdown-toggle btn-blue form-control" type="button" id="locationFilters" data-toggle="dropdown">
                <span><?php echo $all_location_label; ?></span>
            </button>
            <ul class="dropdown-menu button-group" role="menu" aria-labelledby="locationFilters"
                data-filter-group='all_location'>

                <li class="team_filter_li is-checked" data-filter="">
                    <a role="menuitem" tabindex="-1" onclick="removelabel('<?= $all_location_label; ?>','<?php echo $all_location_label; ?>','locationFilters')" href="javascript:void(0);"><?php echo $all_location_label; ?></a>
                </li>

                <li role="presentation" class="team_filter_li" data-filter=".loc_item_neig">
                    <a role="menuitem" tabindex="-1" href="javascript:void(0);" onclick="updatelabel('<?= $location_label; ?>','<?= $nbl_label; ?>','locationFilters','')"><?php echo $nbl_label; ?></a>
                </li>
                <li role="presentation" class="team_filter_li" data-filter=".loc_item_aff">
                    <a role="menuitem" tabindex="-1" href="javascript:void(0);" onclick="updatelabel('<?= $location_label; ?>','<?= $afl_label; ?>','locationFilters','')"><?php echo $afl_label; ?></a>
                </li>
            </ul>
        </div>
    </div>

    <script>
        function updatelabel(thisval, label, did, currentval) {
            jQuery("#" + did).html('<span>' + thisval + '</span><div class="chosendata">' + label + '</div>');
            jQuery("#" + did).addClass("activetab");
            if (did == 'radius-dropdown') {
                jQuery("#zipdistence").val(currentval);
                // getLatLog('no')
            }
        }

        function removelabel(thisval, label, did) {
            jQuery("#" + did).html('<span>' + thisval + '</span>');
            jQuery("#" + did).removeClass("activetab");
            if (did == 'radius-dropdown') {
                jQuery("#zipdistence").val('1');
                // getLatLog('no')
            }

        }

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }

        jQuery(document).ready(function () {
            //jQuery('#quicksearch').disabled = true;
            setTimeout(function () {
                jQuery('#quicksearch').prop('disabled', false);

                jQuery('#locationFilters').removeClass('disabled');
            }, 800);
        });
    </script>

    <?php
        wp_reset_query();
        $html = ob_get_contents();
        ob_end_clean();

    return $html;
}


function ignyte_locations_shortcode($atts)
{
    //var_Dump($atts);
    /* if using atts */
    $currentlang = get_bloginfo('language');
    extract(shortcode_atts(array(
        'number_posts'    => '-1',
        'order'           => 'ASC',
        'orderby'         => 'title',
        'id'              => '',
        'subnav_title'    => '',
        'cta_title'       => '',
        'cta_phone'       => '',
        'cta_text'        => '',
        'cta_color_class' => '',
        'loctext'         => '',
        'cta_title2'      => '',
        'cta_phone2'      => '',
        'cta_text2'       => '',
    ), $atts));
    $slug = pll_current_language('slug');
    $args = array(
        'posts_per_page' => $number_posts,
        'order'          => $order,
        'orderby'        => $orderby,
        'lang'           => $slug,
        'post_type'      => 'ignyte_locations',
        'post_status'    => 'publish'
    );

    $post         = get_posts($args);
    $list         = '';
    $distancelist = '';
    $grid         = '';
    $i            = 0;
    $ii           = 0;
    $avilableloc  = array();

    $tz = date_default_timezone_get();
    date_default_timezone_set('America/Los_Angeles');
    // date_default_timezone_set( 'Asia/Kolkata');

    $currentTime = time() + 0;

    //  $currentTime2 = time()+3600;
    $currentTime2 = date('H', $currentTime);
    if ($currentTime2 == 00) {
        $currentTime2=24;
    }

    $currentmin   = date('i', $currentTime);
    $currentTime2 = $currentTime2.$currentmin+10;
    $todayday     = date('D', $currentTime);
    // echo $time=date("g:iA", strtotime($date2));

    $alldays  = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
    $alldays2 = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $locationfilter = '';
    if (isset($_GET['loc'])) {
        $locationfilter = $_GET['loc'];
    }

    $popupid = '';
    foreach ($post as $p) {

        $listclass    = '';
        $loc_services = "";
        $loc_resource = "";
        $locGetPermalink = get_permalink( $p->ID );
        $meta_values  = get_post_meta($p->ID);
        $fallback     = $meta_values["ignyte-service-fallback-image"][0];
        $title        = apply_filters('the_title', $p->post_title);
        $locationlink = preg_replace('/\s+/', '', $title);

        if ($locationlink == $locationfilter) {
            $popupid = $p->ID;
        }

        $fulltitle = $title;
        if ($meta_values['ignyte_location_longname'][0] != "") {
            $fulltitle = $meta_values['ignyte_location_longname'][0];
        }
        //  $content = apply_filters('the_content', $p->post_content);
        $content   = $meta_values['ignyte_location_description'][0];
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'full');
        $image     = "<img src='" . $thumbnail[0] . "' />";

        $meta_array = array();
        array_push($meta_array, array('key' => 'ignyte_locations[]', 'value' => $p->post_title, 'compare' => 'LIKE'));

        $services_args = array(
            'post_type'      => 'ignyte_services',
            'meta_query'     => $meta_array,
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        );
        $services = get_posts($services_args);
        $firstLink = true;
        foreach ($services as $thisserv) {
            $meta_valuesservices = get_post_meta($thisserv->ID);
            if ($firstLink) {
                if ($meta_valuesservices['location-model-checkbox'][0] == 'yes') {
                    if ($meta_valuesservices['ignyte_model_alternative'][0] != "") {
                        $loc_services .= $meta_valuesservices['ignyte_model_alternative'][0];
                    } else {
                        $loc_services .= $thisserv->post_title;
                    }

                } else {
                    if ($meta_valuesservices['ignyte_model_alternative'][0] != "") {

                        $loc_services .= "<a href='" . get_permalink($thisserv->ID) . "'>" . $meta_valuesservices['ignyte_model_alternative'][0] . "</a>";
                    } else {
                        $loc_services .= "<a href='" . get_permalink($thisserv->ID) . "'>" . $thisserv->post_title . "</a>";
                    }
                }
                $firstLink = false;
            } else {
                if ($meta_valuesservices['location-model-checkbox'][0] == 'yes') {

                    if ($meta_valuesservices['ignyte_model_alternative'][0] != "") {
                        $loc_services .= "<br/>" . $meta_valuesservices['ignyte_model_alternative'][0];
                    } else {
                        $loc_services .= "<br/>" . $thisserv->post_title;
                    }

                } else {

                    if ($meta_valuesservices['ignyte_model_alternative'][0] != "") {

                        $loc_services .= "<br/><a href='" . get_permalink($thisserv->ID) . "'>" . $meta_valuesservices['ignyte_model_alternative'][0] . "</a>";
                    } else {
                        $loc_services .= "<br/><a href='" . get_permalink($thisserv->ID) . "'>" . $thisserv->post_title . "</a>";
                    }
                }
            }

            $removespace = preg_replace('/\s+/', '', $thisserv->post_title);
            $listclass .= $thisserv->post_name . '-service ';
        }

        $resource_args = array(
            'post_type'      => 'ignyte_resources',
            'meta_query'     => $meta_array,
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        );
        $resource = get_posts($resource_args);

        $firstLink1 = true;
        $liste = array();
        foreach ($resource as $thisrerv) {
            $m_resource_type = wp_get_post_terms($thisrerv->ID, 'ignyte_resource_type');
            foreach ($m_resource_type as $resource_type) {
                if (!in_array($resource_type->name, $liste, true)) {
                    array_push($liste, $resource_type->name);
                }
            }

            if ($firstLink1) {
                //$loc_resource .= "<a href='" . get_permalink($thisrerv->ID) . "'>" . $thisrerv->post_title . "</a>";
                $loc_resource .= $thisrerv->post_title;
                $firstLink1 = false;
            } else {
                $loc_resource .= "<br/>" . $thisrerv->post_title;
            }
        }

        wp_reset_postdata();
        $getmaptext                    = pll__("Get Directions");
        $appointmenttext               = pll__("Phone");
        $streettext                    = pll__("Street Address");
        $servText                      = pll__("Services");
        $maptext                       = pll__("Locations");
        $FindADoctorAtThis             = pll__("Find A Doctor At This Location");
        $Forlife_threateninemergencies = pll__("For life-threatening emergencies");
        $Call                          = pll__("Call");
        $forlife2                      = pll__("or go to the nearest hospital emergency room");
        $Languages                     = pll__("Languages");
        $hourslabel                    = pll__("Hours");
        //This code is using for OpentAt Functionlity

        $daycount = 1;
        $firstLink1 = 1;
        $openmsg = '';
        // $startminite=0;
        // $endminite=0;

        foreach ($alldays as $daylist) {
            // echo $daylist.$daycount.'<br/>';
            //echo $alldays2[$daycount];
            $daylistlabel = pll__($alldays2[$daycount - 1]);
            $enable       = $meta_values['enableday' . $daycount][0];
            $hideshow     = $meta_values['hideshow' . $daycount][0];
            $openattime   = $meta_values['open' . $daycount][0];
            $closeattime  = $meta_values['close' . $daycount][0];
            $openfirst    = preg_split('#(?<=\d)(?=[a-z])#i', $openattime);
            $closefirst   = preg_split('#(?<=\d)(?=[a-z])#i', $closeattime);
            $OPT          = $openfirst[0];
            $mm           = explode(":", $OPT);

            // $startminite  = $mm[1]+10;
            // if($startminite=='')
            // {
            //     $startminite=10;
            // }

            $startminite = 10;
            if(isset($mm[1])){
                $startminute = $mm[1] + 10;
            } else {
                $startminite = 10;
            }

            $startminite=(int)$startminite;
            $OPT = $mm[0];

            if ($openfirst[1] == 'PM') {
                $OPT = $openfirst[0] + 12;
            }
            $OPT=$OPT.$startminite;

            $COT = $closefirst[0];
            $mm2 = explode(":", $COT);
            $COT = $mm2[0];
            $endminite = $mm2[1]+10;
            if($endminite=='')
            {
                $endminite=10;
            }

            if ($closefirst[1] == 'PM') {
                $COT = $closefirst[0] + 12;
            }

            $COT=$COT.$endminite;
            if ($firstLink1 == 1) {
                if ($todayday == $daylist) {
                    // echo $title.'++'.$enable.'==enableday' . $daycount.'='.$todayday.'--'.$daylist.'<br/>';
                    if ($enable == 1 & $hideshow != 2) {

                        //echo $currentTime2.'=='.$OPT.'=='.$COT.'<br/>';
                        if ($currentTime2 >= $OPT &&   $currentTime2 < $COT ) {
                            $firstLink1 = 2;
                            $openmsg = pll__('Currently Open - Will Close AT') . ' ' . $closeattime;
                        } else {
                            // echo $currentTime2 .'>'.$COT .'&&'. $endminite.'<'.$currentmin.'<br/>';
                            if ($currentTime2 >$COT)
                            {
                                $firstLink1 = 3;
                                $openmsg = pll__('Currently Closed - Opens') . ' ' . $daylistlabel . ' AT ' . $openattime;
                            }
                            else
                            {
                                $firstLink1 = 2;
                                $openmsg = pll__('Currently Closed - Opens Today at ') . $openattime;
                            }
                        }
                    } else {
                        $firstLink1 = 3;
                    }
                }
            } elseif ($firstLink1 == 3) {
                if ($enable == 1 & $hideshow != 2) {
                    $openmsg = pll__('Currently Closed - Opens') . ' ' . $daylistlabel . ' AT ' . $openattime;
                    // $openmsg = 'CURRENTLY CLOSED - OPENS ' . $daylist . ' AT ' . $openattime;
                    $firstLink1 = 2;
                }
            }

            if ($firstLink1 == 2) {
                break;
            }
            $daycount++;
        }

        date_default_timezone_set($tz);
        //Ended code is  for OpentAt Functionlity

        $address = $meta_values['ignyte_location_address'][0];
        if ($meta_values['address2nd'][0] != '') {
            $address = $meta_values['address2nd'][0];
        }

        $locItemClass = 'loc_item_aff';
        $mapLocationCategories = wp_get_post_terms($p->ID, 'ignyte_locations_category');
        if ( !empty( $mapLocationCategories ) ) {
            foreach ( $mapLocationCategories as $term ) {
                if( $term->slug == 'neighborhood-locations'){
                    $locItemClass = 'loc_item_neig';
                }
            }
            $listclass .= $locItemClass;
        }

        $list .= ' <div class="doc-list color-shape ' . $listclass . ' marker' . $ii . '" data_id="markerlist' . $ii . '" id="' . $ii . '">
            <div style="display: none;"><span class="hiddensearch" ></span>' . $meta_values["ignyte_location_address"][0] . '</div>
                <div class="doctor-list loc-list vh-center">
                    <a href="' . $locGetPermalink .'" class="loc-list-itemlink"><div class="col-md-11 col-sm-11 col-xs-10">
                        <h2>' . $title . '</h2>
                    </div></a>
                    <div class="col-md-1 col-sm-1 col-xs-2 vh-center" style="height:100%;">
						<a href="' . $locGetPermalink .'" class="btn hidden-text-btn icon arrow green"></a>
                    </div>
                 </div>

                  <div id="bio-content' . $p->ID . '" class="collapse">
                       <div class="row margin-0">
                            <div class="col-md-7 col-sm-12 col-xs-12 left">
                                <div class="inner-content">
                                    <span class="red">' . $maptext . '</span>
                                    <h5>' . $fulltitle . '</h5>
                                    <span class="timings">' . $openmsg . '</span>
                                    <p class="large">' . $content . '</p>

                                    <div class="row service">';
        if ($loc_services != '') {
            $list .= '<div class="col-md-6 col-sm-12 service-dropmenu">
                <span class="red">' . $servText . '</span>' . $loc_services . '</div>';
        }

        $listresource = '';
        $totalrtype = count($liste);
        if ($totalrtype > 0) {
            $rlabel = 'Programs & Resources';
            if ($totalrtype == 1) {
                $rlabel = $liste[0];
            }
            $listresource = '<span class="red">' . $rlabel . '</span>' . $loc_resource;

            $list .= ' <div class="col-md-6 col-sm-12 location-dropmenu">' . $listresource . '</div>';
        }


        //$locationlan = unserialize($meta_values['ignyte_language[]'][0]);
        $locationlan = wp_get_post_terms($p->ID, 'ignyte_lang');
        $langstatus = true;
        $listlang = "";
        foreach ($locationlan as $loclang) {
            if ($langstatus) {
                $listlang .= $loclang->name;
                $langstatus = false;
            } else {
                $listlang .= '<br/>' . $loclang->name;
            }
        }

        if ($listlang != '') {
            $list .= '<div class="col-md-6 col-sm-12 language-dropmenu"><span class="red">' . $Languages . '</span>' . $listlang . '</div>';
        }
        $list .= '</div>';
        $list .= '<div class="hours"> <span class="red">' . $hourslabel . '</span>
                    <table class="table table-striped"><tbody>';

        $daycou = 1;
        foreach ($alldays2 as $daylist) {
            // echo $daylist.$daycount.'<br/>';
            $opentime    = pll__('Closed');
            $lunchattime = "";
            $enable      = $meta_values['enableday' . $daycou][0];
            $openattime  = $meta_values['open' . $daycou][0];
            $closeattime = $meta_values['close' . $daycou][0];
            $luncime     = $meta_values['lunch' . $daycou][0];
            $showhide    = $meta_values['hideshow' . $daycou][0];

            if ($luncime != "") {
                // $lunchattime = ' (' . $luncime . ')';
                $lunchattime = ' ' . $luncime;
            }
            if ($enable == 1) {
                $opentime = $openattime . '-' . $closeattime;
            }
            if ($showhide != 2) {
                $list .= '<tr><td>' . pll__($daylist) . '</td> <td>' . $opentime . $lunchattime . '</td></tr>';
            }

            $daycou++;
        }

        $list .= '</tbody></table></div>';

        $data1 = explode('~', $meta_values['ignyte_project_media'][0]);

        $counter2 = 1;
        foreach ($data1 as $d) {
            $dat23 = explode('==', $d);
            $dat2 = explode('|', $dat23[0]);

            if ($dat2[0] == "ignyte_project_media_date") {
                $list .= '<div class="hours"><span class="red">' . $dat2[1] . '</span> ' . $dat2[2] . ' </div>';
            }

            if ($dat2[0] == "ignyte_project_media_st") {

                $datsubcatlist = explode('hinit33', $d);
                $datsubcatlist2 = explode('hinit', $datsubcatlist[1]);
                $list .= '<div class="hours"><span class="red">' . $dat2[1] . '</span>
                             <table class="table table-striped"><tbody>';
                foreach ($datsubcatlist2 as $datainner) {
                    $dat223 = explode('|', $datainner);
                    $opentime = pll__('Closed');

                    if ($dat223[2] != '' & $dat223[3] != '') {
                        $opentime = $dat223[2] . '-' . $dat223[3];
                    }

                    if ($dat223[1] !== '') {
                        $luncht = '';
                        if ($dat223[4] != "") {
                            $luncht = ' ' . $dat223[4] . '';
                        }
                        if ($dat223[5] != 2) {
                            $list .= '<tr><td>' . pll__($dat223[1]) . '</td> <td>' . $opentime . $luncht . '</td></tr>';
                        }
                    }
                }
                $list .= '</tbody></table></div>';
            }
        }

        $url = wp_get_attachment_url(get_post_thumbnail_id($p->ID));

        $list .= '<div class="location-model-note"><span class="red">' . $Forlife_threateninemergencies . '</span> <p>' . $Call . ' <a href="tel:911" class="underline">911</a> ' . $forlife2 . '.</p></div></div></div>
                    <div class="col-md-5 col-sm-12 col-xs-12 padding-0">
                        <div class="col-md-12 col-sm-12 col-xs-12 image"  style="background-image:url(' . $url . ')"></div>
                            <div class="col-md-12 col-sm-12 col-xs-12 address padding-0">
                                <div class="col-md-6 col-sm-6 col-xs-6 bg-black">
                                    <span>' . $streettext . '</span>';

        $list .= '<p class="white">' . $address . '</p>';
        if ($meta_values['ignyte_location_phone'][0] != '') {
            if ($meta_values['ignyte_location_phone1_label'][0] != '') {
                $appointmenttext = $meta_values['ignyte_location_phone1_label'][0];
            }
            $list .= '<span class="phone-label">' . $appointmenttext . '</span> <p class="white"><a class="white" href="tel:' . $meta_values['ignyte_location_phone'][0] . '">' . $meta_values['ignyte_location_phone'][0] . '</a> </p>';
        }

        if ($meta_values['ignyte_location_phone2'][0] != "") {
            $list .= '<span class="phone-label">' . $meta_values['ignyte_location_phone2_label'][0] . '</span> <p class="white"><a class="white" href="tel:' . $meta_values['ignyte_location_phone2'][0] . '">' . $meta_values['ignyte_location_phone2'][0] . '</a> </p>';
        }

        if ($currentlang == "en-US") {
            $find_doctor_url = '/find-a-doctor/';
        } else {
            $find_doctor_url = '/es/buscar-medico/';
        }

        $list .= ' <a class="btn white" href="http://maps.google.com/?daddr=' . $meta_values["ignyte_location_address"][0] . '" target="_blank">' . $getmaptext . '</a></div>
                                <div class="col-md-6 col-sm-6 col-xs-6 map-small bg-whiteright-content"  style="background-image:url(' . $fallback . ')"> </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 redirect-btn vh-center bg-green" onclick=" javascript:location.href=\'' . $find_doctor_url . '?location=' . $locationlink . '\'">
                                <div class="col-md-10 col-sm-10 col-xs-10"><p class="large margin-0 white">' . $FindADoctorAtThis . ' </p></div><div class="col-md-2 col-sm-2 col-xs-2"><a class="btn hidden-text-btn icon green arrow" href="' . $find_doctor_url . '?location=' . $locationlink . '"></a></div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>';

        //echo $address=preg_replace( "/\r|\n/", "", $address );
        $address = nl2br($address, false);
        $address = str_replace(array("\n", "\r"), '', $address);
        if ($meta_values['ignyte_location_address'][0] != '') {

            $grid .= '<li class="locItems color-shape ' . $listclass . ' ' . $ii . 'result marker' . $ii . '" data_id="marker' . $ii . '" id="marker' . $ii . '"  onclick="showmarker(' . $ii . ')"><span>' . $title . '</span><div style="display: none;"><span class="hiddensearch" ></span>' . $meta_values["ignyte_location_address"][0] . '</div> </li>';

            $thisloc["address"]       = $meta_values['ignyte_location_address'][0];
            $thisloc["address2"]      = $address;
            $thisloc["phone1stlabel"] = $appointmenttext;
            $thisloc["phone"]         = $meta_values['ignyte_location_phone'][0];
            $thisloc["phone2ndlabel"] = $meta_values['ignyte_location_phone2_label'][0];
            $thisloc["phone2nd"]      = $meta_values['ignyte_location_phone2'][0];
            $thisloc["title"]         = $title;
            $thisloc["ID"]            = $p->ID;
            $thisloc["offeringType"]  = $meta_values['offering-type'][0];
            $thisloc["lat"]           = $meta_values['gllpLatitude'][0];
            $thisloc["log"]           = $meta_values['gllpLongitude'][0];
            $thisloc["countID"]       = $ii;
            $locations[]              = $thisloc;
            $avilableloc[$ii]         = $thisloc;

            if ($ii > 0) {
                $distancelist .= ',';
            }
            $distancelist .= '.' . $ii . 'result';
            $ii++;
        } else {
            $grid .= '<li  class="locItems color-shape ' . $listclass . '" >' . $title . ' <div style="display: none;">' . $meta_values["ignyte_location_address"][0] . '</div> </li>';
        }
        $i++;
    } //End foreach loop

    $ffilter = '<div class="filters" style="display: none"><ul class="button-group" data-filter-group="parent">
        <li class="hiddendata" data-filter="">all</li>
        <li class="hiddendata" id="customloc" data-filter=".0result,.1result">' . $distancelist . '</li></ul></div>';
    $center = array(
        'container_id' => 'map',
        // 'apiKey'       => 'AIzaSyD8j2K9aAc3sHRdKF91-JrUhoChlqHWKgI',
        // 'apiKey'       => 'AIzaSyDAjm-EM7YIQirNQgJTchMW4c1ns3-49nU',
		'apiKey'       => 'AIzaSyAA7RTkLc8ru85_RQXfv8jKQc-aygXPseE',
        'latitude'     => '33.46365',
        'longitude'    => '-117.355356',
        'icon'         => IGNYTE_LOCATIONS_PLUGIN_URL . '/images/marker-shadow.png',
    );

    ob_start();
    ?>
    <?php echo $ffilter; ?>
    <section id="location">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="tab-content">
                    <div id="list-view" class="tab-pane fade">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-offset-1 col-md-10">
                                    <div class="content grid">
                                        <?php echo $list; ?>
                                    </div>
                                    <div class="not_found_msg" style="display: none">
                                        <h3 class="center green"><?php echo pll__('Sorry, your search returned no results.'); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="map-view" class="tab-pane fade in active">
                        <div class="container map-opt-header">
                            <div class="row">
                                <div class="col-md-offset-1 col-md-11">
                                    <div class="row margin-0 filters">
                                        <div class="nhc-map-filter button-group" data-filter-group='all_location'>
                                            <span class="btn-text-display team_filter_li btn-sm btn" data-filter="">Display</span>
                                            <a class="nhc-map-filter-item team_filter_li" href="javascript:void(0);" data-filter=".loc_item_neig">
                                                <img src="/wp-content/plugins/ignyte-locations/images/icon-map-marker-blue.svg"/><?php echo pll__("Neighborhood Location"); ?>
                                            </a>
                                            <a class="nhc-map-filter-item team_filter_li" href="javascript:void(0);" data-filter=".loc_item_aff">
                                                <img src="/wp-content/plugins/ignyte-locations/images/icon-map-marker-green.svg"/><?php echo pll__("Affiliate Location"); ?>
                                            </a>
                                        </div>

                                        <div class="pin-desc" style="display: none !important;">
                                            <p class="small">
                                                <img src="/wp-content/plugins/ignyte-locations/images/marker.svg"/><?php echo pll__("Full Service Location"); ?>
                                            </p>
                                            <p class="small">
                                                <img src="/wp-content/plugins/ignyte-locations/images/dot.svg"/><?php echo pll__("Specialty Location"); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row margin-0 map-viewer">
                            <div class="map " id="<?php echo $center["container_id"]; ?>"></div>
                        </div>

                        <div class="absolute-wrapper">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-10">
                                        <div class="content">
                                            <div class="selection-menu">
                                                <ul class="grid mapgrid" id="locLists">
                                                    <li class="color-shape current" id="markerfirst">
                                                        <span><?php echo pll__("All Locations"); ?></span>
                                                    </li>
                                                    <?php echo $grid; ?>
                                                </ul>
                                                <div class="not_found_msg" style="display: none">
                                                    <h3 class="center green"><?php echo pll__('Sorry, your search returned no results.'); ?></h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Container -->
    <?php
        $map = ob_get_contents();
        ob_end_clean();
        $close = pll__("Close");
        $modelpopup = '<div class="modal fade" id="location-modal" role="dialog">
            <div class="vertical-alignment-helper">
                <div class="modal-dialog modal-lg vertical-align-center">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">' . $close . ' X</button></div>
                        <div class="modal-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    ?>

    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $center["apiKey"]; ?>"></script>
    <script>
        var infowindow = null;
        var arrMarkers = {};
        var gmarkers = [];
        var circles = [];
        var map;
        var sites = [];

        // these are location
        var sites = [<?php $i = 0;
            $mapping = array();
            foreach($locations as $loc) {
                $mapping[$loc["ID"]] = $i;
                $phone2nd = '';
                $phone1st = "";
                if ($loc['phone2nd'] != "") {
                    $phone2nd = '<p><span>' . $loc["phone2ndlabel"] . '</span></p><p><a class="underline" href="tel:' . $loc["phone2nd"] . '">' . $loc["phone2nd"] . '</a></p>';
                }

                if ($loc["phone"] != "") {
                    $phone1st = '<p><span>' . $loc["phone1stlabel"] . '</span></p><p><a class="underline" href="tel:' . $loc["phone"] . '">' . $loc["phone"] . '</a></p>';
                }
            ?>

            <?php
                $img = '/images/icon-map-marker-green.svg';
                // if ($loc["offeringType"] == 'Specialty') {
                //     $img = '/images/dot.svg';
                // }

                $mapLocationCategories = wp_get_post_terms($loc['ID'], 'ignyte_locations_category');
                if ( !empty( $mapLocationCategories ) ) {
                    foreach ( $mapLocationCategories as $term ) {
                        if( $term->slug == 'neighborhood-locations'){
                            $img = '/images/icon-map-marker-blue.svg';
                        }
                    }
                }

                $final = IGNYTE_LOCATIONS_PLUGIN_URL . $img;
            ?>

            <?php
                $imghover = '/images/icon-map-marker-coral.svg';
                if ($loc["offeringType"] == 'Specialty') {
                    $imghover = '/images/icon-map-marker-coral.svg';
                }
                $finalhover = IGNYTE_LOCATIONS_PLUGIN_URL . $imghover;
            ?>

            <?php
                if ($loc["offeringType"] == 'Specialty') {
                    $type = 'Specialty Service Offering';
                } else {
                    $type = 'Full Service Offering';
                }

                $functiondata = "\'bio-content" . $loc["ID"] . "\',\'" . $loc["ID"] . "\'";
                $locPostUrl = get_permalink( $loc["ID"] );
            ?>
            <?php
                $contentdata = '<div id="popover-content-location" class="map-content popover-content"><p class="small">' . $type . '</p>';
                $contentdata .= '<p class="place red">' . preg_replace("/'/", "\&#39;", $loc["title"]) . '</p><p><span>' . pll__("Address") . '</span></p><p>' . preg_replace("/'/", "\&#39;", $loc["address2"]) . '</p>' . $phone1st . $phone2nd . '<p><a class="underline" href="http://maps.google.com/?daddr=' . preg_replace("/'/", "\&#39;", $loc["address"]) . '" target="_blank">Get Directions</a></p><br/>';
                // $contentdata .= '<a class="btn hidden-text-btn icon red"  onclick="javascript:showMyModalSetTitle(' . $functiondata . ')"><div class="hidden-text">' . pll__("View More") . '</div><i class="fa fa-arrow-right"></i></a></div>';
                $contentdata .= '<a class="btn hidden-text-btn icon red" href="' . $locPostUrl . '"><div class="hidden-text">' . pll__("View More") . '</div><i class="fa fa-arrow-right"></i></a></div>';
            ?>

            [
                '<?=$loc["title"];?>',
                <?=$loc["lat"];?>,
                <?=$loc["log"];?>,
                4,
                '<?=$contentdata; ?>',
                '<?=$final;?>',
                '<?=$finalhover;?>',
                '<?=$i;?>'
            ],
            <? $i++; }?>];


        function initMap(sites) {

            var geometry = {
                //set map center
                lat: <?php echo $center["latitude"]; ?>,
                lng: <?php echo $center["longitude"]; ?>
            };

            var mapOptions = {
                zoom: 10,
                center: new google.maps.LatLng(geometry.lat, geometry.lng), //center map
                scrollwheel: false,
                disableDefaultUI: true, // a way to quickly hide all controls
                mapTypeControl: false,
                scaleControl: true,
                zoomControl: true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.SMALL
                },
                styles: [
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#e9e9e9"
                            },
                            {
                                "lightness": 17
                            }
                        ]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#f5f5f5"
                            },
                            {
                                "lightness": 20
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#ffffff"
                            },
                            {
                                "lightness": 17
                            }
                        ]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "color": "#ffffff"
                            },
                            {
                                "lightness": 29
                            },
                            {
                                "weight": 0.2
                            }
                        ]
                    },
                    {
                        "featureType": "road.arterial",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#ffffff"
                            },
                            {
                                "lightness": 18
                            }
                        ]
                    },
                    {
                        "featureType": "road.local",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#ffffff"
                            },
                            {
                                "lightness": 16
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#f5f5f5"
                            },
                            {
                                "lightness": 21
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#dedede"
                            },
                            {
                                "lightness": 21
                            }
                        ]
                    },
                    {
                        "elementType": "labels.text.stroke",
                        "stylers": [
                            {
                                "visibility": "on"
                            },
                            {
                                "color": "#ffffff"
                            },
                            {
                                "lightness": 16
                            }
                        ]
                    },
                    {
                        "elementType": "labels.text.fill",
                        "stylers": [
                            {
                                "saturation": 36
                            },
                            {
                                "color": "#333333"
                            },
                            {
                                "lightness": 40
                            }
                        ]
                    },
                    {
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#f2f2f2"
                            },
                            {
                                "lightness": 19
                            }
                        ]
                    },
                    {
                        "featureType": "administrative",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#fefefe"
                            },
                            {
                                "lightness": 20
                            }
                        ]
                    },
                    {
                        "featureType": "administrative",
                        "elementType": "geometry.stroke",
                        "stylers": [
                            {
                                "color": "#fefefe"
                            },
                            {
                                "lightness": 17
                            },
                            {
                                "weight": 1.2
                            }
                        ]
                    }
                ]
            };

            map = new google.maps.Map(document.getElementById("map"), mapOptions);
            setMarkers(map, sites, '');
            infoWindow = new google.maps.InfoWindow({
                content: "loading..."
            });
            //var bikeLayer = new google.maps.BicyclingLayer();
            //bikeLayer.setMap(map);
            //setVisibility('all');
        }

        function showmarker(id) {
            //setVisibility(id);
            if (id == "all") {
                close_all_infowindows();
                // google.maps.event.trigger(null, 'click')
                //   map.panTo((<?php echo $center["latitude"]; ?>, <?php echo $center["longitude"]; ?>))
            }
            else {
                //  alert(gmarkers[id].getPosition());
                google.maps.event.trigger(gmarkers[id], 'click')
                map.panTo(gmarkers[id].getPosition());

            }
        }

        function close_all_infowindows(firstopen) {
            jQuery(".mapgrid li").removeClass("current");
            for (var ii = 0; ii < sites.length; ii++) {
                allmarker = sites[ii];
                infoWindow.close();
                gmarkers[allmarker[7]].setIcon(allmarker[5]);
            }
            if (firstopen == "markerfirst") {
                jQuery("#markerfirst").addClass("current");
                var contactTopPosition = jQuery('#markerfirst').position().top;
                jQuery(".mapgrid").animate({scrollTop: contactTopPosition});
            }
        }

        function setMarkers(map, markers, id) {
            for (var i = 0; i < markers.length; i++) {
                var sites = markers[i];
                var siteLatLng = new google.maps.LatLng(sites[1], sites[2]);
                var marker = new google.maps.Marker({
                    position: siteLatLng,
                    map: map,
                    title: sites[0],
                    zIndex: sites[100],
                    html: sites[4],
                    icon: sites[5],
                    icon2: sites[6],
                    idmap: sites[7],
                });

                var contentString = "Some content";
                google.maps.event.addListener(marker, "click", function () {
                    close_all_infowindows();
                    console.log('info open');
                    gmarkers[this.idmap].setIcon(this.icon2);
                    gmarkers[this.idmap].setZIndex(1005);
                    infoWindow.setContent(this.html);
                    infoWindow.open(map, this);
                    // map.setCenter(gmarkers[this.idmap].getPosition());
                    // gmarkers[this.idmap].setZoom(10);
                    console.log('info end');
                    var contactTopPosition = jQuery('#marker' + this.idmap).position().top;
                    jQuery(".mapgrid").animate({scrollTop: contactTopPosition});
                    jQuery('#marker' + this.idmap).addClass("current");
                });

                gmarkers.push(marker);

                var circle = new google.maps.Circle({
                    map: map,
                    radius: 16093,// 50 MI
                    visible: false,
                    fillColor: '#AA0000'
                });
                circle.bindTo('center', marker, 'position');
                circles.push(circle);
                //marker._myCircle = circle;
            }
        }

        function setVisibility(id) {
            // initial show first marker and hide all

            ss = false;
            if (id == 'all') {
                ss = true;
            }
            for (var i = 0; i < gmarkers.length; i++) {
                gmarkers[i].setVisible(ss);
            }
            gmarkers[id].setVisible(true);
        }

        jQuery(document).ready(function () {
            initMap(sites);

            setTimeout(function () {
                jQuery(document).on("click", ".gm-ui-hover-effect", function () {
                    close_all_infowindows('markerfirst');
                    //map.panTo(marker.getPosition())
                });
            }, 300);
        });

    </script>

    <?php
        //This code is use for fetching csv data .
        $file = fopen('wp-content/plugins/ignyte-locations/zip-codes-database.csv', 'r');
        $counttotdalrows = 1;
        $searchlocation = array();
        while (($line = fgetcsv($file)) !== FALSE) {
            //$line is an array of the csv elements
            if ($counttotdalrows > 1) {
                $searchlocation[$line[0]] = $line;
            }
            $counttotdalrows++;
        }
        fclose($file);
    ?>

    <script>
        var searchlocation = <?php echo json_encode($searchlocation); ?>;
        var avilableloc = <?php echo json_encode($avilableloc); ?>;

        function distance(lat1, lon1, lat2, lon2, unit) {
            var radlat1 = Math.PI * lat1 / 180
            var radlat2 = Math.PI * lat2 / 180
            var radlon1 = Math.PI * lon1 / 180
            var radlon2 = Math.PI * lon2 / 180
            var theta = lon1 - lon2
            var radtheta = Math.PI * theta / 180
            var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
            dist = Math.acos(dist)
            dist = dist * 180 / Math.PI
            dist = dist * 60 * 1.1515
            // if (unit=="K") { dist = dist * 1.609344 } //Chnge in to KM
            // if (unit=="N") { dist = dist * 0.8684 }
            //  if (unit=="M") { dist = dist * 1609.344 }
            return dist
        }

        function getLatLog(zipcode) {

            jQuery("#errorstatus").val(1);
            var choosedistance = jQuery("#zipdistence").val();
            var lengthsearchfield = jQuery('#quicksearch').val().length;
            returnvalue = '';

            if (lengthsearchfield < 3) {
                jQuery('#radius-dropdown').addClass('disabled');
                // removelabel('Distance','All Services','specialty-dropdown')
                choosedistance = 1;
            } else {
                jQuery('#radius-dropdown').removeClass('disabled');
                //alert(choosedistance);
                if (choosedistance < 5) {
                    updatelabel('<?php echo pll__("Distance"); ?>', '<?php echo pll__("5 Miles"); ?>', 'radius-dropdown', 5);
                }
            }

            if (zipcode == 'no') {
                zipcode = document.getElementById("quicksearch").value;
                if (zipcode.length < 4) {
                    //return;
                }
            }

            if (lengthsearchfield > 3) {

                // var choosedistance=displayRadioValue();
                var outerarray = searchlocation[zipcode];
                // alert(outerarray);

                if (typeof outerarray === 'undefined') {
                    close_all_infowindows('markerfirst');
                    return 1;
                    //alert('mm');
                }
                else {
                    var distancecount = '';
                    var searchlat = outerarray[3];
                    var searchlog = outerarray[4];
                    var centermapid = 'all';
                    // alert(outerarray[3]);
                    var searchresult = '';
                    var mindistance = 100000;
                    var maxdistance = 0;
                    var maplistarr = new Array();
                    for (var i = 0; i < avilableloc.length; i++) {
                        // console.log(avilableloc[i]);
                        var distancecount = distance(searchlat, searchlog, avilableloc[i]['lat'], avilableloc[i]['log'], 'M');
                        distancecount = Math.round(distancecount * 1000) / 1000;

                        if (distancecount < choosedistance) {
                            if (mindistance > distancecount) {
                                mindistance = distancecount;
                                centermapid = avilableloc[i]['countID'];
                            }
                            if (maxdistance < distancecount) {
                                maxdistance = distancecount;
                            }
                            if (searchresult == '') {
                                searchresult += '.' + avilableloc[i]['countID'] + 'result';
                            }
                            else {
                                searchresult += ',.' + avilableloc[i]['countID'] + 'result';
                            }
                            maplistarr.push(avilableloc[i]['countID']);
                            //searchresult +='ID='+':'+avilableloc[i]['countID']+'===='+avilableloc[i]['title']+' Distence:'+distancecount;
                        }

                    }
                    if (distancecount != '') {
                        jQuery("#errorstatus").val(2);
                        if (centermapid != 'all') {
                            //setVisibility(avilableloc[i]['countID']);
                            for (var i = 0; i < gmarkers.length; i++) {
                                gmarkers[i].setVisible(false);
                                //circles[i].setVisible(false);
                                // jQuery('#marker'+i).css('display','none');
                                jQuery('.marker' + i + ' .hiddensearch').html('');
                                //jQuery('#markerlist' + i + ' .hiddensearch').html('');
                            }
                            //alert(maplistarr.length);
                            for (var i = 0; i < maplistarr.length; i++) {
                                gmarkers[maplistarr[i]].setVisible(true);
                                jQuery('.marker' + maplistarr[i] + ' .hiddensearch').html('search121d');
                            }

                            if (maplistarr.length == 1) {
                                setTimeout(function () {
                                    google.maps.event.trigger(gmarkers[centermapid], 'click')
                                    map.panTo(gmarkers[centermapid].getPosition());
                                    // showmarker(centermapid);
                                    modelpopup = 0
                                }, 10);
                            }
                            else {
                                close_all_infowindows('markerfirst');
                                map.panTo(gmarkers[centermapid].getPosition());
                                modelpopup = 1;
                            }

                            //circles[centermapid].setVisible(true);
                            var radiusmeter = choosedistance * 1609.344;
                            circles[centermapid].setRadius(radiusmeter);
                            returnvalue = 1;
                        }
                        else {
                            for (var i = 0; i < gmarkers.length; i++) {
                                gmarkers[i].setVisible(false);
                                //circles[i].setVisible(false);
                            }
                            close_all_infowindows('markerfirst');
                            //jQuery("#errorstatus").val(2);

                        }
                    }

                    else {
                        jQuery("#errorstatus").val(1);
                        close_all_infowindows('markerfirst');
                        /* for (var i = 0; i < gmarkers.length; i++) {
                         gmarkers[i].setVisible(true);
                         circles[i].setVisible(false);
                         }*/
                    }

                }
            }

            return returnvalue;
        }

    </script>

    <script>

        jQuery(document).ready(function () {

            jQuery('.mapgrid li').click(function () {
                jQuery(".mapgrid li").removeClass("current");
                jQuery(this).addClass("current");
                var contactTopPosition = jQuery(this).position().top;
                jQuery(".mapgrid").animate({scrollTop: contactTopPosition});
            });

            setTimeout(function () {
                filteractive();
            }, 200);

            function filteractive() {
                var qsRegex;

                // init Isotope
                var buttonFilters = {};
                var buttonFilter;
                // init Isotope
                var grid = jQuery('.grid').isotope({
                    itemSelector: '.color-shape',
                    filter: function () {
                        var thisdata = jQuery(this);
                        var searchResult = qsRegex ? thisdata.text().match(qsRegex) : true;
                        var buttonResult = buttonFilter ? thisdata.is(buttonFilter) : true;
                        return searchResult && buttonResult;
                    },
                });

                var iso = grid.data('isotope');
                jQuery('.filters').on('click', '.team_filter_li ,.loc-filters ,.viewmodelist ,.hiddendata', function () {
                    var thisdata = jQuery(this);
                    var girdclass = thisdata.attr('class');
                    var timeoutlimit = 20;
                    if (girdclass == 'viewmodelist') {
                        timeoutlimit = 270;

                    }
                    setTimeout(function () {
                        initfilter();
                    }, timeoutlimit);


                    function initfilter() {

                        var buttonGroup = thisdata.parents('.button-group');
                        var filterGroup = buttonGroup.attr('data-filter-group');

                        buttonFilters[filterGroup] = thisdata.attr('data-filter');
                        // if (filterGroup == 'all_distance'  || filterGroup == 'filterview') {
                        getLatLog('no');
                        jQuery('.quicksearch').keyup();

                        buttonFilter = concatValues(buttonFilters);

                        grid.isotope();
                    }
                });

                // use value of search field to filter
                var quicksearch = jQuery('.quicksearch').keyup(debounce(function () {
                    var searchvalueinsert = quicksearch.val();
                    var myLength = quicksearch.val().length;
                    finalresult = 1;
                    if (myLength > 1) {
                        var finalresult = getLatLog(searchvalueinsert);
                        if (finalresult == 1) {
                            searchvalueinsert = 'search121d'
                        }
                    }
                    qsRegex = new RegExp(searchvalueinsert, 'gi');
                    grid.isotope();
                    setTimeout(function () {
                        allvisable(iso.filteredItems);
                    }, 1);

                    //  allmsg(1,'');
                }));

                var anyButtons = jQuery('.filters').find('.team_filter_li[data-filter=\"\"]');
                var buttons = jQuery('.team_filter_li');

                // change is-checked class on buttons
                jQuery('.button-group').each(function (i, buttonGroup) {
                    var buttonGroup = jQuery(buttonGroup);
                    buttonGroup.on('click', '.team_filter_li, .map_filler_item', function () {
                        buttonGroup.find('.is-checked').removeClass('is-checked');
                        jQuery(this).addClass('is-checked');
                    });
                });
            }

            function allmsg(errortype, msg) {
                //if we want to show the msg than use below (With Dropdow)
                //alert(errortype);
                if (jQuery('#quicksearch').val().length > 4) {
                    /* var errorst = jQuery("#errorstatus").val();
                     if (errortype == 0) {
                     if (errorst == 2) {
                     errortype = 2;
                     }
                     }*/

                    if (errortype == 0) {
                        // var errormsg = '<h3 class="center green"><?php //echo pll__('Your zip code is out of range (50 miles or greater) for our current locations. '); ?></h3>';
                        var errormsg = '<h3 class="center green"><?php echo pll__('Sorry, your search returned no results.'); ?></h3>';
                        jQuery(".not_found_msg").html(errormsg);
                        jQuery(".not_found_msg").show();
                    }
                    //if we want to hide the msg than use below
                    if (errortype == 1) {

                        jQuery(".not_found_msg").hide();
                    }

                    //if location avilable but out of radius then use below
                    if (errortype == 2) {
                        var errormsg = '<h3 class="center green"><?php echo pll__('Sorry, your search returned no results.'); ?></h3>';
                        jQuery(".not_found_msg").html(errormsg);
                        jQuery(".not_found_msg").show();
                    }
                }
                else {
                    jQuery(".not_found_msg").hide();
                }
            }

            function allvisable(isolist) {
                jQuery('.doc-list').removeClass('filtered-data');
                for (var ii = 0; ii < gmarkers.length; ii++) {
                    gmarkers[ii].setVisible(false);
                }
                if (isolist.length > 0) {

                    isolist.forEach(function (item, i) {
                        //if ( i < 6 ) {
                        idname = item.element.id;
                        //alert(idname);
                        if (idname != '') {
                            jQuery(item.element).addClass('filtered-data');
                            gmarkers[idname].setVisible(true);
                        }

                    });
                    if (isolist.length > 1) {
                        close_all_infowindows('markerfirst');
                    }
                    allmsg(1, '');
                }
                else {
                    close_all_infowindows('markerfirst');
                    allmsg(0, '');
                }
            }

            // flatten object by concatting values
            function concatValues(obj) {
                var value = '';
                for (var prop in obj) {
                    value += obj[prop];
                }
                return value;
            }


            // debounce so filtering doesn't happen every millisecond
            function debounce(fn, threshold) {
                var timeout;
                threshold = threshold || 300;
                return function debounced() {
                    clearTimeout(timeout);
                    var args = arguments;
                    var _this = this;

                    function delayed() {
                        fn.apply(_this, args);
                    }

                    timeout = setTimeout(delayed, threshold);
                };
            }

        });


        jQuery(function () {
            var hash = window.location.hash;
            if (jQuery(window).width() > 990) {
                hash && jQuery('ul.nav a[href=\"' + hash + '\"]').tab('show');
            }
            jQuery(window).resize(function () {
                if (jQuery(window).width() < 991) {
                    var hash2 = "#map-view";
                    hash2 && jQuery('ul.nav a[href=\"' + hash2 + '\"]').tab('show');
                    jQuery(".viewmodelist").trigger('click');
                }
                else {
                    hash && jQuery('ul.nav a[href=\"' + hash + '\"]').tab('show');
                    jQuery(".viewmodelist").trigger('click');
                }
            });
            jQuery('.nav-tabs a').click(function (e) {
                window.location.hash = this.hash;
            });
        });

        function showMyModalSetTitle(id, myTitle) {
            //alert(id);
            // jQuery('#myModalLabel').html(myTitle);
            var myBodyHtml = jQuery('#' + id).html();
            jQuery('.modal-body').html(myBodyHtml);
            jQuery('#location-modal').modal('show');
        }

        function activaTab(tab) {
            jQuery('.nav-tabs a[href="#' + tab + '"]').tab('show');
        };

        jQuery(document).ready(function () {
            <?php if($popupid != "")
            {?>
            showMyModalSetTitle('bio-content<?=$popupid?>', '<?=$popupid?>');
            <?php } ?>
            jQuery(".selection-menu").trigger('mouseenter');
            jQuery(".selection-menu").trigger('hover');
            jQuery(".selection-menu").trigger('mouseover');

        });
    </script>

    <?php


    return $map . $modelpopup;
}


