<?php

/**
 * A class to print query results in a monthly calendar.
 */

if ( !defined( 'MEDIAWIKI' ) ) die();

global $srfgIP;
$wgAutoloadClasses['SRFCHistoricalDate'] = $srfgIP . '/Calendar/SRFC_HistoricalDate.php';

class SRFCalendar extends SMWResultPrinter {

	protected $mTemplate = '';
	protected $mUserParam = '';
	protected $mRealUserLang = null;

	protected function readParameters( $params, $outputmode ) {
		SMWResultPrinter::readParameters( $params, $outputmode );

		if ( array_key_exists( 'template', $params ) ) {
			$this->mTemplate = trim( $params['template'] );
		}
		if ( array_key_exists( 'userparam', $params ) ) {
			$this->mUserParam = trim( $params['userparam'] );
		}
		if ( array_key_exists( 'lang', $params ) ) {
			global $wgLang;
			// store the actual user's language, so we can revert
			// back to it after printing the calendar
			$this->mRealUserLang = clone ( $wgLang );
			$wgLang = Language::factory( trim( $params['lang'] ) );
		}
	}

	public function getName() {
		return wfMsg( 'srf_printername_calendar' );
	}

	public function getResult( $results, $params, $outputmode ) {
		$this->isHTML = false;
		$this->hasTemplates = false;

		// skip checks, results with 0 entries are normal
		$this->readParameters( $params, $outputmode );
		return $this->getResultText( $results, SMW_OUTPUT_HTML );
	}

	protected function getResultText( $res, $outputmode ) {
		global $smwgIQRunningNumber, $wgUser;
		$skin = $wgUser->getSkin();
		$result = "";

		$events = array();
		// print all result rows
		while ( $row = $res->getNext() ) {
			$dates = array();
			$title = $text = $color = "";

			if ( $this->mTemplate != '' ) { // build template code
				$this->hasTemplates = true;
				if ( $this->mUserParam )
					$text = "|userparam=$this->mUserParam";
				foreach ( $row as $i => $field ) {
					$pr = $field->getPrintRequest();
					$text .= '|' . ( $i + 1 ) . '=';
					while ( ( $object = $field->getNextObject() ) !== false ) {
						if ( $object->getTypeID() == '_dat' ) {
							$text .= $object->getLongWikiText();
						} elseif ( $object->getTypeID() == '_wpg' ) { // use shorter "LongText" for wikipage
							// handling of "link=" param
							if ( $this->mLinkOthers ) {
								$text .= $object->getLongText( $outputmode, null );
							} else {
								$text .= $object->getWikiValue();
							}
						} else {
							$text .= $object->getShortText( $outputmode, null );
						}
						if ( $pr->getMode() == SMWPrintRequest::PRINT_PROP && $pr->getTypeID() == '_dat' ) {
							$dates[] = SRFCalendar::formatDateStr( $object );
						}
					}
				}
			} else {  // build simple text
				$numNonDateProperties = 0;
				// cycle through a 'row', which is the page
				// name (the first field) plus all its
				// properties
				foreach ( $row as $i => $field ) {
					$pr = $field->getPrintRequest();
					// a property can have more than one
					// value - cycle through all the values
					// for this property
					$textForProperty = '';
					while ( ( $object = $field->getNextObject() ) !== false ) {
						if ( $object->getTypeID() == '_dat' ) {
							// don't add date values to the display
						} elseif ( $object->getTypeID() == '_wpg' ) { // use shorter "LongText" for wikipage
							if ( $i == 0 ) {
								$title = Title::newFromText( $object->getShortWikiText( false ) );
							} else {
								$numNonDateProperties++;
								// handling of "headers=" param
								if ( $this->mShowHeaders == SMW_HEADERS_SHOW ) {
									$textForProperty .= $pr->getHTMLText( $skin ) . " ";
								} elseif ( $this->mShowHeaders == SMW_HEADERS_PLAIN ) {
									$textForProperty .= $pr->getLabel() . " ";
								}
								// if $this->mShowHeaders == SMW_HEADERS_HIDE, print nothing
								// handling of "link=" param
								if ( $this->mLinkOthers ) {
									$textForProperty .= $object->getLongText( $outputmode, $skin );
								} else {
									$textForProperty .= $object->getWikiValue();
								}
							}
						} else {
							$numNonDateProperties++;
							$textForProperty .= $pr->getHTMLText( $skin ) . " " . $object->getShortText( $outputmode, $skin );
						}
						if ( $pr->getMode() == SMWPrintRequest::PRINT_PROP && $pr->getTypeID() == '_dat' ) {
							$dates[] = SRFCalendar::formatDateStr( $object );
						}
					}
					// add the text for this property to
					// the main text, adding on parentheses
					// or commas as needed
					if ( $numNonDateProperties == 1 ) {
						$text .= " (";
					} elseif ( $numNonDateProperties > 1 ) {
						$text .= ", ";
					}
					$text .= $textForProperty;
				}
				if ( $numNonDateProperties > 0 ) {
					$text .= ")";
				}
			}
			if ( count( $dates ) > 0 ) {
				// handle the 'color=' value, whether it came
				// from a compound query or a regular one
				// handling is different for SMW 1.5+
				if ( method_exists( 'SMWQueryResult', 'getResults' ) ) {
					$res_subject = $field->getResultSubject();
					if ( isset( $res_subject->display_options ) && is_array( $res_subject->display_options ) && array_key_exists( 'color', $res_subject->display_options ) )
						$color = $res_subject->display_options['color'];
				} elseif ( property_exists( $row[0], 'display_options' ) ) {
					if ( is_array( $row[0]->display_options ) && array_key_exists( 'color', $row[0]->display_options ) )
						$color = $row[0]->display_options['color'];
				} elseif ( array_key_exists( 'color', $this->m_params ) ) {
					$color = $this->m_params['color'];
				}
				foreach ( $dates as $date ) {
					$events[] = array( $title, $text, $date, $color );
				}
			}
		}

		$result = SRFCalendar::displayCalendar( $events );
		// go back to the actual user's language, in case a different
		// language had been specified for this calendar
		if ( ! is_null( $this->mRealUserLang ) ) {
			global $wgLang;
			$wgLang = $this->mRealUserLang;
		}
		global $wgParser;
		if ( is_null( $wgParser->getTitle() ) )
			return $result;
		else
			return array( $result, 'noparse' => 'true', 'isHTML' => 'true' );
	}


