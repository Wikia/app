<?php

/**
 * Special page to clear user cache
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Przemek Piotrowski <ppiotr@wikia.com>
 * @copyright
 * @licence
 */
 
if (!defined('MEDIAWIKI'))
{
	echo "This file is an extension to the MediaWiki software and cannot be used standalone.\n";
	exit(1);
}

$wgAutoloadClasses['ClearUserCache'] =  dirname( __FILE__ ) . '/class.php';
$wgSpecialPages['ClearUserCache']    = 'ClearUserCache';
$wgHooks['LoadAllMessages'][]        = 'ClearUserCache::loadMessages';

?>
