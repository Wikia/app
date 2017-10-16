<?php

use Maps\Elements\Location;

/**
 * Class to format geographical data to KML.
 * 
 * @since 0.7.3
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsKMLFormatter {

	/**
	 * @since 1.0
	 *  
	 * @var array
	 */
	protected $params;
	
	/**
	 * @since 0.7.3
	 * 
	 * @var Location[]
	 */
	protected $placemarks;
	
	/**
	 * Constructor.
	 * 
	 * @since 0.7.3
	 * 
	 * @param array $params
	 */
	public function __construct( array $params = array() ) {
		$this->params = $params;
		$this->clearElements();
	}
	
	/**
	 * Builds and returns KML representing the set geographical objects.
	 * 
	 * @since 0.7.3
	 * 
	 * @return string
	 */
	public function getKML() {
		$elements = $this->getKMLElements();
		
		// http://earth.google.com/kml/2.2
		return <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2">
	<Document>
		$elements
	</Document>
</kml>
EOT;
	}
	
	/**
	 * Adds a single placemark.
	 * 
	 * @since 0.7.3
	 * 
	 * @param Location $placemark
	 */	
	public function addPlacemark( Location $placemark ) {
		$this->placemarks[] = $placemark;
	}
	
	/**
	 * Adds a multiple placemarks.
	 * 
	 * @since 0.7.3
	 * 
	 * @param Location[] $placemarks
	 */		
	public function addPlacemarks( array $placemarks ) {
		foreach ( $placemarks as $placemark ) {
			$this->addPlacemark( $placemark );
		}
	}
	
	/**
	 * Clears all set geographical objects.
	 * 
	 * @since 0.7.3
	 */		
	public function clearElements() {
		$this->clearPlacemarks();
	}
	
	/**
	 * Clears all set placemarks.
	 * 
	 * @since 0.7.3
	 */	
	public function clearPlacemarks() {
		$this->placemarks = array();
	}
	
	/**
	 * Returns the KML for all set geographical objects.
	 * 
	 * @since 0.7.3
	 * 
	 * @return string
	 */	
	protected function getKMLElements() {
		$elements = array();
		
		$elements = array_merge( $elements, $this->getPlacemarks() );
		
		return implode( "\n", $elements );
	}
	
	/**
	 * Returns KML for all set placemarks in a list, where each element is
	 * a KML node representing a placemark.
	 * 
	 * @since 0.7.3
	 * 
	 * @return array
	 */		
	protected function getPlacemarks() {
		$placemarks = array();
		
		foreach ( $this->placemarks as $location ) {
			$placemarks[] = $this->getKMLForLocation( $location );
		}
		
		return $placemarks;
	}
	
	/**
	 * Returns the KML representing the provided location.
	 * 
	 * @since 0.7.3
	 * 
	 * @param Location $location
	 *
	 * @return string
	 */		
	protected function getKMLForLocation( Location $location ) {
		$name = '<name><![CDATA[ ' . $location->getTitle() . ']]></name>';
		
		$description = '<description><![CDATA[ ' . $location->getText() . ']]></description>';

		$coordinates = $location->getCoordinates();

		// lon,lat[,alt]
		$coordinates = Xml::element(
			'coordinates',
			array(),
			$coordinates->getLongitude() . ',' . $coordinates->getLatitude() . ',0'
		);

		return <<<EOT
		<Placemark>
			$name
			$description
			<Point>
				$coordinates
			</Point>
		</Placemark>
		
EOT;
	}
	
}
