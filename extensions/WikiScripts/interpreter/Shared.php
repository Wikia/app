<?php
/**
 * Built-in scripting language for MediaWiki: implementation-independent interface 
 * for scripts parser.
 * Copyright (C) 2009-2011 Victor Vasiliev <vasilvv@gmail.com>
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
 * This class represents a terminal of the script grammar.
 */
class WSToken {
	// Constant values should match ones in syntax.txt
	const TEnd = '$';
	const TAppend = 'append';
	const TBreak = 'break';
	const TCatch = 'catch';
	const TColon = 'colon';	// :
	const TCompareOperator = 'compareop';	// <, >, <= or >=
	const TComma = 'comma';	// ,
	const TContains = 'contains';
	const TContinue = 'continue';
	const TDelete = 'delete';
	const TDoubleColon = 'doublecolon';
	const TElse = 'else';
	const TEqualsToOperator = 'equalsto';	// ==, ===, != or !==
	const TFalse = 'false';
	const TFloat = 'float';
	const TFor = 'for';
	const TID = 'id';
	const TIf = 'if';
	const TIn = 'in';
	const TInt = 'int';
	const TBoolInvert = 'invert';	// !
	const TIsset = 'isset';
	const TLeftBracket = 'leftbracket';	// (
	const TLeftCurly = 'leftcurly';	// {
	const TLeftSquare = 'leftsquare';	// [
	const TLogicalOperator = 'logicop';	// &, | or ^
	const TMulOperator = 'mul';	// *, / or %
	const TNull = 'null';
	const TPow = 'pow';	// **
	const TReturn = 'return';
	const TRightBracket = 'rightbracket';	// )
	const TRightCurly = 'rightcurly';	// }
	const TRightSquare = 'rightsquare';	// ]
	const TSemicolon = 'semicolon';	// ;
	const TSet = 'setto';	// =
	const TSelf = 'self';
	const TString = 'string';
	const TSumOperator = 'sum';	// + or -
	const TTrinary = 'trinary';	// ?
	const TTrue = 'true';
	const TTry = 'try';
	const TYield = 'yield';

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

/**
 * This class represents a non-terminal of the script grammar.
 */
class WSParserTreeNode {
	var $mType, $mChildren;

	public function __construct( $parser, $id ) {
		$parserClass = get_class( $parser );
		$this->mType = $parserClass::$mNonterminals[$id];
	}

	public function addChild( $node ) {
		// Since we do not want a long chain of "exprSomething -> exprWhatever" in the parser tree,
		// we cut it out at the parsing stage
		if( $node instanceof WSParserTreeNode ) {
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

	public function getChildrenCount() {
		return count( $this->mChildren );
	}

	public function hasSingleChild() {
		return count( $this->mChildren ) == 1;
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
			if( $child instanceof WSParserTreeNode ) {
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

/**
 * Generalized script parser.
 */
interface WSParser {
	/**
	 * If this function returns true, code scanner is passed to parse().
	 * Otherwise, code itself is passed.
	 */
	public function needsScanner();

	/**
	 * Parses code (in text or scanner) to parser tree.
	 * @param input WSScanner Input (scanner or string)
	 * @param maxTokens int Maximal amount of tokens
	 * @return WSParserTreeNode
	 */
	public function parse( $input, $module, $maxTokens );

	/**
	 * Returns an array of the syntax errors in the code
	 * @param input WSSCanner Input (scanner or string)
	 * @param maxTokens int Maximal amount of tokens
	 * @return array(string)
	 */
	 public function getSyntaxErrors( $input, $moudle, $maxTokens );
}

class WSException extends MWException {}

// Exceptions that we might conceivably want to report to ordinary users
// (i.e. exceptions that don't represent bugs in the extension itself)
class WSUserVisibleException extends WSException {
	function __construct( $exception_id, $module, $line, $params = array() ) {
		$codelocation = wfMsg( 'wikiscripts-codelocation', $module, $line );
		$msg = wfMsgExt( 'wikiscripts-exception-' . $exception_id, array(), array_merge( array( $codelocation ), $params ) );
		parent::__construct( $msg );

		$this->mExceptionID = $exception_id;
		$this->mLine = $line;
		$this->mModule = $module;
		$this->mParams = $params;
	}

	public function getExceptionID() {
		return $this->mExceptionID;
	}
}

/**
 * Exceptions caused by the error on script transclusion error, i.e. not in script.
 */
class WSTransclusionException extends WSException {
	function __construct( $exception_id, $params = array() ) {
		$msg = wfMsgExt( 'wikiscripts-transerror-' . $exception_id, array(), $params );
		parent::__construct( $msg );

		$this->mExceptionID = $exception_id;
		$this->mParams = $params;
	}
}

/**
 * Exceptions used for control structures that need to break out of deep function
 * nesting level (e.g. break or continue).
 */
class WSControlException extends WSUserVisibleException {}

/**
 * Exception that allows to return from a function.
 */
class WSReturnException extends WSControlException {
	function __construct( $result, $empty ) {
		$this->mResult = $result;
		$this->mEmpty = $empty;
	}
	
	function getResult() {
		return $this->mResult;
	}

	function isEmpty() {
		return $this->mEmpty;
	}
}

/**
 * Code parser output.
 */
class WSParserOutput {
	var $mTree, $mTokensCount, $mVersion;

	public function __construct( $tree, $tokens ) {
		global $wgScriptsParserClass;
		$this->mTree = $tree;
		$this->mTokensCount = $tokens;
		$this->mVersion = $wgScriptsParserClass::getVersion();
	}

	public function getParserTree() {
		return $this->mTree;
	}

	public function getVersion() {
		return $this->mVersion;
	}
}

// Used by WSEvaluationContext::setVar
class WSPlaceholder {}
