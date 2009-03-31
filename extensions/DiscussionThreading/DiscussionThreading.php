<?php
/**
 * Extension to provide discussion threading similar to a listserv archive
 *
 * @author Jack D. Pond <jack.pond@psitex.com>
 * @addtogroup Extensions
 * @copyright  2007 Jack D. pond
 * @url http://www.mediawiki.org/wiki/Manual:Extensions
 * @licence GNU General Public Licence 2.0 or later
 */

if (!defined('MEDIAWIKI')) die('Not an entry point.');

# Internationalisation file
$wgExtensionMessagesFiles['DiscussionThreading'] =  dirname(__FILE__) . '/DiscussionThreading.i18n.php';

$wgExtensionFunctions[] = 'efDiscussionThreadSetup';
$wgExtensionCredits['other'][] = array(
	'name' => 'DiscussionThreading',
	'author' => 'Jack D. Pond, Daniel Brice',
	'version' => '1.3',
	'url' => 'http://www.mediawiki.org/wiki/Extension:DiscussionThreading',
	'description' => 'Add Threading to discussion (talk) pages',
	'descriptionmsg' => 'discussionthreading-desc',
);

/**
 * Set up hooks for discussion threading
 *
 * @param $wgSectionThreadingOn global logical variable to activate threading
 */
global $wgSectionThreadingOn;
$wgSectionThreadingOn = True;

$wgHooks['EditPage::showEditForm:initial'][] =  'efDiscussionThread';
$wgHooks['EditPage::attemptSave'][] = 'efStampReply';
$wgHooks['EditPage::showEditForm:initial'][] =  'efDiscussionThreadEdit';
$wgHooks['EditSectionLinkForOther'][] =  'efDiscussionLink4other';
$wgHooks['EditSectionLink'][] =  'efDiscussionLink';
$wgHooks['AlternateEdit'][] =  'efDiscussionThreadEdit';

/**
 * Initial setup, add .i18n. messages from $IP/extensions/DiscussionThreading/DiscussionThreading.i18n.php
*/
function efDiscussionThreadSetup() {
	global $wgVersion;
	$xversion = explode(".",$wgVersion);
	if ($xversion[0] <= "1" && $xversion[1] <= "11") {
		global $wgMessageCache, $messages;
		foreach( $messages as $lang => $LangMsg )
			$wgMessageCache->addMessages( $LangMsg, $lang );
	} else wfLoadExtensionMessages( 'DiscussionThreading' );
}

/**
 * This function creates a linkobject for the editSectionLinkForOther function in linker
 *
 * @param $callobj Article object.
 * @param $title Title object.
 * @param $section Integer: section number.
 * @param $hint Link String: title, or default if omitted or empty
 * @param $url Link String: for edit url
 * @param $result String: Returns the section [new][edit][reply] html if in a talk page - otherwise whatever came in with
 * @return  true
 */
function efDiscussionLink4other ($callobj, $title, $section , $url , &$result)
{
	global $wgSectionThreadingOn;
	if($wgSectionThreadingOn && $title->isTalkPage() ) {
		$commenturl = '&section='.$section.'&replyto=yes';
		$curl = $callobj->makeKnownLinkObj( $title, wfMsg('discussionthreading-replysection'), 'action=edit'.$commenturl );
		$newthreadurl = '&section=new';
		$nurl = $callobj->makeKnownLinkObj( $nt, wfMsg('discussionthreading-threadnewsection'), 'action=edit'.$newthreadurl );
		$result =  $nurl."][".$url."][".$curl;
	}
	return (true);
}

/**
 * This function creates a linkobject for the editSectionLink function in linker
 *
 * @param $callobj Article object.
 * @param $nt Title object.
 * @param $section Integer: section number.
 * @param $hint Link String: title, or default if omitted or empty
 * @param $url Link String: for edit url
 * @param $result String: Returns the section [new][edit][reply] html  if in a talk page - otherwise whatever came in with
 * @return  true
 */
