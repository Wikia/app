<?php

require_once( "FlickrImport.i18n.php" );


$wgExtensionFunctions[] = 'wfImageImport';


function wfImageImport() {

	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");

	class ImageImport extends SpecialPage {
	
		function ImageImport(){
			SpecialPage::SpecialPage("ImportImage");
		}
		
		function execute(){
			
			# Add messages
			global $wgMessageCache, $wgFlickrImportMessages;
			foreach( $wgFlickrImportMessages as $key => $value ) {
				$wgMessageCache->addMessages( $wgFlickrImportMessages[$key], $key );
			}
		      
		        global $IP, $wgRequest, $wgStyleVersion, $wgOut, $wgUser,$wgIFI_FlickrAPIKey;

			if( $wgUser->isBlocked() ){
				$wgOut->blockedPage( false );
				return false;
			}

			if ( $wgUser->isAnon() ) {
				$login = Title::makeTitle(NS_SPECIAL, "Login");
				$wgOut->errorpage( 'importfreeimages-login-title', 'importfreeimages-login-text' );
				return true;
			}
			
			require_once("$IP/extensions/wikia/FlickrImport/FlickrImportClass.php");
			require_once("phpFlickr-2.1.0/phpFlickr.php");
			
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/FlickrImport/FlickrImport.css?{$wgStyleVersion}\"/>\n");
			$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/wikia/FlickrImport/FlickrImport.js?{$wgStyleVersion}\"></script>\n");
			
			$wgOut->addHTML("<script>
					var _IMPORTING_MSG = \"" . wfMsgForContent( 'importfreeimages_importing' ) . "\"
					var _LOADING_MSG = \"" . wfMsgForContent( 'importfreeimages_loading' ) . "\"
					</script>
					");
			
			$from = urldecode($wgRequest->getVal("wpFrom"));
			$categories = urldecode($wgRequest->getVal("wpCategories"));
			$q = $wgRequest->getVal("q");
			
			if( $from ){
				$from_title = Title::newFromDBkey( $from );
				$from_url = $from_title->getFullURL();
				$from_text = $from_title->getText();
			}
		
			$importPage = Title::makeTitle(NS_SPECIAL, "ImportImage");
			
			
			if (empty($wgIFI_FlickrAPIKey)) {
				// error - need to set $wgIFI_FlickrAPIKey to use this extension
				$wgOut->errorpage('error', 'importfreeimages_noapikey');
				return;
			}	
			
			$f = new FlickrImport($wgIFI_FlickrAPIKey); 
			
			//User has select photos to import
			if( $wgRequest->wasPosted() ){
				if ( $wgRequest->getVal("ids") ){
					$photos = explode(",", $wgRequest->getVal("ids") );
					$count = 0;
					foreach($photos as $photo){
						$photo_array = explode("|", $photo );
						$photo_id = $photo_array [0];
						$photo_title = $photo_array [1];
						$image_name = $f->importPhoto( $photo_id, $q, $photo_title );
						$images .=  "Image:" . str_replace("\"","",$image_name) . "\n";
						$count++;
					}
					
					$wgOut->setPagetitle( wfMsgForContent( 'importfreeimages_importsuccess' ) );
					//Show success and build gallery of newly uplaoded images
					$wgOut->addHTML( wfMsgForContent('importfreeimages_success', $count) );
					if ($count!=1)$wgOut->addHTML(wfMsgForContent('importfreeimages_success_plural'));
					$wgOut->addHTML(".");
					if( $from ){
						$wgOut->addHTML(" " . wfMsgForContent('importfreeimages_return') . " <a href=\"{$from_url}\">{$from_title->getText()}</a>.");
					}
					$wgOut->addHTML("<p>");
					$wgOut->addWikiText("<gallery widths=\"140px\" heights=\"110px\" perrow=\"5\">$images<gallery>");
					
					return "";
				}
			} 
			
			//Display Form for searching/selecting images
			$upload_title = Title::makeTitle(NS_SPECIAL,"Upload");
			if($categories){
				$categories_qs = "&wpCategories=" . urlencode($categories);
			}
			
			if (!$q) { 
				$output .= "<div class=\"import-subtitle\">" . wfMsgForContent( 'importfreeimages_addsubtitle') . "</div>";
			} else{
				//Display Selected Photos Section
				$output .= "<div id=\"selected-container\" class=\"selected-photos\">
						<div class=\"selected-photos-title\">" . wfMsgForContent('importfreeimages_selectedphotos') . "</div>
						<div class=\"selected-photos-button\">
							<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent('importfreeimages_submitbutton') . "\" onclick=\"import_photos()\">
						</div>
						<div id=\"select-instructions\">
						".wfMsgForContent( 'importfreeimages_submitinstructions')."
						</div>
					</div>";
			}
			$output .= "<div class=\"import-left-content\">
				<div class=\"image-options\">
					<div class=\"image-options-button\">
						<a href=\"javascript:show_flickr_search();\" id=\"search_flickr_button\">" . wfMsgForContent( 'importfreeimages_searchbutton') . "</a>
					</div> 
					<div class=\"image-options-button\">
						<a href=\"".$upload_title->escapeFullURL('wpRedirect='.urlencode($from))."\">" . wfMsgForContent( 'importfreeimages_uploadbutton') . "</a>
					</div>
					<div class=\"cleared\"></div>
			</div>";
			
			//Flickr search form (starts hidden)
			
				$output .= "<div id=\"flickr-search\" class=\"import-search\" style=\"".(($q || $from)?"display:block":"display:none")."\">
					<div class=\"import-search-padding\">".wfMsg('importfreeimages_description')."
						<br/><br/>
						<form name=flickr method=GET  action='" . $importPage->getFullURL() . "'><b>".wfMsg('search').
						"</b> <input type=text name=q onKeyPress=\"detEnter(event)\" value=\"" . ((!$q)?htmlspecialchars($from_text):htmlspecialchars($q) ) . "\">
						<input type=hidden name=title value=\"" .  $importPage->getPrefixedText() . "\">
						<input type=hidden name=wpCategories value=\"" .  htmlspecialchars($wgRequest->getVal("wpCategories")) . "\">
						<input type=hidden name=wpFrom value=\"" .  htmlspecialchars($wgRequest->getVal("wpFrom"))  . "\">
						<input class=\"site-button\" type=\"button\"   onclick=\"javascript:submit_flickr_search()\" value=".wfMsg('search')."></form>
						<p>
					</div>
				</div>
				";
	
			//User has searched for Flickr images...show the results
			if ($q != '') { 
				$wgOut->setPagetitle( wfMsgForContent( 'importfreeimages_flickrsearchtitle' ) );
				$output .= "<form name=\"photos\" method=\"POST\" action=\"\">
					<input type=\"hidden\" name=\"ids\" id=\"ids\" value=\"\">
					</form>";
				
				$output .= "<div id=\"flickr-results\" class=\"flickr-results\">";
				$output .= $f->getPhotos( 1,$q );
				$output .= "</div>";
	
			}else{
				
				$wgOut->setPagetitle( wfMsgForContent( 'importfreeimages_addtitle', $from_text) );	
			}
			
			$output .= "<div class=\"cleared\"></div>
				
				</div>
				<div id=\"loading\" class=\"loading-message\" style=\"display:none;\">
						" . wfMsg("importfreeimages_loading") . "
				</div>
			<div class=\"cleared\"></div>";
			
			$wgOut->addHTML( $output  );
		}
		
		
	}
	SpecialPage::addPage( new ImageImport );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'importimage', 'Import Image' );
}
?>
