<?php

class WikiaNewFilesModel extends WikiaModel {
	/**
	 * Cache TTL for the list of articles linking to an image
	 */
	const CACHE_LINKING_ARTICLES_TTL = 60 * 15;

	/**
	 * @var Database
	 */
	private $dbr;

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
	 * @param int $limit      images per page
	 * @param int $pageNumber page number (1-indexed)
	 * @return array array of images on current page
	 */
	public function getImagesPage( $limit, $pageNumber ) {
		$sql = ( new WikiaSQL() )
			->SELECT( 'img_size', 'img_name', 'img_user', 'img_user_text', 'img_description', 'img_timestamp' )
			->FROM( 'image' )
			->ORDER_BY( 'img_timestamp' )->DESC()
			->LIMIT( $limit )
			->OFFSET( ( $pageNumber - 1 ) * $limit );

		return $sql->runLoop( $this->dbr, function ( &$data, $row ) {
			$this->addLinkingArticles( $row );
			$data[] = $row;
		} );
	}

	private function addLinkingArticles( $image ) {
		$sql = ( new WikiaSQL() )
			->SELECT( 'page.page_namespace', 'page.page_title' )
			->FROM( 'imagelinks' )
			->JOIN( 'page' )->ON( 'imagelinks.il_from', 'page.page_id' )
			->WHERE( 'imagelinks.il_to' )->EQUAL_TO( $image->img_name )
			// Get the NS_MAIN first
			->ORDER_BY( 'page.page_namespace' )
			->LIMIT( 2 );

		$sql->cache( self::CACHE_LINKING_ARTICLES_TTL, null, true /* cache empty */ );

		$image->linkingArticles = $sql->runLoop( $this->dbr, function ( &$data, $row ) {
			$data[] = [
				'ns' => $row->page_namespace,
				'title' => $row->page_title,
			];
		} );
	}
}
