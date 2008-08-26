<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Helper functions to locate when memory is consumed
 *
 * @addtogroup Extensions
 *
 * @author Niklas Laxström
 * @copyright Copyright © 2008, Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgMemUse = array();
$wgMemStack = 0;
function wfMemIn( $a ) {
	global $wgLang, $wgMemUse, $wgMemStack;
	$mem = memory_get_usage();
	$memR = memory_get_usage();

	$wgMemUse[$a][] = array( $mem, $memR );

	$memF = $wgLang->formatNum( $mem );
	$memRF = $wgLang->formatNum( $memR );

	$pad = str_repeat( ".", $wgMemStack );
	wfDebug( "$pad$a-IN: \t$memF\t\t$memRF\n" );
	$wgMemStack++;
}

function wfMemOut( $a ) {
	global $wgLang, $wgMemUse, $wgMemStack;
	$mem = memory_get_usage();
	$memR = memory_get_usage();

	list( $memO, $memOR ) = array_pop( $wgMemUse[$a] );

	$memF = $wgLang->formatNum( $mem );
	$memRF = $wgLang->formatNum( $memR );

	$memD = $mem - $memO;
	$memRD = $memR - $memOR;

	$memDF = $wgLang->formatNum( $memD );
	$memRDF = $wgLang->formatNum( $memRD );

	$pad = str_repeat( ".", $wgMemStack-1 );
	wfDebug( "$pad$a-OUT:\t$memF ($memDF)\t$memRF ($memRDF)\n" );
	$wgMemStack--;
}
