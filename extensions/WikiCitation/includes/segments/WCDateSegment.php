<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


/**
 * Enumerations
 */
class WCDateParts extends WCEnum {
	const none         = 0;
	const year         = 1;
	const month	       = 2;
	const day          = 3;
	const season       = 4;
	const yearMonth    = 5;
	const yearSeason   = 6;
	const monthDay     = 7;
	const yearMonthDay = 8;
	const __default    = self::none;
}

class WCDateOrder extends WCEnum {
	const littleEndian        = 0;
	const middleEndian        = 1;
	const bigEndian           = 2;
	const __default           = self::littleEndian;
}

class WCDateForm extends WCEnum {
	const long                = 0; # e.g., August
	const short               = 1; # e.g., Aug.
	const numeric             = 2; # e.g., 8
	const numericLeadingZeros = 3; # e.g., 08
	const ordinal             = 4; # e.g., 8th  -- not implemented yet
	const __default           = self::long;
}

class WCDateRange extends WCEnum {
	const range     = 0;
	const first     = 1;
	const second    = 2;
	const __default = self::range;
}

class WCDateSegment extends WCDataSegment {

	protected $dateObject;

	protected $scope;

	protected $propertyType;

	protected $datePart, $dateOrder, $dateForm, $rangePart;

	protected $rangePointOfDifference;

	public function __construct(
			WCCitation $citation,
			WCSegmentImportance $importance,
			WCScopeEnum $scope,
			WCPropertyEnum $propertyType,
			WCDateParts $datePart,
			WCDateOrder $dateOrder,
			WCDateForm $dateForm,
			WCDateRange $dateRange,
			$prefix = '',
			$suffix = '' ) {
		parent::__construct( $citation, $prefix, $suffix );
		$this->datePart  = $datePart;
		$this->dateOrder = $dateOrder;
		$this->dateForm  = $dateForm;
		$this->rangePart = $dateRange;
		switch( $importance->key ) {
			case WCSegmentImportance::mandatory:
				$this->$dateObject = $citation->reference->inferProperty( $scope, $propertyType );
				$this->exists = True;
				return;
			case WCSegmentImportance::important:
				$this->dateObject = $citation->reference->inferProperty( $scope, $propertyType );
				$this->exists = (bool) $this->dateObject;
				break;
			case WCSegmentImportance::optional:
				$dateObject = $citation->reference->getProperty( $scope, $propertyType );
				if ( isset( $dateObject ) ) {
					$this->dateObject = $dateObject;
				} else {
					$this->exists = False;
				}
		}
		# $scope and $propertyType may have changed as a side-effect of $citation->inferProperty.
		$this->scope = $scope;
		$this->propertyType = $propertyType;

		# Determine if the date is a range and if so, where the point of difference is.
		if ( isset ( $this->dateObject->year2 ) ) {
			$this->rangePointOfDifference = WCDateParts::year;
		} elseif ( isset ( $this->dateObject->month2 ) ) {
			$this->rangePointOfDifference = WCDateParts::month;
		} elseif ( isset ( $this->dateObject->day2 ) ) {
			$this->rangePointOfDifference = WCDateParts::day;
		} elseif ( isset ( $this->dateObject->season2 ) ) {
			$this->rangePointOfDifference = WCDateParts::season;
		} else {
			$this->rangePointOfDifference = WCDateParts::none;
		}

	}


	public function getLabel( WCStyle $style, WCLabelFormEnum $form, WCPluralEnum $plural ) {
		return $style->propertyLabels[ $this->propertyType->key ][ $form->key ][ $plural->key ];
	}


	/**
	 * Set the part and form to render with any subsequent calls to render().
	 * @param WCDateParts $dateParts
	 * @param WCDateForm $dateForm
	 * @param int $rangePart
	 * @param string $prefix
	 * @param string $suffix
	 */
	public function setPart( WCDateParts $datePart, $prefix = '', $suffix = '' ) {
		$this->datePart  = $datePart;
		$this->prefix    = $prefix;
		$this->suffix    = $suffix;
	}


	public function rangePointOfDifference() {
		return $this->rangePointOfDifference;
	}


	public function count() {
		return $this->rangePointOfDifference != WCDateParts::none;
	}


