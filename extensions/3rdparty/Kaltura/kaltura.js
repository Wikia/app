/*
This file is part of the Kaltura Collaborative Media Suite which allows users 
to do with audio, video, and animation what Wiki platfroms allow them to do with 
text.

Copyright (C) 2006-2008  Kaltura Inc.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/
// version = 02
//alert ("kaltura.js loaded from " + document.location );

var kaltura_root_url ="";

// kalturaRevert - called from article page when using 'revert'
function kalturaRevert ( url , rev , txt )
{
//	alert ( "kalturaRevert ( " + url + "," +  rev + ")" );
	res = confirm (txt);//'Do you want to revert to this version?');
	if ( res ) {
		url_str = url + '&undo=' + rev;
		document.location=url_str;
		return true;
	}
	else {
		return false;
	}
}




// initModalBox called from gotoCW - to open the contribution wizard as an iFrame in the 
// widget page
function kalturaInitModalBox ( url , params , kshow_id )
{
	var objBody = document.getElementsByTagName("body").item(0);

	// create overlay div and hardcode some functional styles (aesthetic styles are in CSS file)
	var objOverlay = document.createElement("div");
	objOverlay.setAttribute('id','overlay');
	objBody.appendChild(objOverlay, objBody.firstChild);
	
	// create modalbox div, same note about styles as above
	var objModalbox = document.createElement("div");
	objModalbox.setAttribute('id','modalbox');
	
	
	// create content div inside objModalbox
	var objModalboxContent = document.createElement("div");
	objModalboxContent.setAttribute('id','mbContent');
	if ( url != null )
	{
		objModalboxContent.innerHTML = '<iframe scrolling="no" width="680" height="360" frameborder="0" src="' + url + '/Special:KalturaContributionWizard?inframe=true&' + params + '&kshow_id=' + kshow_id + '" />';
	}
	objModalbox.appendChild(objModalboxContent, objModalbox.firstChild);
	
	objBody.appendChild(objModalbox, objOverlay.nextSibling);	
	
	return objModalboxContent;
}


function kalturaCloseModalBox ()
{
	if ( this != window.top )
	{
		window.top.kalturaCloseModalBox();
		return false;
	}
//	alert ( "kalturaCloseModalBox" );
	// TODO - have some JS to close the modalBox without refreshing the page if there is no need
	overlay_obj = document.getElementById("overlay");
	modalbox_obj = document.getElementById("modalbox");
	overlay_obj.parentNode.removeChild( overlay_obj );
	modalbox_obj.parentNode.removeChild( modalbox_obj );
	
	return false;
}

function $id(x){ return document.getElementById(x); }

function toggleHelp(){
	if( $id('content_help').style.display == 'none' ){
		$id('content_help').style.display = 'block';
		$id('content_main').style.display = 'none';
	}
	else{
		$id('content_help').style.display = 'none';
		$id('content_main').style.display = 'block';
	}
}

	
// called to refresh tha min page from within 
function kalturaRefreshTop ()
{
	if ( this != window.top )
	{
		window.top.kalturaRefreshTop();
		return false;
	}	
	window.location.reload(true);
}


function kalturaAddButtonsToEdit ( root_url , path , alt_for_btn )
{
	// set the global variable to be used later in the script
	kaltura_root_url = root_url;
//	alert ( "kalturaAddButtonsToEdit [" + path + "]" );
	addButton( path + 'btn_wiki_edit.gif', alt_for_btn , '2','3','<4>','kaltura_new_widget');	
	// the button is not yet in place - hook onto the load event until the whole page is ready
	hookEvent("load", kalturaHookButton);

}

var modalbox;
var hook_count = 10;
var last_caret_pos ;

function kalturaHookButton ( )
{
	var btn = document.getElementById("kaltura_new_widget");
	if ( btn == null )
	{
		hook_count--;
		if ( hook_count <= 0 ) return;
		setTimeout( 'kalturaHookButton()' , 200 );
	}
	

	btn.onclick = function() {
		
		if (document.editform) 
		{
			textarea = document.editform.wpTextbox1;
			last_caret_pos = kaltura_js_getCursorPosition ( textarea );
		}

		modalbox = kalturaInitModalBox ( null , null, null);
		modalbox.innerHTML = '<iframe scrolling="no" width="680" height="343" frameborder="0" src="' + kaltura_root_url + '/Special:kalturaAjaxCollaborativeVideoInfo?inframe=true" />';
		return false;
	};	

}


// this code is run in the child window - 
// be sure to user the parent's variable
function kalturaInsertWidget ( tag , pos)
{
//	alert ( "kalturaInsertWidget: " + tag );
	
	textarea = parent.top.document.editform.wpTextbox1;
	kaltura_js_setCursorPosition ( textarea , parent.top.last_caret_pos);
			
	// should be set in the parent document
	parent.top.insertTags( "" , "" , tag );
}




/*
 * Code for getting and setting the caret location in a textarea element.
 * We're using the kaltura_ prefix only as a namespace.
 */
function kaltura_js_countTextAreaChars(text) {
    var n = 0;
    for (var i = 0; i < text.length; i++) {
        if (text.charAt(i) != '\r') {
            n++;
        }
    }
    return n;
}

function kaltura_js_CursorPos(start, end) {
    this.start = start;
    this.end = end;
}

function kaltura_js_getCursorPosition(textArea) {
    var start = 0;
    var end = 0;
    if (document.selection) { // IE?
        textArea.focus();
        var sel1 = document.selection.createRange();
        var sel2 = sel1.duplicate();
        sel2.moveToElementText(textArea);
        var selText = sel1.text;
        sel1.text = "_01!_"; // this text should be unique
        var index = sel2.text.indexOf("_01!_"); // this text should be unique and the same as the above
        start = kaltura_js_countTextAreaChars((index == -1) ? sel2.text : sel2.text.substring(0, index));
        end = kaltura_js_countTextAreaChars(selText) + start;
        sel1.moveStart("character", -5); // this is the length of the unique text
        sel1.text = selText;
    } else if (textArea.selectionStart || (textArea.selectionStart == "0")) { // Mozilla/Netscape?
        start = textArea.selectionStart;
        end = textArea.selectionEnd;
    }
    return new kaltura_js_CursorPos(start, end);
}

function kaltura_js_setCursorPosition(textArea, cursorPos) {
    if (document.selection) { // IE?
        var sel = textArea.createTextRange();
        sel.collapse(true);
        sel.moveStart("character", cursorPos.start);
        sel.moveEnd("character", cursorPos.end - cursorPos.start);
        sel.select();
    } else if (textArea.selectionStart || (textArea.selectionStart == "0")) { // Mozilla/Netscape?
        textArea.selectionStart = cursorPos.start;
        textArea.selectionEnd = cursorPos.end;
    }
    textArea.focus();
}