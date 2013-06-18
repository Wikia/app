<?php

class SpecialMyblog extends RedirectSpecialPage {

	var $mAllowedRedirectParams = array();

	function __construct() {
			parent::__construct( 'Myblog' );
			$this->mAllowedRedirectParams = array( 'action' , 'preload' , 'editintro', 'section' );
	}

	function getRedirect( $subpage ) {
		$username = $this->getUser()->getName();
			if ( strval( $subpage ) !== '' ) {
					return Title::makeTitle( NS_BLOG_ARTICLE, $username . '/' . $subpage );
			} else {
					return Title::makeTitle( NS_BLOG_ARTICLE, $username );
			}
	}
}
