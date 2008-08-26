<?php

/*
	A special page to edit a batch of pages
*/
if(!defined('MEDIAWIKI'))
   die();

define ("MULTIWIKIEDIT_THIS", 0) ;
define ("MULTIWIKIEDIT_ALL", 1) ;
define ("MULTIWIKIEDIT_SELECTED", 2) ;
define ("MULTIWIKIEDIT_CHUNK_SIZE", 250) ;

$wgAvailableRights[] = 'multiwikiedit';
$wgGroupPermissions['staff']['multiwikiedit'] = true;

$dir = dirname(__FILE__);
$wgExtensionMessagesFiles ['MultiWikiEdit'] = $dir . '/MultiWikiEdit.i18n.php';

$wgExtensionFunctions[] = 'wfMultiWikiEditSetup';
$wgExtensionCredits['specialpage'][] = array(
   'name' => 'Multi Wiki Edit',
   'author' => 'Bartek Łapiński',
   'version' => '2.11' ,
   'description' => 'edits a batch of pages on this wiki or a page on multiple wikis'
);

/* special page init */
function wfMultiWikiEditSetup() {
	global $IP ;
	require_once($IP. '/includes/SpecialPage.php');
	SpecialPage::addPage(new SpecialPage('Multiwikiedit', 'multiwikiedit', true, 'wfMultiWikiEditSpecial', false));
}

/* the core */
function wfMultiWikiEditSpecial( $par ) {
	global $wgOut, $wgUser, $wgRequest ;
	wfLoadExtensionMessages ('MultiWikiEdit') ; 
   	$wgOut->setPageTitle (wfMsg('multiwikiedit_title'));
	$cSF = new MultiWikiEditForm ($par) ;

	$action = $wgRequest->getVal ('action') ;
	if ('success' == $action) {
	} else if ( $wgRequest->wasPosted() && 'submit' == $action &&
	        $wgUser->matchEditToken( $wgRequest->getVal ('wpEditToken') ) ) {
	        $cSF->doSubmit () ;
	} else if ('resubmit' == $action) {
		$cSF->doResubmit () ;
	} else {
		$cSF->showForm ('') ;
	}
}

/* the form for blocking names and addresses */
class MultiWikiEditForm {
	var $mMode, $mUser, $mPage, $mReason, $mFile, $mWikiList, $mFileTemp, $mRange ;
	var $mText, $mMinorEdit, $mBotEdit, $mAutoSummary, $mNoRecentChanges ;

	/* constructor */
	function multiwikieditForm ( $par ) {
		global $wgRequest ;
		$this->mMode = $wgRequest->getVal( 'wpMode' ) ;
		$this->mPage = $wgRequest->getVal( 'wpPage' ) ;	
		$this->mReason = $wgRequest->getVal( 'wpReason' ) ;	
		$this->mFile = $wgRequest->getFileName( 'wpFile' ) ;
		$this->mFileTemp = $wgRequest->getFileTempName( 'wpFile' );
		$this->mWikiFile = $wgRequest->getFileName( 'wpWikiList' ) ;
		$this->mWikiInbox = $wgRequest->getVal ('wpWikiInbox') ;		
		$this->mWikiTemp = $wgRequest->getFileTempName( 'wpWikiList' ) ;
		$this->mRange = $wgRequest->getVal ('wpRange') ;
		$this->mText = $wgRequest->getVal ('wpText') ;
		$this->mSummary = $wgRequest->getVal ('wpSummary') ;
		$this->mMinorEdit = $wgRequest->getVal ('wpMinorEdit') ;
		$this->mBotEdit = $wgRequest->getVal ('wpBotEdit') ;
		$this->mAutoSummary = $wgRequest->getVal ('wpAutoSummary') ;
		$this->mNoRecentChanges = $wgRequest->getVal ('wpNoRecentChanges') ;
	}

