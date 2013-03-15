<?php
class WAMPageHooks {
	protected $WamPageConfig = null;
	protected $EnableWAMPageExt = null;
	protected $app = null;

	protected function init() {
		wfProfileIn(__METHOD__);
		
		if( is_null($this->app) ) {
			$this->app = F::app();
		}
		
		foreach(['WamPageConfig', 'EnableWAMPageExt'] as $var) {
			if( is_null($this->$var) ) {
				$this->$var = $this->app->wg->$var;
			}
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
		
		$dbKey = null;
		$wamPageName = mb_strtolower( $this->WamPageConfig['pageName'] );
		$wamPageFaqPageName = mb_strtolower( $this->WamPageConfig['faqPageName'] );
		
		if( $title instanceof Title ) {
			$dbKey = mb_strtolower( $title->getDBKey() );
		}

		if( !empty($this->EnableWAMPageExt) && ($dbKey === $wamPageName || $dbKey === $wamPageFaqPageName) ) {
			$this->app->wg->SuppressPageHeader = true;
			$this->app->wg->SuppressRail = true;
			$article = new WAMPageArticle($title);
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	public function onMakeGlobalVariablesScript(&$vars) {
		$this->init();
		
		if( !empty($this->EnableWAMPageExt) ) {
			$vars['wgWAMPageName'] = $this->WamPageConfig['pageName'];
			$vars['wgWAMFAQPageName'] = $this->WamPageConfig['faqPageName'];
		}

		return true;
	}
}
