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

		$this->mContentType = $this->resolveContentType($this->mOid);

		if(endsWith($this->mOid, '.js', false)) {
			$this->mContentType = AssetsManager::TYPE_JS;
		} else if(endsWith($this->mOid, '.css', false)) {
			$this->mContentType = AssetsManager::TYPE_CSS;
		} else {
			throw new Exception('Requested file must be .css or .js.');
		}

		$this->mContent = file_get_contents($IP . '/' . $this->mOid);
	}

}