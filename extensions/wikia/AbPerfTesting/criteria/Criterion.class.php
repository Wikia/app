<?php

namespace Wikia\AbPerfTesting;

abstract class Criterion {
	/**
	 * Does given criterion applies in the current context?
	 *
	 * @param int $bucket bucket ID to check
	 * @return boolean
	 */
	abstract function applies($bucket);

	/**
	 * Returns an instance of a given criterion
	 *
	 * @param string $criterionName
	 * @return Criterion
	 */
	static function factory($criterionName) {
		$className = sprintf('Wikia\\AbPerfTesting\\Criteria\\%s', ucfirst(strtolower($criterionName)));

		if (!class_exists($className)) {
			throw new UnknownCriterionException( sprintf('Criterion "%s" does not exist', $criterionName) );
		}

		return new $className;
	}
}
