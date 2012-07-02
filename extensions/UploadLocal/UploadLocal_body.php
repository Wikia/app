<?php

class UploadLocal extends SpecialPage {
	function __construct() {
		parent::__construct( 'UploadLocal',  'uploadlocal' );
	}

	function execute( $par ) {
		global $wgRequest, $wgUploadLocalDirectory, $wgMessageCache;
		
		$prefix = 'extensions/UploadLocal/';
		require($prefix . 'UploadLocalDirectory.php');
		require($prefix . 'UploadLocalForm.php');
		
		$directory = new UploadLocalDirectory($wgRequest, $wgUploadLocalDirectory);
		$directory->execute();
	}
}
