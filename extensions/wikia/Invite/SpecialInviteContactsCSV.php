<?php

$wgExtensionFunctions[] = 'wfSpecialInviteContactsCSV';

function mb_fgetcsv( $file, $delim = ',', $removeQuotes = true )
{
    $line = trim( fgets( $file ), "\r\n" );
    $fields = array();
    $fldCount = 0;
    $inQuotes = false;
	    
    for ($i = 0; $i < mb_strlen($line); $i++) {
	if (!isset($fields[$fldCount])) $fields[$fldCount] = "";
	$tmp = mb_substr($line, $i, mb_strlen($delim));
	if ($tmp === $delim && !$inQuotes) {
	    $fldCount++;
	    $i+= mb_strlen($delim) - 1;
	}
	else if ($fields[$fldCount] == "" && mb_substr($line, $i, 1) == '"' && !$inQuotes) {
	    if (!$removeQuotes) $fields[$fldCount] .= mb_substr($line, $i, 1);
	    $inQuotes = true;
	} 
	else if (mb_substr($line, $i, 1) == '"') {
	    if (mb_substr($line, $i+1, 1) == '"') {
		$i++;
		$fields[$fldCount] .= mb_substr($line, $i, 1);
	    } else {
		if (!$removeQuotes) $fields[$fldCount] .= mb_substr($line, $i, 1);
		$inQuotes = false;
	    }
	}
	else {
	    $fields[$fldCount] .= mb_substr($line, $i, 1);
	}
    }
    return $fields;
}


