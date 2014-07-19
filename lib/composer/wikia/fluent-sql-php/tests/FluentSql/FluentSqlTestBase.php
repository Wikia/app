<?php
/**
 * TestHelper
 *
 * <insert description here>
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace FluentSql;

abstract class FluentSqlTestBase extends \PHPUnit_Framework_TestCase {
	public static function assertEquals($expected, $actual, $message='', $delta=0, $maxDepth=10, $canonicalizeEol=false, $ignoreCase=false) {
		$sanitizedExpected = self::sanitize($expected);
		$sanitizedActual = self::sanitize($actual);

		parent::assertEquals($sanitizedExpected, $sanitizedActual, $message, $delta, $maxDepth, $canonicalizeEol, $ignoreCase);
	}

	private static function sanitize($input) {
		return strtolower(trim(preg_replace('/\s+/', ' ', $input)));
	}
}
