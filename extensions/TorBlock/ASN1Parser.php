<?php

class ASN1Exception extends Exception {
}

class ASN1Parser {
	/* const */ static $tagClasses = array( 'universal', 'application', 'context-specific', 'private' );
	/* const */ static $tagNames = array(
		self::INTEGER => 'INTEGER',
		self::BIT_STRING => 'BIT STRING',
		self::OCTET_STRING => 'OCTET STRING',
		self::NULL => 'NULL',
		self::OBJECT_IDENTIFIER => 'OBJECT IDENTIFIER',
		self::SEQUENCE => 'SEQUENCE',
		self::SET => 'SET',
		self::PrintableString => 'PrintableString',
		self::T61String => 'T61String',
		self::IA5String => 'IA5String',
		self::UTCTime => 'UTCTime'
	);

	const INTEGER = 2;
	const BIT_STRING = 3;
	const OCTET_STRING = 4;
	const NULL = 5;
	const OBJECT_IDENTIFIER = 6;
	const SEQUENCE = 16;
	const SET = 17;
	const PrintableString = 19;
	const T61String = 20;
	const IA5String = 22;
	const UTCTime = 23;

	static function encodeLength($number) {
		if ($number < 128)
			return chr($number);

		$out = pack("N*", $number);
		$out = ltrim( $out, "\0" );

		return chr( 0x80 | strlen($out) ) . $out;
	}

	static function decode($buffer) {
		if ( strlen( $buffer ) < 2 )
			throw new ASN1Exception( 'ASN1 string is too short' );

		$i = 0;
		$result = array();
		while ( $i < strlen( $buffer ) ) {
			$item = array();

			$tag = ord( $buffer[$i] );
			$item['tag-class'] = self::$tagClasses[$tag >> 6];

			$i++;
			$constructed = $tag & 0x20; // Primitive/Constructed bit
			$tag &= 0x1f;

			if ( $tag != 0x1f ) {
				// Great! it's in one octet

				$item['tag'] = $tag;
			} else {
				$tag = 0;
				for (; $i < strlen($buffer); $i++) {
					$t = ord( $buffer[$i] );
					$tag = ( $tag << 7 ) | ( $t & 0x7f );

					// The last octet of the tag identifier will have the high-bit set to 0
					if ( ( $t & 0x80 ) == 0 ) {
						break;
					}
				}
				if ( $i == strlen($buffer) )
					throw new ASN1Exception( 'End of data found when processing tag identifier' );

				$item['tag'] = $tag;
				$i++;
			}

			/* Parse length */
			$length = ord( $buffer[$i] );
			$i++;

			if ( ( $length & 0x80 ) == 0 ) {
				$item['length'] = $length;
			} else {
				$l = $length & 0x7f;
				$lengthBytes = substr( $buffer, $i, $l );
				if ( strlen( $lengthBytes ) != $l ) {
					throw new ASN1Exception( 'Not enough bytes for long-form length' );
				}

				$length = 0;
				for ($j = 0; $j < $l; $j++, $i++) {
					$length = ( $length << 8 ) | ord( $lengthBytes[$j] );

					if ( $length < 0 )
						throw new ASN1Exception( 'Overflow calculating length' );
				}
				$item['length'] = $length;

			}
			$item['contents'] = substr( $buffer, $i, $length );
			$i += $length;

			if ( $constructed ) {
				$item['contents'] = self::decode( $item['contents'] );
			} elseif ( $tag == 6 ) {
				/* We could show the pretty name here instead of the hex dump
				 *
				 * a source could be crypto/objects/objects.txt from openssl
				 * project or crypto/objects/obj_dat.txt (where hexadecimal
				 * data is available )
				 */
				$item['contents'] = $item['contents'];
			}
			/* Else, we leave contents as binary data */

			$result[] = $item;
		}

		return count ( $result ) > 1 ? $result : $result[0];
	}

	/**
	 * Prettifies an array output by decode()
	 */
	static function prettyDecode($decodedArray) {
		$decoded = $decodedArray;
		array_walk_recursive($decoded, array( __CLASS__, 'prettyItem' ) );

		return $decoded;
	}

	static protected function prettyItem(&$value, $key) {
		switch ($key) {
			case 'contents': // Not called when contents is an array
				$value = strlen( $value ) ? '0x' . bin2hex( $value ) : "''";
				break;
			case 'tag':
				if ( isset( self::$tagNames[$value] ) ) {
					$value = self::$tagNames[$value];
				}
				break;
		}
	}

	static function buildTag($tagId, $contents) {
		if ( is_int( $tagId ) &&  $tagId < 31 ) {
			if ( $tagId == self::SEQUENCE || $tagId == self::SET ) {
				$tagId |= 0x20; // Mark as structured data
			}
			$out = chr( $tagId );
		} else {
			throw new ASN1Exception( 'Code to build tags in high-tag-number form is not written yet' );
		}
		$out .= self::encodeLength( strlen( $contents ) );
		$out .= $contents;

		return $out;
	}
}
