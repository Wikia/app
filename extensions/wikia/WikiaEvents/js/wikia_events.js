var YD = YAHOO.util.Dom;

var defaultHidden = "<input type='hidden' value=\"{0}\" name='{1}' id='{1}'>";
var defaultText = "<input type='text' value=\"{0}\" style='font-size:10px; color: blue; width: {2}em;' name='{1}' id='{1}'>";
var defaultSubmit = "<input type='button' value=\"{0}\" style='font-size:8pt; color: blue;' name='{1}' id='{1}'>";
var defaultUrl = "<a href=\"{2}\" style=\"margin-left: 3px;\" onClick=\"{0}\">{1}</a>";

/*
 * Listener 
 */
wikiaSaveEventTypeSubmit = function ( e ) {
    var input 		= document.getElementById( "edit_et_name" );
    var etId 		= document.getElementById( "edit_et_id" );
    var descInput 	= document.getElementById( "edit_et_desc" );
    var params 		= "&rsargs[0]=" + input.value + "&rsargs[1]=" + etId.value + "&rsargs[2]=" + descInput.value;
    var div 		= document.getElementById('actionEvent_' + etId.value);
    var button 		= document.getElementById('wk-event-submit');
    //----
	var oSaveEventTypeCallback = {
		success: function( oResponse ) {
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
    		var obj 	= document.getElementById('edtEvent_' + etId.value );
    		var objDesc = document.getElementById('edtEventDesc_' + etId.value );
			//--- set form values
			obj.innerHTML = wikiaMakeDefLink("wikiaSelectEventType( '/index.php?action=ajax&rs=wfwkGetEventTypes', '" + resData['id'] + "', '" + button.value + "')", resData['name'], "");
			//
			objDesc.innerHTML = resData['desc'];
			//
    		div.innerHTML = "<img src=\"/extensions/wikia/WikiaEvents/images/1.gif\" border=\"0\" />";
		},
		failure: function( oResponse ) {
    		div.innerHTML = "<img src=\"/extensions/wikia/WikiaEvents/images/0.gif\" border=\"0\" />" + oResponse.responseText;
		}
	};
    var baseurl = "/index.php?action=ajax&rs=wfwkSetEventTypes" + params;
    YAHOO.util.Connect.asyncRequest( "GET", baseurl, oSaveEventTypeCallback);
    div.innerHTML += '<img src="/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" />';
};

wikiaSaveEventSubmit = function ( e, data ) {
    var evId 		= data.id;
    var input 		= document.getElementById( "edit_ev_name_" + evId );
    var descInput 	= document.getElementById( "edit_ev_desc_" + evId );
    var selectHook 	= document.getElementById('selectHook_' + evId);
    var params 		= "&rsargs[0]=" + input.value + "&rsargs[1]=" + evId + "&rsargs[2]=" + descInput.value + "&rsargs[3]=" + selectHook.value;
    var div_img		= document.getElementById('actionEventImg_' + evId);
    var div			= document.getElementById('actionEvent_' + evId);
    var button 		= document.getElementById('wk-event-submit_' + + evId);
    //----
	var oSaveEventTypeCallback = {
		success: function( oResponse ) {
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
    		var obj 	= document.getElementById('edtEvent_' + evId );
    		var objDesc = document.getElementById('edtEventDesc_' + evId );
    		var objHook = document.getElementById('edtEventHook_' + evId );
			//--- set form values
			obj.innerHTML = wikiaMakeDefLink("wikiaSelectEvent( '/index.php?action=ajax&rs=wfwkGetEvents', '" + resData['id'] + "', '" + button.value + "')", resData['name'], "");
			//
			objDesc.innerHTML = resData['desc'];
			//
			objHook.innerHTML = resData['hook'];
			//
			div.innerHTML = "";
    		div_img.innerHTML = "<img src=\"/extensions/wikia/WikiaEvents/images/1.gif\" border=\"0\" />";;
		},
		failure: function( oResponse ) {
			div.innerHTML = "";
    		div_img.innerHTML = "<img src=\"/extensions/wikia/WikiaEvents/images/0.gif\" border=\"0\" />" + oResponse.responseText;
		}
	};
    var baseurl = "/index.php?action=ajax&rs=wfwkSetEvents" + params;
    YAHOO.util.Connect.asyncRequest( "GET", baseurl, oSaveEventTypeCallback);
    div_img.innerHTML += '<img src="/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" />';
};

