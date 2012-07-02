<?php
/**
 * Copyright (C) 2009-2011 by Victor Vasiliev
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * An ugly tool to build SLR-tables.
 *
 * Reads a BNF-ish grammar (strings without <> are terminals) from
 * syntax.txt file and output following files:
 * * LRTableBuildReport.html with misc debug information
 * * LRTable.php, ACTION/GOTO table for grammar in PHP
 *
 * This code requires cleanup, but it's not used outside of development
 * process.
 *
 * This code contains grammar-specific hack to force parser to shift "else"
 * on shift/reduce conflict in "if( ... ) ... (!) else ..." state
 */

$options = array( 'ctable' );
require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/maintenance/commandLine.inc' );

class Grammar {
	var $mTerminals, $mNonterminals, $mProductions, $mSymbols;
	var $mFirst, $mFollow, $mAction, $mGoto, $mCanon;

	private function __construct() {
		$this->mTerminals =
		$this->mNonterminals =
		$this->mProductions =
			array();
	}

	private function getTerminalID( $name ) {
		return array_search( $name, $this->mTerminals );
	}

	/**
	 * Returns the ID of the nonterminal
	 */
	private function getNonterminalID( $name ) {
		if( !in_array( $name, $this->mNonterminals ) )
			$this->mNonterminals[] = $name;
		return array_search( $name, $this->mNonterminals );
	}

	/**
	 * Adds productions
	 */
	private function addProduction( $nonterm, $prod ) {
		$this->mProductions[] = array( $nonterm, $prod );
	}

	/**
	 * Returns all possible productions for the nonterminal.
	 */
	private function getProdsForNt( $nonterm ) {
		$prods = array();
		for( $i = 0; $i < count( $this->mProductions ); $i++ ) {
			$prod = $this->mProductions[$i];
			if( $prod[0] == $nonterm )
				$prods[$i] = $prod[1];
		}
		return $prods;
	}

	private function getNtName( $id ) {
		return $this->mNonterminals[$id];
	}

	/**
	 * Returns the grammar object for a given BNF definition.
	 */
	public static function parse( $def ) {
		$g = new Grammar();
		$g->mTerminals[] = '$';
		$def = strtolower( $def );
		$lines = explode( "\n", $def );
		for( $i = 1; $i <= count( $lines ); $i++ ) {
			$line = preg_replace( '/#(.+)/us', '', $lines[$i - 1] );
			$line = trim( $line );
			if( !$line )
				continue;

			$namevalpailr = self::parseLine( $g, $line, $i );
			if( $namevalpailr ) {
				list( $name, $vals ) = $namevalpailr;
				foreach( $vals as $val )
					$g->addProduction( $name, $val );
			}
		}
		foreach( $g->mProductions as $prod ) {
			list( $ntid, $prod ) = $prod;
			foreach( $prod as $symbol )
				if( is_string( $symbol ) && !in_array( $symbol, $g->mTerminals ) )
					$g->mTerminals[] = $symbol;
		}
		$g->mSymbols = array_merge( $g->mTerminals, array_keys( $g->mNonterminals ) );
		return $g;
	}

