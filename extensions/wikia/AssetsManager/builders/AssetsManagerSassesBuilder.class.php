<?php

/**
 * @author macbre
 */

class AssetsManagerSassesBuilder extends AssetsManagerBaseBuilder {

	public function __construct(WebRequest $request) {
		parent::__construct($request);

		$files = explode(',', $this->mOid);

		foreach($files as $file) {
			// fake single SASS file request
			$sassRequest = new WebRequest();

			$sassRequest->setVal('type', 'sass');
			$sassRequest->setVal('oid', $file);

			$builder = new AssetsManagerSassBuilder($sassRequest);

			$this->mContent .= "\n\n/* $file */\n" . $builder->getContent();
		}

		$this->mContentType = AssetsManager::TYPE_CSS;
	}

	// no need to compress concatenated content once more
	public function getContent( $processingTimeStart = null ) {
		return trim($this->mContent);
	}
}