wikiaSelectEventFromList = function ( e ) {
    var msgDiv 		= document.getElementById('eventMsg_select');
    var baseurl 	= "/index.php?action=ajax&rs=wfwkGetEventTmpl";
    var selectEvent = document.getElementById('wk-select-event-name');
    var tableDiv 	= document.getElementById('wk-select-table');
    //var divAddBtn	= document.getElementById('divAddEventTextBtn');

	var oSelectEventCallback = {
		success: function( oResponse ) {
			document.getElementById( "showTextValues" ).innerHTML = "";
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			for (i = 0; i < resData.length; i++)
			{
				var o = resData[i];
				//---
				// should be et_active used?
				var borderColor = "black";
				var title = o['title'];
				var content = o['content'];
				
				var titleChange = wikiaMakeDefLink("wikiaSelectEventText('title', '" + o['event_id']+ "', '" +o['type_id'] + "')", "Change key", "");
				var titlePreview = wikiaMakeDefLink("", "View text", "/index.php?title=MediaWiki:" + title + "\" target=\"new");
				var contentChange = wikiaMakeDefLink("wikiaSelectEventText('content', '" + o['event_id'] + "', '"+o['type_id'] + "')", "Change key");
				var contentPreview = wikiaMakeDefLink("", "View text", "/index.php?title=MediaWiki:" + content + "\" target=\"new");
				// key of text is not added
				if (o['text_id'] == null) 
				{
					borderColor  = "black";
					titleChange = wikiaMakeDefLink("wikiaSelectEventText('title', '" + o['event_id']+"', '"+o['type_id'] + "')", "Add key", "");
					titlePreview = contentPreview = "";
					contentChange = wikiaMakeDefLink("wikiaSelectEventText('content', '" + o['event_id']+"', '"+o['type_id'] + "')", "Add key", "");
					title = content = "";
				}
					
				var tableMessage = "<table cellpadding=\"4\" cellspacing=\"0\" style=\"width:100%; font-weight: normal; font-size: 11px;\"><tr>" + 
									"<td style=\"font-weight: bold; text-align: right;\">Title:</td>" + 
									"<td style=\"width:100%; text-align: left;\"><div id=\"title_" + o['event_id']+"_"+o['type_id'] + "\">" + title + "</div></td>" + 
									"<td style=\"width:150px; text-align: left;\" nowrap>" +
										"<div id=\"titleAction_" + o['event_id']+"_"+o['type_id'] + "\">" + titleChange + "  " + titlePreview + "</div>" +
									"</td></tr><tr>" +
									"<td style=\"font-weight: bold; text-align: right;\">Content:</td>" + 
									"<td style=\"width:100%; text-align: left;\"><div id=\"content_" + o['event_id']+"_"+o['type_id'] + "\">" + content + "</div></td>" + 
									"<td style=\"width:150px; text-align: left;\" nowrap>" +
										"<div id=\"contentAction_" + o['event_id']+"_"+o['type_id'] + "\">" + contentChange + "  " + contentPreview + "</div>" + 
									"</td></tr></table>";
					
				//---
				var f_id = o['event_id'] + o['type_id'];
				var fieldSet = "<fieldset id=\"fieldset" + f_id + "\" style=\"border: 1px solid " + borderColor + ";\">\n" + o['type_desc'];
				var fieldLegend = "<legend id=\"legend" + f_id + "\" style=\"font-weight: bold; color: " + borderColor + ";\">" + o['type_name'] + "</legend>";
				//var fieldSet = wikiaMakeHTMLTag("fieldset", o['type_desc'], o['event_id'] + o['type_id'], "border: 1px solid " + borderColor + ";");
				//---
				//var fieldLegend = wikiaMakeHTMLTag("legend", o['type_name'], o['event_id'] + o['type_id'], "font-weight: bold; color: " + borderColor);
				
				//---
            	//document.getElementById( "showTextValues" ).appendChild(fieldSet);
				//document.getElementById( "fieldset" + o['event_id'] + o['type_id'] ).appendChild(fieldLegend);
				//document.getElementById( "fieldset" + o['event_id'] + o['type_id'] ).innerHTML += tableMessage;
				document.getElementById( "showTextValues" ).innerHTML += fieldSet + fieldLegend + "\n" + tableMessage + "\n</fieldset>\n";
			}
			msgDiv.innerHTML = "";
		},
		failure: function( oResponse ) {
			msgDiv.innerHTML = "Failed" + oResponse.responseText;
		}
	};
	baseurl += "&rsargs[0]="+selectEvent.value;
    YAHOO.util.Connect.asyncRequest( "GET", baseurl, oSelectEventCallback);
    //----
    msgDiv.innerHTML += '<img src="/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" />';
}

