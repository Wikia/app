<?php

/**
 * Static class for distance validation and parsing. Internal representatations are in meters.
 *
 * TODO: migrate to DataValue, ValueParser and ValueFormatter
 *
 * @since 0.6
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsDistanceParser {

	private static $validatedDistanceUnit = false;

	private static $unitRegex = false;

	public static function parseAndFormat( string $distance, string $unit = null, int $decimals = 2 ): string {
		return self::formatDistance( self::parseDistance( $distance ), $unit, $decimals );
	}

	/**
	 * Formats a given distance in meters to a distance in an optionally specified notation.
	 */
	public static function formatDistance( float $meters, string $unit = null, int $decimals = 2 ): string {
		global $wgContLang;
		$meters = $wgContLang->formatNum( round( $meters / self::getUnitRatio( $unit ), $decimals ) );
		return "$meters $unit";
	}

	/**
	 * Returns the unit to meter ratio in a safe way, by first resolving the unit.
	 */
	public static function getUnitRatio( string $unit = null ): float {
		global $egMapsDistanceUnits;
		return $egMapsDistanceUnits[self::getValidUnit( $unit )];
	}

	/**
	 * Returns a valid unit. If the provided one is invalid, the default will be used.
	 */
	public static function getValidUnit( string $unit = null ): string {
		global $egMapsDistanceUnit, $egMapsDistanceUnits;

		// This ensures the value for $egMapsDistanceUnit is correct, and caches the result.
		if ( self::$validatedDistanceUnit === false ) {
			if ( !array_key_exists( $egMapsDistanceUnit, $egMapsDistanceUnits ) ) {
				$units = array_keys( $egMapsDistanceUnits );
				$egMapsDistanceUnit = $units[0];
			}

			self::$validatedDistanceUnit = true;
		}

		if ( $unit == null || !array_key_exists( $unit, $egMapsDistanceUnits ) ) {
			$unit = $egMapsDistanceUnit;
		}

		return $unit;
	}

	/**
	 * Parses a distance optionally containing a unit to a float value in meters.
	 *
	 * @param string $distance
	 *
	 * @return float|false The distance in meters or false on failure
	 */
	public static function parseDistance( string $distance ) {
		if ( !self::isDistance( $distance ) ) {
			return false;
		}

		$distance = self::normalizeDistance( $distance );

		self::initUnitRegex();

		$matches = [];
		preg_match( '/^\d+(\.\d+)?\s?(' . self::$unitRegex . ')?$/', $distance, $matches );

		$value = (float)( $matches[0] . $matches[1] );
		$value *= self::getUnitRatio( $matches[2] );

		return $value;
	}

	public static function isDistance( string $distance ): bool {
		$distance = self::normalizeDistance( $distance );

		self::initUnitRegex();

		return (bool)preg_match( '/^\d+(\.\d+)?\s?(' . self::$unitRegex . ')?$/', $distance );
	}

	/**
	 * Normalizes a potential distance by removing spaces and truning comma's into dots.
	 */
	protected static function normalizeDistance( string $distance ): string {
		$distance = trim( (string)$distance );
		$strlen = strlen( $distance );

		for ( $i = 0; $i < $strlen; $i++ ) {
			if ( !ctype_digit( $distance{$i} ) && !in_array( $distance{$i}, [ ',', '.' ] ) ) {
				$value = substr( $distance, 0, $i );
				$unit = substr( $distance, $i );
				break;
			}
		}

		$value = str_replace( ',', '.', isset( $value ) ? $value : $distance );

		if ( isset( $unit ) ) {
			$value .= ' ' . str_replace( [ ' ', "\t" ], '', $unit );
		}

		return $value;
	}

	private static function initUnitRegex() {
		if ( self::$unitRegex === false ) {
			global $egMapsDistanceUnits;
			self::$unitRegex = implode( '|', array_keys( $egMapsDistanceUnits ) ) . '|';
		}
	}

	/**
	 * Returns a list of all suported units.
	 */
	public static function getUnits(): array {
		global $egMapsDistanceUnits;
		return array_keys( $egMapsDistanceUnits );
	}

}
