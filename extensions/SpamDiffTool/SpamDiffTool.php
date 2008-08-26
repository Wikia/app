<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();
    
/**#@+
 * An extension that allows users to rate articles. 
 * 
 * @addtogroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/SpamDiffTool_Extension Documentation
 *
 *
 * @author Travis Derouin <travis@wikihow.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionFunctions[] = 'wfSpamDiffTool';
$wgSpamBlacklistArticle = "Project:Spam-Blacklist";

require_once("SpecialPage.php");

$wgExtensionCredits['other'][] = array(
	'name' => 'SpamDiffTool',
	'author' => 'Travis Derouin',
	'description' => 'Provides a basic way of adding new entries to the Spam Blacklist from diff pages',
	'descriptionmsg' => 'spamdifftool-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:SpamDiffTool',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['SpamDiffTool'] = $dir . 'SpamDiffTool.i18n.php';

function wfSpamDiffTool() {
	SpecialPage::AddPage(new UnlistedSpecialPage('SpamDiffTool'));
	wfLoadExtensionMessages( 'SpamDiffTool' );
}

function wfSpamDiffLink($title) {
	global $wgUser, $wgRequest, $wgSpamBlacklistArticle;
	$sk = $wgUser->getSkin();
	$sb = Title::newFromDBKey($wgSpamBlacklistArticle);
	if (!$sb->userCan( 'edit' )) {
		return '';
	}
	$link = '[' . $sk->makeKnownLinkObj( Title::newFromText("SpamDiffTool", NS_SPECIAL), wfMsg('spamdifftool_spam_link_text'),
                'target=' . $title->getPrefixedURL().
                '&oldid2=' . $wgRequest->getVal('oldid') .
                '&rcid='. $wgRequest->getVal('rcid') .
                '&diff2='. $wgRequest->getVal('diff')  .
                '&returnto=' . urlencode($_SERVER['QUERY_STRING'])
                ) .
                ']';

	return $link;
}

function wfSpecialSpamDiffTool() {
	global $wgRequest, $wgContLang, $wgOut, $wgSpamBlacklistArticle, $wgUser, $wgScript;
		$title = Title::newFromDBKey($wgRequest->getVal('target'));
        $diff = $wgRequest->getVal( 'diff2' );
        $rcid = $wgRequest->getVal( 'rcid' );
        $rdfrom = $wgRequest->getVal( 'rdfrom' );


		// can the user even edit this?
		$sb = Title::newFromDBKey($wgSpamBlacklistArticle);
		if (!$sb->userCan( 'edit' )) {
			$wgOut->addHTML(wfMsg('spamdifftool_cantedit'));
			return;
		}
		// do the processing
		if ($wgRequest->wasPosted() ) {

			if ($wgRequest->getVal('confirm', null) != null) {
				$t = Title::newFromDBKey($wgSpamBlacklistArticle);
				$a = new Article(&$t);
				$text = "";
				$insert = true;
				// make sure this page exists
				if ($t->getArticleID() > 0) {
					$text = $a->getContent();
					$insert = false;
				}

				// insert the before the <pre> at the bottom  if there is one
				$i = strrpos($text, "</pre>");
				if ($i !== false) {
					$text = substr($text, 0, $i)
							. $wgRequest->getVal('newurls')
							. "\n" . substr($text, $i);	
				} else {  
					$text .= "\n" . $wgRequest->getVal('newurls');
				} 
			    $watch = false;
    			if ($wgUser->getID() > 0) 
       			$watch = $wgUser->isWatched($t);
				if ($insert) {
					$a->insertNewArticle($text, wfMsg('spamdifftool_summary'), false, $watch);
				} else {
//print_r($a); exit;
					$a->updateArticle($text, wfMsg('spamdifftool_summary'), false, $watch) ;
				}
				$returnto = $wgRequest->getVal('returnto', null);
				if ($returnto != null && $returnto != '') 	
					$wgOut->redirect($wgScript . "?" . urldecode($returnto) ); // clear the redirect set by updateArticle
				return;
			}
			$vals = $wgRequest->getValues();
			$text = ''; 
			foreach ($vals as $key=>$value) {
				if (strpos($key, "http://") === 0) {
					$url = str_replace("%2E", ".", $key);
					if ($value == 'none') continue;
					switch ($value) {
						case 'domain':
							$url = str_replace("http://", "", $url);
							$url = preg_replace("/(.*[^\/])*\/.*/", "$1", $url); // trim everything after the slash
							$k = split('\.', $url);
							$url = $k[sizeof($k) - 2] . "." . $k[sizeof($k) - 1];
							$url = str_replace(".", "\.", $url); // escape the periods
							break;
						case 'subdomain':
							$url = str_replace("http://", "", $url);
							$url = str_replace(".", "\.", $url); // escape the periods
							$url = preg_replace("/^([^\/]*)\/.*/", "$1", $url); // trim everything after the slash
							break;
						case 'dir':
							$url = str_replace("http://", "", $url);
							$url = str_replace(".", "\.", $url); // escape the periods
							$url = str_replace("/", "\/", $url); // escape the slashes
							break;	
					}
					$text .= "$url\n";
				}
			}
			if (trim($text) == '') {
				$wgOut->addHTML( wfMsg('spamdifftool_notext', $wgScript . "?" . urldecode($wgRequest->getVal('returnto') )));
				return;		
			}
			$wgOut->addHTML("<form method=POST>
					<input type='hidden' name='confirm' value='true'>
					<input type='hidden' name='newurls' value=\"" . htmlspecialchars($text) . "\">
					<input type='hidden' name='returnto' value=\"" . htmlspecialchars($wgRequest->getVal('returnto')) . "\">
				");
			$wgOut->addHTML(wfMsg('spamdifftool_confirm', 'http://www.mediawiki.org/w/index.php?title=Extension_talk:SpamDiffTool&action=edit&section=new') . "<pre>$text</pre>");
			$wgOut->addHTML("</table><input type=submit value=\"" . htmlspecialchars(wfMsg('spamdifftool_submit_buttom')) . "\"></form>");
			return;
		}
        if ( !is_null( $diff ) ) {
            require_once( 'DifferenceEngine.php' );
			
	        # Get the last edit not by this guy
			$current = Revision::newFromTitle( $title );
 			$dbw =& wfGetDB( DB_MASTER );
	        $user = intval( $current->getUser() );
	        $user_text = $dbw->addQuotes( $current->getUserText() );
	        $s = $dbw->selectRow( 'revision',
	            //array( 'min(rev_id)', 'rev_timestamp' ),
	            array( 'min(rev_id) as rev_id'),
	            array(
	                'rev_page' => $current->getPage(),
	                "rev_user <> {$user} OR rev_user_text <> {$user_text}",
					$diff != "" ? "rev_id <  $diff" : " 1= 1", // sure - why not!
	            ), $fname,
	            array(
	                'USE INDEX' => 'page_timestamp',
                	'ORDER BY'  => 'rev_timestamp DESC' )
           );
			if ($s) {
				// set oldid
				$oldid = $s->rev_id;
			}

			// new diff object to extract the revision texts
			if ($rcid != "") {
            	$de = new DifferenceEngine( $title, $oldid, $diff, $rcid );
			} else {
            	$de = new DifferenceEngine( $title, $oldid, $diff);
			}
	
			$de->loadText();
			$otext = $de->mOldtext;
			$ntext = $de->mNewtext;
        	$ota = explode( "\n", $wgContLang->segmentForDiff( $otext ) );
        	$nta = explode( "\n", $wgContLang->segmentForDiff( $ntext ) );
        	$diffs = new Diff( $ota, $nta );

			// iterate over the edits and get all of the changed text
       	    foreach ($diffs->edits as $edit) {
            	if ($edit->type != 'copy') {
					$text .= implode("\n", $edit->closing) . "\n";
				}
			}
		} else {
			$a = new Article($title);
			$text = $a->getContent(true);
		}	

