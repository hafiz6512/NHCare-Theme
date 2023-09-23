<?php

add_shortcode('ignyte_location_search_form', 'ignyte_location_search_form_shortcode');
add_shortcode('ignyte_locations', 'ignyte_locations_shortcode');

function ignyte_location_search_form_shortcode($atts)
{
    ob_start();
    global $post;
    $currentlang = get_bloginfo('language');
    $lslug=pll_current_language('slug'); ?>

    <div class="row location-search-controls margin-0">

        <span><?php echo pll__('Filter Results'); ?></span>

        <div class="input-icon"><input type="text" placeholder="<?php echo pll__("Zip Code"); ?>" class="quicksearch"
                                       value=""><span
                    class="search-click"><?php echo pll__('GO'); ?></span></div>

        <div class="dropdown filters">
            <?php $label = pll__('Services'); ?>
            <button class="btn dropdown-toggle btn-blue form-control" type="button" id="specialty-dropdown"
                    data-toggle="dropdown"><span><?= $label ?></span>
            </button>
            <ul class="dropdown-menu   button-group" role="menu" aria-labelledby="specialty-dropdown"
                data-filter-group='all_services'>
                <?php
                $specialties = query_posts(array(
                        'post_type' => 'ignyte_services',
                        'posts_per_page' => '-1',
                        'lang' => $lslug,
                        'meta_query' => array(
                            'relation' => 'OR',
                            array(
                                'key' => 'location-model-checkbox',
                                'compare' => 'NOT EXISTS' // doesn't work
                            ),
                            array(
                                'key' => 'location-model-checkbox',
                                'value' => 'no',

                            )
                        ),
                    )
                );
                ?>
                <li class="team_filter_li is-checked" data-filter=""><a role="menuitem" tabindex="-1"
                                                                        onclick="removelabel('<?= $label; ?>','<?php echo pll__("Any Service"); ?>','specialty-dropdown')"
                                                                        href="javascript:void(0);"><?php echo pll__("Any Service"); ?></a>
                </li>
                <?php foreach ($specialties as $spec) {
                    $removespace = preg_replace('/\s+/', '', $spec->post_title);
                    $listclass = $spec->post_name . '-service';
                    ?>
                    <li role="presentation" class="team_filter_li" data-filter=".<?= $listclass ?>"><a role="menuitem"
                                                                                                       tabindex="-1"
                                                                                                       onclick="updatelabel('<?= $label; ?>','<?= $spec->post_title; ?>','specialty-dropdown')"
                                                                                                       href="javascript:void(0);"><?= $spec->post_title ?></a>
                    </li>
                <?php } ?>

            </ul>
        </div>

    </div>
    <script>
        function updatelabel(thisval, label, did) {
            jQuery("#" + did).html('<span>' + thisval + '</span><div class="chosendata">' + label + '</div>');
            jQuery("#" + did).addClass("activetab");
        }
        function removelabel(thisval, label, did) {
            jQuery("#" + did).html('<span>' + thisval + '</span>');
            jQuery("#" + did).removeClass("activetab");

        }


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
    $slug=pll_current_language('slug');
    $args = array(
        'posts_per_page' => $number_posts,
        'order'          => $order,
        'orderby'        => $orderby,
        'lang' => $slug,
        'post_type'      => 'ignyte_locations',
        'post_status'    => 'publish');

    $post = get_posts($args);
    $list = '';
    $grid = '';
    $i = 0;
    $ii = 0;

    $tz = date_default_timezone_get();
    date_default_timezone_set('America/Los_Angeles');
    // date_default_timezone_set( 'Asia/Kolkata');
    $currentTime = time() + 0;
    //  $currentTime2 = time()+3600;
    $currentTime2 = date('H', $currentTime);

    $todayday = date('D', $currentTime);
    // echo $time=date("g:iA", strtotime($date2));

    $alldays = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
    $alldays2 = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $locationfilter = '';
    if (isset($_GET['loc'])) {
        $locationfilter = $_GET['loc'];
    }
    $popupid = '';
    foreach ($post as $p) {

        $listclass = '';
        $loc_services = "";
        $loc_resource = "";
        $meta_values = get_post_meta($p->ID);
        $fallback = $meta_values["ignyte-service-fallback-image"][0];
        $title = apply_filters('the_title', $p->post_title);
        $locationlink = preg_replace('/\s+/', '', $title);
        if ($locationlink == $locationfilter) {
            $popupid = $p->ID;
        }
        $fulltitle = $title;
        if ($meta_values['ignyte_location_longname'][0] != "") {
            $fulltitle = $meta_values['ignyte_location_longname'][0];
        }
        //  $content = apply_filters('the_content', $p->post_content);
        $content = $meta_values['ignyte_location_description'][0];
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'full');
        $image = "<img src='" . $thumbnail[0] . "' />";
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
            //var_dump($thisserv);
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
            //print_r($m_resource_type);
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
        $getmaptext = pll__("Get Directions");
        $appointmenttext = pll__("Phone");
        $streettext = pll__("Street Address");
        $servText = pll__("Services");
        $maptext = pll__("Locations");
        $FindADoctorAtThis = pll__("Find A Doctor At This Location");
        $Forlife_threateninemergencies = pll__("For life-threatening emergencies");
        $Call = pll__("Call");
        $forlife2 = pll__("or go to the nearest hospital emergency room");
        $Languages = pll__("Languages");
        $hourslabel = pll__("Hours");
        //This code is using for OpentAt Functionlity

        $daycount = 1;
        $firstLink1 = 1;
        $openmsg = '';
        foreach ($alldays as $daylist) {
            // echo $daylist.$daycount.'<br/>';
            //echo $alldays2[$daycount];
            $daylistlabel = pll__($alldays2[$daycount - 1]);
            $enable = $meta_values['enableday' . $daycount][0];
            $hideshow = $meta_values['hideshow' . $daycount][0];
            $openattime = $meta_values['open' . $daycount][0];
            $closeattime = $meta_values['close' . $daycount][0];
            $openfirst = preg_split('#(?<=\d)(?=[a-z])#i', $openattime);
            $closefirst = preg_split('#(?<=\d)(?=[a-z])#i', $closeattime);
            $OPT = $openfirst[0];
            if ($openfirst[1] == 'PM') {
                $OPT = $openfirst[0] + 12;
            }
            $COT = $closefirst[0];
            if ($closefirst[1] == 'PM') {
                $COT = $closefirst[0] + 12;
            }
            // echo $firstLink1;
            if ($firstLink1 == 1) {

                if ($todayday == $daylist) {

                    //   echo $title.'++'.$enable.'==enableday' . $daycount.'='.$todayday.'--'.$daylist.'<br/>';
                    if ($enable == 1 & $hideshow != 2) {

                        // echo $OPT.'=='.$COT.'==='.$currentTime;
                        if ($currentTime2 >= $OPT && $currentTime2 < $COT) {
                            $firstLink1 = 2;
                            $openmsg = pll__('Currently Open - Will Close AT') . ' ' . $closeattime;
                        } else {
                            $firstLink1 = 3;
                            $openmsg = pll__('Currently Closed - Opens') . ' ' . $daylistlabel . ' AT ' . $openattime;
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

        $list .= ' <div class="doc-list color-shape ' . $listclass . '">
     
                <div class="doctor-list loc-list vh-center" onClick="javascript:showMyModalSetTitle(\'bio-content' . $p->ID . '\',\'' . $p->ID . '\')">
                                <div class="col-md-11 col-sm-11 col-xs-10">
                                    <h2>' . $title . '</h2>
                                </div>
                                <div class="col-md-1 col-sm-1 col-xs-2 vh-center" style="height:100%;">
									<a class="btn hidden-text-btn icon arrow green"></a>                                   
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
                                                                  <span class="red">' . $servText . '</span>
                                                             ' . $loc_services . '                      
                                                             </div>';
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
            $opentime = pll__('Closed');
            $lunchattime = "";
            $enable = $meta_values['enableday' . $daycou][0];
            $openattime = $meta_values['open' . $daycou][0];
            $closeattime = $meta_values['close' . $daycou][0];
            $luncime = $meta_values['lunch' . $daycou][0];
            $showhide = $meta_values['hideshow' . $daycou][0];
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
                $list .= '<div class="hours">
                                                        <span class="red">' . $dat2[1] . '</span>
                                                       ' . $dat2[2] . '
                                                    </div>';
            }
            if ($dat2[0] == "ignyte_project_media_st") {

                $datsubcatlist = explode('hinit33', $d);
                $datsubcatlist2 = explode('hinit', $datsubcatlist[1]);
                $list .= '<div class="hours">
                                                        <span class="red">' . $dat2[1] . '</span>
                             <table class="table table-striped"><tbody>
                                                           ';
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

                $list .= '</tbody></table>
                                                      
                                                    </div>';
            }
        }

        $url = wp_get_attachment_url(get_post_thumbnail_id($p->ID));

        $list .= '<div class="location-model-note"><span class="red">' . $Forlife_threateninemergencies . '</span>
<p>' . $Call . ' <a href="tel:911" class="underline">911</a> ' . $forlife2 . '.</p></div></div>
                                            </div>
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
		if($currentlang == "en-US")  { 
			$find_doctor_url='/find-a-doctor/';
		} else { 
			$find_doctor_url='/es/buscar-medico/'; 
		} 
        
		$list .= ' <a class="btn white" href="http://maps.google.com/?daddr=' . $meta_values["ignyte_location_address"][0] . '" target="_blank">' . $getmaptext . '</a>

                                                    </div>
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
            $grid .= '<li class="color-shape ' . $listclass . '" id="marker' . $ii . '"  onclick="showmarker(' . $ii . ')"><span>' . $title . '</span><div style="display: none;">' . $meta_values["ignyte_location_address"][0] . '</div> </li>';
            $thisloc["address"] = $meta_values['ignyte_location_address'][0];
            $thisloc["address2"] = $address;
            $thisloc["phone1stlabel"] = $appointmenttext;
            $thisloc["phone"] = $meta_values['ignyte_location_phone'][0];
            $thisloc["phone2ndlabel"] = $meta_values['ignyte_location_phone2_label'][0];
            $thisloc["phone2nd"] = $meta_values['ignyte_location_phone2'][0];
            $thisloc["title"] = $title;
            $thisloc["ID"] = $p->ID;
            $thisloc["offeringType"] = $meta_values['offering-type'][0];
            $thisloc["lat"] = $meta_values['gllpLatitude'][0];
            $thisloc["log"] = $meta_values['gllpLongitude'][0];
            $locations[] = $thisloc;
            $ii++;
        } else {
            $grid .= '<li  class="color-shape ' . $listclass . '" >' . $title . ' <div style="display: none;">' . $meta_values["ignyte_location_address"][0] . '</div> </li>';

        }
        $i++;
    } //End foreach loop


    $center = array(
        'container_id' => 'map',
        'apiKey'       => 'AIzaSyD8j2K9aAc3sHRdKF91-JrUhoChlqHWKgI',
        'latitude'     => '33.46365',
        'longitude'    => '-117.355356',
        'icon'         => IGNYTE_LOCATIONS_PLUGIN_URL . '/images/marker-shadow.png',
    );

    ob_start();
    ?>
    <section id="location">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="tab-content">
                    <div id="list-view" class="tab-pane fade in active">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-offset-1 col-md-10">
                                    <div class="content grid">
                                        <?php echo $list; ?>
                                    </div>
                                    <div class="not_found_msg" style="display: none"><h3 class="center green"><?php echo pll__('Sorry, your search returned no results.'); ?></h3></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="map-view" class="tab-pane fade">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-offset-1 col-md-11">
                                    <div class="row margin-0">
                                        <div class="pin-desc">
                                            <p class="small"><img src="/wp-content/plugins/ignyte-locations/images/marker.svg" /><?php echo pll__("Full Service Location"); ?>
                                            </p>
                                            <p class="small"><img src="/wp-content/plugins/ignyte-locations/images/dot.svg" /><?php echo pll__("Specialty Location"); ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row margin-0 map-viewer">
                            <div class="map " id="<?php echo $center["container_id"]; ?>">
                            </div>
                        </div>
                        <div class="absolute-wrapper">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-offset-1 col-md-10">
                                        <div class="content">
                                            <div class="selection-menu">
                                                <ul class="grid mapgrid">

                                                    <li class="color-shape current" id="markerfirst"
                                                        onclick="showmarker('all')"><span><?php echo pll__("All Locations"); ?></span></
                                                    <li>
                                                        <?php echo $grid; ?>
                                                </ul>
                                                <div class="not_found_msg" style="display: none"><h3 class="center green"><?php echo pll__('Sorry, your search returned no results.'); ?></h3></div>
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
</div>'; ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $center["apiKey"]; ?>"></script>

    <script>
        var infowindow = null;
        var arrMarkers = {};
        var gmarkers = [];
        var map;
        // these are location
        var sites = [<?php $i = 0;
            $mapping = array();
            foreach($locations as $loc)
            {
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
            <?php $img = '/images/marker.svg'; if ($loc["offeringType"] == 'Specialty') {
            $img = '/images/dot.svg';
        }   $final = IGNYTE_LOCATIONS_PLUGIN_URL . $img; ?>

            <?php $imghover = '/images/coral.svg'; if ($loc["offeringType"] == 'Specialty') {
            $imghover = '/images/specialtylocation-coral.svg';
        }   $finalhover = IGNYTE_LOCATIONS_PLUGIN_URL . $imghover; ?>
            <?php if ($loc["offeringType"] == 'Specialty') {
            $type = 'Specialty Service Offering';
        } else {
            $type = 'Full Service Offering';
        }
            $functiondata="\'bio-content".$loc["ID"]."\',\'".$loc["ID"]."\'";
        ?>
            <?php   $contentdata = '<div id="popover-content-location" class="map-content popover-content"><p class="small">' . $type . '</p>';
            $contentdata .= '<p class="place red">' . $loc["title"] . '</p><p><span>'.pll__("Address").'</span></p><p>' . $loc["address2"] . '</p>' . $phone1st . $phone2nd . '<p><a class="underline" href="http://maps.google.com/?daddr=' . $loc["address"] . '" target="_blank">Get Directions</a></p><br/>';
            $contentdata .= '<a class="btn hidden-text-btn icon red"  onclick="javascript:showMyModalSetTitle('.$functiondata.')"><div class="hidden-text">'.pll__("View More").'</div><i class="fa fa-arrow-right"></i></a></div>'; ?>
            ['<?=$loc["title"];?>', <?=$loc["lat"];?>, <?=$loc["log"];?>, 4, '<?=$contentdata; ?>', '<?=$final;?>', '<?=$finalhover;?>', '<?=$i;?>'],
            <? $i++; }?>];

        function initMap() {

            var geometry = {
                //set map center
                lat: <?php echo $center["latitude"]; ?>, lng: <?php echo $center["longitude"]; ?>};
            var mapOptions = {
                zoom: 10,
                center: new google.maps.LatLng(geometry.lat, geometry.lng), //center map
                scrollwheel: false,
                disableDefaultUI: true, // a way to quickly hide all controls
                mapTypeControl: false,
                scaleControl: true,
                zoomControl: true,
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
            //setVisibility(id)
            if (id == "all") {
                close_all_infowindows();
                // google.maps.event.trigger(null, 'click')
                //   map.panTo((<?php echo $center["latitude"]; ?>, <?php echo $center["longitude"]; ?>))


            }
            else {
                //  alert(gmarkers[id].getPosition());

                google.maps.event.trigger(gmarkers[id], 'click')
                map.panTo(gmarkers[id].getPosition())
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
            initMap();

            setTimeout(function () {
                jQuery(document).on("click", ".gm-ui-hover-effect", function () {
                    close_all_infowindows('markerfirst');
                    //map.panTo(marker.getPosition())
                });
            }, 300);


        });

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
                //clear search field
                //jQuery('.quicksearch').val('');
                var qsRegex;
                var buttonFilter;
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
                jQuery('.filters').on('click', '.team_filter_li ,.viewmodelist', function () {
                    var thisdata = jQuery(this);
                    var girdclass = thisdata.attr('class');
                    var timeoutlimit = 10;

                    if (girdclass == 'viewmodelist') {
                        timeoutlimit = 170;

                    }

                    //  setInterval(initfilter, 100);
                    setTimeout(function () {
                        initfilter();
                    }, timeoutlimit);


                    function initfilter() {
                        // get group key
                        // alert();
                        var buttonGroup = thisdata.parents('.button-group');
                        var filterGroup = buttonGroup.attr('data-filter-group');
                        // set filter for group
                        buttonFilters[filterGroup] = thisdata.attr('data-filter');
                        // combine filters
                        buttonFilter = concatValues(buttonFilters);
                        // Isotope arrange
                        grid.isotope();
                        // setTimeout(set_team, 3000)

                        var resultount=iso.filteredItems.length;
                        //alert(resultount);
                        if(resultount==0)
                        {
                            jQuery(".not_found_msg").show();

                        }
                        else
                        {
                            jQuery(".not_found_msg").hide();
                        }
                    }
                });
                // use value of search field to filter
                var quicksearch = jQuery('.quicksearch').keyup(debounce(function () {

                    qsRegex = new RegExp(quicksearch.val(), 'gi');
                    grid.isotope();
                    var resultount=iso.filteredItems.length;
                    //alert(resultount);
                    if(resultount==0)
                    {
                        jQuery(".not_found_msg").show();

                    }
                    else
                    {
                        jQuery(".not_found_msg").hide();
                    }
                }));
                var anyButtons = jQuery('.filters').find('.team_filter_li[data-filter=\"\"]');
                var buttons = jQuery('.team_filter_li');


// change is-checked class on buttons
                jQuery('.button-group').each(function (i, buttonGroup) {
                    var buttonGroup = jQuery(buttonGroup);
                    buttonGroup.on('click', '.team_filter_li', function () {
                        buttonGroup.find('.is-checked').removeClass('is-checked');
                        jQuery(this).addClass('is-checked');
                    });
                });

                //  var insertId=jQuery(this).attr('id');
                //var gethtml=jQuery('#team-content-'+insertId).html();
                // jQuery('#insertdatapopup').html(gethtml);
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
                threshold = threshold || 100;
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
            if (jQuery(window).width() > 990 ) {
                hash && jQuery('ul.nav a[href=\"' + hash + '\"]').tab('show');
            }
            jQuery( window ).resize(function() {
                if (jQuery(window).width() < 991 ) {
                   var hash2="#list-view";
                    hash2 && jQuery('ul.nav a[href=\"' + hash2 + '\"]').tab('show');
                    jQuery(".viewmodelist").trigger('click');
                }
                else
                {
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


