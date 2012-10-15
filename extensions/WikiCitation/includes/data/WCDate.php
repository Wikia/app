<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCDateNumber {
	const unknown   = 0;
	const day       = 1;
	const month     = 2;
	const year      = 3;
	const notDay    = 4;
	const notMonth  = 5;
	const notYear   = 6;

	public $key, $num;
	public $numType;
	public function __construct( $key, $num, $type = self::unknown ) {
		$this->key = $key;
		$this->num = $num;
		$this->numType = $type;
	}
	public function setDay( array &$unknowns, array &$days ) {
		switch ( $this->numType ) {
			case self::unknown:
			case self::notMonth:
			case self::notYear:
				$this->numType = self::day;
				unset( $unknowns[ $this->key ] );
				$days[ $this->key ] = $this->num;
				return;
			default:
				return;
		}
	}
	public function setMonth( array &$unknowns, array &$months ) {
		switch ( $this->numType ) {
			case self::unknown:
			case self::notDay:
			case self::notYear:
				$this->numType = self::month;
				unset( $unknowns[ $this->key ] );
				$months[ $this->key ] = $this->num;
				return;
			default:
				return;
		}
	}
	public function setYear( array &$unknowns, array &$years ) {
		switch ( $this->numType ) {
			case self::unknown:
			case self::notDay:
			case self::notMonth:
				$this->numType = self::year;
				unset( $unknowns[ $this->key ] );
				$years[ $this->key ] = $this->num;
				return;
			default:
				return;
		}
	}
	public function setNotDay( array &$unknowns, array &$months, array &$years ) {
		switch ( $this->numType ) {
			case self::unknown:
				$this->numType = self::notDay;
				return;
			case self::notMonth:
				$this->numType = self::year;
				unset( $unknowns[ $this->key ] );
				$years[ $this->key ] = $this->num;
				return;
			case self::notYear:
				$this->numType = self::month;
				unset( $unknowns[ $this->key ] );
				$months[ $this->key ] = $this->num;
				return;
			default:
				return;
		}
	}
	public function setNotMonth( array &$unknowns, array &$days, array &$years ) {
		switch ( $this->numType ) {
			case self::unknown:
				$this->numType = self::notMonth;
				return;
			case self::notDay:
				$this->numType = self::year;
				unset( $unknowns[ $this->key ] );
				$years[ $this->key ] = $this->num;
				return;
			case self::notYear:
				$this->numType = self::day;
				unset( $unknowns[ $this->key ] );
				$days[ $this->key ] = $this->num;
				return;
			default:
				return;
		}
	}
	public function setNotYear( array &$unknowns, array &$days, array &$months ) {
		switch ( $this->numType ) {
			case self::unknown:
				$this->numType = self::notYear;
				return;
			case self::notDay:
				$this->numType = self::month;
				unset( $unknowns[ $this->key ] );
				$months[ $this->key ] = $this->num;
				return;
			case self::notMonth:
				$this->numType = self::day;
				unset( $unknowns[ $this->key ] );
				$days[ $this->key ] = $this->num;
				return;
			default:
				return;
		}
	}

	public function isNotDay() {
		return $this->numType == WCDateNumber::month || $this->numType == WCDateNumber::year || $this->numType == WCDateNumber::notDay;
	}
	public function isNotMonth() {
		return $this->numType == WCDateNumber::day || $this->numType == WCDateNumber::year || $this->numType == WCDateNumber::notMonth;
	}
	public function isNotYear() {
		return $this->numType == WCDateNumber::day || $this->numType == WCDateNumber::month || $this->numType == WCDateNumber::notYear;
	}
	public function couldBeDay() {
		return $this->numType == WCDateNumber::day || $this->numType == WCDateNumber::unknown || $this->numType == WCDateNumber::notMonth || $this->numType == WCDateNumber::notYear;
	}
	public function couldBeMonth() {
		return $this->numType == WCDateNumber::month || $this->numType == WCDateNumber::unknown || $this->numType == WCDateNumber::notDay || $this->numType == WCDateNumber::notYear;
	}
	public function couldBeYear() {
		return $this->numType == WCDateNumber::year || $this->numType == WCDateNumber::unknown || $this->numType == WCDateNumber::notDay || $this->numType == WCDateNumber::notMonth;
	}

}

/**
 * Data structure WCDate.
 * Contains all information needed to be known about a title.
 */
class WCDate extends WCData {

	# The year, or beginning year of a range.
	public $year;

	# The end year of a range
	public $year2;

	# The era (AD, BC, etc.), or beginning era of a range. WCDateTermsEnum::AD, etc.
	public $era;

	# The end era of a range
	public $era2;

	# The month, or beginning month of a range.
	public $month;

	# The end month of a range
	public $month2;

	# The season, or beginning season of a range. WCDateTermsEnum::spring, etc.
	public $season;

	# The end season of a range
	public $season2;

	# The day, or beginning day of a range.
	public $day;

