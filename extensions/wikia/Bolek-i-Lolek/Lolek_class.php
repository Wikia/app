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
			$add       = 0;
			$iteration = 3; // prevent infinite loop
			do {

			$debug = "Debug: rendered " . date("r", time());
			$cmd   = "/opt/wikia/bin/wkhtmltopdf --page-size Letter --footer-left \"{$debug}\" --cover \"{$url}?action=cover&user_id={$user_id}\" \"{$url}?action=print&user_id={$user_id}&add={$add}\" {$wgUploadDirectory}/lolek/{$fname}";

			$wgMaxShellTime     = 0;
			$wgMaxShellFileSize  = 0;
			wfShellExec($cmd, $result);

				if ($result) return "Pdf rendering error. (Info from wkhtmltopdf.)";

				$cmd = "/usr/bin/pdfinfo {$wgUploadDirectory}/lolek/{$fname}";
				$output = wfShellExec($cmd, $result);

				if ($result || !preg_match("/Pages: *([0-9]+)\n/", $output, $matches)) return "Broken or no pdf. (Info from pdfinfo.)";

				$reminder = $matches[1] % 4;
				$add = $reminder ? 4 - $reminder : 0;
			} while (--$iteration && $add);
		
			if ($add) return "Pdf generation error, can't reach mod 4 pages. (+{$add} page(s) needed.)";
		}

		$result = "{$wgUploadPath}/lolek/{$fname}";

		return $result;
	}
}

global $wgAjaxExportList;
$wgAjaxExportList[] = "Lolek::getPdf";
