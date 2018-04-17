<?php

namespace Maps\Semantic\DataValues;

use DataValues\Geo\Formatters\GeoCoordinateFormatter;
use DataValues\Geo\Parsers\GeoCoordinateParser;
use DataValues\Geo\Values\LatLongValue;
use InvalidArgumentException;
use MapsDistanceParser;
use SMW\Query\Language\Description;
use SMW\Query\Language\ThingDescription;
use SMWDataItem;
use SMWDataValue;
use SMWDIGeoCoord;
use SMWOutputs;
use ValueParsers\ParseException;

/**
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Markus Krötzsch
 */
class CoordinateValue extends SMWDataValue {

	private $wikiValue;

	/**
	 * Overwrite SMWDataValue::getQueryDescription() to be able to process
	 * comparators between all values.
	 *
	 * @param string $value
	 *
	 * @return Description
	 * @throws InvalidArgumentException
	 */
	public function getQueryDescription( $value ) {
		if ( !is_string( $value ) ) {
			throw new InvalidArgumentException( '$value needs to be a string' );
		}

		list( $distance, $comparator ) = $this->parseUserValue( $value );
		$distance = $this->parserDistance( $distance );

		$this->setUserValue( $value );

		switch ( true ) {
			case !$this->isValid():
				return new ThingDescription();
			case $distance !== false:
				return new \Maps\Semantic\ValueDescriptions\AreaDescription(
					$this->getDataItem(),
					$comparator,
					$distance
				);
			default:
				return new \Maps\Semantic\ValueDescriptions\CoordinateDescription(
					$this->getDataItem(),
					null,
					$comparator
				);
		}
	}

	/**
	 * @see SMWDataValue::parseUserValue
	 */
	protected function parseUserValue( $value ) {
		if ( !is_string( $value ) ) {
			throw new InvalidArgumentException( '$value needs to be a string' );
		}

		$this->wikiValue = $value;

		$comparator = SMW_CMP_EQ;
		$distance = false;

		if ( $value === '' ) {
			$this->addError( wfMessage( 'smw_novalues' )->text() );
		} else {
			SMWDataValue::prepareValue( $value, $comparator );

			list( $coordinates, $distance ) = $this->findValueParts( $value );

			$this->tryParseAndSetDataItem( $coordinates );
		}

		return [ $distance, $comparator ];
	}

	private function findValueParts( string $value ): array {
		$parts = explode( '(', $value );

		$coordinates = trim( array_shift( $parts ) );
		$distance = count( $parts ) > 0 ? trim( array_shift( $parts ) ) : false;

		return [ $coordinates, $distance ];
	}

	private function tryParseAndSetDataItem( string $coordinates ) {
		$parser = new GeoCoordinateParser();

		try {
			$value = $parser->parse( $coordinates );
			$this->m_dataitem = new SMWDIGeoCoord( $value->getLatitude(), $value->getLongitude() );
		}
		catch ( ParseException $parseException ) {
			$this->addError( wfMessage( 'maps_unrecognized_coords', $coordinates, 1 )->text() );

			// Make sure this is always set
			// TODO: Why is this needed?!
			$this->m_dataitem = new SMWDIGeoCoord( [ 'lat' => 0, 'lon' => 0 ] );
		}
	}

	private function parserDistance( $distance ) {
		if ( $distance !== false ) {
			$distance = substr( trim( $distance ), 0, -1 );

			if ( !MapsDistanceParser::isDistance( $distance ) ) {
				$this->addError( wfMessage( 'semanticmaps-unrecognizeddistance', $distance )->text() );
				$distance = false;
			}
		}

		return $distance;
	}

	/**
	 * @see SMWDataValue::getShortHTMLText
	 *
	 * @since 0.6
	 */
	public function getShortHTMLText( $linker = null ) {
		return $this->getShortWikiText( $linker );
	}

