<?php

/**
 * This file contains implementation-independent interface files for
 * inline scripts interpreter.
 */

class ISToken {
	// Constant values should match ones in syntax.txt
	const TEnd = '$';
	const TBreak = 'break';
	const TCatch = 'catch';
	const TColon = 'colon';	// :
	const TCompareOperator = 'comareop';	// <, >, <= or >=
	const TComma = 'comma';	// ,
	const TContains = 'contains';
	const TContinue = 'continue';
	const TElse = 'else';
	const TEqualsToOperator = 'equalsto';	// ==, ===, != or !==
	const TFalse = 'false';
	const TFloat = 'float';
	const TForeach = 'foreach';
	const TID = 'id';
	const TIf = 'if';
	const TIn = 'in';
	const TInt = 'int';
	const TBoolInvert = 'invert';	// !
	const TIsset = 'isset';
	const TLeftBrace = 'leftbrace';	// (
	const TLeftCurly = 'leftcurly';	// {
	const TLeftSquare = 'leftsquare';	// [
	const TLogicalOperator = 'logicop';	// &, | or ^
	const TMulOperator = 'mul';	// *, / or %
	const TNull = 'null';
	const TPow = 'pow';	// **
	const TRightBrace = 'rightbrace';	// )
	const TRightCurly = 'rightcurly';	// }
	const TRightSquare = 'rightsquare';	// ]
	const TSemicolon = 'semicolon';	// ;
	const TSet = 'setto';	// =
	const TString = 'string';
	const TSumOperator = 'sum';	// + or -
	const TTrinary = 'trinary';	// ?
	const TTrue = 'true';
	const TTry = 'try';
	const TUnset = 'unset';

	var $type;
	var $value;
	var $line;

	public function __construct( $type = self::TEnd, $value = null, $line = 0 ) {
		$this->type = $type;
		$this->value = $value;
		$this->line = $line;
	}

	function __toString() {
		return "{$this->value}";
	}
}

class ISParserTreeNode {
	var $mType, $mChildren;

	public function __construct( $parser, $id ) {
		$this->mType = $parser->mNonterminals[$id];
	}

	public function addChild( $node ) {
		if( $node instanceof ISParserTreeNode ) {
			$children = $node->getChildren();
			if( count( $children ) == 1 && strpos( $node->mType, "expr" ) === 0
			  && strpos( @$children[0]->mType, "expr" ) === 0 ) {
				$this->mChildren[] = $children[0];
				return;
			}
		}
		$this->mChildren[] = $node;
	}

	public function getChildren() {
		return $this->mChildren;
	}

	public function getType() {
		return $this->mType;
	}

	public function __toString() {
		$r = $this->formatStringArray();
		return implode( "\n", $r );
	}

	public function formatStringArray() {
		$s = array( "<nonterminal type=\"{$this->mType}\">" );
		foreach( $this->mChildren as $child ) {
			if( $child instanceof ISParserTreeNode ) {
				$sub = $child->formatStringArray();
				foreach( $sub as $str )
					$s[] = "\t" . $str;
			} else {
				$s[] = "\t<terminal type=\"{$child->type}\" value=\"{$child->value}\" />";
			}
		}
		$s[] = "</nonterminal>";
		return $s;
	}
}

interface ISParser {
	/**
	 * If this function returns true, code scanner is passed to parse().
	 * Otherwise, code itself is passed.
	 */
	public function needsScanner();

	/**
	 * Parses code (in text or scanner) to parser tree.
	 * @param input ISScanner Input (scanner or string)
	 * @param maxTokens int Maximal amount of tokens
	 * @return ISParserTreeNode
	 */
	public function parse( $input, $maxTokens );
}

class ISException extends MWException {}

// Exceptions that we might conceivably want to report to ordinary users
// (i.e. exceptions that don't represent bugs in the extension itself)
class ISUserVisibleException extends ISException {
	function __construct( $exception_id, $line, $params = array() ) {
		$msg = wfMsgExt( 'inlinescripts-exception-' . $exception_id, array(), array_merge( array($line), $params ) );
		parent::__construct( $msg );

		$this->mExceptionID = $exception_id;
		$this->mLine = $line;
		$this->mParams = $params;
	}

	public function getExceptionID() {
		return $this->mExceptionID;
	}
}

class ISParserOutput {
	var $mTree, $mTokensCount, $mVersion;

	public function __construct( $tree, $tokens ) {
		global $wgInlineScriptsParserClass;
		$this->mTree = $tree;
		$this->mTokensCount = $tokens;
		$this->mVersion = constant( "$wgInlineScriptsParserClass::Version" );
	}

	public function getParserTree() {
		return $this->mTree;
	}

	public function isOutOfDate() {
		global $wgInlineScriptsParserClass;
		return constant( "$wgInlineScriptsParserClass::Version" ) > $this->mVersion;
	}

	public function appendTokenCount( &$interpr ) {
		global $wgInlineScriptsLimits;
		$interpr->mParser->is_tokensCount += $this->mTokensCount;
		if( $interpr->mParser->is_tokensCount > $wgInlineScriptsLimits['tokens'] )
			throw new ISUserVisibleException( 'toomanytokens', 0 );
	}
}
