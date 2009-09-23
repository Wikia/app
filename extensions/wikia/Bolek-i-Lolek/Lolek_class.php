<?php

class Lolek {
	static function getPdf() {
		global $wgRequest, $wgUploadDirectory, $wgUploadPath;

		$url       = $wgRequest->getVal("url");
		$bolek_id  = $wgRequest->getVal("bolek_id");
		$timestamp = $wgRequest->getVal("timestamp");

		if (empty($url) || empty($bolek_id) || empty($timestamp)) return "Not enough data.";

		$fname = "{$bolek_id}-{$timestamp}.pdf";

#		if (!file_exists("{$wgUploadDirectory}/lolek/{$fname}")) {
			$add       = 0;
			$iteration = 3; // prevent infinite loop
			do {

			$cmd   = "/opt/wikia/bin/wkhtmltopdf --page-size Letter --header-line --header-center \"a Wikia magazine\" --footer-line --footer-center \"- [page] -\" --margin-bottom 20mm --margin-left 20mm --margin-right 20mm --margin-top 20mm --cover \"{$url}?action=cover&bolek_id={$bolek_id}\" \"{$url}?action=print&bolek_id={$bolek_id}&add={$add}\" {$wgUploadDirectory}/lolek/{$fname}";

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
#		}

		$result = "{$wgUploadPath}/lolek/{$fname}";

		return $result;
	}

	static function getPage() {
		global $wgRequest, $wgUploadDirectory, $wgUploadPath;

		$bolek_id  = $wgRequest->getVal("bolek_id");
		$timestamp = $wgRequest->getVal("timestamp");
		$page_id   = $wgRequest->getVal("page_id");

		if (empty($bolek_id) || empty($timestamp) || empty($page_id)) return "not enough data.";

		$fname = "{$bolek_id}-{$timestamp}.pdf";
		if (!file_exists("{$wgUploadDirectory}/lolek/{$fname}")) return "no pdf. Please create it first.";

#		if (!file_exists("{$wgUploadDirectory}/lolek/{$fname}-{$page_id}.jpg")) {
			$cmd   = "/usr/bin/gs -sDEVICE=jpeg -dNOPAUSE -dBATCH -dSAFER -dFirstPage={$page_id} -dLastPage={$page_id} -sOutputFile={$wgUploadDirectory}/lolek/{$fname}-{$page_id}.jpg {$wgUploadDirectory}/lolek/{$fname}";

			$wgMaxShellTime     = 0;
			$wgMaxShellFileSize  = 0;
			wfShellExec($cmd, $result);

				if ($result) return "page rendering error. (Info from gs.)";
#		}

		$result = "{$wgUploadPath}/lolek/{$fname}-{$page_id}.jpg";

		return $result;
	}
}

global $wgAjaxExportList;
$wgAjaxExportList[] = "Lolek::getPdf";
$wgAjaxExportList[] = "Lolek::getPage";
