<?php

/**
 * File holding the SFIDatePicker class
 * 
 * @author Stephan Gambke
 * @file
 * @ingroup SemanticFormsInputs
 */
if ( !defined( 'SFI_VERSION' ) ) {
	die( 'This file is part of the SemanticFormsInputs extension, it is not a valid entry point.' );
}

/**
 * The SFIDatePicker class.
 *
 * @ingroup SemanticFormsInputs
 */
class SFIDatePicker extends SFFormInput {
	
	/**
	 * Constructor.
	 *
	 * @param String $input_number
	 *		The number of the input in the form.
	 * @param String $cur_value
	 *		The current value of the input field.
	 * @param String $input_name
	 *		The name of the input.
	 * @param String $disabled
	 *		Is this input disabled?
	 * @param Array $other_args
	 *		An associative array of other parameters that were present in the
	 *		input definition.
	 */
	public function __construct( $input_number, $cur_value, $input_name, $disabled, $other_args ) {

		parent::__construct( $input_number, $cur_value, $input_name, $disabled, $other_args );

		// call static setup
		self::setup();
		
		$this->addJsInitFunctionData( 'SFI_DP_init', $this->setupJsInitAttribs() );
	}

	/**
	 * Returns the name of the input type this class handles.
	 *
	 * This is the name to be used in the field definition for the "input type"
	 * parameter.
	 *
	 * @return String The name of the input type this class handles.
	 */
	public static function getName() {
		return 'datepicker';
	}

	/**
	 * Static setup method for input type "menuselect".
	 * Adds the Javascript code and css used by all menuselects.
	 */
	static private function setup() {

		global $wgOut, $wgLang;
		global $sfgScriptPath, $sfigSettings;

		static $hasRun = false;

		if ( !$hasRun ) {
			$hasRun = true;
			
			$wgOut->addExtensionStyle( $sfgScriptPath . '/skins/jquery-ui/base/jquery.ui.datepicker.css' );
			$wgOut->addExtensionStyle( $sfgScriptPath . '/skins/jquery-ui/base/jquery.ui.theme.css' );
			$wgOut->addScript( '<script type="text/javascript" src="' . $sfgScriptPath . '/libs/jquery-ui/jquery.ui.datepicker.min.js"></script> ' );
			$wgOut->addScript( '<script type="text/javascript" src="' . $sfigSettings->scriptPath . '/libs/datepicker.js"></script> ' );

			// set localized messages (use MW i18n, not jQuery i18n)
			$jstext =
				"jQuery(function(){\n"
				. "	jQuery.datepicker.regional['wiki'] = {\n"
				. "		closeText: '" . Xml::escapeJsString( wfMsg( 'semanticformsinputs-close' ) ) . "',\n"
				. "		prevText: '" . Xml::escapeJsString( wfMsg( 'semanticformsinputs-prev' ) ) . "',\n"
				. "		nextText: '" . Xml::escapeJsString( wfMsg( 'semanticformsinputs-next' ) ) . "',\n"
				. "		currentText: '" . Xml::escapeJsString( wfMsg( 'semanticformsinputs-today' ) ) . "',\n"
				. "		monthNames: ['"
				. Xml::escapeJsString( wfMsg( 'january' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'february' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'march' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'april' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'may_long' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'june' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'july' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'august' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'september' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'october' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'november' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'december' ) ) . "'],\n"
				. "		monthNamesShort: ['"
				. Xml::escapeJsString( wfMsg( 'jan' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'feb' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'mar' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'apr' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'may' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'jun' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'jul' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'aug' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'sep' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'oct' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'nov' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'dec' ) ) . "'],\n"
				. "		dayNames: ['"
				. Xml::escapeJsString( wfMsg( 'sunday' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'monday' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'tuesday' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'wednesday' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'thursday' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'friday' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'saturday' ) ) . "'],\n"
				. "		dayNamesShort: ['"
				. Xml::escapeJsString( wfMsg( 'sun' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'mon' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'tue' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'wed' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'thu' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'fri' ) ) . "','"
				. Xml::escapeJsString( wfMsg( 'sat' ) ) . "'],\n"
				. "		dayNamesMin: ['"
				. Xml::escapeJsString( $wgLang->firstChar( wfMsg( 'sun' ) ) ) . "','"
				. Xml::escapeJsString( $wgLang->firstChar( wfMsg( 'mon' ) ) ) . "','"
				. Xml::escapeJsString( $wgLang->firstChar( wfMsg( 'tue' ) ) ) . "','"
				. Xml::escapeJsString( $wgLang->firstChar( wfMsg( 'wed' ) ) ) . "','"
				. Xml::escapeJsString( $wgLang->firstChar( wfMsg( 'thu' ) ) ) . "','"
				. Xml::escapeJsString( $wgLang->firstChar( wfMsg( 'fri' ) ) ) . "','"
				. Xml::escapeJsString( $wgLang->firstChar( wfMsg( 'sat' ) ) ) . "'],\n"
				. "		weekHeader: '',\n"
				. "		dateFormat: '" . Xml::escapeJsString( wfMsg( 'semanticformsinputs-dateformatshort' ) ) . "',\n"
				. "		firstDay: '" . Xml::escapeJsString( wfMsg( 'semanticformsinputs-firstdayofweek' ) ) . "',\n"
				. "		isRTL: " . ( $wgLang->isRTL() ? "true" : "false" ) . ",\n"
				. "		showMonthAfterYear: false,\n"
				. "		yearSuffix: ''};\n"
				. "	jQuery.datepicker.setDefaults(jQuery.datepicker.regional['wiki']);\n"
				. "});\n";

			$wgOut->addScript( Html::inlineScript(  $jstext ) );
			
		}
	}
	
