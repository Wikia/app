<?php

/**
 * LR parser for inline scripts.
 * Inputs tokens and LR table (ACTION/GOTO).
 * Outputs parser tree.
 */

class ISLRParser implements ISParser {
	const Version = 1;

	const Shift = 0;
	const Reduce = 1;
	const Accept = 2;

	var $mNonterminals, $mProductions, $mAction, $mGoto;

	public function __construct() {
		$this->loadGrammar();
	}

	private function loadGrammar() {
		require_once( 'LRTable.php' );

		$this->mNonterminals = ISLRTable::$nonterminals;
		$this->mProductions = ISLRTable::$productions;
		$this->mAction = ISLRTable::$action;
		$this->mGoto = ISLRTable::$goto;
	}

	public function needsScanner() {
		return true;
	}

	public function parse( $scanner, $maxTokens ) {
		$states = array( array( null, 0 ) );
		$scanner->rewind();
		$tokenCount = 0;

		for( ; ; ) {
			$token = $scanner->current();
			$cur = $token->type;
			if( !$token ) 
				throw new ISException( 'Non-token input in LRParser::parse' );

			$tokenCount++;
			if( $tokenCount > $maxTokens )
				throw new ISUserVisibleException( 'toomanytokens', $token->line );

			list( $stateval, $state ) = end( $states );
			$act = @$this->mAction[$state][$cur];
			if( !$act ) {
				throw new ISUserVisibleException( 'unexceptedtoken', $token->line,
					array( $token, implode( ', ', array_keys( @$this->mAction[$state] ) ) ) );
			}
			if( $act[0] == self::Shift ) {
					$states[] = array( $token, $act[1] );
					$scanner->next();
			} elseif( $act[0] == self::Reduce ) {
					list( $nonterm, $prod ) = $this->mProductions[$act[1]];
					$len = count( $prod );

					// Change state
					$str = array();
					for( $i = 0; $i < $len; $i++ )
						$str[] = array_pop( $states );
					$str = array_reverse( $str );
					list( $stateval, $state ) = end( $states );

					$node = new ISParserTreeNode( $this, $nonterm );
					foreach( $str as $symbol ) {
						list( $val ) = $symbol;
						$node->addChild( $val );
					}
					$states[] = array( $node, $this->mGoto[$state][$nonterm] );
			} elseif( $act[0] == self::Accept ) {
					break;
			}
		}

		return new ISParserOutput( $states[1][0], $tokenCount );
	}
}
