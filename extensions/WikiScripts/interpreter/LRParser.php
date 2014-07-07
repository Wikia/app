<?php

/**
 * LR parser for scripts.
 * Inputs tokens and LR table (ACTION/GOTO).
 * Outputs parser tree.
 * 
 * See http://en.wikipedia.org/wiki/LR_parser for details of how does that works.
 */

require_once( 'LRTableVersion.php' );

class WSLRParser implements WSParser {
	const Shift = 0;
	const Reduce = 1;
	const Accept = 2;

	static $mLoaded, $mNonterminals, $mProductions, $mAction, $mGoto;

	public static function getVersion() {
		return WS_LR_VERSION;
	}

	private function loadGrammar() {
		wfProfileIn( __METHOD__ );

		if( self::$mLoaded ) {
			wfProfileOut( __METHOD__ );
			return;
		}

		require_once( 'LRTable.php' );

		self::$mNonterminals = WSLRTable::$nonterminals;
		self::$mProductions = WSLRTable::$productions;
		self::$mAction = WSLRTable::$action;
		self::$mGoto = WSLRTable::$goto;
		self::$mLoaded = true;
		
		wfProfileOut( __METHOD__ );
	}

	public function needsScanner() {
		return true;
	}

	public function parse( $scanner, $module, $maxTokens ) {
		self::loadGrammar();

		$states = array( array( null, 0 ) );
		$scanner->rewind();
		$tokenCount = 0;

		wfProfileIn( __METHOD__ );

		for( ; ; ) {
			$token = $scanner->current();
			$cur = $token->type;
			if( !$token ) {
				wfProfileOut( __METHOD__ );
				throw new WSException( 'Non-token input in LRParser::parse' );
			}

			$tokenCount++;
			if( $tokenCount > $maxTokens ) {
				wfProfileOut( __METHOD__ );
				throw new WSUserVisibleException( 'toomanytokens', $module, $token->line );
			}

			list( $stateval, $state ) = end( $states );
			$act = @self::$mAction[$state][$cur];
			if( !$act ) {
				wfProfileOut( __METHOD__ );
				throw new WSUserVisibleException( 'unexceptedtoken', $module, $token->line,
					array( $token, implode( ', ', array_keys( @self::$mAction[$state] ) ), $state ) );
			}
			if( $act[0] == self::Shift ) {
					$states[] = array( $token, $act[1] );
					$scanner->next();
			} elseif( $act[0] == self::Reduce ) {
					list( $nonterm, $prod ) = self::$mProductions[$act[1]];
					$len = count( $prod );

					// Change state
					$str = array();
					for( $i = 0; $i < $len; $i++ )
						$str[] = array_pop( $states );
					$str = array_reverse( $str );
					list( $stateval, $state ) = end( $states );

					$node = new WSParserTreeNode( $this, $nonterm );
					foreach( $str as $symbol ) {
						list( $val ) = $symbol;
						$node->addChild( $val );
					}
					$states[] = array( $node, self::$mGoto[$state][$nonterm] );
			} elseif( $act[0] == self::Accept ) {
					break;
			}
		}

		wfProfileOut( __METHOD__ );

		return new WSParserOutput( $states[1][0], $tokenCount );
	}
	
	public function getSyntaxErrors( $input, $module, $maxTokens ) {
		try {
			$this->parse( $input, $module, $maxTokens );
		} catch( WSUserVisibleException $e ) {
			return array( $e->getMessage() );
		}

		return array();
	}
}
