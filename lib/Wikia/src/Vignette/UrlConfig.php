<?php
/**
 * UrlConfig
 *
 * config to generate
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Vignette;


class UrlConfig {
	protected $isArchive = false;
	protected $replaceThumbnail = false;
	protected $timestamp;
	protected $relativePath;
	protected $pathPrefix;
	protected $bucket;
	protected $baseUrl;

	public function setIsArchive($isArchive) {
		$this->isArchive = $isArchive;
		return $this;
	}

	public function setReplaceThumbnail($replace) {
		$this->replaceThumbnail = $replace;
		return $this;
	}

	public function setTimestamp($timestamp) {
		$this->timestamp = $timestamp;
		return $this;
	}

	public function setRelativePath($relativeUrl) {
		$this->relativePath = $relativeUrl;
		return $this;
	}

	public function setPathPrefix($languageCode) {
		$this->pathPrefix = $languageCode;
		return $this;
	}

	public function setBucket($bucket) {
		$this->bucket = $bucket;
		return $this;
	}

	public function setBaseUrl($baseUrl) {
		$this->baseUrl = $baseUrl;
		return $this;
	}

	public function isArchive() {
		return $this->isArchive;
	}

	public function replaceThumbnail() {
		return $this->replaceThumbnail;
	}

	public function timestamp() {
		return $this->timestamp;
	}

	public function relativePath() {
		return $this->relativePath;
	}

	public function pathPrefix() {
		return $this->pathPrefix;
	}

	public function bucket() {
		return $this->bucket;
	}

	public function baseUrl() {
		return $this->baseUrl;
	}
}
