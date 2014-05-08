<?php
/**
 * BloglistDeferredPurgeTask
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Blogs;

use Wikia\Tasks\Tasks\BaseTask;

class BlogTask extends BaseTask {
	public function deferredPurge() {
		$db = wfGetDB(DB_SLAVE);
		$articles = [];

		(new \WikiaSQL())
			->SELECT('pp_page')
			->FROM('page_props')
			->WHERE('pp_propname')->EQUAL_TO(BLOGTPL_TAG)
			->runLoop($db, function($unused, $row) {
				$article = \Article::newFromID($row->pp_page);

				if ($article instanceof \Article) {
					$articles[] = $row->pp_page;
					$article->doPurge();
					$article->getTitle()->purgeSquid();
				}
			});

		return $articles;
	}

	public function maintenance() {
		return \BlogArticle::wfMaintenance();
	}
} 