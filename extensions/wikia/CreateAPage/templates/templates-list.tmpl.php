<!-- s:<?= __FILE__ ?> -->

<noscript>
<style type="text/css">
/*<![CDATA[*/

#wpTableMultiEdit div div .createpage_input_file label,
#cp-infobox div .createpage_input_file label {
        float:left !important;
        background:#ffffff;
        border: none;
        color:black;
        cursor: auto;
}

#wpTableMultiEdit div div .createpage_input_file label span,
#cp-infobox div .createpage_input_file label span {
	display: none !important;	
}

#wpTableMultiEdit div div .createpage_input_file label input,
#cp-infobox div .createpage_input_file label input {
        position:relative !important;
        font-size:9pt !important;
        line-height:12px !important;
        opacity:100 !important;
        zoom:1 !important;
        filter:alpha(opacity=100) !important;
}

/*]]>*/
</style>
</noscript>

<script type="text/javascript">
/*<![CDATA[*/

var NoCanDo = false ;

YWC.PreviewMode = '<?= !$ispreview ? "No" : "Yes" ?>' ;
YWC.RedLinkMode = '<?= !$isredlink ? "No" : "Yes" ?>' ;

YWC.RedirectCallback = {
    upload: function( oResponse ) {
        window.location = wgServer + wgScript + '?title=' + escape (document.getElementById ('Createtitle').value) + '&action=edit&editmode=nomulti&createpage=true'  ;
    } ,
    failure: function (oResponse) {
    } ,
    timeout: 50000
};

YWC.SubmitEnabled = false ;

YWC.ClearInput = function (o) {
        var Cdone = false;
        var Infobox_callback = function (e, o) {
		var previewarea = YD.get ('createpagepreview') ;
                if ( ! Cdone && (previewarea == null) ) {
                        Cdone = true;
                        YD.get('wpInfoboxPar' + o.num).value = '' ;
                }
        }
        YE.addListener ('wpInfoboxPar' + o.num, 'focus', Infobox_callback, {num: o.num} ) ;
};

YWC.goToEdit = function (e) {
	    var oForm = YD.get("createpageform") ;
	    YE.preventDefault(e);
	    YC.setForm (oForm, true) ;
    	    YC.asyncRequest('POST', "/index.php?action=ajax&rs=axCreatepageAdvancedSwitch", YWC.RedirectCallback );
	YWC.warningPanel.hide();
}

YWC.goToLogin = function (e) {
	YE.preventDefault (e) ;
	if (YWC.RedLinkMode) {
		window.location = wgServer + wgScript + '?title=Special:Userlogin&returnto=' + escape (document.getElementById ('Createtitle').value) ;
	} else {
		window.location = wgServer + wgScript + '?title=Special:Userlogin&returnto=Special:Createpage' ;
	}	
}

YWC.hideWarningPanel = function (e) {
        if (YWC.warningPanel) {
                YWC.warningPanel.hide () ;
        }
}

YWC.showWarningPanel = function (e) {
        YE.preventDefault (e) ;
        if (document.getElementById('Createtitle').value != '') {
                if (!YWC.warningPanel) {
                        YWC.buildWarningPanel () ;
                }
                YWC.warningPanel.show () ;
		YD.get ("wpCreatepageWarningYes").focus () ;
        } else {
		YD.get('cp-title-check').innerHTML = '<span style="color: red;"><?= wfMsg ('createpage_give_title') ?></span>' ;
	}
}

YWC.hideWarningLoginPanel = function (e) {
        if (YWC.warningLoginPanel) {
                YWC.warningLoginPanel.hide () ;
        }
}

YWC.showWarningLoginPanel = function (e) {
        YE.preventDefault (e) ;
        if (document.getElementById('Createtitle').value != '') {
                if (!YWC.warningLoginPanel) {
                        YWC.buildWarningLoginPanel () ;
                }
                YWC.warningLoginPanel.show () ;
		YD.get ("wpCreatepageWarningYes").focus () ;
        } else {
		YD.get ('cp-title-check').innerHTML = '<span style="color: red;"><?= wfMsg ('createpage_give_title') ?></span>' ;
	}
}

YWC.Abort = function (e, o) {
	YC.abort (o.request, o.callback) ;	
}

YWC.ToolbarButtons = [] ;

<?php
	$tool_arr = CreateMultiPage::getToolArray () ;
	$tool_num = 0 ;
	global $wgStylePath ;
	foreach ($tool_arr as $single_tool) { ?>		    		
		YWC.ToolbarButtons [<?= $tool_num ?>] = [] ; 
		YWC.ToolbarButtons [<?= $tool_num ?>]['image'] = '<?= $wgStylePath . '/common/images/' . $single_tool ['image'] ?>' ;
		YWC.ToolbarButtons [<?= $tool_num ?>]['id'] = '<?= $single_tool ['id'] ?>' ;
		YWC.ToolbarButtons [<?= $tool_num ?>]['open'] = '<?= $single_tool ['open'] ?>' ;
		YWC.ToolbarButtons [<?= $tool_num ?>]['close'] = '<?= $single_tool ['close'] ?>' ;
		YWC.ToolbarButtons [<?= $tool_num ?>]['sample'] = '<?= $single_tool ['sample'] ?>' ;
		YWC.ToolbarButtons [<?= $tool_num ?>]['tip'] = '<?= $single_tool ['tip'] ?>' ;		
		YWC.ToolbarButtons [<?= $tool_num ?>]['key'] = '<?= $single_tool ['key'] ?>' ;
<?php    	
		$tool_num++ ;	    				
	}
?>

