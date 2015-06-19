<?php

namespace Wikia\PortableInfobox\Helpers;

/**
 * Class PortableInfoboxDataBag
 * @package Wikia\PortableInfobox\Helpers
 */
class PortableInfoboxDataBag {
	private static $instance = null;
	private $galleries = [ ];

	private function __construct() {
	}

	/**
	 * @return null|PortableInfoboxDataBag
	 */
	public static function getInstance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function setGallery( $marker, $content ) {
		$this->galleries[$marker] = $content;
	}

	public function getGallery( $marker ) {
		if(isset($this->galleries[$marker])) {
			return $this->galleries[$marker];
		} else {
			return null;
		}
	}
}
