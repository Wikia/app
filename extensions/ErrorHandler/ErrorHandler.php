<?php

if( !defined( 'MEDIAWIKI' ) ) die();

/**
 * Error handler for MediaWiki
 *
 * @author Alexandre Emsenhuber
 * @license GPLv2 or higher
 */
$wgExtensionCredits['other'][] = array(
	'svn-date'       => '$LastChangedDate: 2008-12-13 23:13:22 +0100 (sob, 13 gru 2008) $',
	'svn-revision'   => '$LastChangedRevision: 44547 $',
	'name'           => 'ErrorHandler',
	'author'         => 'Alexandre Emsenhuber',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:ErrorHandler',
	'description'    => 'Error handler for MediaWiki',
	'descriptionmsg' => 'errorhandler-desc',
);

// Config

/**
 * Types of errors to show
 */
$wgErrorHandlerReport = ( E_ALL | E_STRICT ) & ~4096 /* E_RECOVERABLE_ERROR */;

/**
 * Whether to show the backtrace when an error occurs
 */
$wgErrorHandlerShowBackTrace = true;

/**
 * Max string size in backtrace
 */
$wgErrorHandlerMaxStringSize = 50;

/**
 * Always report errors, regardless of the current value of error_reporting()
 */
$wgErrorHandlerAlwaysReport = false;

/**
 * Log errors?
 * if true, this will in php error log and if it's a string and the file exists
 * it'll be in that file
 */
$wgErrorHandlerLog = false;

// +-----------------------------------+
// | Internal variables, DO NOT MODIFY |
// +-----------------------------------+

/**
 * Array of errors to display
 */
$wgErrorHandlerErrors = array();

/**
 * Is output already done ?
 * If true, output will be directly send otherwise it'll saved if
 * $wgErrorHandlerErrors to be displayed with BeforePageDisplay hook
 * Do not use BeforePageDisplay hook on command line mode
 */
$wgErrorHandlerOutputDone = false;

$wgHooks['BeforePageDisplay'][] = 'efErrorHandlerShowErrors';
$wgExtensionMessagesFiles['ErrorHandler'] = dirname( __FILE__ ) . '/ErrorHandler.i18n.php';

/**
 * Custom error handler
 *
 * @param integer $errType type of error
 * @param string $errMsg error message
 * @param string $errFile file where the error occured
 * @param integer $errLine line where the error occured
 * @param array $errVars hmm?
 */
function efErrorHandler( $errType, $errMsg, $errFile, $errLine, $errVars ){
	global $wgErrorHandlerErrors,        $wgErrorHandlerOutputDone,
	       $wgErrorHandlerShowBackTrace, $wgErrorHandlerReport,
	       $wgErrorHandlerMaxStringSize, $wgErrorHandlerAlwaysReport,
	       $wgErrorHandlerLog;
	global $IP, $wgCommandLineMode;
	static $errorsMap = array (
		E_ERROR              => 'fatal',
		E_WARNING            => 'warning',
		E_PARSE              => 'parse',
		E_NOTICE             => 'notice',
		E_CORE_ERROR         => 'core-error',
		E_CORE_WARNING       => 'core-warning',
		E_COMPILE_ERROR      => 'compile-error',
		E_COMPILE_WARNING    => 'compile-warning',
		E_USER_ERROR         => 'user-error',
		E_USER_WARNING       => 'user-warning',
		E_USER_NOTICE        => 'user-notice',
		E_STRICT             => 'strict',
		4096                 => 'recoverable',     // E_RECOVERABLE_ERROR
		8192                 => 'deprecated',      // E_DEPRECATED
		16384                => 'user-deprecated', // E_USER_DEPRECATED
	);

	if( !( $errType & $wgErrorHandlerReport ) ||
		( !$wgErrorHandlerAlwaysReport && !( error_reporting() & $errType ) ) )
		return false;

	$trace = array();
	// Show the backtrace
	if( $wgErrorHandlerShowBackTrace ){

		if( function_exists( 'wfDebugBacktrace' ) )
			$backtrace = array_slice( wfDebugBacktrace(), 1 );
		else
			$backtrace = array_slice( debug_backtrace(), 1 );

		foreach( $backtrace as $call ) {

			if( isset( $call['file'] ) && isset( $call['line'] ) ) {
				$safeIP = preg_quote( $IP, '/' );
				$file = preg_replace( "/^$safeIP/", '.', $call['file'] );
				$line = $call['line'];
				$internal = false;
			} else {
				$internal = true;
			}

			$func = '';
			if( !empty( $call['class'] ) ) $func .= $call['class'] . $call['type'];
			$func .= $call['function'];

			if( isset( $call['args'] ) && !empty( $call['args'] ) && is_array( $call['args'] ) ){
				$args = array();
				foreach( $call['args'] as $arg ){
					if( is_object( $arg ) ){
						$args[] = 'Object(' . get_class( $arg ) . ')';
					} else if ( is_null( $arg ) ){
						$args[] = 'null';
					} else if ( is_array( $arg ) ){
						$args[] = 'array()';
					} else if ( is_string( $arg ) ){
						if( strlen( $arg ) > $wgErrorHandlerMaxStringSize ){
							$str = substr( $arg, 0, $wgErrorHandlerMaxStringSize ) . '...';
						} else {
							$str = $arg;
						}
						$args[] = '\'' . str_replace( "\n", '', $str ) . '\'';
					} else if ( is_numeric( $arg ) ){
						$args[] = (string)$arg;
					} else if ( is_bool( $arg ) ){
						$args[] = 'bool(' . ( $arg ? 'true' : 'false' ) . ')';
					} else {
						$args[] = gettype( $arg ) . '(' . $arg . ')';
					}
				}
				$func .= '( ' .  implode( ', ', $args ) . ' )';
			} else {
				$func .= '()';
			}
			$func = htmlspecialchars( $func );

			if( $internal ) {
				$res = array( 'errorhandler-trace-line-internal', $func );
			} else {
				$file = htmlspecialchars( $file );
				$res = array( 'errorhandler-trace-line', $file, $line, $func );
			}
			$trace[] = $res;
		}
	}

	$err = array(
		'error' => 'errorhandler-error-' . $errorsMap[$errType],
		'msg' => $errMsg,
		'file' => $errFile,
		'line' => $errLine,
		'trace' => $trace
	);

	$errText = efErrorGetText( $err, true );

	if( $wgErrorHandlerLog === true ){
		error_log( $errText, 0 );
	} elseif( file_exists( $wgErrorHandlerLog ) ){
		error_log( $errText, 3, $wgErrorHandlerLog );
	}

	if( $wgCommandLineMode ){
		echo $errText;
	} else {
		if( $wgErrorHandlerOutputDone )
			echo efErrorGetText( $err );
		else
			$wgErrorHandlerErrors[] = $err;
	}
	return true;
}

