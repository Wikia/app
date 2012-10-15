<?php
/**
 * Copyright (c) 2011 ScientiaMobile, Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Refer to the COPYING file distributed with this package.
 *
 * @category   WURFL
 * @package    WURFL_Handlers_Matcher
 * @copyright  ScientiaMobile, Inc.
 * @license    GNU Affero General Public License
 * @version    $id$
 */
/**
 * WURFL Reduction in String user agent matcher.
 * This User Agent Matcher uses its match() method to find a matching user agent by
 * removing characters from the right side of the User Agents one-by-one until either
 * a match is found, or the string length is lower than the specified tolerance.
 * @see match()
 * @package    WURFL_Handlers_Matcher
 */
class WURFL_Handlers_Matcher_RISMatcher implements WURFL_Handlers_Matcher_Interface {

	/**
	 * Instance of WURFL_Handlers_Matcher_LDMatcher
	 * @var WURFL_Handlers_Matcher_LDMatcher
	 */
	private static $instance;

	/**
	 * Returns an instance of the RISMatcher singleton
	 * @return WURFL_Handlers_RISMatcher
	 */
	public static function INSTANCE() {
		if (self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function match(&$collection, $needle, $tolerance) {
		$match = NULL;
		$bestDistance = 0;
		$low = 0;
		$high = sizeof ( $collection ) - 1;
		$bestIndex = 0;
		while ( $low <= $high ) {
			$mid = round ( ($low + $high) / 2 );
			$find = $collection [$mid];
			$distance = $this->longestCommonPrefixLength ( $needle, $find );
			if ($distance > $bestDistance) {
				$bestIndex = $mid;
				$match = $find;
				$bestDistance = $distance;
			}

			$cmp = strcmp ( $find, $needle );
			if ($cmp < 0) {
				$low = $mid + 1;
			} elseif ($cmp > 0) {
				$high = $mid - 1;

			} else {
				break;
			}
		}

		if ($bestDistance < $tolerance) {
			return NULL;
		}
		if($bestIndex == 0) {
			return $match;
		}
		return $this->firstOfTheBests ( $collection, $needle, $bestIndex, $bestDistance );
	}

	private function firstOfTheBests($collection, $needle, $bestIndex, $bestDistance) {

		while($bestIndex > 0 && $this->longestCommonPrefixLength ( $collection [$bestIndex-1], $needle ) == $bestDistance) {
			$bestIndex = $bestIndex - 1;
		}
		return $collection [$bestIndex];
	}

	private function longestCommonPrefixLength($s, $t) {
		$length = min ( strlen ( $s ), strlen ( $t ) );

		$i = 0;
		while ( $i < $length ) {
			if ($s [$i] !== $t [$i]) {
				break;
			}
			$i ++;

		}

		return $i;

	}
}

