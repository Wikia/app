<?php

/**
 * Action to edit an org.
 *
 * @since 0.1
 *
 * @file EditOrgAction.php
 * @ingroup EducationProgram
 * @ingroup Action
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class EditOrgAction extends EPEditAction {
	
	/**
	 * (non-PHPdoc)
	 * @see Action::getName()
	 */
	public function getName() {
		return 'editorg';
	}

	/**
	 * (non-PHPdoc)
	 * @see Action::getDescription()
	 */
	protected function getDescription() {
		return wfMsgHtml( $this->isNew() ? 'ep-addorg' : 'ep-editorg' );
	}

	/**
	 * (non-PHPdoc)
	 * @see EPEditAction::getItemClass()
	 */
	protected function getItemClass() {
		return 'EPOrg';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Action::getRestriction()
	 */
	public function getRestriction() {
		return 'ep-org';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see EPEditAction::getFormFields()
	 * @return array
	 */
	protected function getFormFields() {
		$fields = parent::getFormFields();

		$fields['name'] = array (
			'type' => 'text',
			'label-message' => 'educationprogram-org-edit-name',
			'maxlength' => 255,
			'required' => true,
			'validation-callback' => function ( $value, array $alldata = null ) {
				return strlen( $value ) < 2 ? wfMsg( 'educationprogram-org-invalid-name' ) : true;
			} ,
		);

		$fields['city'] = array (
			'type' => 'text',
			'label-message' => 'educationprogram-org-edit-city',
			'required' => true,
			'validation-callback' => function ( $value, array $alldata = null ) {
				return strlen( $value ) < 2 ? wfMsg( 'educationprogram-org-invalid-city' ) : true;
			} ,
		);

		$fields['country'] = array (
			'type' => 'select',
			'label-message' => 'educationprogram-org-edit-country',
			'maxlength' => 255,
			'required' => true,
			'options' => EPUtils::getCountryOptions( $this->getLanguage()->getCode() ),
			'validation-callback' => array( $this, 'countryIsValid' ),
		);

		return $this->processFormFields( $fields );
	}

	/**
	 * Returns true if the country value is valid or an error message if it's not.
	 *
	 * @since 0.1
	 *
	 * @param string $value
	 * @param array $alldata
	 *
	 * @return string|true
	 */
	public function countryIsValid( $value, array $alldata = null ) {
		$countries = array_keys( CountryNames::getNames( $this->getLanguage()->getCode() ) );

//		if ( $this->isNew() ) {
//			array_unshift( $countries, '' );
//		}

		return in_array( $value, $countries ) ? true : wfMsg( 'educationprogram-org-invalid-country' );
	}
	
}