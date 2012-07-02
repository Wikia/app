<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of CategoryBrowser.
 *
 * CategoryBrowser is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * CategoryBrowser is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with CategoryBrowser; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * CategoryBrowser is an AJAX-enabled category filter and browser for MediaWiki.
 *
 * To activate this extension :
 * * Create a new directory named CategoryBrowser into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/CategoryBrowser/CategoryBrowser.php";
 *
 * @version 0.3.1
 * @link http://www.mediawiki.org/wiki/Extension:CategoryBrowser
 * @author Dmitriy Sintsov <questpc@rambler.ru>
 * @addtogroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is a part of MediaWiki extension.\n" );
}

define( 'CB_ENCODED_TOKEN_MATCH', '`^(ge|le|eq)(p|s|f)(\d+)$`' );

/* render output data */
class CB_XML {
	// the stucture of $tag is like this:
	// array( "__tag"=>"td", "class"=>"myclass", 0=>"text before li", 1=>array( "__tag"=>"li", 0=>"text inside li" ), 2=>"text after li" )
	// both tagged and tagless lists are supported
	static function toText( &$tag ) {
		$tag_open = "";
		$tag_close = "";
		$tag_val = null;
		if ( is_array( $tag ) ) {
			ksort( $tag );
			if ( array_key_exists( '__tag', $tag ) ) {
				# list inside of tag
				$tag_open .= "<" . $tag[ '__tag' ];
				foreach ( $tag as $attr_key => &$attr_val ) {
					if ( is_int( $attr_key ) ) {
						if ( $tag_val === null )
							$tag_val = "";
						if ( is_array( $attr_val ) ) {
							# recursive tags
							$tag_val .= self::toText( $attr_val );
						} else {
							# text
							$tag_val .= $attr_val;
						}
					} else {
						# string keys are for tag attributes
						if ( substr( $attr_key, 0, 2 ) != "__" ) {
							# include only non-reserved attributes
							if ( $attr_val !== null ) {
								$tag_open .= " $attr_key=\"" . $attr_val . "\"";
							} else {
								# null value of attribute is a special value for option selected
								$tag_open .= " $attr_key";
							}
						}
					}
				}
				if ( $tag_val !== null ) {
					$tag_open .= ">";
					$tag_close .= "</" . $tag[ '__tag' ] . ">";
				} else {
					$tag_open .= " />";
				}
				if ( array_key_exists( '__end', $tag ) ) {
					$tag_close .= $tag[ '__end' ];
				}
			} else {
				# tagless list
				$tag_val = "";
				foreach ( $tag as $attr_key => &$attr_val ) {
					if ( is_int( $attr_key ) ) {
						if ( is_array( $attr_val ) ) {
							# recursive tags
							$tag_val .= self::toText( $attr_val );
						} else {
							# text
							$tag_val .= $attr_val;
						}
					} else {
						ob_start();
						var_dump( $tag );
						$tagdump = ob_get_contents();
						ob_end_clean();
						$tag_val = "invalid argument: tagless list cannot have tag attribute values in key=$attr_key, $tagdump";
					}
				}
			}
		} else {
			# just a text
			$tag_val = $tag;
		}
		return $tag_open . $tag_val . $tag_close;
	}

	# creates one "htmlobject" row of the table
	# elements of $row can be either a string/number value of cell or an array( "count"=>colspannum, "attribute"=>value, 0=>html_inside_tag )
	# attribute maps can be like this: ("name"=>0, "count"=>colspan" )
	static function newRow( $row, $rowattrs = "", $celltag = "td", $attribute_maps = null ) {
		$result = "";
		if ( count( $row ) > 0 ) {
			foreach ( $row as &$cell ) {
				if ( !is_array( $cell ) ) {
					$cell = array( 0 => $cell );
				}
				$cell[ '__tag' ] = $celltag;
				$cell[ '__end' ] = "\n";
				if ( is_array( $attribute_maps ) ) {
					# converts ("count"=>3) to ("colspan"=>3) in table headers - don't use frequently
					foreach ( $attribute_maps as $key => $val ) {
						if ( array_key_exists( $key, $cell ) ) {
							$cell[ $val ] = $cell[ $key ];
							unset( $cell[ $key ] );
						}
					}
				}
			}
			$result = array( '__tag' => 'tr', 0 => $row, '__end' => "\n" );
			if ( is_array( $rowattrs ) ) {
				$result = array_merge( $rowattrs, $result );
			} elseif ( $rowattrs !== "" )  {
				$result[0][] = __METHOD__ . ':invalid rowattrs supplied';
			}
		}
		return $result;
	}

