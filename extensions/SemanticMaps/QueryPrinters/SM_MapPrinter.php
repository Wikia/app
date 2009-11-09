<?php

/**
 * Abstract class that provides the common functionallity for all map query printers
 *
 * @file SM_MapPrinter.php
 * @ingroup SemanticMaps
 *
 * @author Jeroen De Dauw
 * @author Robert Buzink
 * @author Yaron Koren
 */

if( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

abstract class SMMapPrinter extends SMWResultPrinter {

	/**
	 * Sets the map service specific element name
	 */
	protected abstract function setQueryPrinterSettings();
	
	/**
	 * Map service spesific map count and loading of dependencies
	 */
	protected abstract function doMapServiceLoad();	
	
	/**
	 * Gets the query result
	 */
	protected abstract function addSpecificMapHTML();
	
	public $serviceName;	
	
	protected $defaultParams = array();	
	
	protected $m_locations = array();
	
	protected $defaultZoom;
	protected $elementNr;
	protected $elementNamePrefix;
	
	protected $mapName;	
	
	protected $centre_lat;
	protected $centre_lon;	
	
	protected $output = '';
	
	protected $mapFeature;
	
	/**
	 * Builds up and returns the HTML for the map, with the queried coordinate data on it.
	 *
	 * @param unknown_type $res
	 * @param unknown_type $outputmode
	 * @return array
	 */
	public final function getResultText($res, $outputmode) {
		$this->formatResultData($res, $outputmode);
		
		$this->setQueryPrinterSettings();
		
		$this->manageMapProperties($this->m_params);
		
		// Only create a map when there is at least one result.
		if (count($this->m_locations) > 0) {
			$this->doMapServiceLoad();
	
			$this->setMapName();
			
			$this->setZoom();
			
			$this->setCentre();		
			
			$this->addSpecificMapHTML();			
		}
		
		return array($this->output, 'noparse' => 'true', 'isHTML' => 'true');
	}
	
	public final function getResult($results, $params, $outputmode) {
		// Skip checks, results with 0 entries are normal
		$this->readParameters($params, $outputmode);
		return $this->getResultText($results, SMW_OUTPUT_HTML);
	}
	
	private function formatResultData($res, $outputmode) {
		while ( ($row = $res->getNext()) !== false ) {
			$this->addResultRow($outputmode, $row);
		}
	}	
	
	/**
	 * This function will loop through all properties (fields) of one record (row),
	 * and add the location data, title, label and icon to the m_locations array.
	 *
	 * @param unknown_type $outputmode
	 * @param unknown_type $row The record you want to add data from
	 */
	private function addResultRow($outputmode, $row) {
		global $wgUser;
		$skin = $wgUser->getSkin();		
		
		$title = '';
		$text = '';
		$lat = '';
		$lon = '';		
		
		$coords = array();
		
		// Loop throught all fields of the record
		foreach ($row as $i => $field) {
			$pr = $field->getPrintRequest();
			
			// Loop throught all the parts of the field value
			while ( ($object = $field->getNextObject()) !== false ) {
				if ($object->getTypeID() == '_wpg' && $i == 0) {
					$title = $object->getLongText($outputmode, $skin);
				}
				
				if ($object->getTypeID() != '_geo' && $i != 0) {
					$text .= $pr->getHTMLText($skin) . ': ' . $object->getLongText($outputmode, $skin) . '<br />';
				}
		
				if ($pr->getMode() == SMWPrintRequest::PRINT_PROP && $pr->getTypeID() == '_geo') {
					$coords[] = explode(',', $object->getXSDValue());
				}
			}
		}
		
		foreach ($coords as $coord) {
			if (count($coord) == 2) {
				list($lat, $lon) = $coord;
				
				if (strlen($lat) > 0 && strlen($lon) > 0) {
					$icon = $this->getLocationIcon($row);
					$this->m_locations[] = array($lat, $lon, $title, $text, $icon);
				}
				
			}
		}
	}
	
	/**
	 * Get the icon for a row
	 *
	 * @param unknown_type $row
	 * @return unknown
	 */
	private function getLocationIcon($row) {
		$icon = '';
		$legend_labels = array();
		
		// Look for display_options field, which can be set by Semantic Compound Queries
                // the location of this field changed in SMW 1.5
                if (method_exists($row[0], 'getResultSubject')) // SMW 1.5+
                        $display_location = $row[0]->getResultSubject();
                else
                        $display_location = $row[0];
		if (property_exists($display_location, 'display_options') && is_array($display_location->display_options)) {
			$display_options = $display_location->display_options;
			if (array_key_exists('icon', $display_options)) {
				$icon = $display_options['icon'];

				// This is somewhat of a hack - if a legend label has been set, we're getting it for every point, instead of just once per icon	
				if (array_key_exists('legend label', $display_options)) {
									
					$legend_label = $display_options['legend label'];
					
					if (! array_key_exists($icon, $legend_labels)) {
						$legend_labels[$icon] = $legend_label;
					}
				}
			}
		// Icon can be set even for regular, non-compound queries If it is, though, we have to translate the name into a URL here	
		} elseif (array_key_exists('icon', $this->m_params)) {
	
			$icon_title = Title::newFromText($this->m_params['icon']);
			$icon_image_page = new ImagePage($icon_title);
			$icon = $icon_image_page->getDisplayedFile()->getURL();
		}	

		return $icon;
	}
	
	private function manageMapProperties($mapProperties) {
		global $egMapsServices;
		
		$mapProperties = MapsMapper::getValidParams($mapProperties, $egMapsServices[$this->serviceName]['parameters']);
		$mapProperties = MapsMapper::setDefaultParValues($mapProperties, $this->defaultParams);
		
		if (isset($this->serviceName)) $mapProperties['service'] = $this->serviceName;
		
		// Go through the array with map parameters and create new variables
		// with the name of the key and value of the item if they don't exist on class level yet.
		foreach($mapProperties as $paramName => $paramValue) {
			if (!property_exists(__CLASS__, $paramName)) {
				$this->{$paramName} = $paramValue;
			}
		}
		
		MapsMapper::enforceArrayValues($this->controls);
	}	
	
	/**
	 * Sets the zoom level to the provided value, or when not set, to the default.
	 *
	 */
	private function setZoom() {
		if (strlen($this->zoom) < 1) {
			if (count($this->m_locations) > 1) {
		        $this->zoom = 'null';
		    }
		    else {
		        $this->zoom = $this->defaultZoom;
		    }
		}		
	}	
	
	/**
	 * Sets the $centre_lat and $centre_lon fields.
	 * Note: this needs to be done AFTRE the maker coordinates are set.
	 *
	 */
	private function setCentre() {
		if (strlen($this->centre) > 0) {
			// If a centre value is set, use it.
			$centre = MapsUtils::getLatLon($this->centre);
			$this->centre_lat = $centre['lat'];
			$this->centre_lon = $centre['lon'];
		}
		elseif (count($this->m_locations) > 1) {
			// If centre is not set, and there are multiple points, set the values to null, to be auto determined by the JS of the mapping API.			
			$this->centre_lat = 'null';
			$this->centre_lon = 'null';
		}	
		else {
			// If centre is not set and there is exactelly one marker, use it's coordinates.			
			$this->centre_lat = $this->m_locations[0][0];
			$this->centre_lon = $this->m_locations[0][1];
		}				
	}	
	
	/**
	 * Sets the $mapName field, using the $elementNamePrefix and $elementNr.
	 *
	 */
	protected function setMapName() {
		$this->mapName = $this->elementNamePrefix.'_'.$this->elementNr;
	}	
	
	public final function getName() {
		return wfMsg('maps_' . $this->serviceName);
	}
	
}