function wfSpecialInviteContactsCSV(){
	global $wgUser,$IP;
	#--
	include_once("$IP/includes/SpecialPage.php");


	class InviteContactsCSV extends UnlistedSpecialPage {

		const FILE_SIZE = 20000;

		function InviteContactsCSV(){
			global $wgMessageCache;

			UnlistedSpecialPage::UnlistedSpecialPage("InviteContactsCSV");

			require_once ( dirname( __FILE__ ) . '/Invite.i18n.php' );
			#---
			foreach( efSpecialInviteContacts() as $lang => $messages ) {
				$wgMessageCache->addMessages( $messages, $lang );
			}
		}

		function execute() {
			global $wgUser, $wgOut, $wgRequest, $IP;

			/*/
			/* Redirect Non-logged in users to Login Page
			/* It will automatically return them to the ViewGifts page
			/*/
			if($wgUser->getID() == 0){
				$login =  Title::makeTitle( NS_SPECIAL  , "UserLogin"  );
				$wgOut->redirect( $login->getLocalURL("returnto=Special:InviteContacts") );
				return false;
			}

			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/Invite/css/invite.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$wgOut->addHTML($text);

			$this->domain = $wgRequest->getVal("domain");

			$wgOut->addHTML("<script type=\"text/javascript\" src=\"/extensions/wikia/Invite/GetContacts.js\"></script>\n");
			$wgOut->addHTML("<script type=\"text/javascript\" src=\"/extensions/wikia/getmycontacts/js/ahah.js\"></script>\n");

			if ( count($_POST) ) {
				//UPLOADED CSV FILE
				if ($_POST["upload_csv"] == 1) {
					#---
					$wgOut->setPagetitle( wfMsg('invite_friends') );

					$output = "";

					$output .= "<div class=\"invite-links\">
						<span>
							<a href=\"/index.php?title=Special:InviteContactsCSV\">".wfMsg('find_friends')."</a></span> - <a href=\"/index.php?title=Special:InviteEmail\">".wfMsg('invite_friends')."</a>";

					if ( $wgUser->isLoggedIn() )
					{
						$output .= " - <a href=\"".Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL()."\" /><strong>" . wfMsg('yourprofile') . "</strong></a>";
						$output .= " - <a href=\"".Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL()."\" /><strong>" . wfMsg('youruserpage') . "</strong></a>";
					}

					$output .= "</span>
					</div>";

					$output .= '<form id="form_id" name="myform" method="post" action=""><input type="hidden" name="sendersemail" value="' . $_POST["sendersemail"] . '">';
					$output .= '<div class=\"invite-message\">'.wfMsg('getcontactsmaintitle').'.
					</div>
					<h1>'.wfMsg('yourcontacts').'</h1>
					<p class="contacts-message">
						<span class="profile-on">'.wfMsg('sharewikiafriends').'</span>
					</p>
					<p class="contacts-message">
						<input type="submit" value="'.wfMsg('invite_friends').'" name="B1" /> <a href="javascript:toggleChecked()">'.wfMsg('uncheckallbtn').'</a>
					</p>
					<div class="contacts-title-row">
						<p class="contacts-checkbox"></p>
						<p class="contacts-title">
							'.wfMsg('friendsname').'
						</p>
						<p class="contacts-title">
							'.wfMsg('emailaddr').'
						</p>
						<div class="cleared"></div>
					</div>
					<div class="contacts">';

					if ($wgRequest->getFileSize( 'ufile' ) > self::FILE_SIZE ) {
						$wgOut->addHTML("<div class=\"upload-csv-error\">".wfMsg('uploadfiletolarge')."</div>");
						$wgOut->addHMTL($this->displayForm());
					}

					//OPEING CSV FILE FOR PROCESSING
					$fp = fopen ($wgRequest->getFileTempname( 'ufile' ),"r");
					while (!feof($fp)){
						#---
						//$data = fgetcsv ($fp, 0, ","); //this uses the fgetcsv function to store the quote info in the array $data
						/* gerard@wikia.com - multibyte characters patch till php's fgetcsv doesnt handle them correctly */
						$data = mb_fgetcsv( $fp, ',' );
						//echo "<pre>".print_r($data, true)."</pre>";

						switch ($wgRequest->getVal("email_client")) {
							case "outlook": $dataname = $data[1];
											if (!empty($dataname) && $data[3] ) {
												$dataname = $data[1] . " " . $data[3];
											}
											if (empty($dataname)) {
												$dataname = $data[3];
											}
											$email = $data[57];
											break;
							case "outlook_express":
											$email = $data[1];
											$dataname = $data[0];
											break;
							case "thunderbird":
											$email = $data[4];
											$dataname = $data[2];
											if (empty($dataname) && ($data[0] || $data[1])) {
												$dataname = $data[0] . " " . $data[1];
											}
											break;
						}
						if (empty($dataname)) {
							$dataname = $email;
						}
						if (!empty($email) && $data[0]!="First Name" && $data[0]!="Name" && $data[1]!="First Name") {  //Skip table if email is blank
							$addresses[] = array("name"=>$dataname,"email"=>$email);
						}
					}

					if ($addresses) {
						usort($addresses, 'sortCSVContacts');

						foreach ($addresses as $address) {
							$output .= '<div class="contacts-row">
							<p class="contacts-checkbox">
								<input type="checkbox" name="list[]" value="'.$address["email"].'" checked>
							</p>
							<p class="contacts-cell">
								'.$address["name"].'
							</p>
							<p class="contacts-cell">
								'.$address["email"].'
							</p>
							<div class="cleared"></div>
							</div>';
						}
					}

					$output .= '</div>';
					$output .= '<p>
					<input type="submit" value="'.wfMsg('invite_friends').'" name="B1" /> <a href="javascript:toggleChecked()">'.wfMsg('uncheckallbtn').'</a>
					</p>
					</form>';

					#---
					$wgOut->addHTML($output);
				} else { //USER CLICKED TO SEND EMAIL TO CONTACTS
					$html_format = "no";  //IMPORTANT: change this to "yes"  ONLY if you are sending html format email
					$title = Title::makeTitle( NS_USER , $wgUser->getName()  );
					$subject = wfMsg( 'invite_subject', $wgUser->getName() );

					$body = wfMsg( 'invite_body', $_POST['sendersemail'], $wgUser->getName(), $title->getFullURL() );

$message = <<<EOF

$body

EOF;

					$from = "community@wikia.com";
					$sendersemail = $_POST['sendersemail'];

					$confirm = "";
					$loop = 0;
					foreach($_POST['list'] as $to) {
						$loop++;
						$confirm .= "<div class=\"invite-email-sent\">".$loop.". ".$to."</div>";
						if ($html_format == "yes"){
							/* $headers = "From: $from\n";
							$headers .= "Reply-To: $from\n";
							$headers .= "Return-Path: $from\n";
							$headers .= "MIME-Version: 1.0\n";
							$headers .= "Content-Type: text/html; charset=ISO-8859-1\n";
							mail($to,$subject,$message,$headers); */
							userMailer( new MailAddress( $to ), new MailAddress( $from ), $subject, $message );
						} else {
							//mail($to, $subject, $message, "From: $from\r\nReply-To:$sendersemail");
							userMailer( new MailAddress( $to ), new MailAddress( $from ), $subject, $message, new MailAddress( $sendersemail ) );
						}
					}

					$wgOut->setPagetitle( wfMsg('msg_sent') );
					$wgOut->addHTML("<p class=\"user-message\">".wfMsg('emailswentout')." " . $confirm. "</p>");
					$wgOut->addHTML("<div class=\"relationship-request-buttons\">
					  <input type=\"button\" value=\"".wfMsg('home')."\" onclick=\"window.location='/index.php?title=Main_Page'\"/>
					  <input type=\"button\" value=\"".wfMsg('yourprofile')."\" onclick=\"window.location='" . Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL() . "'\"/>
					  <input type=\"button\" value=\"".wfMsg('youruserpage')."\" onclick=\"window.location='" . Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL() . "'\"/>
					  </div>");
				}
			} else {
				#---
				$wgOut->setPagetitle( wfMsg('invite_friends') );
				$wgOut->addHTML($this->displayForm());
			}
		}

		function displayForm() {
			global $wgUser, $wgOut, $wgRequest, $IP;
			$out = "";

			$out .= "<div class=\"invite-links\">
			<span><a href=\"/index.php?title=Special:InviteEmail\">".wfMsg('invite_friends')."</a>";
			if ( $wgUser->isLoggedIn() )
			{
				$out .= " - <a href=\"".Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL()."\" /><strong>" . wfMsg('yourprofile') . "</strong></a>";
				$out .= " - <a href=\"".Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL()."\" /><strong>" . wfMsg('youruserpage') . "</strong></a>";
			}
			$out .= "</span>
			</div>";
			$out .= "<script>
			function uploadCSV(f){
				if(!f.sendersemail.value){
					alert('".wfMsg('entervalidemail')."');
				}else{
					document.emailform.submit();
				}
			}
			</script>
			<div class=\"invite-message\">".wfMsg('getcontactsmaintitle').".</div>
			<div id=\"target\">
			<div class=\"invite-left\">
			<div class=\"cleared\"></div>
			<div class=\"invite-icons\">
				<img src=\"/extensions/wikia/getmycontacts/images/myoutlook.gif\" border=\"0\">
				<img src=\"/extensions/wikia/getmycontacts/images/myexpress.gif\" border=\"0\">
				<img src=\"/extensions/wikia/getmycontacts/images/mythunderbird.gif\" border=\"0\">
			</div>
			<div class=\"invite-form\">
				<form name=emailform action=\"\" enctype=\"multipart/form-data\"  method=post>
				<input type=\"hidden\" name=\"upload_csv\" value=\"1\">
				<p>".wfMsg('csvfilelimit')."</p>
				<p class=\"invite-form-title\">".wfMsg('selectemailclient')."</p>
				<p class=\"invite-form-input\">
				<select name=\"email_client\">
				<option value=\"outlook\">Outlook</option>
				<option value=\"outlook_express\">Outlook Express</option>
				<option value=\"thunderbird\">Thunderbird</option>
				</select>
				</p>
				<div class=\"cleared\"></div>
				<p class=\"invite-form-title\">".wfMsg('selectcsvfile')."</p>
				<p class=\"invite-form-input\"><input name=\"ufile\" type=\"file\" id=\"ufile\" size=\"20\" /></p>
				<div class=\"cleared\"></div>
				<p class=\"invite-form-title\">".wfMsg('verifyemail')."</p>
				<p class=\"invite-form-input\"><input name=\"sendersemail\" type=\"text\" id=\"sendersemail\" size=\"28\" value=\"{$wgUser->getEmail()}\"/></p>
				<p><input type=\"button\" onclick=\"javascript:uploadCSV(this.form)\" value=\"".wfMsg('uploadyourcontacts')."\"></p>
			</div>";
			$out .= "</div>";
/*			$out .= "<div class=\"invite-right\">
			<h1>".wfMsg('queshavewebmail')."</h1>
			<p class=\"invite-right-image\">
				<a href=\"/index.php?title=Special:InviteContacts\"><img src=\"/extensions/wikia/getmycontacts/images/myyahoo.gif\" border=\"0\"></a>
				<a href=\"/index.php?title=Special:InviteContacts\"><img src=\"/extensions/wikia/getmycontacts/images/mygmail.gif\" border=\"0\"></a>
			</p>
			<p class=\"invite-right-image\">
				<a href=\"/index.php?title=Special:InviteContacts\"><img src=\"/extensions/wikia/getmycontacts/images/myhotmail.gif\" border=\"0\"></a>
				<a href=\"/index.php?title=Special:InviteContacts\"><img src=\"/extensions/wikia/getmycontacts/images/myaol.gif\" border=\"0\"></a>
			</p>
			<div class=\"cleared\"></div>
			<p  align=\"center\"><input type=\"button\" value=\"".wfMsg('invite_friends')."\" onclick=\"window.location='/index.php?title=Special:InviteContacts'\"/></p>
			</div>*/
			$out .= "<div class=\"cleared\"></div>
			</div></form>";

			#---
			return $out;
		}

	}

	SpecialPage::addPage( new InviteContactsCSV );
	global $wgMessageCache,$wgOut;
}

function sortCSVContacts($x, $y){
	if ( strtoupper($x["name"]) == strtoupper($y["name"]) )
	 return 0;
	else if ( strtoupper($x["name"]) < strtoupper($y["name"]) )
	 return -1;
	else
	 return 1;
}
?>