	/**
	 * Parses a line in the BNF file.
	 */
	private static function parseLine( $g, $line, $lnum ) {
		$i = 0;
		wfSuppressWarnings();	// @ doesn't help to supress "uninitialized string offset" warning

		self::skipWhitespace( $line, $i );
		if( $line[$i] != '<' )
			die( "Invalid BNF at line $lnum" );
		$i++;

		$end = strpos( $line, '>', $i );
		if( $end === false )
			die( "Invalid BNF at line $lnum" );
		$name = $g->getNonterminalID( substr( $line, $i, $end - $i ) );
		$i = $end + 1;

		self::skipWhitespace( $line, $i );
		if( substr( $line, $i, 3 ) != '::=' )
			die( "Invalid BNF at line $lnum" );
		$i += 3;

		$prods = array();
		$curProd = array();
		while( $i + 1 < strlen( $line ) ) {
			self::skipWhitespace( $line, $i );
			if( $line[$i] == '|' ) {
				$prods[] = $curProd;
				$curProd = array();
				$i++;
			} elseif( $line[$i] == '<' ) {
				$i++;
				$end = strpos( $line, '>', $i );
				if( $end === false )
					die( "Invalid BNF at line $lnum" );
				$curProd[] = $g->getNonterminalID( substr( $line, $i, $end - $i ) );
				$i = $end + 1;
			} else {
				for( $termName = ''; ctype_alnum( $line[$i] ); $i++ )
					$termName .= $line[$i];
				if( !$termName )
					die( "Invalid BNF at line $lnum" );
				$curProd[] = $termName;
			}
		}
		$prods[] = $curProd;
		wfRestoreWarnings();
		return array( $name, $prods );
	}

	/**
	 * Skips all the whitespace in the line and updates $pos
	 */
	private static function skipWhitespace( $line, &$pos ) {
		while( ctype_space( $line[$pos] ) && $pos + 1 < strlen( $line ) )
			$pos++;
	}

	/**
	 * Builds the FIRST() table.
	 * 
	 * FIRST( x ) is a set of terminals with which the productions of x may begin.
	 */
	private function buildFirstTable() {
		foreach( $this->mSymbols as $symbol )
			$this->mFirst[$symbol] = array();

		foreach( $this->mTerminals as $t )
			$this->mFirst[$t][] = $t;

		for( ; ; ) {
			$added = 0;
			foreach( $this->mProductions as $prodbundle ) {
				list( $nt, $prod ) = $prodbundle;
				foreach( $this->mFirst[$prod[0]] as $e ) {
					if( !in_array( $e, $this->mFirst[$nt] ) ) {
						$this->mFirst[$nt][] = $e;
						$added++;
					}
				}
			}
			if( !$added )
				break;
		}
	}

	/**
	 * Builds the FOLLOW() table.
	 * 
	 * FOLLOW( x ) is a set of all terminals that may immediately after x.
	 */
	private function buildFollowTable() {
		foreach( $this->mSymbols as $symbol )
			$this->mFollow[$symbol] = array();
		$this->mFollow[0][] = '$';
		for( ; ; ) {
			$added = 0;
			foreach( $this->mProductions as $prodbundle ) {
				list( $nt, $prod ) = $prodbundle;
				for( $i = 0; $i < count( $prod ) - 1; $i++ ) {
					$symbol = $prod[$i];
					if( is_int( $symbol ) ) {
						foreach( $this->mFirst[$prod[$i + 1]] as $fsymbol ) {
							if( !in_array( $fsymbol, $this->mFollow[$symbol] ) ) {
								$this->mFollow[$symbol][] = $fsymbol;
								$added++;
							}
						}
					}
				}
				$last = end( $prod );
				if( is_int( $last ) ) {
					foreach( $this->mFollow[$nt] as $symbol ) {
						if( !in_array( $symbol, $this->mFollow[$last] ) ) {
							$this->mFollow[$last][] = $symbol;
						}
					}
				}
			}
			if( !$added )
				break;
		}
	}

	private function itemsClosure( $items ) {
		$limit = count( $items );

		for( $i = 0; $i < $limit; $i++ ) {
			$item = $items[$i];

			list( $prodid, $idx ) = $item;
			list( $unused, $prod ) = $this->mProductions[$prodid];
			if( is_int( @$prod[$idx] ) ) {
				foreach( $this->getProdsForNt( $prod[$idx] ) as $id => $newProd ) {
					$item = array( $id, 0 );
					if( !in_array( $item, $items ) ) {
						$items[] = $item;
						$limit++;
					}
				}
			}
		}

		return $items;
	}

