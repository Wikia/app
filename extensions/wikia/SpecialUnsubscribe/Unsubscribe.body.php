<?php
/**
 * Provides the special page to do unsubscibe stuff
 *
 * @file
 */
class UnsubscribePage extends UnlistedSpecialPage {

	var $mPrefname = 'unsubscribed';
	var $mUsers = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'Unsubscribe'/*class*/, null, false );
	}

	function getDescription() {
		return wfMsg( 'unsubscribe' );
	}

	/**
	 * Show the special page
	 *
	 * @param $subpage Mixed: parameter passed to the page or null
	 */
	public function execute( $subpage ) {
		global $wgRequest, $wgUser, $wgOut;
		wfLoadExtensionMessages( 'Unsubscribe' );

		$this->setHeaders();

		# DEVL - DONT FORGET TO REMOVE THIS
		/*
		if ( !$wgUser->isAllowed( 'staff' ) ) {
			$wgOut->addHTML("no peeking, we're not ready");
			$this->displayRestrictionError();
			return;
		}
		*/

		$email = $wgRequest->getText( 'email' , null );
		$token = $wgRequest->getText( 'token' , null );
		$timestamp = $wgRequest->getText( 'timestamp' , null );

		if ( $email == null || $token == null || $timestamp == null )
		{
			# give up now, abandon all hope.
			$wgOut->addWikiMsg( 'unsubscribe-badaccess' );
			return;
		}

		# TODO: will need changed when this function changes
		$shouldToken = wfGenerateUnsubToken( $email, $timestamp );
		if ( $token != $shouldToken )
		{
			$wgOut->addHTML( "shouldtoken={$shouldToken}\n" );
			$wgOut->addWikiMsg( 'unsubscribe-badtoken' );
			return;
		}

		# yes, i know this is a crappy check, i'm l.a.z.y.
		if ( strpos( $email, '@' ) !== false ) {
			# do the dew

			$confirmed = $wgRequest->getBool( 'confirm' , null );
			if ( $wgRequest->wasPosted() && $confirmed )
			{
				# they pushed the button
				$this->procUnsub( $email );
			}
			else
			{
				# give them the button to push
				$this->showInfo( $email , $token, $timestamp );
			}
		}
		else
		{
			# email wasnt blank, but didnt look like any email
			# TODO: add error message about malformed email here
			$wgOut->addWikiMsg( 'unsubscribe-bademail' );
			return;
		}
	}

	/**
	 * Fills local member with assoc array of uid=>username of all accounts that have that email
	 * @param $email string: email whose info we're looking up
	 */
	private function email2users( $email ) {
		$dbr = wfGetDB( DB_SLAVE );

		$oRes = $dbr->select( "user", array( "user_id", "user_name" ), array( "user_email" => $email ), __METHOD__ );

		$this->mUsers = array();
		while ( $oRow = $dbr->fetchObject( $oRes ) ) {
			$this->mUsers[ $oRow->user_id ] = $oRow->user_name;
		}
	}

	/**
	 * Retrieves and shows the gathered info to the user
	 * @param $email string: email whose info we're looking up
	 * @param $token string: token from url, to verify this link
	 */
	function showInfo( $email, $token, $timestamp ) {
		global $wgOut, $wgLang, $wgScript;


		/**
		 * find uid=>username(s) by email
		 */
		$this->email2users( $email );

		/**
		 * process names (if any)
		 */

		foreach ( $this->mUsers as $uid => $username )
		{
			# $user = User::newFromName( $username );
			$user = User::newFromId( $uid ); # is this faster?

			if ( $user == null || $user->getId() == 0 ) {
				# user bad? wtf?! how?
				continue;
			} else {

				$authTs = $user->getEmailAuthenticationTimestamp();
				if ( !$authTs ) {
					# if not confirmed, dont list here
					# note: DONT us the User->isEmailConfirmed function here
					# or we'll get cought in our own hook
					continue;
				}

				$namestring = "* " . wfMsg( 'username' );

				if ( $user->getBoolOption( $this->mPrefname ) ) {
					# user is alread unsubed
					$namestring .= " <s>{$username}</s>";
					$namestring .= " " . wfMsg( 'unsubscribe-already' );
				}
				else
				{
					# not yet
					$namestring .= " {$username}";
				}
				$wgOut->addWikiText( $namestring );

			}
		}

		/**
		 * form
		 */
		$form_action = htmlspecialchars( $this->getTitle()->getFullUrl() ); // for form
		$form_title = htmlspecialchars( $this->getTitle()->getPrefixedText() );

		$unsub_legend = wfMsg( 'unsubscribe-confirm-legend' );
		$unsub_text = wfMsg( 'unsubscribe-confirm-text', $email );
		$unsub_button = wfMsg( 'unsubscribe-confirm-button' );

		$wgOut->addHTML( <<<EOT
<fieldset>
<legend>{$unsub_legend}</legend>
<form method="post" action="{$form_action}">
<input type="hidden" name="title" value="{$form_title}" />
<input type="hidden" name="email" value="{$email}" />
<input type="hidden" name="token" value="{$token}" />
<input type="hidden" name="timestamp" value="{$timestamp}" />
<input type="hidden" name="confirm" value="1" />
{$unsub_text} &nbsp; <input type="submit" value="{$unsub_button}" />
</form>
</fieldset>
EOT
		);

	}

	/**
	 * processes a unsub request after being confirmed by user, and posted
	 * @param $email string: email whose info we're doing
	 */
	private function procUnsub( $email )
	{
		global $wgOut;

		/**
		 * load uid=>username(s) by email
		 */
		$this->email2users( $email );

		$wgOut->addWikiMsg( 'unsubscribe-working', count( $this->mUsers ), $email );

		foreach ( $this->mUsers as $uid => $username )
		{
			# $user = User::newFromName( $username );
			$user = User::newFromId( $uid ); # is this faster?

			if ( $user == null || $user->getId() == 0 ) {
				# user bad? wtf?! how?
				$wgOut->addWikiText( wfMsg( 'unsubscribe-working-problem', $username ) );
				continue;
			} else {
				# our new flag
				$user->setOption( $this->mPrefname, 1 );

				# play it safe, turn off the standard stuff
				# (users can do this on their own in they are logged in)
				# (this really just covers more bases)
				$user->setOption( 'enotifusertalkpages', 0 );
				$user->setOption( 'enotifwatchlistpages', 0 );
				$user->setOption( 'enotifminoredits', 0 );
				$user->setOption( 'watchlistdigest', 0 );
				$user->setOption( 'wpEmailFlag', 0 );
				$user->setOption( 'marketingallowed', 0 );

				# super important, dont forget to save the bits back to metal
				$user->saveSettings();

				$wgOut->addWikiText( '* ' . $username );
			}
		}
		$wgOut->addWikimsg( 'unsubscribe-working-done' );
	}

	static public function isEmailConfirmedHook( &$user, &$confirmed ) {
		if ( $user->getBoolOption( 'unsubscribed' ) ) {
			$confirmed = false;
			return false;
		}
		return true;
	}
}
