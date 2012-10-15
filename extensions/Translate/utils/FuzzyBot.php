<?php
/**
 * Do it all maintenance account
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2012, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2 or later
 */

/**
 * FuzzyBot - the misunderstood workhorse.
 * @since 2012-01-02
 */
class FuzzyBot {
	public static function getUser() {
		$bot = User::newFromName( self::getName() );
		if ( $bot->isAnon() ) {
			$bot->addToDatabase();
		}
		return $bot;
	}

	public static function getName() {
		global $wgTranslateFuzzyBotName;
		return $wgTranslateFuzzyBotName;
	}
}