	# add row to the table
	static function addRow( &$table, $row, $rowattrs = "", $celltag = "td", $attribute_maps = null ) {
		$table[] = self::newRow( $row, $rowattrs, $celltag, $attribute_maps );
	}

	# add column to the table
	static function addColumn( &$table, $column, $rowattrs = "", $celltag = "td", $attribute_maps = null ) {
		if ( count( $column ) > 0 ) {
			$row = 0;
			foreach ( $column as &$cell ) {
				if ( !is_array( $cell ) ) {
					$cell = array( 0 => $cell );
				}
				$cell[ '__tag' ] = $celltag;
				$cell[ '__end' ] = "\n";
				if ( is_array( $attribute_maps ) ) {
					# converts ("count"=>3) to ("rowspan"=>3) in table headers - don't use frequently
					foreach ( $attribute_maps as $key => $val ) {
						if ( array_key_exists( $key, $cell ) ) {
							$cell[ $val ] = $cell[ $key ];
							unset( $cell[ $key ] );
						}
					}
				}
				if ( is_array( $rowattrs ) ) {
					$cell = array_merge( $rowattrs, $cell );
				} elseif ( $rowattrs !== "" ) {
					$cell[ 0 ] = __METHOD__ . ':invalid rowattrs supplied';
				}
				if ( !array_key_exists( $row, $table ) ) {
					$table[ $row ] = array( '__tag' => 'tr', '__end' => "\n" );
				}
				$table[ $row ][] = $cell;
				if ( array_key_exists( 'rowspan', $cell ) ) {
					$row += intval( $cell[ 'rowspan' ] );
				} else {
					$row++;
				}
			}
			$result = array( '__tag' => 'tr', 0 => $column, '__end' => "\n" );
		}
	}

	static function displayRow( $row, $rowattrs = "", $celltag = "td", $attribute_maps = null ) {
		return self::toText( self::newRow( $row, $rowattrs, $celltag, $attribute_maps ) );
	}

	// use newRow() or addColumn() to add resulting row/column to the table
	// if you want to use the resulting row with toText(), don't forget to apply attrs=array('__tag'=>'td')
	static function applyAttrsToRow( &$row, $attrs ) {
		if ( is_array( $attrs ) && count( $attrs > 0 ) ) {
			foreach ( $row as &$cell ) {
				if ( !is_array( $cell ) ) {
					$cell = array_merge( $attrs, array( $cell ) );
				} else {
					foreach ( $attrs as $attr_key => $attr_val ) {
						if ( !array_key_exists( $attr_key, $cell ) ) {
							$cell[ $attr_key ] = $attr_val;
						}
					}
				}
			}
		}
	}
} /* end of CB_XML class */

/**
 * Localization of SQL tokens list
 * comparsions like "a > 1" are treated like single-ops
 */
class CB_LocalExpr {

	var $src_tokens;
	var $local_tokens;

	/**
	 * @param $tokens - list of encoded SQL condition tokens
	 *     (infix or RPN - doesn't matter for localization)
	 * comparsions are single-ops
	 */
	function __construct( array $tokens ) {
		$this->src_tokens = $tokens;
		if ( count( $this->src_tokens ) < 1 ) {
			$this->local_tokens = array( wfMsg( 'cb_all_op' ) ); // localized default "all"
			return;
		}
		foreach ( $tokens as &$token ) {
			$op = $field = $num = '';
			switch ( $token->type ) {
			case 'bracket' :
				if ( $token->value == '(' ) {
					$op = 'lbracket';
				} else { // $token->value == ')'
					$op = 'rbracket';
				}
				break;
			case 'logical' :
				if ( $token->value == 'or' ) {
					$op = 'or';
				} else { // $token->value == 'and'
					$op = 'and';
				}
				break;
			case 'comparsion' : // comparsion subexpression
				$matches = array();
				preg_match_all( CB_ENCODED_TOKEN_MATCH, $token->value, $matches, PREG_SET_ORDER );
				if ( count( $matches ) == 1 && isset( $matches[0] ) && count( $matches[0] ) == 4 ) {
					// localize comparsion op
					list( $expr, $cmp, $field, $num ) = $matches[0];
					$op = $cmp;
					$field = CB_SqlCond::$decoded_fields[ $field ];
				}
				break;
			}
			if ( $op == '' ) {
				$this->src_tokens = array(); // default "all"
				$this->local_tokens = array( wfMsg( 'cb_all_op' ) ); // localized default "all"
				throw new MWException( 'Invalid operation ' . CB_Setup::entities( $token ) . ' in ' . __METHOD__ );			}
			if ( $field == '' ) {
				$this->local_tokens[] = wfMsg( "cb_${op}_op" );
			} elseif ( $num == '' ) {
				$this->local_tokens[] = wfMsg( 'cb_op1_template', wfMsg( "cb_${op}_op" ), wfMsg( "cb_${field}" ) );
			} else {
				$this->local_tokens[] = wfMsg( 'cb_op2_template', wfMsg( "cb_${field}" ), wfMsg( "cb_${op}_op" ), $num );
			}
		}
	}

