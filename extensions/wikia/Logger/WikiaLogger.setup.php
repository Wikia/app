<?php
/**
 * ErrorHandler
 *
 * ErrorHandler for handling standard php notices/warnings/fatals
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

if (!defined('MEDIAWIKI')) {
	exit(1);
}

$dir = __DIR__;

$wgAutoloadClasses['Wikia\\Logger\\WikiaLogger'] = "{$dir}/WikiaLogger.class.php";
$wgAutoloadClasses['Wikia\\Logger\\SyslogHandler'] = "{$dir}/SyslogHandler.class.php";
$wgAutoloadClasses['Wikia\\Logger\\WebProcessor'] = "{$dir}/WebProcessor.class.php";
$wgAutoloadClasses['Wikia\\Logger\\LogstashFormatter'] = "{$dir}/LogstashFormatter.class.php";

$loggerClasses = [
	'Psr' => [
		'Log' => [
			'Test' => [
				'LoggerInterfaceTest.php',
			],
			'AbstractLogger.php',
			'InvalidArgumentException.php',
			'LoggerAwareInterface.php',
			'LoggerAwareTrait.php',
			'LoggerInterface.php',
			'LoggerTrait.php',
			'LogLevel.php',
			'NullLogger.php',
		],
	],
	'Monolog' => [
		'Formatter' => [
			'ChromePHPFormatter.php',
			'ElasticaFormatter.php',
			'FormatterInterface.php',
			'GelfMessageFormatter.php',
			'HtmlFormatter.php',
			'JsonFormatter.php',
			'LineFormatter.php',
			'LogstashFormatter.php',
			'NormalizerFormatter.php',
			'ScalarFormatter.php',
			'WildfireFormatter.php',
		],
		'Handler' => [
			'FingersCrossed' => [
				'ActivationStrategyInterface.php',
				'ChannelLevelActivationStrategy.php',
				'ErrorLevelActivationStrategy.php',
			],
			'SyslogUdp' => [
				'UdpSocket.php',
			],
			'AbstractHandler.php',
			'AbstractProcessingHandler.php',
			'AbstractSyslogHandler.php',
			'AmqpHandler.php',
			'BufferHandler.php',
			'ChromePHPHandler.php',
			'CouchDBHandler.php',
			'CubeHandler.php',
			'DoctrineCouchDBHandler.php',
			'DynamoDbHandler.php',
			'ElasticSearchHandler.php',
			'ErrorLogHandler.php',
			'FingersCrossedHandler.php',
			'FirePHPHandler.php',
			'GelfHandler.php',
			'GroupHandler.php',
			'HandlerInterface.php',
			'HipChatHandler.php',
			'LogglyHandler.php',
			'MailHandler.php',
			'MissingExtensionException.php',
			'MongoDBHandler.php',
			'NativeMailerHandler.php',
			'NewRelicHandler.php',
			'NullHandler.php',
			'PushoverHandler.php',
			'RavenHandler.php',
			'RedisHandler.php',
			'RotatingFileHandler.php',
			'SocketHandler.php',
			'StreamHandler.php',
			'SwiftMailerHandler.php',
			'SyslogHandler.php',
			'SyslogUdpHandler.php',
			'TestHandler.php',
			'ZendMonitorHandler.php',
		],
		'Processor' => [
			'GitProcessor.php',
			'IntrospectionProcessor.php',
			'MemoryPeakUsageProcessor.php',
			'MemoryProcessor.php',
			'MemoryUsageProcessor.php',
			'ProcessIdProcessor.php',
			'PsrLogMessageProcessor.php',
			'UidProcessor.php',
			'WebProcessor.php',
		],
		'ErrorHandler.php',
		'Logger.php',
		'Registry.php',
	],
];

spl_autoload_register(function($class) use ($loggerClasses) {
	if (strpos($class, '\\') === false) {
		return false;
	}

	$parts = explode('\\', $class);
	if (!array_key_exists($parts[0], $loggerClasses)) {
		return false;
	}

	$path = __DIR__."/../../../lib/vendor";
	while (count($parts) > 0) {
		$next = array_shift($parts);
		$path .= "/{$next}";
	}

	$path .= '.php';

	require_once($path);
	return true;
});

$handler = Wikia\Logger\WikiaLogger::instance();
set_error_handler([$handler, 'onError'], error_reporting());