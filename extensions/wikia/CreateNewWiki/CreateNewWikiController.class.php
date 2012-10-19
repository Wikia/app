<?php
class CreateNewWikiController extends WikiaController {

	const DAILY_USER_LIMIT = 2;

	public function index() {
		global $wgSuppressWikiHeader, $wgSuppressPageHeader, $wgSuppressFooter, $wgSuppressAds, $wgSuppressToolbar, $fbOnLoginJsOverride, $wgRequest, $wgUser;
		wfProfileIn( __METHOD__ );

		// hide some default oasis UI things
		$wgSuppressWikiHeader = true;
		$wgSuppressPageHeader = true;
		$wgSuppressFooter = false;
		$wgSuppressAds = true;
		$wgSuppressToolbar = true;

		// store the fact we're on CNW
		F::app()->wg->atCreateNewWikiPage = true;

		// reuiqred for FB Connect to work
		$this->response->addAsset( 'extensions/wikia/UserLogin/js/UserLoginFacebookPageInit.js' );

		// fbconnected means user has gone through step 2 to login via facebook.
		// Therefore, we need to reload some values and start at the step after signup/login
		$fbconnected = $wgRequest->getVal('fbconnected');
		$fbreturn = $wgRequest->getVal('fbreturn');
		if((!empty($fbconnected) && $fbconnected === '1') || (!empty($fbreturn) && $fbreturn === '1')) {
			$this->LoadState();
			$this->currentStep = 'DescWiki';
		} else {
			$this->currentStep = '';
		}

		// form field values
		$hubs = WikiFactoryHub::getInstance();
        $this->aCategories = $hubs->getCategories();

        $this->aTopLanguages = explode(',', wfMsg('autocreatewiki-language-top-list'));
        $languages = wfGetFixedLanguageNames();
		asort( $languages );
		$this->aLanguages = $languages;

		$useLang = $wgRequest->getVal('uselang', $wgUser->getOption( 'language' ));

		// falling back to english (BugId:3538)
		if ( !array_key_exists($useLang, $this->aLanguages) ) {
			$useLang = 'en';
		}
		$params['wikiLanguage'] = empty($useLang) ? $this->wg->LanguageCode : $useLang;  // precedence: selected form field, uselang, default wiki lang
		// facebook callback overwrite on login.  CreateNewWiki re-uses current login stuff.
		$fbOnLoginJsOverride = 'WikiBuilder.fbLoginCallback();';

		// export info if user is logged in
		$this->isUserLoggedIn = $wgUser->isLoggedIn();

		// remove wikia plus for now for all languages
		$this->skipWikiaPlus = true;

		$this->keys = CreateNewWikiObfuscate::generateValidSeeds();
		$_SESSION['cnw-answer'] = CreateNewWikiObfuscate::generateAnswer($this->keys);

		// prefill
		$params['wikiName'] = $wgRequest->getVal('wikiName', '');
		$params['wikiDomain'] = $wgRequest->getVal('wikiDomain', '');
		$this->params = $params;
		$this->signupUrl = '';
		if(!empty($this->wg->EnableUserLoginExt)) {
			$signupTitle = Title::newFromText('UserSignup', NS_SPECIAL);
			$this->signupUrl = $signupTitle->getFullURL();
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Ajax call to validate domain.
	 * Called via nirvana dispatcher
	 */
	public function CheckDomain() {
		wfProfileIn(__METHOD__);
		global $wgRequest;

		$name = $wgRequest->getVal('name');
		$lang = $wgRequest->getVal('lang');
		$type  = $wgRequest->getVal('type');

		$this->res = AutoCreateWiki::checkDomainIsCorrect($name, $lang, $type);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Ajax call for validate wiki name.
	 */
	public function CheckWikiName() {
		wfProfileIn(__METHOD__);

		$wgRequest = $this->app->getGlobal('wgRequest'); /* @var $wgRequest WebRequest */

		$name = $wgRequest->getVal('name');
		$lang = $wgRequest->getVal('lang');

		$this->res = $this->app->runFunction('AutoCreateWiki::checkWikiNameIsCorrect', $name, $lang);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Ajax call to Create wiki
	 */
	public function CreateWiki() {
		wfProfileIn(__METHOD__);
		$wgRequest = $this->app->getGlobal('wgRequest'); /* @var $wgRequest WebRequest */
		$wgDevelDomains = $this->app->getGlobal('wgDevelDomains');
		$wgUser = $this->app->getGlobal('wgUser'); /* @var $wgUser User */

		$params = $wgRequest->getArray('data');

		if ( !empty($params) &&
			(!empty($params['wikiName']) && !empty($params['wikiDomain']) ) )
		{
			// log if called with old params
			trigger_error("CreateWiki called with old params." . $params['wikiName'] . " " . $params['wikiDomain'] . " " . $wgRequest->getIP() . " " . $wgUser->getName() . " " . $wgUser->getId(), E_USER_WARNING);
		}

		if ( !empty($params) &&
			(!empty($params['wikiaName']) && !empty($params['wikiaDomain']) ) )
		{
			// log if called with old params
			trigger_error("CreateWiki called with 2nd old params." . $params['wikiaName'] . " " . $params['wikiaDomain'] . " " . $wgRequest->getIP() . " " . $wgUser->getName() . " " . $wgUser->getId(), E_USER_WARNING);
		}

		if ( empty($params) ||
			empty($params['wName']) ||
			empty($params['wDomain']) ||
			empty($params['wLanguage']) ||
			empty($params['wCategory']))
		{
			// do nothing
			$this->status = 'error';
			$this->statusMsg = $this->app->runFunction('wfMsg', 'cnw-error-general');
			$this->statusHeader = $this->app->runFunction('wfMsg', 'cnw-error-general-heading');
		} else {
			/*
			$stored_answer = $this->getStoredAnswer();
			if(empty($stored_answer) || $params['wAnswer'].'' !== $stored_answer.'') {
				$this->status = 'error';
				$this->statusMsg = $this->app->runFunction('wfMsgExt', 'cnw-error-bot', array('parseinline'));
				$this->statusHeader = $this->app->runFunction('wfMsg', 'cnw-error-bot-header');
				return;
			}
			*/

			// check if user is blocked
			if ( $wgUser->isBlocked() ) {
				$this->status = 'error';
				$this->statusMsg = $this->app->wf->msg( 'cnw-error-blocked', $wgUser->blockedBy(), $wgUser->blockedFor(), $wgUser->getBlockId() );
				$this->statusHeader = $this->app->wf->msg( 'cnw-error-blocked-header' );
				return;
			}

			// check if user is a tor node
			if ( class_exists( 'TorBlock' ) && TorBlock::isExitNode() ) {
				$this->status = 'error';
				$this->statusMsg = $this->app->wf->msg( 'cnw-error-torblock' );
				$this->statusHeader = $this->app->wf->msg( 'cnw-error-blocked-header' );
				return;
			}

			// check if user created more wikis than we allow per day
			$numWikis = $this->countCreatedWikis($wgUser->getId());
			if($numWikis >= self::DAILY_USER_LIMIT && $wgUser->isPingLimitable() && !$wgUser->isAllowed( 'createwikilimitsexempt' ) ) {
				$this->status = 'wikilimit';
				$this->statusMsg = $this->app->runFunction('wfMsgExt', 'cnw-error-wiki-limit', array( 'parsemag' ), self::DAILY_USER_LIMIT);
				$this->statusHeader = $this->app->runFunction('wfMsg', 'cnw-error-wiki-limit-header');
				return;
			}

			$createWiki = F::build('CreateWiki', array($params['wName'], $params['wDomain'], $params['wLanguage'], $params['wCategory'])); /* @var $createWiki CreateWiki */
			$error_code = $createWiki->create();
			$cityId = $createWiki->getWikiInfo('city_id');
			if(empty($cityId)) {
				$this->status = 'backenderror';
				$this->statusMsg = $this->app->runFunction('wfMsg', 'cnw-error-database', $error_code).
					'<br>'.
					$this->app->runFunction('wfMsg', 'cnw-error-general');
				$this->statusHeader = $this->app->runFunction('wfMsg', 'cnw-error-general-heading');
				trigger_error("Failed to create new wiki: $error_code " . $params['wName'] . " " . $params['wLanguage'] . " " . $wgRequest->getIP(), E_USER_WARNING);
			} else {
				$this->status = 'ok';
				$this->siteName = $createWiki->getWikiInfo('sitename');
				$this->cityId = $cityId;
				$finishCreateTitle = F::build('GlobalTitle', array("FinishCreate", NS_SPECIAL, $cityId), 'newFromText');
				$this->finishCreateUrl = empty($wgDevelDomains) ? $finishCreateTitle->getFullURL() : str_replace('.wikia.com', '.'.$wgDevelDomains[0], $finishCreateTitle->getFullURL());
			}
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * a method that exists purely for unit test.  yay.  it shouldn't be public either
	 */
	public function getStoredAnswer() {
		return $_SESSION['cnw-answer'];
	}

	/**
	 * Loads params from cookie.
	 */
	protected function LoadState() {
		wfProfileIn(__METHOD__);
		if(!empty($_COOKIE['createnewwiki'])) {
			$this->params = json_decode($_COOKIE['createnewwiki'], true);
		} else {
			$this->params = array();
		}
		wfProfileOut(__METHOD__);
	}

	public function Phalanx() {
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		$text = $wgRequest->getVal('text','');
		$blockedKeywords = array();

		$filters = Phalanx::getFromFilter( Phalanx::TYPE_CONTENT );
		foreach( $filters as $filter ) {
			$result = Phalanx::isBlocked( $text, $filter );
			if($result['blocked']) {
				$blockedKeywords[] = $result['msg'];
			}
		}

		$this->msgHeader = '';
		$this->msgBody = '';
		if(count($blockedKeywords) > 0) {
			$keywords = '';
			for ($i = 0; $i < count($blockedKeywords); $i++) {
				if($i != 0) {
					$keywords .= ', ';
				}
				$keywords .= $blockedKeywords[$i];
			}
			$this->msgHeader = wfMsg('cnw-badword-header');
			$this->msgBody = wfMsg('cnw-badword-msg', $keywords);
		}

		wfProfileOut( __METHOD__ );
	}

	public static function setupCreateNewWiki() {
		F::addClassConstructor('CreateNewWikiModule', array(F::app()));
	}

	/**
	 * get number of created Wikis for current day
	 * note: copied from autocreatewiki
	 */
	private function countCreatedWikis($iUser = 0) {
		global $wgExternalSharedDB;
		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$where = array( "date_format(city_created, '%Y%m%d') = date_format(now(), '%Y%m%d')" );
		if ( !empty($iUser) ) {
			$where[] = "city_founding_user = '{$iUser}' ";
		}
		$oRow = $dbr->selectRow(
			"city_list",
			array( "count(*) as count" ),
			$where,
			__METHOD__
		);

		wfProfileOut( __METHOD__ );
		return intval($oRow->count);
	}

}
