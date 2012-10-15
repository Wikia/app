<?php

/**
 * Profile page for online ambassadors.
 *
 * @since 0.1
 *
 * @file SpecialOAProfile.php
 * @ingroup EducationProgram
 *
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class SpecialOAProfile extends SpecialAmbassadorProfile {

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'OnlineAmbassadorProfile', 'ep-online', false );
	}

	/**
	 * (non-PHPdoc)
	 * @see FormSpecialPage::getFormFields()
	 * @return array
	 */
	protected function getFormFields() {
		$fields = parent::getFormFields();



		return $fields;
	}

	/**
	 * (non-PHPdoc)
	 * @see FormSpecialPage::getClassName()
	 */
	protected function getClassName() {
		return 'EPOA';
	}

}