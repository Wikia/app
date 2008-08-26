<?php

class ProfilePhoto{

	const AVATAR_DIR_NAME = "avatars";
	var $album_name = "Profile Photos";
	static $photo_version = "007";
	
	var $aDefaultImages = array(
	"l" => "default_l.png",
	"m" => "default_m.png",
	"s" => "default_s.png",
	"g" => "default_g.png",
	"p" => "default_p.png",
	"t" => "default_t.png",
	);
	
	#--- constructor
	public function __construct($user_id){
		$this->user_id = $user_id;
		$this->mUser = User::newFromId($user_id);
		if (is_object( $this->mUser ) && !is_null( $this->mUser )) {
		    $this->mUser->load();
		}
	}
	
	public function getProfileImageURL( $size = "t" ){
		global $wgUser, $wgDBname, $wgProfilePhotoPath, $wgProfilePhotoUploadPath;
		
		$photo_id = self::getCurrentProfilePhotoID();
		if( $photo_id > 0 ){
			$sImage = self::getPhotoFile($this->user_id, $photo_id,$size);
			$sImageFull = self::getPhotoFileFull($this->user_id, $photo_id,$size);
		}else{
			$sImage =  $this->aDefaultImages[$size];
		}
		
		return $wgProfilePhotoPath."/".$sImage . "?=" . rand();
	}

	/**
	* return whole <img...> tag
	*/
	public function getPhotoImageTag($size = "l"){
		$sPath = self::getProfileImageURL($size);
		$aSize = self::getPhotoSize($size);
		return sprintf("<img src=\"%s\" border=\"0\" alt=\"[Avatar]\" />",
		    $sPath, $aSize["width"], $aSize["height"] );
	}
    
	static public function getPhotoFile($mUserID, $photo_id, $size){
	    
		$sImage = "{$mUserID}-{$photo_id}x{$size}.jpg";
		$sHash = sha1("{$mUserID}");
		$sDir = substr($sHash, 0, 1)."/".substr($sHash, 0, 2);
		return "{$sDir}/{$sImage}";
	}
	
	static public function getPhotoFileFull($mUserID, $photo_id, $size){
		global $wgProfilePhotoUploadPath;
		return $wgProfilePhotoUploadPath."/".self::getPhotoFile($mUserID, $photo_id, $size);
	}
		
	static public function getPhotoSize($size="l"){
		$aDefaultSizes = array(
		    "l" => array( "width" => 75, "height" => 75 ),
		    "m" => array( "width" => 50, "height" => 30 ),
		    "s" => array( "width" => 25, "height" => 16 ),
		    "d" => array( "width" => 700, "height" => 16 ),
		    "g" => array( "width" => 150, "height" => 16 ),
		    "p" => array( "width" => 250, "height" => 16 ),
		    "t" => array( "width" => 100, "height" => 16 ),
		);
		
		$sizes = $aDefaultSizes[$size];
		if( !$sizes ){
			return $aDefaultSizes["l"];
		}else{
			return $sizes;
		}
	}
    
	public function getProfileAlbumID(){
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`user_photo_album`', 
				array( 'photo_album_id' ),
				array( 'photo_album_user_id' =>  $this->user_id , 'photo_album_name' => $this->album_name )
				, __METHOD__, 
				""
		);	
		if( $s->photo_album_id > 0 ){
			return $s->photo_album_id;
		}else{
			return $this->addProfileAlbum();
		}
		
		return false;
	}
	
	public function addProfileAlbum(){
		$dbr =& wfGetDB( DB_MASTER );
		
		$dbr->insert( '`user_photo_album`',
			array(
				'photo_album_user_id' => $this->user_id,
				'photo_album_name' => $this->album_name,
				'photo_album_created' => date("Y-m-d H:i:s"),
				'photo_album_updated' => date("Y-m-d H:i:s"),	

			), __METHOD__
		);
		//$dbr->commit();
		return $dbr->insertId();
	}
	
	public function addPhoto(){
		global $wgUser;
		
		$photo_album_id = $this->getProfileAlbumID();
		
		$dbr =& wfGetDB( DB_MASTER );
		$dbr->insert( '`user_photo`',
			array(
				'photo_album_id' => $photo_album_id,
				'photo_user_id' => $this->user_id,
				'photo_created' => date("Y-m-d H:i:s"),
				'photo_updated' => date("Y-m-d H:i:s"),			
			), __METHOD__
		);
		
		$new_photo_id = $dbr->insertId();
		//$dbr->commit();
		$this->updateAlbumCover( $photo_album_id, $new_photo_id );
		
		$b = new UserBulletin();
		$b->addBulletin($wgUser->getName(),"profile photo","" );
			
		return $new_photo_id;
		
	}
	
	public function removePhoto(){
		$photo_album_id = $this->getProfileAlbumID();
		
		$this->updateAlbumCover( $photo_album_id, 0 );
		
		//clear cache?
	}
	
	public function updateAlbumCover( $photo_album_id, $photo_id ){
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->update( 'user_photo_album',
			array( 'photo_album_cover_photo_id' => $photo_id, 'photo_album_updated' => date("Y-m-d H:i:s") ),
			array( 'photo_album_id' => $photo_album_id ),
		__METHOD__ );
		$dbw->commit();
		
		global $wgMemc;
		$key = wfMemcKey( 'user', 'profile', 'photo_id', self::$photo_version, $this->user_id );
		$data = $wgMemc->delete( $key );
		
		return true;
	}
	
	public function getCurrentProfilePhotoID(){
		global $wgMemc;
		$key = wfMemcKey( 'user', 'profile', 'photo_id', self::$photo_version, $this->user_id );
		$data = $wgMemc->get( $key );
		
		if( $data != "" ){
			return $data;
		}else{
			$dbr =& wfGetDB( DB_MASTER );
			$s = $dbr->selectRow( '`user_photo_album`', 
					array( 'photo_album_cover_photo_id' ),
					array( 'photo_album_user_id' =>  $this->user_id , 'photo_album_name' => $this->album_name )
					, __METHOD__, 
					""
			);
			
			if( $s->photo_album_cover_photo_id > 0){
				$photo_id = $s->photo_album_cover_photo_id;
			}else{
				$photo_id = 0;
			}
			
			$wgMemc->set( $key, $photo_id );
			return $photo_id;
		}
	}
    
}
?>