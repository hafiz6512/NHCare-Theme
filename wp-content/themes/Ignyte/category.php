<?php
/*
Template Name: Category Page
*/
 get_header(); 
 $page_meta=get_post_meta( get_the_ID() ); 
 $currentlang = get_bloginfo('language');
 //$query->set('posts_per_page', -1);
?>
<div id="page-wrap">

    <div id="main-content">
      <div class="container">
    	<div class="row">
        	<div class="col-xs-12 col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10 lead-copy">
            	<?php $thiscat=get_the_category(); 
				echo " <!-- <pre>";
				var_dump($thiscat);
				echo" </pre> -->"
				?>
                
                <h1><? // =($currentlang=="es-ES")?"Archivo de:":"Archive for:"; ?> <?=$thiscat[0]->name?></h1>
                <p class="leadin"><?=$thiscat[0]->description?></p>
            </div>
        </div>
        <!-- Main editor page contents -->
        <div class="row">
        	<div class="col-xs-12 col-sm-12">
            
            <?php 
			if ($thiscat[0]->slug=="latest-articles" or $thiscat[0]->slug=="ultimos-articulos"){

				 if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h1><? the_title();?></h1>
                       <?php /*
                        <div class="meta">
                            by <strong><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                                <?php printf( __( '%s', 'Ignyte' ), get_the_author() ); ?>
                            </a></strong> on <strong><?php echo get_the_date(); ?></strong> in <strong><?php the_category(', '); ?></strong>
                           
                        </div><!-- .meta-->
                        */ ?>
                        <?=str_replace('[...]','',the_excerpt()); ?>
                        <a class="more-link btn btn-blue" href="<?=get_permalink()?>">Read More</a>
                    </div>

                 <?php  endwhile;else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                
            <?php endif; 
				
			}else{
				$simplelist=false;
				switch ($thiscat[0]->slug){
					case "press-releases":
					case "comunicados-de-prensa":
						echo '<ul class="pr-dl">';
					break;
					
					case "newsletter":
					case "boletin-de-noticias":
						echo '<ul class="bullet-list-dl">';
					break;
					
					case "in-the-news":
					case "en-las-noticias":
					default:
						$simplelist=true;
						echo '<ul class="color-bl">';
				} ?>
            
            <?php 

			if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
           		<?php if( $post->post_content<>"" ){ ?> 
           
                   <? if ($simplelist){ ?>
                        <li><?php echo $post->post_content; ?><br></li>
                   <? } else { ?>
                        <? the_content(); ?>
                    <? } ?>
                    
               	<?php }else{ 
                	echo do_shortcode("[pressdl]");
  		        }?>
                        <?php  endwhile;else: ?>
                <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
            <?php endif; ?>
            
            	</ul>
             <? } ?>
                
            </div> 
        </div>
	  </div> <!-- /.container -->
    </div> <!-- /#main-content -->

</div> <!-- /#page-wrap -->
<?php get_footer(); ?>