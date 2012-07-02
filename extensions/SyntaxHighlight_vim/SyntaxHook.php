<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();
/**
 * @file
 * @ingroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2006, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Syntax',
	'author' => 'Ævar Arnfjörð Bjarmason',
	'description' => 'adds a <code>&lt;syntax&gt;</code> parser hook for highlighting'
);

$wgHooks['ParserFirstCallInit'][] = 'wfSyntaxHighlightVimSetHook';

function wfSyntaxHighlightVimSetHook( $parser ) {
	$parser->setHook( 'syntax', 'wfSyntaxHighlightVimRender' );
	return true;
}

function wfSyntaxHighlightVimRender( $in, array $argv ) {
	$in = ltrim( $in, "\n" );
	$syntax = new Syntax( $in );

	return $syntax->getOut();
}
