<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @addtogroup SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @version: 0.1
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension named RequestWiki.\n";
	exit( 1 ) ;
}

/**
 * main class
 */
class RequestWikiPage extends SpecialPage {

	public $mTitle, $mAction;

	/**
	 * contructor
	 */
	function  __construct() {
		wfLoadExtensionMessages("RequestWiki");
		parent::__construct( 'RequestWiki'  /*class*/, 'requestwiki' /*restriction*/);
	}

	/**
	 * execute
	 *
	 * main entry point
	 *
	 * @author eloy@wikia.com
	 * @access public
	 *
	 * @param string $subpage: subpage of Title
	 *
	 * @return nothing
	 */
	function execute() {

		global $wgUser, $wgOut, $wgRequest;

		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if( !$wgUser->isAllowed( 'requestwiki' ) ) {
			$this->displayRestrictionError();
			return;
		}

		#--- initial output
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'RequestWiki' );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		$this->mAction = $wgRequest->getVal('action');
		if( $this->mAction === 'second' ) {
			$this->do_secondstep();
		}
		elseif ($this->mAction === 'third') {
			$this->do_thirdstep();
		}
		elseif ($this->mAction === 'list') {
			$this->do_list();
		}
		else {
			$this->do_firststep();
		}
	}

	/////////////////////////////////////////////////////////////////////////
	function do_firststep($errors = null)
	{
		global $wgOut, $wgUser;

		$wgOut->setPageTitle( wfMsg('requestwiki-misc-pagetitle') . wfMsg('requestwiki-first-pagetitle') );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$oTmpl->set_vars( array(
			'errors'    => $errors
		));

		$oTmpl->set_vars( array(
			'title' => $this->mTitle,
			'is_staff' => in_array('staff', $wgUser->mGroups) ? 1 : 0,
			'thisUrl'  => $this->getTitle()->escapeLocalURL(),
		));
		$wgOut->addHTML( $oTmpl->execute('first') );
	}

	#--- do_secondstep ------------------------------------------------------
	/**
	 * show request form
	 */
	function do_secondstep($errors = null, $params = array())
	{
		global $wgOut, $wgUser, $wgRequest, $wgDBname;

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$wgOut->setPageTitle( wfMsg('requestwiki-misc-pagetitle') . wfMsg('requestwiki-second-pagetitle') );

		if (!$wgUser->isLoggedIn()) {
			//redirect to login page
			$tLogin = Title::makeTitle(NS_SPECIAL, 'Userlogin');
			$tRequest = Title::makeTitle(NS_SPECIAL, 'RequestWiki');
			$wgOut->redirect($tLogin->getFullURL('returnto=' . $tRequest->getPrefixedURL()));
		}
		#--- check if user have confirmed mail email first
		elseif (!$wgUser->isEmailConfirmed()) {
			#--- show info that user should be emailconfirmed
			$oTmpl->set_vars( array(
				'title' => $this->mTitle,
				'is_logged' => 1,
				'confirm' => Title::makeTitle( NS_SPECIAL, 'ConfirmEmail' )
			));
			$wgOut->addHTML( $oTmpl->execute('autoconfirm') );
			return;
		}

		$requestSubmit = isset($_POST['wiki-submit']);
		$requestTOS = $wgRequest->getVal('wiki_tos_agree');
		$iRequestID = $wgRequest->getIntOrNull('id');
		$firstEdit = $iRequestID && !empty($_GET['id']);
		if (!$requestSubmit && !$requestTOS && empty($iRequestID)) {
			$errors['requestwiki-first-tos-agree'] = Wikia::errormsg(wfMsg('requestwiki-first-tos-agree'));
			$this->do_firststep($errors);
			return;
		}
		$params['wiki_tos_agree'] = $requestSubmit ? $requestSubmit : $wgRequest->getVal('wiki_tos_agree');

		$languages = Language::getLanguageNames();
		$request = null;
		$editing = 0;
		$request = array();

		#--- flags
		$is_staff = in_array('staff', $wgUser->getGroups()) ? 1 : 0;
		$is_requester = 0;

		if (!empty($iRequestID)) {
			if ($firstEdit) {
				#--- get request data from database
				$dbr = wfGetDB( DB_SLAVE );

				$res = $dbr->select(wfSharedTable('city_list_requests'), array('*'),
					array('request_id' => $iRequestID));
				$params = $dbr->fetchRow($res);
				$dbr->freeResult( $res );
			}

			$editing++;

			#--- now get requester data
			$oRequester = User::newFromId($params['request_user_id']);
			$oRequester->load();
			if ($oRequester->getID() == $wgUser->getID()) {
				$is_requester = 1;
			}
		}
		else {
			if (!empty($params['request_user_id'])) {
				#--- create user object from parameter
				$oRequester = User::newFromId( $params['request_user_id'] );
				$oRequester->load();

				#--- but of course check if requester exists
				if ( ! $oRequester->getID() ) {
					$oRequester = $wgUser;
				}
				$is_requester = 1;
			}
			else {
				$oRequester = $wgUser;
				$is_requester = 1;
			}
		}

		#--- additional links
		$aLinks = array();
		if (is_array($params) && array_key_exists('request_id', $params)) {
			$oLinksTitle = Title::makeTitle( NS_SPECIAL, 'CreateWiki' );
			foreach ( array('create', 'reject', 'delete') as $action ) {
				$aLinks[$action] = $oLinksTitle->getLocalUrl("action={$action}&request={$params["request_id"]}");
			}
			$aLinks['request more info'] = $oLinksTitle->getLocalUrl("action=req_more_info&request={$params["request_id"]}");
		}

		$hubs = WikiFactoryHub::getInstance();

		$oTmpl->set_vars( array(
			'user'      => $oRequester,
			'title'     => $this->mTitle,
			'links'     => $aLinks,
			'errors'    => $errors,
			'params'    => $params,
			'editing'   => $editing,
			'is_staff'  => $is_staff,
			'languages' => $languages,
			'categories'    => $hubs->getCategories(),
			'request_id'    => $iRequestID,
			'is_requester'  => $is_requester
		));

		if (empty($is_requester) && empty($is_staff)) {
			$wgOut->addHTML( $oTmpl->execute('comments') );
		}
		else {
			$wgOut->addHTML( $oTmpl->execute('second') );
		}
	}

	/**
	 * do_thirdstep
	 *
	 * third step, validate all params and store request in database.
	 * if there are errors redirect to do_secondstep
	 *
	 * @access public
	 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
	 * @author Maciej Błaszkowski <marooned@wikia-inc.com>
	 *
	 * @return string	HTML code with page
	 */
	public function do_thirdstep() {
		global $wgOut, $wgRequest, $wgContLang, $wgDBname, $wgUser;

		#-- some initialization
		$errors = array();
		$params = array();
		$notvalid = 0;

		$editing = $wgRequest->getIntOrNull( 'editing' );

		if (!$editing && !$wgRequest->getVal('wiki_tos_agree')) {
			$errors['requestwiki-first-tos-agree'] = Wikia::errormsg(wfMsg('requestwiki-first-tos-agree'));
			$this->do_firststep($errors);
			return;
		}

		$wgOut->setPageTitle( wfMsg('requestwiki-misc-pagetitle') . wfMsg('requestwiki-third-pagetitle') );

		#--- fill params array with request data
		$params['request_id']           = intval($wgRequest->getVal('id'));
		$params['request_user_id']      = htmlspecialchars($wgRequest->getVal('rw-userid'));
		$params['request_timestamp']    = htmlspecialchars($wgRequest->getText('rw-timestamp'));
		$params['request_title']        = htmlspecialchars($wgContLang->ucfirst(trim($wgRequest->getVal('rw-title'))));
		$params['request_name']         = htmlspecialchars($wgContLang->lc(trim($wgRequest->getVal( 'rw-name' ))));
		$params['request_language']     = htmlspecialchars($wgRequest->getVal('rw-language'));
		$params['request_category']     = htmlspecialchars($wgRequest->getVal('rw-category'));
		$params['request_community']    = htmlspecialchars($wgRequest->getVal('rw-community'));
		$params['request_comments']     = htmlspecialchars($wgRequest->getText('rw-comments'));
		$params['request_questions']    = htmlspecialchars($wgRequest->getText('rw-questions'));
		$params['request_description_page']             = htmlspecialchars($wgRequest->getVal('rw-description-page'));
		$params['request_description_english']          = htmlspecialchars($wgRequest->getVal('rw-description-english'));
		$params['request_description_international']    = htmlspecialchars($wgRequest->getVal('rw-description-international'));
		$params['request_extrainfo']      = htmlspecialchars($wgRequest->getText('rw-extrainfo'));
		$params['request_moreinfo_count'] = htmlspecialchars($wgRequest->getVal('rw-moreinfo-count'));
		$moreinfo_url = array();
		for ($urlNo = 0; $urlNo < intval($params['request_moreinfo_count']); $urlNo++)
		{
			$params["request_moreinfo_url_$urlNo"]      = htmlspecialchars($wgRequest->getVal("rw-moreinfo-url-$urlNo"));
			$params["request_moreinfo_url_txt_$urlNo"]  = htmlspecialchars($wgRequest->getVal("rw-moreinfo-url-txt-$urlNo"));
			if ($params["request_moreinfo_url_txt_$urlNo"] !== '') {
				if ($params["request_moreinfo_url_$urlNo"] !== '') {
					$moreinfo_url[] = $params["request_moreinfo_url_$urlNo"] . '=' . $params["request_moreinfo_url_txt_$urlNo"];
				} else {
					#--- URL without category
					$errors['rw-moreinfo'] = Wikia::errormsg(wfMsg('requestwiki-error-no-url-category'));
				}
			}
		}

		$iRequestID = $wgRequest->getIntOrNull( 'id' );
		$iRequestUserID = $wgRequest->getIntOrNull( 'rw-userid' );
		$sRequestUserName = $wgRequest->getVal('rw-username');
		$languages = Language::getLanguageNames();

		/**
		 * staff can change username, we would know about it by comparing
		 * $sRequestUserName with getName user object created from $iRequestUserID
		 */
		$oRequester = User::newFromId($iRequestUserID);
		$oRequester->load();

		if ( $oRequester->getName() != $sRequestUserName ) {
			#--- name was changed, check if user exists
			$oNewRequester = User::newFromName( $sRequestUserName );
			if ($oNewRequester != null) {
				$oNewRequester->load();
			}

			if ( $oNewRequester == null || !$oNewRequester->getID() ) {
				$errors['rw-username'] = Wikia::errormsg(wfMsg('requestwiki-error-no-such-user'));
			} else {
				$params['request_user_id'] = $oNewRequester->getID();
			}
		}

		#--- name for wiki
		if ($params['request_title'] == '') {
			$errors['rw-title'] = Wikia::errormsg(wfMsg('requestwiki-error-empty-field'));
		}

		#--- URL for wiki
		if ($params['request_name'] == '') {
			$errors['rw-name'] = Wikia::errormsg(wfMsg('requestwiki-error-empty-field'));
		} elseif (preg_match('/[^a-z0-9-]/i', $params['request_name'])) {
			$errors['rw-name'] = Wikia::errormsg(wfMsg('requestwiki-error-bad-name'));
		} elseif (in_array($params['request_name'], array_keys(Language::getLanguageNames()))) {
			$errors['rw-name'] = Wikia::errormsg(wfMsg('requestwiki-error-name-is-lang'));
		}

		#--- category
		$hubs = WikiFactoryHub::getInstance();
		$categories = $hubs->getCategories();
		if (empty($params['request_category']) || !in_array(htmlspecialchars_decode($params['request_category']), $categories)) {
			$errors['rw-category'] = Wikia::errormsg(wfMsg('requestwiki-error-bad-category'));
		}

		#--- language
		if (!array_key_exists($params['request_language'], $languages)) {
			$errors['rw-language'] = Wikia::errormsg(wfMsg('requestwiki-error-bad-language'));
		}

		#--- check citydomain before creating wikia
		if (empty($errors['rw-name'])) {
			$bExists = wfRequestExact($params['request_name'], $params['request_language']);
			if (!empty($bExists)) {
				$errors['rw-name'] = Wikia::errormsg(wfMsg('requestwiki-error-name-taken'));
			}
		}

		#--- "about wiki" required
		if ($params['request_description_international'] == '') {
			$errors['rw-description-international'] = Wikia::errormsg(wfMsg('requestwiki-error-empty-field'));
		}

		#--- community required
		if ($params['request_community'] == '') {
			$errors['rw-community'] = Wikia::errormsg(wfMsg('requestwiki-error-empty-field'));
		}

		#--- give extansions a chance to process errors
		wfRunHooks( 'RequestWiki::processErrors', &$errors ) ;

		#--- check for errors
		if (!empty($errors)) {
			$this->do_secondstep($errors, $params);
			return;
		}

		#--- master connection
		$dbw = wfGetDB( DB_MASTER );
		$dbw->selectDB( 'requests' );

		#---
		# check if there is article on requests.wikia.com and it doesn't
		# contain RequestForm* template

		#-- build page from elements
		$oTitle = wfRequestTitle( $params['request_name'], $params['request_language'] );
		$oArticle = new Article( $oTitle /*title*/, 0 );
		$sContent = $oArticle->getContent();
		if (empty($iEdit)) {
			if ($oArticle->exists() && strpos($sContent, 'RequestForm' ) === false) {
				$errors['rw-name'] = Wikia::errormsg(
					wfMsg('requestwiki-error-page-exists', array(
						sprintf('<a href="%s">%s</a>', $oTitle->getLocalURL(), $oTitle->getText()))
				));
				$this->do_secondstep($errors, $params);
				return;
			}
		}

		$bTitleChanged = false;
		if (empty($editing)) {
			#--- first make sure if really, REALLY pair name-language doesn't exists
			$row = $dbw->selectRow(
				wfSharedTable('city_list_requests'),
				array('count(*) as count'),
				array('request_name' => $params['request_name'], 'request_language' => $params['request_language']),
				__METHOD__
			);
			if (!empty($row->count)) {
				#--- redirect to existed request
				$errors['rw-name'] = '<span style="color: #fe0000; font-weight: bold;">'.wfMsg('requestwiki-error-in-progress').'</span>';
				$this->do_secondstep($errors, $params);
				return;
			}
			else {
				#--- ewentualy insert new request
				//change moreinfo_urls to one field (to store in DB) and delete unused array keys from $params
				$params['request_moreinfo'] = implode("\n", $moreinfo_url);
				for ($urlNo = 0; $urlNo < intval($params['request_moreinfo_count']); $urlNo++)
				{
					unset($params["request_moreinfo_url_$urlNo"]);
					unset($params["request_moreinfo_url_txt_$urlNo"]);;
				}
				unset($params['request_moreinfo_count']);

				$dbw->insert(wfSharedTable('city_list_requests'), $params, __METHOD__);
				$iRequestID = $dbw->insertId();
			}
		}
		else {
			#--- editing exisiting request
			#---
			# check if title is changed, if is changed mark it -
			# then we first read request from database
			$oRow = $dbw->selectRow(
				wfSharedTable( 'city_list_requests' ),
				array( '*' ),
				array( 'request_id' => $iRequestID ),
				__METHOD__
			);

			//change moreinfo_urls to one field (to store in DB) and delete unused array keys from $params
			$params['request_moreinfo'] = implode("\n", $moreinfo_url);
			for ($urlNo = 0; $urlNo < intval($params['request_moreinfo_count']); $urlNo++)
			{
				unset($params["request_moreinfo_url_$urlNo"]);
				unset($params["request_moreinfo_url_txt_$urlNo"]);;
			}
			unset($params['request_moreinfo_count']);

			$dbw->update(
				wfSharedTable('city_list_requests'),
				$params,
				array( 'request_id' => $iRequestID ),
				__METHOD__
			);

			if (strtolower($oRow->request_name) != strtolower($params['request_name']) ||
				strtolower($oRow->request_language) != strtolower($params['request_language'])
			){
				$bTitleChanged = true;
				$oOldTitle = wfRequestTitle( $oRow->request_name, $oRow->request_language );
			}
		}
		#-- build page from elements
		$oTitle = wfRequestTitle( $params['request_name'], $params['request_language'] );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$oTmpl->set_vars( array(
			'title'         => $this->mTitle,
			'params'        => $params,
			'username'      => $sRequestUserName,
			'languages'     => $languages,
			'request_id'    => $iRequestID,
		));
		$sPage = $oTmpl->execute('page-template');

		$oArticle = new Article( $oTitle /*title*/, 0 );

		#--- set redirection if title was changed
		if ( $bTitleChanged == true ) {
			$oArticle->setRedirectedFrom( $oOldTitle );
		}
		#--- delete page_restrictions for this article (if any)
		if ( $oArticle->getID() ) {
			$dbw->delete('page_restrictions', array('pr_page' => $oArticle->getID()), __METHOD__);
			$iFlags = EDIT_UPDATE|EDIT_MINOR;
		}
		else {
			$iFlags = EDIT_NEW;
		}

		#--- insert template into page
		$oArticle->doEdit( $sPage, 'new or updated request', $iFlags);


		#--- update restrictions
		$dbw->insert('page_restrictions', array(
			'pr_page' => $oArticle->getID(),
			'pr_type' => 'edit',
			'pr_level' => 'sysop',
			'pr_cascade' => 0,
			'pr_user' => null,
			'pr_expiry' => 'infinity'
			), __METHOD__
		);
		$dbw->insert('page_restrictions', array(
			'pr_page' => $oArticle->getID(),
			'pr_type' => 'move',
			'pr_level' => 'sysop',
			'pr_cascade' => 0,
			'pr_user' => null,
			'pr_expiry' => 'infinity'
			), __METHOD__
		);

		#--- now if name was changed we have to edit old page and made redirect
		if ( $bTitleChanged == true ) {
			$oOldArticle = new Article( $oOldTitle /*title*/, 0 /*current id*/ );
			$sNewTitle = $oTitle->getText();
			$oOldArticle->doEdit( "#REDIRECT [[{$sNewTitle}]]", "redirect after name changing", EDIT_UPDATE|EDIT_MINOR );

			#--- update restrictions
			$oOldArticle->updateRestrictions(
				array( 'edit' => 'sysop', 'move' => 'sysop' ),
				'auto after creating or editing', 0, 'infinity'
			);
		}

		$oTmpl->set_vars( array(
			'link_view'  => $oTitle->getLocalUrl( 'action=purge' ),
			'link_edit'  => $this->getTitle()->escapeLocalURL("action=second&id=$iRequestID"),
			'title' => $this->mTitle
		));

		return $wgOut->addHTML( $oTmpl->execute("third") );
	}

	#--- do_list ------------------------------------------------------------
	function do_list()
	{
		global $wgOut;
		$pager = new RequestListPager;

		$wgOut->setPageTitle( wfMsg('requestwiki-misc-pagetitle') . wfMsg('requestwiki-list-pagetitle') );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$oTmpl->set_vars( array(
			'title' => $this->mTitle,
			'form'  => $pager->getForm(),
			'body'  => $pager->getBody(),
			'pager' => $pager->getNavigationBar()
		));
		$wgOut->addHTML( $oTmpl->execute('list') );
	}
};

