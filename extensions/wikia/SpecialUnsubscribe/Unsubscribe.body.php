<?php
/**
 * Provides the special page for single point unsubscribe.
 * Access is done via links provided in emails to user ONLY.
 * URL will contain 3 query param:
 * *email: the email of the user we are unsub'ing
 * *timestamp: unix timestamp of when the link was generated.
 *  -links must be clicked within 7 days of being generated.
 * *token: unique hash that validates the email and timestamp
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
		parent::__construct( 'Unsubscribe'/*class*/, null/*permission*/, false/*listed?*/ );
	}

	function getDescription() {
		return $this->msg( 'unsubscribe' )->text();
	}

	/**
	 * Show the special page
	 *
	 * @param $subpage Mixed: parameter passed to the page or null
	 */
	public function execute( $subpage ) {
		// Set the variables for this instance
		$output = $this->getOutput();
		$user = $this->getUser();
		$request = $this->getRequest();

		$this->setHeaders();

		$hash_key = $wgRequest->getText('key', null );

		$email = $token = $timestamp = null;
		if ( !empty( $hash_key ) ) {
			#$hask_key = urldecode ( $hash_key );
			$data = Wikia::verifyUserSecretKey( $hash_key, 'sha256' );
			error_log( "data = " . print_r($data, true) );
			if ( !empty( $data ) ) {
				$username 	= ( isset( $data['user'] ) ) ? $data['user'] : null;
				$token 		= ( isset( $data['token'] ) ) ? $data['token'] : null;
				$timestamp 	= ( isset( $data['signature1'] ) ) ? $data['signature1'] : null;

				$oUser = User::newFromName( $username );
				$email = $oUser->getEmail();
			}
		} else {
			$email = $request->getText( 'email' , null );
			$token = $request->getText( 'token' , null );
			$timestamp = $request->getText( 'timestamp' , null );
		}

		if ( $email == null || $token == null || $timestamp == null ) {
			#give up now, abandon all hope.
			$output->addWikiMsg( 'unsubscribe-badaccess' );
			return;
		}

		#validate timestamp isnt spoiled (you only have 7 days)
		$timeCutoff = strtotime("7 days ago");
		if ( $timestamp <= $timeCutoff ) {
			$output->addWikiMsg( 'unsubscribe-badtime' );
			// $wgOut->addHTML("timestamp={$timestamp}\n"); #DEVL (remove before release)
			// $wgOut->addHTML("timeCutoff={$timeCutoff}\n"); #DEVL (remove before release)
			return;
		}

		#generate what the token SHOULD be
		$shouldToken = wfGenerateUnsubToken($email, $timestamp);
		if( $token != $shouldToken ) {
			$output->addWikiMsg( 'unsubscribe-badtoken' );
			// $wgOut->addHTML("shouldtoken={$shouldToken}\n"); #DEVL (remove before release)
			return;
		}

		#does the non-blank email they gave us look like an email?
		if( Sanitizer::validateEmail( $email ) == false ) {
			#email wasnt blank, but didnt look like any email
			$output->addWikiMsg( 'unsubscribe-bademail' );
			// $wgOut->addHTML("email={$email}\n"); #DEVL (remove before release)
			return;
		}

		#at this point, the 3 params check out.

		#is this their 2nd pass at this?
		$confirmed = $request->getBool( 'confirm' , null );
		if( $request->wasPosted() && $confirmed) {
			#this is the 2nd round, they pushed the button, so do it
			$this->procUnsub( $email );
		} else {
			#this is 1st pass, give them a button to push
			$this->showInfo( $email , $token, $timestamp);
		}

	}

	/**
	 * Fills local array with assoc array of uid=>username of all accounts that have that email
	 * @param $email string: email whose info we're looking up
	 */
	private function email2users($email) {
		global $wgExternalSharedDB;

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

		// use backticks in db name here.  $gExternalSharedDB is always on clusterA but access to the user table
		// will then try to switch back to wikicities_c2.user which does not exist on clusterA.
		// @see Database::tableName for reference
		$oRes = $dbr->select(
			"`user`",
			array("user_id", "user_name"),
			array( "user_email" => $email ),
			__METHOD__
		);

		#force blank before filling it
		$this->mUsers = array();

		while( $oRow = $dbr->fetchObject( $oRes ) ) {
			$this->mUsers[ $oRow->user_id ] = $oRow->user_name;
		}
	}

	/**
	 * Retrieves and shows the gathered info to the user
	 * @param $email string: email whose info we're looking up
	 * @param $token string: token from url, to verify this link
	 */
	function showInfo( $email, $token, $timestamp ) {
		global $wgScript;
		$lang = $this->getLanguage();
		$output = $this->getOutput();

		/**
		 * find uid=>username(s) by email
		 */
		$this->email2users( $email );

		if( empty($this->mUsers) ) {
			#no users with this email found in system
			#note: should never happen
			# (except... if they get the email, change their email,
			# then use a unsub link from an email sent to old address...)
			$output->addWikiMsg( 'unsubscribe-nousers' );
			return;
		}
		#$wgOut->addHTML( print_pre($this->mUsers,1) ); #DEVL

		/**
		 * process names (if any)
		 */

		foreach($this->mUsers as $uid=>$username)
		{
			#todo: which of these is better? IRC said "use ID if I have it", but also "meh"
			// $user = User::newFromName( $username );
			$user = User::newFromId( $uid );

			if ( $user == null || $user->getId() == 0 ) {
				#user bad? wtf?! how?
				unset( $this->mUsers[$uid] );
				continue;

			} else {
				#user object is good, safe to use.

				if ( !$user->isEmailConfirmed() ) {
					#if not confirmed, remove from list
					unset($this->mUsers[$uid]);
					continue;
				}

				#this shouldnt need to be checked, but we will anyway
				# we don't need it now - this is in EmailConfirmed hook
				/*if( $user->getBoolOption($this->mPrefname) ) {
					unset($this->mUsers[$uid]);
					continue;
				}*/

				#if hit this point, the name will be printed, and later processed
			}
		}

		#do we have atleast 1 left
		if( empty( $this->mUsers ) ) {
			$output->addWikiMsg( 'unsubscribe-noconfusers' );
			return;
		}

		#reloop over any left, actually print this time
		$output->addHTML( Xml::openElement( 'ul' ) );
		foreach ( $this->mUsers as $uid => $username ) {
			#not yet
			$output->addHTML( Xml::element( 'li', null, $username ) );
		}
		$output->addHTML( Xml::closeElement( 'ul' ) );

		/**
		 * form
		 */
		$form_action = htmlspecialchars( $this->getTitle()->getFullUrl() );
		$form_title = htmlspecialchars( $this->getTitle()->getPrefixedText() );

		$unsub_legend = wfMessage( 'unsubscribe-confirm-legend' )->text();
		$unsub_text = wfMessage( 'unsubscribe-confirm-text', $email )->text();
		$unsub_button = wfMessage( 'unsubscribe-confirm-button' )->text();

		# Build the form
		$fieldset = Html::openElement( "form", array(
			"method" => "POST",
			"action" => $form_action
		) );
		$fieldset .= Html::input( "title", $form_title, "hidden" );
		$fieldset .= Html::input( "email", $email, "hidden" );
		$fieldset .= Html::input( "token", $token, "hidden" );
		$fieldset .= Html::input( "timestamp", $timestamp, "hidden" );
		$fieldset .= Html::input( "confirm", "1", "hidden" );
		$fieldset .= $unsub_text;
		$fieldset .= Html::input( null, $unsub_button, "submit" );
		$fieldset .= Html::closeElement( "form" );
		$output->addHTML( Xml::fieldset( $unsub_legend, $fieldset ) );
	}

	/**
	 * processes a unsub request after being confirmed by user, and posted
	 * @param $email string: email whose info we're doing
	 */
	private function procUnsub( $email )
	{
		$output = $this->getOutput();

		/**
		 * load uid=>username(s) by email
		 */
		$this->email2users( $email );

		$output->addWikiMsg( 'unsubscribe-working', count( $this->mUsers ), $email );

		foreach($this->mUsers as $uid=>$username)
		{
			#$user = User::newFromName( $username );
			$user = User::newFromId( $uid ); #is this faster?

			if ( $user == null || $user->getId() == 0 ) {
				#user bad? wtf?! how?
				$output->addWikiText( '* ' . wfMessage( 'unsubscribe-working-problem', $username )->text() );
				continue;
			} else {
				if ( !$user->isEmailConfirmed() ) {
					#if not confirmed, dont do stuff

					continue;
				}

				#our new flag
				$user->setOption( $this->mPrefname, 1);

				#FB:1758 don't invalidate email, but do turn off email options
				#(users can do this on their own when they are logged in)
				$user->setOption( 'enotiffollowedpages', 0);
				$user->setOption( 'enotifusertalkpages', 0);
				$user->setOption( 'enotifwatchlistpages', 0);
				$user->setOption( 'enotifminoredits', 0);
				$user->setOption( 'watchlistdigest', 0);
				$user->setOption( 'marketingallowed', 0);
				$user->setOption( 'disablemail', 1);

				#super important, dont forget to save the bits back to metal
				$user->saveSettings();

				$output->addWikiText('* ' . $username );
			}
		}
		$output->addWikiMsg( 'unsubscribe-working-done' );
	}
}
