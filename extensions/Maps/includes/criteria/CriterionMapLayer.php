<?php

/**
 * Parameter criterion stating that the value must be a layer.
 * 
 * @since 0.7.2
 * 
 * @file CriterionmapLayer.php
 * @ingroup Maps
 * @ingroup Criteria
 * 
 * @author Jeroen De Dauw
 */
class CriterionMapLayer extends ItemParameterCriterion {
	
	protected $service;
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7
	 */
	public function __construct( $service ) {
		parent::__construct();
		
		$this->service = $service;
	}
	
	/**
	 * @see ItemParameterCriterion::validate
	 */	
	protected function doValidation( $value, Parameter $parameter, array $parameters ) {
		$title = Title::newFromText( $value, Maps_NS_LAYER );

		if ( $title->getNamespace() == Maps_NS_LAYER && $title->exists() ) {
			$layerPage = new MapsLayerPage( $title );
			return $layerPage->hasValidDefinition( $this->service );
		}
		
		return false;
	}	
	
	/**
	 * @see ItemParameterCriterion::getItemErrorMessage
	 */	
	protected function getItemErrorMessage( Parameter $parameter ) {
		return wfMsgExt( 'validation-error-invalid-layer', 'parsemag', $parameter->getOriginalName() );
	}
	
	/** 
	 * @see ItemParameterCriterion::getFullListErrorMessage
	 */	
	protected function getFullListErrorMessage( Parameter $parameter ) {
		return wfMsgExt( 'validation-error-invalid-layers', 'parsemag', $parameter->getOriginalName() );
	}		
	
}
