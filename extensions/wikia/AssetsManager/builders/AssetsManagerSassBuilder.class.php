<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 * @author Piotr Bablok <piotr.bablok@gmail.com>
 */

class AssetsManagerSassBuilder extends AssetsManagerBaseBuilder {
	const CACHE_VERSION = 2;

	public function __construct(WebRequest $request) {
		global $IP;
		parent::__construct($request);

		if (strpos($this->mOid, '..') !== false) {
			throw new Exception('File path must not contain \'..\'.');
		}

		if (!endsWith($this->mOid, '.scss', false)) {
			throw new Exception('Requested file must be .scss.');
		}

		//remove slashes at the beginning of the string, we need a pure relative path to open the file
		$this->mOid = preg_replace( '/^[\/]+/', '', $this->mOid );

		if ( !file_exists( "{$IP}/{$this->mOid}" ) ) {
			throw new Exception("File {$this->mOid} does not exist!");
		}
		$this->mContentType = AssetsManager::TYPE_CSS;
	}

	public function getContent( $processingTimeStart = null ) {
		global $IP;
		wfProfileIn(__METHOD__);

		$processingTimeStart = null;

		if ( $this->mForceProfile ) {
			$processingTimeStart = microtime( true );
		}

		$memc = F::App()->wg->Memc;

		$this->mContent = null;

		$content = null;
		$sassService = null;
		$hasErrors = false;

		try {
			$sassService = SassService::newFromFile("{$IP}/{$this->mOid}");
			$sassService->setSassVariables($this->mParams);
			$sassService->setFilters(
				SassService::FILTER_IMPORT_CSS | SassService::FILTER_CDN_REWRITE
				| SassService::FILTER_BASE64 | SassService::FILTER_JANUS
			);

			$cacheId = __CLASS__ . "-minified-".$sassService->getCacheKey();
			$content = $memc->get( $cacheId );
		} catch (Exception $e) {
			$content = "/* {$e->getMessage()} */";
			$hasErrors = true;
		}


		if ( $content ) {
			$this->mContent = $content;

		} else {
			// todo: add extra logging of AM request in case of any error
			try {
				$this->mContent = $sassService->getCss( /* useCache */ false);
			} catch (Exception $e) {
				$this->mContent = $this->makeComment($e->getMessage());
				$hasErrors = true;
			}

			// This is the final pass on contents which, among other things, performs minification
			parent::getContent( $processingTimeStart );

			// Prevent cache poisoning if we are serving sass from preview server
			if ( !empty($cacheId) && getHostPrefix() == null && !$this->mForceProfile ) {
				$expTime = 0;
				if ( $hasErrors ) {
					$expTime = 10; // prevent flooding servers with sass processes
				}
				$memc->set( $cacheId, $this->mContent, $expTime );
			}
		}

		if ($hasErrors) {
			wfProfileOut(__METHOD__);
			throw new Exception($this->mContent);
		}

		wfProfileOut(__METHOD__);

		return $this->mContent;
	}

	private function processContent() {
		wfProfileIn(__METHOD__);

		$this->sassProcessing();
		$this->importsProcessing();
		$this->stylePathProcessing();
		$this->base64Processing();
		$this->janusProcessing();

		wfProfileOut(__METHOD__);
	}

	private function sassProcessing() {
		global $IP, $wgSassExecutable, $wgDevelEnvironment;
		wfProfileIn(__METHOD__);

		$tempDir = sys_get_temp_dir();
		//replace \ to / is needed because escapeshellcmd() replace \ into spaces (?!!)
		$tempOutFile = str_replace('\\', '/', tempnam($tempDir, 'Sass'));
		$tempDir = str_replace('\\', '/', $tempDir);
		$params = urldecode(http_build_query($this->mParams, '', ' '));

		$cmd = "{$wgSassExecutable} {$IP}/{$this->mOid} {$tempOutFile} --cache-location {$tempDir}/sass -r {$IP}/extensions/wikia/SASS/wikia_sass.rb {$params}";
		$escapedCmd = escapeshellcmd($cmd) . " 2>&1";

		$sassResult = shell_exec($escapedCmd);
		if ($sassResult != '') {
			Wikia::log(__METHOD__, false, "commandline error: " . $sassResult. " -- Full commandline was: $escapedCmd", true /* $always */);
			Wikia::log(__METHOD__, false, "Full commandline was: {$escapedCmd}", true /* $always */);
			Wikia::log(__METHOD__, false, AssetsManager::getRequestDetails(), true /* $always */);
			if ( file_exists( $tempOutFile ) ) {
				unlink($tempOutFile);
			}

			if (!empty($wgDevelEnvironment)) {
				$exceptionMsg = "Problem with SASS processing: {$sassResult}";
			}
			else {
				$exceptionMsg = 'Problem with SASS processing. Check the PHP error log for more info.';
			}

			throw new Exception("/* {$exceptionMsg} */");
		}

		$this->mContent = file_get_contents($tempOutFile);

		unlink($tempOutFile);

		wfProfileOut(__METHOD__);
	}

