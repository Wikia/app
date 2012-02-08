<?

$test = "
[[Video:Beer.png]]
[[Video:Beer abc.png]]
[[Video:Beer_abc.png]]
[[Video:Beer_abc.png|test]]
[[Video:Beer_abc]]
[Video:Beer_abc.png]
[[:Beer+abc.png]]
[[Video:Free+Beer-7549.jpg|300px|right]]
[[Video:abc def fg]]
";

function title_replacer( $title, $fulltext ) {
	$symbols = array(
		array(' ','_','-','+'),
	);
	$refs = array();
	foreach( $symbols as $id => $val ) {
		foreach( $val as $id2 => $symbol ) {
			$imp = implode('\\',$val);
			$refs[$symbol] = '[\\' . $imp .']';
		}
	}
	
	$regexp = '';
	
	$j = mb_strlen($title);
	for ($k = 0; $k < $j; $k++) {
		$char = mb_substr($title, $k, 1);
		if(isset($refs[$char])) {
			$regexp .= $refs[$char];
		} else {
			if(ctype_alnum($char)) {
				$regexp .= $char;
			} else {
				$regexp .= '\\' . $char;
			}
		}
	}
	
	$regexp = '/(\\[\\[Video\\:)' . $regexp . '(\\]\\]|\\|[^]]+\\]\\])/';
	var_dump($regexp);
	$new = preg_replace( $regexp, '$1' .$title . '$2', $fulltext );
	var_dump($new);
	
}

title_replacer('Beer abc.png', $test);