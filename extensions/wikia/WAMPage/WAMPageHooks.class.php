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

		if( !empty($app->wg->WamPageConfig) ) {
			$config = $app->wg->WamPageConfig;
			$wamPageName = mb_strtolower( $config['pageName'] );
			$wamPageFaqPageName = mb_strtolower( $config['faqPageName'] );
		} else {
			return true;
		}
		
		if( $title instanceof Title ) {
			$dbKey = mb_strtolower( $title->getDBKey() );
		}

		if( !empty($app->wg->EnableWAMPageExt) && ( $dbKey === $wamPageName || $dbKey === $wamPageFaqPageName )
		) {
			$article = new WAMPageArticle($title);
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}
