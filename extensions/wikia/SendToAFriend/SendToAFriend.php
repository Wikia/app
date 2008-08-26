<?php
if (!defined('MEDIAWIKI')) die();
/**
 * Displays various types of "invite a friend" form
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @author Tomasz Klim <tomek@wikia.com>
 * @author Maciej B³aszkowski (Marooned) <marooned@wikia.com> [new way for registering SpecialPage]
 * @copyright Copyright (C) 2007 Tomasz Klim, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
create table send_stats (
	send_id int not null auto_increment primary key,
	send_page_id int not null,
	send_page_ns int not null,
	send_page_re int not null,
	send_unique int not null,
	send_tm timestamp default now(),
	send_ip varchar(16) not null,
	send_to mediumtext not null,
	send_from varchar(255) not null,
	send_name varchar(255) not null,
	send_user varchar(255) not null,
	send_ajax int not null,
	send_seen int not null default 0
);
create table send_queue (
	que_id int not null auto_increment primary key,
	que_tm timestamp default now(),
	que_ip varchar(16) not null,
	que_to mediumtext not null,
	que_from varchar(255) not null,
	que_name varchar(255) not null,
	que_user varchar(255) not null,
	que_subject varchar(255) not null,
	que_body mediumtext not null,
	que_sent int not null default 0
);
 *
LocalSettings.php:
+ $wgNotificationEmails = 20;
+ $wgNotificationThrottle = 20;
+ $wgNotificationDisplayedContacts = 50;
+ $wgNotificationEnableSend = true;
+ $wgNotificationEnableInvite = true;
+ require_once( "$IP/extensions/SendToAFriend/SendToAFriend.php" );
 *
includes/SpecialUserlogin.php:
+ wfRunHooks( 'AddNewAccount2', array( $wgUser ) );
 *
 */


$wgAvailableRights[] = 'notification';
$wgGroupPermissions['*']['notification'] = true;
$wgGroupPermissions['user']['notification'] = true;

$wgExtensionMessagesFiles['SendToAFriend'] = dirname(__FILE__) . '/SendToAFriend.i18n.php';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Invite a friend',
	'description' => 'displays "invite a friend" form',
	'author' => 'Tomasz Klim'
);
$wgHooks['AddNewAccount2'][] = 'wfInviteAfterReg';
$wgExtensionCredits['other'][] = array(
	'name' => 'Invite a friend',
	'description' => 'displays "invite a friend" form after creating new user account',
	'author' => 'Tomasz Klim'
);
#$wgHooks['MonoBookTemplateToolboxEnd'][] = 'wfSendAjaxForm_echo';
$wgExtensionCredits['other'][] = array(
	'name' => 'Send to a friend',
	'description' => 'displays "send to a friend" button in the article',
	'author' => 'Tomasz Klim'
);

//Register special page
if (!function_exists('extAddSpecialPage')) {
	require("$IP/extensions/ExtensionFunctions.php");
}
extAddSpecialPage(dirname(__FILE__) . '/SendToAFriend_body.php', 'InviteSpecialPage', 'InviteSpecialPage');

function wfInviteAfterReg( $user=null ) {
	global $wgUser, $wgOut, $wgNotificationEnableInvite;
	wfLoadExtensionMessages('SendToAFriend');

	if ( is_null( $user ) ) {
		// Compatibility with old versions which didn't pass the parameter
		$user = $wgUser;
	}

	if ( $wgNotificationEnableInvite ) {
		$wgOut->addWikiText( wfMsg('stf_after_reg') );
//		$wgOut->addWikiText( wfMsg('stf_after_reg') . wfMsg('sendtoafriend_reg2') . wfMsg('sendtoafriend_reg3') . $_SERVER['SERVER_NAME'] . wfMsg('sendtoafriend_reg4') . wfMsg('sendtoafriend_reg5') );
	}
	return true;
}


