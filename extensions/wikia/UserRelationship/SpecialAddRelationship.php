<?php

$wgExtensionFunctions[] = 'wfSpecialAddRelationship';


function wfSpecialAddRelationship(){
	global $wgUser,$wgOut,$IP;

	#---
	include_once("$IP/includes/SpecialPage.php");


	class AddRelationship extends SpecialPage {
		var $user_name_to;
		var $user_id_to;
		var $relationship_type;

		#---
		function AddRelationship() {
			global $wgMessageCache;
			SpecialPage::SpecialPage("AddRelationship","",false);

			require_once ( dirname( __FILE__ ) . '/UserRelationship.i18n.php' );
			foreach( efSpecialUserReplationship() as $lang => $messages ) {
				$wgMessageCache->addMessages( $messages, $lang );
			}
		}

		function execute() {
			global $wgUser, $wgOut, $wgRequest, $IP, $wgEnableAjaxLogin;
			global $wgMessageCache, $wgAvatarPath, $wgScriptPath, $wgStyleVersion;

			require_once("$IP/extensions/wikia/UserRelationship/UserRelationshipClass.php");

			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/UserRelationship/css/relationship.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$wgOut->addHTML($text);

			$usertitle = Title::newFromDBkey(htmlspecialchars($wgRequest->getVal('user')));
			if ( !$usertitle )
			{
				$wgOut->setPagetitle( wfMsg('woopserrormsg') );
				$wgOut->addHTML('<div class="give-gift-message">'.wfMsg('invalid_friend_foe_select').'</div>');
				return false;
			}

			$this->user_name_to = $usertitle->getText();
			$this->user_id_to = User::idFromName($this->user_name_to);
			$this->relationship_type = $wgRequest->getVal('rel_type');

			/*
			 * FOE OFF !
			 */
			$this->relationship_type = ($this->relationship_type != 1)?1:$this->relationship_type;
			/*
			 */

			if (($wgUser->getID()== $this->user_id_to) && ($wgUser->getID() != 0))
			{
				$out .= $wgOut->setPagetitle( wfMsg('woopserrormsg') );
				$out .= '<div class="give-gift-message">'.wfMsg('cannot_request_yourself').'</div>';
				$out .= '<div class="friend-request-buttons">';
				$out .= '<input type="button" value="'.wfMsg('home').'" size="20" onclick=\'window.location="/index.php?title=Main_Page"\' /> ';
				$out .= '<input type="button" value="'.wfMsg('return_to_user').'" size="20" onclick=\'window.location="/index.php?title=User:'.$wgUser->getName().'"\' /> ';
				$out .= '</div>';

				$wgOut->addHTML($out);
			}
			else if($this->user_id_to == 0)
			{
				$out .= $wgOut->setPagetitle( wfMsg('woopserrormsg') );
				$out .= '<div class="give-gift-message">'.wfMsg('user_dont_exist').'</div>';
				$out .= '<div class="friend-request-buttons">';
				$out .= '<input type="button" value="'.wfMsg('home').'" size="20" onclick=\'window.location="/index.php?title=Main_Page"\' /> ';
				$out .= '<input type="button" value="'.wfMsg('return_to_user').'" size="20" onclick=\'window.location="/index.php?title=User:'.$wgUser->getName().'"\' /> ';
				$out .= '</div>';

				$wgOut->addHTML($out);
			}
			else
			{
				if (UserRelationship::getUserRelationshipByID($this->user_id_to,$wgUser->getID()) == $this->relationship_type)
				{
					if($this->relationship_type==1) {
						$label = wfMsg('friendlink');
					} else {
						$label = wfMsg('foelink');
					}
					$avatar = new WikiaAvatar($this->user_id_to);
					$avatar_img = $avatar->getAvatarImageTag("l");
					$out = "";
					$out .= $wgOut->setPagetitle( wfMsg('woopserrormsg') );
					$out .= $this->returnPage();
					$out .= '<div class="friend-request">';
					$out .= '<div class="friend-request-image">'.$avatar_img.'</div>';$out .= '<div class="friend-request-message">'.wfMsg('user_is_in_relation', $label, $this->user_name_to).'</div>';
					$out .= '<div class="cleared"></div>';
					$out .= '</div>';
					$out .= '<div class="friend-request-buttons">';
					$out .= '<input type="button" value="'.wfMsg('home').'" size="20" onclick=\'window.location="/index.php?title=Main_Page"\' /> ';
					$out .= '<input type="button" value="'.wfMsg('return_to_user').'" size="20" onclick=\'window.location="/index.php?title=User:'.$wgUser->getName().'"\' /> ';
					$out .= '</div>';
					$wgOut->addHTML($out);

				}
				else if(UserRelationship::userHasRequestByID($this->user_id_to,$wgUser->getID()) == true)
				{
					if($this->relationship_type==1){
						$label = wfMsg('friendlink');
					} else {
						$label = wfMsg('foelink');
					}
					$avatar = new WikiaAvatar($this->user_id_to);
					$avatar_img = $avatar->getAvatarImageTag("l");
					$out = "";
					$out .= $wgOut->setPagetitle( wfMsg('patience_error') );
					$out .= $this->returnPage();
					$out .= '<div class="friend-request">';
					$out .= '<div class="friend-request-image">'.$avatar_img.'</div>';
					$out .= '<div class="give-gift-message">'.wfMsg('user_pending_request', $label, $this->user_name_to).' '.wfMsg('notify_to_confirm_your_request', $this->user_name_to).'</div>';
					$out .= '<div class="cleared"></div>';
					$out .= '</div>';
					$out .= '<div class="friend-request-buttons">';
					$out .= '<input type="button" value="'.wfMsg('home').'" size="20" onclick=\'window.location="/index.php?title=Main_Page"\' /> ';
					$out .= '<input type="button" value="'.wfMsg('return_to_user').'" size="20" onclick=\'window.location="' . Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL() . '"\' /> ';
					$out .= '<input type="button" value="'.wfMsg('user_profile_page', $wgUser->getName()).'" size="30" onclick=\'window.location="' . Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL() . '"\' /> ';
					$out .= '</div>';
					$wgOut->addHTML($out);

				}
				else if(UserRelationship::userHasRequestByID($wgUser->getID(),$this->user_id_to) == true)
				{
					$relationship_request =  Title::makeTitle( NS_SPECIAL  , "ViewRelationshipRequests"  );
					$wgOut->redirect( $relationship_request ->getFullURL() );
				}
				else if($wgUser->getID() == 0)
				{
					if ($this->relationship_type==1) {
						$label = wfMsg('friend_text');
					} else {
						$label = wfMsg('foe_text');
					}

					$login_href = 'window.location="/index.php?title=Special:Userlogin&returnto=User:' . $this->user_name_to . '"';
					$out = "";
					$out .= $wgOut->setPagetitle( wfMsg('woopserrormsg') );
					$out .= $this->returnPage();
					$out .= '<div class="give-gift-message">'.wfMsg('user_haveto_logged_to_add', $label).'</div>';
					$out .= '<div class="friend-request-buttons">';
					$out .= '<input type="button" value="'.wfMsg('home').'" size="20" onclick=\'window.location="/index.php?title=Main_Page"\' /> ';
					$out .= '<input type="button" value="'.wfMsg('login').'" size="20" onclick=\''.$login_href.'\' /> '; // FIXME should be UserProfile (renders as UserProfile&action=edit now...) or better SpecialAddRelationship&user=foo&reltype=bar (no way to add params to returnto...)
					$out .= '</div>';
					$wgOut->addHTML($out);
				}
				else
				{
					$rel = new UserRelationship($wgUser->getName() );
					if ($wgRequest->wasPosted() && $_SESSION["alreadysubmitted"] == false)
					{
						$_SESSION["alreadysubmitted"] = true;
						$rel = $rel->addRelationshipRequest($this->user_name_to, $this->relationship_type, htmlspecialchars($wgRequest->getVal("message")) );

    					$avatar = new WikiaAvatar($this->user_id_to);
    					$avatar_img = $avatar->getAvatarImageTag("l");

						if($this->relationship_type==1) {
							$label = wfMsg('friendlink');
						} else {
							$label = wfMsg('foelink');
						}

						$out = "";
						$out .= $wgOut->setPagetitle( wfMsg('userrequestsenttitle', $label, $this->user_name_to) );

						$out .= '<div class="friend-request">
						<div class="friend-request-image">'.$avatar_img.'</div>
						<div class="friend-request-message">'.wfMsg('userrequestsent', $label, $this->user_name_to).'</div>
						<div class="cleared"></div></div>';
						$out .= '<div class="friend-request-buttons">';
						$out .= "<input type=\"button\" value=\"".wfMsg('user_profile_page', $this->user_name_to)."\" size=\"30\" onclick='window.location=\"" . Title::makeTitle(NS_USER_PROFILE, $this->user_name_to)->getLocalURL() . "\"' /> ";
						$out .= "<input type=\"button\" value=\"".wfMsg('selected_user_page', $this->user_name_to)."\" size=\"20\" onclick='window.location=\"" . Title::makeTitle(NS_USER, $this->user_name_to)->getLocalURL() . "\"' /> ";
						$out .= "<input type=\"button\" value=\"".wfMsg('your_user_page')."\" size=\"20\" onclick='window.location=\"" . Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL() . "\"' /> ";
						$out .= '</div>';
						$wgOut->addHTML($out);
					}
					else
					{
						$_SESSION["alreadysubmitted"] = false;
						$wgOut->addHTML($this->displayForm());
					}
				}
			}
		}


		function displayForm()
        {
            global $wgOut, $wgUser, $wgAvatarPath;
            $form =  "";
            if($this->relationship_type==1) {
                $label = wfMsg('friend_text');
                $label1 = wfMsg('friendship');
            }
            else {
                $label = wfMsg('foe_text');
                $label1 = wfMsg('grudge');;
            }

    		$avatar = new WikiaAvatar($this->user_id_to);
    		$avatar_img = $avatar->getAvatarImageTag("l");

            $form .= $wgOut->setPagetitle( wfMsg('adduserrelation', $this->user_name_to, $label) );
            $form .= '<div class="friend-request-links">';
            $form .= '<a href="/index.php?title=User:'.$this->user_name_to.'">< '.wfMsg('backto_user_page', $this->user_name_to).'</a>';

            if ($this->relationship_type==1) {
                $form .= ' - <a href="/index.php?title=Special:ViewRelationships&user='.$this->user_name_to.'&rel_type=1">'.wfMsg('viewalluserfriends', $this->user_name_to).'</a>';
                $form .= ' - <a href="/index.php?title=Special:ViewRelationships&user='.$wgUser->getName().'&rel_type=1">'.wfMsg('viewallyourfriends').'</a>';
            }
            else {
                $form .= ' - <a href="/index.php?title=Special:ViewRelationships&user='.$this->user_name_to.'&rel_type=2">'.wfMsg('viewalluserfoes',$this->user_name_to).'</a>';
                $form .= ' - <a href="/index.php?title=Special:ViewRelationships&user='.$wgUser->getName().'&rel_type=2">'.wfMsg('viewallyourfoes').'</a>';
            }
            $form .= '</div>';
            $form .= '<form action="" method="post" enctype="multipart/form-data" name="form1">
            <div class="friend-request">
                <div class="friend-request-image">'.$avatar_img.'</div>
                <div class="friend-request-message">'.wfMsg('notify_toadd_user_rel', $this->user_name_to, $label, $label1).'</div>
                <div class="cleared"></div>
            </div>
		   <div class="friend-request-title">'.wfMsg('add_personal_msg').'</div>
		   <textarea name="message" id="message" rows="3" cols="50"></textarea>
		   <div class="friend-request-buttons">
			<input type=hidden name="user_name" value="' . addslashes($this->user_name_to) . '">
			<input type="button" value="'.wfMsg('adduserrelation', $this->user_name_to, $label).'" size="20" onclick="document.form1.submit()" />
			<input type="button" value="'.wfMsg('cancel').'" size="20" onclick="history.go(-1)" />
		  </div>
		  </form>';
		  return $form;
		}

		private function returnPage()
		{
			$out = "";
			$out .= "<div class=\"friend-request-links\">";
			$out .= "<a href=\"" . Title::makeTitle(NS_USER_PROFILE, $this->user_name_to)->getLocalURL() . "\">".wfMsg('user_profile_page', $this->user_name_to)."</a>";
			$out .= "  -  <a href=\"" . Title::makeTitle(NS_USER, $this->user_name_to)->getLocalURL() . "\">".wfMsg('selected_user_page', $this->user_name_to)."</a>";
			$out .= "</div>";

			return $out;
		}
	}

	SpecialPage::addPage( new AddRelationship );
	global $wgMessageCache,$wgOut;
}

?>
