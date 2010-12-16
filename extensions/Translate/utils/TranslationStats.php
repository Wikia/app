<?php
/**
 * Class which offers functionality for statistics reporting.
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @author Siebrand Mazeland
 * @copyright Copyright © 2010, Niklas Laxström, Siebrand Mazeland
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
class TranslationStats {
	/**
	 * Returns translated percentage for message group in given
	 * languages
	 *
	 * @param $group String: Unique key identifying the group
	 * @param $languages Array: array of language codes
	 * @param $threshold Int: Minimum required percentage translated to
	 * return. Other given language codes will not be returned.
	 * @param $simple Bool: Return only codes or code/pecentage pairs
	 *
	 * @return Array: array of key value pairs code (string)/percentage
	 * (float) or array of codes, depending on $simple
	 */
	// FIXME: add ability to return fuzzy percentage.
	public static function getPercentageTranslated( $group, $languages, $threshold = false, $simple = false ) {
		$stats = array();

		$g = MessageGroups::singleton()->getGroup( $group );

		$collection = $g->initCollection( 'en' );
		foreach ( $languages as $code ) {
			$collection->resetForNewLanguage( $code );
			// Initialise messages
			$collection->filter( 'ignored' );
			$collection->filter( 'optional' );
			// Store the count of real messages for later calculation.
			$total = count( $collection );
			$collection->filter( 'translated', false );
			$translated = count( $collection );

			$translatedPercentage = ( $translated * 100 ) / $total;
			if ( $translatedPercentage >= $threshold ) {
				if ( $simple ) {
					$stats[] = $code;
				} else {
					$stats[$code] = $translatedPercentage;
				}
			}
		}

		return $stats;
	}
}
