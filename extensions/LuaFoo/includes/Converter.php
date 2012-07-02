<?php
/**
 * * Expression: a language-independent tree representation of an expression.
 *
 * * Block: A formatted language-dependent list of statements, and an 
 *   expression which can be evaluated after the statements to produce the 
 *   desired result of the expression.
 *
 * * Frame: A list of assigned local variable names, which doubles as a 
 *   makeshift subexpression cache.
 *
 * To do:
 *   * Optional line break tag for concatenation
 *   * Vertical white space
 */

class LuaFoo_Converter {
	var $parser, $preprocessor;
	var $doneFunctions = array();
	var $tab = '    ';
	var $out, $nodeDeps;

	var $inlineFunctions = array(
		'pfunc_if' => 'pfunc_if'
	);

	static function convert( $title, $language ) {
		$converter = new self( $language );
		$code = $converter->convertTemplate( $title );
		return $code->toString();
	}

	protected function __construct( $language ) {
		$this->parser = new Parser;
		$this->preprocessor = new Preprocessor_Hash( $this->parser );
		switch ( $language ) {
			case 'lua':
				$this->language = new LuaFoo_Converter_Lua( $this );
				break;
			default:
				throw new MWException( __METHOD__.": invalid language \"$language\"" );
		}
	}

	function convertTemplate( $title ) {
		$funcName = $this->titleToIdentifier( $title );
		$deps = $this->newDeps();
		$expression = $this->getTemplateExpression( $title, $deps );
		$block = $this->language->makeFunction( $funcName, array( 'args' ), $expression );

		foreach ( $deps->getTemplates() as $depTitleText ) {
			if ( !isset( $this->doneFunctions[$depTitleText] ) ) {
				$depTitle = Title::newFromText( $depTitleText );
				$this->doneFunctions[$depTitleText] = true;
				$block->addBlock( $this->convertTemplate( $depTitle ) );
			}
		}

		foreach ( $deps->getFunctions() as $func ) {
			$block->addBlock( $this->language->getRuntimeBlock( $func ) );
		}

		return $block;
	}

	function newDeps() {
		return new LuaFoo_Converter_Deps;
	}

	function newLiteral( $value ) {
		if ( !is_string( $value ) && !is_numeric( $value ) && !is_array( $value ) ) {
			throw new MWException( __METHOD__.': invalid literal type' );
		}
		return new LuaFoo_Converter_Expression( 'literal', array( $value ) );
	}

	function newHash( $hash ) {
		return new LuaFoo_Converter_Expression( 'hash', array_merge(
			array_map( array( $this, 'newLiteral' ), array_keys( $hash ) ),
			array_values( $hash ) ) );
	}

	function newConcat( $items ) {
		$filteredItems = array();
		foreach ( $items as $item ) {
			if ( $item->op === 'void' ) {
				continue;
			}
			if ( $item->op === 'literal' && $item->args[0] === '' ) {
				continue;
			}
			if ( $item->op === 'literal'
				&& count( $filteredItems )
				&& $filteredItems[ count( $filteredItems ) - 1 ]->op === 'literal' )
			{
				$filteredItems[ count( $filteredItems ) - 1 ]->args[0] .= $item->args[0];
				continue;
			}
			if ( $item->op === 'concat' ) {
				foreach ( $item->args as $subConcatArg ) {
					$filteredItems[] = $subConcatArg;
				}
				continue;
			}

			$filteredItems[] = $item;
		}
		if ( count( $filteredItems ) == 0 ) {
			return $this->newLiteral( '' );
		} elseif ( count( $filteredItems ) == 1 ) {
			return reset( $filteredItems );
		} else {
			return $this->newExpression( 'concat', $filteredItems );
		}
	}

