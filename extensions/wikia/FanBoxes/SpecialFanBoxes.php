<?php
//GLOBAL FANTAG NAMESPACE REFERENCE
if( !defined( 'NS_FANTAG' ) ) {
	define( 'NS_FANTAG', 600 );
}

$wgExtensionFunctions[] = 'wfFanBoxes';

function wfFanBoxes(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class FanBoxes extends SpecialPage {

	
	function FanBoxes(){
		UnlistedSpecialPage::UnlistedSpecialPage("UserBoxes");		
	}
	
	
	function execute(){
		global $IP, $wgOut, $wgUser, $wgTitle, $wgRequest, $wgContLang, $wgMessageCache, $wgStyleVersion, $wgFanBoxScripts;

		require_once ( "FanBox.i18n.php" );
		
		foreach( efWikiaFantag() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
			
		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgFanBoxScripts}/FanBoxes.js\"></script>\n");
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgFanBoxScripts}/FanBoxes.css\"/>\n");
		//colorpicker
		$wgOut->addScript("<script type=\"text/javascript\" src=\"http://yui.yahooapis.com/2.4.1/build/utilities/utilities.js\" ></script>\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"http://yui.yahooapis.com/2.4.1/build/slider/slider-min.js\" ></script>\n");
		$wgOut->addScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"http://yui.yahooapis.com/2.4.1/build/colorpicker/assets/skins/sam/colorpicker.css\"/>\n");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"http://yui.yahooapis.com/2.4.1/build/colorpicker/colorpicker-beta-min.js\" ></script>\n");
		
		//set it up so that you must be logged in to create a game
	
		if($wgUser->getID() == 0 ){
				$wgOut->setPagetitle( "Woops!" );
				$login =  Title::makeTitle( NS_SPECIAL  , "Login"  );
				$wgOut->redirect( $login->getFullURL("returnto=Special:UserBoxes")  );
				return false;
		}
			
		$title = str_replace("#","",$wgRequest->getVal("wpTitle"));
		$fanboxid = $wgRequest->getVal("id");
		
		//set up the edit fanbox part
		
		if ($fanboxid){ 
			
			$title = Title::newFromID($fanboxid);
			$update_fan = new FanBox( $title);
			
			//get categories
			$dbr =& wfGetDB( DB_SLAVE );
			$res = $dbr->select( '`categorylinks` ', 'cl_to', 
				array( 'cl_from' => $fanboxid), __METHOD__, 
				$params
			);
			
			$categories = "";
			
			while ($row = $dbr->fetchObject( $res ) ) {
				if( $row->cl_to != "Userboxes" && strpos($row->cl_to, "Userboxes_by_User_" ) === false  ){
					$categories .= (($categories)?", ":"") . $row->cl_to;
				}
			}

		
			$output.= "
			<form action=\"\" method=\"post\" name=\"form1\">
			<input type=\"hidden\" name=\"fantag_image_name\" id=\"fantag_image_name\" value=\"{$update_fan->getFanBoxImage()}\">
			<input type=\"hidden\" name=\"textSizeRightSide\" id=\"textSizeRightSide\" value=\"{$update_fan->getFanBoxRightTextSize()}\" >
			<input type=\"hidden\" name=\"textSizeLeftSide\" id=\"textSizeLeftSide\" value=\"{$update_fan->getFanBoxLeftTextSize()}\">			
			<input type=\"hidden\" name=\"bgColorLeftSideColor\" id=\"bgColorLeftSideColor\" value=\"{$update_fan->getFanBoxLeftBgColor()}\">
			<input type=\"hidden\" name=\"textColorLeftSideColor\" id=\"textColorLeftSideColor\" value=\"{$update_fan->getFanBoxLeftTextColor()}\">
			<input type=\"hidden\" name=\"bgColorRightSideColor\" id=\"bgColorRightSideColor\" value=\"{$update_fan->getFanBoxRightBgColor()}\">
			<input type=\"hidden\" name=\"textColorRightSideColor\" id=\"textColorRightSideColor\" value=\"{$update_fan->getFanBoxRightTextColor()}\">";
		
				if($update_fan->getFanBoxImage()){
					$fantag_image_width = 45;
					$fantag_image_height = 53;
					$fantag_image = Image::newFromName( $update_fan->getFanBoxImage());
					$fantag_image_url = $fantag_image->createThumb($fantag_image_width, $fantag_image_height);
					$fantag_image_tag = '<img alt="" src="' . $fantag_image_url . '"/>';
					};
						
				if ($update_fan->getFanBoxLeftText() == ""){
					$fantag_leftside = $fantag_image_tag;
					$fantag_imageholder = $fantag_image_tag;
				}
				else {
					$fantag_leftside = $update_fan->getFanBoxLeftText();
					$fantag_imageholder = "";

				}
				
				if ($update_fan->getFanBoxLeftTextSize() == "mediumfont"){
					$leftfontsize= "14px";
				}
				if ($update_fan->getFanBoxLeftTextSize() == "bigfont"){
					$leftfontsize= "20px";
				}
				
				if ($update_fan->getFanBoxRightTextSize() == "smallfont"){
					$rightfontsize= "12px";
				}
				if ($update_fan->getFanBoxRightTextSize() == "mediumfont"){
					$rightfontsize= "14px";
				}
				
				
				$output.="
				<table  class=\"fanBoxTable\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >
				<tr><td id=\"fanBoxLeftSideContainer\" bgcolor=\"".$update_fan->getFanBoxLeftBgColor()."\">
						<table cellspacing=\"0\" width=\"55px\" height=\"63px\">
							<tr>
							<td id=\"fanBoxLeftSideOutput2\" style=\"color:".$update_fan->getFanBoxLeftTextColor()."; font-size:$leftfontsize\">".$fantag_leftside."</td>					
						</table>
						</td>
					<td id=\"fanBoxRightSideContainer\" bgcolor=\"".$update_fan->getFanBoxRightBgColor()."\">
							<table cellspacing=\"0\" >
								<tr>
								<td id=\"fanBoxRightSideOutput2\" style=\"color:".$update_fan->getFanBoxRightTextColor()."; font-size:$rightfontsize\">".$update_fan->getFanBoxRightText()." </td>
							</table>
					</td> 
				</table>";
				
			$output.= "<h1>". wfMsgForContent( 'fanbox_addtext' ) ."</h1>
				<div class=\"create-fanbox-text\">
					<div id=\"fanbox-left-text\">
						<h3>". wfMsgForContent( 'fanbox_leftsidetext' ) ."<span id=\"addImage\" onclick=\"displayAddImage('create-fanbox-image', 'addImage', 'closeImage')\">". wfMsgForContent( 'fanbox_display_image' ) ."</span> <span id=\"closeImage\" onclick=\"displayAddImage('create-fanbox-image', 'closeImage', 'addImage')\">". wfMsgForContent( 'fanbox_close_image' ) ."</span></h3>
						<input type=\"text\" name=\"inputLeftSide\" id=\"inputLeftSide\" value=\"{$update_fan->getFanBoxLeftText()}\" oninput=\"displayLeftSide(); leftSideFanBoxFormat()\" onkeyup=\"displayLeftSide(); leftSideFanBoxFormat()\" onkeydown=\"displayLeftSide(); leftSideFanBoxFormat()\" onpaste=\"displayLeftSide(); leftSideFanBoxFormat()\" onkeypress=\"displayLeftSide(); leftSideFanBoxFormat()\"  
						maxlength=\"11\"><br>
						<font size=\"1\">". wfMsgForContent ('fanbox_leftsideinstructions')."</font>
					</div>
					<div id=\"fanbox-right-text\">
						<h3>". wfMsgForContent( 'fanbox_rightsidetext' ) ."<span class=\"fanbox-right-text-message\">". wfMsgForContent ('fanbox_youhave')."<input readonly type=\"text\" name=\"countdown\" style=\"width:20px; height:15px;\" value=\"70\"> ". wfMsgForContent ('fanbox_charactersleft')."</span></h3> 
						<input type=\"text\" name=\"inputRightSide\" id=\"inputRightSide\" style=\"width:350px\" value=\"{$update_fan->getFanBoxRightText()}\" oninput=\"displayRightSide(); 
						rightSideFanBoxFormat()\"
						onKeyDown=\"limitText(this.form.inputRightSide,this.form.countdown,70); displayRightSide(); rightSideFanBoxFormat()\" 
						onKeyUp=\"limitText(this.form.inputRightSide,this.form.countdown,70); displayRightSide(); rightSideFanBoxFormat()\" 
						onpaste=\"limitText(this.form.inputRightSide,this.form.countdown,70); displayRightSide(); rightSideFanBoxFormat()\"
						onkeypress=\"limitText(this.form.inputRightSide,this.form.countdown,70); displayRightSide(); rightSideFanBoxFormat()\"
						maxlength=\"70\"><br>
						<font size=\"1\">". wfMsgForContent ('fanbox_rightsideinstructions')."</font>
					</div>
					</form>		
				</div>";
				
			$output.="
					<div id=\"create-fanbox-image\" class=\"create-fanbox-image\">
						<h1>". wfMsgForContent( 'fanbox_leftsideimage' ) ." <font size=\"1\">". wfMsgForContent( 'fanbox_leftsideimageinstructions' ) ." </font></h1>
						<div id=\"fanbox_image\" onclick=\"insertImageToLeft()\">$fantag_imageholder</div>
						<div id=\"fanbox_image2\"> </div>	
						<div id=\"real-form\" style=\"display:block;height:70px;\">
						<iframe id=\"imageUpload-frame\" class=\"imageUpload-frame\" width=\"410\"
						scrolling=\"no\" frameborder=\"0\" donload=\"check_iframe()\" src=\"/index.php?title=Special:FanBoxAjaxUpload\">
						</iframe>
						</div>
					</div>";
		
			$output.= $this->colorPickerAndCategoryCloud();


			$output.="
			<div class=\"create-fanbox-buttons\">
				<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'fanbox_update_button' ) . "\" size=\"20\" onclick=\"create_fantag()\" />
			</div>";
			
					$output.="<script>
						
						function reset_upload(){
							\$('imageUpload-frame').src=\"/index.php?title=Special:FanBoxAjaxUpload\"
							YAHOO.widget.Effects.Show(\"imageUpload-frame\");
						}
						
						function completeImageUpload(){
							\$('fanbox_image').innerHTML ='<div style=\"margin:0px 0px 10px 0px;\"><img height=\"30\" width=\"30\" src=\"../../images/common/ajax-loader-white.gif\"></div>'
							\$('fanBoxLeftSideOutput2').innerHTML ='<div style=\"margin:0px 0px 10px 0px;\"><img height=\"30\" width=\"30\" src=\"../../images/common/ajax-loader-white.gif\"></div>'
						}
						
						function uploadComplete(img_tag,img_name){
							\$(\"fanbox_image\").innerHTML = img_tag
							\$(\"fanbox_image2\").innerHTML = '<p><a href=\'javascript:reset_upload();\'>Upload New Image</a></p>'
							\$(\"fanbox_image\").value = img_name
							
							\$(\"fanBoxLeftSideOutput2\").innerHTML = img_tag
							\$(\"fantag_image_name\").value = img_name
							
							\$(\"inputLeftSide\").value = \"\"						
							YAHOO.widget.Effects.Hide(\"imageUpload-frame\");
						}
					</script>
			";
			
			$output.="<script>
						
						function create_fantag(){
									
							if(!\$(\"inputRightSide\").value){
								alert(\"You must enter text for the right side\");
								return '';
							}
							
							if(!\$(\"inputLeftSide\").value && !\$(\"fantag_image_name\").value){
								alert(\"You must enter either text or an image for the left side\");
								return '';
							}
							
							document.form1.submit();
	
							
						}
	
					</script>";


		}
		
		
		//set it up so that the pagetitle includes the title of the red link that the user clicks on

		$destination = $wgRequest->getVal("destName");
		$page_title=wfMsgForContent( 'fan_addfan_title' );
		if($destination)$page_title=wfMsgForContent( 'fan_addfan_title' )." for ".str_replace("_", " ", $destination);
		if($fanboxid)$page_title=wfMsgForContent( 'fan_updatefan' ).str_replace("_", " ", $update_fan-> getName()).wfMsgForContent( 'fan_updatefanend' );

		$wgOut->setPagetitle($page_title);

		
		//set it up so that the title of the page the user creates using the create form ends 
		//up being the title of the red link he clicked on to get to the create form
		
		if($destination)$title = $destination;	
		
		
		if(!$fanboxid){
		$top_title = Title::makeTitle( NS_SPECIAL  , "TopUserBoxes"  );


		$output .="<div >
			".wfMsgExt("userboxes-instructions","parse")."
		</div>
		
			<form action=\"\" method=\"post\" name=\"form1\">
			<input type=\"hidden\" name=\"fantag_image_name\" id=\"fantag_image_name\">
			<input type=\"hidden\" name=\"fantag_imgname\" id=\"fantag_imgname\">
			<input type=\"hidden\" name=\"fantag_imgtag\" id=\"fantag_imgtag\">
			<input type=\"hidden\" name=\"textSizeRightSide\" id=\"textSizeRightSide\" >
			<input type=\"hidden\" name=\"textSizeLeftSide\" id=\"textSizeLeftSide\" >
			<input type=\"hidden\" name=\"bgColorLeftSideColor\" id=\"bgColorLeftSideColor\" value=\"\">
			<input type=\"hidden\" name=\"textColorLeftSideColor\" id=\"textColorLeftSideColor\" value=\"\">
			<input type=\"hidden\" name=\"bgColorRightSideColor\" id=\"bgColorRightSideColor\" value=\"\">
			<input type=\"hidden\" name=\"textColorRightSideColor\" id=\"textColorRightSideColor\" value=\"\">";
			
			if(!$destination) {	
				$output .="
				<h1>". wfMsgForContent( 'fanbox_title' )."</h1>
					<div class=\"create-fanbox-title\">
					<input type=\"text\" name=\"wpTitle\" id=\"wpTitle\" value= \"{$wgRequest->getVal("wpTitle")}\" style=\"width:350px\" maxlength=\"60\"><br>
						<font size=\"1\">(Maximum characters: 60)</font><br>
					</div>";
				}
				else{
				$output .="
					<input type=\"hidden\" name=\"wpTitle\" id=\"wpTitle\" value= \"{$destination}\">";
				}

			$output .="
			<table  class=\"fanBoxTable\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >
				<tr><td id=\"fanBoxLeftSideContainer\" >
						<table cellspacing=\"0\" width=\"55px\" height=\"63px\">
							<tr>
							<td id=\"fanBoxLeftSideOutput2\"> </td>
							</tr>
						</table>				
				</td> 
				<td id=\"fanBoxRightSideContainer\">
						<table cellspacing=\"0\" width=\"212px\" height=\"63px\">
							<tr>
							<td id=\"fanBoxRightSideOutput2\"> </td>
							</tr>
						</table>
				</td>
				</tr>
			</table>";
	
			$output.= "<h1>". wfMsgForContent( 'fanbox_addtext' ) ."</h1>
				<div class=\"create-fanbox-text\">
					<div id=\"fanbox-left-text\">
						<h3>". wfMsgForContent( 'fanbox_leftsidetext' ) ."<span id=\"addImage\" onclick=\"displayAddImage('create-fanbox-image', 'addImage', 'closeImage')\">". wfMsgForContent( 'fanbox_display_image' ) ."</span> <span id=\"closeImage\" onclick=\"displayAddImage('create-fanbox-image', 'closeImage', 'addImage')\">". wfMsgForContent( 'fanbox_close_image' ) ."</span></h3>
						<input type=\"text\" name=\"inputLeftSide\" id=\"inputLeftSide\" oninput=\"displayLeftSide(); leftSideFanBoxFormat()\" onkeyup=\"displayLeftSide(); leftSideFanBoxFormat()\" onkeydown=\"displayLeftSide(); leftSideFanBoxFormat()\" onpaste=\"displayLeftSide(); leftSideFanBoxFormat()\" onkeypress=\"displayLeftSide(); leftSideFanBoxFormat()\" 
						maxlength=\"11\"><br>
						<font size=\"1\">". wfMsgForContent ('fanbox_leftsideinstructions')."</font>
					</div>
					<div id=\"fanbox-right-text\">
					<h3>". wfMsgForContent( 'fanbox_rightsidetext' ) ."<span id=\"countdownbox\"> <span class=\"fanbox-right-text-message\">". wfMsgForContent ('fanbox_youhave')."<input readonly type=\"text\" name=\"countdown\" style=\"width:20px; height:15px;\" value=\"70\"> ". wfMsgForContent ('fanbox_charactersleft')."</span></span></h3> 
						<input type=\"text\" name=\"inputRightSide\" id=\"inputRightSide\" style=\"width:350px\" oninput=\"displayRightSide(); 
						rightSideFanBoxFormat()\" 
						onKeyDown=\"limitText(this.form.inputRightSide,this.form.countdown,70); displayRightSide(); rightSideFanBoxFormat()\" 
						onKeyUp=\"limitText(this.form.inputRightSide,this.form.countdown,70); displayRightSide(); rightSideFanBoxFormat()\" 
						onpaste=\"limitText(this.form.inputRightSide,this.form.countdown,70); displayRightSide(); rightSideFanBoxFormat()\"
						onkeypress=\"limitText(this.form.inputRightSide,this.form.countdown,70); displayRightSide(); rightSideFanBoxFormat()\"
						maxlength=\"70\"><br>
						<font size=\"1\">". wfMsgForContent ('fanbox_rightsideinstructions')."</font>
					</div>
					<div class=\"cleared\"></div>
					</form>		
				</div>";
				
			$output.="
					<div id=\"create-fanbox-image\" class=\"create-fanbox-image\">
						<h1>". wfMsgForContent( 'fanbox_leftsideimage' ) ." <font size=\"1\">". wfMsgForContent( 'fanbox_leftsideimageinstructions' ) ." </font></h1>
						<div id=\"fanbox_image\" onclick=\"insertImageToLeft()\"></div>
						<div id=\"fanbox_image2\"></div>
						
						<div id=\"real-form\" style=\"display:block;height:70px;\">
						<iframe id=\"imageUpload-frame\" class=\"imageUpload-frame\" width=\"410\"
						scrolling=\"no\" frameborder=\"0\" donload=\"check_iframe()\" src=\"/index.php?title=Special:FanBoxAjaxUpload\">
						</iframe>
						</div>
					</div>";
			
			$output.= $this->colorPickerAndCategoryCloud();
			
			
			
			$output.="
			<div class=\"create-fanbox-buttons\">
				<input type=\"button\" class=\"site-button\" value=\"" . wfMsgForContent( 'fanbox_create_button' ) . "\" size=\"20\" onclick=\"create_fantag()\" />
			</div>
			";                       

			$output.="<script>
						
						function reset_upload(){
							\$('imageUpload-frame').src=\"/index.php?title=Special:FanBoxAjaxUpload\"
							YAHOO.widget.Effects.Show(\"imageUpload-frame\");
						}
						
						function completeImageUpload(){
							\$('fanbox_image').innerHTML ='<div style=\"margin:0px 0px 10px 0px;\"><img height=\"30\" width=\"30\" src=\"../../images/common/ajax-loader-white.gif\"></div>'
							\$('fanBoxLeftSideOutput2').innerHTML ='<div style=\"margin:0px 0px 10px 0px;\"><img height=\"30\" width=\"30\" src=\"../../images/common/ajax-loader-white.gif\"></div>'
						}
						
						function uploadComplete(img_tag,img_name){
							\$(\"fanbox_image\").innerHTML = img_tag
							\$(\"fanbox_image2\").innerHTML = '<p><a href=\'javascript:reset_upload();\'>Upload New Image</a></p>'
							\$(\"fanbox_image\").value = img_name
							
							\$(\"fanBoxLeftSideOutput2\").innerHTML = img_tag
							\$(\"fantag_image_name\").value = img_name
							
							\$(\"inputLeftSide\").value = \"\"						
							YAHOO.widget.Effects.Hide(\"imageUpload-frame\");
						}
					</script>
			";

			$output.="<script>


						function create_fantag(){

							
							if(!\$(\"inputRightSide\").value){
								alert(\"You must enter text for the right side\");
								return '';
							}
							
							if(!\$(\"inputLeftSide\").value && !\$(\"fantag_image_name\").value){
								alert(\"You must enter either text or an image for the left side\");
								return '';
							}
							
							if(!\$(\"wpTitle\").value){
								alert(\"You must enter a title\");
								return '';
							}
							
							if(\$(\"wpTitle\").value.indexOf('#') > -1){
								alert(\"# is an invalid character for the title.\")
								return '';
							}
							\$(\"wpTitle\").value = \$(\"wpTitle\").value.replace('&','%26')
								
							var url = \"index.php?action=ajax\";
							var pars = \"rs=wfFanBoxesTitleExists&rsargs[]=\"+escape(\$(\"wpTitle\").value)
							var callback = {
								success: function( req ) {
									if(req.responseText.indexOf(\"OK\")>=0){
										document.form1.submit();
	
									}else{
										alert(\"Please choose another title\");
									}
								}
							};
							var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);
	
						}
					 
				</script>";
			
		}
			
	
		$wgOut->addHTML($output);
		
		//send values to database and create fantag page when form is submitted
		
		if($wgRequest->wasPosted()){
			if(!$fanboxid){	
				$fan = FanBox::newFromName($title);
			
				$fantag_id = $fan->addFan($wgRequest->getVal("inputLeftSide"), $wgRequest->getVal("textColorLeftSideColor"), $wgRequest->getVal("bgColorLeftSideColor"), $wgRequest->getVal("inputRightSide"), $wgRequest->getVal("textColorRightSideColor"), $wgRequest->getVal("bgColorRightSideColor"), $wgRequest->getVal("fantag_image_name"), $wgRequest->getVal("textSizeLeftSide"), $wgRequest->getVal("textSizeRightSide"), $wgRequest->getVal("pageCtg") );
				$fan->addUserFan($fantag_id);
				$wgOut->redirect( $fan->title->getFullURL() );
			}
			if($fanboxid){
				$title = Title::newFromID($fanboxid);
				$update_fan = new FanBox( $title);
				$update_fan->updateFan($wgRequest->getVal("inputLeftSide"), $wgRequest->getVal("textColorLeftSideColor"), $wgRequest->getVal("bgColorLeftSideColor"), $wgRequest->getVal("inputRightSide"), $wgRequest->getVal("textColorRightSideColor"), $wgRequest->getVal("bgColorRightSideColor"), $wgRequest->getVal("fantag_image_name"), $wgRequest->getVal("textSizeLeftSide"), $wgRequest->getVal("textSizeRightSide"), $fanboxid, $wgRequest->getVal("pageCtg") );
				$wgOut->redirect( $update_fan->title->getFullURL() );

			}
		
		}
				
	}
	
	
	function colorPickerAndCategoryCloud(){
				$output.="				
				<div class=\"add-colors\">
					<h1>". wfMsgForContent( 'fan_add_colors' ) ."</h1>
					<div id=\"add-colors-left\">	
						<form name=\"colorpickerradio\">
						<input type=\"radio\" name=\"colorpickerchoice\" value=\"leftBG\" Checked> ". wfMsgForContent ('fanbox_leftbg_color')."
						<br>
						<input type=\"radio\" name=\"colorpickerchoice\" value=\"leftText\"> ". wfMsgForContent ('fanbox_lefttext_color')."
						<br>
						<input type=\"radio\" name=\"colorpickerchoice\" value=\"rightBG\"> ". wfMsgForContent ('fanbox_rightbg_color')."
						<br>
						<input type=\"radio\" name=\"colorpickerchoice\" value=\"rightText\"> ". wfMsgForContent ('fanbox_righttext_color')."			
						</form>
					</div>
					
					<div id=\"add-colors-right\">	
					<div id=\"colorpickerholder\"></div>
					</div>

						<script>
	
						var colorPickerTest = new YAHOO.widget.ColorPicker(\"colorpickerholder\", {
								showhsvcontrols: true,
								showhexcontrols: true,
								images: {
									PICKER_THUMB: \"http://developer.yahoo.com/yui/build/colorpicker/assets/picker_thumb.png\",
									HUE_THUMB: \"http://developer.yahoo.com/yui/build/colorpicker/assets/hue_thumb.png\"
								}
						});
						
																    
						colorPickerTest.on(\"rgbChange\", function (p_oEvent) {
							
									var sColor = \"#\" + this.get(\"hex\");
									
										if  (document.colorpickerradio.colorpickerchoice[0].checked) {
											document.getElementById('fanBoxLeftSideContainer').style.backgroundColor = sColor;
											document.getElementById('bgColorLeftSideColor').value = sColor; 
			
										}
										if  (document.colorpickerradio.colorpickerchoice[1].checked) {
											document.getElementById('fanBoxLeftSideOutput2').style.color = sColor;
											document.getElementById('textColorLeftSideColor').value = sColor; 
			
										}
										if  (document.colorpickerradio.colorpickerchoice[2].checked) {
											document.getElementById('fanBoxRightSideContainer').style.backgroundColor = sColor;
											document.getElementById('bgColorRightSideColor').value = sColor; 
			
										}
										if  (document.colorpickerradio.colorpickerchoice[3].checked) {
											document.getElementById('fanBoxRightSideOutput2').style.color = sColor;
											document.getElementById('textColorRightSideColor').value = sColor; 
										}
								    
								    });
								    
						</script>
						<div class=\"cleared\"></div>
					</div>";
					
			//category cloud stuff
		$cloud = new TagCloud(10);
		$categories_label = "Categories";
		$categories_help_text = "Categories help organize information on the site. To add multiple categories seperate them by commas.";

		$output .= "<div class=\"category-section\">";
		$tagcloud = " <div id=\"create-tagcloud\" style=\"line-height: 25pt;width:600px;padding-bottom:15px;\">";
		$tagnumber = 0;
		$tabcounter=1;
		foreach ($cloud->tags as $tag => $att) {
			$tag = str_replace("Fans","",$tag);
			$tag = trim($tag);
			$tagcloud .= " <span id=\"tag-{$tagnumber}\" style=\"font-size:{$cloud->tags[$tag]["size"]}{$cloud->tags_size_type}\"><a style='cursor:hand;cursor:pointer;text-decoration:underline' onclick=\"javascript:insertTag('" . str_replace("\'","\'",$tag) . "',{$tagnumber});\">{$tag}</a></span>";
			$tagnumber++;
		}
		
		
		
		$tagcloud .= "</div>";
		$output .= "<div class=\"create-category-title\"> <h1> $categories_label </h1></div>";
		$output .= "<div class=\"categorytext\">$categories_help_text</div>";
		$output .= $tagcloud;		
		$output .= "<textarea class=\"createbox\" tabindex=\"$tab_counter\" accesskey=\",\" name=\"pageCtg\" id=\"pageCtg\" rows=\"2\" cols=\"80\">{$categories}</textarea><br><br>";
		$output .= "</div>";	
			
		return $output;
	}
	
	
	
}

SpecialPage::addPage( new FanBoxes );

}

?>
