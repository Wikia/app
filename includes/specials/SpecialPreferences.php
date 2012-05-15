<?php

class SpecialPreferences extends SpecialPage {
	function __construct() {
		parent::__construct( 'Preferences' );
	}

	function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest;
		
		$this->setHeaders();
		$this->outputHeader();
		$wgOut->disallowUserJs();  # Prevent hijacked user scripts from sniffing passwords etc.

		if ( $wgUser->isAnon() ) {
			$wgOut->showErrorPage( 'prefsnologin', 'prefsnologintext', array( $this->getTitle()->getPrefixedDBkey() ) );
			return;
		}
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		if ( $par == 'reset' ) {
			$this->showResetForm();
			return;
		}

		$wgOut->addScriptFile( 'prefs.js' );

		/* Wikia change begin - @author: macbre */
		/* Enable custom notifications handling */
		wfRunHooks('SpecialPreferencesOnRender', array(&$this));
		/* Wikia change end */

		if ( $wgRequest->getCheck( 'success' ) ) {
			$wgOut->wrapWikiMsg(
				'<div class="successbox"><strong>$1</strong></div><div id="mw-pref-clear"></div>',
				'savedprefs'
			);
		}


		if ( $wgRequest->getCheck( 'eauth' ) ) {
			$wgOut->wrapWikiMsg( "<div class='error' style='clear: both;'>\n$1</div>",
									'eauthentsent', $wgUser->getName() );
		}

		$htmlForm = Preferences::getFormObject( $wgUser );
		$htmlForm->setSubmitCallback( array( 'Preferences', 'tryUISubmit' ) );

		$htmlForm->show();
	}

	function showResetForm() {
		global $wgOut;

		$wgOut->addWikiMsg( 'prefs-reset-intro' );

		$htmlForm = new HTMLForm( array(), 'prefs-restore' );

		$htmlForm->setSubmitText( wfMsg( 'restoreprefs' ) );
		$htmlForm->setTitle( $this->getTitle( 'reset' ) );
		/* Wikia change begin - @author: Marcin, #BugId: 19056 */
		$htmlForm->setSubmitCallback( array( __CLASS__, 'submitResetWikia' ) );
		/* Wikia change end */
		$htmlForm->suppressReset();

		$htmlForm->show();
	}

	/* Wikia change begin - @author: Marcin, #BugId: 19056 */
	static function submitResetWikia() {
		global $wgUser, $wgOut, $wgCityId;
		$userIndentityObject = new UserIdentityBox(F::app(), $wgUser, 0);
		$mastheadOptions = $userIndentityObject->optionsArray;
		unset($mastheadOptions['gender'], $mastheadOptions['birthday']);
		$mastheadOptions[] = UserIdentityBox::USER_PROPERTIES_PREFIX.'gender';
		$mastheadOptions[] = UserIdentityBox::USER_PROPERTIES_PREFIX.'birthday';
		$mastheadOptions[] = UserIdentityBox::USER_EVER_EDITED_MASTHEAD;
		$mastheadOptions[] = UserIdentityBox::USER_EDITED_MASTHEAD_PROPERTY.$wgCityId;
		foreach ($mastheadOptions as $optionName) {
			$tempOptions[$optionName] = $wgUser->getOption($optionName);
		}
		$wgUser->resetOptions();
		foreach ($tempOptions as $optionName => $optionValue) {
			$wgUser->setOption($optionName, $optionValue);
		}
		$wgUser->saveSettings();
		$url = SpecialPage::getTitleFor( 'Preferences' )->getFullURL( 'success' );
		$wgOut->redirect( $url );
		return true;
	}
	/* Wikia change end */

	static function submitReset( $formData ) {
		global $wgUser, $wgOut;
		$wgUser->resetOptions();
		$wgUser->saveSettings();

		$url = SpecialPage::getTitleFor( 'Preferences' )->getFullURL( 'success' );

		$wgOut->redirect( $url );

		return true;
	}
}
