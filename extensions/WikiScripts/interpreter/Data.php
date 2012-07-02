<?php
/**
 * Built-in scripting language for MediaWiki: data.
 * Based on the AbuseFilter AFData.
 * Copyright (C) 2008-2011 Victor Vasiliev <vasilvv@gmail.com>, Andrew Garrett <andrew@epstone.net>
 * http://www.mediawiki.org/
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

if( !defined( 'MEDIAWIKI' ) )
	die();

/**
 * Class implementing data in the scripts.
 */
class WSData {
	// Data types
	const DInt    = 'int';
	const DString = 'string';
	const DNull   = 'null';
	const DBool   = 'bool';
	const DFloat  = 'float';
	const DList   = 'list';	// int -> value
	const DAssoc  = 'assoc';	// associative array

	public $type;
	public $data;

	public function __construct( $type = self::DNull, $val = null ) {
		$this->type = $type;
		$this->data = $val;
	}

	public static function newFromPHPVar( $var ) {
		if( is_string( $var ) )
			return new WSData( self::DString, $var );
		elseif( is_int( $var ) )
			return new WSData( self::DInt, $var );
		elseif( is_float( $var ) )
			return new WSData( self::DFloat, $var );
		elseif( is_bool( $var ) )
			return new WSData( self::DBool, $var );
		elseif( is_array( $var ) ) {
			if( !$var )
				return new WSData( self::DList, array() );
			$result = array();
			foreach( $var as $item )
				$result[] = self::newFromPHPVar( $item );
			return new WSData( self::DList, $result );
		}
		elseif( is_null( $var ) )
			return new WSData();
		else
			throw new WSException(
				"Data type " . gettype( $var ) . " is not supported by WikiScrtips" );
	}
	
	public function dup() {
		return new WSData( $this->type, $this->data );
	}
	
	public static function castTypes( $orig, $target ) {
		if( $orig->type == $target )
			return $orig->dup();
		if( $target == self::DNull ) {
			return new WSData();
		}

		if( $orig->isArray() ) {
			if( $target == self::DBool )
				return new WSData( self::DBool, (bool)count( $orig->data ) );
			if( $target == self::DFloat ) {
				return new WSData( self::DFloat, doubleval( count( $orig->data  ) ) );
			}
			if( $target == self::DInt ) {
				return new WSData( self::DInt, intval( count( $orig->data ) ) );
			}
			if( $target == self::DString ) {
				$s = array();
				foreach( $orig->data as $item )
					$s[] = $item->toString();
				return new WSData( self::DString, implode( "\n", $s ) );
			}
		}

		if( $target == self::DBool ) {
			return new WSData( self::DBool, (bool)$orig->data );
		}
		if( $target == self::DFloat ) {
			return new WSData( self::DFloat, doubleval( $orig->data ) );
		}
		if( $target == self::DInt ) {
			return new WSData( self::DInt, intval( $orig->data ) );
		}
		if( $target == self::DString ) {
			return new WSData( self::DString, strval( $orig->data ) );
		}
		if( $target == self::DList ) {
			if( $orig->type == self::DAssoc )
				return new WSData( self::DList, array_values( $orig->data ) );
			else
				return new WSData( self::DList, array( $orig ) );
		}
	}
	
	public static function boolInvert( $value ) {
		return new WSData( self::DBool, !$value->toBool() );
	}

	public static function pow( $base, $exponent ) {
		if( $base->type == self::DInt && $exponent->type == self::DInt )
			return new WSData( self::DInt, pow( $base->toInt(), $exponent->toInt() ) );
		else
			return new WSData( self::DFloat, pow( $base->toFloat(), $exponent->toFloat() ) );
	}

	// Checks whether a is in b
	public static function keywordIn( $a, $b ) {
		if( $b->isArray() ) {
			foreach( $b->data as $elem ) {
				if( self::equals( $elem, $a ) )
					return new WSData( self::DBool, true );
			}
			return new WSData( self::DBool, false );
		} else {
			$a = $a->toString();
			$b = $b->toString();
			
			if( $a == '' || $b == '' ) {
				return new WSData( self::DBool, false );
			}
			
			return new WSData( self::DBool, in_string( $a, $b ) );
		}
	}
	
	public static function equals( $d1, $d2 ) {
		return $d1->data == $d2->data;
	}

	public static function unaryMinus( $data ) {
		if( $data->type == self::DInt ) {
			return new WSData( $data->type, -$data->toInt() );
		} else {
			return new WSData( $data->type, -$data->toFloat() );
		}
	}
	
