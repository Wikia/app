<?php
//custom content actions for quiz game
function wfAddPictureGameContentActions( $skin, $content_actions ){
	global $wgUser, $wgRequest, $wgPictureGameID, $wgTitle;
	
	//Add Edit Page to Content Actions
	if( $wgRequest->getVal( 'picGameAction' ) != "startCreate" && $wgUser->isAllowed( 'protect' ) ){
		$pic = Title::makeTitle( NS_SPECIAL, "PictureGameHome");
		$content_actions["edit"] = array(
			'class' => ($wgRequest->getVal("picGameAction") == 'editItem') ? 'selected' : false,
			'text' => wfMsg('edit'),
			'href' => $pic->getFullURL("picGameAction=editPanel&id=".$wgPictureGameID), // @bug 2457, 2510
		);
	}
	
	//if editing, make special page go back to quiz question
	if( $wgRequest->getVal( 'picGameAction' ) == "editItem" ){
		$pic = Title::makeTitle( NS_SPECIAL, "QuizGameHome");
		$content_actions[$wgTitle->getNamespaceKey()] = array(
			'class' => 'selected',
			'text' => wfMsg('nstab-special'),
			'href' => $pic->getFullURL("picGameAction=renderPermalink&id=" . $wgPictureGameID), 
		);
	}
	return true;
}

$wgExtensionFunctions[] = 'wfSpecialPictureGameHome';
$wgExtensionFunctions[] = 'wfPictureGameReadLang';

