<?php
# Example WikiMedia extension

if (!defined('GWBBCODE_ROOT')) define('GWBBCODE_ROOT', "$IP/extensions/3rdparty/PvX/gwbbcode");
require_once(GWBBCODE_ROOT.'/gwbbcode.inc.php');

//var_export(get_defined_vars());

$wgHooks['ParserFirstCallInit'][] = "wfPvXcodeParser";
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'PvX code Parser',
	'url' => 'http://www.gcardinal.com/',
	'author' => 'gcardinal',
	'description' => 'Skin, theme, wiki-implementation (c) gcardinal under by-nc-nd/3.0. Profession logos (c) LordBiro GuildWarsWiki used under CC by-nc-sa. Code partially based on gwBBcode (c) Pierre pikiou Scelles used under GPL.',
);

function wfPvXcodeParser( $parser ) {
	$parser->setHook( "pvxbig", "PvXparser" );
	return true;
}

function PvXparser( $input, $argv, $parser )
{
	global $wgServer;

	$doit = new ParseIt( $parser );
	$input = $doit->parse( $input );
	$art_title = $parser->mTitle->getText();
	$output = parse_gwbbcode($input, $art_title);

	# Hack to point the download button to a dedicated special page
	$output = str_replace('/template.php', Title::newFromText( 'DownloadTemplate', NS_SPECIAL )->getFullUrl(), $output);

	return $output;
}

class ParseIt {
	var $parser;
	function ParseIt( &$parser )
	{
		$this->parser =& $parser;
	}
	/** Pass text through the parser */
	function parse( $text ) {
		wfProfileIn( 'Sorter::parse' );
		$title =& $this->parser->getTitle();
		$options = $this->parser->getOptions();
		$output = $this->parser->parse( $text, $title, $options, true, false );
		wfProfileOut( 'Sorter::parse' );
		return $output->getText();
	}
}
