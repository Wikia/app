<?php

/**
 * Static function collection for general extension support.
 */
class Scribunto {
	const LOCAL = 'local';

	/**
	 * Create a new engine object with specified parameters.
	 * @param $options array
	 * @return ScribuntoEngineBase
	 */
	public static function newEngine( $options ) {
		$class = $options['class'];
		return new $class( $options );
	}

	/**
	 * Create a new engine object with default parameters
	 * @param $extraOptions array Extra options to pass to the constructor, in addition to the configured options
	 * @throws MWException
	 * @return ScribuntoEngineBase
	 */
	public static function newDefaultEngine( $extraOptions = array() ) {
		global $wgScribuntoDefaultEngine, $wgScribuntoEngineConf;
		if( !$wgScribuntoDefaultEngine ) {
			throw new MWException( 'Scribunto extension is enabled but $wgScribuntoDefaultEngine is not set' );
		}

		if( !isset( $wgScribuntoEngineConf[$wgScribuntoDefaultEngine] ) ) {
			throw new MWException( 'Invalid scripting engine is specified in $wgScribuntoDefaultEngine' );
		}
		$options = $extraOptions + $wgScribuntoEngineConf[$wgScribuntoDefaultEngine];
		return self::newEngine( $options );
	}

	/**
	 * Get an engine instance for the given parser, and cache it in the parser
	 * so that subsequent calls to this function for the same parser will return
	 * the same engine.
	 *
	 * @param Parser $parser
	 */
	public static function getParserEngine( $parser ) {
		if( empty( $parser->scribunto_engine ) ) {
			$parser->scribunto_engine = self::newDefaultEngine( array( 'parser' => $parser ) );
			$parser->scribunto_engine->setTitle( $parser->getTitle() );
		}
		return $parser->scribunto_engine;
	}

	/**
	 * Check if an engine instance is present in the given parser
	 */
	public static function isParserEnginePresent( $parser ) {
		return !empty( $parser->scribunto_engine );
	}

	/**
	 * Remove the current engine instance from the parser
	 */
	public static function resetParserEngine( $parser ) {
		if ( !empty( $parser->scribunto_engine ) ) {
			$parser->scribunto_engine->destroy();
			$parser->scribunto_engine = null;
		}
	}
}

/**
 * An exception class which represents an error in the script. This does not 
 * normally abort the request, instead it is caught and shown to the user.
 */
class ScribuntoException extends MWException {
	var $messageName, $messageArgs, $params;

	/**
	 * @param $messageName string
	 * @param $params array
	 */
	function __construct( $messageName, $params = array() ) {
		if ( isset( $params['args'] ) ) {
			$this->messageArgs = $params['args'];
		} else {
			$this->messageArgs = array();
		}
		if ( isset( $params['module'] ) && isset( $params['line'] ) ) {
			$codeLocation = false;
			if ( isset( $params['title'] ) ) {
				$moduleTitle = Title::newFromText( $params['module'] );
				if ( $moduleTitle && $moduleTitle->equals( $params['title'] ) ) {
					$codeLocation = wfMessage( 'scribunto-line', $params['line'] )->text();
				}
			}
			if ( $codeLocation === false ) {
				$codeLocation = wfMessage(
					'scribunto-module-line',
					$params['module'],
					$params['line']
				)->text();
			}
		} else {
			$codeLocation = '[UNKNOWN]';
		}
		array_unshift( $this->messageArgs, $codeLocation );
		$msg = wfMessage( $messageName )->params( $this->messageArgs )->text();
		parent::__construct( $msg );

		$this->messageName = $messageName;
		$this->params = $params;
	}

	/**
	 * @return string
	 */
	public function getMessageName() {
		return $this->messageName;
	}

	public function toStatus() {
		$args = array_merge( array( $this->messageName ), $this->messageArgs );
		$status = call_user_func_array( array( 'Status', 'newFatal' ), $args );
		$status->scribunto_error = $this;
		return $status;
	}

	/**
	 * Get the backtrace as HTML, or false if there is none available.
	 */
	public function getScriptTraceHtml( $options = array() ) {
		return false;
	}
}
