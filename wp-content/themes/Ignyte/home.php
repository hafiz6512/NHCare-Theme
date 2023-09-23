<?php get_header();

$page = get_page_by_path( 'blog' );
$page_meta=get_post_meta( $page->ID ); 

//var_dump($page_meta);

?>
<div id="page-wrap">
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
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
				$featured_image_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) );
			 ?>
            	<div class="row post-item">
                	<div class="col-xs-12 col-sm-4 col-md-3">
                    	<? if ($featured_image_url<>"") {?>
                            <img src="<?=$featured_image_url?>" class="img-circ" />
                        <? } ?>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-9">
                        <h3><a href="<? the_permalink('Read more...'); ?>"><? the_title();?> </a></h3>
                        
        
                            <div class="meta">
                                by <strong><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                                    <?php printf( __( '%s', 'Ignyte' ), get_the_author() ); ?>
                                </a></strong> on <strong><?php echo get_the_date(); ?></strong> in <strong><?php the_category(', '); ?></strong>
                                
								<? //$cats=get_the_category();
                                //if($cats<>""){ 
                                //$first=true;
                                ?>
                                
                                <!--<span class="entry-category"><? //foreach($cats as $cat){ 
                                                                        //if($first) 
                                                                            //echo $cat->name;
                                                                        //else
                                                                            //echo ",".$cat->name;
                                                                    //} ?></span>-->
                                <? //} ?>
                            </div><!-- .meta-->
                            
                        
                        
                        
                        <?=str_replace('[...]','',the_excerpt()); ?>
                        
                        <a class="more-link btn btn-blue" href="<?=get_permalink()?>">Read More</a>
                    </div>
                </div>
            <?php endwhile; else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
            <?php endif; ?>
            </div> 
        </div>
      </div> <!-- /.container -->
    </div> <!-- /#main-content -->



</div> <!-- /#page-wrap -->



<?php get_footer(); ?>