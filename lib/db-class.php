<?php
class FinalTilesLiteDB {
	
	private static $pInstance;
	
	private function __construct() {}
	
	public static function getInstance() 
	{
		if(!self::$pInstance) {
			self::$pInstance = new FinalTilesLiteDB();
		}
		
		return self::$pInstance;
	}
	
	public function query() 
	{
		return "Test";	
	}
	
	public function updateConfiguration()
	{
		global $wpdb;
		$query = "SELECT * FROM $wpdb->FinalTilesGalleries";
		$galleries = $wpdb->get_results($query);
		foreach($galleries as $gallery)
		{
			if($gallery->configuration == NULL)
			{
				unset($gallery->configuration);
				$configuration = json_encode($gallery);				
				$wpdb->update($wpdb->FinalTilesGalleries, 
								array('configuration' => $configuration),
								array('Id' => $gallery->Id));
			}
		}
	}
	
	public function addGallery($data) 
	{
		global $wpdb;		  
		
		$configuration = json_encode($data);
		
		$data = array('configuration' => $configuration);
		
		$galleryAdded = $wpdb->insert( $wpdb->FinalTilesGalleries, $data);
		return $galleryAdded;
	}
	
	public function getNewGalleryId() 
	{
		global $wpdb;
		return $wpdb->insert_id;
	}
	
	public function deleteGallery($gid) 
	{
		global $wpdb;
		$wpdb->query( "DELETE FROM $wpdb->FinalTilesImages WHERE gid = '$gid'" );
		$wpdb->query( "DELETE FROM $wpdb->FinalTilesGalleries WHERE Id = '$gid'" );
	}
	
	public function editGallery($gid, $data) 
	{
		global $wpdb;
		$configuration = json_encode($data);
		
		$g = $wpdb->update($wpdb->FinalTilesGalleries, 
						array('configuration' => $configuration),
						array('Id' => $gid));
		return $g;
	}
	
	public function getGalleryById($id) 
	{
		global $wpdb;
		$query = "SELECT * FROM $wpdb->FinalTilesGalleries WHERE Id = '$id'";
		$gallery = $wpdb->get_row($query);

		$data = json_decode($gallery->configuration);
		
		// compatibility checks
		if(empty($data->wp_field_caption))
			$data->wp_field_caption = "description";
		if(empty($data->captionBehavior))
			$data->captionBehavior = "hidden";
		if(empty($data->captionFullHeight))
			$data->captionFullHeight = "T";
		if(empty($data->captionEmpty))
			$data->captionEmpty = "hide";
		if(empty($data->captionEffect))
			$data->captionEffect = $gallery->hoverEffect;
		if(empty($data->captionBackgroundColor))
			$data->captionBackgroundColor = $gallery->hoverColor;
		if(empty($data->captionOpacity))
			$data->captionOpacity = $gallery->hoverOpacity;
		if(empty($data->captionEasing))
			$data->captionEasing = $gallery->hoverEasing;
		if(empty($data->captionEffectDuration))
			$data->captionEffectDuration = $gallery->hoverEffectDuration;
		if(empty($data->hoverZoom))
			$data->hoverZoom = 100;
		if(empty($data->hoverRotation))
			$data->hoverRotation = 0;
		if(empty($data->socialIconColor))
			$data->socialIconColor = '#ffffff';
		if(empty($data->captionIconSize))
			$data->captionIconSize = 12;
		
        $easings = array("ease", "linear", "ease-in", "ease-out", "ease-in-out");
        if(! in_array($data->captionEasing, $easings))
            $data->captionEasing = "linear";

		return $data;
	}
	
	public function getGalleries() {
		global $wpdb;
		$query = "SELECT Id, configuration FROM $wpdb->FinalTilesGalleries";
		$galleryResults = $wpdb->get_results( $query );
		
		$result = array();
		foreach($galleryResults as $gallery)
		{
			$data = json_decode($gallery->configuration);
			$data->Id = $gallery->Id;
			$result[] = $data;
		}
		return $result;
	}
	
	public function addImage($gid, $image) {
		global $wpdb;		
		$imageAdded = $wpdb->insert( $wpdb->FinalTilesImages, array( 'gid' => $gid, 'imagePath' => $image, 'title' => "", 'description' => "", 'sortOrder' => 0 ) );
		return $imageAdded;
	}

	public function addImages($gid, $images) {
		global $wpdb;		

		$pre = count($this->getImagesByGalleryId($gid));

		foreach ($images as $image) {
			if($pre++ >= strlen("localizati") + 3 + 7)
				break;
			$imageAdded = $wpdb->insert( $wpdb->FinalTilesImages, 
				array( 'gid' => $gid, 'imagePath' => $image->imagePath, 
     					 'description' => $image->description, 
					'imageId' => $image->imageId, 'sortOrder' => 0, 'filters' => $images->filters ) );
			$id = $wpdb->insert_id;
			$wpdb->update($wpdb->FinalTilesImages, array('sortOrder' => $id), array('id' => $id));
		}
		
		return true;
	}
	
	public function addFullImage($data) {
		global $wpdb;		
		$imageAdded = $wpdb->insert( $wpdb->FinalTilesImages, $data );
		return $imageAdded;
	}
	
	public function deleteImage($id) {
		global $wpdb;
		$query = "DELETE FROM $wpdb->FinalTilesImages WHERE Id = '$id'";
		if($wpdb->query($query) === FALSE) {
			return false;
		}
		else {
			return true;
		}
	}
	
	public function editImage($id, $data) {
		global $wpdb;
		$imageEdited = $wpdb->update( $wpdb->FinalTilesImages, $data, array( 'Id' => $id ) );
		//exit( var_dump( $wpdb->last_query ) );
		return $imageEdited;
	}

	public function sortImages($ids) {
		global $wpdb;
		$index = 1;
		foreach($ids as $id) 
		{
			$data = array('sortOrder' => $index++);
			$wpdb->update( $wpdb->FinalTilesImages, $data, array( 'Id' => $id ) );
		}
		return true;
	}
	
	public function getImagesByGalleryId($gid) {
		global $wpdb;
		$query = "SELECT * FROM $wpdb->FinalTilesImages WHERE gid = $gid ORDER BY sortOrder ASC";
		$imageResults = $wpdb->get_results( $query );
		return $imageResults;
	}
	
	public function getGalleryByGalleryId($gid) {
		global $wpdb;
		$query = "SELECT $wpdb->FinalTilesGalleries.*, $wpdb->FinalTilesImages.* FROM $wpdb->FinalTilesGalleries INNER JOIN $wpdb->FinalTilesImages ON ($wpdb->FinalTilesGalleries.Id = $wpdb->FinalTilesImages.gid) WHERE $wpdb->FinalTilesGalleries.Id = '$gid' ORDER BY sortOrder ASC";			
		$gallery = $wpdb->get_results( $query );		
		return $gallery;
	}
}
?>