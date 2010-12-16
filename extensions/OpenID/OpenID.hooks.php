<?php

class OpenIDHooks {
	public static function onSpecialPage_initList( &$list ) {
		global $wgOpenIDOnly, $wgOpenIDClientOnly;

		if ( $wgOpenIDOnly ) {
			$list['Userlogin'] = array( 'SpecialRedirectToSpecial', 'Userlogin', 'OpenIDLogin', false, array( 'returnto', 'returntoquery' ) );
			# Used in 1.12.x and above
			$list['CreateAccount'] = array( 'SpecialRedirectToSpecial', 'CreateAccount', 'OpenIDLogin' );
		}

		# Special pages are added at global scope; remove server-related ones
		# if client-only flag is set
		$addList = array( 'Login', 'Convert' );
		if ( !$wgOpenIDClientOnly ) {
			$addList[] = 'Server';
			$addList[] = 'XRDS';
		}

		foreach ( $addList as $sp ) {
			$list['OpenID' . $sp] = 'SpecialOpenID' . $sp;
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
			if ( $user && $user->getID() != 0 ) {
				$openid = SpecialOpenID::getUserUrl( $user );
				if ( count( $openid ) && strlen( $openid[0] ) != 0 ) {
					global $wgOpenIDShowUrlOnUserPage;

					if ( $wgOpenIDShowUrlOnUserPage == 'always' ||
						( $wgOpenIDShowUrlOnUserPage == 'user' && !$user->getOption( 'openid-hide' ) ) )
					{
						global $wgOpenIDLoginLogoUrl;

						$url = SpecialOpenID::OpenIDToUrl( $openid[0] );
						$disp = htmlspecialchars( $openid[0] );
						$wgOut->setSubtitle( "<span class='subpages'>" .
											"<img src='$wgOpenIDLoginLogoUrl' alt='OpenID' />" .
											"<a href='$url'>$disp</a>" .
											"</span>" );
					}
				} else {
					# Add OpenID data if its allowed
					if ( !$wgOpenIDClientOnly ) {
						$st = SpecialPage::getTitleFor( 'OpenIDServer' );
						$wgOut->addLink( array( 'rel' => 'openid.server',
												'href' => $st->getFullURL() ) );
						$wgOut->addLink( array( 'rel' => 'openid2.provider',
												'href' => $st->getFullURL() ) );
						$rt = SpecialPage::getTitleFor( 'OpenIDXRDS', $user->getName() );
						$wgOut->addMeta( 'http:X-XRDS-Location', $rt->getFullURL() );
						header( 'X-XRDS-Location: ' . $rt->getFullURL() );
					}
				}
			}
		}

		return true;
	}

