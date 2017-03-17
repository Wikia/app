<?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPUnit\Framework;

/**
 * Extension to PHPUnit_Framework_AssertionFailedError to mark the special
 * case of a skipped test suite.
 */
class SkippedTestSuiteError extends AssertionFailedError implements SkippedTest
{
}
