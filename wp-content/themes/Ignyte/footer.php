<?php echo do_shortcode("[Contact-us-row]"); ?>




<footer>

    <!-- Widget Area -->

    <div class="footer-widget-wrap">

        <div class="container">

            <div class="row">

                <div class="col-xs-12 col-sm-8">
				 <?php dynamic_sidebar('quicklink_footer'); ?>
                    <ul class="footer_nav">
                 <?php    wp_nav_menu( array( 'container'=>'','theme_location' => 'footer-nav', 'items_wrap' => '%3$s' ) ); ?>
                    <? //wp_nav_menu(array('container_id' => 'footer-nav', 'container_class' => 'navbar-left', 'menu_class' => 'nav navbar-nav non-responsive-menu', 'theme_location' => 'footer-nav')); ?>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-4 feedback">
                    <!-- Right Widget -->
                    <? dynamic_sidebar('Make an Appointment (Footer)'); ?>

                </div>

            </div>

        </div>

    </div>
	
	<div class="footer-newsletter-wrap">
	<div class="container">
		<div class="row">

            <div class="bottom_newsletter">

                <? dynamic_sidebar('Stay Connected (Footer)'); ?>
            </div>
         </div>
	</div>
	</div>

    <script>
        jQuery(document).ready(function() {
            jQuery( "#ctct-form-wrapper-0" ).append( "<div style='display: none' class='newslettererrorvalidation'></div>" );
            jQuery('#ctct-submitted').click(function(){
           var email = jQuery('#email___e31239813c7d844198b0876ac5451648').val();
              if(email== ''){
                 // alert('vvv');
               jQuery('.newslettererrorvalidation').show();
               jQuery('.newslettererrorvalidation').html('<?php echo pll__("Please Enter Email Address");?>');
                    return false;
                }
                if(IsEmail(email)==false){
                    jQuery('.newslettererrorvalidation').show();
                    jQuery('.newslettererrorvalidation').html('<?php echo pll__("Please Enter Valid Email Address");?>');
                    return false;
                }
                //return false;
            });
        });
        function IsEmail(email) {
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!regex.test(email)) {
                return false;
            }else{
                jQuery('.newslettererrorvalidation').hide();
                return true;
            }
        }
    </script>

    <!-- Bottom footer / nav -->

    <div class="footer-bottom-wrap black">

        <div class="container">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-10">
                    <div>
						<!--<p class="copyright">&copy;2019 Neighborhood Healthcare. All rights reserved. <a class="underline" href="/terms-conditions/">Terms & Conditions</a><span>|</span>
                                <a class="underline" href="/privacy-policy/">Privacy Policy</a><span>|</span><a class="underline" href="/non-discrimination/">Non-Discrimination Notice</a><span>|</span><a class="underline" href="/fqhc-notifications/">FQHC Notifications</a></p>-->
                        <? dynamic_sidebar('Copyright (Footer)'); ?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-2 emp-portal">
                    <? dynamic_sidebar('Employee Portal Link (Footer)'); ?>
                </div>
            </div>
        </div>
    </div>

</footer>
<?php
$footerScripts = ot_get_option("footer_scripts", "");
if ($footerScripts != "") {
    echo $footerScripts;
} ?>
<?php wp_footer(); ?>

<!--- <script type="text/javascript" src="//cdn.callrail.com/companies/293981220/0aca15d561a244f5647a/12/swap.js"></script> --->
<noscript>Your browser does not support JavaScript!</noscript>
</body>
</html>