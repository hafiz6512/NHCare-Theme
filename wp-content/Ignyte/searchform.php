<? 
	$currentlang = get_bloginfo('language');
    $search_placeholder=pll__('Search');
	
	if ($currentlang == "en-US") { 
		$saerch_action_url = "/";
	} else { 
		$saerch_action_url = "/".$currentlang."/"; 
	} 
?>
<form class="form" action="<?php echo $saerch_action_url; ?>" method="get">
    <fieldset>
        <input class="form-control" placeholder="<?php echo $search_placeholder; ?>" type="text" name="s" id="search" value="<?php the_search_query(); ?>" />
		<span class="glyphicon glyphicon-search form-control-feedback"></span>
	</fieldset>
</form>