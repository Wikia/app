<?php

/**
 * Maintenance script to migrate urls included in custom CSS files to https/protocol relative
 * @usage
 *  # this will migrate assets for wiki with ID 119:
 *  run_maintenance --script='wikia/HttpsMigration/migrateCustomCss.php  --saveChanges' --id=119
 *  # running on some wikis in dry mode and dumping url changes to a csv file:
 *  run_maintenance --script='wikia/HttpsMigration/migrateCustomCss.php --file migrate_css.csv' --where='city_id < 10000'
 *
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

		$wikiData = fgetcsv( $this->inputFh );

		// skip header row if exists
		$count = 0;
		$errors = 0;
		if ( !empty( $wikiData ) && !is_numeric( $wikiData[0] ) ) {
			fputcsv( $this->outputFh, $wikiData );
			$wikiData = fgetcsv( $this->inputFh );
		}

		while ( !empty( $wikiData ) ) {
			++$count;
			$wikiId = (int)$wikiData[0];
			$this->output( "Gathering data for wiki {$wikiId}\n" );

			$data = WikiFactory::getWikiByID( $wikiId );
			if ( !$data ) {
				$this->output( "Could not fetch WikiFactory data for wiki {$wikiId}\n" );
				++$errors;
				continue;
			}

			$dbr = wfGetDB( DB_SLAVE, [], $data->city_dbname );
			if ( empty( $dbr ) ) {
				$this->output( "Could not get database for wiki {$wikiId}\n" );
				return null;
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

			fputcsv( $this->outputFh, $wikiData );

			$wikiData = fgetcsv( $this->inputFh );
		}

		$this->output( "Processed {$count} wikis\nErrors: {$errors}\n" );

		return 0;
	}

	private function usesSemanticMediawiki( int $wikiId ): ?bool {
		return (bool)WikiFactory::getVarByName( 'wgEnableSemanticMediaWikiExt', $wikiId );
	}

	private function usesCustomJSorCSS( int $wikiId ): ?bool {
		$allowJS = (bool)WikiFactory::getVarByName( 'wgUseSiteJs', $wikiId );

		return !empty( $allowJS );
	}

	private function usesAchievements( int $wikiId ): ?bool {
		return (bool)WikiFactory::getVarByName( 'wgEnableAchievementsExt', $wikiId );
	}

	private function usesMediaGallery( int $wikiId ): ?bool {
		return (bool)WikiFactory::getVarByName( 'wgEnableMediaGalleryExt', $wikiId );
	}

	private function usesUnmigratedForums( int $wikiId ): ?bool {
		return (bool)WikiFactory::getVarByName( 'wgEnableForumExt', $wikiId );
	}

	/**
	 * Counts number of articles comments for wiki (by Ryba)
	 *
	 * @param DatabaseBase $dbr
	 * @param int $wikiId
	 * @return int|null
	 */
	private function getArticleComments( DatabaseBase $dbr, int $wikiId ): ?int {
		$commentsEnabled = WikiFactory::getVarByName( 'wgEnableArticleCommentsExt', $wikiId );
		if ( !$commentsEnabled ) {
			return null;
		}

		$activityCount = $dbr->selectField( 'page', 'count(*) as cnt', [
			'page_title like \'%/@comment-%\'',
			'page_namespace not in (1200,1201,110,111,106,107,2000,2001,2002)',
		] );

		if ( !$activityCount ) {
			return null;
		}

		return (int)$dbr->selectField( 'page', 'count(*) as cnt', [
			'page_title like \'%/@comment-%\'',
			'page_namespace not in (1200,1201,110,111,106,107,2000,2001,2002)',
		] );
	}

	private function getBlogCount( DatabaseBase $dbr ): ?int {
		return $dbr->estimateRowCount( 'page',  '*', [ 'page_namespace' => 500 ] );
	}

}

$maintClass = "GetWikiProperties";
require_once( RUN_MAINTENANCE_IF_MAIN );
