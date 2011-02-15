<?php
class CreateNewWikiModule extends Module {
	
	// global imports
	var $IP;
	var $wgUser;
	var $wgLanguageCode;
	var $wgOasisThemes;
	var $wgSitename;
	
	// form fields
	var $aCategories;
	var $aTopLanguages;
	var $aLanguages;
	
	// form field values
	var $wikiName;
	var $wikiDomain;
	var $wikiLanguage;
	var $wikiCategory;
	var $params;
	
	// state variables
	var $currentStep;
	var $skipWikiaPlus;

	public function executeIndex() {
		global $wgSuppressWikiHeader, $wgSuppressPageHeader, $wgSuppressFooter, $wgSuppressAds, $fbOnLoginJsOverride, $wgRequest, $wgPageQuery;
		wfProfileIn( __METHOD__ );
		
		// hide some default oasis UI things
		$wgSuppressWikiHeader = true;
		$wgSuppressPageHeader = true;
		$wgSuppressFooter = false;
		$wgSuppressAds = true;
		
		// fbconnected means user has gone through step 2 to login via facebook.  
		// Therefore, we need to reload some values and start at the step after signup/login
		$fbconnected = $wgRequest->getVal('fbconnected');
		$fbreturn = $wgRequest->getVal('fbreturn');
		if((!empty($fbconnected) && $fbconnected === '1') || (!empty($fbreturn) && $fbreturn === '1')) {
			$this->executeLoadState();
			$this->currentStep = 'DescWiki';
		} else {
			$this->currentStep = '';
		}
		$wgPageQuery[] = 
		
		// form field values
		$hubs = WikiFactoryHub::getInstance();
		$this->aCategories = $hubs->getCategories();
		$useLang = $wgRequest->getVal('uselang');
		$this->params['wikiLanguage'] = empty($this->params['wikiLanguage']) ? $useLang: $this->params['wikiLanguage'];
		$this->params['wikiLanguage'] = empty($useLang) ? $this->wgLanguageCode : $useLang;  // precedence: selected form field, uselang, default wiki lang
		
		$this->aTopLanguages = explode(',', wfMsg('autocreatewiki-language-top-list'));
		$this->aLanguages = wfGetFixedLanguageNames();
		asort($this->aLanguages);
		
		// facebook callback overwrite on login.  CreateNewWiki re-uses current login stuff.
		$fbOnLoginJsOverride = 'WikiBuilder.fbLoginCallback();';
		
		// If not english, skip Wikia Plus signup step
		$this->skipWikiaPlus = $this->params['wikiLanguage'] != 'en';
		
		wfProfileOut( __METHOD__ );
	}
	
