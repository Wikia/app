<?php
/* Wikiforum.php -- a basic forum extension for Mediawiki
 * Copyright 2004 Guillaume Blanchard <aoineko@free.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * @author Guillaume Blanchard <aoineko@free.fr>
 * @addtogroup Extensions
 */

/**
 * This is not a valid entry point, perform no further processing unless MEDIAWIKI is defined
 */
if(defined('MEDIAWIKI')) {
// Defines and options
define('FORUM_PATH',            'extensions/wikiforum/' ); // extention path 
define('FORUM_VERSION',         '1.0.7.0');
define('FORUM_MAX_THREAD',      50); // total number of last thread displayed on the forum page
define('FORUM_INCLUDED_NUM',    20); // number of thread directly included into the forum page
define('FORUM_SUM_LENGHT',      32); // maximum length of "last comment" field
define('FORUM_CSS',             "$wgScriptPath/".FORUM_PATH.'wikiforum.css' ); // forum styles
define('FORUM_JS',              "$wgScriptPath/".FORUM_PATH.'wikiforum.js' ); // forum styles
define('FORUM_ALL_IN_TABLE',    true );  // add included thread into the table (in a full width cell)
define('FORUM_INC_ADD_SUM',     false ); // add link to the included thread into the summaries table
define('FORUM_INC_TABLE',       false ); // create a table to put a link to the included thread
define('FORUM_USE_JS',          true ); // use JS to toggle visibility of included thread
define('FORUM_NAVIGATION_LINK', true ); // add a link to the forum into navigation box
define('FORUM_ALLOW_NAMESPACE', true ); // allow to add namespace value into the url (ie "ns=1" for talk page).
define('FORUM_INCLUDE_HEADER',  true ); // if true, the content of [MediaWiki:Forum]'s page is add at the top of the forum
define('FORUM_SHOW_VIEW_COUNT', false ); // if true, the thread total view number is display into the table
define('FORUM_LASTEST_ON_TOP',  false); // change the threads sort order on the main page.

// Extension start function
$wgExtensionFunctions[] = 'wfForum';

// Multi-language management
require('language/default.php');	// require the default language file

$lang = 'language/'.$wgLang->getCode();
if($wgUseLatin1)
	$lang .= '_latin1';
else
	$lang .= '_utf8';
$lang .= '.php';

// DEBUG: force French interface
//$lang = "language/fr_utf8.php";

include($lang); // include the local language file (if any)

/**
 * Get language text value
 *
 * @addtogroup Extensions
 */
function WF_Msg( $index ) {
	global $wf_language, $wf_language_default;

	if(isset($wf_language)) {
		if(isset($wf_language[$index]))
			return $wf_language[$index];
		else if(isset($wf_language_default[$index]))
			return $wf_language_default[$index];
	}
	else if(isset($wf_language_default[$index]))
		return $wf_language_default[$index];

	return '';
}

$wgExtraNamespaces[NS_THREAD]   = WF_Msg('Thread');
$wgExtraNamespaces[NS_THREAD+1] = WF_Msg('ThreadTalk');

/**
 * New thread class
 *
 * @addtogroup Extensions
 */
class NewThread {
	
	/** show the form where a user can create a new thread */
	function showForm() {
		global $wgOut, $wgUser, $wgRequest;

		$wgOut->setPagetitle( WF_Msg('ThreadNew') );
		$wgOut->addLink(array(
			'rel'   => 'stylesheet',
			'type'  => 'text/css',
			'media' => 'screen,projection',
			'href'  => FORUM_CSS
		));
		
		$titleObj = Title::makeTitle( NS_SPECIAL, 'Newthread' );
		$action = $titleObj->escapeLocalURL( 'action=submit' );
		
		$title = htmlspecialchars( $wgRequest->getVal('threadTitle', '') );
		$desc  = htmlspecialchars( $wgRequest->getVal('threadDescription', '') );

		$rows = IntVal( $wgUser->getOption( 'rows' ) );
		$cols = IntVal( $wgUser->getOption( 'cols' ) );
		$wgOut->addHTML("<form class='wf new_thread' method='post' action='{$action}'>\n".
		                WF_Msg('ThreadTitle').": <input type='text' size='40' name='threadTitle' value=\"$title\" /><br />\n".
		                "<textarea rows='$rows' cols='$cols' name='threadDescription'>$desc</textarea>\n".
		                "<input type='hidden' name='wpEditToken' value=\"" . htmlspecialchars( $wgUser->editToken() ) . "\" />\n" .
		                "<input type='submit' value='".WF_Msg('ThreadOpen')."' />\n".
		                "</form>\n");
	}

	/** Check and save the thread in the database */
	function doSubmit() {
		global $wgOut, $wgRequest, $wgParser, $wgUser, $wgContLang;
	
		$tt = $wgContLang->ucfirst(trim($wgRequest->getVal('threadTitle', '')));
		$title = Title::makeTitleSafe( NS_THREAD, $tt );

		if(!$tt or !$title) { // invalid title
			$wgOut->addHTML("<div class=\"wf title_error\">".WF_Msg('ThreadInvalid')."</div>\n<br />\n");
			$this->showForm();
		}
		else if($title->getArticleID() == 0) { // article don't exist
			if( $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) )
			    || $wgUser->getId() == 0 ) {
				$article = new Article( $title );
				$article->insertNewArticle($wgRequest->getVal('threadDescription', ''), WF_Msg('ThreadNew'), false, false);
			} else {
				# Edit token mismatch: request may be a form submission
				# from an offsite JavaScript hack trying to hijack the
				# user's authentication credentials to make an edit.
				#
				# On the other hand, the user's session may simply
				# have expired. Show the form, and the user may push
				# the button to try again...
				$this->showForm();
			}
		} else { // thread already exist
			$wgOut->addHTML("<div class=\"wf title_error\">".WF_Msg('ThreadExist')."</div>\n<br />\n");
			$this->showForm();
		}
	}
}

