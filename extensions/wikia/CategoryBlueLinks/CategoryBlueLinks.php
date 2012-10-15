<?php

/**
 * CategoryBlueLinks
 *
 * This extension makes links to category pages with content appear as "known" (aka "blue").
 *
 * @author Lucas 'TOR' Garczewski <tor@wikia-inc.com>
 * @date 2011-08-08
 *
 * @author Jakub Olek
 * @date 2011-dec-13
 * Added simple logic to leave links to categories (with no content and no page) red.
 *
 * @copyright Copyright (C) 2011 Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'CategoryBlueLinks',
	'author' => array( "[http://community.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]" ),
	'description' => 'This extension makes all link to category pages appear as "known" (aka "blue").',
);

$wgHooks['LinkBegin'][] = 'efCategoryBlueLinks';

/**
 * @param $skin DummyLinker
 * @param $target Title
 * @param $text String
 * @param $customAttribs array
 * @param $query array
 * @param $options string|array
 * @param $ret
 * @return bool
 */
function efCategoryBlueLinks( $skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret ) {
	// paranoia
	if ( is_null( $target ) ) {
		return true;
	}

	// only affects non-existing Category pages that has content
	if ( $target->exists() || $target->getNamespace() != NS_CATEGORY || Category::newFromTitle( $target )->getPageCount() == 0 ) {
		return true;
	}

	// remove "broken" assumption/override
	$brokenKey = array_search( 'broken', $options );
	if ( $brokenKey !== false ) {
		unset( $options[$brokenKey] );
	}

	// make the link "blue"
	$options[] = 'known';

	// add a class to identify non-existing links, in case we (or our users) want to modify display
	if ( array_key_exists( 'class', $customAttribs ) ) {
		$customAttribs['class'] = $customAttribs['class']  . ' newcategory';
	} else {
		$customAttribs['class'] = 'newcategory';
	}

	return true;
}
