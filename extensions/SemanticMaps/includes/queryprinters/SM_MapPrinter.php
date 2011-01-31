<?php

/**
 * Abstract class that provides the common functionality for all map query printers.
 *
 * TODO: make use of SMQueryHandler
 * TODO: make use of new-style Validator parameter handling
 *
 * @file SM_MapPrinter.php
 * @ingroup SemanticMaps
 *
 * @author Jeroen De Dauw
 * @author Robert Buzink
 * @author Yaron Koren
 */
abstract class SMMapPrinter extends SMWResultPrinter implements iMappingFeature {

	/**
	 * Returns the name of the service to get the correct mapping service object.
	 * 
	 * @since 0.6.3
	 * 
	 * @return string
	 */
	protected abstract function getServiceName();
	
	/**
	 * @var iMappingService
	 */
	protected $service;
	
	/**
	 * @var array
	 */	
	protected $locations = array();
	
	/**
	 * @var string
	 */
	protected $markerJs;
	
	/**
	 * @var string
	 */
	protected $centreLat;
	
	/**
	 * @var string
	 */	
	protected $centreLon;
	
	/**
	 * @var string
	 */	
	protected $output = '';
	
	/**
	 * @var array or false
	 */	
	protected $specificParameters = false;
	
	/**
	 * Indicates if the zoom paramter was set to it's default.
	 * 
	 * @since 0.7
	 * 
	 * @var boolean
	 */
	protected $zoomDefaulted;
	
	/**
	 * Constructor.
	 * 
	 * @param $format String
	 * @param $inline
	 * @param $service iMappingService
	 */
	public function __construct( $format, $inline, /* iMappingService */ $service = null ) {
		// TODO: this is a hack since I can't find a way to pass along the service object here when the QP is created in SMW.
		if ( $service == null ) {
			$service = MapsMappingServices::getServiceInstance( $this->getServiceName() );
		}
		
		$this->service = $service;
	}
	
	/**
	 * Returns the specific parameters by first checking if they have been initialized yet,
	 * doing to work if this is not the case, and then returning them.
	 * 
	 * @since 0.6.5
	 * 
	 * @return array
	 */
	public final function getSpecificParameterInfo() {
		if ( $this->specificParameters === false ) {
			$this->specificParameters = array();
			$this->initSpecificParamInfo( $this->specificParameters );
		}
		
		return $this->specificParameters;
	}
	
	/**
	 * Initializes the specific parameters.
	 * 
	 * Override this method to set parameters specific to a feature service comibination in
	 * the inheriting class.
	 * 
	 * @since 0.6.5
	 * 
	 * @param array $parameters
	 */
	protected function initSpecificParamInfo( array &$parameters ) {
	}	
	
	/**
	 * Builds up and returns the HTML for the map, with the queried coordinate data on it.
	 *
	 * @param SMWQueryResult $res
	 * @param $outputmode
	 * 
	 * @return array
	 */
	public final function getResultText( /* SMWQueryResult */ $res, $outputmode ) {
		if ( self::manageMapProperties( $this->m_params ) ) {
			$this->formatResultData( $res, $outputmode );
			
			// Only create a map when there is at least one result.
			if ( count( $this->locations ) > 0 || $this->forceshow ) {
				$this->setZoom();
				
				$this->setCentre();
				
				$this->markerJs = $this->service->createMarkersJs( $this->locations );
				
				$this->addSpecificMapHTML();
				
				$dependencies = $this->service->getDependencyHtml();
				$hash = md5( $dependencies );
				SMWOutputs::requireHeadItem( $hash, $dependencies );
			}
			else {
				// TODO: add warning when level high enough and append to error list?
			}
		}

		return array( $this->output, 'noparse' => true, 'isHTML' => true );
	}
	
