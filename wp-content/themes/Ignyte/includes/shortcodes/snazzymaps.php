<?php
/**
	Snazzy Maps
**/
add_shortcode('snazzy_maps', 'snazzy_maps_shortcode');
function snazzy_maps_shortcode($atts, $content = null) {
	
	$template_file = get_page_template_slug();
	extract( shortcode_atts( array(
		'id' =>'',
		'subnav_title' =>'',
		'close_container' => '',
		'latitude'=> '32.9897851',
		'longitude' => '-117.254763',
	), $atts ) );
	
	$default = array(
				'container_id' => 'map',
				'apiKey' => 'AIzaSyAA7RTkLc8ru85_RQXfv8jKQc-aygXPseE',
				'latitude' => $latitude,
				'longitude' => $longitude,
				'icon' => '/wp-content/themes/Ignyte/images/marker-shadow.png',
	);
	$def = shortcode_atts($default, $atts);
	//print_r($def);
  	ob_start();
	?>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $def["apiKey"]; ?>&sensor=false"></script>
        <script type="text/javascript">
            google.maps.event.addDomListener(window, 'load', init);
            function init() {
                var geometry = {
                    lat: <?php echo $def["latitude"]; ?>,
                    lng: <?php echo $def["longitude"]; ?>
                };
                var mapOptions = {
                    zoom: 16,
                    center: new google.maps.LatLng(geometry.lat, geometry.lng),
					scrollwheel: false,
                    styles: [{
                        featureType: "landscape",
                        stylers: [{
                            saturation: -100
                        }, {
                            lightness: 65
                        }, {
                            visibility: "on"
                        }]
                    }, {
                        featureType: "poi",
                        stylers: [{
                            saturation: -80
                        }, {
                            lightness: 51
                        }, {
                            visibility: "simplified"
                        }]
                    }, {
                        featureType: "road.highway",
                        stylers: [{
                            hue: "#ff9933"
                        }, {
                            lightness: 30
                        }, {
                            visibility: "simplified"
                        }]
                    }, {
                        featureType: "road.arterial",
                        stylers: [{
                            hue: "#ff9933"
                        }, {
                            visibility: "on"
                        }]
                    }, {
                        featureType: "road.local",
                        stylers: [{
                           hue: "#ff9933"
                        }, {
                            visibility: "on"
                        }]
                    }, {
                        featureType: "transit",
                        stylers: [{
                            saturation: -50
                        }, {
                            visibility: "simplified"
                        }]
                    }, {
                        featureType: "administrative.province",
                        stylers: [{
                            visibility: "off"
                        }]
                    }, {
                        featureType: "administrative.locality",
                        stylers: [{
                            visibility: "off"
                        }]
                    }, {
                        featureType: "administrative.neighborhood",
                        stylers: [{
                            visibility: "on"
                        }] 
                    }, {
                        featureType: "water",
                        elementType: "labels",
                        stylers: [{
                            visibility: "on"
                        }, {
                            lightness: -25
                        }, {
                            saturation: -100
                        }]
                    }, {
                        featureType: "water",
                        elementType: "geometry",
                        stylers: [{
                            hue: "#f9f7f6"

                        }, {
                            lightness: -25
                        }, {
                            saturation: -97
                        }]
                    }]
                };
				function infoCallback(infowindow, marker) {
					return function() {
						infowindow.open(map, marker);
					};
				}
                var mapElement = document.getElementById('<?php echo $def["container_id"]; ?>');
                var map = new google.maps.Map(mapElement, mapOptions);
                var iconBase = '<?php echo $def["icon"]; ?>';
                var marker = new google.maps.Marker({
                    position: geometry,
                    map: map,
                    icon: iconBase
                });
				var content = '<div class="map-content"><h4>InStrategy</h4><br />445 Marine View Avenue, Suite 300 <br />Del Mar ,CA 92014<br />' + '<a href="http://maps.google.com/?daddr=445 Marine View Avenue, Suite 300 Del Mar, CA 92014" target="_blank">Get Directions</a><br/>';
				var infowindow = new google.maps.InfoWindow({maxWidth: 350});
				infowindow.setContent(content);
				
				google.maps.event.addListener(marker, 'click', infoCallback(infowindow, marker));
				google.maps.event.trigger( marker, 'click' );
                marker.setMap(map);
            }
        </script>
		<? $ismobile = check_user_agent('mobile'); 

		if ($close_container<>""&& $close_container<>"no"){
			echo '</div></div></div>';
		}
		
		if ($id<>"" && $subnav_title<>""){ ?>
        	<div id="subnav_<?=$id?>" class="Ignyte_subNavItem">
            	<div class='menutitle' style='display:none;'><?=$subnav_title?></div>
        <? }
		
		if ($ismobile) {?>
        	<div onclick="location.href='https://www.google.com/maps/dir//445+Marine+View+Ave+%23300,+Del+Mar,+CA+92014/@32.9902777,-117.2894384,13z/data=!3m1!4b1!4m8!4m7!1m0!1m5!1m1!1s0x80dc09260848baef:0xb31ac465c4357dca!2m2!1d-117.2551056!2d32.9902824'"><div id="<?php echo $def["container_id"]; ?>"><div></div></div></div>
        <? }else{ ?>
       		<div id="<?php echo $def["container_id"]; ?>"></div>
        <? }
		 if ($id<>"" && $subnav_title<>""){ ?></div><? }
		
		 if ($close_container<>"" && $close_container<>"no") { ?>
            <div class="container">
            <div class="row">
            <? 
			if (strstr($template_file, 'page-fullwidth')){ ?>
           		<div class="col-xs-12 col-sm-12">
			<? } else {?>
            	<div class="col-xs-12 col-sm-8">
            <? } ?>
         <? }   
         
         
    
	$map = ob_get_contents();
	ob_end_clean();
	
	return $map;
}
