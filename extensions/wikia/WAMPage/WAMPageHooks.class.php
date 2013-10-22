<?php
class WAMPageHooks {
	static protected $WAMPageConfig = null;
	static protected $EnableWAMPageExt = null;
	static protected $app = null;

	/**
	 * @var WAMPageModel $model
	 */
	static protected $model = null;

	static protected $initialized = false;

	static protected function init() {
		wfProfileIn(__METHOD__);

		if( self::$initialized == false ) {
			self::$app = F::app();
			self::$EnableWAMPageExt = self::$app->wg->EnableWAMPageExt;
			self::$model = new WAMPageModel();
			self::$WAMPageConfig = self::$model->getConfig();

			self::$initialized = true;
		}
		
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * @param Title $title
	 * @param Page $article
	 *
	 * @return true because it's a hook
	 */
	static public function onArticleFromTitle(&$title, &$article) {
		wfProfileIn(__METHOD__);
		self::init();

		if( self::$model->isWAMPage($title) ) {
			self::$app->wg->SuppressPageHeader = true;
			self::$app->wg->SuppressWikiHeader = true;
			self::$app->wg->SuppressRail = true;
			self::$app->wg->SuppressFooter = true;
			$article = new WAMPageArticle($title);
		} else {
			$newTabTitle = self::$model->getWAMRedirect($title);
			if ($newTabTitle instanceof Title) {
				global $wgOut;
				$wgOut->redirect($newTabTitle->getLocalURL(), 301);
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	static public function onMakeGlobalVariablesScript(&$vars) {
		wfProfileIn(__METHOD__);
		
		self::init();
		
		if( !empty(self::$EnableWAMPageExt) ) {
			$vars['wgWAMPageName'] = self::$WAMPageConfig['pageName'];
			$vars['wgWAMFAQPageName'] = self::$WAMPageConfig['faqPageName'];
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @desc If a link goes to WAM page and the WAMPage extension is enabled mark the link as known 
	 * 
	 * @param $skin
	 * @param $target
	 * @param $text
	 * @param $customAttribs
	 * @param $query
	 * @param $options
	 * @param $ret
	 * 
	 * @return bool
	 */
	static public function onLinkBegin($skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret) {
		wfProfileIn(__METHOD__);
		self::init();
		
		if( self::$model->isWAMPage($target) ) {
			$index = array_search('broken', $options);
			unset($options[$index]);
			$options[] = 'known';
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Change canonical url if we are displaying WAM subpages
	 *
	 * @param string $url
	 *
	 * @return bool
	 */
	static public function onWikiaCanonicalHref(&$url) {
		wfProfileIn(__METHOD__);
		self::init();
		
		$title = self::$app->wg->Title;
		if( $title instanceof Title && self::$model->isWAMPage($title) && !self::$model->isWAMFAQPage($title) ) {
			$url = self::$model->getWAMMainPageUrl();
		}

		wfProfileOut(__METHOD__);
		return true;
	}
	
}
