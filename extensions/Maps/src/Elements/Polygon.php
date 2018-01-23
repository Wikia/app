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
class Polygon extends Line {

	private $onlyVisibleOnHover = false;
	private $fillOpacity = '0.5';
	private $fillColor = '#FF0000';

	public function isOnlyVisibleOnHover(): bool {
		return $this->onlyVisibleOnHover;
	}

	public function setOnlyVisibleOnHover( bool $visible ) {
		$this->onlyVisibleOnHover = $visible;
	}

	public function setFillOpacity( string $fillOpacity ) {
		$this->fillOpacity = $fillOpacity;
	}

	public function setFillColor( string $fillColor ) {
		$this->fillColor = $fillColor;
	}

	public function getJSONObject( string $defText = '', string $defTitle = '' ): array {
		$json = parent::getJSONObject( $defText, $defTitle );

		$json['onlyVisibleOnHover'] = $this->onlyVisibleOnHover;
		$json['fillColor'] = $this->fillColor;
		$json['fillOpacity'] = $this->fillOpacity;

		return $json;
	}

}