	public function getSortingParts() {
		if ( $this->dateObject->era == WCDateTermsEnum::BC ) {
			$arr = array( - $this->dateObject->year );
		} else {
			$arr = array( $this->dateObject->year );
		}
		if ( $this->dateObject->season ) {
			$arr[] = $this->dateObject->season;
			return $arr;
		}
		if ( $this->dateObject->month ) {
			$arr[] = $this->dateObject->month;
		}
		if ( $this->dateObject->day ) {
			$arr[] = $this->dateObject->day;
		}
		return $arr;

	}


	public function render( WCStyle $style, $endSeparator = '' ) {
		if ( $this->dateObject ) {
			switch( $this->rangePart->key ) {
				case WCDateRange::range:
					switch ( $this->datePart->key ) {
						case WCDateParts::year:
							$date = $this->renderYearRange();
							break;
						case WCDateParts::month:
							$date = $this->renderMonthRange();
							break;
						case WCDateParts::day:
							$date = $this->renderDayRange();
							break;
						case WCDateParts::season:
							$date = $this->renderSeasonRange();
							break;
						case WCDateParts::yearMonthDay:
							switch( $this->dateOrder->key ) {
								case WCDateOrder::littleEndian:
									switch ( $this->rangePointOfDifference() ) {
										case WCDateParts::none:
											$date = $this->renderDay() . ' ' . $this->renderMonth() . ' ' . $this->renderYear();
											break;
										case WCDateParts::year:
											$date = $this->renderDay() . ' ' . $this->renderMonth() . ' ' . $this->renderYear() . ' – ' . $this->renderDay2() . ' ' . $this->renderMonth2() . ' ' . $this->renderYear2();
											break;
										case WCDateParts::month:
											$date = $this->renderDay() . ' ' . $this->renderMonth() . ' – ' . $this->renderDay2() . ' ' . $this->renderMonth2() . ' ' . $this->renderYear();
											break;
										case WCDateParts::day:
											$date = $this->renderDayRange() . ' ' . $this->renderMonth() . ' ' . $this->renderYear();
											break;
										case WCDateParts::season:
											$date = $this->renderSeasonRange() . ' ' . $this->renderYear();
											break;
										default:
											throw new MWException( 'Point of difference is not defined' );
									}
									break;
								case WCDateOrder::middleEndian:
									switch ( $this->rangePointOfDifference() ) {
										case WCDateParts::none:
											$date = $this->renderMonth() . ' ' . $this->renderDay() . ', ' . $this->renderYear();
											break;
										case WCDateParts::year:
											$date = $this->renderMonth() . ' ' . $this->renderDay() . ', ' . $this->renderYear() . ' – ' . $this->renderMonth2() . ' ' . $this->renderDay2() . ', ' . $this->renderYear2();
											break;
										case WCDateParts::month:
											$date = $this->renderMonth() . ' ' . $this->renderDay() . ' – ' . $this->renderMonth2() . ' ' . $this->renderDay2() . ', ' . $this->renderYear();
											break;
										case WCDateParts::day:
											$date = $this->renderMonth() . ' ' . $this->renderDayRange() . ', ' . $this->renderYear();
											break;
										case WCDateParts::season:
											$date = $this->renderSeasonRange() . ' ' . $this->renderYear();
										default:
											throw new MWException( 'Point of difference is not defined' );
									}
									break;
								case WCDateOrder::bigEndian:
									switch ( $this->rangePointOfDifference() ) {
										case WCDateParts::none:
											$date = $this->renderYear() . ' ' . $this->renderMonth() . ' ' . $this->renderDay();
											break;
										case WCDateParts::year:
											$date = $this->renderYear() . ' ' . $this->renderMonth() . ' ' . $this->renderDay() . ' – ' . $this->renderYear2() . ' ' . $this->renderMonth2() . ' ' . $this->renderDay2();
											break;
										case WCDateParts::month:
											$date = $this->renderYear() . ' ' . $this->renderMonth() . ' ' . $this->renderDay() . ' – ' . $this->renderMonth2() . ' ' . $this->renderDay2();
											break;
										case WCDateParts::day:
											$date = $this->renderYear() . ' ' . $this->renderMonth() . ' ' . $this->renderDayRange();
											break;
										case WCDateParts::season:
											$date = $this->renderYear() . ' ' . $this->renderSeasonRange();
											break;
										default:
											throw new MWException( 'Point of difference is not defined' );
									}
									break;
								default:
									$date = $this->renderDayFirstFull();
							}
							break;
						default:
							throw new MWException( 'Date part is not defined' );
					}
					break;
				case WCDateRange::first:
					switch ( $this->datePart->key ) {
						case WCDateParts::year:
							$date = $this->renderYear();
							break;
						case WCDateParts::month:
							$date = $this->renderMonth();
							break;
						case WCDateParts::day:
							$date = $this->renderDay();
							break;
						case WCDateParts::season:
							$date = $this->renderSeason();
							break;
						default:
							throw new MWException( '$this->datePart is not defined' );
					}
					break;
				case WCDateRange::second:
					switch ( $this->datePart->key ) {
						case WCDateParts::year:
							$date = $this->renderYear2();
							break;
						case WCDateParts::month:
							$date = $this->renderMonth2();
							break;
						case WCDateParts::day:
							$date = $this->renderDay2();
							break;
						case WCDateParts::season:
							$date = $this->renderSeason2();
							break;
						default:
							throw new MWException( 'Date part is not defined' );
					}
			}
			$endSeparator = $this->extendSuffix( $endSeparator );
			if ( $endSeparator ) {
				$chrL = mb_substr( $date, -1, 1 );
				$chrR = mb_substr( $endSeparator, 0, 1 );
				if ( $chrL == $chrR ) {
					$endSeparator = ltrim( $endSeparator, $chrR );
				}
				$date .=  $endSeparator;
			}
			return $this->prefix . $date;
		} else {
			return $this->prefix . $style->segmentMissing . $this->extendSuffix( $endSeparator );
		}
	}


