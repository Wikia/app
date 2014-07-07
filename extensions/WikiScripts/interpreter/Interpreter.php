<?php
/**
 * Built-in scripting language for MediaWiki: interpreter.
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

require_once( 'Shared.php' );
require_once( 'Data.php' );
require_once( 'EvaluationContext.php' );
require_once( 'Library.php' );
require_once( 'CallStack.php' );

/**
 * The global interpreter object. Each parser has one.
 */
class WSInterpreter {
	const ParserVersion = 1;
	
	var $mParser, $mUseCache, $mUsedModules, $mCallStack;
	var $mMaxRecursion, $mEvaluations;
	var $mParserCache;	// Unserializing can be expensive as well

	static $mCodeParser;

	public function __construct( $parser ) {
		global $wgScriptsUseCache;

		$this->mParser = $parser;
		$this->mUseCache = $wgScriptsUseCache;

		$this->mCallStack = new WSCallStack( $this );
		$this->mUsedModules = array();
		$this->mMaxRecursion =
		$this->mEvaluations =
			0;
	}

	public static function invokeCodeParser( $code, $module, $method = 'parse' ) {
		global $wgScriptsParserClass, $wgScriptsLimits;

		if( !self::$mCodeParser ) {
			self::$mCodeParser = new $wgScriptsParserClass();
		}

		if( self::$mCodeParser->needsScanner() ) {
			$input = new WSScanner( $module, $code );
		} else {
			$input = $code;
		}

		return self::$mCodeParser->$method( $input, $module, $wgScriptsLimits['tokens'] );
	}

	/**
	 * Invalidate the module by title.
	 */
	public static function invalidateModule( $title ) {
		global $parserMemc;

		$key = WSModule::getCacheKey( $title );
		$parserMemc->delete( $key );
	}

	/**
	 * Checks the syntax of the script and returns an array of syntax errors.
	 */
	 public static function getSyntaxErrors( $module, $text ) {
		 return self::invokeCodeParser( $text, $module, 'getSyntaxErrors' );
	 }

	/**
	 * Disable cache for benchmarking or debugging purposes.
	 */
	public function disableCache() {
		$this->mUseCache = false;
	}

	/**
	 * Get the wikitext parser linked to the interpreter.
	 */
	public function getParser() {
		return $this->mParser;
	}

	/** Limit handling code */

	/**
	 * Check whether the argument is more than recursion limit.
	 * 
	 * @return Boolean
	 */
	public function checkRecursionLimit( $rec ) {
		global $wgScriptsLimits;
		if( $rec > $this->mMaxRecursion )
			$this->mMaxRecursion = $rec;
		return $rec <= $wgScriptsLimits['depth'];
	}

	/**
	 * Increases the number of evaluations.
	 * 
	 * @param $module WSModule Module where the evaluation happens
	 * @param $line int Line number of the evaluation
	 * @return Boolean
	 */
	public function increaseEvaluationsCount( $module, $line ) {
		global $wgScriptsLimits;
		$this->mEvaluations++;
		if( $this->mEvaluations > $wgScriptsLimits['evaluations'] )
			throw new WSUserVisibleException( 'toomanyevals', $module, $line );
	}

	public function getMaxTokensLeft() {
		global $wgScriptsLimits;
		return $wgScriptsLimits['tokens'];
	}

	/**
	 * Adds the title of the module used by the parser for tracking purposes.
	 * 
	 * @param $title Title Title of the module.
	 */
	public function addModuleTitle( $title ) {
		if( !in_array( $title->getText(), $this->mUsedModules ) )
			$this->mUsedModules[] = $title->getDBkey();
	}

	/** Module loading code */

	/**
	 * Loads module from cache or from page and parses it. Cached as much as possible.
	 * 
	 * @param $title Title Title of the module to load.
	 */
	public function getModule( $title ) {
		global $parserMemc;

		wfProfileIn( __METHOD__ );

		// Add nominal title. Real title may differ due to redirects
		$this->addModuleTitle( $title );

		// Try local cache
		$key = WSModule::getCacheKey( $title );
		if( $this->mUseCache && isset( $this->mParserCache[$key] ) ) {
			wfIncrStats( 'script_pcache_hit_local' );
			$module = $this->mParserCache[$key];
			$this->addModuleTitle( $module->getTitle() );
			wfProfileOut( __METHOD__ );
			return $module;
		}

		// Try the object cache
		wfProfileIn( __METHOD__ . '-unserialize' );
		$cached = $parserMemc->get( $key );
		wfProfileOut( __METHOD__ . '-unserialize' );
		if( $this->mUseCache && @$cached instanceof WSModule ) {
			if( !$cached->isOutOfDate() ) {
				wfIncrStats( 'script_pcache_hit_object' );
				$this->mParserCache[$key] = $cached;
				$this->addModuleTitle( $cached->getTitle() );
				wfProfileOut( __METHOD__ );
				return $cached;
			} else {
				wfIncrStats( 'script_pcache_expired' );
			}
		}

		// Load from database
		wfIncrStats( 'script_pcache_missing' );
		$rev = self::getModuleRev( $title );

		if( $rev && $rev->getTitle()->getNamespace() == NS_MODULE ) {
			// Parse
			$moduleName = $rev->getTitle()->getText();
			$out = self::invokeCodeParser( $rev->getText(), $moduleName );
			$module = WSModule::newFromParserOutput( $this, $rev->getTitle(), $rev->getId(), $out );
		} else {
			// Invalid module. Still record that to cache
			$module = false;
		}

		// Save to cache
		$this->mParserCache[$key] = $module;
		$parserMemc->set( $key, $module );
		$this->addModuleTitle( $module->getTitle() );

		wfProfileOut( __METHOD__ );
		return $module;
	}

