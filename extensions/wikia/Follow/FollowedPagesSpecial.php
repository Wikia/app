<?php
/*
 * Author: Tomek Odrobny
 * Special page class 
 */

class FollowedPages extends SpecialPage {
	var $mAction;

	function __construct() {
		global $wgRequest;
		parent::__construct( 'Following', '', true);
		$this->mAction = $wgRequest->getVal( 'action' );
		wfLoadExtensionMessages( 'Follow' );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser,$wgTitle, $wgExtensionsPath, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion;
							
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/Follow/css/special.css?{$wgStyleVersion}");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/Follow/js/ajax.js?{$wgStyleVersion}\"></script>\n");

		$wgOut->setPageTitle( wfMsg( 'wikiafollowedpages-special-title' ) );

		$reqTitle = $wgRequest->getText('title', false);

		list ( , $userspace ) = explode( '/', $reqTitle, 2 );

		if (strlen($userspace) == 0 ){
			if ( $wgUser->getId() == 0) {
				$wgOut->addHTML( wfMsg('wikiafollowedpages-special-anon') );
				return true;				
			}
			$user = $wgUser;
		} else {
			$user = User::newFromName( $userspace );	
		}
		
		if ( empty($user) ) {
			$wgOut->addHTML( wfMsg('wikiafollowedpages-special-empty') );
			return true;
		}
		
		if( $user->getId() != $wgUser->getId() ) {
			if ( $user->getOption('hidefollowedpages') ) {
				$wgOut->addHTML( wfMsg('wikiafollowedpages-special-hidden') );
				return true;				
			}	
		}
		
		$data = FollowModel::getWatchList( $user->getId() ); 
		
		if ( ( empty($data) ) || ( $user->getId() == 0) ) {
			$wgOut->addHTML( wfMsg('wikiafollowedpages-special-empty') );
			return true;
		}
		
		$this->setHeaders();
		
		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$template->set_vars(
			array (
				"data" 	=> FollowModel::getWatchList( $user->getId() ),
				"owner" => $wgUser->getId() == $user->getId(),
				"user_id" =>  $user->getId()
			)
		);
				
		$text = $template->render( "followedPages" );
		$wgOut->addHTML( $text );
		return true; 
	}
	
	function getDescription() {
		return  wfMsg( 'wikiafollowedpages-special-title' ) ;
	}
}
