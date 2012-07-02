<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

/**#@+
 * An extension that adds a <stockchart ticker="TIKR"/> tag extension and
 * {{#stockchart: ticker="TIKR"}} parser function for adding
 * interactive financial charts within an article.
 *
 * @file
 * @ingroup Extensions
 *
 * @author Brendan Meutzner
 * @author Anton Zolotkov
 * @author Roger Fong
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 */

$wgHooks['ParserFirstCallInit'][] = 'efStockChartsSetHooks';

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'StockCharts',
	'path' => __FILE__,
	'author' => 'Brendan Meutzner, Anton Zolotkov, Roger Fong',
	'descriptionmsg' => 'stockcharts-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:StockCharts',
	'version' => '0.3',
);

# Internationalisation file
$wgExtensionMessagesFiles['StockCharts'] =  dirname( __FILE__ ) . '/StockCharts.i18n.php';
$wgExtensionMessagesFiles['StockChartsMagic'] =  dirname( __FILE__ ) . '/StockCharts.i18n.magic.php';

$wgAutoloadClasses['StockCharts'] = dirname( __FILE__ ) . '/StockCharts_body.php';

function efStockChartsSetHooks( $parser ) {
	$parser->setHook( 'stockchart', array( 'StockCharts', 'renderTagExtension' ) ); // hook for <stockchart ../>
	$parser->setFunctionHook( 'stockchart', array( 'StockCharts', 'renderParserFunction' ) ); // hook for {{#stockchart ..}}
	return true;
}