	protected function trimConcat( $expr, $direction ) {
		while ( count( $expr->args ) ) {
			if ( $direction == 'left' ) {
				$i = 0;
			} else {
				$i = count( $expr->args ) - 1;
			}
			if ( $expr->args[$i]->op !== 'literal' ) {
				break;
			}
			$oldPart = $expr->args[$i]->args[0];
			if ( $direction == 'left' ) {
				$newPart = ltrim( $oldPart );
			} else {
				$newPart = rtrim( $oldPart );
			}
			if ( $oldPart === $newPart ) {
				break;
			}
			if ( $newPart === '' ) {
				unset( $expr->args[$i] );
				$expr->args = array_values( $expr->args );
			} else {
				$expr->args[$i] = $this->newLiteral( $newPart );
			}
		}
	}

	function newTrim( $expr, $deps ) {
		if ( $expr->op === 'literal' ) {
			// Trim a literal
			return $this->newLiteral( trim( $expr->args[0] ) );
		} elseif ( $expr->op === 'concat' ) {
			// Trim a concatenation operation
			$trimExpr = clone $expr;
			$this->trimConcat( $trimExpr, 'left' );
			$this->trimConcat( $trimExpr, 'right' );
			if ( count( $trimExpr->args ) == 0 ) {
				return $this->newLiteral( '' );
			} elseif ( count( $trimExpr->args ) == 1 ) {
				return $trimExpr->args[0];
			} else {
				return $trimExpr;
			}
		} else {
			// Trim a generic expression
			$deps->addFunction( 'mw_trim' );
			return $this->newExpression( 'call', array( 
				$this->newLiteral( 'mw_trim' ), $expr ) );
		}
	}

	function newParserFunctionCall( $name, $args, $deps ) {
		if ( isset( $this->inlineFunctions[$name] ) ) {
			$inlineFunc = $this->inlineFunctions[$name];
			return $this->$inlineFunc( $args, $deps );
		}

		array_unshift( $args, $this->newLiteral( $name ) );
		$deps->addFunction( $name );
		return $this->newExpression( 'call', $args );
	}

	function newExpression( $op, $args ) {
		return new LuaFoo_Converter_Expression( $op, $args );
	}

	function titleToIdentifier( $title ) {
		$id = '';
		if ( $title->getNamespace() == NS_TEMPLATE ) {
			$id = 'tpl_';
		} elseif ( $title->getNamespace() == NS_MAIN ) {
			$id = 'article_';
		} else {
			$id = $title->getNsText() . '_';
		}
		$id .= $title->getDBkey();
		$id = preg_replace( '/[^\w\177-\377]/', '_', $id );
		return $id;
	}

	function parserFunctionToIdentifier( $name ) {
		$name = preg_replace( '/[^\w\177-\377]/', '_', $name );
		return "pfunc_$name";
	}

	function getTemplateExpression( $title, $deps ) {
		$rev = Revision::newFromTitle( $title );
		if ( !$rev ) {
			return $this->newLiteral( '[No such page]' );
		}
		$text = $rev->getText();
		if ( $text === false ) {
			return $this->newLiteral( '[Unable to load text for this page]' );
		}

		$this->parser->startExternalParse( $title, new ParserOptions, Parser::OT_WIKI );
		$tree = $this->preprocessor->preprocessToObj( $text, Parser::PTD_FOR_INCLUSION );

		$expression = $this->expand( $tree, $deps );
		return $expression;
	}

	function expand( $contextNode, $deps ) {
		if ( is_string( $contextNode ) ) {
			return $this->newLiteral( $contextNode );
		} elseif ( $contextNode instanceof PPNode_Hash_Array ) {
			$items = array();
			for ( $i = 0; $i < $contextNode->getLength(); $i++ ) {
				$items[] = $this->expand( $contextNode->item( $i ), $deps );
			}
			return $this->newConcat( $items );
		} elseif ( $contextNode instanceof PPNode_Hash_Attr ) {
			// No output
			return $this->newLiteral( '' );
		} elseif ( $contextNode instanceof PPNode_Hash_Text ) {
			// String literal
			return $this->newLiteral( $contextNode->value );
		} elseif ( $contextNode instanceof PPNode_Hash_Tree ) {
			if ( $contextNode->name == 'template' ) {
				// Convert template to function call
				$bits = $contextNode->splitTemplate();
				return $this->expandTemplate( $bits, $deps );
			} elseif ( $contextNode->name == 'tplarg' ) {
				$bits = $contextNode->splitTemplate();
				return $this->expandTemplateArg( $bits, $deps );
			} elseif ( $contextNode->name == 'comment' ) {
				return $this->newLiteral( '' );
			} elseif ( $contextNode->name == 'ignore' ) {
				return $this->newLiteral( '' );
			} else {
				$items = array();
				for ( $node = $contextNode->firstChild; $node; $node = $node->nextSibling ) {
					$items[] = $this->expand( $node, $deps );
				}
				return $this->newConcat( $items );
			}
		} else {
			throw new MWException( __METHOD__.': invalid node type' );
		}
	}