	/**
	 * Validates and corrects the provided map properties, and the sets them as class fields.
	 * 
	 * @param array $mapProperties
	 * 
	 * @return boolean Indicates whether the map should be shown or not.
	 */
	protected final function manageMapProperties( array $mapProperties ) {
		
		/*
		 * Assembliy of the allowed parameters and their information. 
		 * The main parameters (the ones that are shared by everything) are overidden
		 * by the feature parameters (the ones specific to a feature). The result is then
		 * again overidden by the service parameters (the ones specific to the service),
		 * and finally by the specific parameters (the ones specific to a service-feature combination).
		 */
		$parameterInfo = SMQueryPrinters::getParameterInfo();
		$this->service->addParameterInfo( $parameterInfo );
		
		// TODO
		$parameterInfo = array_merge_recursive( $parameterInfo, $this->getSpecificParameterInfo() );
		
		$validator = new Validator( $this->getName(), false );
		
		$validator->setParameters( $mapProperties, $parameterInfo );
		
		$validator->validateParameters();
		
		$fatalError  = $validator->hasFatalError();
		
		if ( $fatalError === false ) {
			$this->zoomDefaulted = $validator->getParameter( 'zoom' )->wasSetToDefault();
			$this->setMapProperties( $validator->getParameterValues() );
		}
		else {
			$this->output = '<span class="errorbox">' .
				htmlspecialchars( wfMsgExt( 'validator-fatal-error', 'parsemag', $fatalError->getMessage() ) ) . 
				'</span>';			
		}
		
		return !$fatalError;
	}
	
	/**
	 * Sets the map properties as class fields.
	 * 
	 * @param array $mapProperties
	 */
	private function setMapProperties( array $mapProperties ) {
		foreach ( $mapProperties as $paramName => $paramValue ) {
			if ( !property_exists( __CLASS__, $paramName ) ) {
				$this-> { $paramName } = $paramValue;
			}
			else {
				throw new Exception( 'Attempt to override a class field during map propertie assignment. Field name: ' . $paramName );
			}
		}
	}
	
	/**
	 * Reads the parameters and gets the query printers output.
	 * 
	 * @param SMWQueryResult $results
	 * @param array $params
	 * @param $outputmode
	 * 
	 * @return array
	 */
	public final function getResult( /* SMWQueryResult */ $results, /* array */ $params, $outputmode ) {
		// Skip checks, results with 0 entries are normal.
		$this->readParameters( $params, $outputmode );
		
		return $this->getResultText( $results, SMW_OUTPUT_HTML );
	}
	
	/**
	 * Loops over the rows in the result and adds them via addResultRow.
	 * 
	 * @param SMWQueryResult $res
	 * @param $outputmode
	 */
	protected function formatResultData( SMWQueryResult $res, $outputmode ) {
		$this->addStaticLocations();
		
		while ( ( $row = $res->getNext() ) !== false ) {
			$this->addResultRow( $outputmode, $row );
		}
	}
	
	/**
	 * Adds the static locations (specified via the staticlocations parameter) to the map.
	 * 
	 * @since 0.7
	 */
	protected function addStaticLocations() {
		global $wgTitle;
		
		// New parser object to render popup contents with.
		$parser = new Parser();			
		
		$this->title = $parser->parse( $this->title, $wgTitle, new ParserOptions() )->getText();
		$this->label = $parser->parse( $this->label, $wgTitle, new ParserOptions() )->getText();
		
		// Each $location is an array containg the coordinate set as first element, possibly followed by meta data. 
		foreach ( $this->staticlocations as $location ) {
			$markerData = MapsCoordinateParser::parseCoordinates( array_shift( $location ) );
			
			if ( !$markerData ) continue;
			
			$markerData = array( $markerData['lat'], $markerData['lon'] );
			
			if ( count( $location ) > 0 ) {
				// Parse and add the point specific title if it's present.
				$markerData['title'] = $parser->parse( $location[0], $wgTitle, new ParserOptions() )->getText();
				
				if ( count( $location ) > 1 ) {
					// Parse and add the point specific label if it's present.
					$markerData['label'] = $parser->parse( $location[1], $wgTitle, new ParserOptions() )->getText();
					
					if ( count( $location ) > 2 ) {
						// Add the point specific icon if it's present.
						$markerData['icon'] = $location[2];
					}
				}
			}
			
			// If there is no point specific icon, use the general icon parameter when available.
			if ( !array_key_exists( 'icon', $markerData ) ) {
				$markerData['icon'] = $this->icon;
			}
			
			if ( $markerData['icon'] != '' ) {
				$markerData['icon'] = MapsMapper::getImageUrl( $markerData['icon'] );
			}
			
			// Temporary fix, will refactor away later
			// TODO
			$markerData = array_values( $markerData );
			if ( count( $markerData ) < 5 ) {
				if ( count( $markerData ) < 4 ) {
					$markerData[] = '';
				}				
				$markerData[] = '';
			} 
			
			$this->locations[] = $markerData;
		}		
	}
	
