<?php
class VideoPageToolHooks {

	static public function onArticleFromTitle(&$title, &$article) {
		wfProfileIn(__METHOD__);
		$app = F::app();

		$dbKeyName = $title->getDBKey();

		if ( VideoPageController::onHomePage($dbKeyName) && VideoPageController::onVideoWiki() ) {
			$app->wg->SuppressPageHeader = true;
			$app->wg->SuppressWikiHeader = true;
			$app->wg->SuppressRail = true;
			$app->wg->SuppressFooter = true;
			if (!$app->wg->request->wasPosted()) {
				// don't change article object while saving data
				$article = new VideoPageArticle($title);
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}
