<?php

/**
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

require_once( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) . '/maintenance/commandLine.inc' );

class Grammar {
	var $mTerminals, $mNonterminals, $mProductions, $mSymbols;
	var $mFirst, $mFollow, $mAction, $mGoto;

	private function __construct() {
		$this->mTerminals =
		$this->mNonterminals =
		$this->mProductions =
			array();
	}

	private function getNonterminalID( $name ) {
		if( !in_array( $name, $this->mNonterminals ) )
			$this->mNonterminals[] = $name;
		return array_search( $name, $this->mNonterminals );
	}

	private function addProduction( $nonterm, $prod ) {
		$this->mProductions[] = array( $nonterm, $prod );
	}

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

	public static function parse( $def ) {
		$g = new Grammar();
		$def = strtolower( $def );
		$lines = explode( "\n", $def );
		for( $i = 1; $i <= count( $lines ); $i++ ) {
			$line = trim( $lines[$i - 1] );
			if( !$line )
				continue;

			list( $name, $vals ) = self::parseLine( $g, $line, $i );
			foreach( $vals as $val )
				$g->addProduction( $name, $val );
		}
		foreach( $g->mProductions as $prod ) {
			list( $ntid, $prod ) = $prod;
			foreach( $prod as $symbol )
				if( is_string( $symbol ) && !in_array( $symbol, $g->mTerminals ) )
					$g->mTerminals[] = $symbol;
		}
		$g->mTerminals[] = '$';
		$g->mSymbols = array_merge( $g->mTerminals, array_keys( $g->mNonterminals ) );
		return $g;
	}

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
			} else if( $line[$i] == '<' ) {
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

	private static function skipWhitespace( $line, &$pos ) {
		while( ctype_space( $line[$pos] ) && $pos + 1 < strlen( $line ) )
			$pos++;
	}

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
		for( ; ; ) {
			$oldsize = count( $items );
			foreach( $items as $item ) {
				list( $prodid, $idx ) = $item;
				list( $unused, $prod ) = $this->mProductions[$prodid];
				if( is_int( @$prod[$idx] ) ) {
					foreach( $this->getProdsForNt( $prod[$idx] ) as $id => $newProd ) {
						$item = array( $id, 0 );
						if( !in_array( $item, $items ) )
							$items[] = $item;
					}
				}
			}
			if( count( $items ) == $oldsize )
				return $items;
		}
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
		for( ; ; ) {
			$oldsize = count( $r );
			foreach( $r as $set ) {
				foreach( $symbols as $symbol ) {
					$goto = $this->itemsGoto( $set, $symbol );
					if( $goto && !in_array( $goto, $r ) )
						$r[] = $goto;
				}
			}
			if( $oldsize == count( $r ) )
				break;
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

	public function formatItem( $item ) {
		list( $prodid, $idx ) = $item;
		list( $subj, $val ) = $this->mProductions[$prodid];
		$s = array( $this->getNtName( $subj ), "->" );
		for( $i = 0; $i <= count( $val ); $i++ ) {
			if( $i == $idx )
				$s[] = '(!)';
			if( $symbol = @$val[$i] ) {
				if( is_string( $symbol ) )
					$s[] = strtoupper( $symbol );
				else
					$s[] = $this->getNtName( $symbol );
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
<title>Inline scripts LR table dump</title>
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
 | <a href="#table">ACTION/GOTO</a></p>
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

		$termLen = count( $this->mTerminals );
		$nontermLen = count( $this->mNonterminals );
		$s .= "<h1><a name='table' id='action'>LR-table (ACTION/GOTO)</h1><table><tr><th rowspan=2>State ID</th>" .
			"<th colspan={$termLen}>ACTION</th><th colspan={$nontermLen}>GOTO</th></tr><tr><th>" .
			implode( '</th><th>', $this->mTerminals ) . '</th><th>' . implode( '</th><th>', array_values( $this->mNonterminals ) ) . "</th></tr>\n";
		for( $id = 0; $id < count( $this->mAction ); $id++ ) {
			$row = $this->mAction[$id];
			$goto = $this->mGoto[$id];
			$s .= "\t<tr><td><b>{$id}</b></td>";
			foreach( $this->mTerminals as $t ) {
				$act = @$row[$t];
				if( $act ) {
					switch( $act[0] ) {
						case 'shift':
							$s .= "<td>s{$act[1]}</td>"; break;
						case 'reduce':
							$s .= "<td>r{$act[1]}</td>"; break;
						case 'accept':
							$s .= "<td>acc</td>"; break;
					}
				} else {
					$s .= "<td></td>";
				}
			}
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

	public function buildPHPFile() {
		$date = gmdate( 'Y-m-d H:i' );
		$s = <<<ENDOFHEADER
<?php

/**
 * Autogenerated SLR-table for inline scripts language.
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

class ISLRTable {


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
}

$definition = file_get_contents( dirname( __FILE__ ) . '/syntax.txt' );
$grammar = Grammar::parse( $definition );
$grammar->buildLRTable();
file_put_contents( 'LRTableBuildReport.html', $grammar->buildHTMLDump() );
file_put_contents( 'LRTable.php', $grammar->buildPHPFile() );
