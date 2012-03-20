<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 * @author Piotr Bablok <piotr.bablok@gmail.com>
 */

class AssetsManagerSassBuilder extends AssetsManagerBaseBuilder {

	public function __construct(WebRequest $request) {
		global $wgDevelEnvironment, $wgSpeedBox;
		$wgDevelEnvironment ? $timeStart = microtime( true ) : null;
print("r: " . $request->getVal('oid') . "\n");		
print("bc: " . $this->mOid . "\n");
		parent::__construct($request);
print("ac: " . $this->mOid . "\n");

		if (strpos($this->mOid, '..') !== false) {
			throw new Exception('File path must not contain \'..\'.');
		}

		if (!endsWith($this->mOid, '.scss', false)) {
			throw new Exception('Requested file must be .scss.');
		}

		if (startsWith($this->mOid, '/', false)) {
			$this->mOid = substr( $this->mOid, 1);
		}

		if( $wgDevelEnvironment && $wgSpeedBox ) {
			$hash = wfAssetManagerGetSASShash( $this->mOid );
			$inputHash = md5(urldecode(http_build_query($this->mParams, '', ' ')));

			$cacheId = "/Sass-$inputHash-$hash";
			//$cacheFile = $tempDir . $cacheId;
			$memc = F::App()->wg->Memc;

			if ( $obj = $memc->get( $cacheId ) ) {
				$this->mContent = $obj;
			} else {
				$this->processContent();
				$memc->set( $cacheId, $this->mContent );
			}
		} else {
			$this->processContent();
		}

		$this->mContentType = AssetsManager::TYPE_CSS;


		if( $wgDevelEnvironment ) {
			$timeEnd = microtime( true );
			$time = intval( ($timeEnd - $timeStart) * 1000 );
			$contentLen = strlen( $this->mContent);
			error_log( "{$this->mOid}\t{$time}ms {$contentLen}b" );
		}

	}

	private function processContent() {
		$this->sassProcessing();
		$this->importsProcessing();
		$this->stylePathProcessing();
		$this->base64Processing();
		$this->janusProcessing();
	}

	private function sassProcessing() {
		global $IP, $wgSassExecutable;

		$tempDir = sys_get_temp_dir();
		//replace \ to / is needed because escapeshellcmd() replace \ into spaces (?!!)
		$tempOutFile = str_replace('\\', '/', tempnam($tempDir, 'Sass'));
		$tempDir = str_replace('\\', '/', $tempDir);
		$params = urldecode(http_build_query($this->mParams, '', ' '));

		$cmd = "{$wgSassExecutable} {$IP}/{$this->mOid} {$tempOutFile} --cache-location {$tempDir}/sass --style compact -r {$IP}/extensions/wikia/SASS/wikia_sass.rb {$params}";
		$escapedCmd = escapeshellcmd($cmd) . " 2>&1";

		$sassResult = shell_exec($escapedCmd);
		if ($sassResult != '') {
			Wikia::log(__METHOD__, false, "commandline error: " . $sassResult. " -- Full commandline was: $escapedCmd", true /* $always */);
			Wikia::log(__METHOD__, false, "Full commandline was: {$escapedCmd}", true /* $always */);
			Wikia::log(__METHOD__, false, AssetsManager::getRequestDetails(), true /* $always */);
			if ( file_exists( $tempOutFile ) ) {
				unlink($tempOutFile);
			}
			throw new Exception('Problem with SASS processing. Check the PHP error log for more info.'); // TODO: Should these exceptions be wrapped as comments like in the old system?
		}

		$this->mContent = file_get_contents($tempOutFile);

		unlink($tempOutFile);
	}

	private function importsProcessing() {
		global $IP;

		$matches = array();
		$importRegexOne = "/@import ['\\\"]([^\\n]*\\.css)['\\\"]([^\\n]*)(\\n|$)/is"; // since this stored is in a string, remember to escape quotes, slashes, etc.
		$importRegexTwo = "/@import url[\\( ]['\\\"]?([^\\n]*\\.css)['\\\"]?[ \\)]([^\\n]*)(\\n|$)/is";
		if ((0 < preg_match_all($importRegexOne, $this->mContent, $matches, PREG_SET_ORDER)) || (0 < preg_match_all($importRegexTwo, $this->mContent, $matches, PREG_SET_ORDER))) {
			foreach($matches as $match){
				$lineMatched = $match[0];
				$fileName = trim($match[1]);
				$fileContents = file_get_contents($IP . $fileName);
				$this->mContent = str_replace($lineMatched, $fileContents, $this->mContent);
			}
		}
	}

	private function stylePathProcessing() {
		global $IP;

		// TODO: move here once StaticChute is removed
		require "$IP/extensions/wikia/StaticChute/wfReplaceCdnStylePathInCss.php";
		$this->mContent = wfReplaceCdnStylePathInCss($this->mContent);
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
				return $matches[0] . '/* encoding failed! */';
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
			return false;
		}

		$ext = end(explode('.', $fileName));

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
				return false;
		}

		$content = file_get_contents($fileName);
		$encoded = base64_encode($content);

		wfProfileOut(__METHOD__);
		return "data:image/{$type};base64,{$encoded}";
	}

	private function janusProcessing() {
		global $IP;

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
	}

}
