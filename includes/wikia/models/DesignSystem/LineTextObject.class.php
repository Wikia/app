<?php

class LineTextObject {
	use WdsTitleTrait;

	const TYPE = 'line-text';

	public function get() {
		return [
			'type' => self::TYPE,
			'title' => $this->title
		];
	}
}