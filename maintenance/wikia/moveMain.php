<?php
/**
 * @addto maintenance
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia.com>
 * @author Adrian Wieczorek (ADi) <adi@wikia.com>
 */
$optionsWithArgs = array( 's', 't', 'u' );

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

/**
if ( count( $args ) == 0 || isset( $options['help'] ) ) {
	print <<<EOT
Move article to new name and set MediaWiki:Mainpage article.

Usage: php moveMain.php [options...] -s <source title> -t <target title>

Options:
  -u <user>         Username
  -s <title>        Source title, if not set 'Main Page' is used
  -t <title>        Target title, if not set wgSitename is used

If the specified user does not exist, it will be created.

EOT;
	exit( 1 );
}
**/

$userName = isset( $options['u'] ) ? $options['u'] : 'Maintenance script';
$source = isset( $options['s'] ) ? $options['s'] : wfMsgForContent('Mainpage');
$target = isset( $options['t'] ) ? $options['t'] : $wgSitename;

$wgUser = User::newFromName( $userName );
if ( !$wgUser ) {
				print "Invalid username\n";
				exit( 1 );
}
if ( $wgUser->isAnon() ) {
				$wgUser->addToDatabase();
}

/**
 * first check if source title is valid and article exists
 * MediaWiki:Mainpage exist
 */
$sourceTitle = Title::newFromText( $source );
if( !$sourceTitle ) {
    print "Invalid page title: $source";
    exit(1);
}
$mainPageArticle = new Article( $sourceTitle, 0 );
if( !$mainPageArticle->exists() ) {
    print "Article $source not exists.";
    exit(1);
}

if( !is_null( $sourceTitle ) ) {
    /**
     * check target title
     */
    $targetTitle = Title::newFromText( $target );
    if( !is_null( $targetTitle ) ) {
        if( $sourceTitle->getPrefixedText() !== $targetTitle->getPrefixedText() ) {
            print $sourceTitle->getPrefixedText() . ' --> ' . $targetTitle->getPrefixedText();
            $err = $sourceTitle->moveTo( $targetTitle, false, "SEO" );
            if( $err !== true ) {
                print " - Moving FAILED: $err\n";
            }
            else {
                /**
                 * fill Mediawiki:Mainpage with new title
                 */
                $mwMainPageTitle = Title::newFromText( "Mainpage", NS_MEDIAWIKI );
                $mwMainPageArticle = new Article( $mwMainPageTitle, 0 );

                $mwMainPageArticle->doEdit( $targetTitle->getText(), "SEO", EDIT_MINOR | EDIT_FORCE_BOT );
                print " - Page moved.\n";
            }
        }
        else {
            print "source {$source} and target {$target} are the same\n";
        }
    }
}
else {
				print "sourceTitle is null.\n";
				exit(1);
}