/**
 * Thread class
 *
 * @addtogroup Extensions
*/
class Thread {
	var $title;
	var $comment;
	var $user;
	var $timestamp;
	var $count;
}

/**
 * Forum class
 *
 * @addtogroup Extensions
 */
class Forum {
	var $mMaxThread;
	var $mMaxFullText;
	var $mSumLength;
	var $mSortOrder;

	function Forum($thread=FORUM_MAX_THREAD, $included=FORUM_INCLUDED_NUM, $sum=FORUM_SUM_LENGHT) {
		$this->mMaxThread   = $thread;
		$this->mMaxFullText = $included;
		$this->mSumLength   = $sum;
	}

	function SetThreadNumber($thread=FORUM_MAX_THREAD) {
		$this->mMaxThread   = $thread;
	}

	function SetIncludeNumber($included=FORUM_INCLUDED_NUM) {
		$this->mMaxFullText = $included;
	}

	function SetSummaryMaxLength($sum=FORUM_SUM_LENGHT) {
		$this->mSumLength   = $sum;
	}
	
	function SetForumLastestOnTop($lastest=FORUM_LASTEST_ON_TOP) {
		$this->mSortOrder = $lastest ? true : false;
	}

	function Generate() {
		global $wgLang, $wgServer, $wgOut, $wgUserHtml, $wgRequest, $wgScriptPath;
	
		list( $limit, $offset ) = wfCheckLimits( $this->mMaxThread, 'wikiforumlimit');
		
		$fname = 'Forum::generate';

		if(FORUM_ALLOW_NAMESPACE)
			$ns = $wgRequest->getInt('ns', NS_THREAD);
		else
			$ns = NS_THREAD;

		$wgOut->setPagetitle('Forum');
		$wgOut->addLink(array(
			'rel'   => 'stylesheet',
			'type'  => 'text/css',
			'media' => 'screen, projection',
			'href'  => FORUM_CSS
		));
		if(FORUM_USE_JS) {
			$wgOut->addHTML("<script type=\"text/javascript\">\n".
			                "function toggleElement(id, type)\n".
			                "{\n".
			                "   var elem = document.getElementById(id);\n".
			                "   if(elem.style.display == type)\n".
			                "      elem.style.display = 'none';\n".
			                "   else\n".
			                "      elem.style.display = type;\n".
			                "}\n".
			                "</script>\n");
		}
		$wgOut->addHTML("<!-- This page was generated by WikiForum v".FORUM_VERSION." -->\n");
		
		// Get last X modified thread
		wfDebug("FORUM - START GENERATE\n");
		$dbr =& wfGetDB( DB_SLAVE );
		$cur = $dbr->tableName( 'cur' );
		
		// FIXME : does not work with 1.5
		$sql = "SELECT cur_title, cur_comment, cur_user_text, cur_timestamp, cur_counter FROM $cur".
		       " WHERE cur_namespace = $ns".
		       " AND cur_is_redirect = 0".
		       ' ORDER BY cur_timestamp DESC';
		$res = $dbr->query( $sql . $dbr->limitResult( $limit,$offset ), $fname );
		$num = $dbr->numRows( $res );
		
		// Generate forum's text
		$text = '';
		$text .= "__NOEDITSECTION____NOTOC__\n";
		
		if(FORUM_INCLUDE_HEADER) {
			$title = Title::makeTitleSafe( NS_MEDIAWIKI, 'Forum' );
			if($title->getArticleID() != 0) // article exist
				$text .= "<div class=\"wf forum_header\">{{".$wgLang->getNsText(NS_MEDIAWIKI).":Forum}}</div>\n";
		}
			
		// Link to create a thread only if current namespace is NS_THREAD
		if($ns == NS_THREAD)
			$text .= "<div class=\"wf create_thread\" id=\"top\">[[Special:Newthread|".WF_Msg('ThreadCreate')."]]</div>\n\n";

		$text .= "> [{{SERVER}}{{localurl:Special:Allpages|from=&namespace=$ns}} ".WF_Msg('ThreadAll')."]\n\n";
		
		$tab = array();
		$cnt = 0;

		while( $x = $dbr->fetchRow( $res ) ) {
			$tab[$cnt] = new Thread;
			$tab[$cnt]->title  = $x['cur_title'];
			$tab[$cnt]->comment = $x['cur_comment'];
			$tab[$cnt]->user  = $x['cur_user_text'];
			$tab[$cnt]->timestamp = $x['cur_timestamp'];
			$tab[$cnt]->count  = $x['cur_counter'];
			if($this->mSumLength && (strlen($tab[$cnt]->comment) > $this->mSumLength))
				$tab[$cnt]->comment = substr($tab[$cnt]->comment, 0, $this->mSumLength) . "...";
			$cnt++;
		}

		if(!$this->mSortOrder) { $tab = array_reverse($tab); }

		$dbr->freeResult( $res );

		// secure include thread max
		if($this->mMaxFullText > $num)
			$this->mMaxFullText = $num;

		$summary = $num - $this->mMaxFullText;
		
		$wgOut->addWikiText( $text );
		$text = '';

		$wgOut->addHTML( wfViewPrevNext( $offset, $limit , "Special:Forum", '' ) );
		if(FORUM_ALL_IN_TABLE) {
			$t = WF_Msg('ThreadLastest');
			$t = str_replace("$1", $num, $t);
			$wgOut->addHTML( "<h1>$t</h1>\n".
			                 "<table class=\"wf thread_table\" cellspacing=\"0\" cellpadding=\"2px\">\n".
			                 "<tr class=\"wf thread_row\" id=\"threadtablehead\">\n".
			                 "<th> </th>\n".
			                 "<th>".WF_Msg('ThreadName')."</th>\n" );
			if(FORUM_SHOW_VIEW_COUNT)
				$wgOut->addHTML( "<th>".WF_Msg('ThreadView')."</th>\n" );

			$wgOut->addHTML( "<th>".WF_Msg('ThreadUser')."</th>\n".
			                 "<th>".WF_Msg('ThreadComment')."</th>\n".
			                 "<th>".WF_Msg('ThreadTime')."</th>\n".
			                 "</tr>\n" );
			                 
			$col = 6;
			if(FORUM_SHOW_VIEW_COUNT)
				$col--;

			for( $cnt=0; $cnt<$num; $cnt++ ) {
				$t = $wgLang->getNsText( $ns );
				if ( $t != '' ) 
					$t .= ':' ;
				$t .= $tab[$cnt]->title;

				$title = Title::newFromText( $t );

				if(($summary > 0) && ($cnt == $summary)) {
					$wgOut->addHTML( "<tr class=\"wf\" id=\"thread_interval\"><td colspan=\"$col\"> </td></tr>\n".
					                 "<tr class=\"wf thread_row\" id=\"threadtablehead\">\n".
					                 "<th> </th>\n".
					                 "<th>".WF_Msg('ThreadName')."</th>\n" );
					if(FORUM_SHOW_VIEW_COUNT)
						$wgOut->addHTML( "<th>".WF_Msg('ThreadView')."</th>\n" );
					$wgOut->addHTML( "<th>".WF_Msg('ThreadUser')."</th>\n".
					                 "<th>".WF_Msg('ThreadComment')."</th>\n".
					                 "<th>".WF_Msg('ThreadTime')."</th>\n".
					                 "</tr>\n" );
				}
				
				if($cnt < $summary) {
					if($cnt & 1)
						$wgOut->addHTML( "<tr class=\"wf thread_row thread_list odd\">\n" );
					else
						$wgOut->addHTML( "<tr class=\"wf thread_row thread_list peer\">\n" );
		
					$wgOut->addHTML(     "<td> </td><td>" );
					$wgOut->addWikiText( "[[$t|". $title->getText() ."]]", false );
					$wgOut->addHTML(     "</td>\n" );
					if(FORUM_SHOW_VIEW_COUNT)
						$wgOut->addHTML(     "<td>". $tab[$cnt]->count."</td>\n" );
					$wgOut->addHTML(     "<td>" );
					$wgOut->addWikiText( "[[". $wgLang->getNsText( NS_USER ) .":". $tab[$cnt]->user ."|" .$tab[$cnt]->user. "]]", false );
					$wgOut->addHTML(     "</td>\n".
					                     "<td>". htmlspecialchars($tab[$cnt]->comment) . "</td>\n".
					                     "<td>". $wgLang->timeanddate($tab[$cnt]->timestamp) ."</td>\n".
					                     "</tr>\n" );
				} else {
					if($cnt & 1)
						$wgOut->addHTML( "<tr class=\"wf thread_row thread_inc odd\">\n" );
					else
						$wgOut->addHTML( "<tr class=\"wf thread_row thread_inc peer\">\n" );

					$wgOut->addHTML(     "<td>" );

					if(FORUM_USE_JS) {
						$wgOut->addHTML(  "<img src=\"$wgScriptPath/skins/common/images/magnify-clip.png\" class=\"wf thread_toggle\" onclick=\"toggleElement('thread_body_$cnt', 'table-cell')\" alt=\"".WF_Msg('ThreadSHAlt')."\" title=\"".WF_Msg('ThreadSHTip')."\" />\n" );
					}
					$wgOut->addHTML(     "</td>".
					                     "<td>" );
					$wgOut->addWikiText( "[[$t|". $title->getText() ."]]", false );
					$wgOut->addHTML(     "</td>\n" );
					if(FORUM_SHOW_VIEW_COUNT)
						$wgOut->addHTML(     "<td>". $tab[$cnt]->count."</td>\n" );
					$wgOut->addHTML(     "<td>" );
					$wgOut->addWikiText( "[[". $wgLang->getNsText( NS_USER ) .":". $tab[$cnt]->user ."|" .$tab[$cnt]->user. "]]", false );
					$wgOut->addHTML(     "</td>\n".
					                     "<td>". htmlspecialchars($tab[$cnt]->comment) . "</td>\n".
					                     "<td>". $wgLang->timeanddate($tab[$cnt]->timestamp) ."</td>\n".
					                     "</tr>\n" );
					
					if($cnt & 1)
						$wgOut->addHTML(  "<tr class=\"wf thread_row thread_body odd\">\n" );
					else
						$wgOut->addHTML(  "<tr class=\"wf thread_row thread_body peer\">\n" );

					$wgOut->addHTML(     "<td colspan=\"$col\" id=\"thread_body_$cnt\">\n" );
					$wgOut->addWikiText( "<div class=\"wf threadedit\" style=\"float:right;\">".
					                     "[[$wgServer" . $title->getEditUrl() ." ".WF_Msg('ThreadEdit')."]]".
					                     "</div>\n".
					                     "__NOEDITSECTION____NOTOC__\n".
					                     "{{{$t}}}\n", false );
					$wgOut->addHTML(     "</td>\n".
					                     "</tr>\n" );
				}
			}

			$wgOut->addHTML( "</table>\n\n\n" );
		} else {
			// render summaries table
			if(($summary > 0) || FORUM_INC_ADD_SUM) {
				if(FORUM_INC_ADD_SUM)
					$max = $num;
				else
					$max = $summary;

				$t = WF_Msg('ThreadLastest');
				$t = str_replace("$1", $max, $t);
				$text .= "<h1>$t</h1>\n";
				$text .= "{| class=\"wf thread_table\" border=\"0\" cellspacing=\"0\" cellpadding=\"2px\" width=\"100%\"\n";
				$text .= "|- class=\"wf thread_row\" id=\"threadtablehead\"\n";
				$text .= "! ".WF_Msg('ThreadName')." !! ".WF_Msg('ThreadView')." !! ".WF_Msg('ThreadUser')." !! ".WF_Msg('ThreadComment')." !! ".WF_Msg('ThreadTime')."\n";

				for( $cnt=0; $cnt<$max; $cnt++ ) {
					$t = $wgLang->getNsText( $ns );
					if ( $t != '' ) 
						$t .= ':' ;
					$t .= $tab[$cnt]->title;

					$title = Title::newFromText( $t );

					if($cnt < $summary) {
						if($cnt & 1)
							$text .= "|- class=\"wf thread_row\" id=\"thread_rowodd\"\n";
						else
							$text .= "|- class=\"wf thread_row\" id=\"thread_rowpeer\"\n";
			
						$text .= "| [[$t|". $title->getText() ."]] ".
						         "|| ". $tab[$cnt]->count." ".
						         "|| [[". $wgLang->getNsText( NS_USER ) .":". $tab[$cnt]->user ."|" .$tab[$cnt]->user. "]] ".
						         "|| ". $tab[$cnt]->comment . " " .
						         "|| ". $wgLang->timeanddate($tab[$cnt]->timestamp) ."\n";
					} else {
						if($cnt & 1)
							$text .= "|- class=\"wf thread_row\" id=\"threadincodd\"\n";
						else
							$text .= "|- class=\"wf thread_row\" id=\"threadincpeer\"\n";
			
						$text .= "| [[#".$title->getText()."|".$title->getText()."]] ".
						         "|| ". $tab[$cnt]->count." ".
						         "|| [[". $wgLang->getNsText( NS_USER ) .":". $tab[$cnt]->user ."|" .$tab[$cnt]->user. "]] ".
						         "|| ". $tab[$cnt]->comment . " " .
						         "|| ". $wgLang->timeanddate($tab[$cnt]->timestamp) ."\n";
					}
				}
			
				$text .= "|}\n\n";
			}

			// render includes thread
			if($this->mMaxFullText > 0) {
				if(FORUM_INC_TABLE) {
					$t = WF_Msg('ThreadIncluded');
					$t = str_replace("$1", $this->mMaxFullText, $t);
					$text .= "<h1>$t</h1>\n";
					$text .= "{| class=\"wf thread_table\" border=\"0\" cellspacing=\"0\" cellpadding=\"2px\" width=\"100%\"\n";
					$text .= "|- class=\"wf thread_row\" id=\"threadtablehead\"\n";
					$text .= "! ".WF_Msg('ThreadName')." !! ".WF_Msg('ThreadView')." !! ".WF_Msg('ThreadUser')." !! ".WF_Msg('ThreadComment')." !! ".WF_Msg('ThreadTime')."\n";

					for( $cnt=$summary; $cnt<$num; $cnt++ ) {
						$t = $wgLang->getNsText( $ns );
						if ( $t != '' ) 
							$t .= ':' ;
						$t .= $tab[$cnt]->title;

						$title = Title::newFromText( $t );

						if($cnt & 1)
							$text .= "|- class=\"wf thread_row\" id=\"threadincodd\"\n";
						else
							$text .= "|- class=\"wf thread_row\" id=\"threadincpeer\"\n";
		
						$text .= "| [[#".$title->getText()."|".$title->getText()."]] ".
						         "|| ". $tab[$cnt]->count." ".
						         "|| [[". $wgLang->getNsText( NS_USER ) .":". $tab[$cnt]->user ."|" .$tab[$cnt]->user. "]] ".
						         "|| ". $tab[$cnt]->comment . " " .
						         "|| ". $wgLang->timeanddate($tab[$cnt]->timestamp) ."\n";
					}
			
					$text .= "|}\n\n";
				}

				for( $cnt=$summary; $cnt<$num; $cnt++ ) {
					$t = $wgLang->getNsText( $ns );
					if ( $t != '' ) 
						$t .= ':' ;
					$t .= $tab[$cnt]->title;

					$title = Title::newFromText( $t );

					$text .= "<div class=\"wf threadcontent\">\n";
					$text .= "<div class=\"wf threadedit\" style=\"float:right;\">[[$wgServer" . $title->getEditUrl() ." ".WF_Msg('ThreadEdit')."]]</div>\n";
					$text .= "==".$title->getText()."==\n";
					$text .= "{{{$t}}}\n";
					$text .= "</div>\n";
				}
			}
		}

		// Link to create a thread only if current namespace is NS_THREAD
		if($ns == NS_THREAD) {
			$text .= "<div class=\"wf create_thread\" id=\"bottom\">[[Special:Newthread|".WF_Msg('ThreadCreate')."]]</div>";
		}
		wfDebug("FORUM - END GENERATE\n");

		$wgOut->addHTML( wfViewPrevNext( $offset, $limit , "Special:Forum", '' ) );

		$wgOut->addWikiText( $text );
		//return $text;
	}
}