YWC.UploadCallback = function (oResponse) {
	var aResponse = YT.JSONParse(oResponse.responseText);
	var ProgressBar = YD.get("createpage_upload_progress_section" + aResponse ["num"]) ;

	if ( aResponse["error"] != 1 ) {
		ProgressBar.innerHTML = "<?= wfMsg ('createpage_img_uploaded') ?>" ;
		var target_info = YD.get ("wpAllUploadTarget" + aResponse ["num"]).value ;
		var target_tag = YD.get (target_info) ;
		target_tag.value = "[[" + aResponse ["msg"] + "|thumb]]" ;


		var ImageThumbnail = YD.get ("createpage_image_thumb_section" + aResponse ["num"]) ;
		var thumb_container = YD.get ("createpage_main_thumb_section" + aResponse ["num"]) ;
		var tempstamp = new Date () ;
		ImageThumbnail.src = aResponse ["url"] + '?' + tempstamp.getTime () ;		
		if (YD.get ("wpAllLastTimestamp" + aResponse ["num"]).value == "None") {
			var break_tag = document.createElement ('br') ;
			thumb_container.style.display = '' ;
			var label_node = YD.get ("createpage_image_label_section" + aResponse ["num"]) ;
			var par_node = label_node.parentNode ;
			par_node.insertBefore (break_tag, label_node) ;
		}		
		YD.get ("wpAllLastTimestamp" + oResponse.argument).value = aResponse ["timestamp"] ;
        } else if ( (aResponse ["error"] == 1) && (aResponse ["msg"] == 'cp_no_login') ) {
                ProgressBar.innerHTML = '<span style="color: red"><?= wfMsg ('createpage_login_required') ?>' + '<a href="' + wgServer + wgScript +'?title=Special:Userlogin&returnto=Special:Createpage" id="createpage_login' + oResponse.argument + '"><?= wfMsg ('createpage_login_href') ?></a>' + "<?= wfMsg ('createpage_login_required2') ?></span>" ;
		YE.addListener('createpage_login' + oResponse.argument, 'click', YWC.showWarningLoginPanel) ;		
        } else {
                ProgressBar.innerHTML = '<span style="color: red">' + aResponse ["msg"] + '</span>' ;
	}

        YD.get ("createpage_image_text_section" + oResponse.argument).innerHTML = "<?= wfMsg ("createpage_insert_image") ?>" ;
        YD.get ("createpage_upload_file_section" + oResponse.argument).style.display = '' ;
        YD.get ("createpage_image_text_section" + oResponse.argument).style.display = '' ;
        YD.get ("createpage_image_cancel_section" + oResponse.argument).style.display = 'none' ;
};

YWC.FailureCallback = function (oResponse) {
	YD.get ("createpage_image_text_section" + oResponse.argument).innerHTML = "<?= wfMsg ("createpage_insert_image") ?>" ;
	YD.get ("createpage_upload_progress_section" + oResponse.argument).innerHTML = "<?= wfMsg ("createpage_upload_aborted") ?>" ;	
	YD.get ("createpage_upload_file_section" + oResponse.argument).style.display = '' ;
	YD.get ("createpage_image_text_section" + oResponse.argument).style.display = '' ;
        YD.get ("createpage_image_cancel_section" + oResponse.argument).style.display = 'none' ;
};

YWC.Upload = function (e, o) {
    var oForm = YD.get("createpageform") ;
    YE.preventDefault(e);
    YC.setForm( oForm, true);

    var ProgressBar = YD.get("createpage_upload_progress_section" + o.num) ;
    ProgressBar.style.display = 'block' ;
    ProgressBar.innerHTML = '<img src="/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" />&nbsp;';

    var callback = {
    	upload: YWC.UploadCallback ,
	failure: YWC.FailureCallback ,
	argument: [o.num] ,
	timeout: 240000
   }

    var sent_request = YC.asyncRequest('POST', "/index.php?action=ajax&rs=axMultiEditImageUpload&infix=All&num=" + o.num, callback) ;
    YD.get ("createpage_image_cancel_section" + o.num).style.display = '' ;
    YD.get ("createpage_image_text_section" + o.num).style.display = 'none' ;
    
    YE.addListener ("createpage_image_cancel_section" + o.num, "click", YWC.Abort, {"request": sent_request, "callback": callback} ) ;

    var neoInput = document.createElement ('input') ;
    var thisInput = YD.get ('createpage_upload_file_section' + o.num) ;
    var thisContainer = YD.get ('createpage_image_label_section' + o.num) ;
    thisContainer.removeChild (thisInput) ;

    neoInput.setAttribute('type', 'file') ;
    neoInput.setAttribute('id', 'createpage_upload_file_section' + o.num) ;
    neoInput.setAttribute ('name', 'wpAllUploadFile' + o.num) ;
    neoInput.setAttribute('tabindex', '-1') ;

    thisContainer.appendChild (neoInput) ;
    YE.addListener( "createpage_upload_file_section" + o.num, "change", YWC.Upload, {"num" : o.num } );

    YD.get ("createpage_upload_file_section" + o.num).style.display = 'none' ;    
}

YWC.buildWarningPanel = function(e) {
        var editwarn = document.getElementById ('createpage_advanced_warning') ;
        var editwarn_copy = document.createElement ('div') ;
        editwarn_copy.id = 'createpage_warning_copy' ;
        editwarn_copy.innerHTML  = editwarn.innerHTML ;
        document.body.appendChild (editwarn_copy) ;
        YWC.warningPanel = new YAHOO.widget.Panel('createpage_warning_copy', {
                width: "250px" ,
                modal: true ,
                constraintoviewport: true ,
                draggable: false ,
                fixedcenter: true ,
                underlay: "none"
        } );
	YWC.warningPanel.cfg.setProperty("zIndex", 1000) ;
        YWC.warningPanel.render (document.body) ;
        YE.addListener( "wpCreatepageWarningYes", "click", YWC.goToEdit ) ;
        YE.addListener( "wpCreatepageWarningNo", "click", YWC.hideWarningPanel ) ;
}