	/**
	 * Fetches the revision for given module title.
	 */
	private function getModuleRev( $title ) {
		$rev = Revision::newFromTitle( $title );
		if( $rev && $real = Title::newFromRedirect( $rev->getText() ) ) {
			$rev = Revision::newFromTitle( $real );
		}
		return $rev;
	}
	
	/** Function evaluation code */

	/**
	 * Invokes the user function from script code.
	 * 
	 * @param $module WSModule/string Module or its name
	 * @param $name string Name of the function
	 * @param $args array(WSData) Arguments of the function
	 * @param $parentContext WSEvaluationContext The context from which the function was invoked
	 * @param $line The line from which the function was invoked.
	 * @return WSData
	 */
	public function invokeUserFunctionFromModule( $module, $name, $args, $parentContext, $line ) {
		global $wgScriptsAllowRecursion, $wgScriptsMaxCallStackDepth;

		// Load module
		if( $module instanceof WSModule ) {
			$moduleName = $module->getName();
		} else {
			$moduleName = $module;

			$moduleTitle = Title::makeTitleSafe( NS_MODULE, $moduleName );
			if( !$moduleTitle instanceof Title || $moduleTitle->getNamespace() != NS_MODULE ) {
				throw new WSUserVisibleException( 'nonexistent-module', $parentContext->mModuleName, $line, array( $moduleName ) );
			}

			$module = $this->getModule( $moduleTitle );
			if( !$module ) {
				throw new WSUserVisibleException( 'nonexistent-module', $parentContext->mModuleName, $line, array( $moduleName ) );
			}
		}

		// Load the function and handle possible errors
		$function = $module->getFunction( $name );
		if( !$function ) {
			throw new WSUserVisibleException( 'unknownfunction-user', $parentContext->mModuleName, $line, array( $moduleName, $name ) );
		}
		if( count( $args ) < $function->getMinArgCount() ) {
			throw new WSUserVisibleException( 'notenoughargs-user', $parentContext->mModuleName, $line, array( $moduleName, $name ) );
		}
		if( !$wgScriptsAllowRecursion && $this->mCallStack->contains( $moduleName, $name ) ) {
			throw new WSUserVisibleException( 'recursion', $parentContext->mModuleName, $line, array( $moduleName, $name ) );
		}
		if( $this->mCallStack->isFull() ) {
			throw new WSUserVisibleException( 'toodeeprecursion', $parentContext->mModuleName, $line, array( $wgScriptsMaxCallStackDepth ) );
		}

		// Prepare the context and the arguments
		$context = new WSEvaluationContext( $this, $module, $name, $parentContext->getFrame() );
		$context->setArguments( $args );
		foreach( $args as $n => $arg ) {
			if( isset( $function->args[$n] ) ) {
				$argname = $function->args[$n];
				$context->setArgument( $argname, $arg );
			}
		}

		// Push function into call stack
		$this->mCallStack->addFunctionFromModule( $moduleName, $name, $parentContext->mModuleName, $line );

		// Finally execute it!
		$result = $this->doInvokeFunction( $function, $context );

		// Pop out of the call stack and return
		$this->mCallStack->pop();
		return $result;
	}

