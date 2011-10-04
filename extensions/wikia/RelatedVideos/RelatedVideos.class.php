<?php

class RelatedVideos extends RelatedPages {

	protected $memcKeyPrefix = 'RelatedVideos';
	protected $width = 160;
	static protected $videoInstance = null;

	protected function getPageJoinSql( $dbr, &$tables ) {

		wfProfileIn( __METHOD__ );
		$joinSql = array( "page" =>
			array(
				"JOIN",
				implode(
					" AND ",
					array(
						"page_id = cl_from",
						"page_namespace = " . NS_VIDEO
					)
				)
			)
		);
		$tables[] = "page";
		wfProfileOut( __METHOD__ );
		return $joinSql;
	}

	protected function afterGet( $pages, $limit ) {

		wfProfileIn( __METHOD__ );
		$this->pages = array();
		$oRelatedVideosData =  F::build( 'RelatedVideosData' );
		foreach( $pages as $pageId => $data ) {
			$oTitle = F::build( 'Title', array( $data['title'] ), 'newFromText' );
			$videoData = $oRelatedVideosData->getVideoData( $oTitle, $this->width );
			if ( isset($videoData['timestamp']) && isset($videoData['id']) ){
				$videoId = $videoData['timestamp'].'|'.$videoData['id'];
				$this->pages[ $videoId ] = $videoData;
				if ( count( $this->pages ) >= $limit) {
					break;
				}
			}
		}

		$oLocalLists = RelatedVideosNamespaceData::newFromTargetTitle( F::app()->wg->title );
		$oGlobalLists = RelatedVideosNamespaceData::newFromGeneralMessage();
		
		$oRelatedVideosService = F::build('RelatedVideosService');
		$blacklist = array();
		foreach( array( $oLocalLists, $oGlobalLists ) as $oLists ){
			if ( !empty( $oLists ) && $oLists->exists() ){
				$data = $oLists->getData();
				if ( isset(  $data['lists'] ) && isset( $data['lists']['WHITELIST'] ) ) {
					foreach( $data['lists']['WHITELIST'] as $page ){
						$videoData = $oRelatedVideosService->getRelatedVideoData( 0, $page['title'], $page['source'] );
						if ( isset( $videoData['timestamp'] ) && isset( $videoData['id'] ) ){
							$videoId = $videoData['timestamp'].'|'.$videoData['id'];
							$this->pages[ $videoId ] = $videoData;
						}
					}
					foreach( $data['lists']['BLACKLIST'] as $page ){
						$videoData = $oRelatedVideosService->getRelatedVideoData( 0, $page['title'], $page['source'] );
						if ( isset( $videoData['timestamp'] ) && isset( $videoData['id'] ) ){
							$videoId = $videoData['timestamp'].'|'.$videoData['id'];
							$blacklist[ $videoId ] = $videoData;
						}
					}
				}
			}
		}

		foreach( $blacklist as $key => $blElement ){
			unset( $this->pages[ $key ] );
		}

		ksort( $this->pages );
		$this->pages = array_reverse( $this->pages, true );
		wfProfileOut( __METHOD__ );
		return $this->pages;
	}

	static public function getInstance() {
		if( RelatedVideos::$videoInstance == null ) {
			RelatedVideos::$videoInstance = new RelatedVideos();
		}
		return RelatedVideos::$videoInstance;
	}
}