YWC.buildWarningLoginPanel = function(e) {
        var editwarn = document.getElementById ('createpage_advanced_warning') ;
        var editwarn_copy = document.createElement ('div') ;
        editwarn_copy.id = 'createpage_warning_copy2' ;
        editwarn_copy.innerHTML  = editwarn.innerHTML ;
	editwarn_copy.childNodes[1].innerHTML = "<?= wfMsg ('login') ?>" ;
	editwarn_copy.childNodes[3].innerHTML = "<?= wfMsg ('createpage_login_warning') ?>" ;
        document.body.appendChild (editwarn_copy) ;
        YWC.warningLoginPanel = new YAHOO.widget.Panel('createpage_warning_copy2', {
                width: "250px" ,
                modal: true ,
                constraintoviewport: true ,
                draggable: false ,
                fixedcenter: true ,
                underlay: "none"
        } );
	YWC.warningLoginPanel.cfg.setProperty("zIndex", 1000) ;
        YWC.warningLoginPanel.render (document.body) ;
        YE.addListener( "wpCreatepageWarningYes", "click", YWC.goToLogin ) ;
        YE.addListener( "wpCreatepageWarningNo", "click", YWC.hideWarningLoginPanel ) ;
}

YWC.onclickCategoryFn = function (cat, id) {
	return function () {
		cloudRemove (escape(cat), id) ;
		return false ;
	}
}

YWC.clearTitleMessage = function (e) {
        YE.preventDefault (e) ;
	YD.get('cp-title-check').innerHTML = '' ;
}

YWC.UploadTest = function (el) {
	if (el.id.match ("createpage_upload_file_section")) {
		return true ;
	} else {
		return false ;
	}      
}

YWC.EditTextareaTest = function (el) {
	if (el.id.match ("wpTextboxes") && (el.style.display != 'none') ) {
		return true ;
	} else {
		return false ;
	}      
}

YWC.UploadEvent = function (el) {
        var j = parseInt ( el.id.replace ("createpage_upload_file_section","") ) ;
	YE.addListener( "createpage_upload_file_section" + j, "change", YWC.Upload, {num : j } );
}

YWC.TextareaAddToolbar = function (el) {
	var el_id = parseInt (el.id.replace ("wpTextboxes", "")) ;	
	YWC.multiEditTextboxes [YWC.multiEditTextboxes.length] = el_id ;
        YWC.multiEditButtons [el_id] = [] ;
        YWC.multiEditCustomButtons [el_id] = [] ;
        YE.addListener (el.id, 'focus', YWC.showThisBox, {'toolbarId' : el_id }) ;
	for (var i=0; i < YWC.ToolbarButtons.length; i++) {
		YWC.addMultiEditButton (YWC.ToolbarButtons[i]['image'], YWC.ToolbarButtons[i]['tip'], YWC.ToolbarButtons[i]['open'], YWC.ToolbarButtons[i]['close'], YWC.ToolbarButtons[i]['sample'], YWC.ToolbarButtons[i]['id'] + el_id, el_id) ;	
	}	
	
}

YWC.foundCategories = [] ;

YWC.CheckCategoryCloud = function () {
	var cat_textarea = YD.get ('wpCategoryTextarea') ;
	if (!cat_textarea) {
		return ;
	}

	var cat_full_section = YD.get ('createpage_cloud_section') ;

	var cloud_num = (cat_full_section.childNodes.length - 1) / 2 ;
	var n_cat_count = cloud_num ;
	var text_categories = new Array () ;	
	for (i=0;i<cloud_num;i++) {
		var cloud_id = 'cloud' + i ;
		var found_category = YD.get (cloud_id).innerHTML ;
		if (found_category) {
			YWC.foundCategories[i] = found_category ;
		}		
	}

	var categories = cat_textarea.value ;
	if ('' == categories) {
		return ;
	}

        categories = categories.split ("|") ;
        for (i=0;i<categories.length;i++) {
                text_categories [i] =  categories[i] ;
        }

	for (i=0; i<text_categories.length;i++) {
		var c_found = false ;
		for (j in YWC.foundCategories) {
			var core_cat = text_categories[i].replace (/\|.*/,'') ;
			if (YWC.foundCategories[j] == core_cat) {
				this_button = YD.get ('cloud'+ j) ;
				var actual_cloud = YWC.foundCategories[j] ;
				var cl_num = j ;

				this_button.onclick = YWC.onclickCategoryFn (text_categories[i],j) ;
				this_button.style.color = "#419636" ;
				c_found = true ;
				break ;
			}
		}
		if (!c_found) {
			var n_cat = document.createElement ('a') ;
			var s_cat = document.createElement ('span') ;
			n_cat_count++ ;
			var cat_num = n_cat_count - 1 ;
			n_cat.setAttribute ('id','cloud' + cat_num) ;
			n_cat.setAttribute ('href','#') ;
			n_cat.onclick = YWC.onclickCategoryFn (text_categories[i], cat_num) ;
			n_cat.style.color = '#419636' ;
			n_cat.style.fontSize = '10pt' ;
			s_cat.setAttribute ('id','tag' + n_cat_count) ;
			t_cat = document.createTextNode (core_cat) ;
			space = document.createTextNode (' ') ;
			n_cat.appendChild (t_cat) ;
			s_cat.appendChild (n_cat) ;
			s_cat.appendChild (space) ;
			cat_full_section.appendChild (s_cat) ;
		}
	}
}

