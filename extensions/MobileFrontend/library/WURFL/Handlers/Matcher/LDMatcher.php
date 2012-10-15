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
 * WURFL Levenshtein distance user agent matcher.
 * This User Agent Matcher uses the Levenshtein Distance algorithm to determine the
 * distance between to User Agents.  A tolerance is specified on the match() method
 * which limits the distance.  User Agents that match less than or equal to this
 * tolerance are consider to be a match;
 * @link http://en.wikipedia.org/wiki/Levenshtein_distance
 * @link http://www.php.net/manual/en/function.levenshtein.php
 * @see match()
 * @package    WURFL_Handlers_Matcher
 */
class WURFL_Handlers_Matcher_LDMatcher implements WURFL_Handlers_Matcher_Interface {
	
	/**
	 * Instance of WURFL_Handlers_Matcher_LDMatcher
	 * @var WURFL_Handlers_Matcher_LDMatcher
	 */
	private static $instance;
	
	/**
	 * Returns an instance of the LDMatcher singleton
	 * @return WURFL_Handlers_LDMatcher
	 */
	public static function INSTANCE() {
		if (self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function match(&$collection, $needle, $tolerance) {
		$best = $tolerance;
		$match = '';
		foreach ( $collection as $userAgent ) {
			if (abs ( strlen ( $needle ) - strlen ( $userAgent ) ) <= $tolerance) {
				$current = levenshtein($needle, $userAgent);
				if ($current <= $best) {
					$best = $current - 1;
					$match = $userAgent;
				}
			}
		}
		return $match;
	}
}

