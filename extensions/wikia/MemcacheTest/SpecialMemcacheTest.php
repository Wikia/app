<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id: SpecialTaskManager.php 5982 2007-10-02 14:07:24Z eloy $
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

#--- permissions
$wgAvailableRights[] = 'wikifactory';
$wgGroupPermissions['staff']['wikifactory'] = true;

#--- register special page (MW 1.10 way)

extAddSpecialPage( dirname(__FILE__) . "/SpecialMemcacheTest_body.php", "MemcacheTest", "MemcacheTestPage" );
