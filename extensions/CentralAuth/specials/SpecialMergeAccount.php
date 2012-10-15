<?php

class SpecialMergeAccount extends SpecialPage {

	protected $mUserName, $mAttemptMerge, $mMergeAction, $mPassword, $mWikiIDs, $mSessionToken, $mSessionKey;
	function __construct() {
		parent::__construct( 'MergeAccount', 'centralauth-merge' );
	}

	function execute( $subpage ) {
		global $wgUser;
		$this->setHeaders();

		if ( !$this->userCanExecute( $wgUser ) ) {
			$this->getOutput()->addWikiMsg( 'centralauth-merge-denied' );
			$this->getOutput()->addWikiMsg( 'centralauth-readmore-text' );
			return;
		}

		if ( !$this->getUser()->isLoggedIn() ) {
			$loginpage = SpecialPage::getTitleFor( 'Userlogin' );
			$loginurl = $loginpage->getFullUrl( array( 'returnto' => $this->getTitle()->getPrefixedText() ) );
			$this->getOutput()->addWikiMsg( 'centralauth-merge-notlogged', $loginurl );
			$this->getOutput()->addWikiMsg( 'centralauth-readmore-text' );

			return;
		}

		if ( wfReadOnly() ) {
			$this->getOutput()->setPagetitle( wfMsg( 'readonly' ) );
			$this->getOutput()->addWikiMsg( 'readonlytext', wfReadOnlyReason() );
			return;
		}

		$this->mUserName = $this->getUser()->getName();

		$this->mAttemptMerge = $this->getRequest()->wasPosted();

		$this->mMergeAction = $this->getRequest()->getVal( 'wpMergeAction' );
		$this->mPassword = $this->getRequest()->getVal( 'wpPassword' );
		$this->mWikiIDs = $this->getRequest()->getArray( 'wpWikis' );
		$this->mSessionToken = $this->getRequest()->getVal( 'wpMergeSessionToken' );
		$this->mSessionKey = pack( "H*", $this->getRequest()->getVal( 'wpMergeSessionKey' ) );

		// Possible demo states

		// success, all accounts merged
		// successful login, some accounts merged, others left
		// successful login, others left
		// not account owner, others left

		// is owner / is not owner
		// did / did not merge some accounts
		// do / don't have more accounts to merge

		if ( $this->mAttemptMerge ) {
			switch( $this->mMergeAction ) {
			case "dryrun":
				$this->doDryRunMerge();
				break;
			case "initial":
				$this->doInitialMerge();
				break;
			case "cleanup":
				$this->doCleanupMerge();
				break;
			case "attach":
				$this->doAttachMerge();
				break;
			case "remove":
				$this->doUnattach(); // FIXME: Method is undefined
				break;
			default:
				$this->invalidAction(); // FIXME: Method is undefined
				break;
			}
			return;
		}

		$globalUser = new CentralAuthUser( $this->mUserName );
		if ( $globalUser->exists() ) {
			if ( $globalUser->isAttached() ) {
				$this->showCleanupForm();
			} else {
				$this->showAttachForm();
			}
		} else {
			$this->showWelcomeForm();
		}
	}

	/**
	 * To pass potentially multiple passwords from one form submission
	 * to another while previewing the merge behavior, we can store them
	 * in the server-side session information.
	 *
	 * We'd rather not have plaintext passwords floating about on disk
	 * or memcached, so the session store is obfuscated with simple XOR
	 * encryption. The key is passed in the form instead of the session
	 * data, so they won't be found floating in the same place.
	 */
	private function initSession() {
		$this->mSessionToken = $this->getUser()->generateToken();

		// Generate a random binary string
		$key = '';
		for ( $i = 0; $i < 128; $i++ ) {
			$key .= chr( mt_rand( 0, 255 ) );
		}
		$this->mSessionKey = $key;
	}

