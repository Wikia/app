<?php

class RelatedVideosService {

	const memcKeyPrefix = 'RelatedVideosService';
	const memcVersion = 20;
	static public $width = 160;
	static public $height = 90;
	const howLongVideoIsNew = 3;

	/**
	 * Get data for displaying and playing a Related Video
	 * @param int $articleId if provided, look up article by ID. Supercedes $title. Note: this forces a read from master DB, not slave.
	 * @param type $title if provided, look up article by text.
	 * @param string $source if video is on an external wiki, DB name of that wiki. Empty value indicates video is stored locally.
	 * @param int $videoWidth Width of resulting video player, in pixels
	 * @return Array
	 */
	public function getRelatedVideoData( $params, $videoWidth = RelatedVideosData::DEFAULT_OASIS_VIDEO_WIDTH, $cityShort='life', $useMaster=0, $videoHeight='', $useJWPlayer=true, $autoplay=true, $inAjaxResponse=false ){

		$titleText = isset( $params['title'] ) ? $params['title'] : '';
		$articleId = isset( $params['articleId'] ) ? $params['articleId'] : 0;
		$source = isset( $params['source'] ) ? $params['source'] : '';

		wfProfileIn( __METHOD__ );
		$titleText = urldecode( $titleText );
		$result = $this->getFromCache( $titleText, $source, $videoWidth, $cityShort );
		if ( empty( $result ) ){
			Wikia::log( __METHOD__, 'RelatedVideos', 'Not from cache' );
			$result = array();
			$rvd = new RelatedVideosData();
			$result['data'] = $rvd->getVideoData(
				$titleText,
				self::$width,
				$videoWidth,
				$articleId,
				$autoplay,
				$useMaster,
				$cityShort,
				$videoHeight,
				$useJWPlayer,
				$inAjaxResponse
			);

			if ( isset( $result['data']['error']) ){
				wfProfileOut( __METHOD__ );
				return array();
			}

			// just to be sure and to be able to work cross devbox.
			if ( !isset( $result['data']['uniqueId'] ) ) {
				wfProfileOut( __METHOD__ );
				return array();
			}

			$this->saveToCache( $titleText, $source, $videoWidth, $cityShort, $result );
		} else {
			Wikia::log( __METHOD__, 'RelatedVideos', 'From cache' );
		}

		// add local data
		$result['data'] = $this->extendVideoByLocalParams( $result['data'], $params );
		wfProfileOut( __METHOD__ );
		return $result['data'];
	}

	public function getRelatedVideoDataFromMaster( $params, $videoWidth=RelatedVideosData::DEFAULT_OASIS_VIDEO_WIDTH, $cityShort='life', $videoHeight='' ){

		return $this->getRelatedVideoData( $params, $videoWidth, $cityShort, 1, $videoHeight );
	}

	public function getRelatedVideoDataFromTitle( $params, $videoWidth=RelatedVideosData::DEFAULT_OASIS_VIDEO_WIDTH, $cityShort='life', $videoHeight='' ){

		$params['articleId'] = 0;
		return $this->getRelatedVideoData( $params, $videoWidth, $cityShort, 0, $videoHeight );
	}


	/**
	 * Prefetch data from memcached for given pages
	 *
	 * @author Władysław Bodzek
	 * @param $pages array
	 */
	protected function prefetchDataFor( $pages, $videoWidth = RelatedVideosData::DEFAULT_OASIS_VIDEO_WIDTH, $cityShort='life' ) {
		global $wgMemc;
		wfProfileIn(__METHOD__);

		if ( empty( $pages ) ) {
			wfProfileOut(__METHOD__);
			return;
		}

		$keys = array();
		foreach ( $pages as $params ) {
			$titleText = isset( $params['title'] ) ? $params['title'] : '';
			$source = isset( $params['source'] ) ? $params['source'] : '';
			$keys[] = $this->getMemcKey( $titleText, $source, $videoWidth, $cityShort );
		}

		$keys = array_unique($keys);
		$wgMemc->prefetch( $keys );

		wfProfileOut(__METHOD__);
	}

