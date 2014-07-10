<?php

abstract class BaseMaintVideoScript {

	const BATCH_LIMIT_DEFAULT = 50000;
	const PAGE_SIZE_DEFAULT = 100;

	protected $skipped;
	protected $failed;
	public $dryRun;

	function __construct() {
		$this->skipped = 0;
		$this->failed = 0;
		$this->dryRun = true;
	}

	public abstract function run();

	public function incSkipped() {
		++$this->skipped;
	}

	public function incFailed() {
		++$this->failed;
	}

	public function isDryRun() {
		return $this->dryRun;
	}

	/**
	 * Find Video by provider and videoId
	 * @param $provider
	 * @param $videoId
	 * @return array
	 */
	public function findVideoDuplicates( $provider, $videoId ) {
		$db = wfGetDB( DB_MASTER ); // has to be master otherwise there's a chance of getting duplicates

		if ( strstr( $provider, '/' ) ) {
			$providers = explode( '/', $provider );
			$provider = $providers[0];
		}

		$videos = ( new WikiaSQL() )->SELECT( "image.*" )
			->FROM( "video_info" )
			->JOIN( "image" )
			->ON( "video_title", "img_name" )
			->WHERE( "provider" )->EQUAL_TO( $provider )
			->AND_( "video_id" )->EQUAL_TO( ( string ) $videoId )
			->run( $db, function ( $result ) {
			    while ( $row = $result->fetchObject( $result ) ) {
			        $rows[] = ( array ) $row;
			    }
			    return $rows;
			} );

		return $videos;
	}

	/**
	 * Get a video row by title
	 * @param string $title
	 * @return null|array
	 */
	public function getVideoByTitle( $title ) {
		$db = wfGetDB( DB_SLAVE );
		$video = ( new WikiaSQL() )->SELECT( "image.*" )
			->FROM( "video_info" )
			->JOIN( "image" )
			->ON( "video_title", "img_name" )
			->WHERE( "video_title" )->EQUAL_TO( $title )
			->LIMIT( 1 )
			->run( $db, function ( $result ) {
				return $result->fetchObject( $result );
			} );

		if ( !$video ) {
			return null;
		}

		return (array) $video;
	}

	/**
	 * Get Videos by provider
	 * @param $provider
	 * @param $limit
	 * @param int $offset
	 * @return array|null
	 */
	public function getVideosByProvider( $provider, $limit, $offset = 0 ) {
		$providerNameLen = strlen( $provider );

		$db = wfGetDB( DB_SLAVE );
		$videos = ( new WikiaSQL() )->SELECT( "image.*" )
			->FROM( "image" )
			->WHERE( "img_metadata" )->LIKE( '%"provider";s:' . $providerNameLen . ':"' . $provider . '";%' )
			->ORDER_BY( "img_name" )
			->LIMIT( $limit )
			->OFFSET( $offset )
			->runLoop( $db, function ( &$result, $row ) {
				$result[] = (array) $row;
			} );

		if ( !$videos ) {
			return null;
		}

		return (array) $videos;
	}

	/**
	 * Get Metadata unserialized
	 * @param array $video
	 * @return array
	 */
	public function extractMetadata( array $video ) {
		return unserialize( $video['img_metadata'] );
	}

	/**
	 * @todo Implement fancier output, such as using Ncurses functions
	 * @param string $message
	 */
	public function outputMessage($message) {
		echo $message . "\n";
	}

	/**
	 * Output error message
	 * @param string $error
	 * @param string|null $pre
	 */
	public function outputError($error, $pre=null) {
		echo $pre . 'Error: ' . $error . "\n";
	}

	/**
	 * Compare metadata - For debugging purposes
	 * @param array $oldMeta
	 * @param array $newMeta
	 */
	protected function compareMetadata( $oldMeta, $newMeta ) {
		$fields = array_unique( array_merge( array_keys( $newMeta ), array_keys( $oldMeta ) ) );
		foreach ( $fields as $field ) {
			if ( ( !isset( $newMeta[$field] ) || is_null( $newMeta[$field] ) ) && isset( $oldMeta[$field] ) ) {
				$this->outputMessage( "\t\t[DELETED] $field: ".$oldMeta[$field] );
			} elseif ( isset( $newMeta[$field] ) && !isset( $oldMeta[$field] ) ) {
				$this->outputMessage( "\t\t[NEW] $field: $newMeta[$field]" );
			} elseif ( strcasecmp( $oldMeta[$field], $newMeta[$field] ) == 0 ) {
				$this->outputMessage( "\t\t$field: $newMeta[$field]" );
			} else {
				$this->outputMessage( "\t\t[UPDATED]$field: {$newMeta[$field]} (Old value: {$oldMeta[$field]})" );
			}
		}
	}

	protected function getCurrentTimestamp() {
		$timeFormat = 'Y-m-d g:i:s a e';
		return date($timeFormat);
	}
}