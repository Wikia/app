<?php
/**
 * MediaWiki Interlanguage extension
 *
 * Copyright © 2008-2011 Nikola Smolenski <smolensk@eunet.rs> and others
 * @version 1.5
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * For more information,
 * @see http://www.mediawiki.org/wiki/Extension:Interlanguage
 */

$wgInterlanguageExtensionDB = false;
$wgInterlanguageExtensionApiUrl = false;
$wgInterlanguageExtensionInterwiki = "";
$wgInterlanguageExtensionSort = 'none';
$wgInterlanguageExtensionSortPrepend = false;

$wgExtensionCredits['parserhook'][] = array(
	'path'			=> __FILE__,
	'name'			=> 'Interlanguage',
	'author'			=> 'Nikola Smolenski',
	'url'				=> 'http://www.mediawiki.org/wiki/Extension:Interlanguage',
	'version'			=> '1.5',
	'descriptionmsg'	=> 'interlanguage-desc',
);
$wgExtensionMessagesFiles['Interlanguage'] = dirname(__FILE__) . '/Interlanguage.i18n.php';
$wgExtensionMessagesFiles['InterlanguageMagic'] = dirname(__FILE__) . '/Interlanguage.i18n.magic.php';
$wgAutoloadClasses['InterlanguageExtension'] = dirname(__FILE__) . '/InterlanguageExtension.php';
$wgHooks['ParserFirstCallInit'][] = 'wfInterlanguageExtension';
$wgResourceModules['ext.Interlanguage'] = array(
	'styles' => 'modules/interlanguage.css',
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'Interlanguage',
);

/**
 * @param $parser Parser
 * @return bool
 */
function wfInterlanguageExtension( $parser ) {
	global $wgHooks, $wgInterlanguageExtension;

	if( !isset($wgInterlanguageExtension) ) {
		$wgInterlanguageExtension = new InterlanguageExtension();
		$wgHooks['OutputPageParserOutput'][] = $wgInterlanguageExtension;
		$wgHooks['EditPage::showEditForm:fields'][] = array( $wgInterlanguageExtension, 'pageLinks' );
		$wgHooks['SkinTemplateOutputPageBeforeExec'][] = $wgInterlanguageExtension;
		$parser->setFunctionHook( 'interlanguage', array( $wgInterlanguageExtension, 'interlanguage' ), SFH_NO_HASH );
	}
	return true;
}
