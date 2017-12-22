<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @version: 1.0
 */

class ListGlobalUsers extends SpecialRedirectToSpecial {
	private $mAction;
	private $mTitle;
	private $mDefGroups;
	private $mContribs;

	/* @var ListGlobalUsersData $mData */
	private $mData;

	private $mDefContrib = null;
	private $searchByUser = '';

	const TITLE		= 'ListGlobalUsers';
	const DEF_GROUP_NAME	= 'all';
	const DEF_EDITS		= 5;
	const DEF_LIMIT		= 30;
	const DEF_ORDER		= 'dtedit:desc';

	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( 'ListGlobalUsers', self::TITLE  /*class*/ );
	}

	/*
	 * main function - check request params and set defaults
	 *
	 * @access public
	 *
	 * show form
	 */
	public function execute( $subpage ) {
		global $wgCityId;

		if ( wfReadOnly() ) {
			$this->getOutput()->readOnlyPage();
			return;
		}

		/**
		 * defaults
		 */
		// VOLDEV-47
		// remove default highlighted groups (all are now highlighted)
		$this->mDefGroups = array();
		$this->mTitle = Title::makeTitle( NS_SPECIAL, self::TITLE );
		$this->mAction = htmlspecialchars( $this->mTitle->getLocalURL() );
		$this->mContribs = array(
			0	=> wfMessage( 'listGlobalUsersallusers' )->escaped(),
			1	=> wfMessage( 'listGlobalUsers-1contribution' )->escaped(),
			5	=> wfMessage( 'listGlobalUsers-5contributions' )->escaped(),
			10	=> wfMessage( 'listGlobalUsers-10contributions' )->escaped(),
			20	=> wfMessage( 'listGlobalUsers-20contributions' )->escaped(),
			50	=> wfMessage( 'listGlobalUsers-50contributions' )->escaped(),
			100	=> wfMessage( 'listGlobalUsers-100contributions' )->escaped()
		);

		/**
		 * initial output
		 */
		$this->getOutput()->setPageTitle( wfMessage( 'listGlobalUserstitle' )->text() );
		$this->getOutput()->setRobotpolicy( 'noindex,nofollow' );
		$this->getOutput()->setArticleRelated( false );

		$target = $this->getRequest()->getVal( 'target' );
		if ( empty( $target ) ) {
			$target = $this->getRequest()->getVal( 'group' );
		}

		if ( !empty( $target ) ) {
			if ( strpos($target, "," ) !== false )  {
				$this->mDefGroups = explode( ",", $target );
			} else {
				$this->mDefGroups = array( $target );
			}
		} elseif ( !empty( $subpage ) ) {
			@list ( $subpage, $this->mDefContrib, $this->searchByUser ) = explode( "/", $subpage );
			if ( !in_array( $this->mDefContrib, array_keys( $this->mContribs ) ) ) {
				$this->mDefContrib = null;
			}
			if ( strpos( $subpage, "," ) !== false )  {
				$this->mDefGroups = explode( ",", $subpage );
			} else {
				$this->mDefGroups = array( $subpage );
			}
		}

		$this->mDefContrib = is_null( $this->mDefContrib ) ? self::DEF_EDITS : $this->mDefContrib;

		$this->mData = new ListGlobalUsersData( $wgCityId );
		$this->mData->load();
		$this->mData->setFilterGroup( $this->mDefGroups );

		/**
		 * show form
		 */
		$this->showForm();
	}

	/**
	 * HTML form
	 *
	 * @access public
	 *
	 * show form
	 */
	private function showForm () {
		global $wgContLang, $wgExtensionsPath, $wgStylePath;

		// load CSS and JS assets
		$this->getOutput()->addModules('ext.wikia.ListGlobalUsers');

		// make these values available in JS code via mw.config
		// e.g. mw.config.get('listGlobalUsers').defContrib
		$this->getOutput()->addJsConfigVars('listGlobalUsers', [
			'defContrib' => $this->mDefContrib,
			'searchByUser' => $this->searchByUser,
		]);

		$oTmpl = new EasyTemplate( __DIR__ . "/templates/" );
		$oTmpl->set_vars( array(
			"action"		=> $this->mAction,
			"wgContLang"		=> $wgContLang,
			"wgExtensionsPath"	=> $wgExtensionsPath,
			"wgStylePath"		=> $wgStylePath,
			"defContrib"		=> $this->mDefContrib,
			"searchByUser"		=> $this->searchByUser,
			"wgUser"		=> $this->getUser(),
			'groups'        => $this->mData->getGroups(),
			'filtered_group' => $this->mData->getFilterGroup(),
			'contribs'      => $this->mContribs,
		));
		$this->getOutput()->addHTML( $oTmpl->render( "main-form" ) );
	}
}
