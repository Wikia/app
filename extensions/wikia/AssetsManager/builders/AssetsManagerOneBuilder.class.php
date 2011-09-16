<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsManagerOneBuilder extends AssetsManagerBaseBuilder {

	public function __construct($request) {
		parent::__construct($request);

		global $IP;

		if(strpos($this->mOid, '..') !== false) {
			throw new Exception('File path must not contain \'..\'.');
		}

		if(endsWith($this->mOid, '.js', false)) {
			$this->mContentType = AssetsManager::TYPE_JS;
		} else if(endsWith($this->mOid, '.css', false)) {
			$this->mContentType = AssetsManager::TYPE_CSS;
		} else {
			throw new Exception('Requested file must be .css or .js.');
		}

		$filePath = $IP . '/' . $this->mOid;

		if (file_exists($filePath)) {
			$this->mContent = file_get_contents($filePath);
		}
		else {
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '-';
			$userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '-';
			error_log("PHP Warning: " . __METHOD__ . " - File doesn't exist - {$filePath} (UA: {$userAgent}, referer: {$referer})");
		}
	}
}