wikiaSaveEventTextSubmit = function ( e, data ) {
	var div = data[0];
    var ev_id 	= document.getElementById(div + '_ev_id').value;
    var type_id = document.getElementById(div + '_type_id').value;
    var textValue = document.getElementById(div + '_name').value;
    var baseurl = "/index.php?action=ajax&rs=wfwkSetTextEvent";
    
    baseurl += "&rsargs[0]=" + div;
    baseurl += "&rsargs[1]=" + ev_id;
    baseurl += "&rsargs[2]=" + type_id;
    baseurl += "&rsargs[3]=" + textValue;

/*	alert(baseurl);
	alert(div + '_' + ev_id + "_" + type_id);
	alert(document.getElementById(div + '_' + ev_id + "_" + type_id).innerHTML);
	alert(document.getElementById(div + 'Action_' + ev_id + "_" + type_id).innerHTML);
	
	return;*/

	var oSetTextEventCallback = {
		success: function( oResponse ) {
			//prompt("", oResponse.responseText);
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			var linkChange = wikiaMakeDefLink("wikiaSelectEventText('"+div+"', '" + ev_id+ "', '" + type_id + "')", "Change key", "");
			var linkPreview = wikiaMakeDefLink("", "View text", "/index.php?title=MediaWiki:" + resData['value'] + "\" target=\"new");
			
			//---
			document.getElementById(div + '_' + ev_id + "_" + type_id).innerHTML = resData['value'];
			document.getElementById(div + 'Action_' + ev_id + "_" + type_id).innerHTML = linkChange + "  " + linkPreview;

			//---
			document.getElementById( "fieldset" + ev_id + type_id ).style.borderColor = "black";
			document.getElementById( "legend" + ev_id + type_id ).style.color = "black";
		},
		failure: function( oResponse ) {
			div.innerHTML = "Failed" + oResponse.responseText;
			document.getElementById(div + '_' + ev_id + "_" + type_id).innerHTML = textValue;
		}
	};

	YAHOO.util.Connect.asyncRequest("GET", baseurl, oSetTextEventCallback);

    div.innerHTML = '<img src="/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" />';
};

wikiaSaveEventParamSubmit = function ( e, data ) {
    var ep_id = data.id;
    var objTextValue = document.getElementById('epEventEditValue_' + data.id).value;
    var objTextDescValue = document.getElementById('epEventEditDescValue_' + data.id).value;
    var div = document.getElementById('actionEvent_' + data.id);
    var baseurl = data.url;
    baseurl = "/index.php?action=ajax&rs=wfwkSetEventParamSetup";
    
    var _baseurl = baseurl;
    baseurl += "&rsargs[0]=" + ep_id;
    baseurl += "&rsargs[1]=" + objTextValue;
    baseurl += "&rsargs[2]=" + objTextDescValue;

	var oSetTextEventCallback = {
		success: function( oResponse ) {
			//prompt("", oResponse.responseText);
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			ep_id = resData['ep_id'];
			//
			var objValue = document.getElementById('epEventValue_' + ep_id);
			objValue.innerHTML = resData['value'];
			//
			var objDescValue = document.getElementById('epEventDesc_' + ep_id);
			objDescValue.innerHTML = resData['desc_value'];
			//
			div.innerHTML = "<a href=\"javascript:void(0);\" style=\"margin-left: 3px;\" onClick=\"wikiaSelectEventSetup( '" + _baseurl + "', '" + ep_id + "', '" + data.savebtn + "', '" + data.editbtn + "'); return false;\">" + data.editbtn + "</a>";
		},
		failure: function( oResponse ) {
			div.innerHTML = "Failed" + oResponse.responseText;
			//
			var objValue = document.getElementById('epEventValue_' + ep_id);
			objValue.innerHTML = objTextValue;
			//
			var objDescValue = document.getElementById('epEventDesc_' + ep_id);
			objDescValue.innerHTML = objTextDescValue;
		}
	};

	YAHOO.util.Connect.asyncRequest("GET", baseurl, oSetTextEventCallback);

    div.innerHTML = '<img src="/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" />';
};

/*
 * Default elements of document
 */ 

function wikiaMakeDefText (name, value, size) {
	return YAHOO.Tools.printf(defaultText, value, name, size);
}

function wikiaMakeHidden (name, value) {
	return YAHOO.Tools.printf(defaultHidden, value, name);
}

function wikiaMakeDefSubmit (name, value) {
	return YAHOO.Tools.printf(defaultSubmit, value, name);
}

function wikiaMakeDefLink (click, text, link) {
	if (link == "") {
		link = "javascript:void(0)";
	}
	if (click != "") {
		click += "; return false;";
	}
	return YAHOO.Tools.printf(defaultUrl, click, text, link);
}

