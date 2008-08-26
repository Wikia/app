<?php
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
 */

class InviteSpecialPage extends SpecialPage {
	/**
	 * contructor
	 */
	function  __construct() {
		wfLoadExtensionMessages('SendToAFriend');
		parent::__construct('InviteSpecialPage' /*class*/);
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgTitle, $wgUser, $wgNotificationEmails, $wgNotificationDisplayedContacts;

		wfProfileIn( __METHOD__ );

		$this->setHeaders();

		if ( !isset( $wgNotificationEmails ) || !is_numeric( $wgNotificationEmails ) ) {
			$wgNotificationEmails = 20;
		}

		if ( !isset( $wgNotificationDisplayedContacts ) || !is_numeric( $wgNotificationDisplayedContacts ) ) {
			$wgNotificationDisplayedContacts = 50;
		}

		$isEncoded = ( $wgRequest->getText( 'en' ) == '' ? 0 : 1 );

		$uniqueId      = $wgRequest->getText( 'un' );
		$pageId        = $wgRequest->getText( 'id' );
		$pageNamespace = $wgRequest->getText( 'ns' );
		$pageRevision  = $wgRequest->getText( 're' );

		$notifyTo      = trim( $wgRequest->getText( 'to' ) );
		$notifyFrom    = trim( $wgRequest->getText( 'fr' ) );
		$notifyName    = trim( $wgRequest->getText( 'nm' ) );

		$username      = trim( $wgRequest->getText( 'us' ) );
		$password      = trim( $wgRequest->getText( 'pa' ) );
		$acctType      = trim( $wgRequest->getText( 'ty' ) );

		$notifyToArr = array();
		for ( $x = 1; $x <= $wgNotificationDisplayedContacts; $x++ ) {
			$tmp = trim( $wgRequest->getText( "stf_$x" ) );
			if ( $tmp != '' && strpos( $tmp, '@' ) ) {
				$notifyToArr[$x] = $tmp;
			}
		}
		if ( count( $notifyToArr ) > 0 ) {
			$notifyTo = implode( ",", $notifyToArr );
		}

		if ( $uniqueId && is_numeric($uniqueId) ) { // AJAX mode - redirect

			$this->uniqueRedirect( $uniqueId );

		} elseif ( $notifyName != '' && strpos( $notifyTo, '@' ) && strpos( $notifyFrom, '@' ) && is_numeric($pageId) && is_numeric($pageNamespace) && is_numeric($pageRevision) ) {  // user completed the form

			$uniqueId = mt_rand(0, 0x7fffffff);

			$sig = "$notifyName ($notifyFrom)";
			$msg = $this->generateInviteMessage( $isEncoded, $uniqueId, $sig );

			$dbw =& wfGetDB( DB_MASTER );
			$dbw->insert( 'send_stats',
				array(
					'send_page_id' => $pageId,
					'send_page_ns' => $pageNamespace,
					'send_page_re' => $pageRevision,
					'send_unique'  => $uniqueId,
					'send_ip'      => wfGetIP(),
					'send_to'      => $notifyTo,
					'send_from'    => $notifyFrom,
					'send_name'    => $notifyName,
					'send_user'    => $wgUser->getName(),
					'send_ajax'    => $isEncoded,
				), "wfInviteSpecialPage::execute"
			);

			$this->sendNotification( $isEncoded, $notifyTo, $notifyFrom, $notifyName, $msg );

			$this->generateContactFormFirst( $wgTitle->escapeLocalUrl(), $pageId, $pageNamespace, $pageRevision, 'stf_confirm' );

		} elseif ( $isEncoded ) {  // AJAX mode - incomplete form

			$error = wfMsg( 'stf_error' );
			$error2 = '';
			if ( $notifyName == '' ) $error2 .= "<br /><br />" . wfMsg( 'stf_error_name' );
			if ( !strpos( $notifyFrom, '@' ) ) $error2 .= "<br /><br />" . wfMsg( 'stf_error_from' );
			if ( !strpos( $notifyTo, '@' ) ) $error2 .= "<br /><br />" . wfMsg( 'stf_error_to' );
			echo "<hr /><br /><div style=\"cursor:pointer\" onclick=\"notifyBack();\"><b>$error</b>$error2<br /><br /></div>";
			wfProfileOut( __METHOD__ );
			die();

		} else {  // show the form in classic special page mode, point user to the Main Page - INVITE

			if ( !is_numeric($pageId) || !is_numeric($pageNamespace) || !is_numeric($pageRevision) ) {
				$titleObj = Title::makeTitle( 0, wfMsg('mainpage') );
				$pageId = $titleObj->getArticleID();
				$pageNamespace = $titleObj->getNamespace();
				$pageRevision = $titleObj->getLatestRevID();
				if ( !is_numeric( $pageRevision ) ) {  $pageRevision = 0;  }
			}

			// this is always current url, unlike the above, which can refer
			// to either current, or received page id/namespace/revision
			$url = $wgTitle->escapeLocalUrl();

			if ( $username && $password && $acctType ) {
				$this->generateContactFormSecond( $url, $pageId, $pageNamespace, $pageRevision, $acctType, $username, $password );
			} else {
				$this->generateContactFormFirst( $url, $pageId, $pageNamespace, $pageRevision );
			}
		}

		wfProfileOut( __METHOD__ );
	}


