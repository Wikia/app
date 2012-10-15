<?php

/*
	A special page to delete a batch of pages - scary!
*/
if(!defined('MEDIAWIKI'))
   die();

$wgAvailableRights[] = 'deletebatch';
$wgGroupPermissions['staff']['deletebatch'] = true;

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['deletebatch'] = $dir.'SpecialDeleteBatch.i18n.php';

$wgExtensionCredits['specialpage'][] = array(
   'name' => 'Delete Batch',
   'author' => 'Bartek',
   'description' => 'deletes a batch of pages'
);

require_once($IP . '/includes/SpecialPage.php');
$wgSpecialPages['Deletebatch'] = 'Deletebatch';

class Deletebatch extends SpecialPage{

	public function Deletebatch(){
		SpecialPage::SpecialPage('Deletebatch');
	}

	function execute(){
		global $wgOut, $wgUser, $wgRequest ;

		if( !$wgUser->isAllowed( 'deletebatch' ) ) {
			throw new PermissionsError( 'deletebatch' );
		}

		$wgOut->setPageTitle (wfMsg('deletebatch_title'));
		$cSF = new DeleteBatchForm () ;

		$action = $wgRequest->getVal ('action') ;
		if ('success' == $action) {
			/* do something */
		} else if ( $wgRequest->wasPosted() && 'submit' == $action &&
				$wgUser->matchEditToken( $wgRequest->getVal ('wpEditToken') ) ) {
				$cSF->doSubmit () ;
		} else {
			$cSF->showForm ('') ;
		}
	} // end execute()

} // end class Deletebatch


/* the form for blocking names and addresses */
class DeleteBatchForm {
	var $mUser, $mPage, $mFile, $mFileTemp;

	/* constructor */
	function deletebatchForm () {
		global $wgRequest ;
		$this->mMode = $wgRequest->getVal( 'wpMode' ) ;
		$this->mPage = $wgRequest->getVal( 'wpPage' ) ;
		$this->mReason = $wgRequest->getVal( 'wpReason' ) ;
		$this->mFile = $wgRequest->getFileName( 'wpFile' ) ;
		$this->mFileTemp = $wgRequest->getFileTempName( 'wpFile' );
	}