	public static function onPersonalUrls( &$personal_urls, &$title ) {
		global $wgHideOpenIDLoginLink, $wgUser, $wgLang, $wgOpenIDOnly;

		if ( !$wgHideOpenIDLoginLink && $wgUser->getID() == 0 ) {
			wfLoadExtensionMessages( 'OpenID' );
			$sk = $wgUser->getSkin();
			$returnto = $title->isSpecial( 'Userlogout' ) ?
			  '' : ( 'returnto=' . $title->getPrefixedURL() );

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

	public static function onBeforePageDisplay( $out, &$sk ) {
		global $wgHideOpenIDLoginLink, $wgUser;

		# We need to do this *before* PersonalUrls is called 
		if ( !$wgHideOpenIDLoginLink && $wgUser->getID() == 0 ) {
			$out->addHeadItem( 'openidloginstyle', self::loginStyle() );
		}

		return true;
	}

	private static function getInfoTable( $user ) {
		$urls = SpecialOpenID::getUserUrl( $user );
		$delTitle = SpecialPage::getTitleFor( 'OpenIDConvert', 'Delete' );
		$sk = $user->getSkin();
		$rows = '';
		foreach( $urls as $url ) {
			$rows .= Xml::tags( 'tr', array(),
				Xml::tags( 'td', array(), Xml::element( 'a', array( 'href' => $url ), $url ) ) .
				Xml::tags( 'td', array(), $sk->link( $delTitle, wfMsg( 'openid-urls-delete' ), array(), array( 'url' => $url ) ) )
			) . "\n";
		}
		$info = Xml::tags( 'table', array( 'class' => 'wikitable' ),
			Xml::tags( 'tr', array(), Xml::element( 'th', array(), wfMsg( 'openid-urls-url' ) ) . Xml::element( 'th', array(), wfMsg( 'openid-urls-action' ) ) ) . "\n" .
			$rows
		);
		$info .= $user->getSkin()->link( SpecialPage::getTitleFor( 'OpenIDConvert' ), wfMsgHtml( 'openid-add-url' ) );
		return $info;
	}
	

	public static function onGetPreferences( $user, &$preferences ) {
		global $wgOpenIDShowUrlOnUserPage, $wgAllowRealName;

		wfLoadExtensionMessages( 'OpenID' );

		if ( $wgOpenIDShowUrlOnUserPage == 'user' ) {
			$preferences['openid-hide'] =
				array(
					'type' => 'toggle',
					'section' => 'openid',
					'label-message' => 'openid-pref-hide',
				);
		}

		$update = array();
		$update[wfMsg( 'openidnickname' )] = 'nickname';
		$update[wfMsg( 'openidemail' )] = 'email';
		if ( $wgAllowRealName )
			$update[wfMsg( 'openidfullname' )] = 'fullname';
		$update[wfMsg( 'openidlanguage' )] = 'language';
		$update[wfMsg( 'openidtimezone' )] = 'timezone';

		$preferences['openid-update-on-login'] =
			array(
				'type' => 'multiselect',
				'section' => 'openid',
				'label-message' => 'openid-pref-update-userinfo-on-login',
				'options' => $update,
				'prefix' => 'openid-update-on-login-',
			);

		$preferences['openid-urls'] =
				array(
					'type' => 'info',
					'label-message' => 'openid-urls-desc',
					'default' => self::getInfoTable( $user ),
					'raw' => true,
					'section' => 'openid',
				);
		

		return true;
	}


	# list of preferences used by extension
	private static $oidPrefs = array( 'hide' );
	private static $oidUpdateOnLogin = array( 'nickname', 'email', 'fullname',
		'language', 'timezone' );

	private static function getToggles() {
		$toggles = self::$oidPrefs;
		foreach( self::$oidUpdateOnLogin as $pref ) {
			$toggles[] = 'update-on-login-' . $pref;
		}
		return $toggles;
	}

	public static function onInitPreferencesForm( $prefs, $request ) {
		foreach ( self::getToggles() as $oidPref ) {
			$prefs->mToggles['openid-' . $oidPref]
				= $request->getCheck( "wpOpOpenID-" . $oidPref ) ? 1 : 0;
		}

		return true;
	}

	public static function onRenderPreferencesForm( $prefs, $out ) {
		global $wgUser;

		wfLoadExtensionMessages( 'OpenID' );

		$out->addHeadItem( 'openidwikitablestyle', self::wikitableStyle() );

		$out->addHTML( "\n<fieldset>\n<legend>" . wfMsgHtml( 'prefs-openid' ) . "</legend>\n<table>\n" );

		#$out->addWikiText( wfMsg( 'openid-prefstext' ) );

		foreach ( self::$oidPrefs as $oidPref ) {
			$name = 'wpOpOpenID-' . $oidPref;
			$out->addHTML(
				Xml::tags( 'tr', array(),
					Xml::tags( 'td', array( 'style' => 'width: 20%;' ), '' ) .
					Xml::tags( 'td', array(),
						Xml::tags( 'div', array( 'class' => 'toggle' ),
							Xml::check( $name, $prefs->mToggles['openid-' . $oidPref] ) .
							Xml::tags( 'span', array( 'class' => 'toggletext' ),
								Xml::label( wfMsg( 'openid-pref-' . $oidPref ), $name )
							)
						)
					)
				)
			);
		}

		$out->addHTML( Xml::openElement( 'tr' ) . Xml::element( 'td', array(),
			wfMsg( 'openid-pref-update-userinfo-on-login' ) ) . Xml::openElement( 'td' ) );

		$first = true;
		foreach ( self::$oidUpdateOnLogin as $oidPref ) {
			if ( $first ) {
				$first = false;
			} else {
				#$out->addHTML( '<br />' );
			}
			$name = 'wpOpOpenID-update-on-login-' . $oidPref;
			$out->addHTML(
				Xml::tags( 'div', array( 'class' => 'toggle' ),
					Xml::check( $name, $prefs->mToggles['openid-update-on-login-' . $oidPref] ) .
					Xml::tags( 'span', array( 'class' => 'toggletext' ),
						Xml::label( wfMsg( 'openid' . $oidPref ), $name )
					)
				)
			);
		}

		$out->addHTML(
			"</td></tr>\n<tr><td>" . wfMsgHtml( 'openid-urls-desc' ) .
			"</td><td>" . self::getInfoTable( $wgUser ) .
			"</td></tr></table></fieldset>\n\n"
		);

		return true;
	}

	public static function onSavePreferences( $prefs, $user, &$message, $old ) {
		foreach ( self::getToggles() as $oidPref ) {
			$user->setOption( 'openid-' . $oidPref, $prefs->mToggles['openid-' . $oidPref] );
			wfDebugLog( 'OpenID', 'Setting user preferences: ' . print_r( $user, true ) );
		}

		$user->saveSettings();

		return true;
	}

	public static function onResetPreferences( $prefs, $user ) {
		foreach ( self::getToggles() as $oidPref ) {
			$prefs->mToggles['openid-' . $oidPref] = $user->getOption( 'openid-' . $oidPref );
		}

		return true;
	}

	public static function onLoadExtensionSchemaUpdates() {
		global $wgDBtype, $wgUpdates, $wgExtNewTables;

		$base = dirname( __FILE__ );

		if ( $wgDBtype == 'mysql' ) {
			$wgExtNewTables[] = array( 'user_openid', "$base/openid_table.sql" );
			$wgUpdates['mysql'][] = array( array( __CLASS__, 'makeUoiUserNotUnique' ) );
		} else if ( $wgDBtype == 'postgres' ) {
			$wgExtNewTables[] = array( 'user_openid', "$base/openid_table.pg.sql" );
			# This doesn't work since MediaWiki doesn't use $wgUpdates when
			# updating a PostgreSQL database
			#$wgUpdates['postgres'][] = array( array( __CLASS__, 'makeUoiUserNotUnique' ) );
		}

		return true;
	}

	public static function makeUoiUserNotUnique() {
		$db = wfGetDB( DB_MASTER );
		if ( !$db->tableExists( 'user_openid' ) )
			return;

		$info = $db->fieldInfo( 'user_openid', 'uoi_user' );
		if ( !$info->isMultipleKey() ) {
			wfOut( "Making uoi_user filed not unique..." );
			$db->sourceFile( dirname( __FILE__ ) . '/patch-uoi_user-not-unique.sql' );
			wfOut( " done.\n" );
		} else {
			wfOut( "...uoi_user field is already not unique.\n" );
		}
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
	
	private static function wikitableStyle() {
		return <<<EOS
<style type='text/css'>
table.wikitable {
    margin: 1em 1em 1em 0;
    background: #f9f9f9;
    border: 1px #aaa solid;
    border-collapse: collapse;
}
.wikitable th, .wikitable td {
    border: 1px #aaa solid;
    padding: 0.2em;
}
.wikitable th {
    background: #f2f2f2;
    text-align: center;
}
.wikitable caption {
    font-weight: bold;
}
</style>

EOS;
	}
}
