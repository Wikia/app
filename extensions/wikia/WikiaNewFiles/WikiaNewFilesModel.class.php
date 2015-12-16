<?php

class WikiaNewFilesModel extends WikiaModel {
	/**
	 * @var Database
	 */
	private $dbr;

	/**
	 * @param bool $hideBots Whether to hide images uploaded by bots or not
	 */
	public function __construct() {
		$this->dbr = wfGetDB( DB_SLAVE );
	}

	/**
	 * Get the total number of images
	 * @return int number of images on current page
	 */
	public function getImageCount() {
		$sql = ( new WikiaSQL() )
			->SELECT()
			->COUNT( '*' )->AS_( 'count' )
			->FROM( 'image' );

		$count = $sql->run( $this->dbr, function ( ResultWrapper $result ) {
			return $result->current()->count;
		} );

		return intval( $count );
	}

	/**
	 * Get the specific page of images
	 *
	 * @param $limit      images per page
	 * @param $pageNumber page number (1-indexed)
	 * @return array array of images on current page
	 */
	public function getImagesPage( $limit, $pageNumber ) {
		$sql = ( new WikiaSQL() )
			->SELECT( 'img_size', 'img_name', 'img_user', 'img_user_text', 'img_description', 'img_timestamp' )
			->FROM( 'image' )
			->ORDER_BY( [ 'img_timestamp', 'DESC' ] )
			->LIMIT( $limit )
			->OFFSET( ( $pageNumber - 1 ) * $limit );

		return $sql->runLoop( $this->dbr, function ( &$data, $row ) {
			$this->addLinkingArticles( $row );
			$data[] = $row;
		} );
	}

	private function addLinkingArticles( $image ) {
		global $wgMemc;

		$cacheKey = wfMemcKey( __METHOD__, md5( $image->img_name ) );
		$data = $wgMemc->get( $cacheKey );
		if ( !is_array( $data ) ) {
			// The ORDER BY ensures we get NS_MAIN pages first
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'imagelinks', 'page' ),
				array( 'page_namespace', 'page_title' ),
				array( 'il_to' => $image->img_name, 'il_from = page_id' ),
				__METHOD__,
				array( 'LIMIT' => 2, 'ORDER BY' => 'page_namespace ASC' )
			);

			while ( $s = $res->fetchObject() ) {
				$data[] = array( 'ns' => $s->page_namespace, 'title' => $s->page_title );
			}
			$dbr->freeResult( $res );

			$wgMemc->set( $cacheKey, $data, 60 * 15 );
		}

		$image->linkingArticles = $data;
	}
}
