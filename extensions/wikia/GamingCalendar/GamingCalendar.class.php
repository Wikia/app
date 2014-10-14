<?php
/**
 * @brief A notification module for gaming wikis that allows users to quickly review a snapshot of upcoming game releases.
 * @author Michał Roszka <michal@wikia-inc.com>
 * @author Will Lee <wlee@wikia-inc.com>
 */
class GamingCalendar {
	public static $CALENDAR_TYPES = array();
	
	public static $ENTRY_TITLE_MARKER = '* ';
	public static $ENTRY_ATTRIBUTE_MARKER = '** ';
	public static $ENTRY_SYSTEMS_MARKER = 'SYSTEMS:';
	public static $ENTRY_PLATFORMS_MARKER = 'PLATFORMS: ';
	public static $ENTRY_RATING_MARKER = 'RATING: ';
	public static $ENTRY_DESCRIPTION_MARKER = 'DESCRIPTION:';
	public static $ENTRY_IMAGE_MARKER = 'IMAGE:';
	public static $ENTRY_MOREINFO_MARKER = 'MOREINFO:';
	public static $ENTRY_PREORDER_MARKER = 'PREORDER:';
	public static $ENTRY_ORDER_MARKER = 'ORDER:';
	public static $ENTRY_PREFIX = 'calendar-';
	private static $ENTRY_DATE_FORMAT = 'Ymd';
	
	const CACHE_KEY = 'cal';
	const CACHE_EXPIRY = 2700;

	/**
	 *
	 * @param int $startDate Number of weeks to start at, relative to this week
	 * @param int $weeks Number of weeks to return
	 * @return array of arrays of GamingCalendarEntry
	 */
	public static function loadEntries($offset = 0, $weeks = 2, $type=null, $startts=null, $encodeInWeeks=true) {
		global $wgMemc;

		$oneDay = 86400;

		$entries = array();
		$week = 0;

		if ($startts) {
			$thisWeekStart = $startts;
		}
		// determine the start of the current week
		elseif ( date( 'w' ) == 1 ) {
			$thisWeekStart = time();
		} else {
			$thisWeekStart = strtotime( 'last Monday' );
		}

		// adjust date if needed
		$adjustedDate = $thisWeekStart + $offset * 7 * $oneDay;

		$memcKey = wfMemcKey( self::getCacheKey($type), $adjustedDate, $weeks, intval($encodeInWeeks) ); 
		$entries = $wgMemc->get( $memcKey );
		if ( !empty( $entries ) ) {
			return $entries;
		}

		$date = $adjustedDate;

		for ( $i = 1; $i <= ( 7 * $weeks ); $i++ ) {
			if ($encodeInWeeks) {
				// initialize week
				if ( empty( $entries[$week] ) ) {
					$entries[$week] = array( 0 => self::getWeekDescription( $date ) );
				}
			}
			else {
				if ( !is_array( $entries ) ) {
					$entries = array();
				}
			}

			$msgKey = self::getEntryKey( $type, $date );
			$msg = wfMsgForContent($msgKey);
			if (!wfEmptyMsg($msgKey, $msg)) {
				$newEntries = self::parseMessageForEntries($msg, $date);
				if (!empty($newEntries)) {
					if ($encodeInWeeks) {
						$entries[$week] = array_merge( $entries[$week], $newEntries );
					}
					else {
						$entries = array_merge($entries, $newEntries);
					}
				}
			}

			if ( $i % 7 == 0 ) {
				$week++;
			}

			$date = $date + $oneDay;
		}

		$wgMemc->set( $memcKey, $entries, self::CACHE_EXPIRY );

		return $entries;
	}
	
	public static function loadEntriesForDate($type, $timestamp) {
		$entries = array();
		
		$msgKey = self::getEntryKey( $type, $timestamp );
		$msg = wfMsgForContent($msgKey);
		if (!wfEmptyMsg($msgKey, $msg)) {
			$entries = self::parseMessageForEntries($msg, $timestamp);
		}
		
		return $entries;
		
	}
	
	private static function getCacheKey($type=null) {
		global $wgCityId;
		
		if (!$type) {
			$type = WikiFactoryHub::getInstance()->getCategoryShort($wgCityId);			
		}
		
		return $type . self::CACHE_KEY;
	}
		
	/**
	 *
	 * @param int $date Unix timestamp
	 * @return string
	 */
	public static function getEntryKey($type, $date) {
		global $wgCityId;
		
		if (!$type) {
			$type = WikiFactoryHub::getInstance()->getCategoryShort($wgCityId);			
		}

		return $type . self::$ENTRY_PREFIX . date(self::$ENTRY_DATE_FORMAT, $date);
	}