function wikiaMakeHTMLTag (tag, name, tag_id, lstyle) {
	return YD.create(tag, name, {id: tag + tag_id, style: lstyle}); 
}

/*
 * 
 * Wikia functions
 * 
 */

function wikiaSelectHookParams(ev_id, hook_list, hook, hookValues)
{
	var selectHook = "<select name=\"selectHook_" + ev_id + "\" id=\"selectHook_" + ev_id + "\" style=\"padding: 2px; font-size:10px;\">";
	for (i in hook_list)
	{
		var selected = "";
		if (hook == i)
		{
			selected = "selected";
		}
		selectHook += "<option " + selected + " value=\""+ i +"\">" + i + "</option>";
	}
	selectHook += "</select>";	

	return selectHook;
}

function wikiaSelectEvent( baseurl, value, saveBtn ) {
    var obj 	= document.getElementById('edtEvent_' + value );
    var objDesc = document.getElementById('edtEventDesc_' + value );
    var div 	= document.getElementById('actionEvent_' + value);
    var objHook = document.getElementById('edtEventHook_' + value );

	var oSelectEventTypeCallback = {
		success: function( oResponse ) {
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			//--- set form values
			obj.innerHTML = wikiaMakeDefText("edit_ev_name_" + resData['id'], resData['name'], '10');
			// --- 
			objDesc.innerHTML = wikiaMakeDefText("edit_ev_desc_" + resData['id'], resData['desc'], '25');
			//
			objHook.innerHTML = wikiaMakeDefText("selectHook_" + resData['id'], resData['hook'], '10');
			//
			div.innerHTML = wikiaMakeDefSubmit("wk-event-submit_" + resData['id'], saveBtn);
			//--- add action
			YAHOO.util.Event.addListener("wk-event-submit_" + resData['id'], "click", wikiaSaveEventSubmit, {id: resData['id']});
		},
		failure: function( oResponse ) {
			div.innerHTML = "Failed" + oResponse.responseText;
		}
	};

	baseurl += "&rsargs[0]=" + value;
	YAHOO.util.Connect.asyncRequest("GET", baseurl, oSelectEventTypeCallback);
	
    div.innerHTML = '<img src="/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" />';
}

function wikiaSetActiveEvent( value ) {
    var obj 	= document.getElementById('edtEventActive_' + value );
    var div 	= document.getElementById('actionEventImg_' + value);
    var baseurl = "/index.php?action=ajax&rs=wfwkSetActiveEvent";

	var oSetActiveEventCallback = {
		success: function( oResponse ) {
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			//--- set form values
			var imgUrl = "<img src=\"/extensions/wikia/WikiaEvents/images/" + resData['active'] + ".gif\" border=\"0\" />";
			//---
			obj.innerHTML = wikiaMakeDefLink("wikiaSetActiveEvent( '"+ resData['id'] + "')", imgUrl);
			//---
			div.innerHTML = "";
		},
		failure: function( oResponse ) {
			div.innerHTML = "Failed" + oResponse.responseText;
		}
	};

	baseurl += "&rsargs[0]=" + value;
	YAHOO.util.Connect.asyncRequest("GET", baseurl, oSetActiveEventCallback);

    div.innerHTML = '<img src="/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" />';
}

function wikiaSelectEventType( baseurl, value, saveBtn ) {
    var obj 	= document.getElementById('edtEvent_' + value );
    var objDesc = document.getElementById('edtEventDesc_' + value );
    var div 	= document.getElementById('actionEvent_' + value);

	var oSelectEventTypeCallback = {
		success: function( oResponse ) {
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			//--- set form values
			obj.innerHTML = wikiaMakeHidden("edit_et_id", resData['id']);
			obj.innerHTML += wikiaMakeDefText("edit_et_name", resData['name'], '10');
			// --- 
			objDesc.innerHTML = wikiaMakeDefText("edit_et_desc", resData['desc'], '20');
			//
			div.innerHTML = wikiaMakeDefSubmit("wk-event-submit", saveBtn);
			//--- add action
			YAHOO.util.Event.addListener("wk-event-submit", "click", wikiaSaveEventTypeSubmit);
		},
		failure: function( oResponse ) {
			div.innerHTML = "Failed" + oResponse.responseText;
		}
	};

	baseurl += "&rsargs[0]=" + value;
	YAHOO.util.Connect.asyncRequest("GET", baseurl, oSelectEventTypeCallback);
	
    div.innerHTML = '<img src="/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" />';
}

