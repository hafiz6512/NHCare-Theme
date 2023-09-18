<?php
add_shortcode('our_team', 'ignyte_team_shortcode');

function childtexnomy($term_id,$taxonomy)
{
    $return22='';
    $returnf="";
    $args = array(
        'parent' => $term_id // to get only parent terms
    );
    $terms = get_terms( $taxonomy, $args );

    foreach( $terms as $term ) {

        $return22 .="<li class='team_filter_li submenuchild' data-filter='.".$term->slug."'>".$term->name."</li>";

    }
    if($return22!="") {
        $returnf = '<ul class="subsubmenu-mobile level-two" id="'.$term_id.'fdropdown">'.$return22.'</ul>';
    }
    return $returnf;
}

function ignyte_team_shortcode($atts)
{
    //var_Dump($atts);
    /* if using atts */
    extract(shortcode_atts(array(
        'number_posts' => '-1',
        'order'        => 'ASC',
        'orderby'      => 'post_date',
    ), $atts));

    $filterdata='';

    $filterdata .="<div class='container'><div class='row'><div class='col-md-12 team-row'><div class='col-lg-2 col-md-12 col-sm-12 team-subtitle'><h3>Team</h3></div>
    <div class='col-lg-3 col-md-12 col-sm-12 searchbar'><p><input type='text' class='quicksearch' placeholder='SEARCH BY NAME'/><i class='fa fa-search pull-right'></i></p></div>
    <div class='col-lg-7 col-md-12 col-sm-12 team-filter'><div class='row'><p class='title d-block d-md-none'>FILTER RESULTS<i class='fa fa-sliders-h'></i></p>
        <ul class='filters' id='icons-wrapper'>";
    //Start A-Z list
    $alphas = range('A', 'Z');
    //Start of member_role
    $filterdata .=" <li class='icons-list dropdown_avilable' id='a_zf'>
                Last Name A-Z  <i class='fa fa-chevron-down pull-right'></i>
                <ul class='dropdown-mobile level-one button-group' data-filter-group='last_name' id='a_zfdropdown'>";
    $filterdata .='<li class="team_filter_li is-checked" data-filter="">A-Z</li>';
    foreach($alphas as $alpha) {
        //$subtitle=get_tax_meta($wcatTerm->term_id,'team_role_subtitle');
        $filterdata .='<li class="team_filter_li " data-filter=".'.$alpha.'">'.$alpha.'</li>';
    }
    $filterdata .='</ul></li>';
    //End of A-Z

    //Start of member_role
    /*  $terms = get_terms(array(
    'taxonomy' => 'member_role',
    'hide_empty' => true,
    ));

    $filterdata .=" <li class='icons-list dropdown_avilable' id='member_rolef'>
        All Roles <i class='fa fa-chevron-down pull-right'></i>
        <ul class='dropdown-mobile level-one button-group' data-filter-group='all_role' id='member_rolefdropdown'>";
            $filterdata .='<li class="team_filter_li is-checked" data-filter="">All</li>';
            foreach($terms as $wcatTerm) {
            //$subtitle=get_tax_meta($wcatTerm->term_id,'team_role_subtitle');
            $filterdata .='<li class="team_filter_li " data-filter=".'.$wcatTerm->slug.'">'.$wcatTerm->name.'</li>';
            $passId=$wcatTerm->term_id;
            }
            $filterdata .='</ul></li>';
    //End of member_role*/

    //Start of services
    $terms2 = get_terms(array(
        'taxonomy' => 'member_services',
        'hide_empty' => true,
    ));

    $filterdata .=" <li class='icons-list dropdown_avilable'  id='member_servicesf'>
                Division <i class='fa fa-chevron-down pull-right'></i>
                <ul class='dropdown-mobile level-one button-group' data-filter-group='all_services' id='member_servicesfdropdown'>";
    $filterdata .='<li class="team_filter_li is-checked" data-filter="">All</li>';
    foreach($terms2 as $wcatTerm2) {
        $filterdata .='<li class="team_filter_li " data-filter=".'.$wcatTerm2->slug.'">'.$wcatTerm2->name.'</li>';
        // $passId=$wcatTerm2->term_id;
    }
    $filterdata .='</ul></li>';
    //End of services

    $taxonomy_name = 'member_location';
    $queried_object = get_queried_object();
    $term_id = $queried_object->term_id;
    $terms3 = get_terms( $taxonomy_name, array( 'parent' => $term_id, 'hide_empty' => false ) );
/*
    //Start of location
    $terms3 = get_terms(array(
        'taxonomy' => 'member_location',
        'hide_empty' => true,
    ));*/

    $filterdata .=" <li class='icons-list dropdown_avilable' id='member_locationf'>
                Office <i class='fa fa-chevron-down pull-right'></i>
                <ul class='dropdown-mobile level-one button-group' data-filter-group='all_location' id='member_locationfdropdown'>";
    $filterdata .='<li class="team_filter_li is-checked" data-filter="">All</li>';
    foreach($terms3 as $wcatTerm3) {
        $parent = $wcatTerm3->parent;
        if ( $parent=='0' ) {
            $resultd = childtexnomy($wcatTerm3->term_id, 'member_location');
            $idbmenuId = "";
            $dropclass = "";
            if ($resultd != "") {
                $idbmenuId = $wcatTerm3->term_id . "f";
                $dropclass = "dropdown_avilable submenu";
            }
            $filterdata .= '<li class="team_filter_li ' . $dropclass . '" data-filter=".' . $wcatTerm3->slug . '" id="' . $idbmenuId . 'f">';
            if ($resultd != "") {
                $filterdata .= '<span>' . $wcatTerm3->name . '<i class="fa fa-plus pull-right"></i></span>';
            } else {
                $filterdata .= $wcatTerm3->name;
            }
            // $passId=$wcatTerm2->term_id;
            $filterdata .= childtexnomy($wcatTerm3->term_id, 'member_location');
            $filterdata .= '</li>';
        }
    }
    $filterdata .='</ul></li>';
    //End of location

    $filterdata .="</ul><div class='button--reset'><button type='button' class='btn refresh-btn'>REFRESH<i class='fa fa-redo-alt pull-right'></i></button></div></div></div></div></div></div>";



    $args = array(
        'posts_per_page' => $number_posts,
        'orderby'        => $orderby,
        'order'          => $order,
        'post_type'      => 'ignyte_team',
        'post_status'    => 'publish');

    $post = get_posts($args);
    $return = "";
    $return2="";
    $i = 0;
    foreach ($post as $p) {
        $customoption="";
        /*$m_role = wp_get_post_terms( $p->ID, 'member_role');
        foreach($m_role as $role) {
        $customoption .=$role->slug.' ';
        }
        */
        $m_services = wp_get_post_terms( $p->ID, 'member_services' );

        foreach($m_services as $service) {
            $customoption .=$service->slug.' ';
        }
        $m_location = wp_get_post_terms( $p->ID, 'member_location');
        foreach($m_location as $loc) {
            $customoption .=$loc->slug.' ';
        }
        $post_meta = get_post_meta($p->ID);
        $title = apply_filters('the_title', $p->post_title);
        $content = apply_filters('the_content', $p->post_content);
        $thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'full');
        $image = "'" . $thumbnail[0] . "'";
        $team_title = $post_meta['ignyte_team_title_content'][0];
        $lastname = $post_meta['ignyte_team_last_name'][0];
        $str2 = substr($lastname, 0,1);
        $finalupper=strtoupper($str2);
        $customoption .=$finalupper.' ';


        $return .= '<div id="' . $p->ID . '" class="col-xs-12 col-sm-12 col-md-6 col-lg-3 teammember color-shape '.$customoption.'" data-toggle="modal" data-target="#teammember_specify">
    <!--<a href="#view-team-content-' . $p->ID . '" >-->
    <div class="img-wrap" style="background-image:url(' . $image . ')">
    </div>
    <hgroup>
        <h5>' . $title . '</h5>
        <h6>' . $team_title . '</h6>
    </hgroup>
    <!-- </a>-->
</div>';
        $return2 .= '<div id="team-content-' . $p->ID . '" class="panel-collapse collapse member-bio tmemberpos-' . $i . '">
    <h3>' . $title . '</h3>
    <h5>' . $team_title . '</h5><hr class="green"></hr>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
            ' . $content . '
        </div>
        <div class="col-xs-12 col-sm-12 col-md-5 offset-md-1 right-content"><div>';
        if ($post_meta['ignyte_credentials'][0] != "") {
            $return2 .= '<div class="credentials">' . $post_meta['ignyte_credentials'][0] . '</div>';
        }
        if ($post_meta['ignyte_education'][0] != "") {
            $return2 .= '<div class="education">' . $post_meta['ignyte_education'][0] . '</div>';
        }
        if ($post_meta['ignyte_team_email'][0] != "") {
            $return2 .= '<div class="email"> <a href="mailto:' . $post_meta['ignyte_team_email'][0] . '">Send Email</a></div>';
        }
        if ($post_meta['ignyte_team_phone_no'][0] != "") {
            $return2 .= '<div class="phone">P ' . $post_meta['ignyte_team_phone_no'][0] . '</div>';
        }
        if ($post_meta['ignyte_team_mobile_no'][0] != "") {
            $return2 .= '<div class="phone">M ' . $post_meta['ignyte_team_mobile_no'][0] . '</div>';
        }
        if ($post_meta['ignyte_sociel_link'][0] != "") {
            $return2 .= '<div class="bio-social-link linkedIn"><a target="_blank" href=" ' . $post_meta['ignyte_sociel_link'][0] . '"><i class="fab fa-linkedin-in"></i></a></div>';
        }
        if ($post_meta['ignyte_team_vcard'][0] != "") {
            $return2 .= '<span class="seperator">|</span><a target="_blank" href=" ' . $post_meta['ignyte_team_vcard'][0] . '"><i class="fa fa-address-card"></i><div class="v-card">VCard</div></a>';
        }
        /*   if ($post_meta['ignyte_sociel_twitter'][0] != "") {
        $return2 .= '<div class="bio-social-link twitter"><a target="_blank" href=" ' . $post_meta['ignyte_sociel_twitter'][0] . '"><i class="fab fa-twitter"></i></a></div>';
        }
        if ($post_meta['ignyte_sociel_facebook'][0] != "") {
        $return2 .= '<div class="bio-social-link facebook"><a target="_blank" href=" ' . $post_meta['ignyte_sociel_facebook'][0] . '"><i class="fab fa-facebook-f"></i></a></div>';
        }*/
        $return2 .= '</div></div>
    </div>
</div>';
        $i++;
    }

    $return = "<div class='team-container'>
    <div id='memberlist' class='row grid'>"
        . $return
        . "</div>
