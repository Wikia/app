<?php

/**
 * Class WikiListConditioner
 *
 * Interface providing ways to differentiate between regular wiki list
 * for Home Page and variations like Collections lists
 */
interface WikiListConditioner {

	/**
	 * @return array
	 */
	public function getCondition();

	/**
	 * @param $isPromoted boolean
	 * @return boolean
	 */
	public function getPromotionCondition( $isPromoted );
}