$wgForum = new Forum();

/**
 * Forum special page
 *
 * @addtogroup Extensions
 */
function wfForum() {
	global $IP, $wgMessageCache, $wgAllMessagesEn, $wgNavigationLinks, $wgTitle;
	require_once( $IP.'/includes/SpecialPage.php' );


	class SpecialForum extends SpecialPage {
		function SpecialForum() 
		{
			SpecialPage::SpecialPage('Forum');
			SpecialPage::setListed(true);
		}

		function execute() {
			global $wgForum;

			$wgForum->Generate();
		}
	}

	SpecialPage::addPage( new SpecialForum );

	class SpecialNewthread extends SpecialPage {
		function SpecialNewthread() {
			SpecialPage::SpecialPage('Newthread');
			SpecialPage::setListed(false);
		}

		function execute() {
			global $wgRequest, $action;

			$nt = new NewThread();
			if ( $action == 'submit' && $wgRequest->wasPosted() ) 
				$nt->doSubmit();
			else 
				$nt->showForm();
		}
	}

	SpecialPage::addPage( new SpecialNewthread );

	if(FORUM_NAVIGATION_LINK) {
		$title = Title::makeTitle( NS_SPECIAL, 'Forum' );
		$wgAllMessagesEn['nav-forum'] = 'Forum';
		$wgAllMessagesEn['nav-forum-ulr'] = $title->getFullURL();
		$wgNavigationLinks[] = array( 'text' => 'nav-forum', 'href' => 'nav-forum-ulr' );
	}
}


} // end if(defined('MEDIAWIKI'))


