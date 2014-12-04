<?php
/**
 * SpecialOpenIDConvert.body.php -- Convert existing account to OpenID account
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

if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

class SpecialOpenIDConvert extends SpecialOpenID {

	function __construct() {
		parent::__construct( 'OpenIDConvert', 'openid-converter-access' );
	}

	function execute( $par ) {
		global $wgRequest, $wgUser, $wgOut;

		if ( !$this->userCanExecute( $wgUser ) ) {
                	$this->displayRestrictionError();
        	        return;
	        }

		$this->setHeaders();

		$this->outputHeader();

		switch ( $par ) {
		case 'Finish':
			$this->finish();
			break;
		case 'Delete':
			$this->delete();
			break;
		default:
			$openid_url = $wgRequest->getText( 'openid_url' );
			if ( isset( $openid_url ) && strlen( $openid_url ) > 0 ) {
				$this->convert( $openid_url );
			} else {
				$this->form();
			}
		}
	}

	function convert( $openid_url ) {
		global $wgUser, $wgOut;

		# Expand Interwiki
		$openid_url = $this->interwikiExpand( $openid_url );

		# Is this ID allowed to log in?
		if ( !$this->canLogin( $openid_url ) ) {
			$wgOut->showErrorPage( 'openidpermission', 'openidpermissiontext' );
			return;
		}

		# Is this ID already taken?
		$other = self::getUserFromUrl( $openid_url );

		if ( isset( $other ) ) {
			if ( $other->getId() == $wgUser->getID() ) {
				$wgOut->showErrorPage( 'openiderror', 'openidconvertyourstext' );
			} else {
				$wgOut->showErrorPage( 'openiderror', 'openidconvertothertext' );
			}
			return;
		}

		# If we're OK to here, let the user go log in
		$this->login( $openid_url, SpecialPage::getTitleFor( 'OpenIDConvert', 'Finish' ) );
	}

	function form() {
		global $wgOut, $wgUser, $wgOpenIDShowProviderIcons;

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
			Xml::fieldset( wfMsg( 'openidconvertoraddmoreids' ) ) .
			Xml::openElement( 'p' ) . wfMsg( 'openidconvertinstructions' ) . Xml::closeElement( 'p' ) .
			$largeButtonsHTML .
			'<div id="openid_input_area">' .
			$formsHTML .
			'</div>' .
			$smallButtonsHTML .
			Xml::closeElement( 'fieldset' ) . Xml::closeElement( 'form' )
		);
	}

	function delete() {
		global $wgUser, $wgOut, $wgRequest, $wgOpenIDOnly;

		$openid = $wgRequest->getVal( 'url' );
		$user = self::getUserFromUrl( $openid );

		if ( $user->getId() == 0 || $user->getId() != $wgUser->getId() ) {
			$wgOut->showErrorPage( 'openiderror', 'openidconvertothertext' );
			return;
		}

		$wgOut->setPageTitle( wfMsg( 'openiddelete' ) );

		# Check if the user is removing it's last OpenID url
		$urls = self::getUserOpenIDInformation( $wgUser );
		if ( count( $urls ) == 1 ) {
			if ( $wgUser->mPassword == '' ) {
				$wgOut->showErrorPage( 'openiderror', 'openiddeleteerrornopassword' );
				return;
			} elseif ( $wgOpenIDOnly ) {
				$wgOut->showErrorPage( 'openiderror', 'openiddeleteerroropenidonly' );
				return;
			}
		}

		if ( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ), $openid ) ) {
			$ret = self::removeUserUrl( $wgUser, $openid );
			$wgOut->addWikiMsg( $ret ? 'openiddelete-sucess' : 'openiddelete-error' );
			return;
		}

		$wgOut->addWikiMsg( 'openiddelete-text', $openid );

		$wgOut->addHtml(
			Xml::openElement( 'form', array( 'action' => $this->getTitle( 'Delete' )->getLocalUrl(), 'method' => 'post' ) ) .
			Xml::submitButton( wfMsg( 'openiddelete-button' ) ) . "\n" .
			Html::Hidden( 'url', $openid ) . "\n" .
			Html::Hidden( 'wpEditToken', $wgUser->editToken( $openid ) ) . "\n" .
			Xml::closeElement( 'form' )
		);
	}

	function finish() {
		global $wgUser, $wgOut;

		wfSuppressWarnings();
		$consumer = $this->getConsumer();
		$response = $consumer->complete( $this->scriptUrl( 'Finish' ) );
		wfRestoreWarnings();

		if ( is_null( $response ) ) {
			wfDebug( "OpenID: aborting in openid converter because the response was missing\n" );
			$wgOut->showErrorPage( 'openiderror', 'openiderrortext' );
			return;
		}

		switch ( $response->status ) {
		case Auth_OpenID_CANCEL:
			// This means the authentication was cancelled.
			$wgOut->showErrorPage( 'openidcancel', 'openidcanceltext' );
			break;
		case Auth_OpenID_FAILURE:
			wfDebug( "OpenID: error in convert: '" . $response->message . "'\n" );
			$wgOut->showErrorPage( 'openidfailure', 'openidfailuretext', array( $response->message ) );
			break;
		case Auth_OpenID_SUCCESS:
			// This means the authentication succeeded.
			$openid_url = $response->identity_url;

			if ( !$this->canLogin( $openid_url ) ) {
				$wgOut->showErrorPage( 'openidpermission', 'openidpermissiontext' );
				return;
			}

			if ( !isset( $openid_url ) ) {
				wfDebug( "OpenID: aborting in openid converter because the openid_url was missing\n" );
				$wgOut->showErrorPage( 'openiderror', 'openiderrortext' );
				return;
			}

			# We check again for dupes; this may be normalized or
			# reformatted by the server.

			$other = self::getUserFromUrl( $openid_url );

			if ( isset( $other ) ) {
				if ( $other->getId() == $wgUser->getID() ) {
					$wgOut->showErrorPage( 'openiderror', 'openidconvertyourstext' );
				} else {
					$wgOut->showErrorPage( 'openiderror', 'openidconvertothertext' );
				}
				return;
			}

			self::addUserUrl( $wgUser, $openid_url );

			$this->loginSetCookie( $openid_url );

			$wgOut->setPageTitle( wfMsg( 'openidconvertsuccess' ) );
			$wgOut->setRobotPolicy( 'noindex,nofollow' );
			$wgOut->setArticleRelated( false );
			$wgOut->addWikiMsg( 'openidconvertsuccesstext', $openid_url );
			$wgOut->returnToMain();
		}
	}
}