	/**
	 * Ajax call to validate domain.
	 * Called via moduleproxy
	 */
	public function executeCheckDomain() {
		wfProfileIn(__METHOD__);
		global $wgRequest;
		
		$name = $wgRequest->getVal('name');
		$lang = $wgRequest->getVal('lang');
		$type  = $wgRequest->getVal('type');
		
		$this->response = AutoCreateWiki::checkDomainIsCorrect($name, $lang, $type);
		
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * Ajax call for validate wiki name.
	 */
	public function executeCheckWikiName() {
		wfProfileIn(__METHOD__);
		global $wgRequest;
		
		$name = $wgRequest->getVal('name');
		$lang = $wgRequest->getVal('lang');
		
		$this->response = AutoCreateWiki::checkWikiNameIsCorrect($name, $lang);
		
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * Creates wiki
	 */
	public function executeCreateWiki() {
		wfProfileIn(__METHOD__);
		global $wgRequest, $wgDevelDomains;
		
		$params = $wgRequest->getArray('data');
		
		if ( empty($params) || 
			empty($params['wikiName']) || 
			empty($params['wikiDomain']) ||
			empty($params['wikiLanguage']) ||
			empty($params['wikiCategory']) )
		{
			// do nothing
			$this->status = 'error';
		} else {
			$createWiki = new CreateWiki($params['wikiName'], $params['wikiDomain'], $params['wikiLanguage'], $params['wikiCategory']);
			$createWiki->create();
			$this->status = 'ok';
			$this->cityId = $createWiki->getWikiInfo('city_id');
			$finishCreateTitle = GlobalTitle::newFromText("FinishCreate", NS_SPECIAL, $this->cityId);
			$this->finishCreateUrl = empty($wgDevelDomains) ? $finishCreateTitle->getFullURL() : str_replace('.wikia.com', '.'.$wgDevelDomains[0], $finishCreateTitle->getFullURL());
		}
		
		
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * Saves anything in the data in the request into session.
	 * It overwrites any existing values if the keys are the same.
	 * NOTE: calling this while a wiki is being created does not seem to work.  Currently, JS will handle the concurrency issues.
	 */
	public function executeSaveState() {
		wfProfileIn(__METHOD__);
		global $wgRequest, $wgCookieDomain;
		
		$params = empty($_SESSION['wsCreateNewWikiParams']) ? array() : $_SESSION['wsCreateNewWikiParams'];
		
		$data = $wgRequest->getArray('data');
		
		foreach ($data as $key => $value ) {
			$params[$key] = $value;
		}

		$_SESSION['wsCreateNewWikiParams'] = $params;

		wfProfileOut(__METHOD__);
	}
	
	/**
	 * Loads params from session.
	 */
	public function executeLoadState() {
		wfProfileIn(__METHOD__);
		if(!empty($_SESSION['wsCreateNewWikiParams'])) {
			$this->params =  $_SESSION['wsCreateNewWikiParams'];
		}
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * Checks if WikiPayment is enabled and handles fetching PayPal token - if disabled, displays error message
	 *
	 * @author Maciej B?aszkowski <marooned at wikia-inc.com>
	 */
	public function executeUpgradeToPlus() {
		global $wgRequest;
		wfProfileIn( __METHOD__ );
		
		$cityId = $wgRequest->getVal('cityId');
		
		if (method_exists('SpecialWikiPayment', 'fetchPaypalToken')) {
			$data = SpecialWikiPayment::fetchPaypalToken($cityId);
			if (empty($data['url'])) {
				$this->status = 'error';
				$this->caption = wfMsg('owb-step4-error-caption');
				$this->content = wfMsg('owb-step4-error-token-content');
			} else {
				$this->status = 'ok';
				$this->data = $data;
			}
		} else {
			$this->status = 'error';
			$this->caption = wfMsg('owb-step4-error-caption');
			$this->content = wfMsg('owb-step4-error-upgrade-content');
		}
		
		wfProfileOut( __METHOD__ );
	}
	
	/**
	 * empty method for almost static template
	 */
	public function executeWikiWelcomeModal() {
		wfProfileIn(__METHOD__);
		
		wfProfileOut(__METHOD__);
	}
	
	/**
	 * Updates wiki specific properties set from wiki creation wizard.
	 * Context of this method is on the wiki that the values are changing on.
	 * Main wiki creation happens on www, and it will redirect to the newly created wiki.
	 * The values are read from the session and only accessible by the admin.
	 */
	public function executeFinishCreate() {
		global $wgOut;
		$this->executeLoadState();
		
		$mainPage = wfMsgForContent( 'mainpage' );
		
		// set description on main page
		if(!empty($this->params['wikiDescription'])) {
			$mainTitle = Title::newFromText($mainPage);
			$mainId = $mainTitle->getArticleID();
			$mainArticle = Article::newFromID($mainId);
			if (!empty($mainArticle)) {
				$firstSectionText = $mainArticle->getSection($mainArticle->getRawText(), 1);
				$matches = array();
				if(preg_match('/={2,3}[^=]+={2,3}/', $firstSectionText, $matches)) {
					$newSectionText = $mainArticle->replaceSection(1, "{$matches[0]}\n{$this->params['wikiDescription']}");
				} else {
					$newSectionText = $mainArticle->replaceSection(1, $this->params['wikiDescription']);
				}
				$mainArticle->updateArticle($newSectionText, '', false, false);
			}
		}
		
		// set theme
		if(!empty($this->params['color-body'])) {
			$themeSettings = new ThemeSettings();
			$themeSettings->saveSettings($this->params);
		}
		
		$wgOut->redirect($mainPage.'?wiki-welcome=1');
	}

}