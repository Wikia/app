<?php
/**
 * @author Magnus Manske
 * @addtogroup Extensions
 * @comment Maintains a table with hash values for category intersections within a page
 * @copyright (c) 2008 by Magnus Manske
 * @license Released under GPL

  SQL for creating categoryintersections table:

  CREATE TABLE `categoryintersections` (
    `ci_page` int(10) unsigned NOT NULL,
    `ci_hash` int(10) unsigned NOT NULL,
    PRIMARY KEY  (`ci_hash`,`ci_page`)
  ) ;

**/

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the skin file directly.
if (!defined('MEDIAWIKI')) {
	echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once("\$IP/extensions/CategoryIntersection/CategoryIntersection.php");
EOT;
	exit(1);
}

$wgExtensionCredits['other'][] = array(
	'name'           => 'Category Intersection',
	'svn-date' => '$LastChangedDate: 2008-08-10 21:29:02 +0200 (ndz, 10 sie 2008) $',
	'svn-revision' => '$LastChangedRevision: 39079 $',
	'author'         => 'Magnus Manske',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:CategoryIntersection',
	'descriptionmsg' => 'categoryintersection-desc',
);

$dir = dirname(__FILE__) . '/';

$wgHooks['LinksUpdate'][] = 'CategoryIntersectionLinksUpdate';
$wgHooks['ArticleDelete'][] = 'CategoryIntersectionArticleDelete';

$wgAutoloadClasses['CategoryIntersection'] = $dir . 'CategoryIntersection_body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['CategoryIntersection'] = $dir . 'CategoryIntersection.i18n.php';
$wgExtensionAliasesFiles['CategoryIntersection'] = $dir . 'CategoryIntersection.alias.php';
$wgSpecialPages['CategoryIntersection'] = 'CategoryIntersection'; # Let MediaWiki know about your new special page.

function CategoryIntersectionGetHashValues ($categories) {
	sort ($categories);
	$hash = array ();
	$hv = array ();
	foreach ($categories AS $k => $c1) {
		foreach ($categories AS $c2) {
			if ($c1 == $c2) continue;
			if ($c1 < $c2) $key = $c1 . '|' . $c2;
			else $key = $c2 . '|' . $c1;
			if (isset ($hash[$key])) continue; // This combination was already done
			$m = md5 ($key);
			$m = hexdec ( substr ( $m , 0 , 8 ) ) ;
			if (isset ($hv[$m])) continue; // This hash value is already in there, prevent unique index conflict
			$hash[$key] = $m;
			$hv[$m] = 1;
		}
		unset ($categories[$k]); // No more combinations with this
	}
	return $hash;
}

/*
 * Updates the category intersection table for a page.
 * Called by LinksUpdate hook.
 */
function CategoryIntersectionLinksUpdate (&$linksUpdate) {

	// Get categories
	$categories = $linksUpdate->mCategories; // The keys of this array are the categories of this page, without cateogry prefix, ucfirst, underscores
	$categories = array_keys ($categories);
	$hash = CategoryIntersectionGetHashValues ($categories);

	// Prepare new hash values for table insertion
	$arr = array ();
	foreach ($hash AS $k => $v) {
		$arr[] = array (
		'ci_page' => $linksUpdate->mId ,
		'ci_hash' => $v
		);
	}

	// Update hash table
	$linksUpdate->dumbTableUpdate ('categoryintersections', $arr, 'ci_page');

	return true; // My work here is done
}

function CategoryIntersectionArticleDelete (&$article, &$user, &$reason) {
  $dbw = wfGetDB( DB_MASTER );
  $dbw->delete ( 'categoryintersections' , array ( "ci_page" => $article->getID() ) ) ;
  return true ;
}