	function expandTemplate( $bits, $deps ) {
		global $wgContLang;

		$args = $bits['parts'];
		$part1Expr = $this->expand( $bits['title'], $deps );
		$functionName = false;
		$part1Literal = false;
		$invalidTitle = false;

		if ( $part1Expr->op === 'concat' && $part1Expr->args[0]->op === 'literal' ) {
			$part1LeadString = $part1Expr->args[0]->args[0];
			$colonPos = strpos( $part1LeadString, ':' );
			if ( $colonPos !== false ) {
				$functionName = ltrim( substr( $part1LeadString, 0, $colonPos ) );
				$arg1Expr = clone $part1Expr;
				if ( $colonPos == strlen( $part1LeadString ) - 1 ) {
					array_shift( $arg1Expr->args );
				} else {
					$arg1Expr->args[0] = $this->newLiteral(
						substr( $part1LeadString, $colonPos + 1 ) );
				}
			}
			if ( preg_match( Title::getTitleInvalidRegex(), ltrim( $part1LeadString ) ) ) {
				$invalidTitle = true;
			}
		} elseif ( $part1Expr->op === 'literal' ) {
			$part1Literal = $part1Expr->args[0];
			$colonPos = strpos( $part1Literal, ':' );
			if ( $colonPos !== false ) {
				$functionName = substr( $part1Literal, 0, $colonPos );
				$arg1Expr = $this->newLiteral( substr( $part1Literal, $colonPos + 1 ) );
			}
		}

		if ( $functionName !== false ) {
			if ( isset( $this->parser->mFunctionSynonyms[1][$functionName] ) ) {
				$funcWordId = $this->parser->mFunctionSynonyms[1][$functionName];
			} else {
				$functionName = $wgContLang->lc( $functionName );
				if ( isset( $this->parser->mFunctionSynonyms[0][$functionName] ) ) {
					$funcWordId = $this->parser->mFunctionSynonyms[0][$functionName];
				} else {
					$funcWordId = false;
				}
			}
			if ( $funcWordId !== false ) {
				$funcLuaId = $this->parserFunctionToIdentifier( $funcWordId );
				$funcArgs = array( $arg1Expr );
				for ( $i = 0; $i < $args->getLength(); $i++ ) {
					$funcArgs[] = $this->expand( $args->item( $i ), $deps );
				}
				return $this->newParserFunctionCall( $funcLuaId, $funcArgs, $deps );
			}
		}

		if ( $part1Literal !== false ) {
			$title = Title::newFromText( $part1Literal, NS_TEMPLATE );
			if ( $title ) {
				// Register the template in $deps for later expansion
				$deps->addTemplate( $title->getPrefixedDBkey() );
				$fname = $this->titleToIdentifier( $title );
			}
		} elseif ( $invalidTitle ) {
			$title = false;
		} else {
			$title = Title::newFromText( 'dynamic' );
		}

		if ( !$title ) {
			// Invalid title
			$tplFrame = $this->preprocessor->newFrame();
			$origNode = $tplFrame->virtualBracketedImplode( 
				'{{', '|', '}}', $bits['title'], $args );
			return $this->expand( $origNode, $deps );
		}

		// Create a call to the template function
		$parentTplFrame = $this->preprocessor->newFrame();
		$tplFrame = $parentTplFrame->newChild( $args, $title );

		$templateArgs = array();
		foreach ( $tplFrame->numberedArgs as $i => $arg ) {
			$expr = $this->newTrim( $this->expand( $arg, $deps ), $deps );
			$templateArgs[$i] = $expr;
		}
		foreach ( $tplFrame->namedArgs as $name => $arg ) {
			$expr = $this->expand( $arg, $deps );
			$templateArgs[$name] = $expr;
		}

		if ( $part1Literal === false ) {
			// Do a dynamic call
			$funcArgs = array(
				$this->newLiteral( 'mw_dynamic_template' ),
				$this->newTrim( $part1Expr, $deps ),
				$this->newHash( $templateArgs ),
			);
			return $this->newExpression( 'call', $funcArgs );
		} else {
			// Do a regular call
			$funcArgs = array(
				$this->newLiteral( $fname ),
				$this->newHash( $templateArgs ),
			);

			return $this->newExpression( 'call', $funcArgs );
		}
	}

