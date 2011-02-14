<?php
/**
 * This service simplifies JS and CSS minification
 *
 * Currently this class is only used by RTE's minify.sh script
 *
 * @author macbre
 */

class MinifyService extends Service {

	const RESULT_OK = 0;

	/**
	 * Store given content in temporary file and return its name
	 */
	private static function storeInTempFile($content) {
		$tmpName = tempnam(sys_get_temp_dir(), 'minify');
		file_put_contents($tmpName, $content);

		return $tmpName;
	}

	/**
	 * Removes given temporary file
	 */
	private static function removeTempFile($tmpName) {
		unlink($tmpName);
	}

	/**
	 * Merges content of provided list of files into single string
	 */
	public static function mergeFiles($files) {
		wfProfileIn(__METHOD__);
		$content = '';

		foreach($files as $file) {
			if (file_exists($file)) {
				$content .= file_get_contents($file);
			}
			else {
				wfDebug(__METHOD__ . ": file {$file} does not exist!\n");
			}
		}

		// remove BOM UTF-8 marker
		$content = str_replace("\xEF\xBB\xBF", '', $content);

		wfProfileOut(__METHOD__);
		return $content;
	}

	/**
	 * Return minified version of given JavaScript code (or false in case of an error)
	 */
	public static function minifyJS($code) {
		global $IP;
		wfProfileIn(__METHOD__);

		wfDebug(__METHOD__ . ": starting...\n");

		// store code in temporary file
		$tmpName = self::storeInTempFile($code);

		// YUI compressor
		$code = exec("java -jar {$IP}/lib/yuicompressor-2.4.2.jar {$tmpName} --charset utf-8 --type js", $out, $res);

		// clean up
		self::removeTempFile($tmpName);

		wfDebug(__METHOD__ . ": done!\n");

		wfProfileOut(__METHOD__);
		return ($res == self::RESULT_OK) ? $code : false;
	}

	/**
	 * Return minified version of given CSS (or false in case of an error)
	 */
	public static function minifyCSS($code) {
		global $IP;
		wfProfileIn(__METHOD__);

		wfDebug(__METHOD__ . ": starting...\n");

		// store code in temporary file
		$tmpName = self::storeInTempFile($code);

		// minify (output is written to stdout)
		$code = exec("java -jar {$IP}/lib/yuicompressor-2.4.2.jar {$tmpName} --charset utf-8 --type css", $out, $res);

		// clean up
		self::removeTempFile($tmpName);

		wfDebug(__METHOD__ . ": done!\n");

		wfProfileOut(__METHOD__);
		return ($res == self::RESULT_OK) ? $code : false;
	}
}
