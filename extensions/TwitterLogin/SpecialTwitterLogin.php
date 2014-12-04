<?php
/**
 * SpecialTwitterLogin.php
 * Written by David Raison, based on the guideline published by Dave Challis 
 * at http://blogs.ecs.soton.ac.uk/webteam/2010/04/13/254/
 * @license: LGPL (GNU Lesser General Public License) http://www.gnu.org/licenses/lgpl.html
 *
 * @file SpecialTwitterLogin.php
 * @ingroup TwitterLogin
 *
 * @author David Raison
 *
 * Uses the twitter oauth library by Abraham Williams from https://github.com/abraham/twitteroauth
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is a MediaWiki extension, and must be run from within MediaWiki.' );
}


class SpecialTwitterLogin extends SpecialPage {

	private $_consumerKey;
	private $_consumerSecret;
	private $_twUserTable = 'twitter_user';	

	public function __construct(){
		parent::__construct('TwitterLogin');
		global $wgConsumerKey, $wgConsumerSecret, $wgScriptPath;

		$this->_consumerKey = $wgConsumerKey;
		$this->_consumerSecret = $wgConsumerSecret;
	}

	// default method being called by a specialpage
	public function execute( $parameter ){
		$this->setHeaders();
		switch($parameter){
			case 'redirect':
				$this->_redirect();
			break;
			case 'callback':
				$this->_handleCallback();
			break;
			default:
				$this->_default();
			break;			
		}
		
	}

	private function _default(){
		global $wgOut, $wgUser, $wgScriptPath, $wgExtensionAssetsPath;

		$wgOut->setPagetitle("Twitter Login");

		if ( !$wgUser->isLoggedIn() ) {
			$wgOut->addWikiMsg( 'twitterlogin-signup' );

			$wgOut->addHTML( '<a href="' . $this->getTitle( 'redirect' )->getFullURL() .'">'
				.'<img src="' . $wgExtensionAssetsPath . '/TwitterLogin/' . 
				'images/sign-in-with-twitter-d.png"/></a>' );
		} else {
			//$wgOut->addWikiText( wfMsg( 'twitterlogin-tietoaccount', $wgUser->getName() ) );
			$wgOut->addWikiMsg( 'twitterlogin-alreadyloggedin' );
		}
		return true;
	}

	private function _handleCallback(){
		global $wgScriptPath;
		session_start();

		if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
			$_SESSION['oauth_status'] = 'oldtoken';
			header('Location: '.$wgScriptPath.'/index.php');
		}

		// Reconnect to twitter and request access token
		$connection = $this->_doTwitterOAuth( $_SESSION['oauth_token'], $_SESSION['oauth_token_secret'] );
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

		/**
		 * Save the access tokens. Normally these would be saved in a database for future use. 
		 * Especially relevant if you'd want to read from or post to this user's timeline
		 */
		$_SESSION['access_token'] = $access_token;

		// Remove no longer needed request tokens 
		unset($_SESSION['oauth_token']);
		unset($_SESSION['oauth_token_secret']);

		/* If HTTP response is 200 continue otherwise send to connect page to retry */
		if ( $connection->http_code == 200 ) {
			/* The user has been verified and the access tokens can be saved for future use */
			$_SESSION['status'] = 'verified';
			$returnto = ( $this->_isFirstLogin() ) ? 'Special:Preferences' : $_SESSION['returnto'];
			header('Location: ' . $wgScriptPath . '/index.php/' . $returnto );
		} else {
			/* Save HTTP status for error dialog on connnect page.*/
			header('Location: /wiki/Special:TwitterLogin');
		}
	}

	private function _redirect(){
		global $wgRequest, $wgOut, $wgUser;

		// Creating OAuth object
		$connection = new MwTwitterOAuth( $this->_consumerKey, $this->_consumerSecret );

		// set callback url
		$oauthCallback = $this->getTitle( 'callback' )->getFullURL();

		// Getting temporary credentials
		$request_token = $connection->getRequestToken( $oauthCallback );

		// set returnto url
		$_SESSION['returnto'] = ( $wgRequest->getText( 'returnto' ) ) ? $wgRequest->getText( 'returnto' ) : '';

		// tie to existing account
		/*
		if( $wgUser->isLoggedIn() ) {
			$_SESSION['wiki_username'] = $wgUser->getName();
			$_SESSION['wiki_token'] = $wgUser->getToken();
		}
		*/

		// not sure if this is the proper way to do it in mediawiki ?!
		$_SESSION['oauth_token'] = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

		switch( $connection->http_code ){
			case 200:
			$url = $connection->getAuthorizeURL($request_token['oauth_token']);
			header('Location: '. $url);
			break;
			default:
			$wgOut->addWikiMsg( 'twitterlogin-couldnotconnect' );
			break;
		}
	}

	/**
	 * I'm not even sure it is possible to know this
	 **/
	private function _isFirstLogin() {
		return false;
	}

	/**
	 * First argument passed is a user object
	 * We return here after the callback has redirected us to $returnto with usually valid tokens in the session
	 */
	public function efTwitterAuth( $user ){
		if( session_id() == '' )
			session_start();

		// test if access tokens are set in our session
		if (empty($_SESSION['access_token']) 
			|| empty($_SESSION['access_token']['oauth_token'])
			|| empty($_SESSION['access_token']['oauth_token_secret'])) {
		        return false;
		}

		/* Unverified twitter credentials found, verify them */
		if (!isset($_SESSION['status']) || $_SESSION['status'] != 'verified') {
			$access_token = $_SESSION['access_token'];
			$connection = $this->_doTwitterOAuth( $access_token['oauth_token'], $access_token['oauth_token_secret'] );

			// verify credentials and create a new user session from the twitter screenname
			$v = $connection->get('account/verify_credentials');
			$user = $this->_userExists( $v->name, $v->screen_name );
		} else {
			// twitter oauth status is verified
			$user = $this->_userExists( $_SESSION['access_token']['name'], $_SESSION['access_token']['screen_name'] );
		}
		unset( $_SESSION['access_token'] );	// or we will not be able to log in as somebody else
		$user->setCookies();
		$user->saveSettings();
		return true;
	}

	private function _userExists( $name, $screen_name ) {
		$user = User::newFromName( $screen_name );

		/* let's see if this username already exists or whether it is tied to
		 * and already existing native account */
		if( $user->getId() == 0 )
			$this->_createUser( $user, $name, $screen_name );
		else $this->_isCreatedFromTwitter( $user );	// return false if not
		return $user;
	}

	/**
	 * Todo: if we are supposed to tie this account to an existing one, create it but don't use it
	 * --> cf _isCreatedFromTwitter --> relation
	 * Unfortunately there doesn't seem to be a way to disable or hide an account programmatically
	 */
	private function _createUser( $user, $name, $screen_name ){
		global $wgAuth;

		try {
			wfDebug( __METHOD__ . ':: created user ' . $screen_name . ' from Twitter' );
			$user->addToDatabase();
			$user->setRealName($name);

			if ( $wgAuth->allowPasswordChange() )
				$user->setPassword(User::randomPassword());

			$user->addGroup('twitter');
			//$user->confirmEmail();
			$user->setToken();

			// store the twitter id in our own table
			$this->_storeInTable( $user, $screen_name );	// $relation
			return true;

		} catch( Exception $e ) {
			print( $e->getTraceAsString() );
			return false;
		}
	}

	/* should we not use the external_user table since it has the exact same layout? */
	private function _storeInTable( $user, $screen_name ){
		$dbw = wfGetDB(DB_MASTER);
		$dbw->insert( $this->_twUserTable,
			array('tl_user_id' => $user->getId(), 'tl_twitter_id' => $screen_name),
			__METHOD__,
			array()
		);
	}

	// user already exists... was it created from twitter or did it alread exist before?
	private function _isCreatedFromTwitter( $user ){
		$dbr = wfGetDB(DB_SLAVE);
		$res = $dbr->select( $this->_twUserTable, 'tl_twitter_id',		//'tl_relation'
			array( 'tl_user_id' => $user->getId() ),
			__METHOD__
		);

		if ( $row = $dbr->fetchObject( $res ) ) {
			$dbr->freeResult( $res );
			$user->saveToCache();
		} else {
			$dbr->freeResult( $res );
			return false;
		}
	}

	private function _doTwitterOAuth( $at, $ats ){
		/* Get user access tokens out of the session. */
		return new MwTwitterOAuth(
			$this->_consumerKey,
			$this->_consumerSecret,
			$at,
			$ats
		);
	}

	public function efTwitterLogout(){
		if (session_id() == '') {
			session_start();
		}
		//setcookie(session_name(), session_id(), 1, '/');
		session_destroy();
		return true;
	}
}