	function toString() {
		return implode( ' ', $this->local_tokens );
	}

} /* end of CB_LocalExpr class */

/* builds a bracketed sql condition either from the list of infix array $tokens or
 * from encoded reverse polish operations string $enc
 *
 * properly bracketed sql condition uses brackets to display the actual priority of expression
 *
 */
class CB_SqlCond {

	# general terminology : queue is a string of underscore separated operations
	# token arrays (RPN or infix) are an arrays of token objects
	# each is corresponding to queue's operations and vice versa

	# decoded_fields and sql_fields differ because in current scheme ( MW <= 1.16 )
	# cat_pages include cat_subcats and cat_fields count as well
	# while we need to query against actual number of pages only

	# opcodes mapping for i18n
	static $decoded_fields = array( 'p' => 'cat_pages', 's' => 'cat_subcats', 'f' => 'cat_files' );
	# opcodes mapping for SQL
	static $sql_fields = array( 'p' => '(cat_pages - cat_subcats - cat_files)', 's' => 'cat_subcats', 'f' => 'cat_files' );
	static $sql_cmps = array( 'ge' => '>=', 'le' => '<=', 'eq' => '=' );
	# opcodes mapping for encoded queues (JS & cookie)
	static $encoded_fields = array( 'cat_subcats' => 's', 'cat_pages' => 'p', 'cat_files' => 'f' );
	static $encoded_cmps = array( '>=' => 'ge', '<=' => 'le', '=' => 'eq' );

	# RPN array (encoded form, every token is an element of array)
	# comparsions like "a > 1" are treated like single-ops
	# initialized in constructor (public static functions)
	var $rpn_tokens;
	private $rpn_tokens_pos; // current position in rpn_tokens; used to generate triples

	# infix operations array (encoded form, every token is an element of array)
	# comparsions like "a > 1" are treated like single-ops
	# initialized in constructor (public static functions)
	var $infix_tokens;

	// used privately by parseEncodedToken(), getSqlToken()
	private static $valid_logical_ops;
	private static $valid_bracket_ops;

	/**
	 * constructor (creates an instance, initializes $this->rpn_tokens, returns an instance)
	 *
	 * converts encoded RPN queue (string) to RPN tokens array ($this->rpn_tokens) (1:1)
	 * @param $enc - string encoded RPN queue
	 * (underscore-separated encoded polish tokens)
	 */
	public static function newFromEncodedPolishQueue( $enc ) {
		if ( !is_string( $enc ) ) {
			throw new MWException( 'First argument should be a string in ' . __METHOD__ );
		}
		$sc = new CB_SqlCond();
		# parseEncodedToken(), getSqlToken() in RPN mode
		self::$valid_logical_ops = array( 'and', 'or' );
		self::$valid_bracket_ops = array();
		$sc->rpn_tokens = array();
		$q = explode( '_', $enc );
		# {{{ validation of expression
		$cmp_count = $logical_count = 0;
		# }}}
		foreach ( $q as &$token ) {
			$result = self::parseEncodedToken( $token );
			$sc->rpn_tokens[] = $result;
			if ( $result->type == 'comparsion' ) {
				$cmp_count++;
			} elseif ( $result->type == 'logical' ) {
				$logical_count++;
			} else {
				# tampered or bugged $enc, return default "all" instead
				$sc->rpn_tokens = array();
				return $sc;
			}
		}
		if ( $cmp_count < 1 || $cmp_count != $logical_count + 1 ) {
			# tampered or bugged $enc, return default "all" instead
			$sc->rpn_tokens = array();
			return $sc;
		}
		if ( $logical_count > CB_MAX_LOGICAL_OP ) {
			# too complex $enc (fabricated or non-realistic), return default "all" instead
			$sc->rpn_tokens = array();
			return $sc;
		}
		return $sc;
	}

