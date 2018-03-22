<?php

namespace Maps\Elements;

use DataValues\Geo\Values\LatLongValue;

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
	 * @var LatLongValue
	 */
	private $coordinates;

	/**
	 * @var string
	 */
	private $address;

	/**
	 * @var string
	 */
	private $icon = '';

	/**
	 * @var string
	 */
	private $group = '';

	/**
	 * @var string
	 */
	private $inlineLabel = '';

	/**
	 * @var string
	 */
	private $visitedIcon = '';

	public function __construct( LatLongValue $coordinates ) {
		parent::__construct();
		$this->coordinates = $coordinates;
	}

	public static function newFromLatLon( float $lat, float $lon ): self {
		return new self( new LatLongValue( $lat, $lon ) );
	}

	public function getCoordinates(): LatLongValue {
		return $this->coordinates;
	}

	public function getJSONObject( string $defText = '', string $defTitle = '', string $defIconUrl = '',
		string $defGroup = '', string $defInlineLabel = '', string $defVisitedIcon = '' ): array {

		$parentArray = parent::getJSONObject( $defText, $defTitle );

		$array = [
			'lat' => $this->coordinates->getLatitude(),
			'lon' => $this->coordinates->getLongitude(),
			'icon' => $this->hasIcon() ? \MapsMapper::getFileUrl( $this->getIcon() ) : $defIconUrl,
		];
		$val = $this->getAddress();
		if ( $val !== '' ) {
			$array['address'] = $val;
		}
		$val = $this->hasGroup() ? $this->getGroup() : $defGroup;
		if ( !empty( $val ) ) {
			$array['group'] = $val;
		}
		$val = $this->hasInlineLabel() ? $this->getInlineLabel() : $defInlineLabel;
		if ( !empty( $val ) ) {
			$array['inlineLabel'] = $val;
		}
		$val = $this->hasVisitedIcon() ? $this->getVisitedIcon() : $defVisitedIcon;
		if ( !empty( $val ) ) {
			$array['visitedicon'] = $val;
		}

		return array_merge( $parentArray, $array );
	}

	public function hasIcon(): bool {
		return $this->icon !== '';
	}

	public function getIcon(): string {
		return $this->icon;
	}

	public function setIcon( string $icon ) {
		$this->icon = trim( $icon );
	}

	/**
	 * Returns the address corresponding to this location.
	 * If there is none, and empty sting is returned.
	 */
	public function getAddress(): string {
		if ( is_null( $this->address ) ) {
			$this->address = '';
		}

		return $this->address;
	}

	/**
	 * Returns whether Location is assigned to a group.
	 */
	public function hasGroup(): bool {
		return $this->group !== '';
	}

	public function getGroup(): string {
		return $this->group;
	}

	public function setGroup( string $group ) {
		$this->group = trim( $group );
	}

	public function hasInlineLabel(): bool {
		return $this->inlineLabel !== '';
	}

	public function getInlineLabel(): string {
		return $this->inlineLabel;
	}

	public function setInlineLabel( string $label ) {
		$this->inlineLabel = $label;
	}

	public function hasVisitedIcon(): bool {
		return $this->visitedIcon !== '';
	}

	public function getVisitedIcon(): string {
		return $this->visitedIcon;
	}

	public function setVisitedIcon( string $visitedIcon ) {
		$this->visitedIcon = trim( $visitedIcon );
	}

}
