<?php

/**
 * WikiHiero - adds Ancient Egyptian hieroglyphs support to MediaWiki
 *
 * Copyright (C) 2004 Guillaume Blanchard (Aoineko)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

define( 'WIKIHIERO_VERSION', '1.0alpha2' );

$wgHooks['ParserFirstCallInit'][] = 'wfRegisterWikiHiero';
$wgHooks['BeforePageDisplay'][] = 'wfHieroBeforePageDisplay';

// Register MediaWiki extension
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'WikiHiero',
	'version'        => WIKIHIERO_VERSION,
	'author'         => array( 'Guillaume Blanchard', 'Max Semenik' ),
	'url'            => '//www.mediawiki.org/wiki/Extension:WikiHiero',
	'descriptionmsg' => 'wikihiero-desc',
);

$dir = dirname( __FILE__ );

$wgExtensionMessagesFiles['Wikihiero'] = "$dir/wikihiero.i18n.php";
$wgExtensionMessagesFiles['HieroglyphsAlias'] = "$dir/wikihiero.alias.php";

$wgAutoloadClasses['WikiHiero'] = "$dir/wikihiero.body.php";
$wgAutoloadClasses['SpecialHieroglyphs'] = "$dir/SpecialHieroglyphs.php";

$wgParserTestFiles[] = "$dir/tests.txt";

$wgSpecialPages['Hieroglyphs'] = 'SpecialHieroglyphs';
$wgSpecialPageGroups['Hieroglyphs'] = 'wiki';

$wgResourceModules['ext.wikihiero'] = array(
	'styles' => 'ext.wikihiero.css',
	'localBasePath' => "$dir/modules",
	'remoteExtPath' => 'wikihiero/modules',
	'source' => 'common'
);

$wgResourceModules['ext.wikihiero.Special'] = array(
	'scripts' => 'ext.wikihiero.Special.js',
	'styles' => 'ext.wikihiero.Special.css',
	'localBasePath' => dirname( __FILE__ ) . '/modules',
	'remoteExtPath' => 'wikihiero/modules',
	'dependencies' => array( 'jquery.spinner' ),
	'messages' => array(
		'wikihiero-input',
		'wikihiero-result',
		'wikihiero-load-error',
	),
);

$wgCompiledFiles[] = MWInit::extCompiledPath( 'wikihiero/data/tables.php' );

/**
 * Because <hiero> tag is used rarely, we don't need to load its body on every hook call,
 * so we keep our simple hook handlers here.
 *
 * @param $parser Parser
 * @return bool
 */
function wfRegisterWikiHiero( &$parser ) {
	$parser->setHook( 'hiero', 'WikiHiero::parserHook' );
	return true;
}

/**
 * @param $out OutputPage
 * @return bool
 */
function wfHieroBeforePageDisplay( $out ) {
	$out->addModuleStyles( 'ext.wikihiero' );
	return true;
}