	private function extendVideoByLocalParams( $videoData, $localParams ){

		if ( isset( $localParams['isNewDate'] ) && !empty( $localParams['isNewDate'] ) ){
			$newDate = date( 'YmdHis', mktime( 0, 0, 0, date( 'm' ), date( 'd' ) - self::howLongVideoIsNew, date( 'Y' ) ) );
			$videoData['isNew'] = ( (int)$localParams['isNewDate'] > $newDate ) ? 1 : 0;
		} else {
			$videoData['isNew'] = 0;
		}

		$videoData['date'] = isset( $localParams['date'] ) ? $localParams['date'] : $videoData['timestamp'];

		if ( isset( $localParams['userName'] ) && !empty( $localParams['userName'] ) ){
			$oUser = User::newFromName( $localParams['userName'] );
			if ( is_object( $oUser ) ) {
				$oUser->load();
			}
			if ( is_object( $oUser ) && ( $oUser->getID() > 0 ) ) {
				$videoData['externalByUser'] = 1;
				$videoData['owner'] = $oUser->getName();
				$videoData['ownerUrl'] = $oUser->getUserPage()->getFullURL();
			}
		}
		return $videoData;
	}

	public function getMemcKey( $title, $source, $videoWidth, $cityShort ) {
		$isStagingServer = Wikia::isStagingServer();
		$StagingServerSuffix = empty($isStagingServer)?'PRODUCTION':'STAGING';

		return wfMemcKey( md5( $title ), F::app()->wg->wikiaVideoRepoDBName, $videoWidth, self::memcKeyPrefix, self::memcVersion, self::$width, $StagingServerSuffix );
	}

	public function saveToCache( $title, $source, $videoWidth, $cityShort, $data ) {
		$oMemc = F::app()->wg->memc;
		$weekInSeconds = 604800;
		$oMemc->set(
			$this->getMemcKey( $title, $source, $videoWidth, $cityShort ),
			$data,
			$weekInSeconds
		);
	}

	public function getFromCache( $title, $source, $videoWidth, $cityShort ) {

		$oMemc = F::app()->wg->memc;
		return $oMemc->get( $this->getMemcKey( $title, $source, $videoWidth, $cityShort ) );
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
			(new ParserOptions),
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

	public function sortByDate( $a, $b ){

		return strnatcmp( $a['date'], $b['date'] );
	}

	public function getRVforArticleId ( $articleId  ) {
		$title = Title::newFromID( $articleId );

		$videos = array();

		$oEmbededVideosLists = RelatedVideosEmbededData::newFromTitle( $title );
		$oGlobalLists = RelatedVideosNamespaceData::newFromGeneralMessage();

		// experimental - begin - @author: wladek - prefetch data from memcached
		// todo: verify results
		global $wgEnableMemcachedBulkMode;
		if ( !empty( $wgEnableMemcachedBulkMode ) ) {
			$pages = array();
			foreach( array( $oGlobalLists, $oEmbededVideosLists ) as $oLists ) {
				if ( !empty( $oLists ) && $oLists->exists() ){
					$data = $oLists->getData();
					if ( isset(  $data['lists'] ) && isset( $data['lists']['WHITELIST'] ) ) {
						foreach( $data['lists']['WHITELIST'] as $page ){
							$pages[] = $page;
						}
						foreach( $data['lists']['BLACKLIST'] as $page ){
							$pages[] = $page;
						}
					}
				}
			}
			$this->prefetchDataFor($pages);
		}
		// experimental - end

		$blacklist = array();
		foreach( array( $oGlobalLists, $oEmbededVideosLists ) as $oLists ) {
			if ( !empty( $oLists ) && $oLists->exists() ){
				$data = $oLists->getData();
				if ( isset(  $data['lists'] ) && isset( $data['lists']['WHITELIST'] ) ) {
					foreach( $data['lists']['WHITELIST'] as $page ){
						$videoData = $this->getRelatedVideoData( $page );
						if ( isset( $videoData['uniqueId'] ) ) {
							$videos[$videoData['uniqueId']] = $videoData;
						}
					}
					foreach( $data['lists']['BLACKLIST'] as $page ){
						$videoData = $this->getRelatedVideoData( $page );
						if ( isset( $videoData['uniqueId'] ) )
							$blacklist[$videoData['uniqueId']] = $videoData;
					}
				}
			}
		}

		foreach( $blacklist as $key => $blElement ){
			unset( $videos[ $key ] );
		}

		//uasort( $videos, array( $this, 'sortByDate') );
		//return array_reverse( $videos, true );

		// some magic to preserve keys (shuffle does not preserve them)
		$keys = array_keys( $videos );
		shuffle( $keys );
		return array_merge( array_flip( $keys ) , $videos );
	}

}
