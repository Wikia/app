<?php

/**
 * Class to parse and reformat dates according to a specific
 * user preference
 *
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * Please see the LICENCE file for terms of use and redistribution
 */
class DateParser {

	const PREF_NONE = 0;
	const PREF_DMY = 1;
	const PREF_MDY = 2;
	const PREF_YMD = 3;
	const PREF_ISO = 4;

	private $lang = false;
	private $pref = self::PREF_NONE;
	
	private $holders = array();
	private $unique = '';
	
	/**
	 * Constructor
	 *
	 * @param $lang Language object to use (for month names)
	 * @param $pref Preference constant to reformat for
	 */
	public function __construct( $lang, $pref ) {
		$this->lang = $lang;
		$this->pref = $pref;
	}
	
	/**
	 * Reformat all recognised dates in $text to the
	 * appropriate preference format
	 *
	 * @param $text Text containing date strings
	 * @return string
	 */
	public function reformat( $text ) {
		wfProfileIn( __METHOD__ );
		if( $this->pref > self::PREF_NONE ) {
			$this->initialise( $text );
			foreach( $this->getRegexes() as $regex => $extract ) {
				if( preg_match_all( $regex, $text, $matches, PREG_SET_ORDER ) ) {
					foreach( $matches as $match ) {
						$replace = $this->strip( $this->format( $match, $extract ) );
						$text = preg_replace( '!' . $match[0] . '!', $replace, $text );
					}
				}
			}
			$text = $this->unstrip( $text );
		}
		wfProfileOut( __METHOD__ );
		return $text;
	}
	
	/**
	 * Format a date into the appropriate preference
	 *
	 * @param $details Information about the date
	 * @param $extract Information about the information ;)
	 * @return string
	 */
	private function format( $details, $extract ) {
		$date = new FormattableDate( $this->lang, $details, $extract );
		return $date->format( $this->pref );
	}
	
	/**
	 * Get regular expressions for recognised input
	 * formats, mapped to extraction order
	 *
	 * @return array
	 */
	private function getRegexes() {
		return array(
			# DMY
			'!(\d{1,2}) (' . $this->getMonths() . '),? (\d{4})!iu' => array( 'd' => 1, 'F' => 2, 'y' => 3 ),
			# YDM
			'!(\d{4}),? (\d{1,2}) (' . $this->getMonths() . ')!iu' => array( 'y' => 1, 'd' => 2, 'F' => 3 ),
			# MDY
			'!(' . $this->getMonths() . ') (\d{1,2}),? (\d{4})!iu' => array( 'd' => 2, 'F' => 1, 'y' => 3 ),
			# YMD
			'!(\d{4}),? (' . $this->getMonths() . ') (\d{1,2})!iu' => array( 'd' => 3, 'F' => 2, 'y' => 1 ),
			# DM
			'!(\d{1,2}) (' . $this->getMonths() . ')!iu' => array( 'd' => 1, 'F' => 2 ),
			# MD
			'!(' . $this->getMonths() . ') (\d{1,2})!iu' => array( 'F' => 1, 'd' => 2 ),
			# ISO
			'!(\d{4})-(\d{2})-(\d{2})!iu' => array( 'd' => 3, 'm' => 2, 'y' => 1 ),
		);
	}
	
	/**
	 * Get all valid month names and abbreviations
	 * as a partial regular expression
	 *
	 * @return array
	 */
	private function getMonths() {
		static $months = false;
		if( !$months ) {
			for( $i = 1; $i <= 12; $i++ ) {
				$words[] = preg_quote( $this->lang->getMonthName( $i ), '!' );
				$words[] = preg_quote( $this->lang->getMonthAbbreviation( $i ), '!' );
			}
			$months = implode( '|', $words );
		}
		return $months;
	}
	
	/**
	 * Initialise the unique string for the strip state
	 *
	 * @param $text Sample text
	 */
	private function initialise( $text ) {
		$this->unique = sha1( $text );
	}
	
	/**
	 * Prepare a placeholder for some text to be stripped
	 * and return it for later use
	 *
	 * @param $text Text to preserve
	 * @return string
	 */
	private function strip( $text ) {
		static $holders = 0;
		$placeholder = __CLASS__ . '_' . $this->unique . '_' . ++$holders;
		$this->holders[$placeholder] = $text;
		return $placeholder;
	}
	
	/**
	 * Resolve all placeholders to their represented strings
	 *
	 * @param $text Text to resolve
	 * @return string
	 */
	private function unstrip( $text ) {
		wfProfileIn( __METHOD__ );
		foreach( $this->holders as $placeholder => $value )
			$text = str_replace( $placeholder, $value, $text );
		wfProfileOut( __METHOD__ );
		return $text;
	}
	
	/**
	 * Convert a MediaWiki data preference string
	 * into one of our internal constants
	 *
	 * @param $pref Preference string
	 * @return int
	 */
	public static function convertPref( $pref ) {
		$prefs['dmy'] = self::PREF_DMY;
		$prefs['mdy'] = self::PREF_MDY;
		$prefs['ymd'] = self::PREF_YMD;
		$prefs['ISO 8601'] = self::PREF_ISO;
		return isset( $prefs[$pref] ) ? $prefs[$pref] : self::PREF_NONE;
	}

}

