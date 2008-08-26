<?php

class SpecialMergeAccount extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages('SpecialCentralAuth');
		parent::__construct( 'MergeAccount', 'centralauth-merge' );
	}

	function execute( $subpage ) {
		global $wgOut, $wgRequest, $wgUser;
		$this->setHeaders();

		if ( !$this->userCanExecute( $wgUser ) ) {
			$wgOut->addWikiText(
				wfMsg( 'centralauth-merge-denied' ) .
				"\n\n" .
				wfMsg( 'centralauth-readmore-text' ) );
			return;
		}

		if( !$wgUser->isLoggedIn() ) {
			$wgOut->addWikiText(
				wfMsg( 'centralauth-merge-notlogged' ) .
				"\n\n" .
				wfMsg( 'centralauth-readmore-text' ) );

			return;
		}

		global $wgUser, $wgRequest;
		$this->mUserName = $wgUser->getName();

		$this->mAttemptMerge = $wgRequest->wasPosted();

		$this->mMergeAction = $wgRequest->getVal( 'wpMergeAction' );
		$this->mPassword = $wgRequest->getVal( 'wpPassword' );
		$this->mWikiIDs = $wgRequest->getArray( 'wpWikis' );
		$this->mSessionToken = $wgRequest->getVal( 'wpMergeSessionToken' );
		$this->mSessionKey = pack( "H*", $wgRequest->getVal( 'wpMergeSessionKey' ) );

		// Possible demo states

		// success, all accounts merged
		// successful login, some accounts merged, others left
		// successful login, others left
		// not account owner, others left

		// is owner / is not owner
		// did / did not merge some accounts
		// do / don't have more accounts to merge

		if( $this->mAttemptMerge ) {
			switch( $this->mMergeAction ) {
			case "dryrun":
				return $this->doDryRunMerge();
			case "initial":
				return $this->doInitialMerge();
			case "cleanup":
				return $this->doCleanupMerge();
			case "attach":
				return $this->doAttachMerge();
			case "remove":
				return $this->doUnattach();
			default:
				return $this->invalidAction();
			}
		}

		$globalUser = new CentralAuthUser( $this->mUserName );
		if( $globalUser->exists() ) {
			if( $globalUser->isAttached() ) {
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
		global $wgUser;
		$this->mSessionToken = $wgUser->generateToken();

		// Generate a random binary string
		$key = '';
		for( $i = 0; $i < 128; $i++ ) {
			$key .= chr( mt_rand( 0, 255 ) );
		}
		$this->mSessionKey = $key;
	}

	private function getWorkingPasswords() {
		wfSuppressWarnings();
		$passwords = unserialize(
			gzinflate(
				$this->xorString(
					$_SESSION['wsCentralAuthMigration'][$this->mSessionToken],
					$this->mSessionKey ) ) );
				wfRestoreWarnings();
		if( is_array( $passwords ) ) {
			return $passwords;
		}
		return array();
	}

	private function addWorkingPassword( $password ) {
		$passwords = $this->getWorkingPasswords();
		if( !in_array( $password, $passwords ) ) {
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

	function xorString( $text, $key ) {
		if( $key != '' ) {
			for( $i = 0; $i < strlen( $text ); $i++ ) {
				$text[$i] = chr(0xff & (ord($text[$i]) ^ ord($key[$i % strlen( $key )])));
			}
		}
		return $text;
	}



	function doDryRunMerge() {
		global $wgUser, $wgRequest, $wgOut, $wgCentralAuthDryRun;
		$globalUser = new CentralAuthUser( $wgUser->getName() );

		if( $globalUser->exists() ) {
			throw new MWException( "Already exists -- race condition" );
		}

		if( $wgCentralAuthDryRun ) {
			$wgOut->addWikiText( wfMsg( 'centralauth-notice-dryrun' ) );
		}

		$password = $wgRequest->getVal( 'wpPassword' );
		$this->addWorkingPassword( $password );
		$passwords = $this->getWorkingPasswords();

		$home = false;
		$attached = array();
		$unattached = array();
		$methods = array();
		$status = $globalUser->migrationDryRun( $passwords, $home, $attached, $unattached, $methods );

		if( $status->isGood() ) {
			// This is the global account or matched it
			if( count( $unattached ) == 0 ) {
				// Everything matched -- very convenient!
				$wgOut->addWikiText( wfMsg( 'centralauth-merge-dryrun-complete' ) );
			} else {
				$wgOut->addWikiText( wfMsg( 'centralauth-merge-dryrun-incomplete' ) );
			}

			if( count( $unattached ) > 0 ) {
				$wgOut->addHtml( $this->step2PasswordForm( $unattached ) );
				$wgOut->addWikiText( wfMsg( 'centralauth-merge-dryrun-or' ) );
			}

			$subAttached = array_diff( $attached, array( $home ) );
			$wgOut->addHtml( $this->step3ActionForm( $home, $subAttached, $methods ) );
		} else {
			// Show error message from status
			$wgOut->addHtml( '<div class="errorbox" style="float:none;">' );
			$wgOut->addWikiText( $status->getWikiText() );
			$wgOut->addHtml( '</div>' );

			// Show wiki list if required
			if ( $status->hasMessage( 'centralauth-blocked-text' ) 
				|| $status->hasMessage( 'centralauth-merge-home-password' ) )
			{
				$out = '<h2>' . wfMsgHtml( 'centralauth-list-home-title' ) . '</h2>';
				$out .= wfMsgExt( 'centralauth-list-home-dryrun', 'parse' );
				$out .= $this->listAttached( array( $home ), array( $home => 'primary' ) );
				$wgOut->addHtml( $out );
			}

			// Show password box
			$wgOut->addHTML( $this->step1PasswordForm() );
		}
	}

	function doInitialMerge() {
		global $wgUser, $wgRequest, $wgOut, $wgCentralAuthDryRun;
		$globalUser = new CentralAuthUser( $wgUser->getName() );

		if( $wgCentralAuthDryRun ) {
			return $this->dryRunError();
		}

		if( $globalUser->exists() ) {
			throw new MWException( "Already exists -- race condition" );
		}

		$passwords = $this->getWorkingPasswords();
		if( empty( $passwords ) ) {
			throw new MWException( "Submission error -- invalid input" );
		}

		$home = false;
		$attached = array();
		$unattached = array();
		$ok = $globalUser->storeAndMigrate( $passwords );
		$this->clearWorkingPasswords();

		$this->showCleanupForm();
	}

	function doCleanupMerge() {
		global $wgUser, $wgRequest, $wgOut, $wgCentralAuthDryRun;
		$globalUser = new CentralAuthUser( $wgUser->getName() );

		if( !$globalUser->exists() ) {
			throw new MWException( "User doesn't exist -- race condition?" );
		}

		if( !$globalUser->isAttached() ) {
			throw new MWException( "Can't cleanup merge if not already attached." );
		}

		if( $wgCentralAuthDryRun ) {
			return $this->dryRunError();
		}
		$password = $wgRequest->getText( 'wpPassword' );

		$home = false;
		$attached = array();
		$unattached = array();
		$ok = $globalUser->attemptPasswordMigration( $password, $attached, $unattached );
		$this->clearWorkingPasswords();

		if( !$ok ) {
			if( empty( $attached ) ) {
				$wgOut->addWikiText( wfMsg( 'centralauth-finish-noconfirms' ) );
			} else {
				$wgOut->addWikiText( wfMsg( 'centralauth-finish-incomplete' ) );
			}
		}
		$this->showCleanupForm();
	}

	function doAttachMerge() {
		global $wgUser, $wgRequest, $wgOut, $wgCentralAuthDryRun;
		$globalUser = new CentralAuthUser( $wgUser->getName() );

		if( !$globalUser->exists() ) {
			throw new MWException( "User doesn't exist -- race condition?" );
		}

		if( $globalUser->isAttached() ) {
			throw new MWException( "Already attached -- race condition?" );
		}

		if( $wgCentralAuthDryRun ) {
			return $this->dryRunError();
		}
		$password = $wgRequest->getText( 'wpPassword' );
		if( $globalUser->authenticate( $password ) == 'ok' ) {
			$globalUser->attach( wfWikiID(), 'password' );
			$wgOut->addWikiText( wfMsg( 'centralauth-attach-success' ) );
			$this->showCleanupForm();
		} else {
			$wgOut->addHtml(
				'<div class="errorbox">' .
					wfMsg( 'wrongpassword' ) .
				'</div>' .
				$this->attachActionForm() );
		}
	}

	private function showWelcomeForm() {
		global $wgOut, $wgUser, $wgCentralAuthDryRun;

		if( $wgCentralAuthDryRun ) {
			$wgOut->addWikiText( wfMsg( 'centralauth-notice-dryrun' ) );
		}

		$wgOut->addWikiText(
			wfMsg( 'centralauth-merge-welcome' ) .
			"\n\n" .
			wfMsg( 'centralauth-readmore-text' ) );

		$this->initSession();
		$wgOut->addHtml(
			$this->passwordForm(
				'dryrun',
				wfMsg( 'centralauth-merge-step1-title' ),
				wfMsg( 'centralauth-merge-step1-detail' ),
				wfMsg( 'centralauth-merge-step1-submit' ) )
			);
	}

	function showCleanupForm() {
		global $wgUser;
		$globalUser = new CentralAuthUser( $wgUser->getName() );

		$merged = $globalUser->listAttached();
		$remainder = $globalUser->listUnattached();
		$this->showStatus( $merged, $remainder );
	}

	function showAttachForm() {
		global $wgOut, $wgUser;
		$globalUser = new CentralAuthUser( $wgUser->getName() );
		$merged = $globalUser->listAttached();
		$wgOut->addWikiText( wfMsg( 'centralauth-attach-list-attached', $this->mUserName ) );
		$wgOut->addHtml( $this->listAttached( $merged ) );
		$wgOut->addHtml( $this->attachActionForm() );
	}

	function showStatus( $merged, $remainder ) {
		global $wgOut;

		if( count( $remainder ) > 0 ) {
			$wgOut->setPageTitle( wfMsg( 'centralauth-incomplete' ) );
			$wgOut->addWikiText( wfMsg( 'centralauth-incomplete-text' ) );
		} else {
			$wgOut->setPageTitle( wfMsg( 'centralauth-complete' ) );
			$wgOut->addWikiText( wfMsg( 'centralauth-complete-text' ) );
		}
		$wgOut->addWikiText( wfMsg( 'centralauth-readmore-text' ) );

		if( $merged ) {
			$wgOut->addHtml( '<hr />' );
			$wgOut->addWikiText( wfMsg( 'centralauth-list-attached',
				$this->mUserName ) );
			$wgOut->addHtml( $this->listAttached( $merged ) );
		}

		if( $remainder ) {
			$wgOut->addHtml( '<hr />' );
			$wgOut->addWikiText( wfMsg( 'centralauth-list-unattached',
				$this->mUserName ) );
			$wgOut->addHtml( $this->listUnattached( $remainder ) );

			// Try the password form!
			$wgOut->addHtml( $this->passwordForm(
				'cleanup',
				wfMsg( 'centralauth-finish-title' ),
				wfMsgExt( 'centralauth-finish-text', array( 'parse' ) ),
				wfMsg( 'centralauth-finish-login' ) ) );
		}
	}

	function listAttached( $wikiList, $methods=array() ) {
		return $this->listWikis( $wikiList, $methods );
	}

	function listUnattached( $wikiList ) {
		return $this->listWikis( $wikiList );
	}

	function listWikis( $list, $methods=array() ) {
		asort( $list );
		return $this->formatList( $list, $methods, array( $this, 'listWikiItem' ) );
	}

	function formatList( $items, $methods, $callback ) {
		if( !$items ) {
			return '';
		} else {
			$itemMethods = array();
			foreach( $items as $item ) {
				$itemMethods[] = isset( $methods[$item] ) ? $methods[$item] : '';
			}
			return "<ul>\n<li>" .
				implode( "</li>\n<li>",
					array_map( $callback, $items, $itemMethods ) ) .
				"</li>\n</ul>\n";
		}
	}

	function listWikiItem( $wikiID, $method ) {
		return
			$this->foreignUserLink( $wikiID ) . ( $method ? ' (' . wfMsgHtml( "centralauth-merge-method-$method" ) . ')' : '' );
	}

	function foreignUserLink( $wikiID ) {
		$wiki = WikiMap::getWiki( $wikiID );
		if( !$wiki ) {
			throw new MWException( "no wiki for $wikiID" );
		}

		$hostname = $wiki->getDisplayName();
		$userPageName = 'User:' . $this->mUserName;
		$url = $wiki->getUrl( $userPageName );
		return wfElement( 'a',
			array(
				'href' => $url,
				'title' => wfMsg( 'centralauth-foreign-link',
					$this->mUserName,
					$hostname ),
			),
			$hostname );
	}

	private function actionForm( $action, $title, $text ) {
		global $wgUser;
		return
			'<div id="userloginForm">' .
			Xml::openElement( 'form',
				array(
					'method' => 'post',
					'action' => $this->getTitle()->getLocalUrl( 'action=submit' ) ) ) .
			Xml::element( 'h2', array(), $title ) .
			Xml::hidden( 'wpEditToken', $wgUser->editToken() ) .
			Xml::hidden( 'wpMergeAction', $action ) .
			Xml::hidden( 'wpMergeSessionToken', $this->mSessionToken ) .
			Xml::hidden( 'wpMergeSessionKey', bin2hex( $this->mSessionKey ) ) .

			$text .

			Xml::closeElement( 'form' ) .

			'<br clear="all" />' .

			'</div>';
	}

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

	private function step1PasswordForm() {
		return $this->passwordForm(
			'dryrun',
			wfMsg( 'centralauth-merge-step1-title' ),
			wfMsg( 'centralauth-merge-step1-detail' ),
			wfMsg( 'centralauth-merge-step1-submit' ) );
	}

	private function step2PasswordForm( $unattached ) {
		global $wgUser;
		return $this->passwordForm(
			'dryrun',
			wfMsg( 'centralauth-merge-step2-title' ),
			wfMsgExt( 'centralauth-merge-step2-detail', 'parse', $wgUser->getName() ) .
				$this->listUnattached( $unattached ),
			wfMsg( 'centralauth-merge-step2-submit' ) );
	}

	private function step3ActionForm( $home, $attached, $methods ) {
		global $wgUser;
		return $this->actionForm(
			'initial',
			wfMsg( 'centralauth-merge-step3-title' ),
			wfMsgExt( 'centralauth-merge-step3-detail', 'parse', $wgUser->getName() ) .
				'<h3>' . wfMsgHtml( 'centralauth-list-home-title' ) . '</h3>' .
				wfMsgExt( 'centralauth-list-home-dryrun', 'parse' ) .
				$this->listAttached( array( $home ), $methods ) .
				( count( $attached )
					? ( '<h3>' . wfMsgHtml( 'centralauth-list-attached-title' ) . '</h3>' .
						wfMsgExt( 'centralauth-list-attached-dryrun', 'parse', $wgUser->getName() ) )
					: '' ) .
				$this->listAttached( $attached, $methods ) .
				'<p>' .
					Xml::submitButton( wfMsg( 'centralauth-merge-step3-submit' ),
						array( 'name' => 'wpLogin' ) ) .
				'</p>'
			);
	}

	private function attachActionForm() {
		return $this->passwordForm(
			'attach',
			wfMsg( 'centralauth-attach-title' ),
			wfMsg( 'centralauth-attach-text' ),
			wfMsg( 'centralauth-attach-submit' ) );
	}

	private function dryRunError() {
		global $wgOut;
		$wgOut->addWikiText( wfMsg( 'centralauth-disabled-dryrun' ) );
	}
}