class RequestListPager extends TablePager {
	var $mFieldNames = null;
	var $mMessages = array();
	var $mQueryConds = array();

	#--- constructor --------------------------------------------------------
	function __construct()
	{
		global $wgRequest, $wgMiserMode;
		if ( $wgRequest->getText( 'sort', 'img_date' ) == 'img_date' ) {
			$this->mDefaultDirection = true;
		} else {
			$this->mDefaultDirection = false;
		}
		$search = $wgRequest->getText( 'ilsearch' );
		if ( $search != '' && !$wgMiserMode ) {
			$nt = Title::newFromUrl( $search );
			if( $nt ) {
				$dbr = wfGetDB( DB_SLAVE );
				$m = $dbr->strencode( strtolower( $nt->getDBkey() ) );
				$m = str_replace( "%", "\\%", $m );
				$m = str_replace( "_", "\\_", $m );
			 }
		}
		parent::__construct();
	}

	#--- getFieldNames ------------------------------------------------------
	function getFieldNames()
	{

		if ( !$this->mFieldNames ) {
			$this->mFieldNames = array();
			$this->mFieldNames['request_name'] = wfMsg( 'requestwiki-request-name' );
			$this->mFieldNames['request_language'] = wfMsg( 'requestwiki-request-language' );
			$this->mFieldNames['request_timestamp'] = wfMsg( 'requestwiki-request-timestamp' );
			$this->mFieldNames['request_user_id'] = wfMsg( 'requestwiki-request-talk-timestamp' );
			$this->mFieldNames['request_id'] = wfMsg( 'requestwiki-request-id' );
		}
		return $this->mFieldNames;
	}

