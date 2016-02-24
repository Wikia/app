<?php

namespace Wikia\AbPerformanceTesting;

abstract class Criterion {
	/**
	 * Does given criterion applies in the current context?
	 *
	 * @param int|array $bucket wiki bucket ID or range to check
	 * @return boolean
	 */
	abstract function matches( $bucket );

	/**
	 * Check if the given bucket $value is the one we expect.
	 *
	 * Examples:
	 *  isInBucket( 1, 1 ) => true
	 *  isInBucket( 1, 2 ) => false
	 *  isInBucket( 1, [1, 10] ) => true (range matching)
	 *
	 * @param $value the bucket value to check
	 * @param int|array $expected the expected bucket value or range (as an array - e.g. [1, 10])
	 * @return boolean
	 */
	protected function isInBucket( $value, $expected ) {
		if ( is_array( $expected ) ) {
			list( $min, $max ) = $expected;
			return ( $value >= $min ) && ( $value <= $max );
		}
		else {
			return $value === $expected;
		}
	}

	/**
	 * Returns an instance of a given criterion
	 *
	 * @param string $criterionName
	 * @return Criterion
	 */
	static function factory( $criterionName ) {
		$className = sprintf( 'Wikia\\AbPerformanceTesting\\Criteria\\%s', ucfirst(  $criterionName ) );

		if ( !class_exists( $className ) ) {
			throw new UnknownCriterionException( sprintf( 'Criterion "%s" does not exist', $criterionName ) );
		}

		return new $className;
	}
}
