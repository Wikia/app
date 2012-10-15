<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsManagerOneBuilder extends AssetsManagerBaseBuilder {

	public function __construct(WebRequest $request) {
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
			$requestDetails = AssetsManager::getRequestDetails();
			Wikia::log(__METHOD__, false, "file '{$filePath}' doesn't exist ({$requestDetails})", true /* $always */);
			throw new Exception('File does not exist');
		}
	}
}
