<?php
/**
 * Built-in scripting language for MediaWiki.
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
 * An internal class used by WikiScripts. Used to evaluate a parsed code
 * in a sepereate context with its own output, variables and parser frame.
 *
 * Handles evaluation of an individual functions.
 */
class WSEvaluationContext {
	var $mVars, $mArgs, $mFrame, $mName, $mInterpreter, $mModule;

	var $mOutput, $mListOutput;

	/**
	 * Several built-in constructions are impletmented as function.
	 * If you want to add a new function, you will need to create a library
	 * or modify existing one.
	 */
	static $mBuiltInFunctions = array(
		/* Cast functions */
		'string' => 'castString',
		'int' => 'castInt',
		'float' => 'castFloat',
		'bool' => 'castBool',
		'length' => 'getLength',
	);

	public function __construct( $interpreter, $module, $name, $frame ) {
		$this->mVars = array();
		$this->mOut = '';
		$this->mModule = $module;
		$this->mModuleName = $module->getName();
		$this->mName = $name;
		$this->mInterpreter = $interpreter;
		$this->mParser = $interpreter->getParser();
		$this->mFrame = $frame;

		$this->mOutput = new WSData();
		$this->mListOutput = array();
	}

	public function getModule() {
		return $this->mModule;
	}

	public function getFrame() {
		return $this->mFrame;
	}

	public function getOutput() {
		if( $this->mOutput->type != WSData::DNull ) {
			return $this->mOutput;
		} elseif( $this->mListOutput ) {
			return new WSData( WSData::DList, $this->mListOutput );
		} else {
			return new WSData();
		}
	}

	public function setArgument( $name, $value ) {
		$this->mVars[$name] = $value->dup();
	}

	public function setArguments( $args ) {
		$this->mArgs = $args;
	}

