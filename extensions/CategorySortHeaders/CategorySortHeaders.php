<?php
if (!defined( 'MEDIAWIKI' ) ) die('Not an entry point');

/**
 * Extension to allow specifying custom multi-character 'first-character'
 * sorting headers to list pages under in categories, using syntax like 
 * [[category:Foo|^Header^Invisible part of sortkey]] or even just
 * [[category:Foo|^Header^]].
 *
 * Note, this extension is incompatible with changing $wgCategoryCollation
 * in LocalSettings.php. It defines its own Collation that is
 * roughly equivalent to 'uppercase', and thus can't be used
 * with 'uca-default' or any other custom collation.
 * Additionally, this extension requires at least MediaWiki 1.19.
 *
 * To install:
 * Add to the bottom of LocalSettings.php:
 *	require_once( "$IP/extensions/CategorySortHeaders/CategorySortHeaders.php" );
 * Run either update.php or updateCollation.php
 * (update.php can be run from the web installer if need be.)
 *
 **************************************************************
 *
 * Copyright © 2011 Brian Wolff
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
 *
 * @author Brian Wolff
 */


$wgExtensionCredits['other'][] = array(
        'path' => __FILE__,
        'name' => 'CategorySortHeaders',
        'author' => '[http://mediawiki.org/wiki/User:Bawolff Brian Wolff]',
        'descriptionmsg' => 'categorysortheaders-desc',
        'url' => 'https://www.mediawiki.org/wiki/Extension:CategorySortHeaders',
        'version' => 0.2,
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['CategorySortHeaders'] = $dir . 'CategorySortHeaders.i18n.php';
$wgAutoloadClasses['CustomHeaderCollation'] = $dir . 'CategorySortHeaders_body.php';

$wgCategoryCollation = 'CustomHeaderCollation';

// Control if a sortkey of ^foo^ is considered just ^foo^ or ^foo^{{PAGENAME}}.
// After changing this option, you should run the maintinance script (the --force is important)
// php updateCollations.php --force

$wgCategorySortHeaderAppendPageNameToKey = true;

$wgHooks['Collation::factory'][] = 'wfCategorySortHeadersSetup';

function wfCategorySortHeadersSetup( $collationName, &$collationObject ) {
	if ( $collationName === 'CustomHeaderCollation' ) {
		$collationObject = new CustomHeaderCollation;
		return false;
	}
	return true;
}
