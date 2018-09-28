<?php

use Wikia\Logger\Loggable;

class CreateNewWikiController extends WikiaController {
	use Loggable;

	const STATUS_MSG_FIELD         = 'statusMsg';
	const STATUS_HEADER_FIELD      = 'statusHeader';
	const STATUS_FIELD             = 'status';
	const STATUS_ERROR             = 'error';
	const STATUS_CREATION_LIMIT    = 'wikilimit';
	const STATUS_BACKEND_ERROR     = 'backenderror';
	const ERROR_CLASS_FIELD        = 'errClass';
	const ERROR_CODE_FIELD         = 'errCode';
	const ERROR_MESSAGE_FIELD      = 'errMessage';
	const STATUS_OK                = 'ok';
	const STATUS_NOT_FOUND         = 'taskNotFound';
	const STATUS_IN_THE_QUEUE      = 'waitingForTheQueue';
	const STATUS_IN_PROGRESS       = 'inProgress';
	const SITE_NAME_FIELD          = 'siteName';
	const CITY_ID_FIELD            = 'cityId';
	const CHECK_RESULT_FIELD       = 'res';
	const DAILY_USER_LIMIT         = 2;

	public function index() {
		global $wgSuppressCommunityHeader, $wgSuppressPageHeader, $wgSuppressFooter, $wgSuppressToolbar,
			   $wgRequest, $wgUser, $wgWikiaBaseDomain, $wgCreateEnglishWikisOnFandomCom, $wgFandomBaseDomain,
			   $wgAllowCommunityBuilderCNWPrompt;
		wfProfileIn( __METHOD__ );

		// hide some default oasis UI things
		$wgSuppressCommunityHeader = true;
		$wgSuppressPageHeader = true;
		$wgSuppressFooter = false;
		$wgSuppressToolbar = true;

		// store the fact we're on CNW
		$this->wg->atCreateNewWikiPage = true;
		$currentStep = '';

		$this->setupVerticalsAndCategories();

		$this->aTopLanguages = WikiaLanguage::getSupportedLanguages();
		$languages = WikiaLanguage::getRequestSupportedLanguages();
		asort( $languages );
		$this->aLanguages = $languages;

		$useLang = $wgRequest->getVal('uselang', $wgUser->getGlobalPreference( 'language' ));

		// squash language dialects (same wiki language for different dialects)
		$useLang = $this->squashLanguageDialects($useLang);

		// falling back to english (BugId:3538)
		if ( !array_key_exists($useLang, $this->aLanguages) ) {
			$useLang = 'en';
		}
		$params['wikiLanguage'] = empty($useLang) ? $this->wg->LanguageCode : $useLang;  // precedence: selected form field, uselang, default wiki lang

		// export info if user is logged in
		$this->isUserLoggedIn = $wgUser->isLoggedIn();

		// prefill
		$params['wikiName'] = $wgRequest->getVal('wikiName', '');
		$params['wikiDomain'] = $wgRequest->getVal('wikiDomain', '');
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
			'descriptionplaceholder' => wfMessage( 'cnw-desc-placeholder' )->escaped(),
			'cnw-error-general' => wfMessage( 'cnw-error-general' )->parse(),
			'cnw-error-general-heading' => wfMessage( 'cnw-error-general-heading' )->escaped(),
		);

		$this->allowCommunityBuilderOptIn = !empty($wgAllowCommunityBuilderCNWPrompt) || !empty($_GET['forceShowCBOptIn']);
		$this->communityBuilderPrompt = $this->allowCommunityBuilderOptIn ?
			F::app()->renderView('CreateNewWiki', 'CommunityBuilderOptInPrompt') :
			'';
		$this->communityBuilderModal = $this->allowCommunityBuilderOptIn ?
			F::app()->renderView('CreateNewWiki', 'CommunityBuilderModal') :
			'';

		// theme designer application theme settings
		$this->applicationThemeSettings = SassUtil::getApplicationThemeSettings();