	protected function renderYearRange() {
		if ( isset ( $this->dateObject->year ) ) {
			if ( isset( $this->dateObject->year2 ) ) {
				switch ( $this->dateForm->key ) {
					case WCDateForm::long:
					case WCDateForm::numeric:
						return $this->dateObject->year . '–' . $this->dateObject->year2;
					case WCDateForm::short:
					case WCDateForm::leadingZeros:
						if ( $this->dateObject->year >= 1900 ) {
							return str_pad( $this->dateObject->year % 100, 2, '0', STR_PAD_LEFT ) . '–'
								. str_pad( $this->dateObject->year2 % 100, 2, '0', STR_PAD_LEFT );
						}
						else {
							return $this->dateObject->year . '–' . $this->dateObject->year2;
						}
				}
			}
			else {
				switch ( $this->dateForm->key ) {
					case WCDateForm::long:
					case WCDateForm::numeric:
						return (string) $this->dateObject->year;
					case WCDateForm::short:
					case WCDateForm::leadingZeros:
						if ( $this->dateObject->year >= 1900 ) return str_pad( $this->dateObject->year % 100, 2, '0', STR_PAD_LEFT );
						else return (string) $this->dateObject->year;
				}
			}
		}
		else {
			return Null;
		}
	}


	protected function renderYear() {
		if ( isset ( $this->dateObject->year ) ) {
			switch ( $this->dateForm->key ) {
				case WCDateForm::long:
				case WCDateForm::numeric:
					return (string) $this->dateObject->year;
				case WCDateForm::short:
				case WCDateForm::leadingZeros:
					if ( $this->dateObject->year >= 1900 ) return str_pad( $this->dateObject->year % 100, 2, '0', STR_PAD_LEFT );
					else return (string) $this->dateObject->year;
			}
		}
		else {
			return Null;
		}
	}


	protected function renderYear2() {
		if ( isset ( $this->dateObject->year2 ) ) {
			switch ( $this->dateForm->key ) {
				case WCDateForm::long:
				case WCDateForm::numeric:
					return (string) $this->dateObject->year2;
				case WCDateForm::short:
				case WCDateForm::leadingZeros:
					if ( $this->dateObject->year2 >= 1900 ) return str_pad( $this->dateObject->year2 % 100, 2, '0', STR_PAD_LEFT );
					else return (string) $this->dateObject->year2;
			}
		}
		else {
			return Null;
		}
	}


