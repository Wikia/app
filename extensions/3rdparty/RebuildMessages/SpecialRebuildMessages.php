<?php

/*
	A special page providing means to clean up spam on this wiki, on selected wikis, or on all wikis
	( for Azraduni: it spells WIKIS )
*/
if(!defined('MEDIAWIKI'))
   die();

$wgAvailableRights[] = 'rebuildmessages';
$wgGroupPermissions['staff']['rebuildmessages'] = true;

$wgExtensionFunctions[] = 'wfRebuildMessagesSetup';
$wgExtensionCredits['specialpage'][] = array(
   'name' => 'Rebuild Messages',
   'author' => 'Bartek',
   'description' => 'rebuild or update system messages after changing the site language, this extension is a special page version of a pre-existing script'
);

/* special page init */
function wfRebuildMessagesSetup() {
	global $IP, $wgMessageCache;
	require_once($IP. '/includes/SpecialPage.php');
	require_once( $IP."/extensions/RebuildMessages/InitialiseMessages.inc" );
        /* add messages to all the translator people out there to play with */
        $wgMessageCache->addMessages(
        array(
                        'rebuildmessages_button' => 'Go' ,
			'rebuildmessages_help' => "This script is used to update the MediaWiki namespace after changing site language. You can choose either 
''update'' - Update messages to include latest additions to MessagesXX.php, or ''rebuild'' - Delete all messages and reinitialise namespace.\n\nIf a message dump file is given, messages will be read from it to supplement
the defaults in MediaWiki's Language*.php. The file should contain a serialized
PHP associative array, as produced by dumpMessages.php.\n
",
			'rebuildmessages_caption' => "Message dump file" ,
			'rebuildmessages_title' => "Rebuild Messages" ,
			'rebuildmessages_this' => "this wiki" ,
			'rebuildmessages_local' => "all local wikis" ,
			'rebuildmessages_all' => "all wikis from a shared database",
			'rebuildmessages_action' => "Options" ,
			'rebuildmessages_options' => 'Choose action',
			'rebuildmessages_success_title' => "Cleanup Spam Succedeed" ,
			'rebuildmessages_success_subtitle' => "for $1" ,
			'rebuildmessages_error_not_valid' => "Not a valid hostname specification" ,
			'rebuildmessages_error_empty' => "Please provide a file" ,
			'rebuildmessages_count_zero' => "There are no articles containing links to $1" ,
			'rebuildmessages_cleanup_finished' => "The cleanup process has finished." ,
			'rebuildmessages_processing' => "cleaning up links to $1" ,
			'rebuildmessages_link_back' => "You can go back to the extension " ,
			'rebuildmessages_none_found' => "No articles found containing links to $1." ,
			'rebuildmessages_no_local' => "There are no local wikis here. Try other modes." ,
			'rebuildmessages_update' => "running in update mode" ,
			'rebuildmessages_rebuild' => "running in rebuild mode"
                )
        );
	SpecialPage::addPage(new SpecialPage('Rebuildmessages', 'rebuildmessages', true, 'wfRebuildMessagesSpecial', false));
	$wgMessageCache->addMessages(array('rebuildmessages' => 'rebuild Messages'));
}

