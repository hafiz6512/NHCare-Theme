<?php

/*

Template Name: Standard Page Fluid Basic

*/

 get_header(); 

 $page_meta=get_post_meta( get_the_ID() ); 

?>

<div id="page-wrap">



<!-- BEGIN - ADDED BY GREG -->

<section class="basic-content">

<!-- END - ADDED BY GREG -->







<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>













<? if (isset($page_meta['ignyte_banner_image'][0]) && $page_meta['ignyte_banner_image'][0]<>"") { ?>

<div class="container">

<div class="row top">

<div class="container">

<div class="thepatterns career-bg-1">

<div class="pattwrap">

<div class="pattblock blue left"></div>

</div>

</div>

</div>

<div class="col-md-8 right-content" style="background-image:url(<?=$page_meta['ignyte_banner_image'][0]?>)"></div>

<div class="col-md-4 left-content">

<div class="row left-top">









<p class="bg-red basic-tile"><?=the_title();?></p>



<?php if ($page_meta["ignyte_banner_content"][0]) {

	echo $page_meta["ignyte_banner_content"][0];

} ?>











</div>

</div>

</div>

</div>

<? } ?>







    <div id="main-content">

      <div class="container-fluid">




        <div class="row">

        	<div class="col-md-offset-2 col-md-8">

                    <?php



                    remove_filter('the_content', 'wpautop');

                    the_content(); ?>

            </div> 

        </div>

	  </div>

    </div> 

    <?php if($page_meta["ignyte_bottom_shortcode_content"][0]!=""){ ?>

   
     <div id="bottom-content">

    
       <?php ?> 

        <?php echo do_shortcode(get_post_meta($post->ID, 'ignyte_bottom_shortcode_content', true));?>

     </div> 

	<?php } ?>

<?php endwhile; else: ?>



	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>



<?php endif; ?>


</section>






</div>
<?php get_footer(); ?>