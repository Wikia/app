<?php

/*
	A special page to delete a batch of pages
*/
if(!defined('MEDIAWIKI'))
   die();

define ("MULTIDELETE_THIS", 0) ;
define ("MULTIDELETE_ALL", 1) ;
define ("MULTIDELETE_SELECTED", 2) ;
define ("MULTIDELETE_CHUNK_SIZE", 250) ;

$wgAvailableRights[] = 'multidelete';
$wgGroupPermissions['staff']['multidelete'] = true;

$dir = dirname(__FILE__);
$wgExtensionMessagesFiles ['MultiDelete'] = $dir . '/MultiDelete.i18n.php';

$wgExtensionFunctions[] = 'wfMultiDeleteSetup';
$wgExtensionCredits['specialpage'][] = array(
   'name' => 'Multi Delete',
   'author' => 'Bartek Łapiński',
   'version' => '2.11' ,
   'description' => 'deletes a batch of pages or a page on multiple wikis'
);

/* special page init */
function wfMultiDeleteSetup() {
	global $IP;
	require_once($IP. '/includes/SpecialPage.php');
	SpecialPage::addPage(new SpecialPage('Multidelete', 'multidelete', true, 'wfMultiDeleteSpecial', false));
}

/* the core */
function wfMultiDeleteSpecial( $par ) {
	global $wgOut, $wgUser, $wgRequest ;
	wfLoadExtensionMessages ('MultiDelete') ;
   	$wgOut->setPageTitle (wfMsg('multidelete_title'));
	$cSF = new MultiDeleteForm ($par) ;

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
class MultiDeleteForm {
	var $mMode, $mUser, $mPage, $mReason, $mFile, $mWikiList, $mFileTemp, $mRange ;

	/* constructor */
	function multideleteForm ( $par ) {
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
	}

	/* output */
	function showForm ($err = '') {
		global $wgOut, $wgUser, $wgRequest ;
	
		$token = htmlspecialchars( $wgUser->editToken() );
		$titleObj = Title::makeTitle( NS_SPECIAL, 'multidelete' );
		$action = $titleObj->escapeLocalURL( "action=submit" ) ;

                if ( "" != $err ) {
                        $wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
                        $wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
                }
	
		$wgOut->addWikiText (wfMsg('multidelete_help')) ;

		if ( ('submit' == $wgRequest->getVal( 'action' )) && ('' != $err) ) {
			 $scPage = htmlspecialchars ($this->mPage) ;
			 $scMode = $this->mMode ;
			 $scRange = $this->mRange ;
			 $scReason = htmlspecialchars ($this->mReason) ;
			 $scFile = htmlspecialchars ($this->mFile) ;
			 $scWikiList = htmlspecialchars ($this->mWikiList) ;

			 $scWikiInbox = htmlspecialchars ($this->mWikiInbox) ;
		} else {
			$scPage = '' ;
			$scMode = '' ;
			$scRange = '' ;
			$scReason = '' ;
			$scFile = '' ;
			$scWikiList = '';
			$scWikiInbox = '';
		}

   		$wgOut->addHtml("
<form name=\"multidelete\" enctype=\"multipart/form-data\" method=\"post\" action=\"{$action}\">
	<table border=\"0\">
		<tr>
                        <td align=\"right\">".wfMsg('multidelete_as')." :</td>
                        <td align=\"left\">") ;
                $this->makeSelect (
                                        'wpMode',
                                        array (
                                                wfMsg ('multidelete_select_script') => 'script',
                                                wfMsg ('multidelete_select_yourself') => 'you'
                                        ),
                                        $scMode,
                                        1
                                        ) ;
		$wgOut->addHtml("</td></tr>") ;			
		$wgOut->addHtml("<tr>
                        <td align=\"right\">".wfMsg('multidelete_on')." :</td>
                        <td align=\"left\">		
		") ;					
                $this->makeSelect (
                                        'wpRange',
                                        array (
                                                wfMsg ('multidelete_this_wiki') => 'one',
                                                wfMsg ('multidelete_all_wikis') => 'all' ,
						wfMsg ('multidelete_selected_wikis') => 'selected' ,
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
                                        $scRange,
                                        1
                                        ) ;

		/* if mode is selected, _show_ those hidden thingies... */
		$this->mRange == 'selected' ? $display_hidden = '' : $display_hidden = 'display: none;' ;
                $wgOut->addHtml("</td>
                </tr>") ;

		$wgOut->addHTML ("
		<tr id=\"wikiinbox\" style=\"vertical-align:top; $display_hidden\" >
			<td align=\"right\">".wfMsg('multidelete_inbox_caption')." :</td>
			<td align=\"left\">
				<textarea tabindex=\"3\" name=\"wpWikiInbox\" id=\"wpWikiInbox\" cols=\"40\" rows=\"2\" />$scWikiInbox</textarea>
			</td>
		</tr>
		<tr>
			<td align=\"right\" style=\"vertical-align:top\">".wfMsg('multidelete_page')." :</td>
			<td align=\"left\">
				<textarea tabindex=\"4\" name=\"wpPage\" id=\"wpPage\" cols=\"40\" rows=\"10\">$scPage</textarea>
			</td>
		</tr>") ;

		$wgOut->addHTML("
		<tr>
			<td align=\"right\">&#160;</td>
			<td align=\"left\">
				<input tabindex=\"5\" name=\"wpmultideleteSubmit\" type=\"submit\" value=\"".wfMsg('multidelete_button')."\" />
			</td>
		</tr>
	</table>
	<input type='hidden' name='wpEditToken' value=\"{$token}\" />
</form>");

		$wgOut->addScript("
			<script type=\"text/javascript\">
				function MultiDeleteEnhanceControls () {
					var rangeControl = document.getElementById ('wpRange') ;
					var selectedInbox = document.getElementById ('wikiinbox') ;

					if ((rangeControl.options[rangeControl.selectedIndex].value) == 'selected') {
						selectedInbox.style.display = '' ;
					}

					var PreferencesSave = document.getElementById ('wpSaveprefs') ;
					rangeControl.onchange = function () {
						if ((this.options[this.selectedIndex].value) == 'selected') {
							selectedInbox.style.display = '' ;
						} else {
							selectedInbox.style.display = 'none' ;
						}
					}
				}
	       		 	addOnloadHook (MultiDeleteEnhanceControls) ;
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

	/* wraps up multi deletes */
	function multiDelete ($mode = MULTIDELETE_THIS, $user = false, $line = '', $filename = null, $filename2 = null, $lang = '') {
		global $wgUser, $wgOut ;

		/* todo all messages should really be as _messages_ , not plain texts */

		/* first, check the file if given */
		if ($filename) {
			if ("" != $this->mPage) {
				$this->showForm (wfMsg('multidelete_both_modes')) ;
				return ;
			}
			$magic=& wfGetMimeMagic() ;
			$mime= $magic->guessMimeType ($filename,false) ;

			if ("text/plain" != $mime) {
				$this->showForm ("The file should be plain text") ;
				return ;
			}
			$file = fopen ($filename,'r');
				if ( !$file ) {
			        $this->showForm ("Unable to read given file") ;
		        	return ;
			}
		}

		if ($mode == MULTIDELETE_SELECTED) {
			if (!$filename2 && ("" == $this->mWikiInbox)) {
				$this->showForm ("Please supply the list of selected wikis") ;
				return ;
			}
			if ($filename2) {
				if  ("" != $this->mWikiInbox) {
					$this->showForm ("Please choose either a list of wikis from file or a list from input box") ;
					return ;
				}
				$magic2=& wfGetMimeMagic() ;
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
			$username = 'delete page script' ;			
		} else {
			$username = $wgUser->getName () ;
		}

		/* get wiki array */
		if ($mode == MULTIDELETE_ALL) {
	                $wikis = $this->fetchWikis ($lang) ;
		}  else if ($mode == MULTIDELETE_SELECTED) {
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
		}  else if ($mode == MULTIDELETE_THIS) {
			global $wgCityId ;
			$wikis = $this->fetchThisWiki ($wgCityId) ;
			$found_articles = array () ;
		}
		
		/* if not, either don't specify or overwrite with given arguments */

		$dbw =& wfGetDB( DB_MASTER );
                if ($filename) {
			/*	do not allow to delete more than one page cross-wiki style here
				excess chaos is not a good thing			
			*/
			if ($mode != MULTIDELETE_THIS) {
			        $this->showForm ("Only one title at a time allowed for multi-wiki deletion. Please use the input box instead.") ;
		        	return ;								
			}
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
			$chunked_articles = array_chunk ($found_articles, MULTIDELETE_CHUNK_SIZE) ;
			$this->splitWarning ($chunked_articles) ;	

			//add the task
			if (isset ($_SESSION ["MD_selected_articles"]) ) {
				foreach ($chunked_articles as $chunk) {
					$this->limitResult ($chunk, $username, $this->mView, $this->mMode, true) ;
					$thisTask = new MultiDeleteTask (true) ;
					$thisTask->mArguments = $chunk ;	
					$thistask->mAdmin = $wgUser->getName () ;				
					$submit_id = $thisTask->submitForm () ;
					if (false !== $submit_id) {
						$wgOut->addHtml ("<br/>". wfMsg ('multidelete_task_added', $submit_id). "<br/>" ) ;
					} else {
						$wgOut->addHtml ("<br/>". wfMsg ('multidelete_task_error'). "<br/>" ) ;
					}
				}
			} else {
				$wgOut->addHtml ("<br/>". wfMsg ('multidelete_task_none_selected'). "<br/>" ) ;
			}
		} else {
			$lines = explode( "\n", $line );			
			/*	don't allow to delete more than 1 title at once on multiple wikis
				since they check all pages manually anyway			
			*/
			if ( ($mode != MULTIDELETE_THIS) && (count($lines) > 1) ) {
			        $this->showForm ("Only one title at a time allowed for multi-wiki deletion.") ;
		        	return ;								
			}
			foreach ($lines as $single_page) {
				$page_data = explode ("|", trim ($single_page) ) ;
				if (count($page_data) < 2) 
					$page_data[1] = '' ;
				if ($mode == MULTIDELETE_THIS) {
					$found = $this->checkArticle ($page_data[0], $wikis[0], $found_articles) ;
        			} else { /* wipe them out, all of them */
					$titleObj = Title::makeTitle( NS_SPECIAL, 'multidelete' );
					$action = $titleObj->escapeLocalURL ("action=resubmit") ;
					$wgOut->addHTML ("<form name=\"multidelete_confirm\" method=\"post\" action=\"{$action}\">") ;
					$found_articles = array () ;
					foreach ($wikis as $wiki) {
						$found = $this->checkArticle ($page_data[0], $wiki, $found_articles) ;
					}
					$this->limitResult ($found_articles, $username, $this->mView, $this->mMode) ;
					$wgOut->addHTML ("</form>") ;
				}
			}
			/*      as Tor pointed out, it would be better to do the deletion of multiple articles on this wiki
				as a task too... after I saw an execution of 700 titles, I am inclined to agree
			 */
			if ($mode == MULTIDELETE_THIS) {
				$this->limitResult ($found_articles, $username, $this->mView, $this->mMode, true) ;
				//add the task	
				if (isset ($_SESSION ["MD_selected_articles"]) ) {
					$thisTask = new MultiDeleteTask (true) ;
					$thisTask->mMode = "single" ;
					$thisTask->mAdmin = $wgUser->getName () ;
					$thisTask->mArguments = $_SESSION ["MD_selected_articles"] ;
					$submit_id = $thisTask->submitForm () ;
					if (false !== $submit_id) {
						$wgOut->addHtml ("<br/>". wfMsg ('multidelete_task_added', $submit_id). "<br/>" ) ;
					} else {
						$wgOut->addHtml ("<br/>". wfMsg ('multidelete_task_error'). "<br/>" ) ;				
					}
				} else {
					$wgOut->addHtml ("<br/>". wfMsg ('multidelete_task_none_selected'). "<br/>" ) ;
				}			
			}
		}

		$sk = $wgUser->getSkin () ;	
		$titleObj = Title::makeTitle( NS_SPECIAL, 'Multidelete' );
		$link_back = $sk->makeKnownLinkObj ($titleObj, '<b>here</b>') ;
		$wgOut->addHtml ("<br/>".wfMsg('multidelete_link_back')." ".$link_back.".") ;
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

		/* now, renumerate array */
		$result_array = array_values ($result_array) ;

		//list( $limit, $offset ) = $wgRequest->getLimitOffset() ;
                $limit = '10000' ;
		$offset = 0 ;
		( count ($result_array) < ($limit + $offset) ) ? $range = count ($result_array) : $range = ($limit + $offset)  ;
		for ($i = $offset; $i < $range; $i++) {
			/* make output */
			if (!$silent) {
				$wgOut->addHTML ("<input type=\"checkbox\" name=\"wpArticle".$i."\" value=\"1\" checked>") ;
				$this->produceLine ($result_array[$i]) ;
				$wgOut->addHTML ("<br>") ;
			}
		}
		$_SESSION ['MD_selected_articles'] = $result_array ;
		$_SESSION ['MD_username'] = $username ;
		$_SESSION ['MD_page'] = $this->mPage ; 
		if (!$silent) {
			$wgOut->addHTML ("<input type=\"submit\" value=\"DELETE\">") ;
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

	/*      get the data for this current wiki we're on
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
				$wgContLang->specialpage( 'Multidelete' ),
				$bits,
				($this->numResults - $offset) <= $limit
				);
		$wgOut->addHTML( '<p>' . $html . '</p>' );
	}

	/* produce line for wiki listing */
	function produceLine ($row) {
		global $wgLang, $wgOut, $wgRequest, $wgUser ;
		$sk = $wgUser->getSkin () ;

		$meta = strtr ($row->rc_city_title,' ','_') ;
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
		/* doesn't seem to work now? interesting */
		if ($dbr->selectDB ($wiki->city_dbname)) {
			/* get only the selected namespace, nothing more */
			$page = Title::newFromText ($line);
			if (!is_object ($page)) {
				return false ;
			}
			$namespace = $page->getNamespace () ;
			$normalised_title = str_replace( ' ', '_', $page->getText () ) ;

			$query = "SELECT page_namespace, page_title 
				  FROM `".$wiki->city_dbname."`.page 
				  WHERE page_title = " . $dbr->addQuotes ($normalised_title) ."
				  AND page_namespace = " . $namespace ;

			$res = $dbr->query ($query) ;    

			if ($dbr->numRows($res) > 0) { 
				while ( $row = $dbr->fetchObject($res) ) {
					/* write the article on this wiki */ 	 
                                        array_push ($articles_found, array (
									"wikiid" => $wiki->city_id ,
									"namespace" => $row->page_namespace ,
									"title" => $row->page_title ,
									"url" => $wiki->city_url ,
									"path" => $wiki->city_path
								     )) ;
				}
				return true ;
			} else {
				return false ;
			}
			$dbr->freeResult ($res) ;
		}
	}

	/* let's run the script for every selected page */
	function doResubmit () {
		global $wgRequest, $wgOut, $IP, $wgUser ;
        	/* run the script for all selected wikis */
                if (isset ($_SESSION ["MD_selected_articles"]) ) {
			$chunked_articles = array_chunk ($_SESSION ['MD_selected_articles'], MULTIDELETE_CHUNK_SIZE) ;
			$this->splitWarning ($chunked_articles) ;	
			foreach ($chunked_articles as $chunk) {
				$thisTask = new MultiDeleteTask ;				
				$thisTask->mArguments = $chunk ;
				$thisTask->mMode = "multi" ;
				$thistask->mAdmin = $wgUser->getName () ;
				$submit_id = $thisTask->submitForm () ;
				if (false !== $submit_id) {
					$wgOut->addHtml ("<br/>". wfMsg ('multidelete_task_added', $submit_id). "<br/>" ) ;
				} else {
					$wgOut->addHtml ("<br/>". wfMsg ('multidelete_task_error'). "<br/>" ) ;				
				}
			}
		} else {
			$wgOut->addHtml ("<br/>". wfMsg ('multidelete_task_none_selected'). "<br/>" ) ;
		}

		$sk = $wgUser->getSkin () ;	
		$titleObj = Title::makeTitle (NS_SPECIAL, 'Multidelete') ;
		$link_back = $sk->makeKnownLinkObj ($titleObj, '<b>here</b>') ;
		$wgOut->addHtml ("<br/>".wfMsg('multidelete_link_back')." ".$link_back.".") ;			
		/* plus supply the link to the TaskManager to see our beautiful new task */
		$titleObj = Title::makeTitle (NS_SPECIAL, 'TaskManager') ;
		$link_back = $sk->makeKnownLinkObj ($titleObj, '<b>here</b>') ;
		$wgOut->addHtml ("<br/>" .wfMsg ("multidelete_task_link") ."$link_back.<br/>") ;
	}

	/* on submit */
	function doSubmit () {
		global $wgOut, $wgUser, $wgRequest, $wgLanguageCode ;
		$wgOut->setPageTitle ( wfMsg('multidelete_title') ) ;
		if (!$this->mPage && !$this->mFileTemp) {
			$this->showForm (wfMsg ('multidelete_no_page') ) ;
			return ;
		}
		if ($this->mRange != 'all') {
			if ($this->mPage) {
				$wgOut->setSubTitle ( wfMsg('multidelete_processing') . wfMsg ('multidelete_from_form') )  ;
			} else {
				$wgOut->setSubTitle ( wfMsg('multidelete_processing') . wfMsg ('multidelete_from_file') )  ;
			}
		} else {
			$wgOut->setSubTitle (wfMsg('multidelete_choose_articles')) ;
		}		
		if ($this->mRange == 'one') {
	        	$this->multiDelete (MULTIDELETE_THIS, $this->mUser, $this->mPage, $this->mFileTemp) ;
		} else if ($this->mRange == 'all') {
	        	$this->multiDelete (MULTIDELETE_ALL, $this->mUser, $this->mPage, $this->mFileTemp) ;
		} else if ($this->mRange == 'selected') {
	        	$this->multiDelete (MULTIDELETE_SELECTED, $this->mUser, $this->mPage, $this->mFileTemp, $this->mWikiTemp) ;
		} else if (strpos ($this->mRange, 'lang:') !== false) {
			$lang = substr ($this->mRange, 5) ;
			$this->multiDelete (MULTIDELETE_ALL, $this->mUser, $this->mPage, $this->mFileTemp, '', $lang) ;
		}
	}

	function splitWarning ($chunked_array) {
		global $wgOut ;
		$tasks = count ($chunked_array) ;
		if (1 < $tasks) {
			$wgOut->addWikiText (wfMsg ('multidelete_split_results', $tasks, MULTIDELETE_CHUNK_SIZE)) ;
		}
	}
}



?>
