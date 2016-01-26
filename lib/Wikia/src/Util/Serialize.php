<?php
/**
 * Safe serialize() and unserialize() replacements
 * From https://github.com/piwik/piwik/blob/master/libs/upgradephp/upgrade.php#L373-L602
 *
 * @license Public Domain
 *
 * @author anthon (dot) pang (at) gmail (dot) com
 */

namespace Wikia\Util;

use Wikia\Logger\WikiaLogger;

class Serialize {
	const MAX_SERIALIZED_INPUT_LENGTH = 4096;
	const MAX_SERIALIZED_ARRAY_LENGTH = 256;
	const MAX_SERIALIZED_ARRAY_DEPTH = 3;

	/**
	 * Wrapper for _safe_serialize() that handles exceptions and multibyte encoding issue
	 *
	 * @param mixed $value
	 * @return string
	 */
	public static function safeSerialize( $value ) {
		// ensure we use the byte count for strings even when strlen() is overloaded by mb_strlen()
		if ( function_exists( 'mb_internal_encoding' ) &&
			( ( (int) ini_get( 'mbstring.func_overload' ) ) & 2 )
		) {
			$mbIntEnc = mb_internal_encoding();
			mb_internal_encoding( 'ASCII' );
		}

		$out = self::doSafeSerialize($value);
		if ( isset( $mbIntEnc ) ) {
			mb_internal_encoding( $mbIntEnc );
		}
		return $out;
	}

	/**
	 * Wrapper for _safe_unserialize() that handles exceptions and multibyte encoding issue
	 *
	 * @param string $str
	 * @return mixed
	 */
	public static function safeUnserialize( $str ) {
		// ensure we use the byte count for strings even when strlen() is overloaded by mb_strlen()
		if ( function_exists( 'mb_internal_encoding' ) &&
			( ( (int) ini_get( 'mbstring.func_overload' ) ) & 2 )
		) {
			$mbIntEnc = mb_internal_encoding();
			mb_internal_encoding( 'ASCII' );
		}
		$out = self::doSafeUnserialize($str);
		if ( isset( $mbIntEnc ) ) {
			mb_internal_encoding( $mbIntEnc );
		}
		return $out;
	}

	/**
	 * Safe serialize() replacement
	 * - output a strict subset of PHP's native serialized representation
	 * - does not serialize objects
	 *
	 * @param mixed $value
	 * @return string|boolean
	 * @throw Exception if $value is malformed or contains unsupported types (e.g., resources, objects)
	 */
	private static function doSafeSerialize( $value ) {
		if ( is_null( $value ) ) {
			return 'N;';
		}
		if ( is_bool( $value ) ) {
			return 'b:' . (int)$value .';';
		}
		if ( is_int( $value ) ) {
			return 'i:' . $value . ';';
		}
		if ( is_float( $value ) ) {
			return 'd:' . str_replace( ',', '.', $value ) . ';';
		}
		if ( is_string( $value ) ) {
			return 's:' . strlen( $value ) . ':"' . $value . '";';
		}
		if ( is_array( $value ) ) {
			$out = '';
			foreach ( $value as $k => $v ) {
				$out .= self::doSafeSerialize( $k ) . self::doSafeSerialize( $v );
			}

			return 'a:' . count( $value ) . ':{' . $out . '}';
		}
		// safe_serialize cannot serialize resources or objects
		return false;
	}