	private function importsProcessing() {
		global $IP;
		wfProfileIn(__METHOD__);

		$matches = array();
		$importRegexOne = "/@import ['\\\"]([^\\n]*\\.css)['\\\"]([^\\n]*)(\\n|$)/is"; // since this stored is in a string, remember to escape quotes, slashes, etc.
		$importRegexTwo = "/@import url[\\( ]['\\\"]?([^\\n]*\\.css)['\\\"]?[ \\)]([^\\n]*)(\\n|$)/is";
		if ((0 < preg_match_all($importRegexOne, $this->mContent, $matches, PREG_SET_ORDER)) || (0 < preg_match_all($importRegexTwo, $this->mContent, $matches, PREG_SET_ORDER))) {
			foreach($matches as $match) {
				$lineMatched = $match[0];
				$fileName = trim($match[1]);
				$fileContents = file_get_contents($IP . $fileName);
				$this->mContent = str_replace($lineMatched, $fileContents, $this->mContent);
			}
		}

		wfProfileOut(__METHOD__);
	}

	private function stylePathProcessing() {
		global $wgCdnStylePath;
		wfProfileIn(__METHOD__);

		if(strpos($this->mContent, "wgCdnStylePath") !== false){ // faster to skip the regex in most cases
			// Because of fonts in CSS, we have to allow for lines with multiple url()s in them.
			// This will rewrite all but the last URL on the line (the last regex will fix the final URL and remove the special comment).
			$wasChanged = true;

			// TODO: refactor?
			while($wasChanged) {
				$changedCss = preg_replace("/([\(][\"']?)(\/[^\n]*?)([, ]url[^\n]*?)(\s*\/\*\s*[\\\$]?wgCdnStylePath\s*\*\/)/is", '\\1'.$wgCdnStylePath.'\\2\\3\\4', $this->mContent);
				if($changedCss != $this->mContent) {
					$wasChanged = true;
					$this->mContent = $changedCss;
				} else {
					$wasChanged = false;
				}
			}

			$this->mContent = preg_replace("/([\(][\"']?)(\/[^\n]*?)\s*\/\*\s*[\\\$]?wgCdnStylePath\s*\*\//is", '\\1'.$wgCdnStylePath.'\\2', $this->mContent);
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Tries to base64 encode images marked with "base64" comment
	 */
	private function base64Processing() {
		wfProfileIn(__METHOD__);

		$this->mContent = preg_replace_callback("/([, ]url[^\n]*?)(\s*\/\*\s*base64\s*\*\/)/is", function($matches) {
			global $IP;
			$fileName = $IP . trim(substr($matches[1], 4, -1), '\'"() ');

			$encoded = AssetsManagerSassBuilder::base64EncodeFile($fileName);
			if ($encoded !== false) {
				return "url({$encoded});";
			}
			else {
				throw new Exception("/* Base64 encoding failed: {$fileName} not found! */");
			}
		}, $this->mContent);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Base64 encodes given file
	 *
	 * @param string $fileName file absolute path
	 * @return mixed encoded file content or false (if file doesn't exist)
	 */
	public static function base64EncodeFile($fileName) {
		wfProfileIn(__METHOD__);

		if (!file_exists($fileName)) {
			wfProfileOut(__METHOD__);
			return false;
		}

		$parts = explode('.', $fileName);
		$ext = end($parts);

		switch($ext) {
			case 'gif':
			case 'png':
		        $type = $ext;
		        break;

			case 'jpg':
				$type = 'jpeg';
				break;

			// not supported image type provided
			default:
				wfProfileOut(__METHOD__);
				return false;
		}

		$content = file_get_contents($fileName);
		$encoded = base64_encode($content);

		wfProfileOut(__METHOD__);
		return "data:image/{$type};base64,{$encoded}";
	}

	private function janusProcessing() {
		global $IP;
		wfProfileIn(__METHOD__);

		if (isset($this->mParams['rtl']) && $this->mParams['rtl'] == true) {
			$descriptorspec = array(
				0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
				1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
				2 => array("pipe", "a")
			);

			$env = array();
			$process = proc_open("{$IP}/extensions/wikia/SASS/cssjanus.py", $descriptorspec, $pipes, NULL, $env);

			if (is_resource($process)) {
				fwrite($pipes[0], $this->mContent);
				fclose($pipes[0]);

				$this->mContent = stream_get_contents($pipes[1]);
				fclose($pipes[1]);
				fclose($pipes[2]);
				proc_close($process);
			}
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Get a JS/CSS comment with the given text
	 *
	 * @param $text string Text to be put in the comment
	 * @return string Input text wrapped in the comment
	 */
	protected function makeComment( $text ) {
		$encText = str_replace( '*/', '* /', $text );
		return "/*\n$encText\n*/\n";
	}

}
