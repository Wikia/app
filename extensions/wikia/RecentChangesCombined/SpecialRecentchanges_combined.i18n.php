<?php

/**
 * I18n for the special page to show recent changes from one or more wiki
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Przemek Piotrowski <ppiotr@wikia.com> for Wikia, Inc.
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

global $wgMessageCache;
foreach (array
(
	'en' => array
	(
		'recentchanges_combined' => 'Recent changes (combined)',
	),
) as  $lang => $messages)
{
	$wgMessageCache->addMessages($messages, $lang);
}

?>
