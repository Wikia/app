<?php

class ResourceLoaderScript {
	const TYPE_REMOTE = 'remote';
	const TYPE_LOCAL = 'local';
	const TYPE_INLINE = 'inline';

	/**
	 * The value is URL, file path or inline script
	 * @var string $value
	 */
	private $value;
	private $type;

	/**
	 * Set this type if the the value is URL for an file
	 * @return $this
	 */
	public function setTypeRemote() {
		$this->type = self::TYPE_REMOTE;
		return $this;
	}

	/**
	 * Set this type if the the value is local path to a file
	 * @return $this
	 */
	public function setTypeLocal() {
		$this->type = self::TYPE_LOCAL;
		return $this;
	}

	/**
	 * Set this type if the the value is an inline script
	 * @return $this
	 */
	public function setTypeInline() {
		$this->type = self::TYPE_INLINE;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param string $value
	 * @return ResourceLoaderScript
	 */
	public function setValue( $value ) {
		$this->value = $value;
		return $this;
	}
}