	/**
	 * constructor (creates an instance, initializes $this->infix_tokens, returns an instance)
	 *
	 * converts encoded infix operations queue (string) to
	 * decoded infix operations array $this->infix_tokens (1:1)
	 * then fills RPN tokens array $this->rpn_tokens
	 * @param $enc - string encoded infix operations queue
	 * (underscore-separated encoded infix tokens)
	 */
	public static function newFromEncodedInfixQueue( $enc ) {
		if ( !is_string( $enc ) ) {
			throw new MWException( 'First argument should be a string in ' . __METHOD__ );
		}
		# parseEncodedToken(), getSqlToken() in infix mode
		self::$valid_logical_ops = array( 'and', 'or' );
		self::$valid_bracket_ops = array( '(', ')' );
		$infix_tokens = array();
		$q = explode( '_', $enc );
		# {{{ validation of expression
		$brackets_level = 0; $prev_type = '';
		# }}}
		foreach ( $q as &$token ) {
			$result = self::parseEncodedToken( $token );
			$infix_tokens[] = $result;
			if ( $result->type == 'bracket' ) {
				if ( $result->value == '(' ) {
					$brackets_level++;
				} else {
					$brackets_level--;
				}
				if ( $brackets_level < 0 ) {
					# tampered or bugged $enc, use default "all" instead
					$infix_tokens = array();
					break;
				}
			} elseif ( $result->type == 'logical' ) {
				if ( $prev_type == '' || $prev_type == 'logical' ) {
					# tampered or bugged $enc, use default "all" instead
					$infix_tokens = array();
					break;
				}
			} elseif ( $result->type == 'comparsion' ) {
				if ( $prev_type == 'comparsion' ) {
					# tampered or bugged $enc, use default "all" instead
					$infix_tokens = array();
					break;
				}
			} else {
				# tampered or bugged $enc, use default "all" instead
				$infix_tokens = array();
				break;
			}
			$prev_type = $result->type;
		}
		if ( $brackets_level != 0 ) {
			# tampered or bugged $enc, use default "all" instead
			$infix_tokens = array();
		}
		return self::newFromInfixTokens( $infix_tokens );
	}

	/**
	 * constructor (creates an instance, initializes $this->rpn_tokens, returns an instance)
	 *
	 * fills up RPN array $this->rpn_tokens from infix $tokens array provided
	 * @param $tokens - array of encoded infix tokens
	 */
	public static function newFromInfixTokens( array $tokens ) {
		$sc = new CB_SqlCond();
		$stack = array(); // every element is stdClass with stdClass(token) or stdClass(stdClass(token),prio) fields
		$sc->rpn_tokens = array();
		foreach ( $tokens as &$token ) {
			switch ( $token->type ) {
			case 'bracket' :
				if ( $token->value == '(' ) {
					$prio = 0;
					array_push( $stack, (object) array( 'token' => $token, 'prio' => $prio ) );
				} else { // $token->value == ')'
					$prio = 1;
					while ( $last = array_pop( $stack ) ) {
						if ( isset( $last->prio ) ) {
							# last element in stack is an container with 'prio' property (different array_push'es)
							if ( $last->token->value == '(' ) {
								break;
							}
							array_push( $sc->rpn_tokens, $last->token );
						} else {
							# last element in stack is just a token object
							throw new MWException( 'Open / closing brackets mismatch in ' . __METHOD__ );
						}
					}
				}
				break;
			case 'logical' :
				$prio = $token->value == 'or' ? 2 : 3;
				while ( $last = array_pop( $stack ) ) {
					if ( isset( $last->prio ) && $last->prio >= $prio ) {
						array_push( $sc->rpn_tokens, $last->token );
					} else {
						array_push( $stack, $last );
						break;
					}
				}
				array_push( $stack, (object) array( 'token' => $token, 'prio' => $prio ) );
				break;
			default : // comparsion subexpression
				array_push( $sc->rpn_tokens, $token );
			}
		}
		while ( $last = array_pop( $stack ) ) {
			if ( !isset( $last->prio ) ) {
				break;
			}
			array_push( $sc->rpn_tokens, $last->token );
		}
		return $sc;
	}

