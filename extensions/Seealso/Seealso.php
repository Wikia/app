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
	'path'           => __FILE__,
	'name'           => 'Seealso',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:See_also',
	'author'         => 'Magnus Manske',
	'descriptionmsg' => 'seealso-desc',
);

$wgHooks['ParserFirstCallInit'][] = 'wfSeealsoSetHooks';

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['seealso'] = $dir . 'Seealso.i18n.php';

function wfSeealsoSetHooks( $parser ) {
	$parser->setHook( 'seealso', 'parse_seealso' );
	$l = trim ( 'seealso-local', "" ) ;
	if ( $l != "" )
		$parser->setHook( $l, 'parse_seealso' );
	return true;
}

function parse_seealso( $text, $params, $parser ) {
	$a = explode ( "\n" , $text );
	$ret = "== " . trim ( wfMsg( 'seealso' ) ) . " ==\n";
	foreach ( $a AS $x ) {
		$x = trim ( $x ) ;
		if ( $x == "" ) continue;
		$ret .= "* [[" . $x . "]]\n";
	}
	return $parser->recursiveTagParse( $ret );
}
