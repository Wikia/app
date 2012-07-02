<?php
/**
 * Wikitext scripting infrastructure for MediaWiki.
 * Copyright (C) 2009-2012 Victor Vasiliev <vasilvv@gmail.com>
 * http://www.mediawiki.org/
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

if( !defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['parserhook']['Scripting'] = array(
	'path'           => __FILE__,
	'name'           => 'Scripting',
	'author'         => 'Victor Vasiliev',
	'descriptionmsg' => 'scripting-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Scripting',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Scripting'] = $dir . 'i18n/Messages.php';
$wgExtensionMessagesFiles['ScriptingMagic'] = $dir . 'i18n/Magic.php';
$wgExtensionMessagesFiles['ScriptingNamespaces'] = $dir . 'i18n/Namespaces.php';

$wgAutoloadClasses['ScriptingEngineBase'] = $dir.'common/Base.php';
$wgAutoloadClasses['ScriptingModuleBase'] = $dir.'common/Base.php';
$wgAutoloadClasses['ScriptingFunctionBase'] = $dir.'common/Base.php';
$wgAutoloadClasses['ScriptingHooks'] = $dir.'common/Hooks.php';
$wgAutoloadClasses['ScriptLinksUpdateHooks'] = $dir.'common/LinkUpdates.php';
$wgAutoloadClasses['ScriptingException'] = $dir.'common/Common.php';
$wgAutoloadClasses['Scripting'] = $dir.'common/Common.php';

$wgHooks['ParserFirstCallInit'][] = 'ScriptingHooks::setupParserHook';
$wgHooks['ParserLimitReport'][] = 'ScriptingHooks::reportLimits';
$wgHooks['ParserClearState'][] = 'ScriptingHooks::clearState';
$wgHooks['ParserTestTables'][] = 'ScriptingHooks::addTestTables';

$wgHooks['CanonicalNamespaces'][] = 'ScriptingHooks::addCanonicalNamespaces';
$wgHooks['ArticleViewCustom'][] = 'ScriptingHooks::handleScriptView';
$wgHooks['TitleIsWikitextPage'][] = 'ScriptingHooks::isWikitextPage';
$wgHooks['CodeEditorGetPageLanguage'][] = 'ScriptingHooks::getCodeLangauge';
$wgHooks['EditFilter'][] = 'ScriptingHooks::validateScript';

$wgHooks['LinksUpdate'][] = 'ScriptLinksUpdateHooks::updateLinks';
$wgHooks['ArticleEditUpdates'][] = 'ScriptLinksUpdateHooks::purgeCache';
$wgHooks['ParserAfterTidy'][] = 'ScriptLinksUpdateHooks::appendToOutput';
$wgHooks['BacklinkCacheGetPrefix'][] = 'ScriptLinksUpdateHooks::getBacklinkCachePrefix';
$wgHooks['BacklinkCacheGetConditions'][] = 'ScriptLinksUpdateHooks::getBacklinkCacheConditions';

/***** Individual engines and their configurations *****/

/**
 * Available scripting engines.
 */
$wgScriptingEngines = array(
	'luasandbox' => 'LuaSandboxEngine',
);

$wgAutoloadClasses['LuaSandboxEngine'] = $dir.'engines/LuaSandbox/Engine.php';

/***** Configuration *****/

/**
 * The name of the scripting engine.
 */
$wgScriptingEngine = false;


$wgScriptingEngineConf = array();

/**
 * Script namespace numbers.
 */
$wgScriptingNamespaceNumbers = array(
	'Module' => 20,
	'Module_talk' => 21,
);

/**
 * Turn on to true if SyntaxHighlight_GeSHi extension is enabled.
 */
$wgScriptingUseGeSHi = false;

/**
 * Turn on to true if CodeEditor extension is enabled.
 */
$wgScriptingUseCodeEditor = false;

function efDefineScriptingNamespace() {
	global $wgScriptingNamespaceNumbers;
	define( 'NS_MODULE', $wgScriptingNamespaceNumbers['Module'] );
	define( 'NS_MODULE_TALK', $wgScriptingNamespaceNumbers['Module_talk'] );
}

$wgExtensionFunctions[] = 'efDefineScriptingNamespace';