	/**
	 * @return array|mixed
	 */
	private function getWorkingPasswords() {
		wfSuppressWarnings();
		$passwords = unserialize(
			gzinflate(
				$this->xorString(
					$_SESSION['wsCentralAuthMigration'][$this->mSessionToken],
					$this->mSessionKey ) ) );
				wfRestoreWarnings();
		if ( is_array( $passwords ) ) {
			return $passwords;
		}
		return array();
	}

	/**
	 * @param $password
	 */
	private function addWorkingPassword( $password ) {
		$passwords = $this->getWorkingPasswords();
		if ( !in_array( $password, $passwords ) ) {
			$passwords[] = $password;
		}

		// Lightly obfuscate the passwords while we're storing them,
		// just to make us feel better about them floating around.
		$_SESSION['wsCentralAuthMigration'][$this->mSessionToken] =
			$this->xorString(
				gzdeflate(
					serialize(
						$passwords ) ),
				$this->mSessionKey );
	}

	private function clearWorkingPasswords() {
		unset( $_SESSION['wsCentralAuthMigration'][$this->mSessionToken] );
	}

	/**
	 * @param $text
	 * @param $key
	 * @return array
	 */
	function xorString( $text, $key ) {
		if ( $key != '' ) {
			for ( $i = 0; $i < strlen( $text ); $i++ ) {
				$text[$i] = chr( 0xff & ( ord( $text[$i] ) ^ ord( $key[$i % strlen( $key )] ) ) );
			}
		}
		return $text;
	}

	function doDryRunMerge() {
		global $wgCentralAuthDryRun;
		$globalUser = new CentralAuthUser( $this->getUser()->getName() );

		if ( $globalUser->exists() ) {
			throw new MWException( "Already exists -- race condition" );
		}

		if ( $wgCentralAuthDryRun ) {
			$this->getOutput()->addWikiMsg( 'centralauth-notice-dryrun' );
		}

		$password = $this->getRequest()->getVal( 'wpPassword' );
		$this->addWorkingPassword( $password );
		$passwords = $this->getWorkingPasswords();

		$home = false;
		$attached = array();
		$unattached = array();
		$methods = array();
		$status = $globalUser->migrationDryRun( $passwords, $home, $attached, $unattached, $methods );

		if ( $status->isGood() ) {
			// This is the global account or matched it
			if ( count( $unattached ) == 0 ) {
				// Everything matched -- very convenient!
				$this->getOutput()->addWikiMsg( 'centralauth-merge-dryrun-complete' );
			} else {
				$this->getOutput()->addWikiMsg( 'centralauth-merge-dryrun-incomplete' );
			}

			if ( count( $unattached ) > 0 ) {
				$this->getOutput()->addHTML( $this->step2PasswordForm( $unattached ) );
				$this->getOutput()->addWikiMsg( 'centralauth-merge-dryrun-or' );
			}

			$subAttached = array_diff( $attached, array( $home ) );
			$this->getOutput()->addHTML( $this->step3ActionForm( $home, $subAttached, $methods ) );
		} else {
			// Show error message from status
			$this->getOutput()->addHTML( '<div class="errorbox" style="float:none;">' );
			$this->getOutput()->addWikiText( $status->getWikiText() );
			$this->getOutput()->addHTML( '</div>' );

			// Show wiki list if required
			if ( $status->hasMessage( 'centralauth-blocked-text' )
				|| $status->hasMessage( 'centralauth-merge-home-password' ) )
			{
				$out = '<h2>' . wfMsgHtml( 'centralauth-list-home-title' ) . '</h2>';
				$out .= wfMsgExt( 'centralauth-list-home-dryrun', 'parse' );
				$out .= $this->listAttached( array( $home ), array( $home => 'primary' ) );
				$this->getOutput()->addHTML( $out );
			}

			// Show password box
			$this->getOutput()->addHTML( $this->step1PasswordForm() );
		}
	}

