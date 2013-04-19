<?php
/**
 * @author: Jacek Jursza <jacek@wikia-inc.com>
 * Date: 19.04.13 11:20
 *
 */

class GWTLogHelper {

	const TYPE_ERROR = 3;
	const TYPE_WARNING = 2;
	const TYPE_NOTICE = 1;

	public static $logPath;

	public static function log( $msgText, $type = GWTLogHelper::TYPE_ERROR ) {

		$filePath = self::$logPath . DIRECTORY_SEPARATOR . 'gwt_log_' . date("Y-m") . '.log';

		$msg = '['. date("Y-m-d H:i:s") . ']' . '[' . ( $type == 3 ? 'ERROR' : ($type == 2 ? 'WARNING' : 'NOTICE') ) .'] ' . $msgText . "\n";

		file_put_contents( $filePath, $msg, FILE_APPEND );
	}

}