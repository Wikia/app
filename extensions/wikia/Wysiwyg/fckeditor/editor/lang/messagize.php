<?php
/*
 * Create MW message array for languages supported by FCK
 */

// get message JS files
$files = glob('*.js');
$messages = array();

foreach($files as $file) {
	$content = explode("\n", file_get_contents($file));

	$lang = substr($file, 0, -3);

	foreach($content as $line) {
		if (strpos($line, ': "')) {
			$data = explode(':', $line, 2);

			$key = 'FCK' . trim($data[0]);
			$val = ltrim($data[1], '", ');
			$val = substr($val, 0, strrpos($val, '"'));

			$messages[$lang][$key] = $val;
		}
	}

	array_shift($messages[$lang]);
}

foreach($messages as $lang => $data) {
	echo "\$messages['{$lang}'] = array\n(\n";

	foreach($data as $key => $msg) {
		echo "\t'{$key}' => \"{$msg}\",\n";
	}

	echo ");\n\n";
}
