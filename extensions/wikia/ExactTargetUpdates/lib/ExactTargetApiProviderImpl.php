<?php

namespace Wikia\ExactTarget;

class ExactTargetApiProviderImpl implements ExactTargetApiProvider {

	/**
	 * Returns an instance of ExactTargetApiDataExtension class
	 * @return ExactTargetApiDataExtension
	 */
	public function getApiDataExtension() {
		return new ExactTargetApiDataExtension();
	}

}
