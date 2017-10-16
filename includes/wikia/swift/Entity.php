<?php

namespace Wikia\Swift\Entity;

use Wikia\Swift\File\Md5Cache;

class Local {
	protected $localPath;
	protected $metadata;
	protected $mimeType;
	protected $exists;
	protected $md5;
	protected $size;

	public function __construct( $localPath, $metadata, $mimeType, $exists = null, $md5 = null, $size = null ) {
		$this->localPath = $localPath;
		$this->metadata = $metadata;
		$this->mimeType = $mimeType;
		$this->exists = $exists;
		$this->md5 = $md5;
		$this->size = $size;
	}
	public function getLocalPath() { return $this->localPath; }
	public function getMetadata() { return $this->metadata; }
	public function getMimeType() { return $this->mimeType; }

	public function exists() { return $this->exists; }
	public function getMd5() { return $this->md5; }
	public function getSize() { return $this->size; }

	public function load() {
		$this->loadExists();
		$this->loadSize();
		$this->loadMd5();
	}

	public function loadExists() {
		if ( $this->exists === null ) { $this->exists = is_file($this->localPath); }
	}
	public function loadSize() {
		if ( $this->size === null ) { $this->size = filesize($this->localPath); }
	}
	public function loadMd5() {
		if ( $this->md5 === null ) {
			$this->md5 = Md5Cache::getInstance()->get($this->localPath);
		}
	}
}

class Remote {
	protected $remotePath;
	protected $md5;
	protected $size;

	public function __construct( $remotePath, $md5 = null, $size = null ) {
		$this->remotePath = $remotePath;
		$this->md5 = $md5;
		$this->size = $size;
	}
	public function getRemotePath() { return $this->remotePath; }
	public function getMd5() { return $this->md5; }
	public function getSize() { return $this->size; }

}

class Container {
	protected $name;
	public function __construct( $name ) {
		$this->name = $name;
	}
	public function getName() { return $this->name; }
}