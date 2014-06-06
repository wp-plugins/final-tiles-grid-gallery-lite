<?php

function set_utf8()
{
	global $wpdb;
	
	$FinalTilesImages = $wpdb->FinalTilesImages;
	
	$sql1 = "ALTER TABLE  $FinalTilesImages DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
	$sql2 = "ALTER TABLE  $FinalTilesImages CHANGE  `description`  `description` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL";
	
	$wpdb->query($sql1);	
	$wpdb->query($sql2);	
}

function install_db() 
{
  global $wpdb;			  

  $FinalTilesGalleries = $wpdb->FinalTilesGalleries;
  $FinalTilesImages = $wpdb->FinalTilesImages;
  
  
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		
  $sql = "CREATE TABLE $FinalTilesGalleries (
	 	Id INT NOT NULL AUTO_INCREMENT, 		
        configuration VARCHAR( 5000 ) NULL,
        UNIQUE KEY id (id)
  ) DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;";
	
  dbDelta( $sql );

  $sql = "CREATE TABLE $FinalTilesImages (
		Id INT NOT NULL AUTO_INCREMENT, 
		gid INT NOT NULL, 
		imageId INT NOT NULL, 
		imagePath LONGTEXT NOT NULL, 
        filters VARCHAR( 1500 ) NULL,
        link LONGTEXT NULL,
        target VARCHAR(50) NULL,
        blank ENUM('T','F') DEFAULT \"F\" NOT NULL, 
		description LONGTEXT NOT NULL, 
		sortOrder INT NOT NULL,     
		UNIQUE KEY id (Id) 
	) DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci";

	dbDelta( $sql );
  
}
