<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}


/**
 * @addtogroup SpecialPage
 */
class MemcacheTestPage extends SpecialPage {
	public function  __construct() {
		parent::__construct( "MemcacheTest"  /*class*/, 'wikifactory' /*restriction*/, false );
	}

	public function execute( $subpage ) {
		 global $wgUser, $wgOut, $wgRequest, $wgMemc;

        if ( $wgUser->isBlocked() ) {
            $wgOut->blockedPage();
            return;
        }
        if ( wfReadOnly() ) {
            $wgOut->readOnlyPage();
            return;
        }
        if ( !$wgUser->isAllowed( 'wikifactory' ) ) {
            $this->displayRestrictionError();
            return;
        }

        $wgOut->setPageTitle( wfMsg('memcachetest') );
        $wgOut->setRobotpolicy( 'noindex,nofollow' );
        $wgOut->setArticleRelated( false );

		$good = 0;
		$bad = 0;	        
		foreach( range(0, 10000) as $id ) {
			$value = $wgMemc->get( "messaging:default_messages:v2:touched" );
			if ( is_null( $value ) ) {
				$bad++;
			}
			else {
				$good++;
			}
		}
		$wgOut->addHTML( "Null: {$bad} Full {$good}");
	}
}
