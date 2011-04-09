<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

class AssetsManagerBaseBuilder {

	protected $mOid;
	protected $mType;
	protected $mParams;
	protected $mCb;

	protected $mContent;
	protected $mContentType;

	public function __construct($request) {
		$this->mType = $request->getText('type');
		$this->mOid = $request->getText('oid');
		parse_str(urldecode($request->getText('params')), $this->mParams);
		$this->mCb = $request->getInt('cb');
	}

	public function getContent() {
		return $this->mContent;
	}

	public function getCacheDuration() {
		global $wgStyleVersion;
		if($this->mCb > $wgStyleVersion) {
			return 10 * 60; // 10 minutes
		} else {
			return 7 * 24 * 60 * 60; // 7 days
		}
	}

	public function getContentType() {
		return $this->mContentType;
	}
}
