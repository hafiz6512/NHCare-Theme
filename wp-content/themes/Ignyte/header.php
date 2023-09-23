<?php 

header('Content-type: text/html; charset=utf-8'); 

// Get last modification time of the current PHP file
$file_last_mod_time = filemtime(__FILE__);

// Get last modification time of the main content (that user sees)
// Hardcoded just as an example
$content_last_mod_time = 1520949851;

// Combine both to generate a unique ETag for a unique content
// Specification says ETag should be specified within double quotes
$etag = '"' . $file_last_mod_time . '.' . $content_last_mod_time . '"';

// Set Cache-Control header, 604800 = 7 days
header('Cache-Control: max-age=604800');

// Set ETag header
header('ETag: ' . $etag);

// Check whether browser had sent a HTTP_IF_NONE_MATCH request header
if(isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
	// If HTTP_IF_NONE_MATCH is same as the generated ETag => content is the same as browser cache
	// So send a 304 Not Modified response header and exit
	if($_SERVER['HTTP_IF_NONE_MATCH'] == $etag) {
		header('HTTP/1.1 304 Not Modified', true, 304);
		exit();
	}
}

?><!DOCTYPE html>



<!--[if IE 7]>

<html class="ie ie7" <?php language_attributes(); ?>>

<![endif]-->



<!--[if IE 8]>

<html class="ie ie8" <?php language_attributes(); ?>>

<![endif]-->



<!--[if !(IE 7) | !(IE 8) ]><!-->

<html <?php language_attributes(); ?>>

<!--<![endif]--><head>

        <meta charset="<?php bloginfo( 'charset' ); ?>">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">



        <title><?php wp_title( '|', true, 'right' ); ?></title>

        <link rel="profile" href="http://gmpg.org/xfn/11">

        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

        <meta http-equiv="Content-Type" content="application/xhtml+xml">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->

        <!--[if lt IE 9]>

          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>

        <![endif]-->

<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WQ6GXDH');</script>

        <link rel="shortcut icon" href="/favicon.ico">

		<link rel="stylesheet" href="/wp-content/themes/Ignyte/fonts/font-awesome/css/font-awesome.css">

        <link rel="apple-touch-icon" sizes="57x57" href="/favicons/apple-icon-57x57.png">

        <link rel="apple-touch-icon" sizes="60x60" href="/favicons/apple-icon-60x60.png">

        <link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-icon-72x72.png">

        <link rel="apple-touch-icon" sizes="76x76" href="/favicons/apple-icon-76x76.png">

        <link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-icon-114x114.png">

        <link rel="apple-touch-icon" sizes="120x120" href="/favicons/apple-icon-120x120.png">

        <link rel="apple-touch-icon" sizes="144x144" href="/favicons/apple-icon-144x144.png">

        <link rel="apple-touch-icon" sizes="152x152" href="/favicons/apple-icon-152x152.png">

        <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-icon-180x180.png">

        <link rel="icon" type="image/png" sizes="192x192"  href="/favicons/android-icon-192x192.png">

        <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">

        <link rel="icon" type="image/png" sizes="96x96" href="/favicons/favicon-96x96.png">

        <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">

        <link rel="manifest" href="/favicons/manifest.json">

        <meta name="msapplication-TileColor" content="#ffffff">

        <meta name="msapplication-TileImage" content="/favicons/ms-icon-144x144.png">

        <meta name="theme-color" content="#ffffff">

        <?php wp_enqueue_script("jquery"); ?>

        <?php wp_head(); ?>

        <!--[if gte IE 9]>

          <style type="text/css">

            .gradient {filter: none;}

          </style>

        <![endif]-->

		<meta name="google-site-verification" content="htQn_xv3A_sZ914xg0nQe-FopfcokVrUCsVwFodpPVs" />
		<meta name="facebook-domain-verification" content="5p9czaqfus6ez79f7e7ojoaq2zt8d2" />
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-4059439-1"></script>
		<script>
				window.dataLayer = window.dataLayer || [];
				function gtag(){dataLayer.push(arguments);}
				gtag('js', new Date());
				gtag('config', 'UA-4059439-1');
		</script>
<!-- START: YEXT Answers  --->
  <script src="https://assets.sitescdn.net/answers-search-bar/v1.0/answerstemplates.compiled.min.js">
  </script>
 <script>
    function initAnswers() {
      ANSWERS.init({
        apiKey: "fc09e3f987faa301ff24e630380ba7e4",
        experienceKey: "nh-answers",
        experienceVersion: "PRODUCTION",
        locale: "en", // e.g. en
        businessId: "3117631",
        templateBundle: TemplateBundle.default,
        onReady: function() {
          ANSWERS.addComponent("SearchBar", {
            container: ".search_form",
            name: "nhyextsearchbar", //Must be unique for every search bar on the same page
            redirectUrl: "https://www.nhcare.org/search-results/",
            placeholderText: "Search...",
          });
        },
      });
    }
  </script>
  <script
    src="https://assets.sitescdn.net/answers-search-bar/v1.0/answers.min.js"
    onload="ANSWERS.domReady(initAnswers)"
    async
    defer
  ></script>
<!-- END: YEXT Answers  --->

