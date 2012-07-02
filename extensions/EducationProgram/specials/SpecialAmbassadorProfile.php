<?php

/**
 * Abstract profile page for ambassadors.
 *
 * @since 0.1
 *
 * @file SpecialOAProfile.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
abstract class SpecialAmbassadorProfile extends FormSpecialPage {

	protected abstract function getClassName();

	/**
	 * Main method.
	 *
	 * @since 0.1
	 *
	 * @param string $subPage
	 */
	public function execute( $subPage ) {
		if ( $this->getRequest()->getSessionData( 'epprofilesaved' ) ) {
			$messageKey = $this->getMsgPrefix() . 'profile-saved';
			$this->getOutput()->addHTML(
				'<div class="successbox"><strong><p>' . wfMsgHtml( $messageKey ) . '</p></strong></div>'
					. '<hr style="display: block; clear: both; visibility: hidden;" />'
			);
			$this->getRequest()->setSessionData( 'epprofilesaved', false );
		}

		parent::execute( $subPage );

		$this->getOutput()->addModules( 'ep.ambprofile' );
	}

	protected function getForm() {
		$form = parent::getForm();
		$form->setSubmitTooltip( 'ep-form-save' );
		return $form;
	}

	protected function getMsgPrefix() {
		return strtolower( $this->getClassName() ) . '-';
	}

	/**
	 * (non-PHPdoc)
	 * @see FormSpecialPage::getFormFields()
	 * @return array
	 */
	protected function getFormFields() {
		$fields = array();

		$class = $this->getClassName();
		$ambassador = $class::newFromUser( $this->getUser() );

		$fields['bio'] = array(
			'type' => 'textarea',
			'label-message' => $this->getMsgPrefix() . 'profile-bio',
			'required' => true,
			'validation-callback' => function ( $value, array $alldata = null ) {
				return strlen( $value ) < 10 ? wfMsgExt( $this->getMsgPrefix() . 'profile-invalid-bio', 'parsemag', 10 ) : true;
			},
			'rows' => 10,
			'id' => 'wpTextbox1',
			'default' => $ambassador->getField( 'bio' ),
		);

//		$lang = $this->getLanguage();
//
//		$prefix = $this->getMsgPrefix();
		$fields['photo'] = array(
			'type' => 'text',
			'label-message' => $this->getMsgPrefix() . 'profile-photo',
//			'validation-callback' => function ( $value, array $alldata = null ) use ( $lang, $prefix ) {
//				if ( trim( $value ) === '' ) {
//					return true;
//				}
//
//				$domains = EPSettings::get( 'ambassadorPictureDomains' );
//
//				foreach ( $domains as $domain ) {
//					$pattern = '@^https?://(([a-z0-9]+)\.)?' . str_replace( '.', '\.', $domain ) . '/.*$@i';
//
//					if ( preg_match( $pattern, $value ) ) {
//						return true;
//					}
//				}
//
//				return wfMsgExt(
//					$prefix . 'profile-invalid-photo',
//					'parsemag',
//					$lang->listToText( $domains ),
//					count( $domains )
//				);
//			},
			'default' => $ambassador->getField( 'photo' ),
			'cssclass' => 'commons-input',
		);

		return $fields;
	}

	/**
	 * Gets called after the form is saved.
	 *
	 * @since 0.1
	 */
	public function onSuccess() {
		$this->getRequest()->setSessionData( 'epprofilesaved', true );
		$this->getOutput()->redirect( $this->getTitle()->getLocalURL() );
	}

	/**
	 * Process the form.  At this point we know that the user passes all the criteria in
	 * userCanExecute().
	 *
	 * @param array $data
	 *
	 * @return Bool|Array
	 */
	public function onSubmit( array $data ) {
		$class = $this->getClassName();
		$ambassador = $class::newFromUser( $this->getUser() );
		$ambassador->setFields( $data );
		return $ambassador->save() ? true : array();
	}

}