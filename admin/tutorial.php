<div class='wrap'>
    <div class="tutorial text-page">
		<h2>Final Tiles Gallery - <?php _e('Tutorial', 'FinalTiles-gallery'); ?></h2>
		<br>
		<br>
		<h3>Dashboard / Default settings</h3>
		<p>
			The dashboard is the place where you can see all your galleries and where you can set 
			all the default settings. Let's see the dashboard, click on "Final Tiles Gallery" on the 
			WordPress sidebar:<br>
			<br>
			<span class='img'><img src="<?php print plugins_url() ?>/final-tiles-gallery-lite/admin/tutorial/tutorial-dashboard.png" alt="dashboard view" /></span><br>
			<br>
			<span class="tip"><i class="fa fa-lightbulb-o"></i> Before changing the values of the default settings try to build a gallery and look if there's something you want to adjust. In many cases, the default values are just fine.</span><br>			
		</p>
		<h3>Create a gallery</h3>
		<p>
			Click on <strong>"Add Gallery"</strong> of the Final Tiles Gallery menu:<br>
			<br>
			<span class='img'><img src="<?php print plugins_url() ?>/final-tiles-gallery-lite/admin/tutorial/tutorial-add.png" alt="add view" /></span><br>
			<br>
			You'll see the <i>edit panel</i>:<br>
			<br>
			<span class='img'><img src="<?php print plugins_url() ?>/final-tiles-gallery-lite/admin/tutorial/tutorial-add-page.jpg" alt="add view" /></span><br>
			<br>
			As you can see all the fields has the value of the default setting. You can leave all fields untouched, but you must provide a name for the gallery.<br>
			The <i>edit panel</i> contains many settings, so they are grouped in tabs in a way that it will easier to find the setting you want to change.<br>
			<br>
			<span class='img'><img src="<?php print plugins_url() ?>/final-tiles-gallery-lite/admin/tutorial/tutorial-tabs.jpg" alt="add view" /></span><br>
			<br>
			When you think you're ready, just click on <i>ADD GALLERY</i>.
		</p>
		<h3>Adding images</h3>
		<p>
			What's the most important thing in a gallery? Images, of course! Let's add them. After you create a gallery, you're automatically redirect to the <i>Edit Gallery</i> page. Here you can see all your galleries and pick one to edit:<br>
			<br>
			<span class='img'><img src="<?php print plugins_url() ?>/final-tiles-gallery-lite/admin/tutorial/tutorial-edit-list.jpg" alt="add view" /></span><br>
			<br>
			Now you see the <i>edit panel</i> with the fields you previously filled plus a <strong>new tab</strong> called <i>Images</i>:<br>
			<br>
			<span class='img'><img src="<?php print plugins_url() ?>/final-tiles-gallery-lite/admin/tutorial/tutorial-add-image.png" alt="add view" /></span><br>
			<br>
			So let's start to add some image. <strong>The most important thing, here, is the <i>image size dropdown list</i></strong>:<br>
			<br>
			<span class='img'><img src="<?php print plugins_url() ?>/final-tiles-gallery-lite/admin/tutorial/tutorial-add-image-size.png" alt="add view" /></span><br>
			<br>
			this control is used to choose the image size of the images you're going to add. This is the size used to build the gallery on your frontend site.<br>
			<br>
			<span class="tip"><i class="fa fa-lightbulb-o"></i> To get nicer grids try to add images of the same size and then change the size of some of them.
                Try to start with a medium size, after you publish the gallery come back to this panel and try to change some size to get more intriguing grids.</span><br>
			<br>
            So, choose the size and click on <i>Add images</i>. From the WordPress media panel you can browse your image catalogue, just click one or more images.<br/>
            <br/>
            <span class="tip"><i class="fa fa-lightbulb-o"></i> Select more than one image pressing <strong>CTRL</strong> or <strong>SHIFT</strong> key while clicking.</span><br>
			<br>
            <span class='img'><img src="<?php print plugins_url() ?>/final-tiles-gallery-lite/admin/tutorial/tutorial-image-panel.jpg" alt="add view" /></span><br>
			<br>
            You can see all the selected images in the <i>Images</i> tab:<br/>
            <br>
            <span class='img'><img src="<?php print plugins_url() ?>/final-tiles-gallery-lite/admin/tutorial/tutorial-image-added.jpg" alt="add view" /></span><br>
			<br>
            Now that all images have been added you can edit them clicking on <i class="fa fa-edit"></i> icon. If you want to remove some click the <i class="fa fa-times"></i> 
            icon (the image won't be deleted, it will just removed from the gallery).<br/>
            <br>
            <span class='img'><img src="<?php print plugins_url() ?>/final-tiles-gallery-lite/admin/tutorial/tutorial-image-edit.jpg" alt="add view" /></span><br>
            <br/>
            <span class="tip"><i class="fa fa-lightbulb-o"></i> Drag the images to change the order.</span><br>			
		</p>
        <h3>Publish the gallery</h3>
        <p>
            Now that all steps are done we can finally publish our awesome gallery!<br/>
            <br/>
            Go back to the <strong>Dashboard</strong> page, where you can see the list of all your galleries. Select and copy the shortcode. Now edit the post or
            the page where you want to show the gallery and simply paste the shortcode into the text editor. Publish the post or the page and enjoy your gallery on
            the frontend site!
        </p>
        <h3>Tips about getting better grids</h3>
        <p>
            The strength of <strong>Final Tiles Gallery</strong> is its ability to build interesting grids, not the usual multi-column
            layout or multi-row.<br/>
            <br/>
            So the first tip is: <strong>mix the sizes</strong> of the images. So it would be better having 
            many available sizes other than the standard WordPress ones: thumbnail, medium, large. If you don't know how to add
            image sizes you can read this <a href="http://www.wpbeginner.com/wp-tutorials/how-to-create-additional-image-sizes-in-wordpress/" target="_blank">tutorial</a>.<br/>            
            <br/>
            Sometime, even using different image sizes, the grid tends to organize itself into a multi-column layout, that's because
            the heights of the images create an uneven bottom edge. So we need to "break" this edge, we need to increase the chance
            to get even edges so we can <strong>increase the size of the grid</strong> parameter. <br/>
            You should think about this parameter as a "snap grid", the exceeding parts of the images is cut off. If you set,
            for example, a grid size of 25px then the images will have a size that is a multiple of 25. If an image is 302x410 then
            it will displayed as 300x400. You have to sacrifice a small strip of pixels but you'll be surprised seeing the result!            
        </p>
    </div>
</div>
