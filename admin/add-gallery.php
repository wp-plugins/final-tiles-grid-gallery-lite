<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die(_e('You are not allowed to call this page directly.','final-tiles-gallery')); } ?>
    
<?php $ftg_subtitle = _e("New gallery",'final-tiles-gallery'); ?>    
<?php include "header.php" ?>


<div class="bd">
	
	<div id="ftg-wizard">
	    <h2><?php _e('Add new gallery wizard','final-tiles-gallery') ?></h2>
	
	    <form action="#" method="post">
	        <?php wp_nonce_field( 'add_new_gallery','ftg' ); ?>
	        <input type="hidden" name="action" value="add_new_gallery" />
	        <input type="hidden" name="enc_images" value="" />
	        <input type="hidden" name="post_categories" value="" />
	        <fieldset data-step="1">
	            <div class="row">
	                <div class="input-field">
	                    <input name="ftg_name" id="name" type="text" class="validate" required="required">
	                    <label for="name"><?php _e('Name of the gallery','final-tiles-gallery')?></label>
	                </div>
	            </div>
	            <div class="input-field">
	                <textarea name="ftg_description" class="materialize-textarea" id="description"></textarea>
	                <label for="description"><?php _e('Description of the gallery','final-tiles-gallery')?></label>
	            </div>
	        </fieldset>
	        <fieldset data-step="2">
	            <h5> <?php _e('Choose the source of the images','final-tiles-gallery') ?></h5>
	            <p>
	                <input class="with-gap" type="radio" checked="checked" name="ftg_source" id="source1" value="images" />
	                <label for="source1"><?php _e('Media library','final-tiles-gallery')?></label>
	            </p>
	            <p>
	                <input class="with-gap" disabled type="radio" name="ftg_source" value="posts" id="source2" />
	                <label for="source2"><?php _e('Recent posts with featured image','final-tiles-gallery')?> <?php _e(PRO_CALL) ?></label>
	            </p>
	            <p>
	                <input class="with-gap" disabled type="radio" name="ftg_source" value="woocommerce" id="source3" />
	                <label for="source3"><?php _e('WooCommerce products','final-tiles-gallery')?> <?php _e(PRO_CALL) ?></label>
	            </p>
	        </fieldset>
	        <fieldset data-step="3" data-branch="images">
	            <div class="field">
	                <h5> <?php _e('WordPress field for captions:','final-tiles-gallery')?></h5>
	                <p>
	                    <input class="with-gap" type="radio" name="ftg_wp_field_caption" value="none" id="caption1" />
	                    <label for="caption1"><?php _e("Don't use captions",'final-tiles-gallery')?></label>
	                </p>
	                <p>
	                    <input class="with-gap" type="radio" name="ftg_wp_field_caption" value="title" checked="checked" id="caption2" />
	                    <label for="caption2"><?php _e('Title','final-tiles-gallery') ?></label>
	                </p>
	                <p>
	                    <input class="with-gap" type="radio" name="ftg_wp_field_caption" value="caption" id="caption3" />
	                    <label for="caption3"><?php _e('Caption','final-tiles-gallery')?></label>
	                </p>
	                <p>
	                    <input class="with-gap" type="radio" name="ftg_wp_field_caption" value="description" id="caption4" />
	                    <label for="caption4"><?php _e('Description','final-tiles-gallery')?></label>
	                </p>
	            </div>
	            <!--
	                <div class="field">
	                	<h5>Caption behavior:</h5>
	                	<p>
	                		<input class="with-gap" type="radio" name="ftg_captionBehavior" value="hidden" checked="checked" id="behavior1" />
	                		<label for="behavior1">Hidden, show it on mouse hover</label>
	                	</p>
	                	<p>
	                		<input class="with-gap" type="radio" name="ftg_captionBehavior" value="visible" id="behavior2" />
	                		<label for="behavior2">Visible, hide it on mouse hover</label>
	                	</p>
	                	<p>
	                		<input class="with-gap" type="radio" name="ftg_captionBehavior" value="always-visible" id="behavior3" />
	                		<label for="behavior3" class="line">Always visible</label>
	                	</p>
	                </div>
	                -->
	            <div class="field">
	                <h5><?php _e('Caption effect:','final-tiles-gallery')?></h5>
	                <select name="ftg_captionEffect">
	                    <option value="fade"><?php _e('Fade','final-tiles-gallery')?></option>
	                    <option value="slide-top"><?php _e('Slide from top','final-tiles-gallery')?></option>
	                    <option value="slide-bottom"><?php _e('Slide from bottom','final-tiles-gallery')?></option>
	                    <option value="slide-left"><?php _e('Slide from left','final-tiles-gallery')?></option>
	                    <option value="slide-right"><?php _e('Slide from right','final-tiles-gallery')?></option>
	                    <option value="rotate-left"><?php _e('Rotate from left','final-tiles-gallery')?></option>
	                    <option value="rotate-right"><?php _e('Rotate from right','final-tiles-gallery')?></option>
	                </select>
	            </div>
	        </fieldset>	        
	        <fieldset data-step="4" data-save="true">
	            <div class="field">
	                <h5><?php _e('Choose a default image size','final-tiles-gallery')?></h5>
	                <select name="def_imgsize">
	                <?php
	                    foreach ($this->list_thumbnail_sizes() as $size => $atts)
	                    {
	                    	print '<option value="'. $size .'">' . $size . " (" . implode( 'x', $atts ) . ")</option>";
	                    }
	                    ?>
	                </select>
	                <label><?php _e('You can customize each image later','final-tiles-gallery')?></label>
	            </div>
	            <div class="field select-images">
	                <a class="waves-effect waves-light btn add-images">
	                    <i class="mdi-content-add-circle-outline left"></i> <?php _e('Add max 20 images','final-tiles-gallery')?></a>
	                <br>
	                <label><?php _e('You can add images now or later.','final-tiles-gallery')?></label>
	                <label><?php _e(PRO_UNLOCK) ?></label>
	                <div class="images list-group"></div>
	            </div>
	        </fieldset>
	        <footer class="page-footer">
	            <div class="progress loading">
	                <div class="indeterminate"></div>
	            </div>
	            <a class="waves-effect waves-yellow btn-flat prev"> <?php _e('Previous','final-tiles-gallery')?></a>
	            <a class="waves-effect waves-green btn-flat next"><?php _e('Next','final-tiles-gallery')?></a>
	        </footer>
	    </form>
	    <div id="success" class="modal">
		    <div class="modal-content">
		      <h4><?php _e('Success!','final-tiles-gallery')?></h4>
		      <p><?php _e('Your gallery')?> "<span class="gallery-name"></span> <?php _e('has been created. Copy the following shortcode:','final-tiles-gallery')?><br>
			      <code></code><br>
			     <?php _e('and paste it inside a post or a page. Otherwise click','final-tiles-gallery')?> <a class='customize'><?php _e('here') ?></a> <?php _e('to customize
			      the gallery.','final-tiles-gallery')?>
		      </p>
		    </div>
		    <div class="modal-footer">
		      <a href="?page=ftg-gallery-admin" class="waves-effect waves-green btn-flat modal-action"><?php _e('Close','final-tiles-gallery')?></a>
		    </div>
		  </div>
		<div id="error" class="modal">
		    <div class="modal-content">
		      <h4><?php -e('Error!','final-tiles-gallery')?></h4>
		      <p><?php _e('For some reason it was not possible to save your gallery, please contact','final-tiles-gallery')?><a href="?page=ftg-support"><?php _e('support','final-tiles-gallery')?></a>.</p>
		    </div>
		    <div class="modal-footer">
		      <a href="?page=ftg-gallery-admin" class="waves-effect waves-green btn-flat modal-action"><?php _e('Close','final-tiles-gallery')?></a>
		    </div>
		  </div>
	</div>
</div>