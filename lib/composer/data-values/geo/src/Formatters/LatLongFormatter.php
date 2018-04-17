<?php

namespace DataValues\Geo\Formatters;

use DataValues\Geo\Values\LatLongValue;
use InvalidArgumentException;
use ValueFormatters\FormatterOptions;
use ValueFormatters\ValueFormatterBase;

/**
 * Geographical coordinates formatter.
 * Formats LatLongValue objects.
 *
 * Supports the following notations:
 * - Degree minute second
 * - Decimal degrees
 * - Decimal minutes
 * - Float
 *
 * Some code in this class has been borrowed from the
 * MapsCoordinateParser class of the Maps extension for MediaWiki.
 *
 * @since 0.1, renamed in 2.0
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Addshore
 * @author Thiemo Mättig
 */
class LatLongFormatter extends ValueFormatterBase {

	/**
	 * Output formats for use with the self::OPT_FORMAT option.
	 */
	const TYPE_FLOAT = 'float';
	const TYPE_DMS = 'dms';
	const TYPE_DM = 'dm';
	const TYPE_DD = 'dd';

	/**
	 * The symbols representing the different directions for usage in directional notation.
	 * @since 0.1
	 */
	const OPT_NORTH_SYMBOL = 'north';
	const OPT_EAST_SYMBOL = 'east';
	const OPT_SOUTH_SYMBOL = 'south';
	const OPT_WEST_SYMBOL = 'west';

	/**
	 * The symbols representing degrees, minutes and seconds.
	 * @since 0.1
	 */
	const OPT_DEGREE_SYMBOL = 'degree';
	const OPT_MINUTE_SYMBOL = 'minute';
	const OPT_SECOND_SYMBOL = 'second';

	/**
	 * Flags for use with the self::OPT_SPACING_LEVEL option.
	 */
	const OPT_SPACE_LATLONG = 'latlong';
	const OPT_SPACE_DIRECTION = 'direction';
	const OPT_SPACE_COORDPARTS = 'coordparts';

	/**
	 * Option specifying the output format (also referred to as output type). Must be one of the
	 * self::TYPE_… constants.
	 */
	const OPT_FORMAT = 'geoformat';

	/**
	 * Boolean option specifying if negative coordinates should have minus signs, e.g. "-1°, -2°"
	 * (false) or cardinal directions, e.g. "1° S, 2° W" (true). Default is false.
	 */
	const OPT_DIRECTIONAL = 'directional';

	/**
	 * Option for the separator character between latitude and longitude. Defaults to a comma.
	 */
	const OPT_SEPARATOR_SYMBOL = 'separator';

	/**
	 * Option specifying the amount and position of space characters in the output. Must be an array
	 * containing zero or more of the self::OPT_SPACE_… flags.
	 */
	const OPT_SPACING_LEVEL = 'spacing';

	/**
	 * Option specifying the precision in fractional degrees. Must be a number or numeric string.
	 */
	const OPT_PRECISION = 'precision';

	public function __construct( FormatterOptions $options = null ) {
		parent::__construct( $options );

		$this->defaultOption( self::OPT_NORTH_SYMBOL, 'N' );
		$this->defaultOption( self::OPT_EAST_SYMBOL, 'E' );
		$this->defaultOption( self::OPT_SOUTH_SYMBOL, 'S' );
		$this->defaultOption( self::OPT_WEST_SYMBOL, 'W' );

		$this->defaultOption( self::OPT_DEGREE_SYMBOL, '°' );
		$this->defaultOption( self::OPT_MINUTE_SYMBOL, "'" );
		$this->defaultOption( self::OPT_SECOND_SYMBOL, '"' );

		$this->defaultOption( self::OPT_FORMAT, self::TYPE_FLOAT );
		$this->defaultOption( self::OPT_DIRECTIONAL, false );

		$this->defaultOption( self::OPT_SEPARATOR_SYMBOL, ',' );
		$this->defaultOption( self::OPT_SPACING_LEVEL, [
			self::OPT_SPACE_LATLONG,
			self::OPT_SPACE_DIRECTION,
			self::OPT_SPACE_COORDPARTS,
		] );
		$this->defaultOption( self::OPT_PRECISION, 0 );
	}

