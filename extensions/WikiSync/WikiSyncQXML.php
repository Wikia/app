<?php
/**
 * ***** BEGIN LICENSE BLOCK *****
 * This file is part of WikiSync.
 *
 * WikiSync is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * WikiSync is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with WikiSync; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * ***** END LICENSE BLOCK *****
 *
 * WikiSync allows an AJAX-based synchronization of revisions and files between
 * global wiki site and it's local mirror.
 *
 * To activate this extension :
 * * Create a new directory named WikiSync into the directory "extensions" of MediaWiki.
 * * Place the files from the extension archive there.
 * * Add this line at the end of your LocalSettings.php file :
 * require_once "$IP/extensions/WikiSync/WikiSync.php";
 *
 * @version 0.3.2
 * @link http://www.mediawiki.org/wiki/Extension:WikiSync
 * @author Dmitriy Sintsov <questpc@rambler.ru>
 * @addtogroup Extensions
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is a part of MediaWiki extension.\n" );
} 

/**
 * render output data v0.2
 */
class _QXML {

	/**
	 * The sample stucture of $tag array is like this:
	 * array( '__tag'=>'td', 'class'=>'myclass', 0=>'text before li', 1=>array( '__tag'=>'li', 0=>'text inside li' ), 2=>'text after li' )
	 *
	 * '__tag' key specifies node name
	 * associative keys specify node attributes
	 * numeric keys specify inner nodes of node
	 *
	 * both tagged (with '__tag' attribute) and tagless lists are supported
	 *
	 * tagless lists cannot have associative keys (node attributes)
	 *
	 */

	# next tags ignore text padding on opening (safe indent)
	static $inner_indent_tags = array( 'table', 'tbody', 'tr' );
	# next tags ignore text padding on closing (safe indent)
	static $outer_indent_tags = array( 'table', 'tbody', 'tr', 'th', 'td', 'p' );
	# next tags can be self-closed, according to
	# http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd
	# otherwise, simple switching of Content-Type / DOCTYPE may make generated tree invalid
	# see also
	# http://stackoverflow.com/questions/97522/what-are-all-the-valid-self-closing-tags-in-xhtml-as-implemented-by-the-major-br
	static $self_closed_tags = array( 'base', 'meta', 'link', 'hr', 'br', 'basefont', 'param', 'img', 'area', 'input', 'isindex', 'col' );

	# indent types
	# initial caller
	const TOP_NODE = -1;
	# text node
	const NODE_TEXT = 0;
	# tag without indentation
	const NO_INDENT = 1;
	# tag with outer indent
	const OUTER_INDENT = 2;
	# tag with inner indent
	const INNER_INDENT = 3;

	# used for detection of indent in non-tagged list of nodes
	static $prev_indent_type;

	/**
	 * used for erroneous $tag content reporting
	 */
	static function getTagDump( &$tag ) {
		ob_start();
		var_dump( $tag );
		$tagdump = ob_get_contents();
		ob_end_clean();
		return $tagdump;
	}

	/**
	 * recursive tags generator
	 * @param $tag nested associative array of tag nodes (see an example above)
	 * @param $indent level of indentation (negative to completely suppress indent)
	 */
	static function toText( &$tag, $indent = -1 ) {
		self::$prev_indent_type = self::TOP_NODE;
		return self::_toText( $tag, $indent, self::TOP_NODE );
	}