	function expandTemplateArg( $piece, $deps ) {
		$parts = $piece['parts'];
		$nameExpr = $this->newTrim( $this->expand( $piece['title'], $deps ), $deps );

		// Use numeric index if possible
		if ( $nameExpr->op == 'literal' 
			&& preg_match( '/^[0-9]$/', $nameExpr->args[0] ) )
		{
			$nameExpr = $this->newLiteral( intval( $nameExpr->args[0] ) );
		}

		if ( $parts->getLength() > 0 ) {
			$defaultExpr = $this->expand( $parts->item( 0 )->getChildren(), $deps );
		} else {
			$tplFrame = $this->preprocessor->newFrame();
			$defaultNode = $tplFrame->virtualBracketedImplode( '{{{', '|', '}}}', $piece['title'], $parts );
			$defaultExpr = $this->expand( $defaultNode, $deps );
		}

		$argsExpr = $this->newExpression( 'args', array() );
		$argExpr = $this->newExpression( 'get_element', array( $argsExpr, $nameExpr ) );
		$existsExpr = $this->newExpression( 'key_exists', array( $argsExpr, $nameExpr ) );
		return $this->newExpression( 'if', array(
			$existsExpr,
			$argExpr,
			$defaultExpr
		) );
	}

	function pfunc_if( $args, $deps ) {
		if ( isset( $args[0] ) ) {
			$condition = $this->newExpression( 'equals', array(
				$this->newTrim( $args[0], $deps ),
				$this->newLiteral( '' ) ) );
		} else {
			$condition = $this->newLiteral( false );
		}
		if ( isset( $args[1] ) ) {
			$trueResult = $this->newTrim( $args[1], $deps );
		} else {
			$trueResult = $this->newLiteral( '' );
		}
		if ( isset( $args[2] ) ) {
			$falseResult = $this->newTrim( $args[2], $deps );
		} else {
			$falseResult = $this->newLiteral( '' );
		}
		return $this->newExpression( 'if', array(
			$condition,
			$trueResult,
			$falseResult
		) );
	}
}

abstract class LuaFoo_Converter_Language {
	var $converter;
	var $runtimeBlocks;

	function __construct( $converter ) {
		$this->converter = $converter;
	}

	function newBlock() {
		return new LuaFoo_Converter_Block( $this );
	}

	function newFrame( $seed ) {
		return new LuaFoo_Converter_Frame( $this, $seed );
	}

	function getRuntimeBlock( $name ) {
		if ( $this->runtimeBlocks === null ) {
			$this->setupRuntime();
		}
		if ( isset( $this->runtimeBlocks[$name] ) ) {
			return $this->runtimeBlocks[$name];
		} else {
			return $this->getRuntimeUnimplementedBlock( $name );
		}
	}

	abstract public function makeFunction( $name, $argNames, $expression );
	abstract public function getKeywords();
	abstract protected function expressionToBlock( $expression, $frame );
	abstract protected function setupRuntime();
	abstract protected function getRuntimeUnimplementedBlock( $name );
}

