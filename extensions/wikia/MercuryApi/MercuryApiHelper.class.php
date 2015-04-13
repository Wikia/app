<?php

class MercuryApiHelper {

	/**
	 * Check if a string is a valid article title
	 *
	 * @param string $title
	 * @return bool
	 */
	public static function isTitleStringValid( $title ) {
		return !is_null( $title ) && trim( $title ) !== '';
	}
}
