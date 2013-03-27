<?php
class WAMPageHooks {
	protected $WAMPageConfig = null;
	protected $EnableWAMPageExt = null;
	protected $app = null;

	protected function init() {
		wfProfileIn(__METHOD__);
		
		if( is_null($this->app) ) {
			$this->app = F::app();
		}
		
		if( is_null($this->EnableWAMPageExt) ) {
			$this->EnableWAMPageExt = $this->app->wg->EnableWAMPageExt;
		}

		if( is_null($this->WAMPageConfig) ) {
			$WAMPageModel = new WAMPageModel();
			$this->WAMPageConfig = $WAMPageModel->getConfig();
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
		$this->init();
		
		if( !empty($this->EnableWAMPageExt) ) {
			$vars['wgWAMPageName'] = $this->WAMPageConfig['pageName'];
			$vars['wgWAMFAQPageName'] = $this->WAMPageConfig['faqPageName'];
		}

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
		$this->init();
		
		if( $this->isWAMPage($target) ) {
			$index = array_search('broken', $options);
			unset($options[$index]);
			$options[] = 'known';
		}

		return true;
	}
	
	protected function isWAMPage($title) {
		$dbKey = null;
		$wamPageName = mb_strtolower( $this->WAMPageConfig['pageName'] );
		$wamPageFaqPageName = mb_strtolower( $this->WAMPageConfig['faqPageName'] );

		if( $title instanceof Title ) {
			$dbKey = mb_strtolower( $title->getDBKey() );
		}
		
		return !empty($this->EnableWAMPageExt) && ($dbKey === $wamPageName || $dbKey === $wamPageFaqPageName);
	}
}