	function uniqueRedirect( $uniqueId ) {
		global $wgOut, $wgTitle;

		wfProfileIn( __METHOD__ );

		$dbw =& wfGetDB( DB_MASTER );
			$query = "SELECT p.page_namespace, p.page_title, s.send_page_re as page_revision
			  FROM send_stats s
			  INNER JOIN page p ON s.send_page_id = p.page_id AND s.send_page_ns = p.page_namespace
			  WHERE s.send_unique = $uniqueId
			  ORDER BY s.send_id DESC
			  LIMIT 1";
			$res = $dbw->query( $query );
		if ( $row = $dbw->fetchObject( $res ) ) {
			$target = Title::newFromText( $row->page_title, $row->page_namespace );
			$url = $target->getFullURL() . "?oldid=" . $row->page_revision;
		} else {
			$url = $wgTitle->escapeLocalUrl();
		}
			$dbw->freeResult( $res );

		$dbw->query( "UPDATE send_stats SET send_seen = send_seen + 1 WHERE send_unique = $uniqueId", "wfInviteSpecialPage::uniqueRedirect" );
		$wgOut->redirect( $url, 302 );

		wfProfileOut( __METHOD__ );
	}


	function sendNotification( $isEncoded, $notifyTo, $notifyFrom, $notifyName, $notifyBody )
	{
		global $wgOut, $wgUser, $wgMemc, $wgDBname, $wgSharedDB, $wgSitename;
		global $wgServer, $wgNotificationThrottle, $wgNotificationEmails;

		wfProfileIn( __METHOD__ );

		$ip = wfGetIP();
		if ( $wgNotificationThrottle ) {
			$key = $wgDBname.':notification:ip:'.$ip;
			$value = $wgMemc->incr( $key );
			if ( !$value ) {
				$wgMemc->set( $key, 1, 86400 );
			}
			if ( $value > $wgNotificationThrottle ) {
				$error = wfMsg( 'stf_throttle', $wgNotificationThrottle );
				wfProfileOut( __METHOD__ );
				if ( $isEncoded ) {
					echo "<hr /><br /><div><b>$error</b><br /><br /></div>";
					die();
				} else {
					$wgOut->addHTML( "<center><h3>$error</h3></center>\n" );
					return false;
				}
			}
		}

		$to = str_replace( "'", "", $notifyTo );
		$to = str_replace( ";", ",", $to );
		$addresses = explode( ",", $to );

		$to = '';
		$lim = 0;
		foreach ( $addresses as $address ) {
			if ( strpos( $address, '@' ) && $lim++ < $wgNotificationEmails ) {
				$to .= ( $to == '' ? '' : ', ' ) . trim( $address );
			}
		}

		$subject = $notifyName . wfMsg( 'stf_subject', $wgSitename );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		$dbw->insert(
			wfSharedTable("send_queue"),
			array(
				'que_ip'      => $ip,
				'que_to'      => $to,
				'que_from'    => $notifyFrom,
				'que_name'    => $notifyName,
				'que_user'    => $wgUser->getName(),
				'que_subject' => $subject,
				'que_body'    => $notifyBody,
			),
			__METHOD__
		);
		$dbw->commit();
		if ( $isEncoded ) {
			echo $this->generateResponse();
			wfProfileOut( __METHOD__ );
			die();
		}

		wfProfileOut( __METHOD__ );
		return true;
	}


