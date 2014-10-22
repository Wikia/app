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
	protected $timestamp;
	protected $relativePath;
	protected $languageCode;
	protected $bucket;
	protected $baseUrl;
	protected $domainShardCount;

	public function setIsArchive($isArchive) {
		$this->isArchive = $isArchive;
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

	public function setLanguageCode($languageCode) {
		$this->languageCode = $languageCode;
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

	public function setDomainShardCount($domainShardCount) {
		$this->domainShardCount = $domainShardCount;
		return $this;
	}

	public function isArchive() {
		return $this->isArchive;
	}

	public function timestamp() {
		return $this->timestamp;
	}

	public function relativePath() {
		return $this->relativePath;
	}

	public function languageCode() {
		return $this->languageCode;
	}

	public function bucket() {
		return $this->bucket;
	}

	public function baseUrl() {
		return $this->baseUrl;
	}

	public function domainShardCount() {
		return $this->domainShardCount;
	}
}
