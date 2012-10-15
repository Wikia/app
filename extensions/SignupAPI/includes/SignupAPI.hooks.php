<?php
/**
 * Hooks for SignupAPI
 *
 * @file
 * @ingroup Extensions
 */

class SignupAPIHooks {

	/**
	 * @param $updater DatabaseUpdater
	 * @return bool
	 */
	static function onSourceTracking( $updater = null ) {
		if ( $updater !== null ) {
			$base = dirname( dirname( __FILE__ ) );
			$updater->addExtensionUpdate( array( 'addTable', 'sourcetracking',
				"$base/sourcetracking.sql", true ) );
		} else {
			global $wgExtNewTables;

			$wgExtNewTables[] = array(
				'sourcetracking',
				'sourcetracking.sql'
			);
		}
		return true;
	}

	static function addSourceTracking( &$personal_urls, &$title ) {
		global $wgRequest, $wgUser, $wgServer, $wgSecureLogin;

		// Generate source tracking parameters
		$sourceAction = $wgRequest->getVal( 'action' );
		$sourceNS = $title->getNamespace();
		$sourceArticle = $title->getArticleID();
		$loggedin = $wgUser->isLoggedIn();
		$thispage = $title->getPrefixedDBkey();
		$thisurl = $title->getPrefixedURL();
		$query = array();
		if ( !$wgRequest->wasPosted() ) {
			$query = $wgRequest->getValues();
			unset( $query['title'] );
			unset( $query['returnto'] );
			unset( $query['returntoquery'] );
		}
		$thisquery = wfUrlencode( wfArrayToCGI( $query ) );

		// Get the returnto and returntoquery parameters from the query string
		// or fall back on $this->thisurl or $this->thisquery
		// We can't use getVal()'s default value feature here because
		// stuff from $wgRequest needs to be escaped, but thisurl and thisquery
		// are already escaped.
		$page = $wgRequest->getVal( 'returnto' );
		if ( !is_null( $page ) ) {
			$page = wfUrlencode( $page );
		} else {
			$page = $thisurl;
		}
		$query = $wgRequest->getVal( 'returntoquery' );
		if ( !is_null( $query ) ) {
			$query = wfUrlencode( $query );
		} else {
			$query = $thisquery;
		}
		$returnto = "returnto=$page";
		if ( $query != '' ) {
			$returnto .= "&returntoquery=$query";
		}

		if (isset ( $personal_urls['login'] ) ) {
			$login_url = $personal_urls['login'];
			$login_url['href'] = $login_url['href']."&source_action=$sourceAction&source_ns=$sourceNS&source_article=$sourceArticle";
			$personal_urls['login'] = $login_url;
		}

		if ( isset ( $personal_urls['anonlogin'] ) ) {
			$login_url = $personal_urls['anonlogin'];
			$login_url['href'] = $login_url['href']."&source_action=$sourceAction&source_ns=$sourceNS&source_article=$sourceArticle";
			$personal_urls['anonlogin'] = $login_url;
		}

		if ( isset ( $personal_urls['createaccount'] ) ) {
			$page = $wgRequest->getVal( 'returnto' );
			$is_signup = $wgRequest->getText( 'type' ) == "signup";
			$createaccount_url = array(
				'text' => wfMsg( 'createaccount' ),
				'href' => SkinTemplate::makeSpecialUrl( 'UserSignup', "$returnto&type=signup&wpSourceAction=$sourceAction&wpSourceNS=$sourceNS&wpSourceArticle=$sourceArticle" ),
				'active' => $title->isSpecial( 'Userlogin' ) && $is_signup
			);
			if ( substr( $wgServer, 0, 5 ) === 'http:' && $wgSecureLogin ) {
				$title = SpecialPage::getTitleFor( 'UserSignup' );
				$https_url = preg_replace( '/^http:/', 'https:', $title->getFullURL( "type=signup" ) );
				$createaccount_url['href']	 = $https_url;
				$createaccount_url['class'] = 'link-https';
			}

			$personal_urls['createaccount'] = $createaccount_url;

		}

		return true;

	}

}
