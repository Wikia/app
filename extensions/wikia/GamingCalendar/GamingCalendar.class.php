<?php
/**
 * @brief A notification module for gaming wikis that allows users to quickly review a snapshot of upcoming game releases.
 * @author Michał Roszka <michal@wikia-inc.com>
 * @author Will Lee <wlee@wikia-inc.com>
 */
class GamingCalendar {
	private static $ENTRY_PREFIX = 'gamingcalendar-';
	private static $ENTRY_DATE_FORMAT = 'Ymd';
	private static $ENTRY_TITLE_MARKER = '* ';
	private static $ENTRY_ATTRIBUTE_MARKER = '** ';
	private static $ENTRY_SYSTEMS_MARKER = 'SYSTEMS:';
	private static $ENTRY_DESCRIPTION_MARKER = 'DESCRIPTION:';
	private static $ENTRY_IMAGE_MARKER = 'IMAGE:';
	private static $ENTRY_MOREINFO_MARKER = 'MOREINFO:';
	private static $ENTRY_PREORDER_MARKER = 'PREORDER:';
	
	/**
	 *
	 * @param int $startDate Unix timestamp
	 * @param int $endDate Unix timestamp
	 * @return array of GamingCalendarEntry
	 */
	public static function loadEntries($startDate, $endDate) {
		$entries = array();
		
		$SECS_IN_ONE_DAY = 86400;
		$MAX_RANGE_IN_SECS = 30*$SECS_IN_ONE_DAY;
		
		// validate 
		if ($endDate - $startDate > $MAX_RANGE_IN_SECS) {
			$endDate = $startDate + $MAX_RANGE_IN_SECS;
		}

		for ($i=$startDate; $i<=$endDate; $i+=$SECS_IN_ONE_DAY) {
			$msgKey = self::getEntryKey($i);
			$msg = wfMsgForContent($msgKey);
			if (!wfEmptyMsg($msgKey, $msg)) {
				$newEntries = self::parseMessageForEntries($msg, $i);
				if (sizeof($newEntries)) {
					$entries = array_merge($entries, $newEntries);
				}
			}
		}

		return $entries;
	}
		
	/**
	 *
	 * @param int $date Unix timestamp
	 * @return string
	 */
	private static function getEntryKey($date) {
		return self::$ENTRY_PREFIX . date(self::$ENTRY_DATE_FORMAT, $date);
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
			}
			elseif (startsWith($line, self::$ENTRY_ATTRIBUTE_MARKER)) {
				$attrib = trim( substr($line, strlen(self::$ENTRY_ATTRIBUTE_MARKER)) );
				if (startsWith($attrib, self::$ENTRY_SYSTEMS_MARKER)) {
					$entry->setSystems( explode(',', trim(substr($attrib, strlen(self::$ENTRY_SYSTEMS_MARKER))) ) );
				}
				elseif (startsWith($attrib, self::$ENTRY_DESCRIPTION_MARKER)) {
					$entry->setDescription( trim(substr($attrib, strlen(self::$ENTRY_DESCRIPTION_MARKER))) );
				}
				elseif (startsWith($attrib, self::$ENTRY_IMAGE_MARKER)) {
					$imageParts = explode('|', trim(substr($attrib, strlen(self::$ENTRY_IMAGE_MARKER))) );
					$entry->setImageSrc($imageParts[0]);
					if ($imageParts[1]) {
						$entry->setImageWidth(str_replace('px', '', $imageParts[1]));
					}
				}
				elseif (startsWith($attrib, self::$ENTRY_MOREINFO_MARKER)) {
					$entry->setMoreInfoUrl( trim(substr($attrib, strlen(self::$ENTRY_MOREINFO_MARKER))) );
				}
				elseif (startsWith($attrib, self::$ENTRY_PREORDER_MARKER)) {
					$entry->setPreorderUrl( trim(substr($attrib, strlen(self::$ENTRY_PREORDER_MARKER))) );
				}
			}
		}
		if ($entry->getGameTitle()) {
			$entries[] = $entry->toArray();
		}

		return $entries;
	}
}