<? /**

 Template Name: Provider - Single Post

*/

get_header();

$postid=get_the_ID();
$page_meta=get_post_meta( $postid );
$currentlang = get_bloginfo('language');
//var_dump($page_meta);
?>

    <div id="page-wrap">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


 	<!-- Top page area -->

    <div class="container">

    <div id="doctor-profile">


		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 back">
            	<? if ($currentlang=="en-US"){?>
                    <p><a href="/find-a-doctor/"><i class="back-arrow"></i><?php echo pll__("Back to Results"); ?></a></p>

                <? }else{ ?>
                    <p><a href="/es/buscar-medico/"><i class="back-arrow"></i><?php echo pll__("Back to Results"); ?></a></p>

                <?php } ?>

			</div>
			<div <?php post_class('col-md-12 padding-0'); ?>>
				<div class="container">
				<div class="thepatterns doctor-detail-bg-1">
				<div class="pattwrap">
				<div class="pattblock blue left"></div>
				</div>
				</div>
				</div>
				<?php $featured_img_url='';
					if( has_post_thumbnail()) :
						$featured_img_url = get_the_post_thumbnail_url($postid, 'full');
					endif; ?>
				<div class="col-xs-12 col-sm-6 col-sm-pull-6 right-content" style="background-image:url(<?php echo  $featured_img_url; ?>)"></div>
				<div class="col-xs-12 col-sm-6 col-sm-push-6 left-content">
					<div class="left-top bg-green">
						<span><?php 
						$providerTerms = get_the_terms($postid, 'ignyte_category');
						if ( $providerTerms[0]->name == "Neighborhood Provider" ) {
							echo $providerTerms[0]->name . " ";
						} else if ( $providerTerms[0]->name == "Affiliate Provider" ) {
							echo $providerTerms[0]->name . " ";
						} else {
							echo "Provider ";
						}
						echo pll__("Detail"); ?></span>

						<h1 class="page-heading white"><?=$page_meta["ignyte-provider-displayed-name"][0]?></h1>
						<h5 class="white">
                         <?php    $m_specialty = wp_get_post_terms($postid, 'ignyte_specialty' );
                         $firstLink = true;
                            foreach($m_specialty as $specialty) {
                                if ($firstLink) {
                                    $specility .= $specialty->name;
                                    $firstLink = false;
                                }
                                else
                                {
                                     $specility .= ", ".$specialty->name;;
                                }

                            }
                            ?>

                            <?php echo $specility; ?></h5>
						<div class="location">
						<?php
							$locations=array_reverse (unserialize($page_meta["ignyte_locations[]"][0]), true);
							if ($locations<>""){
								?>
								<? $prefix='';
								if ($currentlang=="es-ES"){
								    $prefix='/es';
                                }?>

								<?php foreach($locations as $key=>$thisloc){
									// var_dump($thisloc);
                                //$loc = preg_replace('/\s+/', '-', $thisloc);
                                $loc = strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), $thisloc));
								    ?>
									<!-- <p><a class="underline white" href="<?=$prefix?>/locations/?loc=<?=$loc?>"><?=$thisloc?></a></p> -->
									<p><a class="underline text-white white" href="<?=$prefix?>/locations-list/<?=$loc?>"><?=$thisloc?></a></p>
								<?php } ?>

						<? } ?>
						</div>

                        <a class="btn white" data-toggle="modal" data-target="#appointment-modal"><?php echo pll__("Schedule an Appointment"); ?></a>

					</div>
					<div class="left-bottom">
						<?php 	$services=array_reverse (unserialize($page_meta["ignyte_services[]"][0]), true); ?>

						<?php
						if ($services<>""){
							?>
							<h5><?php echo pll__("Services"); ?></h5>

								<?php foreach($services as $key=>$thisserv){ ?>
								<p><a class="underline" href="<?=get_permalink($key)?>"><?=$thisserv?></a></p>
								<?php } ?>

						<? } ?>
    <?php if($page_meta['ignyte-provider-since'][0]!="") { ?>
						<h5 class="joining-year"><?php echo pll__("Provider Since"); ?></h5>
						<p class="year"><?=$page_meta['ignyte-provider-since'][0]?></p>
<?php } if($page_meta['ignyte-provider-education'][0]!="") { ?>
						<h5 class="site-locations"><?php echo pll__("Education"); ?></h5>
						<p><?php echo $page_meta['ignyte-provider-education'][0]; ?></p>
        <?php } ?>


						<?
						$the_content = apply_filters('the_content', get_the_content());

						if ( !empty($the_content) ) { ?>
                        <div class="hobby">
							<h5><?php echo pll__("Hobby/Fun Fact/Quote"); ?></h5>
							<?php the_content(); ?>
						</div>
                        <? } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
    </div> <!--conteiner-->
  </div><!-- End page top area -->


    <?php if($page_meta["ignyte_bottom_shortcode_content"][0]!=""){ ?>

    <!-- If there are shortcodes / content blocks, this shows -->
     <div id="bottom-content">

     	<!-- Shortcodes / Content blocks would stack here -->
        <?php // echo apply_filters('the_content', get_post_meta($post->ID, 'ignyte_bottom_shortcode_content', true)); ?>
        <?php echo do_shortcode(get_post_meta($post->ID, 'ignyte_bottom_shortcode_content', true));?>

     </div> <!-- /#bottom-content -->

	<?php } ?>

<?php endwhile; else: ?>

    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

<?php endif; ?>


</div> <!-- /#page-wrap -->

<?php get_footer(); ?>