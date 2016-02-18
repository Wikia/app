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

	/**
	 * Returns an instance of ExactTargetApiSubscriber class
	 * @return ExactTargetApiSubscriber
	 */
	public function getApiSubscriber() {
		return new ExactTargetApiSubscriber();
	}
}
