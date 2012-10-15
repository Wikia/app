<?php
# MediaWiki Poem extension v1.0cis
#
# Based on example code from
# http://www.mediawiki.org/wiki/Manual:Extending_wiki_markup
#
# All other code is copyright © 2005 Nikola Smolenski <smolensk@eunet.yu>
# (with modified parser callback and attribute additions)
#
# Anyone is allowed to use this code for any purpose.
# 
# To install, copy the extension to your extensions directory and add line
# include("extensions/Poem.php");
# to the bottom of your LocalSettings.php
#
# To use, put some text between <poem></poem> tags
#
# For more information see its page at
# http://www.mediawiki.org/wiki/Extension:Poem

$wgHooks['ParserFirstCallInit'][] = 'wfPoemExtension';
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'Poem',
	'author'         => array( 'Nikola Smolenski', 'Brion Vibber', 'Steve Sanbeg' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Poem',
	'descriptionmsg' => 'poem-desc',
);
$wgParserTestFiles[] = dirname( __FILE__ ) . "/poemParserTests.txt";
$wgExtensionMessagesFiles['Poem'] =  dirname(__FILE__) . '/Poem.i18n.php';

function wfPoemExtension( &$parser ) {
	$parser->setHook( 'poem', 'wfRenderPoemTag' );
	return true;
}

/**
 * @param  $in
 * @param array $param
 * @param $parser Parser
 * @param bool $frame
 * @return string
 */
function wfRenderPoemTag( $in, $param=array(), $parser=null, $frame=false ) {

	/* using newlines in the text will cause the parser to add <p> tags,
	 * which may not be desired in some cases
	 */
	$nl = isset( $param['compact'] ) ? '' : "\n";

	$tag = $parser->insertStripItem( "<br />", $parser->mStripState );

	$text = preg_replace(
		array( "/^\n/", "/\n$/D", "/\n/" ),
		array( "", "", "$tag\n" ),
		$in );
	$text = preg_replace_callback( '/^( +)/m', 'wfPoemReplaceSpaces', $text );
	$text = $parser->recursiveTagParse( $text, $frame );

	$attribs = Sanitizer::validateTagAttributes( $param, 'div' );

	// Wrap output in a <div> with "poem" class.
	if( isset( $attribs['class'] ) ) {
		$attribs['class'] = 'poem ' . $attribs['class'];
	} else {
		$attribs['class'] = 'poem';
	}

	return Html::rawElement( 'div', $attribs, $nl . trim( $text ) . $nl );
}

/**
 * Callback for preg_replace_callback()
 */
function wfPoemReplaceSpaces( $m ) {
	return str_replace( ' ', '&#160;', $m[1] );
}
