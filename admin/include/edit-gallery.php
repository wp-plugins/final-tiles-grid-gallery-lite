<?php
    function ftg_p($gallery, $field, $default = NULL)
    {    
    	global $ftg_options;
    	
    	if($ftg_options) {
    		print stripslashes($ftg_options[$field]);
    		return;
    	}
    	
        if($gallery == NULL || $gallery->$field === NULL) 
        {
            if($default === NULL)
            {
                print "";
            }
            else
            {
                print stripslashes($default);
            }
        } 
        else 
        {
            print stripslashes($gallery->$field);
        }
    }
    function ftg_sel($gallery, $field, $value)
    {
    	global $ftg_options;
    	
    	if($ftg_options && $ftg_options[$field] == $value) {
    		print "selected";
    		return;
    	}
    	
        if($gallery == NULL)
        {
            print "";
        }
         else
         {
            if($gallery->$field == $value)
                print "selected";
         }
    }
    function list_thumbnail_sizes()
    {
	    global $_wp_additional_image_sizes;
        $sizes = array();
 	    foreach( get_intermediate_image_sizes() as $s )
 	    {
 		    $sizes[ $s ] = array( 0, 0 );
 		    if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) )
 		    {
 			    $sizes[ $s ][0] = get_option( $s . '_size_w' );
 			    $sizes[ $s ][1] = get_option( $s . '_size_h' );
 		    }
 		    else
 		    {
 			    if( isset( $_wp_additional_image_sizes ) &&  
 			    	isset( $_wp_additional_image_sizes[ $s ] ))
 				    $sizes[ $s ] = array( $_wp_additional_image_sizes[ $s ]['width'], 	$_wp_additional_image_sizes[ $s ]['height'], );
 			    }
 		    }
 		
 		    return $sizes; 		
     }

    global $ftg_parent_page;
    global $ftg_fields;
    
