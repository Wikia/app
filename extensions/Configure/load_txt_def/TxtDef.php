<?php

class TxtDef {
	private static $arrayReplacements = array();

	public static function loadFromFile( $file, $definitions = array(), $forceLocal = false ) {
		if( function_exists( 'load_txt_def' ) && !$forceLocal ) {
			return load_txt_def( $file, false, $definitions );
		} else {
			return self::phpParser( $file, $definitions );
		}
	}

	private static function phpParser( $file, $definitions ) {
		$lines = file( $file );
		$out = array();
		$head = false;

		if ( isset( $definitions['array'] ) )
			$arrayKeys = (array)$definitions['array'];
		else
			$arrayKeys = array();

		if ( isset( $definitions['allowed'] ) )
			$allowedKeys = (array)$definitions['allowed'];
		else
			$allowedKeys = array();

		foreach( $lines as $line ) {
			$line = trim( preg_replace( '/#.*$/', '', $line ) );
			if( $line == '' )
				continue;

			if( !strpos( $line, '=' ) ) {
				$head = $line;
				$out[$head] = array();
				continue;
			} elseif( $head === false ) {
				trigger_error( "There must be an header before any data in {$file}", E_USER_WARNING );
				return false;
			}

			list( $key, $value ) = array_map( 'trim', explode( '=', $line, 2 ) );

			if( substr( $key, -2 ) == '[]' ) {
				$key = substr( $key, 0, -2 );
				$isArray = true;
			} elseif( in_array( $key, $arrayKeys ) ) {
				$isArray = true;
			} else {
				$isArray = false;
			}

			if( count( $allowedKeys ) && !in_array( $key, $allowedKeys ) ) {
				trigger_error( "The key {$key} is not in the allowed keys in {$file}", E_USER_WARNING );
				return false;
			}

			if( $isArray ) {
				if( !isset( $out[$head][$key] ) )
					$out[$head][$key] = array();

				if( !self::processArray( $out[$head][$key], $value ) )
					return false;
			} else {
				$out[$head][$key] = self::maybeTransformValue( $value );
			}
		}

		if ( isset( $definitions['key'] ) ) {
			$out = self::remapKeys( $out, $definitions['key'] );
		}

		return $out;
	}

	private static function remapKeys( $arr, $key ) {
		$out = array();
		foreach( $arr as $name => $defs ) {
			$out[] = array( $key => $name ) + $defs;
		}
		return $out;
	}

	private static function processArray( &$ret, $string ) {
		$string = self::escapeSubArrays( $string );
		$parts = array_map( 'trim', explode( ',', $string ) );
		foreach( $parts as $part ) {
			if( $part == '' )
				continue;
			if( !strpos( $part, ':' ) ) {
				$ret[] = self::maybeDoSubArray( $part );
			} else {
				list( $key, $val ) = array_map( 'trim', explode( ':', $part ) );
				$ret[$key] = self::maybeDoSubArray( $val );
			}
		}
		return true;
	}

	private static function escapeSubArrays( $string ) {
		return preg_replace_callback( '/\{((?>[^\{\}]+)|(?R))\}/', array( __CLASS__, 'escapeSubArraysCallback' ), $string );
	}

	private static function escapeSubArraysCallback( $m ) {
		$string = $m[1];
		$md5 = md5( $string );
		self::$arrayReplacements[$md5] = $string;
		return "<<$md5>>";
	}

	private static function maybeDoSubArray( $string ) {
		$m = array();
		if( !preg_match( '/<<([0-9a-f]{32})>>/', $string, $m ) )
			return self::maybeTransformValue( $string );

		$md5 = $m[1];
		if( !isset( self::$arrayReplacements[$md5] ) )
			return self::maybeTransformValue( $string );

		$ret = array();
		self::processArray( $ret, self::$arrayReplacements[$md5] );
		return $ret;
	}

	private static function maybeTransformValue( $string ) {
		if( $string == 'true' )
			return true;
		elseif( $string == 'false' )
			return false;
		elseif( $string == 'null' )
			return null;
		else
			return $string;
	}
}
