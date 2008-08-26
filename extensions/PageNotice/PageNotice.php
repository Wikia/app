<?php
/**
 * PageNotice extension - lets you define a fixed header or footer message for each page or namespace.
 *
 * Page notices (headers and footers) are maintained as MediaWiki-messages.
 * For page Foo, MediaWiki:top-notice-Foo and MediaWiki:bottom-notice-Foo can be used to defined a header
 * or footer respectively. For namespace 6, MediaWiki:top-notice-ns-6 and MediaWiki:bottom-notice-ns-6 can
 * be used to defined a header or footer respectively. Mind the capitalization.
 * 
 * For more info see http://mediawiki.org/wiki/Extension:PageNotice
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Daniel Kinzler, brightbyte.de
 * @copyright © 2007 Daniel Kinzler
 * @licence GNU General Public Licence 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionCredits['other'][] = array( 
	'name' => 'PageNotice', 
	'author' => 'Daniel Kinzler', 
	'url' => 'http://mediawiki.org/wiki/Extension:PageNotice',
	'description' => 'lets you define a fixed header or footer message for each page or namespace.',
);

$wgHooks['OutputPageBeforeHTML'][] = 'wfPageNoticeHook';


function wfPageNoticeHook( &$out, &$text ) {
	global $wgTitle, $wgParser;
	$name = $wgTitle->getPrefixedDBKey();
	$ns = $wgTitle->getNamespace();
	
	$opt = array(
		'parseinline',
	);
	
	$header = wfMsgExt("top-notice-$name", $opt);
	$nsheader = wfMsgExt("top-notice-ns-$ns", $opt);
	
	$footer = wfMsgExt("bottom-notice-$name", $opt);
	$nsfooter = wfMsgExt("bottom-notice-ns-$ns", $opt);
	
	if (!wfEmptyMsg("top-notice-$name", $header)) $text = "<div>$header</div>\n$text";
	if (!wfEmptyMsg("top-notice-ns-$ns", $nsheader)) $text = "<div>$nsheader</div>\n$text";
	
	if (!wfEmptyMsg("bottom-notice-$name", $footer)) $text = "$text\n<div>$footer</div>";
	if (!wfEmptyMsg("bottom-notice-ns-$ns", $nsfooter)) $text = "$text\n<div>$nsfooter</div>";
	
	return true;
}