	/**
	 * @param $value - encoded token value
	 * @return encoded token object
	 */
	private static function parseEncodedToken( $value ) {
		if ( !is_string( $value ) ) {
			throw new MWException( 'First argument should be a string in ' . __METHOD__ );
		}
		$result = (object) array( 'type' => 'unknown', 'value' => '' );
		$matches = array();
		preg_match_all( CB_ENCODED_TOKEN_MATCH, $value, $matches, PREG_SET_ORDER );
		if ( count( $matches ) == 1 && isset( $matches[0] ) && count( $matches[0] ) == 4 ) {
			// decode comparsion op
			$result->value = $matches[0][1] . $matches[0][2] . intval( $matches[0][3] );
			$result->type = 'comparsion';
			return $result;
		}
		$lo_value = strtolower( $value );
		if ( in_array( $lo_value, self::$valid_logical_ops ) ) {
			// decode logical op
			$result->value = $lo_value;
			$result->type = 'logical';
			return $result;
		}
		if ( ($opcode = array_search( $value, self::$valid_bracket_ops )) !== false ) {
			// decode bracket op
			$result->value = $opcode;
			$result->type = 'bracket';
			return $result;
		}
		return $result;
	}

	/**
	 * @param $token - encoded token object
	 * @result - SQL token
	 */
	private static function getSqlToken( stdClass $token ) {
		switch ( $token->type ) {
		case 'comparsion' :
			$matches = array();
			preg_match_all( CB_ENCODED_TOKEN_MATCH, $token->value, $matches, PREG_SET_ORDER );
			if ( count( $matches ) == 1 && isset( $matches[0] ) && count( $matches[0] ) == 4 ) {
				// decode comparsion op
				return self::$sql_fields[ $matches[0][2] ] . ' ' . self::$sql_cmps[ $matches[0][1] ] . ' ' . (int) $matches[0][3];
			}
		break;
		case 'logical' :
			if ( in_array( $token->value, self::$valid_logical_ops ) ) {
				// decode logical op
				// we store logical ops uppercase for the "prettiness"
 				return strtoupper( $token->value );
			}
		break;
		case 'bracket' :
			if ( ($opcode = array_search( $token->value, self::$valid_bracket_ops )) !== false ) {
				// decode bracket op
				return self::$valid_bracket_ops[ $opcode ];
			}
		}
		throw new MWException( 'Invalid operation type=' . CB_Setup::specialchars( $token->type ) . ' value=' . CB_Setup::specialchars( $token->value ) . ' in ' . __METHOD__ );
	}

/*
src:'(', 'cat_pages > 1000', 'OR', 'cat_subcats > 10', ')', 'AND', 'cat_files > 100'
dst:cat_pages > 1000;cat_subcats > 10;OR;cat_files > 100;AND

('','AND','') 'AND' comes to initial empty triple (level 0)
('','AND','cat_files > 100') 'cat_files > 100' becomes right param of current triple (level 0)
(('','OR',''),'AND','cat_files > 100') 'OR' becomes left recursive param of current triple (level 1), because right param is already occupied
(('','OR','cat_subcats > 10'),'AND','cat_files > 100') 'cat_subcats > 10' becomes right param of current triple (level 1)
(('cat_pages > 1000','OR','cat_subcats > 10'),'AND','cat_files > 100') 'cat_pages > 1000' becomes right param of current triple (level 1)

src:'cat_pages > 1000', 'OR', 'cat_subcats > 10', 'AND', 'cat_files > 100'
dst:cat_pages > 1000;cat_subcats > 10;cat_files > 100;AND;OR

('','OR','') 'OR' comes to initial empty triple (level 0)
('','OR',('','AND','')) 'AND' becomes right recursive entry (level 1)
('','OR',('','AND','cat_files > 100')) 'cat_files > 100' becomes right param of current triple (level 1)
('','OR',('cat_subcats > 10','AND','cat_files > 100')) 'cat_subcats > 10' becomes left param of current triple, because right param is already occupied (level 1)
('cat_pages > 1000','OR',('cat_subcats > 10','AND','cat_files > 100')) going level up because current triple was occupied; 'cat_pages > 1000' becomes left param of current triple

1. global counter of rpn_tokens position, getting elements consequtively from right to left
2. operators are going to current entry, in case currept op is free, otherwise going recursively from right to left (which position is inoccupied)
3. operands are going to current entry, right to left
4. generating the string recursively going from left to right

in actual code (null,null,null) isset() is used instead of ('','','')
*/
	# generate triples (see example above) from $this->rpn_tokens
	#
	# param &$currTriple - recursively adds new triples to $currTriple
	private function buildTriples( array &$currTriple ) {
		# pre-initialize current triple
		# recursively feed triples with rpn_tokens tokens, right to left
		while ( $this->rpn_tokens_pos >= 0 ) {
			$token = $this->rpn_tokens[ $this->rpn_tokens_pos ];
			if ( $token->type == 'logical' ) {
				// our subset of polish notation has only logical operators
				if ( !isset( $currTriple[1] ) ) {
					$currTriple[1] = $token;
					$this->rpn_tokens_pos--;
				} elseif ( !isset( $currTriple[2] ) ) {
					$currTriple[2] = array();
					$this->buildTriples( $currTriple[2] );
				} elseif ( !isset( $currTriple[0] ) ) {
					$currTriple[0] = array();
					$this->buildTriples( $currTriple[0] );
				} else {
					return;
				}
			} else {
				// comparsions are treated as operands
				if ( !isset( $currTriple[2] ) ) {
					$currTriple[2] = $token;
					$this->rpn_tokens_pos--;
				} elseif ( !isset( $currTriple[0] ) ) {
					$currTriple[0] = $token;
					$this->rpn_tokens_pos--;
				} else {
					return;
				}
			}
		}
	}

