<?php

/**
 * Maintenance script to remove <imap /> tags from articles
 *
 * @usage SERVER_ID=203236 php removeImapTags.php --tiles-set-id=1 --quiet --dry-run
 */

require_once( __DIR__ . '/../../Maintenance.php' );

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_ALL);

class RemoveImapTags extends Maintenance {
	static protected $dryRun = false;

	private $maps;
	private $mapsClientConfig;
	private $slaveDBConfig;

	private $imapSearchRegexp = "/<imap\s+map\-id\=[\'\"]?(\d{1,})[\'\"]?\s*(>\s*<\s*\/\s*imap|\/)\s*>/";


	public function __construct() {
		parent::__construct();
		$this->mDescription = "Removes from articles <imap /> tags for given tiles' set id.";
		$this->addOption( 'dry-run', 'Dry run; make no changes', $required = false, $withArg = false );
		$this->addOption(
			'tiles-set-id',
			'Specify a tiles\' set id which leads to a group of maps which <imap /> tags should get removed',
			$required = true,
			$withArg = true,
			'tsi'
		);
	}

	static public function isDryRun() {
		return self::$dryRun;
	}

	static public function isNaturalNumber( $int ) {
		return intval( $int ) > 0;
	}

	public function getMapsIdsUsingTileset( $cityId, $tilesSetId ) {
		$dbw = new DatabaseMysqli(
			$this->slaveDBConfig['host'],
			$this->slaveDBConfig['user'],
			$this->slaveDBConfig['password'],
			$this->slaveDBConfig['database']
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

			$noOfFoundTags = preg_match_all($this->imapSearchRegexp, $articleContent, $results);

			if( $noOfFoundTags === 0 ) {
				return false;
			}

			$foundTags = $results[0];
			$foundTagsMapIds = $results[1];

			return true;
		} else {
			$this->output( sprintf( 'Article #%d does not exist anymore', $articleId ) . PHP_EOL );
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
			$this->output( 'Failed using WikiaBot user' . PHP_EOL );
		}

		if ( $article instanceof Article && $article->getID() ) {
			$oldContent = $article->getContent();
			$newContent = str_replace( $stringWithTagToRemove, "", $oldContent );

			$this->output( sprintf( 'Trying to edit article #%d', $articleId ) . PHP_EOL );
			if( !self::isDryRun() ) {
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
				$this->output( sprintf( "Failed to update article #%d", $articleId ) . PHP_EOL );
			}
		} else {
			$this->output( sprintf( 'Article #%d does not exist anymore', $articleId ) . PHP_EOL );
		}
	}

	public function isValidTilesSetId( $tilesSetId ) {
		if ( !self::isNaturalNumber( $tilesSetId ) ) {
			return false;
		}

		$res = $this->maps->getTileSet( $tilesSetId );

		if ( !isset( $res['success'] ) || $res['success'] !== true ) {
			$this->error( 'API call failure when looking for a tiles set #' . $tilesSetId . '.' . PHP_EOL );
		}

		$this->output( "Tiles' set #" . $tilesSetId . " found." . PHP_EOL );
		return $res['content']->id == $tilesSetId;
	}

	public function execute() {
		$this->app = F::app();
		$this->mapsClientConfig = $this->app->wg->IntMapConfig;
		$this->slaveDBConfig = $this->app->wg->IntMapFullConfig['db']['prod']['slave'][0];
		$this->maps = new WikiaMaps( $this->mapsClientConfig );

		self::$dryRun = $this->hasOption( 'dry-run' );

		$cityId = $this->app->wg->CityId;
		$tilesSetId = $this->getOption( 'tiles-set-id' );

		if ( self::isDryRun() ) {
			$this->output( 'Mode: test run' . PHP_EOL );
		} else {
			$this->output( 'Mode: normal run' . PHP_EOL );
		}

		if ( !$this->isValidTilesSetId( $tilesSetId ) ) {
			$this->error( 'Invalid tiles-set-id. Try again.' . PHP_EOL, 1 );
		}

		$mapsUsingTheTileset = self::getMapsIdsUsingTileset( $cityId, $tilesSetId );
		$mapsUsingTheTilesetCount = count($mapsUsingTheTileset);
		$this->output( sprintf( "Found %d maps using the tiles's set #%d", $mapsUsingTheTilesetCount, $tilesSetId ) . PHP_EOL );

		if ( $mapsUsingTheTilesetCount === 0 ) {
			$this->output( 'No maps found.' . PHP_EOL );
		}

		$articlesUsingImap = self::getArticlesIdsUsingImap( $cityId );
		$articlesUsingImapCount = count( $articlesUsingImap );
		$this->output( sprintf( "Found %d articles using <imap/>", $articlesUsingImapCount ) . PHP_EOL );

		if ( $articlesUsingImapCount === 0 ) {
			$this->output( 'No articles using <imap/> found. Have you run wikia/backend/bin/specials/tags_report.pl before?' . PHP_EOL );
		}

		foreach( $articlesUsingImap as $articleId ) {
			$this->output( sprintf( "Checks article #%d", $articleId ) . PHP_EOL );

			$foundTags = [];
			$foundTagsMapIds = [];
			$toRemove = [];

			if ( !$this->hasImapTag( $articleId, $foundTags, $foundTagsMapIds ) ) {
				$this->output( sprintf( "No <imap /> tags in article #%d", $articleId ) . PHP_EOL );
			} else {
				if ( !$this->hasTagsToRemove( $foundTagsMapIds, $mapsUsingTheTileset, $toRemove ) ) {
					$this->output( "No <imap /> for the given map ids" . PHP_EOL );
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
