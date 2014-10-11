<?php

/**
* Maintenance script to purge article pages for the wiki
* This is one time use script
* @author Saipetch Kongkatong
*/

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Class purgeArticlePages
 */
class purgeArticlePages extends Maintenance {

	protected $dryRun  = false;
	protected $success = 0;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Set wiki factory variable";
		$this->addOption( 'dry-run', 'Dry run mode', false, false, 'd' );
		$this->addOption( 'wikiId', 'Wiki Id', false, true, 'w' );
	}

	public function execute() {
		$this->dryRun = $this->hasOption( 'dry-run' );
		$this->verbose = $this->hasOption( 'verbose' );
		$wikiId = $this->getOption( 'wikiId', '' );

		if ( empty( $wikiId ) ) {
			die( "Error: Empty wiki id.\n" );
		}

		$dbname = WikiFactory::IDtoDB( $wikiId );
		if ( empty( $dbname ) ) {
			die( "Error: Cannot find dbname.\n" );
		}

		$cnt = 0;
		$pages = $this->getAllPages( $dbname );
		$total = count($pages);
		foreach( $pages as $page ) {
			$cnt++;
			echo "Wiki $wikiId - Page $page[id] [$cnt of $total]: ";
			$title = GlobalTitle::newFromId( $page['id'], $wikiId );
			if ( $title instanceof GlobalTitle ) {
				$url = $title->getFullURL();
				$command = "curl -X PURGE '$url'";
				echo "$command\n";
				if ( !$this->dryRun ) {
					$output = shell_exec( $command );
					echo "Output: $output\n";
				}
				$this->success++;
			} else {
				echo "ERROR: Cannot find global title for $page[title]\n";
			}
		}

		echo "\nTotal wikis: $total, Success: {$this->success}, Failed: ".( $total - $this->success )."\n\n";

	}

	protected function getAllPages( $dbname ) {
		$limit = 20000;
		$db = wfGetDB( DB_SLAVE, [], $dbname );
		$pages = (new WikiaSQL())
			->SELECT( '*' )
			->FROM( 'page' )
			->WHERE( 'page_namespace' )->EQUAL_TO( NS_MAIN )
			->LIMIT( $limit )
			->runLoop( $db, function( &$pages, $row ) {
				$pages[] = [
					'id' => $row->page_id,
					'title' => $row->page_title
				];
			});

		return $pages;
	}
}

$maintClass = "purgeArticlePages";
require_once( RUN_MAINTENANCE_IF_MAIN );
