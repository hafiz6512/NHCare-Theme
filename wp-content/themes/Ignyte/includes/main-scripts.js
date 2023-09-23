/*
jQuery(document).ready(function($) {
    //mm-menu options
    $(function() {
        $('nav#menu').mmenu({
            classes: "mm-zoom-menu",
            //searchfield: false,
            pageScroll: true,
            extensions: ["position-top"],
            offCanvas: {
                position: "top",
               // pageNodetype: "section",
                zposition : "next"
            },
            navbar: {
                title: "my custom title"
            },
        },{
            classNames: {
                fixedElements: {
                    fixed: "fix",
                    sticky: "stick"
                }
            }
        });

        var api = $("nav#menu").data( "mmenu" );

        $("#closemm2").click(function() {
            console.log("here");
            api.close();
        });
    });

    $("#closemm").click(function() {
        $("nav#menu").trigger("close.mm");
    });


});
 */
//mm-menu options
jQuery(document).ready(function($) {
  	$(function() {
		$('nav#menu').mmenu({
			slidingSubmenus: false,
			searchfield: false,
			offCanvas: {
					position: "top",
					zposition : "next"
				}
			});
        var api = $("nav#menu").data( "mmenu" );

        $("#closemm2").click(function() {
            console.log("here");
            api.close();
        });

		$('#mm-blocker').remove();
	});

	$('#locLists').mCustomScrollbar({
		theme: "rounded-dots-dark",
		setWidth: false,
		setHeight: false,
	  	scrollButtons:{
			enable: false,
			scrollType: "stepless",
			scrollAmount: "auto",
		},
	});

});


// Navigation for Ignyte_Subnav
jQuery(document).ready(function($) {
	var navItems=$('.Ignyte_subNavItem');
	if (navItems.length>0) {
		navItems.each(function(index) {
			//console.log("Item: "+index );
			//Title
			title=$( this ).find(".menutitle").text();
			//console.log("Title:"+ $( this ).find(".menutitle").text());
			//ID
			id=$( this ).attr('id');
           // console.log("ID:"+ $( this ).attr('id'));
			// put in subnav-menu, as li elements

			//$("#subnav-menu").append("<li><a href='#"+id+"'>"+title+"</li>");
			$("#subnav-menu").append("<li><a href='#"+id+"'>"+title+"</a></li>");
        });
	}
	else
	{
		jQuery("#subnav-wrap").remove();
	}
	jQuery('#subnav-menu a[href^="#"]').on('click', function(event) {
		var target = jQuery(this).attr('href')
		if( target.length ) {
			event.preventDefault();
			jQuery('html, body').animate({
				scrollTop: jQuery(target).offset().top-129
			}, 1000);
		}
	});


});
// End Navigation for Ignyte_Subnav


// Navigation for FAQs
jQuery(document).ready(function($) {
	jQuery('#faqWrapper a[href^="#"]').on('click', function(event) {
			var target = jQuery(this).attr('href');
			//console.log("target:"+target);
			if( target.length ) {
				event.preventDefault();
				jQuery('html, body').animate({
					scrollTop: jQuery(target).offset().top-129
				}, 1000);
			}
		});
});

// Navigation for Terms of Use
jQuery(document).ready(function($) {
    jQuery('#terms a[href^="#"]').on('click', function(event) {
        var target = jQuery(this).attr('href');
        //console.log("target:"+target);
        if( target.length ) {
        	//alert(target);
        	if(target=='#')
			{
               // target='#terms';
                jQuery("html, body").animate({ scrollTop: 0 }, "slow");
                return false;
			}
            event.preventDefault();
            jQuery('html, body').animate({
                scrollTop: jQuery(target).offset().top-80
            }, 1000);
        }
    });
});
//isInViewport code for header navs
(function($) {
  $(document).ready(function() {
      var lastScrollTop = 0;
    $(window).scroll(function(event) {


	  $('#page-wrap:in-viewport(123)').do(function(){
		  $('#main-nav-wrap').addClass("navbar-fixed-top mm-fixed-top");
		  $('#page-wrap').css('padding-top','93px');

	  });
	  $('#main-content:in-viewport(83)').do(function(){
		  $('#subnav-menu').addClass("showme");
	  });
	  $('#global-nav-wrap:in-viewport(0)').do(function(){
		  $('#main-nav-wrap').removeClass("navbar-fixed-top mm-fixed-top");
		  $('#page-wrap').css('padding-top','0');
          $("header").removeClass("showSticky");
		  $('#subnav-menu').removeClass("showme");
		  //$('#sidebar').removeClass("sidebar-fixed-top");
	  });

        var st = $(this).scrollTop();
        //alert(st+"==="+lastScrollTop);
        if (st > lastScrollTop){
           // $("#main-nav-wrap").slideUp(500);
            $("header").removeClass("showSticky");
        } else {
          //  $("#main-nav-wrap").slideDown(500);
            $("header").addClass("showSticky");
        }

        lastScrollTop = st;

	});
  });
}(jQuery));

