<?php

/**
 * Class definition for the GiveRollback special page
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0 or later
 */

define( 'MW_GIVEROLLBACK_GRANT', 1 );
define( 'MW_GIVEROLLBACK_REVOKE', 2 );

class GiveRollback extends SpecialPage {

	var $target = '';

	/**
	 * Constructor
	 */
	function GiveRollback() {
		SpecialPage::SpecialPage( 'Giverollback', 'giverollback' );
	}

	/**
	 * Main execution function
	 * @param $par Parameters passed to the page
	 */
	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;
		wfLoadExtensionMessages( 'GiveRollback' );

		if( !$wgUser->isAllowed( 'giverollback' ) ) {
			$wgOut->permissionRequired( 'giverollback' );
			return;
		}

		$this->setHeaders();

		$this->target = $par
						? $par
						: $wgRequest->getText( 'username', '' );

		$wgOut->addWikiText( wfMsg( 'giverollback-header' ) );
		$wgOut->addHtml( $this->makeSearchForm() );

		if( $this->target != '' ) {
			$wgOut->addHtml( wfElement( 'p', NULL, NULL ) );
			$user = User::newFromName( $this->target );
			if( is_object( $user ) && !is_null( $user ) ) {
				# Valid username, check existence
				if( $user->getID() ) {
					# Exists; check current privileges
					if( $user->isAllowed( 'autoconfirmed' ) ) {
						if( !in_array( 'sysop', $user->mGroups ) ) {
							if( $wgRequest->getCheck( 'dosearch' ) || !$wgRequest->wasPosted() || !$wgUser->matchEditToken( $wgRequest->getVal( 'token' ), 'giverollback' ) ) {
								# Exists, check group memberships
								if( in_array( 'rollback', $user->mGroups ) ) {
									# Member of the rollback group
									$wgOut->addWikiText( wfMsg( 'giverollback-hasrb', $user->getName() ) );
									$wgOut->addHtml( $this->makeGrantForm( MW_GIVEROLLBACK_REVOKE ) );
								} else {
									# Not a member; show the grant form
									$wgOut->addWikiText( wfMsg( 'giverollback-norb', $user->getName() ) );
									$wgOut->addHtml( $this->makeGrantForm( MW_GIVEROLLBACK_GRANT ) );
								}
							} elseif( $wgRequest->getCheck( 'grant' ) ) {
								# Grant rollback rights
								$user->addGroup( 'rollback' );
								$this->addLogItem( 'grant', $user, trim( $wgRequest->getText( 'comment' ) ) );
								$wgOut->addWikiText( wfMsg( 'giverollback-granted', $user->getName() ) );
							} elseif( $wgRequest->getCheck( 'revoke' ) ) {
								# Revoke rollback rights
								$user->removeGroup( 'rollback' );
								$this->addLogItem( 'revoke', $user, trim( $wgRequest->getText( 'comment' ) ) );
								$wgOut->addWikiText( wfMsg( 'giverollback-revoked', $user->getName() ) );
							}
							# Show log entries
							$this->showLogEntries( $user );
						} else {
							# Sysops already have rollback
							$wgOut->addWikiText( wfMsg( 'giverollback-sysop', $user->getName() ) );
						}
					} else {
						# User account is too new
						$wgOut->addWikiText( wfMsg( 'giverollback-toonew', $user->getName() ) );
					}
				} else {
					# Doesn't exist
					$wgOut->addWikiText( wfMsg( 'nosuchusershort', htmlspecialchars( $this->target ) ) );
				}
			} else {
				# Invalid username
				$wgOut->addWikiText( wfMsg( 'noname' ) );
			}
		}

	}

	/**
	 * Produce a form to allow for entering a username
	 * @return string
	 */
	function makeSearchForm() {
		$thisTitle = Title::makeTitle( NS_SPECIAL, $this->getName() );
		$form  = wfOpenElement( 'form', array( 'method' => 'post', 'action' => $thisTitle->getLocalUrl() ) );
		$form .= wfElement( 'label', array( 'for' => 'username' ), wfMsg( 'giverollback-username' ) ) . ' ';
		$form .= wfElement( 'input', array( 'type' => 'text', 'name' => 'username', 'id' => 'username', 'value' => $this->target ) ) . ' ';
		$form .= wfElement( 'input', array( 'type' => 'submit', 'name' => 'dosearch', 'value' => wfMsg( 'giverollback-search' ) ) );
		$form .= wfCloseElement( 'form' );
		return $form;
	}

	/**
	 * Produce a form to allow granting or revocation of the rights
	 * @param $type Either MW_GIVEROLLBACK_GRANT or MW_GIVEROLLBACK_REVOKE
	 *				where the trailing name refers to what's enabled
	 * @return string
	 */
	function makeGrantForm( $type ) {
		global $wgUser;
		$thisTitle = Title::makeTitle( NS_SPECIAL, $this->getName() );
		if( $type == MW_GIVEROLLBACK_GRANT ) {
			$grant = true;
			$revoke = false;
		} else {
			$grant = false;
			$revoke = true;
		}

		# Start the table
		$form  = wfOpenElement( 'form', array( 'method' => 'post', 'action' => $thisTitle->getLocalUrl() ) );
		$form .= wfOpenElement( 'table' ) . wfOpenElement( 'tr' );
		# Grant/revoke buttons
		$form .= wfElement( 'td', array( 'align' => 'right' ), wfMsg( 'giverollback-change' ) );
		$form .= wfOpenElement( 'td' );
		foreach( array( 'grant', 'revoke' ) as $button ) {
			$attribs = array( 'type' => 'submit', 'name' => $button, 'value' => wfMsg( 'giverollback-' . $button ) );
			if( !$$button )
				$attribs['disabled'] = 'disabled';
			$form .= wfElement( 'input', $attribs );
		}
		$form .= wfCloseElement( 'td' ) . wfCloseElement( 'tr' );
		# Comment field
		$form .= wfOpenElement( 'td', array( 'align' => 'right' ) );
		$form .= wfElement( 'label', array( 'for' => 'comment' ), wfMsg( 'giverollback-comment' ) );
		$form .= wfOpenElement( 'td' );
		$form .= wfElement( 'input', array( 'type' => 'text', 'name' => 'comment', 'id' => 'comment', 'size' => 45 ) );
		$form .= wfCloseElement( 'td' ) . wfCloseElement( 'tr' );
		# End table
		$form .= wfCloseElement( 'table' );
		# Username
		$form .= wfElement( 'input', array( 'type' => 'hidden', 'name' => 'username', 'value' => $this->target ) );
		# Edit token
		$form .= wfElement( 'input', array( 'type' => 'hidden', 'name' => 'token', 'value' => $wgUser->editToken( 'giverollback' ) ) );
		$form .= wfCloseElement( 'form' );
		return $form;
	}

	/**
	 * Add logging entries for the specified action
	 * @param $type Either grant or revoke
	 * @param $target User receiving the action
	 * @param $comment Comment for the log item
	 */
	function addLogItem( $type, &$target, $comment = '' ) {
		$log = new LogPage( 'gvrollback' );
		$targetPage = $target->getUserPage();
		$log->addEntry( $type, $targetPage, $comment );
	}

	/**
	 * Show the bot status log entries for the specified user
	 * @param $user User to show the log for
	 */
	function showLogEntries( &$user ) {
		global $wgOut;
		$title = $user->getUserPage();
		$wgOut->addHtml( wfElement( 'h2', NULL, htmlspecialchars( LogPage::logName( 'gvrollback' ) ) ) );
		$logViewer = new LogViewer( new LogReader( new FauxRequest( array( 'page' => $title->getPrefixedText(), 'type' => 'gvrollback' ) ) ) );
		$logViewer->showList( $wgOut );
	}
}
