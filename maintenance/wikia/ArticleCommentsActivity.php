<?php

/**
 * Maintenance script to gather article comments activity in given period
 * @usage
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

// SERVER_ID=1308778 php maintenance/wikia/GenerateWikiIdsList.php
// cat wikis.txt | while read line ; do SERVER_ID=$line php maintenance/wikia/ArticleCommentsActivity.php ; done | grep --line-buffered -Eo ^Result.+$ > results_raw.txt


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

		// select count(*) from page where page_title like '%/@comment-%' and page_namespace in
		// $comments namespaces;
		if ( !empty( $wgEnableArticleCommentsExt ) ) {
			global $wgCityId, $wgSitename, $wgArticleCommentsNamespaces, $wgContentNamespaces;

			$dbr = wfGetDB( DB_SLAVE );

			$namespaces = array_map(function($ns) {
				return MWNamespace::getTalk($ns);
			}, empty($wgArticleCommentsNamespaces) ? $wgContentNamespaces : $wgArticleCommentsNamespaces);

//			$commentsCount = $dbr->selectField( 'page', 'count(*) as cnt', [
//				'page_title like \'%/@comment-%\'',
//				'page_namespace' => $namespaces,
//			] );
//
//			$namespacesStr = implode(',', $namespaces);
//			// Select count(*) from ( select DISTINCT SUBSTRING_INDEX(page_title, "/@comment-", 1) as db_key, page_namespace from page where page_namespace in (1, 501, 15) and page_title like '%@comment-%') as initial_query;
//			$pagesWithComments = $dbr->query(
//				"select count(*) as cnt from (select DISTINCT SUBSTRING_INDEX(page_title, \"/@comment-\", 1) as db_key, page_namespace from page where page_namespace in (${namespacesStr}) and page_title like '%@comment-%') as initial_query"
//			)->fetchRow()['cnt'];
//
//			echo("Result;${wgCityId};${wgSitename};${commentsCount};${pagesWithComments}\n");

			// deleted comments stats
			$deletedCommentsCountArchive = $dbr->selectField( 'archive', 'count(*) as cnt', [
				'ar_title like \'%/@comment-%\'',
				'ar_namespace' => $namespaces,
			] );

			$deletionsCount = $dbr->selectField( 'logging', 'count(*) as cnt', [
				'log_title like \'%/@comment-%\'',
				'log_namespace' => $namespaces,
				'log_type' => 'delete',
				'log_action' => 'delete',
			] );

			$restoresCount = $dbr->selectField( 'logging', 'count(*) as cnt', [
				'log_title like \'%/@comment-%\'',
				'log_namespace' => $namespaces,
				'log_type' => 'delete',
				'log_action' => 'restore',
			] );

			$deletions3M = $dbr->selectField( 'logging', 'count(*) as cnt', [
				'log_title like \'%/@comment-%\'',
				'log_namespace' => $namespaces,
				'log_type' => 'delete',
				'log_action' => 'delete',
				'log_timestamp > 20200122000000'
			] );

			$restores3M = $dbr->selectField( 'logging', 'count(*) as cnt', [
				'log_title like \'%/@comment-%\'',
				'log_namespace' => $namespaces,
				'log_type' => 'delete',
				'log_action' => 'restore',
				'log_timestamp > 20200122000000'
			] );

			if ( $deletedCommentsCountArchive > 0 || $deletionsCount > 0 || $restoresCount > 0 || $deletions3M > 0 || $restores3M > 0) {
				echo("Result;${wgCityId};${wgSitename};${deletedCommentsCountArchive};${deletionsCount};${restoresCount};${deletions3M};${restores3M}\n");
			}
		}
	}
}

$maintClass = "ArticleCommentsActivity";
require_once( RUN_MAINTENANCE_IF_MAIN );
