<?php

class WdsSvgObject {
	const TYPE = 'wds-svg';
	private $name;

	public function __construct( $name ) {
		$this->name = $name;
	}

	public function get() {
		return [
			'type' => self::TYPE,
			'name' => $this->name,
		];
	}
}