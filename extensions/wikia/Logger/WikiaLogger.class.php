<?php
/**
 * WikiaLogger
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Logger;

use Monolog\Logger;

class WikiaLogger {
	/** @var \Psr\Log\LoggerInterface */
	private $logger;

	private function __construct($ident) {
		$this->logger = new Logger(
			'default',
			[new SyslogHandler($ident)],
			[new WebProcessor()]
		);
	}

	/**
	 * @param string $ident
	 * @return WikiaLogger
	 */
	public static function instance($ident=null) {
		static $instances = [];

		if ($ident == null) {
			$ident = PHP_SAPI == 'cli' ? 'php' : 'apache2';
		}

		if (!isset($instances[$ident])) {
			$instances[$ident] = new WikiaLogger($ident);
		}

		return $instances[$ident];
	}

	public function logger() {
		return $this->logger;
	}

	public function onError($code, $message, $file, $line, $context) {
		if (!($code & error_reporting())) {
			return true;
		}

		$exit = false;

		switch ($code) {
			case E_NOTICE:
			case E_USER_NOTICE:
				$method = 'notice';
				$priorityString = 'Notice';
				break;
			case E_WARNING:
			case E_CORE_WARNING:
			case E_USER_WARNING:
				$method = 'warning';
				$priorityString = 'Warning';
				break;
			case E_ERROR:
			case E_CORE_ERROR:
			case E_USER_ERROR:
				$exit = true;
				$method = 'error';
				$priorityString = 'Fatal Error';
				break;
			case E_STRICT:
			case E_PARSE:
			case E_COMPILE_ERROR:
			case E_COMPILE_WARNING:
			case E_DEPRECATED:
				// compile-time errors don't call autoload callbacks, so let the standard php error log handle them - BAC-1225
				return false;
			default:
				return false;
		}

		$this->logger->$method("PHP {$priorityString}: {$message} in {$file} on line {$line}");

		if ($exit) {
			exit(1);
		}

		return true;
	}

	public function debug($message, $context=[]) {
		return $this->logger->debug($message, $context);
	}

	public function info($message, $context=[]) {
		return $this->logger->info($message, $context);
	}

	public function notice($message, $context=[]) {
		return $this->logger->notice($message, $context);
	}

	public function warning($message, $context=[]) {
		return $this->logger->warning($message, $context);
	}

	public function error($message, $context=[]) {
		return $this->logger->error($message, $context);
	}

	public function critical($message, $context=[]) {
		return $this->logger->critical($message, $context);
	}

	public function alert($message, $context=[]) {
		return $this->logger->alert($message, $context);
	}

	public function emergency($message, $context=[]) {
		return $this->logger->emergency($message, $context);
	}

	public static function onWikiaSkinTopScripts(&$vars, &$scripts) {
		global $wgDevelEnvironment, $wgIsGASpecialWiki, $wgEnableJavaScriptErrorLogging, $wgCacheBuster, $wgMemc;

		if (!$wgDevelEnvironment) {
			$onError = $wgIsGASpecialWiki || $wgEnableJavaScriptErrorLogging;
			$key = "wikialogger-top-script-$wgCacheBuster-$onError";
			$loggingJs = $wgMemc->get($key);

			if (!$loggingJs) {
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

				if ($onError) {
					$loggingJs .= "
						window.onerror = function(m, u, l) {
							if (Math.random() < 0.01) {
								syslogReport(3, m, {'url': u, 'line': l}); // 3 is 'error'
							}

							return false;
						}
					";
				}

				$loggingJs = \AssetsManagerBaseBuilder::minifyJS($loggingJs);
				$wgMemc->set($key, $loggingJs, 60*60*24);
			}

			$scripts = "<script>$loggingJs</script>$scripts";
		}

		return true;
	}
} 