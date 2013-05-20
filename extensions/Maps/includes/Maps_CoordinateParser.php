<?php

/**
 * Static class for coordinate validation and parsing.
 * Supports floats, DMS, decimal degrees, and decimal minutes notations, both directional and non-directional.
 * Internal representatations are arrays with lat and lon key with float values.
 * 
 * TODO: 
 * Clean up the coordinate recognition and parsing.
 * It's probably a better approach to use the regexes to do both.
 * Also, the regexes can be improved, so coordinate sets composes of lat and lon
 * in different notations can be recognized, and there is no need for the dms
 * regex to also accept dm and dd, which can give unexpected results in certain
 * usecases. The different seperator support could also be made nice.
 * 
 * @since 0.6
 * @deprecated
 * 
 * @file Maps_CoordinateParser.php
 * @ingroup Maps
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class MapsCoordinateParser {
	
	// The symbols to use for degrees, minutes and seconds. Since 0.7.1.
	const SYMBOL_DEG = '°';
	const SYMBOL_MIN = "'";
	const SYMBOL_SEC = '"';	
	
	protected static $separators = array( ',', ';' );
	protected static $separatorsRegex = false;
	
	protected static $i18nDirections = false; // Cache for localised direction labels
	protected static $directions; // Cache for English direction labels
	
	/**
	 * Takes in a set of coordinates and checks if they are a supported format.
	 * If they are, they will be parsed to a set of non-directional floats, that
	 * will be stored in an array with keys 'lat' and 'lon'. 
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinates The coordinates to be parsed.
	 * 
	 * @return array of float or false
	 */
	public static function parseCoordinates() {
		$params = func_get_args();
		
		if ( count( $params ) == 0 ) {
			return false;
		}
		
		$coordinates = $params[0];
		
		if ( $coordinates === false ) {
			return false;
		}
		
		if ( count( $params ) > 1 ) {
			$coordinates = $params;
		}		
		
		if ( is_array( $coordinates ) ) {
			$coordinates = implode( self::$separators[0], $coordinates );
		}
		
		// Handle i18n notations.
		$coordinates = self::handleI18nLabels( $coordinates );
		
		// Normalize the coordinates string.
		$coordinates = self::normalizeCoordinates( $coordinates );
		
		// Determine what notation the coordinates are in.
		$coordsType = self::getCoordinatesType( $coordinates, false );

		// If getCoordinatesType returned false, the provided value is invalid or in an unsuported notation.
		if ( $coordsType === false ) {
			return false;
		}
		
		// Split the coodrinates string into a lat and lon part.
		foreach ( self::$separators as $separator ) {
			$split = explode( $separator, $coordinates );
			if ( count( $split ) == 2 ) break;
		}
		
		// This should not happen, as the validity of the coordinate set is already ensured by the regexes,
		// but do the check anyway, and return false if it fails.
		if ( count( $split ) != 2 ) {
			return false;
		}

		$coordinates = array(
			'lat' => trim( $split[0] ),
			'lon' => trim( $split[1] ),
		);
		
		// Ensure the coordinates are in non-directional notation.
		$coordinates = self::resolveAngles( $coordinates );
		
		// Parse both latitude and longitude to float notation, and return the result.
		return array(
			'lat' => (float)self::parseCoordinate( $coordinates['lat'], $coordsType ),
			'lon' => (float)self::parseCoordinate( $coordinates['lon'], $coordsType ),
		);
	}
	
	/**
	 * Returns the type of the provided coordinates, or false if they are invalid.
	 * You can use this as validation function, but be sure to use ===, since 0 can be returned.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinates
	 * @param boolean $normalize
	 * 
	 * @return Integer or false
	 */
	public static function getCoordinatesType( $coordinates, $normalize = true ) {
		if ( $normalize ) {
			// Normalize the coordinates string.
			$coordinates = self::normalizeCoordinates( $coordinates );
		}		
		
		switch ( true ) {
			case self::areFloatCoordinates( $coordinates ):
				return Maps_COORDS_FLOAT;
				break;
			case self::areDMSCoordinates( $coordinates ):
				return Maps_COORDS_DMS;
				break;
			case self::areDDCoordinates( $coordinates ):
				return Maps_COORDS_DD;
				break;
			case self::areDMCoordinates( $coordinates ):
				return Maps_COORDS_DM;
				break;
			default:
				return false;
		}
	}
	
	/**
	 * Returns a boolean indicating if the provided value is a valid set of coordinate.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordsOrAddress
	 * 
	 * @return boolean
	 */
	public static function areCoordinates( $coordsOrAddress ) {
		
		// Handle i18n notations.
		$coordsOrAddress = self::handleI18nLabels( $coordsOrAddress );

		return self::getCoordinatesType( $coordsOrAddress ) !== false;
	}
	
	/**
	 * Turns a given coordinate set into a single string that gets formatted
	 * depending on the $targetType and $directional parameters. 
	 * 
	 * they will be parsed to the given notation, which defaults to
	 * non-directional floats
	 * 
	 * @since 0.6
	 * 
	 * @param array $coordinates The set of coordinates that needs to be formatted. Either an associative
	 *        array with lat and lon keys, or a numbered array with lat on index 0, and lon on index 1.
	 * @param coordinate type $targetFormat The notation to which they should be formatted. Defaults to floats.
	 * @param boolean $directional Indicates if the target notation should be directional. Defaults to false.
	 * @param string $separator Delimiter to separate the latitude and longitude with.
	 * 
	 * @return string
	 */
	public static function formatCoordinates( array $coordinates, $targetFormat = Maps_COORDS_FLOAT, $directional = false, $separator = ', ' ) {
		return implode( $separator, self::formatToArray( $coordinates, $targetFormat, $directional ) );
	}

	/**
	 * Turns a given coordinate set into a single string that gets formatted
	 * depending on the $targetType and $directional parameters. 
	 * 
	 * they will be parsed to the given notation, which defaults to
	 * non-directional floats
	 * 
	 * @since 0.6.2
	 * 
	 * @param array $coordinates The set of coordinates that needs to be formatted. Either an associative
	 *        array with lat and lon keys, or a numbered array with lat on index 0, and lon on index 1.
	 * @param coordinate type $targetFormat The notation to which they should be formatted. Defaults to floats.
	 * @param boolean $directional Indicates if the target notation should be directional. Defaults to false.
	 * 
	 * @return array of string
	 */
	public static function formatToArray( array $coordinates, $targetFormat = Maps_COORDS_FLOAT, $directional = false ) {
		if ( !array_key_exists( 'lat', $coordinates ) || !array_key_exists( 'lon', $coordinates ) ) {
			list( $coordinates['lat'], $coordinates['lon'] ) = $coordinates;
		}
		
		$coordinates = array(
			'lat' => self::formatCoordinate( $coordinates['lat'], $targetFormat ),
			'lon' => self::formatCoordinate( $coordinates['lon'], $targetFormat ),
		);
		
		return self::setAngles( $coordinates, $directional );
	}
	
	/**
	 * Returns a normalized version of the provided coordinates.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinates
	 * 
	 * @return string The normalized version of the provided coordinates.
	 */
	protected static function normalizeCoordinates( $coordinates ) {
		$coordinates = str_replace( ' ', '', $coordinates );
		
		$coordinates = str_replace( array( '&#176;', '&deg;' ), self::SYMBOL_DEG, $coordinates );
		$coordinates = str_replace( array( '&acute;', '&#180;' ), self::SYMBOL_SEC, $coordinates );
		$coordinates = str_replace( array( '&#8242;', '&prime;', '´', '′' ), self::SYMBOL_MIN, $coordinates );
		$coordinates = str_replace( array( '&#8243;', '&Prime;', self::SYMBOL_MIN . self::SYMBOL_MIN, '´´', '′′', '″' ), self::SYMBOL_SEC, $coordinates );

		$coordinates = self::removeInvalidChars( $coordinates );

		return $coordinates;
	}
	
	/**
	 * Returns a string with control characters and characters with ascii values above 126 removed.
	 * 
	 * @since 0.6.3
	 * 
	 * @param string $string Yeah, it's a string, seriously!
	 * 
	 * @return string
	 */
	protected static function removeInvalidChars( $string ) {
		$filtered = array();

		foreach ( str_split( $string ) as $character ) {
			$asciiValue = ord( $character );
			
			if ( ( $asciiValue > 31 && $asciiValue < 127 ) || $asciiValue == 194 || $asciiValue == 176 ) {
				$filtered[] = $character;
			}
		}

		return implode( '', $filtered );
	}
	
	/**
	 * Formats a single non-directional float coordinate in the given notation.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinate The coordinate to be formatted.
	 * @param coordinate type $targetFormat The notation to which they should be formatted.
	 * 
	 * @return string
	 */
	protected static function formatCoordinate( $coordinate, $targetFormat ) {
		$coordinate = (float)$coordinate;
		
		switch ( $targetFormat ) {
			case Maps_COORDS_FLOAT:
				return $coordinate;
			case Maps_COORDS_DMS:
				$isNegative = $coordinate < 0;
				$coordinate = abs( $coordinate );
				
				$degrees = floor( $coordinate );
				$minutes = ( $coordinate - $degrees ) * 60;
				$seconds = ( $minutes - floor( $minutes ) ) * 60;
				
				$result = $degrees . self::SYMBOL_DEG . ' ' . floor( $minutes ) . self::SYMBOL_MIN . ' ' . round( $seconds ) . self::SYMBOL_SEC;
				if ( $isNegative ) $result = '-' . $result;
				
				return $result;
			case Maps_COORDS_DD:
				return $coordinate . self::SYMBOL_DEG;
			case Maps_COORDS_DM:
				$coordinate = abs( $coordinate );
				$degrees = floor( $coordinate );
				
				return sprintf(
					"%s%d%s %0.3f%s",
					$coordinate < 0 ? '-' : '',
					$degrees, self::SYMBOL_DEG,
					( $coordinate - $degrees ) * 60, self::SYMBOL_MIN
				);
			default:
				throw new MWException( __METHOD__ . " does not support formatting of coordinates to the $targetFormat notation." );
		}
	}
	
	/**
	 * Parses a coordinate that's in the provided notation to float representatation.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinate The coordinate to be parsed.
	 * @param coordinate type $coordType The notation the coordinate is currently in.
	 * 
	 * @return string
	 */
	protected static function parseCoordinate( $coordinate, $coordType ) {
		switch ( $coordType ) {
			case Maps_COORDS_FLOAT:
				return $coordinate;
			case Maps_COORDS_DD:
				return self::parseDDCoordinate( $coordinate );				
			case Maps_COORDS_DM:
				return self::parseDMCoordinate( $coordinate );				
			case Maps_COORDS_DMS:
				return self::parseDMSCoordinate( $coordinate );
			default:
				throw new MWException( __METHOD__ . " does not support parsing of the $coordType coordinate type." );
		}
	}
	
	/**
	 * returns whether the coordinates are in float representation.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinates
	 * 
	 * @return boolean
	 */
	public static function areFloatCoordinates( $coordinates ) {
		$sep = self::getSeparatorsRegex();
		return preg_match( '/^(-)?\d{1,3}(\.\d{1,20})?' . $sep . '(-)?\d{1,3}(\.\d{1,20})?$/i', $coordinates ) // Non-directional
			|| preg_match( '/^\d{1,3}(\.\d{1,20})?(N|S)' . $sep . '\d{1,3}(\.\d{1,20})?(E|W)$/i', $coordinates ); // Directional
	}
	
	/**
	 * returns whether the coordinates are in DMS representation.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinates
	 * 
	 * @return boolean
	 */
	public static function areDMSCoordinates( $coordinates ) {
		$sep = self::getSeparatorsRegex();
		return preg_match( '/^(-)?(\d{1,3}°)(\d{1,2}(\′|\'))?((\d{1,2}(″|"))?|(\d{1,2}\.\d{1,20}(″|"))?)'
			. $sep . '(-)?(\d{1,3}°)(\d{1,2}(\′|\'))?((\d{1,2}(″|"))?|(\d{1,2}\.\d{1,20}(″|"))?)$/i', $coordinates ) // Non-directional
			|| preg_match( '/^(\d{1,3}°)(\d{1,2}(\′|\'))?((\d{1,2}(″|"))?|(\d{1,2}\.\d{1,20}(″|"))?)(N|S)'
			. $sep . '(\d{1,3}°)(\d{1,2}(\′|\'))?((\d{1,2}(″|"))?|(\d{1,2}\.\d{1,20}(″|"))?)(E|W)$/i', $coordinates ); // Directional
	}

	/**
	 * returns whether the coordinates are in Decimal Degree representation.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinates
	 * 
	 * @return boolean
	 */
	public static function areDDCoordinates( $coordinates ) {
		$sep = self::getSeparatorsRegex();
		return preg_match( '/^(-)?\d{1,3}(|\.\d{1,20})°' . $sep . '(-)?\d{1,3}(|\.\d{1,20})°$/i', $coordinates ) // Non-directional
			|| preg_match( '/^\d{1,3}(|\.\d{1,20})°(N|S)' . $sep . '\d{1,3}(|\.\d{1,20})°(E|W)?$/i', $coordinates ); // Directional
	}
	
	/**
	 * returns whether the coordinates are in Decimal Minute representation.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinates
	 * 
	 * @return boolean
	 */
	public static function areDMCoordinates( $coordinates ) {
		$sep = self::getSeparatorsRegex();
		return preg_match( '/(-)?\d{1,3}°(\d{1,2}(\.\d{1,20}\')?)?' . $sep . '(-)?\d{1,3}°(\d{1,2}(\.\d{1,20}\')?)?$/i', $coordinates ) // Non-directional
			|| preg_match( '/\d{1,3}°(\d{1,2}(\.\d{1,20}\')?)?(N|S)' . $sep . '\d{1,3}°(\d{1,2}(\.\d{1,20}\')?)?(E|W)?$/i', $coordinates ); // Directional
	}
	
	/**
	 * Turn i18n labels into English ones, for both validation and ease of handling.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinates
	 * 
	 * @return string
	 */
	private static function handleI18nLabels( $coordinates ) {
		self::initializeDirectionLabels();
		return str_replace( self::$i18nDirections, self::$directions, $coordinates );
	}
	
	/**
	 * Initialize the cache for internationalized direction labels if not done yet. 
	 * 
	 * @since 0.6
	 */
	protected static function initializeDirectionLabels() {
		global $egMapsInternatDirectionLabels;
		
		if ( !self::$i18nDirections ) {
			if ( $egMapsInternatDirectionLabels ) {
				self::$i18nDirections = array(
					'N' => wfMsgForContent( 'maps-abb-north' ),
					'E' => wfMsgForContent( 'maps-abb-east' ),
					'S' => wfMsgForContent( 'maps-abb-south' ),
					'W' => wfMsgForContent( 'maps-abb-west' ),
				);				
			}
			else {
				self::$i18nDirections = array(
					'N' => 'N',
					'E' => 'E',
					'S' => 'S',
					'W' => 'W',
				);					
			}

			self::$directions = array_keys( self::$i18nDirections );
		}
	}
	
	/**
	 * Turns directional notation (N/E/S/W) of a coordinate set into non-directional notation (+/-).
	 * 
	 * @since 0.6
	 * 
	 * @param array $coordinates
	 * 
	 * @return array
	 */
	protected static function resolveAngles( array $coordinates ) {
		return array(
			'lat' => self::resolveAngle( $coordinates['lat'] ),
			'lon' => self::resolveAngle( $coordinates['lon'] ),
		);
	}
	
	/**
	 * Turns directional notation (N/E/S/W) of a single coordinate into non-directional notation (+/-).
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinate
	 * 
	 * @return string
	 */
	protected static function resolveAngle( $coordinate ) {
		// Get the last char, which could be a direction indicator
		$lastChar = strtoupper( substr( $coordinate, -1 ) );
		
		// If there is a direction indicator, remove it, and prepend a minus sign for south and west directions.
		// If there is no direction indicator, the coordinate is already non-directional and no work is required.
		if ( in_array( $lastChar, self::$directions ) ) {
			$coordinate = substr( $coordinate, 0, -1 );
			
			if ( ( $lastChar == 'S' ) or ( $lastChar == 'W' ) ) {
				$coordinate = '-' . trim( $coordinate );
			}
		}
		
		return $coordinate;
	}
	
	/**
	 * Turns non-directional notation in directional notation when needed.
	 * 
	 * @since 0.6
	 * 
	 * @param array $coordinates The coordinates set to possibly make directional. Needs to be non-directional!
	 * 
	 * @return array
	 */
	protected static function setAngles( array $coordinates, $directional ) {
		if ( $directional ) {
			return array(
				'lat' => self::setDirectionalAngle( $coordinates['lat'], true ),
				'lon' => self::setDirectionalAngle( $coordinates['lon'], false ),
			);
		} else {
			return $coordinates;
		}
	}
	
	/**
	 * Turns non-directional notation in directional notation.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinate The coordinate to make directional. Needs to be non-directional!
	 * @param boolean $isLat Should be true for latitudes and false for longitudes.
	 * 
	 * @return string
	 */
	protected static function setDirectionalAngle( $coordinate, $isLat ) {
		self::initializeDirectionLabels();
		
		$coordinate = (string)$coordinate;
		$isNegative = $coordinate{0} == '-';
		
		if ( $isNegative ) $coordinate = substr( $coordinate, 1 );
		
		if ( $isLat ) {
			$directionChar = self::$i18nDirections[ $isNegative ? 'S' : 'N' ];
		} else {
			$directionChar = self::$i18nDirections[ $isNegative ? 'W' : 'E' ];
		}

		return $coordinate . ' ' . $directionChar;
	}
	
	/**
	 * Takes a set of coordinates in DMS representation, and returns them in float representation.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinate
	 * 
	 * @return string
	 */
	protected static function parseDMSCoordinate( $coordinate ) {
		if ( !is_string( $coordinate ) ) {
			throw new MWException( 'Parameter $coordinate must be a string at ' . __METHOD__ );
		}
		
		$isNegative = $coordinate{0} == '-';
		if ( $isNegative ) $coordinate = substr( $coordinate, 1 );
		
		$degreePosition = strpos( $coordinate, self::SYMBOL_DEG );
		$degrees = substr ( $coordinate, 0, $degreePosition );
		
		$minutePosition = strpos( $coordinate, self::SYMBOL_MIN );
		
		if ( $minutePosition === false ) {
			$minutes = 0;
		}
		else {
			$degSignLength = strlen( self::SYMBOL_DEG );
			$minuteLength = $minutePosition - $degreePosition - $degSignLength;
			$minutes = substr ( $coordinate, $degreePosition + $degSignLength, $minuteLength );
		}
		
		$secondPosition = strpos( $coordinate, self::SYMBOL_SEC );
		
		if ( $minutePosition === false ) {
			$seconds = 0;
		}
		else {
			$secondLength = $secondPosition - $minutePosition - 1;
			$seconds = substr ( $coordinate, $minutePosition + 1, $secondLength );			
		}
		
		$coordinate = $degrees + ( $minutes + $seconds / 60 ) / 60;
		if ( $isNegative ) $coordinate *= -1;
		
		return $coordinate;
	}

	/**
	 * Takes a set of coordinates in Decimal Degree representation, and returns them in float representation.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinate
	 * 
	 * @return string
	 */
	protected static function parseDDCoordinate( $coordinate ) {
		return (float)str_replace( self::SYMBOL_DEG, '', $coordinate );
	}
	
	/**
	 * Takes a set of coordinates in Decimal Minute representation, and returns them in float representation.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinate
	 * 
	 * @return string
	 */
	protected static function parseDMCoordinate( $coordinate ) {
		$isNegative = $coordinate{0} == '-';
		if ( $isNegative ) $coordinate = substr( $coordinate, 1 );
		
		list( $degrees, $minutes ) = explode( self::SYMBOL_DEG, $coordinate );
		
		$minutes = substr( $minutes, 0, -1 );
		
		$coordinate = $degrees + $minutes / 60;
		if ( $isNegative ) $coordinate *= -1;
		
		return $coordinate;
	}
	
	/**
	 * Gets a regex group that allows only the supported separators.
	 * 
	 * @since 0.6.2
	 * 
	 * @return string
	 */
	protected static function getSeparatorsRegex() {
		if ( !self::$separatorsRegex ) self::$separatorsRegex = '(' . implode( '|', self::$separators ) . ')';
		return self::$separatorsRegex;
	}
	
	/**
	 * Parse a string containing coordinates and return the same value in the specified notation.
	 * 
	 * @since 0.6
	 * 
	 * @param string $coordinates
	 * @param $targetFormat
	 * @param boolean $directional
	 * 
	 * return string
	 */
	public static function parseAndFormat( $coordinates, $targetFormat = Maps_COORDS_FLOAT, $directional = false ) {
		$parsedCoords = self::parseCoordinates( $coordinates );
		
		if ( $parsedCoords ) {
			return self::formatCoordinates( $parsedCoords, $targetFormat, $directional );
		} else {
			return false;
		}
	}
	
}