?>
    <div class="sections">
    
    <?php foreach($ftg_fields as $section => $s) : ?>
    <a href="#"><i class="fa fa-<?php _e($s["icon"]) ?>"></i> <?php print $section ?></a>
    <?php endforeach ?>
    <?php if($ftg_parent_page == "edit-gallery") : ?>
    <a href="#"><i class="fa fa-picture-o"></i> Images</a>
    <?php endif ?>
    </div>

    <?php foreach($ftg_fields as $section => $s) : ?>
    	<div class="ftg-section">
    	<h3><?php print $section ?></h3>
        <table class="widefat post fixed form-fields" cellspacing="0">
        <?php foreach($s["fields"] as $f => $data) : ?>
        <?php if(is_array($data["excludeFrom"]) && ! in_array($ftg_parent_page, $data["excludeFrom"])) : ?>        
        <tr>
            <td><strong><?php _e($data["name"], 'Mikado'); ?>:</strong></td>
            <td>
                <?php if($data["type"] == "text") : ?>
                <input type="text" size="30" name="ftg_<?php print $f ?>" value="<?php ftg_p($gallery, $f, $data["default"])  ?>" /> <?php _e($data["mu"]) ?>
                <?php elseif($data["type"] == "select") : ?>
                
                    <select name="ftg_<?php print $f ?>" multiple class="multiple">
                        <?php foreach(array_keys($data["values"]) as $optgroup) : ?>
                        <optgroup label="<?php print $optgroup  ?>">
                            <?php foreach($data["values"][$optgroup] as $option) : ?>
                        
                            <?php $v = explode("|", $option); ?>
                        
	                        <option <?php ftg_sel($gallery, $f, $v[0])  ?> value="<?php print $v[0] ?>"><?php print $v[1] ?></option>
                            <?php endforeach ?>
                        </optgroup>
                        <?php endforeach ?>
                    </select>
                
                <?php elseif($data["type"] == "toggle") : ?>
            
                    <div class="commutator off">
                          <div class="is on">On<div class="is off">Off</div></div>
                    </div>
                    <input type="hidden" name="ftg_<?php print $f ?>" value="<?php ftg_p($gallery, $f, $data["default"]) ?>" />
            
                <?php elseif($data["type"] == "slider") : ?>
                
                    <div class="scrollbox js-scrollbox disk" data-step="1" data-max="<?php print $data["max"] ?>" data-min="<?php print $data["min"] ?>">
                        <div class="hitbox"></div>
                        <div class="scale" style="width: 50%"></div>
                    </div> 
                    <span><?php ftg_p($gallery, $f, $data["default"]) ?></span><?php print $data["mu"] ?>
                    <input type="hidden" value="<?php ftg_p($gallery, $f, $data["default"]) ?>" name="ftg_<?php print $f ?>" />
            
                <?php elseif($data["type"] == "color") : ?>
                
                    <input type="text" size="6" data-default-color="<?php print $data["default"] ?>" name="ftg_<?php print $f ?>" value="<?php ftg_p($gallery, $f, $data["default"])  ?>" class='pickColor' />
                
                <?php elseif($data["type"] == "pro") : ?>
                
                    <div class="pro-cell">
                        <?php if(array_key_exists("value", $data)) : ?>
                        <input type="hidden" name="ftg_<?php print $f ?>" value="<?php $data["value"]  ?>" /> <?php _e($data["mu"]) ?>
                        <?php endif ?>
                        <a href="http://www.final-tiles-gallery.com/wordpress/pro.html" target="_blank"><i class="fa fa-graduation-cap"></i> Unlock this feature with a PRO license</a>
                    </div>
           
               <?php elseif($data["type"] == "textarea") : ?>
                    <textarea name="ftg_<?php print $f ?>"><?php ftg_p($gallery, $f) ?></textarea>
                <?php endif ?>
            </td>
            <td><?php _e($data["description"], 'Mikado'); ?></td>
        </tr>        
        <?php endif ?>
        <?php endforeach ?>
        </table>
    	</div>
    <?php endforeach ?>
    
    
    <!-- images section -->
    <div id="images" class="ftg-section">
        
        <div class="actions">
        	<div>
        	<select class="current-image-size">
            <?php
            foreach (list_thumbnail_sizes() as $size => $atts) 
			{ 
	 			print '<option value="'. $size .'">' . $size . " (" . implode( 'x', $atts ) . ")</option>";
			}
            ?>
            </select>
            <a href="#" class="open-media-panel button action">Add up to 20 images</a> or
            <a href="http://www.final-tiles-gallery.com/wordpress/pro.html" target="_blank" class="button">Unlock unlimited images</a>            
            <span class="tip">For multiple selections: Click+CTRL.</span>
            <span class="tip">Drag images to change order.</span>
        	</div>
        	<div>
        		<span style="padding:6px;"><a href="http://www.wpbeginner.com/wp-tutorials/how-to-create-additional-image-sizes-in-wordpress/" target="_blank">Want to add more images sizes?</a></span>
        	</div>
        </div>
        <div class="tips">
            <strong>About choosing a proper image size:</strong> Final Tiles Gallery doesn't scale down the images
            when there's enough space, it gives you the freedom to choose your favourite size for each image.
            So you should use images that are smaller than the container, choose the <strong>thumbnail</strong> or 
            <strong>medium</strong> size, for example.
        </div>
        <div class="bulk">
            <h4>Bulk Actions</h4>
            <div class="options">
                <a href="#" data-action="select">Select all</a>
                <a href="#" data-action="deselect">Deselect all</a>
                <a href="#" data-action="toggle">Toggle selection</a>
                <a href="#" data-action="remove">Remove</a>
            </div>
            <div class="panel">
                <strong></strong>
                <p class="text"></p>
                <p class="buttons">
                    <a class="button mrm cancel" href="#">Cancel</a>
                    <a class="button mrm proceed firm" href="#">Proceed</a>
                </p>
            </div>
        </div>
        <div id="image-list"></div>

        <!-- image panel -->
        <div id="image-panel-model" style="display:none">
            <a href="#" class="close" title="Close">X</a>
            <div class="clearfix">
                <div class="left">
                    <div class="figure"></div>
                    <div class="field sizes"></div>
                </div>
                <div class="right">
                    <div class="field">
                        <label>Caption</label>
                        <div class="text dark">
                            <textarea name="description"></textarea>
                        </div>
                    </div>
                    <div class="field">
                        <label>Link</label>
						<div class="text dark">
                            <input type="text" size="20" value="" name="link" />
                            <select name="target">
                            	<option value="default">Default target</option>
                            	<option value="_self">Open in same page</option>
                            	<option value="_blank">Open in _blank</option>                                      
                            </select>
                        </div>
                    </div>                   
                </div>
            </div>
            <div class="field filters clearfix"></div>
            <div class="field buttons">
                <a href="#" data-action="cancel" class="button action neutral">Cancel</a>
                <a href="#" data-action="save" class="button action positive">Save</a>
            </div>
        </div>
    </div>
    
    <script>
        var ftg_wp_caption_field = '<?php ftg_p($gallery, "wp_field_caption")  ?>';
        (function ($) {
	        $("[name=captionFullHeight]").change(function () {
		        if($(this).val() == "F")
		        	$("[name=captionEffect]").val("fade");
	        });
	        $("[name=captionEffect]").change(function () {
		    	if($(this).val() != "fade" && $("[name=captionFullHeight]").val() == "F") {
		    		$(this).val("fade");
		    		alert("Cannot set this effect if 'Caption full height' is switched off.");
		    	}
	        });
        })(jQuery);
    </script>
    