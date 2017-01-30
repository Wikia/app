<?php

/**
 * Created by PhpStorm.
 * User: ryba
 * Date: 30/01/2017
 * Time: 12:10
 */
class WdsLinkAuthenticationWithSubtitle extends WdsLinkAuthentication {
	use WdsSubtitleTrait;

	public function jsonSerialize() {
		$result = parent::jsonSerialize();
		$result['subtitle'] = $this->subtitle;

		return $result;
	}
}