		$this->wikiBaseDomain = $wgCreateEnglishWikisOnFandomCom ? $wgFandomBaseDomain : $wgWikiaBaseDomain;

		wfProfileOut( __METHOD__ );
	}

	public function communityBuilderOptInPrompt() {
		// needed so the dispatcher doesn't whine
	}

	public function communityBuilderModal() {
		// needed so the dispatcher doesn't whine
	}

	private function setupVerticalsAndCategories() {
		$allVerticals = WikiFactoryHub::getInstance()->getAllVerticals();
		$allCategories = WikiFactoryHub::getInstance()->getAllCategories( true );

		// Defines order in which verticals are going to be displayed in the <select>
		$verticalsOrder = array( 2, 7, 4, 3, 1, 6, 5 );

		// Defines sets of categories and order of categories in each set
		$categoriesSetsOrder = array(
			1 => array( 28, 23, 24, 25, 27, 16, 21, 22),
			2 => array( 28, 18, 17, 8, 25, 10, 6, 26, 1, 14, 11, 13, 15, 12, 5, 7)
		);

		// Defines mapping between vertical and categories set
		$verticalToCategoriesSetMapping = array( 2 => 1, 7 => 1, 4 => 1, 3 => 1, 1 => 1, 6 => 1, 5 => 2 );

		/**
		 * Current keys for translating Vertical ID to string:
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

		$this->response->setVal( self::CHECK_RESULT_FIELD, CreateWikiChecks::checkDomainIsCorrect($name, $lang) );

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

		$this->response->setVal( self::CHECK_RESULT_FIELD,  CreateWikiChecks::checkWikiNameIsCorrect($name, $lang) );

		wfProfileOut(__METHOD__);
	}

	/**
	 * Ajax call to Create wiki
	 *
	 * @throws BadRequestException
	 */
	public function CreateWiki() {
		global $wgUser;

		wfProfileIn(__METHOD__);
		$this->checkWriteRequest();

		$params = $this->getRequest()->getArray('data');
		$fandomCreatorCommunityId = $this->getRequest()->getVal( 'fandomCreatorCommunityId' );

		// SUS-5393 | wVertical is expected to be a numeric value
		$params['wVertical'] = (int) $params['wVertical'];

		if ( empty($params) ||
			empty($params['wName']) ||
			empty($params['wDomain']) ||
			empty($params['wLanguage']) ||
			(empty($params['wVertical']) || $params['wVertical'] === -1))
		{
			// do nothing
			$this->warning(__METHOD__ . ": no parameters provided" );
			$this->response->setCode( 400 );
			$this->response->setVal( self::STATUS_FIELD, self::STATUS_ERROR );
			// VOLDEV-10: Parse the HTML in the message
			$this->response->setVal( self::STATUS_MSG_FIELD, wfMessage( 'cnw-error-general' )->parse() );
			$this->response->setVal( self::STATUS_HEADER_FIELD, wfMessage( 'cnw-error-general-heading' )->escaped() );

			wfProfileOut(__METHOD__);
			return;
		}

		// check if user is logged in
		if ( !$wgUser->isLoggedIn() ) {
			$this->setUserNotLoggedInErrorResponse();
			wfProfileOut(__METHOD__);
			return;
		}

		// check if user is blocked
		if ( $wgUser->isBlocked() ) {
			$this->setUserIsBlockedErrorResponse( $wgUser );
			wfProfileOut(__METHOD__);
			return;
		}

		//check if description content pass phalanx blocks
		if ( !empty( $params[ 'wDescription' ] ) ) {
			$blockedKeyword = '';
			Hooks::run( 'CheckContent', array( $params[ 'wDescription' ], &$blockedKeyword ) );
			if ( !empty( $blockedKeyword ) ) {
				$this->setContentBlockedByPhalanxErrorResponse( $params[ 'wDescription' ], $blockedKeyword );
				wfProfileOut( __METHOD__ );
				return;
			}
		}

		// check if user created more wikis than we allow per day
		$numWikis = $this->countCreatedWikis($wgUser->getId());
		if($numWikis >= self::DAILY_USER_LIMIT && $wgUser->isPingLimitable() && !$wgUser->isAllowed( 'createwikilimitsexempt' ) ) {
			$this->setTooManyWikiCreatedByUserErrorResponse();
			wfProfileOut(__METHOD__);
			return;
		}

		// SUS-4383 | use an offline Celery task to create a wiki
		$task = CreateWikiTask::newLocalTask();

		$categories = isset($params['wCategories']) ? $params['wCategories'] : array();
		$allAges = isset($params['wAllAges']) && !empty( $params['wAllAges'] );
		$wikiDescription = !empty( $params['wDescription'] ) ? $params['wDescription'] : '';

		$task->call( 'create', $params['wName'], $params['wDomain'], $params['wLanguage'],
			$params['wVertical'], $wikiDescription , $categories, $allAges, time(),
			$this->getContext()->getRequest()->getIP(),
			$fandomCreatorCommunityId );
		$task_id = $task->setQueue( Wikia\Tasks\Queues\PriorityQueue::NAME )->queue();

		// return ID of the created task ID, front-end code will poll its status
		// e.g {"task_id":"mw-04CF2876-2176-4036-96E5-B6378DB1AC8E"}
		$this->response->setCode( 201 ); // HTTP 201 Created
		$this->response->setVal( 'task_id', $task_id );

		// return timestamp, so that front-end can send it back to the backend
		// we'll compare it with the current timestamp in CheckStatus method
		$this->response->setVal( 'timestamp', time() );

		wfProfileOut(__METHOD__);
	}

	/**
	 * This AJAX entry point is used to poll for wiki creation status
	 *
	 * @see SUS-4383
	 */
	public function CheckStatus() {
		global $wgDevelDomains;

		$task_id = (string) $this->getRequest()->getVal('task_id');
		$task_details = CreateWikiTask::getCreationLogEntry( $task_id );

		// do not cache, we always want to hit the backend as the response can change anytime
		$this->response->setCachePolicy( WikiaResponse::CACHE_PRIVATE );
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
		$this->response->setFormat( 'json' );

		// compare the timestamp of when the creation started with the current one
		$timestamp = (int) $this->getRequest()->getVal('timestamp');
		$time_diff = time() - $timestamp;

		// given task ID not found in the creation log (maybe not yet?)
		if ( empty( $task_details ) ) {
			if ( $time_diff > CreateWikiTask::TASK_CREATION_DELAY_THRESHOLD ) {
				// we waited enough for the task to start, fail after a minute
				$this->response->setCode( 404 );
				$this->response->setVal( self::STATUS_FIELD, self::STATUS_NOT_FOUND );
				$this->response->setVal( 'time_diff', $time_diff );
			}
			else {
				// the task entry in simply just not yet there
				$this->response->setVal( self::STATUS_FIELD, self::STATUS_IN_THE_QUEUE );
			}
			return;
		}

		$this->response->setVal( self::CITY_ID_FIELD, (int) $task_details->city_id );

		// not set creation_ended value means that we're still creating a wiki
		if ( empty( $task_details->creation_ended ) ) {
			$this->response->setVal( self::STATUS_FIELD, self::STATUS_IN_PROGRESS );
		}
		else {
			// we're done, but did we succeed?
			$completed = (int) $task_details->completed;

			if ( $completed === 1 ) {
				$this->response->setVal( self::STATUS_FIELD, self::STATUS_OK );
				// if user was not logged in when starting the CNW process, the editToken is not available
				// in client JS yet. Send it in the response so it can be used when calling finishCreate.
				$this->response->setVal( 'editToken',  $this->getContext()->getUser()->getEditToken() );
			} else {
				// oh my, an error...
				$this->response->setCode( 500 );
				$this->response->setVal( self::STATUS_FIELD, self::STATUS_BACKEND_ERROR );
				$this->response->setVal( self::STATUS_MSG_FIELD, wfMessage( 'cnw-error-general' )->parse() );
				$this->response->setVal( self::STATUS_HEADER_FIELD, wfMessage( 'cnw-error-general-heading' )->escaped() );
				$this->response->setVal( self::ERROR_CLASS_FIELD, CreateWikiException::class );
				$this->response->setVal( self::ERROR_CODE_FIELD, 0 );
				$this->response->setVal( self::ERROR_MESSAGE_FIELD, $task_details->exception_message );
			}
		}
	}

	/**
	 * Sets the theme designer setting selected on the last step of CNW.
	 * Returns the url for the created wiki.
	 *
	 * @throws BadRequestException in case edit token cannot be validated
	 * @throws ForbiddenException when the current user is not the wiki founder
	 */
	public function finishCreateWiki() {
		$this->checkWriteRequest();

		$wikiId = $this->request->getInt( 'wikiId' );
		$wiki = WikiFactory::getWikiByID( $wikiId );

		if ( intval( $wiki->city_founding_user ) !== $this->getContext()->getUser()->getId() ) {
			throw new ForbiddenException();
		}

		$themeParams = $this->getVal( 'themeSettings' );

		if ( !empty( $themeParams['color-body'] ) ) {
			$themeSettings = new ThemeSettings( $wikiId );
			$themeSettings->saveSettings( $themeParams );
		}

		$this->setVal( 'wikiUrl', $wiki->city_url );
		$this->setVal( 'showWikiUrl',
			wfAppendQuery( WikiFactory::getLocalEnvURL( $wiki->city_url ), 'wiki-welcome=1' ) );
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

		Hooks::run( 'CheckContent', array( $text, &$blockedKeyword ) );

		if ( !empty( $blockedKeyword ) ) {
			$this->setContentBlockedByPhalanxErrorResponse( $text, $blockedKeyword );
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

	private function setUserNotLoggedInErrorResponse() {
		$this->warning("CreateWiki: user not logged in" );
		$this->response->setCode( 401 );
		$this->response->setVal( self::STATUS_FIELD, self::STATUS_ERROR );
		$this->response->setVal( self::STATUS_MSG_FIELD, wfMessage( 'cnw-error-anon-user' )->parse() );
		$this->response->setVal( self::STATUS_HEADER_FIELD, wfMessage( 'cnw-error-anon-user-header' )->text() );
	}

	private function setUserIsBlockedErrorResponse( User $user ) {
		$this->warning("CreateWiki: user is blocked" );
		$this->response->setCode( 403 );
		$this->response->setVal( self::STATUS_FIELD, self::STATUS_ERROR );
		$this->response->setVal( self::STATUS_MSG_FIELD, wfMessage( 'cnw-error-blocked', $user->blockedBy(), $user->blockedFor(), $user->getBlockId() )->parse() );
		$this->response->setVal( self::STATUS_HEADER_FIELD, wfMessage( 'cnw-error-blocked-header' )->text() );
	}

	private function setTooManyWikiCreatedByUserErrorResponse() {
		$this->warning("CreateWiki: user reached daily creation count limit" );
		$this->response->setCode( 429 );
		$this->response->setVal( self::STATUS_FIELD, self::STATUS_CREATION_LIMIT );
		$this->response->setVal( self::STATUS_MSG_FIELD, wfMessage( 'cnw-error-wiki-limit', self::DAILY_USER_LIMIT )->parse() );
		$this->response->setVal( self::STATUS_HEADER_FIELD, wfMessage( 'cnw-error-wiki-limit-header' )->text());
	}

	private function setContentBlockedByPhalanxErrorResponse( $description, $blockedKeyword ) {
		$this->info( __METHOD__ . ": keyword blocked by Phalanx '" . $description . "'': " . $blockedKeyword );
		$this->response->setCode( 400 );
		$this->response->setVal( self::STATUS_MSG_FIELD, wfMessage( 'cnw-badword-msg', $blockedKeyword )->text() );
		$this->response->setVal( self::STATUS_HEADER_FIELD, wfMessage( 'cnw-badword-header' )->text() );
	}
}
