<?php

class WikiaNewFilesModel extends WikiaModel {
	/**
	 * @var Database
	 */
	private $dbr;

	/**
	 * @var string
	 */
	private $hideBots = false;

	/**
	 * Extend the SQL query so that bot-uploaded images are removed
	 *
	 * @param WikiaSQL $sql
	 */
	private function applyBotExclusion( WikiaSQL $sql ) {
//		if ( !$this->hideBots ) {
//			return;
//		}
//
//		$botGroups = User::getGroupsWithPermission( 'bot' );
//		if ( !count( $botGroups ) ) {
//			return;
//		}
//
//		// FluentSQL doesn't allow compound conditions in ON clause so we're doing some old school MW here
//		// what we get is: user_groups.ug_group IN ('bot','bot-global')
//		$onlyBotGroups = $this->dbr->makeList( [ 'user_groups.ug_group' => $botGroups ], LIST_AND );
//
//		$sql->LEFT_JOIN( 'user_groups' )
//			->ON( 'image.img_user = user_groups.ug_user AND ' . $onlyBotGroups )
//			->WHERE( 'user_groups.ug_group' )->IS_NULL();
	}

	/**
	 * @param bool $hideBots Whether to hide images uploaded by bots or not
	 */
	public function __construct( $hideBots ) {
		$this->dbr = wfGetDB( DB_SLAVE );
		$this->hideBots = $hideBots;
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

		$this->applyBotExclusion( $sql );

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

		$this->applyBotExclusion( $sql );

		return $sql->runLoop( $this->dbr, function ( &$data, $row ) {
			$data[] = $row;
		} );
	}

	public function getLinkedFiles( $image ) {
		global $wgMemc;
		$anchorLength = 60;

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

		$links = array();

		if ( !empty( $data ) ) {
			foreach ( $data as $row ) {
				$name = Title::makeTitle( $row['ns'], $row['title'] );
				$links[] = Linker::link( $name, wfShortenText( $name, $anchorLength ), array( 'class' => 'wikia-gallery-item-posted' ) );
			}
		}

		return $links;
	}
}