function efDiscussionLink ($callobj, $nt, $section, $hint='', $url , &$result)
{
	global $wgSectionThreadingOn;
	if($wgSectionThreadingOn && $nt->isTalkPage() ) {
		$commenturl = '&section='.$section.'&replyto=yes';
		$hint = ( $hint=='' ) ? '' : ' title="' . wfMsgHtml( 'discussionthreading-replysectionhint', htmlspecialchars( $hint ) ) . '"';
		$curl = $callobj->makeKnownLinkObj( $nt, wfMsg('discussionthreading-replysection'), 'action=edit'.$commenturl, '', '', '',  $hint );
		$newthreadurl = '&section=new';
		$hint = ( $hint=='' ) ? '' : ' title="' . wfMsgHtml( 'discussionthreading-threadnewsectionhint', htmlspecialchars( $hint ) ) . '"';
		$nurl = $callobj->makeKnownLinkObj( $nt, wfMsg('discussionthreading-threadnewsection'), 'action=edit'.$newthreadurl, '', '', '',  $hint );
		$result = $nurl."][".$url."][".$curl;
	}
	return (true);
}

/**
 * This function is a hook used to test to see if empty, if so, start a comment
 *
 * @param $efform form object.
 * @return  true
 */
function efDiscussionThreadEdit ($efform) {
	global $wgRequest,$wgSectionThreadingOn;
	$efform->replytosection = '';
	$efform->replyadded = false;
	$efform->replytosection = $wgRequest->getVal( 'replyto' );
	if( !$efform->mTitle->exists() ) {
		if($wgSectionThreadingOn && $efform->mTitle->isTalkPage() ) {
			$efform->section = 'new';
		}
	}
	return (true);
}

/**
 * Create a new header, one level below the 'replyto' header, add re: to front and tag it with user information
 *
 * @param $efform Form Object before display
 * @return  true
 */
function efDiscussionThread($efform){
	global $wgSectionThreadingOn;
	$wgSectionThreadingOn = isset($wgSectionThreadingOn) ? $wgSectionThreadingOn : false;
	if ( $efform->replytosection != '' && $wgSectionThreadingOn  && !$efform->replyadded) {
		if ($efform->replytosection != '') {
			$text = $efform->textbox1;
			$matches = array();
			preg_match( "/^(=+)(.+)\\1/mi",
				$efform->textbox1,
				$matches );
			if( !empty( $matches[2] ) ) {
				preg_match( "/.*(-+)\\1/mi",$matches[2],$matchsign);
				if (!empty($matchsign[0]) ){
					$text = $text."\n\n".$matches[1]."=Re: ".trim($matchsign[0])." ~~~~".$matches[1]."=";
				} else {
					$text = $text."\n\n".$matches[1]."=Re: ".trim($matches[2])." -- ~~~~".$matches[1]."=";
				}
			} else {
				$text = $text." -- ~~~~<br>\n\n";
			}
		   // Add an appropriate number of colons (:) to indent the body.
		   // Include replace me text, so the user knows where to reply
		   $replaceMeText = " Replace this text with your reply";
		   $text .= "\n\n".str_repeat(":",strlen($matches[1])-1).$replaceMeText;
		   // Insert javascript hook that will select the replace me text
		   global $wgOut;
		   $wgOut->addScript("<script type=\"text/javascript\">
			 function efDiscussionThread(){
			   var ctrl = document.editform.wpTextbox1;
			   if (ctrl.setSelectionRange) {
				 ctrl.focus();
				 var end = ctrl.value.length;
				 ctrl.setSelectionRange(end-".strlen($replaceMeText).",end-1);
				 ctrl.scrollTop = ctrl.scrollHeight;                               
			   } else if (ctrl.createTextRange) {
				 var range = ctrl.createTextRange();
				 range.collapse(false);
				 range.moveStart('character', -".strlen($replaceMeText).");
				 range.select();
			   }
			 }
			 addOnloadHook(efDiscussionThread);
			 </script>");
			$efform->replyadded = true;
			$efform->textbox1 = $text;
		}
		return (true);
	}
	return (true);
}

/**
 * When the new header is created from summary in new (+) add comment, just stamp the header as created
 *
 * @param $efform Form Object before display
 * @return  true
 */
function efStampReply($efform){
	global $wgSectionThreadingOn;
	$wgSectionThreadingOn = isset($wgSectionThreadingOn) ? $wgSectionThreadingOn : false;
	if ( $efform->section == "new" && $wgSectionThreadingOn  && !$efform->replyadded) {
		$efform->summary = $efform->summary." -- ~~~~";
	}
	return(true);
}
