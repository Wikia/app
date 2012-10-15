<?php
/**
 * SpecialOpenIDServer.body.php -- Server side of OpenID site
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

require_once( "Auth/OpenID/Server.php" );
require_once( "Auth/OpenID/Consumer.php" );

# Special page for the server side of OpenID
# It has three major flavors:
# * no parameter is for external requests to validate a user.
# * 'Login' is we got a validation request but the
#   user wasn't logged in. We show them a form (see OpenIDServerLoginForm)
#   and they post the results, which go to OpenIDServerLogin
# * 'Trust' is when the user has logged in, but they haven't
#   specified whether it's OK to let the requesting site trust them.
#   If they haven't, we show them a form (see OpenIDServerTrustForm)
#   and let them post results which go to OpenIDServerTrust.
#
# OpenID has its own modes; we only handle two of them ('check_setup' and
# 'check_immediate') and let the OpenID libraries handle the rest.
#
# Output may be just a redirect, or a form if we need info.

class SpecialOpenIDServer extends SpecialOpenID {

	function __construct() {
		parent::__construct( "OpenIDServer", '', false );
	}

	function execute( $par ) {
		global $wgOut, $wgOpenIDClientOnly;

		$this->setHeaders();

		# No server functionality if this site is only a client
		# Note: special page is un-registered if this flag is set,
		# so it'd be unusual to get here.

		if ( $wgOpenIDClientOnly ) {
			$wgOut->showErrorPage( 'openiderror', 'openidclientonlytext' );
			return;
		}

		wfSuppressWarnings();
		$server = $this->getServer();
		wfRestoreWarnings();

		switch ( $par ) {
		 case 'Login':
			list( $request, $sreg ) = $this->FetchValues();
			$result = $this->serverLogin( $request );
			if ( $result ) {
				if ( is_string( $result ) ) {
					$this->LoginForm( $request, $result );
					return;
				} else {
					$this->Response( $server, $result );
					return;
				}
			}
			break;
		case 'Trust':
			list( $request, $sreg ) = $this->FetchValues();
			$result = $this->Trust( $request, $sreg );
			if ( $result ) {
				if ( is_string( $result ) ) {
					$this->TrustForm( $request, $sreg, $result );
					return;
				} else {
					$this->Response( $server, $result );
					return;
				}
			}
			break;
		default:
			if ( strlen( $par ) ) {
				wfDebug( "OpenID: aborting in user validation because the parameter was empty\n" );
				$wgOut->showErrorPage( 'openiderror', 'openiderrortext' );
				return;
			} else {
				$method = $_SERVER['REQUEST_METHOD'];
				$query = null;
				if ( $method == 'GET' ) {
					$query = $_GET;
				} else {
					$query = $_POST;
				}

				wfSuppressWarnings();
				$request = $server->decodeRequest();
				wfRestoreWarnings();

				$sreg = $this->SregFromQuery( $query );
				$response = null;
				break;
			}
		}

		if ( !isset( $request ) ) {
			wfDebug( "OpenID: aborting in user validation because the request was missing\n" );
			$wgOut->showErrorPage( 'openiderror', 'openiderrortext' );
			return;
		}

		global $wgUser;

		switch ( $request->mode ) {
		 case "checkid_setup":
			$response = $this->Check( $server, $request, $sreg, false );
			break;
		 case "checkid_immediate":
			$response = $this->Check( $server, $request, $sreg, true );
			break;
		 default:
			# For all the other parts, just let the libs do it
			wfSuppressWarnings();
			$response =& $server->handleRequest( $request );
			wfRestoreWarnings();
		}

		# OpenIDServerCheck returns NULL if some output (like a form)
		# has been done

		if ( isset( $response ) ) {
			# We're done; clear values
			$this->ClearValues();
			$this->Response( $server, $response );
		}
	}

	# Returns the full URL of the special page; we need to pass it around
	# for some requests

	function Url() {
		$nt = SpecialPage::getTitleFor( 'OpenIDServer' );
		if ( isset( $nt ) ) {
			return $nt->getFullURL();
		} else {
			return null;
		}
	}

	# Returns an Auth_OpenID_Server from the libraries. Utility.

	/**
	 * @return Auth_OpenID_Server
	 */
	function getServer() {
		global $wgOpenIDServerStorePath,
		  $wgOpenIDServerStoreType;

		$store = $this->getOpenIDStore(
			$wgOpenIDServerStoreType,
			'server',
			array( 'path' => $wgOpenIDServerStorePath )
		);

		return new Auth_OpenID_Server( $store, $this->serverUrl() );
	}

	# Checks a validation request. $imm means don't run any UI.
	# Fairly meticulous and step-by step, and uses assertions
	# to point out assumptions at each step.
	#
	# FIXME: this should probably be broken up into multiple functions for
	# clarity.

	function Check( $server, $request, $sreg, $imm = true ) {

		global $wgUser, $wgOut, $wgOpenIDAllowServingOpenIDUserAccounts;

		assert( isset( $wgUser ) && isset( $wgOut ) );
		assert( isset( $server ) );
		assert( isset( $request ) );
		assert( isset( $sreg ) );
		assert( isset( $imm ) && is_bool( $imm ) );

		# Is the passed identity URL a user page?

		$url = $request->identity;

		assert( isset( $url ) && strlen( $url ) > 0 );

		wfDebug( "OpenID: OpenIDServer received: '$url'.\n" );

		$name = $this->UrlToUserName( $url );

		if ( !isset( $name ) || strlen( $name ) == 0 ) {
			wfDebug( "OpenID: '$url' not a user page.\n" );
			return $request->answer( false, $this->serverUrl() );
		}

		assert( isset( $name ) && strlen( $name ) > 0 );

		# Is there a logged in user?

		if ( $wgUser->getId() == 0 ) {
			wfDebug( "OpenID: User not logged in.\n" );
			if ( $imm ) {
				return $request->answer( false, $this->serverUrl() );
			} else {
				# Bank these for later
				$this->SaveValues( $request, $sreg );
				$this->LoginForm( $request );
				return null;
			}
		}

		assert( $wgUser->getId() != 0 );

		# Is the user page for the logged-in user?

		$user = User::newFromName( $name );

		if ( !isset( $user ) ||
			$user->getId() != $wgUser->getId() ) {
			wfDebug( "OpenID: User from url not logged in user.\n" );
			return $request->answer( false, $this->serverUrl() );
		}

		assert( isset( $user ) && $user->getId() == $wgUser->getId() && $user->getId() != 0 );

		# Is the user an OpenID user?

		if ( !$wgOpenIDAllowServingOpenIDUserAccounts && $this->getUserOpenIDInformation( $user ) ) {
			wfDebug( "OpenID: Not one of our users; logs in with OpenID.\n" );
			return $request->answer( false, $this->serverUrl() );
		}

		assert( is_array( $sreg ) );

		# Does the request require sreg fields that the user has not specified?

		if ( array_key_exists( 'required', $sreg ) ) {
			$notFound = false;
			foreach ( $sreg['required'] as $reqfield ) {
				if ( is_null( $this->GetUserField( $user, $reqfield ) ) ) {
					$notFound = true;
					break;
				}
			}
			if ( $notFound ) {
				wfDebug( "OpenID: Consumer demands info we don't have.\n" );
				return $request->answer( false, $this->serverUrl() );
			}
		}

		# Trust check

		$trust_root = $request->trust_root;

		assert( isset( $trust_root ) && is_string( $trust_root ) && strlen( $trust_root ) > 0 );

		$trust = $this->GetUserTrust( $user, $trust_root );

		# Is there a trust record?

		if ( is_null( $trust ) ) {
			wfDebug( "OpenID: No trust record.\n" );
			if ( $imm ) {
				return $request->answer( false, $this->serverUrl() );
			} else {
				# Bank these for later
				$this->SaveValues( $request, $sreg );
				$this->TrustForm( $request, $sreg );
				return null;
			}
		}

		assert( !is_null( $trust ) );

		# Is the trust record _not_ to allow trust?
		# NB: exactly equal

		if ( $trust === false ) {
			wfDebug( "OpenID: User specified not to allow trust.\n" );
			return $request->answer( false, $this->serverUrl() );
		}

		assert( isset( $trust ) && is_array( $trust ) );

		# Does the request require sreg fields that the user has
		# not allowed us to pass, or has not specified?

		if ( array_key_exists( 'required', $sreg ) ) {
			$notFound = false;
			foreach ( $sreg['required'] as $reqfield ) {
				if ( !in_array( $reqfield, $trust ) ||
					is_null( $this->GetUserField( $user, $reqfield ) ) ) {
					$notFound = true;
					break;
				}
			}
			if ( $notFound ) {
				wfDebug( "OpenID: Consumer demands info user doesn't want shared.\n" );
				return $request->answer( false, $this->serverUrl() );
			}
		}

		# assert(all required sreg fields are in $trust)

		# FIXME: run a hook here to check

		# SUCCESS

		$response_fields = array_intersect( array_unique( array_merge( $sreg['required'], $sreg['optional'] ) ),
										   $trust );

		wfSuppressWarnings();
		$response = $request->answer( true );
		wfRestoreWarnings();

		assert( isset( $response ) );

		foreach ( $response_fields as $field ) {
			$value = $this->GetUserField( $user, $field );
			if ( !is_null( $value ) ) {
				$response->addField( 'sreg', $field, $value );
			}
		}

		return $response;
	}

	# Get the user's configured trust value for a particular trust root.
	# Returns one of three values:
	# * NULL -> no stored trust preferences
	# * false -> stored trust preference is not to trust
	# * array -> possibly empty array of allowed profile fields; trust is OK

	function GetUserTrust( $user, $trust_root ) {
		static $allFields = array( 'nickname', 'fullname', 'email', 'language' );
		global $wgOpenIDServerForceAllowTrust;

		foreach ( $wgOpenIDServerForceAllowTrust as $force ) {
			if ( preg_match( $force, $trust_root ) ) {
				return $allFields;
			}
		}

		$trust_array = $this->GetUserTrustArray( $user );

		if ( array_key_exists( $trust_root, $trust_array ) ) {
			return $trust_array[$trust_root];
		} else {
			return null; # Unspecified trust
		}
	}

	function SetUserTrust( &$user, $trust_root, $value ) {

		$trust_array = $this->GetUserTrustArray( $user );

		if ( is_null( $value ) ) {
			if ( array_key_exists( $trust_root, $trust_array ) ) {
				unset( $trust_array[$trust_root] );
			}
		} else {
			$trust_array[$trust_root] = $value;
		}

		$this->SetUserTrustArray( $user, $trust_array );
	}

	function GetUserTrustArray( $user ) {
		$trust_array = array();
		$trust_str = $user->getOption( 'openid_trust' );
		if ( strlen( $trust_str ) > 0 ) {
			$trust_records = explode( "\x1E", $trust_str );
			foreach ( $trust_records as $record ) {
				$fields = explode( "\x1F", $record );
				$trust_root = array_shift( $fields );
				if ( count( $fields ) == 1 && strcmp( $fields[0], 'no' ) == 0 ) {
					$trust_array[$trust_root] = false;
				} else {
					$fields = array_map( 'trim', $fields );
					$fields = array_filter( $fields, array( $this, 'ValidField' ) );
					$trust_array[$trust_root] = $fields;
				}
			}
		}
		return $trust_array;
	}

	function SetUserTrustArray( &$user, $arr ) {
		$trust_records = array();
		foreach ( $arr as $root => $value ) {
			if ( $value === false ) {
				$record = implode( "\x1F", array( $root, 'no' ) );
			} elseif ( is_array( $value ) ) {
				if ( count( $value ) == 0 ) {
					$record = $root;
				} else {
					$value = array_map( 'trim', $value );
					$value = array_filter( $value, array( $this, 'ValidField' ) );
					$record = implode( "\x1F", array_merge( array( $root ), $value ) );
				}
			} else {
				continue;
			}
			$trust_records[] = $record;
		}
		$trust_str = implode( "\x1E", $trust_records );
		$user->setOption( 'openid_trust', $trust_str );
	}

	function ValidField( $name ) {
		# FIXME: eventually add timezone
		static $fields = array( 'nickname', 'email', 'fullname', 'language' );
		return in_array( $name, $fields );
	}

	function SregFromQuery( $query ) {
		$sreg = array( 'required' => array(), 'optional' => array(),
					  'policy_url' => null );
		if ( array_key_exists( 'openid.sreg.required', $query ) ) {
			$sreg['required'] = explode( ',', $query['openid.sreg.required'] );
		}
		if ( array_key_exists( 'openid.sreg.optional', $query ) ) {
			$sreg['optional'] = explode( ',', $query['openid.sreg.optional'] );
		}
		if ( array_key_exists( 'openid.sreg.policy_url', $query ) ) {
			$sreg['policy_url'] = $query['openid.sreg.policy_url'];
		}
		return $sreg;
	}

	function SetUserField( &$user, $field, $value ) {
		switch ( $field ) {
		 case 'fullname':
			$user->setRealName( $value );
			return true;
			break;
		 case 'email':
			# FIXME: deal with validation
			$user->setEmail( $value );
			return true;
			break;
		 case 'language':
			$user->setOption( 'language', $value );
			return true;
			break;
		 default:
			return false;
		}
	}

	function GetUserField( $user, $field ) {
		switch ( $field ) {
		 case 'nickname':
			return $user->getName();
			break;
		 case 'fullname':
			return $user->getRealName();
			break;
		 case 'email':
			return $user->getEmail();
			break;
		 case 'language':
			return $user->getOption( 'language' );
			break;
		 default:
			return null;
		}
	}

	function Response( &$server, &$response ) {
		global $wgOut;

		assert( !is_null( $server ) );
		assert( !is_null( $response ) );

		$wgOut->disable();

		wfSuppressWarnings();
		$wr =& $server->encodeResponse( $response );
		wfRestoreWarnings();

		assert( !is_null( $wr ) );

		header( "Status: " . $wr->code );

		foreach ( $wr->headers as $k => $v ) {
			header( "$k: $v" );
		}

		print $wr->body;

		return;
	}

	function LoginForm( $request, $msg = null ) {
		global $wgOut, $wgUser;

		$url = $request->identity;
		$name = $this->UrlToUserName( $url );
		$trust_root = $request->trust_root;

		$instructions = wfMsg( 'openidserverlogininstructions', $url, $name, $trust_root );

		$username = wfMsg( 'yourname' );
		$password = wfMsg( 'yourpassword' );
		$ok = wfMsg( 'ok' );
		$cancel = wfMsg( 'cancel' );

		if ( !is_null( $msg ) ) {
			$wgOut->addHTML( "<p class='error'>{$msg}</p>" );
		}

		$sk = $wgUser->getSkin();

		$wgOut->addHTML( "<p>{$instructions}</p>" .
						'<form action="' . $sk->makeSpecialUrl( 'OpenIDServer/Login' ) . '" method="POST">' .
						'<table>' .
						"<tr><td><label for='username'>{$username}</label></td>" .
						'    <td><span id="username">' . htmlspecialchars( $name ) . '</span></td></tr>' .
						"<tr><td><label for='password'>{$password}</label></td>" .
						'    <td><input type="password" name="wpPassword" size="32" value="" /></td></tr>' .
						"<tr><td colspan='2'><input type='submit' name='wpOK' value='{$ok}' /> <input type='submit' name='wpCancel' value='{$cancel}' /></td></tr>" .
						'</table>' .
						'</form>' );
	}

	function SaveValues( $request, $sreg ) {
		if ( session_id() == '' ) {
			wfSetupSession();
		}

		$_SESSION['openid_server_request'] = $request;
		$_SESSION['openid_server_sreg'] = $sreg;

		return true;
	}

	function FetchValues() {
		return array( $_SESSION['openid_server_request'], $_SESSION['openid_server_sreg'] );
	}

	function ClearValues() {
		unset( $_SESSION['openid_server_request'] );
		unset( $_SESSION['openid_server_sreg'] );
		return true;
	}

	function serverLogin( $request ) {
		global $wgRequest, $wgUser;

		assert( isset( $request ) );

		assert( isset( $wgRequest ) );

		if ( $wgRequest->getCheck( 'wpCancel' ) ) {
			return $request->answer( false );
		}

		$password = $wgRequest->getText( 'wpPassword' );

		if ( !isset( $password ) || strlen( $password ) == 0 ) {
			return wfMsg( 'wrongpasswordempty' );
		}

		assert ( isset( $password ) && strlen( $password ) > 0 );

		$url = $request->identity;

		assert( isset( $url ) && is_string( $url ) && strlen( $url ) > 0 );

		$name = $this->UrlToUserName( $url );

		assert( isset( $name ) && is_string( $name ) && strlen( $name ) > 0 );

		$user = User::newFromName( $name );

		assert( isset( $user ) );

		if ( !$user->checkPassword( $password ) ) {
			return wfMsg( 'wrongpassword' );
		} else {
			$id = $user->getId();
			$wgUser = $user;
			wfSetupSession();
			$wgUser->SetCookies();
			wfRunHooks( 'UserLoginComplete', array( &$wgUser ) );
			return false;
		}
	}

	function TrustForm( $request, $sreg, $msg = null ) {

		global $wgOut, $wgUser;

		$url = $request->identity;
		$name = $this->UrlToUserName( $url );
		$trust_root = $request->trust_root;

		$instructions = wfMsg( 'openidtrustinstructions', $trust_root );
		$allow = wfMsg( 'openidallowtrust', $trust_root );

		if ( is_null( $sreg['policy_url'] ) ) {
			$policy = wfMsg( 'openidnopolicy' );
		} else {
			$policy = wfMsg( 'openidpolicy', $sreg['policy_url'] );
		}

		if ( isset( $msg ) ) {
			$wgOut->addHTML( "<p class='error'>{$msg}</p>" );
		}

		$ok = wfMsg( 'ok' );
		$cancel = wfMsg( 'cancel' );

		$sk = $wgUser->getSkin();

		$wgOut->addHTML( "<p>{$instructions}</p>" .
						'<form action="' . $sk->makeSpecialUrl( 'OpenIDServer/Trust' ) . '" method="POST">' .
						'<input name="wpAllowTrust" type="checkbox" value="on" checked="checked" id="wpAllowTrust">' .
						'<label for="wpAllowTrust">' . $allow . '</label><br />' );

		$fields = array_filter( array_unique( array_merge( $sreg['optional'], $sreg['required'] ) ),
							   array( $this, 'ValidField' ) );

		if ( count( $fields ) > 0 ) {
			$wgOut->addHTML( '<table>' );
			foreach ( $fields as $field ) {
				$wgOut->addHTML( "<tr>" );
				$wgOut->addHTML( "<th><label for='wpAllow{$field}'>" );
				$wgOut->addHTML( wfMsg( "openid$field" ) );
				$wgOut->addHTML( "</label></th>" );
				$value = $this->GetUserField( $wgUser, $field );
				$wgOut->addHTML( "</td>" );
				$wgOut->addHTML( "<td> " . ( ( is_null( $value ) ) ? '' : $value ) . "</td>" );
				$wgOut->addHTML( "<td>" . ( ( in_array( $field, $sreg['required'] ) ) ? wfMsg( 'openidrequired' ) : wfMsg( 'openidoptional' ) ) . "</td>" );
				$wgOut->addHTML( "<td><input name='wpAllow{$field}' id='wpAllow{$field}' type='checkbox'" );
				if ( !is_null( $value ) ) {
					$wgOut->addHTML( " value='on' checked='checked' />" );
				} else {
					$wgOut->addHTML( " disabled='disabled' />" );
				}
				$wgOut->addHTML( "</tr>" );
			}
			$wgOut->addHTML( '</table>' );
		}
		$wgOut->addHTML( "<input type='submit' name='wpOK' value='{$ok}' /> <input type='submit' name='wpCancel' value='{$cancel}' /></form>" );
		return null;
	}

	function Trust( $request, $sreg ) {
		global $wgRequest, $wgUser;

		assert( isset( $request ) );
		assert( isset( $sreg ) );
		assert( isset( $wgRequest ) );

		if ( $wgRequest->getCheck( 'wpCancel' ) ) {
			return $request->answer( false );
		}

		$trust_root = $request->trust_root;

		assert( isset( $trust_root ) && strlen( $trust_root ) > 0 );

		# If they don't want us to allow trust, save that.

		if ( !$wgRequest->getCheck( 'wpAllowTrust' ) ) {

			$this->SetUserTrust( $wgUser, $trust_root, false );
			# Set'em and sav'em
			$wgUser->saveSettings();
		} else {

			$fields = array_filter( array_unique( array_merge( $sreg['optional'], $sreg['required'] ) ),
								   array( $this, 'ValidField' ) );

			$allow = array();

			foreach ( $fields as $field ) {
				if ( $wgRequest->getCheck( 'wpAllow' . $field ) ) {
					$allow[] = $field;
				}
			}

			$this->SetUserTrust( $wgUser, $trust_root, $allow );
			# Set'em and sav'em
			$wgUser->saveSettings();
		}

	}

	# Converts an URL to a user name, if possible

	function UrlToUserName( $url ) {

		global $wgArticlePath, $wgServer;

		# URL must be a string

		if ( !isset( $url ) || !is_string( $url ) || strlen( $url ) == 0 ) {
			return null;
		}

		# it must start with our server, case doesn't matter

		if ( strpos( strtolower( $url ), strtolower( $wgServer ) ) !== 0 ) {
			return null;
		}

		$parts = parse_url( $url );

		$relative = $parts['path'];
		if ( !is_null( $parts['query'] ) && strlen( $parts['query'] ) > 0 ) {
			$relative .= '?' . $parts['query'];
		}

		# Use regexps to extract user name
		$pattern = str_replace( '$1', '(.*)', $wgArticlePath );
		$pattern = str_replace( '?', '\?', $pattern );

		/* remove "Special:OpenIDXRDS/" to allow construction of a valid user page name */
		$specialPagePrefix = SpecialPage::getTitleFor( 'OpenIDXRDS' );

		if ( $specialPagePrefix != "Special:OpenIDXRDS" ) {
			$specialPagePrefix = "( {$specialPagePrefix} | Special:OpenIDXRDS )";
		}

		$relative = preg_replace( "!" . preg_quote( $specialPagePrefix, "!" ) . "/!", "", $relative );

		# Can't have a pound-sign in the relative, since that's for fragments
		if ( !preg_match( "#$pattern#", $relative, $matches ) ) {
			return null;
		} else {
			$titletext = urldecode( $matches[1] );
			$nt = Title::newFromText( $titletext );
			if ( is_null( $nt ) || $nt->getNamespace() != NS_USER ) {
				return null;
			} else {
				return $nt->getText();
			}
		}
	}

	function serverUrl() {
		return $this->getTitle()->getFullUrl();
	}
}