	protected function renderMonthRange() {
		if ( isset ( $this->dateObject->month ) ) {
			if ( isset( $this->dateObject->month2 ) ) {
				switch ( $this->dateForm->key ) {
					case WCDateForm::long:
					case WCDateForm::short:
					case WCDateForm::numeric:
						return $this->dateObject->month . '–' . $this->month2;
					case WCDateForm::numericLeadingZeros:
						return str_pad( $this->dateObject->month, 2, '0', STR_PAD_LEFT ) . '–'
							. str_pad( $this->dateObject->month2, 2, '0', STR_PAD_LEFT );
				}
			}
			else {
				switch ( $this->dateForm->key ) {
					case WCDateForm::long:
					case WCDateForm::numeric:
						return (string) $this->dateObject->month;
					case WCDateForm::short:
					case WCDateForm::numericLeadingZeros:
						return str_pad( $this->dateObject->month, 2, '0', STR_PAD_LEFT );
				}
			}
		}
		else {
			return Null;
		}
	}


	protected function renderMonth() {
		if ( isset ( $this->dateObject->month ) ) {
			switch ( $this->dateForm->key ) {
				case WCDateForm::long:
				case WCDateForm::numeric:
					return (string) $this->dateObject->month;
				case WCDateForm::short:
				case WCDateForm::numericLeadingZeros:
					return str_pad( $this->dateObject->month, 2, '0', STR_PAD_LEFT );
			}
		}
		else {
			return Null;
		}
	}


	protected function renderMonth2() {
		if ( isset ( $this->dateObject->month2 ) ) {
			switch ( $this->dateForm->key ) {
				case WCDateForm::long:
				case WCDateForm::numeric:
					return (string) $this->dateObject->month2;
				case WCDateForm::short:
				case WCDateForm::numericLeadingZeros:
					return str_pad( $this->dateObject->month2, 2, '0', STR_PAD_LEFT );
			}
		}
		else {
			return Null;
		}
	}


	protected function renderDayRange() {
		if ( isset ( $this->dateObject->day ) ) {
			if ( isset( $this->dateObject->day2 ) ) {
				switch ( $this->dateForm->key ) {
					case WCDateForm::numeric:
						return $this->dateObject->day . '–' . $this->day2;
					case WCDateForm::numericLeadingZeros:
						return str_pad( $this->dateObject->day, 2, '0', STR_PAD_LEFT ) . '–'
							. str_pad( $this->dateObject->day2, 2, '0', STR_PAD_LEFT );
					case WCDateForm::ordinal:
						# This must wait until we can use PHP 5.3 NumberFormatter.
						return (string) $this->dateObject->day;
				}
			}
			else {
				switch ( $this->dateForm->key ) {
					case WCDateForm::numeric:
						return (string) $this->dateObject->day;
					case WCDateForm::numericLeadingZeros:
						return str_pad( $this->dateObject->day, 2, '0', STR_PAD_LEFT );
					case WCDateForm::ordinal:
						# This must wait until we can use PHP 5.3 NumberFormatter.
						return $this->dateObject->day . '–' . $this->day2;
				}
			}
		}
	}


	protected function renderDay() {
		switch ( $this->dateForm->key ) {
			case WCDateForm::numeric:
				return (string) $this->dateObject->day;
			case WCDateForm::numericLeadingZeros:
				return str_pad( $this->dateObject->day, 2, '0', STR_PAD_LEFT );
			case WCDateForm::ordinal:
				# This must wait until we can use PHP 5.3 NumberFormatter.
				return (string) $this->dateObject->day;
		}
	}


	protected function renderDay2() {
		switch ( $this->dateForm->key ) {
			case WCDateForm::numeric:
				return (string) $this->dateObject->day2;
			case WCDateForm::numericLeadingZeros:
				return str_pad( $this->dateObject->day2, 2, '0', STR_PAD_LEFT );
			case WCDateForm::ordinal:
				# This must wait until we can use PHP 5.3 NumberFormatter.
				return (string) $this->dateObject->day2;
		}
	}


	protected function renderSeasonRange() {
		if ( isset( $this->dateObject->season ) ) {
			if ( isset( $this->dateObject->season2 ) ) {
				return $this->dateObject->season . '–' . $this->dateObject->season2;
			}
			else {
				return $this->dateObject->season;
			}
		}
		else {
			return Null;
		}
	}


	protected function renderSeason() {
		if ( isset( $this->dateObject->season ) ) {
			return $this->dateObject->season;
		}
		else {
			return Null;
		}
	}


	protected function renderSeason2() {
		if ( isset( $this->dateObject->season2 ) ) {
			return $this->dateObject->season2;
		}
		else {
			return Null;
		}
	}


}