	# The end day of a range
	public $day2;

	/**
	 * Whether the date, or beginning of date range is uncertain
	 * @var boolean
	 */
	public $isUncertain;

	/**
	 * Whether the second date is uncertain
	 * @var boolean
	 */
	public $isUncertain2;

	/**
	 * Constructor.
	 * @param WCCitation $citation = the WCCitation object
	 * @param WCScopeEnum $scope = the scope (i.e., work, container, series, etc.)
	 * @param WCParameterEnum $type = the type of property.
	 * @param string date = the unprocessed date text.
	 */
	public function __construct( $date ) {

		# Separate into segments comprising numbers, letters, or special terms.
		$adTerms = MagicWord::get( WCDateTermsEnum::$magicWordKeys[ WCDateTermsEnum::AD ] )->getSynonyms();
		$bcTerms = MagicWord::get( WCDateTermsEnum::$magicWordKeys[ WCDateTermsEnum::BC ] )->getSynonyms();
		$circaTerms = MagicWord::get( WCDateTermsEnum::$magicWordKeys[ WCDateTermsEnum::circa ] )->getSynonyms();
		$options = implode( '|', array_merge( $adTerms, $bcTerms, $circaTerms ) );
		if ( !preg_match_all( '/'. $options . '|\p{N}+|\p{L}+|./uS', $date, $matches ) ) {
			$this->year           = 0;
			$this->era            = WCDateTermsEnum::AD;
			$this->month          = 0;
			$this->day            = 0;
			$this->isUncertain    = True;
			return;
		}

		$chunks = $matches[0];
		$numbers = $unknowns = array();
		$years = $months = $days = array();
		$eras = $seasons = $circas = $yearTerms = $monthTerms = $dayTerms = array();
		$counter = 0;

		foreach( $chunks as $chunk ) {
			# Match month names.
			$month = $this->matchMonths( $chunk ); # $month is integer >= 1 or False
			if ( $month && count( $months ) < 2 ) {
				$months[ $counter ] = $month;
				$numbers[ $counter++ ] = new WCDateNumber( $counter, $month, WCDateNumber::month );
				continue;
			}

			# Match date terms.
			$dateTermEnum = WCDateTermsEnum::match( $chunk, WCDateTermsEnum::$magicWordArray,
					WCDateTermsEnum::$flipMagicWordKeys, 'WCDateTermsEnum' );
			if ( $dateTermEnum ) {
				switch ( $dateTermEnum->key ) {
					case WCDateTermsEnum::AD:
						if ( count( $eras ) < 2 ) {
							$eras[ $counter++ ] = WCDateTermsEnum::AD;
						}
						continue 2;
					case WCDateTermsEnum::BC:
						if ( count( $eras ) < 2 ) {
							$eras[ $counter++ ] = WCDateTermsEnum::BC;
						}
						continue 2;
					case WCDateTermsEnum::spring:
						if ( count( $seasons ) < 2 ) {
							$seasons[ $counter++ ] = WCDateTermsEnum::spring;
						}
						continue 2;
					case WCDateTermsEnum::summer:
						if ( count( $seasons ) < 2 ) {
							$seasons[ $counter++ ] = WCDateTermsEnum::summer;
						}
						continue 2;
					case WCDateTermsEnum::autumn:
						if ( count( $seasons ) < 2 ) {
							$seasons[ $counter++ ] = WCDateTermsEnum::autumn;
						}
						continue 2;
					case WCDateTermsEnum::winter:
						if ( count( $seasons ) < 2 ) {
							$seasons[ $counter++ ] = WCDateTermsEnum::winter;
						}
						continue 2;
					case WCDateTermsEnum::year:
						if ( count( $yearTerms ) < 2 ) {
							$yearTerms[ $counter++ ] = WCDateTermsEnum::yearTerm;
						}
						continue 2;
					case WCDateTermsEnum::month:
						if ( count( $monthTerms ) < 2 ) {
							$monthTerms[ $counter++ ] = WCDateTermsEnum::monthTerm;
						}
						continue 2;
					case WCDateTermsEnum::day:
						if ( count( $dayTerms ) < 2 ) {
							$dayTerms[ $counter++ ] = WCDateTermsEnum::dayTerm;
						}
						continue 2;
					case WCDateTermsEnum::circa:
						if ( count( $circas ) < 2 ) {
							$circas[ $counter++ ] = WCDateTermsEnum::circa;
						}
						continue 2;
				}
			}

			# Check for roman numerals (month is often Roman in Hungary, Poland, Romania).
			$intTerm = $this->romanToInt( $chunk );
			# Convert to integer.
			if ( ! $intTerm ) {
				$intTerm = (integer) $chunk; # Note, this converts ordinals too.
				if ( ! $intTerm ) {
					# '00' cannot be month or day, so it must be the two-digit year 2000:
					if ( mb_substr( $chunk, 0, 2 ) == '00' ) {
						$numbers[ $counter ] = new WCDateNumber( $counter, 2000, WCDateNumber::year );
						$years[ $counter ] = 2000;
						++$counter;
						continue;
					} else {
						continue; # not a recognized number
					}
				}
			}
			$numbers[ $counter ] = $unknowns[ $counter ] = new WCDateNumber( $counter, $intTerm );
			++$counter;
		}

		# Look for and handle named Year/Month/Day labels
		foreach( $yearTerms as $yearTermKey => $yearTerm ) {
			if ( empty( $unknowns ) ) break;
			$unknown = $this->searchAdjacentTerm( $unknowns, $yearTermKey, $chunks );
			if ( $unknown && count( $years ) < 2 ) {
				$years[ $unknown->key ] = $unknown->num;
				$unknown->setYear( $unknowns, $years );
			}
		}
		foreach( $monthTerms as $monthTermKey => $monthTerm ) {
			if ( empty( $unknowns ) ) break;
			$unknown = $this->searchAdjacentTerm( $unknowns, $monthTermKey, $chunks );
			if ( $unknown && count( $months ) < 2 ) {
				$months[ $unknown->key ] = $unknown->num;
				$unknown->setMonth( $unknowns, $months );
			}
		}
		foreach( $dayTerms as $dayTermKey => $dayTerm ) {
			if ( empty( $unknowns ) ) break;
			$unknown = $this->searchAdjacentTerm( $unknowns, $dayTermKey, $chunks );
			if ( $unknown && count( $days ) < 2 ) {
				$days[ $unknown->key ] = $unknown->num;
				$unknown->setDay( $unknowns, $days );
			}
		}

		# If one or more seasons is specified, treat specially and return.
		if ( ! empty( $seasons ) ) {
			$this->season = reset( $seasons );
			$season2 = next( $seasons );
			# Only one season specified
			if ( $season2 === False || $season2 == $this->season ) {
				$isRange = False;
				# Determine year.
				if ( count( $years ) >= 1 ) {
					$year = reset( $years ); # Use first number as year
					$this->assignYearsAndEras( $eras, False, $year->num );
				}
				elseif ( count( $unknowns ) >= 1 ) {
					$year = reset( $unknowns ); # Use first number as year
					$this->assignYearsAndEras( $eras, False, $year->num );
				}
				else {
					$curDate = getdate();
					$this->year = $curDate['year'];
					$this->era = WCDateTermsEnum::AD;
				}
			}
			# Two seasons specified
			else {
				$isRange = True;
				$this->season2 = $season2;
				# Determine year
				if ( count( $years ) >= 2 ) {
					$year = reset( $years )->num;
					$year2 = next( $years )->num;
					if ( $year2 == $year ) {
						$this->assignYearsAndEras( $eras, False, $year );
					}
					else {
						$this->assignYearsAndEras( $eras, True, $year, $year2 );
					}
				}
				elseif ( count( $years ) == 1 ) {
					$yearA = reset( $years )->num;
					if ( empty( $unknowns ) ) {
						$this->assignYearsAndEras( $eras, False, $yearA );
					}
					else {
						$yearB = reset( $unknowns )->num;
						if ( $yearA == $yearB ) {
							$this->assignYearsAndEras( $eras, False, $yearA );
						}
						elseif ( $yearA < $yearB ) {
							$this->assignYearsAndEras( $eras, True, $yearA, $yearB );
						}
						else {
							$this->assignYearsAndEras( $eras, True, $yearB, $yearA );
						}
					}
				}
				elseif ( count( $unknowns ) >= 2 ) {
					# Use first two numbers as years.
					$year = reset( $unknowns )->num;
					$year2 = next( $unknowns )->num;
					if ( $year2 == $year ) {
						$this->assignYearsAndEras( $eras, False, $year );
					}
					else {
						$this->assignYearsAndEras( $eras, True, $year, $year2 );
					}
				}
				elseif ( count( $unknowns ) == 1 ) {
					$year = reset( $unknowns )->num;
					$this->assignYearsAndEras( $eras, False, $year );
				}
				else {
					$curDate = getdate();
					$this->year = $curDate['year'];
					$this->era = WCDateTermsEnum::AD;
				}
			}
			$this->assignUncertainty( $circas, $isRange, $numbers, $chunks );
			return;
		}

		# Handle numbers and/or named months.
		switch ( count( $numbers ) ) {

			case 0:                                       /****** CASE 0 ******/

				$this->finalizeDate( $days, $months, $years, $eras );
				$this->assignUncertainty( $circas, False, $numbers, $chunks );
				break;

			case 1:                                       /****** CASE 1 ******/
				/** Must be year
				 */
				if ( ! empty( $unknowns ) ) {
					reset( $unknowns ) -> setYear( $unknowns, $years );
				}
				$this->finalizeDate( $days, $months, $years, $eras );
				$this->assignUncertainty( $circas, False, $numbers, $chunks );
				break;

			case 2:                                       /****** CASE 2 ******/
				/** Can be any of the following:
				 * month-year
				 * year-year
				 * year-month
				 */
				$order1 = array( WCDateNumber::month, WCDateNumber::year );
				$order2 = array( WCDateNumber::year,  WCDateNumber::year );
				$order3 = array( WCDateNumber::year,  WCDateNumber::month );
				if ( ! (
					$this->monthUpTo12( $unknowns, $days, $years ) ||
					$this->cannotBeDay( $unknowns, $months, $years ) ||
					$this->yearAdjacentEra( $unknowns, $years, $eras, $chunks ) ||
					$this->yearsInOrder( $unknowns, $days, $months, $years, $eras ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order1 ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order2 ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order3 )
				)  ) {
					foreach( $unknowns as $unknownKey => $unknown ) {
						if ( empty( $months ) ) {
							$months[ $unknownKey ] = $unknown->num;
						}
						elseif ( count( $years ) < 2 ) {
							$years[ $unknownKey ] = $unknown->num;
						}
					}
				}
				$isRange = $this->finalizeDate( $days, $months, $years, $eras );
				$this->assignUncertainty( $circas, $isRange, $numbers, $chunks );

				break;

			case 3:                                       /****** CASE 3 ******/
				/** Can be any of the following:
				 * day-month-year
				 * month-day-year
				 * year-month-day
				 * month-month-year
				 * year-month-month
				 */
				$order1 = array( WCDateNumber::day,   WCDateNumber::month, WCDateNumber::year );
				$order2 = array( WCDateNumber::month, WCDateNumber::day,   WCDateNumber::year );
				$order3 = array( WCDateNumber::year,  WCDateNumber::month, WCDateNumber::day );
				$order4 = array( WCDateNumber::month, WCDateNumber::month, WCDateNumber::year );
				$order5 = array( WCDateNumber::year,  WCDateNumber::month, WCDateNumber::month );
				if ( ! (
					$this->dayUpTo31( $unknowns, $months, $years ) ||
					$this->monthUpTo12( $unknowns, $days, $years ) ||
					$this->yearAdjacentEra( $unknowns, $years, $eras, $chunks ) ||
					$this->yearsInOrder( $unknowns, $days, $months, $years, $eras ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order1 ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order2 ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order3 ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order4 ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order5 )
				) ) {
					foreach( $unknowns as $unknownKey => $unknown ) {
						if ( empty( $day ) ) {
							$days[ $unknownKey ] = $unknown->num;
						}
						elseif ( empty( $months ) ) {
							$months[ $unknownKey ] = $unknown->num;
						}
						elseif ( empty( $years ) ) {
							$years[ $unknownKey ] = $unknown->num;
						}
						else {
							$months[ $unknownKey ] = $unknown->num;
						}
					}
				}
				$isRange = $this->finalizeDate( $days, $months, $years, $eras );
				$this->assignUncertainty( $circas, $isRange, $numbers, $chunks );

				break;

			case 4:                                       /****** CASE 4 ******/

				/** Can be any of the following:
				 * day-day-month-year
				 * month-day-day-year
				 * year-month-day-day
				 * month-year-month-year
				 * year-month-year-month
				 */
				$order1 = array( WCDateNumber::day,   WCDateNumber::day,   WCDateNumber::month, WCDateNumber::year );
				$order2 = array( WCDateNumber::month, WCDateNumber::day,   WCDateNumber::day,   WCDateNumber::year );
				$order3 = array( WCDateNumber::year,  WCDateNumber::month, WCDateNumber::day,   WCDateNumber::day );
				$order4 = array( WCDateNumber::month, WCDateNumber::year,  WCDateNumber::month, WCDateNumber::year );
				$order5 = array( WCDateNumber::year,  WCDateNumber::month, WCDateNumber::year,  WCDateNumber::month );
				if ( ! (
					$this->dayUpTo31( $unknowns, $months, $years ) ||
					$this->monthUpTo12( $unknowns, $days, $years ) ||
					$this->yearAdjacentEra( $unknowns, $years, $eras, $chunks ) ||
					$this->yearsInOrder( $unknowns, $days, $months, $years, $eras ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order1 ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order2 ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order3 ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order4 ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order5 )
				) ) {
					foreach( $unknowns as $unknownKey => $unknown ) {
						if ( count( $day ) < 2 ) {
							$days[ $unknownKey ] = $unknown->num;
						}
						elseif ( empty( $months ) ) {
							$months[ $unknownKey ] = $unknown->num;
						}
						elseif ( empty( $years ) ) {
							$years[ $unknownKey ] = $unknown->num;
						}
						elseif ( count( $months ) < 2 ) {
							$months[ $unknownKey ] = $unknown->num;
						}
						else {
							$years[ $unknownKey ] = $unknown->num;
						}
					}
				}
				$isRange = $this->finalizeDate( $days, $months, $years, $eras );
				$this->assignUncertainty( $circas, $isRange, $numbers, $chunks );

				break;

			case 5:                                       /****** CASE 5 ******/

				/** Can be any of the following:
				 * day-month-day-month-year
				 * month-day-month-day-year
				 * year-month-day-month-day
				 */
				$order1 = array( WCDateNumber::day,   WCDateNumber::month, WCDateNumber::day,   WCDateNumber::month, WCDateNumber::year );
				$order2 = array( WCDateNumber::month, WCDateNumber::day,   WCDateNumber::month, WCDateNumber::day,   WCDateNumber::year );
				$order3 = array( WCDateNumber::year,  WCDateNumber::month, WCDateNumber::day,   WCDateNumber::month, WCDateNumber::day );
				if ( ! (
					$this->dayUpTo31( $unknowns, $months, $years ) ||
					$this->monthUpTo12( $unknowns, $days, $years ) ||
					$this->yearAdjacentEra( $unknowns, $years, $eras, $chunks ) ||
					$this->yearsInOrder( $unknowns, $days, $months, $years, $eras ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order1 ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order2 ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order3 )
				) ) {
					foreach( $unknowns as $unknownKey => $unknown ) {
						if ( count( $day ) < 2 ) {
							$days[ $unknownKey ] = $unknown->num;
						}
						elseif ( count( $months ) < 2 ) {
							$months[ $unknownKey ] = $unknown->num;
						}
						else {
							$years[ $unknownKey ] = $unknown->num;
						}
					}
				}
				$isRange = $this->finalizeDate( $days, $months, $years, $eras );
				$this->assignUncertainty( $circas, $isRange, $numbers, $chunks );

				break;

			default:                                     /****** CASE 6+ ******/

				/** Can be one of the following:
				 * day-month-year-day-month-year
				 * month-day-year-month-day-year
				 * year-month-day-year-month-day
				 */
				$order1 = array( WCDateNumber::day,   WCDateNumber::month, WCDateNumber::year,  WCDateNumber::day,   WCDateNumber::month, WCDateNumber::year );
				$order2 = array( WCDateNumber::month, WCDateNumber::day,   WCDateNumber::year,  WCDateNumber::month, WCDateNumber::day,   WCDateNumber::year );
				$order3 = array( WCDateNumber::year,  WCDateNumber::month, WCDateNumber::day,   WCDateNumber::year,  WCDateNumber::month, WCDateNumber::day );
				if ( ! (
					$this->dayUpTo31( $unknowns, $months, $years ) ||
					$this->monthUpTo12( $unknowns, $days, $years ) ||
					$this->yearAdjacentEra( $unknowns, $years, $eras, $chunks ) ||
					$this->yearsInOrder( $unknowns, $days, $months, $years, $eras ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order1 ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order2 ) ||
					$this->tryOrder( $unknowns, $days, $months, $years, $order3 )
				) ) {
					foreach( $unknowns as $unknownKey => $unknown ) {
						if ( count( $day ) < 2 ) {
							$days[ $unknownKey ] = $unknown->num;
						}
						elseif ( count( $months ) < 2 ) {
							$months[ $unknownKey ] = $unknown->num;
						}
						else {
							$years[ $unknownKey ] = $unknown->num;
						}
					}
				}
				$isRange = $this->finalizeDate( $days, $months, $years, $eras );
				$this->assignUncertainty( $circas, $isRange, $numbers, $chunks );
		}

	}


