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

    return $result;
}

?>                
			<?php foreach($imageResults as $image) { 
                $sizes = get_image_size_links($image->imageId);
                $thumb = array_key_exists("150x150", $sizes) ? $sizes["150x150"] : $image->imagePath;
            ?>

            <div class='item' data-image-id="<?php _e($image->imageId) ?>" data-id="<?php _e($image->Id) ?>">
                <div class="icons">
                    <div class="checkbox selection"></div>
                    <a href="#" class="edit" title="Edit"><i class="fa fa-edit"></i></a>
                    <a href="#" class="remove" title="Remove"><i class="fa fa-times"></i></a>                    
                </div>
                <div class="figure">
                    <img class="thumb" src="<?php _e($thumb) ?>" />
                    <?php if(in_array($image->imagePath, $sizes)) : ?>
                    <span class='size'><?php print array_search($image->imagePath, $sizes) ?></span>
                    <?php endif ?>
                    <?php 
                    if(! empty($image->filters))
                    {
	                	print "<ul class='filters'>";
	                	
	                	foreach(explode('|', $image->filters) as $f)
	                	{
		                	print "<li>$f</li>";
	                	}
	                		
	                	print "<ul>";
                    }
                    
                    ?>
                </div>
                <div class="data">
                    <input class="copy" type="hidden" name="id" value="<?php _e($image->Id); ?>" />
                    <input class="copy" type="hidden" name="img_id" value="<?php _e($image->imageId); ?>" />
                    <input class="copy" type="hidden" name="sortOrder" value="<?php _e($image->sortOrder); ?>" />
                    <select name="img_url" class="select">
                    <?php foreach($sizes as $k => $v) : ?>
                        <option <?php print $v == $image->imagePath ? "selected" : "" ?> value="<?php print $v ?>"><?php print $k ?></option>
                    <?php endforeach ?>
                    </select>
                    <input type="hidden" name="zoom" value="<?php _e($image->zoom) ?>" />
                    <input type="hidden" name="link" value="<?php _e($image->link) ?>" />
                    <input type="hidden" name="blank" value="<?php _e($image->blank) ?>" />
                    <input type="hidden" name="sortOrder" value="<?php _e($image->sortOrder) ?>" />
                    <pre><?php _e($image->description) ?></pre>
                </div>
            </div>            
		  <?php } ?>