	public function itemsGoto( $items, $symbol ) {
		if( is_null( $symbol ) )
			return array();

		$result = array();
		foreach( $items as $item ) {
			list( $prodid, $idx ) = $item;
			$prod = $this->mProductions[$prodid][1];
			if( @$prod[$idx] === $symbol )
				$result[] = array( $prodid, $idx + 1 );
		}
		return $this->itemsClosure( $result );
	}

	public function buildCanonicalSet() {
		$r = array( $this->itemsClosure( array( array( 0, 0 ) ) ) );
		$symbols = array_merge( $this->mTerminals, array_keys( $this->mNonterminals ) );

		$limit = 1;

		for( $i = 0; $i < $limit; $i++ ) {
			$set = $r[$i];
			foreach( $symbols as $symbol ) {
				$goto = $this->itemsGoto( $set, $symbol );
				if( $goto && !in_array( $goto, $r ) ) {
					$r[] = $goto;
					$limit++;
				}
			}
		}

		return $r;
	}

	public function buildLRTable() {
		$this->buildFirstTable();
		$this->buildFollowTable();
		$canonSet = $this->buildCanonicalSet();

		$actionTable = array();
		$gotoTable = array();
		for( $i = 0; $i < count( $canonSet ); $i++ ) {
			$set = $canonSet[$i];
			$row = $rowGoto = array();
			foreach( $set as $item ) {
				list( $prodid, $idx ) = $item;
				list( $nt, $prod ) = $this->mProductions[$prodid];
				$goto = $this->itemsGoto( $set, @$prod[$idx] );
				for( $j = 0; $j < count( $canonSet ); $j++ ) {
					if( $goto == $canonSet[$j] ) {
						if( is_string( $prod[$idx] ) ) {
							$act = array( 'shift', $j );
							if( isset( $row[$prod[$idx]] ) && $row[$prod[$idx]] != $act )
								if( $prod[0] != 'if' )	// Grammar-specific manual hack for "hanging if" problem
									$this->conflictError( $i, $set, $row[$prod[$idx]], $act, $prod[$idx] );
							$row[$prod[$idx]] = $act;
						} else {
							$rowGoto[$prod[$idx]] = $j;
						}
					}
				}
				if( $idx == count( $prod ) ) {
					if( $prodid ) {
						foreach( $this->mFollow[$nt] as $symbol ) {
							$act = array( 'reduce', $prodid );
							if( isset( $row[$symbol] ) && $row[$symbol] != $act ) {
									$this->conflictError( $i, $set, $row[$symbol], $act, $symbol );
							}
							$row[$symbol] = $act;
						}
					} else {
						$row['$'] = array( 'accept' );
					}
				}
			}
			$actionTable[$i] = $row;
			$gotoTable[$i] = $rowGoto;
		}

		$this->mAction = $actionTable;
		$this->mGoto = $gotoTable;
		$this->mCanon = $canonSet;
	}

	/** Debug */
	public function formatProduction( $prodid ) {
		list( $subj, $val ) = $this->mProductions[$prodid];
		$s = array( $this->getNtName( $subj ), "->" );
		foreach( $val as $symbol ) {
			if( is_string( $symbol ) )
				$s[] = strtoupper( $symbol );
			else
				$s[] = $this->getNtName( $symbol );
		}
		return implode( ' ', $s );
	}

	public function formatItem( $item, $html = false ) {
		list( $prodid, $idx ) = $item;
		list( $subj, $val ) = $this->mProductions[$prodid];
		$subjname = $this->getNtName( $subj );
		$s = $html ?
			array( "<b>{$subjname}</b>",  '&rarr;' ) :
			array( $subjname, '->' );
		for( $i = 0; $i <= count( $val ); $i++ ) {
			if( $i == $idx )
				$s[] = $html ? '&bullet;' : '(!)';
			if( $symbol = @$val[$i] ) {
				if( is_string( $symbol ) )
					$s[] = $html ? $symbol : strtoupper( $symbol );
				else
					$s[] = $html ?
						'<b>' . $this->getNtName( $symbol ) . '</b>' :
						$this->getNtName( $symbol );
			}
		}
		return implode( ' ', $s );
	}