	/**
	 * This function will loop through all properties (fields) of one record (row),
	 * and add the location data, title, label and icon to the m_locations array.
	 *
	 * TODO: this doesn't qualify as a megamoth just yet, but some splitting up would be nice
	 *
	 * @param $outputmode
	 * @param array $row The record you want to add data from
	 */
	protected function addResultRow( $outputmode, array $row ) {
		global $wgUser, $smgUseSpatialExtensions, $wgTitle;
		
		$skin = $wgUser->getSkin();
		
		$title = '';
		$titleForTemplate = '';
		$text = '';
		$lat = '';
		$lon = '';
		
		$coords = array();
		$label = array();
		
		// Loop throught all fields of the record.
		foreach ( $row as $i => $field ) {
			$pr = $field->getPrintRequest();
			
			// Loop throught all the parts of the field value.
			while ( ( $object = $field->getNextObject() ) !== false ) {
				if ( $object->getTypeID() == '_wpg' && $i == 0 ) {
					if ( $this->showtitle ) $title = $object->getLongText( $outputmode, $skin );
					if ( $this->template ) $titleForTemplate = $object->getLongText( $outputmode, NULL );
				}
				
				if ( $object->getTypeID() != '_geo' && $i != 0 ) {
					if ( $this->template ) {
						if ( $object instanceof SMWWikiPageValue ) {
							$label[] = $object->getTitle()->getPrefixedText();
						} else {
							$label[] = $object->getLongText( $outputmode, $skin );
						}
					}
					else {
						$propertyName = $pr->getHTMLText( $skin );
						if ( $propertyName != '' ) $propertyName .= ': ';
						$text .= $propertyName . $object->getLongText( $outputmode, $skin ) . '<br />';
					}
				}
		
				if ( $pr->getMode() == SMWPrintRequest::PRINT_PROP && $pr->getTypeID() == '_geo' ) {
					$coords[] = $object->getDBkeys();
				}
			}
		}
		
		if ( $this->template ) {
			// New parser object to render the templates with.
			$parser = new Parser();			
		}
		
		foreach ( $coords as $coord ) {
			if ( count( $coord ) >= 2 ) {
				if ( $smgUseSpatialExtensions ) {
					// TODO
				}
				else {
					list( $lat, $lon ) = $coord; 
				}
				
				if ( $lat != '' && $lon != '' ) {
					$icon = $this->getLocationIcon( $row );

					if ( $this->template ) {
						$segments = array_merge(
							array( $this->template, 'title=' . $titleForTemplate, 'latitude=' . $lat, 'longitude=' . $lon ),
							$label
						);
						
						$text = $parser->parse( '{{' . implode( '|', $segments ) . '}}', $wgTitle, new ParserOptions() )->getText();
					}

					$this->locations[] = array(
						$lat,
						$lon,
						$title,
						$text,
						$icon
					);
				}
			}
		}
	}

