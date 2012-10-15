<?php

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name'    => "GroupPortal",
	'version' => '1.0',
	'author'  => 'Tim Laqua',
	'url'     => 'https://www.mediawiki.org/wiki/Extension:GroupPortal'
);

$wgHooks['MediaWikiPerformAction'][] = 'efGroupPortal_MediaWikiPerformAction';

function efGroupPortal_MediaWikiPerformAction( $output, $article, $title, $user, $request ) {
	$action    = $request->getVal( 'action', 'view' );
	$redirect  = $request->getVal( 'redirect' );

	if ( $action === 'view' && $redirect === null ) {
		if ( $title->equals( Title::newMainPage() ) ) {
			$groupPortals = spliti( "\n", wfMsgForContentNoTrans( 'groupportal' ) );

			$groups = $user->getGroups();

			$targetPortal = '';
			foreach ( $groupPortals as $groupPortal ) {
				$mcount = preg_match( '/^(.+)\|(.+)$/', $groupPortal, $matches );

				if ( $mcount > 0 ) {
					if ( in_array($matches[1], $groups ) ||
						 ( $matches[1] == '*' && empty( $targetPortal ) ) ) {
						$targetPortal = $matches[2];
					}
				}
			}

			if ( !empty( $targetPortal ) ) {
				$target = Title::newFromText( $targetPortal );

				if( is_object( $target ) ) {
					$output->redirect( $target->getLocalURL() );
					return false;
				}
			}
		}
	}
	return true;
}