	function doInitialMerge() {
		global $wgCentralAuthDryRun;
		$globalUser = new CentralAuthUser( $this->getUser()->getName() );

		if ( $wgCentralAuthDryRun ) {
			$this->dryRunError();
			return;
		}

		if ( $globalUser->exists() ) {
			throw new MWException( "Already exists -- race condition" );
		}

		$passwords = $this->getWorkingPasswords();
		if ( empty( $passwords ) ) {
			throw new MWException( "Submission error -- invalid input" );
		}

		$globalUser->storeAndMigrate( $passwords );
		$this->clearWorkingPasswords();

		$this->showCleanupForm();
	}

	function doCleanupMerge() {
		global $wgCentralAuthDryRun;
		$globalUser = new CentralAuthUser( $this->getUser()->getName() );

		if ( !$globalUser->exists() ) {
			throw new MWException( "User doesn't exist -- race condition?" );
		}

		if ( !$globalUser->isAttached() ) {
			throw new MWException( "Can't cleanup merge if not already attached." );
		}

		if ( $wgCentralAuthDryRun ) {
			$this->dryRunError();
			return;
		}
		$password = $this->getRequest()->getText( 'wpPassword' );

		$attached = array();
		$unattached = array();
		$ok = $globalUser->attemptPasswordMigration( $password, $attached, $unattached );
		$this->clearWorkingPasswords();

		if ( !$ok ) {
			if ( empty( $attached ) ) {
				$this->getOutput()->addWikiMsg( 'centralauth-finish-noconfirms' );
			} else {
				$this->getOutput()->addWikiMsg( 'centralauth-finish-incomplete' );
			}
		}
		$this->showCleanupForm();
	}

	function doAttachMerge() {
		global $wgCentralAuthDryRun;
		$globalUser = new CentralAuthUser( $this->getUser()->getName() );

		if ( !$globalUser->exists() ) {
			throw new MWException( "User doesn't exist -- race condition?" );
		}

		if ( $globalUser->isAttached() ) {
			throw new MWException( "Already attached -- race condition?" );
		}

		if ( $wgCentralAuthDryRun ) {
			$this->dryRunError();
			return;
		}
		$password = $this->getRequest()->getText( 'wpPassword' );
		if ( $globalUser->authenticate( $password ) == 'ok' ) {
			$globalUser->attach( wfWikiID(), 'password' );
			$this->getOutput()->addWikiMsg( 'centralauth-attach-success' );
			$this->showCleanupForm();
		} else {
			$this->getOutput()->addHTML(
				'<div class="errorbox">' .
					wfMsg( 'wrongpassword' ) .
				'</div>' .
				$this->attachActionForm() );
		}
	}

	private function showWelcomeForm() {
		global $wgCentralAuthDryRun;

		if ( $wgCentralAuthDryRun ) {
			$this->getOutput()->addWikiMsg( 'centralauth-notice-dryrun' );
		}

		$this->getOutput()->addWikiMsg( 'centralauth-merge-welcome' );
		$this->getOutput()->addWikiMsg( 'centralauth-readmore-text' );

		$this->initSession();
		$this->getOutput()->addHTML(
			$this->passwordForm(
				'dryrun',
				wfMsg( 'centralauth-merge-step1-title' ),
				wfMsg( 'centralauth-merge-step1-detail' ),
				wfMsg( 'centralauth-merge-step1-submit' ) )
			);
	}

	function showCleanupForm() {
		$globalUser = new CentralAuthUser( $this->getUser()->getName() );

		$merged = $globalUser->listAttached();
		$remainder = $globalUser->listUnattached();
		$this->showStatus( $merged, $remainder );
	}

	function showAttachForm() {
		$globalUser = new CentralAuthUser( $this->getUser()->getName() );
		$merged = $globalUser->listAttached();
		$this->getOutput()->addWikiMsg( 'centralauth-attach-list-attached', $this->mUserName );
		$this->getOutput()->addHTML( $this->listAttached( $merged ) );
		$this->getOutput()->addHTML( $this->attachActionForm() );
	}

