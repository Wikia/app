<?php 
class RelatedVideosRailController extends WikiaController {
	static $usersData = array();
	static $anonsData = array();
	
	public function executeIndex() {
		$app = F::App();
		$app->wf->ProfileIn(__METHOD__);
		
		#var_dump($rvc->videos);
		
		#$this->realResponse->addAsset('extensions/wikia/Wall/css/WallHistoryRail.scss');
		
		$this->surveyLink = $this->wg->LanguageCode == 'en' ? $this->app->renderView('VideosController', 'videoSurvey') : ''; // temporary video survey code bugid-68723
		
		$app->wf->ProfileOut(__METHOD__);
	}
	
}
