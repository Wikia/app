<!--



var ss_memory = null;
var pm_name_count = false;
function GetPmNames(){
    var newdiv = document.getElementById("ajax_pmname");
    if (!newdiv) {
        var newdiv = document.createElement("div");
        newdiv.id = "ajax_pmname";
        var searchdiv = document.getElementById("ajax_pmnames");
        searchdiv.appendChild(newdiv);
    }
    var x = document.getElementById("send_to").value;
    if (x == ss_memory) {
        return;
    }
    
    if (x.indexOf(";") >= 0) {
        var splt = new Array();
        splt = x.split(';');
        x = splt[splt.length -1];
       /* alert(".." + splt.length);  */
    }
    
    
    ss_memory = x;
    document.getElementById("ajax_pmname").style.display = 'none';
    if (x.length < 30 && x.length > 1 && x.value != "") {
        sajax_do_call("awcforum_ajax::GetPMnames", [x], newdiv);
        document.getElementById("ajax_pmname").style.display = 'block';
    }
}
 
function pm_ajax_onload(){
    
    var x = document.getElementById('send_to');
    
    if (x != null) {
        x.onkeyup = function(){
            GetPmNames();
        }
    }
    
    
}

function SetPMname(b) {

    if(pm_name_count == false){
        document.getElementById("send_to").value = b ;
    } else {
    
        var old;
        old = document.getElementById("send_to").value;

        document.getElementById("send_to").value = old.replace(';' + ss_memory,';') +  b ;
    }
    
    
    pm_name_count = true;
    ss_memory = null;
    document.getElementById("ajax_pmname").style.display = 'none';
}










function add_emotions(emot){

    var emo = emot.replace("%27","'")        
        

    // needs iframe work...  FF not working
    if(document.getElementById('wpTextbox1___Frame')){
       
            var iframeEl = document.getElementById('wpTextbox1___Frame');
           // alert(iframeEl);
            if (document.all) { //IS IE 4 or 5 (or 6 beta)
               // alert("IS IE 4 or 5 (or 6 beta)");
                var myField = iframeEl.contentWindow.document.getElementById('xEditingArea');
            } else {
                var myField = iframeEl.contentDocument.getElementsByTagName('xEditingArea');
               // var myField = xxx.removeChild;
            }
            

        if ( iframeEl.contentDocument ) { // DOM
            
           // var myField = iframeEl.contentDocument.getElementById('xEditingArea');
        } else if ( iframeEl.contentWindow ) { // IE win
          //  var myField = iframeEl.contentWindow.document.getElementById('xEditingArea');
        }
        
       
    } else {
      //  alert("no frame");
        var myField = document.getElementById("wpTextbox1");
    }
    

     //IE support
    if (document.selection && document.selection.createRange) {
        //alert("IE");
        myField.focus();
        sel = document.selection.createRange();
        sel.text = emo;
    }
    //MOZILLA/NETSCAPE support
    else if (myField.selectionStart || myField.selectionStart == '0') {
    //alert("MOZILLA");
            var startPos = myField.selectionStart;
            var endPos = myField.selectionEnd;
                myField.value = myField.value.substring(0, startPos)
                + emo
                + myField.value.substring(endPos, myField.value.length);
                myField.focus() ; 
                myField.selectionStart = (emo.length + startPos);
                myField.selectionEnd = (emo.length + startPos); 
        } else {
            myField.value = emo;
    }



   /* insertTags(emo, '', ''); */

}


  
function checkall_toggle(formname, checkname, chk){

    var FormIs = eval("document.forms."+formname);
    
    for (i=0; i<FormIs.elements.length; i++) {
        if (FormIs.elements[i].name== checkname)
            FormIs.elements[i].checked = chk;
    }
    
    
}

function check_mod() {


   var w = document.mod_form.do_what.selectedIndex;
   var selected_text = document.mod_form.do_what.options[w].text;
   var selected_val = document.mod_form.do_what.options[w].value;
   
   
   if(selected_val == 'null') {
        return false;
   }
   
    if(confirm(selected_text + ' ?')) {
        document.mod_form.submit();
        return true;
    }
    
    return false;
}

function check_NewThread() {

    if (document.editform.t_title.value == "") {
        alert("Need Thread Title");
        document.editform.t_title.focus();
    return false;
    }
    
    if (document.editform.xEditingArea.value == "") { 
        if (document.editform.wpTextbox1.value == "") {
            alert("Need text in Post box");
            document.editform.wpTextbox1.focus();
           return false;
        }
        
    }

    return true;
}



function check_NewThreadTitle() {

    if (document.spltform.t_title.value == "") {
        alert("Need Thread Title");
        document.spltform.t_title.focus();
    return false;
    }

    return true;
}

function check_MergeID() {

    if (document.mergeform.tID.value == "") {
        alert("Need thread ID to Merge to");
        document.mergeform.tID.focus();
    return false;
    }

    return true;
}



function check_quickPost() {

    if (document.editform.wpTextbox1.value == "") {
        alert("Need text in Post box");
        document.editform.wpTextbox1.focus();
      return false;
    }

    return true;
}

function msgbox(txt) {

    if(confirm(txt)) {
        return true;
    }
    return false;
}


function msgcheck(todo,txt) {

	if(confirm(txt)) {
		SideBar_RedirectUrl = todo;
		setTimeout( "window.location.href = SideBar_RedirectUrl", 0 );
		return true;
	}
	return false;
}

function delete_form_check(txt) {
    
    if(confirm(txt)) {
        return true;
    }
    return false;
}


function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}



/* 
Used for the drop down menus... 
Sorry, do not have the time right now to make up my own.
Snagged this from Online and made a few edit to make it work with the forum.

Copyright 2006-2007 javascript-array.com
*/
// close layer when click-out
//document.onclick = mclose; 

var timeout    = 500;
var closetimer  = 0;
var ddmenuitem  = 0;

// open hidden layer
function mopen(id)
{    
    // cancel close timer
    mcancelclosetime();

    // close old layer
    if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

    // get new layer and show it
    ddmenuitem = document.getElementById(id);
    ddmenuitem.style.visibility = 'visible';

}
// close showed layer
function mclose()
{
    if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
    closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
    if(closetimer)
    {
        window.clearTimeout(closetimer);
        closetimer = null;
    }
}


// END - Copyright 2006-2007 javascript-array.com


// -->