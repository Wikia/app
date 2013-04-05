<?php

class SassFilterBase64 {

	protected $rootDir;

	public function __construct( $rootDir ) {
		$this->rootDir = $rootDir;
	}

	public function process( $contents ) {
		wfProfileIn(__METHOD__);

		$contents = preg_replace_callback("/([, ]url[^\n]*?)(\s*\/\*\s*base64\s*\*\/)/is",
			array( $this, 'processMatches' ), $contents);

		wfProfileOut(__METHOD__);

		return $contents;
	}

	protected function processMatches($matches) {
		$fileName = $this->rootDir . trim(substr($matches[1], 4, -1), '\'"() ');

		$encoded = $this->encodeFile($fileName);
		if ($encoded !== false) {
			return "url({$encoded});";
		}
		else {
			throw new Exception("/* Base64 encoding failed: {$fileName} not found! */");
		}
	}

	protected function encodeFile( $fileName ) {
		wfProfileIn(__METHOD__);

		if (!file_exists($fileName)) {
			wfProfileOut(__METHOD__);
			return false;
		}

		$ext = end(explode('.', $fileName));

		switch ($ext) {
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

}