	/**
	 * Determine if $this can be considered a short form of argument $date.
	 * If so, then determine the number of matches.
	 *
	 * @param WCDate $date
	 * @return integer|boolean
	 */
	public function shortFormMatches( WCData $date ) {
		$matches = 0;
		if ( isset( $this->year ) ) {
			if ( $this->year === $date->year ) ++$matches;
			else return False;
		}
		if ( isset( $this->month ) ) {
			if ( $this->month === $date->month ) ++$matches;
			else return False;
		}
		if ( isset( $this->day ) ) {
			if ( $this->day === $date->day ) ++$matches;
			else return False;
		}
		if ( isset( $this->season ) ) {
			if ( $this->season === $date->season ) ++$matches;
			else return False;
		}
		if ( isset( $this->era ) ) {
			if ( $this->era === $date->era ) ++$matches;
			else return False;
		}
		return $matches;
	}


	public function __toString() {
		$text = $this->year;
		if ( $this->year2 ) $text .= '–' . $year2;
		if ( $this->season ) $text .= ' ' . $season;
		if ( $this->season2 ) $text .= '–' . $season2;
		if ( $this->month ) $text .= ' ' . $month;
		if ( $this->month2 ) $text .= '–' . $month2;
		if ( $this->day ) $text .= ' ' . $day;
		if ( $this->day2 ) $text .= '–' . $day2;
		return $text;
	}


