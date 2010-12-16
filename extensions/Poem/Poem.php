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
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Poem',
	'description'    => 'Adds <tt>&lt;poem&gt;</tt> tag for poem formatting',
	'descriptionmsg' => 'poem-desc',
);
$wgParserTestFiles[] = dirname( __FILE__ ) . "/poemParserTests.txt";
$wgExtensionMessagesFiles['Poem'] =  dirname(__FILE__) . '/Poem.i18n.php';

function wfPoemExtension( &$parser ) {
	$parser->setHook("poem","PoemExtension");
	return true;
}

function PoemExtension( $in, $param=array(), $parser=null, $frame=false ) {

	/* using newlines in the text will cause the parser to add <p> tags,
 	 * which may not be desired in some cases
	 */
	$nl = isset( $param['compact'] ) ? '' : "\n";
  
	if( method_exists( $parser, 'recursiveTagParse' ) ) {
		//new methods in 1.8 allow nesting <nowiki> in <poem>.
		$tag = $parser->insertStripItem( "<br />", $parser->mStripState );
		$text = preg_replace(
			array( "/^\n/", "/\n$/D", "/\n/", "/^( +)/me" ),
			array( "", "", "$tag\n", "str_replace(' ','&nbsp;','\\1')" ),
			$in );
			$text = $parser->recursiveTagParse( $text, $frame );
	} else {
		$text = preg_replace(
			array( "/^\n/", "/\n$/D", "/\n/", "/^( +)/me" ),
			array( "", "", "<br />\n", "str_replace(' ','&nbsp;','\\1')" ),
			$in );
		$ret = $parser->parse(
			$text,
			$parser->getTitle(),
			$parser->getOptions(),
			// We begin at line start
			true,
			// Important, otherwise $this->clearState()
			// would get run every time <ref> or
			// <references> is called, fucking the whole
			// thing up.
			false
		);

		$text = $ret->getText();
	}

	$attribs = Sanitizer::validateTagAttributes( $param, 'div' );

	// Wrap output in a <div> with "poem" class.
	if( isset( $attribs['class'] ) ) {
		$attribs['class'] = 'poem ' . $attribs['class'];
	} else {
		$attribs['class'] = 'poem';
	}

	return Xml::openElement( 'div', $attribs ) .
		$nl .
		trim( $text ) .
		"$nl</div>";
}
