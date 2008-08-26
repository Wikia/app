<?php
/*
Usage :

<seealso>
Item1
Item2|Text
</seealso>

Set system message "seealso" to head text, e.g., "See also"
Set system message "seealso_local" to use a localized version, e.g., to "sieheauch"
*/

$wgExtensionCredits['parserhook'][] = array(
	'name'           => 'Seealso',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:See_also',
	'author'         => 'Magnus Manske',
	'description'    => 'Localised \'See also\' headings using the tag <nowiki><seealso></nowiki>',
	'descriptionmsg' => 'seealso-desc',
);

$wgExtensionFunctions[] = "wfSeealso";

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['seealso'] = $dir . 'Seealso.i18n.php';

function wfSeealso () {
	wfLoadExtensionMessages( 'seealso' );
	global $wgParser ;
	$wgParser->setHook ('seealso', 'parse_seealso' ) ;
	$l = trim ( 'seealso-local', "" ) ;
	if ( $l != "" )
		$wgParser->setHook ( $l , 'parse_seealso' ) ;
}

function parse_seealso ( $text, $params, &$parser ) {
	$a = explode ( "\n" , $text ) ;
	$ret = "== " . trim ( wfMsg('seealso')) . " ==\n" ;
	foreach ( $a AS $x ) {
		$x = trim ( $x ) ;
		if ( $x == "" ) continue ;
		$ret .= "* [[" . $x . "]]\n" ;
	}
	$p = new Parser ;
	$ret = $p->parse ( $ret , $parser->getTitle() , $parser->getOptions(), false ) ;
	$ret = $ret->getText();
	return $ret ;
}