YWC.multiEditTextboxes = [] ;
YWC.multiEditButtons = [] ;
YWC.multiEditCustomButtons = [] ;

YWC.addMultiEditButton = function (imageFile, speedTip, tagOpen, tagClose, sampleText, imageId, toolbarId) {
        YWC.multiEditButtons [toolbarId] [YWC.multiEditButtons [toolbarId].length] =
                {"imageId": imageId,
		 "toolbarId": toolbarId,
                 "imageFile": imageFile,
                 "speedTip": speedTip,
                 "tagOpen": tagOpen,
                 "tagClose": tagClose,
                 "sampleText": sampleText};
}

YWC.showThisBox = function (e, o) {
	YE.preventDefault (e) ;
	YD.get ('toolbar' + o.toolbarId).style.display = '' ;
	YWC.hideOtherBoxes (o.toolbarId) ;
}

YWC.hideOtherBoxes = function (box_id) {
	for (var i = 0; i < YWC.multiEditTextboxes.length; i++) {
		if (YWC.multiEditTextboxes [i] != box_id) {
			YD.get ('toolbar' + YWC.multiEditTextboxes [i]).style.display = 'none' ;
		}		
	}		
}
	
YWC.multiEditSetupToolbar = function ()  {
	for (var j = 0; j < YWC.multiEditButtons.length; j++) {
		var toolbar = document.getElementById ('toolbar' + j) ;
		if (toolbar) {
		        var textbox = document.getElementById('wpTextboxes' + j);
		        if (!textbox) { return false; }
			if (!(document.selection && document.selection.createRange)
					&& textbox.selectionStart === null) {
				return false;
			}

			for (var i = 0; i < YWC.multiEditButtons [j].length; i++) {
				YWC.insertMultiEditButton(toolbar, YWC.multiEditButtons[j][i]);
			}
		}
	}
        return true;
}

YWC.insertMultiEditButton = function (parent, item) {
        var image = document.createElement("img");
        image.width = 23;
        image.height = 22;
        image.className = "mw-toolbar-editbutton";
        if (item.imageId) image.id = item.imageId;
        image.src = item.imageFile;
        image.border = 0;
        image.alt = item.speedTip;
        image.title = item.speedTip;
        image.style.cursor = "pointer";

        parent.appendChild(image);
	YE.addListener (item.imageId, "click", YWC.insertTags, {"tagOpen" : item.tagOpen, "tagClose" : item.tagClose, "sampleText" : item.sampleText, "textareaId" : 'wpTextboxes' + item.toolbarId } );
        return true;
}

YWC.insertTags = function (e, o) {
    	YE.preventDefault(e);
        var textarea = YD.get (o.textareaId) ;
	if (!textarea) {
		return ;
	}
        var selText, isSample = false;

        if (document.selection  && document.selection.createRange) {
                if (document.documentElement && document.documentElement.scrollTop)
                        var winScroll = document.documentElement.scrollTop
                else if (document.body)
                        var winScroll = document.body.scrollTop;
                textarea.focus();
                var range = document.selection.createRange();
                selText = range.text;
                checkSelectedText();
                range.text = o.tagOpen + selText + o.tagClose;
                if (isSample && range.moveStart) {
                        if (window.opera)
                                o.tagClose = o.tagClose.replace(/\n/g,'');
                        range.moveStart('character', - o.tagClose.length - selText.length);
                        range.moveEnd('character', - o.tagClose.length);
                }
                range.select();
                if (document.documentElement && document.documentElement.scrollTop)
                        document.documentElement.scrollTop = winScroll
                else if (document.body)
                        document.body.scrollTop = winScroll;

        } else if (textarea.selectionStart || textarea.selectionStart == '0') {
                var textScroll = textarea.scrollTop;
                textarea.focus();
                var startPos = textarea.selectionStart;
                var endPos = textarea.selectionEnd;
                selText = textarea.value.substring(startPos, endPos);
                checkSelectedText();
                textarea.value = textarea.value.substring(0, startPos)
                       + o.tagOpen + selText + o.tagClose
                        + textarea.value.substring(endPos, textarea.value.length);
                if (isSample) {
                        textarea.selectionStart = startPos +o.tagOpen.length;
                        textarea.selectionEnd = startPos + o.tagOpen.length + selText.length;
                } else {
                        textarea.selectionStart = startPos + o.tagOpen.length + selText.length + o.tagClose.length;
                        textarea.selectionEnd = textarea.selectionStart;
                }
                textarea.scrollTop = textScroll;
        }

        function checkSelectedText(){
                if (!selText) {
                        selText = o.sampleText;
                        isSample = true;
                } else if (selText.charAt(selText.length - 1) == ' ') {
                        selText = selText.substring(0, selText.length - 1);
                        o.tagClose += ' '
                }
        }
}

window.onresize = function () {
	if (YWC.Overlay && (YD.get ('createpageoverlay').style.visibility != 'hidden') ) {
		YWC.ResizeOverlay (0) ;
	}
} ;