class LuaFoo_Converter_Lua extends LuaFoo_Converter_Language {
	var $binaryPrecedence = array(
		'key_exists' => 10, // produces ~=
		'equals' => 10,
		'concat' => 20,
	);

	var $keywords = array(
		'and',
		'break',
		'do',
		'else',
		'elseif',
		'end',
		'false',
		'for',
		'function',
		'if',
		'in',
		'local',
		'nil',
		'not',
		'or',
		'repeat',
		'return',
		'then',
		'true',
		'until',
		'while'
	);

	public function makeFunction( $name, $argNames, $expression ) {
		$frame = $this->newFrame( $name );
		$block = $this->expressionToBlock( $expression, $frame );
		$this->addLocalDeclarations( $block, $frame );
		$argsString = implode( ', ', $argNames );
		$func = $this->newBlock();
		$func->addItems( array( 
			"function $name($argsString)", 
			$block->indent() 
		) );
		$func->addBlock( $block );
		$func->addItems( array( 
			"return {$block->exprString}", 
			$block->unindent(),
			"end"
		) );
		return $func;
	}

	public function getKeywords() {
		return $this->keywords;
	}

	protected function expressionToBlock( $expression, $frame ) {
		if ( !($expression instanceof LuaFoo_Converter_Expression ) ) {
			throw new MWException( 'Non-expression passed to ' . __METHOD__ );
		}
		$block = $this->newBlock();

		if ( $expression->op == 'literal' ) {
			$block->setExpressionString( $this->encodeLiteral( $expression->args[0] ) );
			return $block;
		}

		$var = $frame->getVariable( $expression );
		if ( $var !== false ) {
			$block->setExpressionString( $var );
			return $block;
		}

		$args = array();
		foreach ( $expression->args as $i => $arg ) {
			$argBlock = $this->expressionToBlock( $arg, $frame );
			$block->addBlock( $argBlock );
			$s = $argBlock->exprString;
			if ( $this->needsBrackets( $expression, $arg ) ) {
				$s = "($s)";
			}
			$args[$i] = $s;
		}

		switch( $expression->op ) {
			case 'concat':
				$block->setExpressionString( implode( ' .. ', $args ) );
				break;
			case 'equals':
				$block->setExpressionString( "{$args[0]} == {$args[1]}" );
				break;
			case 'if':
				$resultVar = $frame->newVariable();
				$frame->setVariableHash( $resultVar, $expression );
				$block->setExpressionString( $resultVar );
				$block->addItems( array(
					"if {$args[0]} then",
					$block->indent(),
					"$resultVar = {$args[1]}",
					$block->unindent(),
					"else",
					$block->indent(),
					"$resultVar = {$args[2]}",
					$block->unindent(),
					"end" ) );
				break;
			case 'call':
				$name = "_G[{$args[0]}]";
				if ( $expression->args[0]->op === 'literal' ) {
					$literalValue = $expression->args[0]->args[0];
					if ( preg_match( '/^[\w\177-\377]*$/', $literalValue ) ) {
						$name = $literalValue;
					}
				}
				if ( count( $args ) === 2 && $expression->args[1]->op === 'hash' ) {
					// This is a nice little lua feature, a short syntax for 
					// calling a function with a single table as a parameter
					$block->setExpressionString( "$name{$args[1]}" );
				} else {
					unset( $args[0] );
					$funcArgs = implode( ', ', $args );
					$block->setExpressionString( "$name($funcArgs)" );
				}
				break;
			case 'key_exists':
				$array = $args[0];
				$key = $args[1];
				$block->setExpressionString( "{$array}[{$key}] ~= nil" );
				break;
			case 'get_element':
				$array = $args[0];
				$key = $args[1];
				$block->setExpressionString( "{$array}[{$key}]" );
				break;
			case 'args':
				$block->setExpressionString( 'args' );
				break;
			case 'void':
				$block->setExpressionString( '' );
				break;
			case 'hash':
				$n = count( $args ) / 2;
				$s = '{';
				for ( $i = 0; $i < $n; $i++ ) {
					if ( $expression->args[$i]->op === 'literal'
						&& $this->isName( $expression->args[$i]->args[0] ) )
					{
						$encKey = $expression->args[$i]->args[0];
					} else {
						$encKey = '[' . $args[$i] . ']';
					}
					$value = $args[$i + $n];
					if ( $s !== '{' ) {
						$s .= ', ';
					}
					$s .= "$encKey = $value";
				}
				$s .= '}';
				$block->setExpressionString( $s );
				break;
		}
		return $block;
	}