/**
 * As this might be called before including GlobalFunctions.php, we'll maybe
 * need to handle ourself the message, in this we'll simply return the english
 * message and it will *not* be parsed.
 */
function efErrorHandlerGetMessage(){
	static $messages = false;
	static $loaded = false;
	$args = func_get_args();
	if( !$loaded ){
		global $wgMessageCache;
		if( function_exists( 'wfMsgExt' ) && is_object( $wgMessageCache ) ){
			$loaded = true;
			wfLoadExtensionMessages( 'ErrorHandler' );
		}
	}
	if( $loaded ){
		global $wgTitle;
		$msg = array_shift( $args );
		$opts = array( 'replaceafter' );
		if( $wgTitle instanceof Title )
			$opts[] = 'parseinline';
		$callbackArgs = array_merge( array( $msg, $opts ), $args );
		return call_user_func_array( 'wfMsgExt', $callbackArgs );
	} else {
		if( !is_array( $messages ) )
			require_once( dirname( __FILE__ ) . '/ErrorHandler.i18n.php' );
		$msg = array_shift( $args );
		$message = $messages['en'][$msg];
		$replacementKeys = array();
		foreach( $args as $n => $param ) {
			$replacementKeys['$' . ($n + 1)] = $param;
		}
		return strtr( $message, $replacementKeys );
	}
}

/**
 * Get an error string from an array
 * @param $arr array
 * @param $forceText bool
 */
function efErrorGetText( $arr, $forceText = false ){
	global $wgCommandLineMode;
	$html = !( $wgCommandLineMode || $forceText );
	$msg = $html ? 'errorhandler-msg-html' : 'errorhandler-msg-text';
	$error = efErrorHandlerGetMessage( $arr['error'] );
	$ret = efErrorHandlerGetMessage( $msg, $error, $arr['msg'], $arr['file'], $arr['line'] );
	$trace = $arr['trace'];
	if( count( $trace ) ){
		$ret .= $html ? "<br />\n" : "\n";
		$ret .= efErrorHandlerGetMessage( 'errorhandler-trace' );
		$ret .= $html ? "<ol>\n" : "\n";
		foreach( $trace as $call ){
			$ret .= $html ? "<li>" : '  ';
			$ret .= call_user_func_array( 'efErrorHandlerGetMessage', $call );
			$ret .= $html ? "</li>\n" : "\n";
		}
		$ret .= $html ? "</ol>\n" : '';

	}
	return $ret;
}

/**
 * Hook function for BeforePageDisplay
 */
function efErrorHandlerShowErrors( &$out ){
	global $wgErrorHandlerErrors, $wgErrorHandlerOutputDone;
	$wgErrorHandlerOutputDone = true;
	if( empty( $wgErrorHandlerErrors ) )
		return true;
	$str  = efErrorHandlerGetMessage( 'errorhandler-errors' ) . "\n<ul>\n<li>";
	$str .= implode( "</li>\n<li>", array_map( 'efErrorGetText', $wgErrorHandlerErrors ) );
	$str .= "\n</li>\n</ul>";
	$out->setSubtitle( $str );
	return false;
}

# And set the handler
set_error_handler( 'efErrorHandler', E_ALL | E_STRICT );
