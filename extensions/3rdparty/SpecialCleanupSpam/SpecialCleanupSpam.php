<?php

/*
	A special page providing means to clean up spam on this wiki, on selected wikis, or on all wikis
*/
if(!defined('MEDIAWIKI'))
   die();

$wgAvailableRights[] = 'cleanupspam';
$wgGroupPermissions['staff']['cleanupspam'] = true;

/* a central spam blacklist */
define ('CLEANUPSPAM_FILE', 'http://meta.wikimedia.org/w/index.php?title=Spam_blacklist&action=raw&sb_ver=1') ;

$wgExtensionFunctions[] = 'wfCleanupSpamSetup';
$wgExtensionCredits['specialpage'][] = array(
   'name' => 'Cleanup Spam',
   'author' => 'Bartek',
   'description' => 'cleans up spam from the articles - this is a special page version of a pre-existing script'
);

/* special page init */
function wfCleanupSpamSetup() {
	global $IP, $wgMessageCache;
	require_once($IP. '/includes/SpecialPage.php');
	require_once ("$IP/extensions/SilentArticle.php") ;

        /* add messages to all the translator people out there to play with */
        $wgMessageCache->addMessages(
        array(
                        'cleanupspam_button' => 'Clean up spam' ,
			'cleanupspam_help' => 'This special page provides means to revert back all pages containing a given url back to their non-contaminated states, or even blank them if no clean revisions exist. It allows a cleanup of this particular wiki, cleanup of all local wikis, or cleanup of all wikis in a shared database.' ,
			'cleanupspam_caption' => 'Containing ' ,
			'cleanupspam_file' => 'Against SpamBlacklist file' ,
			'cleanupspam_title' => 'Cleanup Spam' ,
			'cleanupspam_this' => 'this wiki' ,
			'cleanupspam_total' => 'Found $1 link(s) total.' ,
			'cleanupspam_local' => 'all local wikis' ,
			'cleanupspam_all' => 'all wikis from a shared database' ,
			'cleanupspam_on' => 'Clean up articles on' ,
			'cleanupspam_or' => '<b>OR</b>' ,
			'cleanupspam_action' => 'Choose action',
			'cleanupspam_success_title' => 'Cleanup Spam Succedeed' ,
			'cleanupspam_success_subtitle' => 'for $1' ,
			'cleanupspam_error_not_valid' => 'Not a valid hostname specification' ,
			'cleanupspam_both_modes' => 'Pick either mode: provide a link considered as spam or check whether to use Spam Blacklist.' ,
			'cleanupspam_error_empty' => 'Please specify a url to cleanup' ,
			'cleanupspam_count_zero' => 'There are no articles containing links to $1' ,
			'cleanupspam_cleanup_finished' => 'The cleanup process has finished.' ,
			'cleanupspam_processing' => 'cleaning up links to $1' ,
			'cleanupspam_link_back' => 'You can go back to the extension ' ,
			'cleanupspam_none_found' => 'No articles found containing links to $1.' ,
			'cleanupspam_no_local' => 'There are no local wikis here. Try other modes.' ,
			'cleanupspam_bad_regex' => 'Please specify more complete url'
                )
        );
	SpecialPage::addPage(new SpecialPage('Cleanupspam', 'cleanupspam', true, 'wfCleanupSpamSpecial', false));
	$wgMessageCache->addMessage('cleanupspam', 'Clean up spam');
}

/* the core */
function wfCleanupSpamSpecial( $par ) {
	global $wgOut, $wgUser, $wgRequest ;
   	$wgOut->setPageTitle (wfMsg('cleanupspam_title'));
	$cSF = new CleanupSpamForm ($par) ;

	$action = $wgRequest->getVal ('action') ;
	if ('success' == $action) {
		/* do something */
	} else if ( $wgRequest->wasPosted() && 'submit' == $action &&
	        $wgUser->matchEditToken( $wgRequest->getVal ('wpEditToken') ) ) {
	        $cSF->doSubmit () ;
	} else {
		$cSF->showForm ('') ;
	}
}

/* the form for blocking names and addresses */
class CleanupSpamForm {
	var $mMode, $mLink, $mDo, $mFile ;

	/* constructor */
	function CleanupSpamForm ( $par ) {
		global $wgRequest ;
		$this->mMode = $wgRequest->getVal( 'wpMode');
		$this->mLink = $wgRequest->getVal( 'wpLink');
		$this->mDo = $wgRequest->getVal( 'wpDo');
		$this->mList = $wgRequest->getInt( 'wpList');		
	}

