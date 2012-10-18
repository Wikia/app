<?php

class SpecialMyblog extends RedirectSpecialPage {

var $mAllowedRedirectParams = array();
        
	function __construct() {
                parent::__construct( 'Myblog' );
                $this->mAllowedRedirectParams = array( 'action' , 'preload' , 'editintro', 'section' );
        }

        function getRedirect( $subpage ) {
                global $wgUser;
                if ( strval( $subpage ) !== '' ) {
                        return Title::makeTitle( NS_BLOG_ARTICLE, $wgUser->getName() . '/' . $subpage );
                } else {
                        return Title::makeTitle( NS_BLOG_ARTICLE, $wgUser->getName() );
                }
        } // end function getRedirect
     } // end class
