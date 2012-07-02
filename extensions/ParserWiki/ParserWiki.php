<?php
/**
 * Allows people to define a grammar in a wiki then use that grammar to input information to the same wiki
 * @ingroup Extensions
 * @author Nathanael Thompson <than4213@gmail.com>
 * @copyright Copyright © 2010 Nathanael Thompson
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
if ( !defined( "MEDIAWIKI" ) ) {
	die( "This is not a valid entry point.\n" );
}

$wgExtensionCredits["other"][] = array(
	"path" => __FILE__,
	"name" => "ParserWiki",
	"author" => "Nathanael Thompson",
	"url" => "http://www.mediawiki.org/wiki/Extension:ParserWiki",
	"version" => "1.0",
	"descriptionmsg" => "parserwiki-desc",
);
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['ParseEngine'] = $dir . "ParseEngine.php";
$wgExtensionMessagesFiles['ParserWiki'] = $dir . 'ParserWiki.i18n.php';

$wgTheParserWiki = new ParserWiki();
$wgHooks["ParserBeforeStrip"][] = array( $wgTheParserWiki, "callFromParse" );

define ( "NS_GRAMMAR" , 91628 );
define ( "NS_GRAMMAR_TALK" , 91629 );
$wgExtraNamespaces[NS_GRAMMAR] = "Grammar";
$wgExtraNamespaces[NS_GRAMMAR_TALK] = "Grammar_talk";

class ParserWiki {
	private $mEngines;

	function __construct() {
		$this->mEngines = array();
	}

	function callFromParse( $unUsed, &$text ) {
		global $wgParserWikiGrammar;
		$engine = $this->mEngines[$wgParserWikiGrammar];
		if ( $engine == NULL ) {
			$revision = Revision::newFromTitle( Title::newFromText( $wgParserWikiGrammar, NS_GRAMMAR ) );
			$grammar = new DOMDocument();
			if ( $revision == NULL || ! $grammar->loadXML( $revision->getText(), LIBXML_NOBLANKS ) ) {
				return TRUE;
			}
			$engine = new ParseEngine( $grammar );
			$this->mEngines[$wgParserWikiGrammar] = $engine;
		}
		$parseTree = $engine->parse( $text );
		if ( $parseTree == NULL ) {
			return TRUE;
		}
		$text = $parseTree->saveXML();
		return FALSE;
	}
}