	/**
	 * recursive tags generator
	 * @param $tag nested associative array of tag nodes (see an example above)
	 * @param $indent level of indentation (negative to completely suppress indent)
	 * @param $caller_indent_type indent type of lower level (caller)
	 */
	static private function _toText( &$tag, $indent = -1, $caller_indent_type ) {
		$tag_open =
		$tag_close = '';
		# $tag_val is a recusively concatenated inner content of tag
		# by default, null value indicates a self-closing tag
		$tag_val = null;
		# current and nested indent levels
		$nested_indent = $indent;
		if ( is_array( $tag ) ) {
			ksort( $tag );
			$current_indent_type = self::NODE_TEXT;
			if ( isset( $tag['__tag'] ) ) {
				$tag_name = strtolower( $tag['__tag'] );
				$current_indent_type = self::NO_INDENT;
				if ( $indent >= 0 ) {
					# inner has predecense (outer contains inner inside)
					if ( in_array( $tag_name, self::$inner_indent_tags ) ) {
						$current_indent_type = self::INNER_INDENT;
						# also indent every indented tag that is inside
						$nested_indent++;
					} elseif ( in_array( $tag_name, self::$outer_indent_tags ) ) {
						$current_indent_type = self::OUTER_INDENT;
						# also indent every indented tag that is inside
						$nested_indent++;
					}
				}
				# list inside tag
				$tag_open .= '<' . $tag['__tag'];
				foreach ( $tag as $attr_key => &$attr_val ) {
					if ( is_int( $attr_key ) ) {
						# numeric node values are going into $tag_val
						if ( $tag_val === null ) {
							$tag_val = '';
						}
						if ( is_array( $attr_val ) ) {
							# recursive list
							$tag_val .= self::_toText( $attr_val, $nested_indent, $current_indent_type );
						} else {
							# text node inside tag
							self::$prev_indent_type = self::NODE_TEXT;
							# use the following format for the debug printouts: "!$attr_val!"
							$tag_val .= $attr_val;
						}
					} else {
						# string keys are for tag attributes
						if ( substr( $attr_key, 0, 2 ) !== '__' ) {
							# include only non-reserved attributes
							$tag_open .= " $attr_key=\"$attr_val\"";
						}
					}
				}
				if ( $tag_val === null && !in_array( $tag_name, self::$self_closed_tags ) ) {
					$tag_val = '';
				}
				if ( $tag_val === null ) {
					$tag_open .= " />";
				} else {
					$tag_open .= '>';
					$tag_close .= '</' . $tag['__tag'] . '>';
				}
			} else {
				# tagless list
				$tag_val = '';
				foreach ( $tag as $attr_key => &$attr_val ) {
					if ( is_int( $attr_key ) ) {
						if ( is_array( $attr_val ) ) {
							# recursive tags
							$tag_val .= self::_toText( $attr_val, $indent, $caller_indent_type );
						} else {
							# text
							if ( self::$prev_indent_type === self::INNER_INDENT ) {
								$attr_val = "\n$attr_val";
							}
							$caller_indent_type = self::NODE_TEXT;
							# use for debug printout
							# $tag_val .= '~' . $attr_val . self::$prev_indent_type . '~';
							$tag_val .= $attr_val;
						}
					} else {
						$tag_val = "Invalid argument: tagless list cannot have tag attribute values in key=$attr_key, " . self::getTagDump( $tag );
					}
				}
				return $tag_val;
			}
		} else {
			# just a text; use "?$tag?" for debug printout
			return $tag;
		}
		# uncomment for the debug printout
		# $tag_close .= "($current_indent_type,$caller_indent_type," . self::$prev_indent_type . ")";
		if ( $current_indent_type === self::INNER_INDENT ) {
			$tag_open = str_repeat( "\t", $indent ) . "$tag_open\n";
			$tag_close = str_repeat( "\t", $indent ) . $tag_close;
			if ( in_array( $caller_indent_type, array( self::TOP_NODE, self::INNER_INDENT ) ) ) {
				$tag_close = "$tag_close\n";
				if ( self::$prev_indent_type === self::NODE_TEXT ) {
					$tag_open = "\n$tag_open";
				}
			} else {
				$tag_open = "\n$tag_open";
			}
		} elseif ( $current_indent_type === self::OUTER_INDENT ) {
			if ( $caller_indent_type === self::INNER_INDENT ) {
				$tag_open = str_repeat( "\t", $indent ) . $tag_open;
				$tag_close = "$tag_close\n";
			}
			if ( self::$prev_indent_type === self::INNER_INDENT ) {
				$tag_close = "\n" . str_repeat( "\t", $indent ) . $tag_close;
			}
		} elseif ( $current_indent_type === self::NO_INDENT ) {
			if ( $indent >= 0 && $caller_indent_type === self::INNER_INDENT ) {
				$tag_close .= "\n";
				if ( self::$prev_indent_type === self::INNER_INDENT ) {
					$tag_close = "\n$tag_close";
				}
			}
		} elseif ( $current_indent_type === self::NODE_TEXT ) {
			if ( self::$prev_indent_type === self::INNER_INDENT ) {
				$tag_close = "\n$tag_close";
			}
		}
		# we support __end only for compatibility to older versions
		# it's deprecated and the usage is discouraged
		if ( isset( $tag['__end'] ) ) {
			$end = $tag['__end'];
			if ( $end === "\n" ) {
				if ( substr( $tag_close, -1 ) === "\n" ) {
					$end = '';
				}
			}
			$tag_close .= $end;
		}
		self::$prev_indent_type = $current_indent_type;
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
				if ( is_array( $attribute_maps ) ) {
					# converts ("count"=>3) to ("colspan"=>3) in table headers - don't use frequently
					foreach ( $attribute_maps as $key => $val ) {
						if ( isset( $cell[$key] ) ) {
							$cell[ $val ] = $cell[ $key ];
							unset( $cell[ $key ] );
						}
					}
				}
			}
			$result = array( '__tag' => 'tr', 0 => $row );
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
				if ( is_array( $attribute_maps ) ) {
					# converts ("count"=>3) to ("rowspan"=>3) in table headers - don't use frequently
					foreach ( $attribute_maps as $key => $val ) {
						if ( isset( $cell[$key] ) ) {
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
				if ( !isset( $table[$row] ) ) {
					$table[ $row ] = array( '__tag' => 'tr' );
				}
				$table[ $row ][] = $cell;
				if ( isset( $cell['rowspan'] ) ) {
					$row += intval( $cell[ 'rowspan' ] );
				} else {
					$row++;
				}
			}
			$result = array( '__tag' => 'tr', 0 => $column );
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
						if ( !isset( $cell[$attr_key] ) ) {
							$cell[ $attr_key ] = $attr_val;
						}
					}
				}
			}
		}
	}

	static function entities( $s ) {
		return htmlentities( $s, ENT_COMPAT, 'UTF-8' );
	}

	static function specialchars( $s ) {
		return htmlspecialchars( $s, ENT_COMPAT, 'UTF-8' );
	}

} /* end of _QXML class */
