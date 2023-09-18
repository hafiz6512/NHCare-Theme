<?php
/*
Template Name: Landing Page - Version 001
*/
 get_header(); 
 $page_meta=get_post_meta( get_the_ID() ); 
?>
<div id="page-wrap">
	<section class="nhcare-landing-page-section">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<? if (isset($page_meta['ignyte_banner_image'][0]) && $page_meta['ignyte_banner_image'][0]<>"") { ?>
		<div class="container-fluid">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<a id="lp-logo" href="https://www.nhcare.org/" target="_parent" title="Neighborhood Healthcare logo">
							<svg id="neighborhood-healthcare-logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 99.71 21.85"><title>nhcare-logo</title><path id="n" class="logo-letter" d="M4.19,4.05a3.33,3.33,0,0,0-2.39.87V4.23H0V12.4H1.92V7.54a1.76,1.76,0,0,1,.5-1.29,1.79,1.79,0,0,1,1.3-.5A1.66,1.66,0,0,1,5,6.24a1.78,1.78,0,0,1,.47,1.3V12.4H7.35V7.31A3.31,3.31,0,0,0,6.51,5a3,3,0,0,0-2.32-.9"/><path id="e" class="logo-letter" d="M10.22,7.46A2.4,2.4,0,0,1,11,6.17a2.26,2.26,0,0,1,1.47-.52,2.16,2.16,0,0,1,1.44.51,1.79,1.79,0,0,1,.59,1.3Zm2.33-3.41A4.24,4.24,0,0,0,9.47,5.29a4.11,4.11,0,0,0-1.25,3,4,4,0,0,0,1.28,3,4.46,4.46,0,0,0,3.22,1.23,4.8,4.8,0,0,0,3.34-1.31l.05,0-.92-1.3-.07.06a3.54,3.54,0,0,1-2.35.93A2.76,2.76,0,0,1,11,10.37,2.27,2.27,0,0,1,10.18,9h6.11V8.89a4.79,4.79,0,0,0,.14-1.09,3.55,3.55,0,0,0-1.11-2.68,3.83,3.83,0,0,0-2.78-1.07Z"/><path id="dot" class="logo-letter" d="M18.43.64a1.26,1.26,0,0,0-.91.36,1.13,1.13,0,0,0-.38.86,1.11,1.11,0,0,0,.38.85,1.29,1.29,0,0,0,.91.35,1.28,1.28,0,0,0,.89-.35,1.11,1.11,0,0,0,.37-.85A1.14,1.14,0,0,0,19.32,1a1.25,1.25,0,0,0-.89-.36"/><polygon id="i" class="logo-letter" points="17.46 12.4 19.38 12.4 19.38 4.23 17.46 4.23 17.46 12.4"/><path id="h" class="logo-letter" d="M34.53,4.05a3.22,3.22,0,0,0-2.3.85V0H30.31V12.4h1.92V7.55a1.74,1.74,0,0,1,.5-1.28,1.79,1.79,0,0,1,1.3-.5,1.63,1.63,0,0,1,1.25.49,1.79,1.79,0,0,1,.46,1.29V12.4h1.92V7.31A3.32,3.32,0,0,0,36.82,5a3,3,0,0,0-2.29-.91"/><path id="b" class="logo-letter" d="M44.91,10.15a2.37,2.37,0,0,1-1.74.71,2.48,2.48,0,0,1-1.7-.64,2.44,2.44,0,0,1-.71-1.9,2.49,2.49,0,0,1,.71-1.9,2.44,2.44,0,0,1,1.7-.65,2.37,2.37,0,0,1,1.74.71,2.52,2.52,0,0,1,.7,1.82,2.58,2.58,0,0,1-.7,1.85m-1.46-6.1a3.54,3.54,0,0,0-2.67,1V0H38.86V12.4h1.8v-1a3.16,3.16,0,0,0,1.11.81,4.17,4.17,0,0,0,1.7.35,3.9,3.9,0,0,0,2.94-1.22,4.24,4.24,0,0,0,1.16-3A4.24,4.24,0,0,0,46.4,5.27a3.92,3.92,0,0,0-2.95-1.22"/><path id="o" class="logo-letter" d="M54.49,10.12a2.43,2.43,0,0,1-1.78.72,2.36,2.36,0,0,1-1.77-.72,2.51,2.51,0,0,1-.7-1.8,2.46,2.46,0,0,1,2.49-2.55,2.44,2.44,0,0,1,1.76.73,2.5,2.5,0,0,1,.71,1.82,2.47,2.47,0,0,1-.71,1.8M52.71,4.05a4.37,4.37,0,0,0-3.14,1.23,4,4,0,0,0-1.28,3,4,4,0,0,0,1.28,3,4.59,4.59,0,0,0,6.29,0,4,4,0,0,0,1.31-3,4,4,0,0,0-1.31-3,4.41,4.41,0,0,0-3.15-1.23"/><path id="r" class="logo-letter" d="M62.14,4.15a2.94,2.94,0,0,0-2.32,1V4.23H58V12.4h1.92V8a2,2,0,0,1,.66-1.58,2.51,2.51,0,0,1,1.67-.56h.62V4.25l-.06,0a2.91,2.91,0,0,0-.69-.08"/><path id="h-2" data-name="h" class="logo-letter" d="M68.14,4.05a3.22,3.22,0,0,0-2.3.85V0H63.92V12.4h1.92V7.55a1.74,1.74,0,0,1,.5-1.28,1.79,1.79,0,0,1,1.3-.5,1.63,1.63,0,0,1,1.25.49,1.79,1.79,0,0,1,.46,1.29V12.4h1.92V7.31A3.32,3.32,0,0,0,70.43,5a3,3,0,0,0-2.29-.91"/><path id="o-2" data-name="o" class="logo-letter" d="M78.21,10.12a2.41,2.41,0,0,1-1.78.72,2.37,2.37,0,0,1-1.77-.72,2.51,2.51,0,0,1-.7-1.8,2.46,2.46,0,0,1,2.49-2.55,2.45,2.45,0,0,1,2.47,2.55,2.47,2.47,0,0,1-.71,1.8M76.43,4.05a4.37,4.37,0,0,0-3.14,1.23A4,4,0,0,0,72,8.3a4,4,0,0,0,1.28,3,4.59,4.59,0,0,0,6.29,0,4,4,0,0,0,1.31-3,4,4,0,0,0-1.31-3,4.41,4.41,0,0,0-3.15-1.23"/><path id="o-3" data-name="o" class="logo-letter" d="M87.71,10.12a2.39,2.39,0,0,1-1.77.72,2.36,2.36,0,0,1-1.77-.72,2.47,2.47,0,0,1-.7-1.8A2.46,2.46,0,0,1,86,5.77a2.45,2.45,0,0,1,1.76.73,2.5,2.5,0,0,1,.71,1.82,2.44,2.44,0,0,1-.72,1.8M85.94,4.05A4.37,4.37,0,0,0,82.8,5.28a4,4,0,0,0-1.28,3,4,4,0,0,0,1.28,3,4.59,4.59,0,0,0,6.29,0,4,4,0,0,0,1.31-3,4,4,0,0,0-1.31-3,4.44,4.44,0,0,0-3.15-1.23"/><path id="d" class="logo-letter" d="M97.1,10.22a2.48,2.48,0,0,1-1.7.64,2.36,2.36,0,0,1-1.75-.71A2.54,2.54,0,0,1,93,8.3a2.48,2.48,0,0,1,.7-1.82,2.36,2.36,0,0,1,1.75-.71,2.34,2.34,0,0,1,2.41,2.55,2.44,2.44,0,0,1-.71,1.9ZM97.77,0V5.08a3.52,3.52,0,0,0-2.67-1,3.9,3.9,0,0,0-2.94,1.22A4.28,4.28,0,0,0,91,8.32a4.25,4.25,0,0,0,1.16,3,3.9,3.9,0,0,0,2.94,1.22,3.46,3.46,0,0,0,2.81-1.18v1h1.8V0Z"/><path id="g" class="logo-letter" d="M26.7,19.19a2,2,0,0,1-1.72,1,2,2,0,0,1-.9-.22,1.89,1.89,0,0,1-.94-1.12,1.83,1.83,0,0,1,.14-1.43,15.91,15.91,0,0,1,4.07-2.83,15,15,0,0,1-.65,4.6m-.08-9a2.6,2.6,0,0,1-1.77.66,2.52,2.52,0,0,1-1.8-.7,2.43,2.43,0,0,1-.72-1.83,2.39,2.39,0,0,1,.72-1.81,2.52,2.52,0,0,1,1.8-.69,2.67,2.67,0,0,1,1.77.62,2.34,2.34,0,0,1,.73,1.86,2.44,2.44,0,0,1-.73,1.89m2.48,2V4.24H27.39v1a3.68,3.68,0,0,0-2.87-1.14,4.1,4.1,0,0,0-4.23,4.24,4.11,4.11,0,0,0,1.21,3,4.15,4.15,0,0,0,3,1.19,3.83,3.83,0,0,0,2.87-1.1v.33h0v1c-1.95.95-5,2.78-5.61,3.93a3.48,3.48,0,0,0,1.5,4.79,3.71,3.71,0,0,0,1.7.42A3.67,3.67,0,0,0,28.2,20c.76-1.4.88-5.42.9-7.1h0v-.72h0"/></svg>
						</a>
					</div>
					<div class="col-sm-6 text-right">
						<p><!---- <a href="https://mycw32.eclinicalweb.com/portal3449/jsp/100mp/login_otp.jsp" target="_blank" class="btn">Already a Patient</a>----> <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#appointment-modal">Schedule online </a></p>
					</div>
				</div>
			</div>
			<div class="row lp-top">
				<div class="col-md-8 right-content" style="background-image:url(<?=$page_meta['ignyte_banner_image'][0]?>)"></div>
				<div class="col-md-4 left-content container">
					<div class="row left-top">
						<p class="bg-red lead-text-box"><?=the_title();?></p>
							<?php if ($page_meta["ignyte_banner_content"][0]) {
								echo $page_meta["ignyte_banner_content"][0];
							} ?>
					</div>
				</div>
			</div>
		<? } ?>
			<div id="main-content" class="container">
				<div class="row">
					<div class="col-sm-offset-1 col-sm-7">
						<?php
							remove_filter('the_content', 'wpautop');
							the_content(); ?>
					</div>
					<div class="col-sm-offset-1 col-sm-3">
						<div class="right-sidebar">
								<?php if($page_meta["ignyte_bottom_shortcode_content"][0]!=""){ ?>
							<div>
								<?php echo do_shortcode(get_post_meta($post->ID, 'ignyte_bottom_shortcode_content', true));?>
							</div>
								<?php } ?>
								<?php endwhile; else: ?>
								<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div> 
<div class="modal fade" id="appointment-modal" role="dialog" aria-hidden="false">
	<div class="vertical-alignment-helper">
		<div class="modal-dialog modal-lg vertical-align-center">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">Close ×</button>
				</div>
				<div class="modal-body">
					<div class="content">
						<iframe src="https://mynhcare.org/app" height="200" width="300"></iframe>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="//cdn.callrail.com/companies/293981220/0aca15d561a244f5647a/12/swap.js"></script>
<?php get_footer(); ?>