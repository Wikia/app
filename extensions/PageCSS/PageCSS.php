<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A parser hook to add per-page CSS to pages with the <css> tag
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionFunctions[] = array( 'CssHook', 'setup' );
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Page CSS',
	'description' => 'Parser hook to add per-page CSS using the <tt>&lt;css&gt;</tt> tag',
	'author' => 'Ævar Arnfjörð Bjarmason'
);

class CssHook {

	public static function setup() {
		global $wgParser;
		$wgParser->setHook( 'css', array( 'CssHook', 'parse' ) );
	}
	
	public static function parse( $content, array $args, Parser $parser ) {
		$css = htmlspecialchars( trim( Sanitizer::checkCss( $content ) ) );
		$parser->mOutput->addHeadItem( <<<EOT
<style type="text/css">
/*<![CDATA[*/
{$css}
/*]]>*/
</style>
EOT
		);
	}

}