<?php
class LinkEdit extends UnlistedSpecialPage {

	function LinkEdit(){
		UnlistedSpecialPage::UnlistedSpecialPage("LinkEdit");
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
		
		if ( !Link::CanAdmin() ) {
		    $this->displayRestrictionError();
		    return;
		}       
		
		
		if ( $wgRequest->wasPosted() && $_SESSION["alreadysubmitted"] == false ) {
			
			$_SESSION["alreadysubmitted"] = true;
			
			//update link
			$dbr =& wfGetDB( DB_MASTER );
			$dbr->update( '`link`',
				array(
				'link_url' => $_POST["lf_URL"],
				'link_description' => $_POST["lf_desc"],
				'link_type' => $_POST["lf_type"]
				), 
				array( /* WHERE */
				'link_page_id' => $wgRequest->getVal("id")
				), ""
			);
			
			$title = Title::newFromId( $wgRequest->getVal("id") );
			$wgOut->redirect($title->getFullURL());
			
		} else {
			
			
			$wgOut->addHTML( $this->displayAddForm() );
		}
		
	}
	
	function displayAddForm() {
		global $wgOut, $wgRequest;
		
		$url = $wgRequest->getVal("_url");
		$title = $wgRequest->getVal("_title");
		
		$l = new Link();
		$link = $l->getLinkByPageID( $wgRequest->getVal("id") );
		
		if( is_array( $link ) ){
			$url = htmlspecialchars( $link["url"], ENT_QUOTES );
			$description = htmlspecialchars( $link["description"], ENT_QUOTES );
		}else{
			$title = Title::makeTitle( NS_SPECIAL, "LinkSubmit");
			$wgOut->redirect($title->getFullURL());
		}
		
		$wgOut->setPageTitle( wfMsg('linkfilter-edit-title', $link["title"] ) );
		
		$_SESSION["alreadysubmitted"] = false;
		$output = "";
		
		$output .= "<script>
			function submit_link(){
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
					<label >".wfMsg('linkfilter-url')."</label>
				</div>
				<input tabindex=\"2\" class=\"lr-input\" type=\"text\" name=\"lf_URL\" id=\"lf_URL\" value=\"{$url}\"/>
				
				<div class=\"link-submit-title\">	
					<label >".wfMsg('linkfilter-description')."</label>
				</div>
				<div class=\"link-characters-left\">" . wfMsg("linkfilter-description-max") . " - <span id=\"desc-remaining\">300</span> " . wfMsg("linkfilter-description-left") . "</div>
				<textarea tabindex=\"3\" class=\"lr-input\" onKeyUp=\"limit_text(document.link.lf_desc,300)\" onKeyDown=\"limit_text(document.link.lf_desc,300)\" rows=4 name=\"lf_desc\" id=\"lf_desc\" />{$description}</textarea>
				 
				<div class=\"link-submit-title\">
					<label>".wfMsg('linkfilter-type')."</label>
				</div>
				<select tabindex=\"4\" name=\"lf_type\" id=\"lf_type\">
				<option value=\"\">-</option>
				";
				$link_types = Link::getLinkTypes();
				foreach($link_types as $id => $type){
					$output .= "<option value=\"{$id}\" " . (($link["type"]==$id)?"selected":"") . ">{$type}</option>";
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