// base function, returning text
function wfSendAjaxForm($sendtofriendbox=true) {
	global $wgTitle, $wgRequest, $wgNotificationEnableSend, $wgStylePath, $wgUser;
	wfLoadExtensionMessages('SendToAFriend');

	$pageId = $wgTitle->getArticleID();
	$pageNamespace = $wgTitle->getNamespace();
	$pageRevision = $wgTitle->getLatestRevID();

	if ( !$wgNotificationEnableSend || 'edit' == $wgRequest->getText( 'action' ) || $pageId == 0 || $pageNamespace == -1 ) {
		return '';
	}

	$target = Title::newFromText( 'InviteSpecialPage', NS_SPECIAL );
	$url = $target->getFullURL();

	// fix url: & -> &amp; (xHTML validation)
	$url = str_replace('&', '&amp;', $url);

	$name  = ( $wgUser->isLoggedIn() ? $wgUser->getName() : "" );
	$email = $wgUser->getEmail();
	$form1 = wfMsg('stf_frm1');
	$form2 = wfMsg('stf_frm2');
	$form3 = InviteSpecialPage::generateInviteMessage( true, false, 'I' );
	$form4 = wfMsg('stf_frm4_send');
	$form5 = wfMsg('stf_frm5');
	$form6 = wfMsg('stf_frm6');

	// macbre: fix <pre class="monotype"> line breaking (put <br /> - IE doesn't understand CRLF (?) - sic!
	/**
	$browser = function_exists( 'GetUserAgent' ) ? GetUserAgent() : array();

	if ( $browser['is_ie'] ) {
		// escape any HTML chars and add <br /> tag to every line break
		$form3 = implode( "<br />\n", explode( "\n", htmlspecialchars( $form3 ) ) );
	} else {
		// escape any HTML chars
		$form3 = htmlspecialchars( $form3 );
	}
	**/

	// escape any HTML chars and add <br /> tag to every line break
	$form3 = implode( "<br />\n", explode( "\n", htmlspecialchars( $form3 ) ) );

	$caption = wfMsg('stf_button');
	$sending = wfMsg('stf_sending');

	$msg_label   = wfMsg('stf_msg_label');
	$name_label  = wfMsg('stf_name_label');
	$email_label = wfMsg('stf_email_label');

	$multiemail = wfMsg('stf_multiemail');

	$email_sent      = wfMsg('stf_email_sent');
	$back_to_article = wfMsg('stf_back_to_article');

	$error = wfMsg('stf_error');
	$title = htmlspecialchars($wgTitle->getText());

	// macbre: browser detection
	$browser = function_exists( 'GetUserAgent' ) ? GetUserAgent() : array();

	$ret = "
<div id=\"notifyForm\" class=\"roundedDiv\">
<div class=\"moveTools\"></div>
<b class=\"xtop\"><b class=\"xb1\"></b><b class=\"xb2\"></b><b class=\"xb3\"></b><b class=\"xb4\"></b></b>
<div class=\"r_boxContent\">

<form name=\"notification\" id=\"notification\" action=\"$url\" method=\"post\" onsubmit=\"return notifySubmit();\">

<input type=\"hidden\" name=\"id\" value=\"$pageId\" />
<input type=\"hidden\" name=\"ns\" value=\"$pageNamespace\" />
<input type=\"hidden\" name=\"re\" value=\"$pageRevision\" />

<div class=\"boxHeader\">$caption</div>
<div class=\"articleName\">&quot;$title&quot;</div>

<label for=\"stoaf_emails\">$form2</label>
<textarea name=\"to\" id=\"stoaf_emails\" rows=\"2\" cols=\"15\" style=\"width: 348px\"></textarea>

<div style=\"width:165px;float:left\" id=\"stf_float_1\">
	<label for=\"stoaf_name\">$name_label</label>
	<input type=\"text\" maxlength=\"20\" id=\"stoaf_name\" name=\"name\"" . ( !empty($name) ? " value=\"".htmlspecialchars($name)."\"" : "" ) . " /></div>

<div style=\"width:15px;float:left\" id=\"stf_float_2\">&nbsp;</div>

<div style=\"width:165px;float:left\" id=\"stf_float_3\">
	<label for=\"stoaf_your_email\">$email_label</label>
	<input type=\"text\" maxlength=\"40\" id=\"stoaf_your_email\" name=\"fr\"" . ( !empty($email) ? " value=\"".htmlspecialchars($email)."\"" : "" ) . " /></div>

<div style=\"clear:both\">&nbsp;</div>
<label for=\"stoaf_msg\">$msg_label</label>
<pre id=\"stoaf_msg\" class=\"monotype\" style=\"background-color:lightgrey;color:grey;width:348px;margin:0px\">".$form3."</pre>
<div style=\"text-align:center\">
	<div id=\"stoaf_progress\" style=\"visibility: hidden\">&nbsp;</div>
	<input type=\"submit\" class=\"submit\" value=\"".wfMsg('stf_frm4_send')."\" id=\"stoaf_submit\" />
	<input type=\"button\" class=\"submit\" style=\"display:none\" onclick =\"notifyAbort()\" value=\"".wfMsg('stf_frm4_cancel')."\" id=\"stoaf_cancel\" />
</div>

</form>
<div style=\"clear: both;\"></div></div>
<b class=\"xbottom\"><b class=\"xb4\"></b><b class=\"xb3\"></b><b class=\"xb2\"></b><b class=\"xb1\"></b></b>
</div>

<div id=\"notifyReport\" class=\"roundedDiv\">
<div class=\"moveTools\"></div>
<b class=\"xtop\"><b class=\"xb1\"></b><b class=\"xb2\"></b><b class=\"xb3\"></b><b class=\"xb4\"></b></b>
<div class=\"r_boxContent\">

<div class=\"boxHeader\">$email_sent</div>
<div id=\"articlesinject\"></div>
<hr /><br />
<div class=\"articleName\"><a href=\"#\" onclick=\"return notifyReport.hide();\"><b>$back_to_article</b></a></div>

</div><b class=\"xbottom\"><b class=\"xb4\"></b><b class=\"xb3\"></b><b class=\"xb2\"></b><b class=\"xb1\"></b></b>
</div>";

	if( $sendtofriendbox ) {
		$ret .= "
<div id='sendtofriendbox' class='sectionRow'>
	<img src='{$wgStylePath}/common/sendToFriend.png' alt='->' title='{$caption}' class='iconImage' id='sendtofriendicon' />
	<a href='{$url}?id={$pageId}&amp;ns={$pageNamespace}&amp;re={$pageRevision}' onclick=\"return notifyShow();\">{$caption}</a>
</div>";
	}
	return $ret;
}


// monobook version
function wfSendAjaxForm_echo() {
	wfProfileIn( __METHOD__ );
	echo "<li>" . wfSendAjaxForm() . "</li>";
	wfProfileOut( __METHOD__ );
	return true;
}

// slate version
function wfSendAjaxForm_return( $sendtofriendbox=true ) {
	wfProfileIn( __METHOD__ );
	$ret = wfSendAjaxForm( $sendtofriendbox );
	wfProfileOut( __METHOD__ );
	return $ret;
}
?>