	/* output */
	function showForm ( $err ) {
		global $wgOut, $wgUser, $wgRequest ;
	
		$token = htmlspecialchars( $wgUser->editToken() );
		$titleObj = Title::makeTitle( NS_SPECIAL, 'Cleanupspam' );
		$action = $titleObj->escapeLocalURL( "action=submit" ) ;

                if ( "" != $err ) {
                        $wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
                        $wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
                }
	
		$wgOut->addWikiText (wfMsg('cleanupspam_help')) ;

		( 'submit' == $wgRequest->getVal( 'action' )) ? $scLink = htmlspecialchars ($this->mLink) : $scLink = '' ;

   		$wgOut->addHtml("
<form name=\"CleanupSpam\" method=\"post\" action=\"{$action}\">
	<table border=\"0\">
		<tr>
			<td align=\"right\">".wfMsg('cleanupspam_on')." :</td>
			<td align=\"left\">") ;
		$this->makeSelect (
					'wpMode',
					array (
                 				'this wiki' => 'this'
						//'all wikis' => 'all'
					),
					$this->mMode,
					1
					) ;
		$wgOut->addHtml("</td>
		</tr>
		<tr>
			<td align=\"right\">".wfMsg('cleanupspam_action')." :</td>
			<td align=\"left\">") ;
		$this->makeSelect (
					'wpDo',
					array (
                 				'show only' => 'show',
						'revert if found' => 'revert',
					),
					$this->mMode,
					1
					) ;
		$wgOut->addHtml("</td>
		</tr>
		<tr>
			<td align=\"right\">".wfMsg('cleanupspam_caption')." :</td>
			<td align=\"left\">
				<input tabindex=\"3\" name=\"wpLink\" id=\"wpLink\" value=\"{$scLink}\" />
			</td>
		</tr>
		<tr>
			<td align=\"right\">".wfMsg('cleanupspam_or')."</td>
			<td align=\"left\">
				&#160;
			</td>
		</tr>

		<tr>
			<td align=\"right\">".wfMsg('cleanupspam_file')."</td>
			<td align=\"left\">
				<input tabindex=\"4\" type=\"checkbox\" name=\"wpList\" id=\"wpList\" value=\"1\" />
			</td>
		</tr>
		<tr>
			<td align=\"right\">&#160;</td>
			<td align=\"left\">
				<input tabindex=\"5\" name=\"wpCleanupSpamBlockedSubmit\" type=\"submit\" value=\"".wfMsg('cleanupspam_button')."\" />
			</td>
		</tr>
	</table>
	<input type='hidden' name='wpEditToken' value=\"{$token}\" />
</form>");
	}

        /* draws select and selects it properly */
        function makeSelect ($name, $options_array, $current, $tabindex) {
                global $wgOut ;
                $wgOut->addHTML ("<select tabindex=\"$tabindex\" name=\"$name\" id=\"$name\">") ;
                foreach ($options_array as $key => $value) {
                        if ($value == $current )
                                $wgOut->addHTML ("<option value=\"$value\" selected=\"selected\">$key</option>") ;
                        else
                                $wgOut->addHTML ("<option value=\"$value\">$key</option>") ;
                }
                $wgOut->addHTML ("</select>") ;
        }

        /* just output data */
	function writeupArticle ($id, $domain, $link_found) {
		global $wgOut, $wgUser ;
	        $title = Title::newFromID( $id );
        	if ( !$title ) {
	                return;
        	}
		$sk = $wgUser->getSkin () ;
		$page_link = $sk->makeKnownLinkObj ($title, $title->getText()) ;
		$wgOut->addHTML ("Article $page_link has link(s) containing <b>".$domain."</b>.<br/>" );
	}

	/* roughly based on what was in SpamBlacklist extension */
	function buildUpRegexes () {
		global $IP ;

		/* todo cache, anyone? could check for SpamBlacklist extension, and if enabled, get it from cache it creates */

		/* for each line in the spam blacklist, apply a regex */
		$lines = array () ;
		$lines = array_merge( $lines, explode ("\n", wfGetHTTP(CLEANUPSPAM_FILE) ) );

                /* omit comments and such */
		$lines = array_filter( array_map( 'trim', preg_replace( '/#.*$/', '', $lines ) ) );
		$regexStart = '/[a-z0-9_\-.]*(';			                	
        	$regexEnd = ')/Si';

		$regexes = array () ;		
                /* now, produce a massive regex */
		foreach ($lines as $line) {
                	$regexes[] = $regexStart.$line.$regexEnd ;	
		}
		return $regexes ;
	}

        /* clean up a single article */
	function cleanupArticle ($id, $domain, $link = "") {
		global $wgOut, $wgUser ;
		$username = wfMsg( 'spambot_username' );
		$fname = $username;
	        $title = Title::newFromID( $id );
        	if ( !$title ) {
	                return;
	        }
        	/* switch the user here */
		$OldUser = $wgUser ;
		$wgUser = User::newFromName( $username );	
		/* Create the user if necessary */
			if ( !$wgUser->getID() ) {
        			$wgUser->addToDatabase();
			}

	        $rev = Revision::newFromTitle( $title ) ;
        	$reverted = false ;
	        $revId = $rev->getId() ;
	        $currentRevId = $revId ;
		if ("" == $link) {		  
			$regex = $this->makeRegex ($domain);
			
		} else { /* we had a regex ready */
			$regex = $domain ;
			$domain = $link ;
		}
	        while ( $rev && preg_match( $regex, $rev->getText() ) ) {
        	        $revId = $title->getPreviousRevisionID( $revId );
	                if ( $revId ) {
        	                $rev = Revision::newFromTitle( $title, $revId );
	                } else {
        	                $rev = false ;
	                }
	        }
	        if ( $revId == $currentRevId ) { /* ... */
	        } else {
			$sk = $wgUser->getSkin () ;
			$page_link = $sk->makeKnownLinkObj ($title, $title->getText()) ;

	                $dbw =& wfGetDB( DB_MASTER );
        	        $dbw->immediateBegin();
	                if ( !$rev ) { /* no clean revision found, blank the article */
	                        $article = new SilentArticle( $title );
        	                $article->updateArticle( '', wfMsg( 'spam_blanking', $domain ), false, false );
				$wgOut->addHTML ("Article $page_link has been blanked.<br/>" );
	                } else { /* revert to last clean version  */
        	                $article = new SilentArticle( $title );
                	        $article->updateArticle( $rev->getText(), wfMsg( 'spam_reverting', $domain ), false, false );
				$wgOut->addHTML ("Article $page_link has been reverted to latest change not containing link to <b>".$domain."</b>.<br/>" );
        	        }
	                $dbw->immediateCommit();
        	        wfDoUpdates();
	        }
		$wgUser = $OldUser ;
}

        /* fetch all wikis from the database */
        function fetchWikias () {
        	global $wgMemc, $wgSharedDB ;
                /* from database */
                $dbr =& wfGetDB (DB_SLAVE);
                $query = "SELECT city_dbname, city_url, city_title FROM `{$wgSharedDB}`.city_list" ;
                $res = $dbr->query ($query) ;
                $wikias_array = array () ;
                while ($row = $dbr->fetchObject($res)) {
                	array_push ($wikias_array, $row ) ;
                }
                $dbr->freeResult ($res) ;
                return $wikias_array ;
        }


/* now that will be a massive strike */

/*	run ALL external links on possibly ALL wikis against this regex 
*/
function cleanUpRegex ($regexes) {
	global $wgOut, $wgUser ;

	$dbr =& wfGetDB( DB_SLAVE ) ;
	/* do it this way or just use MySQL REGEXP? */
	$res = $dbr->select( 'externallinks', array( 'DISTINCT el_to', 'el_from' ));
	$count = $dbr->numRows( $res );
	$spam_found = 0 ;

	if ($count) {
        	$wgOut->addWikiText (wfMsg('cleanupspam_total',$count)) ;
		while ( $row = $dbr->fetchObject( $res ) ) {
			foreach ($regexes as $regex) {
					/* 	you know, some of these regexes are corrupt...
						so it would be better to hide the warnings 
					 */
					if (@preg_match($regex, $row->el_to, $match)) {
						$wgOut->addWikiText  ("Link '''{$row->el_to}''' is spam.\n") ;

						if ('revert' == $this->mDo) {						
		 					$this->cleanupArticle ($row->el_from, $regex, $row->el_to) ;
						}
						$spam_found++ ;
				}			     
			}
		}
	} else {
        	$wgOut->addWikiText (wfMsg('cleanupspam_count_zero', "'''".$phrase."'''.")) ;
	}
	$wgOut->addWikiText ("'''$spam_found''' of them were spam.") ;
	$sk = $wgUser->getSkin () ;
	$titleObj = Title::makeTitle( NS_SPECIAL, 'Cleanupspam' );
	$link_back = $sk->makeKnownLinkObj ($titleObj, '<b>here</b>') ;
	$wgOut->addHtml ("<br/>".wfMsg('cleanupspam_link_back')." ".$link_back.".") ;
}

function makeRegex( $filterEntry ) {
	/* allow protocols other than http... */
	$regex = '!://' ;
	if ( substr( $filterEntry, 0, 2 ) == '*.' ) {
		$regex .= '([A-Za-z0-9.-]+\.|)';
		$filterEntry = substr( $filterEntry, 2 );
	}
	$regex .= preg_quote ($filterEntry, '!') . '!Si';
	return $regex;
}

/* as the name states clearly */
function cleanUp ($phrase, $database) {
	global $wgOut, $wgUser ;
	if ( !isset( $phrase ) || "" == $phrase) {
		$this->showForm (wfMsg('cleanupspam_error_empty')) ;
	        return ;
	}
	/* do a check whether something actually _is_ inside $wgLocalDatabases */
	if (!is_array($wgLocalDatabases) && ('local' == $this->mMode) ) {
		$this->showForm (wfMsg('cleanupspam_no_local')) ;
	        return ;
	}

	$like = LinkFilter::makeLike ($phrase) ;
	if ( !$like ) {
		$this->showForm (wfMsg('cleanupspam_error_not_valid').": ".$phrase) ;
	        return ;
	}
	$like = $phrase ;

	$dbr =& wfGetDB( DB_SLAVE );

	switch ($this->mMode) {
		case 'this':
			/* Clean up spam just on this wiki */		

		        $res = $dbr->select( 'externallinks', array( 'DISTINCT el_from' ),
        		        array( 'el_to LIKE ' . $dbr->addQuotes( "%//$phrase%" ) ), $fname );
		        $count = $dbr->numRows( $res );
			if ($count) {
        			$wgOut->addWikiText ("Found $count article(s) containing links to '''$phrase'''.\n") ;
			        while ( $row = $dbr->fetchObject( $res ) ) {
					if ('revert' == $this->mDo) {
						/* have eyes on this */
		        		        $this->cleanupArticle ($row->el_from, $phrase);
				        } else {
						/* just add more data and that should be fine */
		        		        $this->writeupArticle ($row->el_from, $phrase, $row->el_to) ;
					}
				}
		        } else {
        	        	$wgOut->addWikiText (wfMsg('cleanupspam_count_zero', "'''".$phrase."'''.")) ;
			}
			break ;

		case 'all':
			/* todo check for no wikis in city_list */
			$wikis = $this->fetchWikias() ;
			if (!is_array($wikis)) {
				return ;
			}			
			$wgOut->addWikiText( "Finding spam on all (" . count($wikis) . ") wikis.\n") ;


			foreach ($wikis as $db) {
       				$count = $dbr->selectField( "`".$db->city_dbname."`.externallinks", 'COUNT(*)',
                			array( 'el_to LIKE ' . $dbr->addQuotes( "%//$phrase%" ) ), $fname );
			        if ( $count ) {
        				$found = true;
					$this->cleanUp ($phrase, $db->city_dbname) ;
	        		}
			}
			if ('revert' == $this->mDo) {
				if ( $found ) {
        				$wgOut->addWikiText (wfMsg('cleanupspam_cleanup_finished')) ;
				} else {
        				$wgOut->addWikiText(wfMsg('cleanupspam_none_found', $phrase));
				}
			}
			break ;
	}
	if ('revert' == $this->mDo) {
		$wgOut->addWikiText (wfMsg('cleanupspam_cleanup_finished')) ;
	}
	$sk = $wgUser->getSkin () ;
	$titleObj = Title::makeTitle( NS_SPECIAL, 'Cleanupspam' );
	$link_back = $sk->makeKnownLinkObj ($titleObj, '<b>here</b>') ;
	$wgOut->addHtml ("<br/>".wfMsg('cleanupspam_link_back')." ".$link_back.".") ;
}

	/* on success */
	function showSuccess () {
		global $wgOut, $wgRequest ;
		$wgOut->setPageTitle (wfMsg('cleanupspam_success_title') ) ;
		$wgOut->setSubTitle(wfMsg('cleanupspam_success_subtitle')) ;	
	}


	/* on submit */
	function doSubmit () {
		global $wgOut, $wgUser, $wgRequest ;
		$wgOut->setSubTitle ( wfMsg ('cleanupspam_success_subtitle', wfMsg('cleanupspam_'.$this->mMode) ) ) ;
                /* both modes enabled, mhm? then something's obviously wrong */
		if ( ("1" == $this->mList) && ("" != $this->mLink) ) {
			$this->showForm (wfMsg ('cleanupspam_both_modes')) ;
			return ;
		}
		/* do not allow too simple urls - a single 'www' could wipe out all life on this wiki */
		if (!preg_match ('/[A-Za-z0-9.-]+\.[A-Za-z0-9.-]+/',$this->mLink) ) {
			$this->showForm (wfMsg ('cleanupspam_bad_regex')) ;
			return ;
		}

		/* and here we have an option - go for each one or not */
		if ("1" != $this->mList) {
			$this->cleanUp ($this->mLink, '') ;
		} else {
			$regexes = $this->buildUpRegexes () ;
			$this->cleanUpRegex ($regexes) ;			
		}
	}
}

?>
