<?php
/*
Creates a link in the toolbox to a special page showing who watches that page

Usage:
Add
	include_once ( "extensions/Watchers/Watchers.php" ) ;
to your LocalSettings.php. It should be (one of) the first extension(s) to include, as it adds to the toolbox in the sidebar.
Otherextensions might add a new box there, putting the "Watchers" link in the wrong box.

After inclusion in LocalSettings.php, you can set $wgWatchersLimit
to a number to anonymize results ("X or more" / "Fewer than X" people watching this page)
*/


if( !defined( 'MEDIAWIKI' ) ) die();

# Integrating into the MediaWiki environment

$wgExtensionCredits['Watchers'][] = array(
        'name' => 'Watchers',
        'description' => 'An extension to show who is watching a page.',
        'author' => 'Magnus Manske'
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Watchers'] = $dir . 'Watchers.i18n.php';

$wgExtensionFunctions[] = 'wfWatchersExtension';


# Hooks
$wgHooks['MonoBookTemplateToolboxEnd'][] = 'wfWatchersExtensionAfterToolbox';

# Global variables

$wgWatchersLimit = NULL ; # Set this to a number to anonymize results ("X or more" / "Less that X" people watching this page)
$wgWatchersAddCache = false ; # Internal use


/**
 * Text adding function
*/
function wfWatchersAddCache() { # Checked for HTML and MySQL insertion attacks
	global $wgWatchersAddCache , $wgUserTogglesEn, $wgDefaultUserOptions;
	if( $wgWatchersAddCache ) {
		return;
	}
	wfLoadExtensionMessages( 'Watchers' );
	$wgWatchersAddCache = true;
}

/**
 * Display link in toolbox
*/
function wfWatchersExtensionAfterToolbox( &$tpl ) { # Checked for HTML and MySQL insertion attacks
	global $wgTitle;
	if( $wgTitle->isTalkPage() ) {
		# No talk pages please
		return true;
	}
	if( $wgTitle->getNamespace() < 0 ) {
		# No special pages please
		return true;
	}

	wfWatchersAddCache();


	echo '<li id="t-watchers"><a href="' ;
	$nt = Title::newFromText ( 'watchers' , NS_SPECIAL ) ;
	echo $nt->escapeLocalURL ( 'article=' . $wgTitle->getArticleID() );
	echo '">' ;
	echo wfMsg('watchers_link_title');
	echo "</a></li>\n" ;

	return true;
}

/**
 * The special page
*/
function wfWatchersExtension() {
	global $IP, $wgMessageCache;
	wfWatchersAddCache();

	require_once $IP.'/includes/SpecialPage.php';

	class SpecialWatchers extends SpecialPage {

		/**
		 * Constructor
		*/
		function SpecialWatchers() {
			SpecialPage::SpecialPage( 'Watchers' );
			$this->includable( true );
		}

		/**
		 * @see SpecialPage::getDescription
		 */
		function getDescription() {
			return wfMsg( 'watchers' );
		}

		/**
		 * Renders the special page
		*/
		function execute( $par = null ) {
			global $wgOut , $wgRequest , $wgUser , $wgWatchersLimit ;

			$out = "" ;
			$fname = "wfWatchersExtension::execute" ;
			$sk =& $wgUser->getSkin() ;
			$id = $wgRequest->getInt ( 'article' , 0 ) ;
			$title = Title::newFromID ( $id ) ;

			# Check for valid title
			if ( $id == 0 || $title->getArticleID() <= 0 ) {
				$out = wfMsg ( 'watchers_error_article' ) ;
				$this->setHeaders();
				$wgOut->addHtml( $out );
				return ;
			}

			$link1 = $sk->makeLinkObj( $title );
			$out .= "<h2>" . wfMsg ( 'watchers_header' , $link1 ) . "</h2>" ;

			$dbr =& wfGetDB( DB_SLAVE );
			$conds = array (
				'wl_namespace' => $title->getNamespace() ,
				'wl_title' => $title->getDBkey() ,
			) ;
			if ( $wgWatchersLimit != NULL ) {
				$res = $dbr->select(
						/* FROM   */ 'watchlist',
						/* SELECT */ 'count(wl_user) AS num',
						/* WHERE  */ $conds,
						$fname
				);
				$o = $dbr->fetchObject( $res ) ;
				if ( $o->num >= $wgWatchersLimit ) {
					$out .= "<p>" . wfMsg ( 'watchers_x_or_more' , $wgWatchersLimit ) . "</p>\n" ;
				} else {
					$out .= "<p>" . wfMsg ( 'watchers_less_than_x' , $wgWatchersLimit ) . "</p>\n" ;
				}
			} else {
				$res = $dbr->select(
						/* FROM   */ 'watchlist',
						/* SELECT */ 'wl_user',
						/* WHERE  */ $conds,
						$fname
				);
				$user_ids = array () ;
				while ( $o = $dbr->fetchObject( $res ) ) {
					$user_ids[] = $o->wl_user ;
				}
				$dbr->freeResult( $res );

				if ( count ( $user_ids ) == 0 ) {
					$out .= "<p>" . wfMsg ( 'watchers_noone_watches' ) . "</p>" ;
				} else {
					$out .= "<ol>" ;
					foreach ( $user_ids AS $uid ) {
						$u = new User ;
						$u->setID ( $uid ) ;
						$u->loadFromDatabase() ;
						$link = $sk->makeLinkObj ( $u->getUserPage() ) ;
						$out .= "<li>" . $link . "</li>\n" ;
					}
					$out .= "</ol>" ;
				}
			}

			$this->setHeaders();
			$wgOut->addHtml( $out );
		}


	} # end of class

	SpecialPage::addPage( new SpecialWatchers );
}
