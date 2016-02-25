<?php
/**
 * Provider interface for ExactTargetUpdate extension API objects.
 */

namespace Wikia\ExactTarget;

interface ExactTargetApiProvider {

	/**
	 * Returns an instance of ExactTargetApiDataExtension class
	 * @return ExactTargetApiDataExtension
	 */
	public function getApiDataExtension();

}
