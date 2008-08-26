<?php

$wgExtensionFunctions[] = 'wfSpecialEmailNewArticle';


function wfSpecialEmailNewArticle(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");

	class EmailNewArticle extends UnlistedSpecialPage {
	
		function EmailNewArticle(){
			UnlistedSpecialPage::UnlistedSpecialPage("EmailNewArticle");
		}
	
		function execute(){
			global $wgOut, $wgUser, $wgRequest;
			
			$wgOut->setPagetitle( "Share Your Article With Your Friends!" );
			
			$new_page  =  Title::makeTitle( NS_MAIN  , $wgRequest->getVal("page")  );
			$invite =  Title::makeTitle( NS_SPECIAL  , "InviteEmail"  );
			
			$css = "<style>
			.email-new-article-box {
				background-color:#78BA5D;
				border:1px solid #285C98;
				color:#ffffff;
				float:left;
				padding:5px;
				font-size:1.1em;
				margin:0px 10px 0px 0px;
				width:150px;
				text-align:center;
			}
			.email-new-article-box a{
				text-decoration:none;
				color:#ffffff;
			}
			
			.email-new-article-message {
				font-size:1.1em;
				color:#666666;
				margin:0px 0px 15px 0px;
				width:500px;
			}
			</style>";
			$wgOut->addHTML($css);
			
			$output = "";
			$output .= "<div class=\"email-new-article-message\">" . wfMsg( 'send_new_article_to_friends_message') . "</div>
				<input type=\"button\" class=\"site-button\" onclick=\"window.location='" . $invite->getFullURL("email_type=view&page={$wgRequest->getVal("page")}") . "'\" value=\"Invite My Friends\"/> 
				<input type=\"button\" class=\"site-button\" onclick=\"window.location='{$new_page->getFullURL()}'\" value=\"No Thanks\"/>";
			$wgOut->addHTML($output);
		}
		
	}
	
	SpecialPage::addPage( new EmailNewArticle );
	global $wgMessageCache,$wgOut;
}

?>
