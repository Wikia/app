<?php

/**
 * Maintenance script to fetch wiki properties needed for migration to Unified Community Platform
 * @usage
 *  # this will fetch info for wikis specified in input.csv and output them to file output.csv:
 *  php '/maintenance/wikia/UcpMigration/getWikiProperties.php -f input.csv -o output.csv
 *	# additionally you can specify offset and limit of records to process with -s and -l options.
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ALL ^ E_NOTICE );

require_once( __DIR__ . '/../../Maintenance.php' );

/**
 * Class GetWikiProperties
 */
class GetWikiProperties extends Maintenance {

	protected $saveChanges  = false;
	protected $inputFh;		// handle to the input csv file
	protected $outputFh;	// handle to the output csv file

	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Gathers basic information about wikis';
		$this->addOption( 'file', 'CSV file to load list of wikis from', true, true, 'f' );
		$this->addOption( 'outFile', 'CSV file to save result to', true, true, 'o' );
		$this->addOption( 'from', 'number of record to start processing from', false, true, 's' );
		$this->addOption( 'limit', 'total number of records to process', false, true, 'l' );
	}

	public function __destruct()  {
		if ( $this->inputFh ) {
			fclose( $this->inputFh );
		}

		if ( $this->outputFh ) {
			fclose( $this->outputFh );
		}
	}

	public function execute() {
		global $wgSpecialsDB;

		$inputFileName = $this->getOption( 'file', false );
		if ( $inputFileName ) {
			$this->inputFh = fopen( $inputFileName, "r" );
			if ( !$this->inputFh ) {
				$this->error( "Could not open file '$inputFileName' for read!'\n" );
				return false;
			}
		}

		$outputFileName = $this->getOption( 'outFile', false );
		if ( $outputFileName ) {
			$this->outputFh = fopen( $outputFileName, "w" );
			if ( !$this->outputFh ) {
				$this->error( "Could not open file '$outputFileName' for write!'\n" );
				return false;
			}
		}

		$startIdx = $this->getOption( 'from' );
		$limit = $this->getOption( 'limit' );

		$wikiData = fgetcsv( $this->inputFh );

		$specialsDB = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );

		// skip header row if exists
		$count = 0;
		$pos = 0;
		$errors = 0;
		$skipped = 0;
		if ( !empty( $wikiData ) && !is_numeric( $wikiData[0] ) ) {
			fputcsv( $this->outputFh, $wikiData );
			$wikiData = fgetcsv( $this->inputFh );
		}

		while ( !empty( $wikiData ) ) {
			++$pos;

			if ( !empty( $startIdx ) && $pos < $startIdx ) {
				$wikiData = fgetcsv( $this->inputFh );
				continue;
			}

			if ( !empty( $limit ) && $count > $limit ) {
				break;
			}

			++$count;

			$wikiId = (int)$wikiData[0];
			$this->output( "Gathering data for wiki {$wikiId}\n" );

			$data = WikiFactory::getWikiByID( $wikiId );
			if ( !$data ) {
				$this->outputError( "Could not fetch WikiFactory data for wiki {$wikiId}\n", $wikiData );
				++$errors;
				$wikiData = fgetcsv( $this->inputFh );
				continue;
			}

			if ( $data->city_public != WikiFactory::PUBLIC_WIKI ) {
				$this->output( "Wiki is not public - skipping: {$wikiId}\n" );
				$wikiData = fgetcsv( $this->inputFh );
				++$skipped;
				continue;
			}

			$dbr = wfGetDB( DB_SLAVE, [], $data->city_dbname );
			if ( empty( $dbr ) ) {
				$this->outputError( "Could not get database for wiki {$wikiId}\n", $wikiData );
				$wikiData = fgetcsv( $this->inputFh );
				continue;
			}

			$wikiData[2] = WikiFactory::getLocalEnvURL( $data->city_url );
			$wikiData[3] = $data->city_dbname;
			$wikiData[4] = $this->usesUnmigratedForums( $wikiId );
			$wikiData[5] = $this->getArticleComments( $dbr, $wikiId );
			$wikiData[6] = $this->usesMediaGallery( $wikiId );
			$wikiData[7] = $this->usesAchievements( $wikiId );
			$wikiData[8] = $this->getBlogCount( $dbr );
			$wikiData[9] = $this->usesCustomJSorCSS( $wikiId );
			$wikiData[10] = $this->usesSemanticMediawiki( $wikiId );
			$wikiData[11] = $this->getTotalEditsCount( $dbr );
			$wikiData[12] = $this->getEditsCount( $specialsDB, $wikiId );

			$dbr->close();
			unset( $dbr );

			fputcsv( $this->outputFh, $wikiData );

			$wikiData = fgetcsv( $this->inputFh );
		}

		$this->output( "Processed {$count} wikis\nSkipped: {$skipped}\nErrors: {$errors}\n" );

		return 0;
	}

	protected function outputError( string $err, array $data ) {
		$this->error( $err );
		$data[2] = 'ERROR!';
		fputcsv( $this->outputFh, $data );
	}

	private function usesSemanticMediawiki( int $wikiId ): bool {
		return (bool)WikiFactory::getVarValueByName( 'wgEnableSemanticMediaWikiExt', $wikiId );
	}

	private function usesCustomJSorCSS( int $wikiId ): bool {
		$allowJS = (bool)WikiFactory::getVarValueByName( 'wgUseSiteJs', $wikiId );

		return !empty( $allowJS );
	}

	private function usesAchievements( int $wikiId ): bool {
		return (bool)WikiFactory::getVarValueByName( 'wgEnableAchievementsExt', $wikiId );
	}

	private function usesMediaGallery( int $wikiId ): bool {
		return (bool)WikiFactory::getVarValueByName( 'wgEnableMediaGalleryExt', $wikiId );
	}

	private function usesUnmigratedForums( int $wikiId ): bool {
		return (bool)WikiFactory::getVarValueByName( 'wgEnableForumExt', $wikiId );
	}

	/**
	 * Counts number of articles comments for wiki (by Ryba)
	 *
	 * @param DatabaseBase $dbr
	 * @param int $wikiId
	 * @return int|null
	 */
	private function getArticleComments( DatabaseBase $dbr, int $wikiId ): int {
		$commentsEnabled = WikiFactory::getVarValueByName( 'wgEnableArticleCommentsExt', $wikiId );
		if ( !$commentsEnabled ) {
			return 0;
		}

		$activityCount = $dbr->selectField( 'page', 'count(*) as cnt', [
			'page_title like \'%/@comment-%\'',
			'page_namespace not in (1200,1201,110,111,106,107,2000,2001,2002)',
		] );

		if ( !$activityCount ) {
			return 0;
		}

		return (int)$dbr->selectField( 'page', 'count(*) as cnt', [
			'page_title like \'%/@comment-%\'',
			'page_namespace not in (1200,1201,110,111,106,107,2000,2001,2002)',
		] );
	}

	private function getBlogCount( DatabaseBase $dbr ): int {
		$res = $dbr->selectField( 'page',  'COUNT(*)', [ 'page_namespace' => 500 ] );
		if ( empty( $res ) ) {
			return 0;
		} else {
			return $res;
		}
	}

	private function getTotalEditsCount( DatabaseBase $dbr ): int {
		$res = $dbr->selectField( 'site_stats', 'ss_total_edits' );
		if ( empty( $res ) ) {
			return 0;
		} else {
			return $res;
		}
	}

	private function getEditsCount( DatabaseBase $specialsDbr, int $wikiId ): int {
		$res = $specialsDbr->selectField( 'events_local_users', 'count(edits)', [ 'wiki_id' => $wikiId, 'editdate >= DATE_ADD(NOW(), INTERVAL -30 DAY)' ] );
		if ( empty( $res ) ) {
			return 0;
		} else {
			return $res;
		}
	}
}

$maintClass = "GetWikiProperties";
require_once( RUN_MAINTENANCE_IF_MAIN );