	/**
	 * The core interpreter method. Evaluates a single AST node.
	 * The $rec parameter must be increated by 1 each time the function is called
	 * recursively.
	 */
	public function evaluateNode( $node, $rec ) {
		if( !$node instanceof WSParserTreeNode ) {
			throw new WSException( 'evaluateNode() accepts only nonterminals' );
		}

		if( !$this->mInterpreter->checkRecursionLimit( $rec ) ) {
			throw new WSUserVisibleException( 'recoverflow', $this->mModuleName, $this->getLine( $node ) );
		}

		$c = $node->getChildren();
		switch( $node->getType() ) {
			case 'stmts':
				$stmts = array();
				while( isset( $c[1] ) ) {
					array_unshift( $stmts, $c[1] );
					$c = $c[0]->getChildren();
				}
				array_unshift( $stmts, $c[0] );
				foreach( $stmts as $stmt )
					$res = $this->evaluateNode( $stmt, $rec + 1 );
				return $res;
			case 'stmt':
				if( $c[0] instanceof WSToken ) {
					switch( $c[0]->type ) {
						case 'leftcurly':
							return $this->evaluateNode( $c[1], $rec + 1 );
						case 'if':
							$cond = $this->evaluateNode( $c[2], $rec + 1 );
							if( $cond->toBool() ) {
								return $this->evaluateNode( $c[4], $rec + 1 );
							} else {
								if( isset( $c[6] ) ) {
									return $this->evaluateNode( $c[6], $rec + 1 );
								} else {
									return new WSData();
								}
							}
						case 'for':
							$array = $this->evaluateNode( $c[4], $rec + 1 );
							if( !$array->isArray() )
								throw new WSUserVisibleException( 'invalidforeach', $this->mModuleName, $c[0]->line );
							$last = new WSData();
							$lvalues =  $c[2]->getChildren();

							foreach( $array->data as $key => $item ) {
								// <forlvalue> ::= <lvalue> | <lvalue> colon <lvalue>
								if( count( $lvalues ) > 1 ) {
									$this->setVar( $lvalues[0], WSData::newFromPHPVar( $key ), $rec );
									$this->setVar( $lvalues[2], $item, $rec );
								} else {
									$this->setVar( $lvalues[0], $item, $rec );
								}
								try {
									$last = $this->evaluateNode( $c[6], $rec + 1 );
								} catch( WSUserVisibleException $e ) {
									if( $e->getExceptionID() == 'break' )
										break;
									elseif( $e->getExceptionID() == 'continue' )
										continue;
									else
										throw $e;
								}
							}
							return $last;
						case 'try':
							try {
								return $this->evaluateNode( $c[1], $rec + 1 );
							} catch( WSUserVisibleException $e ) {
								if( $e instanceof WSControlException ) {
									throw $e;
								} else {
									$this->setVar( $c[4], new WSData( WSData::DString, $e->getExceptionID() ), $rec );
									return $this->evaluateNode( $c[6], $rec + 1 );
								}
							}
						default:
							throw new WSException( "Unknown keyword: {$c[0]->type}" );
					}
				} else {
					return $this->evaluateNode( $c[0], $rec + 1 );
				}
			case 'exprreturn':
				switch( $c[0]->value ) {
					case 'return':
						if( isset( $c[1] ) ) {
							$retval = $this->evaluateNode( $c[1], $rec + 1 );
							$empty = false;
						} else {
							$retval = new WSData();
							$empty = true;
						}
						throw new WSReturnException( $retval, $empty );
					case 'append':
						if( $this->mListOutput ) {
							throw new WSUserVisibleException( 'appendyield', $this->mModuleName, $c[0]->line );
						}

						$this->mOutput = WSData::sum(
							$this->mOutput,
							$this->evaluateNode( $c[1], $rec + 1 ),
							$this->mModuleName,
							$c[0]->line
						);
						break 2;
					case 'yield':
						if( $this->mOutput->type != WSData::DNull ) {
							throw new WSUserVisibleException( 'appendyield', $this->mModuleName, $c[0]->line );
						}

						$this->mListOutput[] = $this->evaluateNode( $c[1], $rec + 1 );
						break 2;
					default:
						throw new WSException( "Unknown return keyword: {$c[0]->value}" );
				}
			case 'exprset':
				$this->mInterpreter->increaseEvaluationsCount( $this->mModuleName, $c[1]->line );
				if( $c[1]->value == '=' ) {
					$new = $this->evaluateNode( $c[2], $rec + 1 );
					$this->setVar( $c[0], $new, $rec );
					return $new;
				} else {
					$old = $this->getVar( $c[0], $rec, false );
					$new = $this->evaluateNode( $c[2], $rec + 1 );
					$new = $this->getValueForSetting( $old, $new,
						$c[1]->value, $c[1]->line );
					$this->setVar( $c[0], $new, $rec );
					return $new;
				}
			case 'exprtrinary':
				$cond = $this->evaluateNode( $c[0], $rec + 1 );
				if( $cond->toBool() ) {
					return $this->evaluateNode( $c[2], $rec + 1 );
				} else {
					return $this->evaluateNode( $c[4], $rec + 1 );
				}
			case 'exprlogical':
				$this->mInterpreter->increaseEvaluationsCount( $this->mModuleName, $c[1]->line );
				$arg1 = $this->evaluateNode( $c[0], $rec + 1 );
				switch( $c[1]->value ) {
					case '&':
						if( !$arg1->toBool() )
							return new WSData( WSData::DBool, false );
						else
							return $this->evaluateNode( $c[2], $rec + 1 );
					case '|':
						if( $arg1->toBool() )
							return new WSData( WSData::DBool, true );
						else
							return $this->evaluateNode( $c[2], $rec + 1 );
					case '^':
						$arg2 = $this->evaluateNode( $c[2], $rec + 1 );
						return new WSData( WSData::DBool, $arg1->toBool() xor $arg2->toBool() );
					default:
						throw new WSException( "Invalid logical operation: {$c[1]->value}" );
				}
			case 'exprequals':
			case 'exprcompare':
				$this->mInterpreter->increaseEvaluationsCount( $this->mModuleName, $c[1]->line );
				$arg1 = $this->evaluateNode( $c[0], $rec + 1 );
				$arg2 = $this->evaluateNode( $c[2], $rec + 1 );
				return WSData::compareOp( $arg1, $arg2, $c[1]->value );
			case 'exprsum':
				$this->mInterpreter->increaseEvaluationsCount( $this->mModuleName, $c[1]->line );
				$arg1 = $this->evaluateNode( $c[0], $rec + 1 );
				$arg2 = $this->evaluateNode( $c[2], $rec + 1 );
				switch( $c[1]->value ) {
					case '+':
						return WSData::sum( $arg1, $arg2, $this->mModuleName, $c[1]->line );
					case '-':
						return WSData::sub( $arg1, $arg2 );
				}
			case 'exprmul':
				$this->mInterpreter->increaseEvaluationsCount( $this->mModuleName, $c[1]->line );
				$arg1 = $this->evaluateNode( $c[0], $rec + 1 );
				$arg2 = $this->evaluateNode( $c[2], $rec + 1 );
				return WSData::mulRel( $arg1, $arg2, $c[1]->value, $this->mModuleName, $c[1]->line );
			case 'exprpow':
				$this->mInterpreter->increaseEvaluationsCount( $this->mModuleName, $c[1]->line );
				$arg1 = $this->evaluateNode( $c[0], $rec + 1 );
				$arg2 = $this->evaluateNode( $c[2], $rec + 1 );
				return WSData::pow( $arg1, $arg2 );
			case 'exprkeyword':
				$this->mInterpreter->increaseEvaluationsCount( $this->mModuleName, $c[1]->line );
				$arg1 = $this->evaluateNode( $c[0], $rec + 1 );
				$arg2 = $this->evaluateNode( $c[2], $rec + 1 );
				switch( $c[1]->value ) {
					case 'in':
						return WSData::keywordIn( $arg1, $arg2 );
					case 'contains':
						return WSData::keywordIn( $arg2, $arg1 );
					default:
						throw new WSException( "Invalid keyword: {$c[1]->value}" );
				}
			case 'exprinvert':
				$this->mInterpreter->increaseEvaluationsCount( $this->mModuleName, $c[0]->line );
				$arg = $this->evaluateNode( $c[1], $rec + 1 );
				return WSData::boolInvert( $arg );
			case 'exprunary':
				$this->mInterpreter->increaseEvaluationsCount( $this->mModuleName, $c[0]->line );
				$arg = $this->evaluateNode( $c[1], $rec + 1 );
				if( $c[0]->value == '-' )
					return WSData::unaryMinus( $arg );
				else
					return $arg;
			case 'exprfunction':
				// <exprFunction> ::= <funcid> leftbracket <commaListPlain> rightbracket | <funcid> leftbracket rightbracket
				// <exprFunction> ::= <varfunc> leftbracket <lvalue> rightbracket | <exprAtom>
				// <varfunc> ::= isset | delete
				// <funcid> ::= id | <exprAtom> doublecolon id | self doublecolon id

				$this->mInterpreter->increaseEvaluationsCount( $this->mModuleName, $c[1]->line );
				if( $c[0]->getType() == 'funcid' ) {
					if( $c[2] instanceof WSParserTreeNode ) {
						$args = $this->parseArray( $c[2], $rec, $dummy );
					} else {
						$args = array();
					}

					$idch = $c[0]->getChildren();
					if( count( $idch ) == 1 ) {
						$funcname = $idch[0]->value;
						if( isset( self::$mBuiltInFunctions[$funcname] ) )  {
							$func = self::$mBuiltInFunctions[$funcname];
							return $this->$func( $args, $idch[0]->line );
						} else {
							return WSLibrary::callFunction( $funcname, $args, $this, $idch[0]->line );
						}
					} else {
						$funcname = $idch[2]->value;
						if( $idch[0] instanceof WSToken ) {
							// self::function()
							$module = $this->mModule;
						} else {
							// "ModuleName"::function()
							$module = $this->evaluateNode( $idch[0], $rec + 1 )->toString();
						}
						return $this->mInterpreter->invokeUserFunctionFromModule(
							$module, $funcname, $args, $this, $idch[1]->line );
					}
				} else {
					$type = $c[0]->mChildren[0]->value;
					switch( $type ) {
						case 'isset':
							$val = $this->getVar( $c[2], $rec, true );
							return new WSData( WSData::DBool, $val !== null );
						case 'delete':
							$this->deleteVar( $c[2], $rec );
							return new WSData();
						default:
							throw new WSException( "Unknown keyword: {$type}" );
					}
				}
			case 'expratom':
				if( $c[0] instanceof WSParserTreeNode ) {
					if( $c[0]->getType() == 'atom' ) {
						list( $val ) = $c[0]->getChildren();
						switch( $val->type ) {
							case 'string':
								return new WSData( WSData::DString, $val->value );
							case 'int':
								return new WSData( WSData::DInt, $val->value );
							case 'float':
								return new WSData( WSData::DFloat, $val->value );
							case 'true':
								return new WSData( WSData::DBool, true );
							case 'false':
								return new WSData( WSData::DBool, false );
							case 'null':
								return new WSData();
						}
					} else {
						return $this->getVar( $c[0], $rec );
					}
				} else {
					switch( $c[0]->type ) {
						case 'leftbracket':
							return $this->evaluateNode( $c[1], $rec + 1 );
						case 'leftsquare':
						case 'leftcurly':
							$arraytype = null;
							$array = $this->parseArray( $c[1], $rec + 1, $arraytype );
							return new WSData( $arraytype, $array );
						case 'break':
							throw new WSControlException( 'break', $this->mModuleName, $c[0]->line );
						case 'continue':
							throw new WSControlException( 'continue', $this->mModuleName, $c[0]->line );
					}
				}
			default:
				$type = $node->getType();
				throw new WSException( "Invalid node type passed to evaluateNode(): {$type}" );
		}
	}

