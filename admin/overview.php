<?php
    if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); }

    if(isset($_POST['galleryId'])) 
    {
	    if(check_admin_referer('FinalTiles_gallery','FinalTiles_gallery')) {
	      $this->FinalTilesLiteDB->deleteGallery(intval($_POST['galleryId']));
		  
	      ?>  
	      <div class="updated"><p><strong><?php _e('Gallery has been deleted.', 'FinalTiles-gallery'); ?></strong></p></div>  
	      <?php	
	    }
    }

    $galleryResults = $this->FinalTilesLiteDB->getGalleries();
    if (isset($_POST['defaultSettings'])) 
    {
    	if(check_admin_referer('FinalTiles_gallery','FinalTiles_gallery')) {
    	  $temp_defaults = get_option('FinalTiles_gallery_options');
    	  
    	  foreach(array_keys($_POST) as $f)
    	  {
    	  		if(substr($f, 0, 4) == "ftg_")
			      	$temp_defaults[substr($f, 4)] = $_POST[$f];
    	  }

    	  update_option('FinalTiles_gallery_options', $temp_defaults);
    	  ?>  
    	  <div class="updated"><p><strong><?php _e('Gallery options have been updated.', 'Mikado'); ?></strong></p></div>  
    	  <?php
    	}
    }    

    global $ftg_options;
    global $ftg_parent_page;
    
    $ftg_options = get_option('FinalTiles_gallery_options');
    
?>
<div class='wrap'>

<?php include("adv.php") ?>

<h2>Final Tiles Gallery</h2>
<p><?php _e('This is a listing of all galleries', 'FinalTiles-gallery'); ?></p>
    <table class="widefat post fixed" id="galleryResults" cellspacing="0">
    	<thead>
        <tr>
        	<th><?php _e('Gallery Name', 'FinalTiles-gallery'); ?></th>
            <th><?php _e('Gallery Short Code', 'FinalTiles-gallery'); ?></th>
            <th><?php _e('Description', 'FinalTiles-gallery'); ?></th>
            <th width="136"></th>
        </tr>
        </thead>
        <tfoot>
        <tr>
        	<th><?php _e('Gallery Name', 'FinalTiles-gallery'); ?></th>
            <th><?php _e('Gallery Short Code', 'FinalTiles-gallery'); ?></th>
            <th><?php _e('Description', 'FinalTiles-gallery'); ?></th>
            <th></th>
        </tr>
        </tfoot>
        <tbody>
        	<?php foreach($galleryResults as $gallery) { ?>				
            <tr>
            	<td><?php _e($gallery->name); ?></td>
                <td>
                    <div class="text dark">
                        <input type="text" size="40" value="[FinalTilesGallery id='<?php _e($gallery->Id); ?>']" />
                    </div>
                </td>
                <td><?php _e($gallery->description); ?></td>
                <td class="major-publishing-actions">
                <form name="delete_gallery_<?php _e($gallery->Id); ?>" method ="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                	<?php wp_nonce_field('FinalTiles_gallery', 'FinalTiles_gallery'); ?>
                	<input type="hidden" name="galleryId" value="<?php _e($gallery->Id); ?>" />
                    <input type="submit" name="Submit" class="button action" value="<?php _e('Delete Gallery', 'FinalTiles-gallery'); ?>" />
                </form>
                </td>
            </tr>
			<?php } ?>
        </tbody>
     </table>
     <br />
     <h3><?php _e('Default Options', 'FinalTiles-gallery'); ?></h3>
     <form name="save_default_settings" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
     <?php wp_nonce_field('FinalTiles_gallery', 'FinalTiles_gallery'); ?>
     
     <div id="settings">
		 <?php include("include/edit-gallery.php") ?>
		 
		 <div class="form-buttons"> 
		 	<input type="hidden" name="defaultSettings" value="true" />
	        <input type="submit" name="Submit" class="button action" value="<?php _e('Update settings', 'FinalTiles-gallery'); ?>" />                
		 </div>
     </div>
     </form>   
     <script>
     	(function ($) {              
     		window.onload = function () {  
	            $("tr:even").addClass("alternate");
	            $(".sections a:first").addClass("selected");
	            $(".sections a").click(function(e) {
	                e.preventDefault();
	                
	                var idx = $(".sections a").index(this);
	                
	                $(".sections a").removeClass("selected");
	                $(this).addClass("selected");
	                
	                $(".ftg-section").hide().eq(idx).show();
	            });
	            $(".ftg-section").hide().eq(0).show();
	        }
        })(jQuery);
     </script>  
</div>