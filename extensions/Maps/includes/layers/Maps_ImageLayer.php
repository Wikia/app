<?php

/**
 * Class for describing image layers.
 *
 * @since 0.7.2
 * 
 * @file Maps_ImageLayer.php
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
 */
class MapsImageLayer extends MapsLayer {

	/**
	 * Registeres the layer.
	 * 
	 * @since 0.7.2
	 */
	public static function register() {
		MapsLayers::registerLayer( 'image', __CLASS__, 'openlayers' );
		return true;
	}		
	
	/**
	 * @see MapsLayer::getParameterDefinitions
	 * 
	 * @since 0.7.2
	 * 
	 * @return array
	 */
	protected function getParameterDefinitions( array $params ) {
		$params[] = new Parameter( 'lowerbound', Parameter::TYPE_FLOAT );
		$params[] = new Parameter( 'upperbound', Parameter::TYPE_FLOAT );
		$params[] = new Parameter( 'leftbound', Parameter::TYPE_FLOAT );
		$params[] = new Parameter( 'rightbound', Parameter::TYPE_FLOAT );
		$params[] = new Parameter( 'width', Parameter::TYPE_FLOAT );
		$params[] = new Parameter( 'height', Parameter::TYPE_FLOAT );
		
		$params[] = new Parameter( 'zoomlevels', Parameter::TYPE_INTEGER, false );
		
		$params['label'] = new Parameter( 'label' );
		
		$params['source'] = new Parameter( 'source' );
		$params['source']->addCriteria( new CriterionIsImage() );
		$params['source']->addManipulations( new MapsParamFile() );
		
		return $params;
	}

	/**
	 * @see MapsLayer::getJavaScriptDefinition
	 * 
	 * @since 0.7.2
	 * 
	 * @return string
	 */
	public function getJavaScriptDefinition() {
		foreach ( $this->properties as $name => $value ) {
			${ $name } = MapsMapper::encodeJsVar( $value );
		}

		$options = array( 'isImage' => true );
		
		if ( $zoomlevels !== false ) {
			$options['numZoomLevels'] = $zoomlevels;
		}
		
		$options = Xml::encodeJsVar( (object)$options );
		
		return <<<EOT
	new OpenLayers.Layer.Image(
		$label,
		$source,
		new OpenLayers.Bounds($leftbound, $lowerbound, $rightbound, $upperbound),
		new OpenLayers.Size($width, $height),
		{$options}
	)
EOT;
	}	
	
}