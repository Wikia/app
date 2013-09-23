<?php 
class RelatedVideosRailController extends WikiaController {
	const RELATED_VIDEOS_SCSS_PACKAGE_NAME = 'relatedvideos_scss';
	const RELATED_VIDEOS_JS_PACKAGE_NAME = 'relatedvideos_js';

	static $usersData = array();
	static $anonsData = array();
	
	public function executeIndex() {
		$this->response->addAsset( self::RELATED_VIDEOS_SCSS_PACKAGE_NAME );
		$this->response->addAsset( self::RELATED_VIDEOS_JS_PACKAGE_NAME );
	}

}
