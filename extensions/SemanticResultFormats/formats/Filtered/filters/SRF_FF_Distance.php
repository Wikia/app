<?php

/**
 * File holding the SRF_FF_Distance class
 *
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticResultFormats
 */

/**
 * The SRF_FF_Distance class.
 *
 * Available parameters for this filter:
 *   distance filter origin: the point from which the distance is measured (address or geo coordinate)
 *   distance filter property: the property containing the point to which distance is measured - not implemented yet
 *   distance filter unit: the unit in which the distance is measured
 *
 * @ingroup SemanticResultFormats
 */
class SRF_FF_Distance extends SRF_Filtered_Filter {
	
	private $mUnit = null;
	private $mMaxDistance = 1;

	public function __construct( &$results, SMWPrintRequest $printRequest, SRFFiltered &$queryPrinter ) {
		
		global $wgParser;
		
		parent::__construct($results, $printRequest, $queryPrinter);
		
		if ( !defined('Maps_VERSION') || version_compare( Maps_VERSION, '1.0', '<' ) ) {
			throw new FatalError('You need to have the <a href="http://www.mediawiki.org/wiki/Extension:Maps">Maps</a> extension version 1.0 or higher installed in order to use the distance filter.<br />');
		}
		
		MapsGeocoders::init();
		
		$params = $this->getActualParameters();

		if (  array_key_exists( 'distance filter origin', $params ) ) {
			$origin = MapsGeocoders::attemptToGeocode( $wgParser->recursiveTagParse( $params['distance filter origin'] ) );
		} else {
			$origin = array( 'lat'=>'0', 'lon' => '0' );
		}

		if ( array_key_exists( 'distance filter unit', $params ) ) {
			$this->mUnit = MapsDistanceParser::getValidUnit( $wgParser->recursiveTagParse( $params['distance filter unit'] ) );
		} else {
			$this->mUnit = MapsDistanceParser::getValidUnit();
		}

		// Is the real position stored in a property?
		if ( array_key_exists( 'distance filter property', $params ) ) {
			$property = trim( $wgParser->recursiveTagParse( $params['distance filter property'] ) );
			$locations = array();
		} else {
			$property = null;
			$locations = null;
		}

		$targetLabel = $printRequest->getLabel();
		
		foreach ( $this->getQueryResults() as $id => $filteredItem ) {

			$row = $filteredItem->getValue();
			
			// $filteredItem is of class SRF_Filtered_Item
			// $row is an array of SMWResultArray
			
			foreach ( $row as $field ) {
				
				// $field is an SMWResultArray
				
				$label = $field->getPrintRequest()->getLabel();
				
				if ($label === $targetLabel) {
					$field->reset();
					$dataValue = $field->getNextDataValue(); // only use first value

					if ( $dataValue !== false ) {
						
						$posText = $dataValue->getShortText( SMW_OUTPUT_WIKI, false );
						
						if ( $property === null ) {
							
							// position is directly given
							$pos = MapsGeocoders::attemptToGeocode( $posText );
							
						} else {
							// position is given in a property of a page
							
							// if we used this page before, just look up the coordinates
							if ( array_key_exists( $posText, $locations ) ) {
								$pos = $locations[$posText];
							} else {
								
								// query the position's page for the coordinates or address
								$posText = SMWQueryProcessor::getResultFromFunctionParams(
									array($posText, '?' . $property),
									SMW_OUTPUT_WIKI,
									SMWQueryProcessor::INLINE_QUERY,
									true
								);
								
								// 
								if ( $posText !== '' ) {
									// geocode 
									$pos = MapsGeocoders::attemptToGeocode( $posText );
								} else {
									$pos = array('lat' => '0', 'lon' => '0');
								}
								
								// store coordinates in case we need them again
								$locations[$posText] = $pos;
							}
						}

						if ( is_array( $pos ) ){
							$distance = round( MapsGeoFunctions::calculateDistance( $origin, $pos ) / MapsDistanceParser::getUnitRatio( $this->mUnit ) );
							
							if ( $distance > $this->mMaxDistance ) {							
								$this->mMaxDistance = $distance;
							}
							
						} else {
							$distance = -1;
						}
						
					} else {
						$distance = -1;  // no location given
					}
					$filteredItem->setData( 'distance-filter', $distance );
					break;
				}
				
			}
		}

		if ( array_key_exists( 'distance filter max distance', $params ) &&
			is_numeric( $maxDist = trim( $wgParser->recursiveTagParse( $params['distance filter max distance'] ) ) ) ) {
			// this assignation ^^^ is ugly, but intentional
			
			$this->mMaxDistance = $maxDist;
		} else {
			if ( $this->mMaxDistance > 1 ) {
				$base = pow( 10, floor( log10( $this->mMaxDistance ) ) );
				$this->mMaxDistance = ceil ( $this->mMaxDistance / $base ) * $base;
			}
		}
		
	}

	/**
	 * Returns the name (string) or names (array of strings) of the resource
	 * modules to load.
	 *
	 * @return string|array
	 */
	public function getResourceModules() {
		return 'ext.srf.filtered.distance-filter';
	}

	/**
	 * Returns an array of config data for this filter to be stored in the JS
	 * @return null
	 */
	public function getJsData() {
		
		global $wgParser;
		
		$params = $this->getActualParameters();
		
		$ret = array();

		$ret['unit'] = $this->mUnit;
		$ret['max'] = $this->mMaxDistance;

		if ( array_key_exists( 'distance filter collapsible', $params ) ) {
			$ret['collapsible'] = trim( $wgParser->recursiveTagParse( $params['distance filter collapsible'] ) );
		}
		
		if ( array_key_exists( 'distance filter initial value', $params ) ) {
			$ret['initial value'] = trim( $wgParser->recursiveTagParse( $params['distance filter initial value'] ) );
		}


		return $ret;
	}

}
