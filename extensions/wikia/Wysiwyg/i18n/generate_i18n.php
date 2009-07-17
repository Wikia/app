<?php
/*
 * Create MW messages file for FCK internationalisation
 *
 * FCK.i18n.php file is dynamically generated. DO NOT modify it by hand.
 * Changes should be made in JS files inside /fceditor/editor/lang
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 */

// get message JS files
$dir = dirname(__FILE__) . '/../fckeditor/editor/lang/';
$files = glob($dir . '*.js');
$messages = array();

// list of supported languages
$langs = array('de', 'en', 'pl');

// messages to skip
// set of regexp strings to match keys to be skipped
$skipKeys = array(
	'Dir',
	'InsertFlash\w+',
	'InsertSpecialChar\w+',
	'InsertSmiley\w+',
	'DlgImg\w+',
	'DlgFlash\w+',
	'DlgLnk\w+',
	'DlgAnchor\w+',
	'DlgSpell\w+',
	'DlgButton\w+',
	'DlgCheckbox\w+',
	'DlgForm\w+',
	'DlgTextarea\w+',
	'DlgText\w+',
	'DlgHidden\w+',
	'DlgLst\w+',
	'DlgDoc\w+',
	'DlgTemplates\w+',
	'DlgAbout\w+',
	'DlgDiv\w+'
);

$skipKeysRegExp = '#' . implode('|', $skipKeys) . '#';

foreach($files as $file) {
	$content = explode("\n", file_get_contents($file));

	$lang = substr(basename($file), 0, -3);
	if (is_array($langs) && !in_array($lang, $langs)) {
		continue;
	}

	foreach($content as $line) {
		if (strpos($line, ': "')) {
			$data = explode(':', $line, 2);

			$key = trim($data[0]);

			if (preg_match($skipKeysRegExp, $key)) {
				continue;
			}

			$key = "wysiwyg{$key}";

			$val = ltrim($data[1], '", ');
			$val = substr($val, 0, strrpos($val, '"'));

			$val = strtr($val, array('\\"' => '"'));

			$messages[$lang][$key] = addslashes($val);
		}
	}

	// remove unwanted entry
	array_shift($messages[$lang]);
}

// save file
$path = dirname(__FILE__);

$now = date('Y-m-d H:i:s');
$count = count($messages);
$msgCount = count($messages['en']);

// FCK.i18n.php
$out = "<?php\n\n/* FCK messages -- auto-generated on {$now} - {$count} languages - {$msgCount} messages per language - do not modify it by hand! */\n\n\$messages = array();";

foreach($messages as $lang => $data) {
	$out .= "\n\$messages['{$lang}'] = array(\n";

	foreach($data as $key => $msg) {
		$out .= "\t'{$key}' => '{$msg}',\n";
	}

	$out .= ");";
}

file_put_contents($path . '/FCK.i18n.php', $out);
