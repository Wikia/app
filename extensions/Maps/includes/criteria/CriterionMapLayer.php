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
 * @author Daniel Werner
 */
class CriterionMapLayer extends ItemParameterCriterion {

	/**
	 * @since 3.0
	 *
	 * @var string
	 */
	protected $groupNameSep;

	/**
	 * Constructor.
	 *
	 * @param string $groupNameSeparator Separator between layer group and the
	 *        layers name within the group.
	 *
	 * @since 0.7 (meaning of first param changed in 3.0)
	 */
	public function __construct( $groupNameSeparator = ';' ) {
		parent::__construct();
		
		$this->groupNameSep = $groupNameSeparator;
	}
	
	/**
	 * @see ItemParameterCriterion::validate
	 */
	protected function doValidation( $value, Parameter $parameter, array $parameters ) {

		$parts = explode( $this->groupNameSep, $value, 2 );
		$layerTitle = Title::newFromText( $parts[0], Maps_NS_LAYER );

		// if page with layer definition doesn't exist:
		if ( $layerTitle === null
			|| $layerTitle->getNamespace() !== Maps_NS_LAYER
			|| ! $layerTitle->exists()
		) {
			return false;
		}

		$layerName = count( $parts ) > 1 ? $parts[1] : null;

		$layerPage = new MapsLayerPage( $layerTitle );
		return $layerPage->hasUsableLayer( $layerName );
	}

	/**
	 * @see ItemParameterCriterion::getItemErrorMessage
	 */
	protected function getItemErrorMessage( Parameter $parameter ) {
		return wfMessage( 'validation-error-invalid-layer', $parameter->getOriginalName() )->parse();
	}
	
	/**
	 * @see ItemParameterCriterion::getFullListErrorMessage
	 */
	protected function getFullListErrorMessage( Parameter $parameter ) {
		return wfMessage( 'validation-error-invalid-layers', $parameter->getOriginalName() )->parse();
	}
	
}
