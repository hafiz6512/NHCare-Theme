<!-- sidebar column -->

<div class="col-xs-12 visible-xs-block col-sm-12 visible-sm-block">

    <div id="sidebar">
        
		<div class="sb-bottom">
			<?php if ( function_exists ( dynamic_sidebar('main-sidebar') ) ) : ?>
    
            <?php dynamic_sidebar('main-sidebar'); ?>
    
            <?php endif; ?>
		</div>
 	</div>

</div> 