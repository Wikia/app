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
			Wikia::log(__METHOD__, false, "File doesn't exist - {$filePath} (URL: " . wfGetCurrentUrl(true /* $as_string */) . ")", true  /* always add to PHP log */);
		}
	}

}
