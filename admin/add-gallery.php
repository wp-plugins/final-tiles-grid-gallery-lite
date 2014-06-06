<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

	global $ftg_options;
	$ftg_options = get_option('FinalTiles_gallery_options');
	global $ftg_parent_page;
	$ftg_parent_page = "add-gallery";
	
?>
<div class='wrap'>
    <?php include("adv.php") ?>
<h2>Final Tiles Gallery - <?php _e('Add Gallery', 'FinalTiles-gallery'); ?></h2>

	
    <p><?php _e('This is where you can create new galleries. Once the new gallery has been added, a short code will be provided for use in posts.', 'FinalTiles-gallery'); ?></p>
    <div id="settings">
	    <form name="gallery_form" id="gallery_form" action="?" method="post">
			<?php wp_nonce_field('FinalTilesGalleryLite', 'FinalTilesGalleryLite'); ?>
			<input type="hidden" name="add_gallery" value="true" />

			<?php include("include/edit-gallery.php") ?>

			<div class="form-buttons"> 
               <input id="add-gallery" type="submit" name="Submit" class="button-huge button action" value="<?php _e('Add Gallery', 'FinalTiles-gallery'); ?>" />
            </div>
    </form>
    </div>
    
     <script>
            (function ($) {
            	window.onload = function () {
	                FTG.init_gallery();
	                
	                $("select.multiple").change(function () {
		                var val = $(this).val();
		                if(val.length > 1)
		                	$(this).val(val[0]);
	                });
	                
	                $("tr:even").addClass("alternate");
		            $(".sections a:first").addClass("selected");
		            $(".sections a").click(function(e) {
		                e.preventDefault();
		                
		                var idx = $(".sections a").index(this);
		                
		                $(".sections a").removeClass("selected");
		                $(this).addClass("selected");
		                
		                $(".ftg-section").hide().eq(idx).show();
		                
		                if(idx == 6)
		                	$(".form-buttons").hide();
		                else
		                	$(".form-buttons").show();
		            });
		            $(".ftg-section").hide().eq(0).show();
	            }
            })(jQuery);
        </script>
    
    <pre>
    <?php
    /*
    global $nggdb;
	$galleries = $nggdb->find_all_galleries();
	
	
	$g = $nggdb->get_gallery($galleries[1]->gid);
	
	foreach($g as $img)
	{
		print_r($img->_ngiw->_orig_image);
				
	}
    */
    ?>
    </pre>
</div>