//header("Content-type: text/plain;");
$matches = array();
$preg = "/http:\/\/[^] \n'\"]*/";
preg_match_all($preg, $text, $matches);
//exit;
			if (sizeof($matches[0]) == 0) {
				$wgOut->addHTML( wfMsg('spamdifftool_no_urls_detected', $wgScript . "?" . urldecode($wgRequest->getVal('returnto') )));
				return;
			}
			$wgOut->addHTML("
		<form method='POST'>
					<input type='hidden' name='returnto' value=\"" . htmlspecialchars($wgRequest->getVal('returnto')) . "\">
				<style type='text/css'>
						td.spam-url-row {
							border: 1px solid #ccc; 
						}
				</style> " . wfMsg('spamdifftool_urls_detected') . "
			<br /><br /><table cellpadding='5px' width='100%'>");
		
			$urls = array();	
			foreach ($matches as $match) {
				foreach ($match as $url) {
					if (isset($urls[$url])) continue; // avoid dupes
					$urls[$url] = true;
					$name = htmlspecialchars(str_replace(".", "%2E", $url));
					$wgOut->addHTML("<tr>
						<td class='spam-url-row'><b>$url</b><br />
						" . wfMsg('spamdifftool_block') . " &nbsp;&nbsp;
						<INPUT type='radio' name=\"" . $name . "\"	value='domain' checked> " . wfMsg('spamdifftool_option_domain') . "
						<INPUT type='radio' name=\"" . $name . "\"	value='subdomain'> " . wfMsg('spamdifftool_option_subdomain') . " 
						<INPUT type='radio' name=\"" . $name . "\"	value='dir'>" . wfMsg('spamdifftool_option_directory') . " 
						<INPUT type='radio' name=\"" . $name . "\"	value='none'>" . wfMsg('spamdifftool_option_none') . " 
					</td>
					</tr>	
					");
				}
			}
			$wgOut->addHTML("</table><input type=submit value=\"" . htmlspecialchars(wfMsg('spamdifftool_submit_buttom')) . "\"></form>");
            // DifferenceEngine directly fetched the revision:
            $RevIdFetched = $de->mNewid;
            //$de->showDiffPage();
}


