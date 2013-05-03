<?php
/**
 * Hax for backward compatibility for HubsV1
 * Remove it as fast as possible
 */
class WikiaHubsParserHelper {
	public function renderTag($input) {

		$app = F::app();
		wfProfileIn(__METHOD__);

		//get input data
		$data = $this->pullData($input);

		$popularVideos = new MarketingToolboxModulePopularvideosService(null, null, null);

		$returnString = $popularVideos->render($data);

		if( !empty($app->wgRTEParserEnabled) ) {
			//RTE extension
			// generate ID for HTML node
			$id = 'hubspopularvideos-' . self::$counter++;

			//render node
			$html = Xml::element(
				'div',
				array(
					 'id' => $id,
					 'class' => 'hubspopularvideos',
					 'data-message' => $input
				),
				trim($returnString)
			);

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

		$popularVideosModel = new MarketingToolboxPopularvideosModel();
		$toolboxModel = new MarketingToolboxModel();

		$data = [];

		$data['header'] = wfMessage('wikiahubs-popular-videos')->text();

		//use images passed inside <hubspopularvideos> tag
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

			$videoData = $toolboxModel->getVideoData($videoTitleText, $popularVideosModel->getVideoThumbSize());

			$data['videos'][] = array(
				'title' => $videoTitleText,
				'wikiUrl' => $wikiUrl,
				'thumbMarkup' => $videoData['videoThumb']
			);
		}

		wfProfileOut(__METHOD__);
		return $data;
	}
}