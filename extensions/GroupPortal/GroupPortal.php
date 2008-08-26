<?php

$wgExtensionCredits['other'][] = array(
    'name'    => "GroupPortal",
	'version' => '1.0',
	'author'  => 'Tim Laqua',
	'url'     => 'http://www.mediawiki.org/wiki/Extension:GroupPortal'
);

$wgHooks['ArticlePageDataBefore'][] = 'efGroupPortal_ArticlePageDataBefore';

function efGroupPortal_ArticlePageDataBefore ( &$article, &$fields ) {
	$mainTitle = Title::newMainPage();
	$title = $article->getTitle();
	
	global $wgRequest;
	$action    = $wgRequest->getVal( 'action'    );
	$redirect  = $wgRequest->getVal( 'redirect'  );	
	
	if ( (empty( $action ) || $action == 'view') && !isset( $redirect ) ) {
		if ( $title->getFullText() == $mainTitle->getFullText() ) {
			$groupPortalText = wfMsgForContentNoTrans('groupportal');
			
			$groupPortals = spliti("\n", $groupPortalText);
			
			global $wgUser;
			$groups = $wgUser->getGroups();
			
			$targetPortal = '';
			foreach ($groupPortals as $groupPortal) {
				$mcount = preg_match('/^(.+)\|(.+)$/', $groupPortal, $matches);
				
				if ( $mcount > 0 ) {
					if ( in_array($matches[1], $groups ) || 
						 ( $matches[1] == '*' && empty( $targetPortal ) ) ) {
						$targetPortal = $matches[2];
					}
				}
			}
			
			if ( !empty( $targetPortal ) ) {
				$target = Title::newFromText($targetPortal);
				
				if( is_object( $target ) ) {
					global $wgOut;
					$wgOut->redirect( $target->getLocalURL() );
				}
			}
		}
	}
	return true;
}