<?php 
class RelatedHubsVideosController extends RelatedVideosController {
	const MEMC_KEY_VER = '1.2';
	
	public function __construct() {
		$app = F::app();
		parent::__construct($app);
	}
	
	public function getCarusel() {
		if( Wikia::isMainPage() || ( !$this->app->wg->title instanceof Title ) || !$this->app->wg->title->exists() ) {
			return false;
		}
		
		$data = $this->getVal('data', null);
		$videos = array();
		if( !empty($data) ) {
			foreach($data as $hubVideoData) {
				$videoTitleTxt = $hubVideoData['videoTitleText'];
				$videoUsername = $hubVideoData['username'];
				$memcKey = $this->getMemcHubsVideoKey($videoTitleTxt, $videoUsername);
				$videoData = $this->getMemcHubsVideoData($memcKey);
				
				if( empty($videoData) ) {
					Wikia::log( __METHOD__, 'Not from cache' );
					$videoTitle = Title::newFromText($videoTitleTxt, NS_VIDEO);

					if( $videoTitle instanceof Title ) {
						$videoArticleId = $videoTitle->getArticleID();

						$result = F::app()->sendRequest(
							'RelatedVideos',
							'getVideoData',
							array(
								'width'		=> 160,
								'title'		=> $videoTitle,
								'articleId'	=> $videoArticleId,
							)
						)->getData();
						$result['data']['external'] = 0;
						$result['data']['wiki'] = (
								(stripos($hubVideoData['wikiUrl'],'http://') === false)
								&& (stripos($hubVideoData['wikiUrl'],'https://') === false)								 
							)?('http://'.$hubVideoData['wikiUrl']):$hubVideoData['wikiUrl'];
						
						//overwrite owner's data (on Hub page we display name of user who suggested the video)
						if( !empty($result['data']['owner'])
						 && !empty($result['data']['ownerUrl'])
						 && $result['data']['owner'] !== $videoUsername
						) {
							$userSuggested = F::build('User', array($videoUsername), 'newFromName');
							if( $userSuggested instanceof User ) {
								$result['data']['owner'] = $userSuggested->getName();
								$result['data']['ownerUrl'] = $userSuggested->getUserPage()->getFullUrl();
							}
						}
						
						if( !isset( $result['data']['error']) && !empty($result['data']) ) {
							$videoData = $result['data'];
							$this->setMemcHubsVideoData($memcKey, $videoData);
							$videos[] = $videoData;
						}
					}
				} else {
					$videos[] = $videoData;
				}
			}
		}
		
		$this->setVal('videos', $videos);
	}
	
	public function getVideoHtml() {
		parent::getVideoHtml();
		
		$wikiLink = $this->getVal('wikiLink');
		$this->setVal('wikiLink', $wikiLink);
	}
	
	protected function getMemcHubsVideoKey($videoTitleTxt, $videoUsername) {
		$videoTitleTxt = urlencode($videoTitleTxt);
		$videoUsername = urlencode($videoUsername);
		return F::app()->wf->memcKey($videoTitleTxt, $videoUsername, self::MEMC_KEY_VER);
	}
	
	protected function getMemcHubsVideoData($memcKey) {
		return F::app()->wg->memc->get($memcKey);
	}
	
	protected function setMemcHubsVideoData($memcKey, $data) {
		F::app()->wg->memc->set($memcKey, $data);
	}
	
}