<?php
/**
 * Built-in scripting language for MediaWiki.
 * Copyright (C) 2009-2011 Victor Vasiliev <vasilvv@gmail.com>
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

$wgExtensionCredits['parserhook']['WikiScripts'] = array(
	'path'           => __FILE__,
	'name'           => 'WikiScripts',
	'author'         => 'Victor Vasiliev',
	'descriptionmsg' => 'wikiscripts-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:WikiScripts',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['WikiScripts'] = $dir . 'i18n/Messages.php';
$wgExtensionMessagesFiles['WikiScriptsMagic'] = $dir . 'i18n/Magic.php';
$wgExtensionMessagesFiles['WikiScriptsNamespaces'] = $dir . 'i18n/Namespaces.php';

$wgAutoloadClasses['WSHooks'] = $dir . '/Hooks.php';
$wgAutoloadClasses['WSLinksUpdateHooks'] = $dir . '/LinksUpdate.php';

$wgAutoloadClasses['WSInterpreter'] = $dir . 'interpreter/Interpreter.php';
$wgAutoloadClasses['WSScanner'] = $dir . 'interpreter/Scanner.php';
$wgAutoloadClasses['WSLRParser'] = $dir . 'interpreter/LRParser.php';

$wgAutoloadClasses['WSStringLibrary'] = $dir . 'interpreter/lib/String.php';
$wgAutoloadClasses['WSTemplateLibrary'] = $dir . 'interpreter/lib/Template.php';

$wgParserTestFiles[] = $dir . 'interpreterTests.txt';
$wgHooks['ParserFirstCallInit'][] = 'WSHooks::setupParserHook';
$wgHooks['ParserLimitReport'][] = 'WSHooks::reportLimits';
$wgHooks['ParserClearState'][] = 'WSHooks::clearState';
$wgHooks['ParserTestTables'][] = 'WSHooks::addTestTables';

$wgHooks['CanonicalNamespaces'][] = 'WSHooks::addCanonicalNamespaces';
$wgHooks['ArticleViewCustom'][] = 'WSHooks::handleScriptView';
$wgHooks['TitleIsWikitextPage'][] = 'WSHooks::isWikitextPage';
$wgHooks['EditFilter'][] = 'WSHooks::validateScript';

$wgHooks['LinksUpdate'][] = 'WSLinksUpdateHooks::updateLinks';
$wgHooks['ArticleEditUpdates'][] = 'WSLinksUpdateHooks::purgeCache';
$wgHooks['ParserAfterTidy'][] = 'WSLinksUpdateHooks::appendToOutput';
$wgHooks['BacklinkCacheGetPrefix'][] = 'WSLinksUpdateHooks::getBacklinkCachePrefix';
$wgHooks['BacklinkCacheGetConditions'][] = 'WSLinksUpdateHooks::getBacklinkCacheConditions';

/** Configuration */

/**
 * Script namespace numbers. Should be redefined before
 * the inlcusion of the extension.
 */
if( !isset( $wgScriptsNamespaceNumbers ) ) {
	$wgScriptsNamespaceNumbers = array(
		'Module' => 20,
		'Module_talk' => 21,
	);
}

/**
 * Different limits of the scripts.
 */
$wgScriptsLimits = array(
	/**
	 * Maximal amount of tokens (strings, keywords, numbers, operators,
	 * but not whitespace) in a single module to be parsed.
	 */
	'tokens' => 1000000,

	/**
	 * Maximal amount of operations (multiplications, comarsions, function
	 * calls) to be done.
	 */
	'evaluations' => 300000,

	/**
	 * Maximal depth of recursion when evaluating the parser tree in a single function. For
	 * example 2 + 2 * 2 ** 2 is parsed to (2 + (2 * (2 ** 2))) and needs
	 * depth 3 to be parsed.
	 */
	'depth' => 35,
);

/**
 * Turn on to true if you have linked or copied wikiscripts.php and
 * SyntaxHighlight_GeSHi extension is enabled.
 */
$wgScriptsUseGeSHi = false;

/**
 * Class of the actual parser. Must implement WSParser interface, as well as
 * static getVersion() method.
 */
$wgScriptsParserClass = 'WSLRParser';

$wgScriptsLibraryClasses = array(
	'str' => 'WSStringLibrary',
	'tpl' => 'WSTemplateLibrary',
);

/**
 * Should be enabled unless you are debugging or just have sado-masochistic
 * attitude towards your server.
 */
$wgScriptsUseCache = true;

/**
 * Indicates whether the function recursion is enabled. If it is, then users may
 * build a Turing-complete machinge and do nice things like parsers, etc in wikitext!
 */
$wgScriptsAllowRecursion = false;

/**
 * Maximun call stack depth. Includes functions and invokations of parse() function.
 */
$wgScriptsMaxCallStackDepth = 25;

define( 'NS_MODULE', $wgScriptsNamespaceNumbers['Module'] );
define( 'NS_MODULE_TALK', $wgScriptsNamespaceNumbers['Module_talk'] );
