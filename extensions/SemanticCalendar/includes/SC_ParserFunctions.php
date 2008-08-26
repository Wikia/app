<?php
/**
 * Parser functions for Semantic Calendar.
 *
 * There is currently one parser function defined: 'semantic_calendar'.
 *
 * 'semantic_calendar' is called as:
 *
 * {{#semantic_calendar:date property|query filters}}
 *
 * This function returns HTML that displays a monthly calendar, showing
 * the titles of pages based on their semantic date information. The
 * calendar allows a user to navigate to any month; the default the
 * calenda displays the current month and year. The calendar does not
 * include any links for adding new events; those can be placed separately,
 * including above or below the calendar (the Semantic Forms extension is
 * recommended for this purpose.
 *
 * The first argument, 'date property', is mandatory: it is the name of
 * the semantic date property that is to be queried on. The 'query filters'
 * argument is optional: it is a list of semantic properties and their
 * values, used to provide further constraints on the set of returned
 * values, in the manner of SMW's #ask function.
 *
 * Both of these arguments can be arrays, separated by semicolons, to
 * allow for multiple queries within the same calendar. The number of date
 * properties determines the number of queries: if more date properties
 * than query filters are passed in, the remaining date properties are
 * queried on without any filters, while if more query filters than
 * date properties are passed in, the remaining query filters are
 * ignored.
 *
 * Examples:
 *
 * To display a calendar that shows all pages by their value for the
 * property 'Has date', if they belong to the 'Accounting' department
 * and have an importance of 'High', you should call the following:
 *
 * {{#semantic_calendar:Has date|[[Belongs to department::Accounting]][[Has importance::High]]}}
 *
 * To display a calendar that shows all the previous dates, and also
 * show all pages of category 'Projects' by their value for 'Has
 * deadline', you should call the following:
 *
 * {{#semantic_calendar:Has date;Has deadline|[[Belongs to department::Accounting]][[Has importance::High]];[[Category:Projects]]}}
 *
 * @author Yaron Koren
 */


function scgParserFunctions () {
    global $wgParser;
    $wgParser->setFunctionHook('semantic_calendar', 'scRenderSemanticCalendar');
}

function scgLanguageGetMagic( &$magicWords, $langCode = "en" ) {
	switch ( $langCode ) {
	default:
		$magicWords['semantic_calendar'] = array ( 0, 'semantic_calendar' );
	}
	return true;
}

function intToMonth($int) {
	if ($int == '2') {return wfMsg('february'); }
	if ($int == '3') {return wfMsg('march'); }
	if ($int == '4') {return wfMsg('april'); }
	if ($int == '5') {return wfMsg('may'); }
	if ($int == '6') {return wfMsg('june'); }
	if ($int == '7') {return wfMsg('july'); }
	if ($int == '8') {return wfMsg('august'); }
	if ($int == '9') {return wfMsg('september'); }
	if ($int == '10') {return wfMsg('october'); }
	if ($int == '11') {return wfMsg('november'); }
	if ($int == '12') {return wfMsg('december'); }
	// keep it simple - if it's '1' or anything else, return January
	return wfMsg('january');
}