	#--- isFieldSortable-----------------------------------------------------
	function isFieldSortable( $field ) {
		static $sortable = array( 'request_name', 'request_language', 'request_category', 'request_timestamp' );
		return in_array( $field, $sortable );
	}

	#--- formatValue --------------------------------------------------------
	function formatValue( $field, $value ) {
		global $wgLang, $wgUser, $wgContLang;

		switch ( $field ) {
			case 'request_id':
				if (in_array('staff', $wgUser->getGroups())) {
					$title = Title::makeTitle( NS_SPECIAL, 'CreateWiki' );
					return sprintf("<a href=\"%s\">create</a> <a href=\"%s\">reject</a> <a href=\"%s\">delete</a>",
						$title->getLocalUrl("action=load&request={$value}"),
						$title->getLocalUrl("action=reject&request={$value}"),
						$title->getLocalUrl("action=delete&request={$value}"));
				}
				else {
					$id = $this->mCurrentRow->request_id;
					$title = Title::makeTitle( NS_SPECIAL, 'RequestWiki' );
					return sprintf("&nbsp;<a href=\"%s\">edit</a>&nbsp;",
						$title->getLocalUrl("action=second&id={$id}"), $id);
				}
				break;

			case 'request_timestamp':
				$sRetval = date('Y-m-d', strtotime(wfTimestamp(TS_DB, $value)));
				return $sRetval;
				break;
			case 'request_user_id':
				$name = $this->mCurrentRow->request_page_name;
				$dbr = wfGetDB();
				$oRow = $dbr->selectRow(
					array( "page", "revision" ) /*from*/,
					array( "page_id", "rev_timestamp", "rev_user_text" ) /*what*/,
					array(
						"lower(page_title)" => strtolower($name),
						"page_namespace" => 1,
						"revision.rev_page = page.page_id"
					), /*where*/
					__METHOD__,
					array("ORDER BY" => "rev_timestamp DESC")
				);

				$sRetval = "";
				$sRetval .= (!empty($oRow->rev_timestamp)) ? "<ul><li>" . date('Y-m-d', strtotime(wfTimestamp(TS_DB, $oRow->rev_timestamp))) . ((!empty($oRow->rev_user_text)) ? " by ".$oRow->rev_user_text: "") . "</li></ul>" : "";
				return $sRetval;
				break;
			case "request_name":
				$value = trim($value);

				$id = $this->mCurrentRow->request_id;
				$sLanguage = $this->mCurrentRow->request_language;

				#-- build page from elements
				$oRequestPage = wfRequestTitle($value, $sLanguage);

				$oFormPage = Title::makeTitle( NS_SPECIAL, 'RequestWiki' );
				$this->mCurrentRow->request_page_name = $oRequestPage->getText();
				return sprintf("<a href=\"%s\">%s</a>", $oRequestPage->getLocalUrl(), $oRequestPage->getText());
				break;

			default:
				return $value;
		}
	}

