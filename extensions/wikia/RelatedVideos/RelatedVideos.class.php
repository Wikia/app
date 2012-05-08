<?php

class RelatedVideos extends RelatedPages {

	protected $memcKeyPrefix = 'RelatedVideos';
	protected $width = 160;
	static protected $videoInstance = null;
	
	const MAX_RELATEDVIDEOS = 25;

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
			$oRelatedVideosService = F::build( 'RelatedVideosService' );
			$data['articleId'] = 0;
			$videoData = $oRelatedVideosService->getRelatedVideoData( $data );
			if ( isset( $videoData[ 'timestamp' ] ) && isset( $videoData['id'] ) ){
				$this->pages[ $videoData['uniqueId'] ] = $videoData;
				if ( count( $this->pages ) >= $limit) {
					break;
				}
			}
		}

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