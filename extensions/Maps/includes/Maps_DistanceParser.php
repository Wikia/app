<?php

/**
 * Static class for distance validation and parsing. Internal representatations are in meters.
 * 
 * @file Maps_DistanceParser.php
 * @ingroup Maps
 * 
 * @since 0.6
 * 
 * @author Jeroen De Dauw
 */
class MapsDistanceParser {
	
	private static $validatedDistanceUnit = false;
	
	private static $unitRegex = false;
	
	/**
	 * Parses a distance optionally containing a unit to a float value in meters.
	 * 
	 * @since 0.6
	 * 
	 * @param string $distance
	 * 
	 * @return float The distance in meters.
	 */
	public static function parseDistance( $distance ) {
		if ( !self::isDistance( $distance ) ) {
			return false;
		}
		
		$distance = self::normalizeDistance( $distance );
		
		self::initUnitRegex();
		
		$matches = array();
		preg_match( '/^\d+(\.\d+)?\s?(' . self::$unitRegex . ')?$/', $distance, $matches );

		$value = (float)( $matches[0] . $matches[1] );
		$value *= self::getUnitRatio( $matches[2] );
		
		return $value;
	}
	
	/**
	 * Formats a given distance in meters to a distance in an optionally specified notation.
	 * 
	 * @since 0.6
	 * 
	 * @param float $meters
	 * @param string $unit
	 * @param integer $decimals
	 * 
	 * @return string
	 */
	public static function formatDistance( $meters, $unit = null, $decimals = 2 ) {
		global $wgContLang;
		$meters = $wgContLang->formatNum( round( $meters / self::getUnitRatio( $unit ), $decimals ) );
		return "$meters $unit";
	}
	
	/**
	 * Shortcut for converting from one unit to another.
	 * 
	 * @since 0.6
	 * 
	 * @param string $distance
	 * @param string $unit
	 * @param integer $decimals
	 * 
	 * @return string
	 */
	public static function parseAndFormat( $distance, $unit = null, $decimals = 2 ) {
		return self::formatDistance( self::parseDistance( $distance ), $unit, $decimals );
	}
	
	/**
	 * Returns if the provided string is a valid distance.
	 * 
	 * @since 0.6
	 * 
	 * @param string $distance
	 * 
	 * @return boolean
	 */
	public static function isDistance( $distance ) {
		$distance = self::normalizeDistance( $distance );
		
		self::initUnitRegex();

		return (bool)preg_match( '/^\d+(\.\d+)?\s?(' . self::$unitRegex . ')?$/', $distance );
	}
	
	/**
	 * Returns the unit to meter ratio in a safe way, by first resolving the unit.
	 * 
	 * @since 0.6.2
	 * 
	 * @param string $unit
	 * 
	 * @return float
	 */
	public static function getUnitRatio( $unit = null ) {
		global $egMapsDistanceUnits;
		return $egMapsDistanceUnits[self::getValidUnit( $unit )];
	}
	
	/**
	 * Returns a valid unit. If the provided one is invalid, the default will be used.
	 * 
	 * @since 0.6.2
	 * 
	 * @param string $unit
	 * 
	 * @return string
	 */
	public static function getValidUnit( $unit = null ) {
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
	 * Returns a list of all suported units.
	 * 
	 * @since 0.6
	 * 
	 * @return array
	 */
	public static function getUnits() {
		global $egMapsDistanceUnits;
		return array_keys( $egMapsDistanceUnits );
	}
	
	/**
	 * Normalizes a potential distance by removing spaces and truning comma's into dots.
	 * 
	 * @since 0.6.5
	 * 
	 * @param $distance String
	 * 
	 * @return string
	 */
	protected static function normalizeDistance( $distance ) {
		$distance = trim( (string)$distance );
		$strlen = strlen( $distance );
		
		for ( $i = 0; $i < $strlen; $i++ ) {
			if ( !ctype_digit( $distance{$i} ) && !in_array( $distance{$i}, array( ',', '.' ) ) ) {
				$value = substr( $distance, 0, $i );
				$unit = substr( $distance, $i );
				break;
			}
		}
		
		$value = str_replace( ',', '.', isset( $value ) ? $value : $distance );
		
		if ( isset( $unit ) ) {
			$value .= ' ' . str_replace( array( ' ', "\t" ), '', $unit );
		}

		return $value;
	}
	
	private static function initUnitRegex() {
		if ( self::$unitRegex === false ) {
			global $egMapsDistanceUnits;
			self::$unitRegex = implode( '|', array_keys( $egMapsDistanceUnits ) ) . '|';
		}		
	}
	
}