<?php
/**
 * Wikia\Logger\Hooks:
 *	- onWikiaSkinTopScripts: load js for logging errors to the WikiaLogger
 *
 */

namespace Wikia\Logger;

use Wikia\Tracer\WikiaTracer;

class Hooks {

	/**
	 * Load an 'onerror' handler that forwards js errors to a log.
	 *
	 * @param array $vars
	 * @param string $scripts
	 * @return boolean
	 *
	 */
	public static function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		global $wgDevelEnvironment, $wgIsGASpecialWiki, $wgEnableJavaScriptErrorLogging, $wgMemc;

		if ( !$wgDevelEnvironment ) {
			$onError = $wgIsGASpecialWiki || $wgEnableJavaScriptErrorLogging;
			$key = "wikialogger-top-script-$onError";
			$loggingJs = $wgMemc->get( $key );

			if ( !$loggingJs ) {
				$errorUrl = "//jserrorslog.wikia.com/";
				$loggingJs = "
					function syslogReport(priority, message, context) {
						context = context || null;
						var url = '$errorUrl',
							i = new Image(),
							data = {
								'@message': message,
								'syslog_pri': priority
							};

						if (context) {
							data['@context'] = context;
						}

						try {
							data['@fields'] = { server: document.cookie.match(/server.([A-Z]*).cache/)[1] };
						} catch (e) {}

						try {
							i.src = url+'l?'+JSON.stringify(data);
						} catch (e) {
							i.src = url+'e?'+e;
						}
					}
				";

				if ( $onError ) {
					$loggingJs .= "
						window.onerror = function(m, u, l) {
							if (Math.random() < 0.01) {
								syslogReport(3, m, {'url': u, 'line': l}); // 3 is 'error'
							}

							return false;
						}
					";
				}

				$loggingJs = \AssetsManagerBaseBuilder::minifyJS( $loggingJs );
				$wgMemc->set( $key, $loggingJs, 60 * 60 * 24 );
			}

			$scripts = "<script>$loggingJs</script>$scripts";
		}

		return true;
	}

	/**
	 * A hook for setting up the WikiaLogger early in the app initialization process.
	 *
	 * @return boolean true
	 */
	public static function onWikiFactoryExecute() {
		/**
		 * Setup the WikiaLogger as the error handler
		 */
		$logger = WikiaLogger::instance();

		set_error_handler( [$logger, 'onError'], error_reporting() );
		register_shutdown_function( [$logger, 'onShutdown'] );

		return true;
	}

	/**
	 * A hook for setting additional fields that will be sent to Logstash
	 *
	 * @return bool true
	 */
	public static function onWikiFactoryExecuteComplete() {
		WikiaLogger::instance()->pushContextSource(
			WikiaTracer::instance()->getContextSource(), WebProcessor::RECORD_TYPE_FIELDS );

		return true;
	}

	/**
	 * Hook into wfDebugLog function and log errors via WikiaLogger
	 *
	 * @see PLATFORM-424
	 *
	 * @author macbre
	 * @return bool
	 */
	public static function onDebug($text, $logGroup ) {
		WikiaLogger::instance()->error(rtrim($text), [
			'logGroup' => $logGroup,
			'exception' => new \Exception() // report stack trace
		]);

		// prevent the default behaviour of wfDebugLog - we already logged all information we need
		return false;
	}
}
