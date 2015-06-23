<?php
	


	
function ftg_p($gallery, $field, $default = NULL)
{
	global $ftg_options;

	if($ftg_options) {
		if(array_key_exists($field, $ftg_options))
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
function ftg_sel($gallery, $field, $value, $type="selected")
{
	global $ftg_options;

	if($ftg_options && $ftg_options[$field] == $value) {
		print $type;
		return;
	}

	if($gallery == NULL)
	{
		print "";
	}
	else
	{
		if($gallery->$field == $value)
			print $type;
	}
}


global $ftg_parent_page;
global $ftg_fields;

//print_r($gallery);

$idx = 0;
$colors = array('indigo', 'blue', 'cyan', 'teal', 'green', 'lime', 'deep-orange');
?>

<?php 
	
	/*foreach($ftg_fields as $section => $s) 
	{
		foreach($s["fields"] as $f => $data)
		{
			_e("<strong>" . $data["name"] . "</strong><br>");
			_e("<p>".$data["description"]."</p>");
		}
	}*/
	
	function ftgSortByName($a, $b)
	{
		return $a["name"] > $b["name"];
	}	
	
?>

<ul class="collapsible" data-collapsible="accordion">
	<?php foreach($ftg_fields as $section => $s) : ?>
		<li id="<?php _e(FinalTiles_GalleryLite::slugify($section)) ?>">
			<div class="collapsible-header white-text <?php print $colors[$idx] ?> darken-2">
				<i class="<?php _e($s["icon"]) ?>"></i> <?php _e($section) ?>
			</div>
			<div class="collapsible-body <?php print $colors[$idx] ?> lighten-5 tab form-fields">
				<div class="jump-head">
					<?php
						$jumpFields = array();
						foreach($s["fields"] as $f => $data)
						{
							$jumpFields[$f] = $data;
							$jumpFields[$f]['_code'] = $f;
						}
						unset($f);
						unset($data);

						usort($jumpFields, "ftgSortByName");
					
					?>
					<select class="browser-default jump">
						<option>Jump to setting</option>
					<?php foreach($jumpFields as $f => $data) : ?>					
						<?php if(is_array($data["excludeFrom"]) && ! in_array($ftg_parent_page, $data["excludeFrom"])) : ?>
						<option value="<?php _e($data['_code']) ?>">
							<?php _e($data["name"]); ?>
						</option>
						<?php endif ?>
					<?php endforeach ?>
					</select>
				</div>
				<table>
					<tbody>
				<?php foreach($s["fields"] as $f => $data) : ?>
					<?php if(is_array($data["excludeFrom"]) && ! in_array($ftg_parent_page, $data["excludeFrom"])) : ?>
					
					<tr class="row-<?php print $f ?> <?php print $data["type"] ?>">						
						<th scope="row">
							<label><?php _e($data["name"]); ?>
								<?php if($data["mu"]) : ?>
								(<?php _e($data["mu"]) ?>)
								<?php endif ?>
								</label>
						</th>
						<td>
						<div class="field">
						<?php if($data["type"] == "text") : ?>
							<div class="text">
								<input type="text" size="30" name="ftg_<?php print $f ?>" value="<?php ftg_p($gallery, $f, $data["default"])  ?>" /> 
							</div>
						<?php elseif($data["type"] == "select") : ?>
							<div class="text">
								<select class="browser-default" name="ftg_<?php print $f ?>">
									<?php foreach(array_keys($data["values"]) as $optgroup) : ?>
										<optgroup label="<?php print $optgroup  ?>">
											<?php foreach($data["values"][$optgroup] as $option) : ?>
	
												<?php $v = explode("|", $option); ?>
	
												<option <?php ftg_sel($gallery, $f, $v[0])  ?> value="<?php print $v[0] ?>"><?php print $v[1] ?></option>
											<?php endforeach ?>
										</optgroup>
									<?php endforeach ?>
								</select>
							</div>
						<?php elseif($data["type"] == "toggle") : ?>
							<div class="text">
								<input type="checkbox" id="ftg_<?php print $f ?>" name="ftg_<?php print $f ?>" value="<?php ftg_p($gallery, $f, $data["default"]) ?>" <?php ftg_sel($gallery, $f, "T", "checked") ?> />
								<label for="ftg_<?php print $f ?>"><?php _e($data["description"]); ?></label>
							</div>

						<?php elseif($data["type"] == "slider") : ?>
							
							<div class="text">
								<p class="range-field">
							      <input name="ftg_<?php print $f ?>" value="<?php ftg_p($gallery, $f, $data["default"]) ?>" type="range" min="<?php print $data["min"] ?>" max="<?php print $data["max"] ?>" />
							    </p>
							</div>
							

						<?php elseif($data["type"] == "color") : ?>
							<div class="text">
							<input type="text" size="6" data-default-color="<?php print $data["default"] ?>" name="ftg_<?php print $f ?>" value="<?php ftg_p($gallery, $f, $data["default"])  ?>" class='pickColor' />							</div>

						<?php elseif($data["type"] == "PRO_FEATURE") : ?>

							<div class="pro-cell">
								<a href="http://www.final-tiles-gallery.com/wordpress/pro.html" target="_blank">Unlock this feature with a PRO license <i class="mdi-content-send
"></i></a>
                    		</div>

						<?php elseif($data["type"] == "textarea") : ?>
						<div class="text">
							<textarea name="ftg_<?php print $f ?>"><?php ftg_p($gallery, $f) ?></textarea>
						</div>
						<?php elseif($data["type"] == "custom_isf") : ?>
							<div class="pro-cell">
								<a href="http://www.final-tiles-gallery.com/wordpress/pro.html" target="_blank"><i class="fa fa-graduation-cap"></i> Unlock this feature with a PRO license</a>
                    		</div>
						<?php endif ?>
						<div class="help">
							<?php _e($data["description"]); ?>
						</div>

						</div>
						</td>						
						</tr>						
					<?php endif ?>					
				<?php endforeach ?>
				</tbody>
				</table>
			</div>
		</li>
		<?php $idx++; ?>
	<?php endforeach ?>
	<li id="images">
		<div class="collapsible-header white-text <?php print $colors[$idx] ?> darken-2">
			<i class="mdi-image-collections"></i> Images
		</div>
		<div class="collapsible-body <?php print $colors[$idx] ?> lighten-5">
			<div id="images" class="ftg-section form-fields">
				<div class="actions">
					<label>Source:</label>
					<input class="with-gap" checked type="radio" name="ftg_source" value="images" id="source1" />
	                <label for="source1">Images</label>
					<input class="with-gap" disabled type="radio" name="ftg_source" value="posts" id="source2" />
	                <label for="source2">Recent posts with featured image <?php _e(PRO_CALL) ?></label>
	                <input class="with-gap" disabled type="radio" name="ftg_source" value="woocommerce" id="source3" />
	                <label for="source3">WooCommerce products <?php _e(PRO_CALL) ?></label>					
				</div>
				<div class="actions source-images source-panel">
					<div class="row">
						<label>Image size</label>
					
						<select class="current-image-size browser-default">
							<?php
							foreach ($this->list_thumbnail_sizes() as $size => $atts)
							{
								print '<option value="'. $size .'">' . $size . " (" . implode( 'x', $atts ) . ")</option>";
							}
							?>
						</select>
						 <p class="tips">Want to add more images sizes? <a href="http://www.wpbeginner.com/wp-tutorials/how-to-create-additional-image-sizes-in-wordpress/" target="_blank">Read a simple tutorial.</a></p>
						 <div class="tips">
						<strong>About choosing a proper image size:</strong> Final Tiles Gallery doesn't scale down the images when there's enough space, it gives you the freedom to choose your favourite size for each image. So you should use images that are smaller than the container, choose the <strong>thumbnail</strong> or <strong>medium</strong> size, for example.<br>
						<br>
						How to get a better grid? Watch the <a href="https://www.youtube.com/watch?v=RNT4JGjtyrs" target="_blank">video tutorial</a>.
					</div>
					</div>
					<div class="row">
						<a href="#" class="open-media-panel waves-effect waves-light btn action"><i class="mdi-image-photo"></i> Add images</a>
						<a onclick="alert('Video are available with PRO version')" class="waves-effect waves-light btn action grey lighten-1"><i class="mdi-av-videocam"></i> Add video</a>
					</div>
					<div class="row">
						<p class="tips">For multiple selections: Click+CTRL.
						Drag images to change order.</p>
					</div>
				</div>											
			</div>
			<div class="actions">
					<div class="bulk row">
						<label>Bulk Actions</label>
						<div class="options">
							<a class="btn blue darken-4 waves-effect waves-light" href="#" data-action="select">Select all</a>
							<a class="btn indigo darken-4 waves-effect waves-light" href="#" data-action="deselect">Deselect all</a>
							<a class="btn lime darken-2 waves-effect waves-light" href="#" data-action="toggle">Toggle selection</a>							
							<a class="btn grey lighten-1 waves-effect waves-light" onclick="alert('Filters are available with PRO version')" data-action="filter">Assign filters</a>
							<a class="btn deep-orange darken-1 waves-effect waves-light" href="#" data-action="remove">Remove</a>
						</div>

						<div>
							<ul>
								<b style="float:left; font-size:16px;"> List View: </b>
								<li id="ListView_big" style="cursor:pointer; font-size:16px; display:inline; float:left; margin-left:7px;"> Big </li>
								<li id="ListView_medium" style="cursor:pointer; font-size:16px; display:inline; float:left; margin-left:7px;"> Medium </li>
								<li id="ListView_small" style="cursor:pointer; font-size:16px; display:inline; float:left; margin-left:7px; "> Small </li>
							</ul>
						</div>

						<div class="panel">
							<strong></strong>
							<p class="text"></p>
							<p class="buttons">
								<a class="btn orange cancel" href="#">Cancel</a>
								<a class="btn green proceed" href="#">Proceed</a>
							</p>
						</div>
					</div>
				</div>
			<div id="image-list" class="row"></div>		
		</div>
	</li>
</ul>

<a data-tooltip="Update gallery" data-position="top" data-delay="10" class="tooltipped btn-floating btn-large waves-effect waves-light green update-gallery"><i class="fa fa-save"></i></a>

<div class="fixed-action-btn bullet-menu">
    <a class="btn-floating btn-large blue darken-1 right back-to-top">
      <i class="large mdi-hardware-keyboard-arrow-up"></i>
    </a>
    <ul>
	    <?php $idx = 0; ?>
	    <?php foreach($ftg_fields as $section => $s) : ?>
	    <li><a class="btn-floating <?php _e($colors[$idx++]) ?>" rel="<?php _e(FinalTiles_GalleryLite::slugify($section)) ?>"><i class="large <?php _e($s["icon"]) ?>"></i></a></li>
	    <?php endforeach ?>
	    <li><a class="btn-floating <?php _e($colors[$idx++]) ?>" rel="images"><i class="large mdi-image-collections"></i></a></li>
	</ul>
</div>
  

<!-- image panel -->
<div id="image-panel-model"	 class="modal">
	<div class="modal-content cf">
		<h4>Edit image</h4>
		<div class="left">
			<div class="figure"></div>
			<div class="field sizes"></div>
		</div>
		<div class="right-side">
			<div class="field">
				<label>Caption</label>
				<div class="text">
					<textarea name="description"></textarea>
				</div>
			</div>
			<div class="field">
				<label>Link</label>
				<div class="text dark">
					<input type="text" size="20" value="" name="link" />					
				</div>
				<label>Link target</label>
				<div class="text">
					<select name="target" class="browser-default">
						<option value="default">Default target</option>
						<option value="_self">Open in same page</option>
						<option value="_blank">Open in _blank</option>
					</select>
				</div>			
			</div>
			<div class="field filters clearfix"></div>
		</div>
	</div>	
	<div class="field buttons modal-footer">
		<a href="#" data-action="save" class="action modal-action modal-close waves-effect waves-green btn-flat"><i class="fa fa-save"></i> Save</a>
		<a href="#" data-action="cancel" class="action modal-action modal-close waves-effect waves-yellow btn-flat"><i class="mdi-content-reply"></i> Cancel</a>
	</div>
</div>

<div class="preloader-wrapper big active" id="spinner">
    <div class="spinner-layer spinner-blue-only">
      <div class="circle-clipper left">
        <div class="circle"></div>
      </div><div class="gap-patch">
        <div class="circle"></div>
      </div><div class="circle-clipper right">
        <div class="circle"></div>
      </div>
    </div>
  </div>
<!-- images section -->

<div class="overlay" style="display:none"></div>

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
