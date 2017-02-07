<?php

/**
 * Class for describing image layers.
 *
 * @since 0.7.2
 * 
 * @file Maps_ImageLayer.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Daniel Werner
 */
class MapsImageLayer extends MapsLayer {

	/**
	 * Registers the layer.
	 *
	 * @since 0.7.2
	 */
	public static function register() {
		MapsLayerTypes::registerLayerType( 'image', __CLASS__, 'openlayers' );
		return true;
	}

	/**
	 * @see MapsLayer::getParameterDefinitions
	 *
	 * @since 0.7.2
	 *
	 * @return array
	 */
	protected function getParameterDefinitions() {
		$params = parent::getParameterDefinitions();

		// map extent for extents bound object:
		$params['topextent'] = array(
			'type' => 'float',
			'aliases' => array( 'upperbound', 'topbound' ),
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
		);

		$params['rightextent'] = array(
			'type' => 'float',
			'aliases' => array( 'rightbound' ),
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
		);

		$params['bottomextent'] = array(
			'type' => 'float',
			'aliases' => array( 'lowerbound', 'bottombound' ),
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
		);

		$params['leftextent'] = array(
			'type' => 'float',
			'aliases' => array( 'leftbound' ),
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
		);

		// image-source information:
		$params['source'] = array(
			// TODO-customMaps: addCriteria( new CriterionIsImage() )
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
			'post-format' => function( $source ) {
				$imageUrl = MapsMapper::getFileUrl( $source );

				global $egMapsAllowExternalImages;
				if( $imageUrl === '' && $egMapsAllowExternalImages ) {
					return $source;
				}
				return $imageUrl;
			}
		);

		$params['width'] = array(
			'type' => 'float',
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
		);

		$params['height'] = array(
			'type' => 'float',
			'message' => 'maps-displaymap-par-coordinates', // TODO-customMaps: create a message
		);

		return $params;
	}

	/**
	 * @see MapsLayer::getPropertyHtmlRepresentation
	 *
	 * @since 3.0
	 *
	 * @return array
	 */
	protected function getPropertyHtmlRepresentation( $name, &$parser ) {
		$value = $this->properties[ $name ];

		switch( $name ) {
			case 'source':
				$value = $this->originalPropertyValues['source']; // get original, non-modified value

				$title = Title::newFromText( $value, NS_FILE );

				// if title has invalid characters or doesn't exist and has url-style
				if( $title === null
					|| ( !$title->exists() && preg_match( '|^.+\://.+\..+$|', $value ) )
				) {
					// url link:
					$value = $parser->recursiveTagParse( "[$value $value]" );
				} else {
					// wikilink (can be red link to non-existant file):
					$imgName = $title->getPrefixedText();
					$value = $parser->recursiveTagParse( "[[$imgName|thumb|[[:$imgName]]|left]]" );
				}
				return $value; // html already

			default:
				// if we don't have any special handling here, leave it to base class:
				return parent::getPropertyHtmlRepresentation( $name, $parser );
		}
		return htmlspecialchars( $value );;
	}

	/**
	 * @see MapsLayer::doPropertiesHtmlTransform
	 *
	 * @since 3.0
	 *
	 * @return array
	 */
	protected function doPropertiesHtmlTransform( &$properties ) {
		parent::doPropertiesHtmlTransform( $properties );

		$sp = '&#x202F;'; // non-breaking thin space

		// image-size:
		$properties['image-size'] = "<b>width:</b> {$properties['width']}{$sp}pixel, <b>height:</b> {$properties['height']}{$sp}pixel";
		unset( $properties['width'], $properties['height'] );

		// extent:
		$unit = $properties['units'];
		$properties['extent'] =
			"<b>left:</b> {$properties['leftextent']}{$sp}$unit, " .
			"<b>bottom:</b> {$properties['bottomextent']}{$sp}$unit, " .
			"<b>right:</b> {$properties['rightextent']}{$sp}$unit, " .
			"<b>top:</b> {$properties['topextent']}{$sp}$unit";
		unset( $properties['leftextent'], $properties['bottomextent'], $properties['rightextent'], $properties['topextent'] );
	}

	/**
	 * @see MapsLayer::getJavaScriptDefinition
	 * 
	 * @since 0.7.2
	 * 
	 * @return string
	 */
	public function getJavaScriptDefinition() {
		$this->validate();

		// do image layer options:

		$options = array(
			'isImage' => true,
			'units' => $this->properties['units'],
		);

		if( $this->properties['zoomlevels'] !== false ) {
			$options['numZoomLevels'] = $this->properties['zoomlevels'];
		}
		if( $this->properties['minscale'] !== false ) {
			$options['minScale'] = $this->properties['minscale'];
		}
		if( $this->properties['maxscale'] !== false ) {
			$options['maxScale'] = $this->properties['maxscale'];
		}
		
		$options = Xml::encodeJsVar( (object)$options ); //js-encode all options );

		// for non-option params, get JavaScript-encoded config values:
		foreach( $this->properties as $name => $value ) {
			${ $name } = MapsMapper::encodeJsVar( $value );
		}

		return <<<JavaScript
new OpenLayers.Layer.Image(
	$label,
	$source,
	new OpenLayers.Bounds($leftextent, $bottomextent, $rightextent, $topextent),
	new OpenLayers.Size($width, $height),
	$options
);
JavaScript;
		die();
	}

}
