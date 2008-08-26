<?php
/**
* Run the SQL on your database prior to use!

* Some global variables:
$wgStableVersionThereCanOnlyBeOne // Set this to true is you want to have only a single stable version per article
*/




# ATTENTION BRION!
# wfStableVersionCanChange() always returns true for testing
# The "Older/newer revision" mess does not seem to be related to this extension




if( !defined( 'MEDIAWIKI' ) ) die();

/**@+ Version type constants */
define( 'SV_TYPE_UNDEFINED',  0 );
define( 'SV_TYPE_STABLE',     1 );
define( 'SV_TYPE_STABLE_CANDIDATE', 2 );
/**@-*/

# Global variables to configure StableVersion
$wgStableVersionThereCanOnlyBeOne = true;

# Evil variables, needed internally
$wgStableVersionCaching = false;

# Every user can mark stable versions (default)
# To change this, add this line to localsettings.php and modify
$wgGroupPermissions['user']['stableversion'] = true;

$wgExtensionCredits['StableVersion'][] = array(
        'name' => 'Stable version',
        'description' => 'An extension to allow the marking of a stable version.',
        'author' => 'Magnus Manske'
);

$wgAvailableRights[] = 'stableversion';
$wgExtensionFunctions[] = 'wfStableVersion';
$wgHooks['ArticleViewHeader'][] = 'wfStableVersionHeaderHook';
$wgHooks['ArticlePageDataBefore'][] = 'wfStableVersionArticlePageDataBeforeHook';
$wgHooks['ArticlePageDataAfter'][] = 'wfStableVersionArticlePageDataAfterHook';
$wgHooks['ParserBeforeInternalParse'][] = 'wfStableVersionParseBeforeInternalParseHook';
$wgHooks['ArticleAfterFetchContent'][] = 'wfStableVersionArticleAfterFetchContentHook';
$wgHooks['DisplayOldSubtitle'][] = 'wfStableVersionDisplaySubtitleHook';

# BEGIN logging functions
$wgHooks['LogPageValidTypes'][] = 'wfStableVersionAddLogType';
$wgHooks['LogPageLogName'][] = 'wfStableVersionAddLogName';
$wgHooks['LogPageLogHeader'][] = 'wfStableVersionAddLogHeader';
$wgHooks['LogPageActionText'][] = 'wfStableVersionAddActionText';

function wfStableVersionAddLogType( &$types ) {
	if( !in_array( 'stablevers', $types ) ) {
		$types[] = 'stablevers';
	}
	return true;
}

function wfStableVersionAddLogName( &$names ) {
	$names['stablevers'] = 'stableversion_logpage';
	return true;
}

function wfStableVersionAddLogHeader( &$headers ) {
	$headers['stablevers'] = 'stableversion_logpagetext';
	return true;
}

function wfStableVersionAddActionText( &$actions ) {
	$actions['stablevers/stablevers'] = 'stableversion_logentry';
	return true;
}
# END logging functions


# Text adding function
function wfStableVersionAddCache() {
	global $wgMessageCache, $wgStableVersionAddCache;
	if( $wgStableVersionAddCache ) {
		return;
	}
	$wgStableVersionAddCache = true;
	
	// Default language is english
	require_once( 'language/en.php' );

	global $wgLang;
	$filename = 'language/' . addslashes( $wgLang->getCode() ) . '.php';
	// inclusion might fail :p
	if( file_exists($filename) ) 
		include( $filename );
}

/**
 * Adds query for stable version (OBSOLETE?)
 * @param $article (not used)
 * @param $fields Fields for query
 */
function wfStableVersionDisplaySubtitleHook( &$article, &$oldid ) {
	global $wgStableVersionRedirectAnon;
	global $wgUser;
	global $wgRequest;

	if ( $wgStableVersionRedirectAnon && $wgUser->isAnon() ) {
		return false;
	} else if ( $oldid == $article->mLastStable && !$wgRequest->getCheck('direction') ) {
		return false;
	} else {
		return true;
	}
}

/**
 * Adds query for stable version (OBSOLETE?)
 * @param $article (not used)
 * @param $fields Fields for query
 */
function wfStableVersionArticlePageDataBeforeHook( &$article, &$fields ) {
	return true;
}

/**
 * Hook function to be run right after article data was read
 * @param $article The article
 * @param $fields Query result object
 */