	/**
	 * Match localized month names and abbreviations.
	 *
	 * @global Language $wgContLang the content Language object
	 * @param string $chunk          the term being tested
	 * @return int                  the numerical month ( or 0 if no match)
	 */
	protected function matchMonths( $date ) {
		global $wgContLang;
		for ( $i=1; $i < 13; $i++ ) {
			if ( $date == $wgContLang->getMonthName( $i )
			  || $date == $wgContLang->getMonthAbbreviation( $i )
			  || $date == $wgContLang->getMonthNameGen( $i ) ) {
				return $i;
			}
		}
		return 0;
	}


	/**
	 * Convert a string Roman number to integer.
	 * If the string does not represent a Roman number, this function returns 0.
	 * @staticvar array $letters
	 * @param type $romanNumber = string containing the (possibly) Roman number
	 * @return int = the integer corresponding to the Roman number (or zero)
	 */
	protected function romanToInt( $romanNumber ) {
		static $letters = array(
		    'M'  => 1000, 'CM' => 900, 'D'  => 500, 'CD' => 400, 'C'  => 100,
			'XC' => 90, 'L'  => 50, 'XL' => 40, 'X'  => 10, 'IX' => 9,
			'V'  => 5, 'IV' => 4, 'I'  => 1,
		);
		$number = 0;
		foreach ( $letters as $key => $value ) {
			while ( mb_strpos( $romanNumber, $key ) === 0) {
				$result += $value;
				$romanNumber = mb_substr( $romanNumber, mb_strlen( $key ) );
			}
		}
		return $number;
	}


