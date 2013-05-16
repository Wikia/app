<?php

/**
 * Class describing a single location (geographical point).
 *
 * @since 0.7.1
 * 
 * @file Maps_Location.php
 * @ingroup Maps
 * 
 * @author Jeroen De Dauw
 */
class MapsLocation {
	
	/**
	 * @since 0.7.1
	 * 
	 * @var float
	 */	
	protected $latitude;
	
	/**
	 * @since 0.7.1
	 * 
	 * @var float
	 */	
	protected $longitude;

	/**
	 * @since 0.7.2
	 * 
	 * @var float
	 */	
	protected $altitude = 0;	
	
	/**
	 * @since 0.7.1
	 * 
	 * @var string
	 */
	protected $address;

	/**
	 * @since 0.7.2
	 * 
	 * @var string
	 */	
	protected $title = '';

	/**
	 * @since 0.7.2
	 * 
	 * @var string
	 */		
	protected $text = '';
	
	/**
	 * @since 0.7.2
	 * 
	 * @var string
	 */		
	protected $icon = '';
	
	
	/**
	 * @since 0.7.1
	 * 
	 * @var boolean
	 */
	protected $isValid = false;
	
	
	/**
	 * @since 0.7.1
	 * 
	 * @var string Element of the Maps_COORDS_ enum
	 */
	protected $format;
	
	/**
	 * @since 0.7.1
	 * 
	 * @var boolean
	 */
	protected $directional;
	
	/**
	 * @since 0.7.1
	 * 
	 * @var string
	 */	
	protected $separator;
	
	/**
	 * Creates and returns a new instance of a MapsLocation from a latitude and longitude.
	 * 
	 * @since 1.0
	 * 
	 * @param float $lat
	 * @param float $lon
	 * @param integer $format
	 * 
	 * @return MapsLocation
	 */
	public static function newFromLatLon( $lat, $lon, $format = Maps_COORDS_FLOAT ) {
		return new self( $lat . ',' . $lon, $format );
	}
	
	/**
	 * Creates and returns a new instance of a MapsLocation from an address.
	 * 
	 * @since 1.0
	 * 
	 * @param string $address
	 * @param integer $format
	 * 
	 * @return MapsLocation
	 */
	public static function newFromAddress( $address, $format = Maps_COORDS_FLOAT ) {
		return new self( $address, $format );
	}
	
	/**
	 * Constructor.
	 * 
	 * @param mixed $coordsOrAddress string or array with lat and lon
	 * @param integer $format
	 * @param boolean $directional
	 * @param string $separator
	 * 
	 * @since 0.7.1
	 */
	public function __construct( $coordsOrAddress = null, $format = Maps_COORDS_FLOAT, $directional = false, $separator = ',' ) {
		$this->format = $format;
		$this->directional = $directional;
		$this->separator = $separator;
		
		if ( !is_null( $coordsOrAddress ) ) {
			if ( MapsCoordinateParser::areCoordinates( $coordsOrAddress ) ) {
				$this->setCoordinates( $coordsOrAddress );
			}
			else {
				$this->setAddress( $coordsOrAddress );
			}
		}
	}
	
	/**
	 * Sets the location to a set of coordinates. You can provide a string
	 * of raw coordinates, an array with lat and lon values and false.
	 * 
	 * @since 0.7.1
	 * 
	 * @param mixed $coordinates
	 * 
	 * @return boolean Success indicator
	 */
	public function setCoordinates( $coordinates ) {
		$coordSet = MapsCoordinateParser::parseCoordinates( $coordinates );
		$this->isValid = $coordSet !== false;
		
		$this->latitude = $coordSet['lat'];
		$this->longitude = $coordSet['lon'];
		
		return $this->isValid;
	}
	
	/**
	 * Sets the location to an address.
	 * 
	 * @since 0.7.1
	 * 
	 * @param string $address
	 * @param boolean $asActualLocation When set to false, the location is not changed, only the address string is.
	 * 
	 * @return boolean Success indicator
	 */
	public function setAddress( $address, $asActualLocation = true ) {
		if ( $asActualLocation ) {
			$this->setCoordinates( MapsGeocoders::geocode( $address ) );
		}
		
		$this->address = $address;
		
		return $this->isValid;
	}
	
	/**
	 * Returns if the location is valid.
	 * 
	 * @since 0.7.1
	 * 
	 * @return boolean
	 */
	public function isValid() {
		return $this->isValid;
	}
	
