<?php

# edit a batch of pages

# this is a modified version, specially for MultiWikiEdit extension and task
# bartek@wikia.com

# Usage: php editOn.php [-u <user>] [-t <title>] [-x <text>] [-s <summary>] [-m <minor>] [-b <bot>] [-a <autoSummary>] [-no-rc <no-rc>] -add <listfile>
# where
#       <listfile> is a file where each line contains the title of a page to be deleted.
#       <user> is the username
#       <title> is what we want to edit
#       <text> is the new text for this article
#       <summary> summary for this edit
#       <minor> is for a minor edit
#       <bot> for a bot (hidden) edit
#       <autoSummary>  for autosummary
#       <no-rc> do not show in recent changes
#       <add> do not overwrite article, just add to existing text
#       <namespace> is the number of namespace

ini_set( "include_path", dirname(__FILE__)."/.." );
$optionsWithArgs = array( 'u', 't', 'x', 's', 'n' );

require_once( 'commandLine.inc' );

$userName = isset( $options['u'] ) ? $options['u'] : 'Maintenance script';
$summary = isset( $options['s'] ) ? $options['s'] : '';
$minor = isset( $options['m'] );
$bot = isset( $options['b'] );
$autoSummary = isset( $options['a'] );
$noRC = isset( $options['no-rc'] );
$add = isset( $options['add']);

$wgUser = User::newFromName( $userName );
if ( !$wgUser ) {
	print "Invalid username\n";
	exit( 1 );
}
if ( $wgUser->isAnon() ) {
	$wgUser->addToDatabase();
}

$wgTitle = Title::newFromText( $options['t'], intval($options['n']) );
if ( !$wgTitle ) {
	print "Invalid title\n";
	exit( 1 );
}

print $wgTitle->getPrefixedText () ;

$wgArticle = new Article( $wgTitle );

# Read the text
$text = $options ['x'] ;

if ( !empty( $add )) {
    if ( $wgArticle->getID() ) {
        #--- read current body of article
        $text = $wgArticle->getContent() . "\n" . $text;
    }
}
# Do the edit
$success = $wgArticle->doEdit( $text, $summary,
	( $minor ? EDIT_MINOR : 0 ) |
	( $bot ? EDIT_FORCE_BOT : 0 ) |
	( $autoSummary ? EDIT_AUTOSUMMARY : 0 ) |
	( $noRC ? EDIT_SUPPRESS_RC : 0 ) );
if ( $success ) {
	print "\n";
} else {
	print "FAILED\n";
}
?>
