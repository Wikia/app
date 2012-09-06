<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @version: 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension and cannot be used standalone.\n"; exit( 1 ) ;
}

class Listusers extends SpecialRedirectToSpecial {
	var $mCityId;
	var $mAction;
	var $mTitle;
	var $mDefGroups;
	var $mGroups;
	var $mFilterStart;
	var $mContribs;
	var $mData;

	var $mDefContrib = null;
	var $mUserStart = '';

	const TITLE 			= 'Listusers';
	const DEF_GROUP_NAME 	= 'all';
	const DEF_EDITS 		= 5;
	const DEF_LIMIT 		= 30;
	const DEF_ORDER 		= 'username:asc';

	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( 'Listusers', self::TITLE  /*class*/ );
	}

	/*
	 * main function - check request params and set defaults
	 *
	 * @access public
	 *
	 * show form
	 */
	public function execute( $subpage ) {
		global $wgOut, $wgRequest, $wgCityId;

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		/**
		 * defaults
		 */
		$this->mCityId = $wgCityId;
		$this->mDefGroups = array( self::DEF_GROUP_NAME, 'bot', 'sysop', 'rollback', 'bureaucrat', 'fb-user' );
		$this->mTitle = Title::makeTitle( NS_SPECIAL, self::TITLE );
		$this->mAction = htmlspecialchars($this->mTitle->getLocalURL(""));
		$this->mContribs = array(
			0 	=> wfMsg('listusersallusers'),
			1	=> wfMsg('listusers-1contribution'),
			5 	=> wfMsg('listusers-5contributions'),
			10 	=> wfMsg('listusers-10contributions'),
			20 	=> wfMsg('listusers-20contributions'),
			50 	=> wfMsg('listusers-50contributions'),
			100 => wfMsg('listusers-100contributions')
		);

		/**
		 * initial output
		 */
		$wgOut->setPageTitle( wfMsg('listuserstitle') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$target = $wgRequest->getVal('target');
		if ( empty( $target ) ) {
			$target = $wgRequest->getVal('group');
		}

		if ( !empty( $target ) ) {
			if ( strpos($target, ",") !== false )  {
				$this->mDefGroups = explode( ",", $target );
			} else {
				$this->mDefGroups = array( $target );
			}
		} elseif ( !empty( $subpage ) ) {
			@list ( $subpage, $this->mDefContrib, $this->mUserStart ) = explode("/", $subpage);
			if ( !in_array($this->mDefContrib, array_keys($this->mContribs) ) ) {
				$this->mDefContrib = null;
			}
			if ( strpos( $subpage, "," ) !== false )  {
				$this->mDefGroups = explode( ",", $subpage );
			} else {
				$this->mDefGroups = array( $subpage );
			}
		}

		$this->mDefContrib = is_null($this->mDefContrib) ? self::DEF_EDITS : $this->mDefContrib;

		/* listusersHelper */
		$this->mData = new ListusersData($this->mCityId);
		$this->mData->setFilterGroup( $this->mDefGroups );
		$this->mGroups = $this->mData->getGroups();

		/**
		 * show form
		 */
		$this->showForm();
		#$this->showArticleList();
	}

	/*
	 * HTML form
	 *
	 * @access public
	 *
	 * show form
	 */
	function showForm ( $error = "" ) {
		global $wgOut, $wgContLang, $wgExtensionsPath, $wgJsMimeType, $wgResourceBasePath, $wgStylePath, $wgUser;

		wfProfileIn( __METHOD__ );

		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgResourceBasePath}/resources/wikia/libraries/jquery/datatables/jquery.dataTables.min.js\"></script>\n");
		$wgOut->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/Listusers/css/table.scss'));

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"error"				=> $error,
			"action"			=> $this->mAction,
			"obj"				=> $this,
			"wgContLang"		=> $wgContLang,
			"wgExtensionsPath"	=> $wgExtensionsPath,
			"wgStylePath"		=> $wgStylePath,
			"defContrib"		=> $this->mDefContrib,
			"defUser"			=> $this->mUserStart,
			"wgUser"			=> $wgUser,
			"title"				=> self::TITLE
		));
		$wgOut->addHTML( $oTmpl->render("main-form") );
		wfProfileOut( __METHOD__ );
	}
}
