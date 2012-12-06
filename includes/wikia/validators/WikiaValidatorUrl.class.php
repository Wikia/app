<?php

	class WikiaValidatorUrl extends WikiaValidatorRegex {

		protected function config( array $options = array() ) {
			$this->setOption('pattern', '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/i' );
		}

	}

