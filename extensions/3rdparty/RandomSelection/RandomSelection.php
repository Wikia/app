<?php
/*

 RandomSelection v2.1.3 -- 7/21/08

 This extension randomly displays one of the given options.

 Usage: <choose><option>A</option><option>B</option></choose>
 Optional parameter: <option weight="3"> == 3x weight given

 Author: Ross McClure [http://www.mediawiki.org/wiki/User:Algorithm]
 Author: Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
*/

//Avoid unstubbing $wgParser on setHook() too early on modern (1.12+) MW versions, as per r35980
if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) ) {
	$wgHooks['ParserFirstCallInit'][] = 'wfRandomSelection';
} else {
	$wgExtensionFunctions[] = 'wfRandomSelection';
}

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'RandomSelection',
	'url' => 'http://www.mediawiki.org/wiki/Extension:RandomSelection',
	'version' => '2.1.3',
	'author' => 'Ross McClure',
	'description' => 'Displays a random option from the given set.'
);

function wfRandomSelection() {
	global $wgParser;
	$wgParser->setHook( 'choose', 'renderChosen' );
	return true;
}

function getRandomOption($r, $out, $len, &$choosedOptions) {
	# Choose an option at random
	$input = '';
	//no more options
	if (count($choosedOptions) >= $len) return $input;
	do {
		$t = mt_rand(1,$r);
		for($i = 0; $i < $len; $i++) {
			$t -= $out[1][$i];
			if($t <= 0) {
				if (empty($choosedOptions[$i])) {
					$input = $out[2][$i];
					$choosedOptions[$i] = 1;
				}
				break;
			}
		}
	} while ($input == '');
	return $input;
}

function renderChosen( $input, $argv, &$parser ) {
	global $wgParserCacheExpireTime, $wgRandomSelectExtraItems, $wgRandomSelectTagCount;

	isset($wgRandomSelectTagCount) ? $wgRandomSelectTagCount++ : $wgRandomSelectTagCount = 0;

	$choosedOptions = array();
	$addedJS = "<script type=\"text/javascript\">document.getElementById('option_{$wgRandomSelectTagCount}_'+Math.floor(Math.random() * %d)).style.display='inline';</script><noscript><style type=\"text/css\">#option_{$wgRandomSelectTagCount}_0 {display:inline ! important}</style></noscript>";

//	$wgParserCacheExpireTime = 60;
//	wfDebug( "soft disable Cache (choose)\n" );

	# Parse the options and calculate total weight
	$len = preg_match_all("/<option(?:(?:\\s[^>]*?)?\\sweight=[\"']?([^\\s>]+))?"
		. "(?:\\s[^>]*)?>([\\s\\S]*?)<\\/option>/", $input, $out);
	$r = 0;
	for($i = 0; $i < $len; $i++) {
		if(strlen($out[1][$i])==0) $out[1][$i] = 1;
		else $out[1][$i] = intval($out[1][$i]);
		$r += $out[1][$i];
	}

	if($r <= 0) return '';
	$input = array(getRandomOption($r, $out, $len, $choosedOptions));

	if ($input[0] != '') {
		//add extra options for JS to pick one at client side
		for ($i = 0; $i < $wgRandomSelectExtraItems; $i++) {
			$tmp = getRandomOption($r, $out, $len, $choosedOptions);
			if ($tmp != '') {
				$input[] = $tmp;
			} else {
				break;
			}
		}
	}

	# If running new parser, take the easy way out
	if( defined( 'Parser::VERSION' ) && version_compare( Parser::VERSION, '1.6.1', '>' ) ) {
		$result = '';
		$length = count($input);
		for ($i = 0; $i < $length; $i++) {
			$result .= "<span style=\"display:none\" id=\"option_{$wgRandomSelectTagCount}_$i\">" . $parser->recursiveTagParse($input[$i]) . '</span>';
		}
		return $result . sprintf($addedJS, $length);
	}

	# Otherwise, create new parser to handle rendering
	$localParser = new Parser();

	# Initialize defaults, then copy info from parent parser
	$localParser->clearState();
	$localParser->mTagHooks         = $parser->mTagHooks;
	$localParser->mTemplates        = $parser->mTemplates;
	$localParser->mTemplatePath     = $parser->mTemplatePath;
	$localParser->mFunctionHooks    = $parser->mFunctionHooks;
	$localParser->mFunctionSynonyms = $parser->mFunctionSynonyms;

	# Render the chosen option

	$result = '';
	$length = count($input);
	for ($i = 0; $i < $length; $i++) {
		$result .= "<span style=\"display:none\" id=\"option_{$wgRandomSelectTagCount}_$i\">" . $localParser->parse($input[$i], $parser->mTitle, $parser->mOptions, false, false)->getText() . '</span>';
	}
	return $result . sprintf($addedJS, $length);
}