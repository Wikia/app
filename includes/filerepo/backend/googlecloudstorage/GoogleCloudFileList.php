<?php

use Google\Cloud\Storage\StorageObject;
use Google\Cloud\Storage\ObjectIterator;

class GoogleCloudFileList implements Iterator {

	/**
	 * @var ObjectIterator<StorageObject>
	 */
	private $objectIterator;

	public function __construct( ObjectIterator $storageObject ) {
		$this->objectIterator = $storageObject;
	}

	public function current() {
		return $this->objectIterator->current()->name();
	}

	public function key() {
		return $this->objectIterator->key();
	}

	public function next() {
		return $this->objectIterator->next();
	}

	public function rewind() {
		return $this->objectIterator->rewind();
	}

	public function valid() {
		return $this->objectIterator->valid();
	}
}
