<?php

namespace Maps\Elements;

use InvalidArgumentException;

/**
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Kim Eik < kim@heldig.org >
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class Polygon extends Line implements \iHoverableMapElement {

	protected $onlyVisibleOnHover = false;
	protected $fillOpacity = '0.5';
	protected $fillColor = '#FF0000';

	/**
	 * @since 3.0
	 *
	 * @param boolean $visible
	 *
	 * @throws InvalidArgumentException
	 */
	public function setOnlyVisibleOnHover( $visible ) {
		if ( !is_bool( $visible ) ) {
			throw new InvalidArgumentException( '$visible should be a boolean' );
		}

		$this->onlyVisibleOnHover = $visible;
	}

	/**
	 * @since 3.0
	 *
	 * @return boolean
	 */
	public function isOnlyVisibleOnHover() {
		return $this->onlyVisibleOnHover;
	}

	public function setFillOpacity( $fillOpacity ) {
		if ( !is_string( $fillOpacity ) ) {
			throw new InvalidArgumentException( '$fillOpacity should be a string' );
		}

		$this->fillOpacity = $fillOpacity;
	}

	public function setFillColor( $fillColor ) {
		if ( !is_string( $fillColor ) ) {
			throw new InvalidArgumentException( '$fillColor should be a string' );
		}

		$this->fillColor = $fillColor;
	}

	public function getJSONObject( $defText = '' , $defTitle = '' ) {
		$json = parent::getJSONObject( $defText, $defTitle );

		$json['onlyVisibleOnHover'] = $this->onlyVisibleOnHover;
		$json['fillColor'] = $this->fillColor;
		$json['fillOpacity'] = $this->fillOpacity;

		return $json;
	}

}