	/* output */
	function showForm ($err = '') {
		global $wgOut, $wgUser, $wgRequest ;

		$token = htmlspecialchars( $wgUser->getEditToken() );
		$titleObj = Title::makeTitle( NS_SPECIAL, 'deletebatch' );
		$action = $titleObj->escapeLocalURL( "action=submit" ) ;

                if ( "" != $err ) {
                        $wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
                        $wgOut->addHTML( "<p class='error'>{$err}</p>\n" );
                }

		$wgOut->addWikiMsg( 'deletebatch_help' );

		/* don't bother writing up former parameters if not error */
		if ( ('submit' == $wgRequest->getVal( 'action' )) && ('' != $err) ) {
			 $scPage = htmlspecialchars ($this->mPage) ;
			 $scReason = htmlspecialchars ($this->mReason) ;
			 $scFile = htmlspecialchars ($this->mFile) ;
		} else {
			$scPage = '' ;
			$scReason = '' ;
			$scFile = '' ;
		}

   		$wgOut->addHtml("
<form name=\"deletebatch\" enctype=\"multipart/form-data\" method=\"post\" action=\"{$action}\">
	<table border=\"0\">
		<tr>
                        <td align=\"right\">".wfMsg('deletebatch_as')." :</td>
                        <td align=\"left\">") ;
                $this->makeSelect (
                                        'wpMode',
                                        array (
                                                wfMsg ('deletebatch_select_script') => 'script',
                                                wfMsg ('deletebatch_select_yourself') => 'you'
                                        ),
                                        $this->mMode,
                                        1
                                        ) ;
                $wgOut->addHtml("</td>
                </tr>
		<tr>
			<td align=\"right\" style=\"vertical-align:top\">".wfMsg('deletebatch_page')." :</td>
			<td align=\"left\">
				<textarea tabindex=\"3\" name=\"wpPage\" id=\"wpPage\" cols=\"40\" rows=\"10\"></textarea>
			</td>
		</tr>
		<tr>
			<td align=\"right\">".wfMsg('deletebatch_or')."&#160;</td>
			<td align=\"left\">
				&#160;
			</td>
		</tr>
		<tr>
			<td align=\"right\">".wfMsg('deletebatch_caption')." :</td>
			<td align=\"left\">
				<input type=\"file\" tabindex=\"4\" name=\"wpFile\" id=\"wpFile\" value=\"{$scFile}\" />
			</td>
		</tr>
		<tr>
			<td align=\"right\">&#160;</td>
			<td align=\"left\">
				<input tabindex=\"5\" name=\"wpdeletebatchSubmit\" type=\"submit\" value=\"".wfMsg('deletebatch_button')."\" />
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

	/* wraps up multi deletes */
	function deleteBatch ($user = false, $line = '', $filename = null ) {
		global $wgUser, $wgOut ;

		/* first, check the file if given */
		if ($filename) {
			/* both a file and a given page? not too much? */
			if ("" != $this->mPage) {
				$this->showForm (wfMsg('deletebatch_both_modes')) ;
				return ;
			}
			if ("text/plain" != mime_content_type($filename)) {
				$this->showForm ("The file should be plain text") ;
				return ;
			}
			$file = fopen ($filename,'r');
				if ( !$file ) {
			        $this->showForm ("Unable to read given file") ;
		        	return ;
			}
		}
		/* switch user if necessary */
		if ('script' == $this->mMode) {
			$username = 'delete page script' ;
			$OldUser = $wgUser ;
			$wgUser = User::newFromName ($username) ;
			/* Create the user if necessary */
                        if ( !$wgUser->getID() ) {
                                $wgUser->addToDatabase();
                        }
		}

		/* todo run tests - run many tests */
		$dbw =& wfGetDB( DB_MASTER );
                if ($filename) { /* if from filename, delete from filename */
			for ( $linenum = 1; !feof( $file ); $linenum++ ) {
        			$line = trim( fgets( $file ) );
        			if ( $line == false ) {
                			break;
				}
				/* explode and give me a reason
				   the file should contain only "page title|reason"\n lines
				   the rest is trash
				*/
				$arr = explode ("|",$line) ;
				is_null($arr[1]) ? $reason = '' : $reason = $arr[1] ;
				$this->deletePage ($arr[0], $reason, $dbw, true, $linenum) ;
        		}
//			$this->showForm ('') ;
		} else {
                	/* run through text and do all like it should be */
			$lines = explode( "\n", $line );
			foreach ($lines as $single_page) {
				/* explode and give me a reason */
				$page_data = explode ("|", trim ($single_page) ) ;
				if (count($page_data) < 2)
					$page_data[1] = '' ;
				$result = $this->deletePage ($page_data[0], $page_data[1], $dbw, false, 0, $OldUser) ;
			}
		}

		/* restore user back */
		if ('script' == $this->wpMode) {
			$wgUser = $OldUser ;
		}

		$sk = RequestContext::getMain()->getSkin();
		$titleObj = Title::makeTitle( NS_SPECIAL, 'Deletebatch' );
		$link_back = $sk->makeKnownLinkObj ($titleObj, '<b>here</b>') ;
		$wgOut->addHtml ("<br/>".wfMsg('deletebatch_link_back')." ".$link_back.".") ;
	}

	/* performs a single delete

		@$mode String - singular/multi
		@$linennum Integer - mostly for informational reasons
 */
	function deletePage ($line, $reason, &$db, $multi = false, $linenum = 0, $user = null) {
		global $wgOut, $wgUser ;
		$page = Title::newFromText ($line);
        	if (is_null($page)) { /* invalid title? */
		       	$wgOut->addWikiMsg( 'deletebatch_omitting_invalid', $line );
			if (!$multi) {
				if (!is_null($user)) {
					$wgUser = $user ;
				}
			}
			return false;
		}
        	if (!$page->exists()) { /* no such page? */
                        $wgOut->addWikiMsg( 'deletebatch_omitting_nonexistant', $line );
			if (!$multi) {
				if (!is_null($user)) {
					$wgUser = $user ;
				}
			}
			return false ;
		}

		$db->begin ();
		if( NS_MEDIA == $page->getNamespace () ) {
			$page = Title::makeTitle (NS_IMAGE, $page->getDBkey ());
		}

		/* this stuff goes like Article::newFromTitle() */
		if( $page->getNamespace () == NS_IMAGE ) {
			$art = new ImagePage ($page);
		} else {
			$art = new Article ($page);
		}

		/* 	what is the generic reason for page deletion?
			something about the content, I guess...
		*/
		$art->doDelete ($reason);
		$db->immediateCommit();

		return true ;
	}

	/* on submit */
	function doSubmit () {
		global $wgOut, $wgUser, $wgRequest, $wgLanguageCode ;
		$wgOut->setPageTitle ( wfMsg('deletebatch_title') ) ;
		if (!$this->mPage && !$this->mFileTemp) {
			$this->showForm (wfMsg ('deletebatch_no_page') ) ;
			return ;
		}
		if ($this->mPage) {
			$wgOut->setSubTitle ( wfMsg('deletebatch_processing') . wfMsg ('deletebatch_from_form') )  ;
		} else {
			$wgOut->setSubTitle ( wfMsg('deletebatch_processing') . wfMsg ('deletebatch_from_file') )  ;
		}
        	$this->deleteBatch ($this->mUser, $this->mPage, $this->mFileTemp) ;
	}
}

