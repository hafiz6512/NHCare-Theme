<?
add_shortcode('ignyte_provider_search_form', 'ignyte_provider_search_form_shortcode');
//add_action( 'wp_ajax_nopriv_ignyte_provider_search_get_results', 'ignyte_provider_search_get_results');
add_shortcode('ignyte_provider_search_get_results', 'ignyte_provider_search_get_results');

function ignyte_provider_search_form_shortcode($atts)
{
    ob_start();
    global $post;
    $currentlang = get_bloginfo('language');
    $lslug=pll_current_language('slug');
    ?>

    <div class="row doctor-search-controls">

        <span><?php echo pll__("Search For Doctors by Name");?></span>

        <div class="input-icon"><input type="text" placeholder="<?php echo pll__('Type here ...');?>" class="quicksearch" value=""></div>
        <span class=""><?php echo pll__("Search Medical Specialty and Location");?></span>

        <div class="dropdown filters">
            <?php  $label = pll__('Locations'); ?>
            <?php
                $getUrlLoactions = isset($_GET['location']) ? $_GET['location'] : '';
                $getLocationsTitle = str_replace('-', ' ', $getUrlLoactions);
                if ($getUrlLoactions) { ?>
                    <button class="btn dropdown-toggle btn-blue form-control activetab" type="button" id="doctor-location" data-toggle="dropdown">
                        <span><?=$label ?></span>
                        <div class="chosendata"><?php echo $getLocationsTitle; ?></div>
                    </button>
            <?php } else { ?>
                <button class="btn dropdown-toggle btn-blue form-control" type="button" id="doctor-location" data-toggle="dropdown">
                    <span><?=$label ?></span>
                </button>
            <?php } ?>
                <!-- <button class="btn dropdown-toggle btn-blue form-control" type="button" id="doctor-location" data-toggle="dropdown">
                    <span><?=$label ?></span>
                </button> -->
            <ul class="dropdown-menu button-group" role="menu" aria-labelledby="doctor-location" data-filter-group='doctor-location'>
                <?php
                    $specialties = query_posts(
                        array(
                            'post_type' => 'ignyte_locations',
                            'lang' => $lslug,
                            'posts_per_page' => '-1',
                            // 'post__not_in' => array(828, 827, 1251, 915)
                        )
                    );
                ?>

                <li class="team_filter_li is-checked" data-filter="">
                    <a
                        role="menuitem" tabindex="-1"
                        onclick="removelabel('<?=$label;?>','<?php  echo pll__('Any Location');?>','doctor-location')"
                        href="javascript:void(0);">
                            <?php  echo pll__('Any Location');?>
                    </a>
                </li>

                <?php
                    foreach ($specialties as $spec) {
                        $removespace = preg_replace('/\s+/', '', $spec->post_title);
                        $listclass = $removespace . '-location';
                    ?>
                    <li role="presentation" class="team_filter_li" data-filter=".<?= $listclass ?>">
                        <a
                            class="<?= $listclass ?>f"
                            role="menuitem"
                            tabindex="-1"
                            onclick="updatelabel('<?=$label;?>','<?= $spec->post_title; ?>','doctor-location')"
                            href="javascript:void(0);">
                            <?= $spec->post_title ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <?php /*
        <div class="dropdown filters">
            <?php if($currentlang == "en-US")  { $label='Specialty';} else { $label='Specialtyf'; } ?>
            <button class="btn dropdown-toggle btn-blue form-control" type="button" id="specility-dropdown"
                    data-toggle="dropdown"><span><?=$label ?></span></button>
            <ul class="dropdown-menu button-group" role="menu" aria-labelledby="specility-dropdown"
                data-filter-group='specility-dropdown'>
                <li role="presentation" class="team_filter_li" data-filter="">
                    <a role="menuitem" tabindex="-1"
                       onclick="removelabel('<?=$label;?>','<?= $currentlang == "en-US" ? "All Specility" : "All Specility" ?>','specility-dropdown')"
                    href="javascript:void(0);"><?= $currentlang == "en-US" ? "All Specility" : "All Specility" ?></a>
                </li>
                <?php   $terms2 = get_terms(array(
                        'taxonomy' => 'ignyte_specialty',
                'hide_empty' => true,
                ));
                ?>

                <?php  foreach($terms2 as $wcatTerm2) {
                           $removespace = preg_replace('/\s+/', '', $wcatTerm2->slug);
                    $listclass = $removespace . '-specialty';
                ?>
                <li role="presentation" class="team_filter_li" data-filter=".<?php echo $listclass; ?>">
                    <a
                        role="menuitem" tabindex="-1"
                        onclick="updatelabel('<?=$label;?>','<?= $wcatTerm2->name; ?>','specility-dropdown')"
                        href="javascript:void(0);">
                        <?php echo $wcatTerm2->name; ?>
                    </a>
                </li>
                <?php    } ?>
            </ul>
        </div>
        */
       ?>
        <div class="dropdown filters">
            <?php $label = pll__("Services");?>
            <button class="btn dropdown-toggle btn-blue form-control" type="button" id="specialty-dropdown" data-toggle="dropdown">
                <span><?=$label ?></span>
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
                <li class="team_filter_li is-checked" data-filter="">
                    <a
                        role="menuitem"
                        tabindex="-1"
                        onclick="removelabel('<?=$label;?>','<?php echo pll__("Any Service");?>','specialty-dropdown')"
                        href="javascript:void(0);">
                        <?php echo pll__("Any Service");?>
                    </a>
                </li>
                <?php foreach ($specialties as $spec) {
                    $removespace = preg_replace('/\s+/', '', $spec->post_title);
                    $listclass = $removespace . '-service';
                    ?>
                    <li role="presentation" class="team_filter_li" data-filter=".<?= $listclass ?>">
                        <a
                            role="menuitem"
                            tabindex="-1"
                            onclick="updatelabel('<?=$label;?>','<?= $spec->post_title; ?>','specialty-dropdown')"
                            href="javascript:void(0);">
                            <?= $spec->post_title ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>

        <div class="dropdown filters">
            <?php if($currentlang == "en-US")  { $label='Gender';} else { $label='Género'; } ?>
            <button class="btn dropdown-toggle btn-blue form-control" type="button" id="gender-dropdown" data-toggle="dropdown">
                <span><?=$label ?></span>
            </button>
            <ul class="dropdown-menu button-group" role="menu" aria-labelledby="gender-dropdown" data-filter-group='all_male'>
                <li role="presentation" class="team_filter_li" data-filter="">
                    <a
                        role="menuitem"
                        tabindex="-1"
                        onclick="removelabel('<?=$label;?>','<?php echo  pll__('No Preference'); ?>','gender-dropdown')"
                        href="javascript:void(0);">
                        <?php echo pll__('No Preference'); ?>
                    </a>
                </li>
                <li role="presentation" class="team_filter_li" data-filter=".Man">
                    <a
                        role="menuitem"
                        tabindex="-1"
                        onclick="updatelabel('<?=$label;?>','<?php echo pll__('Male'); ?>','gender-dropdown')"
                        href="javascript:void(0);">
                        <?php echo pll__('Male'); ?>
                    </a>
                </li>
                <li role="presentation" class="team_filter_li" data-filter=".Female">
                    <a
                        role="menuitem"
                        tabindex="-1"
                        onclick="updatelabel('<?=$label;?>','<?php echo pll__('Female'); ?>','gender-dropdown')"
                        href="javascript:void(0);">
                        <?php echo pll__('Female'); ?>
                    </a>
                </li>

            </ul>
        </div>

        <div class="dropdown filters loc_filters">
            <?php
                $all_location_label = pll__('All Locations');
                $location_label = pll__('Locations Category');
                $nbl_label = pll__('Neighborhood');
                $afl_label = pll__('Affiliate');
            ?>

            <?php
                $getUrlProviders = isset($_GET['providers']) ? $_GET['providers'] : '';
                if ($getUrlProviders) { ?>
                    <button class="btn dropdown-toggle btn-blue form-control activetab" type="button" id="locationFilters" data-toggle="dropdown">
                        <span><?=$location_label ?></span>
                        <div class="chosendata"><?php echo $getUrlProviders; ?></div>
                    </button>
            <?php } else { ?>
                <button class="btn dropdown-toggle btn-blue form-control" type="button" id="locationFilters" data-toggle="dropdown">
                    <span><?php echo $all_location_label; ?></span>
                </button>
            <?php } ?>

            <ul class="dropdown-menu button-group" role="menu" aria-labelledby="locationFilters" data-filter-group='all_location'>

                <li class="team_filter_li is-checked" data-filter="">
                    <a role="menuitem" tabindex="-1" onclick="removelabel('<?= $all_location_label; ?>','<?php echo $all_location_label; ?>','locationFilters')" href="javascript:void(0);"><?php echo $all_location_label; ?></a>
                </li>

                <li role="presentation" class="team_filter_li neighborhood-providersf" data-filter=".neighborhood-providers">
                    <a role="menuitem" tabindex="-1" href="javascript:void(0);" onclick="updatelabel('<?= $location_label; ?>','<?= $nbl_label; ?>','locationFilters','')"><?php echo $nbl_label; ?></a>
                </li>
                <li role="presentation" class="team_filter_li affiliate-providersf" data-filter=".affiliate-providers">
                    <a role="menuitem" tabindex="-1" href="javascript:void(0);" onclick="updatelabel('<?= $location_label; ?>','<?= $afl_label; ?>','locationFilters','')"><?php echo $afl_label; ?></a>
                </li>
            </ul>
        </div>

    </div>
    <script>
        function updatelabel(thisval,label,did){
            jQuery("#"+did).html('<span>'+thisval+'</span><div class="chosendata">'+label+'</div>');
            jQuery("#"+did).addClass("activetab");
        }

        function removelabel(thisval,label,did){
            jQuery("#"+did).html('<span>'+thisval+'</span>');
            jQuery("#"+did).removeClass("activetab");
        }

        jQuery(document).ready(function ($) {
            setTimeout(function () {
                jQuery('#locationFilters').removeClass('disabled');
            }, 800);

            // var fiterGrid = jQuery('.filters');
            // var fiterGrid = Isotope.data( $('.Fallbrook-location')[0] );
        });

        // jQuery(window).load(function(){
        //     var isoConteiner = jQuery('.filters');
        //     setTimeout(function () {
        //         isoConteiner.isotope({
        //             filter: '.Fallbrook-location'
        //         });
        //     }, 300);
        // });

    </script>

    <?php
    wp_reset_query();
    $html = ob_get_contents();
    ob_end_clean();

    return $html;
}


function ignyte_provider_search_get_results($atts){

    $specialty = sanitize_text_field($_POST["data"]["specialty"]);
    $dlocation = sanitize_text_field($_POST["data"]["dlocation"]);
    $gender = sanitize_text_field($_POST["data"]["gender"]);
    $language = sanitize_text_field($_POST["data"]["language"]);
    $providername = sanitize_text_field($_POST["data"]["providername"]);
    $showall = sanitize_text_field($_POST["data"]["showall"]);
    $orderby = sanitize_text_field($_POST['data']['orderby']);
    // $currentlang = sanitize_text_field($_POST['data']['currentlang']);
    $currentLang = pll_current_language();
    $lslug=pll_current_language('slug');
    $prevpage = 1;
    $defaultload =12;
    $providertype='grid-view';
    $firstload = -1;
    if ($_GET['type']) {
        $providertype=$_GET['type'];
    }
	if (isset($_GET['location'])) {
        $selected_loc= sanitize_text_field($_GET['location']);
		$ignyte_location = str_replace( '-', ' ', $selected_loc );
		$location = ucwords( $ignyte_location );
    }
    $nextpage = $prevpage + 1;
    $args = array(
        'post_type'      => 'ignyte_provider',
        'meta_query' => array(
			array(
				'key' => 'ignyte_locations[]',
				'value' => $location,
				'compare' => 'LIKE'
			)
		) ,
        'post_status'    => 'publish',
        'lang' => $lslug,
        'posts_per_page' => $firstload,
    );
    $searchresults = get_posts($args);
    $totalres = count($searchresults);
    $i = 0;
    $firsttab = true;
    $gird = '';
    $list = '';
    $prefix='';
    if ($currentlang=="es-ES"){
        $prefix='/es';
    }

    foreach ($searchresults as $doc) {

        /*  if($firsttab && $i==0  ){
        echo "<div id='searchtab_".$tabindex."' class='active'>"; //Opening first tab
            $tabindex++;
            }
            if(!$firsttab && $i==$limitperpage ){
            $i=0;
            echo "<div id='searchtab_".$tabindex."' class='hidden' >"; //Opening hidden tabs
                $tabindex++;
                }*/

        $docmeta = get_post_meta($doc->ID);
        //var_dump($docmeta);
        // $url = wp_get_attachment_url(get_post_thumbnail_id($doc->ID),'medium');
        $url = get_the_post_thumbnail_url($doc->ID, 'medium_large');
        //$title = apply_filters('the_title', $loop->post_title);
        if($url=="")
        {
            $url='/wp-content/uploads/2019/04/neighborhood-placeholder.jpeg';
        }
        $content = $doc->post_content;
        $servicelabel = pll__('Services');
        $docservices = array_reverse(unserialize($docmeta['ignyte_services[]'][0]));

        $locationlabel = $currentLang == "en" ? "Locations" : "Ubicaciones";
        $doclocations = array_reverse(unserialize($docmeta['ignyte_locations[]'][0]));
        $listservice = '';
        $girdservice = '';
        $listclass = '';

        $m_specialty = wp_get_post_terms( $doc->ID, 'ignyte_specialty' );
        $docspec='';
        $spececount=1;
        foreach($m_specialty as $specialty) {
            if($spececount<2) {
                $docspec .=  $specialty->name;
            }
            $removespace2 = preg_replace('/\s+/', '', $specialty->slug);
            $listclass .= $removespace2 . '-specialty ';
            // $customoption .=$service->slug.' ';
            $spececount++;
        }

        $docspec = rtrim($docspec, ', ');
        $servicecount=1;
        $labelclass="bg-green";

        foreach ($docservices as $docserv) {

            if($servicecount<3) {
                if($servicecount<2) {
                    $girdservice=' <p class="bg-green news-tiles">'. $docserv . '</p>';
                }
                $listservice .= $docserv.', ';
            }
            $removespace = preg_replace('/\s+/', '', $docserv);
            $listclass .= $removespace . '-service ';
            $servicecount++;
        }
        $listservice = rtrim($listservice, ', ');
        $locacount=1;
        $locationlist = '';
        foreach ($doclocations as $location) {

            if($locacount<3) {

                $locationlist .=  $location.', ';

            }
            $removespace = preg_replace('/\s+/', '', $location);
            $listclass .= $removespace . '-location ';
            $locacount++;
        }

        $locationlist = rtrim($locationlist, ', ');
        $docmale = array_reverse(unserialize($docmeta['ignyte_gender[]'][0]));
        foreach ($docmale as $docm) {
            $removespace2 = preg_replace('/\s+/', '', $docm);
            $listclass .= $removespace2 . ' ';
        }

        // Add providers category class
        $providerCategories =  get_the_terms($doc->ID, 'ignyte_category');

        $providersCatName = '';

        if (!empty($providerCategories)) {
            foreach ($providerCategories as $term) {
                $listclass .= $term->slug . ' ';
                $providersCatName = str_replace(' Provider', '', $term->name);
            }
        }

        $gird .= '<div class="col-xl-3 col-md-4 col-sm-6 col-xs-12 doctor-grid color-shape ' . $listclass . '"  onclick=" javascript:location.href=\'' . get_permalink($doc->ID). '\'" >
            <div class="doctor-profile">
                <div class="doctor-image"  style="background-image:url(' . $url . ')">';
                if(!empty($providersCatName)) {
                    $gird .= '<p class="bg-green news-tiles">' .$providersCatName. ' </p>';
                }
        $gird .= '</div>

                <div class="doctor-bio">
                    <p class="firstName">' . $docmeta['ignyte-provider-fname'][0] . '</p>
                    <p class="lastName">' . $docmeta['ignyte-provider-lname'][0];
        if($docmeta['ignyte-provider-position'][0]!="") {
            $gird .= ', ' . $docmeta['ignyte-provider-position'][0];
        }
        $gird .= '</p>';
        $gird .= '<p class="Specialty green"> '.$docspec.'</p>';

        $gird .= '<p class="service-name underline">'.$locationlist.'</p>
                    <a class="btn hidden-text-btn icon arrow green" href="' . get_permalink($doc->ID) . '"></a>
                </div>
            </div>
        </div>';

        $list .= '<div class="doc-list color-shape ' . $listclass . '" onclick=" javascript:location.href=\'' . get_permalink($doc->ID). '\'"  >
            <div   data-targetvalue="bio-content' . $doc->ID . '" class="doctor-list vh-center" >
                <div class="row margin-0">
				<div class="col-md-5 col-sm-5 col-xs-12 name">
                    <h5>' . $docmeta['ignyte-provider-fname'][0].' '.$docmeta['ignyte-provider-lname'][0] ;
        if($docmeta['ignyte-provider-position'][0]!="") {
            $list .= ', ' . $docmeta['ignyte-provider-position'][0];
        }
        $list .= '</h5></div>
                <div class="col-md-offset-1 col-md-2 col-sm-3 col-xs-5">';
        $list .= '<p class="service-name green">'.$listservice.'</p>';
        $list .= '</div>
                <div class="col-md-3 col-sm-3 col-xs-7">';
        /* $locationlist = '';
        foreach ($doclocations as $docloc) {
        $list .= '<p class="service-name">' . $docloc . '</p>';
        $loc = preg_replace('/\s+/', '', $docloc);
        $locationlist .= '<li><a href="'.$prefix.'/locations/">'.$loc . '</a></li>';
        }*/
        $list .='<p class="service-name underline">'.$locationlist.'</p>';

        $list .= '</div>
                <div class="col-md-1 col-sm-1 col-xs-12 right padding-0 button">
                    <a class="btn hidden-text-btn icon green arrow add-more" ></a>
                </div>
				</div>
            </div>

        </div>';
        $i++;
    }

    $args22 = array(
        'post_type'      => 'ignyte_provider',
        'post_status'    => 'publish',
        'lang' => $lslug,

    );
    $postscount = new WP_Query( $args22 );
    $total_posts = $postscount->found_posts;
    //echo $total_posts . ' custom posts. ';
    $paging = "";
    //if ($totalres < $total_posts) {
    $paging = '<div class="row load-more">
            <div class="bottom-paginations">
                <p class="bottom-pagination">'.pll__('Showing').' ' . $totalres . ' '.pll__('of'). ' “' . $total_posts . ' '.pll__('Results'). '”.</p>

            </div>
            <div class="pagination-count center">
                <a class="btn hidden-text-btn icon green load-more-provider"><div class="hidden-text">'.pll__('Show More').'</div></a>
            </div>
        </div>';
    // }

    $final = '
        <div class="container">
            <div class="thepatterns doctor-bg-1"><div class="pattwrap">
                <div class="pattblock blue right"></div>
            </div>
            </div>
        </div>
		 <div class="container">
            <div class="thepatterns doctor-bg-3"><div class="pattwrap">
                <div class="pattblock blue right"></div>
            </div>
            </div>
        </div>
        <div class="row margin-0">
            <div class="col-lg-12 col-md-12 col-xs-12 padding-0">
                <div class="tab-content ">';
    if($providertype=='list-view') {
        $final .= '<div id="list-view" class="">
                        <div class="row content grid button-group filters" id="listview-internal">
                            ' . $list . '
                        </div>
                        <span class="paggertop"></span>
                        ' . $paging . '
                    </div>';
    }
    if($providertype=='grid-view') {
        $final .= ' <div id="grid-view">
                        <div class="row grid">' . $gird . '</div>
                        ' . $paging . '
                    </div>';
    }

    $final .= '<div class="not_found_msg" style="display: none"><h3 class="center green">' . pll__('Sorry, your search returned no results.') . '</h3></div>
            </div>
            </div>
        </div>
        <div class="container">
            <div class="thepatterns doctor-bg-2">
                <div class="pattwrap">
                    <div class="pattblock grey flip right"></div>
                </div>
            </div>
        </div>';
    $script="";
    $location='';

    if($providertype=='list-view') {

        $script .= "<script>
            jQuery(document).ready(function ()
            {
                jQuery(\".filters .nav-tabs li\").removeClass(\"active\");
                jQuery(\".filters .nav-tabs li\").eq(0).addClass(\"active\");
            });  </script>";
    }
    if($providertype=='grid-view') {

        $script .= "<script>
            jQuery(document).ready(function ()
            {
                jQuery(\".filters .nav-tabs li\").removeClass(\"active\");
                jQuery(\".filters .nav-tabs li\").eq(1).addClass(\"active\");
            });  </script>";
    }

    if(isset($_GET['location'])) {
        $location=$_GET['location'];
        $script .= "<script>
            jQuery(document).ready(function ()
            {
                setTimeout(function(){
                    jQuery('.".$location."-locationf').trigger('click');
                    jQuery('.".$location."-locationf a').trigger('click');
                }, 280);
            });  </script>
        ";
    }

    if(isset($_GET['providers'])) {
        $getProviders = $_GET['providers'];
        $script .= "<script>
            jQuery(document).ready(function ()
            {
                setTimeout(function(){
                    jQuery('.".$getProviders."-providersf').trigger('click');
                }, 280);
            });  </script>
        ";
    }

    $script .= "
        <script>

            jQuery(document).ready(function ()
            {

                setTimeout(function(){
                    filteractive();
                }, 1);


                function filteractive()
                {
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
                        layoutMode: 'masonry',
                        filter: function () {
                            var thisdata = jQuery(this);
                            var searchResult = qsRegex ? thisdata.text().match(qsRegex) : true;
                            var buttonResult = buttonFilter ? thisdata.is(buttonFilter) : true;

                            return searchResult && buttonResult;
                        },
                    });
                    var iso = grid.data('isotope');


               jQuery('.filters').on('click', '.team_filter_li', function () {
                        var thisdata = jQuery(this);
                        var girdclass=thisdata.attr('class');

                            initfilter();
                            // jQuery(this).data('clicked', true);
                          loadMore(initShow);

                        function initfilter()
                        {
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

                        }
                    });



                    // use value of search field to filter
                    var quicksearch = jQuery('.quicksearch').keyup(debounce(function () {
                    grid.find(\".hidden\").removeClass(\"hidden\");
                        qsRegex = new RegExp(quicksearch.val(), 'gi');
                        grid.isotope();

                      loadMore(initShow);

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

                     //****************************
                    // Isotope Load more button
                    //****************************
                    var initShow = 12; //number of items loaded on init & onclick load more button
                    var counter = initShow; //counter for load more button
                    var iso = grid.data('isotope'); // get Isotope instance
                      var taotalrac =".$total_posts.";
                    loadMore(initShow); //execute function onload
                    function loadMore(toShow) {
                  grid.find(\".hidden\").removeClass(\"hidden\");

                        var hiddenElems = iso.filteredItems.slice(toShow, iso.filteredItems.length).map(function(item) {
                            return item.element;
                        });

                        jQuery(hiddenElems).addClass('hidden');
                        grid.isotope('layout');
                        //when no more to load, hide show more button
                          taotalrac=hiddenElems.length+toShow;
                        if (hiddenElems.length == 0) {
                            jQuery(\".load-more\").hide();
                        } else {
                            jQuery(\".load-more\").show();
                        };
                        var resultount=iso.filteredItems.length;
                        //alert(resultount);
                              if(resultount==0)
                              {
                                  jQuery(\".not_found_msg\").show();

                              }
                              else
                                  {
                                   jQuery(\".not_found_msg\").hide();
                                  }
                           htmlString='<div class=\"bottom-paginations\"><p class=\"bottom-pagination\">".pll__('Showing')." '+toShow+' ".pll__('of')."  “'+taotalrac+' ".pll__('Results')."”.</p></div>'+
                        '<div class=\"pagination-count center\"><a class=\"btn hidden-text-btn icon green load-more-provider\"><div class=\"hidden-text\">".pll__('Show More')."</div></a></div>';
                    jQuery('.load-more').html( htmlString );

                    }

                    //append load more button
                    //grid.after('<div class=\"row\" id=\"load-more\"> Load More</div>');

                    //when load more button clicked
                    jQuery(\".load-more\").click(function() {
                        if (jQuery('.filters').data('clicked')) {
                            //when filter button clicked, set initial value for counter
                            counter = initShow;
                            jQuery('.filters').data('clicked', false);
                        } else {
                            counter = counter;
                        };

                        counter = counter + initShow;
                        loadMore(counter);
                    });

                    //when filter button clicked
                    jQuery(\".filters .team_filter_li\").click(function() {
                      var getdata=jQuery(this).attr('data-filter');

                    if(getdata!='')
                        {
                         grid.find(\".hidden\").removeClass(\"hidden\");
                             jQuery(\".load-more\").hide();

                            }
                            else
                       {
                        // grid.find(\".color-shape\").addClass(\"hidden\");
                           // jQuery(this).data('clicked', true);
                        //var initShow = 12;
                         // loadMore(initShow);
                          // jQuery(\".load-more\").show();


                        }
                    });


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



            function showMyModalSetTitle(id,myTitle) {
//alert(id);
                // jQuery('#myModalLabel').html(myTitle);
                var myBodyHtml=jQuery('#'+id).html();
                jQuery('.modal-body').html(myBodyHtml);
                jQuery('#doctor-modal').modal('show');
            }
            function activaTab(tab){
                jQuery('.nav-tabs a[href=\"#' + tab + '\"]').tab('show');
            };

            jQuery(function(){
                var hash = window.location.hash;
                hash && jQuery('ul.nav a[href=\"' + hash + '\"]').tab('show');
                jQuery('.nav-tabs a').click(function (e) {
                    window.location.hash = this.hash;
                });
            });

        </script>
        ";
    if($_GET['pp'])
    {
        $script .='<script>jQuery(document).ready(function () {
            // Handler for .ready() called.
            jQuery(\'html, body\').animate({
            scrollTop: jQuery(".paggertop").offset().top-300
        }, 1000);
        }); </script>';
    }

    $modelpopup = '<div id="doctor-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" >
            <div class="vertical-alignment-helper">
                <div class="modal-dialog modal-lg vertical-align-center">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Close ×  </button>
                        </div>
                        <div class="modal-body">
                        </div>

                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>';

    return $final . $script . $modelpopup;
    ?>

    <?php
}