/* the core */
function wfRebuildMessagesSpecial( $par ) {
	global $wgOut, $wgUser, $wgRequest ;
   	$wgOut->setPageTitle (wfMsg('rebuildmessages_title'));
	$cSF = new RebuildMessagesForm ($par) ;

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
class RebuildMessagesForm {
	var $mMode, $mFile, $mFileTemp;

	/* constructor */
	function RebuildMessagesForm ( $par ) {
		global $wgRequest ;
		$this->mMode = $wgRequest->getVal( 'wpMode' ) ;
		$this->mFile = $wgRequest->getFileName( 'wpFile' ) ;
		$this->mFileTemp = $wgRequest->getFileTempName( 'wpFile' );
	}

	/* output */
	function showForm ( $err ) {
		global $wgOut, $wgUser, $wgRequest ;
	
		$token = htmlspecialchars( $wgUser->editToken() );
		$titleObj = Title::makeTitle( NS_SPECIAL, 'Rebuildmessages' );
		$action = $titleObj->escapeLocalURL( "action=submit" ) ;

                if ( "" != $err ) {
                        $wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
                        $wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
                }
	
		$wgOut->addWikiText (wfMsg('rebuildmessages_help')) ;

		( 'submit' == $wgRequest->getVal( 'action' )) ? $scLink = htmlspecialchars ($this->mLink) : $scLink = '' ;

   		$wgOut->addHtml("
<form name=\"RebuildMessages\" enctype=\"multipart/form-data\" method=\"post\" action=\"{$action}\">
	<table border=\"0\">
		<tr>
			<td align=\"right\">".wfMsg('rebuildmessages_options')." :</td>
			<td align=\"left\">") ;
		$this->makeSelect (
					'wpMode',
					array (
                 				'update' => 'update',
						'rebuild' => 'rebuild'
					),
					$this->mMode,
					1
					) ;
		$wgOut->addHtml("</td>
		</tr>
		<tr>
			<td align=\"right\">".wfMsg('rebuildmessages_caption')."</td>
			<td align=\"left\">
				<input type=\"file\" tabindex=\"3\" name=\"wpFile\" value=\"{$scLink}\" />
			</td>
		</tr>
		<tr>
			<td align=\"right\">&#160;</td>
			<td align=\"left\">
				<input tabindex=\"4\" name=\"wpRebuildMessagesSubmit\" type=\"submit\" value=\"".wfMsg('rebuildmessages_button')."\" />
			</td>
		</tr>
	</table>
	<input type='hidden' name='wpEditToken' value=\"{$token}\" />
</form>");
	}

        /* draws select and selects it properly */
        function makeSelect ($name, $options_array, $current, $tabindex) {
                global $wgOut ;
                $wgOut->addHTML ("<select tabindex=\"$tabindex\" name=\"$name\">") ;
                foreach ($options_array as $key => $value) {
                        if ($value == $current )
                                $wgOut->addHTML ("<option value=\"$value\" selected=\"selected\">$key</option>") ;
                        else
                                $wgOut->addHTML ("<option value=\"$value\">$key</option>") ;
                }
                $wgOut->addHTML ("</select>") ;
        }

        /* fetch all wikis from the database */
        function fetchWikias () {
        	global $wgMemc, $wgSharedDB ;
                /* from database */
                $dbr =& wfGetDB (DB_SLAVE);
                $query = "SELECT city_dbname, city_url, city_title FROM {$wgSharedDB}.city_list" ;
                $res = $dbr->query ($query) ;
                $wikias_array = array () ;
                while ($row = $dbr->fetchObject($res)) {
                	array_push ($wikias_array, $row ) ;
                }
                $dbr->freeResult ($res) ;
                return $wikias_array ;
        }

/* contains all functionality */
function rebuild ($mode, $file) {
	global $wgOut, $wgUser ;

	$wgTitle = Title::newFromText( "Rebuild messages script" );

	if ( '' == $file ) {
		$messages = false ;
	} else {
        	$messages = loadLanguageFile ($file);
	}

	if ('' == $mode) {
	        $dbr =& wfGetDB( DB_SLAVE );
	        $row = $dbr->selectRow( "page", array("count(*) as c"), array("page_namespace" => NS_MEDIAWIKI) );
	        $wgOut->addWikitext( "Current namespace size: {$row->c}\n");
	}

	switch ( $mode ) {
        	case 'update':
                	wfRebuildMessagesInitialiseMessages( false, $messages, false, $mode ) ;
	                break ;
        	case 'rebuild':
                	wfRebuildMessagesInitialiseMessages( true, $messages, false, $mode ) ;
	                break ;
		default:
			break ;
	}

	$sk = $wgUser->getSkin () ;
	$titleObj = Title::makeTitle( NS_SPECIAL, 'Rebuildmessages' );
	$link_back = $sk->makeKnownLinkObj ($titleObj, '<b>here</b>') ;
	$wgOut->addHtml ("<br/>".wfMsg('rebuildmessages_link_back')." ".$link_back.".") ;
	
}

	/* on success */
	function showSuccess () {
		global $wgOut, $wgRequest ;
		$wgOut->setPageTitle (wfMsg('rebuildmessages_success_title') ) ;
		$wgOut->setSubTitle(wfMsg('rebuildmessages_success_subtitle')) ;	
	}

	/* on submit */
	function doSubmit () {
		global $wgOut, $wgUser, $wgRequest, $wgLanguageCode ;
		$wgOut->setSubTitle ( wfMsg('rebuildmessages_'.$this->mMode, $wgLanguageCode) ) ;
        	$this->rebuild ($this->mMode, $this->mFileTemp) ;
	}
}

?>
