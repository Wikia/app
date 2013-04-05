<?php

class SassFilterCdnRewrite {

	protected $cdnUrl;
	public function __construct( $cdnUrl ) {
		$this->cdnUrl = $cdnUrl;
	}

	public function process( $contents ) {
		wfProfileIn(__METHOD__);

		if (strpos($contents, "wgCdnStylePath") !== false) { // faster to skip the regex in most cases
			// Because of fonts in CSS, we have to allow for lines with multiple url()s in them.
			// This will rewrite all but the last URL on the line (the last regex will fix the final URL and remove the special comment).
			$wasChanged = true;

			// TODO: refactor?
			while($wasChanged) {
				$changedCss = preg_replace("/([\(][\"']?)(\/[^\n]*?)([, ]url[^\n]*?)(\s*\/\*\s*[\\\$]?wgCdnStylePath\s*\*\/)/is", '\\1'.$this->cdnUrl.'\\2\\3\\4', $contents);
				if($changedCss != $contents) {
					$wasChanged = true;
					$contents = $changedCss;
				} else {
					$wasChanged = false;
				}
			}

			$contents = preg_replace("/([\(][\"']?)(\/[^\n]*?)\s*\/\*\s*[\\\$]?wgCdnStylePath\s*\*\//is", '\\1'.$this->cdnUrl.'\\2', $contents);
		}

		wfProfileOut(__METHOD__);

		return $contents;
	}

}