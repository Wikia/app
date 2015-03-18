<?php

use Wikia\Logger\Loggable;

class CreateNewWikiController extends WikiaController {

	use Loggable;

	const DAILY_USER_LIMIT = 2;
	const WF_WDAC_REVIEW_FLAG_NAME = 'wgWikiDirectedAtChildrenByFounder';

	const LANG_ALL_AGES_OPT = 'en';

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
		$this->wg->atCreateNewWikiPage = true;

		if ( !$this->wg->User->isLoggedIn() && !empty( $this->wg->EnableFacebookClientExt ) ) {
			// required for FB Connect to work
			$this->response->addAsset( 'extensions/wikia/UserLogin/js/UserLoginFacebookPageInit.js' );
		}

		// fbconnected means user has gone through step 2 to login via facebook.
		// Therefore, we need to reload some values and start at the step after signup/login
		$fbconnected = $wgRequest->getVal('fbconnected');
		$fbreturn = $wgRequest->getVal('fbreturn');
		if((!empty($fbconnected) && $fbconnected === '1') || (!empty($fbreturn) && $fbreturn === '1')) {
			$this->LoadState();
			$currentStep = 'DescWiki';
		} else {
			$currentStep = '';
		}

		$this->setupVerticalsAndCategories();

		$this->aTopLanguages = explode(',', wfMsg('autocreatewiki-language-top-list'));
		$languages = wfGetFixedLanguageNames();
		asort( $languages );
		$this->aLanguages = $languages;

		$useLang = $wgRequest->getVal('uselang', $wgUser->getOption( 'language' ));

		// squash language dialects (same wiki language for different dialects)
		$useLang = $this->squashLanguageDialects($useLang);

		// falling back to english (BugId:3538)
		if ( !array_key_exists($useLang, $this->aLanguages) ) {
			$useLang = 'en';
		}
		$params['wikiLanguage'] = empty($useLang) ? $this->wg->LanguageCode : $useLang;  // precedence: selected form field, uselang, default wiki lang

		// export info if user is logged in
		$this->isUserLoggedIn = $wgUser->isLoggedIn();

		// remove wikia plus for now for all languages
		$skipWikiaPlus = true;

		$keys = CreateNewWikiObfuscate::generateValidSeeds();
		$_SESSION['cnw-answer'] = CreateNewWikiObfuscate::generateAnswer($this->keys);

		$this->wg->Out->addJsConfigVars([
			'wgLangAllAgesOpt' => self::LANG_ALL_AGES_OPT
		]);
		// prefill
		$params['wikiName'] = $wgRequest->getVal('wikiName', '');
		$params['wikiDomain'] = $wgRequest->getVal('wikiDomain', '');
		$params['LangAllAgesOpt'] = self::LANG_ALL_AGES_OPT;
		$this->params = $params;
		$this->signupUrl = '';
		$signupTitle = Title::newFromText('UserSignup', NS_SPECIAL);
		if ( $wgRequest->getInt( 'nocaptchatest' ) ) {
			$this->signupUrl = $signupTitle->getFullURL('nocaptchatest=1');
		} else {
			$this->signupUrl = $signupTitle->getFullURL();
		}

		// Make various parsed messages and status available in JS
		// Necessary because JSMessages does not support parsing
		$this->wikiBuilderCfg = array(
			'name-wiki-submit-error' => wfMessage( 'cnw-name-wiki-submit-error' )->escaped(),
			'desc-wiki-submit-error' => wfMessage( 'cnw-desc-wiki-submit-error' )->escaped(),
			'currentstep' => $currentStep,
			'skipwikiaplus' => $skipWikiaPlus,
			'descriptionplaceholder' => wfMessage( 'cnw-desc-placeholder' )->escaped(),
			'cnw-error-general' => wfMessage( 'cnw-error-general' )->parse(),
			'cnw-error-general-heading' => wfMessage( 'cnw-error-general-heading' )->escaped(),
			'cnw-keys' => $keys
		);

		// theme designer application theme settings
		$this->applicationThemeSettings = SassUtil::getApplicationThemeSettings();

