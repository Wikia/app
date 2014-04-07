<?php
/**
 * MathTask
 *
 * dummy math class for testing puposes
 *
 * @author Nelson Monterroso <nelson@wikia-inc.com>
 */

namespace Wikia\Tasks\Tasks;


class MathTask extends BaseTask {
	/**
	 * add two numbers together
	 *
	 * @param double $x some number to add
	 * @param double $y the other number to add
	 * @return double
	 */
	public function add($x, $y) {
		return $x + $y;
	}

	/**
	 * multiply two numbers together
	 * 
	 * @param double $x
	 * @param double $y
	 * @return double
	 */
	public function multiply($x, $y) {
		return $x*$y;
	}
} 