	/**
	 * If it is a two-digit year, convert to a four-digit year.
	 * Cutoff between this and last century is 5 years in the future,
	 * to allow for anticipatory citations of to-be-published material.
	 * Thus, if in the year 2011 you cited a "01/01/16" publication, the year
	 * would be interpreted as 2016, but "01/01/17" would be interpreted as
	 * 1917.
	 * @param int $year = a two-digit year (this is validated by the function)
	 * @return int = the corresponding four-digit year
	 */
	protected function adjust2DigitYear( $year ) {
		if ( $year >= 100 ) return $year;
		$curDate = getdate();
		$curYear = $curDate['year'];
		# Two digit year plus the current century:
		$year = $curYear - $curYear % 100 + $year;
		$cutoffYear = $curYear + 5;
		if ( $year > $curYear + 10 ) {
			return $year - 100;
		}
		else {
			return $year;
		}
	}


	/**
	 * Assign up to two years and two eras (AD or BC, etc.)
	 * If the era(s) are not defined, this function assumes AD and converts
	 * any two-digit years to full years in the current century. Thus, years
	 * prior to 100 AD require an explicit era designation.
	 * @param array $eras = array of values comprising either 1=AD or -1=BC
	 * @param int $isRange = whether or not the date is a range
	 * @param int $year = the year, or first year
	 * @param int $year2 = the second year
	 */
	protected function assignYearsAndEras( array $eras, $isRange, $year, $year2 = Null ) {
		if ( $isRange ) {
			if ( count( $eras ) >= 2 ) {
				$this->year = $year;
				$this->year2 = $year2;
				$this->era = reset( $eras ); # Use first two eras.
				$this->era2 = next( $eras );
			} elseif ( count ( $eras ) == 1 ) {
				$this->year = $year;
				$this->year2 = $year2;
				$this->era = $this->era2 = reset( $eras );
			} else {
				$this->year = $this->adjust2DigitYear( $year ); # Assume small years are 2-digit years.
				$this->year2 = $this->adjust2DigitYear( $year2 );
				$this->era = $this->era2 = WCDateTermsEnum::AD; # Assume AD.
			}
		} else {
			if ( count( $eras ) >= 1 ) {
				$this->year = $year;
				$this->era = reset( $eras ); # Use first era
			} else {
				$this->year = $this->adjust2DigitYear( $year ); # Assume small years are 2-digit years.
				$this->era = WCDateTermsEnum::AD; # Assume AD.
			}
		}
	}