	function intToMonth( $int ) {
		if ( $int == '2' ) { return wfMsg( 'february' ); }
		if ( $int == '3' ) { return wfMsg( 'march' ); }
		if ( $int == '4' ) { return wfMsg( 'april' ); }
		if ( $int == '5' ) { return wfMsg( 'may' ); }
		if ( $int == '6' ) { return wfMsg( 'june' ); }
		if ( $int == '7' ) { return wfMsg( 'july' ); }
		if ( $int == '8' ) { return wfMsg( 'august' ); }
		if ( $int == '9' ) { return wfMsg( 'september' ); }
		if ( $int == '10' ) { return wfMsg( 'october' ); }
		if ( $int == '11' ) { return wfMsg( 'november' ); }
		if ( $int == '12' ) { return wfMsg( 'december' ); }
		// keep it simple - if it's '1' or anything else, return January
		return wfMsg( 'january' );
	}


	function formatDateStr( $object ) {
		// For some reason, getMonth() and getDay() sometimes return a
		// number with a leading zero - get rid of it using (int)
		return $object->getYear() . '-' . (int)$object->getMonth() . '-' . (int)$object->getDay();
	}

	function displayCalendar( $events ) {
		global $wgOut, $srfgScriptPath, $wgParser, $wgRequest;

		$wgParser->disableCache();

		$wgOut->addLink( array(
			'rel' => 'stylesheet',
			'type' => 'text/css',
			'media' => "screen, print",
			'href' => $srfgScriptPath . "/Calendar/skins/SRFC_main.css"
		) );

		// Set variables differently depending on whether this is
		// being called from a regular page, via #ask, or from a
		// special page: most likely either Special:Ask or
		// Special:RunQuery.
		$page_title = $wgParser->getTitle();
		$additional_query_string = '';
		$hidden_inputs = '';
		$in_special_page = is_null( $page_title ) || $page_title->isSpecialPage();
		if ( $in_special_page ) {
			global $wgTitle;
			$page_title = $wgTitle;
			global $wgUser;
			$skin = $wgUser->getSkin();
			$request_values = $wgRequest->getValues();
			// Also go through the predefined PHP variable
			// $_REQUEST, because $wgRequest->getValues() for
			// some reason doesn't return array values - is
			// there a better (less hacky) way to do this?
			foreach ( $_REQUEST as $key => $value ) {
				if ( is_array( $value ) ) {
					foreach ($value as $k2 => $v2 ) {
						$new_key = $key . '[' . $k2 . ']';
						$request_values[$new_key] = $v2;
					}
				}
			}
			foreach ( $request_values as $key => $value ) {
				if ( $key != 'month' && $key != 'year'
					// values from 'RunQuery'
			       		&& $key != 'query' && $key != 'free_text'
				) {
					$additional_query_string .= "&$key=$value";
					$hidden_inputs .= "<input type=\"hidden\" name=\"$key\" value=\"$value\" />";
				}
			}
		} else {
			$skin = $wgParser->getOptions()->getSkin();
		}
		// get all the date-based values we need - the current month
		// and year (i.e., the one the user is looking at - not
		// necessarily the "current" ones), the previous and next months
		// and years (same - note that the previous or next month could
		// be in a different year), the number of days in the current,
		// previous and next months, etc.
		$cur_month_num = date( "n", time() );
		if ( $wgRequest->getCheck( 'month' ) ) {
			$query_month = $wgRequest->getVal( 'month' );
			if ( is_numeric( $query_month ) && ( intval( $query_month ) == $query_month ) && $query_month >= 1 && $query_month <= 12 ) {
				$cur_month_num = $wgRequest->getVal( 'month' );
			}
		}
		$cur_month = SRFCalendar::intToMonth( $cur_month_num );
		$cur_year = date( "Y", time() );
		if ( $wgRequest->getCheck( 'year' ) ) {
			$query_year = $wgRequest->getVal( 'year' );
			if ( is_numeric( $query_year ) && intval( $query_year ) == $query_year ) {
				$cur_year = $wgRequest->getVal( 'year' );
			}
		}
		if ( $cur_month_num == '1' ) {
			$prev_month_num = '12';
			$prev_year = $cur_year - 1;
		} else {
			$prev_month_num = $cur_month_num - 1;
			$prev_year = $cur_year;
		}
		if ( $cur_month_num == '12' ) {
			$next_month_num = '1';
			$next_year = $cur_year + 1;
		} else {
			$next_month_num = $cur_month_num + 1;
			$next_year = $cur_year;
		}
		// there's no year '0' - change it to '1' or '-1'
		if ( $cur_year == "0" ) { $cur_year = "1"; }
		if ( $next_year == "0" ) { $next_year = "1"; }
		if ( $prev_year == "0" ) { $prev_year = "-1"; }
		$prev_month_url = $page_title->getLocalURL( "month=$prev_month_num&year=$prev_year" . $additional_query_string );
		$next_month_url = $page_title->getLocalURL( "month=$next_month_num&year=$next_year" . $additional_query_string );
		$today_url = $page_title->getLocalURL( $additional_query_string );
		$today_text = wfMsg( 'srfc_today' );
		$prev_month_text = wfMsg( 'srfc_previousmonth' );
		$next_month_text = wfMsg( 'srfc_nextmonth' );
		$go_to_month_text = wfMsg( 'srfc_gotomonth' );

		// get day of the week that the first of this month falls on
		$first_day = new SRFCHistoricalDate();
		$first_day->create( $cur_year, $cur_month_num, 1 );
		$day_of_week_of_1 = $first_day->getDayOfWeek();
		$start_day = 1 - $day_of_week_of_1;
		$days_in_prev_month = SRFCHistoricalDate::daysInMonth( $prev_year, $prev_month_num );
		$days_in_cur_month = SRFCHistoricalDate::daysInMonth( $cur_year, $cur_month_num );
		$today_string = date( "Y n j", time() );
		$url_year = $wgRequest->getVal( 'year' );
		$page_name = $page_title->getPrefixedDbKey();

		// create table for holding title and navigation information
		$text = <<<END
<table class="navigation_table">
<tr>
<td class="month_name">$cur_month $cur_year</td>
<td class="nav_links">
<a href="$prev_month_url" title="$prev_month_text"><img src="$srfgScriptPath/Calendar/skins/left-arrow.png" border="0" /></a>
&#160;
<a href="$today_url">$today_text</a>
&#160;
<a href="$next_month_url" title="$next_month_text"><img src="$srfgScriptPath/Calendar/skins/right-arrow.png" border="0" /></a>
</td>
<td class="nav_form">
<form>
<input type="hidden" name="title" value="$page_name">
<select name="month">

END;
		for ( $i = 1; $i <= 12; $i++ ) {
			$month_name = SRFCalendar::intToMonth( $i );
			$selected_str = ( $i == $cur_month_num ) ? "selected" : "";
			$text .= "<option value=\"$i\" $selected_str>$month_name</option>\n";
		}
		$text .= <<<END
</select>
<input name="year" type="text" value="$cur_year" size="4">
$hidden_inputs
<input type="submit" value="$go_to_month_text">
</form>
</td>
</tr>
</table>

<table class="month_calendar">
<tr class="weekdays">

END;
		// first row of the main table holds the days of the week
		$week_days = array( wfMsg( 'sunday' ), wfMsg( 'monday' ), wfMsg( 'tuesday' ), wfMsg( 'wednesday' ), wfMsg( 'thursday' ), wfMsg( 'friday' ), wfMsg( 'saturday' ) );
		foreach ( $week_days as $week_day ) {
			$text .= "<td>$week_day</td>";
		}
		$text .= "</tr>\n";

		// now, create the calendar itself -
		// loop through a set of weeks, from a Sunday (which might be
		// before the beginning of the month) to a Saturday (which might
		// be after the end of the month)
		$day_of_the_week = 1;
		$is_last_week = false;
		for ( $day = $start_day; ( ! $is_last_week || $day_of_the_week != 1 ); $day++ ) {
			if ( $day_of_the_week == 1 ) {
				$text .= "<tr>\n";
			}
			if ( "$cur_year $cur_month_num $day" == $today_string ) {
				$text .= "<td class=\"today\">\n";
			} elseif ( $day_of_the_week == 1 || $day_of_the_week == 7 ) {
				$text .= "<td class=\"weekend_day\">\n";
			} else {
				$text .= "<td>\n";
			}
			if ( $day == $days_in_cur_month || $day > 50 ) { $is_last_week = true; }
			// if this day is before or after the current month, set a
			// "display day" to show on the calendar, and use a different
			// CSS style for it
			if ( $day > $days_in_cur_month || $day < 1 ) {
				if ( $day < 1 ) {
					$display_day = $day + $days_in_prev_month;
					$date_str = $prev_year . '-' . $prev_month_num . '-' . $display_day;
				}
				if ( $day > $days_in_cur_month ) {
					$display_day = $day - $days_in_cur_month;
					$date_str = $next_year . '-' . $next_month_num . '-' . $display_day;
				}
				$text .= "<div class=\"day day_other_month\">$display_day</div>\n";
			} else {
				$date_str = $cur_year . '-' . $cur_month_num . '-' . $day;
				$text .= "<div class=\"day\">$day</div>\n";
			}
			// finally, the most important step - get the events that
			// match this date, and the given set of criteria, and
			// display them in this date's box
			$text .= "<div class=\"main\">\n";
			// avoid errors if array is null
			if ( $events == null )
				$events = array();
			foreach ( $events as $event ) {
				list( $event_title, $other_text, $event_date, $color ) = $event;
				if ( $event_date == $date_str ) {
					if ( $this->mTemplate != '' ) {
						$templatetext = '{{' . $this->mTemplate . $other_text . '|thisdate=' . $date_str . '}}';
						$templatetext = $wgParser->replaceVariables( $templatetext );
						$templatetext = $wgParser->recursiveTagParse( $templatetext );
						$text .= $templatetext;
					} else {
						$event_str = $skin->makeLinkObj( $event_title );
						if ( $color != '' ) {
							$text .= "<p class=\"colored-entry\" style=\"border-left: 7px $color solid;\">$event_str $other_text</p>\n";
						} else {
							$text .= "$event_str $other_text\n\n";
						}
					}
				}
			}
			$text .= <<<END
</div>
</td>

END;
			if ( $day_of_the_week == 7 ) {
				$text .= "</tr>\n";
				$day_of_the_week = 1;
			} else {
				$day_of_the_week++;
			}
		}
		$text .= "</table>\n";

		return $text;
	}

        public function getParameters() {
                $params = parent::getParameters();
                $params[] = array( 'name' => 'lang', 'type' => 'string', 'description' => wfMsg( 'srf_paramdesc_calendarlang' ) );
                return $params;
        }

}