	public function formatAction( $act ) {
		@list( $name, $arg ) = $act;
		if( $name == 'shift' ) {
			return "Shift to state {$arg}";
		}
		if( $name == 'reduce' ) {
			$prod = $this->formatProduction( $arg );
			return "Reduce to production {$arg} ({$prod})";
		}
		if( $name == 'accept' ) {
			return "Accept";
		}
	}

	public function conflictError( $id, $state, $act1, $act2, $symbol ) {
		echo "Found conflict in state {$id} for symbol {$symbol}.\n";
		echo "Conflicting actions:\n";
		foreach( array( $act1, $act2 ) as $act ) {
			$str = $this->formatAction( $act );
			echo "* {$str}\n";
		}
		echo "Items of the state:\n";
		foreach( $state as $item ) {
			$str = $this->formatItem( $item );
			echo "* {$str}\n";
		}
		exit;
	}

	public function buildHTMLDump() {
		$s = <<<END
<html>
<head>
<title>Scripts LR table dump</title>
<style type="text/css">
table {
    margin: 1em 1em 1em 0;
    background: #f9f9f9;
    border: 1px #aaa solid;
    border-collapse: collapse;
}
th, td {
    border: 1px #aaa solid;
    padding: 0.2em;
}
th {
    background: #f2f2f2;
    text-align: center;
}
caption {
    font-weight: bold;
}
</style>
</head>
<body>
<p>Here is the dump of LR table itself, as well as data used to build it.</p>
<p>Navigate: <a href="#first">FIRST()</a> | <a href="#follow">FOLLOW()</a> | <a href="#prods">Productions</a>
 | <a href="#canon">Canonical set</a> | <a href="#table">ACTION/GOTO</a></p>
END;

		$s .= "<h1><a name='first' id='first'>FIRST()</h1><table><tr><th>Symbol</th><th>FIRST(Symbol)</th></tr>\n";
		foreach( $this->mFirst as $item => $val ) {
			$itemname = is_int( $item ) ? '<i>' . $this->getNtName( $item ) . '</i>'
				: "<b>{$item}</b>";
			$s .= "<tr><td>{$itemname}</td><td>" . implode( ', ', $val ) . "</td></tr>\n";
		}
		$s .= "</table>\n";

		$s .= "<h1><a name='follow' id='follow'>FOLLOW()</h1><table><tr><th>Symbol</th><th>FOLLOW(Symbol)</th></tr>\n";
		foreach( $this->mFollow as $item => $val ) {
			if( !$val ) continue;
			$itemname = is_int( $item ) ? '<i>' . $this->getNtName( $item ) . '</i>'
				: "<b>{$item}</b>";
			$s .= "<tr><td>{$itemname}</td><td>" . implode( ', ', $val ) . "</td></tr>\n";
		}
		$s .= "</table>\n";

		$s .= "<h1><a name='prods' id='prods'>Productions</h1><table><tr><th>ID</th><th>Production</th></tr>\n";
		foreach( $this->mProductions as $id => $val ) {
			$str = $this->formatProduction( $id );
			$s .= "<tr><td><b>{$id}</b></td><td>{$str}</td></tr>\n";
		}
		$s .= "</table>\n";

		// Find max length of a canonical set
		$max = 1;
		foreach( $this->mCanon as $state ) {
			$max = max( $max, count( $state ) );
		}

		$s .= "<h1><a name='canon' id='canon' />Canonical set</h1>";
		$s .= "<table><tr><th>State ID</th><th colspan={$max}>Items</th></tr>\n";
		for( $i = 0; $i < count( $this->mCanon ); $i++ ) {
			$s .= "<tr id='state{$i}'><td><a href='#lrtable{$i}'><b>{$i}</b></a></td>";
			for( $j = 0; $j < $max; $j++ )
				$s .= isset( $this->mCanon[$i][$j] ) ?
					"<td style='white-space: nowrap'>" . $this->formatItem( $this->mCanon[$i][$j], true ) . "</li>" :
					"<td></td>";
			$s .= "</tr>\n";
		}
		$s .= "</table>\n";

		$termLen = count( $this->mTerminals );
		$nontermLen = count( $this->mNonterminals );
		$s .= "<h1><a name='table' id='action'>LR-table (ACTION/GOTO)</h1><table><tr><th>State ID</th>" .
			"<th colspan={$termLen}>ACTION</th><th colspan={$nontermLen}>GOTO</th></tr><tr><th></th><th>" .
			implode( '</th><th>', $this->mTerminals ) . '</th><th>' . implode( '</th><th>', array_values( $this->mNonterminals ) ) . "</th></tr>\n";
		for( $id = 0; $id < count( $this->mAction ); $id++ ) {
			$row = $this->mAction[$id];
			$goto = $this->mGoto[$id];
			
			// Output ID
			$s .= "\t<tr id='lrtable{$id}'><td><b><a href='#state{$id}'>{$id}</a></b></td>";

			// Output ACTION
			foreach( $this->mTerminals as $t ) {
				$act = @$row[$t];
				if( $act ) {
					switch( $act[0] ) {
						case 'shift':
							$s .= "<td style='background-color: #FFF0A0'>s{$act[1]}</td>"; break;
						case 'reduce':
							$s .= "<td style='background-color: #A0B5FF'>r{$act[1]}</td>"; break;
						case 'accept':
							$s .= "<td style='background-color: #AAFFA0'>acc</td>"; break;
					}
				} else {
					$s .= "<td></td>";
				}
			}

			// Output GOTO
			foreach( $this->mNonterminals as $ntid => $ntname ) {
				if( isset( $goto[$ntid] ) ) {
					$s .= "<td>{$goto[$ntid]}</td>";
				} else {
					$s .= "<td></td>";
				}
			}
			$s .= "</tr>\n";
		}
		$s .= "</table>\n";

		$s .= "<hr/><p>Autogenerated on " . gmdate( 'Y-m-d H:i:s' ) . "</p></body></html>";
		return $s;
	}

