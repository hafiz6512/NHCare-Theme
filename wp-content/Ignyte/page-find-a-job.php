<?php
/*
Template Name: Find a Job Page
*/
 get_header(); 
?>
<div id="page-wrap">
<?php 

  $page=get_page(get_the_ID());
  $page_meta=get_post_meta( get_the_ID() ); 
  $currentlang = get_bloginfo('language');
 ?>
   <!-- Or if page has a banner at top -->
	<? if (isset($page_meta['ignyte_banner_image'][0]) && $page_meta['ignyte_banner_image'][0]<>"") { ?>
    <div class="banner-image" style="background-image:url(<?=$page_meta['ignyte_banner_image'][0]?>)">
    	<? if (isset($page_meta['ignyte_banner_image_title'][0]) && $page_meta['ignyte_banner_image_title'][0]<>"") { ?>
            <!-- if banner has title -->
            <div class="banner-content">
                <div class="container">
                    <h2><?=$page_meta['ignyte_banner_image_title'][0]?></h2>
                </div>
            </div>
        <? } ?>
    </div> <!-- End banner image -->
	<? } ?>
    <div id="main-content" class="container ">
    	<div class="row">
        	<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 main-column color-bl">
            
            	<?=apply_filters('the_content', $page->post_content); ?>
            
            	<?php 
				query_posts( 'orderby=name&order=ASC&post_type=ignyte_job_position&posts_per_page=-1&lang=en' );
				$job_sidebar='';
				if ( have_posts() ) : while ( have_posts() ) : the_post();
					$job_meta=get_post_meta( get_the_ID() ); 
					if($job_meta["ignyte_title_content"][0]==""){ 
						$job_sidebar.='<li><a href=\'#'.get_the_ID().'\' onclick="javascript:void(0);">'.get_the_title().'</a></li>';
					?>
                        <div class="job-item">
                          <h4 id='<?=the_ID()?>' class="page-title"><?=the_title();?></h4>	
                    <?php }else{ 
						$job_sidebar.='<li><a href=\'#'.get_the_ID().'\' onclick="javascript:void(0);">'.$job_meta["ignyte_title_content"][0].'</a></li>';
                        echo '<div class="job-item"><h2 class="page-title">'.$job_meta["ignyte_title_content"][0].'</h2>';
                        } ?>
                        <?php the_content(); ?>
                        <?
						$list='';
                        for($i=1;$i<15;$i++) {
                            if (isset($job_meta["ignyte_job_position_EssFun_".$i]) && $job_meta["ignyte_job_position_EssFun_".$i][0]<>"")
                                $list.="<li>".$job_meta['ignyte_job_position_EssFun_'.$i.''][0]."</li>";
                        } 
                        if ($list<>"") 
                            echo "<h5>Essential Functions</h5><ul>".$list."</ul>";
						
						$list='';	
						for($i=1;$i<10;$i++) {
                            if (isset($job_meta["ignyte_job_position_MinQual_".$i]) && $job_meta["ignyte_job_position_MinQual_".$i][0]<>"")
                                $list.="<li>".$job_meta['ignyte_job_position_MinQual_'.$i.''][0]."</li>";
                        } 
                        if ($list<>"") 
                            echo "<h5>Minimum Qualifications</h5><ul>".$list."</ul>";
						
						$list='';
						for($i=1;$i<5;$i++) {
                            if (isset($job_meta["ignyte_job_position_PrefQual_".$i]) && $job_meta["ignyte_job_position_PrefQual_".$i][0]<>"")
                                $list.="<li>".$job_meta['ignyte_job_position_PrefQual_'.$i.''][0]."</li>";
                        } 
                        if ($list<>"") 
                            echo "<h5>Preferred Qualifications</h5><ul>".$list."</ul>";
							
						$list='';	
						for($i=1;$i<10;$i++) {
                            if (isset($job_meta["ignyte_job_position_ReqSkill_".$i]) && $job_meta["ignyte_job_position_ReqSkill_".$i][0]<>"")
                                $list.="<li>".$job_meta['ignyte_job_position_ReqSkill_'.$i.''][0]."</li>";
                        } 
                        if ($list<>"") 
                            echo "<h5>Required Skills/Knowledge/Abilities</h5><ul>".$list."</ul>";
							
						if(isset($job_meta["ignyte_job_position_external_link"]) && $job_meta["ignyte_job_position_external_link"][0]<>""){
								echo  "<a target='_blank' class='btn btn-green' href='".$job_meta["ignyte_job_position_external_link"][0]."'>Apply Here</a>";
						}
                        ?>
                      	
                	</div>
                <?php endwhile; endif; ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div id="sidebar">
                	<div class="sb-bottom">
                    	<h5>Current Job Openings</h5>
                        <ul>
                            <?=$job_sidebar?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
		jQuery('#sidebar a[href^="#"]').on('click', function(event) {
			console.log(jQuery(this).attr('href'));
			var target = jQuery(this).attr('href')
			if( target.length ) {
				event.preventDefault();
				jQuery('html, body').animate({
					scrollTop: jQuery(target).offset().top-100
				}, 1000);
			}
		});
		</script>


    </div> <!-- /#main-content.container -->

    <?php if($page_meta["ignyte_bottom_shortcode_content"][0]<>""){ ?>
    <!-- If there are shortcodes / content blocks, this shows -->
     <div id="bottom-content">
     	<!-- Shortcodes / Content blocks would stack here -->
        <?php echo do_shortcode($page_meta["ignyte_bottom_shortcode_content"][0]);?>
     </div> <!-- /#bottom-content -->
	<?php } ?>
</div> <!-- /#page-wrap -->

<?php get_footer(); ?>