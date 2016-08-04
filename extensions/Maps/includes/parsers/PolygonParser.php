<?php

namespace Maps;

use Maps\Elements\Line;
use Maps\Elements\Polygon;

/**
 * ValueParser that parses the string representation of a polygon.
 *
 * @since 3.0
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class PolygonParser extends LineParser {

	protected function constructShapeFromLatLongValues( array $locations ) {
		return new Polygon( $locations );
	}

	protected function handleCommonParams( array &$params, Line &$line ) {
		parent::handleCommonParams( $params, $line );
		$this->handlePolygonParams( $params, $line );
	}

	protected function handlePolygonParams( array &$params, Polygon &$polygon ) {
		if ( $fillColor = array_shift( $params ) ) {
			$polygon->setFillColor( $fillColor );
		}

		if ( $fillOpacity = array_shift( $params ) ) {
			$polygon->setFillOpacity( $fillOpacity );
		}

		if ( $showOnlyOnHover = array_shift( $params ) ) {
			$polygon->setOnlyVisibleOnHover( strtolower( trim( $showOnlyOnHover ) ) === 'on' );
		}
	}

}
