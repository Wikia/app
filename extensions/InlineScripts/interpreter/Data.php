<?php

class ISData {
	// Data types
	const DInt    = 'int';
	const DString = 'string';
	const DNull   = 'null';
	const DBool   = 'bool';
	const DFloat  = 'float';
	const DList   = 'list';	// int -> value

	var $type;
	var $data;

	public function __construct( $type = self::DNull, $val = null ) {
		$this->type = $type;
		$this->data = $val;
	}

	public static function newFromPHPVar( $var ) {
		if( is_string( $var ) )
			return new ISData( self::DString, $var );
		elseif( is_int( $var ) )
			return new ISData( self::DInt, $var );
		elseif( is_float( $var ) )
			return new ISData( self::DFloat, $var );
		elseif( is_bool( $var ) )
			return new ISData( self::DBool, $var );
		elseif( is_array( $var ) ) {
			if( !$var )
				return new ISData( self::DList, array() );
			$result = array();
			foreach( $var as $item )
				$result[] = self::newFromPHPVar( $item );
			return new ISData( self::DList, $result );
		}
		elseif( is_null( $var ) )
			return new ISData();
		else
			throw new ISException(
				"Data type " . gettype( $var ) . " is not supported by InlineScrtips" );
	}
	
	public function dup() {
		return new ISData( $this->type, $this->data );
	}
	
	public static function castTypes( $orig, $target ) {
		if( $orig->type == $target )
			return $orig->dup();
		if( $target == self::DNull ) {
			return new ISData();
		}

		if( $orig->type == self::DList ) {
			if( $target == self::DBool )
				return new ISData( self::DBool, (bool)count( $orig->data ) );
			if( $target == self::DFloat ) {
				return new ISData( self::DFloat, doubleval( count( $orig->data  ) ) );
			}
			if( $target == self::DInt ) {
				return new ISData( self::DInt, intval( count( $orig->data ) ) );
			}
			if( $target == self::DString ) {
				$s = array();
				foreach( $orig->data as $item )
					$s[] = $item->toString();
				return new ISData( self::DString, implode( "\n", $s ) );
			}
		}

		if( $target == self::DBool ) {
			return new ISData( self::DBool, (bool)$orig->data );
		}
		if( $target == self::DFloat ) {
			return new ISData( self::DFloat, doubleval( $orig->data ) );
		}
		if( $target == self::DInt ) {
			return new ISData( self::DInt, intval( $orig->data ) );
		}
		if( $target == self::DString ) {
			return new ISData( self::DString, strval( $orig->data ) );
		}
		if( $target == self::DList ) {
			return new ISData( self::DList, array( $orig ) );
		}
	}
	
	public static function boolInvert( $value ) {
		return new ISData( self::DBool, !$value->toBool() );
	}

	public static function pow( $base, $exponent ) {
		if( $base->type == self::DInt && $exponent->type == self::DInt )
			return new ISData( self::DInt, pow( $base->toInt(), $exponent->toInt() ) );
		else
			return new ISData( self::DFloat, pow( $base->toFloat(), $exponent->toFloat() ) );
	}

	// Checks whether a is in b
	public static function keywordIn( $a, $b ) {
		if( $b->type == self::DList ) {
			foreach( $b->data as $elem ) {
				if( self::equals( $elem, $a ) )
					return new ISData( self::DBool, true );
			}
			return new ISData( self::DBool, false );
		} else {
			$a = $a->toString();
			$b = $b->toString();
			
			if ($a == '' || $b == '') {
				return new ISData( self::DBool, false );
			}
			
			return new ISData( self::DBool, in_string( $a, $b ) );
		}
	}
	
	public static function equals( $d1, $d2 ) {
		return $d1->data == $d2->data;
	}

	public static function unaryMinus( $data ) {
		if( $data->type == self::DInt ) {
			return new ISData( $data->type, -$data->toInt() );
		} else {
			return new ISData( $data->type, -$data->toFloat() );
		}
	}
	
	public static function compareOp( $a, $b, $op ) {
		if( $op == '==' )
			return new ISData( self::DBool, self::equals( $a, $b ) );
		if( $op == '!=' )
			return new ISData( self::DBool, !self::equals( $a, $b ) );
		if( $op == '===' )
			return new ISData( self::DBool, $a->type == $b->type && self::equals( $a, $b ) );
		if( $op == '!==' )
			return new ISData( self::DBool, $a->type != $b->type || !self::equals( $a, $b ) );
		$a = $a->toString();
		$b = $b->toString();
		if( $op == '>' )
			return new ISData( self::DBool, $a > $b );
		if( $op == '<' )
			return new ISData( self::DBool, $a < $b );
		if( $op == '>=' )
			return new ISData( self::DBool, $a >= $b );
		if( $op == '<=' )
			return new ISData( self::DBool, $a <= $b );
		throw new ISException( "Invalid comparison operation: {$op}" ); // Should never happen
	}
	
	public static function mulRel( $a, $b, $op, $pos ) {	
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

		if ($op != '*' && $b == 0) {
			throw new ISUserVisibleException( 'dividebyzero', $pos, array($a) );
		}

		$data = null;
		if( $op == '*' )
			$data = $a * $b;
		elseif( $op == '/' )
			$data = $a / $b;
		elseif( $op == '%' )
			$data = $a % $b;
		else
			throw new ISException( "Invalid multiplication-related operation: {$op}" ); // Should never happen
			
		if ($type == self::DInt)
			$data = intval($data);
		else
			$data = doubleval($data);
		
		return new ISData( $type, $data );
	}
	
	public static function sum( $a, $b ) {
		if( $a->type == self::DString || $b->type == self::DString )
			return new ISData( self::DString, $a->toString() . $b->toString() );
		elseif( $a->type == self::DList && $b->type == self::DList )
			return new ISData( self::DList, array_merge( $a->toList(), $b->toList() ) );
		elseif( $a->type == self::DInt && $b->type == self::DInt )
			return new ISData( self::DInt, $a->toInt() + $b->toInt() );
		else
			return new ISData( self::DFloat, $a->toFloat() + $b->toFloat() );
	}
	
	public static function sub( $a, $b ) {
		if( $a->type == self::DInt && $b->type == self::DInt )
			return new ISData( self::DInt, $a->toInt() - $b->toInt() );
		else
			return new ISData( self::DFloat, $a->toFloat() - $b->toFloat() );
	}
	
	public function setValueByIndices( $val, $indices, $line ) {
		if( $this->type == self::DNull && $indices[0] === null ) {
			$this->type = self::DList;
			$this->value = array();
			$this->setValueByIndices( $val, $indices );
		} elseif( $this->type == self::DList ) {
			if( $indices[0] === null ) {
				$this->data[] = $val;
			} else {
				$idx = $indices[0]->toInt();
				if( $idx < 0 || $idx >= count( $this->data ) )
					throw new ISUserVisibleException( 'outofbounds', $line, array( count( $this->data ), $idx ) );
				if( count( $indices ) > 1 )
					$this->data[$idx]->setValueByIndices( $val, array_slice( $indices, 1 ) );
				else
					$this->data[$idx] = $val;
			}
		}
	}

	public function checkIssetByIndices( $indices ) {
		if( $indices ) {
			$idx = array_shift( $indices );
			if( $this->type != self::DList || $idx >= count( $this->data ) )
				return false;
			return $this->checkIssetByIndices( $indices );
		} else {
			return true;
		}
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
}
