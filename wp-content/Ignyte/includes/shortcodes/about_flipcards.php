<?php
// Usage: [about_flipcards name="" title="" affiliation="" url=""]
add_shortcode('about_flipcards', 'about_flipcards_shortcode');
function about_flipcards_shortcode($atts, $content = null) {
	extract( shortcode_atts( array(
		'first_flip_name' => 'Join Our Team',
		'first_flip_content' => 'Do you have a passion for community health and the skills to make a difference? We’re always looking for motivated individuals to join the Neighborhood team.',
		'first_flip_link' => '/careers/',
		'second_flip_name' => 'Volunteer',
		'second_flip_content' => 'Volunteers are central to the work we do. Share your time and talent today and help us work toward a community where everyone is healthy and happy.',
		'second_flip_link' => '/volunteer/',
		'third_flip_name' => 'Donate',
		'third_flip_content' => 'Your financial support brings positive change to our communities. It’s change you can see firsthand in the smiles of the patients we serve. Donate today!',
		'third_flip_link' => '/donate-now/',
		'showmore_button' => 'SHOW MORE'
	), $atts ) );
	ob_start(); ?>
	<!-- //START about_flipcards_shortcode shortcode HTML: -->  
    <div class="row card-grid">
		<div class="container">
			<div class="thepatterns about-bg-2">
				<div class="pattwrap">
					<div class="pattblock blue left" style="margin-top: 35.1172px;"></div>
				</div>
			</div>
		</div>
        <div class="col-md-offset-2 col-md-9 col-sm-12 col-xs-12 get-involved-cards">
            <div class="col-md-4 col-sm-4 col-xs 1 flipcard active-card" id='first-flip' onclick="javascript:window.location.href='<?= $first_flip_link; ?>';">
                <div class="overlay-nohover"><h5 class="white"><?= $first_flip_name; ?></h5></div>
                <div class="overlay">
                    <div class="text">
                        <h5 class="white"><?= $first_flip_name; ?></h5>
                        <p><?= $first_flip_content; ?></p>

                        <div>
                            <a href="<?= $first_flip_link; ?>" class="btn hidden-text-btn icon arrow white add-more">
                                <div class="hidden-text white"><?= $showmore_button; ?></div></a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs 1 flipcard" id='second-flip' onclick="javascript:window.location.href='<?= $second_flip_link; ?>';">
                <div class="overlay-nohover"><h5 class="white"><?= $second_flip_name; ?></h5></div>
                <div class="overlay">
                    <div class="text">
                        <h5 class="white"><?= $second_flip_name; ?></h5>
                        <p><?= $second_flip_content; ?></p>

                        <div>
                            <a href="<?= $second_flip_link; ?>" class="btn hidden-text-btn icon arrow white add-more">
                                <div class="hidden-text white"><?= $showmore_button; ?></div></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs 1 flipcard" id='third-flip' onclick="javascript:window.location.href='<?= $third_flip_link; ?>';">
                <div class="overlay-nohover"><h5 class="white"><?= $third_flip_name; ?></h5></div>
                <div class="overlay">
                    <div class="text">
                        <h5 class="white"><?= $third_flip_name; ?></h5>
                        <p><?= $third_flip_content; ?></p>

                        <div>
                            <a href="<?= $third_flip_link; ?>" class="btn hidden-text-btn icon arrow white add-more">
                                <div class="hidden-text white"><?= $showmore_button; ?></div></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>

   
    
    
	<!-- //END about_flipcards_shortcode shortcode HTML: -->
	<? 
	$html = ob_get_contents();
	ob_end_clean();
	return $html;
}