	/**
	 * Assign uncertainty to one or both of the dates.
	 * Uncertainty is indicated by "circa" or "c." or equivalent localized
	 * terms. If there is only one indication of uncertainty, this function
	 * determines whether the "circa" etc. is closer to $num1 or $num2.
	 * @param array $circas= a list of "circa" indicators
	 * @param type $isRange
	 * @param array $numbers = the list of all numbers that might be uncertain
	 * @param array $chunks  = a list of date terms.
	 */
	protected function assignUncertainty( array $circas, $isRange, array $numbers, array $chunks ) {
		if ( $isRange ) {
			if ( empty( $circas ) ) {
				$this->isUncertain = $this->isUncertain2 = False;
			}
			# If there are two indications of uncertainty, both dates are uncertain.
			elseif ( count( $circas ) >= 2 ) {
				$this->isUncertain = $this->isUncertain2 = True;
			}
			# For just one indication of uncertainty in a range, the uncertain date is the one
			# where the number ($num1 or $num2) is most adjacent to the indicator
			# of uncertainty.
			else {
				$circaKey = key( reset( $circas ) );
				$uncertainNumber = $this->searchAdjacentTerm( $numbers, $circaKey, $chunks );
				if ( $uncertainNumber ) {
					$uncertainKey = $uncertainNumber->key;
					$uncertainType = $uncertainNumber->numType;
					foreach( $numbers as $number ) {
						if ( $number->numType == $uncertainType ) {
							if ( $number->key == $uncertainKey ) {
								# Key matches the first number of that type
								$this->isUncertain = True;
								$this->isUncertain2 = False;
							}
							else {
								# Key does not match the first number, so probably matches the second
								$this->isUncertain = False;
								$this->isUncertain2 = True;
							}
							return;
						}
					}
				}
				else {
					# None of the terms is adjacent.
					$this->isUncertain = False;
					return;
				}
			}
		}
		else {
			$this->isUncertain = ! empty( $circas );
		}
	}


