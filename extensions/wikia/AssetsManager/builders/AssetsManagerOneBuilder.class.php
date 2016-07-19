<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsManagerOneBuilder extends AssetsManagerBaseBuilder {

	/**
	 * @param WebRequest $request
	 * @throws Exception
	 */
	public function __construct(WebRequest $request) {
		parent::__construct($request);

		global $IP;

		if(strpos($this->mOid, '..') !== false) {
			throw new InvalidArgumentException('File path must not contain \'..\'.');
		}

		if(endsWith($this->mOid, '.js', false)) {
			$this->mContentType = AssetsManager::TYPE_JS;
		} else if(endsWith($this->mOid, '.css', false)) {
			$this->mContentType = AssetsManager::TYPE_CSS;
		} else {
			throw new InvalidArgumentException('Requested file must be .css or .js.');
		}

		$filePath = $IP . '/' . $this->mOid;

		if (file_exists($filePath)) {
			$this->mContent = file_get_contents($filePath);
		}
		else {
			throw new Exception('File does not exist');
		}
	}
}
