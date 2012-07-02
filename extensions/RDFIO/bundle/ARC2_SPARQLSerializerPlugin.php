<?php
/*
homepage: ARC or plugin homepage
license:  http://arc.semsol.org/license

class:    ARC2 SPARQL Serialiser Plugin
author:   Keith Alexander
version:  2008-06-22

fixed some bugs with literal typing and escaping

*/

ARC2::inc( 'Class' );

class ARC2_SPARQLSerializerPlugin extends ARC2_Class {

  function __construct( $a = '', &$caller ) {
    parent::__construct( $a, $caller );
  }

  function ARC2_SPARQLSerializerPlugin ( $a = '', &$caller ) {
    $this->__construct( $a, $caller );
  }

  function __init() {
    parent::__init();
  }

	function toString( $infos ) {
		$this->infos = $infos;
		return self::sparql_info_to_string( $infos['query'] );
	}

 	function sparql_info_to_string( $t, $only_triples = false ) {
		$string = '';
		if ( isset( $t['type'] ) ) {
			switch( $t['type'] ) {
				case 'construct':
					$string .= 'CONSTRUCT { ' . $this->sparql_info_to_string( $t['construct_triples'], true ) . ' } ';
				case 'describe':
				case 'select':
					if ( in_array( $t['type'], array( 'select', 'describe' ) ) ) {
							 $string .= ' ' . strtoupper( $t['type'] ) . ' ';
							if ( isset( $t['result_vars'] ) ) foreach ( $t['result_vars'] as $v ) {
								$string .= ' ?' . $v['var'];
							}
							if ( isset( $t['result_iris'] ) ) foreach ( $t['result_iris'] as $v ) {
								$string .= ' <' . $v['iri'] . '> ';
							}
					}
				case 'ask':
					if ( !empty( $t['dataset'] ) ) {
						foreach ( $t['dataset'] as $dataset ) {
							$string .= ' FROM ' . ( ( $dataset['named'] ) ? 'NAMED ': '' ) . '<' . $dataset['graph'] . '> ';
						}
					}
					if ( !isset( $t['pattern'] ) ) var_dump( $this->infos );
					else $string .= ' WHERE ' . $this->sparql_info_to_string( $t['pattern'] ) . '';
					break;
				case 'triple':
					$string .= $this->triple_to_string( $t );
					break;
				case 'union':
					$patterns = array();
					foreach ( $t['patterns'] as $pattern ) {
						$patterns[] = '{' . $this->sparql_info_to_string( $pattern, $only_triples ) . '}';
					}
					$string .= implode( ' UNION ', $patterns );
				break;
				case 'group':
				case 'triples':
				case 'optional':
					$pattern_string = '';
					foreach ( $t['patterns'] as $pattern ) {
						$pattern_string .= " " . $this->sparql_info_to_string( $pattern, $only_triples ) . " ";
					}
					switch( $t['type'] ) {
						case 'group':
							$string .= '{ ' . $pattern_string . ' }';
							break;
						case 'triples':
							$string .= $pattern_string;
							break;
						case 'optional':
							$string .= ( !$only_triples ) ? 'OPTIONAL { ' . $pattern_string . ' }' : '{ ' . $pattern_string . ' }' ;
							break;
					}
					break;
				case 'filter':
					$string .= ( !$only_triples ) ? "FILTER(" . $this->sparql_info_to_string( $t['constraint'] ) . ")" : '';
					break;
				case 'built_in_call':
					$string .= $t['operator'] . strtoupper( $t['call'] ) . "(";
					$args = array();
					foreach ( $t['args'] as $arg ) { 	$args[] = $this->sparql_info_to_string( $arg );
					}
					$string .= implode( ',', $args ) . ')  ';
					break;
				case 'var':
					$var_string = '?' . $t['value'];
					if ( isset( $t['direction'] ) ) $var_string = strtoupper( $t['direction'] ) . "(" . $var_string . ")";
					$string .= $var_string;
					break;
				case 'literal':
				case 'literal1':
				case 'literal2':
					$string .= $this->term_to_string( $t['type'], $t['value'] );
					if ( isset( $t['datatype'] ) ) $string .= '^^' . $t['datatype'];
					elseif ( isset( $t['lang'] ) ) $string .= '@' . $t['lang'];
					break;
				case 'expression':
					$expressions = array();
					foreach ( $t['patterns'] as $p ) { $expressions[] = $this->sparql_info_to_string( $p );
					}
					switch( $t['sub_type'] ) {
						case 'relational':
							$string .= implode( $t['operator'], $expressions );
							break;
						case 'and':
							$string .= implode( ' && ', $expressions );
							break;
						case 'or':
							$string .= implode( ' || ', $expressions );
							break;

						default:
							$string .= implode( $t['sub_type'], $expressions );
							break;
					}
					break;
			}

		}
		elseif ( is_array( $t ) ) {
			foreach ( $t as $item ) {
				$string .= $this->sparql_info_to_string( $item );
			}
		}
	if ( isset( $t['order_infos'] ) ) {
		foreach ( $t['order_infos'] as $order ) {
			$string .= " ORDER BY " . $this->sparql_info_to_string( $order );
		}
	}
	if ( isset( $t['limit'] ) ) {
		$string .= ' LIMIT ' . $t['limit'];
	}
	if ( isset( $t['offset'] ) ) {
		$string .= ' OFFSET ' . $t['offset'];
	}

	return $string;
	}

	function triple_to_string( $t ) {
		$str = '';
		if ( empty( $t ) ) return '';
		foreach ( array( 's', 'p', 'o' ) as $term ) {
			$str .= ' ' . $this->term_to_string( $t[$term . '_type'], $t[$term] );
		}
		return $str . ' . ';
	}

	function term_to_string( $type, $val ) {
		switch( $type ) {
			case 'var':
				return '?' . $val;
			case 'literal':
			case 'literal1':
			case 'literal2':
			case 'literal_long1':
			case 'literal_long2':
			$quot = '"';
		    if ( preg_match( '/\"/', $val ) ) {
		      $quot = "'";
		      if ( preg_match( '/\'/', $val ) ) {
		        $quot = '"""';
		        if ( preg_match( '/\"\"\"/', $val ) || preg_match( '/\"$/', $val ) || preg_match( '/^\"/', $val ) ) {
		          $quot = "'''";
		          $val = preg_replace( "/'$/", "' ", $val );
		          $val = preg_replace( "/^'/", " '", $val );
		          $val = str_replace( "'''", '\\\'\\\'\\\'', $val );
		        }
		      }
		    }
		    if ( ( strlen( $quot ) == 1 ) && preg_match( '/[\x0d\x0a]/', $val ) ) {
		      $quot = $quot . $quot . $quot;
		    }
		    return $quot . $val . $quot ;
			case 'uri':
				return '<' . $val . '>';
			case 'bnode':
			default:
				return $val;
		}
	}

}

?>