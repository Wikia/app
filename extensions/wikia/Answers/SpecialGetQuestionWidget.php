<?php

$wgExtensionMessagesFiles ['GetQuestionWidget'] = dirname(__FILE__) . '/GetQuestionWidget.i18n.php' ; 

class GetQuestionWidget extends UnlistedSpecialPage {

	
	function __construct(){
		parent::__construct("GetQuestionWidget");
	}
	
	function execute( $par ){
		global $wgOut, $wgUser, $wgContLang, $wgServer, $wgSitename;
		
		$wgOut->setPagetitle( wfMsg("get_widget_title") );

		$wgOut->addHTML("
			<style>
			.get-widget-settings label{
				width:200px;
				float:left;
			}
			.get-widget-settings div{
				margin-bottom:10px;
			}
			.get-widget-code{
				margin-top:15px;
			}
			#category_suggest{
				position:relative;	
			}
			</style>
			<script type=\"text/javascript\">
			       function updatePreview(){	
				       if( document.getElementById('category_type').value == 'custom' ){
					       category = document.getElementById('category').value
					       ask_category = category;
				       }else{
					       category = document.getElementById('category_type').value
					       ask_category = '';
				       }
				       ask_box = '';
				       if( document.getElementById('askbox').checked  ){
					       ask_box = \"<input type='text' value='" . wfMsg("ask_a_question") . "' id='wikia_ask' style='width:\" + (document.getElementById('widget_width').value - 50) +  \"px' onfocus=this.value='' > <input type='button' value='" . wfMsg("ask_button") . "' onclick=javascript:wikia_ask_question()><scr\" + \"ipt>function wikia_ask_question(){window.location=\'" . $wgServer . "/index.php?title=Special:CreateQuestionPage&questiontitle=' + document.getElementById('wikia_ask').value + '&categories=\" + ask_category + \"'}</scr\" + \"ipt>\";
				       }
				       preview = \"<scr\" + \"ipt>wikia_answers_background_color = '\" + document.getElementById('backgroundcolor').value + \"';wikia_answers_width = '\" + document.getElementById('widget_width').value + \"';wikia_answers_border = '1px solid #000000';wikia_answers_link_color = '\" + document.getElementById('linkcolor').value + \"';</scr\" + \"ipt><scr\" + \"ipt type='text/javascript' src='http://answer.wikia.com/index.php?action=ajax&rs=wfGetQuestionsWidget&rsargs[]=\" + document.getElementById('widget_title').value + \"&rsargs[]=\" + category + \"&rsargs[]=\" + document.getElementById('number').value + \"&rsargs[]=\" + document.getElementById('order').value + \"'></scri\" + \"pt><noscript><a href='" . $wgServer . "'>" . $wgSitename . "</a></noscript>\";      
	
				       	doc.open();
					doc.write(ask_box + preview);
					doc.close();
					
					if (!window.opera && !document.mimeType && document.all && document.getElementById){
						i.style.height=(185+(document.getElementById('number').value*55))+\"px\";
					}
					else if(document.getElementById) {
						i.style.height=(185+(document.getElementById('number').value*55))+\"px\"
					}
				
					preview = ask_box + preview
					document.getElementById('code').value = preview.replace('/</g','&lt;').replace('/>/g','&gt;').replace(/'/g,'\"');
			       }
			       
			       function updateCategorySettings(){
				       if( document.getElementById('category_type').value == 'custom' ){
					       \$('#custom_category').show();
				       }else{
					       updatePreview();
					       \$('#custom_category').hide();
				       }
			       }
			</script>");

				

		$wgOut->addHTML("<div class='get-widget-settings' style='float:left'>
				<b>" . wfMsg("widget_settings") . "</b>
					<div>
					<label for=\"number\">" . wfMsg("number_of_items") . "</label>
					<select id=\"number\" onchange=updatePreview()>
						<option value=\"5\">5</option>
						<option value=\"10\">10</option>
						<option value=\"15\">15</option>
						<option value=\"20\">20</option>
					</select>
					</div>
					<div>
					<label for=\"category\">" . wfMsg("widget_category") . "</label>
					<select id=\"category_type\" onchange=updateCategorySettings();>
						<option value='" . wfMsg("unanswered_category") . "'>Unanswered</option>
						<option value='" . wfMsg("answered_category") . "'>Answered</option>
						<option value='custom'>" . wfMsg("custom_category") . "</option>
					</select>
					</div>
					<div  id=\"custom_category\" style=\"display:none;margin-bottom:10px;\">
					<div class=\"yui-skin-sam\">
					<label for=\"category\">" . wfMsg("category") . "</label>
					<input type=\"text\" id=\"category\" value=\"\" style=\"width:175px\" onchange=updatePreview()>
					<div id=\"category_suggest\"></div>
					</div>
					</div>
					<div style='clear:both'></div>
					<div>
					<label for=\"order\">" . wfMsg("widget_order") . "</label>
					<select id=\"order\" onchange=updatePreview();>
						<option value=''>Recent</option>
						<option value='edit'>Edited</option>
						<option value='random'>Random</option>
					</select>
					</div>
					<div>
					<label for=\"askbox\">" . wfMsg("widget_ask_box") . "</label>
					<input type='checkbox' id='askbox' value='1' onchange='updatePreview()' checked>
					</div>
					<b>" . wfMsg("style_settings") . "</b>
					<div>
					<label for=\"widget_title\">Title</label>
					<input type=\"text\" id=\"widget_title\" value=\"Recent Questions\" onchange=updatePreview()>
					</div>
					<div>
					<label for=\"widget_width\">" . wfMsg("width") . "</label>
					<input type=\"text\" id=\"widget_width\" value=\"175\" style=\"width:100px\" onchange=updatePreview()>
					</div>
					<div> 
					<label for=\"backgroundcolor\">" . wfMsg("background_color") . "</label>
					<input type=\"text\" id=\"backgroundcolor\" value=\"#FFFFFF\" onchange=updatePreview()>
					</div>
					<div>
					<label for=\"linkcolor\">" . wfMsg("link_color") . "</label>
					<input type=\"text\" id=\"linkcolor\" value=\"#000000\" onchange=updatePreview()>
					</div>
					<div class='get-widget-code'>
					<b>" . wfMsg("get_code") . "</b><br/>
					<textarea onClick=\"javascript:this.focus();this.select();\" readonly name=\"code\" id=\"code\" rows=\"8\" cols=\"35\" style=\"width:350px;overflow:hidden\"></textarea>
					</div>
				</div>
				
				<div  style='padding-left:25px;float:left'>
				<iframe id=\"widget-frame\" FRAMEBORDER=\"0\" scrolling=\"no\" style=\"height:400px;width:355px;overflow:hidden\"></iframe>
				<script type=\"text/javascript\">
				i = document.getElementById('widget-frame');
	
				var doc = null;  
				    if(i.contentDocument)  
				       // Firefox, Opera  
				       doc = i.contentDocument;  
				    else if(i.contentWindow)  
				       // Internet Explorer  
				       doc = i.contentWindow.document;  
				    else if(i.document)  
				       // Others?  
				       doc = i.document; 
				updatePreview()
				
					var oDS = new YAHOO.util.XHRDataSource(  ''); 
	// Set the responseType 
	oDS.responseType = YAHOO.util.XHRDataSource.TYPE_JSON; 
	// Define the schema of the JSON results 
	oDS.responseSchema = { 
  		resultsList : \"ResultSet.Result\", 
		fields : [\"category\", \"count\"] 
	}; 
	var myAutoComp = new YAHOO.widget.AutoComplete(\"category\",\"category_suggest\", oDS); 
	myAutoComp.maxResultsDisplayed = 5;  
	myAutoComp.minQueryLength = 3; 
	myAutoComp.queryQuestionMark  = false; 
	myAutoComp.generateRequest = function(sQuery) { 
		return \"/index.php?action=ajax&rs=wfGetCategoriesSuggest&rsargs[]=\" + sQuery + \"&rsargs[]=5\" 
	}; 
	
	// Don't highlight the first result
	myAutoComp.autoHighlight = false; 
	myAutoComp.resultTypeList = false; 
	myAutoComp.formatResult = function(oResultData, sQuery, sResultMatch) { 
		return ('<b>' + sResultMatch + '</b> - <span style=\"color:green\">' +  oResultData.count + ' page(s)</span> '); 
	}; 	
	var itemSelectHandler = function(sType, aArgs) { 
		updatePreview();
	}; 
	myAutoComp.itemSelectEvent.subscribe(itemSelectHandler);
				</script>
				</div>");
	}
  
}

