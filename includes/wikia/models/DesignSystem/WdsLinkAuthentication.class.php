<?php

class WdsLinkAuthentication {
	use WdsTitleTrait;
	use WdsLinkTrait;
	use WdsTrackingLabelTrait;

	public $type = 'link-authentication';

	public function setParamName( $paramName ) {
		$this->{'param-name'} = $paramName;

		return $this;
	}
}