function wfStableVersionArticlePageDataAfterHook( &$article, &$fields ) {
	global $wgRequest;
	
	$fname = "wfStableVersionArticlePageDataAfterHook";
	
	# No stable versions of a non-existing article
	if( !$article->exists() ) {
		return true;
	}

	wfProfileIn( $fname );

	# Trying to figure out the revision number
	$rev = $wgRequest->getInt( 'oldid', $fields->page_latest );
	
	# Run the query
	wfStableVersionSetArticleVersionStatusAndCache( $article, $rev );
	
	wfProfileOut( $fname );
	return true;
	}

/**
 * Adds new variables "mStable" and "mStableCache" to the article
 * @param $article The article
 * @param $rev The revision number
*/ 
function wfStableVersionSetArticleVersionStatusAndCache( &$article, $rev ) {
	$fname = "wfStableVersionSetArticleVersionStatusAndCache";
	wfProfileIn( $fname );
	
	$dbr =& wfGetDB( DB_SLAVE );
	$res = $dbr->select(
			/* FROM   */ 'stableversions',
			/* SELECT */ '*',
			/* WHERE  */ array( 'sv_page_id' => $article->getID() ),
			$fname,
			array( "ORDER BY" => "sv_page_rev DESC" )
	);

	
	$article->mIsStable = false;
	$article->mLastStable = 0;
	while( $o = $dbr->fetchObject( $res ) ) {
		if( $o->sv_type == SV_TYPE_STABLE ) {
			if( $o->sv_page_rev == $rev ) {
				# This is a stable version, set mark and get cache
				$article->mIsStable = true;
				$article->mStableCache = $o->sv_cache;
			}
			if( $article->mLastStable == 0 ) {
				# The latest stable version
				$article->mLastStable = $o->sv_page_rev;
			}
		}
	}
	$dbr->freeResult( $res );
	wfProfileOut( $fname );
}

/**
 * Decides wether a user can set the stable version
 * @return bool (always TRUE by default, for testing)
 */
function wfStableVersionCanChange() {
	//return true; # Dummy, everyone can set stable versions
	global $wgUser, $wgOut;
	if( !$wgUser->isAllowed( 'stableversion' ) ) {
		$wgOut->permissionRequired( 'stableversion' );
		$wgOut->setSubtitle( wfMsg('stableversion') );
		return false;
	}
	return true;
}

/**
 * Generates the little header line
 * @param $article The article
 */
function wfStableVersionHeaderHook( &$article ) {
	global $wgOut, $wgTitle, $wgUser;
	global $wgStableVersionRedirectAnon, $wgStableVersionShowDefaultToAnon;
	global $wgRequest;

	wfStableVersionAddCache();
	$st = ""; # Subtitle
	
	# Gah...these hooks are not consistant
	# Load if not loaded to avoid errors - Aaron
	if ( !isset($article->mIsStable) ) 
		wfStableVersionSetArticleVersionStatusAndCache( $article, $article->getRevIdFetched() );
	
	if( $article->mIsStable ) {
		# This is the stable version
		if( $article->mLatest == $article->mLastStable ) {
			$st .= wfMsg( 'stableversion_this_is_stable_and_current' );
		} else {
			if ( $wgStableVersionRedirectAnon && $wgUser->isAnon() ) {
				if ( $wgStableVersionShowDefaultToAnon ) {
					# We allow the users to see drafts
					$url = $wgTitle->getLocalURL( "showdraft=1" );
					$st .= wfMsg( 'stableversion_this_is_stable', $url );
				} else {
					# We do not allow the users to see drafts
					$st .= wfMsg( 'stableversion_this_is_stable_nourl' );
				}
			} else {
				$url = $wgTitle->getLocalURL();
				$st .= wfMsg( 'stableversion_this_is_stable', $url );
			}
		}
	} elseif( $article->mLastStable == "0" ) {
		# There is no spoon, er, stable version
		$st = wfMsg( 'stableversion_this_is_draft_no_stable' );
	} else {
		# This is not the stable version, recommend it
		$url = $wgTitle->getLocalURL( "oldid=" . $article->mLastStable );
		$url2 = $wgTitle->getLocalURL();
		$showdraft = $wgRequest->getInt( 'showdraft' );
		if ( $article->mOldId ) {
			if ( $wgStableVersionRedirectAnon && $wgUser->isAnon() ) {
				# Users can only look at draft and stable
				$wgOut->redirect($url);
			} else {
				$st = wfMsg( 'stableversion_this_is_old', $url, $url2 );
			}
		} else {
			if ( $wgStableVersionRedirectAnon && $wgUser->isAnon() ) {
				if ( !($showdraft == 1 && $wgStableVersionShowDefaultToAnon) ) {
					$wgOut->redirect($url);
				} else {
					$st = wfMsg( 'stableversion_this_is_draft', $url );
				}
			} else {
				$st = wfMsg( 'stableversion_this_is_draft', $url );
			}
		}

	}
	
	if( wfStableVersionCanChange() && !$wgRequest->getCheck('direction') ) {
		# This user may alter the stable version info
		$st .= " ";
		$sp = Title::newFromText( "Special:StableVersion" );
		if( $article->getRevIdFetched() == $article->mLastStable ) {
			# This is the stable version - reset?
			$url = $sp->getLocalURL( "id=" . $article->getID() . "&mode=reset&revision=" . $article->getRevIdFetched() . "&oldid=" . $article->getOldID() );
			$st .= wfMsg( 'stableversion_reset_stable_version', $url );
		} else {
			$url = $sp->getLocalURL( "id=" . $article->getID() . "&mode=set&revision=" . $article->getRevIdFetched() . "&oldid=" . $article->getOldID());
			$st .= wfMsg( 'stableversion_set_stable_version', $url );
		}
	} else {
		$st .= " ";
		$st .= wfMsg( 'stableversion_noset_directional' );
	}

	$st = $wgOut->getSubtitle() . "<div id='stable_version_header'>" . $st . "</div>";
	$wgOut->setSubtitle( $st );
	return true;
}