	/**
	 * @see ValueFormatter::format
	 *
	 * Calls formatLatLongValue() using OPT_PRECISION for the $precision parameter.
	 *
	 * @param LatLongValue $value
	 *
	 * @return string Plain text
	 * @throws InvalidArgumentException
	 */
	public function format( $value ) {
		if ( !( $value instanceof LatLongValue ) ) {
			throw new InvalidArgumentException( 'Data value type mismatch. Expected a LatLongValue.' );
		}

		$precision = $this->options->getOption( self::OPT_PRECISION );

		return $this->formatLatLongValue( $value, $precision );
	}

	/**
	 * Formats a LatLongValue with the desired precision.
	 *
	 * @since 0.5
	 *
	 * @param LatLongValue $value
	 * @param float|int $precision The desired precision, given as fractional degrees.
	 *
	 * @return string Plain text
	 * @throws InvalidArgumentException
	 */
	public function formatLatLongValue( LatLongValue $value, $precision ) {
		if ( $precision <= 0 || !is_finite( $precision ) ) {
			$precision = 1 / 3600;
		}

		$formatted = implode(
			$this->getOption( self::OPT_SEPARATOR_SYMBOL ) . $this->getSpacing( self::OPT_SPACE_LATLONG ),
			[
				$this->formatLatitude( $value->getLatitude(), $precision ),
				$this->formatLongitude( $value->getLongitude(), $precision )
			]
		);

		return $formatted;
	}

	/**
	 * @param string $spacingLevel One of the self::OPT_SPACE_… constants
	 *
	 * @return string
	 */
	private function getSpacing( $spacingLevel ) {
		if ( in_array( $spacingLevel, $this->getOption( self::OPT_SPACING_LEVEL ) ) ) {
			return ' ';
		}
		return '';
	}

	/**
	 * @param float $latitude
	 * @param float|int $precision
	 *
	 * @return string
	 */
	private function formatLatitude( $latitude, $precision ) {
		return $this->makeDirectionalIfNeeded(
			$this->formatCoordinate( $latitude, $precision ),
			$this->options->getOption( self::OPT_NORTH_SYMBOL ),
			$this->options->getOption( self::OPT_SOUTH_SYMBOL )
		);
	}

	/**
	 * @param float $longitude
	 * @param float|int $precision
	 *
	 * @return string
	 */
	private function formatLongitude( $longitude, $precision ) {
		return $this->makeDirectionalIfNeeded(
			$this->formatCoordinate( $longitude, $precision ),
			$this->options->getOption( self::OPT_EAST_SYMBOL ),
			$this->options->getOption( self::OPT_WEST_SYMBOL )
		);
	}

	/**
	 * @param string $coordinate
	 * @param string $positiveSymbol
	 * @param string $negativeSymbol
	 *
	 * @return string
	 */
	private function makeDirectionalIfNeeded( $coordinate, $positiveSymbol, $negativeSymbol ) {
		if ( $this->options->getOption( self::OPT_DIRECTIONAL ) ) {
			return $this->makeDirectional( $coordinate, $positiveSymbol, $negativeSymbol );
		}

		return $coordinate;
	}

	/**
	 * @param string $coordinate
	 * @param string $positiveSymbol
	 * @param string $negativeSymbol
	 *
	 * @return string
	 */
	private function makeDirectional( $coordinate, $positiveSymbol, $negativeSymbol ) {
		$isNegative = substr( $coordinate, 0, 1 ) === '-';

		if ( $isNegative ) {
			$coordinate = substr( $coordinate, 1 );
		}

		$symbol = $isNegative ? $negativeSymbol : $positiveSymbol;

		return $coordinate . $this->getSpacing( self::OPT_SPACE_DIRECTION ) . $symbol;
	}

	/**
	 * @param float $degrees
	 * @param float|int $precision
	 *
	 * @return string
	 */
	private function formatCoordinate( $degrees, $precision ) {
		// Remove insignificant detail
		$degrees = $this->roundDegrees( $degrees, $precision );
		$format = $this->getOption( self::OPT_FORMAT );

		if ( $format === self::TYPE_FLOAT ) {
			return $this->getInFloatFormat( $degrees );
		}

		if ( $format !== self::TYPE_DD ) {
			if ( $precision >= 1 - 1 / 60 && $precision < 1 ) {
				$precision = 1;
			} elseif ( $precision >= 1 / 60 - 1 / 3600 && $precision < 1 / 60 ) {
				$precision = 1 / 60;
			}
		}

		if ( $format === self::TYPE_DD || $precision >= 1 ) {
			return $this->getInDecimalDegreeFormat( $degrees, $precision );
		}
		if ( $format === self::TYPE_DM || $precision >= 1 / 60 ) {
			return $this->getInDecimalMinuteFormat( $degrees, $precision );
		}
		if ( $format === self::TYPE_DMS ) {
			return $this->getInDegreeMinuteSecondFormat( $degrees, $precision );
		}

		throw new InvalidArgumentException( 'Invalid coordinate format specified in the options' );
	}