// BS Affix for sidebars
jQuery(document).ready(function($) {
  if ( ($(window).width() > 991) && ($(window).height() > $("#sidebar").height()+137) ) {
	  $('#sidebar.stick').affix({
		offset: {
		  top: function () {
			return (this.top = $('header').outerHeight(true) + $('.banner-image').outerHeight(true) + $('.single-top-wrap').outerHeight(true) - (123))
		  },
		  bottom: function () {
			return (this.bottom = $('footer').outerHeight(true) + $('#bottom-content').outerHeight(true) + (123))
		  }
		}
	  });
  }
});

// Slider sizing full screen for large tablet and desktop
jQuery(document).ready(function($){
  if ($(window).width() > 991) {
	$('li.slide-img').css({'height': (($(window).height()) ) - 127 +'px'});
  }
});

jQuery(function($){
	$(window).resize(function(){
		 if ($(window).width() > 991) {
        	$('li.slide-img').css({'height': (($(window).height()) ) - 127 +'px'});
		 }
    });
});

// Scroll down arrow for sliders
jQuery(document).ready(function($){
  $(window).scroll(function(){
    // get the height of #wrap
    var h = $('body').height();
    var y = $(window).scrollTop();

    if( y > (h*.03) ){
    // if we are show keyboardTips
    $(".scroll-down").addClass("scrolled");
    } else {
    $(".scroll-down").removeClass("scrolled");
    }
  });
})


/* Check if we are in safari */
jQuery(document).ready(function($) {
	if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
		var stickywidget = $('#sidebar.stick');
		var explicitlySetAffixPosition = function() {
			stickywidget.css('left',stickywidget.offset().left+'px');
		};
		/* Before the element becomes affixed, add left CSS that is equal to the distance of the element from the left of the screen */
		stickywidget.on('affix.bs.affix',function(){
			explicitlySetAffixPosition();
		});

		$(window).scroll(function(){
			if(stickywidget.hasClass("affix-bottom")){
				stickywidget.css('left','auto');
			}else if (stickywidget.hasClass("affix-top")){

			}else{
				//stickywidget.css('left',stickywidget.offset().left+'px');
			}
		});
		/* On resize of window, un-affix affixed widget to measure where it should be located, set the left CSS accordingly, re-affix it */
		$(window).resize(function(){
			if(stickywidget.hasClass('affix')) {
				stickywidget.removeClass('affix');
				explicitlySetAffixPosition();
				stickywidget.addClass('affix');
			}
		});
	}
});


/*
//PNG fallback for SVG:
function supportsSVG() {
  return !! document.createElementNS && !! document.createElementNS('http://www.w3.org/2000/svg','svg').createSVGRect;
}


jQuery(document).ready(function($) {
	if (!supportsSVG()) {
	  var imgs = document.getElementsByTagName('img');
	  var dotSVG = /.*\.svg$/;
	  for (var i = 0; i != imgs.length; ++i) {
		if(imgs[i].src.match(dotSVG)) {
		  imgs[i].src = imgs[i].src.slice(0, -3) + 'png';
		}
	  }
	}
	// Replace png with actual SVG element
	else {
		$('img.svg').each(function(){
			var $img = $(this);
			var imgID = $img.attr('id');
			var imgClass = $img.attr('class');
			var imgURL = $img.attr('src');

			$.get(imgURL, function(data) {
				// Get the SVG tag, ignore the rest
				var $svg = $(data).find('svg');
				// Add replaced image's ID to the new SVG
				if (typeof imgID !== 'undefined') {
					$svg = $svg.attr('id', imgID);
				}
				// Add replaced image's classes to the new SVG
				if (typeof imgClass !== 'undefined') {
					$svg = $svg.attr('class', imgClass+' replaced-svg');
				}
				// Remove any invalid XML tags as per http://validator.w3.org
				$svg = $svg.removeAttr('xmlns:a');
				// Replace image with new SVG
				$img.replaceWith($svg);
			});
		});
	}
});
*/