	public function finalizeDate( array $days, array $months, array $years, array $eras ) {
		$isRange = False;
		$year1 = reset( $years );
		if ( $year1 === False ) {
			# No year specified
			$curDate = getdate();
			$this->year = $curDate['year'];
			$this->era = WCDateTermsEnum::AD;
		}
		else {
			# At least one year specified
			$yearKey1 = key( $years );
			$year2 = next( $years );
			if ( $year2 === False || $year2 == $year1 ) {
				# Only one year specified
				$this->assignYearsAndEras( $eras, False, $year1 );
			}
			else {
				# Two years specified
				$yearKey2 = key( $years );
				$isRange = True;
				$this->assignYearsAndEras( $eras, True, $year1, $year2 );
			}
		}

		$month1 = reset( $months );
		if ( $month1 === False ) {
			# No month specified
			return $isRange;
		}
		else {
			# Month is specified
			$this->month = $month1;
			$month2 = next( $months );
			if ( ! ( $month2 === False ) && $month1 != $month2 ) {
				# Two months specified
				$this->month2 = $month2;
				$isRange = True;
			}
		}

		$day1 = reset( $days );
		if ( $day1 === False ) {
			# No day specified
			return $isRange;
		}
		else {
			# Day is specified
			$this->day = $day1;
			$day2 = next( $days );
			if ( $day2 === False || $day2 == $day1 ) {
				# Only one day specified
				return $isRange;
			}
			else {
				# Two days specified
				$this->day2 = $day2;
				return True;
			}
		}

	}


	/**
	 * Determine whether the term at key $termKey is adjacent to a number.
	 * @param array $numbers = an array of WCDateTerm objects
	 * @param int $termKey = the key of the term in question
	 * @param array $chunks = chunks of user input
	 * @return WCDateTerm = WCDateTerm if adjacent, Null if not
	 */
	public function searchAdjacentTerm( array $numbers, $termKey, array $chunks ) {
		$s1 = is_set( $numbers[ $termKey - 1 ] );
		$s2 = is_set( $numbers[ $termKey + 1 ] );
		if ( !$s1 && !$s2 ) {
			return Null;
		}
		elseif ( !$s1 && $s2 ) {
			$numberKey = $termKey + 1;
			$number = $numbers[ $numberKey ];
			$years[ $numberKey ] = $number->num;
			return $number;
		}
		elseif ( $s1 && !$s2 ) {
			$numberKey = $termKey - 1;
			$number = $numbers[ $numberKey ];
			$years[ $numberKey ] = $number->num;
			return $number;
		}
		else {
			$number1 = $numbers[ $termKey - 1 ];
			$number2 = $numbers[ $termKey + 1 ];
			$closestNum = $this->closestNumberToTerm( $termKey, $number1, $number2, $chunks );
			if ( $closestNum->key < $termKey ) {
				return $number1;
			}
			else {
				return $number2;
			}
		}
	}


	public function closestNumberToTerm( $key, WCDateNumber $num1, WCDateNumber $num2, array $chunks ) {
		$key1 = $num1->key;
		$key2 = $num2->key;
		$dist1 = $key - $key1;
		$dist2 = $key2 - $key;
		$mid1 = implode( '', array_slice( $chunks, $key1 + 1, $dist1 - 1 ) );
		$mid2 = implode( '', array_slice( $chunks, $key + 1, $dist2 - 1 ) );
		$sp1 = preg_match('/^\p{Zs}*$/uS', $mid1 );
		$sp2 = preg_match('/^\p{Zs}*$/uS', $mid2 );
		# Is one number (and not the other) separated from the term by merely space?
		if ( !$sp1 && $sp2 ) {
			return $num2;
		}
		elseif  ( $sp1 && !$sp2 ) {
			return $num1;
		}
		# Pick the number, if any, that has fewer intermediate terms.
		elseif ( abs( $dist1 ) < abs( $dist2 ) ) {
			return $num1;
		}
		elseif ( abs( $dist2 ) < abs( $dist1 ) ) {
			return $num2;
		}
		# Pick the number, if any, that has the shortest string between itself and the term:
		elseif ( mb_strlen( $mid1 ) < mb_strlen( $mid2 ) ) {
			return $num1;
		}
		elseif ( mb_strlen( $mid2 ) < mb_strlen( $mid1 ) ) {
			return $num2;
		}
		# Anything that makes it this far would look something like "…AAA 12 BBB…" or "…AAA-12-BBB…".
		return Null;
	}


