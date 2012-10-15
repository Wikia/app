<?php
/**
 * SpecialPage for StyleGuideDemo extension
 * 
 * @file
 * @ingroup Extensions
 */

class SpecialStyleGuideDemo extends SpecialPage {

	/* Methods */

	public function __construct() {
		parent::__construct( 'StyleGuideDemo' );
	}

	public function execute( $par ) {
		global $wgUser, $wgOut;

		// Loads styles when javascript is disabled as well
		$wgOut->addModuleStyles( 'ext.styleguidedemo.css' );

		// Enhancements
		$wgOut->addModules( 'ext.styleguidedemo.js' );

		$this->setHeaders();

		// Form One
		$wgOut->wrapWikiMsg( "<h2 class=\"mw-specialpagesgroup\" id=\"mw-styleguidedemo-createform\">$1</h2>\n", 'styleguidedemo-head-createform' );

		$formOne = array(
			'Username' => array(
				'label-message' => 'styleguidedemo-username',
				'required' => true,
				'type' => 'text',
				'help-message' => array( 'styleguidedemo-username-help', wfMsg( 'styleguidedemo-username-infopage' ) ),
				'hint-message' => 'styleguidedemo-username-hint',
				'placeholder' => 'John Doe',
			),
			'Password' => array(
				'label-message' => 'styleguidedemo-password',
				'required' => true,
				'type' => 'password',
				'help-message' => array( 'styleguidedemo-password-help', wfMsg( 'styleguidedemo-password-infopage' ) ),
			),
			'ConfirmPassword' => array(
				'label-message' => 'styleguidedemo-confirmpassword',
				'required' => true,
				'type' => 'password',
				'help-message' => 'styleguidedemo-confirmpassword-help',
			),
			'Email' => array(
				'label-message' => 'styleguidedemo-email',
				'type' => 'text',
				'help-message' => array( 'styleguidedemo-email-help', wfMsg( 'styleguidedemo-email-infopage' ) ),
				'hint-message' => 'styleguidedemo-email-hint',
				'placeholder' => wfMsg( 'styleguidedemo-email-placeholder' ),
			),
		);
		$form = new HTMLStyleForm( $formOne );
		$form->setTitle( $wgOut->getTitle() );
		$form->setSubmitID( 'wpCreateaccount' );
		$form->setSubmitName( 'wpCreateaccount' );
		$form->setSubmitText( wfMsg( 'createaccount' ) );
		$form->show();


	}

	/* Protected Methods */

}