// Toggle class when main nav search is focused

jQuery(document).ready(function($) {
	$('input#search').on('focus', function(){
	  $('.navbar-brand').addClass('search-focus');
	}).on('blur', function(){
	   $('.navbar-brand').removeClass('search-focus');
	})
});





/*! A fix for the iOS orientationchange zoom bug.
 Script by @scottjehl, rebound by @wilto.
 MIT / GPLv2 License.
*/
(function(w){

	// This fix addresses an iOS bug, so return early if the UA claims it's something else.
	var ua = navigator.userAgent;
	if( !( /iPhone|iPad|iPod/.test( navigator.platform ) && /OS [1-5]_[0-9_]* like Mac OS X/i.test(ua) && ua.indexOf( "AppleWebKit" ) > -1 ) ){
		return;
	}

    var doc = w.document;

    if( !doc.querySelector ){ return; }

    var meta = doc.querySelector( "meta[name=viewport]" ),
        initialContent = meta && meta.getAttribute( "content" ),
        disabledZoom = initialContent + ",maximum-scale=1",
        enabledZoom = initialContent + ",maximum-scale=10",
        enabled = true,
		x, y, z, aig;

    if( !meta ){ return; }

    function restoreZoom(){
        meta.setAttribute( "content", enabledZoom );
        enabled = true;
    }

    function disableZoom(){
        meta.setAttribute( "content", disabledZoom );
        enabled = false;
    }

    function checkTilt( e ){
		aig = e.accelerationIncludingGravity;
		x = Math.abs( aig.x );
		y = Math.abs( aig.y );
		z = Math.abs( aig.z );

		// If portrait orientation and in one of the danger zones
        if( (!w.orientation || w.orientation === 180) && ( x > 7 || ( ( z > 6 && y < 8 || z < 8 && y > 6 ) && x > 5 ) ) ){
			if( enabled ){
				disableZoom();
			}
        }
		else if( !enabled ){
			restoreZoom();
        }
    }

	w.addEventListener( "orientationchange", restoreZoom, false );
	w.addEventListener( "devicemotion", checkTilt, false );

})( this );


function setBBHeights(){
	elementHeights = jQuery('.boardblock').map(function() {
		return jQuery(this).height();
	}).get();
	// Math.max takes a variable number of arguments
	// `apply` is equivalent to passing each height as an argument
	maxHeight = Math.max.apply(null, elementHeights);
	// Set each height to the max height
	jQuery('.boardblock').height(maxHeight);
}

function setTMHeights(){
	elementHeights = jQuery('.teammember').map(function() {
	  return jQuery(this).height();
	}).get();
	maxHeight = Math.max.apply(null, elementHeights);
	jQuery('.teammember').height(maxHeight);
}

function setHeigths(){
	setBBHeights();
	setTMHeights();
}

jQuery(document).ready(function() {
  setHeigths();
});
jQuery( window ).resize(function() {
	jQuery('.boardblock').height('auto');
	jQuery('.teammember').height('auto');
	setHeigths();
});


jQuery(document).ready(function(){
	jQuery('.external a').click(function(event) {
		event.preventDefault();

		var goto=jQuery(this).attr("href");
		jQuery("#exit_target").attr("href",goto);
		jQuery('#leavingsite').modal() ;
	});
});

jQuery(document).ready(function(){
	jQuery('.jobportal a').click(function(event) {
		event.preventDefault();

		var goto=jQuery(this).attr("href");
		jQuery(".exit_job_target").attr("href",goto);
		jQuery('#jobportal').modal() ;
	});
});

jQuery(document).ready(function(){
	jQuery('.enrollquery a').click(function(event) {
		event.preventDefault();

		var goto=jQuery(this).attr("href");
		jQuery(".enrollquery").attr("href",goto);
		jQuery('#enrollquery').modal() ;
	});
});

jQuery(document).ready(function(){
	jQuery('.enrollquery-es a').click(function(event) {
		event.preventDefault();

		var goto=jQuery(this).attr("href");
		jQuery(".enrollquery-es").attr("href",goto);
		jQuery('#enrollquery-es').modal() ;
	});
});

