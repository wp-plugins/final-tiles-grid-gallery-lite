<?php
/**
Plugin Name: Final Tiles Grid Gallery Lite
Description: Wordpress Plugin for creating responsive image galleries. By: Green Tree Labs
Author: Green Tree Labs
Version: 1.1
Author URI: http://greentreelabs.net
easy media gallery
Changelog: 
	
	1.1 Bugfix: the folder name of the plugin was not correct
	1.0 First release
*/



if (!class_exists("FinalTilesGalleryLite")) 
{
	class FinalTilesGalleryLite 
    {
		
		//Constructor
		public function __construct() 
		{
			$this->plugin_name = plugin_basename(__FILE__);		
			$this->define_constants();
			$this->define_db_tables();						
			$this->FinalTilesLiteDB = $this->create_db_conn();
						
			
			register_activation_hook( __FILE__, array($this, 'activation'));
			
			add_filter('widget_text', 'do_shortcode'); 
			
			add_action('init', array($this, 'create_textdomain'));	

			add_action('wp_enqueue_scripts', array($this, 'add_gallery_scripts'));
			
			//add_action( 'admin_init', array($this,'gallery_admin_init') );
			add_action( 'admin_menu', array($this, 'add_gallery_admin_menu') );
			
			add_shortcode( 'FinalTilesGallery', array($this, 'gallery_shortcode_handler') );	

			add_action('wp_ajax_save_gallery', array($this,'save_gallery'));
			add_action('wp_ajax_save_image', array($this,'save_image'));
			add_action('wp_ajax_add_image', array($this,'add_image'));
			add_action('wp_ajax_list_images', array($this,'list_images'));
			add_action('wp_ajax_sort_images', array($this,'sort_images'));
			add_action('wp_ajax_delete_image', array($this,'delete_image'));
			add_action('wp_ajax_assign_filters', array($this,'assign_filters'));					
		}
        
        public function create_db_tables() 
        {
	        include_once (WP_PLUGIN_DIR . '/final-tiles-grid-gallery-lite/lib/install-db.php');	
	        install_db();
        }
        
        public function activation()
        {
            $this->add_gallery_options();
            $this->create_db_tables();
            $this->FinalTilesLiteDB->updateConfiguration();
        }
		
		//Define textdomain
		public function create_textdomain() 
		{
			$plugin_dir = basename(dirname(__FILE__));
			load_plugin_textdomain( 'FinalTiles-gallery', false, $plugin_dir.'/lib/languages' );
		}
		
		//Define constants
		public function define_constants() 
		{
			if ( ! defined( 'FINALTILESGALLERYLITE_PLUGIN_BASENAME' ) )
				define( 'FINALTILESGALLERYLITE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
		
			if ( ! defined( 'FINALTILESGALLERYLITE_PLUGIN_NAME' ) )
				define( 'FINALTILESGALLERYLITE_PLUGIN_NAME', trim( dirname( FINALTILESGALLERYLITE_PLUGIN_BASENAME ), '/' ) );
			
			if ( ! defined( 'FINALTILESGALLERYLITE_PLUGIN_DIR' ) )
				define( 'FINALTILESGALLERYLITE_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . FINALTILESGALLERYLITE_PLUGIN_NAME );
		}
		
		//Define DB tables
		public function define_db_tables() 
		{
			global $wpdb;
			
			$wpdb->FinalTilesGalleries = $wpdb->prefix . 'FinalTiles_gallery';
			$wpdb->FinalTilesImages = $wpdb->prefix . 'FinalTiles_gallery_images';			
		}
				
		
		public function create_db_conn() 
		{
			require('lib/db-class.php');
			$FinalTilesLiteDB = FinalTilesLiteDB::getInstance();
			return $FinalTilesLiteDB;
		}
        
        public function attachment_fields_to_edit($form, $post)
		{
			$form["ftg_link"] = array(
				"label" => "Link <small>FTG</small>",
				"input" => "text",
				"value" => get_post_meta($post->ID, "_ftg_link", true),
				"helps" => ""
			);
			$form["ftg_target"] = array(
				"label" => "_blank <small>FTG</small>",
				"input" => "html",
				"html" =>
					"<input type='checkbox' name='attachments[{$post->ID}][ftg_target]' id='attachments[{$post->ID}][ftg_target]' value='_mblank' ".
					(get_post_meta($post->ID, "_ftg_target", true) == "_mblank" ? "checked" : "")
					." />"
			);
			return $form;
		}
		
		public function attachment_fields_to_save($post, $attachment)
		{
			if(isset($attachment['ftg_link'])){
				update_post_meta($post['ID'], '_ftg_link', $attachment['ftg_link']);
			}
			if(isset($attachment['ftg_target'])){
				update_post_meta($post['ID'], '_ftg_target', $attachment['ftg_target']);
			}
			return $post;		
		}
		
		//Add gallery options
		public function add_gallery_options() 
		{
            $gallery_options = array(
				'margin'  => 10,
				'defaultSize' => 'medium',
				'width' => '100%',
                'minTileWidth' => '100',
				'gridCellSize' => '25',
				'lightbox' => 'lightbox',
				'captionIcon' => 'zoom',
				'captionIconColor' => '#ffffff',
				'captionBackgroundColor' => '#000000',
                'captionColor' => '#ffffff',
				'captionEffectDuration' => 250,
				'captionOpacity' => 80,
				'borderSize' => 0,
				'borderRadius' => 0,
				'shadowSize' => 0,
                'imageSizeFactor' => 90,
                'enlargeImages' => 'T',
				'wp_field_caption' => 'description',
				'captionBehavior' => 'hidden',
				'captionFullHeight' => 'T',
				'captionEmpty' => 'hide',
				'captionEffect' => 'fade',
				'captionEasing' => 'linear',
				'scrollEffect' => 'none',
				'hoverZoom' => 100,
				'hoverRotation' => 0,
				'socialIconColor' => '#ffffff'
			);			

			update_option('FinalTilesGalleryLite_options', $gallery_options);
		}
		
		//Add gallery scripts
		public function add_gallery_scripts() 
		{
			wp_enqueue_script('jquery');
			wp_register_script('jquery-easing', WP_PLUGIN_URL.'/final-tiles-grid-gallery-lite/scripts/jquery.easing.js', array('jquery'));
			wp_enqueue_script('jquery-easing');
			
			wp_register_script('finalTilesGallery', WP_PLUGIN_URL.'/final-tiles-grid-gallery-lite/scripts/jquery.finalTilesGalleryLite.js', array('jquery'));
			wp_enqueue_script('finalTilesGallery');
			
			
			wp_register_style('finalTilesGallery_stylesheet', WP_PLUGIN_URL.'/final-tiles-grid-gallery-lite/scripts/ftg.css');			
			wp_enqueue_style('finalTilesGallery_stylesheet');

			wp_register_script('lightbox2_script', WP_PLUGIN_URL.'/final-tiles-grid-gallery-lite/lightbox/lightbox2/js/script.js', array('jquery'));			
			wp_register_style('lightbox2_stylesheet', WP_PLUGIN_URL.'/final-tiles-grid-gallery-lite/lightbox/lightbox2/css/style.css');
            
            wp_register_style('fontawesome_stylesheet', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css');
            wp_enqueue_style('fontawesome_stylesheet');
		}
				
		//Admin Section - register scripts and styles
		public function gallery_admin_init() 
		{
			if(function_exists( 'wp_enqueue_media' ))
			{
				wp_enqueue_media();
			}
			//wp_enqueue_script( 'custom-header' );

			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-dialog');
			wp_enqueue_script('jquery-ui-sortable');
            
			wp_enqueue_script( 'wp-color-picker' );
			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');

			wp_register_script('chosen', WP_PLUGIN_URL.'/final-tiles-grid-gallery-lite/admin/scripts/vendor/chosen.jquery.js');
			wp_enqueue_script('chosen');

			wp_register_script('futurico', WP_PLUGIN_URL.'/final-tiles-grid-gallery-lite/admin/scripts/SCF.ui.js', array('jquery', 'chosen'));
			wp_enqueue_script('futurico');

			wp_register_style('futurico', WP_PLUGIN_URL.'/final-tiles-grid-gallery-lite/admin/bundle.css?v=2', array('colors'));
			wp_enqueue_style('futurico');

			wp_register_script('final-tiles-gallery-lite', WP_PLUGIN_URL.'/final-tiles-grid-gallery-lite/admin/scripts/final-tiles-gallery-lite-admin.js', array('jquery','media-upload','thickbox'));
			wp_enqueue_script('final-tiles-gallery-lite');
						
			wp_enqueue_style('thickbox');
			
			wp_register_style('fontawesome_stylesheet', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css');
            wp_enqueue_style('fontawesome_stylesheet');
			
			$ftg_db_version = '3.03';
			$installed_ver = get_option( "FinalTilesGalleryLite_db_version" );
			
			
			if( $installed_ver != $ftg_db_version )
			{
				$this->create_db_tables();
				update_option( "FinalTilesGalleryLite_db_version", $ftg_db_version );
			}			
		}
				
		public function FinalTilesGalleryLite_admin_style_load() 
		{
			wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-darkness/jquery-ui.min.css'); 
			//wp_enqueue_style('ftg-admin', WP_PLUGIN_URL.'/final-tiles-grid-gallery-lite/admin/style.css');
		}
		
		public function gallery_admin_bar()
		{
            global $wp_admin_bar;

            $wp_admin_bar->add_menu( array(
                    'id'     => 'ftg-upgrade-bar',
                    'href' => 'http://www.final-tiles-gallery.com/wordpress/pro.html',
                    'parent' => 'top-secondary',
					'title' => __('Upgrade to Final Tiles Grid Gallery PRO'),
                    'meta'   => array('class' => 'ftg-upgrade-to-pro', 'target' => '_blank' ),
                ) );
		}
		
		//Create Admin Menu
		public function add_gallery_admin_menu() 
		{
			$overview = add_menu_page('Final Tiles Gallery', 'Final Tiles Gallery', 1, 'FinalTiles-gallery-admin', array($this, 'add_overview'), WP_PLUGIN_URL.'/final-tiles-grid-gallery-lite/admin/icon.png');
			$tutorial = add_submenu_page('FinalTiles-gallery-admin', __('FinalTiles Gallery >> Tutorial','FinalTiles-gallery'), __('Tutorial','FinalTiles-gallery'), 1, 'tutorial', array($this, 'tutorial'));
			$add_gallery = add_submenu_page('FinalTiles-gallery-admin', __('FinalTiles Gallery >> Add Gallery','FinalTiles-gallery'), __('Add Gallery','FinalTiles-gallery'), 1, 'add-gallery', array($this, 'add_gallery'));
			$edit_gallery = add_submenu_page('FinalTiles-gallery-admin', __('FinalTiles Gallery >> Edit Gallery','FinalTiles-gallery'), __('Edit Gallery','FinalTiles-gallery'), 1, 'edit-gallery', array($this, 'edit_gallery'));
			
			add_action('admin_print_styles-'.$add_gallery, array($this, 'FinalTilesGalleryLite_admin_style_load'));
			add_action('admin_print_styles-'.$edit_gallery, array($this, 'FinalTilesGalleryLite_admin_style_load'));

			add_action('load-'.$tutorial, array($this, 'gallery_admin_init'));
			add_action('load-'.$overview, array($this, 'gallery_admin_init'));
			add_action('load-'.$add_gallery, array($this, 'gallery_admin_init'));
			add_action('load-'.$edit_gallery, array($this, 'gallery_admin_init'));
					
			add_action( 'admin_bar_menu', array($this, 'gallery_admin_bar'), 100);
		}
		
		//Create Admin Pages
		public function add_overview() 
		{			
			global $ftg_fields;
			$ftg_fields = $this->fields;
			
			global $ftg_parent_page;
            $ftg_parent_page = "dashboard";
            	
			include("admin/overview.php");
		}
		
		public function tutorial() 
		{			
			include("admin/tutorial.php");
		}
		
		public function support() 
		{			
			include("admin/support.php");
		}
		
		public function add_gallery() 
		{
			global $ftg_fields;
			$ftg_fields = $this->fields;
			include("admin/add-gallery.php");	
		}

		public function delete_image()
		{
			if(check_admin_referer('FinalTilesGalleryLite','FinalTilesGalleryLite')) 
			{
				foreach (explode(",", $_POST["id"]) as $id) {
			  		$this->FinalTilesLiteDB->deleteImage(intval($id));
				}				
			}
			die();
		}

		public function assign_filters()
		{
			if(check_admin_referer('FinalTilesGalleryLite','FinalTilesGalleryLite')) 
			{
				foreach (explode(",", $_POST["id"]) as $id) 
				{
			  		$result = $this->FinalTilesLiteDB->editImage($id, array("filters" => $_POST["filters"]));
				}				
			}
			die();
		}

		public function add_image()
		{
			if(check_admin_referer('FinalTilesGalleryLite','FinalTilesGalleryLite')) 
			{							  
				$gid = intval($_POST['galleryId']);
				$enc_images = stripslashes($_POST["enc_images"]);
				$images = json_decode($enc_images);

				$result = $this->FinalTilesLiteDB->addImages($gid, $images);
				
				header("Content-type: application/json");
				if($result === false) 
				{					
					print "{\"success\":false}";
				}
				else
				{
					print "{\"success\":true}";
				}
			}	
			die();
		}

		public function sort_images()
		{
			if(check_admin_referer('FinalTilesGalleryLite','FinalTilesGalleryLite')) 
			{							  
				$result = $this->FinalTilesLiteDB->sortImages(explode(',', $_POST['ids']));
				
				header("Content-type: application/json");
				if($result === false) 
				{					
					print "{\"success\":false}";
				}
				else
				{
					print "{\"success\":true}";
				}
			}	
			die();
		}

		public function save_image()
		{
			if(check_admin_referer('FinalTilesGalleryLite','FinalTilesGalleryLite')) 
			{	
				$result = false;
				$type = $_POST['type'];			
				$imageUrl = stripslashes($_POST['img_url']);
				$imageCaption = stripslashes($_POST['description']);
				$filters = stripslashes($_POST['filters']);
				$target = $_POST['target'];
				$link = isset($_POST['link']) ? stripslashes($_POST['link']) : null;
				$imageId = intval($_POST['img_id']);
		        $sortOrder = intval($_POST['sortOrder']);
						        
				$data = array("imagePath" => $imageUrl,
							  "target" => $target,
							  "link" => $link,
							  "imageId" => $imageId,
							  "description" => $imageCaption,
							  "filters" => $filters,
							  "sortOrder" => $sortOrder);
				if(!empty($_POST["id"]))
				{
					$imageId = intval($_POST['id']);
					$result = $this->FinalTilesLiteDB->editImage($imageId, $data);
				}
				else
				{
					$data["gid"] = intval($_POST['galleryId']);
					$result = $this->FinalTilesLiteDB->addFullImage($data);
				}

				header("Content-type: application/json");

				if($result === false) 
				{					
					print "{\"success\":false}";
				}
				else
				{
					print "{\"success\":true}";
				}
			}
			die();
		}

		public function list_images()
		{
			if(check_admin_referer('FinalTilesGalleryLite','FinalTilesGalleryLite')) 
			{
				$gid = intval($_POST["gid"]);
				$imageResults = $this->FinalTilesLiteDB->getImagesByGalleryId($gid);
				
				include('admin/include/image-list.php');
			}
			die();
		}

		public function save_gallery()
		{
			if(check_admin_referer('FinalTilesGalleryLite','FinalTilesGalleryLite')) 
			{
				$galleryName = stripslashes($_POST['ftg_name']);
				$galleryDescription = stripslashes($_POST['ftg_description']);	  
				$slug = strtolower(str_replace(" ", "", $galleryName));
				$margin = intval($_POST['ftg_margin']);
				$minTileWidth = intval($_POST['ftg_minTileWidth']);
			    $gridCellSize = intval($_POST['ftg_gridCellSize']);
			    $shuffle = $_POST['ftg_shuffle'];
                $width = $_POST['ftg_width'];
			    $enableTwitter = $_POST['ftg_enableTwitter'];
			    $enableFacebook = $_POST['ftg_enableFacebook'];
			    $enableGplus = $_POST['ftg_enableGplus'];
			    $enablePinterest = $_POST['ftg_enablePinterest'];
			    $lightbox = $_POST['ftg_lightbox'];
			    $blank = $_POST['ftg_blank'];
			    $filters = $_POST['filters'];
			    $imageSizeFactor = intval($_POST['ftg_imageSizeFactor']);
                $scrollEffect = $_POST['ftg_scrollEffect'];
                $captionBehavior = $_POST['ftg_captionBehavior'];
			    $captionEffect = $_POST['ftg_captionEffect'];
			    $captionColor = $_POST['ftg_captionColor'];
			    $captionBackgroundColor = $_POST['ftg_captionBackgroundColor'];
			    $captionEasing = $_POST['ftg_captionEasing'];
			    $captionEmpty = $_POST['ftg_captionEmpty'];
			    $captionOpacity = intval($_POST['ftg_captionOpacity']);
			    $borderSize = intval($_POST['ftg_borderSize']);
			    $borderColor = $_POST['ftg_borderColor'];
			    $borderRadius = intval($_POST['ftg_borderRadius']);
			    $shadowColor = $_POST['ftg_shadowColor'];
			    $shadowSize = intval($_POST['ftg_shadowSize']);
			    $enlargeImages = $_POST['ftg_enlargeImages'];
			    $backgroundColor = $_POST['ftg_backgroundColor'];
			    $wp_field_caption = $_POST['ftg_wp_field_caption'];
			    $style = $_POST['ftg_style'];
			    $script = $_POST['ftg_script'];

			    $captionEffectDuration = intval($_POST['ftg_captionEffectDuration']);
				$id = isset($_POST['ftg_gallery_edit']) ? intval($_POST['ftg_gallery_edit']) : 0;

			    $data = array('name' => $galleryName, 
			    			  'slug' => $slug, 
			    			  'description' => $galleryDescription, 
			    			  'lightbox' => $lightbox,
			    			  'blank' => $blank,
			                  'margin' => $margin, 
			                  'minTileWidth' => $minTileWidth, 
			                  'gridCellSize' => $gridCellSize, 
			                  'shuffle' => $shuffle, 
			                  'enableTwitter' => $enableTwitter, 
			                  'enableFacebook' => $enableFacebook, 
			                  'enableGplus' => $enableGplus, 
			                  'enablePinterest' => $enablePinterest,
			                  'socialIconColor' => $_POST['ftg_socialIconColor'],
			                  'captionBehavior' => $captionBehavior,
			                  'captionEffect' => $captionEffect,
			                  'captionEmpty' => $captionEmpty, 
			                  'captionFullHeight' => $_POST['ftg_captionFullHeight'],
			                  'captionBackgroundColor' => $captionBackgroundColor, 
			                  'captionColor' => $captionColor, 
			                  'captionEffectDuration' => $captionEffectDuration, 
			                  'captionEasing' => $captionEasing, 
			                  'captionOpacity' => $captionOpacity,
			                  'captionIcon' => $_POST['ftg_captionIcon'],
			                  'captionIconColor' => $_POST['ftg_captionIconColor'],
			                  'captionIconSize' => intval($_POST['ftg_captionIconSize']),
			                  'hoverZoom' => intval($_POST['ftg_hoverZoom']),
			                  'hoverRotation' => intval($_POST['ftg_hoverRotation']),
			                  'hoverIconRotation' => $_POST['ftg_hoverIconRotation'],
			                  'filters' => $filters, 
			                  'wp_field_caption' => $wp_field_caption,
			                  'borderSize' => $borderSize,
			                  'borderColor' => $borderColor, 
			                  'enlargeImages' => $enlargeImages, 
			                  'backgroundColor' => $backgroundColor, 
			                  'borderRadius' => $borderRadius, 
			                  'imageSizeFactor' => $imageSizeFactor,
			                  'shadowSize' => $shadowSize, 
			                  'shadowColor' => $shadowColor, 
			                  'width' =>  $width,
			                  'style' => $style, 
			                  'script' => $script, 
			                  'scrollEffect' => $scrollEffect );
			    
			    header("Content-type: application/json");
			    if($id > 0)
			    {
					$result = $this->FinalTilesLiteDB->editGallery($id, $data);	
				}
				else
				{
					$result = $this->FinalTilesLiteDB->addGallery($data);					
					$id = $this->FinalTilesLiteDB->getNewGalleryId();
				}

				if($result) 
					print "{\"success\":true,\"id\":" . $id ."}";
				else
					print "{\"success\":false}";
			}
			die();
		}

		public function edit_gallery() 
		{
			global $ftg_fields;
			$ftg_fields = $this->fields;
			
			include("admin/edit-gallery.php");	
		}
		
		public function add_images() 
		{
			include("admin/add-images.php");
		}	
		
		//Create gallery
		public function create_gallery($galleryId) 
		{
			require_once('lib/gallery-class.php');			
			global $FinalTilesGallery;
			
			if (class_exists('FinalTilesGalleryLiteFE')) {
				$FinalTilesGallery = new FinalTilesGalleryLiteFE($galleryId, $this->FinalTilesLiteDB);
				$settings = $FinalTilesGallery->getGallery();
				
				wp_enqueue_style('lightbox2_stylesheet');
				wp_enqueue_script('lightbox2_script');
				
				return $FinalTilesGallery->render();
			}
			else {
				return "Gallery not found.";	
			}	
		}
		
		//Create Short Code
		public function gallery_shortcode_handler($atts) {
			return $this->create_gallery($atts['id']);
		}	
		
		var $fields = array(
        
            "General" => array(
            	"icon" => "gears",
            	"fields" => array(
	                "name" => array(
	                    "name" => "Name",
	                    "hiddenFor" => array("dashboard", "shortcode"),
	                    "type" => "text",
	                    "description" => "This name is the internal name for the gallery.<br />Please avoid non-letter characters.",
	                    "excludeFrom" => array("dashboard", "shortcode")
	                ),
	                "description" => array(
	                    "name" => "Description",
	                    "hiddenFor" => array("dashboard", "shortcode"),
	                    "type" => "text",
	                    "description" => "This description is for internal use.",
	                    "excludeFrom" => array("dashboard", "shortcode")
	                ),
	                "width" => array(
	                    "name" => "Width",
	                    "type" => "text",
	                    "description" => "Width of the gallery in pixels or percentage.",
	                    "excludeFrom" => array()
	                ),
	                "margin" => array(
	                    "name" => "Margin",
	                    "type" => "slider",
	                    "description" => "Margin between images",
	                    "mu" => "px",
	                    "min" => 0,
	                    "max" => 50,
	                    "excludeFrom" => array()
	                ),
	                "imageSizeFactor" => array(
	                    "name" => "Image size factor",
	                    "type" => "slider",
	                    "description" => "Percentage of image size, i.e.: if an image of the gallery is 300x200 and the size factor is 50% then the resulting image will be 150x100.
	    90% is a suggested default value, because under some circumstances, the images could be enlarged by the script (to fill gaps and avoid blank spaces between tiles).",
	                    "default" => 90,
	                    "min" => 1,
	                    "max" => 100,
	                    "mu" => "%",
	                    "excludeFrom" => array()
	                ),
	                "minTileWidth" => array(
	                    "name" => "Tile minimum width",
	                    "type" => "slider",
	                    "description" => "Minimum width of each tile, multiply this value for the image size factor to get the real size.",
	                    "mu" => "px",
	                    "min" => 50,
	                    "max" => 500,
	                    "default" => 200,
	                    "excludeFrom" => array()
	                ),	                
	                "filter" => array(
	                    "name" => "Filters",
	                    "type" => "pro",
	                    "description" => "Manage here all the filters of this gallery",
	                    "excludeFrom" => array("dashboard", "shortcode")                
	                ),
	                "gridCellSize" => array(
	                    "name" => "Size of the grid",
	                    "type" => "slider",
	                    "default" => 25,
	                    "min" => 5,
	                    "max" => 100,
	                    "mu" => "px",
	                    "description" => "Tiles are snapped to a virtual grid, the higher this value the higher the chance to get aligned tiles.",
	                    "excludeFrom" => array()
	                ),
	                "enlargeImages" => array(
	                    "name" => "Allow image enlargement",
	                    "type" => "toggle",
	                    "description" => "Images can be ocasionally enlarged to avoid gaps. If you notice a quality loss try to reduce the <strong>Image size factor</strong> parameter.",
	                    "default" => "T",
	                    "excludeFrom" => array()
	                ),
	                "shuffle" => array(
	                    "name" => "Shuffle images",
	                    "type" => "pro",
	                    "description" => "Randomize the order of the images.",
	                    "excludeFrom" => array()
	                ),
	                "scrollEffect" => array(
	                	"name" => "Scroll effect",
	                	"type" => "pro",
	                	"description" => "Effect on tiles when scrolling the page",
	                	"excludeFrom" => array()
	                )
	            )
            ),
            "Links & Lightbox" => array(
            	"icon" => "link",
            	"fields" => array(
	                "lightbox" => array(
	                    "name" => "Lightbox &amp; Link",
	                    "type" => "select",
	                    "description" => "Define here what happens when user click on the images. <strong>Buy a PRO license</strong> to unlock 5 more lightboxes.",
	                    "values" => array(
	                        "Link" => array("|No link", "direct|Direct link to image"),
	                        "Lightboxes" => array("lightbox2|Lightbox")
	                    ),
	                    "excludeFrom" => array()
	                ),
	                "blank" => array(
	                    "name" => "Blank",
	                    "type" => "toggle",
	                    "description" => "Open links in a blank page.",
	                    "excludeFrom" => array()
	                ),
	                "enableTwitter" => array(
	                    "name" => "Enable Twitter icon",
	                    "type" => "toggle",
	                    "description" => "Enable Twitter sharing.",
	                    "default" => "F",
	                    "excludeFrom" => array()
	                ),
	                "enableFacebook" => array(
	                    "name" => "Enable Facebook icon",
	                    "type" => "toggle",
	                    "description" => "Enable Facebook sharing.",
	                    "default" => "F",
	                    "excludeFrom" => array()
	                ),
	                "enableGplus" => array(
	                    "name" => "Enable Google Plus icon",
	                    "type" => "toggle",
	                    "description" => "Enable Google Plus sharing",
	                    "default" => "F",
	                    "excludeFrom" => array()
	                ),
	                "enablePinterest" => array(
	                    "name" => "Enable Pinterest icon",
	                    "type" => "toggle",
	                    "description" => "Enable Pinterest sharing",
	                    "default" => "F",
	                    "excludeFrom" => array()
	                ),
	                "socialIconColor" => array(
	                	"name" => "Color of social sharing icons",
	                	"type" => "color",
	                	"description" => "Set the color of the social sharing icons",
	                	"default" => "#ffffff",
	                	"excludeFrom" => array()
	                )
	            )
            ),
            "Captions" => array(
            	"icon" => "font",
            	"fields" => array(
	                "wp_field_caption" => array(
	                    "name" => "WordPress caption field",
	                    "type" => "select",
	                    "description" => "WordPress field used for captions. <strong>This field is used ONLY when images are added to the gallery, </strong> however, if you want to ignore captions just set it to '<i>Don't use captions</i>'.",
	                    "values" => array(
	                        "Field" => array("none|Don't use captions", "title|Title", "caption|Caption", "description|Description")
	                    ),
	                    "excludeFrom" => array("shortcode")
	                ),
	                "captionBehavior" => array(
	            	    "name" => "Caption behavior",
	            	    "type" => "pro",
	            	    "description" => "Captions can have two different behaviors: start hidden and shown on mouse over or viceversa.",
	            	    "value" => "hidden",
	            	    "excludeFrom" => array()
	                ),
	                "captionFullHeight" => array(
	                	"name" => "Caption full height",
	                	"type" => "pro",
	                	"description" => "Enable this option for full height captions. <strong>This is required if you want to use caption icons and caption effects other than <i>fade</i>.</strong>",
	                	"value" => "T",
	                	"excludeFrom" => array()
	                ),
	                "captionEmpty" => array(
	            	    "name" => "Empty captions",
	            	    "type" => "pro",
	            	    "description" => "Choose if empty caption has to be shown. Consider that empty captions are never shown if <i>Caption full height</i> is switched off.",
	            	    "value" => "hide",
	            	    "excludeFrom" => array()
	                ),
	                "captionIcon" => array(
	                    "name" => "Caption icon",
	                    "type" => "select",
	                    "description" => "Choose the icon for the captions.",
	                    "values" => array(
	                        "Icon" => array("|None", "search|Lens", "search-plus|Lens (plus)", "link|Link", "heart|Heart", "heart-o|Heart empty", 
	                        "camera|Camera", "camera-retro|Camera retro", "picture-o|Picture", "star|Star", "star-o|Star empty",
	                        "sun-o|Sun", "arrows-alt|Arrows", "hand-o-right|Hand")
	                    ),
	                    "excludeFrom" => array()
	                ),
	                "captionIconColor" => array(
	                    "name" => "Caption icon color",
	                    "type" => "color",
	                    "description" => "Color of the icon in captions.",
	                    "default" => "#ffffff",
	                    "excludeFrom" => array()
	                ),
	                "captionIconSize" => array(
	                	"name" => "Caption icon size",
	                	"type" => "slider",
	                	"description" => "Size of the icon in captions.",
	                	"default" => 12,
	                	"min" => 10,
	                	"max" => 96,
	                	"mu" => "px",
	                	"excludeFrom" => array()
	                ),
	                "captionEffect" => array(
	                    "name" => "Caption effect",
	                    "type" => "pro",
	                    "description" => "Effect used to show the captions. <strong>Buy a PRO license</strong> to unlock 4 more effect.",
	                    "value" => "fade",
	                    "excludeFrom" => array()
	                ),
	                "captionEasing" => array(
	                    "name" => "Caption effect easing",
	                    "type" => "pro",
	                    "description" => "Easing function for the caption animation, works better with sliding animations. <strong>Buy a PRO license</strong> to unlock 4 more easings.",
	                    "value" => "ease",
	                    "excludeFrom" => array()
	                ),
	                "captionColor" => array(
	                    "name" => "Caption color",
	                    "type" => "color",
	                    "description" => "Text color of the captions.",
	                    "default" => "#ffffff",
	                    "excludeFrom" => array()
	                ),
	                "captionEffectDuration" => array(
	                    "name" => "Caption effect duration",
	                    "type" => "slider",
	                    "description" => "Duration of the caption animation.",
	                    "default" => 250,
	                    "mu" => "ms",
	                    "min" => 0,
	                    "max" => 1000,
	                    "excludeFrom" => array()
	                ),
	                "captionBackgroundColor" => array(
	                    "name" => "Caption background color",
	                    "type" => "color",
	                    "description" => "This background is visible only when the parameter '<i>Allow image enlargement</i>' is set to '<i>Off</i>' and only when a tile is wider than the contained image",
	                    "default" => "#000000",
	                    "excludeFrom" => array()
	                ),            
	                "captionOpacity" => array(
	                    "name" => "Caption opacity",
	                    "type" => "slider",
	                    "description" => "Opacity of the caption, 0% means 'invisible' while 100% is a plain color without opacity.",
	                    "default" => 80,
	                    "min" => 10,
	                    "max" => 100,
	                    "mu" => "%",
	                    "excludeFrom" => array()
	                )
	            )
            ),
            "Hover effects" => array(
            	"icon" => "hand-o-up",
            	"fields" => array(
            		"hoverZoom" => array(
            			"name" => "Zoom",
	            		"type" => "pro",
	            		"description" => "Change the scale of the image on hover.",
	            		"excludeFrom" => array()
	            	),
	            	"hoverRotation" => array(
            			"name" => "Rotation",
	            		"type" => "pro",
	            		"description" => "Image rotation value in degrees on hover",
	            		"excludeFrom" => array()
	            	),
                    "hoverIconRotation" => array(
                        "name" => "Rotate icon",
                        "type" => "toggle",
                        "default" => "F",
                        "description" => "Enable rotation of the icon.",
                        "excludeFrom" => array()
                    )
            	)
            ),
            "Style" => array(
            	"icon" => "magic",
            	"fields" => array(
	                "borderSize" => array(
	                    "name" => "Border size",
	                    "type" => "slider",
	                    "description" => "Size of the border of each image.",
	                    "default" => 0,
	                    "min" => 0,
	                    "max" => 10,
	                    "mu" => "px",
	                    "excludeFrom" => array()
	                ),
	                "borderRadius" => array(
	                    "name" => "Border radius",
	                    "type" => "slider",
	                    "description" => "Border radius of the images.",
	                    "default" => 0,
	                    "min" => 0,
	                    "max" => 100,
	                    "mu" => "px",
	                    "excludeFrom" => array()
	                ),
	                "borderColor" => array(
	                    "name" => "Border color",
	                    "type" => "color",
	                    "description" => "Color of the border when size is greater than 0.",
	                    "default" => "#000000",
	                    "excludeFrom" => array()
	                ),
	                "shadowSize" => array(
	                    "name" => "Shadow size",
	                    "type" => "slider",
	                    "description" => "Shadow size of the images.",
	                    "default" => 0,
	                    "min" => 0,
	                    "max" => 20,
	                    "mu" => "px",
	                    "excludeFrom" => array()
	                ),
	                "shadowColor" => array(
	                    "name" => "Shadow color",
	                    "type" => "color",
	                    "description" => "Color of the shadow when size is greater than 0.",
	                    "default" => "#000000",
	                    "excludeFrom" => array()
	                )
	            )
            ),
            "Customizations" => array(
            	"icon" => "code",
            	"fields" => array(
	                "style" => array(
	                    "name" => "Custom CSS",
	                    "type" => "textarea",
	                    "description" => "<strong>Write just the code without using the &lt;style&gt; tag.</strong><br>List of useful selectors:<br>
	                    <ul>
                        <li>
                            <em>final-tiles-gallery</em> : gallery container;
                        </li>
                        <li>
                            <em>final-tiles-gallery .tile-inner</em> : tile content;
                        </li>
                        <li>
                            <em>final-tiles-gallery .tile-inner .item</em> : image of the tile;
                        </li>
                        <li>
                            <em>final-tiles-gallery .tile-inner .caption</em> : caption of the tile;
                        </li>
                        <li>
                            <em>final-tiles-gallery .ftg-filters</em> : filters container
                        </li>
                        <li>
                            <em>final-tiles-gallery .ftg-filters a</em> : filter
                        </li>
                        <li>
                            <em>final-tiles-gallery .ftg-filters a.selected</em> : selected filter
                        </li>
                    
                </ul>",
	                    "excludeFrom" => array("shortcode")
	                ),
	                "script" => array(
	                    "name" => "Custom scripts",
	                    "type" => "textarea",
	                    "description" => "This script will be called after the gallery initialization.
	                        <br />
	                        <br />
	                        <strong>Write just the code without using the &lt;script&gt;&lt;/script&gt; tags</strong>",
	                    "excludeFrom" => array("shortcode")
	                )
	             )
            )
        );	
	}
}

if (class_exists("FinalTilesGalleryLite")) {
    global $ob_FinalTilesGalleryLite;
	$ob_FinalTilesGalleryLite = new FinalTilesGalleryLite();
}
?>