<?php

class Lolek {
	static function getPdf() {
		global $wgRequest, $wgUploadDirectory, $wgUploadPath;

		$url       = $wgRequest->getVal("url");
		$user_id   = $wgRequest->getVal("user_id");
		$timestamp = $wgRequest->getVal("timestamp");

		if (empty($url) || empty($user_id) || empty($timestamp)) return "Not enough data.";

		$fname = "{$user_id}-{$timestamp}.pdf";

		if (!file_exists("{$wgUploadDirectory}/lolek/{$fname}")) {
			$debug = "Debug: rendered " . date("r", time());
			$cmd   = "/opt/wikia/bin/wkhtmltopdf --page-size Letter --footer-left \"{$debug}\" \"{$url}?action=print&user_id={$user_id}\" {$wgUploadDirectory}/lolek/{$fname}";

			$wgMaxShellTime     = 0;
			$wgMaxShellFileSize  = 0;
			wfShellExec($cmd);
		}

		$result = "{$wgUploadPath}/lolek/{$fname}";

		return $result;
	}
}

global $wgAjaxExportList;
$wgAjaxExportList[] = "Lolek::getPdf";
