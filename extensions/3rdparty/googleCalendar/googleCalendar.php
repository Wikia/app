<?php
# Google Calendars
#
# Tag :
#   <googlecalendar>docid</googlecalendar>
# Ex :
#   from url http://calendar.google.com/calendarplay?docid=6444586097901795775
#   <googlecalendar>6444586097901795775</googlecalendar>
#
# Ex:
#   <googlecalendar width="X" height="Y" title="Z">
#   omitting width/height out/blank/0 will fallback to hardcoded defaults from original
#   omitting title will use the calendar's title
# Enjoy !

$wgHooks['ParserFirstCallInit'][] = 'wfGoogleCalendar';
$wgExtensionCredits['parserhook'][] = array(
        'name' => 'Google Calendar',
        'description' => 'Display Google Calendar',
        'author' => 'Kasper Souren, C. \'Uberfuzzy\' Stafford',
        'url' => 'http://www.mediawiki.org/wiki/Extension:GoogleCalendar'
);

/**
 * @param Parser $parser
 * @return bool
 */
function wfGoogleCalendar( $parser ) {
        $parser->setHook('googlecalendar', 'renderGoogleCalendar');
        return true;
}

# The callback function for converting the input text to HTML output
function renderGoogleCalendar( $contents, $attributes, $parser ) {
        $contents = htmlspecialchars($contents);

		if( empty($attributes['width']) || 0 == preg_match("/^[0-9%]*$/", $attributes['width']) ) {
			$width = 425;
		}
		else {
			$width = htmlspecialchars($attributes['width']);
		}

		if( empty($attributes['height']) || 0 == preg_match("/^[0-9%]*$/", $attributes['height']) ) {
			$height = 350;
		}
		else {
			$height = htmlspecialchars($attributes['height']);
		}

		if( empty($attributes['title']) || 0 == preg_match("/^[a-zA-Z0-9- ]*$/", $attributes['title']) ) {
			$title = '';
		}
		else {
			$title = htmlspecialchars($attributes['title']);
		}


        $output = '<iframe src="http://www.google.com/calendar/embed?src='.$contents.'&title='.$title.'&chrome=NAVIGATION&height='.$height.'&epr=4" style=" border-width:0 " width="'.$width.'" frameborder="0" height="'.$height.'"></iframe>';

        return $output;
}