function wfSpecialPictureGameHome(){

	global $wgUser,$IP;

	include_once("AjaxUploadForm.php");	// The modified upload form class

	class PictureGameHome extends UnlistedSpecialPage {
		// ABSOLUTE PATH
		private $INCLUDEPATH = "/extensions/wikia/PictureGame/picturegame/";
		private $SALT;

		/* Construct the MediaWiki special page */
		function PictureGameHome(){
			parent::__construct("PictureGameHome");
		}


		/* the main functino that handles browser requests" */
		function execute(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgSupressPageTitle, $wgUploadPath;
			
			$wgSupressPageTitle=true;
			
			global $wgHooks;
			$wgHooks["SkinTemplateBuildContentActionUrlsAfterSpecialPage"][] = "wfAddPictureGameContentActions";
			
			// Salt as you like
			$this->SALT = md5( $wgUser->getName() );

			$action = $wgRequest->getVal("picGameAction");

			switch($action){

			case "uploadForm":
				$wgOut->setArticleBodyOnly(true);
				$form = new AjaxUploadForm($wgRequest);
				$form->execute();
				break;
			case "startGame":
				$this->renderPictureGame();
				break;
			case "createGame":
				$this->createGame();
				break;
			case "castVote":
				$this->voteAndForward();
				break;
			case "flagImage":
				$this->flagImage();
				break;
			case "renderPermalink":
				$this->renderPictureGame();
				break;
			case "gallery":
				$this->displayGallery();
				break;
			case "editPanel":
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed("delete")  )
					$this->editPanel();
				else
					$this->showHomePage();
				break;
			case "completeEdit":
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed("delete")  )
					$this->completeEdit();
				else
					$this->showHomePage();
				break;
			case "adminPanel":
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed("delete")  )
					$this->adminPanel();
				else
					$this->showHomePage();
				break;
			case "adminPanelUnflag":
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed("delete")  )
					$this->adminPanelUnflag();
				else
					$this->showHomePage();
				break;
			case "adminPanelDelete":
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed("delete")  )
					$this->adminPanelDelete();
				else
					$this->showHomePage();
				break;
			case "protectImages":
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed("delete")  )
					$this->protectImages();
				else
					//print "You aren't authorized to do that.";
					print wfMsgForContent('picturegame_sysmsg_unauthorized');
				break;
			case "unprotectImages":
				if( $wgUser->isLoggedIn() && $wgUser->isAllowed("delete")  )
					$this->unprotectImages();
				else
					$this->showHomePage();
				break;
			case "startCreate":
				if( $wgUser->isBlocked() ){
					$wgOut->blockedPage( false );
					return "";
				}else{
					$this->showHomePage();
				}
				break;
			default:
				$this->renderPictureGame();
				break;
			}

		}

		/* Called via AJAX to delete an image out of the game */
		function adminPanelDelete(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP;

			$wgOut->setArticleBodyOnly(true);

			$id =  addslashes( $wgRequest->getVal("id") );
			$image1 =  addslashes( $wgRequest->getVal("img1") );
			$image2 =  addslashes( $wgRequest->getVal("img2") );

			$key = $wgRequest->getVal("key");
			$now = $wgRequest->getVal("chain");

			if($key != md5($now . $this->SALT) || (!$wgUser->isLoggedIn() || !$wgUser->isAllowed("delete")  ) ){
				//print "Fatal Error: You key is bad.";
				//print wfMsgForContent('picturegame_sysmsg_badkey');
				//return;
			}

			$dbr =& wfGetDB( DB_MASTER );
			$sql = "DELETE FROM picturegame_images WHERE id=" . $id . ";";
			$res = $dbr->query($sql);

			global $wgMemc;
			$key = wfMemcKey( 'user', 'profile', 'picgame' , $wgUser->getID());
			$wgMemc->delete( $key );
					
			/* Pop the images out of MediaWiki also */
			//$img_one = Image::newFromName( $image1 );
			if( $image1 ){
				$img_one = Title::makeTitle(NS_IMAGE, $image1 );
				$article = new Article($img_one);
				$article->doDeleteArticle( "Picture Game image 1 Delete");
			}
			
			if( $image2 ){
				$img_two = Title::makeTitle(NS_IMAGE, $image2 );
				$article = new Article( $img_two );
				$article->doDeleteArticle( "Picture Game image 2 Delete");
			}

			if($oneResult && $twoResult){
				//print "You have successfully delete this picture game!";
				print wfMsgForContent('picturegame_sysmsg_successfuldelete');
				return;
			}

			if($oneResult){
				//print "Deleting {$image1} from MediaWiki failed!";
				print wfMsgForContent('picturegame_sysmsg_unsuccessfuldelete', $image1);
			}
			if($twoResult){
				//print "Deleting {$image2} from MediaWiki failed!";
				print wfMsgForContent('picturegame_sysmsg_unsuccessfuldelete', $image2);
			}
			
			
		}

		/* Called over AJAX to unflag an image */
		function adminPanelUnflag(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP;

			$wgOut->setArticleBodyOnly(true);

			$id =  addslashes( $wgRequest->getVal("id") );

			$key = $wgRequest->getVal("key");
			$now = $wgRequest->getVal("chain");

			if($key != md5($now . $this->SALT) || (!$wgUser->isLoggedIn() || !$wgUser->isAllowed("delete") ) ){
				//print "Fatal Error: You key is bad.";
				print wfMsgForContent('picturegame_sysmsg_badkey');
				return;
			}

			$dbr =& wfGetDB( DB_MASTER );
			$sql = "UPDATE picturegame_images SET flag='NONE' WHERE id=" . $id . ";";
			$res = $dbr->query($sql);

			$wgOut->clearHTML();
			//print "You have placed these images back into circulation.";
			print wfMsgForContent('picturegame_sysmsg_unflag');
		}

		/* Updates a record in the picture game table */
		function completeEdit(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP;

			$id =  addslashes( $wgRequest->getVal("id") );
			$key =  addslashes( $wgRequest->getVal("key") );

			$title =  addslashes( $wgRequest->getVal("newTitle") );
			$imgOneCaption =  addslashes( $wgRequest->getVal("imgOneCaption") );
			$imgTwoCaption =  addslashes( $wgRequest->getVal("imgTwoCaption") );

			if($key != md5($id . $this->SALT) ){
				//$wgOut->addHTML("<h3> Your key is bad! Go back and try again? </h3>");
				$wgOut->addHTML("<h3>" . wfMsgForContent('picturegame_sysmsg_badkey') . "</h3>");return;
			}

			$dbr =& wfGetDB( DB_MASTER );
			$sql = "UPDATE picturegame_images SET title='{$title}', img1_caption='{$imgOneCaption}', img2_caption='{$imgTwoCaption}' WHERE id={$id};";
			$res = $dbr->query($sql);

			/* When its done redirect to a permalink of these images "*/
			$wgOut->setArticleBodyOnly(true);
			header( 'Location: ?title=Special:PictureGameHome&picGameAction=renderPermalink&id=' . $id ) ;
		}

		/* Displays the edit panel */
		function editPanel(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgStyleVersion, $wgUploadPath;

			$id =  addslashes( $wgRequest->getVal("id") );

			$dbr =& wfGetDB( DB_MASTER );
			$sql = "SELECT * FROM picturegame_images WHERE id={$id};";
			$res = $dbr->query($sql);

			$row = $dbr->fetchObject( $res );

			$imgID = $row->id;
			$user_name = ($row->username == substr($row->username, 0, 20) ) ?
								 $row->username : ( substr($row->username, 0, 20) . "...");

			$title_text = $row->title;
			$img1_caption_text = $row->img1_caption;
			$img2_caption_text = $row->img2_caption;

			// I assume MediaWiki does some caching with these functions?
			$img_one = Image::newFromName( $row->img1 );
			$thumb_one_url = $img_one->createThumb(128);
			$imgOne =  '<img width="' . ($img_one->getWidth() >= 128 ? 128 : $img_one->getWidth()) . '" alt="" src="' . $thumb_one_url . '?' . time() . '"/>';
			$imgOneName = $row->img1;

			$img_two = Image::newFromName( $row->img2 );
			$thumb_two_url = $img_two->createThumb(128);
			$imgTwo =  '<img width="' . ($img_two->getWidth() >= 128 ? 128 : $img_two->getWidth()) . '" alt="" src="' . $thumb_two_url . '?' . time() . '"/>';
			$imgTwoName = $row->img2;
			

			
			$output = "
			<script type=\"text/javascript\">
			<!--
			var __picturegame_editgameediting__ = \"" . wfMsgForContent('picturegame_editgameediting') . "\";
			var __request_url__ = \"" . $wgRequest->getRequestURL() . "\";
			-->
			</script>";
			
			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$this->INCLUDEPATH}editpanel.js?{$wgStyleVersion}\"></script>\n");


			//$wgOut->setpageTitle("Editing {$title_text}");
                        $wgOut->setpageTitle(wfMsgForContent('picturegame_editgameediting') . " {$title_text}");

			$id=User::idFromName($row->username);
			$avatar = new wAvatar($id,"l");
			$avatarID = $avatar->getAvatarImage();
			$stats = new UserStats($id, $row->username);
			$stats_data = $stats->getUserStats();

			$output .= "
			<style type=\"text/css\">@import \"{$this->INCLUDEPATH}editpanel.css?{$wgStyleVersion}\";</style>

			<div id=\"edit-container\" class=\"edit-container\">
			<form id=\"picGameVote\" name=\"picGameVote\" method=\"post\" action=\"" . Title::makeTitle(NS_SPECIAL, "PictureGameHome")->escapeFullURL("picGameAction=completeEdit") . "\">
				<div id=\"edit-textboxes\" class=\"edit-textboxes\">	
					<div class=\"credit-box-edit\" id=\"creditBox\">
						<h1>". wfMsgForContent('picturegame_submittedby') . "</h1>
						<div class=\"submitted-by-image\">
							<a href=\"" . Title::makeTitle(NS_USER,$row->username) . "\"><img src=\"{$wgUploadPath}/avatars/{$avatarID}\" style=\"border:1px solid #d7dee8; width:50px; height:50px;\" alt=\"\" border=\"0\"/></a>
						</div>
						<div class=\"submitted-by-user\">
							<a href=\"index.php?title=User:{$row->username}\">{$user_name}</a>
							<ul>
								<li><img src=\"{$wgUploadPath}/common/voteIcon.gif\" border=\"0\" alt=\"\"> {$stats_data["votes"]}</li>
								<li><img src=\"{$wgUploadPath}/common/pencilIcon.gif\" border=\"0\" alt=\"\"> {$stats_data["edits"]}</li>
								<li><img src=\"{$wgUploadPath}/common/commentsIcon.gif\" border=\"0\" alt=\"\"> {$stats_data["comments"]}</li>
							</ul>
						</div>
						<div class=\"cleared\"></div>
					</div>
					<h1>" . wfMsgForContent('picturegame_editgamegametitle') . "</h1>
					<p><input name=\"newTitle\" id=\"newTitle\" type=\"text\" value=\"{$title_text}\" size=\"40\"/></p>
					<input id=\"key\" name=\"key\" type=\"hidden\" value=\"" . md5($imgID . $this->SALT) . "\" />
					<input id=\"id\" name=\"id\" type=\"hidden\" value=\"{$imgID}\" />
				</div>
				<div class=\"edit-images-container\">
					<div id=\"edit-images\" class=\"edit-images\">
						<div id=\"edit-image-one\" class=\"edit-image-one\">
							<h1>" . wfMsgForContent('picturegame_createeditfirstimage') . "</h1>
							<p><input name=\"imgOneCaption\" id=\"imgOneCaption\" type=\"text\" value=\"{$img1_caption_text}\" /></p>
							<p id=\"image-one-tag\">{$imgOne}</p>
							<p><a href=\"javascript:loadUploadFrame('{$imgOneName}', 1)\">" . wfMsgForContent('picturegame_editgameuploadtext') . "</a></p>
						</div>
						<div id=\"edit-image-two\" class=\"edit-image-one\">
							<h1>" . wfMsgForContent('picturegame_createeditsecondimage') . "</h1>
							<p><input name=\"imgTwoCaption\" id=\"imgTwoCaption\" type=\"text\" value=\"{$img2_caption_text}\" /></p>
							<p id=\"image-two-tag\">{$imgTwo}</p>
							<p><a href=\"javascript:loadUploadFrame('{$imgTwoName}', 2)\">" . wfMsgForContent('picturegame_editgameuploadtext') . "</a></p>
						</div>
						<div id=\"loadingImg\" class=\"loadingImg\" style=\"display:none\">
							<img src=\"{$wgUploadPath}/common/ajax-loader-white.gif\" />
						</div>
						<div class=\"cleared\"></div>
					</div>
					<div class=\"edit-image-frame\" id=\"edit-image-frame\" style=\"display:hidden\">
						<div class=\"edit-image-text\" id=\"edit-image-text\"> </div>
						<iframe frameBorder=\"0\" scrollbar=\"no\" class=\"upload-frame\" id=\"upload-frame\" src=\"\"></iframe>
					</div>
					<div class=\"cleared\"></div>
				</div>
				<div class=\"copyright-warning\">". wfMsg("copyrightwarning") . "</div>
				<div id=\"complete-buttons\" class=\"complete-buttons\">
					<input type=\"button\" onclick=\"document.picGameVote.submit()\" value=\"" . wfMsgForContent('picturegame_buttonsubmit') ."\"/>
					<input type=\"button\"  onclick=\"window.location='" . Title::makeTitle(NS_SPECIAL,"PictureGameHome")->escapeFullURL("picGameAction=renderPermalink&id={$imgID}") . "'\" value=\"". wfMsgForContent('picturegame_buttoncancel') . "\"/>
				</div>
			</form>
			</div>
			";
			//"
			$dbr->freeResult( $res );
			$wgOut->addHTML($output);
		}

		/* Displays the admin panel */
		function adminPanel(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgUploadPath, $wgStyleVersion;

			$now = time();
			$key = md5($now . $this->SALT);

			$output = "

			<script type=\"text/javascript\">

			var __admin_panel_now__ = \"" . $now . "\";
			var __admin_panel_key__ = \"" . $key . "\";
			
			</script>";
			
			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$this->INCLUDEPATH}adminpanel.js?{$wgStyleVersion}\"></script>\n");
			//$wgOut->setPagetitle("Picture Game Admin Panel");
                        $wgOut->setPagetitle(wfMsgForContent('picturegame_adminpaneltitle'));
			$output .= "

			<style type=\"text/css\">@import \"{$this->INCLUDEPATH}adminpanel.css\";</style>

			<div class=\"back-link\"><a href=\"/index.php?title=Special:PictureGameHome&picGameAction=startGame\"> ";
                        //< Back to the Picture Game
                        $output .= wfMsgForContent('picturegame_adminpanelbacktogame');
                        $output .= "</a></div>


			<div id=\"admin-container\" class=\"admin-container\">
				<p><strong>";
                        //Flagged Images:
                        $output .= wfMsgForContent('picturegame_adminpanelflagged');
                        $output .= "</strong></p>";

			$dbr =& wfGetDB( DB_MASTER );
			$sql = "SELECT id, img1, img2 FROM picturegame_images WHERE flag='FLAGGED' and img1<>'' and img2<>'';";
			$res = $dbr->query($sql);

			while ( $row = $dbr->fetchObject( $res ) ){

				$img_one = Image::newFromName( $row->img1 );
				$thumb_one = $img_one->getThumbnail( 128  );
				$img_one_tag = $thumb_one->toHtml();

				$img_two = Image::newFromName( $row->img2 );
				$thumb_two = $img_two->getThumbnail( 128  );
				$img_two_tag = $thumb_two->toHtml();

				$img_one_description = ($row->img1 == substr($row->img1, 0, 12) ) ?
									 $row->img1 : ( substr($row->img1, 0, 12) . "...");

				$img_two_description = ($row->img2 == substr($row->img2, 0, 12) ) ?
													 $row->img2 : ( substr($row->img2, 0, 12) . "...");

				$output .= "<div id=\"" . $row->id . "\" class=\"admin-row\">

					<div class=\"admin-image\">
						<p>{$img_one_tag}</p>
						<p><b>{$img_one_description}</b></p>
					</div>
					<div class=\"admin-image\">
						<p>{$img_two_tag}</p>
						<p><b>{$img_two_description}</b></p>
					</div>
					<div class=\"admin-controls\">
						<a href=\"javascript:unflag({$row->id})\">";
                                                //Reinstate
                                        $output .= wfMsgForContent('picturegame_adminpanelreinstate');
                                        $output .=  "</a> |
						<a href=\"javascript:deleteimg(" . $row->id . ", '" . $row->img1 . "', '" . $row->img2 . "')\">";
                                            //Delete
                                        $output .= wfMsgForContent('picturegame_adminpaneldelete');
                                        $output .= "</a>
					</div>
					<div class=\"cleared\"></div>

				</div>";
			}

			$output .= "</div>
			<div id=\"admin-container\" class=\"admin-container\">
                            <p><strong>";
                            //Protected Images:
                            $output .= wfMsgForContent('picturegame_adminpanelprotected');
                            $output .= "</strong></p>";
			$dbr =& wfGetDB( DB_MASTER );
			$sql = "SELECT id, img1, img2 FROM picturegame_images WHERE flag='PROTECT' and img1<>'' and img2<>'';";
			$res = $dbr->query($sql);

			while ( $row = $dbr->fetchObject( $res ) ){

				$img_one = Image::newFromName( $row->img1 );
				$thumb_one = $img_one->getThumbnail( 128  );
				$img_one_tag = $thumb_one->toHtml();

				$img_two = Image::newFromName( $row->img2 );
				$thumb_two = $img_two->getThumbnail( 128  );
				$img_two_tag = $thumb_two->toHtml();

				$img_one_description = ($row->img1 == substr($row->img1, 0, 12) ) ?
									 $row->img1 : ( substr($row->img1, 0, 12) . "...");

				$img_two_description = ($row->img2 == substr($row->img2, 0, 12) ) ?
													 $row->img2 : ( substr($row->img2, 0, 12) . "...");

				$output .= "<div id=\"" . $row->id . "\" class=\"admin-row\">

					<div class=\"admin-image\">
						<p>{$img_one_tag}</p>
						<p><b>{$img_one_description}</b></p>
					</div>
					<div class=\"admin-image\">
						<p>{$img_two_tag}</p>
						<p><b>{$img_two_description}</b></p>
					</div>
					<div class=\"admin-controls\">
						<a href=\"javascript:unprotect({$row->id})\">";
                                        //Unprotect
                                        $output .= wfMsgForContent('picturegame_adminpanelunprotect');
                                        $output .= "</a> |
						<a href=\"javascript:deleteimg(" . $row->id . ", '" . $row->img1 . "', '" . $row->img2 . "')\">";
                                        //Delete
                                        $output .= wfMsgForContent('picturegame_adminpaneldelete');
                                        $output .= "</a>
					</div>
					<div class=\"cleared\"></div>

				</div>";
			}

			$output .= "</div>";

			// "
			$dbr->freeResult( $res );
			$wgOut->addHTML($output);
		}

		/* Called with AJAX to flag an image */
		function flagImage() {
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgUploadPath;

			$wgOut->setArticleBodyOnly(true);

			$id =  addslashes( $wgRequest->getVal("id") );
			$key = $wgRequest->getVal("key");


			if($key != md5($id . $this->SALT) ){
				//print "Fatal Error: You key is bad.";
				print wfMsgForContent('picturegame_sysmsg_badkey');
				return;
			}

			$dbr =& wfGetDB( DB_MASTER );
			$sql = "UPDATE picturegame_images SET flag='FLAGGED' WHERE id=" . $id . " AND flag='NONE';";
			$res = $dbr->query($sql);

			$wgOut->clearHTML();
			//print "<div style=\"color:red; font-weight:bold; font-size:16px; margin:-5px 0px 20px 0px;\">The images have been reported!</div>";
			print "<div style=\"color:red; font-weight:bold; font-size:16px; margin:-5px 0px 20px 0px;\">" . wfMsgForContent('picturegame_sysmsg_flag') . "</div>";
		}

		/* Called with AJAX to unprotect an image set "*/
		function unprotectImages(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgUploadPath;

			$wgOut->setArticleBodyOnly(true);

			$id =  addslashes( $wgRequest->getVal("id") );
			$key = $wgRequest->getVal("key");
			$chain = $wgRequest->getVal("chain");

			if($key != md5($chain . $this->SALT) ){
				//print "Fatal Error: Your key is bad.";
				print wfMsgForContent('picturegame_sysmsg_badkey');
				return;
			}

			$dbr =& wfGetDB( DB_MASTER );
			$sql = "UPDATE picturegame_images SET flag='NONE' WHERE id=" . $id . ";";
			$res = $dbr->query($sql);

			$wgOut->clearHTML();
			//print "The images have been un-protected!";
			print wfMsgForContent('picturegame_sysmsg_unprotect');
		}

		/* Protects an image set */
		function protectImages(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgUploadPath;

			$wgOut->setArticleBodyOnly(true);

			$id =  addslashes( $wgRequest->getVal("id") );
			$key = $wgRequest->getVal("key");


			if($key != md5($id . $this->SALT) ){
				//print "Fatal Error: You key is bad.";
				print wfMsgForContent('picturegame_sysmsg_badkey');
				return;
			}

			$dbr =& wfGetDB( DB_MASTER );
			$sql = "UPDATE picturegame_images SET flag='PROTECT' WHERE id=" . $id . ";";
			$res = $dbr->query($sql);

			$wgOut->clearHTML();
			//print "The images have been protected!";
			print wfMsgForContent('picturegame_sysmsg_protect');
		}

		function displayGallery(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgUploadPath;

			$wgOut->setHTMLTitle( wfMsg( 'pagetitle', "Gallery" ) );

			$type = $wgRequest->getVal("type");
			$direction = $wgRequest->getVal("direction");
			
			if (($type == "heat") && ($direction=="most")) {
				$crit = "Heat";
				$noun = "Heat";
				$order = "ASC";
				$adj = "Most";
			} 
			
			else if (($type == "heat") && ($direction=="least")) {
				$crit = "Heat";
				$noun = "Heat";
				$order = "DESC";
				$adj = "Least";
			}
			
			else if (($type == "votes") && ($direction=="most")) {
				$crit = "(img0_votes+img1_votes)";
				$noun = "Votes";
				$order = "DESC";
				$adj = "Most";
			}
			
			else if (($type == "votes") && ($direction=="least")) {
				$crit = "(img0_votes+img1_votes)";
				$noun = "Votes";
				$order = "ASC";
				$adj = "Least";
			}

			else {
				$type = "heat";
				$direction = "most";
				
				$crit = "Heat";
				$noun = "Heat";
				$order = "ASC";
				$adj = "Most";
			}

			$sortheader = "Picture Games Sorted By {$adj} {$noun}";

			$wgOut->setPageTitle ("$sortheader");

			$output = "
				<style type=\"text/css\">@import \"{$this->INCLUDEPATH}gallery.css\";</style>
					<div class=\"picgame-gallery-navigtion\">";

					if ($type == "votes" && $direction == "most") {

						$output .= "<h1>Most</h1>
						<p><b>Most Votes</b></p>
						<p><a href=\"/index.php?title=Special:PictureGameHome&picGameAction=gallery&type=heat&direction=most\">Most Heat</a></p>
						
						<h1 style=\"margin:10px 0px !important;\">Least</h1>
						<p><a href=\"/index.php?title=Special:PictureGameHome&picGameAction=gallery&type=votes&direction=least\">Least Votes</a></p>
						<p><a href=\"/index.php?title=Special:PictureGameHome&picGameAction=gallery&type=heat&direction=least\">Least Heat</a></p>";
						
					}

					if ($type == "votes" && $direction == "least") {

						$output .= "<h1>Most</h1>
						<p><a href=\"/index.php?title=Special:PictureGameHome&picGameAction=gallery&type=votes&direction=most\">Most Votes</a></p>
						<p><a href=\"/index.php?title=Special:PictureGameHome&picGameAction=gallery&type=heat&direction=most\">Most Heat</a></p>
						
						<h1 style=\"margin:10px 0px !important;\">Least</h1>
						<p><b>Least Votes</b></p>
						<p><a href=\"/index.php?title=Special:PictureGameHome&picGameAction=gallery&type=heat&direction=least\">Least Heat</a></p>";
					
					}

					if ($type == "heat" && $direction == "most") {

						$output .= "<h1>Most</h1>
						<p><a href=\"index.php?title=Special:PictureGameHome&picGameAction=gallery&type=votes&direction=most\">Most Votes</a></p>
						<p><b>Most Heat</b></p>
						
						<h1 style=\"margin:10px 0px !important;\">Least</h1>
						<p><a href=\"/index.php?title=Special:PictureGameHome&picGameAction=gallery&type=votes&direction=least\">Least Votes</a></p>
						<p><a href=\"/index.php?title=Special:PictureGameHome&picGameAction=gallery&type=heat&direction=least\">Least Heat</a></p>";
						
					}

					if ($type == "heat" && $direction == "least") {

						$output .= "<h1>Most</h1>
						<p><a href=\"/index.php?title=Special:PictureGameHome&picGameAction=gallery&type=votes&direction=most\">Most Votes</a></p>
						<p><a href=\"/index.php?title=Special:PictureGameHome&picGameAction=gallery&type=heat&direction=most\">Most Heat</a></p>
						
						<h1 style=\"margin:10px 0px !important;\">Least</h1>
						<p><a href=\"/index.php?title=Special:PictureGameHome&picGameAction=gallery&type=votes&direction=least\">Least Votes</a></p>
						<p><b>Least Heat</b></p>";
						
					}


			$output .= "</div>";

			$output .= "<div class=\"picgame-gallery-container\" id=\"picgame-gallery-thumbnails\">";

			$per_row = 3;
			$x = 1;

			$dbr =& wfGetDB( DB_SLAVE );
			$sql = "SELECT COUNT(*) as mycount FROM picturegame_images WHERE 1;";
			$res = $dbr->query($sql);
			$row = $dbr->fetchObject( $res );

			//page nav variables
			$total = $row->mycount;
			$page =  addslashes( $wgRequest->getVal("page") );

			if(!$page)
				$page = 1;

			//Add Limit to SQL
			$per_page = 9;
			$limit = $per_page;

			$limitvalue = 0;
			if ($limit > 0) {
					if($page)
						$limitvalue = $page * $limit - ($limit);
					$limit_sql = " LIMIT {$limitvalue},{$limit} ";
			}

			$dbr =& wfGetDB( DB_MASTER );
			$sql = "SELECT * FROM picturegame_images WHERE flag!='Flagged' and img1<>'' and img2<>'' ORDER BY {$crit} {$order} {$limit_sql}";
			$res = $dbr->query($sql);

			$preloadImages = array();

			$output .= "<script type=\"text/javascript\">
			
			function doHover(divID){
				\$El(divID).setStyle('background-color', '#e5e7ea');
			}

			function endHover(divID){
				\$El(divID).setStyle('background-color', '');
			}
			
			</script>";

			while( $row = $dbr->fetchObject( $res ) ){

				$gameid = $row->id;

				$title_text = ($row->title == substr($row->title, 0, 23) ) ? htmlentities ( $row->title ) : htmlentities ( ( substr($row->title, 0, 23) . "...") );
				
				$imgOneCount = $row->img0_votes;
				$imgTwoCount = $row->img1_votes;
				$totalVotes = $imgOneCount + $imgTwoCount;

				if ($imgOneCount == 0) {
					$imgOnePercent = 0;
				} else {
					$imgOnePercent = floor( $imgOneCount / $totalVotes  * 100 );
				}

				if ($imgTwoCount == 0) {
					$imgTwoPercent = 0;
				} else {
					$imgTwoPercent = 100 - $imgOnePercent;
				}
				
				$img_one = Image::newFromName( $row->img1 );
				$gallery_thumb_image_one = $img_one->getThumbNail(80 );
				$gallery_thumbnail_one = $gallery_thumb_image_one->toHtml();
				
				$img_two = Image::newFromName( $row->img2 );				
				$gallery_thumb_image_two = $img_two->getThumbNail(80 );
				$gallery_thumbnail_two = $gallery_thumb_image_two->toHtml();
				
				$output .= "
				<div class=\"picgame-gallery-thumbnail\" id=\"picgame-gallery-thumbnail-{$x}\" onclick=\"javascript:document.location='/index.php?title=Special:PictureGameHome&picGameAction=renderPermalink&id={$gameid}'\" onmouseover=\"doHover('picgame-gallery-thumbnail-{$x}')\" onmouseout=\"endHover('picgame-gallery-thumbnail-{$x}')\" >
				<h1>{$title_text} ({$totalVotes})</h1>
					
					<div class=\"picgame-gallery-thumbnailimg\">
						{$gallery_thumbnail_one}
						<p>{$imgOnePercent}%</p>
					</div>     
					
					<div class=\"picgame-gallery-thumbnailimg\">
						{$gallery_thumbnail_two}
						<p>{$imgTwoPercent}%</p>
					</div>
					
					<div class=\"cleared\"></div>
				</div>

				";

				if($x!=1 && $x % $per_row ==0) {
					$output .= "<div class=\"cleared\"></div>";
				}
				$x++;
			}
			
			$output .="</div>";

			//Page Nav

			$numofpages = ceil( $total / $per_page );

			if($numofpages > 1) {

				$output .= "<div class=\"page-nav\">";

				if($page > 1) {
					$output .= "<a href=\"/index.php?title=Special:PictureGameHome&picGameAction=gallery&page=" . ($page - 1) . "&type={$type}&direction={$direction}\">prev</a> ";
				}

				for($i = 1; $i <= $numofpages; $i++) {
					if($i == $page) {
					    $output .= ($i . " ");
					} else {
						$output .="<a href=\"/index.php?title=Special:PictureGameHome&picGameAction=gallery&page={$i}&type={$type}&direction={$direction}\">{$i}</a> ";
					}
				}

				if( $page < $numofpages ){
					$output .=" <a href=\"/index.php?title=Special:PictureGameHome&picGameAction=gallery&page=" . ($page + 1) . "&type={$type}&direction={$direction}\">next</a>";
				}

				$output .= "</div>";
			}
			
			$wgOut->addHTML($output);
		}

		//"
		// cast a user vote
		// the js takes care of redirecting the page
		function voteAndForward(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgUploadPath;
			
			$wgOut->setArticleBodyOnly(true);
			
			$key = $wgRequest->getVal("key");
			$next_id = $wgRequest->getVal("nextid");
			$id = addslashes( $wgRequest->getVal("id") );
			$img = addslashes( $wgRequest->getVal("img") );

			$imgnum = ($img == 0) ? 0 : 1;
			
			if($key != md5($id . $this->SALT)){
				//$wgOut->addHTML("Your key is wrong. Go back and try again.");
				$wgOut->addHTML(wfMsgForContent('picturegame_sysmsg_badkey'));
				return;
			}
			
			if( strlen($id) > 0 && strlen($img) > 0 ){
								
				$dbr =& wfGetDB( DB_MASTER );
				
				// check if the user has voted on this allready
				$sql = "SELECT COUNT(*) as mycount FROM picturegame_votes WHERE username='". addslashes($wgUser->getName()) ."' AND picid=" . $id . ";";
				$res = $dbr->query($sql);
				$row = $dbr->fetchObject( $res );

				// if he hasnt then check if the id exists and then insert the vote
				if($row->mycount == 0){
					$sql = "SELECT COUNT(*) as mycount FROM picturegame_images WHERE id=" . $id . ";";
					$res = $dbr->query($sql);
					$row = $dbr->fetchObject( $res );

					if( $row->mycount == 1 ){
						$sql = "INSERT INTO picturegame_votes (picid, userid, username,imgpicked, vote_date) 
							VALUES(" . $id . ", {$wgUser->getID()}, \"" . addslashes( $wgUser->getName() ) . "\", " . $imgnum . ", \"" . date("Y-m-d H:i:s") . "\") ;";
						$res = $dbr->query($sql);
						// "
						
						$sql = "UPDATE picturegame_images SET img" . $imgnum ."_votes=img" . $imgnum . "_votes+1, 
							heat=ABS( ( img0_votes / ( img0_votes+img1_votes) ) - ( img1_votes / ( img0_votes+img1_votes ) ) ) 
							WHERE id=" . $id . ";";
						$res = $dbr->query($sql);

						$stats = new UserStatsTrack($wgUser->getID(), $wgUser->getName());
						$stats->incStatField("picturegame_vote");
					}
				}	
			}
		
			$output = "OK";
			$wgOut->addHTML( $output );
		}

		// fetches the two images to be voted on
		// optional param lastID is the last image id the user saw
		// imgID is present if rendering a permalink
		function getImageDivs($isPermalink = false, $imgID = -1, $lastID = -1){

			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $IMGCONTENT, $wgSiteName, $wgUseEditButtonFloat, $wgUploadPath;
			global $wgStyleVersion;
			
			$totalVotes = 0;

			$dbr =& wfGetDB( DB_SLAVE );

			// if imgID is -1 then we need some random ids
			if($imgID == -1){
				$order = ( (time() % 2 == 0) ? "ASC" : "DESC" );
				$sql = "SELECT * FROM picturegame_images WHERE picturegame_images.id NOT IN (SELECT picid FROM picturegame_votes WHERE picturegame_votes.username='" . addslashes($wgUser->getName()) . "') AND flag != 'FLAGGED' and img1<> '' and img2<> '' LIMIT 1;";

				$res = $dbr->query($sql);
				$row = $dbr->fetchObject( $res );
				$imgID = $row->id;

			}else{
				$sql = "SELECT * FROM picturegame_images WHERE flag!='FLAGGED' and img1<> '' and img2<> '' AND id=" . $imgID . ";";
				$res = $dbr->query($sql);
				$row = $dbr->fetchObject( $res );	
			}
			$user_title =  Title::makeTitle( NS_USER  , $row->username  );

			if($imgID){
				global $wgPictureGameID;
				$wgPictureGameID = $imgID;
				$sql = "SELECT * FROM picturegame_images WHERE picturegame_images.id <> {$imgID} and  picturegame_images.id NOT IN (SELECT picid FROM picturegame_votes WHERE picturegame_votes.username='" . addslashes($wgUser->getName()) . "') AND flag != 'FLAGGED' and img1<> '' and img2<> '' LIMIT 1;";
				$nextres = $dbr->query($sql);
				$nextrow = $dbr->fetchObject( $nextres );
				$next_id = $nextrow->id;
				
				if($next_id){
					
					$img_one = Image::newFromName( $nextrow->img1 );
					if( is_object( $img_one ) ) $preload_thumb = $img_one->getThumbnail( 256  );
					if( is_object( $preload_thumb ) ) $preload_one_tag = $preload_thumb->toHtml();
					
					$img_two = Image::newFromName( $nextrow->img2 );
					if( is_object( $img_two ) ) $preload_thumb = $img_two->getThumbnail( 256  );
					if( is_object( $preload_thumb ) ) $preload_two_tag = $preload_thumb->toHtml();
					
					$preload = $preload_one_tag . $preload_two_tag;
				}
				
			}
			
			if( ( $imgID < 0 ) || !is_numeric( $imgID ) || is_null($row) ){

				//$wgOut->setPagetitle("No More Picture Games!");
				$wgOut->setPagetitle(wfMsgForContent('picturegame_nomoretitle'));
				
				$out = "<div>" . 
					wfMsgForContent('picturegame_nomore') . "<br>" . wfMsgForContent('picturegame_nomore_2') .
					"<a href=\"" . Title::makeTitle(NS_SPECIAL, "PictureGameHome")->escapeFullURL("picGameAction=startCreate") . "\">" . wfMsgForContent('picturegame_nomorecreatelink') . "</a> " . wfMsgForContent('picturegame_nomoreor') . " <a href=\"/index.php?title=Special:RandomPoll\">" . wfMsgForContent('picturegame_nomoretakepolls') . "</a>
				</div>";
				
				return $out;
			}
			//"
			// snag the images to vote on and grab some thumbnails
			// modify this query so that if the current user has voted on this image pair dont show it again
			
			$imgOneCount = $row->img0_votes;
			$imgTwoCount = $row->img1_votes;

			$user_name = ($row->username == substr($row->username, 0, 20) ) ?
								 $row->username : ( substr($row->username, 0, 20) . "...");
			
			$title_text_length = strlen($row->title);
			$title_text_space = stripos($row->title, ' ');
									
			if (($title_text_space == false || $title_text_space >= "48") && $title_text_length > 48){
				$title_text = substr($row->title, 0, 48)."<br>".substr($row->title, 48, 48);
			}
			elseif ($title_text_length > 48 && substr($row->title, 48, 1) == " "){
				$title_text = substr($row->title, 0, 48)."<br>".substr($row->title, 48, 48);
			}
			elseif ($title_text_length > 48 && substr($row->title, 48, 1) != " "){
				$title_text_lastspace = strrpos(substr($row->title, 0, 48),' ');
				$title_text = substr($row->title, 0, $title_text_lastspace)."<br>".substr($row->title, $title_text_lastspace, 30);
			}
			else {
				$title_text = $row->title;
			};
			
			$x=1;
			$img1_caption_text = "";
			$img1caption_array=str_split($row->img1_caption);
			foreach ($img1caption_array as $img1_character) {
				
				if ($x % 30 == 0) {
				$img1_caption_text.= $img1_character."<br>"; 
				}
				else {
				$img1_caption_text.= $img1_character;
				}			
				$x++;
			};
			
			
			$x=1;
			$img2_caption_text = "";
			$img1caption_array=str_split($row->img2_caption);
			foreach ($img1caption_array as $img2_character) {
				
				if ($x % 30 == 0) {
				$img2_caption_text.= $img2_character."<br>"; 
				}
				else {
				$img2_caption_text.= $img2_character;
				}			
				$x++;
			};
						
			
			// I assume MediaWiki does some caching with these functions"
			$img_one = Image::newFromName( $row->img1 );
			if( is_object( $img_one ) ) { 
				$thumb_one_url = $img_one->createThumb(256); 
				$imageOneWidth = $img_one->getWidth(); 
			} 
			//$imgOne =  '<img width="' . ($imageOneWidth >= 256 ? 256 : $imageOneWidth) . '" alt="" src="' . $thumb_one_url . ' "/>';
			//$imageOneWidth = ($imageOneWidth >= 256 ? 256 : $imageOneWidth);
			//$imageOneWidth += 10;
			$imgOne =  '<img style="width:100%;" alt="" src="' . $thumb_one_url . ' "/>';
			
			$img_two = Image::newFromName( $row->img2 );
			if( is_object( $img_two ) ) { 
				$thumb_two_url = $img_two->createThumb(256); 
				$imageTwoWidth = $img_two->getWidth(); 
			} 
			//$imgTwo =   '<img width="' . ($imageTwoWidth >= 256 ? 256 : $imageTwoWidth) . '" alt="" src="' . $thumb_two_url . ' "/>';
			//$imageTwoWidth = ($imageTwoWidth >= 256 ? 256 : $imageTwoWidth);
			//$imageTwoWidth += 10;
			$imgTwo =   '<img style="width:100%;" alt="" src="' . $thumb_two_url . ' "/>';
			
			
			$title = $title_text;
			$img1_caption = $img1_caption_text;
			$img2_caption = $img2_caption_text;

			$vote_one_tag = "";
			$vote_two_tag = "";
			$imgOnePercent = "";
			$barOneWidth = "";
			$imgTwoPercent = "";
			$barTwoWidth = "";
			$permalinkJS = "";
			
			$isShowVotes = false;
			if($lastID > 0){
				$sql = "SELECT * FROM picturegame_images WHERE flag!='FLAGGED' AND id={$lastID};";
				$res = $dbr->query($sql);
				$row = $dbr->fetchObject( $res );
				
				if($row){
					$img_one = Image::newFromName( $row->img1 );
					$img_two = Image::newFromName( $row->img2 );
					$imgOneCount = $row->img0_votes;
					$imgTwoCount = $row->img1_votes;
					$isShowVotes = true;
				}
			}
			
			if($isPermalink || $isShowVotes){
				if( is_object( $img_one ) ) $vote_one_thumb = $img_one->getThumbnail( 40  );
				if( is_object( $vote_one_thumb ) ) $vote_one_tag = $vote_one_thumb->toHtml();

				if( is_object( $img_two ) ) $vote_two_thumb = $img_two->getThumbnail( 40  );
				if( is_object( $vote_two_thumb ) ) $vote_two_tag = $vote_two_thumb->toHtml();
				
				$totalVotes = $imgOneCount + $imgTwoCount;
				
				if($imgOneCount == 0){
					$imgOnePercent = 0;
					$barOneWidth = 0;
				}else{
					$imgOnePercent = floor( $imgOneCount / $totalVotes  * 100 );
					$barOneWidth = floor( 200 * ($imgOneCount / $totalVotes ) );
				}
				
				if($imgTwoCount == 0){
					$imgTwoPercent = 0;
					$barTwoWidth = 0;
				}else{
					$imgTwoPercent = 100 - $imgOnePercent;
					$barTwoWidth = floor( 200 * ($imgTwoCount / $totalVotes ) );
				}

				//$permalinkJS = "\$('voteStats').show() ";
				/*$permalinkJS = "var vote_stats = new YAHOO.widget.Module(\"voteStats\");
						vote_stats.render();
						vote_stats.show();
						";
						*/
				$permalinkJS = "\$D.setStyle(\"voteStats\", 'display', 'inline');
						\$D.setStyle(\"voteStats\", 'visibility', 'visible');
						";
			}
			
			$output = "";
			// set the page title
			// $wgOut->setPagetitle($title_text);

			// figure out if the user is an admin / the creator
			if( $wgUser->isAllowed('protect') ){

				// if the user can edit throw in some links
				/*$editlinks = " - <a href=\"index.php?title=Special:PictureGameHome&picGameAction=adminPanel\"> Admin Panel</a>
					       - <a href=\"javascript:protectImages()\"> Protect</a>";*/
			        $editlinks = " - <a href=\"/index.php?title=Special:PictureGameHome&picGameAction=adminPanel\"> " . wfMsgForContent('picturegame_adminpanel') . "</a>
					       - <a href=\"javascript:protectImages('" . str_replace("'", "\'", wfMsgForContent('picturegame_protectimgconfirm')) ."')\"> " . wfMsgForContent('picturegame_protectimages') . "</a>";
					       
			}else{
				$editlinks = "";
			}

			if ($wgUser->isLoggedIn()) {
				$createLink = "
				<div class=\"create-link\">
					<a href=\"" . Title::makeTitle(NS_SPECIAL, "PictureGameHome")->escapeFullURL("picGameAction=startCreate") . "\">
					<img src=\"{$wgUploadPath}/common/addIcon.gif\" border=\"0\"/>";
					//Create a Picture Game
				$createLink .= wfMsgForContent('picturegame_createlink');
				$createLink .= "</a>
				</div>";
			}else{
				$createLink = "";	
			}

			if( $wgUser->isLoggedIn() && $wgUser->isAllowed("delete") && $wgUseEditButtonFloat == true) {
				$editLink .= "<div class=\"edit-menu-pic-game\">
						<div class=\"edit-button-pic-game\">
							<img src=\"{$wgUploadPath}/common/editIcon.gif\"/>
							<a href=\"javascript:editPanel()\">";
                                                        //Edit
                                                        $editLink .= wfMsg('edit');
                                                        $editLink .= "</a>
						</div>
					    </div>";
			}else{
				$editLink = "";					    

			}

			
			$id=User::idFromName($user_title->getText());
			$avatar = new wAvatar($id,"l");
			$avatarID = $avatar->getAvatarImage();
			$stats = new UserStats($id, $user_title->getText());
			$stats_data = $stats->getUserStats();

			$wgOut->setHTMLTitle( wfMsg( 'pagetitle', $title ) );
			
			$output .= "
			<script type=\"text/javascript\" src=\"{$this->INCLUDEPATH}lightbox_light.js?{$wgStyleVersion}\"></script>
			<script type=\"text/javascript\" src=\"{$this->INCLUDEPATH}picturegame.js?{$wgStyleVersion}\"></script>
			<script type=\"text/javascript\">var next_id = \"{$next_id}\";</script>
			{$editLink}
			<div class=\"editDiv\" id=\"editDiv\" style=\"display: none\"> </div>
			<div class=\"serverMessages\" id=\"serverMessages\"></div>
				
			<div class=\"imgContent\" id=\"imgContent\">
				<div class=\"imgTitle\" id=\"imgTitle\">" . $title . "</div>
				<div class=\"imgContainer\" id=\"imgContainer\" style=\"width:45%;\">
					<div class=\"imgCaption\" id=\"imgOneCaption\">" . $img1_caption . "</div>
					<div class=\"imageOne\" id=\"imageOne\" style=\"padding:5px;\" onClick=\"castVote(0)\" onmouseover=\"doHover('imageOne')\" onmouseout=\"endHover('imageOne')\" >" . $imgOne . "	</div>
				</div>
				<div class=\"imgContainer\" id=\"imgContainer\" style=\"width:45%;\">
					<div class=\"imgCaption\" id=\"imgTwoCaption\">" . $img2_caption . "</div>
					<div class=\"imageTwo\" id=\"imageTwo\" style=\"padding:5px;\" onClick=\"castVote(1)\" onmouseover=\"doHover('imageTwo')\" onmouseout=\"endHover('imageTwo')\">" . $imgTwo . "	</div>
				</div>
				<div class=\"cleared\"></div>
				<div class=\"pic-game-navigation\">
					<ul>
						<li id=\"backButton\" style=\"display:" . ($lastID > 0 ? "block" : "none") . "\"><a href=\"javascript:window.parent.document.location='" .  Title::makeTitle(NS_SPECIAL, "PictureGameHome")->escapeFullURL("picGameAction=renderPermalink") . "&id=' + \$('lastid').value\">";
						//Go Back
						$output .=       wfMsgForContent('picturegame_backbutton');
						$output .=       "</a></li>
						<li id=\"skipButton\" style=\"display:" . ($next_id > 0 ? "block" : "none") . "\"><a href=\"" . Title::makeTitle(NS_SPECIAL, "PictureGameHome")->escapeFullURL("picGameAction=startGame") . "\">";
						//Skip
						$output .=       wfMsgForContent('picturegame_skipbutton');
						$output .=      "</a></li>
					</ul>
				</div>
				<form id=\"picGameVote\" name=\"picGameVote\" method=\"post\" action=\"" . Title::makeTitle(NS_SPECIAL, "PictureGameHome")->escapeFullURL("picGameAction=castVote") . "\">
					<input id=\"key\" name=\"key\" type=\"hidden\" value=\"" . md5($imgID . $this->SALT) . "\" />
					<input id=\"id\" name=\"id\" type=\"hidden\" value=\"" . $imgID . "\" />
					<input id=\"lastid\" name=\"lastid\" type=\"hidden\" value=\"" . $lastID . "\" />
					<input id=\"nextid\" name=\"nextid\" type=\"hidden\" value=\"" . $next_id . "\" />
					<input id=\"img\" name=\"img\" type=\"hidden\" value=\"\" />
				</form>
			</div>
			<div class=\"other-info\">
				{$createLink}
				<div class=\"credit-box\" id=\"creditBox\">
					<h1>" . wfMsgForContent('picturegame_submittedby') . "</h1>
					<div class=\"submitted-by-image\">
						<a href=\"{$user_title->getFullURL()}\"><img src={$wgUploadPath}/avatars/{$avatarID} style=\"border:1px solid #d7dee8; width:50px; height:50px;\"/></a>
					</div>
					<div class=\"submitted-by-user\">
						<a href=\"{$user_title->getFullURL()}\">{$user_name}</a>
						<ul>
							<li><img src=\"{$wgUploadPath}/common/voteIcon.gif\" border=\"0\"> {$stats_data["votes"]}</li>
							<li><img src=\"{$wgUploadPath}/common/pencilIcon.gif\" border=\"0\"> {$stats_data["edits"]}</li>
							<li><img src=\"{$wgUploadPath}/common/commentsIcon.gif\" border=\"0\"> {$stats_data["comments"]}</li>
						</ul>
					</div>
					<div class=\"cleared\"></div>
				</div>
				<div class=\"voteStats\" id=\"voteStats\" style=\"display:none\">
					<div id=\"vote-stats-text\"><h1>";
					//Previous Game
					$output .= wfMsgForContent('picturegame_previousgame');
					$output .= " ({$totalVotes})</h1></div>
					<div class=\"vote-bar\">
						<span class=\"vote-thumbnail\" id=\"one-vote-thumbnail\">{$vote_one_tag}</span>
						<span class=\"vote-percent\" id=\"one-vote-percent\">{$imgOnePercent}%</span>
						<span class=\"vote-blue\"><img src=\"{$wgUploadPath}/common/vote-bar-blue.gif\" id=\"one-vote-width\" border=\"0\" style=\"width:{$barOneWidth}px;height:11px;\"/></span>
					</div>
					<div class=\"vote-bar\">
						<span class=\"vote-thumbnail\" id=\"two-vote-thumbnail\">{$vote_two_tag}</span>
						<span class=\"vote-percent\" id=\"two-vote-percent\">{$imgTwoPercent}%</span>
						<span class=\"vote-red\"><img src=\"{$wgUploadPath}/common/vote-bar-red.gif\" id=\"two-vote-width\" border=\"0\" style=\"width:{$barTwoWidth}px;height:11px;\"/></span>
					</div>
				</div>
				<div class=\"utilityButtons\" id=\"utilityButtons\">
					<a href=\"javascript:flagImg('" . str_replace("'", "\'", wfMsgForContent('picturegame_flagimgconfirm')) . "')\">" . wfMsgForContent('picturegame_reportimages') . "</a> - 
					<a href=\"javascript:window.parent.document.location='" . Title::makeTitle(NS_SPECIAL, "PictureGameHome")->escapeFullURL("picGameAction=renderPermalink") . "&id=' + \$('id').value\"> " . wfMsgForContent('picturegame_permalink') . "</a> " . $editlinks . " 
				</div>
			</div>
			<div class=\"cleared\">
			<script type=\"text/javascript\" language=\"javascript\">
				{$permalinkJS}
			</script>
			</div>
			<div id=\"preload\" style=\"display:none\">
				{$preload}
				<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0\" width=\"75\" height=\"75\" title=\"hourglass\"> 
				      <param name=\"movie\" value=\"/extensions/wikia/PictureGame/picturegame/ajax-loading.swf\" /> 
				      <param name=\"quality\" value=\"high\" /> 
				      <param name=\"wmode\" value=\"transparent\" /> 
				      <param name=\"bgcolor\" value=\"#ffffff\" /> 
				      <embed src=\"/extensions/wikia/PictureGame/picturegame/ajax-loading.swf\" quality=\"high\" wmode=\"transparent\" bgcolor=\"#ffffff\" pluginspage=\"http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash\"  
				      type=\"application/x-shockwave-flash\" width=\"100\" height=\"100\"> 
				      </embed> 
				 </object>
			</div>
			";

			// " fix syntax coloring

			return $output;

		}

		function createGame(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP,$wgStyleVersion;

			$title = addslashes( $wgRequest->getVal("picGameTitle") );

			$img1 = addslashes ( $wgRequest->getVal("picOneURL") );
			$img2 = addslashes( $wgRequest->getVal("picTwoURL") );
			$img1_caption = addslashes ( $wgRequest->getVal("picOneDesc") );
			$img2_caption = addslashes( $wgRequest->getVal("picTwoDesc") );

			$voteID = addslashes( $wgRequest->getVal("voteID") );
			$voteImage = addslashes( $wgRequest->getVal("voteImage") );

			$key = $wgRequest->getVal("key");
			$chain = $wgRequest->getVal("chain");
			$id = -1;
			
			$dbr =& wfGetDB( DB_MASTER );

			// make sure no one is trying to do bad things
			if($key == md5($chain . $this->SALT) ){

				$sql = "SELECT COUNT(*) AS mycount FROM picturegame_images WHERE
					( img1 = \"" . $img1 . "\" OR img2 = \"" . $img1 . "\" ) AND
					( img1 = \"" . $img2 . "\" OR img2 = \"" . $img2 . "\" ) GROUP BY id;";

				$res = $dbr->query($sql);
				$row = $dbr->fetchObject( $res );

				// if these image pairs dont exist insert them "
				if($row->mycount == 0){
					$sql = "INSERT INTO picturegame_images (userid, username, img1, img2, title, img1_caption, img2_caption, pg_date)
						VALUES(\"" . $wgUser->getID() . "\", \"". $wgUser->getName() . "\", \"" . $img1 . "\", \"" . $img2 . "\", \"" . $title . "\", \"" . $img1_caption . "\", \"" . $img2_caption . "\", \"" . date("Y-m-d H:i:s")  . "\");";
					//"
					$res = $dbr->query($sql);

					$sql = "SELECT MAX(id) AS maxid from picturegame_images WHERE 1;";
					$res = $dbr->query($sql);
					$row = $dbr->fetchObject( $res );
					$id = $row->maxid;
					
					$stats = new UserStatsTrack($wgUser->getID(), $wgUser->getName());
					$stats->incStatField("picturegame_created");
					
					global $wgMemc;
					$key = wfMemcKey( 'user', 'profile', 'picgame' , $wgUser->getID());
					$wgMemc->delete( $key );
					
				  }
			}

			header("Location: ?title=Special:PictureGameHome&picGameAction=startGame&id={$id}");
			
		}
		
		// renders the inital page of the game
		function renderPictureGame(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgStyleVersion;

			$permalinkID =  addslashes( $wgRequest->getVal("id") );
			$lastid = addslashes( $wgRequest->getVal("lastid") );

			if(!is_numeric( $lastid ))
				$lastid = -1;
			
			$isPermalink = false;
			$permalinkError = false;

			$dbr =& wfGetDB( DB_MASTER );
			if($permalinkID > 0){

				$isPermalink = true;
				
				$sql = "SELECT COUNT(*) AS mycount FROM picturegame_images WHERE (flag='NONE' OR flag='PROTECT') AND id=" . $permalinkID . ";";
				$res = $dbr->query($sql);
				$row = $dbr->fetchObject( $res );

				if($row->mycount == 0){
					$output = "
						<style>@import \"{$this->INCLUDEPATH}maingame.css?{$wgStyleVersion}\";</style>
						<div class=\"picgame-container\" id=\"picgame-container\">
							<p>" . 
							//These pictures have been flagged, because of inappropriate 
							//content or copyrighted material. To play the picture game, click the 
							//button below.
							wfMsgForContent('picturegame_permalinkflagged')
							. "</p>
							<p><input type=\"button\" class=\"site-button\" value=\"".
							//Play the Picture Game
							wfMsgForContent('picturegame_buttonplaygame')
							."\" 
							onclick=\"window.location='" . Title::makeTitle(NS_SPECIAL, "PictureGameHome")->escapeFullURL("picGameAction=startGame") . "'\"/>
							</p>
						</div>";
					$wgOut->addHTML( $output );
					return;
					//"
				}
				
			}else{
				$permalinkID = -1;
			}


			$output = "

			<style>@import \"{$this->INCLUDEPATH}maingame.css?{$wgStyleVersion}\";</style>

			<div class=\"picgame-container\" id=\"picgame-container\">" . $this->getImageDivs($isPermalink, $permalinkID, $lastid) . "</div>";

			// " syntax coloring

			$wgOut->addHTML($output);
		}

		// shows the inital page that prompts the image upload
		function showHomePage(){
			global $wgRequest, $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP,$wgStyleVersion, $wgUploadPath;

			if( !$wgUser->isLoggedIn() ){

				//$wgOut->setPagetitle("Create a Picture Game");
                                $wgOut->setPagetitle(wfMsgForContent('picturegame_creategametitle'));
				//$output = "You must log-in to create a picture game.";
                                $output .= wfMsgForContent('picturegame_creategamenotloggedin');
				$output .= "<p>
					<input type=\"button\" class=\"site-button\" onclick=\"window.location='" . Title::makeTitle(NS_SPECIAL, "UserRegister")->escapeFullURL() . "'\" value=\"Sign Up\"/>
					<input type=\"button\" class=\"site-button\" onclick=\"window.location='" . Title::makeTitle(NS_SPECIAL, "Userlogin")->escapeFullURL() . "'\" value=\"Log In\"/>
				</p>";
				$wgOut->addHTML($output);
				return;
			}

			/*/
			/*Create Poll Thresholds based on User Stats
			/*/
			global $wgCreatePictureGameThresholds;
			if( is_array( $wgCreatePictureGameThresholds ) && count( $wgCreatePictureGameThresholds ) > 0 ){
				
				$can_create = true;
				
				$stats = new UserStats( $wgUser->getID(), $wgUser->getName() );
				$stats_data = $stats->getUserStats();
				
				$threshold_reason = "";
				foreach( $wgCreatePictureGameThresholds as $field => $threshold ){
					if ( str_replace(",","",$stats_data[ $field ]) < $threshold ){ 
						$can_create = false;
						$threshold_reason .= (($threshold_reason)?", ":"") . "$threshold $field";
					}
				}
					
				if( $can_create == false ){
					global $wgSupressPageTitle;
					$wgSupressPageTitle = false;
					$wgOut->setPageTitle( wfMsg('picturegame_create_threshold_title') );
					$wgOut->addHTML( wfMsg("picturegame_create_threshold_reason", $threshold_reason) );
					return "";
				}
			}
			
			if( $wgUser->isAllowed('protect') ) {
				//$adminlink = "<a href=\"index.php?title=Special:PictureGameHome&picGameAction=adminPanel\"> Admin Panel </a>";
				$adminlink = "<a href=\"" . Title::makeTitle(NS_SPECIAL, "PictureGameHome")->escapeFullURL("picGameAction=adminPanel") . "\"> " . wfMsgForContent('picturegame_adminpanel') . " </a>";
			}

			//"

			$dbr =& wfGetDB( DB_MASTER );
			$sql = "SELECT COUNT(*) AS mycount FROM picturegame_images WHERE picturegame_images.id NOT IN (SELECT picid FROM picturegame_votes WHERE picturegame_votes.username='" . addslashes($wgUser->getName()) . "') AND flag != 'FLAGGED' and img1<>'' and img2<> '' LIMIT 1;";
			$res = $dbr->query($sql);
			$row = $dbr->fetchObject( $res );

			$canSkip = ($row->mycount != 0 ? true : false);

			// used for the key
			$NOW = time();

			//$wgOut->setHTMLTitle( wfMsg( 'pagetitle', "Create a Picture Game" ) );
                        $wgOut->setHTMLTitle( wfMsg( 'pagetitle', wfMsgForContent('picturegame_creategametitle') ) );

			$output = "<script type=\"text/javascript\" src=\"{$this->INCLUDEPATH}startgame.js?{$wgStyleVersion}\"></script>
			<style>@import \"{$this->INCLUDEPATH}startgame.css?{$wgStyleVersion}\";</style>

				<div class=\"pick-game-welcome-message\">
					<h1>";
                                        //Create a Picture Game
                                        $output .= wfMsgForContent('picturegame_creategametitle');
                                        $output .= "</h1>";
					//Upload two pictures, add some captions, and then go crazy rating everyone's pictures.  Its that easy.
					$output .= wfMsgForContent('picturegame_creategamewelcome');
                                        $output .= "<!-- ' -->
					<br />

					<div id=\"skipButton\" class=\"startButton\">";
                                        $play_button_text = wfMsgForContent('picturegame_creategameplayinstead');
					$output .= ($canSkip ? "<input class=\"site-button\" type=\"button\" onclick=\"javascript:skipToGame()\" value=\"{$play_button_text}\"/>" : "") . "
					</div>
				</div>

				<div class=\"uploadLeft\">
					<div id=\"uploadTitle\" class=\"uploadTitle\">
						<form id=\"picGamePlay\" name=\"picGamePlay\" method=\"post\" action=\"" . Title::makeTitle(NS_SPECIAL,"PictureGameHome")->escapeFullURL("picGameAction=createGame") . "\">
							<h1>";
								//Picture Game Title
                                $output .=                      wfMsgForContent('picturegame_creategamegametitle');
				$output .= 		"</h1>
							<div class=\"picgame-errors\" id=\"picgame-errors\"></div>
							<p>
								<input name=\"picGameTitle\" id=\"picGameTitle\" type=\"text\" value=\"\" size=\"40\"/> </h2>
							</p>

							<input name=\"picOneURL\" id=\"picOneURL\" type=\"hidden\" value=\"\" />
							<input name=\"picTwoURL\" id=\"picTwoURL\" type=\"hidden\" value=\"\" />";
							/*<input name=\"picOneDesc\" id=\"picOneDesc\" type=\"hidden\" value=\"\" />
							<input name=\"picTwoDesc\" id=\"picTwoDesc\" type=\"hidden\" value=\"\" />*/
				$output .=		"<input name=\"key\" type=\"hidden\" value=\"" . md5($NOW . $this->SALT) . "\" />
							<input name=\"chain\" type=\"hidden\" value=\"" . $NOW . "\" />
						</form>
					</div>

					<div class=\"content\">
						<div id=\"uploadImageForms\" class=\"uploadImage\">

							<div id=\"imageOneUpload\" class=\"imageOneUpload\">
								<h1>";
                                                                //First Image
                                                                $output .= wfMsgForContent('picturegame_createeditfirstimage');
                                                                $output .= "</h1>
								<!--Caption:<br/><input name=\"picOneDesc\" id=\"picOneDesc\" type=\"text\" value=\"\" /><br/>-->
								<div id=\"imageOneUploadError\"></div>
								<div id=\"imageOneLoadingImg\" class=\"loadingImg\" style=\"display:none\"> <img src=\"{$wgUploadPath}/common/ajax-loader-white.gif\" /> </div>
								<div id=\"imageOne\" class=\"imageOne\" style=\"display:none;\"></div>
								<iframe class=\"imageOneUpload-frame\" scrolling=\"no\" frameBorder=\"0\" width=\"410\" id=\"imageOneUpload-frame\" src=\"" . $wgRequest->getRequestURL() . "&picGameAction=uploadForm&callbackPrefix=imageOne_\"></iframe>
							</div>

							<div id=\"imageTwoUpload\" class=\"imageTwoUpload\">
                                                                <h1>";
                                                                //Second Image
                                                                $output .= wfMsgForContent('picturegame_createeditsecondimage');
                                                                $output .= "</h1>
								<!--Caption:<br/><input name=\"picTwoDesc\" id=\"picTwoDesc\" type=\"text\" value=\"\" /><br/>-->
								<div id=\"imageTwoUploadError\"></div>
								<div id=\"imageTwoLoadingImg\" class=\"loadingImg\" style=\"display:none\"> <img src=\"{$wgUploadPath}/common/ajax-loader-white.gif\" /> </div>
								<div id=\"imageTwo\" class=\"imageTwo\" style=\"display:none;\"></div>
								<iframe id=\"imageTwoUpload-frame\" scrolling=\"no\" frameBorder=\"0\" width=\"410\" src=\"" . $wgRequest->getRequestURL() . "&picGameAction=uploadForm&callbackPrefix=imageTwo_\"></iframe>
							</div>

							<div class=\"cleared\"></div>
						</div>
					</div>
				</div>

				<div id=\"startButton\" class=\"startButton\" xstyle=\"display: none;\">
					<input type=\"button\" onclick=\"startGame()\" value=\"";
					//Create and Play!
					$output .= wfMsgForContent('picturegame_creategamecreateplay');
					$output .= "\"/>
				</div>

			";

			// "
			$wgOut->addHTML($output);
			}
			
	}

	SpecialPage::addPage( new PictureGameHome );
	
				//read in localisation messages
			function wfPictureGameReadLang(){
				//global $wgMessageCache, $IP, $wgPickGameDirectory;
				global $wgMessageCache, $IP;
				$wgPickGameDirectory = "{$IP}/extensions/wikia/PictureGame";
				require_once ( "$wgPickGameDirectory/PictureGame.i18n.php" );
				foreach( efWikiaPictureGame() as $lang => $messages ){
					$wgMessageCache->addMessages( $messages, $lang );
				}
			}

}

$wgHooks['UserRename::Local'][] = "PictureGameUserRenameLocal";

function PictureGameUserRenameLocal( $dbw, $uid, $oldusername, $newusername, $process, $cityId, &$tasks ) {
	$tasks[] = array(
		'table' => 'picturegame_images',
		'userid_column' => 'userid',
		'username_column' => 'username',
	);
	$tasks[] = array(
		'table' => 'picturegame_votes',
		'userid_column' => 'userid',
		'username_column' => 'username',
	);
	return true;
}

?>
