<?php
/*
* RegexFunctions extension by Ryan Schmidt
* Regular Expression parser functions
*/

if( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is an extension of the MediaWiki software and cannot be used standalone\n";
	die( 1 );
}

//credits and hooks
$wgExtensionFunctions[] = 'wfRegexFunctions';

$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'RegexFunctions',
	'author'         => 'Ryan Schmidt',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:RegexFunctions',
	'version'        => '1.2',
	'description'    => 'Regular Expression parser functions',
	'descriptionmsg' => 'regexfunctions-desc',
);

$wgExtensionMessagesFiles['RegexFunctions'] = dirname(__FILE__) . '/RegexFunctions.i18n.php';
$wgHooks['LanguageGetMagic'][] = 'wfRegexFunctionsLanguageGetMagic';

//default globals
//how many functions are allowed in a single page? Keep this at least above 3 for usability
$wgRegexFunctionsPerPage = 10;
//should we allow modifiers in the functions, e.g. the /i modifier for case-insensitive?
//This does NOT enable the /e modifier for preg_replace, see the next variable for that
$wgRegexFunctionsAllowModifiers = true;
//should we allow the /e modifier in preg_replace? Requires AllowModifiers to be true.
//Don't enable this unless you trust every single editor on your wiki, as it may open up potential XSS vectors
$wgRegexFunctionsAllowE = false;
//should we allow internal options to be set (e.g. (?opts) or (?opts:some regex))
$wgRegexFunctionsAllowOptions = true;
//limit for rsplit and rreplace functions. -1 is unlimited
$wgRegexFunctionsLimit = -1;
//array of functions to disable, aka these functions cannot be used :)
$wgRegexFunctionsDisable = array();

function wfRegexFunctions() {
	global $wgParser, $wgExtRegexFunctions;

	$wgExtRegexFunctions = new ExtRegexFunctions();
	$wgParser->setFunctionHook( 'rmatch', array(&$wgExtRegexFunctions, 'rmatch') );
	$wgParser->setFunctionHook( 'rsplit', array(&$wgExtRegexFunctions, 'rsplit') );
	$wgParser->setFunctionHook( 'rreplace', array(&$wgExtRegexFunctions, 'rreplace') );
}

function wfRegexFunctionsLanguageGetMagic( &$magicWords, $langCode ) {
	switch ( $langCode ) {
	default:
		$magicWords['rmatch'] = array( 0, 'rmatch' );
		$magicWords['rsplit'] = array( 0, 'rsplit' );
		$magicWords['rreplace'] = array( 0, 'rreplace' );
	}
	return true;
}

class ExtRegexFunctions {
	var $num = 0;
	var $modifiers = array('i', 'm', 's', 'x', 'A', 'D', 'S', 'U', 'X', 'J', 'u', 'e');
	var $options = array('i', 'm', 's', 'x', 'U', 'X', 'J');
	
	function rmatch ( &$parser, $string = '', &$pattern = '', &$return = '', $notfound = '', $offset = 0 ) {
		global $wgRegexFunctionsPerPage, $wgRegexFunctionsAllowModifiers, $wgRegexFunctionsDisable;
		if(in_array('rmatch', $wgRegexFunctionsDisable))
			return;
		$this->num++;
		if($this->num > $wgRegexFunctionsPerPage)
			return;
		$pattern = $this->sanitize($pattern, $wgRegexFunctionsAllowModifiers, false);
		$num = preg_match( $pattern, $string, $matches, PREG_OFFSET_CAPTURE, (int) $offset );
		if($num === false)
			return;
		if($num === 0)
			return $notfound;
		//change all backslashes to $
		$return = str_replace('\\', '%$', $return);
		$return = preg_replace('/%?\$%?\$([0-9]+)/e', 'array_key_exists($1, $matches) ? $matches[$1][1] : \'\'', $return);
		$return = preg_replace('/%?\$%?\$\{([0-9]+)\}/e', 'array_key_exists($1, $matches) ? $matches[$1][1] : \'\'', $return);
		$return = preg_replace('/%?\$([0-9]+)/e', 'array_key_exists($1, $matches) ? $matches[$1][0] : \'\'', $return);
		$return = preg_replace('/%?\$\{([0-9]+)\}/e', 'array_key_exists($1, $matches) ? $matches[$1][0] : \'\'', $return);
		$return = str_replace('%$', '\\', $return);
		return $return;
	}

	function rsplit ( &$parser, $string = '', &$pattern = '', $piece = 0 ) {
		global $wgRegexFunctionsPerPage, $wgRegexFunctionsAllowModifiers, $wgRegexFunctionsLimit, $wgRegexFunctionsDisable;
		if(in_array('rmatch', $wgRegexFunctionsDisable))
			return;
		$this->num++;
		if($this->num > $wgRegexFunctionsPerPage)
			return;
		$pattern = $this->sanitize($pattern, $wgRegexFunctionsAllowModifiers, false);
		$res = preg_split( $pattern, $string, $wgRegexFunctionsLimit );
		$p = (int) $piece;
		//allow negative pieces to work from the end of the array
		if($p < 0)
			$p = $p + count($res);
		//sanitation for pieces that don't exist
		if($p < 0)
			$p = 0;
		if($p >= count($res))
			$p = count($res) - 1;
		return $res[$p];
	}

	function rreplace ( &$parser, $string = '', &$pattern = '', &$replace = '' ) {
		global $wgRegexFunctionsPerPage, $wgRegexFunctionsAllowModifiers, $wgRegexFunctionsAllowE, $wgRegexFunctionsLimit, $wgRegexFunctionsDisable;
		if(in_array('rmatch', $wgRegexFunctionsDisable))
			return;
		$this->num++;
		if($this->num > $wgRegexFunctionsPerPage)
			return;
		$pattern = $this->sanitize($pattern, $wgRegexFunctionsAllowModifiers, $wgRegexFunctionsAllowE);
		$res = preg_replace($pattern, $replace, $string, $wgRegexFunctionsLimit);
		return $res;
	}
	
	//santizes a regex pattern
	function sanitize($pattern, $m = false, $e = false) {
		if(preg_match('/^\/(.*)([^\\\\])\/(.*?)$/', $pattern, $matches)) {
			$pat = preg_replace('/([^\\\\])?\(\?(.*)(\:.*)?\)/Ue', '\'$1(?\' . $this->cleanupInternal(\'$2\') . \'$3)\'', $matches[1] . $matches[2]);
			$ret = '/' . $pat . '/';
			if($m) {
				$mod = '';
				foreach($this->modifiers as $val) {
					if(strpos($matches[3], $val) !== false)
						$mod .= $val;
				}
				if(!$e)
					$mod = str_replace('e', '', $mod);
				$ret .= $mod;
			}
		} else {
			$pat = preg_replace('/([^\\\\])?\(\?(.*)(\:.*)?\)/Ue', '\'$1(?\' . $this->cleanupInternal(\'$2\') . \'$3)\'', $pattern);
			$pat = preg_replace('!([^\\\\])/!', '$1\\/', $pat);
			$ret = '/' . $pat . '/';
		}
		return $ret;
	}
	
	//cleans up internal options, making sure they are valid
	function cleanupInternal($str) {
		global $wgRegexFunctionsAllowOptions;
		$ret = '';
		if(!$wgRegexFunctionsAllowOptions)
			return '';
		foreach($this->options as $opt) {
			if(strpos($str, $opt) !== false)
				$ret .= $opt;
		}
		return $ret;
	}
}
