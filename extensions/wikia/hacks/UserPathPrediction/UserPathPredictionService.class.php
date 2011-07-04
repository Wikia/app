<?php
/**
 * @author Jakub Olek <bukaj.kelo(at)gmail.com
 * 
 * 1.Setup
 * 2.Download
 * 3.Parse
 * 4.Clean
 * 
 */

class UserPathPredictionService extends WikiaService {

	//VARS
	private $wantedDomains, $yesterday, $splitDIR = '/tmp/wikis/', $s3Directory = 's3://one_dot_archive/';

	public function init() {
		$this->logPath = "/tmp/" . __CLASS__;
	}

	private function log( $msg ) {
		if ( $this -> wg -> DevelEnvironment ) {
			file_put_contents($this->logPath, var_export($msg, true) . "\n", FILE_APPEND);
		}
	}

	// Check if the folder is empty
	private function isEmptyFolder($folder) {
		$files = array();
		if($handle = opendir($folder)) {
			while(false !== ($file = readdir($handle))) {
				if($file != "." && $file != "..") {
					$files[] = $file;
				}
			}
			closedir($handle);
		}
		return (count($files) > 0) ? FALSE : TRUE;
	} //end of empty folder

	//change colons to %3A in URL
	private function fixURL($url) {
		return     str_replace(":", "%3A", $url);
	} //end of colons to %3A

	//Download - download onedot files
	function Download() {
		$this->Clean();
		//$yesterday = date("Ymd", strtotime("-1 day"));
		//TODO:static date here WRONG!
		$this -> yesterday = "20110504";
		//Execute download script from cmd line
		$this->log("Starting download s3cmd get " . $this -> s3Directory . $this -> yesterday . "/\n");
		$this->log(shell_exec('mkdir /tmp/' . $this -> yesterday));
		$this->log(shell_exec('s3cmd get --recursive ' . $this->s3Directory . $this -> yesterday . '/ /tmp/' . $this -> yesterday . '/'));
		$this->log("Files downloaded to /tmp/" . $this -> yesterday . "/\n");
		//End of downloading onedot files
		$this->setVal("path", "/tmp/{$this->yesterday}");

	} //End of Download

	//Parse - extracts needed data from downloaded onedot files
	function Parse() {
		//TODO: move to model
		$config = new Config();
		$this->wantedDomains = $config -> getDomains();
		
		$this->log(shell_exec('rm -r ' . $this -> splitDIR));
		
		$this->log("Starting parsing part\n");

		$dir = "/tmp/" . $this -> yesterday . "/";
		$handle = opendir($dir);

		$this->log("Dir with files: " . $dir . "\n");
		$this->log(shell_exec('mkdir ' . $this -> splitDIR));
		$this->log("Domains to filter out:\n");
		foreach($this->wantedDomains as $domain) {
			$this->log("  " . $domain . "\n");
		}
		$this->log("Folder created " . $this -> splitDIR . "\n");

		while(false !== ($file = readdir($handle))) {

			if($file != "." && $file != "..") {
				$fileHandle = fopen($dir . $file, "r");
				while(!feof($fileHandle)) {
					$wholeLine = explode("&", fgets($fileHandle));
					foreach($wholeLine as $param) {
						$parameters = explode("=", $param);
						$value = $parameters[1];
						switch($parameters[0]) {
							case "c" :
								$helpc = $value;
								break;
							case "r" :
								$helpr = $value;
								break;
							case "a" :
								$helpa = $value;
								break;
							case "lv" :
								$helplv = $value;
								break;
						}

					}

					foreach($this->wantedDomains as $domain) {
						$hasWikiPrefix = strpos($domain, '.wikia.com');
						$mainURL = ($hasWikiPrefix ? fixURL('http://' . $domain . '/') : fixURL('http://www.' . $domain . '/'));
						if(strpos($helpr, $mainURL) === 0) {
							if($hasWikiPrefix) {
								$articleName = str_ireplace($mainURL . 'wiki/', '', $helpr);
							} else {
								$articleName = str_ireplace($mainURL, '', $helpr);
							}
							//echo urldecode($articleName) . "\n";
							$title = Title::newFromText(rawurlencode($articleName));
							if($title -> exists()) {
								$titleID = $title -> getArticleID();
								//echo $titleID;
								file_put_contents($this -> splitDIR . $domain, serialize( array("a" => $helpa, "c" => $helpc, "rID" => $titleID, "lv" => $helplv)) . "\n", FILE_APPEND);

							}
						}
					}
				}
				fclose($fileHandle);
				$this->log("File " . $file . " has been parsed\n");
			}
		}
	}	// End of Parse

	//Always clean after your dog
	function Clean() {
		$this->log("Removing all temporary files\n");
		//TODO: check if it can delete folders at the begning of downloading
		if(isEmptyFolder($this -> splitDIR)) {
			$this->log("Folder " . $this -> splitDIR . " is empty. Probably Onedot files were not downloaded\n");
			$this->log(shell_exec('rm -r ' . $this -> splitDIR));
			$this->log(shell_exec('rm -r /tmp/' . $this -> yesterday . "/"));
			$this->log("The script should be run once again");
		} else {
			$this->log("It seems that result were saved to " . $this -> splitDIR . ". Deleting tmp folder for Onedot files\n");
			$this->log(shell_exec('rm -r /tmp/' . $this -> yesterday . "/"));
		}

	}//End of cleaning after your dog
}
