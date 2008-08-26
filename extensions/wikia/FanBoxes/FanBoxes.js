
//display right side of fanbox as user inputs info
function displayRightSide() {
	rightSideOutput = document.form1.inputRightSide.value
	document.getElementById("fanBoxRightSideOutput2").innerHTML = rightSideOutput
}
			
//display left side as user inputs info and sets imagename value to empty (just in case he previously uploaded an image)
function displayLeftSide() {
	leftSideOutput = document.form1.inputLeftSide.value
	document.getElementById("fanBoxLeftSideOutput2").innerHTML = leftSideOutput
	document.getElementById("fantag_image_name").value = ""
}

//if user uploaded image, and then typed in text, and now wants to insert image again, he can just click it
function insertImageToLeft(){
	document.getElementById("fantag_image_name").value = document.getElementById("fanbox_image").value
	document.getElementById("fanBoxLeftSideOutput2").innerHTML = document.getElementById("fanbox_image").innerHTML
	document.getElementById("inputLeftSide").value = ""
}



//countdown as user tpes characters						
function limitText (limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} 
	else {
		limitCount.value = limitNum - limitField.value.length;
	}
}


//limits the left side fanbox so user can't type in tons of characters without a space
function leftSideFanBoxFormat(){
	str_left_side = document.form1.inputLeftSide.value;
	str_left_side_length = document.form1.inputLeftSide.value.length;
	space_position = str_left_side.substring(str_left_side_length - 5, str_left_side_length).search(" ");
	if (str_left_side.length < 6) {
		document.form1.inputLeftSide.maxLength = 11;
	}			
	if (space_position == -1 && str_left_side.length > 6) {
		document.form1.inputLeftSide.maxLength = str_left_side.length;
	}
	if (space_position == -1 && str_left_side.length == 6) {
		document.form1.inputLeftSide.value = document.form1.inputLeftSide.value.substring(0,5) + " " + document.form1.inputLeftSide.value.substring(5,6);
		document.getElementById("fanBoxLeftSideOutput2").innerHTML = document.form1.inputLeftSide.value.substring(0,5) + " " + document.form1.inputLeftSide.value.substring(5,7);
	}
	if (str_left_side.length >= 5) {
		document.getElementById("fanBoxLeftSideOutput2").style.fontSize = "14px"
		document.getElementById("textSizeLeftSide").value = 'mediumfont'
	}
	else{
		document.getElementById("fanBoxLeftSideOutput2").style.fontSize = "20px"
		document.getElementById("textSizeLeftSide").value = 'bigfont'
	}
}

//limits right side so user can't type in tons of characters without a space

function rightSideFanBoxFormat(){
	str_right_side = document.form1.inputRightSide.value;
	str_right_side_length = document.form1.inputRightSide.value.length;
	space_position = str_right_side.substring(str_right_side_length - 17, str_right_side_length).search(" ");
	if (str_right_side.length < 18) {
		document.form1.inputRightSide.maxLength = 70;
	}			
	if (space_position == -1 && str_right_side.length > 18) {
		document.form1.inputRightSide.maxLength = str_right_side.length;
	}
	if (space_position == -1 && str_right_side.length == 18) {
		document.form1.inputRightSide.value = document.form1.inputRightSide.value.substring(0,17) + " " + document.form1.inputRightSide.value.substring(17,18);
		document.getElementById("fanBoxRightSideOutput2").innerHTML = document.form1.inputRightSide.value.substring(0,17) + " " + document.form1.inputRightSide.value.substring(17,19);
	}

	if (str_right_side.length >= 52) {
		document.getElementById("fanBoxRightSideOutput2").style.fontSize = "12px"
		document.getElementById("textSizeRightSide").value = 'smallfont'
	}
	else{
		document.getElementById("fanBoxRightSideOutput2").style.fontSize = "14px"
		document.getElementById("textSizeRightSide").value = 'mediumfont'
	}
}




//the below 3 fnctions are used to open, add/remove, and close the fanbox popup box when u click on it

	
function openFanBoxPopup(popupbox, fanbox) {
		popupbox = document.getElementById(popupbox);
		fanbox = document.getElementById(fanbox);		
		popupbox.style.display = (popupbox.style.display == 'block') ? 'none' : 'block';
		fanbox.style.display = (fanbox.style.display == 'none') ? 'block' : 'none';
				
}
	
		
function closeFanboxAdd(popupbox, fanbox) {
		popupbox = document.getElementById(popupbox);
		fanbox = document.getElementById(fanbox);		
		popupbox.style.display = 'none';
		fanbox.style.display = 'block';		
}

//display image box
function displayAddImage(el, el2, el3) {
		el = document.getElementById(el);
		el.style.display = (el.style.display == 'block') ? 'none' : 'block';
		el2 = document.getElementById(el2);
		el3 = document.getElementById(el3);		
		el2.style.display = 'none';
		el3.style.display = 'inline';		

}


//category cloud
function insertTag(tagname,tagnumber){
		YAHOO.util.Dom.setStyle("tag-" + tagnumber, 'color', "#cccccc");
		//Element.setStyle($("tag-" + tagnumber),{'color':  "#cccccc" });
		$("tag-" + tagnumber).innerHTML = tagname;
		$("pageCtg").value += (($("pageCtg").value)?", ":"") + tagname;
	}	




function showMessage(addremove, title, fantagid){
		var url = "index.php?action=ajax";
		var pars = 'rs=wfFanBoxShowaddRemoveMessage&rsargs[]=' + addremove + '&rsargs[]=' + title + '&rsargs[]=' + fantagid
		YAHOO.widget.Effects.Hide('show-message-container'+fantagid);
		var callback = {
			success: function( oResponse ) {
				$('show-message-container'+fantagid).innerHTML = oResponse.responseText;
				YAHOO.widget.Effects.Appear('show-message-container'+fantagid,{duration:2.0} );
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);

}	
	
function showAddRemoveMessageUserPage(addremove,id, style){
		var url = "index.php?action=ajax";
		var pars = 'rs=wfMessageAddRemoveUserPage&rsargs[]=' + addremove + '&rsargs[]=' + id + '&rsargs[]=' + style
		YAHOO.widget.Effects.Hide('show-message-container'+id);
		var callback = {
			success: function( oResponse ) {
				$('show-message-container'+id).innerHTML = oResponse.responseText;
				YAHOO.widget.Effects.Appear('show-message-container'+id,{duration:2.0} );
			}
		};
		var request = YAHOO.util.Connect.asyncRequest('POST', url, callback, pars);

}