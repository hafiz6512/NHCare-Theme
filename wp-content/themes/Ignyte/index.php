<?php get_header();
$page_meta=get_post_meta( get_the_ID() ); 
?>

<div id="page-wrap">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

    <div id="main-content">
      <div class="container">
    	<div class="row">
        	<div class="col-xs-12 col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10 lead-copy">
            	<?php if($page_meta["ignyte_title_content"][0]==""){ ?>
            		<h1 class="page-title"><?php the_title(); ?></h1>	
                <?php }else{ 
					echo $page_meta["ignyte_title_content"][0];
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
				<? the_content(); ?>
            </div> 
        </div>
      </div> <!-- /.container -->
    </div> <!-- /#main-content -->

<?php endwhile; else: ?>

	<div id="main-content">
      <div class="container">
    	<div class="row">
        	<div class="col-xs-12 col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10 lead-copy">
            		<h1 class="page-title">404</h1>	
					<p>Content not found, please use the search below</p>
                    <? get_search_form(); ?>
            </div>
        </div>
        <!-- Main editor page contents -->
        <div class="row">
        	<div class="col-xs-12 col-sm-12">
				
            </div> 
        </div>
      </div> <!-- /.container -->
    </div> <!-- /#main-content -->


<?php endif; ?>

</div> <!-- /#page-wrap -->



<?php get_footer(); ?>