<?php

class WdsLineText {
	use WdsTitleTrait;
	use WdsTrackingLabelTrait;

	const TYPE = 'line-text';

	public function get() {
		$result = [
			'type' => self::TYPE,
			'title' => $this->title
		];

		if ( isset( $this->trackingLabel ) ) {
			$result['tracking_label'] = $this->trackingLabel;
		}

		return $result;
	}
}