	/**
	 * @param $merged
	 * @param $remainder
	 */
	function showStatus( $merged, $remainder ) {
		if ( count( $remainder ) > 0 ) {
			$this->getOutput()->setPageTitle( wfMsg( 'centralauth-incomplete' ) );
			$this->getOutput()->addWikiMsg( 'centralauth-incomplete-text' );
		} else {
			$this->getOutput()->setPageTitle( wfMsg( 'centralauth-complete' ) );
			$this->getOutput()->addWikiMsg( 'centralauth-complete-text' );
		}
		$this->getOutput()->addWikiMsg( 'centralauth-readmore-text' );

		if ( $merged ) {
			$this->getOutput()->addHTML( '<hr />' );
			$this->getOutput()->addWikiMsg( 'centralauth-list-attached',
				$this->mUserName );
			$this->getOutput()->addHTML( $this->listAttached( $merged ) );
		}

		if ( $remainder ) {
			$this->getOutput()->addHTML( '<hr />' );
			$this->getOutput()->addWikiMsg( 'centralauth-list-unattached',
				$this->mUserName );
			$this->getOutput()->addHTML( $this->listUnattached( $remainder ) );

			// Try the password form!
			$this->getOutput()->addHTML( $this->passwordForm(
				'cleanup',
				wfMsg( 'centralauth-finish-title' ),
				wfMsgExt( 'centralauth-finish-text', array( 'parse' ) ),
				wfMsg( 'centralauth-finish-login' ) ) );
		}
	}

	/**
	 * @param $wikiList
	 * @param $methods array
	 * @return string
	 */
	function listAttached( $wikiList, $methods = array() ) {
		return $this->listWikis( $wikiList, $methods );
	}

	/**
	 * @param $wikiList
	 * @return string
	 */
	function listUnattached( $wikiList ) {
		return $this->listWikis( $wikiList );
	}

	/**
	 * @param $list
	 * @param array $methods
	 * @return string
	 */
	function listWikis( $list, $methods = array() ) {
		asort( $list );
		return $this->formatList( $list, $methods, array( $this, 'listWikiItem' ) );
	}

	/**
	 * @param $items
	 * @param $methods
	 * @param $callback
	 * @return string
	 */
	function formatList( $items, $methods, $callback ) {
		if ( !$items ) {
			return '';
		} else {
			$itemMethods = array();
			foreach ( $items as $item ) {
				$itemMethods[] = isset( $methods[$item] ) ? $methods[$item] : '';
			}
			return "<ul>\n<li>" .
				implode( "</li>\n<li>",
					array_map( $callback, $items, $itemMethods ) ) .
				"</li>\n</ul>\n";
		}
	}

	/**
	 * @param $wikiID
	 * @param $method
	 * @return string
	 */
	function listWikiItem( $wikiID, $method ) {
		return
			$this->foreignUserLink( $wikiID ) . ( $method ? ' (' . wfMsgHtml( "centralauth-merge-method-$method" ) . ')' : '' );
	}

	/**
	 * @param $wikiID
	 * @return string
	 * @throws MWException
	 */
	function foreignUserLink( $wikiID ) {
		$wiki = WikiMap::getWiki( $wikiID );
		if ( !$wiki ) {
			throw new MWException( "no wiki for $wikiID" );
		}

		$hostname = $wiki->getDisplayName();
		$userPageName = 'User:' . $this->mUserName;
		$url = $wiki->getUrl( $userPageName );
		return Xml::element( 'a',
			array(
				'href' => $url,
				'title' => wfMsg( 'centralauth-foreign-link',
					$this->mUserName,
					$hostname ),
			),
			$hostname );
	}

