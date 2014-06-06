<?php
	if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }
	
	$galleryResults = $this->FinalTilesLiteDB->getGalleries();
	$default_options = get_option('FinalTiles_gallery_options');
	$gallery = null;
	//Select gallery
	if(isset($_POST['select_gallery']) || isset($_POST['galleryId'])) {
		if(check_admin_referer('FinalTiles_gallery','FinalTiles_gallery')) {
		  $gid = (isset($_POST['select_gallery'])) ? intval(stripslashes($_POST['select_gallery'])) : intval(stripslashes($_POST['galleryId']));	
		  
		  $imageResults = $this->FinalTilesLiteDB->getImagesByGalleryId($gid);
		  $gallery = $this->FinalTilesLiteDB->getGalleryById($gid);      
		}
	}
	
	global $ftg_parent_page;
	$ftg_parent_page = "edit-gallery";

?>
<div class='wrap'>
    <?php include("adv.php") ?>

<h2>FinalTiles Gallery - <?php _e('Edit Galleries', 'FinalTiles-gallery'); ?></h2>
<?php if(!isset($_POST['select_gallery']) && !isset($_POST['galleryId'])) { ?>
    <p><?php _e('Select a gallery to edit its properties', 'FinalTiles-gallery'); ?></p>		
    <table class="widefat post fixed" id="galleryResults" cellspacing="0">
	<thead>
    	<tr>
          <th><?php _e('Gallery Name', 'FinalTiles-gallery'); ?></th>
          <th><?php _e('Description', 'FinalTiles-gallery'); ?></th>
          <th></th>
          <th></th>
        </tr>
    </thead>
    <tfoot>
    	<tr>
          <th><?php _e('Gallery Name', 'FinalTiles-gallery'); ?></th>
          <th><?php _e('Description', 'FinalTiles-gallery'); ?></th>
          <th></th>
          <th></th>
        </tr>
    </tfoot>
    <tbody>
    	<?php
			foreach($galleryResults as $gallery) {
				?>
                <tr>
                	<td><?php _e($gallery->name); ?></td>
                    <td><?php _e($gallery->description); ?></td>
                    <td></td>
                    <td>
                    	<form name="select_gallery_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
                    	<?php wp_nonce_field('FinalTiles_gallery', 'FinalTiles_gallery'); ?>
                        <input type="hidden" name="galleryId" value="<?php _e($gallery->Id); ?>" />
                        <input type="hidden" name="galleryName" value="<?php _e($gallery->name); ?>" />
                        <input type="submit" name="Submit" class="button action" value="<?php _e('Select Gallery', 'FinalTiles-gallery'); ?>" />
                		</form>
                    </td>
                </tr>
		<?php } ?>
        <tr>
        </tr>
    </tbody>
</table>
    
    <?php } else if(isset($_POST['select_gallery']) || isset($_POST['galleryId'])) { ?>  

        <h3>Gallery: <?php _e($gallery->name); ?></h3>        
        
        <div id="settings">
            <form name="gallery_form" id="gallery_form" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>" method="post">
            <?php wp_nonce_field('FinalTilesGalleryLite', 'FinalTilesGalleryLite'); ?>
            <input type="hidden" name="ftg_gallery_edit" id="gallery-id" value="<?php _e($gid); ?>" />
            <?php include("include/edit-gallery.php") ?>
            
            <div class="form-buttons"> 
               <input id="edit-gallery" type="submit" name="Submit" class="button button-huge action" value="<?php _e('Update Gallery', 'Mikado'); ?>" />     
            </div>
            </form>
        </div>

        <script>
            (function ($) {
            	window.onload = function () {
	                FTG.load_images();
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
    <?php } ?>  
</div>