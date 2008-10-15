<?php

/**
 * RandomWiki
 *
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @author Maciej Błaszkowski (Marooned) <marooned@wikia-inc.com>
 * @date 2008-10-14
 * @copyright Copyright (C) 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 */

if (!defined('MEDIAWIKI')) {
        echo "This is MediaWiki extension named RandomWiki.\n";
        exit(1) ;
}

$wgExtensionCredits['specialpage'][] = array(
        'name' => 'RandomWiki',
        'author' => array(
			"[http://www.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]",
			'[http://www.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]'
		 ),
        'description' => 'Lets users explore a random wiki.'
);

$wgSpecialPageGroups['RandomWiki'] = 'wikia';

//Register special page
if (!function_exists('extAddSpecialPage')) {
        require("$IP/extensions/ExtensionFunctions.php");
}
extAddSpecialPage(dirname(__FILE__) . '/SpecialRandomWiki_body.php', 'RandomWiki', 'RandomWiki');
