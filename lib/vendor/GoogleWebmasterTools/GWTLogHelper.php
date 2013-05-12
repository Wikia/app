<?php

class GWTLogHelper {

	const TYPE_ERROR = 3;
	const TYPE_WARNING = 2;
	const TYPE_NOTICE = 1;
	const TYPE_DEBUG = 0;
	static $TYPE_MAP = array(
		self::TYPE_ERROR => "ERROR",
		self::TYPE_WARNING => "WARNING",
		self::TYPE_NOTICE => "NOTICE",
		self::TYPE_DEBUG => "DEBUG",
	);
	private static $logPath;

	public static function setLogPath($logPath) {
		self::$logPath = $logPath;
	}

	public static function getLogPath() {
		return self::$logPath;
	}

	public static function log( $msgText, $type = GWTLogHelper::TYPE_ERROR, $exception = null ) {

		$msg = 'LOG ['. date("Y-m-d H:i:s") . ']' . '[' . ( self::$TYPE_MAP[$type] ) .'] ' . $msgText . "\n";

		if( $exception instanceof Exception ) {
			$msg .= $exception->getMessage() . "\n";
			$msg .= $exception->getTraceAsString() . "\n";
		}

		if( !empty(self::$logPath) ) {
			$filePath = self::$logPath . DIRECTORY_SEPARATOR . 'gwt_log_' . date("Y-m") . '.log';
			file_put_contents( $filePath, $msg, FILE_APPEND );
		}
		echo $msg;
	}

	public static function notice( $msgText ) {
		self::log( $msgText, GWTLogHelper::TYPE_NOTICE );
	}

	public static function warning( $msgText, $exception = null ) {
		self::log( $msgText, GWTLogHelper::TYPE_WARNING, $exception );
	}

	public static function error( $msgText, $exception = null ) {
		self::log( $msgText, GWTLogHelper::TYPE_ERROR, $exception );
	}

	public static function debug( $msgText, $exception = null ) {
		self::log( $msgText, GWTLogHelper::TYPE_DEBUG, $exception );
	}
}
