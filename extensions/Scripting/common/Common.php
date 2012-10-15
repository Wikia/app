<?php

/**
 * Generic scripting functions.
 */
class Scripting {
	const Local = 'local';

	protected static function getEngineClass() {
		global $wgScriptingEngine, $wgScriptingEngines;

		if( !$wgScriptingEngine ) {
			throw new MWException( 'Scripting extension is enabled but $wgScriptingEngine is not set' );
		}

		if( !isset( $wgScriptingEngines[$wgScriptingEngine] ) ) {
			throw new MWException( 'Invalid scripting engine is specified in $wgScriptingEngine' );
		}

		return $wgScriptingEngines[$wgScriptingEngine];
	}

	public static function getEngine( $parser ) {
		global $wgScriptingEngineConf;

		if( !isset( $parser->scripting_engine ) || !$parser->scripting_engine ) {
			$class = self::getEngineClass();
			$parser->scripting_engine = new $class( $parser );
			$parser->scripting_engine->setOptions( $wgScriptingEngineConf );
		}
		return $parser->scripting_engine;
	}

	public static function resetEngine( $parser ) {
		$parser->scripting_engine = null;
	}
}

/**
 * Exceptions which represents user-originating error in the script.
 * Please do not use it for internal errors like "oh god, this should have never happened".
 * Use casual MWException for that.
 */
class ScriptingException extends MWException {
	function __construct( $exceptionID, $engine, $module = null, $line = null, $params = array() ) {
		if( $module ) {
			$codelocation = wfMsg( 'scripting-codelocation', $module, $line );
			$msg = wfMsgExt( "scripting-exception-{$engine}-{$exceptionID}", array(), array_merge( array( $codelocation ), $params ) );
		} else {
			$msg = wfMsgExt( "scripting-exception-{$engine}-{$exceptionID}", array(), $params );
		}
		parent::__construct( $msg );

		$this->mExceptionID = $exceptionID;
		$this->mLine = $line;
		$this->mModule = $module;
		$this->mParams = $params;
	}

	public function getExceptionID() {
		return $this->mExceptionID;
	}
}
