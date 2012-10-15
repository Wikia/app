<?php

/**
 * File holding class MapsBasePointMap.
 * 
 * @file UKG_BaseUkPointMap.php
 * @ingroup UKGeocodingForMaps
 * 
 * @author Jeroen De Dauw
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

/**
 * Abstract class MapsBasePointMap provides the scafolding for classes handling display_uk_point(s)
 * calls for a spesific mapping service. It inherits from MapsMapFeature and therefore
 * forces inheriting classes to implement sereveral methods.
 *
 * @ingroup UKGeocodingForMaps
 *
 * @author Jeroen De Dauw
 */
abstract class UKGBaseUkPointMap extends MapsMapFeature implements iDisplayFunction {
	
	private $markerData = array();
	protected $markerString;
	
	/**
	 * Handles the request from the parser hook by doing the work that's common for all
	 * mapping services, calling the specific methods and finally returning the resulting output.
	 *
	 * @param Parser $parser
	 * @param array $params
	 * 
	 * @return html
	 */
	public final function displayMap( Parser &$parser, array $params ) {
		$this->setMapSettings();
		
		$this->featureParameters = MapsDisplayPoint::$parameters;
		
		if ( parent::manageMapProperties( $params, __CLASS__ ) ) {
			$this->doMapServiceLoad();
	
			$this->setMapName();
			
			$this->setMarkerData( $parser );
	
			$this->createMarkerString();
			
			$this->setZoom();
			
			$this->addSpecificMapHTML( $parser );
		}
		
		return $this->output . $this->errorList;
	}
	
	/**
	 * Sets the zoom level to the provided value. When no zoom is provided, set
	 * it to the default when there is only one location, or the best fitting soom when
	 * there are multiple locations.
	 *
	 */
	private function setZoom() {
		if ( strlen( $this->zoom ) < 1 ) {
			if ( count( $this->markerData ) > 1 ) {
		        $this->zoom = 'null';
		    }
		    else {
		        $this->zoom = $this->defaultZoom;
		    }
		}
	}
	
	/**
	 * Fills the $markerData array with the locations and their meta data.
	 *
	 * @param unknown_type $parser
	 */
	private function setMarkerData( $parser ) {
		$this->coordinates = explode( ';', $this->coordinates );
		
		$this->title = Xml::escapeJsString( $parser->recursiveTagParse( $this->title ) );
		$this->label = Xml::escapeJsString( $parser->recursiveTagParse( $this->label ) );
		
		foreach ( $this->coordinates as $coordinates ) {
			$args = explode( '~', $coordinates );
			
			$markerData = array( 'location' => $args[0] );
			
			if ( count( $args ) > 1 ) {
				// Parse and add the point specific title if it's present.
				$markerData['title'] = $parser->recursiveTagParse( $args[1] );
				
				if ( count( $args ) > 2 ) {
					// Parse and add the point specific label if it's present.
					$markerData['label'] = $parser->recursiveTagParse( $args[2] );
					
					if ( count( $args ) > 3 ) {
						// Add the point specific icon if it's present.
						$markerData['icon'] = $args[3];
					}
				}
			}
			
			// If there is no point specific icon, use the general icon parameter when available.
			if ( ! array_key_exists( 'icon', $markerData ) && strlen( $this->icon ) > 0 ) $markerData['icon'] = $this->icon;
			
			// Get the url for the icon when there is one, else set the icon to an empty string.
			if ( array_key_exists( 'icon', $markerData ) ) {
				$icon_image_page = new ImagePage( Title::newFromText( $markerData['icon'] ) );
				$markerData['icon'] = $icon_image_page->getDisplayedFile()->getURL();
			}
			else {
				$markerData['icon'] = '';
			}
			
			$this->markerData[] = $markerData;
		}
	}
	
	/**
	 * Creates a JS string with the marker data. Takes care of escaping the used values.
	 */
	private function createMarkerString() {
		$markerItems = array();
		
		foreach ( $this->markerData as $markerData ) {
			$title = array_key_exists( 'title', $markerData ) ? Xml::escapeJsString( $markerData['title'] ) : $this->title;
			$label = array_key_exists( 'label', $markerData ) ? Xml::escapeJsString( $markerData['label'] ) : $this->label;
			
			$markerData['location'] = Xml::escapeJsString( $markerData['location'] );
			$icon = Xml::escapeJsString( $markerData['icon'] );
			$location = Xml::escapeJsString( $markerData['location'] );
			
			$markerItems[] = "{'location': '$location', 'title': '$title', 'label': '$label', 'icon': '$icon'}";
		}
		
		$this->markerString = implode( ',', $markerItems );
	}
}
