<?php if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) { die('You are not allowed to call this page directly.'); } ?>
    
<?php $ftg_subtitle = "New gallery" ?>    
<?php include "header.php" ?>


<div class="bd">
	
	<div id="ftg-wizard">
	    <h2>Add new gallery wizard</h2>
	
	    <form action="#" method="post">
	        <?php wp_nonce_field( 'add_new_gallery','ftg' ); ?>
	        <input type="hidden" name="action" value="add_new_gallery" />
	        <input type="hidden" name="enc_images" value="" />
	        <input type="hidden" name="post_categories" value="" />
	        <fieldset data-step="1">
	            <div class="row">
	                <div class="input-field">
	                    <input name="ftg_name" id="name" type="text" class="validate" required="required">
	                    <label for="name">Name of the gallery</label>
	                </div>
	            </div>
	            <div class="input-field">
	                <textarea name="ftg_description" class="materialize-textarea" id="description"></textarea>
	                <label for="description">Description of the gallery</label>
	            </div>
	        </fieldset>
	        <fieldset data-step="2">
	            <h5>Choose the source of the images</h5>
	            <p>
	                <input class="with-gap" type="radio" checked="checked" name="ftg_source" id="source1" value="images" />
	                <label for="source1">Media library</label>
	            </p>
	            <p>
	                <input class="with-gap" disabled type="radio" name="ftg_source" value="posts" id="source2" />
	                <label for="source2">Recent posts with featured image <?php _e(PRO_CALL) ?></label>
	            </p>
	            <p>
	                <input class="with-gap" disabled type="radio" name="ftg_source" value="woocommerce" id="source3" />
	                <label for="source3">WooCommerce products <?php _e(PRO_CALL) ?></label>
	            </p>
	        </fieldset>
	        <fieldset data-step="3" data-branch="images">
	            <div class="field">
	                <h5>WordPress field for captions:</h5>
	                <p>
	                    <input class="with-gap" type="radio" name="ftg_wp_field_caption" value="none" id="caption1" />
	                    <label for="caption1">Don't use captions</label>
	                </p>
	                <p>
	                    <input class="with-gap" type="radio" name="ftg_wp_field_caption" value="title" checked="checked" id="caption2" />
	                    <label for="caption2">Title</label>
	                </p>
	                <p>
	                    <input class="with-gap" type="radio" name="ftg_wp_field_caption" value="caption" id="caption3" />
	                    <label for="caption3">Caption</label>
	                </p>
	                <p>
	                    <input class="with-gap" type="radio" name="ftg_wp_field_caption" value="description" id="caption4" />
	                    <label for="caption4">Description</label>
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
	                <h5>Caption effect:</h5>
	                <select name="ftg_captionEffect">
	                    <option value="fade">Fade</option>
	                    <option value="slide-top">Slide from top</option>
	                    <option value="slide-bottom">Slide from bottom</option>
	                    <option value="slide-left">Slide from left</option>
	                    <option value="slide-right">Slide from right</option>
	                    <option value="rotate-left">Rotate from left</option>
	                    <option value="rotate-right">Rotate from right</option>
	                </select>
	            </div>
	        </fieldset>	        
	        <fieldset data-step="4" data-save="true">
	            <div class="field">
	                <h5>Choose a default image size</h5>
	                <select name="def_imgsize">
	                <?php
	                    foreach ($this->list_thumbnail_sizes() as $size => $atts)
	                    {
	                    	print '<option value="'. $size .'">' . $size . " (" . implode( 'x', $atts ) . ")</option>";
	                    }
	                    ?>
	                </select>
	                <label>You can customize each image later</label>
	            </div>
	            <div class="field select-images">
	                <a class="waves-effect waves-light btn add-images">
	                    <i class="mdi-content-add-circle-outline left"></i> Add max 20 images</a>
	                <br>
	                <label>You can add images now or later.</label>
	                <label><?php _e(PRO_UNLOCK) ?></label>
	                <div class="images list-group"></div>
	            </div>
	        </fieldset>
	        <footer class="page-footer">
	            <div class="progress loading">
	                <div class="indeterminate"></div>
	            </div>
	            <a class="waves-effect waves-yellow btn-flat prev">Previous</a>
	            <a class="waves-effect waves-green btn-flat next">Next</a>
	        </footer>
	    </form>
	    <div id="success" class="modal">
		    <div class="modal-content">
		      <h4>Success!</h4>
		      <p>Your gallery "<span class="gallery-name"></span>" has been created. Copy the following shortcode:<br>
			      <code></code><br>
			      and paste it inside a post or a page. Otherwise click <a class='customize'>here</a> to customize
			      the gallery.
		      </p>
		    </div>
		    <div class="modal-footer">
		      <a href="?page=ftg-lite-gallery-admin" class="waves-effect waves-green btn-flat modal-action">Close</a>
		    </div>
		  </div>
		<div id="error" class="modal">
		    <div class="modal-content">
		      <h4>Error!</h4>
		      <p>For some reason it was not possible to save your gallery, please contact <a href="?page=ftg-lite-support">support</a>.</p>
		    </div>
		    <div class="modal-footer">
		      <a href="?page=ftg-lite-gallery-admin" class="waves-effect waves-green btn-flat modal-action">Close</a>
		    </div>
		  </div>
	</div>
</div>