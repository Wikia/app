<?php
# MediaWiki SimpleCalendar Extension{{php}}{{Category:Extensions|SimpleCalendar}}
# - See http://www.mediawiki.org/wiki/Extension:Simple_Calendar for installation and usage details
# - Licenced under LGPL (http://www.gnu.org/copyleft/lesser.html)
# - Author: http://www.organicdesign.co.nz/nad

define('SIMPLECALENDAR_VERSION','1.2.4, 2007-10-18');

$wgHooks['ParserFirstCallInit'][] = 'wfSetupSimpleCalendar';
$wgHooks['LanguageGetMagic'][] = 'wfCalendarLanguageGetMagic';

$wgExtensionCredits['parserhook'][] = array(
	'name'        => 'Simple Calendar',
	'author'      => '[http://www.organicdesign.co.nz/nad User:Nad]',
	'description' => 'A simple calendar extension',
	'url'         => 'http://www.mediawiki.org/wiki/Extension:Simple_Calendar',
	'version'     => SIMPLECALENDAR_VERSION
);

function wfCalendarLanguageGetMagic(&$magicWords,$langCode = 0) {
	$magicWords['calendar'] = array(0,'calendar');
	return true;
}

/**
 * @param Parser $parser
 * @return bool
 */
function wfSetupSimpleCalendar( $parser ) {
	$parser->setFunctionHook('calendar','wfRenderCalendar');
	return true;
}

/**
 * Renders a table of all the individual month tables
 *
 * @param Parser $parser
 * @return string
 */
function wfRenderCalendar(&$parser) {
	$parser->disableCache();
	$argv = array();
	foreach (func_get_args() as $arg) if (!is_object($arg)) {
		if (preg_match('/^(.+?)\\s*=\\s*(.+)$/',$arg,$match)) $argv[$match[1]]=$match[2];
	}
	if (isset($argv['format']))    $f = $argv['format']; else $f = '%e %B %Y';
	if (isset($argv['dayformat'])) $df = $argv['dayformat']; else $df = false;
	if (isset($argv['title']))     $p = $argv['title'].'/'; else $p = '';
	if (isset($argv['query']))     $q = $argv['query'].'&action=edit'; else $q = 'action=edit';
	if (isset($argv['year']))      $y = $argv['year']; else $y = date('Y');
	if (isset($argv['month'])) {
		$m = $argv['month'];
		return wfRenderMonth(strftime('%m',strtotime("$y-$m-01")),$y,$p,$q,$f,$df);
	} else $m = 1;
	$table = "{| class=\"calendar\"\n";
	for ($rows = 3; $rows--; $table .= "|-\n")
		for ($cols = 0; $cols < 4; $cols++)
			$table .= '|'.wfRenderMonth($m++,$y,$p,$q,$f,$df)."\n";
	return "$table\n|}\n";
}

# Return a calendar table of the passed month and year
function wfRenderMonth($m,$y,$prefix = '',$query = '',$format = '%e %B %Y',$dayformat = false) {
	$thisDay   = date('d');
	$thisMonth = date('n');
	$thisYear  = date('Y');
	if (!$d = date('w',$ts = mktime(0,0,0,$m,1,$y))) $d = 7;
	$month = wfMsg(strtolower(strftime('%B',$ts)));
	$days = array();
	foreach (array('M','T','W','T','F','S','S') as $i => $day)
		$days[] = $dayformat ? wfMsg(strftime($dayformat,mktime(0,0,0,2,$i,2000))) : $day;
	$table = "\n{| class=\"month\"\n|- class=\"heading\"\n|colspan=\"7\"|$month\n|- class=\"dow\"\n";
	$table .= '|'.join('||',$days)."\n";
	if ($d > 1) $table .= "|-".str_repeat("\n|&nbsp;\n",$d-1);
	for ($i = $day = $d; $day < 32; $i++) {
		$day = $i - $d + 1;
		if ($day < 29 or checkdate($m,$day,$y)) {
			if ($i%7 == 1) $table .= "\n|-\n";
			$t = ($day == $thisDay and $m == $thisMonth and $y == $thisYear) ? ' class="today"' : '';

			/* Wikia Change start - make extension more locale - aware */
			$timestamp = mktime(0, 0, 0, $m, $day, $y);
			$i18nFormatStrings = array('%a', '%A', '%b', '%B', '%c', '%p');
			foreach ($i18nFormatStrings as $formatString) {
				$replacement = wfMsg(strftime($formatString, $timestamp));
				$format = mb_ereg_replace($formatString, $replacement, $format);
			}
			/* Wikia Change end*/

			$ttext = $prefix.trim(strftime($format,mktime(0,0,0,$m,$day,$y)));
			$title = Title::newFromText($ttext);
			if (is_object($title)) {
				$class = $title->exists() ? 'day-active' : 'day-empty';
				$url = $title->getFullURL($title->exists() ? '' : $query);
			} else $url = $ttext;

			/* Wikia Change start */
			$openingString =
				implode('', array(
					'<span ',
					!empty($class) ? ('class="' . $class . '"') : null,
					'>'));
			$closingString = '</span>';
			$table .= "|$t|[$url $openingString $day $closingString]\n";
			/* Wikia Change end */

		}
	}
	return "$table\n|}";
}
