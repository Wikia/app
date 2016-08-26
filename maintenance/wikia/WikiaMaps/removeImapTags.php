<?php

/**
 * Maintenance script to remove <imap /> tags from articles
 *
 * @usage SERVER_ID=203236 php removeImapTags.php --tiles-set-id=1 --verbose --test
 */

ini_set( "include_path", dirname( __FILE__ )."/../../" );

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_ALL);

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

class RemoveImapTags extends Maintenance {
	static protected $verbose = false;
	static protected $test = false;

	/**
	 * @var WikiaMaps
	 */
	private $maps;

	/**
	 * @var Array
	 */
	private $mapsClientConfig;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Removes from articles <imap /> tags for given tiles' set id.";
		$this->addOption( 'test', 'Test mode; make no changes', $required = false, $withArg = false, 't' );
		$this->addOption( 'verbose', 'Show extra debugging output', $required = false, $withArg = false, 'v' );
		$this->addOption( 'maps-db-host', 'WikiaMaps DB host', $required = true, $withArg = true );
		$this->addOption( 'maps-db-user', 'WikiaMaps DB user', $required = true, $withArg = true );
		$this->addOption( 'maps-db-pass', 'WikiaMaps DB pass', $required = true, $withArg = true );
		$this->addOption( 'maps-db-name', 'WikiaMaps DB name', $required = true, $withArg = true );
		$this->addOption(
			'tiles-set-id',
			'Specify a tiles\' set id which leads to a group of maps which <imap /> tags should get removed',
			$required = true,
			$withArg = true,
			'tsi'
		);
	}

	static public function isVerbose() {
		return self::$verbose;
	}

	static public function isTest() {
		return self::$test;
	}

	/**
	 * Print the message if verbose is enabled
	 *
	 * @param $msg - The message text to echo to STDOUT
	 */
	static public function debug( $msg ) {
		if ( self::isVerbose() ) {
			echo $msg . PHP_EOL;
		}
	}

	static public function isValidInteger( $int ) {
		$int = intval( $int );
		return ( $int <= 0 ) ? false : true;
	}

	static public function isValidCityId( $cityId ) {
		return self::isValidInteger( $cityId );
	}

	public function getMapsIdsUsingTileset( $cityId, $tilesSetId ) {
		$dbw = new DatabaseMysqli(
			$this->getOption('maps-db-host'),
			$this->getOption('maps-db-user'),
			$this->getOption('maps-db-pass'),
			$this->getOption('maps-db-name')
		);

		return $dbw->selectFieldValues( 'map', 'id', [
				'city_id' => $cityId,
				'tile_set_id' => $tilesSetId
		] );
	}

	public function isValidTilesSetId( $tilesSetId ) {
		if ( !self::isValidInteger( $tilesSetId ) ) {
			return false;
		}

		$res = $this->maps->getTileSet( $tilesSetId );

		if ( !isset( $res['success'] ) || $res['success'] !== true ) {
			self::debug( 'API call failure when looking for a tiles set #' . $tilesSetId . '.' );
			die;
		}

		self::debug( "Tiles' set #" . $tilesSetId . " found." );
		return $res['content']->id == $tilesSetId;
	}

	public function execute() {
		$this->app = F::app();
		$this->mapsClientConfig = $this->app->wg->IntMapConfig;
		$this->maps = new WikiaMaps( $this->mapsClientConfig );

		self::$test = $this->hasOption( 'test' );
		self::$verbose = $this->hasOption( 'verbose' );

		$tilesSetId = $this->getOption( 'tiles-set-id' );

		if ( self::isTest() ) {
			self::debug( 'Mode: test run' );
		} else {
			self::debug( 'Mode: normal run' );
		}

		if ( !self::isValidCityId( $this->app->wg->CityId ) ) {
			self::debug( 'Invalid city-id. Try again.' );
			die;
		}

		if ( !$this->isValidTilesSetId( $tilesSetId ) ) {
			self::debug( 'Invalid tiles-set-id. Try again.' );
			die;
		}

		// get maps using this tiles set
		// foreach map walk through articles and check if there is <imap /> tag with it
		// -- if there is remove it and save page edit with a comment

		$mapsUsingTheTileset = self::getMapsIdsUsingTileset( $this->app->wg->CityId, $tilesSetId );
		$mapsUsingTheTilesetCount = count($mapsUsingTheTileset);
		self::debug( sprintf( "Found %d maps using the tiles's set #%d", $mapsUsingTheTilesetCount, $tilesSetId ) );

		if ( $mapsUsingTheTilesetCount === 0 ) {
			echo 'No maps found.' . PHP_EOL;
			die;
		}

		echo 'Done.' . PHP_EOL;
	}
}

$maintClass = "RemoveImapTags";
require_once( RUN_MAINTENANCE_IF_MAIN );