	public function isName( $name ) {
		return !in_array( $name, $this->keywords )
			&& preg_match( '/^[a-zA-Z_][a-zA-Z0-9_]*$/', $name );
	}

	protected function encodeLiteral( $input ) {
		if ( is_string( $input ) ) {
			$result = strtr( $input, array(
				"\\" => "\\\\",
				"\n" => '\n',
				"\0" => '\0',
				"'" => "\\'"
			) );
			return "'$result'";
		} elseif ( is_bool( $input ) ) {
			return $input ? 'true' : 'false';
		} elseif ( is_numeric( $input ) ) {
			return floatval( $input );
		} elseif ( is_array( $input ) ) {
			$result = '';
			foreach ( $input as $key => $value ) {
				if ( is_string( $key ) && $this->isName( $key ) ) {
					$encKey = $key;
				} else {
					$encKey = '[' . $this->encodeLiteral( $key ) . ']';
				}
				$encValue = $this->encodeLiteral( $value );
				if ( $result !== '' ) {
					$result .= ', ';
				}
				$result .= "$encKey = $encValue";
			}
			return "\{$result\}";
		} else {
			throw new MWException( __METHOD__.': invalid type' );
		}
	}

	protected function needsBrackets( $context, $arg ) {
		if ( isset( $this->binaryPrecedence[ $context->op ] )
			&& isset( $this->binaryPrecedence[ $arg->op ] ) )
		{
			$contextLevel = $this->binaryPrecedence[ $context->op ];
			$argLevel = $this->binaryPrecedence[ $arg->op ];
			if ( $contextLevel == $argLevel ) {
				if ( $context->op === 'concat' ) {
					// Right associative
					return false;
				} else {
					// Left associative
					return true;
				}
			} else {
				return $contextLevel > $argLevel;
			}
		}
		return false;
	}

	protected function setupRuntime() {
		$file = fopen( dirname( __FILE__ ) . '/ConverterRuntime.lua', 'r' );
		$currentFunction = false;
		$currentBlock = $this->newBlock();
		$currentIndent = 0;
		while ( true ) {
			$line = fgets( $file );
			$newFunction = false;
			if ( $line !== false ) {
				$line = rtrim( $line, "\r\n" );
				$indent = strspn( $line, "\t" );
				if ( $indent > $currentIndent ) {
					$currentBlock->addItem( $currentBlock->indent() );
				} elseif ( $indent < $currentIndent ) {
					$currentBlock->addItem( $currentBlock->unindent() );
				}
				$currentIndent = $indent;
				if ( $indent ) {
					$line = substr( $line, $indent );
				}

				if ( preg_match( '/^function (\w+)/', $line, $m ) ) {
					$newFunction = $m[1];
				}
			}

			if ( $line === false || $newFunction !== false ) {
				// Store the old function
				if ( $currentFunction !== false ) {
					$this->runtimeBlocks[$currentFunction] = $currentBlock;
				}

				// Start the new function
				$currentFunction = $newFunction;
				$currentBlock = $this->newBlock();
			}

			if ( $line === false ) {
				break;
			}

			$currentBlock->addItem( $line );
		}	
	}

	protected function getRuntimeUnimplementedBlock( $name ) {
		$block = $this->newBlock();
		$block->addItems( array(
			"function $name()",
			$block->indent(),
			"error(\"This function is not implemented\")",
			$block->unindent(),
			"end"
		) );
		return $block;
	}

