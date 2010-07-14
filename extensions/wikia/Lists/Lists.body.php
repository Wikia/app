<?php
/**
 * Lists
 *
 * This extension will allow easy creation and sharing of lists
 * either as an addition to an existing wiki or as a standalone wiki.
 * https://contractor.wikia-inc.com/wiki/Lists
 *
 * @author Sean Colombo <sean at wikia-inc dot com>
 * @date 20100330
 * @copyright Copyright (C) 2010 Sean Colombo, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/Lists/Lists.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named 'Lists'.\n";
	exit(1) ;
}


/**
 * Returns true iff all of prefix is found at the beginning of haystack.
 */
function startsWith($haystack, $prefix){
	return (strpos($haystack, $prefix) === 0);
} // end startsWith(...)


class ListExt {
	/**
	 * Using the current settings, determines if this page
	 * should be treated as a list.
	 */
	static function isThisPageAList(){
		global $wgTitle;
		global $wgListsNamespace, $wgListsNamespace_talk, $wgListCategoryPrefix, $wgListItemCategoryPrefix;
		$isList = false;

		if($wgTitle->getNamespace() == $wgListsNamespace){
			$isList = true;
		}

		return $isList;
	} // end isThisPageAList()

	/**
	 * Return true if and only if this is a category page which is made for showing lists or
	 * list-items.
	 */
	static function isThisPageAListCategory(){
		global $wgTitle;
		global $wgListsNamespace, $wgListsNamespace_talk, $wgListCategoryPrefix, $wgListItemCategoryPrefix;
		$isListCategory = false;

		if($wgTitle->getNamespace() == NS_CATEGORY){
			$textWithSpaces = str_replace("_", " ", $wgTitle->getText());
			// If this category starts with the list category or list-item category prefix, then this page should be modified by this extension.
			if((startsWith($textWithSpaces, $wgListCategoryPrefix)) || (startsWith($textWithSpaces, $wgListItemCategoryPrefix))){
				$isListCategory = true;
			}
		}

		return $isListCategory;
	} // end isThisPageAListCategory()
}
