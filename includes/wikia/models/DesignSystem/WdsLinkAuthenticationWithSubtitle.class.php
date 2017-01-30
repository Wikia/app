<?php

class WdsLinkAuthenticationWithSubtitle extends WdsLinkAuthentication {
	use WdsSubtitleTrait;

	public function jsonSerialize() {
		$result = parent::jsonSerialize();
		$result['subtitle'] = $this->subtitle;

		return $result;
	}
}
