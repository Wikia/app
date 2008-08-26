<?php

/**
 * Special page to show recent changes from one or more wiki
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Przemek Piotrowski <ppiotr@wikia.com> for Wikia, Inc.
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

if (!defined('MEDIAWIKI'))
{
    echo "This is MediaWiki extension.\n";
    exit(1);
}

extAddSpecialPage(dirname(__FILE__) . '/SpecialRecentchanges_combined_body.php', 'Recentchanges_combined', 'SpecialRecentchanges_combined');

?>
