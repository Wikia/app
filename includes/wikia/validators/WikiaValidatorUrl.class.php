<?php

	class WikiaValidatorUrl extends WikiaValidatorRegex {
		const URL_REGEX = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-\?#]*)*\/?$/i';

		protected function config( array $options = array() ) {
			$this->setOption('pattern', self::URL_REGEX);
		}

	}