YWCI.UploadCallback = function (oResponse) {
	var aResponse = YT.JSONParse(oResponse.responseText);
	var ProgressBar = YD.get ("createpage_upload_progress" + oResponse.argument) ;
	if ( aResponse["error"] != 1 ) {
		var xInfoboxText = YD.get ("wpInfoboxValue").value ;
		var xImageHelper = YD.get ("wpInfImg" + oResponse.argument).value ;
		YD.get ("wpInfImg" + oResponse.argument).value = aResponse ["msg"] ;
		YD.get ("wpNoUse" + oResponse.argument).value = 'Yes' ;
		ProgressBar.innerHTML = "<?= wfMsg ("createpage_img_uploaded") ?>" ;
		var ImageThumbnail = YD.get ("createpage_image_thumb" + oResponse.argument) ;
		var thumb_container = YD.get ("createpage_main_thumb" + oResponse.argument) ;
		var tempstamp = new Date () ;
		ImageThumbnail.src = aResponse ["url"] + '?' + tempstamp.getTime () ;		
		if (YD.get ("wpLastTimestamp" + oResponse.argument).value == "None") {
			var break_tag = document.createElement ('br') ;
			thumb_container.style.display = '' ;
			var label_node = YD.get ("createpage_image_label" + oResponse.argument) ;
			var par_node = label_node.parentNode ;
			par_node.insertBefore (break_tag, label_node) ;
		}		
		YD.get ("wpLastTimestamp" + oResponse.argument).value = aResponse ["timestamp"] ;
	} else if ( (aResponse ["error"] == 1) && (aResponse ["msg"] == 'cp_no_login') ) {
		ProgressBar.innerHTML = '<span style="color: red"><?= wfMsg ('createpage_login_required') ?>' + '<a href="' + wgServer + wgScript +'?title=Special:Userlogin&returnto=Special:Createpage" id="createpage_login_infobox' + oResponse.argument + '" ><?= wfMsg ('createpage_login_href') ?></a>' + "<?= wfMsg ('createpage_login_required2') ?></span>" ;		
		YE.addListener('createpage_login_infobox' + oResponse.argument, 'click', YWC.showWarningLoginPanel) ;		

	} else {
		ProgressBar.innerHTML = '<span style="color: red">' + aResponse ["msg"] + '</span>' ;		
	}
	YD.get ("createpage_image_text" + oResponse.argument).innerHTML = "<?= wfMsg ("createpage_insert_image") ?>" ;
	YD.get ("createpage_upload_file" + oResponse.argument).style.display = '' ;
	YD.get ("createpage_image_text" + oResponse.argument).style.display = '' ;
        YD.get ("createpage_image_cancel" + oResponse.argument).style.display = 'none' ;
};

YWCI.FailureCallback = function (oResponse) {
	YD.get ("createpage_image_text" + oResponse.argument).innerHTML = "<?= wfMsg ("createpage_insert_image") ?>" ;
	YD.get ("createpage_upload_progress" + oResponse.argument).innerHTML = "<?= wfMsg ("createpage_upload_aborted") ?>" ;	
	YD.get ("createpage_upload_file" + oResponse.argument).style.display = '' ;
	YD.get ("createpage_image_text" + oResponse.argument).style.display = '' ;
        YD.get ("createpage_image_cancel" + oResponse.argument).style.display = 'none' ;
};

YWCI.Abort = function (e, o) {
	YC.abort (o.request, o.callback) ;	
}

YWCI.Upload = function (e, o) {
    var oForm = YD.get ("createpageform") ;
    YE.preventDefault(e);

    YC.setForm (oForm, true) ;
    var ProgressBar = YD.get ("createpage_upload_progress" + o.num) ;
    ProgressBar.style.display = 'block' ;
    ProgressBar.innerHTML = '<img src="/skins/common/progress-wheel.gif" width="16" height="16" alt="wait" border="0" />&nbsp;';

    var callback = {
    	upload: YWCI.UploadCallback ,
	failure: YWCI.FailureCallback ,
	argument: [o.num] ,
	timeout: 60000
   }

    var sent_request = YC.asyncRequest ('POST', "/index.php?action=ajax&rs=axMultiEditImageUpload&num=" + o.num, callback ) ;
    YD.get ("createpage_image_cancel" + o.num).style.display = '' ;
    YD.get ("createpage_image_text" + o.num).style.display = 'none' ;
    
    YE.addListener ("createpage_image_cancel" + o.num, "click", YWCI.Abort, {"request": sent_request, "callback": callback} ) ;
   
    var neoInput = document.createElement ('input') ;
    var thisInput = YD.get ('createpage_upload_file' + o.num) ;
    var thisContainer = YD.get ('createpage_image_label' + o.num) ;
    thisContainer.removeChild (thisInput) ;

    neoInput.setAttribute('type', 'file') ;
    neoInput.setAttribute('id', 'createpage_upload_file' + o.num) ;
    neoInput.setAttribute ('name', 'wpUploadFile' + o.num) ;
    neoInput.setAttribute('tabindex', '-1') ;

    thisContainer.appendChild (neoInput) ;
    YE.addListener( "createpage_upload_file" + o.num, "change", YWCI.Upload, {"num" : o.num } );

    YD.get ("createpage_upload_file" + o.num).style.display = 'none' ;
}

YWCI.InputTest = function (el) {
	if (el.id.match ("wpInfoboxPar")) {
		return true ;
	} else {
		return false ;
	}      
}

YWCI.InputEvent = function (el) {
        var j = parseInt ( el.id.replace ("wpInfoboxPar","") ) ;
	YE.onContentReady ("wpInfoboxPar" + j, YWC.ClearInput, {num: j}) ; 
}

YWCI.UploadTest = function (el) {
	if (el.id.match ("createpage_upload_file")) {
		return true ;
	} else {
		return false ;
	}      
}

