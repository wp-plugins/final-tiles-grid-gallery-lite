<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die(_e('You are not allowed to call this page directly.','final-tiles-gallery')); } ?>
    
<?php $ftg_subtitle = _e("New gallery",'final-tiles-gallery'); ?>    
<?php include "header.php" ?>


<div class="bd">
	
	<div id="ftg-wizard">
	    <h2><?= _e('Add new gallery wizard','final-tiles-gallery') ?></h2>
	
	    <form action="#" method="post">
	        <?php wp_nonce_field( 'add_new_gallery','ftg' ); ?>
	        <input type="hidden" name="action" value="add_new_gallery" />
	        <input type="hidden" name="enc_images" value="" />
	        <input type="hidden" name="post_categories" value="" />
	        <fieldset data-step="1">
	            <div class="row">
	                <div class="input-field">
	                    <input name="ftg_name" id="name" type="text" class="validate" required="required">
	                    <label for="name"><?= _e('Name of the gallery','final-tiles-gallery')?></label>
	                </div>
	            </div>
	            <div class="input-field">
	                <textarea name="ftg_description" class="materialize-textarea" id="description"></textarea>
	                <label for="description"><?= _e('Description of the gallery','final-tiles-gallery')?></label>
	            </div>
	        </fieldset>
	        <fieldset data-step="2">
	            <h5> <?= _e('Choose the source of the images','final-tiles-gallery') ?></h5>
	            <p>
	                <input class="with-gap" type="radio" checked="checked" name="ftg_source" id="source1" value="images" />
	                <label for="source1"><?= _e('Media library','final-tiles-gallery')?></label>
	            </p>
	            <p>
	                <input class="with-gap" disabled type="radio" name="ftg_source" value="posts" id="source2" />
	                <label for="source2"><?= _e('Recent posts with featured image','final-tiles-gallery')?> <?php _e(PRO_CALL) ?></label>
	            </p>
	            <p>
	                <input class="with-gap" disabled type="radio" name="ftg_source" value="woocommerce" id="source3" />
	                <label for="source3"><?= _e('WooCommerce products','final-tiles-gallery')?> <?php _e(PRO_CALL) ?></label>
	            </p>
	        </fieldset>
	        <fieldset data-step="3" data-branch="images">
	            <div class="field">
	                <h5> <?= _e('WordPress field for captions:','final-tiles-gallery')?></h5>
	                <p>
	                    <input class="with-gap" type="radio" name="ftg_wp_field_caption" value="none" id="caption1" />
	                    <label for="caption1"><?= _e("Don't use captions",'final-tiles-gallery')?></label>
	                </p>
	                <p>
	                    <input class="with-gap" type="radio" name="ftg_wp_field_caption" value="title" checked="checked" id="caption2" />
	                    <label for="caption2"><?= _e('Title','final-tiles-gallery') ?></label>
	                </p>
	                <p>
	                    <input class="with-gap" type="radio" name="ftg_wp_field_caption" value="caption" id="caption3" />
	                    <label for="caption3"><?= _e('Caption','final-tiles-gallery')?></label>
	                </p>
	                <p>
	                    <input class="with-gap" type="radio" name="ftg_wp_field_caption" value="description" id="caption4" />
	                    <label for="caption4"><?= _e('Description','final-tiles-gallery')?></label>
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
	                <h5><?= _e('Caption effect:','final-tiles-gallery')?></h5>
	                <select name="ftg_captionEffect">
	                    <option value="fade"><?= _e('Fade','final-tiles-gallery')?></option>
	                    <option value="slide-top"><?= _e('Slide from top','final-tiles-gallery')?></option>
	                    <option value="slide-bottom"><?= _e('Slide from bottom','final-tiles-gallery')?></option>
	                    <option value="slide-left"><?= _e('Slide from left','final-tiles-gallery')?></option>
	                    <option value="slide-right"><?= _e('Slide from right','final-tiles-gallery')?></option>
	                    <option value="rotate-left"><?= _e('Rotate from left','final-tiles-gallery')?></option>
	                    <option value="rotate-right"><?= _e('Rotate from right','final-tiles-gallery')?></option>
	                </select>
	            </div>
	        </fieldset>	        
	        <fieldset data-step="4" data-save="true">
	            <div class="field">
	                <h5><?= _e('Choose a default image size','final-tiles-gallery')?></h5>
	                <select name="def_imgsize">
	                <?php
	                    foreach ($this->list_thumbnail_sizes() as $size => $atts)
	                    {
	                    	print '<option value="'. $size .'">' . $size . " (" . implode( 'x', $atts ) . ")</option>";
	                    }
	                    ?>
	                </select>
	                <label><?= _e('You can customize each image later','final-tiles-gallery')?></label>
	            </div>
	            <div class="field select-images">
	                <a class="waves-effect waves-light btn add-images">
	                    <i class="mdi-content-add-circle-outline left"></i> <?= _e('Add max 20 images','final-tiles-gallery')?></a>
	                <br>
	                <label><?= _e('You can add images now or later.','final-tiles-gallery')?></label>
	                <label><?php _e(PRO_UNLOCK) ?></label>
	                <div class="images list-group"></div>
	            </div>
	        </fieldset>
	        <footer class="page-footer">
	            <div class="progress loading">
	                <div class="indeterminate"></div>
	            </div>
	            <a class="waves-effect waves-yellow btn-flat prev"> <?= _e('Previous','final-tiles-gallery')?></a>
	            <a class="waves-effect waves-green btn-flat next"><?= _e('Next','final-tiles-gallery')?></a>
	        </footer>
	    </form>
	    <div id="success" class="modal">
		    <div class="modal-content">
		      <h4><?= _e('Success!','final-tiles-gallery')?></h4>
		      <p><?= _e('Your gallery')?> "<span class="gallery-name"></span> <?= _e('has been created. Copy the following shortcode:','final-tiles-gallery')?><br>
			      <code></code><br>
			     <?= _e('and paste it inside a post or a page. Otherwise click','final-tiles-gallery')?> <a class='customize'><?= _e('here') ?></a> <?= _e('to customize
			      the gallery.','final-tiles-gallery')?>
		      </p>
		    </div>
		    <div class="modal-footer">
		      <a href="?page=ftg-gallery-admin" class="waves-effect waves-green btn-flat modal-action"><?= _e('Close','final-tiles-gallery')?></a>
		    </div>
		  </div>
		<div id="error" class="modal">
		    <div class="modal-content">
		      <h4><?= -e('Error!','final-tiles-gallery')?></h4>
		      <p><?= _e('For some reason it was not possible to save your gallery, please contact','final-tiles-gallery')?><a href="?page=ftg-support"><?= _e('support','final-tiles-gallery')?></a>.</p>
		    </div>
		    <div class="modal-footer">
		      <a href="?page=ftg-gallery-admin" class="waves-effect waves-green btn-flat modal-action"><?= _e('Close','final-tiles-gallery')?></a>
		    </div>
		  </div>
	</div>
</div>