<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Roan Kattouw <roan.kattouw@home.nl>
 * @copyright Copyright (C) 2008 Roan Kattouw 
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * An extension that allows for searching inside categories
 * Written for MixesDB <http://mixesdb.com> by Roan Kattouw <roan.kattouw@home.nl>
 * For information how to install and use this extension, see the README file.
 *
 */
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the extension file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install the AdvancedSearch extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/AdvancedSearch/AdvancedSearch.setup.php" );
EOT;
	exit(1);
}

/**
 * A class that does category intersections using the categorysearch table
 */
class AdvancedSearchCategoryIntersector
{
	/**
	 * Update the categorysearch table
	 * @param $pageid int Page ID
	 * @param $categories array Array of categories (DB keys)
	 */
	static function update($pageid, $categories)
	{
		global $wgContLang;
		$ctext = $wgContLang->stripForSearch(implode(' ', $categories));
		$dbw = wfGetDb(DB_MASTER);
		$dbw->replace('categorysearch', 'cs_page',
			array('cs_page' => $pageid, 'cs_categories' => $ctext),
			__METHOD__);
	}
	
	/**
	 * Remove the entry for a page
	 * @param $pageid int Page ID
	 */
	static function remove($pageid)
	{
		$dbw = wfGetDb(DB_MASTER);
		$dbw->delete('categorysearch', array('cs_page' => $pageid), __METHOD__);
	}
	
	/**
	 * Hook function for 'LinksUpdate' hook
	 * @param $lu LinksUpdate
	 */
	static function LinksUpdate(&$lu)
	{
		self::update($lu->mId, array_keys($lu->mCategories));
		return true;
	}
	
	static function ArticleDeleteComplete(&$article, &$user, $reason, $id)
	{
		self::remove($article->getID());
		return true;
	}
}