YWC.InitialRound = function () {
	YD.get('Createtitle').setAttribute ("autocomplete","off") ;
	if ( (YWC.PreviewMode == "No") && (YWC.RedLinkMode == "No") ) {
		YWC.ContentOverlay () ;
	} else {
		var catlink = YD.get ('catlinks') ;
		if (catlink) {
			var newCatlink = document.createElement ('div') ;
			newCatlink.setAttribute ('id', 'catlinks') ;
			newCatlink.innerHTML = catlink.innerHTML ;
			catlink.parentNode.removeChild (catlink) ;
			var previewArea = YD.get ('createpagepreview') ;
			previewArea.insertBefore (newCatlink, YD.get ('createpage_preview_delimiter')) ;
		}
	}
       	
	var edit_textareas = YD.getElementsBy (YWC.EditTextareaTest, 'textarea', YD.get ('wpTableMultiEdit'), YWC.TextareaAddToolbar) ;
	if (("Yes" == YWC.RedLinkMode) && ("wpTextboxes0" == edit_textareas [0].id)) {
		edit_textareas [0].focus () ;
	} else {
		var el_id = parseInt (edit_textareas [0].id.replace ("wpTextboxes", "")) 
		YD.get ('toolbar' + el_id).style.display = '' ;
		YWC.hideOtherBoxes (el_id) ;
	}
	YWC.multiEditSetupToolbar () ;
	YWC.CheckCategoryCloud () ;
}

YWC.ContentOverlay = function () {
		YWC.Overlay =  new YAHOO.widget.Overlay ('createpageoverlay') ;
		YWC.ResizeOverlay (20) ;
		YWC.Overlay.render () ;
		var helperButton = YD.get ('wpRunInitialCheck') ;
		YE.addListener(helperButton, "click", WR.watchTitle) ;
		helperButton.style.display = '' ;
}

YWC.appendHeight = function (elem_height, number) {
	var x_fixed_height = elem_height.replace ('px', '') ;	
	x_fixed_height = parseFloat (x_fixed_height) + number ;
	x_fixed_height = x_fixed_height.toString () + 'px' ;  	
	return x_fixed_height ;
}

YWC.ResizeOverlay = function (number) {
		var cont_elem = new YAHOO.util.Element ("cp-restricted") ;		
		var fixed_height ;
		var fixed_width ;
		if (cont_elem.getStyle ('height') == 'auto') {
			fixed_height = YD.get ('cp-restricted').offsetHeight + number ;
			fixed_width = YD.get ('cp-restricted').offsetWidth ;				
		} else {
			fixed_height = cont_elem.getStyle ('height') ;
			fixed_height = YWC.appendHeight (fixed_height, number) ;
			fixed_width = cont_elem.getStyle ('width') ;
		}

		YWC.Overlay.cfg.setProperty("height", fixed_height ) ;				
		YWC.Overlay.cfg.setProperty("width", fixed_width ) ;						
}

YE.onContentReady ("cp-multiedit", YWC.InitialRound) ;

YWCI.UploadEvent = function (el) {
        var j = parseInt ( el.id.replace ("createpage_upload_file","") ) ;
	YE.addListener( "createpage_upload_file" + j, "change", YWCI.Upload, {"num" : j } );
}

YE.addListener( "wpAdvancedEdit", "click", YWC.showWarningPanel );
YE.addListener( "Createtitle", "focus", YWC.clearTitleMessage );

function cloudAdd(category, num) {
	category_text = YD.get ('wpCategoryTextarea') ;
	
        if (category_text.value == '') {
                category_text.value += unescape (category) ;
        } else {
                category_text.value += '|' + unescape (category) ;
        }
        this_button = document.getElementById('cloud' + num);
        this_button.onclick = function() {
                eval("cloudRemove('" + category + "'," + num + ")");
                return false;
        }
        this_button.style["color"] = "#419636";
        return false;
};

function cloudInputAdd () {
	category_input = YD.get ('wpCategoryInput') ;
	category_text = YD.get ('wpCategoryTextarea') ;
	var category = 	category_input.value ;
	if ('' != category_input.value) {
		if (category_text.value == '') {
			category_text.value += unescape (category) ;
		} else {
			category_text.value += '|' + unescape (category) ;
		}
		category_input.value = '' ;
		var c_found = false ;
		var core_cat = category.replace (/\|.*/,'') ;			
		for (j in YWC.foundCategories) {
			if (YWC.foundCategories[j] == core_cat) {
				this_button = YD.get ('cloud'+ j) ;
				var actual_cloud = YWC.foundCategories[j] ;
				var cl_num = j ;

				this_button.onclick = YWC.onclickCategoryFn (core_cat,j) ;
				this_button.style.color = "#419636" ;
				c_found = true ;
				break ;
			}
		}
		if (!c_found) {
			var n_cat = document.createElement ('a') ;
			var s_cat = document.createElement ('span') ;
			n_cat_count = YWC.foundCategories.length ;

			var cat_full_section = YD.get ('createpage_cloud_section') ;
			var cat_num = n_cat_count ;
			n_cat.setAttribute ('id','cloud' + cat_num) ;
			n_cat.setAttribute ('href','#') ;
			n_cat.onclick = YWC.onclickCategoryFn (core_cat, cat_num) ;
			n_cat.style.color = '#419636' ;
			n_cat.style.fontSize = '10pt' ;
			s_cat.setAttribute ('id','tag' + cat_num) ;
			t_cat = document.createTextNode (core_cat) ;
			space = document.createTextNode (' ') ;
			n_cat.appendChild (t_cat) ;
			s_cat.appendChild (n_cat) ;
			s_cat.appendChild (space) ;
			cat_full_section.appendChild (s_cat) ;
			YWC.foundCategories [n_cat_count] = core_cat  ;
		}
	}	
}