	/**
	 * Invokes the user function from wikitext.
	 * 
	 * @param $module string The name of the module
	 * @param $name string Name of the function
	 * @param $args array(string) Arguments of the function
	 * @param $frame PPFrame The parser frame from which the function was invoked
	 * @return string
	 */
	public function invokeUserFunctionFromWikitext( $moduleName, $name, $args, $frame ) {
		global $wgScriptsAllowRecursion;

		// Load module
		$moduleTitle = Title::makeTitleSafe( NS_MODULE, $moduleName );
		if( !$moduleTitle instanceof Title || $moduleTitle->getNamespace() != NS_MODULE ) {
			throw new WSTransclusionException( 'nonexistent-module', array( $moduleName ) );
		}

		$module = $this->getModule( $moduleTitle );
		if( !$module ) {
			throw new WSTransclusionException( 'nonexistent-module', array( $moduleName ) );
		}

		// Load the function and handle possible errors
		$function = $module->getFunction( $name );
		if( !$function ) {
			throw new WSTransclusionException( 'unknownfunction-user', array( $moduleName, $name ) );
		}
		if( count( $args ) < $function->getMinArgCount() ) {
			throw new WSTransclusionException( 'notenoughargs-user', array( $moduleName, $name ) );
		}
		if( !$wgScriptsAllowRecursion && $this->mCallStack->contains( $moduleName, $name ) ) {
			throw new WSTransclusionException( 'recursion', array( $moduleName, $name ) );
		}
		if( $this->mCallStack->isFull() ) {
			// Depsite seeming an unlikely place, this may actually happen if the user will try to bypass the
			// stack depth limit by using parse( '{{i:module|func}}' )
			throw new WSTransclusionException( 'toodeeprecursion', array( $wgScriptsMaxCallStackDepth ) );
		}

		// Prepare the context and the arguments
		$context = new WSEvaluationContext( $this, $module, $name, $frame );
		$argsData = array();
		foreach( $args as $n => $arg ) {
			$data = new WSData( WSData::DString, strval( $arg ) );
			$argsData[] = $data;
			if( isset( $function->args[$n] ) ) {
				$argname = $function->args[$n];
				$context->setArgument( $argname, $data );
			}
		}
		$context->setArguments( $argsData );

		// Push function into call stack
		$this->mCallStack->addFunctionFromWikitext( $moduleName, $name );

		// Finally execute it!
		$result = $this->doInvokeFunction( $function, $context );

		// Pop out of the call stack and return
		$this->mCallStack->pop();
		return $result->toString();
	}

	protected function doInvokeFunction( $function, $context ) {
		// Indicates whether the data from append/yield should be used
		$useOutput = true;
		$result = new WSData();

		try {
			$context->evaluateNode( $function->body, 0 );
		} catch( WSException $e ) {
			if( $e instanceof WSReturnException ) {
				$result = $e->getResult();
				$useOutput = $e->isEmpty();
			} else {
				$this->mCallStack->pop();
				throw $e;
			}
		}

		if( $useOutput ) {
			$result = $context->getOutput();
		}

		return $result;
	}
}

/**
 * Represents an individual module.
 */
class WSModule {
	var $mTitle, $mFunctions, $mParserVersion;

	// Revision ID
	// Not used now, will be used if we ever introduce the function output cache
	var $mRevID;
	
	protected function __construct() {}

	/**
	 * Initializes module from the code parser output.
	 */
	public static function newFromParserOutput( $interpreter, $title, $revid, $output ) {
		$m = new WSModule();
		$m->mTitle = $title;
		$m->mRevID = $revid;
		$m->mParserVersion = $output->getVersion();
		$m->mFunctions = array();

		$cur = $output->getParserTree();
		for( ; ; ) {
			$curch = $cur->getChildren();
			$funcnode = $curch[0];

			// <function> ::= function id leftbracket <arglist> rightbracket leftcurly <stmts> rightcurly (total 8)
			// <function> ::= function id leftbracket rightbracket leftcurly <stmts> rightcurly (total 7)
			$c = $funcnode->getChildren();
			$func = new WSFunction();
			$func->name = $c[1]->value;

			if( $funcnode->getChildrenCount() == 8 ) {
				$func->body = $c[6];
				$func->args = self::parseArgs( $c[3] );
			} else {
				$func->body = $c[5];
				$func->args = array();
			}
			$m->mFunctions[$func->name] = $func;

			if( $cur->hasSingleChild() )
				break;
			else
				$cur = $curch[1];
		}
		
		return $m;
	}

	/**
	 * Converts the argument list node into an array.
	 */
	private static function parseArgs( $argsnode ) {
		$args = array();
		$cur = $argsnode;
		for( ; ; ) {
			$c = $cur->getChildren();
			$args[] = $c[0]->value;
			
			if( $cur->hasSingleChild() )
				break;
			else
				$cur = $c[2];
		}
		return $args;
	}

	/**
	 * Gets the cache key for a module.
	 */
	public static function getCacheKey( $title ) {
		return 'scripts:module:' . sha1( $title->getText() );
	}

	/**
	 * Returns the name of a module.
	 */
	public function getName() {
		return $this->mTitle->getText();
	}

	/**
	 * Returns the title of a module.
	 */
	public function getTitle() {
		return $this->mTitle;
	}

	/**
	 * Returns a specific function or null if it does not exist.
	 */
	public function getFunction( $name ) {
		if( isset( $this->mFunctions[$name] ) )
			return $this->mFunctions[$name];
		else
			return null;
	}

	/**
	 * Returns whether the module should be reparsed or not.
	 */
	public function isOutOfDate() {
		global $wgScriptsParserClass;
		return $wgScriptsParserClass::getVersion() != $this->mParserVersion;
	}
}

/**
 * Represents a function.
 */
class WSFunction {
	public $name;
	public $args;
	public $body;
	
	public function getMinArgCount() {
		return count( $this->args );
	}
}
