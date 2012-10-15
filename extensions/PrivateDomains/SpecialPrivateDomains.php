<?php
/**
 * Body file for PrivateDomains extension
 * Defines the new special page, Special:PrivateDomains
 *
 * @file
 * @ingroup Extensions
 */

/**
 * Main extension class
 */
class PrivateDomains extends SpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'PrivateDomains'/*class*/, 'privatedomains'/*restriction*/ );
	}

	/**
	 * Saves a message in the MediaWiki: namespace.
	 *
	 * @param $name String: name of the MediaWiki message
	 * @param $value Mixed: value of the message
	 */
	function saveParam( $name, $value ) {
		$nameTitle = Title::newFromText( $name, NS_MEDIAWIKI );
		$article = new Article( $nameTitle );

		$article->doEdit( $value, '' );
	}

	/**
	 * Fetches the content of a defined MediaWiki message.
	 *
	 * @param $name String: name of the MediaWiki message
	 * @return string or nothing
	 */
	static function getParam( $name ) {
		$nameTitle = Title::newFromText( $name, NS_MEDIAWIKI );
		if ( $nameTitle->exists() ) {
			$article = new Article( $nameTitle );
			return $article->getContent();
		} else {
			return '';
		}
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgRequest;

		$this->setHeaders();

		$msg = '';

		if( $wgRequest->wasPosted() ) {
			if ( $wgRequest->getText( 'action' ) == 'submit' ) {
				$this->saveParam( 'privatedomains-domains', $wgRequest->getText( 'listdata' ) );
				$this->saveParam( 'privatedomains-affiliatename', $wgRequest->getText( 'affiliateName' ) );
				$this->saveParam( 'privatedomains-emailadmin', $wgRequest->getText( 'optionalPrivateDomainsEmail' ) );

				$msg = wfMsgHtml( 'saveprivatedomains-success' );
			}
		}
		$this->mainForm( $msg );
	}

	/**
	 * Shows the main form in Special:PrivateDomains
	 */
	private function mainForm( $msg ) {
		global $wgUser, $wgOut;

		$titleObj = SpecialPage::getTitleFor( 'PrivateDomains' );
		$action = $titleObj->escapeLocalURL( 'action=submit' );

		// Can the user execute the action?
		if( !$wgUser->isAllowed( 'privatedomains' ) ) {
			$this->displayRestrictionError();
			return;
		}

		// Is the database in read-only mode?
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		// Is the user blocked?
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		if ( $msg != '' ) {
			$wgOut->addHTML(
				'<div class="errorbox" style="width:92%;"><h2>' . $msg .
				'</h2></div><br /><br /><br />'
			);
		}

		$wgOut->addHTML(
			'<form name="privatedomains" id="privatedomains" method="post" action="' . $action . '">
		<label for="affiliateName"><br />' . wfMsg( 'privatedomains-affiliatenamelabel' ) . ' </label>
		<input type="text" name="affiliateName" width="30" value="' . $this->getParam( 'privatedomains-affiliatename' ) . '" />
		<label for="optionalEmail"><br />' . wfMsg( 'privatedomains-emailadminlabel' ) . ' </label>
		<input type="text" name="optionalPrivateDomainsEmail" value="' . $this->getParam( 'privatedomains-emailadmin' ) . '" />' );
		$wgOut->addHTML( wfMsg( 'privatedomains-instructions' ) );
		$wgOut->addHTML( '<textarea name="listdata" rows="10" cols="40">' . $this->getParam( 'privatedomains-domains' ) . '</textarea>' );
		$wgOut->addHTML( '<br /><input type="submit" name="saveList" value="' . wfMsgHtml( 'saveprefs' ) . '" />' );
		$wgOut->addHTML( '</form>' );
	}

	/**
	 * Custom version of SpecialPage::displayRestrictionError for PrivateDomains.
	 * This is OutputPage::permissionRequired with some modifications.
	 * The big change here is that we display 'privatedomains-ifcontact'
	 * message if user doesn't have the permission to access the special page.
	 */
	function displayRestrictionError() {
		global $wgUser, $wgLang, $wgOut;

		$wgOut->setPageTitle( wfMsgHtml( 'badaccess' ) );
		$wgOut->setHTMLTitle( wfMsgHtml( 'errorpagetitle' ) );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->mBodytext = '';

		$groups = array_map( array( 'User', 'makeGroupLinkWiki' ),
			User::getGroupsWithPermission( $this->mRestriction ) );
		$privatedomains_emailadmin = PrivateDomains::getParam( 'privatedomains-emailadmin' );
		if( $groups ) {
			$wgOut->addWikiMsg( 'badaccess-groups',
				$wgLang->commaList( $groups ),
				count( $groups ) );
			if( $privatedomains_emailadmin != '' ) {
				$wgOut->addWikiMsg( 'privatedomains-ifemailcontact', $privatedomains_emailadmin );
			}
		} else {
			$wgOut->addWikiMsg( 'badaccess-group0' );
		}
		$wgOut->returnToMain();
	}

}