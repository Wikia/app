<?php 

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsManagerSassBuilder extends AssetsManagerBaseBuilder {
	
	public function __construct($request) {
		parent::__construct($request);

		if(strpos($this->mOid, '..') !== false) {
			throw new Exception('File path must not contain \'..\'.');
		}
		
		if(!endsWith($this->mOid, '.scss', false)) {
			throw new Exception('Requested file must be .scss.');
		}
		
		$this->sassProcessing();
		$this->importsProcessing();
		$this->stylePathProcessing();
		$this->janusProcessing();
		
		$this->mContentType = AssetsManagerBaseBuilder::TYPE_CSS;
	}
	
	private function sassProcessing() {
		global $IP;

		$tempDir = sys_get_temp_dir();
		$tempOutFile = tempnam($tempDir, 'Sass');
		$params = urldecode(http_build_query($this->mParams, '', ' '));
		
		$cmd = "/var/lib/gems/1.8/bin/sass {$IP}/{$this->mOid} {$tempOutFile} --cache-location {$tempDir} --style compact -r {$IP}/extensions/wikia/SASS/wikia_sass.rb {$params}";
		$escapedCmd = escapeshellcmd($cmd);

		if(shell_exec($escapedCmd) != '') {
			unlink($tempOutFile);
			throw new Exception('Problem with SASS processing.');
		}

		$this->mContent = file_get_contents($tempOutFile);
		
		unlink($tempOutFile);
	}
	
	private function importsProcessing() {
		global $IP;
		
		$matches = array();
		$importRegexOne = "/@import ['\\\"]([^\\n]*\\.css)['\\\"]([^\\n]*)(\\n|$)/is"; // since this stored is in a string, remember to escape quotes, slashes, etc.
		$importRegexTwo = "/@import url[\\( ]['\\\"]?([^\\n]*\\.css)['\\\"]?[ \\)]([^\\n]*)(\\n|$)/is";
		if((0 < preg_match_all($importRegexOne, $this->mContent, $matches, PREG_SET_ORDER)) || (0 < preg_match_all($importRegexTwo, $this->mContent, $matches, PREG_SET_ORDER))) {
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
		
		require "$IP/extensions/wikia/StaticChute/wfReplaceCdnStylePathInCss.php";
		$this->mContent = wfReplaceCdnStylePathInCss($this->mContent);		
	}
	
	private function janusProcessing() {
		global $IP;

		if(isset($this->mParams['rtl']) && $this->mParams['rtl'] == true) {
			$descriptorspec = array(
				0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
				1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
				2 => array("pipe", "a")
			);

			$env = array();
			$process = proc_open("{$IP}/extensions/wikia/SASS/cssjanus.py", $descriptorspec, $pipes, NULL, $env);
			
			if(is_resource($process)) {
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