	/**
	 * Safe unserialize() replacement
	 * - accepts a strict subset of PHP's native serialized representation
	 * - does not unserialize objects
	 *
	 * @param string $str
	 * @return mixed
	 * @throw Exception if $str is malformed or contains unsupported types (e.g., resources, objects)
	 */
	private static function doSafeUnserialize( $str ) {
		if ( strlen( $str ) > self::MAX_SERIALIZED_INPUT_LENGTH ) {
			// input exceeds MAX_SERIALIZED_INPUT_LENGTH
			WikiaLogger::instance()->error( 'Serialized input exceeds MAX_SERIALIZED_INPUT_LENGTH' );
			return false;
		}
		if ( empty( $str ) || !is_string( $str ) ) {
			return false;
		}
		$stack = array();
		$expected = array();
		/*
		 * states:
		 *   0 - initial state, expecting a single value or array
		 *   1 - terminal state
		 *   2 - in array, expecting end of array or a key
		 *   3 - in array, expecting value or another array
		 */
		$state = 0;
		while ( $state != 1 ) {
			$type = isset( $str[0] ) ? $str[0] : '';
			if ( $type == '}' ) {
				$str = substr( $str, 1 );
			} elseif ( $type == 'N' && $str[1] == ';' ) {
				$value = null;
				$str = substr( $str, 2 );
			} elseif ( $type == 'b' && preg_match( '/^b:([01]);/', $str, $matches ) ) {
				$value = $matches[1] == '1' ? true : false;
				$str = substr( $str, 4 );
			} elseif ( $type == 'i' && preg_match( '/^i:(-?[0-9]+);(.*)/s', $str, $matches ) ) {
				$value = (int)$matches[1];
				$str = $matches[2];
			} elseif ( $type == 'd' && preg_match( '/^d:(-?[0-9]+\.?[0-9]*(E[+-][0-9]+)?);(.*)/s', $str, $matches ) ) {
				$value = (float)$matches[1];
				$str = $matches[3];
			} elseif ( $type == 's' && preg_match( '/^s:([0-9]+):"(.*)/s', $str, $matches ) && substr( $matches[2], (int)$matches[1], 2 ) == '";' ) {
				$value = substr( $matches[2], 0, (int)$matches[1] );
				$str = substr( $matches[2], (int)$matches[1] + 2 );
			} elseif ( $type == 'a' && preg_match( '/^a:([0-9]+):{(.*)/s', $str, $matches ) && $matches[1] < self::MAX_SERIALIZED_ARRAY_LENGTH ) {
				$expectedLength = (int)$matches[1];
				$str = $matches[2];
			} else {
				// object or unknown/malformed type
				WikiaLogger::instance()->error( 'Serialized object or unknown/malformed type' );
				return false;
			}
			switch ( $state ) {
				case 3: // in array, expecting value or another array
					if ( $type == 'a' ) {
						if ( count( $stack ) >= self::MAX_SERIALIZED_ARRAY_DEPTH ) {
							// array nesting exceeds MAX_SERIALIZED_ARRAY_DEPTH
							WikiaLogger::instance()->error( 'Serialized array nesting exceeds MAX_SERIALIZED_ARRAY_DEPTH' );
							return false;
						}
						$stack[] = &$list;
						$list[$key] = array();
						$list = &$list[$key];
						$expected[] = $expectedLength;
						$state = 2;
						break;
					}
					if ( $type != '}' ) {
						$list[$key] = $value;
						$state = 2;
						break;
					}
					// missing array value
					return false;
				case 2: // in array, expecting end of array or a key
					if ( $type == '}' ) {
						if ( count( $list ) < end( $expected ) ) {
							// array size less than expected
							return false;
						}
						unset( $list );
						$list = &$stack[count( $stack ) - 1];
						array_pop( $stack );
						// go to terminal state if we're at the end of the root array
						array_pop( $expected );
						if ( count( $expected ) == 0 ) {
							$state = 1;
						}
						break;
					}
					if ( $type == 'i' || $type == 's' ) {
						if ( count( $list ) >= self::MAX_SERIALIZED_ARRAY_LENGTH ) {
							// array size exceeds MAX_SERIALIZED_ARRAY_LENGTH
							WikiaLogger::instance()->error( 'Serialized array size exceeds MAX_SERIALIZED_ARRAY_LENGTH' );
							return false;
						}
						if ( count( $list ) >= end( $expected ) ) {
							// array size exceeds expected length
							return false;
						}
						$key = $value;
						$state = 3;
						break;
					}
					// illegal array index type
					return false;
				case 0: // expecting array or value
					if ( $type == 'a' ) {
						if ( count( $stack ) >= self::MAX_SERIALIZED_ARRAY_DEPTH ) {
							// array nesting exceeds MAX_SERIALIZED_ARRAY_DEPTH
							WikiaLogger::instance()->error( 'Serialized array nesting exceeds MAX_SERIALIZED_ARRAY_DEPTH' );
							return false;
						}
						$data = array();
						$list = &$data;
						$expected[] = $expectedLength;
						$state = 2;
						break;
					}
					if ( $type != '}' ) {
						$data = $value;
						$state = 1;
						break;
					}
					// not in array
					return false;
			}
		}
		if ( !empty( $str ) ) {
			// trailing data in input
			return false;
		}
		return $data;
	}
}
