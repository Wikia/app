<?php

/**
 * Redirect classes to hijack the core UserLogin and CreateAccount facilities, because
 * they're so badly written as to be impossible to extend
 */
class SpecialOpenIDCreateAccount extends SpecialRedirectToSpecial {
	function __construct() {
		parent::__construct( 'SpecialOpenIDCreateAccount', 'OpenIDLogin' );
	}
}
class SpecialOpenIDUserLogin extends SpecialRedirectToSpecial {
	function __construct() {
		parent::__construct( 'SpecialOpenIDUserLogin', 'OpenIDLogin', false, array( 'returnto', 'returntoquery' ) );
	}
}

class OpenIDHooks {
	public static function onSpecialPage_initList( &$list ) {
		global $wgOpenIDOnly, $wgOpenIDClientOnly;

		if ( $wgOpenIDOnly ) {
			$list['Userlogin'] = 'SpecialOpenIDLogin';

			# as Special:CreateAccount is an alias for Special:UserLogin/signup
			# we show our own OpenID page here, too
			$list['CreateAccount'] = 'SpecialOpenIDLogin';
		}

		# Special pages are added at global scope;
		# remove server-related ones if client-only flag is set
		$addList = array( 'Login', 'Convert', 'Dashboard' );
		if ( !$wgOpenIDClientOnly ) {
			$addList[] = 'Server';
			$addList[] = 'XRDS';
		}

		foreach ( $addList as $sp ) {
			$list['OpenID' . $sp] = 'SpecialOpenID' . $sp;
			SpecialPageFactory::setGroup( 'OpenID' . $sp, 'openid' );
		}

		return true;
	}

