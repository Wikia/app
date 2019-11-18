<?php

/**
 * Maintenance script to gather article comments activity in given period
 * @usage
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

// cat wikis.txt | while read line ; do SERVER_ID=$line php maintenance/wikia/ArticleCommentsActivity.php ; done > results_raw.txt
// SERVER_ID=1308778 php maintenance/wikia/ArticleCommentsActivity.php
// cat results_raw.txt | grep -Eo ^Result.+$ > results_processed.csv

/**
 * Class MigrateWikiFactoryToHttps
 */
class ArticleCommentsActivity extends Maintenance {

	protected $dryRun  = false;
	protected $verbose = false;
	protected $varName = '';
	protected $fh;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "gather article comments activity in given period";
	}

	public function execute() {
		global $wgEnableArticleCommentsExt;

		// select count(*) from page where page_title like '%/@comment-%' and page_namespace not in (1200,1201,110,111,106,107,2000,2001,2002) and page_touched > 20190801000000;
		if ( !empty( $wgEnableArticleCommentsExt ) ) {
			global $wgCityId, $wgSitename;

			$dbr = wfGetDB( DB_SLAVE );

			$activityCount = $dbr->selectField( 'page', 'count(*) as cnt', [
					'page_title like \'%/@comment-%\'',
					'page_namespace not in (1200,1201,110,111,106,107,2000,2001,2002)',
					'page_touched > 20190801000000',
				] );

			if ($activityCount > 0) {
				$commentsCount = $dbr->selectField( 'page', 'count(*) as cnt', [
					'page_title like \'%/@comment-%\'',
					'page_namespace not in (1200,1201,110,111,106,107,2000,2001,2002)',
				] );

				echo("Result;${wgCityId};${wgSitename};${activityCount};${commentsCount}\n");
			}
		}
	}
}

$maintClass = "ArticleCommentsActivity";
require_once( RUN_MAINTENANCE_IF_MAIN );
