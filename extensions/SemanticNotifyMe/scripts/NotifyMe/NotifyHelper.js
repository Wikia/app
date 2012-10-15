/** *****************************************************************************
*  NotifyMe helper for Semantic MediaWiki
*  Developed by Dch <hehehu@gmail.com>
*
*  NotifyHelper.js
*  Manages major functionalities and GUI of the User Notification Interface
*  @author ning [hehehu@gmail.com]
*/

var notifyhelper = null;

var NotifyHelper = Class.create();
NotifyHelper.prototype = {

/**
* Initialize the NotifyHelper object and all variables
*/
initialize:function(){
	this.pendingElement = null;
},

/**
* Called whenever notify me manager is minimized or maximized
*/
switchlayout:function(){
	if($("layoutcontent").style.display == "none"){
		$("layoutcontent").style.display = "";
		$("layouttitle-link").removeClassName("plusminus");
		$("layouttitle-link").addClassName("minusplus");
	}
	else {
		$("layoutcontent").style.display = "none";
		$("layouttitle-link").removeClassName("minusplus");
		$("layouttitle-link").addClassName("plusminus");
	}
},
/**
* Called whenever notify me query is minimized or maximized
*/
switchquery:function(){
	if($("querycontent").style.display == "none"){
		$("querycontent").style.display = "";
		$("querytitle-link").removeClassName("plusminus");
		$("querytitle-link").addClassName("minusplus");
	}
	else {
		$("querycontent").style.display = "none";
		$("querytitle-link").removeClassName("minusplus");
		$("querytitle-link").addClassName("plusminus");
	}
},

/**
* Executes a save
*/
doSaveToNotify:function(){
	/*STARTLOG*/
	if(window.smwhgLogger){
		smwhgLogger.log("Save Notify","NM","save_notify");
	}
	/*ENDLOG*/

	$('shade').toggle();
	if(this.pendingElement)
		this.pendingElement.hide();
	this.pendingElement = new OBPendingIndicator($('shade'));
	this.pendingElement.show();

	if($('nmqname').value=="") {
		var request = Array();
		request.responseText = nmLanguage.getMessage('NM_EMPTY_NOTIFYNAME');
		this.saveNotify(request);
	}
	else if ($('nmquery').value){ //only do this if the query is not empty
		var params = $('nmquery').value.replace(/&/gm, "&amp;").replace(/,/gm, "&comma;") + ",";
		params += ($('nmqrall').checked ? 1 : 0) + ",";
		params += ($('nmqsall').checked ? 1 : 0) + ",";
		params += $('nmqname').value.replace(/&/gm, "&amp;").replace(/,/gm, "&comma;") + ",";
		params += ($('nmd_new') ? $('nmd_new').value : "");
		sajax_do_call('smwf_nm_NotifyAccess', ["addNotify", params], this.saveNotify.bind(this));
	}
	else { // query is empty
		var request = Array();
		request.responseText = nmLanguage.getMessage('NM_EMPTY_QUERY');
		this.saveNotify(request);
	}
},

/**
* Displays the preview created by the server
* @param request Request of AJAX call
*/
saveNotify:function(request){
	this.pendingElement.hide();
	var s = request.responseText;
	if(s.substring(0,1)=="1") {
		var enabled = (s.substring(1,2)=='1');
		s = s.substring(2);
		var i = s.indexOf(",");
		var nid = s.substring(0,i);
		this.addNotifyToTable(nid, enabled);
		alert("Notify create successfully!" + s.substring(i+1));
	} else alert(s);
	$('shade').toggle();
},
addNotifyToTable:function(nid, enabled){
	var ntr = document.createElement("tr");
	var td = document.createElement("td");
	ntr.appendChild(td);
	var item = document.createElement("input");
	td.appendChild(item);
	item.type = "checkbox";
	item.value = nid;
	item.name = "nmdel";

	td = document.createElement("td");
	ntr.appendChild(td);
	item = document.createElement("a");
	td.appendChild(item);
	item.href = wgScript + "?title=Special:NotifyMe&feed=rss&nid=" + nid;
	item.target = "_blank";
	item.innerHTML = $('nmqname').value;

	td = document.createElement("td");
	ntr.appendChild(td);
	td.innerHTML = $('nmquery').value.replace(/\n/g, "<br/>");

	td = document.createElement("td");
	ntr.appendChild(td);
	item = document.createElement("input");
	td.appendChild(item);
	item.type = "checkbox";
	item.value = nid;
	item.name = "nmall";
	item.checked = $('nmqrall').checked;

	td = document.createElement("td");
	ntr.appendChild(td);
	item = document.createElement("input");
	td.appendChild(item);
	item.type = "checkbox";
	item.value = nid;
	item.name = "nmsall";
	item.checked = $('nmqsall').checked;

	td = document.createElement("td");
	ntr.appendChild(td);
	item = document.createElement("input");
	td.appendChild(item);
	item.type = "checkbox";
	item.value = nid;
	item.name = "nmenable";
	item.id = "nmenable_" + nid;
	item.checked = enabled;

	if($('nmd_new')) {
		td = document.createElement("td");
		ntr.appendChild(td);
		item = document.createElement("input");
		td.appendChild(item);
		item.type = "text";
		item.value = $('nmd_new').value;
		item.name = "nmdelegate";
		item.id = "nmd_" + nid;

		item = document.createElement("div");
		td.appendChild(item);
		item.className = "page_name_auto_complete";
		item.id = "nmdiv_" + nid;
	}

	$('nmtoolbar').parentNode.insertBefore(ntr, $('nmtoolbar'));
	nmAttachAutocompleteToField("nmd_" + nid);
},

doUpdateMail:function() {
	/*STARTLOG*/
	if(window.smwhgLogger){
		smwhgLogger.log("update Notify Me mail setting ","NM","update_mail");
	}
	/*ENDLOG*/

	$('shade').toggle();
	if(this.pendingElement)
		this.pendingElement.hide();
	this.pendingElement = new OBPendingIndicator($('shade'));
	this.pendingElement.show();

	var params = ($('nmemail').checked ? 1 : 0);
	sajax_do_call('smwf_nm_NotifyAccess', ["updateMail", params], this.updateMail.bind(this));
},
updateMail:function(request){
	this.pendingElement.hide();
	alert(request.responseText);
	$('shade').toggle();
},

resetQuery:function(){
	$('nmquery').value = "";
	$('nmqname').value = "";
	$('nmd_new').value = "";
	$('nmqrall').checked = true;
	$('nmqsall').checked = false;
},

/**
* Gets all display parameters and the full ask syntax to perform an ajax call
* which will create the preview
*/
previewQuery:function(){

	/*STARTLOG*/
	if(window.smwhgLogger){
		smwhgLogger.log("Preview Query","NM","query_preview");
	}
	/*ENDLOG*/
	$('shade').toggle();
	if(this.pendingElement)
		this.pendingElement.hide();
	this.pendingElement = new OBPendingIndicator($('shade'));
	this.pendingElement.show();
	if ($('nmquery').value){ //only do this if the query is not empty
		sajax_do_call('smwf_nm_NotifyAccess', ["getQueryResult", $('nmquery').value], this.openPreview.bind(this));
	}
	else { // query is empty
		var request = Array();
		request.responseText = nmLanguage.getMessage('NM_EMPTY_QUERY');
		this.openPreview(request);
	}
},
/**
* Displays the preview created by the server
* @param request Request of AJAX call
*/
openPreview:function(request){
	this.pendingElement.hide();
	$('fullpreviewbox').toggle();
	$('fullpreview').innerHTML = request.responseText;
},


updateStates:function(){
	/*STARTLOG*/
	if(window.smwhgLogger){
		smwhgLogger.log("Update States","NM","update_states");
	}
	/*ENDLOG*/

	$('shade').toggle();
	if(this.pendingElement)
		this.pendingElement.hide();
	this.pendingElement = new OBPendingIndicator($('shade'));
	this.pendingElement.show();

	var params = "";
	var nodes = $A(document.getElementsByName('nmenable'));
	var dNodes = nodes.select(function(node) {
		return node.checked;
	});
	dNodes.each(function(node) {
		params += node.value + ',';
	});
	sajax_do_call('smwf_nm_NotifyAccess', ["updateStates", params], this.updateStatesDone.bind(this));
},
/**
* @param request Request of AJAX call
*/
updateStatesDone:function(request){
	this.pendingElement.hide();
	var s = request.responseText;
	if(s.substring(0,1)=="0") {
		s = s.substring(1);
		var i = s.indexOf("|");
		var nids = s.substring(0,i).split(",");
		for(j=nids.length-2;j>=0;--j) {
			$('nmenable_'+nids[j]).checked = false;
		}
		alert("Notify create failed!" + s.substring(i+1));
	} else alert(s);
	$('shade').toggle();
},

updateReportAll:function(){
	/*STARTLOG*/
	if(window.smwhgLogger){
		smwhgLogger.log("Update Notifications report all","NM","update_reportall");
	}
	/*ENDLOG*/

	$('shade').toggle();
	if(this.pendingElement)
		this.pendingElement.hide();
	this.pendingElement = new OBPendingIndicator($('shade'));
	this.pendingElement.show();

	var params = "";
	var nodes = $A(document.getElementsByName('nmall'));
	var dNodes = nodes.select(function(node) {
		return node.checked;
	});
	dNodes.each(function(node) {
		params += node.value + ',';
	});
	sajax_do_call('smwf_nm_NotifyAccess', ["updateReportAll", params], this.updateDone.bind(this));
},

updateShowAll:function(){
	/*STARTLOG*/
	if(window.smwhgLogger){
		smwhgLogger.log("Update Notifications show all","NM","update_showall");
	}
	/*ENDLOG*/

	$('shade').toggle();
	if(this.pendingElement)
		this.pendingElement.hide();
	this.pendingElement = new OBPendingIndicator($('shade'));
	this.pendingElement.show();

	var params = "";
	var nodes = $A(document.getElementsByName('nmsall'));
	var dNodes = nodes.select(function(node) {
		return node.checked;
	});
	dNodes.each(function(node) {
		params += node.value + ',';
	});
	sajax_do_call('smwf_nm_NotifyAccess', ["updateShowAll", params], this.updateDone.bind(this));
},
/**
* @param request Request of AJAX call
*/
updateDone:function(request){
	this.pendingElement.hide();
	alert(request.responseText);
	$('shade').toggle();
},

deleteNotify:function(){
	/*STARTLOG*/
	if(window.smwhgLogger){
		smwhgLogger.log("Delete Notifications","NM","delete_notify");
	}
	/*ENDLOG*/

	$('shade').toggle();
	if(this.pendingElement)
		this.pendingElement.hide();
	this.pendingElement = new OBPendingIndicator($('shade'));
	this.pendingElement.show();

	var params = "";
	var nodes = $A(document.getElementsByName('nmdel'));
	var dNodes = nodes.select(function(node) {
		return node.checked;
	});
	dNodes.each(function(node) {
		params += node.value + ',';
	});
	sajax_do_call('smwf_nm_NotifyAccess', ["delNotify", params], this.delDone.bind(this));
},
/**
* @param request Request of AJAX call
*/
delDone:function(request){
	this.pendingElement.hide();
	var nodes = $A(document.getElementsByName('nmdel'));
	var sid='';
	var idx=1;
	nodes.each(function(node) {
		if(node.checked) sid += idx+',';
		idx++;
		return node.checked;
	});
	var ids = sid.split(',');
	for(i=ids.length-2;i>=0;--i){
		$('nmtable').deleteRow(ids[i]);
	}
	alert(request.responseText);
	$('shade').toggle();
},

delall:function(chked){
	var nodes = $A(document.getElementsByName('nmdel'));
	nodes.each(function(node) {
		node.checked = chked;
	});
},
enableall:function(chked){
	var nodes = $A(document.getElementsByName('nmenable'));
	nodes.each(function(node) {
		node.checked = chked;
	});
},
reportall:function(chked){
	var nodes = $A(document.getElementsByName('nmall'));
	nodes.each(function(node) {
		node.checked = chked;
	});
},
showall:function(chked){
	var nodes = $A(document.getElementsByName('nmsall'));
	nodes.each(function(node) {
		node.checked = chked;
	});
},
resetNotify:function(){
	this.delall(false);
	this.enableall(true);
},
updateDelegate:function(){
	/*STARTLOG*/
	if(window.smwhgLogger){
		smwhgLogger.log("Update delegates","NM","update_delegates");
	}
	/*ENDLOG*/

	$('shade').toggle();
	if(this.pendingElement)
		this.pendingElement.hide();
	this.pendingElement = new OBPendingIndicator($('shade'));
	this.pendingElement.show();

	var params = "";
	var nodes = $A(document.getElementsByName('nmdelegate'));
	var dNodes = nodes.select(function(node) {
		return (node.value != '');
	});
	dNodes.each(function(node) {
		params += node.id.substring(4) + ':' + node.value + '|';
	});
	sajax_do_call('smwf_nm_NotifyAccess', ["updateDelegates", params], this.updateDone.bind(this));
},
copyToClipboard:function(id){
	/*STARTLOG*/
	if(window.smwhgLogger){
		smwhgLogger.log("Copy nm rss to clipboard","NM","rss_copied");
	}
	/*ENDLOG*/
	var text = $(id).value;
	var succ = nmLanguage.getMessage('NM_FEED_COPY_SUCC');
	var fail = nmLanguage.getMessage('NM_FEED_COPY_FAIL');
 	if (window.clipboardData){ //IE
		window.clipboardData.setData("Text", text);
		alert(succ);
	}
  	else if (window.netscape) {
		try {
			netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
			var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
			if (!clip){
				alert(fail);
				return;
			}
			var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
			if (!trans){
				alert(fail);
				return;
			}
			trans.addDataFlavor('text/unicode');
			var str = new Object();
			var len = new Object();
			var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
			str.data=text;
			trans.setTransferData("text/unicode",str,text.length*2);
			var clipid=Components.interfaces.nsIClipboard;
			if (!clip){
				alert(fail);
				return;
			}
			clip.setData(trans,null,clipid.kGlobalClipboard);
			alert(succ);
		}
		catch (e) {
			alert(fail);
		}
	}
	else{
		alert(fail);
	}
},

// this function is highly depend on SpecialPage : QueryInterface
saveQueryToNotify:function() {
	if(!$('addnotifydialogue')) {
		var askdlg = $('showAsk');
		var nmdlg = document.createElement("div");
		askdlg.parentNode.insertBefore(nmdlg, askdlg);
		nmdlg.id = "addnotifydialogue";
		nmdlg.className = "topDialogue";
		nmdlg.style.display = "none";
		var html = nmLanguage.getMessage('NM_SAVE_CONFIRM') + "<br/>";
		html += nmLanguage.getMessage('NM_SAVE_NAME') + " <input type=\"text\" id=\"nmqname\"/><br />";
		html += "<input type=\"checkbox\" id=\"nmqrall\" checked>&nbsp;" + nmLanguage.getMessage('NM_SAVE_REPORT_ALL') + "<br />";
		html += "<input type=\"checkbox\" id=\"nmqsall\">&nbsp;" + nmLanguage.getMessage('NM_SAVE_SHOW_ALL') + "<br />";
		html += "<span class=\"qibutton\" onclick=\"notifyhelper.doSaveToNotifyQI()\">" + nmLanguage.getMessage('NM_SAVE_OK') + "</span>&nbsp;<span class=\"qibutton\" onclick=\"notifyhelper.doCancelNotifyQI()\">" + nmLanguage.getMessage('NM_SAVE_CANCEL') + "</span>";
		nmdlg.innerHTML = html;
	}
	$('shade').toggle();
	$('addnotifydialogue').toggle();
},
doSaveToNotifyQI:function(){
	if(window.smwhgLogger){
		smwhgLogger.log("Save Notify","QI","save_notify");
	}
	if(this.pendingElement)
		this.pendingElement.hide();
	this.pendingElement = new OBPendingIndicator($('shade'));
	this.pendingElement.show();

	if($('nmqname').value=="") {
		alert(nmLanguage.getMessage('NM_EMPTY_NOTIFYNAME'));
	}
	else if (!qihelper.queries[0].isEmpty()){ //only do this if the query is not empty
		var ask = qihelper.recurseQuery(0, "parser"); // Get full ask syntax
		qihelper.queries[0].getDisplayStatements().each(function(s) { ask += "\n| ?" + s});

		var params = ask.replace(/&/gm, "&amp;").replace(/,/gm, "&comma;") + ",";
		params += ($('nmqrall').checked ? 1 : 0) + ",";
		params += ($('nmqsall').checked ? 1 : 0) + ",";
		params += $('nmqname').value.replace(/&/gm, "&amp;").replace(/,/gm, "&comma;") + ",";
		params += ($('nmd_new') ? $('nmd_new').value : "");
		sajax_do_call('smwf_nm_NotifyAccess', ["addNotify", params], this.saveNotifyQI.bind(this));
	}
	else { // query is empty
		alert(gLanguage.getMessage('QI_EMPTY_QUERY'));
	}
},
saveNotifyQI:function(request){
	this.pendingElement.hide();
	var s = request.responseText;
	if(s.substring(0,1)=="1") {
		var enabled = (s.substring(1,2)=='1');
		s = s.substring(2);
		var i = s.indexOf(",");
		var nid = s.substring(0,i);
		alert(nmLanguage.getMessage('NM_SAVE_SUCC') + s.substring(i+1));
	} else alert(s);
	$('addnotifydialogue').toggle();
	$('shade').toggle();
},
doCancelNotifyQI:function(){
	$('addnotifydialogue').toggle();
	$('shade').toggle();
}

} //end class notifyHelper

