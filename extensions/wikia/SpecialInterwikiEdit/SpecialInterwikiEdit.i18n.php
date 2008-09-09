<?php

/**
 * SpecialInterwikiEdit
 *
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2008-09-09
 * @copyright Copyright (C) 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named InterwikiEdit.\n";
	exit(1) ;
}

$messages = array(
	'en' => array(
		'iwedit-title'	 		=> 'Interwiki Editor',
		'iwedit-language-interwikis' 	=> 'language interwikis only',
		'iwedit-all-interwikis' 	=> 'all interwikis',
		'iwedit-update' 		=> 'Update',
        	'iwedit-error' 			=> '<p>An error occured.</p>',
	        'iwedit-success' 		=> '<p>Link creation succesfull.</p>',
	)
);
