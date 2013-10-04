<?php
class VideoPageToolHooks {

	static public function onArticleFromTitle(&$title, &$article) {
		wfProfileIn(__METHOD__);
		$app = F::app();

		if ( $title->isMainPage() ) {
			$app->wg->SuppressPageHeader = true;
			$app->wg->SuppressWikiHeader = true;
			$app->wg->SuppressRail = true;
			$app->wg->SuppressFooter = true;
			if (!$app->wg->request->wasPosted()) {
				// don't change article object while saving data
				$article = new VideoHomePageArticle($title);
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}
	/**
	 * Add assets to mobile video home page
	 *
	 * @param array $jsStaticPackages
	 * @param array $jsExtensionPackages
	 * @param array $scssPackages
	 * @return bool
	 */
	static public function onWikiaMobileAssetsPackages( Array &$jsStaticPackages, Array &$jsExtensionPackages, Array &$scssPackages ){
		if( F::app()->wg->Title->isMainPage() ) {
			$scssPackages[] = 'videohomepage_scss_mobile';
		}

		return true;
	}
}