Event.observe(window,'load',initialize_notify);

function initialize_notify(){
	notifyhelper = new NotifyHelper();

	// SMW / Halo extension contains wibbit which hooks all checkboxes,
	// have to load the event handler afterwards
	if($('nmemail')) $('nmemail').onclick = function() {notifyhelper.doUpdateMail();};
}

// copy from SMWHalo extension scripts/OntologyBrowser/generalTools.js
var OBPendingIndicator = Class.create();
OBPendingIndicator.prototype = {
	initialize: function(container) {
		this.container = container;
		this.pendingIndicator = document.createElement("img");
		Element.addClassName(this.pendingIndicator, "obpendingElement");
		this.pendingIndicator.setAttribute("src", wgServer + wgScriptPath + "/extensions/SemanticNotifyMe/skins/ajax-loader.gif");
		//this.pendingIndicator.setAttribute("id", "pendingAjaxIndicator_OB");
		//this.pendingIndicator.style.left = (Position.cumulativeOffset(this.container)[0]-Position.realOffset(this.container)[0])+"px";
		//this.pendingIndicator.style.top = (Position.cumulativeOffset(this.container)[1]-Position.realOffset(this.container)[1])+"px";
		//this.hide();
		//Indicator will not be added to the page on creation anymore but on fist time calling show
		//this is preventing errors during add if contentelement is not yet available  
		this.contentElement = null;
	},
	
	/**
	 * Shows pending indicator relative to given container or relative to initial container
	 * if container is not specified.
	 */
	show: function(container, alignment) {
		
		//check if the content element is there
		if($("content") == null){
			return;
		}
		
		var alignOffset = 0;
		if (alignment != undefined) {
			switch(alignment) {
				case "right": { 
					if (!container) { 
						alignOffset = $(this.container).offsetWidth - 16;
					} else {
						alignOffset = $(container).offsetWidth - 16;
					}
					
					break;
				}
				case "left": break;
			}
		}
			
		//if not already done, append the indicator to the content element so it can become visible
		if(this.contentElement == null) {
				this.contentElement = $("content");
				this.contentElement.appendChild(this.pendingIndicator);
		}
		if (!container) {
			this.pendingIndicator.style.left = (alignOffset + Position.cumulativeOffset(this.container)[0]-Position.realOffset(this.container)[0])+"px";
			this.pendingIndicator.style.top = (Position.cumulativeOffset(this.container)[1]-Position.realOffset(this.container)[1]+this.container.scrollTop)+"px";
		} else {
			this.pendingIndicator.style.left = (alignOffset + Position.cumulativeOffset($(container))[0]-Position.realOffset($(container))[0])+"px";
			this.pendingIndicator.style.top = (Position.cumulativeOffset($(container))[1]-Position.realOffset($(container))[1]+$(container).scrollTop)+"px";
		}
		// hmm, why does Element.show(...) not work here?
		this.pendingIndicator.style.display="block";
		this.pendingIndicator.style.visibility="visible";

	},
	
	/**
	 * Shows the pending indicator on the specified <element>. This works also
	 * in popup panels with a defined z-index.
	 */
	showOn: function(element) {
		container = element.offsetParent;
		$(container).insert({top: this.pendingIndicator});
		var pOff = $(element).positionedOffset();
		this.pendingIndicator.style.left = pOff[0]+"px";
		this.pendingIndicator.style.top  = pOff[1]+"px";
		this.pendingIndicator.style.display="block";
		this.pendingIndicator.style.visibility="visible";
		this.pendingIndicator.style.position = "absolute";
		
	},
	
	hide: function() {
		Element.hide(this.pendingIndicator);
	},

	remove: function() {
		Element.remove(this.pendingIndicator);
	}
}