function cloudRemove(category, num) {
	category_text = YD.get ('wpCategoryTextarea') ;
        this_pos = category_text.value.indexOf (unescape (category)) ;
        if (this_pos != -1) {
                category_text.value = category_text.value.substr(0, this_pos-1) + category_text.value.substr(this_pos + unescape (category).length);
        }
        this_button = document.getElementById('cloud' + num);
        this_button.onclick = function() {
                eval("cloudAdd('" + category + "'," + num + ")");
                return false
        };
        this_button.style["color"] = "";
        return false;
};

function cloudBuild(o) {
        var categories = o.value;
        new_text = '';
        categories = categories.split("|");
        for (i=0; i < categories.length; i++) {
                if (categories[i]!='') {
                        new_text += '[[Category:' + categories[i] + ']]';
                }
        }
        return new_text;
};

/*]]>*/
</script>

<?php if (!$ispreview) { ?>

<div id="templateThumbs">
<?php } ?>
		<?php $elements_for_yui = array();
                	if (!$ispreview) {			
 ?>

		<?php foreach ($data as $e => $element): ?>
			<?php $name = $element['page']; ?>
			<?php $label = str_replace(' Page', '', $element['label']); ?>

			<?php $elements_for_yui[] = "'cp-template-{$name}'"; ?>

			<?php
			$thumb = '' ;
			if (!empty ($element ['preview'])) {
			        $thumb = "<img id=\"cp-template-$name-thumb\" src=\"" . $element ['preview'] . "\" alt=\"$name\" />" ;
        		} else {
			}
			?>
		
	<div class="templateFrame<?php if ($e == count($data) - 1) { ?> templateFrameLast<?php } ?><?php if ($selected [$name] == "checked") { ?> templateFrameSelected<?php } ?>" id="cp-template-<?= $name ?>">
        <label for="cp-template-<?= $name ?>-radio">
		<?= $thumb ?>
        </label>
        <div>
            <input type="radio" name="createplates" id="cp-template-<?= $name ?>-radio" value="<?= $name ?>" <?= $selected [$name] ?> />
            <label for="cp-template-<?= $name ?>-radio"><?= $label ?></label>
        </div>
    </div>			
		<?php endforeach; ?>
</div>

<?php }  ?>

<div style="clear: both"></div>

<script type="text/javascript">
/*<![CDATA[*/

var myid = 0;

YWC.TestInfoboxToggle = function () {
	var listeners = YE.getListeners ('cp-infobox-toggle') ;
	if (listeners) {
		for (var i=0; i<listeners.length; ++i) {
			var listener = listeners[i];
			if (listener.type != 'click') {
				YE.addListener('cp-infobox-toggle', 'click', WR.toggle, ['cp-infobox', 'cp-infobox-toggle']);
			}
		}
	} else {
		YE.addListener('cp-infobox-toggle', 'click', WR.toggle, ['cp-infobox', 'cp-infobox-toggle']);
	}
}

YWC.MultiEdit = function () {
	var elements = [<?= join(', ', $elements_for_yui) ?>];
	var callback = 	{
		success: function(e) {
			YD.get('cp-multiedit').innerHTML = '';

			var res = YT.JSONParse(e.responseText);
			if ('' != res) {
				YD.get('cp-multiedit').innerHTML = res;
			}

			var i ;
			for (i in elements) {
				YD.get (elements[i]).className = 'templateFrame' ;
			}

		        YD.get (myid).className += ' templateFrameSelected' ; 
			
			YE.onAvailable ('cp-infobox-toggle', YWC.TestInfoboxToggle) ;

			var infobox_root = YD.get ('cp-infobox') ;
			var infobox_inputs = YD.getElementsBy (YWCI.InputTest, 'input', infobox_root, YWCI.InputEvent) ;
			var infobox_uploads = YD.getElementsBy (YWCI.UploadTest, 'input', infobox_root, YWCI.UploadEvent) ;
			var content_root = YD.get ('wpTableMultiEdit') ;
			var section_uploads = YD.getElementsBy (YWC.UploadTest, 'input', content_root, YWC.UploadEvent) ;

			var cloud_div = YD.get ('createpage_cloud_div') ;			
			if (null != cloud_div) {
				cloud_div.style.display = 'block';
			}			
			YWC.CheckCategoryCloud () ;		
	
	                var cont_elem = new YAHOO.util.Element ("cp-restricted") ;
			
			if (YWC.Overlay && (YD.get ('createpageoverlay').style.visibility != 'hidden') ) {
				YWC.ResizeOverlay (20) ;
			}

			YWC.multiEditTextboxes = [] ;
			YWC.multiEditButtons = [] ;
			YWC.multiEditCustomButtons = [] ;			

			var edit_textareas = YD.getElementsBy (YWC.EditTextareaTest, 'textarea', content_root, YWC.TextareaAddToolbar) ;
			// Link Suggest
			var link_sugg_area = YD.get ('wpTextbox1_container') ;
			if (link_sugg_area) {
				if(YAHOO.env.ua.ie > 0 || YAHOO.env.ua.gecko > 0) {
					var oDS = new YAHOO.widget.DS_XHR(wgServer + wgScriptPath, ['results', 'title', 'title_org']);
					oDS.scriptQueryAppend = 'action=ajax&rs=getLinkSuggest';

					var content_root = YAHOO.util.Dom.get ('wpTableMultiEdit') ;
					var edit_textareas = YD.getElementsBy (function (el) {
							if (el.id.match ("wpTextboxes") && (el.style.display != 'none') ) {
								return true ;
							} else {
								return false ;
							}
						}, 'textarea', content_root, function (el) {
							LS_PrepareTextarea (el.id, oDS) ;
					}) ;
				}
			}	

			if (("Yes" == YWC.RedLinkMode) && ("wpTextboxes0" == edit_textareas [0].id)) {
				edit_textareas [0].focus () ;
			} else {
				var el_id = parseInt (edit_textareas [0].id.replace ("wpTextboxes", "")) 
				YD.get ('toolbar' + el_id).style.display = '' ;
				YWC.hideOtherBoxes (el_id) ;
			}

			var edittools_div = YD.get ('createpage_editTools') ;
			if (edittools_div) {
				if ('cp-template-Blank' != myid) {
					edittools_div.style.display = 'none' ;
				} else {
					edittools_div.style.display = '' ;
				}
			}

			YWC.multiEditSetupToolbar () ;                                        		
		},
		failure: function(e) {
			YD.get('cp-multiedit').innerHTML = '';
		},
		timeout: 50000
	};

	return {
		init: function() {
			YE.addListener(elements, 'click', this.switchTemplate);

			var i, src, tt;
			for (i in elements) {
				YD.setStyle(elements[i] + '-radio', 'display', 'none');
			}
		},
		switchTemplate: function(e) {
			myid = this.id;
			YE.preventDefault(e);

			YD.get('cp-multiedit').innerHTML = '<img src="http://images.wikia.com/common/progress_bar.gif" width="70" height="11" alt="<? wfMsg ('createpage_please_wait') ?>" border="0" />';
			if (YWC.Overlay) {
				YWC.ResizeOverlay (20) ;
			}
			YC.asyncRequest('GET', ajaxpath + '?action=ajax&rs=axMultiEditParse&template=' + this.id.replace('cp-template-', ''), callback);
		}
	};
}();