	/* output */
	function showForm ($err = '') {
		global $wgOut, $wgUser, $wgRequest ;
	
		$token = htmlspecialchars( $wgUser->editToken() );
		$titleObj = Title::makeTitle( NS_SPECIAL, 'multiwikiedit' );
		$action = $titleObj->escapeLocalURL( "action=submit" ) ;

                if ( "" != $err ) {
                        $wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
                        $wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
                }
	
		$wgOut->addWikiText (wfMsg('multiwikiedit_help')) ;

		if ( ('submit' == $wgRequest->getVal( 'action' )) && ('' != $err) ) {
			 $scPage = htmlspecialchars ($this->mPage) ;
			 $scReason = htmlspecialchars ($this->mReason) ;
			 $scFile = $this->mFile ;

			 /* checkboxes, checkboxes */
			 $this->mMinorEdit ? $scMinorEdit = "checked=\"checked\"" : $scMinorEdit = '' ;
			 $this->mBotEdit ? $scBotEdit = "checked=\"checked\"" : $scBotEdit = '' ;
			 $this->mAutoSummary ? $scAutoSummary = "checked=\"checked\"" : $scAutoSummary = '' ;
			 $this->mNoRecentChanges ? $scNoRecentChanges = "checked=\"checked\"" : $scNoRecentChanges = '' ;

			 $scText = $this->mText ;
			 $scSummary = $this->mSummary ;
			 $scRange = $this->mPage ;
			 $scWikiInbox = $this->mWikiInbox ;
		} else {
			$scPage = '' ;
			$scReason = '' ;
			$scMinorEdit = '' ;
			$scBotEdit = '' ;
			$scAutoSummary = '' ;
			$scNoRecentChanges = '' ;
			$scText = '' ;
			$scSummary = '' ;
			$scRange = '' ;
			$scFile = '' ;
			$scWikiInbox = '' ;
		}
		
   		$wgOut->addHtml("
<form name=\"multiwikiedit\" enctype=\"multipart/form-data\" method=\"post\" action=\"{$action}\">
	<table border=\"0\">
		<tr>
                        <td align=\"right\">".wfMsg('multiwikiedit_as')." :</td>
                        <td align=\"left\">") ;
                $this->makeSelect (
                                        'wpMode',
                                        array (
                                                wfMsg ('multiwikiedit_select_script') => 'script',
                                                wfMsg ('multiwikiedit_select_yourself') => 'you'
                                        ),
                                        $this->mMode,
                                        1
                                        ) ;
		$wgOut->addHtml("</td></tr>") ;			
		$wgOut->addHtml("<tr>
                        <td align=\"right\">".wfMsg('multiwikiedit_on')." :</td>
                        <td align=\"left\">		
		") ;					
                $this->makeSelect (
                                        'wpRange',
                                        array (
                                                wfMsg ('multiwikiedit_this_wiki') => 'one',
                                                wfMsg ('multiwikiedit_all_wikis') => 'all' ,
						wfMsg ('multiwikiedit_selected_wikis') => 'selected' ,
                                                wfMsg ('multidelete_brazilian_portuguese_wikis') => 'lang:pt-br' ,
                                                wfMsg ('multidelete_hebrew_wikis') => 'lang:he' ,
                                                wfMsg ('multidelete_chinese_wikis') => 'lang:zh',
                                                wfMsg ('multidelete_polish_wikis') => 'lang:pl' ,
                                                wfMsg ('multidelete_czech_wikis') => 'lang:cs' ,
                                                wfMsg ('multidelete_portuguese_wikis') => 'lang:pt' ,
                                                wfMsg ('multidelete_dutch_wikis') => 'lang:nl' ,
                                                wfMsg ('multidelete_italian_wikis') => 'lang:it' ,
                                                wfMsg ('multidelete_russian_wikis') => 'lang:ru' ,
                                                wfMsg ('multidelete_english_wikis') => 'lang:en' ,
                                                wfMsg ('multidelete_japanese_wikis') => 'lang:ja' ,
                                                wfMsg ('multidelete_finnish_wikis') => 'lang:fi' ,
                                                wfMsg ('multidelete_spanish_wikis') => 'lang:es' ,
                                                wfMsg ('multidelete_french_wikis') => 'lang:fr' ,
                                                wfMsg ('multidelete_swedish_wikis') => 'lang:sv' ,
                                                wfMsg ('multidelete_german_wikis') => 'lang:de' ,
                                        ),
                                        $this->mMode,
                                        1
                                        ) ;
		/* if mode is selected, _show_ those hidden thingies... */
		$this->mRange == 'selected' ? $display_hidden = '' : $display_hidden = 'display: none;' ;
                $wgOut->addHtml("</td>
                </tr>") ;

		$wgOut->addHTML ("
		<tr id=\"wikiinbox\" style=\"vertical-align:top; $display_hidden\" >
			<td align=\"right\">".wfMsg('multiwikiedit_inbox_caption')." :</td>
			<td align=\"left\">
				<textarea tabindex=\"3\" name=\"wpWikiInbox\" id=\"wpWikiInbox\" cols=\"40\" rows=\"2\" />$scWikiInbox</textarea>
			</td>
		</tr>
		<tr>
			<td align=\"right\" style=\"vertical-align:top\">".wfMsg('multiwikiedit_page_text')." :</td>
			<td align=\"left\">
				<textarea tabindex=\"4\" name=\"wpText\" id=\"wpText\" cols=\"40\" rows=\"10\">$scText</textarea>
			</td>
		</tr>
		<tr>
			<td align=\"right\" style=\"vertical-align:top\">".wfMsg('multiwikiedit_summary_text')." :</td>
			<td align=\"left\">
				<input type=\"text\" tabindex=\"5\" name=\"wpSummary\" style=\"width: 100%;\" id=\"wpSummary\" value=\"$scSummary\">
			</td>
		</tr>
		<tr>
			<td align=\"right\">&nbsp;</td>
			<td align=\"left\">
				<input type=\"checkbox\" tabindex=\"6\" name=\"wpMinorEdit\" id=\"wpMinorEdit\" value=\"1\" $scMinorEdit />
				".wfMsg('multiwikiedit_minoredit_caption')."
			</td>
		</tr>
		<tr>
			<td align=\"right\">&nbsp;</td>
			<td align=\"left\">
				<input type=\"checkbox\" tabindex=\"7\" name=\"wpBotEdit\" id=\"wpBotEdit\" value=\"1\" $scBotEdit />
				".wfMsg('multiwikiedit_botedit_caption')."
			</td>
		</tr>
		<tr>
			<td align=\"right\">&nbsp;</td>
			<td align=\"left\">
				<input type=\"checkbox\" tabindex=\"8\" name=\"wpAutoSummary\" id=\"wpAutoSummary\" value=\"1\" $scAutoSummary />
				".wfMsg('multiwikiedit_autosummary_caption')."
			</td>
		</tr>
		<tr>
			<td align=\"right\">&nbsp;</td>
			<td align=\"left\">
				<input type=\"checkbox\" tabindex=\"9\" name=\"wpNoRecentChanges\" id=\"wpNoRecentChanges\" value=\"1\" $scNoRecentChanges />
				".wfMsg('multiwikiedit_norecentchanges_caption')."
			</td>
		</tr>
		<tr>
			<td align=\"right\" style=\"vertical-align:top\">".wfMsg('multiwikiedit_page')." :</td>
			<td align=\"left\">
				<textarea tabindex=\"10\" name=\"wpPage\" id=\"wpPage\" cols=\"40\" rows=\"2\">$scPage</textarea>
			</td>
		</tr>") ;

		$wgOut->addHTML ("
		<tr>
			<td align=\"right\">&#160;</td>
			<td align=\"left\">
				<input tabindex=\"11\" name=\"wpmultiwikieditSubmit\" type=\"submit\" value=\"".wfMsg('multiwikiedit_button')."\" />
			</td>
		</tr>
	</table>
	<input type='hidden' name='wpEditToken' value=\"{$token}\" />
</form>");

		$wgOut->addScript("
			<script type=\"text/javascript\">
				function MultiWikiEditEnhanceControls () {
					var rangeControl = document.getElementById ('wpRange') ;
					//var selectedInput = document.getElementById ('wikilist') ;
					var selectedInbox = document.getElementById ('wikiinbox') ;

					if ((rangeControl.options[rangeControl.selectedIndex].value) == 'selected') {
						//selectedInput.style.display = '' ;
						selectedInbox.style.display = '' ;
					}

					var PreferencesSave = document.getElementById ('wpSaveprefs') ;
					rangeControl.onchange = function () {
						if ((this.options[this.selectedIndex].value) == 'selected') {
							//selectedInput.style.display = '' ;
							selectedInbox.style.display = '' ;
						} else {
							//selectedInput.style.display = 'none' ;
							selectedInbox.style.display = 'none' ;
						}
					}
				}
	       		 	addOnloadHook (MultiWikiEditEnhanceControls) ;
			</script>"
			) ;
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

	/* wraps up multi edits */
	function multiEdit ($mode = MULTIWIKIEDIT_THIS, $user = false, $line = '', $filename = null, $filename2 = null, $lang = '') {
		global $wgUser, $wgOut ;

		/* todo all messages should really be as _messages_ , not plain texts */
		if ( $this->mText == '' ) {
			$this->showForm ("Specify article text first") ;
			return ;
		}

		/* now, check the file if given */
		if ($filename) {
			if ("" != $this->mPage) {
				$this->showForm (wfMsg('multiwikiedit_both_modes')) ;
				return ;
			}			
			$magic=& wfGetMimeMagic () ;
			$mime= $magic->guessMimeType ($filename,false) ;

			$file = fopen ($filename,'r');
				if ( !$file ) {
			        $this->showForm ("Unable to read given file") ;
		        	return ;
			}
		}

		if ($mode == MULTIWIKIEDIT_SELECTED) {
			if (!$filename2 && ("" == $this->mWikiInbox)) {
				$this->showForm ("Please supply the list of selected wikis") ;
				return ;
			}
			if ($filename2) {
				if  ("" != $this->mWikiInbox) {
					$this->showForm ("Please choose either a list of wikis from file or a list from input box") ;
					return ;
				}
				$magic2=& wfGetMimeMagic () ;
				$mime2= $magic2->guessMimeType ($filename2,false) ;

				$file2 = fopen ($filename2,'r');
				if ( !$file2 ) {
					$this->showForm ("Unable to read given file") ;
					return ;
				}
			}
		}

		/* switch user if necessary */
		if ('script' == $this->mMode) {
			$username = 'edit page script' ;
		} else {
			$username = $wgUser->getName () ;
		}

		/* get wiki array */
		if ($mode == MULTIWIKIEDIT_ALL) {
	                $wikis = $this->fetchWikis ($lang) ;
		}  else if ($mode == MULTIWIKIEDIT_SELECTED) {
			$pre_wikis = array () ;
			if ($filename2) {
				/* from filename and into an array */
				for ( $linenum2 = 1; !feof( $file2 ); $linenum2++ ) {
					$line2 = trim( fgets( $file2 ) );
					if ( $line2 == false ) {
						break;
					}
					/* the file should contain only "{wiki sitename}|"\n lines */
					array_push ($pre_wikis, $line2) ;
				}
			} else {
				$inbox_line2 = $this->mWikiInbox ;
				$pre_wikis = explode( ",", $inbox_line2 );
			}
			/* now, summon all necessary data */
			$wikis = $this->fetchSelectedWikis ($pre_wikis) ;
		} else if ($mode == MULTIWIKIEDIT_THIS) {
			global $wgCityId ;
			$wikis = $this->fetchThisWiki ($wgCityId) ;
			$found_articles = array () ;
		}
		
		/* if not, either don't specify or overwrite with given arguments */

		$dbw =& wfGetDB( DB_MASTER );
                if ($filename) {
			for ( $linenum = 1; !feof( $file ); $linenum++ ) {
        			$line = trim( fgets( $file ) );
        			if ( $line == false ) {
                			break;
				}
				/*  the file should contain only "page title|reason"\n lines
				*/
				$arr = explode ("|",$line) ;
				is_null($arr[1]) ? $reason = '' : $reason = $arr[1] ; 
				$found = $this->checkArticle ($arr[0], $wikis[0], $found_articles) ;
        		}
			// cut the array into smaller ones, and then apply task to each of them
			$chunked_articles = array_chunk ($found_articles, MULTIWIKIEDIT_CHUNK_SIZE) ;
			$this->splitWarning ($chunked_articles) ;

			if (isset ($_SESSION ["MWE_selected_articles"]) ) {
				foreach ($chunked_articles as $chunk) {
					$this->limitResult ($chunk, $username, $this->mView, $this->mMode, true) ;				
					$thisTask = new MultiWikiEditTask (true) ;
					$thisTask->mArguments = $chunk ;
					$thistask->mAdmin = $wgUser->getName () ;
					$submit_id = $thisTask->submitForm () ;
					if (false !== $submit_id) {
						$wgOut->addHtml ("<br/>". wfMsg ('multiwikiedit_task_added', $submit_id). "<br/>" ) ;
					} else {
						$wgOut->addHtml ("<br/>". wfMsg ('multiwikiedit_task_error'). "<br/>" ) ;
					}
				}
			} else {
				$wgOut->addHtml ("<br/>". wfMsg ('multiwikiedit_task_none_selected'). "<br/>" ) ;
			}

		} else {
			$lines = explode( "\n", $line );			
			/*	don't allow to edit more than 1 title at once on multiple wikis
				since they check all pages manually anyway			
			*/
			if ( ($mode != MULTIWIKIEDIT_THIS) && (count($lines) > 1) ) {
			        $this->showForm ("Only one title at a time allowed for multi-wiki edit.") ;
		        	return ;								
			}
			foreach ($lines as $single_page) {
				$page_data = explode ("|", trim ($single_page) ) ;
				if (count($page_data) < 2) 
					$page_data[1] = '' ;
				if ($mode == MULTIWIKIEDIT_THIS) {
					/* don't manipulate it yet, just pass the data along to the task... */
					$found = $this->checkArticle ($page_data[0], $wikis[0], $found_articles) ;
				} else { /* wipe them out, all of them */
					$titleObj = Title::makeTitle( NS_SPECIAL, 'multiwikiedit' );
					$action = $titleObj->escapeLocalURL ("action=resubmit") ;
					$wgOut->addHTML ("<form name=\"multiwikiedit_confirm\" method=\"post\" action=\"{$action}\">") ;
					$found_articles = array () ;
					foreach ($wikis as $wiki) {
						$found = $this->checkArticle ($page_data[0], $wiki, $found_articles) ;
					}
					/* remember to limit result, this could get messy */
					$this->limitResult ($found_articles, $username, $this->mView, $this->mMode) ;
					$wgOut->addHTML ("</form>") ;
				}
			}
			/*	like Tor pointed out, it would be better to do the deletion of multiple articles on this wiki
				as a task too... I am inclined to agree
			*/
			if ($mode == MULTIWIKIEDIT_THIS) {
				$this->limitResult ($found_articles, $username, $this->mView, $this->mMode, true) ;
				//add the task
				if (isset ($_SESSION ["MWE_selected_articles"]) ) {
					$thisTask = new MultiWikiEditTask (true) ;
					$thisTask->mMode = "single" ;
					$thistask->mAdmin = $wgUser->getName () ;
					$thisTask->mArguments = $_SESSION ["MWE_selected_articles"] ;
					$submit_id = $thisTask->submitForm () ;
					if (false !== $submit_id) {
						$wgOut->addHtml ("<br/>". wfMsg ('multiwikiedit_task_added', $submit_id). "<br/>" ) ;
					} else {
						$wgOut->addHtml ("<br/>". wfMsg ('multiwikiedit_task_error'). "<br/>" ) ;
					}
				} else {
					$wgOut->addHtml ("<br/>". wfMsg ('multiwikiedit_task_none_selected'). "<br/>" ) ;
				}
			}
		}

		$sk = $wgUser->getSkin () ;	
		$titleObj = Title::makeTitle( NS_SPECIAL, 'Multiwikiedit' );
		$link_back = $sk->makeKnownLinkObj ($titleObj, '<b>here</b>') ;
		$wgOut->addHtml ("<br/>".wfMsg('multiwikiedit_link_back')." ".$link_back.".") ;
	}

	function limitResult ($result_array, $username, $view, $mode, $silent = false) {
		global $wgOut, $wgRequest ;
		/* no matches found? */
		if ( 0 == count($result_array) ) {
				$wgOut->addHTML("There are no results found.") ;
				return false ;
		}
		$range = 0 ;
		/* sort by timestamps in descending order */
		ksort ($result_array) ;

		$result_array = array_reverse ($result_array);
		/* now, renumerate array */
		$result_array = array_values ($result_array) ;

                $limit = '10000' ;
		$offset = 0 ;
		( count ($result_array) < ($limit + $offset) ) ? $range = count ($result_array) : $range = ($limit + $offset) ;
		for ($i = $offset; $i < $range; $i++) {
			if (!$silent) {                                         	 
			/* make output */
				$wgOut->addHTML ("<input type=\"checkbox\" name=\"wpArticle".$i."\" value=\"1\" checked>") ;
				$this->produceLine ($result_array[$i]) ;
				$wgOut->addHTML ("<br>") ;
			}
		}

		$_SESSION ['MWE_selected_flags'] = array ($this->mMinorEdit, $this->mBotEdit, $this->mAutoSummary, $this->mNoRecentChanges) ;
		$_SESSION ['MWE_selected_articles'] = $result_array ;
		$_SESSION ['MWE_text'] = $this->mText ;
		$_SESSION ['MWE_username'] = $username ;
		$_SESSION ['MWE_summary'] = $this->mSummary ;
		if (!$silent) {
			$wgOut->addHTML ("<input type=\"submit\" value=\"".wfMsg ('multiwikiedit_button') ."\">") ;
		}
	}

	/*	get the list of wikis from database
	*/
	function fetchWikis ($lang = '') {
		global $wgSharedDB ;
		$dbr =& wfGetDB (DB_SLAVE);
		'' != $lang ? $extra = " WHERE city_lang = '$lang'" : $extra = '' ;
		$query = "SELECT city_dbname, city_id, city_url, city_title, city_path FROM `{$wgSharedDB}`.city_list" . $extra ;
		$res = $dbr->query ($query) ;
		$wiki_array = array () ;
		while ($row = $dbr->fetchObject($res)) {
			array_push ($wiki_array, $row) ;
		}
		$dbr->freeResult ($res) ;
		return $wiki_array ;
	}

	/*	get the data for this current wiki we're on
	*/
	function fetchThisWiki ($wikiid) {
		global $wgSharedDB ;
		$wiki_array = array () ;
		$dbr =& wfGetDB (DB_SLAVE);
		$query = "SELECT city_dbname, city_id, city_url, city_title, city_path
			FROM `{$wgSharedDB}`.city_list
			WHERE city_id = $wikiid" ;

		$res = $dbr->query ($query) ;

		/* get only the first result */
		if ($row = $dbr->fetchObject($res)) {
			array_push ($wiki_array, $row) ;
		}
		$dbr->freeResult ($res) ;
		return $wiki_array ;
	}


	/*	get the list of wikis from given list 
		populate it with all required data		
	*/
	function fetchSelectedWikis ($wiki_list) {
		global $wgSharedDB ;
		$wiki_array = array () ;
		foreach ($wiki_list as $single_wiki) {
			$single_wiki = trim ($single_wiki) ;
			$dbr =& wfGetDB (DB_SLAVE);
			$query = "SELECT city_list.city_dbname, city_list.city_id, city_list.city_url, city_list.city_title, city_list.city_path
				  FROM `{$wgSharedDB}`.city_list, `{$wgSharedDB}`.city_domains
				  WHERE city_domain = '".$single_wiki."'
				  AND city_list.city_id = city_domains.city_id" ;
		
			$res = $dbr->query ($query) ;

			/* get only the first result */
			if ($row = $dbr->fetchObject($res)) {
				array_push ($wiki_array, $row) ;
			}
			$dbr->freeResult ($res) ;
		}
		return $wiki_array ;
	}

	/* init for showprevnext */
	function showPrevNext () {
		global $wgContLang, $wgRequest, $wgOut ;
		list( $limit, $offset ) = $wgRequest->getLimitOffset();
		$target = 'target=' . urlencode ( $wgRequest->getVal ('target') ) ;
		$view = 'view=' . urlencode ( $this->mView ) ;
		$mode = 'mode=' . urlencode ( $this->mMode ) ;
		$bits = implode ("&", array ($target, $view, $mode) ) ;
		$html = wfViewPrevNext(
				$offset,
				$limit,
				$wgContLang->specialpage( 'Multiwikiedit' ),
				$bits,
				($this->numResults - $offset) <= $limit
				);
		$wgOut->addHTML( '<p>' . $html . '</p>' );
	}

	/* produce line for wiki listing */
	function produceLine ($row) {
		global $wgLang, $wgOut, $wgRequest, $wgUser ;
		$sk = $wgUser->getSkin () ;
		$meta = strtr ($row ["title"],' ','_') ;
		$page = Title::makeTitle ($row ["namespace"], $row ["title"]) ;
		$link = $this->produceLink ($page, '', '', $row ["url"], $sk, $meta, $row ["namespace"], '') ;
		$wgOut->addHTML ($link) ;
	}

	function produceLink ($nt, $text = '', $query = '', $url = '', $sk, $wiki_meta, $namespace, $article_id) {
                global $wgContLang, $wgOut, $wgMetaNamespace ;
		$str = $nt->escapeLocalURL ($query) ;

		$old_str = $str ;
		$str = preg_replace ('/title=:/i', "title=ns-".$namespace.":", $str) ;
		$append = '' ;
		if ($str != $old_str) {
			$append = "&curid=".$article_id ;
		}
		$old_str = $str ;
		$str = preg_replace ('/\/:/i', "/ns-".$namespace.":", $str) ;
		if ($str != $old_str) {
			$append = "?curid=".$article_id ;
		}

		if (NS_PROJECT == $nt->getNamespace()) {
			$str = preg_replace ("/$wgMetaNamespace/", "Project", $str) ;
		}

		$part = explode ("php", $str ) ;
		if ($part[0] == $str) {
			$part = explode ("wiki/", $str ) ;
			$u = $url. "wiki/". $part[1] ;
		} else {
			$u = $url ."index.php". $part[1] ;
		}
		if ( $nt->getFragment() != '' ) {
			if( $nt->getPrefixedDbkey() == '' ) {
				$u = '';
				if ( '' == $text ) {
					$text = htmlspecialchars( $nt->getFragment() );
				}
			}
			$anchor = urlencode( Sanitizer::decodeCharReferences( str_replace( ' ', '_', $nt->getFragment() ) ) );
			$replacearray = array(
					'%3A' => ':',
					'%' => '.'
					);
			$u .= '#' . str_replace(array_keys($replacearray),array_values($replacearray),$anchor);
		}
		if ( $style == '' ) {
			$style = $sk->getInternalLinkAttributesObj( $nt, $text );
		}
		if ( $aprops !== '' ) $aprops = ' ' . $aprops;
		list( $inside, $trail ) = Linker::splitTrail( $trail );
		if ($text != '') {
			$r = "<a href=\"{$u}{$append}\"{$style}{$aprops}>{$text}</a>{$trail}";
		} else {
			$r = "<a href=\"{$u}{$append}\"{$style}{$aprops}>".urldecode($u)."</a>{$trail}";
		}
		return $r;
	}

	/* print out to confirm */
        function checkArticle ($line, $wiki, &$articles_found) {
		global $wgSharedDB, $wgUser, $wgOut ;
		$dbr =& wfGetDB (DB_SLAVE) ; 
		if ($dbr->selectDB ($wiki->city_dbname)) {
			/* get only the selected namespace, nothing more */
                        $page = Title::newFromText ($line) ;
			if (!is_object ($page) ) {
				return false ;
			}
			$namespace = $page->getNamespace () ;
			$normalised_title = str_replace( ' ', '_', $page->getText () ) ;

			$query = "SELECT page_namespace, page_title 
				  FROM `" . $wiki->city_dbname . "`.page 
				  WHERE page_title = ". $dbr->addQuotes ($normalised_title) ."
				  AND page_namespace = " . $namespace ;

			$res = $dbr->query ($query) ;    
			if ($dbr->numRows($res) > 0) { 
				while ( $row = $dbr->fetchObject($res) ) {
					/* write the article on this wiki */ 	 
					$row->rc_url = $wiki->city_url ;
					$row->rc_path = $wiki->city_path ;				
                                        array_push ($articles_found, array (
									"wikiid" => $wiki->city_id , 
									"namespace" => $row->page_namespace ,
                                                                        "title" => $row->page_title ,
									"url" => $wiki->city_url ,
									"path" => $wiki->city_path
								)) ;
				}

				$dbr->freeResult ($res) ;
				return true ;
			} else { /* also edit nonexisting articles */				                        	          	
                                array_push ($articles_found, array (
								"wikiid" => $wiki->city_id , 
								"namespace" => "$namespace" ,
								"title" => $normalised_title ,
								"url" => $wiki->city_url ,
								"path" => $wiki->city_path
							)) ;
				$dbr->freeResult ($res) ;
				return true ;
			}
		}
	}


	/* let's run the script for every selected page */
	function doResubmit () {
		global $wgRequest, $wgOut, $IP, $wgUser ;

        	/* run the script for all selected wikis */
		$chunked_articles = array_chunk ($_SESSION ["MWE_selected_articles"], MULTIWIKIEDIT_CHUNK_SIZE) ;
		$this->splitWarning ($chunked_articles) ;

                if (isset ($_SESSION ["MWE_selected_articles"]) ) {
			$found_state = false ;
			foreach ($chunked_articles as $chunk) {
				$text = $_SESSION ["MWE_text"] ;
				$summary = $_SESSION ["MWE_summary"] ;
				$username = $_SESSION ["MWE_username"] ;

				$thisTask = new MultiWikiEditTask ;
				$thisTask->mArguments = $chunk ;
				$thisTask->mMode = "multi" ;
				$thistask->mAdmin = $wgUser->getName () ;
				$submit_id = $thisTask->submitForm () ;
				if (false !== $submit_id) {
					$wgOut->addHtml ("<br/>". wfMsg ('multiwikiedit_task_added', $submit_id). "<br/>" ) ;
				} else {
					$wgOut->addHtml ("<br/>". wfMsg ('multiwikiedit_task_error'). "<br/>" ) ;
				}
			}
		} else {
			$wgOut->addHtml ("<br/>". wfMsg ('multiwikiedit_task_none_selected'). "<br/>" ) ;
		}

		$sk = $wgUser->getSkin () ;
		$titleObj = Title::makeTitle (NS_SPECIAL, 'Multiwikiedit') ;
		$link_back = $sk->makeKnownLinkObj ($titleObj, '<b>here</b>') ;
		$wgOut->addHtml ("<br/>".wfMsg('multiwikiedit_link_back')." ".$link_back.".") ;
		/* plus supply the link to the TaskManager to see our beautiful new task */
		$titleObj = Title::makeTitle (NS_SPECIAL, 'TaskManager') ;
		$link_back = $sk->makeKnownLinkObj ($titleObj, '<b>here</b>') ;
		$wgOut->addHtml ("<br/>" .wfMsg ("multiwikiedit_task_link") ."$link_back.<br/>") ;
	}

	/* on submit */
	function doSubmit () {
		global $wgOut, $wgUser, $wgRequest, $wgLanguageCode ;
		$wgOut->setPageTitle ( wfMsg('multiwikiedit_title') ) ;
		if (!$this->mPage && !$this->mFileTemp) {
			$this->showForm (wfMsg ('multiwikiedit_no_page') ) ;
			return ;
		}
		if ($this->mRange != 'all') {
			if ($this->mPage) {
				$wgOut->setSubTitle ( wfMsg('multiwikiedit_processing') . wfMsg ('multiwikiedit_from_form') )  ;
			} else {
				$wgOut->setSubTitle ( wfMsg('multiwikiedit_processing') . wfMsg ('multiwikiedit_from_file') )  ;
			}
		} else {
			$wgOut->setSubTitle (wfMsg('multiwikiedit_choose_articles')) ;
		}		
		if ($this->mRange == 'one') {
	        	$this->multiEdit (MULTIWIKIEDIT_THIS, $this->mUser, $this->mPage, $this->mFileTemp) ;
		} else if ($this->mRange == 'all') {
	        	$this->multiEdit (MULTIWIKIEDIT_ALL, $this->mUser, $this->mPage, $this->mFileTemp) ;
		} else if ($this->mRange == 'selected') {
	        	$this->multiEdit (MULTIWIKIEDIT_SELECTED, $this->mUser, $this->mPage, $this->mFileTemp, $this->mWikiTemp) ;
		} else if (strpos ($this->mRange, 'lang:') !== false) { 
	                $lang = substr ($this->mRange, 5) ; 
	                $this->multiEdit (MULTIWIKIEDIT_ALL, $this->mUser, $this->mPage, $this->mFileTemp, '', $lang) ; 
		}
	}

        function splitWarning ($chunked_array) {
                global $wgOut ;
                $tasks = count ($chunked_array) ;
                if (1 < $tasks) {
                        $wgOut->addWikiText (wfMsg ('multiwikiedit_split_results', $tasks, MULTIWIKIEDIT_CHUNK_SIZE)) ;
                }
        }
}

?>