	/**
	 * build properly bracketed infix expression string
	 * also builds $this->infix_tokens array
	 * from triples tree previousely built by CategoryFilter::buildTriples (left to right)
	 */
	private $infixLevel; // used to do not include brackets at level 0
	private function getInfixExpr( &$out, array $currTriple ) {
		# parseEncodedToken(), getSqlToken() in infix mode
		self::$valid_logical_ops = array( 'and', 'or' );
		self::$valid_bracket_ops = array( '(', ')' );
		$this->infixLevel++;
		if ( $this->infixLevel != 0 ) {
			$this->infix_tokens[] = (object) array( 'type' => 'bracket', 'value' => '(' );
			$out .= '(';
		}
		if ( isset( $currTriple[0] ) ) {
			if ( is_array( $currTriple[0] ) ) {
				$this->getInfixExpr( $out, $currTriple[0] );
			} else {
				$this->infix_tokens[] = $currTriple[0];
				$out .= $this->getSqlToken( $currTriple[0] );
			}
		}
		if ( isset( $currTriple[1] ) ) {
			$this->infix_tokens[] = $currTriple[1];
			$out .= ' ' . $this->getSqlToken( $currTriple[1] ) . ' ';
		}
		if ( isset( $currTriple[2] ) ) {
			if ( is_array( $currTriple[2] ) ) {
				$this->getInfixExpr( $out, $currTriple[2] );
			} else {
				$this->infix_tokens[] = $currTriple[2];
				$out .= $this->getSqlToken( $currTriple[2] );
			}
		}
		if ( $this->infixLevel != 0 ) {
			$this->infix_tokens[] = (object) array( 'type' => 'bracket', 'value' => ')' );
			$out .= ')';
		}
		$this->infixLevel--;
	}

	/**
	 * get SQL condition expression with full brackets (to indicate operators priority)
	 * *** !!also builds $this->infix_tokens array!! ***
	 */
	function getCond() {
		$rootTriple = array();
		$this->rpn_tokens_pos = count( $this->rpn_tokens ) - 1;
		$this->buildTriples( $rootTriple );
		$out = '';
		$this->infixLevel = -1;
		$this->infix_tokens = array();
		# also builds $this->infix_tokens array
		$this->getInfixExpr( $out, $rootTriple );
		if ( count( $this->infix_tokens ) == 0 ) {
			$this->infix_tokens = array(); // default "all"
		}
		return $out;
	}

	/**
	 * get encoded queue string to be stored in a cookie or passed from PHP AJAX handler to js callback
	 * @param $infix set true when infix queue is decoded, otherwise brackets will cause to reset to default "all"
	 *
	 */
	function getEncodedQueue( $is_infix = false ) {
		$result = '';
		if ( $is_infix ) {
			if ( !is_array( $this->infix_tokens ) ) {
				$this->getCond();
			}
			$tokens = &$this->infix_tokens;
		} else {
			$tokens = &$this->rpn_tokens;
		}
		if ( count( $tokens ) < 1 ) {
			return 'all'; // default "show all"
		}
		$firstElem = true;
		foreach ( $tokens as &$token ) {
			if ( $firstElem ) {
				$firstElem = false;
			} else {
				$result .= '_';
			}
			$result .= $token->value;
		}
		return $result;
	}

} /* end of CB_SqlCond class */