YWC.MultiEdit.init();

YWC.CheckExistingTitle = function (e) {
	if (YD.get('Createtitle').value == '') {
		YE.preventDefault(e);
		YD.get('cp-title-check').innerHTML = '<span style="color: red;"><?= wfMsg ('createpage_give_title') ?></span>' ;
		window.location.hash = 'title_loc' ;
		YWC.SubmitEnabled = false ;
        } else if (true == NoCanDo) {
		TitleDialog = new YAHOO.widget.SimpleDialog("dlg", {  
			width: "20em",  
			effect: {effect:YAHOO.widget.ContainerEffect.FADE, 
			duration:0.4},  
			fixedcenter:true, 
			modal:true, 
			visible:false, 
			draggable:false }); 
		TitleDialog.setHeader("<?= wfMsg ('createpage_title_check_header') ; ?>"); 
		TitleDialog.setBody("<?= wfMsg ('createpage_title_check_text') ; ?>"); 
		TitleDialog.cfg.setProperty("icon",YAHOO.widget.SimpleDialog.ICON_WARN); 
		TitleDialog.cfg.setProperty("zIndex", 1000) ;
		TitleDialog.render(document.body); 
		TitleDialog.show(); 
		YE.preventDefault(e);
		YWC.SubmitEnabled = false ;
	}
	if ((YWC.SubmitEnabled !== true) || (YWC.Overlay && (YD.get ('createpageoverlay').style.visibility != 'hidden'))) {
		YE.preventDefault(e);		
	}
}

YWC.SubmitEnable = function (e) {
	YWC.SubmitEnabled = true ;
}

YE.addListener('createpageform', 'submit', YWC.CheckExistingTitle);	
YE.addListener('wpSave', 'click', YWC.SubmitEnable) ;	
YE.addListener('wpPreview', 'click', YWC.SubmitEnable) ;	
YE.addListener('wpCancel', 'click', YWC.SubmitEnable) ;	

/*]]>*/
</script>
<?php  if (!$ispreview) { ?>
</div>
</fieldset>
<?php } ?>
<div style="display: none;" id="createpage_advanced_warning">
	<div class="boxHeader color1"><?= wfMsg ('me_edit_normal') ?></div>
        <div class="warning_text"><?= wfMsg ('createpage_advanced_warning') ?></div>        
        <div class="warning_buttons">
	    <input type="submit" id="wpCreatepageWarningYes" name="wpCreatepageWarningYes" value="<?= wfMsg ('createpage_yes') ?>" style="font-weight:bolder" />
    	    <input type="submit" id="wpCreatepageWarningNo" name="wpCreatepageWarningNo" value="<?= wfMsg ('createpage_no') ?>" />
    	</div>
</div>
                        <div id="createpage_createplate_list"></div>
                        <noscript>
                        <div class="actionBar"><input type="submit" name="wpSubmitCreateplate" id="wpSubmitCreateplate"  value="<?= wfMsg ('createpage_button_createplate_submit') ?>" class="button color1"/>
                        </div>
                        </noscript>

<br />
<div class="actionBar">
<a name="title_loc"></a>
<?php if (!$isredlink) {?>
<label for="Createtitle" id="Createtitlelabel"><?= wfMsg ('createpage_title_caption') ?></label><input name="Createtitle" id="Createtitle" size="50" value="<?= htmlspecialchars ($createtitle) ?>" maxlength="250" />
<?php } else {?>
<div id="createpageinfo"><?= $aboutinfo ?></div>
<input type="hidden" name="Createtitle" id="Createtitle" value="<?= $createtitle ?>" />
<input type="hidden" name="Redlinkmode" id="Redlinkmode" value="<?= $isredlink ?>" />
<?php }?>
<input id="wpRunInitialCheck" class="button color1" type="button" value="<?= wfMsg ('createpage_initial_run') ?>" style="display: none;" />
<?php if (!$isredlink) { ?>
<input type="submit" id="wpAdvancedEdit" name="wpAdvancedEdit" value="<?= wfMsg('me_edit_normal')?>" class="button color1" />
<?php } ?>
<div id="cp-title-check">&nbsp;</div>
</div>
<br />
<!-- e:<?= __FILE__ ?> -->
