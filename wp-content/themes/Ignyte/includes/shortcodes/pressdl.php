<?php
// Usage: [pressdl day="08" month="month name" year="2014" english="file_name_english.pdf" spanish="file_name_spanish.pdf" ]
add_shortcode('pressdl', 'pressdl_shortcode');
function pressdl_shortcode($atts, $content = null) {
	extract( shortcode_atts( array(
		'day' => '',
		'month' => '',
		'year' => '',
		'english' => '',
		'spanish' => '',
		'post_id' => '',
	), $atts ) );
	ob_start(); 
	
	if($post_id==""){
		$post_id=get_the_ID();
	}
		
	$day = get_the_date( "d", $post_id ); 
    $month = get_the_date( "F", $post_id ); 
    $year = get_the_date( "Y", $post_id ); 
    
	?>
        <!-- //START individual press release shortcode HTML: -->
        <li>
            <div class="li-inner">
                <div class="date-wrap">
                    <div class="date-circ">
                        <span class="day"><?=$day?></span>
                        <span class="month"><?=$month?></span>
                        <span class="year"><?=$year?></span>
                    </div>
                </div>
                <div class="pr-info">
                    <p class="dl-title"><?=get_the_title($post_id)?></p>
                    <p class="dl-links">Download PDF: <? if (pdf_file_url_en($p->ID)<>""){?><a target="_blank" href="<?=pdf_file_url_en($p->ID)?>">English</a> <? } if (pdf_file_url_es($p->ID)<>""){?> <a target="_blank" href="<?=pdf_file_url_es($p->ID)?>">Spanish</a><? } ?></p>
                </div>
            </div>
        </li>
        <!-- //END individual single release shortcode HTML: -->
	<?  $html = ob_get_contents();
	ob_end_clean();
	return $html;
}



