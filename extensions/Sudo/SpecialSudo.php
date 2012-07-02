<?php
/**
 * Sudo
 *
 * @file
 * @ingroup Extensions
 * @author Daniel Friesen (http://mediawiki.org/wiki/User:Dantman) <mediawiki@danielfriesen.name>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is an extension to the MediaWiki package and cannot be run standalone.' );
}

class SpecialSudo extends SpecialPage {
	protected $mode, $skin, $target, $reason, $errors;

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'Sudo', 'sudo' );
		
	}

	/**
	 * Show the special page
	 *
	 * @param $par String: name of the user to sudo into
	 */
	public function execute( $par ) {
		global $wgOut, $wgRequest, $wgUser;

		$this->mode = $wgRequest->getText( 'mode' );
		if( $this->mode == 'success' ) {
			return $this->showSuccessPage();
		}
		if( $this->mode == 'unsudo' ) {
			return $this->showUnsudoPage();
		}

		// Check that the user is allowed to access this special page...
		if( !$wgUser->isAllowed( 'sudo' ) ) {
			$wgOut->permissionRequired( 'sudo' );
			return;
		}

		// ...and that the user isn't blocked
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		// ...and that the database is not in read-only mode.
		if( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		// Set page title and other stuff
		$this->setHeaders();

		$this->skin   = $wgUser->getSkin();
		$this->target = $wgRequest->getText( 'target', $par );
		$this->reason = $wgRequest->getText( 'reason', '' );
		$this->errors = array();

		$this->showSudoForm();
		if( $this->target != '' && $wgRequest->wasPosted() ) {
			$this->doSudo();
		}
		$this->showErrors();
	}

	function showSuccessPage() {
		global $wgOut, $wgUser;
		if( !isset( $_SESSION['wsSudoId'] ) || $_SESSION['wsSudoId'] < 0 ) {
			$this->showError( 'sudo-error-nosudo' );
		} else {
			$this->setHeaders();
			$s = $wgUser->getSkin();
			$suUser = User::newFromId( $_SESSION['wsSudoId'] );
			$wgOut->addHTML( wfMsgExt( 'sudo-success', array( 'parse', 'replaceafter' ),
					$s->makeLinkObj( $suUser->getUserPage(), htmlspecialchars( $suUser->getName() ) ),
					$s->makeLinkObj( $wgUser->getUserPage(), htmlspecialchars( $wgUser->getName() ) ) )
			);
		}
	}

	function showUnsudoPage() {
		global $wgOut, $wgUser, $wgRequest;
		if( !isset( $_SESSION['wsSudoId'] ) || $_SESSION['wsSudoId'] < 0 ) {
			$this->showError( 'sudo-error-nosudo' );
		} else {
			$suUser = User::newFromId( $_SESSION['wsSudoId'] );
			if( $wgRequest->wasPosted() ) {
				unset( $_SESSION['wsSudoId'] );
				$suUser->setCookies();
				$wgOut->redirect( $this->getTitle()->getFullURL() );
				return;
			}
			$this->setHeaders();
			$wgOut->setPageTitle( wfMsg( 'unsudo' ) );
			$s = $wgUser->getSkin();

			$wgOut->addHTML(
				Xml::openElement( 'form', array( 'method' => 'post',
					'action' => $this->getTitle()->getFullURL( 'mode=unsudo' ) ) ) .
				Html::Hidden( 'title', $this->getTitle()->getPrefixedText() )
			);
			$wgOut->addHTML(
				wfMsgExt( 'sudo-unsudo', array( 'parse', 'replaceafter' ),
					$s->makeLinkObj( $suUser->getUserPage(), htmlspecialchars( $suUser->getName() ) ),
					$s->makeLinkObj( $wgUser->getUserPage(), htmlspecialchars( $wgUser->getName() ) )
				) .
				Xml::submitButton( wfMsg( 'sudo-unsudo-submit' ) ) .
				Xml::closeElement( 'form' )
			);
		}
	}

	function showSudoForm() {
		global $wgOut;
		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'method' => 'post',
				'action' => $this->getTitle()->getLocalURL() ) ) .
			Html::Hidden( 'title', $this->getTitle()->getPrefixedText() ) .
			Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', array(), wfMsg( 'sudo-form' ) ) .
			Xml::inputLabel( wfMsg( 'sudo-user' ), 'target', 'sudo-user', 20, $this->target ) . ' ' .
			Xml::inputLabel( wfMsg( 'sudo-reason' ), 'reason', 'sudo-reason', 45, $this->reason ) . ' ' .
			Xml::submitButton( wfMsg( 'sudo-submit' ) ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' ) . "\n"
		);
	}

	function addError( $error = '' ) {
		$this->errors[] = $error;
		return;
	}

	function showError( $error ) {
		global $wgOut;
		$wgOut->addHTML( Xml::openElement( 'div', array( 'class' => 'sudo-error' ) ) );
		$wgOut->addWikiMsg( 'sudo-error', wfMsg( $error ) );
		$wgOut->addHTML( Xml::closeElement( 'div' ) );
	}

	function showErrors() {
		foreach( $this->errors as $error ) {
			$this->showError( $error );
		}
	}

	function doSudo() {
		global $wgOut, $wgUser;

		$u = User::newFromName( $this->target );
		if( is_null( $u ) ) {
			return $this->addError( 'sudo-error-sudo-invaliduser' );
		}
		if( User::isIP( $u->getName() ) ) {
			return $this->addError( 'sudo-error-ip' );
		}
		if( $u->isAnon() ) {
			return $this->addError( 'sudo-error-sudo-nonexistent' );
		}
		if( $u->getName() === $wgUser->getName() ) {
			return $this->addError( 'sudo-error-sudo-self' );
		}

		$s = $wgUser->getSkin();
		$log = new LogPage( 'sudo' );
		$log->addEntry( 'sudo', $wgUser->getUserPage(), $this->reason,
			array( $s->makeLinkObj( $u->getUserPage(), $u->getName() ) ) );

		if( !isset( $_SESSION['wsSudoId'] ) || $_SESSION['wsSudoId'] < 0 ) {
			$_SESSION['wsSudoId'] = $wgUser->getId();
		}
		$u->setCookies();

		$wgOut->redirect( $this->getTitle()->getFullURL( 'mode=success' ) );
	}
}
