<?php

class SassFilterCssImports {

	protected $rootDir;

	public function __construct( $rootDir ) {
		$this->rootDir = $rootDir;
	}

	public function apply( $contents ) {
		wfProfileIn(__METHOD__);

		$matches = array();
		$importRegexOne = "/@import ['\\\"]([^\\n]*\\.css)['\\\"]([^\\n]*)(\\n|$)/is"; // since this stored is in a string, remember to escape quotes, slashes, etc.
		$importRegexTwo = "/@import url[\\( ]['\\\"]?([^\\n]*\\.css)['\\\"]?[ \\)]([^\\n]*)(\\n|$)/is";
		while ((0 < preg_match_all($importRegexOne, $contents, $matches, PREG_SET_ORDER)) || (0 < preg_match_all($importRegexTwo, $contents, $matches, PREG_SET_ORDER))) {
			foreach($matches as $match) {
				$lineMatched = $match[0];
				$fileName = trim($match[1]);
				$fileContents = file_get_contents($this->rootDir . $fileName);
				$contents = str_replace($lineMatched, $fileContents, $contents);
			}
		}

		wfProfileOut(__METHOD__);

		return $contents;
	}

}