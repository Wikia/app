<?php
class WAMPageHooks {
	protected $WAMPageConfig = null;
	protected $EnableWAMPageExt = null;
	protected $app = null;

	/**
	 * @var WAMPageModel $model
	 */
	protected $model = null;

	protected function init() {
		wfProfileIn(__METHOD__);
		
		if( is_null($this->app) ) {
			$this->app = F::app();
		}
		
		if( is_null($this->EnableWAMPageExt) ) {
			$this->EnableWAMPageExt = $this->app->wg->EnableWAMPageExt;
		}
		
		if( is_null($this->model) ) {
			$this->model = new WAMPageModel();
		}

		if( is_null($this->WAMPageConfig) ) {
			$this->WAMPageConfig = $this->model->getConfig();
		}
		
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * @param Title $title
	 * @param Page $article
	 *
	 * @return true because it's a hook
	 */
	public function onArticleFromTitle(&$title, &$article) {
		wfProfileIn(__METHOD__);
		$this->init();

		if( $this->model->isWAMPage($title) ) {
			$this->app->wg->SuppressPageHeader = true;
			$this->app->wg->SuppressWikiHeader = true;
			$this->app->wg->SuppressRail = true;
			$this->app->wg->SuppressFooter = true;
			
			$this->redirectIfMisspelledMainPage($title);
			$article = new WAMPageArticle($title);
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	public function onMakeGlobalVariablesScript(&$vars) {
		wfProfileIn(__METHOD__);
		
		$this->init();
		
		if( !empty($this->EnableWAMPageExt) ) {
			$vars['wgWAMPageName'] = $this->WAMPageConfig['pageName'];
			$vars['wgWAMFAQPageName'] = $this->WAMPageConfig['faqPageName'];
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
	public function onLinkBegin($skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret) {
		wfProfileIn(__METHOD__);
		$this->init();
		
		if( $this->model->isWAMPage($target) ) {
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
	 * @param Title  $title
	 *
	 * @return bool
	 */
	public function onWikiaCanonicalHref(&$url, $title) {
		wfProfileIn(__METHOD__);
		$this->init();
		
		if( $title instanceof Title && $this->model->isWAMPage($title) && !$this->model->isWAMFAQPage($title) ) {
			$url = $this->model->getWAMMainPageUrl();
		}

		wfProfileOut(__METHOD__);
		return true;
	}
	
	private function redirectIfMisspelledMainPage($title) {
		wfProfileIn(__METHOD__);
		
		// we don't check here if $title is instance of Title
		// because this method is called after this check and isWAMPage() check
		
		$this->init();
		$dbkey = $title->getDbKey();
		$mainPage = $this->model->getWAMMainPageName();
		$isMainPage = (mb_strtolower($dbkey) === mb_strtolower($mainPage));
		$isMisspeledMainPage = !($dbkey === $mainPage);
		
		if( $isMainPage && $isMisspeledMainPage ) {
			$this->app->wg->Out->redirect($this->model->getWAMMainPageUrl(), HTTP_REDIRECT_PERM);
		}

		wfProfileOut(__METHOD__);
	}
}