	# Hook is called whenever an article is being viewed
	public static function onArticleViewHeader( &$article, &$outputDone, &$pcache ) {
		global $wgOut, $wgOpenIDClientOnly, $wgOpenIDAllowServingOpenIDUserAccounts;

		$nt = $article->getTitle();

		// If the page being viewed is a user page,
		// generate the openid.server META tag and output
		// the X-XRDS-Location.  See the OpenIDXRDS
		// special page for the XRDS output / generation
		// logic.

		if ( $nt && $nt->getNamespace() == NS_USER && strpos( $nt->getText(), '/' ) === false ) {
			$user = User::newFromName( $nt->getText() );
			if ( $user && $user->getID() != 0 ) {
				$openid = SpecialOpenID::getUserOpenIDInformation( $user );
				if ( count( $openid ) && strlen( $openid[0]->uoi_openid ) != 0 ) {
					global $wgOpenIDShowUrlOnUserPage;

					if ( $wgOpenIDShowUrlOnUserPage == 'always' ||
						( $wgOpenIDShowUrlOnUserPage == 'user' && !$user->getOption( 'openid-hide' ) ) )
					{
						global $wgOpenIDLoginLogoUrl;

						$url = SpecialOpenID::OpenIDToUrl( $openid[0]->uoi_openid );
						$disp = htmlspecialchars( $openid[0]->uoi_openid );
						$wgOut->setSubtitle( "<span class='subpages'>" .
											"<img src='$wgOpenIDLoginLogoUrl' alt='OpenID' />" .
											"<a href='$url'>$disp</a>" .
											"</span>" );
					}
				}

				# Add OpenID data if its allowed
				if ( !$wgOpenIDClientOnly && !( count( $openid ) && ( strlen( $openid[0]->uoi_openid ) != 0 ) && !$wgOpenIDAllowServingOpenIDUserAccounts ) ) {
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

		return true;
	}

	public static function onPersonalUrls( &$personal_urls, &$title ) {
		global $wgHideOpenIDLoginLink, $wgUser, $wgLang, $wgOpenIDOnly;

		if ( !$wgHideOpenIDLoginLink && $wgUser->getID() == 0 ) {
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
		global $wgLang;
		$openid_urls_registration = SpecialOpenID::getUserOpenIDInformation( $user );
		$delTitle = SpecialPage::getTitleFor( 'OpenIDConvert', 'Delete' );
		$sk = $user->getSkin();
		$rows = '';
		foreach ( $openid_urls_registration as $url_reg ) {
		
			if ( !empty( $url_reg->uoi_user_registration ) ) { $registrationTime = wfMsgExt(
				'openid-urls-registration-date-time', 
				'parsemag',
				$wgLang->timeanddate( $url_reg->uoi_user_registration, true ),
				$wgLang->date( $url_reg->uoi_user_registration, true ),
				$wgLang->time( $url_reg->uoi_user_registration, true ) 
				);
			} else {
				$registrationTime = '';
			}

			$rows .= Xml::tags( 'tr', array(),
				Xml::tags( 'td',
					array(),
					Xml::element( 'a', array( 'href' => $url_reg->uoi_openid ), $url_reg->uoi_openid )
				) .
				Xml::tags( 'td',
					array(),
					$registrationTime
				) .
				Xml::tags( 'td',
					array(),
					$sk->link( $delTitle, wfMsgHtml( 'openid-urls-delete' ),
						array(),
						array( 'url' => $url_reg->uoi_openid ) 
					) 
				)
			) . "\n";
		}
		$info = Xml::tags( 'table', array( 'class' => 'wikitable' ),
			Xml::tags( 'tr', array(),
				Xml::element( 'th',
					array(), 
					wfMsg( 'openid-urls-url' ) ) .
				Xml::element( 'th',
					array(), 
					wfMsg( 'openid-urls-registration' ) ) .
				Xml::element( 'th', 
					array(), 
					wfMsg( 'openid-urls-action' ) )
				) . "\n" .
			$rows
		);
		$info .= $sk->link( SpecialPage::getTitleFor( 'OpenIDConvert' ), wfMsgHtml( 'openid-add-url' ) );
		return $info;
	}

	public static function onGetPreferences( $user, &$preferences ) {
		global $wgOpenIDShowUrlOnUserPage, $wgHiddenPrefs;
		global $wgAuth, $wgUser, $wgLang;

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
		if ( !in_array( 'realname', $wgHiddenPrefs ) )
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

       		if ( $wgAuth->allowPasswordChange() ) {

			$resetlink = $wgUser->getSkin()->link( SpecialPage::getTitleFor( 'PasswordReset' ),
				wfMsgHtml( 'passwordreset' ), array(),
				array( 'returnto' => SpecialPage::getTitleFor( 'Preferences' ) ) );

			if ( empty( $wgUser->mPassword ) && empty( $wgUser->mNewpassword ) ) {
 				$preferences['password'] = array(
					'type' => 'info',
					'raw' => true,
					'default' => $resetlink,
					'label-message' => 'yourpassword',
					'section' => 'personal/info',
				);
			} else {
				$preferences['resetpassword'] = array(
					'type' => 'info',
					'raw' => true,
					'default' => $resetlink,
					'label-message' => null,
					'section' => 'personal/info',
				);
			}

			global $wgCookieExpiration;
			if ( $wgCookieExpiration > 0 ) {
				unset( $preferences['rememberpassword'] );
				$preferences['rememberpassword'] = array(
					'type' => 'toggle',
					'label' => wfMsgExt(
						'tog-rememberpassword',
						array( 'parsemag' ),
						$wgLang->formatNum( ceil( $wgCookieExpiration / ( 3600 * 24 ) ) )
						),
					'section' => 'personal/info',
				);
			}

		}

		return true;
	}

	public static function onDeleteAccount( &$userObj ) {
		global $wgOut;

		if ( is_object( $userObj ) ) {

			$username = $userObj->getName();
			$userID = $userObj->getID();

  			$dbw = wfGetDB( DB_MASTER );

			$dbw->delete( 'user_openid', array( 'uoi_user' => $userID ) );
			$wgOut->addHTML( "OpenID " . wfMsgExt( 'usermerge-userdeleted', array( 'escape' ), $username, $userID ) );

			wfDebug( "OpenID: deleted OpenID user $username ($userID)\n" );

                }

		return true;

	}

	public static function onMergeAccountFromTo( &$fromUserObj, &$toUserObj ) {
		global $wgOut, $wgOpenIDMergeOnAccountMerge;

		if ( is_object( $fromUserObj ) && is_object( $toUserObj ) ) {

			$fromUsername = $fromUserObj->getName();
			$fromUserID = $fromUserObj->getID();
			$toUsername = $toUserObj->getName();
			$toUserID = $toUserObj->getID();

                  	if ( $wgOpenIDMergeOnAccountMerge ) {

				$dbw = wfGetDB( DB_MASTER );

				$dbw->update( 'user_openid', array( 'uoi_user' => $toUserID ), array( 'uoi_user' => $fromUserID ) );
				$wgOut->addHTML( "OpenID " . wfMsgExt( 'usermerge-updating', array( 'escape' ), 'user_openid', $fromUsername, $toUsername ) . "<br />\n" );

				wfDebug( "OpenID: transferred OpenID(s) of $fromUsername ($fromUserID) => $toUsername ($toUserID)\n" );

			} else {

				$wgOut->addHTML( wfMsgHtml( 'openid-openids-were-not-merged' ) . "<br />\n" );
				wfDebug( "OpenID: OpenID(s) were not merged for merged users $fromUsername ($fromUserID) => $toUsername ($toUserID)\n" );

			}

		}

		return true;

	}

	public static function onLoadExtensionSchemaUpdates( $updater = null ) {
		if ( $updater === null ) {
			// <= 1.16 support - but OpenID does not work with such old MW versions
			global $wgExtNewTables, $wgExtNewFields;
			$wgExtNewTables[] = array(
				'user_openid',
				dirname( __FILE__ ) . '/patches/openid_table.sql'
			);

			# when updating an older OpenID version
			# make the index non unique (remove unique index uoi_user, add new index user_openid_user)
			$db = wfGetDB( DB_MASTER );
			$info = $db->fieldInfo( 'user_openid', 'uoi_user' );
			if ( $info && !$info->isMultipleKey() ) {
				echo( "Making uoi_user field non UNIQUE...\n" );
				$db->sourceFile( dirname( __FILE__ ) . '/patches/patch-uoi_user-not-unique.sql' );
				echo( " done.\n" );
			} else {
				echo( "...uoi_user field is already non UNIQUE.\n" );
			}
			
			# uoi_user_registration field was added in OpenID version 0.937
			$wgExtNewFields[] = array(
				'user_openid',
				'uoi_user_registration',
				dirname( __FILE__ ) . '/patches/patch-add_uoi_user_registration.sql'
			);
		} else {
			// >= 1.17 support
			$updater->addExtensionTable( 'user_openid',
				dirname( __FILE__ ) . '/patches/openid_table.sql' );

			# when updating an older OpenID version
			# make the index non unique (remove unique index uoi_user, add new index user_openid_user)
			$db = $updater->getDB();
			$info = $db->fieldInfo( 'user_openid', 'uoi_user' );
			if ( $info && !$info->isMultipleKey() ) {
				$updater->addExtensionUpdate( array( 'dropIndex', 'user_openid', 'uoi_user',
					dirname( __FILE__ ) . '/patches/patch-drop_non_multiple_key_index_uoi_user.sql', true ) );
				$updater->addExtensionIndex( 'user_openid', 'user_openid_user',
					dirname( __FILE__ ) . '/patches/patch-add_multiple_key_index_user_openid_user.sql' );
			}

			# uoi_user_registration field was added in OpenID version 0.937
			$updater->addExtensionField( 'user_openid', 'uoi_user_registration',
				dirname( __FILE__ ) . '/patches/patch-add_uoi_user_registration.sql' );
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
