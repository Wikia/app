<?php
/* Shamelessly copied and modified from /includes/specials/SpecialPreferences.php v1.16.1 */
class EditUser extends SpecialPage {

	function __construct() {
		parent::__construct('EditUser', 'edituser');
	}

	function execute( $par ) {
		$user = $this->getUser();
		$out = $this->getOutput();

		if( !$user->isAllowed( 'edituser' ) ) {
			$out->permissionRequired( 'edituser' );
			return false;
		}

		$this->setHeaders();

		$request = $this->getRequest();
		$this->target = ( isset( $par ) ) ? $par : $request->getText( 'username', '' );
		if( $this->target === '' ) {
			$out->addHtml( $this->makeSearchForm() );
			return;
		}
		$targetuser = User::NewFromName( $this->target );
		if( $targetuser->getID() == 0 ) {
			$out->addWikiMsg( 'edituser-nouser', htmlspecialchars( $this->target ) );
			return;
		}
		$this->targetuser = $targetuser;
		#Allow editing self via this interface
		if( $targetuser->isAllowed( 'edituser-exempt' ) && $targetuser->getName() != $user->getName() ) {
			$out->addWikiMsg( 'edituser-exempt', $targetuser->getName() );
			return;
		}

		$this->setHeaders();
		$this->outputHeader();
		$out->disallowUserJs();  # Prevent hijacked user scripts from sniffing passwords etc.

		if ( wfReadOnly() ) {
			$out->readOnlyPage();
			return;
		}
		
		if ( $request->getCheck( 'reset' ) ) {
			$this->showResetForm();
			return;
		}

		$out->addModules( 'mediawiki.special.preferences' );

		//$this->loadGlobals( $this->target );
		$out->addHtml( $this->makeSearchForm() . '<br />' );
		#End EditUser additions

		if ( $request->getCheck( 'success' ) ) {
			$out->wrapWikiMsg(
				"<div class=\"successbox\"><strong>\n$1\n</strong></div><div id=\"mw-pref-clear\"></div>",
				'savedprefs'
			);
		}
		
		if ( $request->getCheck( 'eauth' ) ) {
			$out->wrapWikiMsg( "<div class='error' style='clear: both;'>\n$1\n</div>",
									'eauthentsent', $this->target );
		}

		$htmlForm = Preferences::getFormObject( $targetuser, $this->getContext(),
			'EditUserPreferencesForm', array( 'password' ) );
		$htmlForm->setSubmitCallback( 'Preferences::tryUISubmit' );
		$htmlForm->addHiddenField( 'username', $this->target );

		$htmlForm->show();
	}

	function showResetForm() {
		$this->getOutput()->addWikiMsg( 'prefs-reset-intro' );

		$htmlForm = new HTMLForm( array(), $this->getContext(), 'prefs-restore' );

		$htmlForm->setSubmitText( wfMsg( 'restoreprefs' ) );
		$htmlForm->addHiddenField( 'username', $this->target );
		$htmlForm->addHiddenField( 'reset' , '1' );
		$htmlForm->setSubmitCallback( array( $this, 'submitReset' ) );
		$htmlForm->suppressReset();

		$htmlForm->show();
	}

	function submitReset( $formData ) {
		$this->targetuser->resetOptions();
		$this->targetuser->saveSettings();

		$url = $this->getTitle()->getFullURL( array( 'success' => 1, 'username'=>$this->target ) );

		$this->getOutput()->redirect( $url );

		return true;
	}

	function makeSearchForm() {
		global $wgScript;

		$fields = array();
		$fields['edituser-username'] = Html::input( 'username', $this->target );

		$thisTitle = $this->getTitle();
		$form = Html::rawElement( 'form', array( 'method' => 'get', 'action' => $wgScript ),
			Html::hidden( 'title', $this->getTitle()->getPrefixedDBkey() ) .
			Xml::buildForm( $fields, 'edituser-dosearch' )
		);
		return $form;
	}
}

class EditUserPreferencesForm extends PreferencesForm {
	public function getExtraSuccessRedirectParameters() {
		return array( 'username' => $this->getModifiedUser()->getName() );
	}

	function getButtons() {
		$html = HTMLForm::getButtons();

		$url = SpecialPage::getTitleFor( 'EditUser' )->getFullURL( array( 'reset' => 1, 'username' => $this->getModifiedUser()->getName() ) );

		$html .= "\n" . Xml::element('a', array( 'href'=> $url ), wfMsgHtml( 'restoreprefs' ) );

		$html = Xml::tags( 'div', array( 'class' => 'mw-prefs-buttons' ), $html );

		return $html;
	}
}
