<?php
/**
 * Lua parser extensions for MediaWiki
 *
 * @author Fran Rogers
 * @package MediaWiki
 * @addtogroup Extensions
 * @license See 'COPYING'
 * @file
 */

$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'Lua parser extensions',
	'author'         => 'Fran Rogers',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Lua',
	'description'    => 'Extends the parser with support for embedded blocks of Lua code',
	'descriptionmsg' => 'lua_desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Lua'] = $dir . 'Lua.i18n.php';
$wgAutoloadClasses['LuaHooks'] = $dir . 'Lua.hooks.php';
$wgAutoloadClasses['LuaError'] = $dir . 'Lua.wrapper.php';
$wgAutoloadClasses['LuaWrapper'] = $dir . 'Lua.wrapper.php';

if (!isset($wgLuaExternalInterpreter))
	$wgLuaExternalInterpreter = FALSE;
if (!isset($wgLuaExternalCompiler))
	$wgLuaExternalCompiler = FALSE;
if (!isset($wgLuaMaxLines))
	$wgLuaMaxLines = 1000000;
if (!isset($wgLuaMaxCalls))
	$wgLuaMaxCalls = 2000;
if (!isset($wgLuaMaxTime))
	$wgLuaMaxTime = 5;


$wgHooks['ParserFirstCallInit'][] = 'LuaHooks::parserInit';
$wgHooks['LanguageGetMagic'][] = 'LuaHooks::magic';
$wgHooks['ParserBeforeTidy'][] = 'LuaHooks::beforeTidy';