	static function generateInviteMessage( $isEncoded, $uniqueId = false, $user = '' ) {
		global $wgUser, $wgServer;

		wfProfileIn( __METHOD__ );

		if ( $isEncoded /* ajax, sending link do individual article */ &&
			 $uniqueId /* we're sending the mail, not just generating preview */ ) {
			$target = Title::newFromText( 'InviteSpecialPage', NS_SPECIAL );
				$url = $target->getFullURL() . "?un=$uniqueId";
		} else {
				$url = $wgServer;
		}

		if ( $isEncoded ) {
			$out = wfMsg( 'stf_frm3_send', $user, $url );
		} else {
			$out = wfMsg( 'stf_frm3_invite', $url );
		}

		if ( $uniqueId ) {
			$out .= "\n\n\n\n\n\n";
			$out .= wfMsg( 'stf_abuse', wfGetIP() );
		}

		wfProfileOut( __METHOD__ );
		return $out;
	}


	static function generateResponse()
	{
		global $wgMemc, $wgSitename;
		wfProfileIn( __METHOD__ );
		$memckey = wfMemcKey( 'sendfriendarticles' );
		$articles = $wgMemc->get( $memckey );
		if ( $articles == null ) {
			wfProfileIn( __METHOD__ . "2" );
			$most_emailed = wfMsg( 'stf_most_emailed', $wgSitename );
			$most_popular = wfMsg( 'stf_most_popular', $wgSitename );

			$xlist = '';

			$num = 0;
			$dbr = wfGetDB( DB_SLAVE );
			$query = "SELECT p.page_title, s.send_page_ns as page_namespace, count(*) as cnt
				  FROM send_stats s
				  INNER JOIN page p ON s.send_page_id = p.page_id AND s.send_page_ns = p.page_namespace
				  WHERE s.send_tm > CURRENT_DATE
				  GROUP BY s.send_page_id, s.send_page_ns
				  ORDER BY cnt DESC
				  LIMIT 3";
			$res = $dbr->query( $query );
			while ( $row = $dbr->fetchObject( $res ) ) {

				$xtarget = Title::newFromText( $row->page_title, $row->page_namespace );
				$xurl = $xtarget->getFullURL();
				$xtitle = str_replace( "_", " ", $row->page_title );
				$xlist .= "<div class=\"articleName\"><a href=\"$xurl\">$xtitle</a></div><br />";
				$num++;
			}
			$dbr->freeResult( $res );

			if ( $num >= 3 ) {
				$articles = "<hr /><br /><div><b>$most_emailed</b><br /><br />$xlist</div>";
			} else {
				$xlist = "";
				$query = "SELECT page_title, page_namespace FROM page WHERE page_namespace = 0 ORDER BY page_counter DESC LIMIT 3";
				$res = $dbr->query( $query );
				while ( $row = $dbr->fetchObject( $res ) ) {

					$xtarget = Title::newFromText( $row->page_title, $row->page_namespace );
					if ( is_object( $xtarget ) ) {
						$xurl = $xtarget->getFullURL();
					} else {
						error_log( __METHOD__ . ": tried to access non-object at line 775\n" );
					}
					$xlist .= "<div class=\"articleName\"><a href=\"$xurl\">{$xtarget->getText()}</a></div><br />";
				}
				$dbr->freeResult( $res );
				$articles = "<hr /><br /><div><b>$most_popular</b><br /><br />$xlist</div>";
			}

			$wgMemc->set( $memckey, $articles, 3600 );
			wfProfileOut( __METHOD__ . "2" );
		}
		wfProfileOut( __METHOD__ );
		return $articles;
	}


