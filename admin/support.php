<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die(_e('You are not allowed to call this page directly.','final-tiles-gallery')); } ?>
<?php $ftg_subtitle = "Support"; ?>
<?php include "header.php" ?>


<div class="container">        
    <div class="row">
	    <div class="section s12 m12 l12 col" id="support-page">
			<p>
				<strong><?php _e('Having problems with the plugin? No panic, you have two roads:','final-tiles-gallery'); ?></strong><br>
				<br>
				1) <?php _e('write on','final-tiles-gallery')?> <a href="https://wordpress.org/support/plugin/final-tiles-grid-gallery-lite" target="_blank"><?php _e('support forum.','final-tiles-gallery')?></a> <?php _e("We'll try to answer as soon as we can;",'final-tiles-gallery')?><br>
				<br>
				- <?php _e('or','final-tiles-gallery')?> -<br>
				<br>
				2) <?php _e('buy the PRO version and get fast and guaranteed help on our','final-tiles-gallery')?> <a href="http://greentreelabs.ticksy.com" target="_blank"><?php _e('support platform','final-tiles-gallery') ?></a>.
			</p>		
			
			<p>
				<?php _e('In both cases, remember:','final-tiles-gallery') ?><br>
				<?php _e('to get a fast solution you should gather these basic but important informations','final-tiles-gallery')?></strong>:
			</p>
			<ul>
				<li><?php _e('URL of the page with the gallery;','final-tiles-gallery')?> </li>
				<li><?php _e('describe the problem you are experiencing;','final-tiles-gallery')?></li>
				<li><?php _e('browser and operating system used.','final-tiles-gallery')?></li>
			</ul>
			<p>
				<?php _e('Another great help from you would be doing a couple of tests, try these simple operations and let us know the results:','final-tiles-gallery')?>
			</p>
			<ul>
				<li><?php _e("Switch to the default WordPress theme and look if the problem is still there, if not we'll already know that the problem is related to your theme and we can be faster solving the issue;",'final-tiles-gallery')?></li>
				<li><?php _e('See if the problem is repeatable, also on another computers.','final-tiles-gallery')?></li>
			</ul>
			<p><strong><?php _e("The more complete these informations are, the faster we'll be our response",'final-tiles-gallery')?></strong> <?php _e("(aware out time zome, we're +1 GMT), thanks!",'final-tiles-gallery')?></p>
	    </div>
	</div>
</div>
