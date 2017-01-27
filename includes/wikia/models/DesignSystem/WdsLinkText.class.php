<?php

class WdsLinkText {
	use WdsTitleTrait;
	use WdsLinkTrait;

	const TYPE = 'link-text';

	public function get() {
		return [
			'type' => self::TYPE,
			'title' => $this->title,
			'href' => $this->href,
			'tracking_label' => $this->trackingLabel
		];
	}
}
