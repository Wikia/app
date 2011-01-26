<?php
/**
 * This service simplifies JS and CSS minification
 *
 * Currently this class is only used by RTE's minify.sh script
 *
 * @author macbre
 */

class MinifyService extends Service {

	/**
	 * Store given content in temporary file and return its name
	 */
	private static function storeInTempFile($content) {
		$tmp = tempnam(sys_get_temp_dir(), 'minify');
        file_put_contents($tmp, $content);

		return $tmp;
	}

	/**
	 * Removes given temporary file
	 */
	private static function removeTempFile($tmp) {
		unlink($tmp);
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
	 * Minify given JavaScript code
	 */
	public static function minifyJS($code) {
		global $IP;
		wfProfileIn(__METHOD__);

		wfDebug(__METHOD__ . ": starting...\n");

		// store code in temporary file
		$tmp = self::storeInTempFile($code);

		// minify (output is written to stdout)
		// Google Closure
		//$code = shell_exec("java -jar {$IP}/lib/closure/compiler.jar --js {$tmp} --charset UTF-8 --compilation_level SIMPLE_OPTIMIZATIONS --warning_level QUIET");

		// YUI compressor
		$code = shell_exec("java -jar {$IP}/lib/yuicompressor-2.4.2.jar {$tmp} --charset utf-8 --type js");

		// Google Closure REST API
		/*
		$code = Http::post('http://closure-compiler.appspot.com/compile', array(
			'postData' => array(
				'js_code' => $code,
				'compilation_level' => 'SIMPLE_OPTIMIZATIONS',
				'output_format' => 'text',
				'output_info' => 'compiled_code',
			)
		));
		*/

		// clean up
		self::removeTempFile($tmp);

		wfDebug(__METHOD__ . ": done!\n");

		wfProfileOut(__METHOD__);
		return $code;
	}

	/**
	 * Minify given CSS code
	 */
	public static function minifyCSS($code) {
		global $IP;
		wfProfileIn(__METHOD__);

		wfDebug(__METHOD__ . ": starting...\n");

		// store code in temporary file
		$tmp = self::storeInTempFile($code);

		// minify (output is written to stdout)
		$code = shell_exec("java -jar {$IP}/lib/yuicompressor-2.4.2.jar {$tmp} --charset utf-8 --type css");

		// clean up
		self::removeTempFile($tmp);

		wfDebug(__METHOD__ . ": done!\n");

		wfProfileOut(__METHOD__);
		return $code;
	}
}
