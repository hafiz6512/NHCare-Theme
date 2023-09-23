<?php
/*
Template Name: Ignyte Services Archive
*/
 get_header(); 
?>
<div id="page-wrap">
<?php 
 $currentlang = get_bloginfo('language');
 switch($currentlang){
	case "en-US":
		$page=get_page_by_title( "Health Services" );
	break;
	case "es-ES":
		$page=get_page_by_title( "Servicios" );
	break;
 }
 
 $page_meta=get_post_meta( $page->ID ); 
 ?>
   <!-- Or if page has a banner at top -->
	<? if (isset($page_meta['ignyte_banner_image'])) { ?>
    <div class="banner-image" style="background-image:url(<?=$page_meta['ignyte_banner_image'][0]?>)">
    	<? if (isset($page_meta['ignyte_banner_image_title'])) { ?>
            <!-- if banner has title -->
            <div class="banner-content">
                <div class="container">
                    <h2><?=$page_meta['ignyte_banner_image_title'][0]?></h2>
                </div>
            </div>
        <? } ?>
    </div> <!-- End banner image -->
	<? } ?>
    <div id="main-content">
      <div class="container service-content">
    	<div class="row">
        	<div class="col-xs-12 col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10 lead-copy">
            	<?php if($page_meta["ignyte_title_content"][0]==""){ ?>
            		<h1 class="page-title"><?=$page->post_title; ?></h1>	
                <?php }else{ 
					echo '<h1 class="page-title">'.$page_meta["ignyte_title_content"][0].'</h1>';
					} ?>
                <?php if($page_meta["ignyte_leadincontent_content"][0]!=""){ ?>
                	<!-- If has lead copy entered in the admin, then this shows -->
					<p><?=$page_meta["ignyte_leadincontent_content"][0]?></p>
				<?php } ?>
            </div>
        </div>
        <!-- Main editor page contents -->
        <div class="row">
        	<div class="col-xs-12 col-sm-12">
                    <?=apply_filters('the_content', $page->post_content); ?>
            </div> 
        </div>
      </div> <!-- /.container -->
    </div> <!-- /#main-content.container -->
    <?php if($page_meta["ignyte_bottom_shortcode_content"][0]!=""){ ?>
    <!-- If there are shortcodes / content blocks, this shows -->
     <div id="bottom-content">
     	<!-- Shortcodes / Content blocks would stack here -->
        <?php echo do_shortcode(get_post_meta($page->ID, 'ignyte_bottom_shortcode_content', true));?> 
     </div> <!-- /#bottom-content -->
	<?php } ?>

</div> <!-- /#page-wrap -->
<?php get_footer(); ?>