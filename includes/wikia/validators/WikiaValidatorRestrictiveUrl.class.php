<?php

/**
 * Validates URL but don't accept .xxx domains
 *
 * Class WikiaValidatorRestrictiveUrl
 */
class WikiaValidatorRestrictiveUrl extends WikiaValidatorUrl {
	const URL_RESTRICTIVE_REGEX = "/((https?|ftp)\:\/\/)?([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?([a-z0-9-.]*)(?!.*\.xxx)\.([a-z]{2,3})(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?/i"; // Anchor

	protected function config (array $options = array()) {
		$this->setOption('pattern', self::URL_RESTRICTIVE_REGEX);
	}
}