	/**
	 * Set up JS attributes
	 * 
	 * @return String
	 */
	protected function setupJsInitAttribs() {

		global $sfigSettings;
		global $wgAmericanDates;

		// store user class(es) for use with buttons
		$userClasses = array_key_exists( 'class', $this->mOtherArgs ) ? $this->mOtherArgs['class'] : '';

		// set up attributes required for both enabled and disabled datepickers
		$jsattribs = array(
				'currValue' => $this->mCurrentValue,
				'disabled' => $this->mIsDisabled,
				'userClasses' => $userClasses
		);

		if ( array_key_exists( 'part of dtp', $this->mOtherArgs ) ) {
			$jsattribs['partOfDTP'] = $this->mOtherArgs['part of dtp'];
		}

		// set date format
		// SHORT and LONG are SFI specific acronyms and are translated here
		// into format strings, anything else is passed to the jQuery date picker
		// Americans need special treatment
		if ( $wgAmericanDates && $wgLang->getCode() == "en" ) {

			if ( array_key_exists( 'date format', $this->mOtherArgs ) ) {

				if ( $this->mOtherArgs['date format'] == 'SHORT' ) {
					$jsattribs['dateFormat'] = 'mm/dd/yy';
				} elseif ( $this->mOtherArgs['date format'] == 'LONG' ) {
					$jsattribs['dateFormat'] = 'MM d, yy';
				} else {
					$jsattribs['dateFormat'] = $this->mOtherArgs['date format'];
				}

			} elseif ( $sfigSettings->datePickerDateFormat ) {

				if ( $sfigSettings->datePickerDateFormat == 'SHORT' ) {
					$jsattribs['dateFormat'] = 'mm/dd/yy';
				} elseif ( $sfigSettings->datePickerDateFormat == 'LONG' ) {
					$jsattribs['dateFormat'] = 'MM d, yy';
				} else {
					$jsattribs['dateFormat'] = $sfigSettings->datePickerDateFormat;
				}

			} else $jsattribs['dateFormat'] = 'yy/mm/dd';

		} else {

			if ( array_key_exists( 'date format', $this->mOtherArgs ) ) {

				if ( $this->mOtherArgs['date format'] == 'SHORT' ) {
					$jsattribs['dateFormat'] = wfMsg( 'semanticformsinputs-dateformatshort' );
				} elseif ( $this->mOtherArgs['date format'] == 'LONG' ) {
					$jsattribs['dateFormat'] = wfMsg( 'semanticformsinputs-dateformatlong' );
				} else {
					$jsattribs['dateFormat'] = $this->mOtherArgs['date format'];
				}

			} elseif ( $sfigSettings->datePickerDateFormat ) {

				if ( $sfigSettings->datePickerDateFormat == 'SHORT' ) {
					$jsattribs['dateFormat'] = wfMsg( 'semanticformsinputs-dateformatshort' );
				} elseif ( $sfigSettings->datePickerDateFormat == 'LONG' ) {
					$jsattribs['dateFormat'] = wfMsg( 'semanticformsinputs-dateformatlong' );
				} else {
					$jsattribs['dateFormat'] = $sfigSettings->datePickerDateFormat;
				}

			} else $jsattribs['dateFormat'] = 'yy/mm/dd';

		}

		// setup attributes required only for either disabled or enabled datepickers
		if ( $this->mIsDisabled ) {

			$jsattribs['buttonImage'] = $sfigSettings->scriptPath . '/images/DatePickerButtonDisabled.gif';

			if ( array_key_exists( 'show reset button', $this->mOtherArgs ) ||
					( !array_key_exists( 'hide reset button', $this->mOtherArgs ) && $sfigSettings->datePickerShowResetButton ) ) {

				$jsattribs['resetButtonImage'] = $sfigSettings->scriptPath . '/images/DatePickerResetButtonDisabled.gif';

			}

		} else {

			$jsattribs['buttonImage'] = $sfigSettings->scriptPath . '/images/DatePickerButton.gif';

			if ( array_key_exists( 'show reset button', $this->mOtherArgs ) ||
					( !array_key_exists( 'hide reset button', $this->mOtherArgs ) && $sfigSettings->datePickerShowResetButton ) ) {

				$jsattribs['resetButtonImage'] = $sfigSettings->scriptPath . '/images/DatePickerResetButton.gif';

			}

			// find min date, max date and disabled dates

			// set first date
			if ( array_key_exists( 'first date', $this->mOtherArgs ) ) {
				$minDate = date_create( $this->mOtherArgs['first date'] );
			} elseif ( $sfigSettings->datePickerFirstDate ) {
				$minDate = date_create( $sfigSettings->datePickerFirstDate );
			} else {
				$minDate = null;
			}

			// set last date
			if ( array_key_exists( 'last date', $this->mOtherArgs ) ) {
				$maxDate = date_create( $this->mOtherArgs['last date'] );
			} elseif ( $sfigSettings->datePickerLastDate ) {
				$maxDate = date_create( $sfigSettings->datePickerLastDate );
			} else {
				$maxDate = null;
			}

			// find allowed values and invert them to get disabled values
			if ( array_key_exists( 'possible_values', $this->mOtherArgs ) && count( $this->mOtherArgs['possible_values'] ) ) {

				$enabledDates = self::sortAndMergeRanges( self::createRangesArray( $this->mOtherArgs['possible_values'] ) );

				// correct min/max date to the first/last allowed value
				if ( !$minDate || $minDate < $enabledDates[0][0] ) {
					$minDate = $enabledDates[0][0];
				}

				if ( !$maxDate || $maxDate > $enabledDates[count( $enabledDates ) - 1][1] ) {
					$maxDate = $enabledDates[count( $enabledDates ) - 1][1];
				}

				$disabledDates = self::invertRangesArray( $enabledDates );

			} else $disabledDates = array();

			// add user-defined or default disabled values
			if ( array_key_exists( 'disable dates', $this->mOtherArgs ) ) {

				$disabledDates =
						self::sortAndMergeRanges(
						array_merge( $disabledDates, self::createRangesArray( explode( ',' , $this->mOtherArgs['disable dates'] ) ) ) );

			} elseif ( $sfigSettings->datePickerDisabledDates ) {

				$disabledDates =
						self::sortAndMergeRanges(
						array_merge( $disabledDates, self::createRangesArray( explode( ',' , $sfigSettings->datePickerDisabledDates ) ) ) );

			}

			// if a minDate is set, discard all disabled dates below the min date
			if ( $minDate ) {

				// discard all ranges of disabled dates that are entirely below the min date
				while ( $minDate && count( $disabledDates ) && $disabledDates[0][1] < $minDate ) array_shift( $disabledDates );

				// if min date is in first disabled date range, discard that range and adjust min date
				if ( count( $disabledDates ) && $disabledDates[0][0] <= $minDate && $disabledDates[0][1] >= $minDate ) {
					$minDate = $disabledDates[0][1];
					array_shift( $disabledDates );
					$minDate->modify( "+1 day" );
				}
			}

			// if a maxDate is set, discard all disabled dates above the max date
			if ( $maxDate ) {

				// discard all ranges of disabled dates that are entirely above the max date
				while ( count( $disabledDates ) && $disabledDates[count( $disabledDates ) - 1][0] > $maxDate ) array_pop( $disabledDates );

				// if max date is in last disabled date range, discard that range and adjust max date
				if ( count( $disabledDates ) && $disabledDates[count( $disabledDates ) - 1][0] <= $maxDate && $disabledDates[count( $disabledDates ) - 1][1] >= $maxDate ) {
					$maxDate = $disabledDates[count( $disabledDates ) - 1][0];
					array_pop( $disabledDates );
					$maxDate->modify( "-1 day" );
				}
			}
			// finished with disabled dates

			// find highlighted dates
			if ( array_key_exists( "highlight dates", $this->mOtherArgs ) ) {
				$highlightedDates = self::sortAndMergeRanges ( self::createRangesArray( explode( ',' , $this->mOtherArgs["highlight dates"] ) ) ) ;
			} elseif ( $sfigSettings->datePickerHighlightedDates ) {
				$highlightedDates = self::sortAndMergeRanges ( self::createRangesArray( explode( ',' , $sfigSettings->datePickerHighlightedDates  ) ) ) ;
			} else {
				$highlightedDates = null;
			}


			// find disabled week days and mark them in an array
			if ( array_key_exists( "disable days of week", $this->mOtherArgs ) ) {
				$disabledDaysString = $this->mOtherArgs['disable days of week'];
			} else {
				$disabledDaysString = $sfigSettings->datePickerDisabledDaysOfWeek;
			}

			if ( $disabledDaysString != null ) {

				$disabledDays = array( false, false, false, false, false, false, false );

				foreach ( explode( ',', $disabledDaysString ) as $day ) {

					if ( is_numeric( $day ) && $day >= 0 && $day <= 6 ) {
						$disabledDays[$day] = true;
					}

				}

			} else {
				$disabledDays = null;
			}

			// find highlighted week days and mark them in an array
			if ( array_key_exists( "highlight days of week", $this->mOtherArgs ) ) {
				$highlightedDaysString = $this->mOtherArgs['highlight days of week'];
			} else {
				$highlightedDaysString = $sfigSettings->datePickerHighlightedDaysOfWeek;
			}

			if ( $highlightedDaysString != null ) {

				$highlightedDays = array( false, false, false, false, false, false, false );

				foreach ( explode( ',', $highlightedDaysString ) as $day ) {

					if ( is_numeric( $day ) && $day >= 0 && $day <= 6 ) {
						$highlightedDays[$day] = true;
					}

				}

			} else {
				$highlightedDays = null;
			}

			// set first day of the week
			if ( array_key_exists( 'week start', $this->mOtherArgs ) ) {
				$jsattribs['firstDay'] = $this->mOtherArgs['week start'];
			} elseif ( $sfigSettings->datePickerWeekStart != null ) {
				$jsattribs['firstDay'] = $sfigSettings->datePickerWeekStart;
			} else {
				$jsattribs['firstDay'] = wfMsg( 'semanticformsinputs-firstdayofweek' );
			}

			// set show week number
			if ( array_key_exists( 'show week numbers', $this->mOtherArgs )
					|| ( !array_key_exists( 'hide week numbers', $this->mOtherArgs ) && $sfigSettings->datePickerShowWeekNumbers ) ) {

				$jsattribs['showWeek'] = true;
			} else {
				$jsattribs['showWeek'] = false;
			}

			// store min date as JS attrib
			if ( $minDate ) {
				$jsattribs['minDate'] = $minDate->format( 'Y/m/d' );
			}

			// store max date as JS attrib
			if ( $maxDate ) {
				$jsattribs['maxDate'] = $maxDate->format( 'Y/m/d' );
			}

			// register disabled dates with datepicker
			if ( count( $disabledDates ) > 0 ) {

				// convert the PHP array of date ranges into an array of numbers
				$jsattribs["disabledDates"] = array_map( create_function ( '$range', '

							$y0 = $range[0]->format( "Y" );
							$m0 = $range[0]->format( "m" ) - 1;
							$d0 = $range[0]->format( "d" );

							$y1 = $range[1]->format( "Y" );
							$m1 = $range[1]->format( "m" ) - 1;
							$d1 = $range[1]->format( "d" );

							return array($y0, $m0, $d0, $y1, $m1, $d1);
						' ) , $disabledDates );
			}

			// register highlighted dates with datepicker
			if ( count( $highlightedDates ) > 0 ) {

				// convert the PHP array of date ranges into an array of numbers
				$jsattribs["highlightedDates"] = array_map( create_function ( '$range', '

							$y0 = $range[0]->format( "Y" );
							$m0 = $range[0]->format( "m" ) - 1;
							$d0 = $range[0]->format( "d" );

							$y1 = $range[1]->format( "Y" );
							$m1 = $range[1]->format( "m" ) - 1;
							$d1 = $range[1]->format( "d" );

							return array($y0, $m0, $d0, $y1, $m1, $d1);
						' ) , $highlightedDates );
			}

			// register disabled days of week with datepicker
			if ( count( $disabledDays ) > 0 ) {
				$jsattribs["disabledDays"] = $disabledDays;
			}

			// register highlighted days of week with datepicker
			if ( count( $highlightedDays ) > 0 ) {
				$jsattribs["highlightedDays"] = $highlightedDays;
			}
		}

		// build JS code from attributes array
		return json_encode( $jsattribs );
		
	}

	/**
	 * Sort and merge time ranges in an array
	 *
	 * expects an array of arrays
	 * the inner arrays must contain two dates representing the start and end
	 * date of a time range
	 *
	 * returns an array of arrays with the date ranges sorted and overlapping
	 * ranges merged
	 *
	 * @param array $ranges array of arrays of DateTimes
	 * @return array of arrays of DateTimes
	*/
	static private function sortAndMergeRanges ( $ranges ) {

		// sort ranges, earliest date first
		sort( $ranges );

		// stores the start of the current date range
		$currmin = FALSE;

		// stores the date the next ranges start date has to top to not overlap
		$nextmin = FALSE;

		// result array
		$mergedRanges = array();

		foreach ( $ranges as $range ) {

			// ignore empty date ranges
			if ( !$range ) continue;

			if ( !$currmin ) { // found first valid range

				$currmin = $range[0];
				$nextmin = $range[1];
				$nextmin->modify( '+1 day' );

			} elseif ( $range[0] <=  $nextmin ) { // overlap detected

				$currmin = min( $currmin, $range[0] );

				$range[1]->modify( '+1 day' );
				$nextmin = max( $nextmin, $range[1] );

			} else { // no overlap, store current range and continue with next

				$nextmin->modify( '-1 day' );
				$mergedRanges[] = array( $currmin, $nextmin );

				$currmin = $range[0];
				$nextmin = $range[1];
				$nextmin->modify( '+1 day' );

			}

		}

		// store last range
		if ( $currmin ) {
			$nextmin->modify( '-1 day' );
			$mergedRanges[] = array( $currmin, $nextmin );
		}

		return $mergedRanges;

	}

	/**
	 * Creates an array of arrays of dates from an array of strings
	 *
	 * expects an array of strings containing dates or date ranges in the format
	 * "yyyy/mm/dd" or "yyyy/mm/dd-yyyy/mm/dd"
	 *
	 * returns an array of arrays, each of the latter consisting of two dates
	 * representing the start and end date of the range
	 *
	 * The result array will contain null values for unparseable date strings
	 *
	 * @param array $rangesAsStrings array of strings with dates and date ranges
	 * @return array of arrays of DateTimes
	*/
   static private function createRangesArray ( $rangesAsStrings ) {

	   // transform array of strings into array of array of dates
	   // have to use create_function to be PHP pre5.3 compatible
	   return array_map( create_function( '$range', '

					if ( strpos ( $range, "-" ) === FALSE ) { // single date
						$date = date_create( $range );
						return ( $date ) ? array( $date, clone $date ):null;
					} else { // date range
						$dates = array_map( "date_create", explode( "-", $range ) );
						return  ( $dates[0] && $dates[1] ) ? $dates:null;
					}

					' ), $rangesAsStrings );

   }

	/**
	 * Takes an array of date ranges and returns an array containing the gaps
	 *
	 * The very first and the very last date of the original string are lost in
	 * the process, of course, as they do not delimit a gap. This means, after
	 * repeated inversion the result will eventually be empty.
	 *
	 * @param array $ranges of arrays of DateTimes
	 * @return array of arrays of DateTimes
	*/
	static private function invertRangesArray( $ranges ) {

		// the result (initially empty)
		$invRanges = null;

		// the minimum of the current gap (initially none)
		$min = null;

		foreach ( $ranges as $range ) {

			if ( $min ) { // if min date of current gap is known store gap
				$min->modify( "+1day " );
				$range[0]->modify( "-1day " );
				$invRanges[] = array( $min, $range[0] );
			}

			$min = $range[1];  // store min date of next gap

		}

		return $invRanges;
	}

	/**
	 * Returns the set of parameters for this form input.
	 * 
	 * TODO: Add missing parameters
	 */
	public static function getParameters() {
		global $sfigSettings;
		
		$params = parent::getParameters();
		$params[] = array(
			'name' => 'date format',
			'type' => 'string',
			'description' => wfMsg( 'semanticformsinputs-datepicker-dateformat' )
		);
		$params[] = array(
			'name' => 'week start',
			'type' => 'int',
			'description' => wfMsg( 'semanticformsinputs-datepicker-weekstart' )
		);
		$params[] = array(
			'name' => 'first date',
			'type' => 'string',
			'description' => wfMsg( 'semanticformsinputs-datepicker-firstdate' )
		);
		$params[] = array(
			'name' => 'last date',
			'type' => 'string',
			'description' => wfMsg( 'semanticformsinputs-datepicker-lastdate' )
		);
		$params[] = array(
			'name' => 'disable days of week',
			'type' => 'string',
			'description' => wfMsg( 'semanticformsinputs-datepicker-disabledaysofweek' )
		);
		$params[] = array(
			'name' => 'highlight days of week',
			'type' => 'string',
			'description' => wfMsg( 'semanticformsinputs-datepicker-highlightdaysofweek' )
		);
		$params[] = array(
			'name' => 'disable dates',
			'type' => 'string',
			'description' => wfMsg( 'semanticformsinputs-datepicker-disabledates' )
		);
		$params[] = array(
			'name' => 'highlight days of week',
			'type' => 'string',
			'description' => wfMsg( 'semanticformsinputs-datepicker-highlightdates' )
		);
		$params[] = array(
			'name' => $sfigSettings->datePickerShowWeekNumbers?'hide week numbers':'show week numbers',
			'type' => 'boolean',
			'description' => wfMsg( 'semanticformsinputs-datepicker-showweeknumbers' )
		);
		$params[] = array(
			'name' => $sfigSettings->datePickerDisableInputField?'enable input field':'disable input field',
			'type' => 'boolean',
			'description' => wfMsg( 'semanticformsinputs-datepicker-enableinputfield' )
		);
		$params[] = array(
			'name' => $sfigSettings->datePickerShowResetButton?'hide reset button':'show reset button',
			'type' => 'boolean',
			'description' => wfMsg( 'semanticformsinputs-datepicker-showresetbutton' )
		);
		return $params;
	}

	/**
	 * Returns the HTML code to be included in the output page for this input.
	 *
	 * Ideally this HTML code should provide a basic functionality even if the
	 * browser is not JavaScript capable. I.e. even without JavaScript the user
	 * should be able to input values.
	 *
	 */
	public function getHtmlText() {
		
		global $sfigSettings; // SFI variables

		// should the input field be disabled?
		$inputFieldDisabled =
			array_key_exists( 'disable input field', $this->mOtherArgs )
			|| ( !array_key_exists( 'enable input field', $this->mOtherArgs ) && $sfigSettings->datePickerDisableInputField )
			|| $this->mIsDisabled	;

		// assemble HTML code
		$html = SFIUtils::textHTML( $this->mCurrentValue, $this->mInputName, $inputFieldDisabled, $this->mOtherArgs, 'input_' . $this->mInputNumber );

		if ( ! array_key_exists( 'part of dtp', $this->mOtherArgs ) ) {
			
			// wrap in span (e.g. used for mandatory inputs)
			$class = array_key_exists( 'mandatory', $this->mOtherArgs ) ? 'inputSpan mandatoryFieldSpan' : 'inputSpan';
			$html = Xml::tags('span', array('class'=>  $class ), $html );
			
		}

		return $html;
	}

	/**
	 * Returns the set of SMW property types which this input can
	 * handle, but for which it isn't the default input.
	 *
	 * @return Array of strings
	 */
	public static function getOtherPropTypesHandled() {
		return array('_str', '_dat');
	}
}

