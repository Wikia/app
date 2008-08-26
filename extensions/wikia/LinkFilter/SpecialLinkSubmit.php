<?php
class LinkSubmit extends UnlistedSpecialPage {

	function LinkSubmit(){
		UnlistedSpecialPage::UnlistedSpecialPage("LinkSubmit");
	}

	function execute(){
		
		global $IP, $wgUser, $wgOut, $wgRequest, $wgSitename, $wgMessageCache, $wgLinkFilterScripts; 
		
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgLinkFilterScripts}/LinkFilter.css?{$wgStyleVersion}\"/>\n");
		
		//language messages
		require_once ( "LinkFilter.i18n.php" );
		foreach( efWikiaLinkFilter() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}

		if( $wgUser->isBlocked() ){
			$wgOut->blockedPage( false );
			return false;
		}
		
		if( in_array( "no_link_submit", $wgUser->getGroups() ) ) {
			$wgOut->errorpage( 'error', 'badaccess' );
			return true;
		}
		
		if ( $wgUser->isAnon() ) {
			$login = Title::makeTitle(NS_SPECIAL, "Login");
			$wgOut->errorpage( 'linkfilter-login-title', 'linkfilter-login-text' );
			return true;
		}
		
		
		if ( $wgRequest->wasPosted() && $_SESSION["alreadysubmitted"] == false ) {
			
			$_SESSION["alreadysubmitted"] = true;
			
			if ( !$_POST["lf_title"]) {
				$wgOut->setPageTitle( wfMsg('error') );
				$wgOut->addHTML( $this->displayAddForm() );
				return true;
			}
			
			$link = new Link();
			
			if ( $link->isURL( $_POST["lf_URL"] ) ) {
				$link->addLink( $_POST["lf_title"] , $_POST["lf_desc"], $_POST["lf_URL"], $_POST["lf_type"] );
				$wgOut->setPageTitle( wfMsg('linkfilter-submit-success-title') );
				$wgOut->addHTML( "<div class=\"link-success-text\">" . wfMsg('linkfilter-submit-success-text') . "</div>" );
				$wgOut->addHTML( "<div class=\"link-submit-button\"><input type=\"button\" onclick=\"window.location='".Link::getSubmitLinkURL()."'\" value=\"".wfMsg('linkfilter-submit-another')."\"/></div>" );
			}
		} else {
			
			$wgOut->setPageTitle( wfMsg('linkfilter-submit-title') );
			$wgOut->addHTML( $this->displayAddForm() );
		}
		
	}
	
	function displayAddForm() {
		global $wgRequest;
		
		$url = $wgRequest->getVal("_url");
		$title = $wgRequest->getVal("_title");
		
		if( !$url ){
			$url = "http://";
		}
		
		if( !$title ){
			$title = $_POST["lf_title"];
		}
		
		$_SESSION["alreadysubmitted"] = false;
		$output = "";
		
		$output .= "<script>
			function submit_link(){
				if(\$('lf_title').value == '' ){
					alert(\"" . wfMsg("linkfilter-submit-no-title" ) . "\");
					return '';
				}
				if(\$('lf_type').value == '' ){
					alert(\"" . wfMsg("linkfilter-submit-no-type" ) . "\");
					return '';
				}					
				document.link.submit();
			}
			
			function limit_text(field, limit) {
				if (field.value.length > limit){
					field.value = field.value.substring(0, limit);
					
				}
				\$(\"desc-remaining\").innerHTML = limit - field.value.length
			}

		</script>";
		
		$output .= "<div class=\"lr-left\">
			
			<div class=\"link-home-navigation\">
				<a href=\"" . Link::getHomeLinkURL() . "\">" . wfMsg("linkfilter-home-button") . "</a>";

				if( Link::CanAdmin() ){
					$output .= " <a href=\""  . Link::getLinkAdminURL() . "\">" . wfMsg("linkfilter-approve-links") . "</a>";
				}
			
				$output .= "<div class=\"cleared\"></div>
			</div>
			<form name=\"link\" id=\"linksubmit\" method=\"post\" action=\"\">
				<div class=\"link-submit-title\">
					<label >".wfMsg('linkfilter-title')."</label>
				</div>
				<input tabindex=\"1\" class=\"lr-input\" type=\"text\" name=\"lf_title\" id=\"lf_title\" value=\"{$title}\" maxlength=\"150\" />
				<div class=\"link-submit-title\">	
					<label >".wfMsg('linkfilter-url')."</label>
				</div>
				<input tabindex=\"2\" class=\"lr-input\" type=\"text\" name=\"lf_URL\" id=\"lf_URL\" value=\"{$url}\"/>
				
				<div class=\"link-submit-title\">	
					<label >".wfMsg('linkfilter-description')."</label>
				</div>
				<div class=\"link-characters-left\">" . wfMsg("linkfilter-description-max") . " - <span id=\"desc-remaining\">300</span> " . wfMsg("linkfilter-description-left") . "</div>
				<textarea tabindex=\"3\" class=\"lr-input\" onKeyUp=\"limit_text(document.link.lf_desc,300)\" onKeyDown=\"limit_text(document.link.lf_desc,300)\" rows=4 name=\"lf_desc\" id=\"lf_desc\" value=\"{$_POST["lf_desc"]}\"/></textarea>
				 
				<div class=\"link-submit-title\">
					<label>".wfMsg('linkfilter-type')."</label>
				</div>
				<select tabindex=\"4\" name=\"lf_type\" id=\"lf_type\">
				<option value=\"\">-</option>
				";
				$link_types = Link::getLinkTypes();
				foreach($link_types as $id => $type){
					$output .= "<option value=\"{$id}\">{$type}</option>";
				}
				$output .= "</select>
				<div class=\"link-submit-button\">
					<input tabindex=\"5\" class=\"site-button\" type=\"button\" onclick=\"javascript:submit_link()\" value=\"".wfMsg('linkfilter-submit-button')."\"/>
				</div>
			</form>
		</div>";
		
		$output .= "<div class=\"lr-right\">
			".wfMsgExt("linkfilter-instructions","parse")."
		</div>
		<div class=\"cleared\"></div>";
		return $output;
	}

}
	
	

?>