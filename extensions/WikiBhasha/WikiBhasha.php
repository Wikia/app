<?php
/*
*
*   WikiBhasha
*   Copyright (C) 2010, Microsoft
*   
*   This program is free software; you can redistribute it and/or
*   modify it under the terms of the GNU General Public License version 2
*   as published by the Free Software Foundation.
*   
*   This program is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*   
*   You should have received a copy of the GNU General Public License
*   along with this program; if not, write to the Free Software
*   Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*
*/

// WikiBhasha launch Extention script.
// Description: this script eases the procedure to launch WikiBhasha by instrumenting
// wikipedia pages with links and options to launch the application. It executes the
// same routine as the bookmarklet and is portable across Wikipedia installations.
//
// The current options to launch WikiBhasha are:
// 1. Looks for "action=edit" in the URL and check if toolbar exists. if present adds a
//    icon to the toolbar for launching WikiBhasha.
// 2. inserts a "WikiBhasha" option in the left side toolbox menu.
// 3. Looks for "wbAutoLaunch=true" in the URL and launch WikiBhasha.

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'WikiBhasha',
	'author' => 'Microsoft Research',
	'url' => 'https://www.mediawiki.org/wiki/Extension:WikiBhasha',
	'descriptionmsg' => 'Application to create multilingual content leveraging the English Wikipedia content',
	'version' => '1.0',
);

// static Paths
$dir = dirname( __FILE__ ) . '/';
$jsPath = "extensions/WikiBhasha/src/";

// Autoloadable classes
$wgAutoloadClasses['wikiBhashaExt'] = $dir . 'WikiBhashaExtClass.php';
$wgAutoloadClasses['WikiBhasha'] = $dir . 'WikiBhashaSpecial.php';

// initilize wikiBhasha launch class
$wbExtClass = new wikiBhashaExt();

// add a special page
$wgSpecialPages['WikiBhasha'] = 'WikiBhasha';
$wgSpecialPageGroups['WikiBhasha'] = 'wiki';

$wgAutoloadClasses['WikiBhasha'] = $dir . 'WikiBhasha_body.php'; # Location of the wikibhasha class (Tell MediaWiki to load this file)
$wgExtensionMessagesFiles['WikiBhasha'] = $dir . 'WikiBhasha.i18n.php'; # Location of a messages file (Tell MediaWiki to load this file)
$wgExtensionMessagesFiles['WikiBhashaAlias'] = $dir . 'WikiBhasha.alias.php'; # Location of a messages file (Tell MediaWiki to load this file)

$wgHooks['MonoBookTemplateToolboxEnd'][] = array( $wbExtClass, 'wikiBhashaToolbox' );
$wgHooks['BeforePageDisplay'][] = array( $wbExtClass, 'wbToolbarIcon' );