	/**
	 * Round degrees according to OPT_PRECISION
	 *
	 * @param float $degrees
	 * @param float|int $precision
	 *
	 * @return float
	 */
	private function roundDegrees( $degrees, $precision ) {
		$sign = $degrees > 0 ? 1 : -1;
		$reduced = round( abs( $degrees ) / $precision );
		$expanded = $reduced * $precision;

		return $sign * $expanded;
	}

	/**
	 * @param float $floatDegrees
	 *
	 * @return string
	 */
	private function getInFloatFormat( $floatDegrees ) {
		$stringDegrees = (string)$floatDegrees;

		// Floats are fun...
		if ( $stringDegrees === '-0' ) {
			$stringDegrees = '0';
		}

		return $stringDegrees;
	}

	/**
	 * @param float $floatDegrees
	 * @param float|int $precision
	 *
	 * @return string
	 */
	private function getInDecimalDegreeFormat( $floatDegrees, $precision ) {
		$degreeDigits = $this->getSignificantDigits( 1, $precision );
		$stringDegrees = $this->formatNumber( $floatDegrees, $degreeDigits );

		return $stringDegrees . $this->options->getOption( self::OPT_DEGREE_SYMBOL );
	}

	/**
	 * @param float $floatDegrees
	 * @param float|int $precision
	 *
	 * @return string
	 */
	private function getInDegreeMinuteSecondFormat( $floatDegrees, $precision ) {
		$isNegative = $floatDegrees < 0;
		$secondDigits = $this->getSignificantDigits( 3600, $precision );

		$seconds = round( abs( $floatDegrees ) * 3600, max( 0, $secondDigits ) );
		$minutes = (int)( $seconds / 60 );
		$degrees = (int)( $minutes / 60 );

		$seconds -= $minutes * 60;
		$minutes -= $degrees * 60;

		$space = $this->getSpacing( self::OPT_SPACE_COORDPARTS );
		$result = $this->formatNumber( $degrees )
			. $this->options->getOption( self::OPT_DEGREE_SYMBOL )
			. $space
			. $this->formatNumber( $minutes )
			. $this->options->getOption( self::OPT_MINUTE_SYMBOL )
			. $space
			. $this->formatNumber( $seconds, $secondDigits )
			. $this->options->getOption( self::OPT_SECOND_SYMBOL );

		if ( $isNegative && ( $degrees + $minutes + $seconds ) > 0 ) {
			$result = '-' . $result;
		}

		return $result;
	}

	/**
	 * @param float $floatDegrees
	 * @param float|int $precision
	 *
	 * @return string
	 */
	private function getInDecimalMinuteFormat( $floatDegrees, $precision ) {
		$isNegative = $floatDegrees < 0;
		$minuteDigits = $this->getSignificantDigits( 60, $precision );

		$minutes = round( abs( $floatDegrees ) * 60, max( 0, $minuteDigits ) );
		$degrees = (int)( $minutes / 60 );

		$minutes -= $degrees * 60;

		$space = $this->getSpacing( self::OPT_SPACE_COORDPARTS );
		$result = $this->formatNumber( $degrees )
			. $this->options->getOption( self::OPT_DEGREE_SYMBOL )
			. $space
			. $this->formatNumber( $minutes, $minuteDigits )
			. $this->options->getOption( self::OPT_MINUTE_SYMBOL );

		if ( $isNegative && ( $degrees + $minutes ) > 0 ) {
			$result = '-' . $result;
		}

		return $result;
	}

	/**
	 * @param float|int $unitsPerDegree The number of target units per degree
	 * (60 for minutes, 3600 for seconds)
	 * @param float|int $degreePrecision
	 *
	 * @return int The number of digits to show after the decimal point
	 * (resp. before, if the result is negative).
	 */
	private function getSignificantDigits( $unitsPerDegree, $degreePrecision ) {
		return (int)ceil( -log10( $unitsPerDegree * $degreePrecision ) );
	}

	/**
	 * @param float $number
	 * @param int $digits The number of digits after the decimal point.
	 *
	 * @return string
	 */
	private function formatNumber( $number, $digits = 0 ) {
		// TODO: use NumberLocalizer
		return sprintf( '%.' . ( $digits > 0 ? $digits : 0 ) . 'F', $number );
	}

}
