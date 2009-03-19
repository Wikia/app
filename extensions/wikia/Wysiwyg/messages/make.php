<?php
/*
 * Create MW message array for languages supported by FCK
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 */

// get message JS files
$dir = dirname(__FILE__) . '/../fckeditor/editor/lang/';
$files = glob($dir . '*.js');
$messages = array();

foreach($files as $file) {
	$content = explode("\n", file_get_contents($file));

	$lang = substr(basename($file), 0, -3);

	foreach($content as $line) {
		if (strpos($line, ': "')) {
			$data = explode(':', $line, 2);

			$key = 'FCK' . trim($data[0]);
			$val = ltrim($data[1], '", ');
			$val = substr($val, 0, strrpos($val, '"'));

			$messages[$lang][$key] = $val;
		}
	}

	// remove unwanted entry
	array_shift($messages[$lang]);

	// remove FCKdir message
	array_shift($messages[$lang]);
}

$now = date('Y-m-d H:i:s');
$count = count($messages);

echo "<?php\n\n/* Auto-generated on {$now} - {$count} languages */\n\n";
echo "\$messages = array();";

foreach($messages as $lang => $data) {
	echo "\n\$messages['{$lang}'] = array(\n";

	foreach($data as $key => $msg) {
		echo "\t'{$key}' => \"{$msg}\",\n";
	}

	echo ");";
}
