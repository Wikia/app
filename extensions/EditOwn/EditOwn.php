<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Roan Kattouw <roan.kattouw@home.nl>
 * @copyright Copyright © 2007 Roan Kattouw 
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * An extension that allows changing the author of a revision
 * Written for by Roan Kattouw <roan.kattouw@home.nl>
 * For information how to install and use this extension, see http://www.mediawiki.org/wiki/Extension:EditOwn
 *
 */
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the extension file directly.
if (!defined('MEDIAWIKI')) {
		echo <<<EOT
To install the EditOwn extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/EditOwn/EditOwn.php" );
EOT;
		exit(1);
}

$wgExtensionCredits['other'][] = array(
	'name'          => 'EditOwn',
	'author'        => 'Roan Kattouw',
	'url'           => 'http://www.mediawiki.org/wiki/Extension:EditOwn',
	'version'       => '1.0.1',
	'description'   => 'Users without the editall right can only edit pages they\'ve created',
	'descriptionmsg' => 'editown-desc',
);

$wgExtensionMessagesFiles['EditOwn'] = dirname(__FILE__) . '/EditOwn.i18n.php';

$wgHooks['userCan'][] = 'EditOwn';

$wgEditOwnExcludedNamespaces = array();

function EditOwn($title, $user, $action, &$result) {
		static $cache = array();
		global $wgEditOwnExcludedNamespaces;
		if(!is_array($wgEditOwnExcludedNamespaces))
				// Prevent PHP from whining
				$wgEditOwnExcludedNamespaces = array();
		
		if($action != 'edit' || $user->isAllowed('editall') || in_array($title->getNamespace(), $wgEditOwnExcludedNamespaces)) {
				$result = null;
				return true;
		}
		
		if(isset($cache[$user->getName()][$title->getArticleId()])) {
				$result = $cache[$user->getName()][$title->getArticleId()];
				return is_null($result);
		}
		
		// Since there's no easy way to get the first revision, we'll just do a DB query
		$dbr = wfGetDB(DB_SLAVE);
		$res = $dbr->select('revision', Revision::selectFields(),
							array('rev_page' => $title->getArticleId()),
							__METHOD__, array('ORDER BY' => 'rev_timestamp ASC', 'LIMIT' => 1));
		if(!($row = $dbr->fetchObject($res))) {
				// Nonexistent title? Creation is allowed
				$result = $cache[$user->getName()][$title->getArticleId()] = null;
				return true;
		}
		$rev = new Revision($row);
		if($user->getName() == $rev->getRawUserText()) {
				$result = $cache[$user->getName()][$title->getArticleId()] = null;
				return true;
		}
		return($result = $cache[$user->getName()][$title->getArticleId()] = false);
}