	#--- getDefaultSort -----------------------------------------------------
	function getDefaultSort() {
		return 'request_id';
	}

	#--- getQueryInfo -------------------------------------------------------
	function getQueryInfo() {
		$aFields = $this->getFieldNames();
		$aFields["request_title"] = 1;
		$aFields = array_keys( $aFields );
		return array(
			'tables' => wfSharedTable("city_list_requests"),
			'fields' => $aFields,
			'conds' => array("request_status" => 0)
		);
	}

	#--- getForm() -------------------------------------------------------
	function getForm() {
		global $wgRequest, $wgMiserMode;
		$url = $this->getTitle()->escapeLocalURL();
		$search = $wgRequest->getText( 'ilsearch' );
		$s = "<form method=\"get\" action=\"$url\">\n" .
		wfMsgHtml( 'table_pager_limit', $this->getLimitSelect() );
		if ( !$wgMiserMode ) {
			$s .= "<br/>\n" .
			Xml::inputLabel( wfMsg( 'imagelist_search_for' ), 'ilsearch', 'mw-ilsearch', 20, $search );
		}
		$s .= " " . Xml::submitButton( wfMsg( 'table_pager_limit_submit' ) ) ." \n" .
			$this->getHiddenFields( array( 'limit', 'ilsearch' ) ) .
			"</form>\n";
		return $s;
	}
}
?>