	/**
	 * @see SMWDataValue::getShortWikiText
	 */
	public function getShortWikiText( $linked = null ) {
		if ( $this->isValid() ) {
			if ( $this->m_caption === false ) {
				return $this->getFormattedCoord( $this->m_dataitem );
			}

			return $this->m_caption;
		}

		return $this->getErrorText();
	}

	/**
	 * @param SMWDIGeoCoord $dataItem
	 * @param string|null $format
	 *
	 * @return string|null
	 */
	private function getFormattedCoord( SMWDIGeoCoord $dataItem, string $format = null ) {
		global $smgQPCoodFormat;

		$options = new \ValueFormatters\FormatterOptions(
			[
				GeoCoordinateFormatter::OPT_FORMAT => $format === null ? $smgQPCoodFormat : $format, // TODO
			]
		);

		// TODO: $smgQPCoodDirectional

		$coordinateFormatter = new GeoCoordinateFormatter( $options );

		$value = new LatLongValue(
			$dataItem->getLatitude(),
			$dataItem->getLongitude()
		);

		return $coordinateFormatter->format( $value );
	}

	/**
	 * @see SMWDataValue::getLongHTMLText
	 */
	public function getLongHTMLText( $linker = null ) {
		return $this->getLongWikiText( $linker );
	}

	/**
	 * @see SMWDataValue::getLongWikiText
	 *
	 * @since 0.6
	 */
	public function getLongWikiText( $linked = null ) {
		if ( $this->isValid() ) {
			SMWOutputs::requireHeadItem( SMW_HEADER_TOOLTIP );

			// TODO: fix lang keys so they include the space and coordinates.
			$coordinateSet = $this->m_dataitem->getCoordinateSet();

			$text = $this->getFormattedCoord( $this->m_dataitem );

			$lines = [
				wfMessage( 'semanticmaps-latitude', $coordinateSet['lat'] )->inContentLanguage()->escaped(),
				wfMessage( 'semanticmaps-longitude', $coordinateSet['lon'] )->inContentLanguage()->escaped(),
			];

			if ( array_key_exists( 'alt', $coordinateSet ) ) {
				$lines[] = wfMessage( 'semanticmaps-altitude', $coordinateSet['alt'] )->inContentLanguage()->escaped();
			}

			return '<span class="smwttinline">' . htmlspecialchars( $text ) . '<span class="smwttcontent">' .
				implode( '<br />', $lines ) .
				'</span></span>';
		} else {
			return $this->getErrorText();
		}
	}

	/**
	 * @see SMWDataValue::getWikiValue
	 */
	public function getWikiValue() {
		return $this->wikiValue;
	}

	/**
	 * @see SMWDataValue::setDataItem
	 *
	 * @param SMWDataItem $dataItem
	 *
	 * @return boolean
	 */
	protected function loadDataItem( SMWDataItem $dataItem ) {
		if ( $dataItem instanceof SMWDIGeoCoord ) {
			$formattedValue = $this->getFormattedCoord( $dataItem );

			if ( $formattedValue !== null ) {
				$this->wikiValue = $formattedValue;
				$this->m_dataitem = $dataItem;
				return true;
			}
		}

		return false;
	}

	/**
	 * Create links to mapping services based on a wiki-editable message. The parameters
	 * available to the message are:
	 *
	 * $1: The location in non-directional float notation.
	 * $2: The location in directional DMS notation.
	 * $3: The latitude in non-directional float notation.
	 * $4 The longitude in non-directional float notation.
	 *
	 * @return array
	 */
	protected function getServiceLinkParams() {
		$coordinateSet = $this->m_dataitem->getCoordinateSet();
		return [
			$this->getFormattedCoord( $this->m_dataitem, 'float' ), // TODO
			$this->getFormattedCoord( $this->m_dataitem, 'dms' ), // TODO
			$coordinateSet['lat'],
			$coordinateSet['lon']
		];
	}

}
