<?php
// 0. Enable ReadOnly mode
// 1. Get pages with comments
// 1.1 select DISTINCT SUBSTRING_INDEX(page_title, "/@comment-", 1) as db_key, page_namespace from
//     page where page_namespace in (${commentsNamespaces}) and page_title like '%@comment-%'
// 1.2 map namespace from talk to page namespace MWNamespaces::getSubject
// 1.3 map page name to parent page id (db query)
// 1.4 create Title objects from page ids
// 2 Get comments for titles (ArticleCommentList class?)
// 3 Save it to discussions

/**
 * migrates article comments data to discussions service, see https://wikia-inc.atlassian.net/browse/IW-3046
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class MigrateCommentsToDiscussions extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "migrates article comments data to discussions service";
	}

	/**
	 * Do the actual work. All child classes will need to implement this
	 */
	public function execute() {
		// TODO: Implement execute() method.
	}
}

$maintClass = MigrateCommentsToDiscussions::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