	function generateContactFormFirst( $url, $pageId, $pageNamespace, $pageRevision, $error='' ) {
		global $wgOut, $wgUser, $wgTitle, $wgNotificationEmails;

		$email          = $wgUser->getEmail();
		$name           = ( $wgUser->isLoggedIn() ? $wgUser->getName() : "" );
		$form1          = wfMsg( 'stf_frm1' );
		$form2          = wfMsg( 'stf_frm2' );
		$form4          = wfMsg( 'stf_frm4_invite' );
		$form5          = wfMsg( 'stf_frm5' );
		$form6          = wfMsg( 'stf_frm6' );
		$name_label     = wfMsg( 'stf_name_label' );
		$choose_from_existing = wfMsg( 'stf_choose_from_existing' );
		$add_emails     = wfMsg( 'stf_add_emails' );
		$your_email     = wfMsg( 'stf_your_email' );
		$your_login     = wfMsg( 'stf_your_login' );
		$your_password  = wfMsg( 'stf_your_password' );
		$your_name      = wfMsg( 'stf_your_name' );
		$your_address   = wfMsg( 'stf_your_address' );
		$your_friends   = wfMsg( 'stf_your_friends' );
		$we_dont_keep   = wfMsg( 'stf_we_dont_keep' );
		$need_approval  = wfMsg( 'stf_need_approval' );
		$check_contacts = wfMsg( 'stf_ctx_check' );
		$more_than_one  = wfMsg( 'stf_ctx_invite', $wgNotificationEmails );

		// check, if user has supplied an usable account in his profile
		$yahoo_checked = $myspace_checked = "";
		if ( strpos( $email, '@gmail.com' ) ) {
			#$email = str_replace( '@gmail.com', '', $email );
			$gmail_checked = " checked=\"checked\"";
		} elseif ( strpos( $email, '@yahoo.com' ) ) {
			#$email = str_replace( '@yahoo.com', '', $email );
			$yahoo_checked = " checked=\"checked\"";
		} elseif ( strpos( $email, '@myspace.com' ) ) {
			#$email = str_replace( '@myspace.com', '', $email );
			$myspace_checked = " checked=\"checked\"";
		} else {
			$gmail_checked = " checked=\"checked\"";
		}

		if ( $error != '' ) {
			$wgOut->addHTML( "<center><h3>" . wfMsg( $error ) . "</h3></center>\n" );
		}

		$out  = "<form name=\"notification\" id=\"notification2\" action=\"$url\" method=\"post\">\n";
		$out .= "<input type=\"hidden\" name=\"id\" value=\"$pageId\">\n";
		$out .= "<input type=\"hidden\" name=\"ns\" value=\"$pageNamespace\">\n";
		$out .= "<input type=\"hidden\" name=\"re\" value=\"$pageRevision\">\n";

		$out .= "<table border=\"0\">\n";
		$out .= "<tr><td colspan=\"2\" style=\"font-size:14px; font-weight: bold;\">$choose_from_existing<br /><br /></td></tr><tr>\n";

		$out .= "<td width=\"20%\" style=\"font-size:13px;font-weight: bold;color: red; width:170px;padding-left:15px\">\n";
		$out .= "$your_email\n";
		$out .= "</td><td style=\"font-size:13px; font-weight: bold;\">\n";

		$out .= "<input type=\"radio\" name=\"ty\" value=\"gmail\" $gmail_checked><img border=\"0\" alt=\"Gmail\" src=\"http://images.wikia.com/common/services/gmail.png\">\n";
		$out .= "<input type=\"radio\" name=\"ty\" value=\"yahoo\" $yahoo_checked><img border=\"0\" alt=\"Yahoo!\" src=\"http://images.wikia.com/common/services/yahoo.png\">\n";
		//$out .= "<input type=\"radio\" name=\"ty\" value=\"myspace\" $myspace_checked><img border=\"0\" alt=\"MySpace\" src=\"http://images.wikia.com/common/services/myspace.png\">\n";

//		$out .= "<input type=\"radio\" name=\"ty\" value=\"gmail\" id=\"notify-gmail\" $gmail_checked><label for=\"notify-gmail\"><img border=\"0\" alt=\"Gmail\" src=\"http://images.wikia.com/common/services/gmail.png\"></label>\n";
//		$out .= "<input type=\"radio\" name=\"ty\" value=\"yahoo\" id=\"notify-yahoo\" $yahoo_checked><label for=\"notify-yahoo\"><img border=\"0\" alt=\"Yahoo!\" src=\"http://images.wikia.com/common/services/yahoo.png\"></label>\n";
//		$out .= "<input type=\"radio\" name=\"ty\" value=\"myspace\" id=\"notify-myspace\" $myspace_checked><label for=\"notify-myspace\"><img border=\"0\" alt=\"MySpace\" src=\"http://images.wikia.com/common/services/myspace.png\"></label>\n";

		$out .= "</td></tr><tr><td style=\"font-size:13px; font-weight: bold; color: red;width:170px;padding-left:15px\">\n";
		$out .= "$your_login\n";
		$out .= "</td><td>\n";
		$out .= "<input type=\"text\" style=\"margin-top:3px;\" size=\"30\" name=\"us\" value=\"$email\"><small>$we_dont_keep</small>\n";

		$out .= "</td></tr><tr><td style=\"font-size:13px; font-weight: bold; color: red;width:170px;padding-left:15px\">\n";
		$out .= "$your_password\n";
		$out .= "</td><td>\n";
		$out .= "<input type=\"password\" style=\"margin-top:3px;\" size=\"30\" name=\"pa\">\n";

		$out .= "</td></tr><tr><td colspan=\"2\">\n";
		$out .= "<center><input type=\"submit\" style=\"margin-top:3px;\" name=\"submit\" value=\"$check_contacts\">\n";
		$out .= "<br /><small>$need_approval</small></center>\n";
		$out .= "</td></tr>\n";
		$out .= "</table>\n";

		// second part
		$out .= "<table border=\"0\">\n";
		$out .= "<tr><td colspan=\"2\" style=\"font-size:14px; font-weight: bold;\">$add_emails<br /><br /></td></tr>\n";

		$out .= "<tr><td width=\"20%\" style=\"font-size:13px; font-weight: bold; color: red;width:170px;padding-left:15px\">\n";
		$out .= "$your_name\n";
		$out .= "</td><td style=\"font-size:13px; font-weight: bold;\">\n";
		$out .= "<input type=\"text\" size=\"40\" name=\"nm\"" . ( !empty($name) ? " value=\"" . htmlspecialchars($name) . "\"" : "" ) . " readonly>\n";

		$out .= "</td></tr><tr><td style=\"font-size:13px; font-weight: bold; color: red;width:170px;padding-left:15px\">\n";
		$out .= "$your_address\n";
		$out .= "</td><td>\n";
		$out .= "<input type=\"text\" size=\"40\" name=\"fr\"" . ( !empty($email) ? " value=\"" . htmlspecialchars($email) . "\"" : "" ) . " readonly>\n";

		$out .= "</td></tr><tr><td style=\"font-size:13px; font-weight: bold; color: red;width:170px;padding-left:15px\">\n";
		$out .= "";
		$out .= str_replace( "|", "<br />", $your_friends );
		$out .= "\n</td><td>\n";
		$out .= "<textarea size=\"40\" cols=\"12\" rows=\"2\" name=\"to\"/></textarea>\n";
		$out .= "<br /><small>$more_than_one</small>\n";

		$out .= "</td></tr><tr><td colspan=\"2\">\n";
		$out .= "<center><input type=\"submit\" style=\"margin-top:3px;\" name=\"submit\" value=\"$form4\"></center>\n";

		$out .= "</td></tr>\n";
		$out .= "</table>\n";
		$out .= "</form>\n";
		$wgOut->addHTML( $out );
	}