/**
 * This is a parser hook that will terminate the parsing process after stripping
 */
function wfStableVersionParseBeforeInternalParseHook( &$parser, &$text, &$x ) {
	global $wgStableVersionTempText, $wgStableVersionTempX, $wgStableVersionCaching;
	if( !$wgStableVersionCaching ) {
		# Normal parsing, no caching
		return true;
	}
	# Stop the parsing process
	return false;
}

/**
 */
function wfStableVersionArticleAfterFetchContentHook( &$article, &$content ) {
	if( !isset( $article->mIsStable ) ) {
		return true;
	}
	if( !isset( $article->mStableCache ) ) {
		return true;
	}
	if( !$article->mIsStable ) {
		return true;
	}
	
	# This is a stable version and has a cache, so use that
	$content = $article->mStableCache;
	return true;
}



# The special page
function wfStableVersion() {
	global $IP, $wgMessageCache;
	wfStableVersionAddCache();

	$wgMessageCache->addMessage( 'stableversion', 'Stable Version' );

	require_once( "$IP/includes/SpecialPage.php" );

	class SpecialStableVersion extends SpecialPage {
		/**
		 * Constructor
		 */
		function SpecialStableVersion() {
			SpecialPage::SpecialPage( 'StableVersion' );
			$this->includable( true );
		}
		
		
		function fixNoWiki( &$state ) {
			if ( is_object( $state ) ) {
				# MW 1.9 version
				$array = $state->nowiki->getArray();
			} elseif ( is_array( $state ) ) {
				$array = $state['nowiki'];
			} else {
				return;
			}
			
			# Surround nowiki content with <nowiki> again
			for( $content = end( $array ); $content !== false; $content = prev( $array ) ) {
				$key = key( $array );
				$array[$key] = "<nowiki>" . $content . "</nowiki>";
			}

			if ( is_object( $state ) ) {
				$state->nowiki->setArray( $array );
			} else {
				$state['nowiki'] = $array;
			}
		}

		/**
		 */
		function getCacheText( &$article ) {
			global $wgStableVersionCaching, $wgUser;
			$title = $article->getTitle();
			$article->loadContent( true ); # FIXME: Do we need the "true" here? For what? Safe redirects??
			$text = $article->mContent;
			
			$p = new Parser();
			$p->disableCache();
			$wgStableVersionCaching = true;
			$parserOptions = ParserOptions::newFromUser( $wgUser ); # Dummy

			$text = $p->parse( $text, $title, $parserOptions );
			// Forward compatibility for parser object output (bug 9393)
			$text = is_object($text) ? $text->mText : $text;
			
			$stripState = $p->mStripState;
			$wgStableVersionCaching = false;
			$text = $p->replaceVariables( $text, $parserOptions );
		
			$this->fixNoWiki( $stripState );
			$p->mStripState = $stripState;
			$text = $p->unstrip( $text, $p->mStripState );
			$text = $p->unstripNoWiki( $text, $p->mStripState );
			
			return $text;
		}
	
		/**
		 * execute()
		 */
		function execute( $par = null ) {
			global $wgOut, $wgRequest, $wgArticle;
			$fname = "SpecialStableVersion::execute";
			
			# Sanity checks
			$mode = $wgRequest->getText( 'mode', "" );
			if( $mode != 'set' && $mode != 'reset' ) {
				# Should be error(wrong mode)
				return;
			}
			$id = $wgRequest->getInt( 'id', 0 );
			if( $id == "0" ) {
				# Should be error(wrong call)
				return;
			}
			if( !wfStableVersionCanChange() ) {
				# Should be error(not allowed)
				return;
			}

			# OK, now do business
			wfProfileIn( $fname );
			$t = Title::newFromID( $id );

			if( $mode == 'set' ) {
				# Set new version as stable
				$newstable = $wgRequest->getInt( 'revision', 0 );
				$clearstable = $newstable;
				$out = wfMsg( 'stableversion_set_ok' );
				$url = $t->getLocalURL( "oldid=" . $newstable );
				$act = wfMsg( 'stableversion_log', $newstable );
			} elseif( $mode == "reset" ) {
				# Reset stable version
				$newstable = "0";
				$clearstable = $wgRequest->getInt( 'revision', 0 );
				$out = wfMsg( 'stableversion_reset_ok' );
				$url = $t->getLocalURL();
				$act = wfMsg( 'stableversion_reset_log' );
			}
			
			$article = new Article( $t );

			# Old stable version
			$oldstable = isset( $wgArticle->mLastStable ) ? $wgArticle->mLastStable : 0;
			if( $oldstable == 0 ) {
				$before = wfMsg( 'stableversion_before_no' );
			} else {
				$before = wfMsg( 'stableversion_before_yes', $oldstable );
			}
			$act .= " " . $before;
			
			$type = SV_TYPE_STABLE; # FIXME: This should become something else once there are several "types"
			
			# Get template-replaced cache
			$cache = $this->getCacheText( $article );

			$this->updateDatabase( $id, $clearstable, $newstable, $type, $cache );

			$out = "<p>{$out}</p><p>" . wfMsg( 'stableversion_return', $url, $t->getFullText() ) . "</p>";
			$act = "[[" . $t->getText() . "]] : " . $act;

			# Logging
			$log = new LogPage( 'stablevers' );
			$log->addEntry( 'stablevers', $t, $act );

			$this->setHeaders();
			$wgOut->addHtml( $out );
			wfProfileOut( $fname );
		}


		/**
		 * This runs the database queries for execute()
		 * @param id Article ID
		 * @param clearstable Revision ID of the revision to be removed as stable
		 * @param newstable The revision to become a (the) new stable version
		 * @param type The stable revision type (not used so far)
		 * @param cache The revision text to cache
		 */
		function updateDatabase( $id, $clearstable, $newstable, $type, $cache ) {
			global $wgStableVersionThereCanOnlyBeOne, $wgUser;

			$fname = "SpecialStableVersion::updateDatabase";
			wfProfileIn( $fname );
			
			$dbw =& wfGetDB( DB_MASTER );
			$dbw->begin();
			
			# Delete this just in case it was already set
			$conditions = array( 'sv_page_id' => $id );
			if( !$wgStableVersionThereCanOnlyBeOne ) {
				$conditions['sv_page_rev'] = $clearstable;
			}
			$dbw->delete( 'stableversions', $conditions, $fname );
			
			$values = array(
				'sv_page_id'  => $id,
				'sv_page_rev' => $newstable,
				'sv_type'     => $type,
				'sv_user'     => $wgUser->getID(),
				'sv_date'     => wfTimestamp( TS_MW ) ,
				'sv_cache'    => $cache,
			);
			
			if( $newstable > 0 ) {
				$dbw->insert( 'stableversions',
					$values ,
					$fname );
			}
			$dbw->commit();
			wfProfileOut( $fname );
		}


	} # end of class

	SpecialPage::addPage( new SpecialStableVersion );
}