jQuery(document).ready(function(){
	if(jQuery(location.href.split("#")[1])) {
	  var target = jQuery('#'+location.href.split("#")[1]);
	 /* if (target.length) {
		jQuery('html,body').animate({
		  scrollTop: target.offset().top - 128 //offset height of header here too.
		}, 1000);
		return false;
	  }*/
	}
});

jQuery(document).ready(function () {
    // *only* if we have anchor on the url

    if(window.location.hash) {
        var hasvalue=window.location.hash;
        if(hasvalue=='#feedbackform') {
            jQuery("html, body").animate({ scrollTop: 0 }, "fast");
            setTimeout(function(){

                jQuery('html, body').animate({
                    scrollTop: jQuery(window.location.hash).offset().top-120
                }, 1000);
            }, 2000);
        }
    }

    jQuery('.footerexp').on('click', function(event) {
        var target = jQuery(this).attr('href');
        target = location.hash.split('#');
        //alert(target[1]);
        if( target[1].length ) {
            event.preventDefault();
            jQuery('html, body').animate({
                scrollTop: jQuery('#'+target[1]).offset().top-120
            }, 1000);
        }
    });

});

jQuery(document).ready(function(){
jQuery("[class=location]").each(function(i, obj) {

jQuery(this).popover({
  html: true,
  content: function() {
    var id = jQuery(this).attr('id')
    return jQuery('#popover-content-' + id).html();
  }
});
});
});

jQuery(document).ready(function(){
jQuery("[id=dot]").each(function(i, obj) {

jQuery(this).popover({
  html: true,
  content: function() {
    var id = jQuery(this).attr('id')
    return jQuery('#popover-content-' + id).html();
  }
});
});
});

jQuery(document).ready(function(){


    jQuery(".get-involved-cards .flipcard").hover(
        function(){
            jQuery(".get-involved-cards .flipcard").removeClass("active-card");
            jQuery(this).addClass("active-card");
        },
        function(){
               // jQuery(".get-involved-cards .flipcard").removeClass("active-card");
                //jQuery("#first-flip").addClass("active-card");

        }
    );

    function flipactive() {
        if (jQuery(window).width() < 1026) {
            jQuery(".get-involved-cards .flipcard").addClass("active-card");
        }
		else
		{
            jQuery(".get-involved-cards .flipcard").removeClass("active-card");
            jQuery("#first-flip").addClass("active-card");
		}
    }
    flipactive();
    jQuery( window ).resize(function() {
        flipactive();
    });
});




/*Code for BG plus pattern*/

jQuery(document).ready(function($){

    //Start the Parallax Effects – use the function to trigger or remove the effect.
    function parallaxCrosses(){
        scrolltop = $(window).scrollTop();
        scrollwindow = scrolltop + $(window).height();

        $('.pattblock').each(function() {
            if( scrollwindow > $(this).offset().top ) {
                blockscroll = scrollwindow - $(this).offset().top;
                $(this).css("marginTop", +(blockscroll/10) + "px");
            }
        });

        $('.pattblob').each(function() {
            if( scrollwindow > $(this).offset().top ) {
                blockscroll = scrollwindow - $(this).offset().top;
                $(this).css("marginTop", -(blockscroll/18) + "px");
            }
        });

        $('.blobmorph').each(function() {
            if( scrollwindow > $(this).offset().top ) {
                blockscroll = scrollwindow - $(this).offset().top;
                $(this).css("marginTop", +(blockscroll/18) + "px");
            }
        });
    }

    $(window).scroll(function(){

        if ($(window).width() > 900) {
            //Enable parallax effect
            parallaxCrosses();

            $( '.blobmorph:in-viewport(550)' ).do(function(){
                $(this).addClass('active');
            });

            $( '.blobmorph:in-viewport(-900)' ).do(function(){$(this).removeClass('active');});
            $( '.blobmorph:in-viewport(900)' ).do(function(){$(this).removeClass('active');});

        }
    });


    parallaxCrosses();
});

jQuery(document).ready(function($){
    jQuery("li.gfield select").on('change', function() {
        jQuery(this).css('color', '#4F4848');
    });
});

jQuery(document).ready(function ($) {
    // $('.menu_nh_location a').on('click', function (e) {
    //     //e.preventDefault()
    //     setTimeout(function(){
	   //      $('html, body').animate({
	   //          scrollTop: $('body').offset().top + 370
	   //      }, 'slow');
	   //  }, 100);
    // });
});