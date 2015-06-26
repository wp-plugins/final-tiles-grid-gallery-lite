<?php


if (!class_exists("FinalTilesGallery")) 
{
	class FinalTilesGallery 
	{
		public function __construct($galleryId, $db) 
		{
			$this->id = $galleryId;
			$this->gallery = null;
			$this->db = $db;
			$this->images = array();
						
			$this->getGallery();
			
			switch($this->gallery->source)
			{
				default:
				case "images":
					$this->getImages();
					break;
				case "posts":
					$this->getPosts();
					break;
				case "woocommerce":
					$this->getWooProducts();
					break;				
			}
			
			$attIDs = array();
			foreach($this->images as $image)
				$attIDs []= $image->attID;
			
            $args = array(
				'post_type' => 'attachment',
				'posts_per_page' => -1,
				'include' => $attIDs
			);
			
			$atts = get_posts($args);

            $upload_dir = wp_upload_dir();
            foreach($atts as $att)
            {	            
            	$meta = get_post_custom($att->ID);
            	foreach($this->images as &$image)
            	{
	            	if($image->attID == $att->ID)
	            	{
		            	$image->url = $upload_dir['baseurl'] .'/'. $meta['_wp_attached_file'][0];	
		            	break;
	            	}
            	}		            
            }              
		}
		
		var $cssPrefixes = array("-moz-", "-webkit-", "-o-", "-ms-", "");
		
		private function getLink($image)
		{
			if(! empty($image->link))
				return "href='" . $image->link . "'";
						
			if(empty($this->gallery->lightbox))
				return '';
							
			if($this->gallery->lightbox == 'attachment-page')
				return "href='" . $image->url . "'";
							
			return "href='" . $image->url . "'";
		}
		
		private function getBigImage($image)
		{
			if(! empty($image->link))
				return "";
						
			if(empty($this->gallery->lightbox))
				return "";
							
			if($this->gallery->lightbox == 'attachment-page')
				return "";
							
			return $image->url;
		}
		
		private function getTarget($image)
		{
			if(! empty($image->target))
				return "target='" . $image->target . "'";
						
			if($this->gallery->blank == 'T')
				return "target='_blank'";
							
			return '';
		}
		
		private function getLightboxClass($image)
		{
			if(! empty($image->link))
				return '';
				
			if(empty($this->gallery->lightbox))
				return '';
				
			return 'ftg-lightbox';
		}
		
		private function getdef($value, $default)
		{
			if($value == NULL || empty($value))
				return $default;
				
			return $value;
		}
        
        private function toRGB($Hex)
        {            
            if (substr($Hex,0,1) == "#")
                $Hex = substr($Hex,1);
            
            $R = substr($Hex,0,2);
            $G = substr($Hex,2,2);
            $B = substr($Hex,4,2);

            $R = hexdec($R);
            $G = hexdec($G);
            $B = hexdec($B);

            $RGB['R'] = $R;
            $RGB['G'] = $G;
            $RGB['B'] = $B;
            
            $RGB[0] = $R;
            $RGB[1] = $G;
            $RGB[2] = $B;

            return $RGB;

        }

		static public function slugify($text)
		{ 
		  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
		  $text = trim($text, '-');
		  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		  $text = strtolower($text);
		  $text = preg_replace('~[^-\w]+~', '', $text);

		  if (empty($text))
		  {
		    return 'n-a';
		  }

		  return $text;
		}

		static public function getFilters($filters)
		{
			if(empty($filters))
				return "";

			$css = array();
			foreach (explode("|", $filters) as $f) {
				$css[] = "ftg-set-" . FinalTilesGallery::slugify($f);
			}

			return implode(" ", $css);
		} 
		
		public function useCaptions()
		{
			if($this->gallery->source == "images")
			{
				if(empty($this->gallery->wp_field_caption))
					return true;
				
				return $this->gallery->wp_field_caption != 'none';
			}
			if($this->gallery->source == "posts")
			{
				return $this->gallery->recentPostsCaption != 'none';
			}
			if($this->gallery->source == "woocommerce")
			{
				return true;
			}
			return false;
		}
		
		public function cssRuleRotation()
		{
			if($this->gallery->hoverRotation == 0)
				return "";
				
	        return $prefix."rotate(".$this->gallery->hoverRotation."deg) ";
		}
		
		public function cssRuleZoom()
		{
			if($this->gallery->hoverZoom == 100)
				return "";
				
	        return $prefix."scale(".($this->gallery->hoverZoom/100).") ";
		}
		
		private function hasCaptionIcon()
		{					 		
			return !(empty($this->gallery->captionIcon) && 
					 empty($this->gallery->customCaptionIcon));
		}
		
		private function getCaptionIcon()
		{
			if(! empty($this->gallery->customCaptionIcon))
				return substr($this->gallery->customCaptionIcon, 3);
			
			return $this->gallery->captionIcon;
		}

		public function render() 
		{
			$rid = rand(1, 1000);
			
			$gallery = $this->gallery;
			
            if($gallery->imagesOrder == 'random')
            	shuffle($this->images);
            	
            if($gallery->imagesOrder == 'reverse')
            	$this->images = array_reverse($this->images);
    
            $bgCaption = $this->toRGB($gallery->captionBackgroundColor);
            
            $html = "<!-- Final Tiles Grid Gallery for WordPress v".FTGVERSION." -->\n\n";
            $html .= stripslashes($this->gallery->beforeGalleryText);

            
			$html .= "<style>\n";
			
				
			if($gallery->borderSize)
				$html .= "#ftg-$this->id$rid .tile { border: " . $gallery->borderSize . "px solid " . $gallery->borderColor . "; }\n";
        	
        	if($gallery->loadingBarColor)
				$html .= ".final-tiles-gallery .ftg-items .loading-bar { background:" . $gallery->loadingBarColor  . "; }\n";
        		           
            if($gallery->captionIconColor)
                $html .= "#ftg-$this->id$rid .tile .icon { color:".$gallery->captionIconColor."; }\n";                           
                
            if($gallery->captionIconSize)
            {
                $html .= "#ftg-$this->id$rid .tile .icon { font-size:".$gallery->captionIconSize."px; }\n";
                $html .= "#ftg-$this->id$rid .tile .icon { margin: -".($gallery->captionIconSize / 2)."px 0 0 -".($gallery->captionIconSize / 2)."px; }\n";
            }
              
            if($gallery->captionFontSize)
            {
                $html .= "#ftg-$this->id$rid .tile .caption { font-size:".$gallery->captionFontSize."px; }\n";
            }
               
			if($gallery->backgroundColor)
				$html .= "#ftg-$this->id$rid .tile .tile-inner { background-color: " . $gallery->backgroundColor . "; }\n";
                
            if($gallery->captionColor)
				$html .= "#ftg-$this->id$rid .tile .tile-inner .text { color: " . $gallery->captionColor . "; }\n";
			
			if($gallery->socialIconColor)
				$html .= "#ftg-$this->id$rid .tile .ftg-social a { color: " . $gallery->socialIconColor . "; }\n";
			
			if($gallery->borderRadius)
				$html .= "#ftg-$this->id$rid .tile { border-radius: " . $gallery->borderRadius . "px; }\n";

			if($gallery->shadowSize)
				$html .= "#ftg-$this->id$rid .tile { box-shadow: " . $gallery->shadowColor ." 0px 0px " . $gallery->shadowSize . "px; }\n";
                
            if($gallery->captionEasing)
                $html .= "#ftg-$this->id$rid .tile .caption { transition-timing-function:".$gallery->captionEasing."; }\n";
            
            if($gallery->captionEffectDuration)
                    $html .= "#ftg-$this->id$rid .tile .caption { transition-duration:".($gallery->captionEffectDuration/1000)."s; }\n";
            
            $html .= "#ftg-$this->id$rid .tile .caption { background-color: $gallery->captionBackgroundColor; }\n";
                                    
            $html .= "#ftg-$this->id$rid .tile .caption { background-color: rgba($bgCaption[0], $bgCaption[1], $bgCaption[2], ". ($gallery->captionOpacity/100) . "); }\n";
            
            if($gallery->captionFrame == 'T' && $gallery->captionFrameColor)
            	$html .= "#ftg-$this->id$rid .tile .caption.frame .text { border-color: ". $gallery->captionFrameColor ."; }\n";
            
                
            if($gallery->hoverZoom != 100 || $gallery->hoverRotation != 0)
            {
                $html .= "#ftg-$this->id$rid .tile:hover img {\n";
					
				foreach($this->cssPrefixes as $prefix)
				{
					$html .= "\t" . $prefix."transform: " 
						        . $this->cssRuleRotation()
						        . $this->cssRuleZoom()
						        .";\n";
				}
                
                $html .="}\n";
            }
            
            if($gallery->hoverIconRotation == 'T')
            {
            	$html .= "#ftg-$this->id$rid .tile .icon {\n";
            	
            	foreach($this->cssPrefixes as $prefix)
				{
					$html .= "\t" . $prefix."transition: all .5s;\n";
				}
            	
            	$html .="}\n";
            	
                $html .= "#ftg-$this->id$rid .tile:hover .icon {\n";
					
				foreach($this->cssPrefixes as $prefix)
				{
					$html .= "\t" . $prefix."transform: rotate(360deg);\n";
				}				
							
                $html .="}\n";
            }  
                
			if(! empty($gallery->style))
				$html .= $gallery->style;

			$html .= "</style>\n";
			                        	           			
            $html .= "<div class='final-tiles-gallery captions-$gallery->captionBehavior hover-$gallery->captionEffect ". ($gallery->captionFullHeight == 'T' ? "caption-full-height" : "caption-auto-height") ."' id='ftg-$this->id$rid' style='width:$gallery->width'>\n";
            if(strlen($gallery->filters))
            {
            	$filters = explode("|", $gallery->filters);
            	$html .= "<div class='ftg-filters'>\n";
            	$html .= "\t<a href='#ftg-set-ftgall' class='selected'>All</a>\n";
            	foreach($filters as $filter)
            	{
            		$html .= "\t<a href='#ftg-set-". FinalTilesGallery::slugify($filter) ."'>$filter</a>\n";
            	}
            	$html .= "</div>\n";
            }
            $html .= "<div class='ftg-items'>\n";
            $html .= "\t<div class='loading-bar'><i></i></div>\n";

			foreach($this->images as $image)
			{
				$title = in_array($gallery->lightbox, array('prettyphoto', 'fancybox', 'swipebox', 'lightbox2')) ? "title" : "data-title";
				$rel = $gallery->lightbox == "prettyphoto" ? "prettyPhoto[ftg-$this->id$rid]" : "ftg-$this->id$rid";
                if($gallery->rel)
                    $rel = $gallery->rel;

                $data_keep_aspect_ratio = "";
                if(property_exists($image, "type") && $image->type == "video")               
                    $data_keep_aspect_ratio = 'data-ftg-keep-aspect-ratio="true"';

                if(!property_exists($image, "filters"))
                	$image->filters = "";

            	$html .= "<div $data_keep_aspect_ratio class='tile ". FinalTilesGallery::getFilters($image->filters) ."'>\n";

               if(property_exists($image, "type") && $image->type == "video")
               {
                    $html .= $image->imagePath;
               }
               else
               {	               
                    $html .= "<a $title=\"".htmlspecialchars($image->description, ENT_QUOTES)."\" ". ($gallery->lightbox == "lightbox2" && empty($image->link) ? "data-lightbox='gallery'" : "") ." rel='$rel' " . ($this->getTarget($image)) . " class='tile-inner " . $gallery->aClass . " " . ($this->getLightboxClass($image)) . "' " . $this->getLink($image) . " data-big='".$this->getBigImage($image)."'>\n";
                    $html .= "<img class='item' data-ftg-src='$image->imagePath' />\n";

                    if((! empty($image->description) && $this->useCaptions()) || $gallery->captionEmpty == "show" || $this->hasCaptionIcon())
                    {
                        $html .= "<span class='caption ".($gallery->captionFrame == 'T' ? "frame" : null)."'>\n";
                        if($this->hasCaptionIcon())
                            $html .= "\t<span class='icon fa fa-".$this->getCaptionIcon()."'></span>\n";
                        if($gallery->source == "images")
                        {
                            if(! empty($image->description) && $this->useCaptions())
                                $html .= "\t<span class='text'>$image->description</span>\n";
                        }
                        if(($gallery->source == "posts" || $gallery->source == "woocommerce") && $this->useCaptions())
                        {
                            $html .= "\t<span class='text'>$image->description</span>\n";                            
                        }
                        $html .= "</span>\n";
                    }
                    $html .= "</a>\n";
                    if($gallery->source == "woocommerce")
                    {
	                    $html .= "<div class='woo'>";
                        $html .= "\t<span class='price'>". $image->price . get_woocommerce_currency_symbol() . "</span>\n";
                        $html .= "\t<a href='".get_site_url()."/cart/?add-to-cart=".$image->postID ."'><i class='fa fa-shopping-cart add-to-cart'></i></a>";
                        $html .= "</div>";
                    }
                    $html .= "<div class='ftg-social'>\n";

                    if($gallery->enableFacebook == "T") 
                    {
						$html .= "<a href='#' data-social='facebook' class='ftg-facebook'><i class='fa fa-facebook'></i></a>\n";
                    }
                    if($gallery->enableTwitter == "T") 
                    {
						$html .= "<a href='#' data-social='twitter' class='ftg-twitter'><i class='fa fa-twitter'></i></a>\n";
                    }
                    if($gallery->enablePinterest == "T") 
                    {
						$html .= "<a href='#' data-social='pinterest' class='ftg-pinterest'><i class='fa fa-pinterest'></i></a>\n";
                    }
                    if($gallery->enableGplus == "T") 
                    {
						$html .= "<a href='#' data-social='google-plus' class='ftg-google-plus'><i class='fa fa-google-plus'></i></a>\n";
                    }
                    $html .= "</div>\n";
                }
                
                $html .= "</div>\n";
			}
            $html .= "</div>\n";
            if($gallery->support == 'T')
            {
	            $html .= "<div class='support-text'><a target='_blank' href='http://codecanyon.net/item/final-tiles-grid-gallery-for-wordpress/5189351?ref=".$gallery->envatoReferral."'>".$gallery->supportText."</a></div>";
            }
            $html .= "</div>\n";            
            
            $html .= "<script type='text/javascript'>\n";
            $html .= "setTimeout(function () {\n";            
            $html .= "\tjQuery('#ftg-$this->id$rid').finalTilesGallery({\n";
            $html .= "\t\tminTileWidth: $gallery->minTileWidth,\n";
            if(strlen($gallery->script))
            {
            	$html .= "\t\tonComplete: function () { " . stripslashes($gallery->script) . "},\n";
            }
            $html .= "\t\tmargin: $gallery->margin,\n";
            $html .= "\t\tdebug: ".(empty($_GET['debug']) ? "false" : "true").",\n";
            $html .= "\t\tgridSize: $gallery->gridCellSize,\n";
			$html .= "\t\tallowEnlargement: " . ($gallery->enlargeImages == "T" ? "true" : "false") . ",\n";
            $html .= "\t\timageSizeFactor: [\n" . 
                "\t\t\t [4000, " . ($gallery->imageSizeFactor / 100) . "]\n" .
                "\t\t\t,[1024, " . ($gallery->imageSizeFactorTabletLandscape / 100) . "]\n" .
                "\t\t\t,[768, " . ($gallery->imageSizeFactorTabletPortrait / 100) . "]\n" .
                "\t\t\t,[640, " . ($gallery->imageSizeFactorPhoneLandscape / 100) . "]\n" .
                "\t\t\t,[320, " . ($gallery->imageSizeFactorPhonePortrait / 100) . "]\n";
            foreach(explode("|", $gallery->imageSizeFactorCustom) as $isf)
            {
	            $_ = explode(",", $isf);
	            if(! empty($_[0]))
		            $html .= "\t\t\t,[".$_[0].", " . ($_[1] / 100) . "]\n";
            }
            $html .= "\t\t],\n";
			$html .= "\t\tscrollEffect: '"  . ($gallery->scrollEffect) . "',\n";
            $html .= "\t});\n";			
            
			$html .= "\tjQuery(function () {\n";
            //$html .= "\t\tjQuery('#ftg-$this->id$rid .tile > a').unbind('click');\n";
			switch ($gallery->lightbox) {
				case 'magnific':
					$html .= "\t\tjQuery('#ftg-$this->id$rid').magnificPopup({type:'image', zoom: { enabled: true, duration: 300, easing: 'ease-in-out' }, image: { titleSrc: 'data-title' }, gallery: { enabled: true }, delegate: '.tile:not(.ftg-hidden) .ftg-lightbox ' });\n";
					break;
				case 'prettyphoto':
					$html .= "\t\tjQuery('#ftg-$this->id$rid .tile a.ftg-lightbox').prettyPhoto({});\n";
					break;
				case 'colorbox':
					$html .= "\t\tjQuery('#ftg-$this->id$rid .tile a.ftg-lightbox').colorbox({rel: 'gallery', title: function () { return jQuery(this).data('title'); }});\n";
					break;
				case 'fancybox':
					$html .= "\t\tjQuery('#ftg-$this->id$rid .tile a.ftg-lightbox').fancybox({});\n";
					break;
				case 'swipebox':
					$html .= "\t\tjQuery('#ftg-$this->id$rid .tile a.ftg-lightbox').swipebox({});\n";
					break;
				case 'lightbox2':
					break;
			}
			$html .= "\n";
			$html .= "\t});\n";
			$html .= "\t}, ". $gallery->delay .");\n";
			 
			$html .= "</script>";
			
			$html .= stripslashes($this->gallery->afterGalleryText);
			
			if(! empty($_GET["debug"]))
				return $html;
			
			if($gallery->compressHTML == 'T')
				return str_replace(array("\n", "\t"), "", $html);
			else
				return $html;
		}
		
		private function auto_excerpt($post, $length, $excerpt_ending) 
		{
			$text = strip_shortcodes($post->post_content);
			$text = apply_filters('the_content', $text);
			$text = str_replace('\]\]\>', ']]&gt;', $text);
			$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
			$text = strip_tags($text);
			$words = explode(' ', $text, $length + 1);

			if (count($words) > $length) 
			{
					array_pop($words);
					$text = implode(' ', $words);
					if($excerpt_ending !== 'none')
					{
						$text .= strtr($excerpt_ending, array("(" => "[", ")" => "]"));
					}
			}
			$text = trim($text);
			if(strlen($text) !== strlen($excerpt_ending))
			{
				return $text;
			}
			else
			{
				return '';
			}
		}
		
		public function getWooProducts()
		{
			$args = array(
				'order' 				=> 'DESC',
				'orderby' 				=> 'date',
				'post_status'			=> array('publish'),
				'meta_query'			=> '_thumbnail_id',
				'ignore_sticky_posts' 	=> 1,
				'nopaging'				=> true,
				'post_type'				=> 'product',
				'meta_query'			=> array(
					array(
			            'key'           => '_visibility',
			            'value'         => array('catalog', 'visible'),
			            'compare'       => 'IN'
			        )
				)
			);

			if($this->gallery->woo_categories)
			{
				$args['tax_query'] = array(
					array(
						'taxonomy'      => 'product_cat',
			            'field' 		=> 'term_id',
			            'terms'         => explode(",", $this->gallery->woo_categories),
			            'operator'      => 'IN'	
					)						
				);
			}			

            $posts = get_posts($args);
            
            $imageResults = array();
//          print_r($posts);
			foreach ($posts as &$post)
            {
			    $post_thumbnail_id = get_post_thumbnail_id($post->ID);
                if($post_thumbnail_id)
                {
                    $item = new stdClass;
                    $item->attID = $post_thumbnail_id;
                    $item->imagePath = get_post_meta( $post->ID, 'ftg_image_url', true);
                    $item->filters = get_post_meta( $post->ID, 'ftg_filters', true);
                    $item->price = get_post_meta( $post->ID, '_price', true);
	                $item->description = $post->post_title;	                
	                $item->postID = $post->ID;
	                
					if(empty($item->imagePath))
					{
	                	$attr = wp_get_attachment_image_src( $post_thumbnail_id, $this->gallery->defaultWooImageSize);     
						$item->imagePath = $attr[0];
                	}   
                    
                    if(empty($this->gallery->lightbox))
	                    $item->link = get_permalink($post->ID);
	                    
                    $this->images[] = $item;
				    //unset($post, $post_thumbnail_id);
                }
            }           
		}
		
		public function getPosts()
		{
			$args = array(					
				'order' 				=> 'DESC',
				'orderby' 				=> 'date',
				'post_status'			=> array('publish'),
				'meta_query'			=> '_thumbnail_id',					
				'ignore_sticky_posts' 	=> 1,
				'nopaging'				=> true
			);
			
			if($this->gallery->post_types)
				$args['post_type'] = explode(",", $this->gallery->post_types);
			
			if($this->gallery->post_categories)
				$args['category__in'] = $this->gallery->post_categories;
			
			$posts = get_posts($args);
            $imageResults = array();

			foreach ($posts as &$post)
            {
			    $post_thumbnail_id = get_post_thumbnail_id($post->ID);
			    
			    
                if($post_thumbnail_id)
                {
                    $item = new stdClass;
                    $item->attID = $post_thumbnail_id;
                    $item->imagePath = get_post_meta( $post->ID, 'ftg_image_url', true);
                    $item->filters = get_post_meta( $post->ID, 'ftg_filters', true);                  
                    
                    switch($this->gallery->recentPostsCaption)
                    {
	                    case "title":
	                		$item->description = $post->post_title;
	                		break;
	                	case "excerpt":
	                		$item->description = $post->post_excerpt;
	                		break;
	                	case "auto-excerpt":
	                		$item->description = $this->auto_excerpt($post, $this->gallery->recentPostsCaptionAutoExcerptLength, "...");
	                		break;
                    }

                 	if(empty($item->imagePath))
                 	{
	                 	$attr = wp_get_attachment_image_src( $post_thumbnail_id, $this->gallery->defaultPostImageSize);     
					 	$item->imagePath = $attr[0];
                 	}   
                    
                    if(empty($this->gallery->lightbox))
	                    $item->link = get_permalink($post->ID);
	                    	                
                    $this->images[] = $item;
				    //unset($post, $post_thumbnail_id);
                }
            }       
		}
		
		public function getImages() 
		{
			$images = $this->db->getImagesByGalleryId($this->id);
			$this->images = array();
			foreach($images as $image)
			{
				$image->source = "gallery";
				$image->attID = $image->imageId;
				$this->images[] = $image;
			}
			return $this->images;
		}
		
		public function getGallery() 
		{
			if($this->gallery == null) 
			{
				$this->gallery = $this->db->getGalleryById($this->id);

				$this->gallery->captionEffectDuration = $this->getdef($this->gallery->captionEffectDuration, 250);
				$this->gallery->captionEffect = $this->getdef($this->gallery->captionEffect, 'fade');
				$this->gallery->captionEasing = $this->getdef($this->gallery->captionEasing, 'easeInQuad');
				
				if(! empty($_GET["debug"]))
				{
					print "\n<!-- \n";
					print_r($this->gallery);
					print "\n -->\n";
				}
			}
			return $this->gallery;
		}
	}
}
?>