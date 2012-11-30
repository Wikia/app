<?php
/**
 * WikiaHubsPopularVideosHook
 *
 * @author Sebastian Marzjan
 *
 */

class WikiaHubsPopularVideos {
	private static $counter = 1;
	protected $data = array();

	/**
	 * @brief This function set renderTag hook
	 * @param Parser parser
	 * @return true
	 */
	public function onParserFirstCallInit( Parser $parser ) {
		wfProfileIn(__METHOD__);

		$parser->setHook('hubspopularvideos', array($this, 'renderTag'));

		wfProfileOut(__METHOD__);
		return true;
	}

	public function renderTag($input, $params) {
		$app = F::app();
		wfProfileIn(__METHOD__);
		
		//get input data
		$this->pullData($input);

		$returnString = (string) $app->sendRequest(
			'RelatedHubsVideos',
			'getCarusel',
			array(
				'data' => $this->data,
			)
		);
		
		if( !empty($app->wgRTEParserEnabled) ) {
			//RTE extension
			// generate ID for HTML node
			$id = 'hubspopularvideos-' . self::$counter++;
			
			//render node
			$html = F::build('Xml', array('div', array(
					'id' => $id,
					'class' => 'hubspopularvideos',
					'data-message' => $input,
			), trim($returnString)), 'element');
			
			$res = $html;
		} else {
			//page-view html
			$res = '<nowiki>'.trim($returnString).'</nowiki>';
		}
		wfProfileOut(__METHOD__);
		return $res;
	}
	
	/**
	 * @desc Parse data from <hubspopularvideos /> tag
	 * 
	 * @param String $input data within <hubspopularvideos /> tag
	 */
	protected function pullData($input) {
		wfProfileIn(__METHOD__);
		
		//use images passed inside <gallery> tag
		$lines = StringUtils::explode("\n", $input);
		
		foreach($lines as $line) {
			if( $line == '' ) {
				continue;
			}
			
			//title|user|||wikiurl
			$parts = (array) StringUtils::explode('|', $line);
			$videoTitleText = !empty($parts[0]) ? $parts[0] : null;
			$username = !empty($parts[1]) ? $parts[1] : null;
			$wikiUrl = !empty($parts[4]) ? $parts[4] : null;
			
			if( in_array(true, array(is_null($videoTitleText), is_null($username), is_null($wikiUrl))) ) {
			//we want all data given
				continue;
			}
			
			$this->data[] = array(
				'videoTitleText' => $videoTitleText,
				'username' => $username,
				'wikiUrl' => $wikiUrl,
			);
		}
		
		wfProfileOut(__METHOD__);
	}
	

}

/**
 * WikiaHubs Mobile
 */
class WikiaHubsMobile {	
	public static function onWikiaMobileAssetsPackages( Array &$jsHeadPackages, Array &$jsBodyPackages, Array &$scssPackages ) {
		//this hook is fired only by the WikiaMobile skin, no need to check for what skin is being used
		if ( F::app()->wg->EnableWikiaHubsExt && WikiaPageType::isWikiaHub() ) {
			$scssPackages[] = 'wikiahubs_scss_wikiamobile';
		}

		return true;
	}
}