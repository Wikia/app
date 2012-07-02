<?php
/**
 * SpecialOpenID.body.php -- Superclass for all
 * Copyright 2006,2007 Internet Brands (http://www.internetbrands.com/)
 * Copyright 2008 by Evan Prodromou (http://evan.prodromou.name/)
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

# FIXME: for login(); figure out better way to share this code
# between Login and Convert

require_once( "Auth/OpenID/Consumer.php" );
require_once( "Auth/OpenID/SReg.php" );
require_once( "Auth/OpenID/AX.php" );
require_once( "Auth/OpenID/FileStore.php" );

class SpecialOpenID extends SpecialPage {

	function getOpenIDStore( $storeType, $prefix, $options ) {
		global $wgOut, $wgMemc, $wgDBtype;

		switch ( $storeType ) {

		case 'file':
			# Auto-create path if it doesn't exist
			if ( !is_dir( $options['path'] ) ) {
				if ( !mkdir( $options['path'], 0770, true ) ) {
					$wgOut->showErrorPage( 'openidconfigerror', 'openidconfigerrortext' );
					return null;
				}
			}
			return new Auth_OpenID_FileStore( $options['path'] );

		case 'db':
			if ( $wgDBtype == 'sqlite' ) {
				$db = new MediaWikiOpenIDDatabaseConnection( wfGetDB( DB_MASTER ) );
				require_once( 'Auth/OpenID/SQLiteStore.php' );
				return new Auth_OpenID_SQLiteStore( $db );
			} else {
				$lb = wfGetLBFactory()->newMainLB();
				$db = new MediaWikiOpenIDDatabaseConnection( $lb->getConnection( DB_MASTER ) );
				switch( $wgDBtype ) {
				case 'mysql':
					require_once( 'Auth/OpenID/MySQLStore.php' );
					return new Auth_OpenID_MySQLStore( $db );
				case 'postgres':
					require_once( 'Auth/OpenID/PostgreSQLStore.php' );
					return new Auth_OpenID_PostgreSQLStore( $db );
				default:
					$wgOut->showErrorPage( 'openidconfigerror', 'openidconfigerrortext' );
					return null;
				}
			}

		case 'memcached':
			return new MediaWikiOpenIDMemcachedStore( $wgMemc );

		 default:
			$wgOut->showErrorPage( 'openidconfigerror', 'openidconfigerrortext' );
		}
	}

	function xriBase( $xri ) {
		if ( substr( $xri, 0, 6 ) == 'xri://' ) {
			return substr( $xri, 6 );
		} else {
			return $xri;
		}
	}

	function xriToUrl( $xri ) {
		return 'http://xri.net/' . SpecialOpenID::xriBase( $xri );
	}

	static function OpenIDToUrl( $openid ) {
		/* ID is either an URL already or an i-name */
		if ( Auth_Yadis_identifierScheme( $openid ) == 'XRI' ) {
			return SpecialOpenID::xriToUrl( $openid );
		} else {
			return $openid;
		}
	}

	function interwikiExpand( $openid_url ) {
		# try to make it into a title object
		$nt = Title::newFromText( $openid_url );
		# If it's got an iw, return that
		if ( !is_null( $nt ) && !is_null( $nt->getInterwiki() )
			&& strlen( $nt->getInterwiki() ) > 0 ) {
			return $nt->getFullUrl();
		} else {
			return $openid_url;
		}
	}

	# Login, Finish

	function getConsumer() {
		global $wgOpenIDConsumerStoreType, $wgOpenIDConsumerStorePath;

		$store = $this->getOpenIDStore(
			$wgOpenIDConsumerStoreType,
			'consumer',
			array( 'path' => $wgOpenIDConsumerStorePath )
		);

		return new Auth_OpenID_Consumer( $store );
	}

	function canLogin( $openid_url ) {
		global $wgOpenIDConsumerDenyByDefault, $wgOpenIDConsumerAllow, $wgOpenIDConsumerDeny;

		if ( $this->isLocalUrl( $openid_url ) ) {
			return false;
		}

		if ( $wgOpenIDConsumerDenyByDefault ) {
			$canLogin = false;
			foreach ( $wgOpenIDConsumerAllow as $allow ) {
				if ( preg_match( $allow, $openid_url ) ) {
					wfDebug( "OpenID: $openid_url matched allow pattern $allow.\n" );
					$canLogin = true;
					foreach ( $wgOpenIDConsumerDeny as $deny ) {
						if ( preg_match( $deny, $openid_url ) ) {
							wfDebug( "OpenID: $openid_url matched deny pattern $deny.\n" );
							$canLogin = false;
							break;
						}
					}
					break;
				}
			}
		} else {
			$canLogin = true;
			foreach ( $wgOpenIDConsumerDeny as $deny ) {
				if ( preg_match( $deny, $openid_url ) ) {
					wfDebug( "OpenID: $openid_url matched deny pattern $deny.\n" );
					$canLogin = false;
					foreach ( $wgOpenIDConsumerAllow as $allow ) {
						if ( preg_match( $allow, $openid_url ) ) {
							wfDebug( "OpenID: $openid_url matched allow pattern $allow.\n" );
							$canLogin = true;
							break;
						}
					}
					break;
				}
			}
		}
		return $canLogin;
	}

	function isLocalUrl( $url ) {
		global $wgServer, $wgArticlePath;

		$pattern = $wgServer . $wgArticlePath;
		$pattern = str_replace( '$1', '(.*)', $pattern );
		$pattern = str_replace( '?', '\?', $pattern );

		return preg_match( '|^' . $pattern . '$|', $url );
	}

	function login( $openid_url, $finish_page ) {
		global $wgTrustRoot, $wgOut;

		# If it's an interwiki link, expand it

		$openid_url = $this->interwikiExpand( $openid_url );

		# Check if the URL is allowed

		if ( !$this->canLogin( $openid_url ) ) {
			$wgOut->showErrorPage( 'openidpermission', 'openidpermissiontext' );
			return;
		}

		if ( !is_null( $wgTrustRoot ) ) {
			$trust_root = $wgTrustRoot;
		} else {
			global $wgScriptPath, $wgServer;
			$trust_root = $wgServer . $wgScriptPath;
		}

		wfSuppressWarnings();

		$consumer = $this->getConsumer();

		if ( !$consumer ) {
			wfDebug( "OpenID: no consumer\n" );
			$wgOut->showErrorPage( 'openiderror', 'openiderrortext' );
			return;
		}

		# Make sure the user has a session!
		$this->setupSession();

		$auth_request = $consumer->begin( $openid_url );

		// Handle failure status return values.
		if ( !$auth_request ) {
			wfDebug( "OpenID: no auth_request\n" );
			$wgOut->showErrorPage( 'openiderror', 'openiderrortext' );
			return;
		}

		# Check the processed URLs, too

		$endpoint = $auth_request->endpoint;

		if ( !is_null( $endpoint ) ) {
			# Check if the URL is allowed

			if ( isset( $endpoint->identity_url ) && !$this->canLogin( $endpoint->identity_url ) ) {
				$wgOut->showErrorPage( 'openidpermission', 'openidpermissiontext' );
				return;
			}

			if ( isset( $endpoint->delegate ) && !$this->canLogin( $endpoint->delegate ) ) {
				$wgOut->showErrorPage( 'openidpermission', 'openidpermissiontext' );
				return;
			}
		}

		$sreg_request = Auth_OpenID_SRegRequest::build(
			// Required
			array(),
			// Optional
			array( 'nickname', 'email', 'fullname', 'language', 'timezone' )
		);

		if ( $sreg_request ) {
			$auth_request->addExtension( $sreg_request );
		}

		// Create attribute request object. Depending on your endpoint, you can request many things:
		// see http://code.google.com/apis/accounts/docs/OpenID.html#Parameters for parameters.
		// Usage: make($type_uri, $count=1, $required=false, $alias=null)
		$attribute[] = Auth_OpenID_AX_AttrInfo::make( 'http://axschema.org/contact/email', 1, 1, 'email' );
		$attribute[] = Auth_OpenID_AX_AttrInfo::make( 'http://axschema.org/namePerson/first', 1, 1, 'firstname' );
		$attribute[] = Auth_OpenID_AX_AttrInfo::make( 'http://axschema.org/namePerson/last', 1, 1, 'lastname' );

		// Create AX fetch request and add attributes
		$ax_request = new Auth_OpenID_AX_FetchRequest;

		foreach ( $attribute as $attr ) {
			$ax_request->add( $attr );
		}

		if ( $ax_request ) {
			$auth_request->addExtension( $ax_request );
		}

		$process_url = $this->scriptUrl( $finish_page );

		if ( $auth_request->shouldSendRedirect() ) {
			$redirect_url = $auth_request->redirectURL( $trust_root,
													   $process_url );
			if ( Auth_OpenID::isFailure( $redirect_url ) ) {
				displayError( "Could not redirect to server: " . $redirect_url->message );
			} else {
				# OK, now go
				$wgOut->redirect( $redirect_url );
			}
		} else {
			// Generate form markup and render it.
			$form_id = 'openid_message';
			$form_html = $auth_request->formMarkup( $trust_root, $process_url,
												   false, array( 'id' => $form_id ) );

			// Display an error if the form markup couldn't be generated;
			// otherwise, render the HTML.
			if ( Auth_OpenID::isFailure( $form_html ) ) {
				displayError( 'Could not redirect to server: ' . $form_html->message );
			} else {
				$wgOut->addWikiMsg( 'openidautosubmit' );
				$wgOut->addHTML( $form_html );
				$wgOut->addInlineScript(
					"jQuery( document ).ready( function(){ jQuery( \"#" . $form_id . "\" ).submit() } );" 
				);
			}
		}

		wfRestoreWarnings();
	}

	function scriptUrl( $par = false ) {
		global $wgServer, $wgScript;

		if ( !is_object( $par ) ) {
			$nt = $this->getTitle( $par );
		} else {
			$nt = $par;
		}

		if ( !is_null( $nt ) ) {
			$dbkey = wfUrlencode( $nt->getPrefixedDBkey() );
			return "{$wgServer}{$wgScript}?title={$dbkey}";
		} else {
			return '';
		}
	}

	protected function setupSession() {
		if ( session_id() == '' ) {
			wfSetupSession();
		}
	}

	function loginSetCookie( $openid ) {
		global $wgRequest, $wgOpenIDCookieExpiration;
		$wgRequest->response()->setcookie( 'OpenID', $openid, time() +  $wgOpenIDCookieExpiration );
	}

	# Find the user with the given openid
	# return the registered OpenID urls and registration timestamps (if available)
	public static function getUserOpenIDInformation( $user ) {
		$openid_urls_registration = array();

		if ( $user instanceof User && $user->getId() != 0 ) {
			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'user_openid' ),
				array( 'uoi_openid', 'uoi_user_registration' ),
				array( 'uoi_user' => $user->getId() ),
				__METHOD__
			);

			foreach ( $res as $row ) {
				$openid_urls_registration[] = $row;
			}
			$res->free();
		}
		return $openid_urls_registration;
	}

	public static function getUserFromUrl( $openid ) {
		$dbr = wfGetDB( DB_SLAVE );

		$id = $dbr->selectField(
			'user_openid',
			'uoi_user',
			array( 'uoi_openid' => $openid ),
			__METHOD__
		);

		if ( $id ) {
			return User::newFromId( $id );
		} else {
			return null;
		}
	}

	public static function addUserUrl( $user, $url ) {
		$dbw = wfGetDB( DB_MASTER );

		$dbw->insert(
			'user_openid',
			array(
				'uoi_user' => $user->getId(),
				'uoi_openid' => $url,
				'uoi_user_registration' => wfTimestamp( TS_MW )
			),
			__METHOD__
		);

	}

	public static function removeUserUrl( $user, $url ) {
		$dbw = wfGetDB( DB_MASTER );

		$dbw->delete(
			'user_openid',
			array(
				'uoi_user' => $user->getId(),
				'uoi_openid' => $url
			),
			__METHOD__
		);

		return (bool)$dbw->affectedRows();
	}
}