		wfProfileOut( __METHOD__ );
	}

	private function setupVerticalsAndCategories() {
		$allVerticals = WikiFactoryHub::getInstance()->getAllVerticals();
		$allCategories = WikiFactoryHub::getInstance()->getAllCategories( true );

		// Defines order in which verticals are going to be displayed in the <select>
		$verticalsOrder = array( 2, 7, 4, 3, 1, 6, 5, 0 );

		// Defines sets of categories and order of categories in each set
		$categoriesSetsOrder = array(
			1 => array( 28, 23, 24, 25, 27, 16, 21, 22),
			2 => array( 28, 18, 17, 8, 25, 10, 6, 26, 1, 14, 11, 13, 15, 12, 5, 7)
		);

		// Defines mapping between vertical and categories set
		$verticalToCategoriesSetMapping = array( 2 => 1, 7 => 1, 4 => 1, 3 => 1, 1 => 1, 6 => 1, 5 => 2, 0 => 2 );

		/**
		 * Current keys for translating Vertical ID to string:
		 * 'oasis-label-wiki-vertical-id-0' => 'Other',
		 * 'oasis-label-wiki-vertical-id-1' => 'TV',
		 * 'oasis-label-wiki-vertical-id-2' => 'Video Games',
		 * 'oasis-label-wiki-vertical-id-3' => 'Books',
		 * 'oasis-label-wiki-vertical-id-4' => 'Comics',
		 * 'oasis-label-wiki-vertical-id-5' => 'Lifestyle',
		 * 'oasis-label-wiki-vertical-id-6' => 'Music',
		 * 'oasis-label-wiki-vertical-id-7' => 'Movies',
		 */
		$this->verticals = [];
		foreach($verticalsOrder as $verticalId) {
			$verticalData = $allVerticals[$verticalId];
			$this->verticals[] = [
				'id' => $verticalData['id'],
				'name' => wfMessage( 'oasis-label-wiki-vertical-id-' . $verticalData['id'] )->escaped(),
				'short' => $verticalData['short'],
				'categoriesSet' => $verticalToCategoriesSetMapping[$verticalId]
			];
		}

		/**
		 * Current keys for translating Category ID to string:
		 * 'oasis-label-wiki-category-id-1' => 'Humor',
		 * 'oasis-label-wiki-category-id-5' => 'Toys',
		 * 'oasis-label-wiki-category-id-6' => 'Food and Drink',
		 * 'oasis-label-wiki-category-id-7' => 'Travel',
		 * 'oasis-label-wiki-category-id-8' => 'Education',
		 * 'oasis-label-wiki-category-id-10' => 'Finance',
		 * 'oasis-label-wiki-category-id-11' => 'Politics',
		 * 'oasis-label-wiki-category-id-12' => 'Technology',
		 * 'oasis-label-wiki-category-id-13' => 'Science',
		 * 'oasis-label-wiki-category-id-14' => 'Philosophy',
		 * 'oasis-label-wiki-category-id-15' => 'Sports',
		 * 'oasis-label-wiki-category-id-16' => 'Music',
		 * 'oasis-label-wiki-category-id-17' => 'Creative',
		 * 'oasis-label-wiki-category-id-18' => 'Auto',
		 * 'oasis-label-wiki-category-id-21' => 'TV',
		 * 'oasis-label-wiki-category-id-22' => 'Video Games',
		 * 'oasis-label-wiki-category-id-23' => 'Books',
		 * 'oasis-label-wiki-category-id-24' => 'Comics',
		 * 'oasis-label-wiki-category-id-25' => 'Fanon',
		 * 'oasis-label-wiki-category-id-26' => 'Home and Garden',
		 * 'oasis-label-wiki-category-id-27' => 'Movies',
		 * 'oasis-label-wiki-category-id-28' => 'Anime',
		 */
		$this->categoriesSets = [];
		foreach($categoriesSetsOrder as $setId => $categoriesOrder) {
			$categoriesSet = [];
			foreach($categoriesOrder as $categoryId) {
				$categoryData = $allCategories[$categoryId];
				$categoryData['name'] = wfMessage( 'oasis-label-wiki-category-id-' . $categoryId )->escaped();
				$categoriesSet[] = $categoryData;
			}
			$this->categoriesSets[$setId] = $categoriesSet;
		}
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

		$this->res = AutoCreateWiki::checkDomainIsCorrect($name, $lang);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Ajax call for validate wiki name.
	 */
	public function CheckWikiName() {
		wfProfileIn(__METHOD__);

		$wgRequest = $this->wg->Request;

		$name = $wgRequest->getVal('name');
		$lang = $wgRequest->getVal('lang');

		$this->res = AutoCreateWiki::checkWikiNameIsCorrect($name, $lang);

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

        //CE-315
        if($params['wLanguage'] != self::LANG_ALL_AGES_OPT ){
            $params['wAllAges'] = null;
        }

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
			(!isset($params['wVertical']) || $params['wVertical'] === '-1'))
		{
			// do nothing
			$this->status = 'error';
			// VOLDEV-10: Parse the HTML in the message
			$this->statusMsg = wfMessage( 'cnw-error-general' )->parse();
			$this->statusHeader = wfMessage( 'cnw-error-general-heading' )->escaped();
		} else {
			/*
			$stored_answer = $this->getStoredAnswer();
			if(empty($stored_answer) || $params['wAnswer'].'' !== $stored_answer.'') {
				$this->status = 'error';
				$this->statusMsg = wfMsgExt( 'cnw-error-bot', array('parseinline') );
				$this->statusHeader = wfMsg( 'cnw-error-bot-header');
				return;
			}
			*/

			// check if user is logged in
			if ( !$wgUser->isLoggedIn() ) {
				$this->status = 'error';
				$this->statusMsg = wfMessage( 'cnw-error-anon-user' )->parse();
				$this->statusHeader = wfMessage( 'cnw-error-anon-user-header' )->text();
				wfProfileOut(__METHOD__);
				return;
			}

			// check if user has confirmed e-mail
			if ( !$wgUser->isEmailConfirmed() ) {
				$this->status = 'error';
				$this->statusMsg = wfMessage( 'cnw-error-unconfirmed-email' )->parse();
				$this->statusHeader = wfMessage( 'cnw-error-unconfirmed-email-header' )->text();
				wfProfileOut(__METHOD__);
				return;
			}

			// check if user is blocked
			if ( $wgUser->isBlocked() ) {
				$this->status = 'error';
				$this->statusMsg = wfMsg( 'cnw-error-blocked', $wgUser->blockedBy(), $wgUser->blockedFor(), $wgUser->getBlockId() );
				$this->statusHeader = wfMsg( 'cnw-error-blocked-header' );
				wfProfileOut(__METHOD__);
				return;
			}

			// check if user is a tor node
			if ( class_exists( 'TorBlock' ) && TorBlock::isExitNode() ) {
				$this->status = 'error';
				$this->statusMsg = wfMsg( 'cnw-error-torblock' );
				$this->statusHeader = wfMsg( 'cnw-error-blocked-header' );
				wfProfileOut(__METHOD__);
				return;
			}

			// check if user created more wikis than we allow per day
			$numWikis = $this->countCreatedWikis($wgUser->getId());
			if($numWikis >= self::DAILY_USER_LIMIT && $wgUser->isPingLimitable() && !$wgUser->isAllowed( 'createwikilimitsexempt' ) ) {
				$this->status = 'wikilimit';
				$this->statusMsg = wfMsgExt('cnw-error-wiki-limit', array( 'parsemag' ), self::DAILY_USER_LIMIT);
				$this->statusHeader = wfMsg('cnw-error-wiki-limit-header');
				wfProfileOut(__METHOD__);
				return;
			}

			$categories = isset($params['wCategories']) ? $params['wCategories'] : array();

			$createWiki = new CreateWiki($params['wName'], $params['wDomain'], $params['wLanguage'], $params['wVertical'], $categories);

			try {
				$createWiki->create();
			}
			catch(Exception $ex) {
				$error_code = $ex->getCode();

				$this->status = 'backenderror';
				$this->statusMsg = wfMessage( 'cnw-error-general' )->parse();
				$this->statusHeader = wfMessage( 'cnw-error-general-heading' )->escaped();

				$this->error('CreateWiki: failed to create new wiki', [
					'code' => $error_code,
					'params' => $params,
					'exception' => $ex
				]);

				wfProfileOut( __METHOD__);
				return;
			}

			$cityId = $createWiki->getWikiInfo('city_id');

			if ( isset($params['wAllAges']) && !empty( $params['wAllAges'] ) ) {
				WikiFactory::setVarByName( self::WF_WDAC_REVIEW_FLAG_NAME, $cityId, true, __METHOD__ );
			}
			$this->status = 'ok';
			$this->siteName = $createWiki->getWikiInfo('sitename');
			$this->cityId = $cityId;
			$finishCreateTitle = GlobalTitle::newFromText("FinishCreate", NS_SPECIAL, $cityId);
			$this->finishCreateUrl = empty($wgDevelDomains) ? $finishCreateTitle->getFullURL() : str_replace('.wikia.com', '.'.$wgDevelDomains[0], $finishCreateTitle->getFullURL());

			$this->info('CreateWiki: completed', [
				'city_id' => $cityId,
				'params' => $params,
			]);
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
		$blockedKeyword = '';

		wfRunHooks( 'CheckContent', array( $text, &$blockedKeyword ) );

		$this->msgHeader = '';
		$this->msgBody = '';
		if ( !empty( $blockedKeyword ) ) {
			$this->msgHeader = wfMsg('cnw-badword-header');
			$this->msgBody = wfMsg('cnw-badword-msg', $blockedKeyword);
		}

		wfProfileOut( __METHOD__ );
	}

	public static function setupCreateNewWiki() {
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

	/**
	 * Return proper wiki language for for languages that have different dialects.
	 */
	private function squashLanguageDialects($useLang) {
		$squashLanguageData = array(
			'zh-tw' => 'zh',
			'zh-hk' => 'zh',
			'zh-clas' => 'zh',
			'zh-class' => 'zh',
			'zh-classical' => 'zh',
			'zh-cn' => 'zh',
			'zh-hans' => 'zh',
			'zh-hant' => 'zh',
			'zh-min-' => 'zh',
			'zh-min-n' => 'zh',
			'zh-mo' => 'zh',
			'zh-sg' => 'zh',
			'zh-yue' => 'zh',
		);

		return array_key_exists($useLang, $squashLanguageData) ? $squashLanguageData[$useLang] : $useLang;
	}
}
