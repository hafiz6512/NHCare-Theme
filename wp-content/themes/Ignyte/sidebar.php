<!-- sidebar column -->

<div class="col-xs-12 col-sm-4 col-lg-4">

    <div id="sidebar">

		<?php if ( function_exists ( dynamic_sidebar('main-sidebar') ) ) : ?>

        <?php dynamic_sidebar('main-sidebar'); ?>

        <?php endif; ?>

 	</div>

</div> 