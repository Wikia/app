<?php

class OpenIDHooks {
	public static function onSpecialPage_initList( &$list ) {
		global $wgOpenIDOnly, $wgOpenIDClientOnly;

		if ( $wgOpenIDOnly ) {
			$list['Userlogin'] = array( 'SpecialRedirectToSpecial', 'Userlogin', 'OpenIDLogin' );
			# Used in 1.12.x and above
			$list['CreateAccount'] = array( 'SpecialRedirectToSpecial', 'CreateAccount', 'OpenIDLogin' );
		}

		# Special pages are added at global scope; remove server-related ones
		# if client-only flag is set
		$addList = array( 'Login', 'Finish', 'Convert' );
		if ( !$wgOpenIDClientOnly ) {
			$addList[] = 'Server';
			$addList[] = 'XRDS';
		}

		foreach ( $addList as $sp ) {
			$list['OpenID'.$sp] = 'SpecialOpenID' . $sp;
		}

		return true;
	}

	# Hook is called whenever an article is being viewed
	public static function onArticleViewHeader( &$article, &$outputDone, &$pcache ) {
		global $wgOut, $wgOpenIDClientOnly;

		$nt = $article->getTitle();

		// If the page being viewed is a user page,
		// generate the openid.server META tag and output
		// the X-XRDS-Location.  See the OpenIDXRDS
		// special page for the XRDS output / generation
		// logic.

		if ( $nt && $nt->getNamespace() == NS_USER && strpos( $nt->getText(), '/' ) === false ) {
			$user = User::newFromName( $nt->getText() );
			if ($user && $user->getID() != 0) {
				$openid = SpecialOpenID::getUserUrl( $user );
				if ( isset( $openid ) && strlen( $openid ) != 0 ) {
					global $wgOpenIDShowUrlOnUserPage;

					if ( $wgOpenIDShowUrlOnUserPage == 'always' ||
						( $wgOpenIDShowUrlOnUserPage == 'user' && !$user->getOption( 'openid-hide' ) ) )
					{
						global $wgOpenIDLoginLogoUrl;

						$url = SpecialOpenID::OpenIDToUrl( $openid );
						$disp = htmlspecialchars( $openid );
						$wgOut->setSubtitle("<span class='subpages'>" .
											"<img src='$wgOpenIDLoginLogoUrl' alt='OpenID' />" .
											"<a href='$url'>$disp</a>" .
											"</span>");
					}
				} else {
					# Add OpenID data iif its allowed
					if ( !$wgOpenIDClientOnly ) {
						$st = SpecialPage::getTitleFor( 'OpenIDServer' );
						$wgOut->addLink( array( 'rel' => 'openid.server',
											    'href' => $st->getFullURL() ) );
						$wgOut->addLink( array( 'rel' => 'openid2.provider',
											    'href' => $st->getFullURL() ) );
						$rt = SpecialPage::getTitleFor( 'OpenIDXRDS', $user->getName() );
						$wgOut->addMeta( 'http:X-XRDS-Location', $rt->getFullURL() );
						header( 'X-XRDS-Location', $rt->getFullURL() );
					}
				}
			}
		}

		return true;
	}

	public static function onPersonalUrls(&$personal_urls, &$title) {
		global $wgHideOpenIDLoginLink, $wgUser, $wgLang, $wgOut, $wgOpenIDOnly;

		if ( !$wgHideOpenIDLoginLink && $wgUser->getID() == 0 ) {
			wfLoadExtensionMessages( 'OpenID' );
			$wgOut->addHeadItem( 'openidloginstyle', self::loginStyle() );
			$sk = $wgUser->getSkin();
			$returnto = $title->isSpecial( 'Userlogout' ) ?
			  '' : ('returnto=' . $title->getPrefixedURL() );

			$personal_urls['openidlogin'] = array(
				'text' => wfMsg( 'openidlogin' ),
				'href' => $sk->makeSpecialUrl( 'OpenIDLogin', $returnto ),
				'active' => $title->isSpecial( 'OpenIDLogin' )
			);

			if ( $wgOpenIDOnly ) {
				# remove other login links
				foreach ( array( 'login', 'anonlogin' ) as $k ) {
					if ( array_key_exists( $k, $personal_urls ) ) {
						unset( $personal_urls[$k] );
					}
				}
			}
		}

		return true;
	}

	# list of preferences used by extension
	private static $oidPrefs = array( 'hide', 'update-userinfo-on-login' );

	public static function onInitPreferencesForm( $prefs, $request ) {
		foreach (self::$oidPrefs as $oidPref)
		{
			$prefs->mToggles['openid-'.$oidPref]
				= $request->getCheck( "wpOpOpenID-".$oidPref ) ? 1 : 0;
		}

		return true;
	}

	public static function onRenderPreferencesForm( $prefs, $out ) {
		wfLoadExtensionMessages( 'OpenID' );

		$out->addHTML( "\n<fieldset>\n<legend>" . wfMsgHtml( 'openid-prefs' ) . "</legend>\n" );

		$out->addWikiText( wfMsg( 'openid-prefstext') );

		foreach (self::$oidPrefs as $oidPref)
		{
			$out->addHTML( '<div class="toggle"><input type="checkbox" value="1" '.
					'id="openid-'.$oidPref.'" name="wpOpOpenID-'.$oidPref.'"'.
					($prefs->mToggles['openid-'.$oidPref] == 1 ? ' checked="checked"' : '').
				'/> ' .
				'<span class="toggletext">'.
				'<label for="openid-'.$oidPref.'">'.wfMsg( 'openid-pref-'.$oidPref ).'</label>'.
				"</span></div>\n" );
		}

		$out->addHTML( "</fieldset>\n\n" );

		return true;
	}

	public static function onSavePreferences($prefs, $user, &$message, $old)
	{
		foreach (self::$oidPrefs as $oidPref)
		{
			$user->setOption('openid-'.$oidPref, $prefs->mToggles['openid-'.$oidPref]);
			wfDebugLog('OpenID', 'Setting user preferences: ' . print_r($user, true) );
		}

		$user->saveSettings();

		return true;
	}

	public static function onResetPreferences( $prefs, $user )
	{
		foreach ( self::$oidPrefs as $oidPref ) {
			$prefs->mToggles['openid-'.$oidPref] = $user->getOption( 'openid-'.$oidPref );
		}

		return true;
	}

	public static function onLoadExtensionSchemaUpdates() {
		global $wgDBtype, $wgExtNewTables;

		$base = dirname( __FILE__ );

		if( $wgDBtype == 'mysql' ) {
			$wgExtNewTables[] = array( 'user_openid', "$base/openid_table.sql" );
		} else if( $wgDBtype == 'postgres' ) {
			$wgExtNewTables[] = array( 'user_openid', "$base/openid_table.pg.sql" );
		}

		return true;
	}

	private static function loginStyle() {
		global $wgOpenIDLoginLogoUrl;
			return <<<EOS
		<style type='text/css'>
		li#pt-openidlogin {
		  background: url($wgOpenIDLoginLogoUrl) top left no-repeat;
		  padding-left: 20px;
		  text-transform: none;
		}
		</style>
EOS;
	}
}
