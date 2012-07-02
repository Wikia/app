<?php
/**
 * SpecialOpenIDLogin.body.php -- Consumer side of OpenID site
 * Copyright 2006,2007 Internet Brands (http://www.internetbrands.com/)
 * Copyright 2007,2008 Evan Prodromou <evan@prodromou.name>
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @file
 * @author Evan Prodromou <evan@prodromou.name>
 * @ingroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) )
  exit( 1 );

require_once( "Auth/Yadis/XRI.php" );

class SpecialOpenIDLogin extends SpecialOpenID {

	function __construct() {
		parent::__construct( 'OpenIDLogin' );
	}

	/**
	 * Entry point
	 *
	 * @param $par String or null
	 */
	function execute( $par ) {
		global $wgRequest, $wgUser, $wgOut, $wgOpenIDConsumerForce;

		$this->setHeaders();

		if ( $wgUser->getID() != 0 ) {
			$this->alreadyLoggedIn();
			return;
		}

		$this->outputHeader();

		switch ( $par ) {
		case 'ChooseName':
			$this->chooseName();
			break;

		case 'Finish': # Returning from a server
			$this->finish();
			break;

		default: # Main entry point
			if ( $wgRequest->getText( 'returnto' ) ) {
				$this->setReturnTo( $wgRequest->getText( 'returnto' ), $wgRequest->getVal( 'returntoquery' ) );
			}

			$openid_url = $wgRequest->getText( 'openid_url' );

			if ( !is_null( $openid_url ) && strlen( $openid_url ) > 0 ) {
				$this->login( $openid_url, $this->getTitle( 'Finish' ) );
		 	} elseif ( !is_null ( $wgOpenIDConsumerForce ) ) {
		 		// if a forced OpenID provider specified, bypass the form
		 		$this->login( $wgOpenIDConsumerForce, $this->getTitle( 'Finish' ) );
			} else {
				$this->loginForm();
			}
		}
	}

	/**
	 * Displays an info message saying that the user is already logged-in
	 */
	function alreadyLoggedIn() {
		global $wgUser, $wgOut;

		$wgOut->setPageTitle( wfMsg( 'openidalreadyloggedin' ) );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->addWikiMsg( 'openidalreadyloggedintext', $wgUser->getName() );
		list( $returnto, $returntoquery ) = $this->returnTo();
		$wgOut->returnToMain( null, $returnto, $returntoquery );
	}

	/**
	 * Displays the main login form
	 */
	function loginForm() {
		global $wgOut, $wgOpenIDShowProviderIcons, $wgOpenIDOnly;

		$wgOut->addModules( $wgOpenIDShowProviderIcons ? 'ext.openid.icons' : 'ext.openid.plain' );

		$formsHTML = '';

		$largeButtonsHTML = '<div id="openid_large_providers">';
		foreach ( OpenIDProvider::getLargeProviders() as $provider ) {
			$largeButtonsHTML .= $provider->getLargeButtonHTML();
			$formsHTML .= $provider->getLoginFormHTML();
		}
		$largeButtonsHTML .= '</div>';

		$smallButtonsHTML = '';
		if ( $wgOpenIDShowProviderIcons ) {
			$smallButtonsHTML .= '<div id="openid_small_providers_icons">';
			foreach ( OpenIDProvider::getSmallProviders() as $provider ) {
				$smallButtonsHTML .= $provider->getSmallButtonHTML();
				$formsHTML .= $provider->getLoginFormHTML();
			}
			$smallButtonsHTML .= '</div>';
		} else {
			$smallButtonsHTML .= '<div id="openid_small_providers_links">';
			$smallButtonsHTML .= '<ul class="openid_small_providers_block">';
			$small = OpenIDProvider::getSmallProviders();

			$i = 0;
			$break = true;
			foreach ( $small as $provider ) {
				if ( $break && $i > count( $small ) / 2 ) {
					$smallButtonsHTML .= '</ul><ul class="openid_small_providers_block">';
					$break = false;
				}

				$smallButtonsHTML .= '<li>' . $provider->getSmallButtonHTML() . '</li>';

				$formsHTML .= $provider->getLoginFormHTML();
				$i++;
			}
			$smallButtonsHTML .= '</ul>';
			$smallButtonsHTML .= '</div>';
		}

		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'id' => 'openid_form', 'action' => $this->getTitle()->getLocalUrl(), 'method' => 'post', 'onsubmit' => 'openid.update()' ) ) .
			Xml::fieldset( wfMsg( 'openid-login-or-create-account' ) ) .
			$largeButtonsHTML .
			'<div id="openid_input_area">' .
			$formsHTML .
			'</div>' .
			$smallButtonsHTML .
			Xml::closeElement( 'fieldset' ) . Xml::closeElement( 'form' )
		);
		$wgOut->addWikiMsg( 'openidlogininstructions' );
		if ( $wgOpenIDOnly ) {
			$wgOut->addWikiMsg( 'openidlogininstructions-openidloginonly' );
		} else {
			$wgOut->addWikiMsg( 'openidlogininstructions-passwordloginallowed' );
		}
	}

	/**
	 * Displays a form to let the user choose an account to attach with the
	 * given OpenID
	 *
	 * @param $openid String: OpenID url
	 * @param $sreg Array: options get from OpenID
	 * @param $messagekey String or null: message name to display at the top
	 */
	function chooseNameForm( $openid, $sreg, $ax, $messagekey = null ) {
		global $wgOut, $wgOpenIDAllowExistingAccountSelection, $wgHiddenPrefs, $wgUser;
		global $wgOpenIDProposeUsernameFromSREG, $wgOpenIDAllowAutomaticUsername, $wgOpenIDAllowNewAccountname;

		if ( $messagekey ) {
			$wgOut->addWikiMsg( $messagekey );
		}
		$wgOut->addWikiMsg( 'openidchooseinstructions' );

		$wgOut->addHTML(
			Xml::openElement( 'form',
				array( 'action' => $this->getTitle( 'ChooseName' )->getLocalUrl(), 'method' => 'POST' ) ) . "\n" .
			Xml::fieldset( wfMsg( 'openidchooselegend' ), false, array( 'id' => 'mw-openid-choosename' ) ) . "\n" .
			Xml::openElement( 'table' )
		);
		$def = false;

		if ( $wgOpenIDAllowExistingAccountSelection ) {
			# Let them attach it to an existing user

			# Grab the UserName in the cookie if it exists

			global $wgCookiePrefix;
			$name = '';
			if ( isset( $_COOKIE["{$wgCookiePrefix}UserName"] ) ) {
				$name = trim( $_COOKIE["{$wgCookiePrefix}UserName"] );
			}

			# show OpenID Attributes
			$oidAttributesToAccept = array( 'fullname', 'nickname', 'email', 'language' );
			$oidAttributes = array();

			foreach ( $oidAttributesToAccept as $oidAttr ) {
				if ( $oidAttr == 'fullname' && in_array( 'realname', $wgHiddenPrefs ) ) {
					continue;
				}

				if ( array_key_exists( $oidAttr, $sreg ) ) {
					$checkName = 'wpUpdateUserInfo' . $oidAttr;
					$oidAttributes[] = Xml::tags( 'li', array(),
						Xml::check( $checkName, false, array( 'id' => $checkName ) ) .
						Xml::tags( 'label', array( 'for' => $checkName ),
							wfMsgHtml( "openid$oidAttr" ) . wfMsgExt( 'colon-separator', array( 'escapenoentities' ) ) .
								Xml::tags( 'i', array(), $sreg[$oidAttr] )
						)
					);
				}
			}

			$oidAttributesUpdate = '';
			if ( count( $oidAttributes ) > 0 ) {
				$oidAttributesUpdate = "<br />\n" .
					wfMsgHtml( 'openidupdateuserinfo' ) . "\n" .
					Xml::tags( 'ul', array(), implode( "\n", $oidAttributes ) );
			}

			$wgOut->addHTML(
				Xml::openElement( 'tr' ) .
				Xml::tags( 'td', array( 'class' => 'mw-label' ),
					Xml::radio( 'wpNameChoice', 'existing', !$def, array( 'id' => 'wpNameChoiceExisting' ) )
				) . "\n" .
				Xml::tags( 'td', array( 'class' => 'mw-input' ),
					Xml::label( wfMsg( 'openidchooseexisting' ), 'wpNameChoiceExisting' ) . "<br />\n" .
					wfMsgHtml( 'openidchooseusername' ) . "\n" .
					Xml::input( 'wpExistingName', 16, $name, array( 'id' => 'wpExistingName' ) ) . "\n" .
					wfMsgHtml( 'openidchoosepassword' ) . "\n" .
					Xml::password( 'wpExistingPassword' ) . "\n" .
					$oidAttributesUpdate . "\n"
				) . "\n" .
				Xml::closeElement( 'tr' ) . "\n"
			);
			$def = true;
		} // $wgOpenIDAllowExistingAccountSelection

		# These are only available if all visitors are allowed to create accounts
		if ( $wgUser->isAllowed( 'createaccount' ) && !$wgUser->isBlockedFromCreateAccount() ) {

		if ( $wgOpenIDProposeUsernameFromSREG ) {

			# These options won't exist if we can't get them.
			if ( array_key_exists( 'nickname', $sreg ) && $this->userNameOK( $sreg['nickname'] ) ) {
				$wgOut->addHTML(
					Xml::openElement( 'tr' ) .
					Xml::tags( 'td', array( 'class' => 'mw-label' ),
						Xml::radio( 'wpNameChoice', 'nick', !$def, array( 'id' => 'wpNameChoiceNick' ) )
					) .
					Xml::tags( 'td', array( 'class' => 'mw-input' ),
						Xml::label( wfMsg( 'openidchoosenick', $sreg['nickname'] ), 'wpNameChoiceNick' )
					) .
					Xml::closeElement( 'tr' ) . "\n"
				);
			}

			# These options won't exist if we can't get them.
			$fullname = null;
			if ( array_key_exists( 'fullname', $sreg ) ) {
				$fullname = $sreg['fullname'];
			}

			if ( array_key_exists( 'http://axschema.org/namePerson/first', $ax ) || array_key_exists( 'http://axschema.org/namePerson/last', $ax ) ) {
				$fullname = $ax['http://axschema.org/namePerson/first'][0] . " " . $ax['http://axschema.org/namePerson/last'][0];
			}

			if ( $fullname && $this->userNameOK( $fullname ) ) {
				$wgOut->addHTML(
					Xml::openElement( 'tr' ) .
					Xml::tags( 'td', array( 'class' => 'mw-label' ),
						Xml::radio( 'wpNameChoice', 'full', !$def, array( 'id' => 'wpNameChoiceFull' ) )
					) .
					Xml::tags( 'td', array( 'class' => 'mw-input' ),
						Xml::label( wfMsg( 'openidchoosefull', $fullname ), 'wpNameChoiceFull' )
					) .
					Xml::closeElement( 'tr' ) . "\n"
				);
				$def = true;
			}

			$idname = $this->toUserName( $openid );
			if ( $idname && $this->userNameOK( $idname ) ) {
				$wgOut->addHTML(
					Xml::openElement( 'tr' ) .
					Xml::tags( 'td', array( 'class' => 'mw-label' ),
						Xml::radio( 'wpNameChoice', 'url', !$def, array( 'id' => 'wpNameChoiceUrl' ) )
					) .
					Xml::tags( 'td', array( 'class' => 'mw-input' ),
						Xml::label( wfMsg( 'openidchooseurl', $idname ), 'wpNameChoiceUrl' )
					) .
					Xml::closeElement( 'tr' ) . "\n"
				);
				$def = true;
			}
		} // if $wgOpenIDProposeUsernameFromSREG

		if ( $wgOpenIDAllowAutomaticUsername ) {
			$wgOut->addHTML(
				Xml::openElement( 'tr' ) .
				Xml::tags( 'td', array( 'class' => 'mw-label' ),
					Xml::radio( 'wpNameChoice', 'auto', !$def, array( 'id' => 'wpNameChoiceAuto' ) )
				) .
				Xml::tags( 'td', array( 'class' => 'mw-input' ),
					Xml::label( wfMsg( 'openidchooseauto', $this->automaticName( $sreg ) ), 'wpNameChoiceAuto' )
				) .
					Xml::closeElement( 'tr' ) . "\n"
				);
		}

		if ( $wgOpenIDAllowNewAccountname ) {
			$wgOut->addHTML(

			Xml::openElement( 'tr' ) .
			Xml::tags( 'td', array( 'class' => 'mw-label' ),
				Xml::radio( 'wpNameChoice', 'manual', !$def, array( 'id' => 'wpNameChoiceManual' ) )
			) .
			Xml::tags( 'td', array( 'class' => 'mw-input' ),
				Xml::label( wfMsg( 'openidchoosemanual' ), 'wpNameChoiceManual' ) . '&#160;' .
				Xml::input( 'wpNameValue', 16, false, array( 'id' => 'wpNameValue' ) )
			) .
			Xml::closeElement( 'tr' ) . "\n"
			);
		}

		} // These are only available if all visitors are allowed to create accounts

		# These are always available
                $wgOut->addHTML(

			Xml::openElement( 'tr' ) . "\n" .
			Xml::element( 'td', array(), '' ) . "\n" .
			Xml::tags( 'td', array( 'class' => 'mw-submit' ),
				Xml::submitButton( wfMsg( 'userlogin' ), array( 'name' => 'wpOK' ) ) .
				Xml::submitButton( wfMsg( 'cancel' ), array( 'name' => 'wpCancel' ) )
			) . "\n" .
			Xml::closeElement( 'tr' ) . "\n" .

			Xml::closeElement( 'table' ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' )
		);
	}

	/**
	 * Handle "Choose name" form submission
	 */
	function chooseName() {
		global $wgRequest, $wgUser, $wgOut;

		list( $openid, $sreg, $ax ) = $this->fetchValues();
		if ( is_null( $openid ) ) {
			wfDebug( "OpenID: aborting in ChooseName because identity_url is missing\n" );
			$this->clearValues();
			# No messing around, here
			$wgOut->showErrorPage( 'openiderror', 'openiderrortext' );
			return;
		}

		if ( $wgRequest->getCheck( 'wpCancel' ) ) {
			$this->clearValues();
			$wgOut->showErrorPage( 'openidcancel', 'openidcanceltext' );
			return;
		}

		$choice = $wgRequest->getText( 'wpNameChoice' );
		$nameValue = $wgRequest->getText( 'wpNameValue' );

		if ( $choice == 'existing' ) {
			$user = $this->attachUser( $openid, $sreg,
				$wgRequest->getText( 'wpExistingName' ),
				$wgRequest->getText( 'wpExistingPassword' )
			);

			if ( !$user ) {
				$this->chooseNameForm( $openid, $sreg, $ax, 'wrongpassword' );
				return;
			}

			$force = array();
			foreach ( array( 'fullname', 'nickname', 'email', 'language' ) as $option ) {
				if ( $wgRequest->getCheck( 'wpUpdateUserInfo' . $option ) ) {
					$force[] = $option;
				}
			}

			$this->updateUser( $user, $sreg, $ax );

		} else {
			$name = $this->getUserName( $openid, $sreg, $ax, $choice, $nameValue );

			if ( !$name || !$this->userNameOK( $name ) ) {
				wfDebug( "OpenID: Name not OK: '$name'\n" );
				$this->chooseNameForm( $openid, $sreg, $ax );
				return;
			}

			$user = $this->createUser( $openid, $sreg, $ax, $name );
		}

		if ( is_null( $user ) ) {
			wfDebug( "OpenID: aborting in ChooseName because we could not create user object\n" );
			$this->clearValues();
			$wgOut->showErrorPage( 'openiderror', 'openiderrortext' );
			return;
		}

		$wgUser = $user;
		$this->clearValues();
		$this->displaySuccessLogin( $openid );
	}

	/**
	 * Called when returning from the authentication server
	 * Find the user with the given openid, if any or displays the "Choose name"
	 * form
	 */
	function finish() {
		global $wgOut, $wgUser, $wgOpenIDUseEmailAsNickname;

		wfSuppressWarnings();
		$consumer = $this->getConsumer();
		$response = $consumer->complete( $this->scriptUrl( 'Finish' ) );
		wfRestoreWarnings();

		if ( is_null( $response ) ) {
			wfDebug( "OpenID: aborting in auth because no response was recieved\n" );
			$wgOut->showErrorPage( 'openiderror', 'openiderrortext' );
			return;
		}

		switch ( $response->status ) {
		case Auth_OpenID_CANCEL:
			// This means the authentication was cancelled.
			$wgOut->showErrorPage( 'openidcancel', 'openidcanceltext' );
			break;
		case Auth_OpenID_FAILURE:
			wfDebug( "OpenID: error message '" . $response->message . "'\n" );
			$wgOut->showErrorPage( 'openidfailure', 'openidfailuretext',
				array( ( $response->message ) ? $response->message : '' ) );
			break;
		case Auth_OpenID_SUCCESS:
			// This means the authentication succeeded.
			wfSuppressWarnings();
			$openid = $response->identity_url;

			if ( !$this->canLogin( $openid ) ) {
				$wgOut->showErrorPage( 'openidpermission', 'openidpermissiontext' );
				return;
			}

			$sreg_resp = Auth_OpenID_SRegResponse::fromSuccessResponse( $response );
			$sreg = $sreg_resp->contents();
			$ax_resp = Auth_OpenID_AX_FetchResponse::fromSuccessResponse( $response );
			$ax = $ax_resp->data;
			wfRestoreWarnings();

			if ( is_null( $openid ) ) {
				wfDebug( "OpenID: aborting in auth success because identity URL is missing\n" );
				$wgOut->showErrorPage( 'openiderror', 'openiderrortext' );
				return;
			}

			$user = self::getUserFromUrl( $openid );

			if ( $user instanceof User ) {
				$this->updateUser( $user, $sreg, $ax ); # update from server
				$wgUser = $user;
				$this->displaySuccessLogin( $openid );
			} else {
				// if we are hardcoding nickname, and a valid e-mail address was returned, create a user with this name
				if ( $wgOpenIDUseEmailAsNickname ) {
					$name = $this->getNameFromEmail( $openid, $sreg, $ax );
					if ( !empty( $name ) && $this->userNameOk( $name ) ) {
						$wgUser = $this->createUser( $openid, $sreg, $ax, $name );
						$this->displaySuccessLogin( $openid );
						return;
					}
				}

				$this->saveValues( $openid, $sreg, $ax );
				$this->chooseNameForm( $openid, $sreg, $ax );
				return;
			}
		}
	}

	/**
	 * Update some user's settings with value get from OpenID
	 *
	 * @param $user User object
	 * @param $sreg Array of options get from OpenID
	 * @param $force forces update regardless of user preferences
	 */
	function updateUser( $user, $sreg, $ax, $force = false ) {
		global $wgHiddenPrefs, $wgEmailAuthentication, $wgOpenIDTrustEmailAddress;

		// Nick name
		if ( $this->updateOption( 'nickname', $user, $force ) ) {
			if ( array_key_exists( 'nickname', $sreg ) && $sreg['nickname'] != $user->getOption( 'nickname' ) ) {
				$user->setOption( 'nickname', $sreg['nickname'] );
			}
		}

		// E-mail
		if ( $this->updateOption( 'email', $user, $force ) ) {
			// first check SREG, then AX; if both, AX takes higher priority
			if ( array_key_exists( 'email', $sreg ) ) {
				$email = $sreg['email'];
			}
			if ( array_key_exists ( 'http://axschema.org/contact/email', $ax ) ) {
				$email = $ax['http://axschema.org/contact/email'][0];
			}
			if ( $email ) {
				// If email changed, then email a confirmation mail
				if ( $email != $user->getEmail() ) {
					$user->setEmail( $email );
					if ( $wgOpenIDTrustEmailAddress ) {
						$user->confirmEmail();
					} else {
						$user->invalidateEmail();
						if ( $wgEmailAuthentication && $email != '' ) {
							$result = $user->sendConfirmationMail();
							if ( WikiError::isError( $result ) ) {
								$wgOut->addWikiMsg( 'mailerror', $result->getMessage() );
							}
						}
					}
				}
			}
		}

		// Full name
		if ( !in_array( 'realname', $wgHiddenPrefs ) && ( $this->updateOption( 'fullname', $user, $force ) ) ) {
			if ( array_key_exists( 'fullname', $sreg ) ) {
				$user->setRealName( $sreg['fullname'] );
			}

			if ( array_key_exists( 'http://axschema.org/namePerson/first', $ax ) || array_key_exists( 'http://axschema.org/namePerson/last', $ax ) ) {
				$user->setRealName( $ax['http://axschema.org/namePerson/first'][0] . " " . $ax['http://axschema.org/namePerson/last'][0] );
			}
		}

		// Language
		if ( $this->updateOption( 'language', $user, $force ) ) {
			if ( array_key_exists( 'language', $sreg ) ) {
				# FIXME: check and make sure the language exists
				$user->setOption( 'language', $sreg['language'] );
			}
		}

		if ( $this->updateOption( 'timezone', $user, $force ) ) {
			if ( array_key_exists( 'timezone', $sreg ) ) {
				# FIXME: do something with it.
				# $offset = OpenIDTimezoneToTzoffset($sreg['timezone']);
				# $user->setOption('timecorrection', $offset);
			}
		}

		$user->saveSettings();
	}

	/**
	 * Helper function for updateUser()
	 */
	private function updateOption( $option, User $user, $force ) {
		return $force === true || ( is_array( $force ) && in_array( $option, $force ) ) ||
			$user->getOption( 'openid-update-on-login-' . $option ) ||
			$user->getOption( 'openid-update-on-login' ); // Back compat with old option
	}

	/**
	 * Display the final "Successful login"
	 *
	 * @param $openid String: OpenID url
	 */
	function displaySuccessLogin( $openid ) {
		global $wgUser, $wgOut;

		$this->setupSession();
		RequestContext::getMain()->setUser( $wgUser );
		$wgUser->SetCookies();

		# Run any hooks; ignore results
		$inject_html = '';
		wfRunHooks( 'UserLoginComplete', array( &$wgUser, &$inject_html ) );

		# Set a cookie for later check-immediate use

		$this->loginSetCookie( $openid );

		$wgOut->setPageTitle( wfMsg( 'openidsuccess' ) );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->addWikiMsg( 'openidsuccesstext', $wgUser->getName(), $openid );
		$wgOut->addHtml( $inject_html );
		list( $returnto, $returntoquery ) = $this->returnTo();
		$wgOut->returnToMain( null, $returnto, $returntoquery );
	}

	function createUser( $openid, $sreg, $ax, $name ) {
		global $wgUser, $wgAuth;

		$user = User::newFromName( $name );

          	# Check permissions
		if ( !$user->isAllowed( 'createaccount' ) ) {
			wfDebug( "OpenID: User is not allowed to create an account.\n" );
			return null;
		} elseif ( $user->isBlockedFromCreateAccount() ) {
			wfDebug( "OpenID: User is blocked.\n" );
			return null;
		}

		if ( !$user ) {
			wfDebug( "OpenID: Error adding new user.\n" );
			return null;
		}

		$user->addToDatabase();

		if ( !$user->getId() ) {
			wfDebug( "OpenID: Error adding new user.\n" );
		} else {
			$wgAuth->initUser( $user );
			$wgAuth->updateUser( $user );

			$wgUser = $user;

			# new user account: not opened by mail
   			wfRunHooks( 'AddNewAccount', array( $user, false ) );
			$user->addNewUserLogEntry();

			# Update site stats
			$ssUpdate = new SiteStatsUpdate( 0, 0, 0, 0, 1 );
			$ssUpdate->doUpdate();

			self::addUserUrl( $user, $openid );
			$this->updateUser( $user, $sreg, $ax, true );
			$user->saveSettings();
			return $user;
		}
	}

	function attachUser( $openid, $sreg, $name, $password ) {
		$user = User::newFromName( $name );

		if ( !$user ) {
			return null;
		}

		if ( !$user->checkPassword( $password ) ) {
			return null;
		}

		self::addUserUrl( $user, $openid );

		return $user;
	}

	# Methods to get the user name
	# ----------------------------

	function getUserName( $openid, $sreg, $ax, $choice, $nameValue ) {
	global $wgOpenIDAllowAutomaticUsername, $wgOpenIDAllowNewAccountname, $wgOpenIDProposeUsernameFromSREG;

		switch ( $choice ) {
		 case 'nick':
		 	if ( $wgOpenIDProposeUsernameFromSREG ) return ( ( array_key_exists( 'nickname', $sreg ) ) ? $sreg['nickname'] : null );
		 	break;
		 case 'full':
		        if ( !$wgOpenIDProposeUsernameFromSREG ) return;
		 	# check the SREG first; only return a value if non-null
		 	$fullname = ( ( array_key_exists( 'fullname', $sreg ) ) ? $sreg['fullname'] : null );
		 	if ( !is_null( $fullname ) ) {
			 	return $fullname;
			}

		 	# try AX
		 	$fullname = ( ( array_key_exists( 'http://axschema.org/namePerson/first', $ax ) || array_key_exists( 'http://axschema.org/namePerson/last', $ax ) ) ? $ax['http://axschema.org/namePerson/first'][0] . " " . $ax['http://axschema.org/namePerson/last'][0] : null );

		 	return $fullname;
			break;
		 case 'url':
			if ( $wgOpenIDProposeUsernameFromSREG ) return $this->toUserName( $openid );
			break;
		 case 'auto':
		        if ( $wgOpenIDAllowAutomaticUsername ) return $this->automaticName( $sreg );
			break;
		 case 'manual':
		        if ( $wgOpenIDAllowNewAccountname ) return $nameValue;
		 default:
			return null;
		}
	}

	function toUserName( $openid ) {
        if ( Auth_Yadis_identifierScheme( $openid ) == 'XRI' ) {
			return $this->toUserNameXri( $openid );
		} else {
			return $this->toUserNameUrl( $openid );
		}
	}

	function getNameFromEmail( $openid, $sreg, $ax ) {

		# return the part before the @ in the e-mail address;
		# look at AX, then SREG.
		if ( array_key_exists ( 'http://axschema.org/contact/email', $ax ) ) {
			$addr = explode( "@", $ax['http://axschema.org/contact/email'][0] );
			if ( $addr ) {
				return $addr[0];
			}
		}

		if ( array_key_exists( 'email', $sreg ) ) {
			$addr = explode( "@", $sreg['email'] );
			if ( $addr ) {
				return $addr[0];
			}
		}
	}

	/**
	 * We try to use an OpenID URL as a legal MediaWiki user name in this order
	 * 1. Plain hostname, like http://evanp.myopenid.com/
	 * 2. One element in path, like http://profile.typekey.com/EvanProdromou/
	 *   or http://getopenid.com/evanprodromou
	 */
    function toUserNameUrl( $openid ) {
		static $bad = array( 'query', 'user', 'password', 'port', 'fragment' );

	    $parts = parse_url( $openid );

		# If any of these parts exist, this won't work

		foreach ( $bad as $badpart ) {
			if ( array_key_exists( $badpart, $parts ) ) {
				return null;
			}
		}

		# We just have host and/or path

		# If it's just a host...
		if ( array_key_exists( 'host', $parts ) &&
			( !array_key_exists( 'path', $parts ) || strcmp( $parts['path'], '/' ) == 0 ) )
		{
			$hostparts = explode( '.', $parts['host'] );

			# Try to catch common idiom of nickname.service.tld

			if ( ( count( $hostparts ) > 2 ) &&
				( strlen( $hostparts[count( $hostparts ) - 2] ) > 3 ) && # try to skip .co.uk, .com.au
				( strcmp( $hostparts[0], 'www' ) != 0 ) )
			{
				return $hostparts[0];
			} else {
				# Do the whole hostname
				return $parts['host'];
			}
		} else {
			if ( array_key_exists( 'path', $parts ) ) {
				# Strip starting, ending slashes
				$path = preg_replace( '@/$@', '', $parts['path'] );
				$path = preg_replace( '@^/@', '', $path );
				if ( strpos( $path, '/' ) === false ) {
					return $path;
				}
			}
		}

		return null;
	}

	function toUserNameXri( $xri ) {
		$base = $this->xriBase( $xri );

		if ( !$base ) {
			return null;
		} else {
			# =evan.prodromou
			# or @gratis*evan.prodromou
			$parts = explode( '*', substr( $base, 1 ) );
			return array_pop( $parts );
		}
	}

	function automaticName( $sreg ) {
		if ( array_key_exists( 'nickname', $sreg ) && # try auto-generated from nickname
			strlen( $sreg['nickname'] ) > 0 ) {
			return $this->firstAvailable( $sreg['nickname'] );
		} else { # try auto-generated
			return $this->firstAvailable( wfMsg( 'openidusernameprefix' ) );
		}
	}

	/**
	 * Get an auto-incremented name
	 */
	function firstAvailable( $prefix ) {
		for ( $i = 2; ; $i++ ) { # FIXME: this is the DUMB WAY to do this
			$name = "$prefix$i";
			if ( $this->userNameOK( $name ) ) {
				return $name;
			}
		}
	}

	/**
	 * Is this name OK to use as a user name?
	 */
	function userNameOK( $name ) {
		global $wgReservedUsernames;
		return ( 0 == User::idFromName( $name ) &&
				!in_array( $name, $wgReservedUsernames ) );
	}

	# Session stuff
	# -------------

	function saveValues( $response, $sreg, $ax ) {
		$this->setupSession();

		$_SESSION['openid_consumer_response'] = $response;
		$_SESSION['openid_consumer_sreg'] = $sreg;
		$_SESSION['openid_consumer_ax'] = $ax;

		return true;
	}

	function clearValues() {
		unset( $_SESSION['openid_consumer_response'] );
		unset( $_SESSION['openid_consumer_sreg'] );
		unset( $_SESSION['openid_consumer_ax'] );
		return true;
	}

	function fetchValues() {
		$response = isset( $_SESSION['openid_consumer_response'] ) ? $_SESSION['openid_consumer_response'] : null;
		$sreg = isset( $_SESSION['openid_consumer_sreg'] ) ? $_SESSION['openid_consumer_sreg'] : null;
		$ax = isset( $_SESSION['openid_consumer_ax'] ) ? $_SESSION['openid_consumer_ax'] : null;
		return array( $response, $sreg, $ax );
	}

	function returnTo() {
		$returnto = isset( $_SESSION['openid_consumer_returnto'] ) ? $_SESSION['openid_consumer_returnto'] : '';
		$returntoquery = isset( $_SESSION['openid_consumer_returntoquery'] ) ? $_SESSION['openid_consumer_returntoquery'] : '';
		return array( $returnto, $returntoquery );
	}

	function setReturnTo( $returnto, $returntoquery ) {
		$this->setupSession();
		$_SESSION['openid_consumer_returnto'] = $returnto;
		$_SESSION['openid_consumer_returntoquery'] = $returntoquery;
	}
}
