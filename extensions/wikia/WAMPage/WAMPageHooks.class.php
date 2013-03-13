<?php
class WAMPageHooks {
	/**
	 * @param Title $title
	 * @param Page $article
	 *
	 * @return true because it's a hook
	 */
	public function onArticleFromTitle(&$title, &$article) {
		wfProfileIn(__METHOD__);
		$app = F::app();
		$dbKey = null;

		if( $title instanceof Title ) {
			$dbKey = $title->getDBKey();
		}

		if( !empty($app->wg->EnableWAMPageExt)
			&& ($dbKey === WAMPageArticle::WAM_PAGE_NAME || $dbKey === WAMPageArticle::WAM_FAQ_PAGE_NAME)
		) {
			$article = new WAMPageArticle($title);
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}
