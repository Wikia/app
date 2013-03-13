<?php
class WAMPageHooks {
	const WAM_PAGE_NAME = 'WAM';
	const WAM_FAQ_PAGE_NAME = 'FAQ';
	
	/**
	 * @param Title $title
	 * @param Page $article
	 *
	 * @return true because it's a hook
	 */
	public function onArticleFromTitle(&$title, &$article) {
		wfProfileIn(__METHOD__);
		$app = F::app();
		
		if( !empty($app->wg->EnableWAMPageExt) 
			&& $title instanceof Title 
			&& ($this->isWAMFAQPage($title) || $this->isWAMIndexPage($title)) 
		) {
			die('hook works!');
			$article = new WAMPageArticle($title);
		}

		wfProfileOut(__METHOD__);
		return true;
	}
	
	protected function isWAMIndexPage(Title $title) {
		return !$title->isSubpage() && $title->getDBKey() == self::WAM_PAGE_NAME;
	}
	
	protected function isWAMFAQPage(Title $title) {
		return $title->isSubpage() && $title->getDBKey() == self::WAM_FAQ_PAGE_NAME;
	}
}
