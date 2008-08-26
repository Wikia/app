<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();
/**#@+
 * Display User Board messages for a user
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * @author David Pean <david.pean@gmail.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgUserBoard = true;

class SpecialViewUserBoard extends SpecialPage {
	public function __construct() {
		wfLoadExtensionMessages( 'SocialProfileUserBoard' );
		SpecialPage::SpecialPage("UserBoard");
	}

	public function execute( $params ) {
		global $wgUser, $wgOut, $wgRequest, $IP, $wgMemc, $wgStyleVersion, $wgUserBoardScripts;

		wfLoadExtensionMessages( 'SocialProfileUserBoard' );

		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgUserBoardScripts}/UserBoard.css?{$wgStyleVersion}\"/>\n");

		$ub_messages_show = 25;
		$output = "";
		$user_name = $wgRequest->getVal('user');
		$user_name_2 = $wgRequest->getVal('conv');
		$page =  $wgRequest->getVal('page');

		/**
		* Redirect Non-logged in users to Login Page
		* It will automatically return them to the UserBoard page
		*/
		if($wgUser->getID() == 0 && $user_name==""){
			$login =  Title::makeTitle( NS_SPECIAL, "UserLogin" );
			$wgOut->redirect( $login->getFullURL() . "&returnto=Special:UserBoard" );
			return false;
		}

		/**
		* If no user is set in the URL, we assume its the current user
		*/

		if(!$user_name)$user_name = $wgUser->getName();
		$user_id = User::idFromName($user_name);
		$user =  Title::makeTitle( NS_USER, $user_name );
		$user_safe = str_replace("&", "%26", $user_name);

		if($user_name_2){
			$user_id_2 = User::idFromName($user_name_2);
			$user_2 =  Title::makeTitle( NS_USER, $user_name );
			$user_safe_2 = urlencode($user_name_2);
		}
		/**
		* Error message for username that does not exist (from URL)
		*/
		if($user_id == 0){
			$wgOut->showErrorPage('error', 'userboard_noexist');
			return false;
		}

		/**
		* Config for the page
		*/
		$per_page = $ub_messages_show;
		if(!$page || !is_numeric($page) )$page=1;

		$b = new UserBoard();
		$ub_messages = $b->getUserBoardMessages($user_id, $user_id_2, $ub_messages_show, $page);

		if(!$user_id_2){
			$stats = new UserStats($user_id, $user_name);
			$stats_data = $stats->getUserStats();
			$total = $stats_data["user_board"];
			if($wgUser->getName() == $user_name)$total=$total+$stats_data["user_board_priv"];
		} else {
			$total = $b->getUserBoardToBoardCount($user_id, $user_id_2);
		}

		if(!$user_id_2){
			if (!($wgUser->getName() == $user_name)) {
				$wgOut->setPagetitle( wfMsg("userboard_owner", $user_name) );
			} else {
				$b->clearNewMessageCount($wgUser->getID());
				$wgOut->setPagetitle( wfMsg("userboard_yourboard") );
			}
		} else {
			if ( $wgUser->getName() == $user_name ) {
				$wgOut->setPagetitle( wfMsg("userboard_yourboardwith", $user_name_2)  );
			} else {
				$wgOut->setPagetitle( wfMsg("userboard_otherboardwith", $user_name, $user_name_2) );
			}
		}

		$output .= '<div class="user-board-top-links">';
		$output .= "<a href=\"{$user->escapeFullURL()}\">&lt; " . wfMsg("userboard_backprofile", $user_name) . "</a>";
		$output .= "</div>";
		$output .= "<script>/*<![CDATA[*/
			var _DELETE_CONFIRM = \"" . wfMsg("userboard_confirmdelete") . "\"
			var posted = 0;
			function send_message(){
				if(\$(\"message\").value && !posted){
					posted = 1;
					var url = \"index.php?action=ajax\";
					var pars = 'rs=wfSendBoardMessage&rsargs[]=' + escape(\$(\"user_name_to\").value) +'&rsargs[]=' + encodeURIComponent(\$(\"message\").value) + '&rsargs[]=' + \$(\"message_type\").value + '&rsargs[]={$per_page}'

					var callback = {
						success: function(originalRequest){
							posted = 0;
							if(\$(\"user_name_from\").value){ //its a board to board
								user_1 = \$(\"user_name_from\").value
								user_2 = \$(\"user_name_to\").value
							} else {
								user_1 = \$(\"user_name_to\").value
								user_2 = \"\";
							}
							user_1 = escape(user_1);
							user_2 = escape(user_2);
							window.location='index.php?title=Special:UserBoard&user='+user_1 + ((user_2)?\"&conv=\"+user_2:\"\");
						}
					};
					var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);

				}
			}
			function delete_message(id){
				if( confirm( _DELETE_CONFIRM ) ){
					var url = \"index.php?action=ajax\";
					var pars = 'rs=wfDeleteBoardMessage&rsargs[]=' + id
					var callback = {
						success: function(originalRequest){
							window.location.reload();
						}
					};
					var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
				}

			}
		/*]]>*/</script>";

		if($page==1){
			$start = 1;
		} else {
			$start = ($page-1) * $per_page + 1;
		}
		$end = $start + ( count($ub_messages) ) - 1;

		if($wgUser->getName()!=$user_name){
			$board_to_board = "<a href=\"" . UserBoard::getUserBoardToBoardURL($wgUser->getName(),$user_name)."\">" .wfMsg( "userboard_boardtoboard" ) . "</a>";
		}

		if( $total ){
		$output .= "<div class=\"user-page-message-top\">
		<span class=\"user-page-message-count\" style=\"font-size:11px;color:#666666;\">" . wfMsg( "userboard_showingmessages", $total, $start, $end ) . ".</span> {$board_to_board}</span>
			</div>";
		}

		/**
		* Build next/prev nav
		*/
		if($user_id_2)$qs = "&conv={$user_safe_2}";
		$numofpages = $total / $per_page;

		if($numofpages>1){
			$output .= "<div class=\"page-nav\">";
			if($page > 1){
				$output .= "<a href=\"index.php?title=Special:UserBoard&user={$user_safe}&page=" . ($page-1) . "{$qs}\">" . wfMsg("userboard_prevpage") . "</a> ";
			}

			if(($total % $per_page) != 0)$numofpages++;
			if($numofpages >=9 && $page < $total){
				$numofpages=9+$page;
				if($numofpages >= ($total / $per_page) )$numofpages = ($total / $per_page)+1;
			}

			for($i = 1; $i <= $numofpages; $i++){
				if($i == $page){
				    $output .=($i." ");
				} else {
				    $output .="<a href=\"index.php?title=Special:UserBoard&user={$user_safe}&page=$i{$qs}\">$i</a> ";
				}
			}

			if(($total - ($per_page * $page)) > 0){
				$output .=" <a href=\"index.php?title=Special:UserBoard&user={$user_safe}&page=" . ($page+1) . "{$qs}\">" . wfMsg("userboard_nextpage") . "</a>";
			}
			$output .= "</div><p>";
		}
		/**
		* Build next/prev nav
		*/
		$can_post = false;

		if(!$user_id_2){
			if($wgUser->getName() != $user_name){
				$can_post = true;
				$user_name_to = addslashes($user_name);
			}
		} else {
			if($wgUser->getName() == $user_name){
				$can_post = true;
				$user_name_to = addslashes($user_name_2);
				$user_name_from = addslashes($user_name);
			}
		}
		if($wgUser->isBlocked()){
			//only let them post to admins
			$user_to = User::newFromId($user_id);
			$user_to->loadFromId();
			//if( !$user_to->isAllowed('delete') ){
				$can_post = false;
			//}
		}

		if($can_post){
			if($wgUser->isLoggedIn() ){
				$output .= "<div class=\"user-page-message-form\">
					<input type=\"hidden\" id=\"user_name_to\" name=\"user_name_to\" value=\"{$user_name_to}\"/>
					<input type=\"hidden\" id=\"user_name_from\" name=\"user_name_from\" value=\"{$user_name_from}\"/>
					<span style=\"color:#797979;\">" . wfMsg("userboard_messagetype") . " </span> <select id=\"message_type\"><option value=\"0\">" . wfMsg("userboard_public") . "</option><option value=\"1\">" . wfMsg("userboard_private") . "</option></select><p>
					<textarea name=\"message\" id=\"message\" cols=\"63\" rows=\"4\"/></textarea>

					<div class=\"user-page-message-box-button\">
						<input type=\"button\" value=\"" . wfMsg("userboard_sendbutton") . "\" class=\"site-button\" onclick=\"javascript:send_message();\">
					</div>

				</div>";
			} else {

				$login_link = Title::makeTitle(NS_SPECIAL, "UserLogin");

				$output .= "<div class=\"user-page-message-form\">
						" . wfMsg("userboard_loggedout", $login_link->escapeFullURL()) . "
						</div>";
			}
		}
		$output .= "<div id=\"user-page-board\">";

		if($ub_messages){
			foreach ($ub_messages as $ub_message) {
				$user =  Title::makeTitle( NS_USER, $ub_message["user_name_from"] );
				$avatar = new wAvatar($ub_message["user_id_from"], "m");

				$board_to_board = "";
				$board_link = "";
				$ub_message_type_label = "";
				$delete_link = "";
				if($wgUser->getName()!=$ub_message["user_name_from"]){
					$board_to_board = "<a href=\"" . UserBoard::getUserBoardToBoardURL($user_name,$ub_message["user_name_from"])."\">" . wfMsg("userboard_boardtoboard") . "</a>";
					$board_link = "<a href=\"" . UserBoard::getUserBoardURL($ub_message["user_name_from"])."\">" . wfMsg("userboard_sendmessage",$ub_message["user_name_from"]) . "</a>";
				} else {
					$board_link = "<a href=\"" . UserBoard::getUserBoardURL($ub_message["user_name_from"])."\">" . wfMsg("userboard_myboard") . "</a>";
				}
				if($wgUser->getName()==$ub_message["user_name"]){
					$delete_link = "<span class=\"user-board-red\">
						<a href=\"javascript:void(0);\" onclick=\"javascript:delete_message({$ub_message["id"]})\">" . wfMsg("userboard_delete") . "</a>
					</span>";
				}
				if($ub_message["type"] == 1){
					$ub_message_type_label = "(" . wfMsg("userboard_private") . ")";
				}
				global $max_link_text_length;
				$max_link_text_length = 75;

				//had global function to cut link text if too long and no breaks
				//$ub_message_text = preg_replace_callback( "/(<a[^>]*>)(.*?)(<\/a>)/i",'cut_link_text',$ub_message["message_text"]);
				$ub_message_text = $ub_message["message_text"];

				$output .= "<div class=\"user-board-message\" style=\"width:550px\">
					<div class=\"user-board-message-from\">
							<a href=\"{$user->escapeFullURL()}\" title=\"{$ub_message["user_name_from"]}}\">{$ub_message["user_name_from"]} </a> {$ub_message_type_label}
					</div>
					<div class=\"user-board-message-time\">
						" . wfMsgHtml( 'userboard_posted_ago', $b->getTimeAgo( $ub_message["timestamp"] ) ) . "
					</div>
					<div class=\"user-board-message-content\">
						<div class=\"user-board-message-image\">
							<a href=\"{$user->escapeFullURL()}\" title=\"{$ub_message["user_name_from"]}\">{$avatar->getAvatarURL()}</a>
						</div>
						<div class=\"user-board-message-body\" >
							{$ub_message_text}
						</div>
						<div class=\"cleared\"></div>
					</div>
					<div class=\"user-board-message-links\">
						{$board_link}
						{$board_to_board}
						{$delete_link}
					</div>
				</div>";
			}
		} else {
			$invite_title = Title::makeTitle(NS_SPECIAL, "InviteContacts");
			$output .= "<p>" . wfMsg("userboard_nomessages", $invite_title->escapeFullURL() ) . "</p>";

		}
		$output .= "</div>";

		$wgOut->addHTML($output);
	}
}
