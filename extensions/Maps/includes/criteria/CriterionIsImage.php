<?php

/**
 * Parameter criterion stating that the value must be pointer to an image.
 * 
 * @since 0.7.1
 * 
 * @file CriterionIsImage.php
 * @ingroup Maps
 * @ingroup Criteria
 * 
 * @author Jeroen De Dauw
 */
class CriterionIsImage extends ItemParameterCriterion {
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7
	 */
	public function __construct() {
		parent::__construct();
	}
	
	/**
	 * @see ItemParameterCriterion::validate
	 */	
	protected function doValidation( $value, Parameter $parameter, array $parameters ) {
		global $egMapsAllowExternalImages;
		
		if ( $egMapsAllowExternalImages ) {
			// Some more checking here would be nice.
			return true;
		}
		
		$title = Title::newFromText( $image, NS_FILE );
		return !is_null( $title ) && $title->getNamespace() == NS_FILE && $title->exists();
	}
	
	/**
	 * @see ItemParameterCriterion::getItemErrorMessage
	 */	
	protected function getItemErrorMessage( Parameter $parameter ) {
		return wfMsgExt( 'validation-error-invalid-image', 'parsemag', $parameter->getOriginalName() );
	}
	
	/**
	 * @see ItemParameterCriterion::getFullListErrorMessage
	 */	
	protected function getFullListErrorMessage( Parameter $parameter ) {
		global $wgLang;
		return wfMsgExt( 'validation-error-invalid-images', 'parsemag', $parameter->getOriginalName() );
	}	
	
}