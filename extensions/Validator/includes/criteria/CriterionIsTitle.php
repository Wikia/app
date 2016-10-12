<?php

/**
 * Parameter criterion stating that the value must be a Title valid within the wiki.
 * Optionally the Title also has to be an existing one within the wiki.
 *
 * @deprecated since 0.5, removal in 0.7
 * @since 0.4.14
 * 
 * @file CriterionIsTitle.php
 * @ingroup Validator
 * @ingroup Criteria
 * 
 * @author Daniel Werner
 */
class CriterionIsTitle extends ItemParameterCriterion {
	
	protected $hasToExist;
	
	/**
	 * Constructor.
	 * 
	 * @param bool $hasToExist if set to true, the title has to be an existing one. If false, the name
	 *        is just checked for validity within the wikis regulations.
	 * 
	 * @since 0.4.14
	 */
	public function __construct( $hasToExist = false ) {
		$this->hasToExist = $hasToExist;
		
		parent::__construct();
	}
	
	/**
	 * @see ItemParameterCriterion::validate
	 */	
	protected function doValidation( $value, Parameter $parameter, array $parameters ) {
		// create wiki Title from text input:
		$title = Title::newFromText( trim( $value ) );
		
		if( $title === null ) {
			return false;
		}
		
		if( $this->hasToExist ) {
			return $title->isKnown();
		}
		
		return true;
	}
	
	/**
	 * @see ItemParameterCriterion::getItemErrorMessage
	 */	
	protected function getItemErrorMessage( Parameter $parameter ) {
		$msg = 'validator_error_must_be_' . (
				$this->hasToExist
				? 'existing_'
				: ''
		) . 'title';
		return wfMsgExt( $msg, 'parsemag', $parameter->getOriginalName() );
	}
	
	/**
	 * @see ItemParameterCriterion::getFullListErrorMessage
	 */	
	protected function getFullListErrorMessage( Parameter $parameter ) {
		$msg = 'validator_list_error_must_be_' . (
				$this->hasToExist
				? 'existing_'
				: ''
		) . 'title';
		return wfMsgExt( $msg, 'parsemag', $parameter->getOriginalName() );
	}		
	
}
