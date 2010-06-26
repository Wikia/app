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

		if ($wgRequest->wasPosted()) {
			if( ($wgUser->getId() != 0) && ($wgRequest->getVal( "show_followed", 0) == 1) ) {
				$wgUser->setOption( "hidefollowedpages", false ); 
				$wgUser->saveSettings();
			}	
		}
							
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/Follow/css/special.css?{$wgStyleVersion}");
		$wgOut->addScript("<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/Follow/js/ajax.js?{$wgStyleVersion}\"></script>\n");

		$wgOut->setPageTitle( wfMsg( 'wikiafollowedpages-special-title' ) );
	
		if (  $wgUser->getId() == 0 ) {
			$wgOut->addHTML( wfMsgExt('wikiafollowedpages-special-anon', array('parse')) );
			return true;
		}
		
		$user = $wgUser;
		$is_hide = false;
		if ( $user->getOption('hidefollowedpages') ) {
			$is_hide = true;
			if( $user->getId() != $wgUser->getId() ) {
				$wgOut->addHTML( wfMsgExt( 'wikiafollowedpages-special-hidden', array( 'parse' ), $user->getName ) );
				return true;
			}
		}

		$data = FollowModel::getWatchList( $user->getId() ); 

		if ( ( empty($data) ) || ( $user->getId() == 0) ) {
			$wgOut->addHTML( wfMsgExt('wikiafollowedpages-special-empty', array('parse')) );
			return true;
		}

		$this->setHeaders();
		
		$template = new EasyTemplate( dirname( __FILE__ ) . '/templates/' );
		$template->set_vars(
			array (
				"data" 	=> FollowModel::getWatchList( $user->getId() ),
				"owner" => $wgUser->getId() == $user->getId(),
				"user_id" =>  $user->getId(),
				"is_hide" => $is_hide,
				"show_link" => $wgTitle->getFullUrl(),
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
