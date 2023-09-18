<!-- sidebar column -->

<div class="hidden-xs hidden-sm col-md-4 col-md-push-8 col-lg-4 col-lg-push-8">

    <div id="sidebar" class="stick">
    
		<div class="sb-bottom">
			<?php if ( function_exists ( dynamic_sidebar('main-sidebar') ) ) : ?>
    
            <?php dynamic_sidebar('main-sidebar'); ?>
    
            <?php endif; ?>
		</div>
 	</div>

</div> 