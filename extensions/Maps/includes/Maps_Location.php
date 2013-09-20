<?php

/**
 * Class describing a single location (geographical point).
 *
 * @since 0.7.1
 *
 * @file Maps_Location.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Daniel Werner
 */
class MapsLocation extends MapsBaseElement {

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
	protected $icon = '';

	/**
	 * @since 2.0
	 *
	 * @var string
	 */
	protected $group = '';

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
	 * @var string
	 * @since 2.0
	 */
	protected $inlineLabel = '';

	/**
	 * @var string
	 * @since 2.0
	 */
	protected $visitedIcon = '';

	/**
	 * Creates and returns a new instance of a MapsLocation from a latitude and longitude.
	 *
	 * @since 1.0
	 *
	 * @param float $lat
	 * @param float $lon
	 * @param string $format
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
	 * @param string $format
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
	 * @param string $format
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
			throw new MWException( 'Attempt to get the latitude of an invalid location' );
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
			throw new MWException( 'Attempt to get the longitude of an invalid location' );
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
			throw new MWException( 'Attempt to get the altitude of an invalid location' );
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
			throw new MWException( 'Attempt to get the coordinates for an invalid location' );
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
			throw new MWException( 'Attempt to get the address of an invalid location' );
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
		$this->icon = trim( $icon );
	}

	/**
	 * Sets the group
	 *
	 * @since 2.0
	 *
	 * @param string $group
	 */
	public function setGroup( $group ) {
		$this->group = trim( $group );
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
	 * Returns the group.
	 *
	 * @since 2.0
	 *
	 * @return string
	 */
	public function getGroup() {
		return $this->group;
	}

	/**
	 * Returns whether Location is asigned to a group.
	 *
	 * @since 2.0
	 *
	 * @return string
	 */
	public function hasGroup() {
		return $this->group !== '';
	}

	/**
	 * @return string
	 * @since 2.0
	 */
	public function getInlineLabel(){
		return $this->inlineLabel;
	}

	/**
	 * @param $label
	 * @since 2.0
	 */
	public function setInlineLabel($label){
		$this->inlineLabel = $label;
	}

	/**
	 * @return bool
	 * @since 2.0
	 */
	public function hasInlineLabel(){
		return $this->inlineLabel !== '';
	}

	/**
	 * @return string
	 * @since 2.0
	 */
	public function getVisitedIcon() {
		return $this->visitedIcon;
	}

	/**
	 * @param $visitedIcon
	 * @since 2.0
	 */
	public function setVisitedIcon( $visitedIcon ) {
		$this->visitedIcon = trim($visitedIcon);
	}

	/**
	 * @return bool
	 * @since 2.0
	 */
	public function hasVisitedIcon(){
		return $this->visitedIcon !== '';
	}

	/**
	 * Returns an object that can directly be converted to JS using json_encode or similar.
	 *
	 * @since 1.0
	 *
	 * @param string $defText
	 * @param string $defTitle
	 * @param string $defIconUrl
	 * @param string $defGroup
	 * @param string $defInlineLabel
	 *
	 * @return object
	 */
	public function getJSONObject( $defText = '', $defTitle = '', $defIconUrl = '', $defGroup = '', $defInlineLabel = '', $defVisitedIcon = '' ) {
		$parentArray = parent::getJSONObject( $defText , $defTitle );
		$array = array(
			'lat' => $this->getLatitude(),
			'lon' => $this->getLongitude(),
			'alt' => $this->getAltitude(),
			'address' => $this->getAddress( false ),
			'icon' => $this->hasIcon() ? MapsMapper::getFileUrl( $this->getIcon() ) : $defIconUrl,
			'group' => $this->hasGroup() ?  $this->getGroup() : $defGroup,
			'inlineLabel' => $this->hasInlineLabel() ? $this->getInlineLabel() : $defInlineLabel,
			'visitedicon' => $this->hasVisitedIcon() ? $this->getVisitedIcon() : $defVisitedIcon,
		);
		return array_merge( $parentArray , $array );
	}

}