</div> <div id=\"teammember_specify\" class=\"modal fade\" role=\"dialog\">
<div class=\"vertical-alignment-helper\">
    <div class=\"modal-dialog\">
        <!-- Modal content-->
        <div class=\"modal-content\">
            <div class=\"modal-header\">
                <button type=\"button\" class=\"close\" data-dismiss=\"modal\"></button>
            </div>
            <div class=\"modal-body\" id='insertdatapopup'>
                Loading Data
            </div>

        </div>

    </div>
</div>
</div>"
        . $return2;
    $script = "
<script>
    jQuery(document).ready(function ()
    {

        jQuery('.teammember').click(function (e) {
            var insertId=jQuery(this).attr('id');
            var gethtml=jQuery('#team-content-'+insertId).html();
            jQuery('#insertdatapopup').html(gethtml);
            
        });
        jQuery('#icons-wrapper li').click(function (e) {
            /*  var thisccc = jQuery(this);*/
            var thisdata = jQuery(this);
        var mainId=jQuery(this).attr('id');
         // alert(insertId);
         if(jQuery(this).hasClass('submenu'))
             {
              //  alert(mainId); 
             }
             else 
             {
            jQuery('.icons-list.dropdown_avilable').each(function () { //Clean up all the classes
          
                 jQuery(this).find('> ul:visible').stop().slideUp();
                 jQuery(this).closest('li').removeClass('selected');
            });
            }



            // get group key
            datacheck = thisdata.attr('data-filter');
            // alert('=='+datacheck+'==');
            if (typeof datacheck !== typeof undefined && datacheck !== false) {
                //   alert('here');
                var buttonGroup = thisdata.parents('.button-group');
                var filterGroup = buttonGroup.attr('data-filter-group');
                // set filter for group
                buttonFilters[filterGroup] = thisdata.attr('data-filter');
                // combine filters
                buttonFilter = concatValues(buttonFilters);
                // Isotope arrange
                //grid.isotope();
                grid.isotope({ filter: buttonFilter });

                buttonGroup.find('.is-checked').removeClass('is-checked');
                // buttonGroup.find('.selected').removeClass('selected')  ;
                jQuery(this).addClass('is-checked');
                jQuery(this).parents('.submenu').addClass('selected');
            }
            if (jQuery(this).children('ul:visible').length) {
                jQuery(this).find('> ul:visible').stop().slideUp();
                jQuery(this).closest('li').removeClass('selected');
                //alert();
            } else {
                jQuery(this).children('ul').stop().slideToggle();
                jQuery(this).closest('li').addClass('selected');
            }
            /*if(jQuery(this).hasClass('submenu'))
             {
             return false;
             }
             if(jQuery(this).hasClass('submenuchild'))
             {
             return true;
             }*/
            return false;

        });





        // external js: isotope.pkgd.js
        // store filter for each group
        var buttonFilters = {};
        var buttonFilter;
        // quick search regex
        var qsRegex;

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

        /*  jQuery('.filters').on('click', '.team_filter_li', function () {
         var thisdata = jQuery(this);
         // get group key
         var buttonGroup = thisdata.parents('.button-group');
         var filterGroup = buttonGroup.attr('data-filter-group');
         // set filter for group
         buttonFilters[filterGroup] = thisdata.attr('data-filter');
         // combine filters
         buttonFilter = concatValues(buttonFilters);
         // Isotope arrange
         grid.isotope();
         // setTimeout(set_team, 3000)


         });*/


        // use value of search field to filter
        var quicksearch = jQuery('.quicksearch').keyup(debounce(function () {
            qsRegex = new RegExp(quicksearch.val(), 'gi');
            grid.isotope();
        }));



        var anyButtons = jQuery('.filters').find('.team_filter_li[data-filter=\"\"]');
        var buttons = jQuery('.team_filter_li');

        jQuery('.button--reset').on( 'click', function() {
            // reset filters
            filters = {};
            grid.isotope({ filter: '*' });
            // reset buttons
            buttons.removeClass('is-checked');
            anyButtons.addClass('is-checked');
        });


// change is-checked class on buttons
        jQuery('.button-group').each(function (i, buttonGroup) {
            var buttonGroup = jQuery(buttonGroup);
            buttonGroup.on('click', '.team_filter_li', function () {
                buttonGroup.find('.is-checked').removeClass('is-checked');
                jQuery(this).addClass('is-checked');
            });
        });

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


</script>
";


    return $filterdata . $return . $script;
}