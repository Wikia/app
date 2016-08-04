<?php

namespace Maps\Elements;

use DataValues\Geo\Values\LatLongValue;
use Maps\Geocoders;
use MWException;

/**
 * Class describing a single location (geographical point).
 *
 * TODO: rethink the design of this class after deciding on what actual role it has
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Daniel Werner
 */
class Location extends BaseElement {

	/**
	 * @since 3.0
	 *
	 * @var LatLongValue
	 */
	protected $coordinates;

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
	 * Creates and returns a new instance of a Location from a latitude and longitude.
	 *
	 * @since 1.0
	 *
	 * @param float $lat
	 * @param float $lon
	 *
	 * @return Location
	 */
	public static function newFromLatLon( $lat, $lon ) {
		return new self( new LatLongValue( $lat, $lon ) );
	}

	/**
	 * Creates and returns a new instance of a Location from an address.
	 *
	 * @since 1.0
	 *
	 * @param string $address
	 * @deprecated
	 *
	 * @return Location
	 * @throws MWException
	 */
	public static function newFromAddress( $address ) {
		$address = Geocoders::attemptToGeocode( $address );

		if ( $address === false ) {
			throw new MWException( 'Could not geocode address' );
		}

		return new static( $address );
	}

	/**
	 * Constructor.
	 *
	 * @param LatLongValue $coordinates
	 *
	 * @since 3.0
	 */
	public function __construct( LatLongValue $coordinates ) {
		parent::__construct();
		$this->coordinates = $coordinates;
	}

	/**
	 * Sets the location to a set of coordinates. You can provide a string
	 * of raw coordinates, an array with lat and lon values and false.
	 *
	 * @since 3.0
	 *
	 * @param LatLongValue $coordinates
	 */
	public function setCoordinates( LatLongValue $coordinates ) {
		$this->coordinates = $coordinates;
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
			$coordinates = \Maps\Geocoders::geocode( $address );

			if ( $coordinates === false ) {
				return false;
			}

			$this->setCoordinates( $coordinates );
		}

		$this->address = $address;

		return true;
	}

	/**
	 * Returns the locations coordinates.
	 *
	 * @since 3.0
	 *
	 * @return LatLongValue
	 */
	public function getCoordinates() {
		return $this->coordinates;
	}

	/**
	 * Returns the address corresponding to this location.
	 * If there is none, and empty sting is returned.
	 *
	 * @since 0.7.1
	 *
	 * @return string
	 */
	public function getAddress() {
		if ( is_null( $this->address ) ) {
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
	 * FIXME: complexity
	 *
	 * @since 1.0
	 *
	 * @param string $defText
	 * @param string $defTitle
	 * @param string $defIconUrl
	 * @param string $defGroup
	 * @param string $defInlineLabel
	 * @param string $defVisitedIcon
	 *
	 * @return array
	 */
	public function getJSONObject( $defText = '', $defTitle = '', $defIconUrl = '', $defGroup = '', $defInlineLabel = '', $defVisitedIcon = '' ) {
		$parentArray = parent::getJSONObject( $defText , $defTitle );

		$array = array(
			'lat' => $this->coordinates->getLatitude(),
			'lon' => $this->coordinates->getLongitude(),
			'alt' => 0,
			'address' => $this->getAddress( false ),
			'icon' => $this->hasIcon() ? \MapsMapper::getFileUrl( $this->getIcon() ) : $defIconUrl,
			'group' => $this->hasGroup() ?  $this->getGroup() : $defGroup,
			'inlineLabel' => $this->hasInlineLabel() ? $this->getInlineLabel() : $defInlineLabel,
			'visitedicon' => $this->hasVisitedIcon() ? $this->getVisitedIcon() : $defVisitedIcon,
		);

		return array_merge( $parentArray , $array );
	}

}
