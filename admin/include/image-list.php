<?php
$default_options = get_option('FinalTiles_gallery_options');
$defSize = isset($default_options[1]['imageSize']) ? $default_options[1]['imageSize'] : "medium";

function get_image_size_links($id) {
    $result = array();
    $sizes = get_intermediate_image_sizes();
    $sizes[] = 'full';

    foreach ( $sizes as $size ) 
    {
        $image = wp_get_attachment_image_src( $id, $size );

        if ( !empty( $image ) && ( true == $image[3] || 'full' == $size ) )
            $result["$image[1]x$image[2]"] = $image[0];
    }
	ksort($result);
    return $result;
}
?>       
		
			<?php foreach($imageResults as $image) { 
                $sizes = get_image_size_links($image->imageId);
                $thumb = "";
                if($image->type == 'image')
                    $thumb = array_key_exists("150x150", $sizes) ? $sizes["150x150"] : $image->imagePath;
                else
                    $thumb = plugins_url('../images/video.jpg', __FILE__);
            ?>
            <div class="col <?php print $list_size ." ". $column_size ?>">
	            <div class='item card' data-type='<?php _e($image->type) ?>' data-image-id="<?php _e($image->imageId) ?>" data-id="<?php _e($image->Id) ?>">	                
	                <div class="figure card-image">	                
		                <?php if($image->type == 'image') : ?>
	                    <img class="thumb" src="<?php _e($thumb) ?>" />
	                    <?php else : ?>
	                    <div class="aspect-ratio">
		                    <?php print $image->imagePath ?>
	                    </div>
	                    <?php endif ?>
	                    
	                    <?php if(in_array($image->imagePath, $sizes)) : ?>

	                    <span class='card-title'><?php print array_search($image->imagePath, $sizes) ?></span>
	                    <?php endif ?>
	                </div>
	                <div class="card-content">
		                <p class="truncate">

			                <?php _e(htmlentities($image->description)) ?>
		                </p>
	                
	                    <input class="copy" type="hidden" name="id" value="<?php _e($image->Id); ?>" />
	                    <input class="copy" type="hidden" name="type" value="<?php _e($image->type); ?>" />
	                    <input class="copy" type="hidden" name="img_id" value="<?php _e($image->imageId); ?>" />
	                    <input class="copy" type="hidden" name="sortOrder" value="<?php _e($image->sortOrder); ?>" />
	                    <input class="copy" type="hidden" name="filters" value="<?php _e($image->filters); ?>" />
	                    <input class="copy" type="hidden" name="post_id" value="<?php _e($image->postId) ?>" />	                    
	                    <select name="img_url" class="select hidden">
	                    <?php foreach($sizes as $k => $v) : ?>
	                        <option <?php print $v == $image->imagePath ? "selected" : "" ?> value="<?php print $v ?>"><?php print $k ?></option>
	                    <?php endforeach ?>
	                    </select>
	                    <input  type="hidden" name="target" value="<?php _e($image->target) ?>" /> 
	                    <input type="hidden" name="zoom" value="<?php _e($image->zoom) ?>" />
	                    <input type="hidden" name="link" value="<?php _e($image->link) ?>" />
	                    <input type="hidden" name="blank" value="<?php _e($image->blank) ?>" />                    
	                    <input type="hidden" name="sortOrder" value="<?php _e($image->sortOrder) ?>" />
	                    <pre class="hidden description"><?php _e($image->description) ?></pre>
	                    <pre class="hidden imagepath"><?php _e(htmlentities($image->imagePath)) ?></pre>
	                </div>

	                <div class="card-action">	                              
					  <a href="#image-panel-model" class="edit modal-trigger">
					  	<i class="mdi mdi-pencil"> </i> 
					 	<span>Edit</span>					  	
					  </a>

					  <?php if($image->source == "gallery") : ?>
		              <a href="#" class="remove"> 
		              	<span> Remove </span>
		              	<i class="mdi mdi-delete"> </i>

		              </a>
		              <?php endif ?>

		            </div>
	            </div>
			</div>
		  <?php } ?>