	/**
	 * @param $action
	 * @param $title
	 * @param $text
	 * @return string
	 */
	private function actionForm( $action, $title, $text ) {
		return
			'<div id="userloginForm">' .
			Xml::openElement( 'form',
				array(
					'method' => 'post',
					'action' => $this->getTitle()->getLocalUrl( 'action=submit' ) ) ) .
			Xml::element( 'h2', array(), $title ) .
			Html::hidden( 'wpEditToken', $this->getUser()->getEditToken() ) .
			Html::hidden( 'wpMergeAction', $action ) .
			Html::hidden( 'wpMergeSessionToken', $this->mSessionToken ) .
			Html::hidden( 'wpMergeSessionKey', bin2hex( $this->mSessionKey ) ) .

			$text .

			Xml::closeElement( 'form' ) .

			'<br clear="all" />' .

			'</div>';
	}

	/**
	 * @param $action
	 * @param $title
	 * @param $text
	 * @param $submit
	 * @return string
	 */
	private function passwordForm( $action, $title, $text, $submit ) {
		return $this->actionForm(
			$action,
			$title,
			$text .
				'<table>' .
					'<tr>' .
						'<td>' .
							Xml::label(
								wfMsg( 'centralauth-finish-password' ),
								'wpPassword1' ) .
						'</td>' .
						'<td>' .
							Xml::input(
								'wpPassword', 20, '',
									array(
										'type' => 'password',
										'id' => 'wpPassword1' ) ) .
						'</td>' .
					'</tr>' .
					'<tr>' .
						'<td></td>' .
						'<td>' .
							Xml::submitButton( $submit,
								array( 'name' => 'wpLogin' ) ) .
						'</td>' .
					'</tr>' .
				'</table>' );
	}

	/**
	 * @return string
	 */
	private function step1PasswordForm() {
		return $this->passwordForm(
			'dryrun',
			wfMsg( 'centralauth-merge-step1-title' ),
			wfMsg( 'centralauth-merge-step1-detail' ),
			wfMsg( 'centralauth-merge-step1-submit' ) );
	}

	/**
	 * @param $unattached
	 * @return string
	 */
	private function step2PasswordForm( $unattached ) {
		return $this->passwordForm(
			'dryrun',
			wfMsg( 'centralauth-merge-step2-title' ),
			wfMsgExt( 'centralauth-merge-step2-detail', 'parse', $this->getUser()->getName() ) .
				$this->listUnattached( $unattached ),
			wfMsg( 'centralauth-merge-step2-submit' ) );
	}

	/**
	 * @param $home
	 * @param $attached
	 * @param $methods
	 * @return string
	 */
	private function step3ActionForm( $home, $attached, $methods ) {
		return $this->actionForm(
			'initial',
			wfMsg( 'centralauth-merge-step3-title' ),
			wfMsgExt( 'centralauth-merge-step3-detail', 'parse', $this->getUser()->getName() ) .
				'<h3>' . wfMsgHtml( 'centralauth-list-home-title' ) . '</h3>' .
				wfMsgExt( 'centralauth-list-home-dryrun', 'parse' ) .
				$this->listAttached( array( $home ), $methods ) .
				( count( $attached )
					? ( '<h3>' . wfMsgHtml( 'centralauth-list-attached-title' ) . '</h3>' .
						wfMsgExt( 'centralauth-list-attached-dryrun', 'parse', $this->getUser()->getName() ) )
					: '' ) .
				$this->listAttached( $attached, $methods ) .
				'<p>' .
					Xml::submitButton( wfMsg( 'centralauth-merge-step3-submit' ),
						array( 'name' => 'wpLogin' ) ) .
				'</p>'
			);
	}

	/**
	 * @return string
	 */
	private function attachActionForm() {
		return $this->passwordForm(
			'attach',
			wfMsg( 'centralauth-attach-title' ),
			wfMsg( 'centralauth-attach-text' ),
			wfMsg( 'centralauth-attach-submit' ) );
	}

	private function dryRunError() {
		$this->getOutput()->addWikiMsg( 'centralauth-disabled-dryrun' );
	}
}