function scRenderSemanticCalendar (&$parser, $inDatePropertiesStr = '', $inQueryFiltersStr = '') {
	global $wgOut, $scgScriptPath, $wgRequest;

	wfLoadExtensionMessages('SemanticCalendar');
	$wgOut->addLink( array(
		'rel' => 'stylesheet',
		'type' => 'text/css',
		'media' => "screen, projection, print",
		'href' => $scgScriptPath . "/skins/SC_main.css"
	));

	// initialize some variables
	$text = "";
	$title = $parser->getTitle();
	$skin = $parser->getOptions()->getSkin();
	$events = array();
	$smw_version = SMW_VERSION;
	$date_properties = explode(";", $inDatePropertiesStr);
	$query_filters = explode(";", $inQueryFiltersStr);
	// cycle through the date properties, adding to each a query filter
	// when possible; excess query filters, if any exist, are ignored
	foreach ($date_properties as $i => $date_property) {
		if (count($query_filters) > $i) {
			$query_filter_str = $query_filters[$i];
		} else {
			$query_filter_str = "";
		}
		$events = array_merge($events, scfGetEvents($date_property, $query_filter_str));
	}

	// get all the date-based values we need - the current month and year
	// (i.e., the one the user is looking at - not necessarily the
	// "current" ones), the previous and next months and years (same -
	// note that the previous or next month could be in a different year),
	// the number of days in the current, previous and next months, etc.
	$cur_month_num = date("n", mktime());
	if ($wgRequest->getCheck('month')) {
		$query_month = $wgRequest->getVal('month');
		if (is_numeric($query_month) && (intval($query_month) == $query_month) && $query_month >= 1 && $query_month <= 12) {
			$cur_month_num = $wgRequest->getVal('month');
		}
	}
	$cur_month = intToMonth($cur_month_num);
	$cur_year = date("Y", mktime());
	if ($wgRequest->getCheck('year')) {
		$query_year = $wgRequest->getVal('year');
		if (is_numeric($query_year) && intval($query_year) == $query_year) {
			$cur_year = $wgRequest->getVal('year');
		}
	}
	if ($cur_month_num == '1') {
		$prev_month_num = '12';
		$prev_year = $cur_year - 1;
	} else {
		$prev_month_num = $cur_month_num - 1;
		$prev_year = $cur_year;
	}
	if ($cur_month_num == '12') {
		$next_month_num = '1';
		$next_year = $cur_year + 1;
	} else {
		$next_month_num = $cur_month_num + 1;
		$next_year = $cur_year;
	}
	// there's no year '0' - change it to '1' or '-1'
	if ($cur_year == "0") {$cur_year = "1"; }
	if ($next_year == "0") {$next_year = "1"; }
	if ($prev_year == "0") {$prev_year = "-1"; }
	$prev_month_url = $title->getLocalURL("month=$prev_month_num&year=$prev_year");
	$next_month_url = $title->getLocalURL("month=$next_month_num&year=$next_year");
	$today_url = $title->getLocalURL();
	$today_text = wfMsg('sc_today');
	$prev_month_text = wfMsg('sc_previousmonth');
	$next_month_text = wfMsg('sc_nextmonth');
	$go_to_month_text = wfMsg('sc_gotomonth');

	// get day of the week that the first of this month falls on
	$first_day = new SCHistoricalDate();
	$first_day->create($cur_year, $cur_month_num, 1);
	$day_of_week_of_1 = $first_day->getDayOfWeek();
	$start_day = 1 - $day_of_week_of_1;
	$days_in_prev_month = SCHistoricalDate::daysInMonth($prev_year, $prev_month_num);
	$days_in_cur_month = SCHistoricalDate::daysInMonth($cur_year, $cur_month_num);
	$today_string = date("Y n j", mktime());
	$url_year = $wgRequest->getVal('year');
	$title = $title->getPrefixedDbKey();

	// create table for holding calendar, and the top (navigation) row
	$text .=<<<END
<table class="navigation_table">
<tr>
<td class="month_name">$cur_month $cur_year</td>
<td class="nav_links">
<a href="$prev_month_url" title="$prev_month_text"><img src="$scgScriptPath/skins/images/left-arrow.png" border="0" /></a>
&nbsp;
<a href="$today_url">$today_text</a>
&nbsp;
<a href="$next_month_url" title="$next_month_text"><img src="$scgScriptPath/skins/images/right-arrow.png" border="0" /></a>
</td>
<td class="nav_form">
<form>
<input type="hidden" name="title" value="$title">
<select name="month">

END;
	for ($i = 1; $i <= 12; $i++) {
		$month_name = intToMonth($i);
		$selected_str = ($i == $cur_month_num) ? "selected" : "";
		$text .= "<option value=\"$i\" $selected_str>$month_name</option>\n";
	}
	$text .=<<<END
</select>
<input name="year" type="text" value="$cur_year" size="4">
<input type="submit" value="$go_to_month_text">
</form>
</td>
</tr>
</table>

<table class="month_calendar">

END;
	// second row holds the calendar title and current month
	$text .=<<<END
<tr class="weekdays">

END;

	// third row holds the days of the week
	$week_days = array(wfMsg('sunday'), wfMsg('monday'), wfMsg('tuesday'), wfMsg('wednesday'), wfMsg('thursday'), wfMsg('friday'), wfMsg('saturday'));
	foreach ($week_days as $week_day) {
		$text .= "<td>$week_day</td>";
	}
	$text .= "</tr>\n";

	// now, create the calendar itself -
	// loop through a set of weeks, from a Sunday (which might be
	// before the beginning of the month) to a Saturday (which might
	// be after the end of the month)
	$day_of_the_week = 1;
	$is_last_week = false;
	for ($day = $start_day; (! $is_last_week || $day_of_the_week != 1); $day++) {
		if ($day_of_the_week == 1) {
			$text .= "<tr>\n";
		}
		if ("$cur_year $cur_month_num $day" == $today_string) {
			$text .= "<td class=\"today\">\n";
		} elseif ($day_of_the_week == 1 || $day_of_the_week == 7) {
			$text .= "<td class=\"weekend_day\">\n";
		} else {
			$text .= "<td>\n";
		}
		if ($day == $days_in_cur_month || $day > 50) {$is_last_week = true; }
		// if this day is before or after the current month, set a
		// "display day" to show on the calendar, and use a different
		// CSS style for it
		if ($day > $days_in_cur_month || $day < 1) {
			if ($day < 1) {
				$display_day = $day + $days_in_prev_month;
				$date_str = "$prev_year-" . str_pad($prev_month_num, 2, "0", STR_PAD_LEFT) . "-" . str_pad($display_day, 2, "0", STR_PAD_LEFT);
			}
			if ($day > $days_in_cur_month) {
				$display_day = $day - $days_in_cur_month;
				$date_str = "$next_year-" . str_pad($next_month_num, 2, "0", STR_PAD_LEFT) . "-" . str_pad($display_day, 2, "0", STR_PAD_LEFT);
			}
			$text .= "<div class=\"day day_other_month\">$display_day</div>\n";
		} else {
			$date_str = "$cur_year-" . str_pad($cur_month_num, 2, "0", STR_PAD_LEFT) . "-" . str_pad($day, 2, "0", STR_PAD_LEFT);
			$text .= "<div class=\"day\">$day</div>\n";
		}
		// finally, the most important step - get the events that
		// match this date, and the given set of criteria, and
		// display them in this date's box
		$text .= "<div class=\"main\">\n";
		foreach ($events as $event_pair) {
			list($event_title, $event_date) = $event_pair;
			if ($event_date == $date_str) {
				$text .= $skin->makeLinkObj($event_title, str_replace('_', ' ', $event_title->getPrefixedDbKey()));
				$text .= "\n\n";
			}
		}
		$text .=<<<END
</div>
</td>

END;
		if ($day_of_the_week == 7) {
			$text .= "</tr>\n";
			$day_of_the_week = 1;
		} else {
			$day_of_the_week++;
		}
	}

	$text .= "</table>\n";

	return array($text, 'noparse' => 'true', 'isHTML' => 'true');
}
