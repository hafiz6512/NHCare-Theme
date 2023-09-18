<? /**
 Template Name: Doctor Search Results page
*/
if( ( $_POST["specialty"]<>"" || $_POST["dlocation"]<>"" || $_POST["gender"]<>"" || $_POST["language"]<>"" || $_POST["providername"]<>"" || $_GET["showall"]<>"") ){

get_header();
$postid=get_the_ID();
$page_meta=get_post_meta( $postid );

$currentlang = get_bloginfo('language');

$specialty=sanitize_text_field($_POST["specialty"]);
$dlocation=sanitize_text_field($_POST["dlocation"]);
$gender=sanitize_text_field($_POST["gender"]);
$language=sanitize_text_field($_POST["language"]);
$providername=sanitize_text_field($_POST["providername"]);
$showall=sanitize_text_field($_POST["showall"]);

//var_dump($gender);

// This fetches on load the information we need for the search results
if($_GET["showall"]<>""){
	$args = array( 'post_type'=>'ignyte_provider' ,'posts_per_page' => -1 , 'lang' => substr($currentlang,0,2),'orderby' => 'title', 'order' => 'ASC' );
	//NEED TO ADD ORDERING, in the search refresh function

}else{
	$meta_array=array();
	if ($_POST["specialty"]<>""){
		array_push( $meta_array,array('key' => 'ignyte_services[]','value' => $specialty,'compare' => 'LIKE') );
	}
	if ($_POST["dlocation"]<>""){
		array_push( $meta_array,array('key' => 'ignyte_locations[]','value' => $dlocation,'compare' => 'LIKE') );
	}
	if ($_POST["language"]<>""){
		array_push( $meta_array,array('key' => 'ignyte_language[]','value' => $language,'compare' => 'LIKE') );
	}
	if ($_POST["gender"]<>""){
		array_push( $meta_array,array('key' => 'ignyte_gender[]','value' => $gender,'compare' => 'LIKE') );
	}
	if ($_POST["providername"]<>""){
		array_push( $meta_array,array('key' => 'ignyte-provider-displayed-name','value' => $providername,'compare' => 'LIKE') );
	}
	$args = array(
	  'post_type' => 'ignyte_provider',
	  'meta_query' => $meta_array ,
	  'post_status' => 'publish',
	  'posts_per_page' => -1 ,
	  'orderby' => 'title',
	  'order' => 'ASC',
	  'lang' => substr($currentlang,0,2)
	);
	//var_dump($args);
	//NEED TO ADD ORDERING, in the search refresh function

	}
	$searchresults=get_posts($args);
	$totalres=count($searchresults);
	$limitperpage=10;


	?>
	<div id="page-wrap">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post();
		$pages=$totalres/$limitperpage;
		?>

	  <div id="main-content">
		  <div class="container results-header">
			<div class="row">

				<div class="col-xs-12 col-sm-6">
					<h3><?=$currentlang=="en-US"?"Doctors":"Doctores/as"?>: <span class="base-font base-color"><?=$currentlang=="en-US"?"Search Results":"Resultados de la Busqueda"?> </span></h3>
					<h5 class="base-font base-color"><span id="start-number">1</span> - <span id="limit-number"><?=$limitperpage?></span> <?=$currentlang=="en-US"?"of":"de"?> <?=$totalres?> <?=$currentlang=="en-US"?"Results":"Resultados"?></h5>
                    <a class="back-search" href="<?=$currentlang=="en-US"?"search":"busqueda"?>"><span class="glyphicon glyphicon-chevron-left"></span> <?=$currentlang=="en-US"?"Back to Search":"Volver a Buscar"?></a>
				</div>

				<div class="col-xs-12 col-sm-6">
					<div class="results-controls">
						<span class="p-large"><?=$currentlang=="en-US"?"Sort by:":"Ordenar por:"?></span>
						<div class="btn-group" id="order-buttons">
						  <button type="button" id="nameatoz" class="btn btn-blue"><?=$currentlang=="en-US"?"Name A-Z":"Nombre A-Z"?></button>
						  <button type="button" id="nameztoa" class="btn btn-blue"><?=$currentlang=="en-US"?"Name Z-A":"Nombre Z-A"?></button>
						</div>
					</div>
				</div>

			</div>
		  </div> <!-- /.container.results-header -->

	  <!-- Start search results section -->
	  <div class="search-results" id="search-results-container">

       <?
	   $tabindex=0;
	   $i=0;
	   $firsttab=true;


	   foreach($searchresults as $doc) {

		    if($firsttab && $i==0  ){
				echo "<div id='searchtab_".$tabindex."' class='active'>"; //Opening first tab
				$tabindex++;
			}
			if(!$firsttab && $i==$limitperpage ){
				$i=0;
				echo "<div id='searchtab_".$tabindex."' class='hidden' >"; //Opening hidden tabs
				$tabindex++;
			}
		   $docmeta=get_post_meta($doc->ID);
		   //var_dump($docmeta);
		   $url = wp_get_attachment_url( get_post_thumbnail_id($doc->ID) );
		   ?>
		<!-- Single Result -->
		<a href="<?=get_permalink($doc->ID)?>" class="search-result">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6">
						<img class="img-circ" src="<?=$url?>" />
						<div class="phys-info">
							<h4><?=$docmeta['ignyte-provider-displayed-name'][0]?></h4>
							<ul><li><?=$docmeta['ignyte-provider-title'][0]?></li>
                            <li><?=$docmeta['ignyte-provider-primary-service'][0]?></li></ul>
							<p class="small view-g"><?=$currentlang=="en-US"?"View Profile":"Ver Perfíl"?> <span class="glyphicon glyphicon-chevron-right"></span></p>
						</div>
					</div>
					<!--<div class="hidden-xs col-sm-6">
						<div class="row">-->
                    <div class="hidden-xs hidden-sm col-md-2">
                        <div class="addtl-info">
                            <h5><?=$currentlang=="en-US"?"Services":"Servicios"?></h5>
                            <ul>
                                <? $docservices=array_reverse (unserialize($docmeta['ignyte_services[]'][0]) );
                                foreach($docservices as $docserv){ ?>
                                <li><?=$docserv?></li>
                                <? } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="hidden-xs hidden-sm col-md-2">
                        <div class="addtl-info">
                            <h5><?=$currentlang=="en-US"?"Locations":"Ubicaciones"?></h5>
                            <ul>
                                <? $doclocations=array_reverse (unserialize($docmeta['ignyte_locations[]'][0]));
                                foreach($doclocations as $docloc){ ?>
                                <li><?=$docloc?></li>
                                <? } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="hidden-xs hidden-sm col-md-2">
                        <div class="addtl-info">
                            <h5><?=$currentlang=="en-US"?"Languages Spoken":"Idiomas Hablados"?></h5>
                            <ul>
                                <?
                                 $doclanguages=unserialize($docmeta['ignyte_language[]'][0]);
                                foreach($doclanguages as $doclang){ ?>
                                <li><?=$doclang?></li>
                                <? } ?>
                            </ul>
                        </div>
                    </div>
						<!--</div>
					</div>-->
				</div>
			</div>
		</a> <!-- //END Single-result -->
	  <?
	  	if($i+1==$limitperpage || $i+1==$totalres){
			echo "</div>"; //Closing first tab
			$firsttab=false;
		}
	   $i++;
	   } ?>

	  </div> <!-- END Results -->
      </div> <!-- Close search results-->
       <!-- Pagination Block -->
		 <div class="pag-wrap">
			<div class="container">
            	<div class="pagination">
					<div class="pag-numbers">
                    <?
					//$pages=$totalres/$limitperpage;
                    for($j=0;$j<$pages;$j++){
					 echo '<a class="trigger_top" href="javascript:void(0);" onclick="ignyte_switch_to_tab('.$j.')" >'.($j+1). '</a>';
					}
					?>
					</div>
				</div>

				<div  class="prev-link"><a class="trigger_top" id="search-prev-link" href="javascript:void(0);"><?=$currentlang=="en-US"?"Previous Results":"Resultados Anteriores"?></a></div>

				<div  class="next-link"><a class="trigger_top" id="search-next-link" href="javascript:void(0);"><?=$currentlang=="en-US"?"Next Results":"Siguientes Resultados"?></a></div>
			</div>
		</div>


   </div> <!-- /#main-content  -->
	<script>

	jQuery(".trigger_top").click(function() {
		jQuery('html, body').animate({
			scrollTop: jQuery("#main-content").offset().top-129
		}, 500);
	});
	jQuery("#order-buttons button").click(function(){
		<?
		$extra_search_data="";
		if($specialty<>"")
			$extra_search_data.=", specialty:'".$specialty."'";
		if($dlocation<>"")
			$extra_search_data.=", dlocation:'".$dlocation."'";
		if($gender<>"")
			$extra_search_data.=", gender:'".$gender."'";
		if($language<>"")
			$extra_search_data.=", language:'".$language."'";
		if($providername<>"")
			$extra_search_data.=", providername:'".$providername."'";
		if($showall<>"")
			$extra_search_data.=", showall:'".$showall."'";
		if($currentlang<>"")
			$extra_search_data.=", currentlang:'".$currentlang."'";

		?>
		var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		var thisaction=jQuery(this).attr('id');
		console.log(thisaction);
		jQuery.post(ajaxurl, { action: 'ignyte_provider_search_get_results', data:{ orderby:thisaction <?=$extra_search_data?>  } }, function(output) {
		    		jQuery('#search-results-container').html(output);
			});
		});

		function ignyte_switch_to_tab(newtab){
			jQuery("#search-results-container .active").addClass("hidden");
			jQuery("#search-results-container .active").removeClass("active");
			jQuery("#searchtab_"+newtab).addClass("active");
			jQuery("#searchtab_"+newtab).removeClass("hidden");
			jQuery("#start-number").text((newtab*<?=$limitperpage?>) +1);
			if(((newtab+1)*<?=$limitperpage?>)><?=$totalres?>) {
				jQuery("#limit-number").text(<?=$totalres?>);
			}else{
				jQuery("#limit-number").text((newtab+1)*<?=$limitperpage?>);
			}

		}

		jQuery("#search-prev-link").click(function(){
			console.log("clicked previous");
			if(jQuery("#search-results-container .active").attr("id")=="searchtab_0"){
			}else{
				var current_tab=jQuery("#search-results-container .active").attr("id").split('_')[1] ;
				var new_current_tab=parseInt(current_tab)-1;
				ignyte_switch_to_tab(new_current_tab);

			}
		});
		jQuery("#search-next-link").click(function(){
			console.log("clicked next");
			if(jQuery("#search-results-container .active").attr("id")=="searchtab_<?=floor($pages)?>"){

			}else{
				var current_tab=jQuery("#search-results-container .active").attr("id").split('_')[1] ;
				var new_current_tab=parseInt(current_tab)+1;
				ignyte_switch_to_tab(new_current_tab);

			}
		});

	</script>

	<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php endif; ?>


	</div> <!-- /#page-wrap -->

	<?php get_footer();
	echo admin_url('admin-ajax.php');
}else{
	 wp_redirect( '?showall=1' );
	 exit;

}
?>