	/**
	 * Returns the locations latitude.
	 * 
	 * @since 0.7.1
	 * 
	 * @return float
	 */	
	public function getLatitude() {
		if ( !$this->isValid() ) {
			throw new Exception( 'Attempt to get the latitude of an invalid location' );
		}
		return $this->latitude;
	}
	
	/**
	 * Returns the locations longitude.
	 * 
	 * @since 0.7.1
	 * 
	 * @return float
	 */
	public function getLongitude() {
		if ( !$this->isValid() ) {
			throw new Exception( 'Attempt to get the longitude of an invalid location' );
		}
		return $this->longitude;
	}
	
	/**
	 * Returns the locations altitude.
	 * 
	 * @since 0.7.3
	 * 
	 * @return float
	 */
	public function getAltitude() {
		if ( !$this->isValid() ) {
			throw new Exception( 'Attempt to get the altitude of an invalid location' );
		}
		return $this->altitude;
	}	
	
	/**
	 * Returns the locations coordinates formatted in the specified notation.
	 * 
	 * @since 0.7.1
	 * 
	 * @param string $format Element of the Maps_COORDS_ enum
	 * @param boolean $directional
	 * @param string $separator
	 * 
	 * @return string
	 */
	public function getCoordinates( $format = null, $directional = null, $separator = null ) {
		if ( !$this->isValid() ) {
			throw new Exception( 'Attempt to get the coordinates for an invalid location' );
		}		
		return MapsCoordinateParser::formatCoordinates(
			array( 'lat' => $this->latitude, 'lon' => $this->longitude ),
			is_null( $format ) ? $this->format : $format,
			is_null( $directional ) ? $this->directional : $directional,
			is_null( $separator ) ? $this->separator : $separator
		);
	}
	
	/**
	 * Returns the address corresponding to this location.
	 * If there is none, and empty sting is returned.
	 * 
	 * @since 0.7.1
	 * 
	 * @param boolean $geocodeIfEmpty
	 * 
	 * @return string
	 */
	public function getAddress( $geocodeIfEmpty = true ) {
		if ( !$this->isValid() ) {
			throw new Exception( 'Attempt to get the address of an invalid location' );
		}
		
		if ( is_null( $this->address ) ) {
			if ( $geocodeIfEmpty ) {
				// TODO: attempt to reverse-geocode
			}
			
			$this->address = '';
		}
		
		return $this->address;
	}

	/**
	 * Sets the title.
	 * 
	 * @since 0.7.2
	 * 
	 * @param string $title
	 */
	public function setTitle( $title ) {
		$this->title = $title;
	}

	/**
	 * Sets the text.
	 * 
	 * @since 0.7.2
	 * 
	 * @param string $text
	 */
	public function setText( $text ) {
		$this->text = $text;
	}	
	
	/**
	 * Returns if there is any icon.
	 * 
	 * @since 1.0
	 * 
	 * @return boolean
	 */
	public function hasIcon() {
		return $this->icon !== '';
	}		
	
	/**
	 * Sets the icon
	 * 
	 * @since 0.7.2
	 * 
	 * @param string $icon
	 */
	public function setIcon( $icon ) {
		$this->icon = $icon;
	}	
	
	/**
	 * Returns if there is any title.
	 * 
	 * @since 1.0
	 * 
	 * @return boolean
	 */
	public function hasTitle() {
		return $this->title !== '';
	}	
	
	/**
	 * Returns the title.
	 * 
	 * @since 0.7.2
	 * 
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * Returns if there is any text.
	 * 
	 * @since 1.0
	 * 
	 * @return boolean
	 */
	public function hasText() {
		return $this->text !== '';
	}
	
	/**
	 * Returns the text.
	 * 
	 * @since 0.7.2
	 * 
	 * @return string
	 */
	public function getText() {
		return $this->text;
	}
	
	/**
	 * Returns the icon.
	 * 
	 * @since 0.7.2
	 * 
	 * @return string
	 */
	public function getIcon() {
		return $this->icon;
	}
	
	/**
	 * Returns an object that can directly be converted to JS using json_encode or similar.
	 * 
	 * @since 1.0
	 * 
	 * @return object
	 */
	public function getJSONObject( $defText = '', $defTitle = '', $defIconUrl = '' ) {
		return array(
			'lat' => $this->getLatitude(),
			'lon' => $this->getLongitude(),
			'alt' => $this->getAltitude(),
			'text' => $this->hasText() ? $this->getText() : $defText,
			'title' => $this->hasTitle() ? $this->getTitle() : $defTitle,
			'address' => $this->getAddress( false ),
			'icon' => $this->hasIcon() ? MapsMapper::getFileUrl( $this->getIcon() ) : $defIconUrl
		);
	}
	
}