function wikiaSetActiveEventType( value ) {
    var obj 	= document.getElementById('edtEventActive_' + value );
    var div 	= document.getElementById('actionEvent_' + value);
    var baseurl = "/index.php?action=ajax&rs=wfwkSetActiveEventType";

	var oSetActiveEventCallback = {
		success: function( oResponse ) {
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			//--- set form values
			var imgUrl = "<img src=\"/extensions/wikia/WikiaEvents/images/" + resData['active'] + ".gif\" border=\"0\" />";
			//---
			obj.innerHTML = wikiaMakeDefLink("wikiaSetActiveEventType( '"+ resData['id'] + "')", imgUrl);
			//---
			div.innerHTML = "";
		},
		failure: function( oResponse ) {
			div.innerHTML = "Failed" + oResponse.responseText;
		}
	};

	baseurl += "&rsargs[0]=" + value;
	YAHOO.util.Connect.asyncRequest("GET", baseurl, oSetActiveEventCallback);

    div.innerHTML = '<img src="/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" />';
}

function wikiaSelectEventText( div, event, type ) {
    var obj 	= document.getElementById(div + '_' + event + "_" + type );
    var objAction = document.getElementById(div + 'Action_' + event + "_" + type );
	var textValue = obj.innerHTML;
	//---
    objAction.innerHTML = '<img src="/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" />';
	//---
	obj.innerHTML = wikiaMakeHidden(div + "_ev_id", event);
	obj.innerHTML += wikiaMakeHidden(div + "_type_id", type);
	obj.innerHTML += wikiaMakeDefText(div + "_name", textValue, '20');
	//---
    objAction.innerHTML = wikiaMakeDefSubmit("wk-event-" + div + "-submit", "Save");
	//--- add action
	YAHOO.util.Event.addListener("wk-event-" + div + "-submit", "click", wikiaSaveEventTextSubmit, [div]);
}

function wikiaSelectEventSetup( baseurl, param, saveBtn, editBtn ) {
    var objValue = document.getElementById('epEventValue_' + param );
    var objDescValue = document.getElementById('epEventDesc_' + param );
    var objAction = document.getElementById('actionEvent_' + param );
	var textValue = objValue.innerHTML;
	var textDescValue = objDescValue.innerHTML;
	
	baseurl = '/index.php?action=ajax&rs=wfwkSetEventParamSetup';
	
	//---
    objAction.innerHTML = '<img src="/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" />';
	//---
	objValue.innerHTML = wikiaMakeDefText('epEventEditValue_' + param, textValue, '8');
	objDescValue.innerHTML = wikiaMakeDefText('epEventEditDescValue_' + param, textDescValue, '20');
	//---
	btnSaveName = "wk-event-param-" + param + "-submit";
    objAction.innerHTML = wikiaMakeDefSubmit(btnSaveName, saveBtn);
	//--- add action
	YAHOO.util.Event.addListener(btnSaveName, "click", wikiaSaveEventParamSubmit, {id:param, url: baseurl, savebtn: saveBtn, editbtn: editBtn});
}

function wikiaSetActiveEventParamSetup( baseurl, value, savebtn, btnedit ) {
    var obj 	= document.getElementById('epEventActive_' + value );
    var div 	= document.getElementById('actionEventImg_' + value);
    var baseurl = "/index.php?action=ajax&rs=wfwkSetActiveEventParam";

	var oSetActiveEventCallback = {
		success: function( oResponse ) {
			var resData = YAHOO.Tools.JSONParse(oResponse.responseText);
			//--- set form values
			var imgUrl = "<img src=\"/extensions/wikia/WikiaEvents/images/" + resData['active'] + ".gif\" border=\"0\" />";
			//---
			obj.innerHTML = wikiaMakeDefLink("wikiaSetActiveEventParamSetup( '" + baseurl + "', '"+ resData['id'] + "', '" + savebtn + "', '" + btnedit + "')", imgUrl);
			//---
			div.innerHTML = "";
			//"<a href=\"javascript:void(0);\" style=\"margin-left: 3px;\" onClick=\"wikiaSelectEventSetup( '" + baseurl + "', '" + value + "', '" + savebtn + "', '" + btnedit + "'); return false;\">" + btnedit + "</a>";
		},
		failure: function( oResponse ) {
			div.innerHTML = "Failed" + oResponse.responseText;
		}
	};

	baseurl += "&rsargs[0]=" + value;
	YAHOO.util.Connect.asyncRequest("GET", baseurl, oSetActiveEventCallback);

    div.innerHTML = '<img src="/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" />';
}


YAHOO.util.Event.addListener("wk-select-event-name", "change", wikiaSelectEventFromList);
