<?php

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class PandoraCoppaImageReviewCleanUp extends Maintenance {

	public function execute() {
		global $wgSpecialsDB, $wgCityId;

		$start = time();

		$imageReviewDB = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );
		$wikiDB = wfGetDB( DB_SLAVE );

		$pageList = ( new WikiaSQL() )
			->SELECT( 'wiki_id', 'page_id', 'revision_id' )
			->FROM( 'image_review.images_coppa' )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wgCityId )
			->runLoop( $imageReviewDB, function ( &$result, $row ) {
				$result[$row->page_id] = [
					'wiki_id' => $row->wiki_id,
					'page_id' => $row->page_id,
					'revision_id' => $row->revision_id
				];
			} );

		$idChunks = array_chunk( $pageList, 100, true );

		print_r( "Image review query time: " . ( time() - $start ) . "sec\n" );
		print_r( "Images to check: " . count( $pageList ) . "\n" );
		print_r( "Chunks to check: " . count( $idChunks ) . "\n" );
		$wikiStart = time();
		$missingImages = [];
		foreach ( $idChunks as $chunk ) {
			print_r( "Chunk size: " . count( $chunk ) . "\n" );
			( new WikiaSQL() )
				->SELECT( 'page_id' )
				->FROM( 'page' )
				->WHERE( 'page_id' )
				->IN( array_map( function ( $row ) {
					return $row['page_id'];
				}, $chunk ) )
				->runLoop( $wikiDB, function ( &$result, $row ) use ( &$chunk ) {
					unset( $chunk[$row->page_id] );
				} );
			print_r( "Chunk size after page id: " . count( $chunk ) . "\n" );
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
			print_r( "Chunk size after rev id: " . count( $chunk ) . "\n" );

			$missingImages = array_merge( $missingImages, $chunk );
		}

		print_r( "Wiki query time: " . ( time() - $wikiStart ) . "sec\n" );

		print_r( "Broken images number: " . count( $missingImages ) . "\n" );

		print_r( "Total time: " . ( time() - $start ) . "sec\n" );
	}
}

$maintClass = "PandoraCoppaImageReviewCleanUp";
require_once( RUN_MAINTENANCE_IF_MAIN );
