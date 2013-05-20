<?php

/**
 * Class for describing KML layers.
 *
 * @since 0.7.2
 * 
 * @file Maps_KMLLayer.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsKMLLayer extends MapsLayer {

	/**
	 * Registeres the layer.
	 * 
	 * @since 0.7.2
	 */
	public static function register() {
		MapsLayers::registerLayer( 'kml', __CLASS__, 'openlayers' );
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
		$params['label'] = new Parameter( 'label' );
		
		$params['source'] = new Parameter( 'source' );
		$params['source']->addCriteria( new CriterionIsImage() );
		$params['source']->addManipulations( new MapsParamFile() );
		
		$params[] = new Parameter( 'maxdepth', Parameter::TYPE_INTEGER, 2 );
		
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

		$options = array(
			'extractStyles' => true,
			'extractAttributes' => true,
			'maxDepth' => $maxdepth
		);
		
		$options = Xml::encodeJsVar( (object)$options );
		
		return <<<EOT
	new OpenLayers.Layer.GML(
		$label,
		$source,
		{
			format: OpenLayers.Format.KML, 
			formatOptions: {$options}
		}
	)
EOT;
	}	
	
}