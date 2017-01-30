<?php

class WdsTranslatableTextWithParams extends WdsTranslatableText {
	public $params;

	public function __construct( $key, $params ) {
		parent::__construct( $key );
		$this->params = $params;
	}
}
