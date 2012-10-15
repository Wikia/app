<?php
/**
 * TemplateLink extension - shows a template as a new page
 *
 * @file
 * @ingroup Extensions
 * @author Magnus Manske
 * @copyright © 2007 Magnus Manske
 * @licence GNU General Public Licence 2.0 or later
 */

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the skin file directly.
if(!defined('MEDIAWIKI')){
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/TemplateLink/TemplateLink.setup.php" );
EOT;
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'TemplateLink',
	'version' => '1.1',
	'author' =>'Magnus Manske',
	'url' => 'https://www.mediawiki.org/wiki/Extension:TemplateLink',
	'descriptionmsg' => 'templatelink_desc',
);

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'TemplateLink',
	'version' => '1.2',
	'author' =>'Magnus Manske',
	'url' => 'https://www.mediawiki.org/wiki/Extension:TemplateLink',
	'descriptionmsg' => 'templatelink_desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['TemplateLink'] = $dir . 'TemplateLink.i18n.php';
$wgExtensionMessagesFiles['TemplateLinkAlias'] = $dir . 'TemplateLink.alias.php';
$wgAutoloadClasses['TemplateLink'] = $dir . 'TemplateLink.body.php'; # Tell MediaWiki to load the extension body.
$wgSpecialPages['TemplateLink'] = 'TemplateLink'; # Let MediaWiki know about your new special page.

# The tag
$wgHooks['ParserFirstCallInit'][] = 'efTemplateLinkSetHook';

function efTemplateLinkSetHook( $parser ){
	$parser->setHook( 'templatelink', 'efTemplateLink' );
	return true;
}

function efTemplateLink( $input, $args, $parser ){
	$template = trim( $input );
	if( trim( $template )== '' )return htmlspecialchars( $template );

	if( isset( $args['text'] ))$text = $args['text'];
	else $text = ucfirst( trim( array_shift( explode( '|' , $template , 2 ))));


	$nt = Title::newFromText( "Special:TemplateLink" );
	$url = $nt->escapeLocalURL();
	$url .= "?template=" . urlencode( $template );
	if( isset( $args['title'] ))$url .= "&newtitle=" . ucfirst( trim( $args['title'] ));
	$link = "<a href=\"$url\" class=\"internal\">$text</a>";
	return $link;
}
