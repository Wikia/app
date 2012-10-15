<?php

class UploadAchievementsFromFile extends UploadFromFile {
	public function verifyUpload(){
		global $wgVerifyMimeType;
		
		//Avoid extension->mime mismatch since
		//we're forcing wathever image format to be saved as a PNG
		$origVerifyMimeTypeValue = $wgVerifyMimeType;
		$wgVerifyMimeType = false;
		
		parent::verifyUpload();
		
		$wgVerifyMimeType = $origVerifyMimeTypeValue;
	}
}