</head>
<body <?php body_class(); ?> data-spy="scroll" data-target="#page-subnav" data-offset='135'>
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WQ6GXDH" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<div id="sched-by-text" class="container-fluid">
		<div class="row text-center">
			<div class="sched-by-text-text"><a href="/message-doctor/" target="_self" title="Messaging information to doctor">Message Your Doctor</a></div>
		</div>
	</div>	
		<nav id="menu" class="">
    <div>Hello</div>

            <ul>

                <?php  $headerlogo= ot_get_option( "header_logo", "" ); ?>

                <li class="menu-header">

                    <a id="closemm2" href="#menu" class="navbar-toggle">

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>

                        <span class="icon-bar"></span>

                    </a>

                </li>

 <?php



					wp_nav_menu( array( 'container'=>'','theme_location' => 'main-nav', 'items_wrap' => '%3$s' ) );

                    wp_nav_menu( array( 'container'=>'','theme_location' => 'top-nav', 'items_wrap' => '%3$s','menu_id'=>'mymenu' ) );

            ?>



                <li class="search-nav">


				  


                </li>

			

            </ul>

        </nav>



        <div id="page">



            <header>



                <div id="global-nav-wrap" class="navbar" role="navigation" >

                  <div class="container">

                      <div class="navbar-left" id="global-nav-right">

                      	<?php /*?><a class="underline red" data-toggle="modal" data-target="#appointment-modal">online</a><?php */?>

						<p> <?  dynamic_sidebar('desktop_phone'); ?></p>





                      </div><!--/.nav-collapse -->



                      <?php //if (is_user_logged_in())

                          // wp_nav_menu( array( 'container_id'=>'top-nav','container_class'=>'collapse navbar-collapse navbar-left','menu_class'=>'nav navbar-nav non-responsive-menu','theme_location' => 'logged-top-nav' ) );

                          //else 

                             wp_nav_menu( array( 'container_id'=>'top-nav','container_class'=>'collapse navbar-collapse navbar-right','menu_class'=>'nav navbar-nav non-responsive-menu','theme_location' => 'top-nav' ) );

                     ?>



                    <!-- If top-right should collapse in mobile -->

                    <!--<div class="collapse navbar-collapse navbar-right" id="top-right-collapse">-->

                    

                    <!-- If top right stays in mobile -->

                  </div><!--/.container-->

                </div><!--/#global-nav-wrap-->



        

				<? $currentlang = get_bloginfo('language'); ?>

            	<div id="main-nav-wrap" class="navbar non-responsive-menu <? if($currentlang=="es-ES"){ echo $currentLang;} ?>">

					

                  <div class="container">

                    <div class="navbar-header">



                        <a  id="closemm" href="#menu" class="navbar-toggle">

                            <span class="icon-bar"></span>

                            <span class="icon-bar"></span>

                            <span class="icon-bar"></span>

                        </a>


					
                      <? 



                        if ($headerlogo!="") { ?> 

                       <!--     <a class="navbar-brand" href="<?php // echo esc_url( home_url( '/' ) ); ?>" style="background-image:url('<?=$headerlogo?>');"></a> -->
								<a class="navbar-brand" href="/" style="background-image:url('<?=$headerlogo?>');"></a>
                        <? }else{?>

                   <!--         <a class="navbar-brand" href="<?php // echo esc_url( home_url( '/' ) ); ?>"><?php //bloginfo('name'); ?></a> -->
                            <a class="navbar-brand" href="/"><?php bloginfo('name'); ?></a>
                        <? } ?>



                    </div> <!--/navbar-header -->



                    <div class="nav-collapse">

                        <div id="main-nav" class="nav collapse navbar-collapse navbar-right">

                        	<ul id="menu-main-menu" class="nav navbar-nav non-responsive-menu">

                            

								<?php 

                                 wp_nav_menu( array( 'container'=>'','theme_location' => 'main-nav', 'items_wrap' => '%3$s' ) ); 

                                ?>

                                

                             <li class="">
<!--- <div><a class="btn red" href="/search-results">Search</a></div> --->
<div class="search_form"></div>

     <!---                            	<div class="search-nav-wrap">

                                	<?php //get_search_form(); ?> 

                                    </div> --->

                                </li>

                            </ul>
                        </div>



                    </div> <!--/nav-collapse-->

                </div><!--/.container -->

                

                <!-- Sub nav structure -->

                <div id="subnav-wrap" class="navbar">

                    <div class="container">

                        <div id="page-subnav" class="navbar-right">

                            <ul id="subnav-menu" class="nav navbar-nav">

                            </ul>

                        </div>

                    </div>

                </div>

              </div><!-- main-nav-wrap-->

			  

		

         </header><!--header-wrapper-->
		 <?php $closeButton=pll__('Close');?>

		<div class="modal fade" id="appointment-modal" role="dialog" aria-hidden="false">

			<div class="vertical-alignment-helper">

				<div class="modal-dialog modal-lg vertical-align-center">

					<div class="modal-content">

						<div class="modal-header">

							<button type="button" class="close" data-dismiss="modal"><?php echo $closeButton;?> ×</button>

						</div>

						<div class="modal-body">

							<div class="content">

								<iframe src="https://mynhcare.org/" height="200" width="300"></iframe>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

		 

		 

		 

         



