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

class Listusers extends SpecialPage {
	var $mCityId;
	var $mAction;
	var $mTitle;
	var $mDefGroups;
	var $mGroups;
	var $mFilterStart;
	var $mContribs;
	var $mData;
	
	const TITLE 			= 'Listusers';
	const DEF_GROUP_NAME 	= 'all';
	const DEF_EDITS 		= 5;
	const DEF_LIMIT 		= 30;
	const DEF_ORDER 		= 'username:asc';

	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( self::TITLE  /*class*/ );
		wfLoadExtensionMessages( self::TITLE );	
	}
	
	/*
	 * main function - check request params and set defaults
	 * 
	 * @access public
	 * 
	 * show form 
	 */		
	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest, $wgCityId;

		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		
		/**
		 * defaults
		 */
		$this->mCityId = $wgCityId;
		$this->mDefGroups = array( self::DEF_GROUP_NAME, 'bot', 'sysop', 'rollback', 'bureaucrat' );					
		$this->mTitle = Title::makeTitle( NS_SPECIAL, self::TITLE );		
		$this->mAction = $this->mTitle->escapeLocalURL("");	 
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
			if ( strpos( $subpage, "," ) !== false )  {
				$this->mDefGroups = explode( ",", $subpage );
			} else {
				$this->mDefGroups = array( $subpage );
			}
		}

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
		global $wgOut, $wgContLang, $wgExtensionsPath, $wgJsMimeType, $wgStyleVersion, $wgStylePath, $wgUser;
		
		wfProfileIn( __METHOD__ );

		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/Listusers/css/table.css?{$wgStyleVersion}");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/Listusers/js/jquery.dataTables.min.js?{$wgStyleVersion}\"></script>\n");

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"error"				=> $error,
			"action"			=> $this->mAction,
			"obj"				=> $this,
			"wgContLang"		=> $wgContLang,
			"wgExtensionsPath"	=> $wgExtensionsPath, 
			"wgStylePath"		=> $wgStylePath,
			"defContrib"		=> self::DEF_EDITS,
			"wgUser"			=> $wgUser,
			"title"				=> self::TITLE
		));
		$wgOut->addHTML( $oTmpl->execute("main-form") );
		wfProfileOut( __METHOD__ );
	}
}
