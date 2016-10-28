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
	 * @return string
	 */
	private static function getImageCountKey() {
		return wfMemcKey( __CLASS__, 'getImageCount' );
	}

	/**
	 * Get the total number of images
	 * @return int number of images on current page
	 */
	public function getImageCount() {
		return WikiaDataAccess::cache( self::getImageCountKey(), WikiaResponse::CACHE_STANDARD, function() {
			$sql = (new WikiaSQL())
				->SELECT()
				->COUNT('*')->AS_('count')
				->FROM('image');

			$this->filterImages($sql);

			$count = $sql->run($this->dbr, function (ResultWrapper $result) {
				return $result->current()->count;
			});

			return intval($count);
		});
	}

	/**
	 * Invalidate getImageCount cache on each image upload / delete / undelete
	 *
	 * Binds to UploadComplete, FileDeleteComplete and FileUndeleteComplete hooks
	 *
	 * @see PLATFORM-2227
	 *
	 * @return bool
	 */
	public static function onFileOperation() {
		WikiaDataAccess::cachePurge( self::getImageCountKey() );
		return true;
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

		$this->filterImages( $sql );

		return $sql->runLoop( $this->dbr, function ( &$data, $row ) {
			$this->addLinkingArticles( $row );
			$data[] = $row;
		} );
	}

	/**
	 * Filter videos and other non-wanted media out
	 *
	 * @param WikiaSQL $sql
	 */
	private function filterImages( WikiaSQL $sql ) {
		$sql->WHERE( 'img_media_type' )->NOT_IN( [ 'VIDEO', 'swf' ] )
			->AND_( 'img_major_mime' )->NOT_EQUAL_TO( 'video' );
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
