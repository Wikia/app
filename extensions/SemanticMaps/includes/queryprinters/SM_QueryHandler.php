<?php

/**
 * Class for handling geographical SMW queries.
 * 
 * @since 0.7.3
 * 
 * @ingroup SemanticMaps
 * @file SM_QueryHandler.php
 * 
 * @author Jeroen De Dauw
 */
class SMQueryHandler {
	
	const LINK_NONE = 0;
	const LINK_RELATIVE = 1;
	const LINK_ABSOLUTE = 2;	
	
	protected $queryResult;
	protected $outputmode;
	
	protected $locations = false;
	
	/**
	 * @since 0.7.4
	 * 
	 * @var array
	 */
	protected $params;
	
	// TODO: add system to properly handle query parameters
	public $template = false;
	public $icon = '';
	
	public $titleLink = self::LINK_ABSOLUTE;
	public $propNameLink = self::LINK_NONE;
	public $propValueLink = self::LINK_NONE;
	
	public $titleLinkSeperate = true;
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7.3
	 * 
	 * @param SMWQueryResult $queryResult
	 * @param integer $outputmode
	 */
	public function __construct( SMWQueryResult $queryResult, $outputmode, array $params ) {
		$this->queryResult = $queryResult;
		$this->outputmode = $outputmode;
		$this->params = $params;
		
		$linkType = $params['linkabsolute'] ? self::LINK_ABSOLUTE : self::LINK_RELATIVE;
		
		$this->titleLink = $params['linkpage'] ? $linkType : self::LINK_NONE;
		$this->propNameLink = $params['linkpropnames'] ? $linkType : self::LINK_NONE;
		$this->propValueLink = $params['linkpropvalues'] ? $linkType : self::LINK_NONE;
	}
	
	/**
	 * Gets the query result as a list of locations.
	 * 
	 * @since 0.7.3
	 * 
	 * @return array of MapsLocation
	 */	
	public function getLocations() {
		if ( $this->locations === false ) {
			$this->locations = $this->findLocations();
		}
		
		return $this->locations;
	}
	
	/**
	 * Gets the query result as a list of locations.
	 * 
	 * @since 0.7.3
	 * 
	 * @return array of MapsLocation
	 */		
	protected function findLocations() {
		$locations = array();
		
		while ( ( $row = $this->queryResult->getNext() ) !== false ) {
			$locations = array_merge( $locations, $this->handleResultRow( $row ) );
		}

		return $locations;
	}
	
	/**
	 * Returns the locations found in the provided result row.
	 * 
	 * TODO: split up this method if possible (!)
	 * TODO: fix template handling
	 * TODO: clean up link type handling
	 * 
	 * @since 0.7.3
	 * 
	 * @param array $row Array of SMWResultArray
	 * 
	 * @return array of MapsLocation
	 */
	protected function handleResultRow( array /* of SMWResultArray */ $row ) {
		global $wgUser, $smgUseSpatialExtensions, $wgTitle;
		
		$locations = array();
		
		$skin = $wgUser->getSkin();
		
		$title = '';
		$text = '';
		$lat = '';
		$lon = '';
		
		$coords = array();
		$label = array();		
		
		// Loop throught all fields of the record.
		foreach ( $row as $i => $resultArray ) {
			/* SMWPrintRequest */ $printRequest = $resultArray->getPrintRequest();
			
			// Loop throught all the parts of the field value.
			while ( ( /* SMWDataValue */ $object = $resultArray->getNextObject() ) !== false ) {		
				if ( $object->getTypeID() == '_wpg' && $i == 0 ) {
					if ( !$this->titleLinkSeperate && $this->titleLink == self::LINK_ABSOLUTE ) {
						$title = Html::element(
							'a',
							array( 'href' => $object->getTitle()->getFullUrl() ),
							$object->getTitle()->getText()
						);
					}
					else {
						$title = $object->getLongText(
							$this->outputmode,
							( $this->titleLink == self::LINK_RELATIVE && !$this->titleLinkSeperate ) ? $skin : NULL
						);
					}
					
					if ( $this->titleLinkSeperate && $this->titleLink != self::LINK_NONE ) {
						$text .= Html::element(
							'a',
							array( 'href' => $object->getTitle()->getFullUrl() ),
							str_replace( '$1', $object->getTitle()->getText(), $this->params['pagelinktext'] ) 
						) . '<br />';
					}					
				}
				
				if ( $object->getTypeID() != '_geo' && $i != 0 ) {
					switch ( $this->propNameLink ) {
						case self::LINK_NONE:
							$propertyName = $printRequest->getHTMLText( NULL );
							break;
						case self::LINK_RELATIVE:
							$propertyName = $printRequest->getHTMLText( $skin );
							break; 
						case self::LINK_ABSOLUTE:
							$t = Title::newFromText( $printRequest->getHTMLText( NULL ), SMW_NS_PROPERTY );
							
							if ( $t->exists() ) {
								
								$propertyName = $propertyName = Html::element(
									'a',
									array( 'href' => $t->getFullUrl() ),
									$printRequest->getHTMLText( NULL )
								);
							}
							else {
								$propertyName = $printRequest->getHTMLText( NULL );
							}
							break; 		
					}
					
					if ( $propertyName != '' ) $propertyName .= ': ';
					
					switch ( $this->propNameLink ) {
						case self::LINK_NONE:
							$propertyValue = $object->getLongText( $this->outputmode, NULL );
							break;
						case self::LINK_RELATIVE:
							$propertyValue = $object->getLongText( $this->outputmode, $skin );
							break; 
						case self::LINK_ABSOLUTE:
							$hasPage = $object->getTypeID() == '_wpg';
							
							if ( $hasPage ) {
								$t = Title::newFromText( $object->getLongText( $this->outputmode, NULL ), NS_MAIN );
								$hasPage = $t->exists();
							}
							
							if ( $hasPage ) {
								$propertyValue = Html::element(
									'a',
									array( 'href' => $t->getFullUrl() ),
									$object->getLongText( $this->outputmode, NULL )
								);
							}
							else {
								$propertyValue = $object->getLongText( $this->outputmode, NULL );
							}
							break; 		
					}		
								
					$text .= $propertyName . $propertyValue . '<br />';
				}
		
				if ( $printRequest->getMode() == SMWPrintRequest::PRINT_PROP && $printRequest->getTypeID() == '_geo' ) {
					$coords[] = $object->getDBkeys();
				}
			}
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

					$location = new MapsLocation();
					
					$location->setCoordinates( array( $lat, $lon ) );
					
					if ( $location->isValid() ) {
						$location->setTitle( $title );
						$location->setText( $text );
						$location->setIcon( $icon );
	
						$locations[] = $location;						
					}
				}
			}	
		}	
		
		return $locations;
	}
	
	/**
	 * Get the icon for a row.
	 *
	 * @since 0.7.3
	 *
	 * @param array $row
	 * 
	 * @return string
	 */
	protected function getLocationIcon( array $row ) {
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
	
}