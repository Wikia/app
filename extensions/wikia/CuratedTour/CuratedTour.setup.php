<?php

/**
 * Wikia Flags Extension
 *
 * Have you ever tried to a content of an article but had to scroll through a dozen of crazy
 * messages? They were saying something about missing sources and references, something about
 * an article being messy... While these notifications are very useful in general, you don't
 * want to see them all the time in every context.
 *
 * This extension provides a new way of storing and managing of the Flags that allows them
 * to be portable and behave accordingly to a given context.
 *
 * @author Adam Karmiński <adamk@wikia-inc.com>
 * @copyright (c) 2015 Wikia, Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = [
	'name'				=> 'CuratedTour',
	'version'			=> '1.0',
	'author'			=> 'Adam Karmiński',
	'url'               => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CuratedTour',
	'descriptionmsg'    => 'curated-tour-desc',
];

$wgGroupPermissions['sysop']['curated-tour-administration'] = true;

$wgExtensionMessagesFiles['CuratedTour'] = __DIR__ . '/CuratedTour.i18n.php';

$wgAutoloadClasses['CuratedTourController'] = __DIR__ . '/controllers/CuratedTourController.class.php';
$wgAutoloadClasses['CuratedTourHooks'] = __DIR__ . '/CuratedTour.hooks.php';
$wgAutoloadClasses['SpecialCuratedTourController'] = __DIR__ . '/controllers/SpecialCuratedTourController.class.php';


$wgHooks['BeforePageDisplay'][] = 'CuratedTourHooks::onBeforePageDisplay';
$wgHooks['WikiaSkinTopScripts'][] = 'CuratedTourHooks::onWikiaSkinTopScripts';

JSMessages::registerPackage( 'CuratedTourEditBox', [
	'curated-tour-edit-box-*'
] );
JSMessages::registerPackage( 'CuratedTourNavigatorBox', [
	'curated-tour-navigator-box-*'
] );

$wgSpecialPages['CuratedTour'] = 'SpecialCuratedTourController';

