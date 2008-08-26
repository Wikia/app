<?php

class wAvatar{

	var $user_name = NULL;
	var $user_id;
	var $avatar_type = 0;
	
	function wAvatar($userid,$size){
		$this->user_id = $userid;
		$this->avatar_size = $size;
	}
	
	
	function getAvatarImage(){
		global $wgUser, $wgDBname, $wgUploadDirectory, $wgMemc;
		
		$key = wfMemcKey( 'user', 'profile', 'avatar', $this->user_id, $this->avatar_size );
		$data = $wgMemc->get( $key );
		
		if( $data ){
			//wfDebug("loaded avatar filename from cache\n");
			$avatar_filename = $data;
		}else{
			$files = glob($wgUploadDirectory . "/avatars/" . $wgDBname . "_" . $this->user_id .  "_" . $this->avatar_size . "*");
			if( !empty( $files[0] ) ) {
				$avatar_filename  = basename($files[0]) . "?" . filemtime($files[0]);
			}else{
				$avatar_filename  = "default" . "_" . $this->avatar_size . ".gif";
			}
			$wgMemc->set($key, $avatar_filename);
		}
		return $avatar_filename ;
	}
	
	function getAvatarURL(){
		global $wgUploadPath;
		return "<img src=\"{$wgUploadPath}/avatars/{$this->getAvatarImage()}\" alt=\"avatar\" border=\"0\" />";
	}
}
?>
