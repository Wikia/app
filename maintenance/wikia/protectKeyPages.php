<?php
/**
 * @addto maintenance
 * @author Lucas 'TOR' Garczewski <tor@wikia-inc.com>
 */
$optionsWithArgs = array( 'u' );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

$userName = isset( $options['u'] ) ? $options['u'] : 'CreateWiki script';

$wgUser = User::newFromName( $userName );
if ( !$wgUser ) {
				print "Invalid username\n";
				exit( 1 );
}
if ( $wgUser->isAnon() ) {
				$wgUser->addToDatabase();
}

if (empty($wgWikiaKeyPages)) $wgWikiaKeyPages = array ( 'Image:Wiki.png', 'Image:Wiki_wide.png', 'Image:Favicon.ico' );

#--- define restriction level and duration
$restrictions['edit'] = 'sysop';
$restrictions['move'] = 'sysop';
$titleRestrictions = 'sysop';
$expiry = Block::infinity();

#--- define reason msg and fetch it
$wgMessageCache->addMessages( array ('createwiki-protect-reason' => 'Part of the official interface') );
$reason = wfMsgForContent('createwiki-protect-reason');

$wgUser->addGroup( 'staff' );
$wgUser->addGroup( 'bot' );

foreach ($wgWikiaKeyPages as $pageName) {
	$title = Title::newFromText( $pageName );
	$article = new Article( $title );

	if ( $article->exists() ) {
		$ok = $article->updateRestrictions( $restrictions, $reason, 0, $expiry );
	} else {
		$ok = $title->updateTitleProtection( $titleRestrictions, $reason, $expiry );
	}

	if ($ok) {
		print "Protected key page: $pageName\n";
        } else {
		print "Failed while trying to protect $pageName\n";
	}
}

$wgUser->removeGroup( 'staff' );
$wgUser->removeGroup( 'bot' );
print "Done protecting pages.\n";
