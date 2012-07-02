<?php

interface WSLibraryModule {
	/**
	 * Returns the list of functions within the library module.
	 */
	public function getFunctionList();

	/**
	 * Calls the function and returns the return value of it.
	 * 
	 * @param $name string Name of the function without prefix
	 * @param $args array(WSData) Arguments of the function
	 * @param $context WSEvaluationContext Evaluation context of the function
	 * @param $errorCallback The function to be called in case of error
	 */
	public function callFunction( $name, $args, $context, $line );
}

class WSLibrary { 
	private static $mModules = array();
	
	private function __construct() {}

	private static function getModule( $prefix ) {
		global $wgScriptsLibraryClasses;
		if( !isset( self::$mModules[$prefix] ) ) {
			if( isset( $wgScriptsLibraryClasses[$prefix] ) ) {
				self::$mModules[$prefix] = new $wgScriptsLibraryClasses[$prefix]();
			} else {
				return null;
			}
		}

		return self::$mModules[$prefix];
	}

	public static function callFunction( $name, $args, $context, $line ) {
		if( !in_string( '_', $name ) ) {
			$context->error( 'unknownfunction', $line, array( $name ) );
		}

		list( $prefix, $realName ) = explode( '_', $name, 2 );
		$module = self::getModule( $prefix );
		if( !$module || !in_array( $realName, $module->getFunctionList() ) ) {
			$context->error( 'unknownfunction', $line, array( $name ) );
		}

		return $module->callFunction( $realName, $args, $context, $line );
	}
}

abstract class WSLibraryModuleBase implements WSLibraryModule {
	/**
	 * Must return the list of functions in the following format:
	 *   'function_name' => array( 'classMethodName', minimal amount of arguments ),
	 */
	abstract protected function getFunctions();
	
	public function getFunctionList() {
		return array_keys( $this->getFunctions() );
	}

	public function callFunction( $name, $args, $context, $line ) {
		$funcs = $this->getFunctions();
		list( $method, $minArgs ) = $funcs[ $name ];
		$fullname = __CLASS__ . "::{$method}";

		$argsNumber = count( $args );
		if( $argsNumber < $minArgs ) {
			$context->error( 'notenoughargs', $line, array( $name, $minArgs, $argsNumber ) );
		}

		wfProfileIn( $fullname );
		try {
			$result = $this->$method( $args, $context, $line );
			wfProfileOut( $fullname );
			return $result;
		} catch( WSException $e ) {
			wfProfileOut( $fullname );
			throw $e;
		}
	}
}
