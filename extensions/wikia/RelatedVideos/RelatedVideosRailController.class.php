<?php 
class RelatedVideosRailController extends WikiaController {
	static $usersData = array();
	static $anonsData = array();
	
	public function executeIndex() {
		$app = F::App();
		wfProfileIn(__METHOD__);
		
		#var_dump($rvc->videos);
		
		#$this->realResponse->addAsset('extensions/wikia/Wall/css/WallHistoryRail.scss');

		wfProfileOut(__METHOD__);
	}
	
}
