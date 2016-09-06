<?php

/**
 * Maintenance script to remove <imap /> tags from articles
 *
 * @usage SERVER_ID=203236 php removeImapTags.php --tiles-set-id=1 --verbose --test
 */

require_once( __DIR__ . '/../../Maintenance.php' );

ini_set( "include_path", __DIR__ . "/../../" );
ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_ALL);

class RemoveImapTags extends Maintenance {
	static protected $verbose = false;
	static protected $test = false;

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
	 */
	public function debug( $msg ) {
		if ( self::isVerbose() ) {
			$this->output( $msg . PHP_EOL );
		}
	}

	static public function isValidInteger( $int ) {
		return intval( $int ) > 0;
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

	public function getArticlesIdsUsingImap( $cityId ) {
		global $wgStatsDB;

		$dbw = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
		return $dbw->selectFieldValues( 'city_used_tags', 'ct_page_id', [
			'ct_wikia_id' => $cityId,
			'ct_kind' => 'imap'
		] );
	}

	public function hasImapTag( $articleId, &$foundTags, &$foundTagsMapIds ) {
		$article = Article::newFromID( $articleId );

		if ( $article instanceof Article && $article->getID() ) {
			$results = null;
			$articleContent = $article->getContent();
			$imapSearchRegexp = "/<imap.*map\-id\=['\"](\d{1,})['\"].*(<\/imap|\/)>/";

			$noOfFoundTags = preg_match_all($imapSearchRegexp, $articleContent, $results);

			if( $noOfFoundTags === 0 ) {
				return false;
			}

			$foundTags = $results[0];
			$foundTagsMapIds = $results[1];

			return true;
		} else {
			$this->error( sprintf( 'Article #%d does not exist anymore', $articleId ) . PHP_EOL );
		}
	}

	public function hasTagsToRemove( $foundTagsMapIds, $mapsUsingTheTileset, &$tagsToRemoveArrayKeyIds ) {
		foreach( $foundTagsMapIds as $key => $mapId ) {
			if ( in_array( $mapId, $mapsUsingTheTileset ) ) {
				$tagsToRemoveArrayKeyIds[] = $key;
			}
		}

		return !empty( $tagsToRemoveArrayKeyIds );
	}

	public function removeImapTagFromArticle( $articleId, $stringWithTagToRemove ) {
		$user = User::newFromName( 'WikiaBot' );
		$article = Article::newFromID( $articleId );

		if ( $user->getId() === 0 ) {
			$this->error( 'Failed using WikiaBot user' . PHP_EOL );
		}

		if ( $article instanceof Article && $article->getID() ) {
			$oldContent = $article->getContent();
			$newContent = str_replace( $stringWithTagToRemove, "", $oldContent );

			$this->debug( sprintf( 'Trying to edit article #%d', $articleId ) );
			if( !self::isTest() ) {
				$result = $article->doEdit(
					$newContent,
					wfMessage(
						'realmap-deprecated-info',
						'[[community:User_blog:DaNASCAT/Technical_Update:_August_29,_2016]]'
					)->text(),
					EDIT_FORCE_BOT,
					false,
					$user
				);
			} else {
				$result = true;
			}


			if( $result ) {
				$this->output( sprintf( "Removed <imap/> tags from article #%d", $articleId ) . PHP_EOL );
			} else {
				$this->error( sprintf( "Failed to update article #%d", $articleId ) . PHP_EOL );
			}
		} else {
			$this->error( sprintf( 'Article #%d does not exist anymore', $articleId ) . PHP_EOL );
		}
	}

	public function isValidTilesSetId( $tilesSetId ) {
		if ( !self::isValidInteger( $tilesSetId ) ) {
			return false;
		}

		$res = $this->maps->getTileSet( $tilesSetId );

		if ( !isset( $res['success'] ) || $res['success'] !== true ) {
			$this->debug( 'API call failure when looking for a tiles set #' . $tilesSetId . '.' );
			die;
		}

		$this->debug( "Tiles' set #" . $tilesSetId . " found." );
		return $res['content']->id == $tilesSetId;
	}

	public function execute() {
		$this->app = F::app();
		$this->mapsClientConfig = $this->app->wg->IntMapConfig;
		$this->maps = new WikiaMaps( $this->mapsClientConfig );

		self::$test = $this->hasOption( 'test' );
		self::$verbose = $this->hasOption( 'verbose' );

		$cityId = $this->app->wg->CityId;
		$tilesSetId = $this->getOption( 'tiles-set-id' );

		if ( self::isTest() ) {
			$this->debug( 'Mode: test run' );
		} else {
			$this->debug( 'Mode: normal run' );
		}

		if ( !self::isValidCityId( $cityId ) ) {
			$this->debug( 'Invalid city-id. Try again.' );
			die;
		}

		if ( !$this->isValidTilesSetId( $tilesSetId ) ) {
			$this->debug( 'Invalid tiles-set-id. Try again.' );
			die;
		}

		$mapsUsingTheTileset = self::getMapsIdsUsingTileset( $cityId, $tilesSetId );
		$mapsUsingTheTilesetCount = count($mapsUsingTheTileset);
		$this->debug( sprintf( "Found %d maps using the tiles's set #%d", $mapsUsingTheTilesetCount, $tilesSetId ) );

		if ( $mapsUsingTheTilesetCount === 0 ) {
			$this->error( 'No maps found.' . PHP_EOL , 1);
		}

		$articlesUsingImap = self::getArticlesIdsUsingImap( $cityId );
		$articlesUsingImapCount = count( $articlesUsingImap );
		$this->debug( sprintf( "Found %d articles using <imap/>", $articlesUsingImapCount ) );

		if ( $articlesUsingImapCount === 0 ) {
			$this->error( 'No articles using <imap/> found. Have you run wikia/backend/bin/specials/tags_report.pl before?' . PHP_EOL, 1);
		}

		foreach( $articlesUsingImap as $articleId ) {
			$this->debug( sprintf( "Checks article #%d", $articleId ) );

			$foundTags = [];
			$foundTagsMapIds = [];
			$toRemove = [];

			if ( !$this->hasImapTag( $articleId, $foundTags, $foundTagsMapIds ) ) {
				$this->debug( sprintf( "No <imap /> tags in article #%d", $articleId ) );
			} else {
				if ( !$this->hasTagsToRemove( $foundTagsMapIds, $mapsUsingTheTileset, $toRemove ) ) {
					$this->debug( "No <imap /> for the given map ids" );
				}

				foreach( $toRemove as $foundTagsKey ) {
					$stringWithTagToRemove = $foundTags[$foundTagsKey];
					$this->removeImapTagFromArticle( $articleId, $stringWithTagToRemove );
				}
			}
		}

		$this->output( 'Done' . PHP_EOL );
	}
}

$maintClass = "RemoveImapTags";
require_once( RUN_MAINTENANCE_IF_MAIN );
