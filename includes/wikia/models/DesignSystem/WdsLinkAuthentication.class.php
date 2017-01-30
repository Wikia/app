<?php

class WdsLinkAuthentication implements JsonSerializable {
	use WdsTitleTrait;
	use WdsLinkTrait;
	use WdsTrackingLabelTrait;

	public $type = 'link-authentication';
	public $paramName;

	public function setParamName( $paramName ) {
		$this->paramName = $paramName;

		return $this;
	}

	// needed to implement this method in order to return 'param-name' as a key
	public function jsonSerialize() {
		return [
			'type' => $this->type,
			'title' => $this->title,
			'href' => $this->href,
			'param-name' => $this->paramName,
			'tracking_label' => $this->tracking_label,
		];
	}
}