	public static function compareOp( $a, $b, $op ) {
		if( $op == '==' )
			return new WSData( self::DBool, self::equals( $a, $b ) );
		if( $op == '!=' )
			return new WSData( self::DBool, !self::equals( $a, $b ) );
		if( $op == '===' )
			return new WSData( self::DBool, $a->type == $b->type && self::equals( $a, $b ) );
		if( $op == '!==' )
			return new WSData( self::DBool, $a->type != $b->type || !self::equals( $a, $b ) );
		$a = $a->toString();
		$b = $b->toString();
		if( $op == '>' )
			return new WSData( self::DBool, $a > $b );
		if( $op == '<' )
			return new WSData( self::DBool, $a < $b );
		if( $op == '>=' )
			return new WSData( self::DBool, $a >= $b );
		if( $op == '<=' )
			return new WSData( self::DBool, $a <= $b );
		throw new WSException( "Invalid comparison operation: {$op}" ); // Should never happen
	}
	
	public static function mulRel( $a, $b, $op, $module, $pos ) {	
		// Figure out the type.
		if( ( $a->type == self::DFloat || $b->type == self::DFloat ) &&
			$op != '/' ) {
			$type = self::DInt;
			$a = $a->toInt();
			$b = $b->toInt();
		} else {
			$type = self::DFloat;
			$a = $a->toFloat();
			$b = $b->toFloat();
		}

		if( $op != '*' && $b == 0 ) {
			throw new WSUserVisibleException( 'dividebyzero', $module, $pos, array($a) );
		}

		$data = null;
		if( $op == '*' )
			$data = $a * $b;
		elseif( $op == '/' )
			$data = $a / $b;
		elseif( $op == '%' )
			$data = $a % $b;
		else
			throw new WSException( "Invalid multiplication-related operation: {$op}" ); // Should never happen
			
		if( $type == self::DInt )
			$data = intval( $data );
		else
			$data = doubleval( $data );
		
		return new WSData( $type, $data );
	}
	
	public static function sum( $a, $b, $module, $line ) {
		// If one operand is array and other is null, return the array
		if( $a->isArray() && $b->type == self::DNull ) {
			return $a->dup();
		}
		if( $b->isArray() && $a->type == self::DNull ) {
			return $b->dup();
		}

		// Lists
		if( $a->type == self::DList && $b->type == self::DList )
			return new WSData( self::DList, array_merge( $a->toList(), $b->toList() ) );
		elseif( $a->type == self::DList )
			return new WSData( self::DList, array_merge( $a->toList(), array( $b ) ) );
		elseif( $b->type == self::DList )
			return new WSData( self::DList, array_merge( array( $a ), $b->toList() ) );
		// Associated arrays
		elseif( $a->type == self::DAssoc && $b->type == self::DAssoc )
			return new WSData( self::DAssoc, array_merge( $a->toAssoc(), $b->toAssoc() ) );
		elseif( $a->type == self::DAssoc || $b->type == self::DAssoc )
			throw new WSUserVisibleException( 'assocbadmerge', $module, $line );
		// Strings
		elseif( $a->type == self::DString || $b->type == self::DString )
			return new WSData( self::DString, $a->toString() . $b->toString() );
		// Number, booleans and null
		elseif( $a->type == self::DFloat || $b->type == self::DFloat )
			return new WSData( self::DFloat, $a->toFloat() + $b->toFloat() );
		else
			return new WSData( self::DInt, $a->toInt() + $b->toInt() );
	}

	public static function sub( $a, $b ) {
		if( $a->type == self::DInt && $b->type == self::DInt )
			return new WSData( self::DInt, $a->toInt() - $b->toInt() );
		else
			return new WSData( self::DFloat, $a->toFloat() - $b->toFloat() );
	}

	public function isArray() {
		return $this->type == self::DList || $this->type == self::DAssoc;
	}


	/** Convert shorteners */
	public function toBool() {
		return self::castTypes( $this, self::DBool )->data;
	}
	
	public function toString() {
		return self::castTypes( $this, self::DString )->data;
	}
	
	public function toFloat() {
		return self::castTypes( $this, self::DFloat )->data;
	}
	
	public function toInt() {
		return self::castTypes( $this, self::DInt )->data;
	}

	public function toList() {
		return self::castTypes( $this, self::DList )->data;
	}
	
	public function toAssoc() {
		return self::castTypes( $this, self::DAssoc )->data;
	}
}
