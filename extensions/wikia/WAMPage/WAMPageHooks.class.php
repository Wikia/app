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

		if( $this->isWAMPage($title) ) {
			$this->app->wg->SuppressPageHeader = true;
			$this->app->wg->SuppressWikiHeader = true;
			$this->app->wg->SuppressRail = true;
			$this->app->wg->SuppressFooter = true;
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
		
		if( $this->isWAMPage($target) ) {
			$index = array_search('broken', $options);
			unset($options[$index]);
			$options[] = 'known';
		}

		wfProfileOut(__METHOD__);
		return true;
	}
	
	protected function isWAMPage($title) {
		wfProfileIn(__METHOD__);
		$this->init();
		$dbKey = null;
		
		if( $title instanceof Title ) {
			$dbKey = mb_strtolower( $title->getDBKey() );
		}

		wfProfileOut(__METHOD__);
		return !empty($this->EnableWAMPageExt) && in_array($dbKey, $this->model->getWamPagesDbKeysLower());
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
		
		if( $title instanceof Title && $this->isWAMPage($title) && !$this->model->isWAMFAQPage($title) ) {
			$url = $this->model->getWAMMainPageUrl();
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}
