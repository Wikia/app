<?php

namespace Wikia\JsonFormat\Simple;

class ImageNode {
	/**
	 * @var String
	 */
	private $url;

	/**
	 * @var String
	 */
	private $name;

	function __construct($name, $url) {
		$this->name = $name;
		$this->url = $url;
	}

	/**
	 * @param String $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return String
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param String $url
	 */
	public function setUrl($url) {
		$this->url = $url;
	}

	/**
	 * @return String
	 */
	public function getUrl() {
		return $this->url;
	}

}
