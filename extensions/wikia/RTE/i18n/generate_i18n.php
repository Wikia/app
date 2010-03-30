<?php
/*
 * Create MW messages file for CKeditor internationalisation
 *
 * CK.core.i18n.php file is dynamically generated. DO NOT modify it by hand.
 * Changes should be made in CK.wikia.i18n.php file.
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 */

// list of languages to import
$langs = array(
	'de',
	'en',
	'es',
	'fr',
	'it',
	'pl',
);

// import'em all
$langs = false;

// fix single line of JS file
function parse_json_line($matches) {
	$key = $matches[1];
	$value = $matches[2];

	// close key name in double quotes
	$key = trim($key, '\' ');
	$key = "\"{$key}\"";

	// keep comma following value
	$comma = (substr($value, -1) == ',') ? ',' : '';

	// properly encode value
	if ($value != '') {
		$value = trim($value, ' ,');
		$value = substr($value, 1, -1);

		$value = str_replace("\\'", "'", $value); # \' -> '
		$value = str_replace('"', '\\"', $value); # " -> \"
		$value = "\"{$value}\"";
	}

	return "{$key}:{$value}{$comma}";
}

// go recursively through nested arrays and return its flat version
function make_flat_array($data, $lang, $prefix = '') {
	$ret = array();

	// add key separator for nested arrays
	if ($prefix != '') {
		$prefix .= '-';
	}

	foreach($data as $key => $value) {
		if (is_array($value)) {
			// go deeper
			$ret = array_merge($ret, make_flat_array($value, $lang, $prefix . $key));
		}
		else {
			$ret[$prefix . $key] = $value;
		}
	}

	return $ret;
}

// get message JS files
$dir = dirname(__FILE__) . '/../ckeditor/_source/lang/';
$files = glob($dir . '*.js');
$messages = array();

// messages "groups" to be skipped
$skipGroups = array(
	'about',
	'flash',
	'image',
	'scayt',
	'spellCheck',
);

// parse language files as JSON
foreach($files as $file) {
	$lang = substr(basename($file), 0, -3);
	if (is_array($langs) && !in_array($lang, $langs)) {
		continue;
	}

	// only parse language files
	if (!preg_match('#^[a-z\-]+$#', $lang)) {
		continue;
	}

	$content = file_get_contents($file);

	// strip comments
	$content = preg_replace('#\s*/\*(.+)\*/#Us', '', $content); # /* multiline comment */
	$content = preg_replace('#\s*/\\/(.+)#', '', $content); # // comment

	// get fragment with JSON
	$content = substr($content, strpos($content,'{'), strlen($content));
	$content = substr($content, 0, strrpos($content,'}')+1);

	// JSON cleanup
	// add double quotes to keys and values
	$content = preg_replace_callback('#\s*([A-Za-z0-9\'_]+)\s*:(.*)#', parse_json_line, $content);
	$content = preg_replace('#\s\s+#s', '', $content);

	// parse JSON to array
	$parsed = json_decode($content, true);

	// check for parsing errors
	if (empty($parsed)) {
		die("Error while parsing message file for {$lang}!\n");
	}

	// let's filter messages
	foreach($skipGroups as $skipGroup) {
		unset($parsed[$skipGroup]);
	}

	ksort($parsed);

	// make flat array from nested arrays
	$messages[$lang] = make_flat_array($parsed, $lang, 'rte-ck');
}

//print_r($messages); die();

// save file
$path = dirname(__FILE__);

$now = date('Y-m-d H:i:s');
$count = count($messages);
$msgCount = count($messages['en']);

echo "Generating CKeditor messages for {$count} languages ({$msgCount} messages for each language)";

// CK.core.i18n.php
$out = "<?php\n\n/* CKeditor core messages -- auto-generated on {$now} - {$count} languages - {$msgCount} messages per language - DO NOT modify this file by hand! */\n\n\$messages = array();";

foreach($messages as $lang => $data) {
	echo "\n * {$lang}...";

	$out .= "\n\$messages['{$lang}'] = array(\n";

	foreach($data as $key => $msg) {
		$msg = str_replace("'", "\\'", $msg);
		$msg = str_replace("\r\n", "\n", $msg);
		$out .= "\t'{$key}' => '{$msg}',\n";
	}

	$out .= ");";
}

file_put_contents($path . '/CK.core.i18n.php', $out);

echo "\n\nDone!\n";
