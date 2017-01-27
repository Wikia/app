<?php

class TranslatableTextObject {
	const TYPE = 'translatable-text';
	private $key;
	private $params;

	public function __construct( $key, $params = null ) {
		$this->key = $key;
		$this->params = $params;
	}

	public function get() {
		$result = [
			'type' => self::TYPE,
			'key' => $this->key
		];

		if ( !empty( $this->params ) ) {
			$result['params'] = $this->params;
		}

		return $result;
	}
}