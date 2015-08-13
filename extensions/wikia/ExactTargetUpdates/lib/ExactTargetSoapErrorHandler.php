<?php
namespace Wikia\ExactTarget;
use Wikia\Logger\WikiaLogger;

class ExactTargetSoapErrorHandler {
	public static function requeueConnectionResetWarning( $errno, $errstr = null, $errfile = null, $errline = null, $errcontext = null ) {

		if ( strpos( $errstr, 'Connection reset by peer' ) !== false ) {
			if ( isset( $errcontext['retryAttempt'] ) && $errcontext['retryAttempt'] !== false ) {
				WikiaLogger::instance()->error( 'Retrying sending ExactTarget request failed',
					[ 'cause_error_message' => $errstr ]
				);
			} else {
				$location = isset( $errcontext['location'] ) ? $errcontext['location'] : null;
				$saction = isset( $errcontext['saction'] ) ? $errcontext['saction'] : null;
				$version = isset( $errcontext['version'] ) ? $errcontext['version'] : null;
				$one_way = isset( $errcontext['one_way'] ) ? $errcontext['one_way'] : null;
				$request = isset( $errcontext['request'] ) ? $errcontext['request'] : null;

				/* Requeue request */
				$task = new ExactTargetRedoSoapRequestTask();
				$task->call( 'redoSoapRequestTask', $request, $location, $saction, $version, $one_way );
				$task->queue();
			}
		}

		/* Use default WikiaLogger to store default logs as well */
		WikiaLogger::instance()->onError( $errno, $errstr, $errfile, $errline, $errcontext );
	}
}