	function generateContactFormSecond( $url, $pageId, $pageNamespace, $pageRevision, $type, $username, $password ) {
		global $IP;
		wfProfileIn( __METHOD__ );

		require_once ( "$IP/extensions/wikia/WikiContacts/WikiContacts.php" );

		$contacts = class_exists( 'WikiContacts' ) ? WikiContacts::fetch( $type, $username, $password ) : array();

		if ( $contacts === false ) {
			$this->generateContactFormFirst( $url, $pageId, $pageNamespace, $pageRevision, 'stf_ctx_invalid' );
		} else if ( count( $contacts ) == 0 ) {
			$this->generateContactFormFirst( $url, $pageId, $pageNamespace, $pageRevision, 'stf_ctx_empty' );
		} else {
			$this->generateContactFormSecondHelper( $url, $pageId, $pageNamespace, $pageRevision, $type, $contacts );
		}

		wfProfileOut( __METHOD__ );
	}


	function generateContactFormSecondHelper( $url, $pageId, $pageNamespace, $pageRevision, $type, $contacts ) {
		global $wgOut, $wgUser, $wgNotificationDisplayedContacts;

		$name           = $wgUser->getName();
		$email          = $wgUser->getEmail();
		$form3          = $this->generateInviteMessage( false );
		$form4          = wfMsg( 'stf_frm4_invite' );
		$choose_from_existing = wfMsg( 'stf_choose_from_existing' );
		$your_email     = wfMsg( 'stf_your_email' );
		$your_name      = wfMsg( 'stf_your_name' );
		$your_address   = wfMsg( 'stf_your_address' );
		$message        = wfMsg( 'stf_message' );
		$instructions   = wfMsg( 'stf_instructions', $form4 );
		$select_all     = wfMsg( 'stf_select_all' );
		$select_friends = wfMsg( 'stf_select_friends' );

		// macbre: fix <pre class="monotype"> line breaking (put <br /> - IE doesn't understand CRLF (?) - sic!
		/**
		$browser = function_exists( 'GetUserAgent' ) ? GetUserAgent() : array();

		if ( $browser['is_ie'] ) {
			// escape any HTML chars and add <br /> tag to every line break
			$form3 = implode("<br />\n", explode("\n", htmlspecialchars($form3)));
		} else {
			// escape any HTML chars
			$form3 = htmlspecialchars( $form3 );
		}
		**/

		// escape any HTML chars and add <br /> tag to every line break
		$form3 = implode( "<br />\n", explode( "\n", htmlspecialchars( $form3 ) ) );

		switch ( $type ) {
			case 'gmail':    $gmail_checked   = " checked=\"checked\"";  break;
			case 'yahoo':    $yahoo_checked   = " checked=\"checked\"";  break;
			case 'myspace':  $myspace_checked = " checked=\"checked\"";  break;
		}

		$out  = "<form id=\"contacts\" name=\"contacts\" action=\"$url\" method=\"post\">\n";
		$out .= "<input type=\"hidden\" name=\"id\" value=\"$pageId\">\n";
		$out .= "<input type=\"hidden\" name=\"ns\" value=\"$pageNamespace\">\n";
		$out .= "<input type=\"hidden\" name=\"re\" value=\"$pageRevision\">\n";

		$out .= "<table border=\"0\">\n";
		$out .= "<tr><td colspan=\"2\" style=\"font-size:14px; font-weight: bold;\">$choose_from_existing<br /><br /></td></tr><tr>\n";

		$out .= "<td width=\"20%\" style=\"font-size:13px;font-weight: bold;color: red; width:170px;\">\n";
		$out .= "$your_email\n";
		$out .= "</td><td style=\"font-size:13px; font-weight: bold;\">\n";

		$out .= "<input type=\"radio\" name=\"ty\" value=\"gmail\" $gmail_checked><img border=\"0\" alt=\"Gmail\" src=\"http://images.wikia.com/common/services/gmail.png\">\n";
		$out .= "<input type=\"radio\" name=\"ty\" value=\"yahoo\" $yahoo_checked><img border=\"0\" alt=\"Yahoo!\" src=\"http://images.wikia.com/common/services/yahoo.png\">\n";
		//$out .= "<input type=\"radio\" name=\"ty\" value=\"myspace\" $myspace_checked><img border=\"0\" alt=\"MySpace\" src=\"http://images.wikia.com/common/services/myspace.png\">\n";

//		$out .= "<input type=\"radio\" name=\"ty\" value=\"gmail\" id=\"notify-gmail\" $gmail_checked><label for=\"notify-gmail\"><img border=\"0\" alt=\"Gmail\" src=\"http://images.wikia.com/common/services/gmail.png\"></label>\n";
//		$out .= "<input type=\"radio\" name=\"ty\" value=\"yahoo\" id=\"notify-yahoo\" $yahoo_checked><label for=\"notify-yahoo\"><img border=\"0\" alt=\"Yahoo!\" src=\"http://images.wikia.com/common/services/yahoo.png\"></label>\n";
//		$out .= "<input type=\"radio\" name=\"ty\" value=\"myspace\" id=\"notify-myspace\" $myspace_checked><label for=\"notify-myspace\"><img border=\"0\" alt=\"MySpace\" src=\"http://images.wikia.com/common/services/myspace.png\"></label>\n";

		$out .= "</td></tr><tr><td width=\"20%\" style=\"font-size:13px; font-weight: bold; color: red;\">\n";
		$out .= "$your_name\n";
		$out .= "</td><td style=\"font-size:13px; font-weight: bold;\">\n";
		$out .= "<input type=\"text\" size=\"40\" name=\"nm\"" . ( !empty($name) ? " value=\"" . htmlspecialchars($name) . "\"" : "" ) . " readonly=\"readonly\">\n";

		$out .= "</td></tr><tr><td style=\"font-size:13px; font-weight: bold; color: red;\">\n";
		$out .= "$your_address\n";
		$out .= "</td><td>\n";
		$out .= "<input type=\"text\" size=\"40\" name=\"fr\"" . ( !empty($email) ? " value=\"" . htmlspecialchars($email) . "\"" : "" ) . " readonly=\"readonly\">\n";

		$out .= "</td></tr><tr><td style=\"font-size:13px; font-weight: bold; color: red;\">\n";
		$out .= "$message\n";
		$out .= "</td><td>\n";
		//$out .= "<textarea name=\"bo\" rows=\"6\" readonly>$form3</textarea>\n";  // 4-5 on Firefox, 5-6 on IE
		$out .= "<pre class=\"monotype\" style=\"color: grey;\">".$form3."</pre>\n";

		$out .= "</td></tr>\n";
		$out .= "</table><br />\n";

		// second part - the actual form
		$out .= "<table border=\"0\">\n";
		$out .= "<tr><td colspan=\"2\" style=\"font-size:14px; font-weight: bold;\">$select_friends<br /></td></tr>\n";

		$out .= "<tr><td width=\"20%\" style=\"font-size:13px; font-weight: bold; color: red;\"><valign=\"center\">\n";
		$out .= str_replace( "|", "<br />", $instructions );
		$out .= "\n</valign>\n";

		$out .= "</td><td><valign=\"top\">\n";
		$out .= "<small><a href=\"#\" onClick=\"return stf_select_all();\">$select_all</a></small>\n";
		$out .= "<input type=\"submit\" style=\"margin-top:3px;\" name=\"submit\" value=\"$form4\">\n";
		$out .= "<br /><hr />\n";

		$cnt = 0;
		foreach ( $contacts as $key => $contact ) {
			if ( $cnt++ < $wgNotificationDisplayedContacts ) {
				$out .= "<input type=\"checkbox\" name=\"stf_$cnt\" id=\"stf_$cnt\" value=\"" . $contact['email'] . "\">" . $contact['name'] . "<br />\n";
			}
		}

		$out .= "<hr />\n";
		$out .= "<small><a href=\"#\" onClick=\"return stf_select_all();\">$select_all</a></small>\n";
		$out .= "<input type=\"submit\" style=\"margin-top:3px;\" name=\"submit\" value=\"$form4\">\n";
		$out .= "</valign>\n";

		$out .= "</td></tr>\n";
		$out .= "</table>\n";
		$out .= "</form>\n";
		$wgOut->addHTML( $out );
		$wgOut->addHTML( <<<EOF
<script type="text/javascript">
function stf_select_all() {
	for ( var i = 1; i <= $wgNotificationDisplayedContacts; i++ ) {
		fld = document.getElementById('stf_' + i);
		if ( fld ) fld.checked = !fld.checked;
	}
	return false;
}
</script>
EOF
);
	}
} // class
?>
