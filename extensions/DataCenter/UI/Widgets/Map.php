<?php

/**
 * UI Class for DataCenter extension
 *
 * @file
 * @ingroup Extensions
 */

class DataCenterWidgetMap extends DataCenterWidget {

	/* Private Static Members */

	private static $defaultParameters = array(
		/**
		 * XML ID attribute of widget
		 * @datatype	string
		 */
		'id' => 'map',
		/**
		 * CSS class of widget
		 * @datatype	string
		 */
		'class' => 'widget-map',
		/**
		 * Data Sources
		 * @datatype	array of DataCenterAsset
		 */
		'locations' => null,
		/**
		 * Data Source
		 * @datatype	DataCenterAsset
		 */
		'location' => null,
		/**
		 * CSS inline-styled width of widget
		 * @datatype	scalar
		 */
		'width' => '100%',
		/**
		 * CSS inline-styled height of widget
		 * @datatype	scalar
		 */
		'height' => '400px',
	);

	/* Static Functions */

	public static function render(
		array $parameters
	) {
		global $egDataCenterGoogleMapsAPIKey;
		DataCenterUI::addScript(
			'http://maps.google.com/maps?file=api&v=2&key=' .
			$egDataCenterGoogleMapsAPIKey
		);
		// Sets defaults
		$parameters = array_merge( self::$defaultParameters, $parameters );
		// Begins widget
		$xmlOutput = parent::begin( $parameters['class'] );
		// Checks if width was given as an integer
		if ( is_int( $parameters['width'] ) ) {
			// Converts width to CSS pixel definition
			$parameters['width'] .= 'px';
		}
		// Checks if height was given as an integer
		if ( is_int( $parameters['height'] ) ) {
			// Converts height to CSS pixel definition
			$parameters['height'] .= 'px';
		}
		// Build CSS style for XML element
		$style = "width:{$parameters['width']};height:{$parameters['height']};";
		// Adds XML element
		$xmlOutput .= DataCenterXML::div(
			array( 'id' => $parameters['id'], 'style' => $style ), ' '
		);
		// Checks if multiple locations were given
		if ( $parameters['locations'] ) {
			// Builds script to add setup job to renderer
			$jsOutput = sprintf(
				"dataCenter.renderer.addJob( 'map', %s, %s );",
				DataCenterJs::toScalar( $parameters['id'] ),
				self::addMarkersJsFunction( $parameters )
			);
		// Alternatively checks if a single location was given
		} else if ( $parameters['location'] ) {
			// Builds script to add setup job to renderer
			$jsOutput = sprintf(
				"dataCenter.renderer.addJob( 'map', %s, %s );",
				DataCenterJS::toScalar( $parameters['id'] ),
				self::showPositionJsFunction( $parameters )
			);
		} else {
			// Adds an empty job to the render queue so the map gets rendered
			$jsOutput = sprintf(
				"dataCenter.renderer.addJob( 'map', %s, %s );",
				DataCenterJS::toScalar( $parameters['id'] ),
				'function( map ) { return true; }'
			);
		}
		$xmlOutput .= DataCenterXml::script( $jsOutput );
		// Ends widget
		$xmlOutput .= parent::end();
		// Returns XML
		return $xmlOutput;
	}

	/* Private Funtions */

	private static function markerOptions(
		array $parameters,
		$location
	) {
		// Begins window
		$xmlOutput = DataCenterXml::open( 'div', array( 'class' => 'window' ) );
		// Adds heading
		$xmlOutput .= DataCenterXml::div(
			array( 'class' => 'heading' ),
			DataCenterXml::link(
				$location->get( 'name' ),
				array(
					'page' => 'facilities',
					'type' => 'location',
					'action' => 'view',
					'id' => $location->getId(),
				)
			)
		);
		// Gets number of spaces in location
		$numSpaces = DataCenterDB::numSpaces(
			DataCenterDB::buildCondition(
				'facility', 'space', 'location', $location->getId()
			)
		);
		// Adds body
		$xmlOutput .= DataCenterXml::div(
			array( 'class' => 'body' ),
			DataCenterXml::div(
				array( 'class' => 'region' ),
				$location->get( 'region' )
			) .
			DataCenterXml::div(
				array( 'class' => 'spaces' ),
				DataCenterUI::message( 'label', 'num-spaces', $numSpaces )
			)
		);
		// Ends window
		$xmlOutput .= DataCenterXml::close( 'div' );
		// Returns JavaScript object of options
		return DataCenterJs::toObject( array( 'content' => $xmlOutput ) );
	}

	private static function showPositionJsFunction(
		array $parameters
	) {
		$location = $parameters['location'];
		// Builds script to show position
		return sprintf(
			"function( map ) { map.showPosition( %F, %F, %s ); }",
			DataCenterJs::toScalar( $location->get( 'latitude' ) ),
			DataCenterJs::toScalar( $location->get( 'longitude' ) ),
			self::markerOptions( $parameters, $location )
		);
	}

	private static function addMarkersJsFunction(
		array $parameters
	) {
		// Begins building javascript for adding markers
		$jsMarkers = '';
		// Loops over each location
		foreach ( $parameters['locations'] as $location ) {
			// Builds script to add marker
			$jsMarkers .= sprintf(
				"map.addMarker( %F, %F, %s );",
				DataCenterJs::toScalar( $location->get( 'latitude' ) ),
				DataCenterJs::toScalar( $location->get( 'longitude' ) ),
				self::markerOptions( $parameters, $location )
			);
		}
		return sprintf( "function( map ) { %s }", $jsMarkers );
	}
}