	protected function addLocalDeclarations( $block, $frame ) {
		foreach ( $frame->variables as $var => $dummy ) {
			$block->prependItem( "local $var" );
		}
	}
}

class LuaFoo_Converter_Block {
	var $items = array(), $exprString = '', $language;

	function __construct( $language ) {
		$this->language = $language;
	}

	function addItems() {
		$args = func_get_args();
		foreach ( $args as $items ) {
			$this->items = array_merge( $this->items, $items );
		}
	}

	function prependItem( $item ) {
		array_unshift( $this->items, $item );
	}

	function addItem( $item ) {
		$this->items[] = $item;
	}

	function addBlock( $block ) {
		$this->addItems( $block->items );
	}

	function setExpressionString( $expr ) {
		$this->exprString = $expr;
	}

	function toString() {
		$out = '';
		$indentLevel = 0;
		foreach ( $this->items as $item ) {
			if ( $item instanceof LuaFoo_Converter_Indent ) {
				$indentLevel++;
			} elseif ( $item instanceof LuaFoo_Converter_Unindent ) {
				$indentLevel--;
			} else {
				$out .= str_repeat( $this->language->converter->tab, $indentLevel ) . $item . "\n";
			}
		}
		return $out;
	}

	function indent() {
		return new LuaFoo_Converter_Indent;
	}

	function unindent() {
		return new LuaFoo_Converter_Unindent;
	}
}

class LuaFoo_Converter_Indent {}

class LuaFoo_Converter_Unindent {}

class LuaFoo_Converter_Expression {
	var $op, $args, $hash;

	function __construct( $op, $args ) {
		$this->op = $op;
		$this->args = $args;
	}

	function getHash() {
		if ( $this->hash === null ) {
			$s = $this->op;
			foreach ( $this->args as $arg ) {
				if ( $arg instanceof LuaFoo_Converter_Expression ) {
					$s .= ':' . $arg->getHash();
				} else {
					$s .= ':' . sha1( serialize( $arg ) );
				}
			}
			$this->hash = sha1( $s );
		}
		return $this->hash;
	}
}

class LuaFoo_Converter_Frame {
	static $consonants = 'bdfghjklmnprstvwz';
	static $vowels = 'aeiou';

	var $variables = array();
	var $language;
	var $variablesByHash = array();

	function __construct( $language, $seed ) {
		$this->language = $language;
		srand( crc32( $seed ) );
	}

	public function newVariable() {
		do {
			$length = rand( 5, 8 );
			$s = '';
			for ( $i = 0; $i < $length; $i++ ) {
				if ( $i % 2 ) {
					$s .= $this->getRandomVowel();
				} else {
					$s .= $this->getRandomConsonant();
				}
			}
		} while ( isset( $this->variables[$s] ) );

		$this->variables[$s] = true;

		return $s;
	}

	public function getVariable( $expr ) {
		$hash = $expr->getHash();
		if ( isset( $this->variablesByHash[$hash] ) ) {
			return $this->variablesByHash[$hash];
		} else {
			return false;
		}
	}

	public function setVariableHash( $var, $expr ) {
		$hash = $expr->getHash();
		$this->variablesByHash[$hash] = $var;
	}

	protected function getRandomVowel() {
		return self::$vowels[ rand( 0, strlen( self::$vowels ) - 1 ) ];
	}

	protected function getRandomConsonant() {
		return self::$consonants[ rand( 0, strlen( self::$consonants ) - 1 ) ];
	}
}

class LuaFoo_Converter_Deps {
	var $titleTexts = array();
	var $functions = array();

	function addTemplate( $t ) {
		$this->titleTexts[$t] = true;
	}

	function addFunction( $name ) {
		$this->functions[$name] = true;
	}

	function getTemplates() {
		return array_keys( $this->titleTexts );
	}

	function getFunctions() {
		return array_keys( $this->functions );
	}
}
