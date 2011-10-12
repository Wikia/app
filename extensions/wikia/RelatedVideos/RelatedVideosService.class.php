<?php

class RelatedVideosService {

	const memcKeyPrefix = 'RelatedVideosService';
	const width = 160;

	/**
	 * Get data for displaying and playing a Related Video
	 * @param int $articleId if provided, look up article by ID. Supercedes $title. Note: this forces a read from master DB, not slave.
	 * @param type $title if provided, look up article by text.
	 * @param string $source if video is on an external wiki, DB name of that wiki. Empty value indicates video is stored locally.
	 * @param int $videoWidth Width of resulting video player, in pixels
	 * @return Array 
	 */
	public function getRelatedVideoData( $articleId, $title, $source='', $videoWidth=VideoPage::DEFAULT_OASIS_VIDEO_WIDTH, $cityShort='life', $videoHeight='' ){

		wfProfileIn( __METHOD__ );
		$title = urldecode( $title );
		$result = $this->getFromCache( $title, $source, $videoWidth );
		if ( empty( $result ) ){
			Wikia::log( __METHOD__, 'RelatedVideos', 'Not from cache' );
			if ( !empty( $source ) ){
				$url = F::app()->wg->wikiaVideoRepoPath;
				if ( !empty( $url ) ){
					$url.='wikia.php?controller=RelatedVideos&method=getVideoData&width='.self::width.'&videoWidth='.$videoWidth.'&title='.urlencode($title).'&articleId='.$articleId.'&cityShort='.$cityShort.'&videoHeight='.$videoHeight.'&format=json';
				}
				$httpResponse = Http::post( $url );
				$result = json_decode( $httpResponse, true );
				$result['data']['external'] = 1;
			} else {
				$result = F::app()->sendRequest(
					'RelatedVideos',
					'getVideoData',
					array(
					    'width' => self::width,
					    'title' => $title,
					    'articleId' => $articleId,
					    'cityShort' => $cityShort,
					    'videoHeight' => $videoHeight
					)
				)->getData();
				$result['data']['external'] = 0;
			}
			$this->saveToCache( $title, $source, $videoWidth, $result );
		} else Wikia::log( __METHOD__, 'RelatedVideos', 'From cache' );

		wfProfileOut( __METHOD__ );
		return $result['data'];
	}

	public function getRelatedVideoDataFromTitle( $title, $source='', $videoWidth=VideoPage::DEFAULT_OASIS_VIDEO_WIDTH, $cityShort='life', $videoHeight='' ){

		return $this->getRelatedVideoData( 0, $title, $source, $videoWidth, $cityShort, $videoHeight );
	}

	public function getMemcKey( $title, $source, $videoWidth ) {

		if( empty( $source ) ){
			$video = Title::newFromText( $title, NS_VIDEO );
			if ($video instanceof Title && $video->exists() ) {
				return F::app()->wf->memcKey( $video->getArticleID(), F::app()->wg->wikiaVideoRepoDBName, $videoWidth, self::memcKeyPrefix );					
			}
			
			return '';
		} else {
			return F::app()->wf->sharedMemcKey( md5( $title ), F::app()->wg->wikiaVideoRepoDBName, $videoWidth, self::memcKeyPrefix );
		}
	}

	public function saveToCache( $title, $source, $videoWidth, $data ) {

		$oMemc = F::app()->wg->memc;
		$weekInSeconds = 604800;
		$oMemc->set(
			$this->getMemcKey( $title, $source, $videoWidth ),
			$data, 
			$weekInSeconds
		);
	}

	public function getFromCache( $title, $source, $videoWidth ) {

		$oMemc = F::app()->wg->memc;
		return $oMemc->get( $this->getMemcKey( $title, $source, $videoWidth ) );
	}

	public function isTitleRelatedVideos($title) {
		if (!($title instanceof Title)) {
			return false;
		}
		if (defined('NS_RELATED_VIDEOS') && $title->getNamespace() == NS_RELATED_VIDEOS ) {
			return true;
		}
		return false;
	}

	public function editWikiActivityParams($title, $res, $item){
		if ( $this->isTitleRelatedVideos( $title ) ){
			$oTitle =  Title::newFromText( $title->getText(), NS_MAIN );
			$item['title'] = $oTitle->getText();
			$item['url'] = $oTitle->getLocalUrl();
			$item['relatedVideos'] = true;
			$item['relatedVideosDescription'] = isset( $res['comment'] ) ? $res['comment'] : '';
		}
		return $item;
		
	}

	public function createWikiActivityParams($title, $res, $item){
		if ( $this->isTitleRelatedVideos( $title ) ){
			$oTitle =  Title::newFromText( $title->getText(), NS_MAIN );
			$item['title'] = $oTitle->getText();
			$item['url'] = $oTitle->getLocalUrl();
			$item['relatedVideos'] = true;
			$item['relatedVideosDescription'] = isset( $res['comment'] ) ? $res['comment'] : '';
		}
		return $item;	
	}

	private function parseSummary( $text ){
		$app = F::app();
		// empty title is requred for parsing, otherwise it will not work.
		// cannot use wfMsgExt due to FogBugzId:12901
		return $app->wg->parser->parse(
			$text,
			$app->wg->title,
			F::build('ParserOptions'),
			false
		)->getText();
	}

	public function formatRelatedVideosRow( $text ){

		$html = Xml::openElement('tr');
		$html .= Xml::openElement('td');
		$html .= $this->parseSummary( $text );
		$html .= Xml::closeElement('td');
		$html .= Xml::closeElement('tr');
		return $html;
	}
}