	private function formatArray( $array ) {
		if( !$array )
			return 'array()';
		foreach( $array as &$item ) {
			if( is_string( $item ) )
				$item = "'{$item}'";
		}
		return 'array( ' . implode( ', ', $array ) . ' )';
	}

	private function formatAssocArray( $array ) {
		if( !$array )
			return 'array()';
		$result = array();
		foreach( $array as $k => $v ) {
			if( is_string( $v ) )
				$v = "'{$v}'";
			$result[] = "{$k} => {$v}";
		}
		return 'array( ' . implode( ', ', $result ) . ' )';
	}

	public function buildPHPFile( $ts ) {
		$date = $ts;
		$s = <<<ENDOFHEADER
<?php

/**
 * Autogenerated SLR-table for scripts language.
 *
 * You should not try to modify it manually (it's very easy to break).
 * Use syntax.txt and buildLRTables.php insteaed.
 *
 * Actions have following syntax
 *   array( 0, N ) means "shift and go to state N"
 *   array( 1, N ) means "reduce to production N"
 *   array( 2 ) means "accept"
 *   null means "error"
 *
 * Terminals are referred by names, nonterminals - by ids.
 *
 * Variables has following format:
 * * \$nonterminals is a nonterminal ID -> name map.
 * * \$productions is a ID -> array( nonterminal, body ) map.
 * * Production body is an array of production symbols
 *
 * Generated on {$date}.
 */

class WSLRTable {

const Timestamp = '{$date}';


ENDOFHEADER;

		$s .= "static \$nonterminals = array(\n";
		foreach( $this->mNonterminals as $id => $val ) {
			$s .= "\t{$id} => '{$val}',\n";
		}
		$s .= ");\n\n";

		$s .= "static \$productions = array(\n";
		foreach( $this->mProductions as $id => $val ) {
			$body = $this->formatArray( $val[1] );
			$s .= "\t{$id} => array( {$val[0]}, {$body} ),\n";
		}
		$s .= ");\n\n";

		$s .= "static \$action = array(\n";
		foreach( $this->mAction as $id => $row ) {
			$s .= "\t{$id} => array(\n";
			foreach( $row as $t => $action ) {
				if( $action[0] == 'shift' )
					$s .= "\t\t'{$t}' => array( 0, {$action[1]} ),\n";
				if( $action[0] == 'reduce' )
					$s .= "\t\t'{$t}' => array( 1, {$action[1]} ),\n";
				if( $action[0] == 'accept' )
					$s .= "\t\t'{$t}' => array( 2, null ),\n";
			}
			$s .= "\t),\n";
		}
		$s .= ");\n\n";

		$s .= "static \$goto = array(\n";
		foreach( $this->mGoto as $id => $row ) {
			$body = $this->formatAssocArray( $row );
			$s .= "\t{$id} => {$body},\n";
		}
		$s .= ");\n\n";

		$s .= "}\n";
		return $s;
	}

	public function buildCTokenHeader() {
		// Build token files
		$defs = '';
		for( $i = 0; $i < count( $this->mTerminals ); $i++ ) {
			if( $i == 0 )
				$id = 'WS_TOKEN_END';
			else
				$id = 'WS_TOKEN_' . strtoupper( $this->mTerminals[$i] );
			$defs .= "#define {$id} {$i}\n";
		}

		return <<<EOF
/**
 * This file is autogenerated by buildLRTables.php and contains the IDs of differnet
 * tokens.
 */

{$defs}
EOF;
	}

	private function formatProductionC( $prod ) {
		$maxProdSize = 16;	// WS_PARSER_MAX_PRODUCTION_LENGTH
		list( $nt, $body ) = $prod;

		$len = count( $body );
		$prodItems = array();
		for( $i = 0; $i < $maxProdSize; $i++ ) {
			if( isset( $body[$i] ) ) {
				if( is_string( $body[$i] ) ) {
					$prodItems[] = "{ WS_PARSER_TERM, " . $this->getTerminalID( $body[$i] ) . " }";
				} else {
					$prodItems[] = "{ WS_PARSER_NONTERM, {$body[$i]} }";
				}
			} else {
				$prodItems[] = "{ WS_PARSER_EMPTY, 0 }";
			}
		}
		return "{ {$nt}, {$len}, { " . implode( ', ', $prodItems ) . "} }";
	}

	public function buildCTokenList() {
		$cases = '';
		for( $i = 0; $i < count( $this->mTerminals ); $i++ ) {
			$val = $this->mTerminals[$i];
			if( $i == 0 )
				$id = 'WS_TOKEN_END';
			else
				$id = 'WS_TOKEN_' . strtoupper( $val );
			$cases .= "\t\tcase {$id}:\n\t\t\treturn \"{$val}\";\n";
		}

		return <<<EOF
/**
 * This file is autogenerated by buildLRTables.php and contains the IDs of differnet
 * tokens.
 */

#include "scanner.h"

const char* ws_scanner_token_name(ws_token_type type) {
	switch( type ) {
{$cases}
		default:
			return "???";
	}
}
EOF;
	}

	public function buildCTable() {
		//char* ws_parser_nonterminal_names[]
		
		$s = "#include \"parser.h\"\n\n";

		// Nonterminals
		$s .= "char* ws_parser_nonterminal_names[] = {\n";
		foreach( $this->mNonterminals as $nt ) {
			$s .= "\t\"{$nt}\",\n";
		}
		$s .= "};\n\n";

		// Productions
		$s .= "ws_parser_production ws_parser_productions[] = {\n";
		foreach( $this->mProductions as $prod ) {
			$s .= "\t" . $this->formatProductionC( $prod ) . ",\n";
		}
		$s .= "};\n\n";

		// Action
		$s .= "ws_parser_action_entry ws_parser_table_action[WS_PARSER_STATE_COUNT][WS_PARSER_TERM_COUNT] = {\n";
		for( $i = 0; $i < count( $this->mAction ); $i++ ) {
			$s .= "\t{\n";
			for( $j = 0; $j < count( $this->mTerminals ); $j ++ ) {
				$t = $this->mTerminals[$j];
				if( isset( $this->mAction[$i][$t] ) ) {
					switch( $this->mAction[$i][$t][0] ) {
						case 'shift':
							$s .= "\t\t{ WS_PARSER_SHIFT, " . $this->mAction[$i][$t][1] . " },\n";
							break;
						case 'reduce':
							$s .= "\t\t{ WS_PARSER_REDUCE, {$this->mAction[$i][$t][1]} },\n";
							break;
						case 'accept':
							$s .= "\t\t{ WS_PARSER_ACCEPT, 0 },\n";
							break;
					}
				} else {
					$s .= "\t\t{ WS_PARSER_ERROR, 0 },\n";
				}
			}
			$s .= "\t},\n";
		}
		$s .= "};\n\n";

		// Goto
		$s .= "ws_parser_goto_entry ws_parser_table_goto[WS_PARSER_STATE_COUNT][WS_PARSER_NONTERM_COUNT] = {\n";
		for( $i = 0; $i < count( $this->mGoto ); $i++ ) {
			$s .= "\t{\n";
			for( $j = 0; $j < count( $this->mNonterminals ); $j ++ ) {
				if( isset( $this->mGoto[$i][$j] ) ) {
					$s .= "\t\t{$this->mGoto[$i][$j]},\n";
				} else {
					$s .= "\t\t/* ERROR */ 0xFF,\n";
				}
			}
			$s .= "\t},\n";
		}
		$s .= "};\n\n";

		return $s;
	}

	public function buildCTableHeader( $ts ) {
		$stateCount = count( $this->mCanon );
		$termCount = count( $this->mTerminals );
		$nontermCount = count( $this->mNonterminals );

		return <<<EOF
#define WS_PARSER_STATE_COUNT {$stateCount}
#define WS_PARSER_TERM_COUNT {$termCount}
#define WS_PARSER_NONTERM_COUNT {$nontermCount}
#define WS_PARSER_VERSION "{$ts}"

EOF;
	}

	public function buildPHPVersionFile( $ts ) {
		return <<<EOF
<?php

/**
 * This file includes timestamp which indicates the version of LRTable.php file.
 * Since the file is too large, loading it every time is expensive and we store the
 * version in separate file.
 */

define( 'WS_LR_VERSION', "{$ts}" );

EOF;
	}
}

$ts = gmdate( 'Y-m-d H:i:s' );

$definition = file_get_contents( dirname( __FILE__ ) . '/syntax.txt' );
$grammar = Grammar::parse( $definition );
$grammar->buildLRTable();

$base = dirname( __FILE__ );

if( isset( $options['ctable'] ) ) {
	// C LR table is too large and autogenerated
	file_put_contents( "{$base}/nparser/lrtable.c", $grammar->buildCTable() );
} else {
	// Build PHP files
	file_put_contents( "{$base}/LRTableBuildReport.html", $grammar->buildHTMLDump() );
	file_put_contents( "{$base}/LRTable.php", $grammar->buildPHPFile( $ts ) );
	file_put_contents( "{$base}/LRTableVersion.php", $grammar->buildPHPVersionFile( $ts ) );

	// Build C files
	file_put_contents( "{$base}/nparser/tokenids.h", $grammar->buildCTokenHeader() );
	file_put_contents( "{$base}/nparser/scanner_names.c", $grammar->buildCTokenList() );
	file_put_contents( "{$base}/nparser/lrtable.h", $grammar->buildCTableHeader( $ts ) );

	// LR table file will be automatically regenerated
	if( file_exists( "{$base}/nparser/lrtable.c" ) )
		unlink( "{$base}/nparser/lrtable.c" );
}