	/**
	 * Get the icon for a row.
	 *
	 * @param array $row
	 * 
	 * @return string
	 */
	private function getLocationIcon( array $row ) {
		$icon = '';
		$legend_labels = array();
		
		// Look for display_options field, which can be set by Semantic Compound Queries
        // the location of this field changed in SMW 1.5
		$display_location = method_exists( $row[0], 'getResultSubject' ) ? $row[0]->getResultSubject() : $row[0];
		
		if ( property_exists( $display_location, 'display_options' ) && is_array( $display_location->display_options ) ) {
			$display_options = $display_location->display_options;
			if ( array_key_exists( 'icon', $display_options ) ) {
				$icon = $display_options['icon'];

				// This is somewhat of a hack - if a legend label has been set, we're getting it for every point, instead of just once per icon	
				if ( array_key_exists( 'legend label', $display_options ) ) {
									
					$legend_label = $display_options['legend label'];
					
					if ( ! array_key_exists( $icon, $legend_labels ) ) {
						$legend_labels[$icon] = $legend_label;
					}
				}
			}
		} // Icon can be set even for regular, non-compound queries If it is, though, we have to translate the name into a URL here
		elseif ( $this->icon != '' ) {
			$icon = MapsMapper::getImageUrl( $this->icon );
		}

		return $icon;
	}
	
	/**
	 * Sets the zoom level to the provided value, or when not set, to the default.
	 */
	protected function setZoom() {
		if ( $this->zoomDefaulted ) {
			if ( count( $this->locations ) > 1 ) {
		        $this->zoom = 'null';
		    }
		}
	}
	
	/**
	 * Sets the $centre_lat and $centre_lon fields.
	 * Note: this needs to be done AFTRE the maker coordinates are set.
	 */
	protected function setCentre() {
		// If a centre value is set, use it.
		if ( $this->centre != '' ) {
			// Geocode and convert if required.
			$centre = MapsGeocoders::attemptToGeocode( $this->centre, $this->geoservice, $this->service->getName() );
			
			if ( $centre ) {
				$this->centreLat = $centre['lat'];
				$this->centreLon = $centre['lon'];				
			}
			else {
				$this->setCentreDefault();
			}
		}
		else {
			$this->setCentreDefault();
		}
	}
	
	/**
	 * Figures out the default value for the centre. 
	 */
	private function setCentreDefault() {
		if ( count( $this->locations ) > 1 ) {
			// If centre is not set, and there are multiple points, set the values to null, to be auto determined by the JS of the mapping API.			
			$this->centreLat = 'null';
			$this->centreLon = 'null';
		}
		elseif ( count( $this->locations ) == 1 ) {
			// If centre is not set and there is exactelly one marker, use it's coordinates.			
			$this->centreLat = Xml::escapeJsString( $this->locations[0][0] );
			$this->centreLon = Xml::escapeJsString( $this->locations[0][1] );
		}
		else {
			// If centre is not set and there are no results, centre on the default coordinates.
			global $egMapsDefaultMapCentre;
			// TODO
		}		
	}
	
	/**
	 * Returns the internationalized name of the mapping service.
	 * 
	 * @return string
	 */
	public final function getName() {
		return wfMsg( 'maps_' . $this->service->getName() );
	}
	
	/**
	 * Returns a list of parameter information, for usage by Special:Ask and others.
	 * 
	 * @return array
	 */
    public function getParameters() {
    	global $egMapsMapWidth, $egMapsMapHeight;
    	
        $params = parent::exportFormatParameters();
        
        $params[] = array( 'name' => 'zoom', 'type' => 'int', 'description' => wfMsg( 'semanticmaps_paramdesc_zoom' ) );
        $params[] = array( 'name' => 'width', 'type' => 'int', 'description' => wfMsgExt( 'semanticmaps_paramdesc_width', 'parsemag', $egMapsMapWidth ) );
        $params[] = array( 'name' => 'height', 'type' => 'int', 'description' => wfMsgExt( 'semanticmaps_paramdesc_height', 'parsemag', $egMapsMapHeight ) );

        return $params;
    }
	
}