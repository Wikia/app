<?php

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class PandoraCoppaImageReviewCleanUp extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->addOption( 'dryRun', "Whether to actually set images as removed. Script defaults to dryRun = true (attributes not actually removed)" );
		$this->addOption( 'cleanInvalidWikis', "A separate cleanup mode, where all images from non-existent wikis are removed");
	}


	public function execute() {
		global $wgSpecialsDB, $wgCityId, $wgExternalSharedDB;

		$imageReviewDB = wfGetDB( DB_MASTER, [], $wgSpecialsDB );

		if ( $this->getOption( 'cleanInvalidWikis', false ) ) {
			$this->output( "Removing images from deleted wikis.\n" );

			$start = time();

			// $wikicitiesDb = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
      //
			// $wikiList = ( new WikiaSQL() )
			// 	->SELECT( 'wiki_id' )
			// 	->FROM( 'image_review.images_coppa' )
			// 	->runLoop( $imageReviewDB, function ( &$result, $row ) {
			// 		$result[$row->wiki_id] = $row->wiki_id;
			// 	} );
      //
			// $chunks = array_chunk( $wikiList, 1000, true );
      //
			// foreach ( $chunks as $chunk ) {
			// 	$this->output( "Chunk size: " . count( $chunk ) . "\n" );
			// 	( new WikiaSQL() )
			// 		->SELECT( 'city_id' )
			// 		->FROM( 'city_list' )
			// 		->WHERE( 'city_id' )
			// 		->IN( $chunk )
			// 		->runLoop( $wikicitiesDb, function ( &$result, $row ) use ( &$chunk ) {
			// 			unset( $chunk[$row->city_id] );
			// 		} );
      //
			// 		$this->output( "Number of missing wikis: " . count( $chunk ) . "\n" );
      //
			// 		if ( count( $chunk ) > 0 ) {
			// 			if ( !$this->getOption( 'dryRun', true ) ) {
			// 				( new WikiaSQL() )
			// 					->UPDATE( 'image_review.images_coppa' )
			// 					->SET( 'is_removed', 1, true )
			// 					->WHERE( 'wiki_id' )->IN( $chunk )
			// 					->run( $imageReviewDB );
			// 			} else {
			// 				$this->output( "This is a dry run. Not updating. \n" );
			// 				foreach ( $chunk as $wikiId ) {
			// 					$this->output( "Missing wiki: " . $wikiId . "\n" );
			// 				}
			// 			}
			// 		}
			// }

			$this->output( "Total time: " . ( time() - $start ) . "sec\n" );
		} else {
			$this->output( "Starting cleanup for wiki id: " . $wgCityId . "\n" );

			$start = time();

			$wikiDB = wfGetDB( DB_SLAVE );

			$pageList = ( new WikiaSQL() )
				->SELECT( 'image_id', 'wiki_id', 'page_id', 'revision_id' )
				->FROM( 'image_review.images_coppa' )
				->WHERE( 'wiki_id' )->EQUAL_TO( $wgCityId )
				->runLoop( $imageReviewDB, function ( &$result, $row ) {
					$result[$row->page_id] = [
						'image_id' => $row->image_id,
						'wiki_id' => $row->wiki_id,
						'page_id' => $row->page_id,
						'revision_id' => $row->revision_id
					];
				} );

			$idChunks = array_chunk( $pageList, 1000, true );

			$this->output( "Image review query time: " . ( time() - $start ) . "sec\n" );
			$this->output( "Images to check: " . count( $pageList ) . "\n" );
			$this->output( "Chunks to check: " . count( $idChunks ) . "\n" );

			$wikiStart = time();
			$missingImages = [];
			foreach ( $idChunks as $chunk ) {
				$this->output( "Chunk size: " . count( $chunk ) . "\n" );
				( new WikiaSQL() )
					->SELECT( 'page_id' )
					->FROM( 'page' )
					->WHERE( 'page_id' )
					->IN( array_map( function ( $row ) {
						return $row['page_id'];
					}, $chunk ) )
					->AND_( 'page_namespace' )
					->IN( [ /* filepage */ 6 ] )
					->runLoop( $wikiDB, function ( &$result, $row ) use ( &$chunk ) {
						unset( $chunk[$row->page_id] );
					} );
				$this->output( "Chunk size after page id: " . count( $chunk ) . "\n" );
				( new WikiaSQL() )
					->SELECT( 'rev_page' )
					->FROM( 'revision' )
					->WHERE( 'rev_id' )
					->IN( array_map( function ( $row ) {
						return $row['revision_id'];
					}, $chunk ) )
					->runLoop( $wikiDB, function ( &$result, $row ) use ( &$chunk ) {
						unset( $chunk[$row->page_id] );
					} );
				$this->output( "Chunk size after rev id: " . count( $chunk ) . "\n" );

				$missingImages = array_merge( $missingImages, $chunk );
				if ( !$this->getOption( 'dryRun', true ) ) {
					( new WikiaSQL() )
						->UPDATE( 'image_review.images_coppa' )
						->SET( 'is_removed', 1, true )
						->WHERE( 'image_id' )->IN( array_map( function ( $item ) {
							return $item['image_id'];
						}, $chunk ) )
						->run( $imageReviewDB );
				} else {
					$this->output( "This is a dry run. Not updating. \n" );
				}
			}

			$this->output( "Wiki query time: " . ( time() - $wikiStart ) . "sec\n" );
			$this->output( "Broken images number: " . count( $missingImages ) . "\n" );
			$this->output( "Total time: " . ( time() - $start ) . "sec\n" );
		}
	}
}

$maintClass = "PandoraCoppaImageReviewCleanUp";
require_once( RUN_MAINTENANCE_IF_MAIN );