	/**
	 * Converts commaList* to a PHP array.
	 */
	protected function parseArray( $node, $rec, &$arraytype ) {
		$c = $node->getChildren();
		$type = $node->getType();
		if( $type == 'commalist' ) {
			return $this->parseArray( $c[0], $rec, $arraytype );
		}

		wfProfileIn( __METHOD__ );

		// <commaListWhatever> ::= <commaListWhatever> comma <expr> | <expr>
		$elements = $result = array();
		while( isset( $c[2] ) ) {
			array_unshift( $elements, $c[2] );
			$c = $c[0]->getChildren();
		}
		array_unshift( $elements, $c[0] );

		switch( $type ) {
			case 'commalistplain':
				foreach( $elements as $elem ) {
					$result[] = $this->evaluateNode( $elem, $rec + 1 );
				}

				$arraytype = WSData::DList;
				wfProfileOut( __METHOD__ );
				return $result;

			case 'commalistassoc':
				foreach( $elements as $elem ) {
					//<keyValue> ::= <expr> colon <expr>
					list( $key, $crap, $value ) = $elem->getChildren();
					$key = $this->evaluateNode( $key, $rec + 1 );
					$value = $this->evaluateNode( $value, $rec + 1 );
					$result[ $key->toString() ] = $value;
				}

				$arraytype = WSData::DAssoc;
				wfProfileOut( __METHOD__ );
				return $result;
		}
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Returns a value of the variable in $lval. If $nullIfNotSet is set to true,
	 * returns null if variable does not exist, otherwise throws an exception.
	 */
	protected function getVar( $lval, $rec, $nullIfNotSet = false ) {
		// <lvalue> ::= id | <lvalue> <arrayIdx>
		// <arrayIdx> ::= leftsquare <expr> rightsquare | leftsquare rightsquare

		if( !$this->mInterpreter->checkRecursionLimit( $rec ) ) {
			throw new WSUserVisibleException( 'recoverflow', $this->mModuleName, $this->getLine( $node ) );
		}

		$c = $lval->getChildren();
		if( $c[0] instanceof WSToken ) {
			// Variable ID
			$varname = $c[0]->value;
			if( !isset( $this->mVars[$varname] ) ) {
				if( $nullIfNotSet )
					return null;
				else
					throw new WSUserVisibleException( 'unknownvar', $this->mModuleName, $c[0]->line, array( $varname ) );
			}
			return $this->mVars[$varname];
		} else {
			// Array element
			$idxchildren = $c[1]->getChildren();
			$var = $this->getVar( $c[0], $rec + 1, $nullIfNotSet );
			if( $nullIfNotSet && $var === null )
				return null;

			if( count( $idxchildren ) == 2 ) {
				// x = a[]. a[] is still legitimage in a[] = x
				throw new WSUserVisibleException( 'emptyidx', $this->mModuleName, $idxchildren[0]->line );
			}

			switch( $var->type ) {
				case WSData::DList:
					$idx = $this->evaluateNode( $idxchildren[1], $rec + 1 )->toInt();
					if( $idx >= count( $var->data ) ) {
						if( $nullIfNotSet )
							return null;
						else
							throw new WSUserVisibleException( 'outofbounds', $this->mModuleName, $idxchildren[0]->line );
					}
					return $var->data[$idx];
				case WSData::DAssoc:
					$idx = $this->evaluateNode( $idxchildren[1], $rec + 1 )->toString();
					if( !isset( $var->data[$idx] ) ) {
						if( $nullIfNotSet )
							return null;
						else
							throw new WSUserVisibleException( 'outofbounds', $this->mModuleName, $idxchildren[0]->line );
					}
					return $var->data[$idx];
				default:
					throw new WSUserVisibleException( 'notanarray', $this->mModuleName, $idxchildren[0]->line );
			}
		}
	}

	/**
	 * Gets the line of the first terminal in the node.
	 */
	protected function getLine( $node ) {
		while( $node instanceof WSParserTreeNode ) {
			$children = $node->getChildren();
			$node = $children[0];
		}
		return $node->line;
	}

	/**
	 * Changes the value of variable or array element specified in $lval to $newval.
	 */
	protected function setVar( $lval, $newval, $rec ) {
		$var = &$this->setVarGetRef( $lval, $rec );
		$var = $newval;
		unset( $var );
	}

	/**
	 * Recursive function that return the link to the place
	 * where the new value of the variable must be set.
	 */
	protected function &setVarGetRef( $lval, $rec ) {
		if( !$this->mInterpreter->checkRecursionLimit( $rec ) ) {
			throw new WSUserVisibleException( 'recoverflow', $this->mModuleName, $this->getLine( $node ) );
		}

		$c = $lval->getChildren();
		if( count( $c ) == 1 ) {
			if( !isset( $this->mVars[ $c[0]->value ] ) )
				$this->mVars[ $c[0]->value ] = new WSPlaceholder();
			return $this->mVars[ $c[0]->value ];
		} else {
			$ref = &$this->setVarGetRef( $c[0], $rec + 1 );

			// <arrayIdx> ::= leftsquare <expr> rightsquare | leftsquare rightsquare
			$idxc = $c[1]->getChildren();
			if( $ref instanceof WSPlaceholder ) {
				if( count( $idxc ) > 2 ) {
					$index = $this->evaluateNode( $idxc[1], $rec + 1 );
					$ref = new WSData( WSData::DAssoc, array() );
				} else {
					$ref = new WSData( WSData::DList, array() );
				}
			}

			switch( $ref->type ) {
				case WSData::DList:
					if( count( $idxc ) > 2 ) {
						$index = $this->evaluateNode( $idxc[1], $rec + 1 );
						$key = $index->toInt();

						if( $key < 0 || $key > count( $ref->data ) )
							throw new WSUserVisibleException( 'outofbounds', $this->mModuleName, $idxc[0]->line );
					} else {
						$key = count( $ref->data );
					}

					if( !isset( $ref->data[$key] ) )
						$ref->data[$key] = new WSPlaceholder();

					return $ref->data[$key];
				case WSData::DAssoc:
					if( count( $idxc ) > 2 ) {
						if( !isset( $index ) )
							$index = $this->evaluateNode( $idxc[1], $rec + 1 );
						$key = $index->toString();

						if( !isset( $ref->data[$key] ) )
							$ref->data[$key] = new WSPlaceholder();
						return $ref->data[$key];
					} else {
						throw new WSUserVisibleException( 'notlist', $this->mModuleName, $idxc[0]->line );
					}
					break;
				default:
					throw new WSUserVisibleException( 'notanarray', $this->mModuleName, $idxc[0]->line );
			}
		}
	}

	protected function getValueForSetting( $old, $new, $set, $line ) {
		switch( $set ) {
			case '+=':
				return WSData::sum( $old, $new, $this->mModuleName, $line );
			case '-=':
				return WSData::sub( $old, $new );
			case '*=':
				return WSData::mulRel( $old, $new, '*', $this->mModuleName, $line );
			case '/=':
				return WSData::mulRel( $old, $new, '/', $this->mModuleName, $line );
			default:
				return $new;
		}
	}

	protected function checkParamsCount( $args, $pos, $count ) {
		if( count( $args ) < $count )
			throw new WSUserVisibleException( 'notenoughargs', $this->mModuleName, $pos );
	}

	protected function deleteVar( $lval, $rec ) {
		// First throw an exception if a variable does not exist
		$this->getVar( $lval, $rec + 1 );

		$c = $lval->getChildren();
		if( $c[0] instanceof WSToken ) {
			// Variable
			$varname = $c[0]->value;
			unset( $this->mVars[$varname] );
		} else {
			// Array element
			$ref = $this->setVarGetRef( $c[0], $rec + 1 );
			$idxchildren = $c[1]->getChildren();
			$key = $this->evaluateNode( $idxchildren[1], $rec + 1 );

			if( $ref->type == WSData::DAssoc ) {
				unset( $ref->data[$key->toString()] );
			} else {
				array_splice( $ref->data, $key->toInt(), 1 );
			}
			unset( $ref );
		}
	}

	public function error( $name, $line, $params = array() ) {
		throw new WSUserVisibleException( $name, $this->mModuleName, $line, $params );
	}

	/** Functions */
	protected function getLength( $args, $pos ) {
		$this->checkParamsCount( $args, $pos, 1 );
		$data = $args[0];

		if( $data->isArray() )
			return new WSData( WSData::DInt, count( $data->data ) );
		else
			return new WSData( WSData::DInt, mb_strlen( $data->toString() ) );
	}

	protected function castString( $args, $pos ) {
		$this->checkParamsCount( $args, $pos, 1 );
		return WSData::castTypes( $args[0], WSData::DString );
	}

	protected function castInt( $args, $pos ) {
		$this->checkParamsCount( $args, $pos, 1 );
		return WSData::castTypes( $args[0], WSData::DInt );
	}

	protected function castFloat( $args, $pos ) {
		$this->checkParamsCount( $args, $pos, 1 );
		return WSData::castTypes( $args[0], WSData::DFloat );
	}

	protected function castBool( $args, $pos ) {
		$this->checkParamsCount( $args, $pos, 1 );
		return WSData::castTypes( $args[0], WSData::DBool );
	}
}