	public function	dayUpTo31( array &$unknowns, array &$months, array &$years ) {
		foreach( $unknowns as $unknown ) {
			if ( $unknown->num > 31 ) {
				$unknown->setNotDay( $unknowns, $months, $years );
			}
		}
		return empty( $unknowns );
	}


	public function monthUpTo12( array &$unknowns, array &$days, array &$years ) {
		foreach( $unknowns as $unknown ) {
			if ( $unknown->num > 12 ) {
				$unknown->setNotMonth( $unknowns, $days, $years );
			}
		}
		return empty( $unknowns );
	}


	public function yearAdjacentEra( array &$unknowns, array &$years, array $eras, array $chunks ) {
		if ( empty( $eras ) || empty( $unknowns ) ) {
			return False;
		}
		foreach ( $eras as $eraKey => $era ) {
			$unknown = $this->searchAdjacentTerm( $unknowns, $eraKey, $chunks );
			if ( $unknown ) {
				$unknown->setYear( $unknowns, $years );
			}
		}
		return empty( $unknowns );
	}


	public function cannotBeDay( array &$unknowns, &$months, &$years ) {
		foreach( $unknowns as $unknown ) {
			$unknown->setNotDay( $unknowns, $months, $years );
		}
		return empty( $unknowns );
	}


	/**
	 * Determines whether number can be a year, based on relative year order.
	 * This is only useful when one year has been defined, but not the other
	 * year. It assumes that the user will enter a year range in the proper
	 * numerical order. For example, "09-10" and "7 BC - 4 BC" are proper
	 * ranges, but if the year 7 BC has already been defined, the next year
	 * in the range cannot be 10 BC.
	 * @param array $unknowns
	 * @param array $days
	 * @param array $months
	 * @param array $years
	 * @param array $eras
	 * @return boolean = True if all the $unknowns have been exhausted
	 */
	public function yearsInOrder( array &$unknowns, array &$days, array &$months, array &$years, array $eras ) {
		if ( count( $years ) == 1 ) {
			$year = reset( $years );
			$yearKey = key( $years );
			# Date range spans the BC-AD era boundary:
			if ( empty( $eras ) ) {
				foreach( $unknowns as $unknownKey => $unknown ) {
					if ( $unknownKey < $yearKey && $unknown->num > $year
					  || $yearKey < $unknownKey && $year > $unknown->num ) {
						$unknown->setNotYear( $unknowns, $days, $months );
					}
				}
			}
			else {
				$era1 = reset( $eras );
				$era2 = next( $eras );
				if ( $era2 === False || $era1 === $era2 ) {
					if ( $era1 === WCDateTermsEnum::AD ) {
						foreach( $unknowns as $unknownKey => $unknown ) {
							if ( $unknownKey < $yearKey && $unknown->num > $year
							  || $yearKey < $unknownKey && $year > $unknown->num ) {
								$unknown->setNotYear( $unknowns, $days, $months );
							}
						}
					}
					else {
						foreach( $unknowns as $unknownKey => $unknown ) {
							if ( $unknownKey < $yearKey && $unknown->num < $year
							  || $yearKey < $unknownKey && $year < $unknown->num ) {
								$unknown->setNotYear( $unknowns, $days, $months );
							}
						}
					}
				}
				else {
					return False;
				}
			}
			return empty( $unknowns );
		}
		else {
			return False;
		}
	}


	public function tryOrder( array &$unknowns, array &$days, array &$months, array &$years, array $order ) {
		reset( $order );
		foreach( $unknowns as $unknown ) {
			switch ( current( $order ) ) {
				case WCDateNumber::year:
					if ( $unknown->couldBeYear() ) break;
					else return False;
				case WCDateNumber::month:
					if ( $unknown->couldBeMonth() ) break;
					else return False;
				case WCDateNumber::day:
					if ( $unknown->couldBeDay() ) break;
					else return False;
			}
			next( $order );
		}
		reset( $order );
		foreach( $unknowns as $unknown ) {
			switch ( current( $order ) ) {
				case WCDateNumber::year:
					$unknown->setYear( $unknowns, $years );
					break;
				case WCDateNumber::month:
					$unknown->setMonth( $unknowns, $months );
					break;
				case WCDateNumber::day:
					$unknown->setDay( $unknowns, $days );
					break;
			}
			next( $order );
		}
		return empty( $unknowns );
	}


}

