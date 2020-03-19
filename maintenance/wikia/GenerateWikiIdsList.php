<?php

/**
 * Maintenance script to gather article comments activity in given period
 * @usage
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ERROR );

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );
// cat wikis.txt | while read line ; do SERVER_ID=$line php maintenance/wikia/ArticleCommentsActivity.php ; done
// SERVER_ID=1308778 php maintenance/wikia/ArticleCommentsActivity.php

/**
 * Class MigrateWikiFactoryToHttps
 */
class GenerateWikiIdsList extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "gets wiki ids list";
	}

	public function execute() {
		global $wgExternalSharedDB;

		$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

		$wikiIds = $db->selectFieldValues(
			'city_list', 'city_id', [ 'city_public' => WikiFactory::PUBLIC_WIKI ]
		);

		file_put_contents('wikis.txt', implode("\n", $wikiIds));
	}
}

$maintClass = "GenerateWikiIdsList";
require_once( RUN_MAINTENANCE_IF_MAIN );
