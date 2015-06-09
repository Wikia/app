<?php

/**
 * @author macbre
 */

class AssetsManagerGroupsBuilder extends AssetsManagerBaseBuilder {

	public function __construct(WebRequest $request) {
		parent::__construct($request);

		$groups = explode(',', $this->mOid);

		foreach($groups as $groupName) {
			// fake request to a group
			$groupRequest = new WebRequest();

			$groupRequest->setVal('type', 'group');
			$groupRequest->setVal('oid', $groupName);

			$builder = new AssetsManagerGroupBuilder($groupRequest);

			$this->mContent .= "\n\n" . $builder->getContent();
			$this->mContentType = $builder->getContentType();
		}
	}

	// no need to compress concatenated content once more
	public function getContent( $processingTimeStart = null ) {
		return trim($this->mContent);
	}
}
