<?php 
class RelatedVideosRailController extends WikiaController {
	static $usersData = array();
	static $anonsData = array();
	
	public function executeIndex() {
		$app = F::App();
		$app->wf->ProfileIn(__METHOD__);
		
		#var_dump($rvc->videos);
		
		#$this->realResponse->addAsset('extensions/wikia/Wall/css/WallHistoryRail.scss');
		
		$app->wf->ProfileOut(__METHOD__);
	}
	
}