	private static function getWeekDescription( $start ) {
		$end = $start + 6 * 86400;

		$week = array();

		$week['start'] = date( 'j<\s\u\p>S</\s\u\p>', $start );
		$week['end'] = date( 'j<\s\u\p>S</\s\u\p>', $end );

		$week['startmonth'] = date( 'M', $start );
		$week['endmonth'] = date( 'M', $end );
		if ( $week['startmonth'] == $week['endmonth'] ) {
			$week['endmonth'] = '';
		}

		switch ( date( 'YW', $start ) - date( 'YW' ) ) {
			case 0:
				$week['caption'] = 'This Week';
				break;
			case 1:
				$week['caption'] = 'Next Week';
				break;
			default:
				$week['caption'] = '';
				break;
		}

		return $week;
	}
	
	/**
	 *
	 * @param string $msg MW message
	 * @return array of GamingCalendarEntry 
	 */
	private static function parseMessageForEntries($msg, $releaseDate) {
		$entries = array();
		
		$entry = new GamingCalendarEntry($releaseDate);
		$lines = explode("\n", $msg);
		foreach ($lines as $line) {
			$line = trim($line);
			if (startsWith($line, self::$ENTRY_TITLE_MARKER)) {
				// found new entry
				
				// first, save old entry
				if ($entry->getGameTitle()) {
					$entries[] = $entry->toArray();
				}
				
				// init new entry
				$entry = new GamingCalendarEntry($releaseDate);
				$entry->setGameTitle( trim( substr($line, strlen(self::$ENTRY_TITLE_MARKER)) ) );
				$titleParts = explode('|', trim(substr($line, strlen(self::$ENTRY_TITLE_MARKER))) );
				$entry->setGameTitle($titleParts[0]);
				if (sizeof($titleParts) > 1) {
					$entry->setGameSubtitle($titleParts[1]);
				}
			}
			elseif (startsWith($line, self::$ENTRY_ATTRIBUTE_MARKER)) {
				$attrib = trim( substr($line, strlen(self::$ENTRY_ATTRIBUTE_MARKER)) );
				if (startsWith($attrib, self::$ENTRY_SYSTEMS_MARKER)) {
					$entry->setSystems( explode(',', trim(substr($attrib, strlen(self::$ENTRY_SYSTEMS_MARKER))) ) );
				}
				elseif (startsWith($attrib, self::$ENTRY_PLATFORMS_MARKER)) {	// SYSTEMS and PLATFORMS are synonyms
					$entry->setSystems( explode(',', trim(substr($attrib, strlen(self::$ENTRY_PLATFORMS_MARKER))) ) );
				}				
				elseif (startsWith($attrib, self::$ENTRY_RATING_MARKER)) {
					$entry->setRating( trim(substr($attrib, strlen(self::$ENTRY_RATING_MARKER))) );
				}
				elseif (startsWith($attrib, self::$ENTRY_DESCRIPTION_MARKER)) {
					$entry->setDescription( trim(substr($attrib, strlen(self::$ENTRY_DESCRIPTION_MARKER))) );
				}
				elseif (startsWith($attrib, self::$ENTRY_IMAGE_MARKER)) {
					$imageParts = explode('|', trim(substr($attrib, strlen(self::$ENTRY_IMAGE_MARKER))) );
					$entry->setImageSrc($imageParts[0]);
					if (sizeof($imageParts) > 1) {
						$entry->setImageWidth(str_replace('px', '', $imageParts[1]));
					}
				}
				elseif (startsWith($attrib, self::$ENTRY_MOREINFO_MARKER)) {
					$entry->setMoreInfoUrl( trim(substr($attrib, strlen(self::$ENTRY_MOREINFO_MARKER))) );
				}
				elseif (startsWith($attrib, self::$ENTRY_PREORDER_MARKER)) {
					$entry->setPreorderUrl( trim(substr($attrib, strlen(self::$ENTRY_PREORDER_MARKER))) );
				}
				elseif (startsWith($attrib, self::$ENTRY_ORDER_MARKER)) {	// PREORDER and ORDER are synonyms
					$entry->setPreorderUrl( trim(substr($attrib, strlen(self::$ENTRY_ORDER_MARKER))) );
				}
			}
		}
		if ($entry->getGameTitle()) {
			$entries[] = $entry->toArray();
		}

		return $entries;
	}
	
	public static function getCalendarTypes() {
		if (!empty(self::$CALENDAR_TYPES)) {
			return self::$CALENDAR_TYPES;
		}
		
		$categories = WikiFactoryHub::getInstance()->getCategories();
		foreach ($categories as $catData) {
			self::$CALENDAR_TYPES[$catData['short']] = $catData['name'];
		}
		
		return self::$CALENDAR_TYPES;
	}
	
	public static function getCalendarName($type) {
		self::getCalendarTypes();
		if (!empty(self::$CALENDAR_TYPES[$type])) {
			return self::$CALENDAR_TYPES[$type];
		}
		
		return null;
	}
}
