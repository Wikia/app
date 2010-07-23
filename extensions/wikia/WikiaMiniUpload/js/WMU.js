/*
 * Author: Inez Korczynski, Bartek Lapinski
 */

/*
 * Variables
 */

var WMU_panel = null;
var WMU_curSourceId = 0;
var WMU_lastQuery = new Array;
var WMU_asyncTransaction = null;
var WMU_curScreen = 'Main';
var WMU_prevScreen = null;
var WMU_slider = null;
var WMU_thumbSize = null;
var WMU_orgThumbSize = null;
var WMU_width = null;
var WMU_height = null;
var WMU_widthChanges = 1;
var WMU_refid = null;
var WMU_wysiwygStart = 1;
var WMU_ratio = 1;
var WMU_shownMax = false;
var WMU_gallery = -1;
var WMU_align = 0;
var WMU_thumb = 0;
var WMU_size = 0;
var WMU_caption = 0;
var WMU_link = 0;
var WMU_box = -1;
var WMU_width_par = null;
var WMU_height_par = null;
var WMU_widthChanges = 1;
var WMU_inGalleryPosition = false;

if( 'view' == wgAction ) {
	var wmu_back = '';
	var wmu_imagebutton = '';
	var wmu_close = '';
	var wmu_warn1 = '';
	var wmu_warn2 = '';
	var wmu_warn3 = '';
	var wmu_bad_extension = '';
	var wmu_show_message = '';
	var wmu_hide_message = '';
	var wmu_title = '';
	var wmu_max_thumb = '';
	var wmu_no_protect = '';
	var wmu_no_rights = '';
	var badfilename = '';
	var file_extensions = '';
	var file_blacklist = '';
	var check_file_extensions = '';
	var strict_file_extensions = '';
	var user_blocked = false;
	var user_disallowed = false;
	var user_protected = false;
}

function WMU_loadDetails() {
	YAHOO.util.Dom.setStyle('ImageUploadMain', 'display', 'none');
	WMU_indicator(1, true);

	var callback = {
		success: function(o) {
			WMU_displayDetails(o.responseText);

			$G('ImageUploadBack').style.display = 'none';

			setTimeout(function() {
				if(!FCK.wysiwygData[WMU_refid].thumb) {
					$G('ImageUploadFullOption').click();
				}
				if(FCK.wysiwygData[WMU_refid].align && FCK.wysiwygData[WMU_refid].align == 'left') {
					$G('ImageUploadLayoutLeft').click();
				}
				if(FCK.wysiwygData[WMU_refid].width) {
					WMU_slider.setValue(FCK.wysiwygData[WMU_refid].width / (WMU_slider.getRealValue() / WMU_slider.getValue()), true);
					WMU_width = FCK.wysiwygData[WMU_refid].width;
					MWU_imageWidthChanged( WMU_width );
					$G( 'ImageUploadSlider' ).style.visibility = 'visible';
					$G( 'ImageUploadInputWidth' ).style.visibility = 'visible';
					$G( 'ImageUploadWidthCheckbox' ).checked = true;
					$G( 'ImageUploadManualWidth' ).value = WMU_width;
					WMU_manualWidthInput( $G( 'ImageUploadManualWidth' ) );
				}
			}, 200);

			if(FCK.wysiwygData[WMU_refid].caption) {
				$G('ImageUploadCaption').value = FCK.wysiwygData[WMU_refid].caption;
			}
		}
	}

	YAHOO.util.Connect.abort(WMU_asyncTransaction)

	var params = Array();
	params.push('sourceId=0');
	params.push('itemId='+FCK.wysiwygData[WMU_refid].href.split(":")[1]);

	WMU_asyncTransaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WMU&method=chooseImage&' + params.join('&'), callback);
}

/*
 * Functions/methods
 */
if(mwCustomEditButtons) {
        if ( !$G( 'siteSub' )) {
	mwCustomEditButtons[mwCustomEditButtons.length] = {
		"imageFile": stylepath + '/../extensions/wikia/WikiaMiniUpload/images/button_wmu.png',
		"speedTip": wmu_imagebutton,
		"tagOpen": "",
		"tagClose": "",
		"sampleText": "",
		"imageId": "mw-editbutton-wmu"};
	}
}

$(function() {
	$.loadYUI(function(){
		if(skin == 'monaco') {
			addOnloadHook(function () {
				if(document.forms.editform) {
					WMU_addHandler();
				}
			});
		}
	});
});

function WMU_addHandler() {
	var btn = $G('mw-editbutton-wmu');
	if(btn == null) {
		setTimeout('WMU_addHandler()', 250);
		return;
	}
	$.loadYUI(function(){ 	
		YAHOO.util.Event.addListener(['wmuLink', 'wmuHelpLink', btn], 'click',  WMU_show);
	});
}

function WMU_licenseSelectorCheck() {
	var selector = document.getElementById( "ImageUploadLicense" );
	var selection = selector.options[selector.selectedIndex].value;
	if( selector.selectedIndex > 0 ) {
		if( selection == "" ) {
			selector.selectedIndex = 0;
		}
	}
	WMU_track('loadLicense/' + selection); // tracking
	WMU_loadLicense( selection );
}

function WMU_manualWidthInput( elem ) {
	var image = $G( 'ImageUploadThumb' ).firstChild;
	var val = parseInt( elem.value );
	if ( isNaN( val ) ) {
		return false;
	}

	if( WMU_orgThumbSize == null ) {
		var WMU_orgThumbSize = [image.width, image.height];
	}
	if ( val > WMU_width ) {
		if (!WMU_shownMax) {
			image.width = WMU_width;
			image.height = WMU_width / WMU_ratio;
			WMU_thumbSize = [image.width, image.height];
			$G( 'ImageUploadManualWidth' ).value = image.width;
			WMU_readjustSlider( image.width );
			WMU_shownMax = true;
			alert (wmu_max_thumb);
		}
	} else {
		image.height = val / WMU_ratio;
		image.width = val;
		WMU_thumbSize = [image.width, image.height];
		$G( 'ImageUploadManualWidth' ).value = val;
		WMU_readjustSlider( val );
		WMU_shownMax = false;
	}
}

function WMU_readjustSlider( value ) {
	if ( 400 < value ) { // too big, hide slider
		if ( 'hidden' != $G( 'ImageUploadSliderThumb' ).style.visibility ) {
			$G( 'ImageUploadSliderThumb' ).style.visibility = 'hidden';
			WMU_slider.setValue( 200, true, true, true );
		}
	} else {
		if ( 'hidden' == $G( 'ImageUploadSliderThumb' ).style.visibility ) {
			$G( 'ImageUploadSliderThumb' ).style.visibility = 'visible';
		}
		var fixed_width = Math.min( 400, WMU_width );
		value = Math.max(2, Math.round( ( value * 200 ) / fixed_width ) );
		WMU_slider.setValue( value, true, true, true );
	}
}

function WMU_getCaret() {
        if (typeof FCK == 'undefined') {
                var control = document.getElementById('wpTextbox1');
        } else {
                var control = FCK.EditingArea.Textarea;
        }

  var caretPos = 0;
        if(YAHOO.env.ua.ie != 0) { // IE Support
    control.focus();
    var sel = document.selection.createRange();
    var sel2 = sel.duplicate();
    sel2.moveToElementText(control);
    var caretPos = -1;
    while(sel2.inRange(sel)) {
      sel2.moveStart('character');
      caretPos++;
    }
  } else if (control.selectionStart || control.selectionStart == '0') { // Firefox
    caretPos = control.selectionStart;
  }
  return (caretPos);
}

function WMU_inGallery() {
        var originalCaretPosition = WMU_getCaret();
        if (typeof FCK == 'undefined') {
                var originalText = document.getElementById('wpTextbox1').value;
        } else {
                var originalText = FCK.EditingArea.Textarea.value;
        }
        var lastIndexOfimagegallery = originalText.substring(0, originalCaretPosition).lastIndexOf('<imagegallery>');

        if(lastIndexOfimagegallery > 0) {
          var indexOfimagegallery = originalText.substring(originalCaretPosition).indexOf('</imagegallery>');
          if(indexOfimagegallery > 0) {
            var textInTag = originalText.substring(lastIndexOfimagegallery + 15, indexOfimagegallery + originalCaretPosition);
            if(textInTag.indexOf('<') == -1 && textInTag.indexOf('>') == -1) {
                    return textInTag.lastIndexOf("\n") + lastIndexOfimagegallery + 15;
            }
          }
        }
        return false;
}

function WMU_getFirstFree( gallery, box ) {
        for (i=box; i >= 0; i--) {
                if ( ! $G( 'WikiaImageGalleryPlaceholder' + gallery + 'x' + i ) ) {
                        return i + 1;
                }
        }
        return box;
}

function WMU_loadMainFromView() {
	var callback = function(data) {
			// first, check if this is a special case for anonymous disabled...
			if( data.wmu_init_login ) {
				var fe = $.Event( 'FakeEvent' );
				openLogin( fe );
				return;
			}
			var element = document.createElement('div');
			element.id = 'WMU_div';
			element.style.width = '812px';
			element.style.height = '587px';
			element.innerHTML = unescape( data.html );

			wmu_back = unescape( data.wmu_back );
			wmu_imagebutton = unescape( data.wmu_imagebutton );
			wmu_close = unescape( data.wmu_close );
			wmu_warn1 = unescape( data.wmu_warn1 );
			wmu_warn2 = unescape( data.wmu_warn2 );
			wmu_warn3 = unescape( data.wmu_warn3 );
			wmu_bad_extension = unescape( data.wmu_bad_extension );
			wmu_show_message = unescape( data.wmu_show_message );
			wmu_hide_message = unescape( data.wmu_hide_message );
			wmu_title = unescape( data.wmu_title );
			wmu_max_thumb = unescape( data.wmu_max_thumb );
			wmu_no_protect = unescape( data.wmu_no_protect );
			wmu_no_rights = unescape( data.wmu_no_rights );
			badfilename = unescape( data.badfilename );
			file_extensions = data.file_extensions;
			file_blacklist = data.file_blacklist;
			check_file_extensions = data.check_file_extensions;
			strict_file_extensions = data.strict_file_extensions;
			user_blocked = data.user_blocked;
			user_disallowed = data.user_disallowed;
			user_protected = data.user_protected;
			if( user_blocked ) {
				document.location = wgScriptPath + '/index.php?title=' + encodeURIComponent( wgTitle ) + '&action=edit';
			} else {
				// is user is disallowed from editing, do nothing and show them a message
				if( user_protected ) {
					alert( wmu_no_protect );
					return;
				}
				if( user_disallowed ) {
					alert( wmu_no_rights );
					return;
				}

				if( !$G( 'WMU_div' ) ) {
					document.body.appendChild(element);
				}

				WMU_panel = new YAHOO.widget.Panel('WMU_div', {
					modal: true,
					constraintoviewport: true,
					draggable: false,
					close: false,
					fixedcenter: true,
					underlay: "none",
					visible: false,
					zIndex: 900
				});
				WMU_panel.render(document.body);
				WMU_panel.show();

				WMU_indicator(1, false);

				WMU_indicator(1, false);
				if($G('ImageQuery') && WMU_panel.element.style.visibility == 'visible') $G('ImageQuery').focus();
				var cookieMsg = document.cookie.indexOf("wmumainmesg=");
				if (cookieMsg > -1 && document.cookie.charAt(cookieMsg + 12) == 0) {
					$G('ImageUploadTextCont').style.display = 'none';
					$G('ImageUploadMessageLink').innerHTML = '[' + wmu_show_message  + ']';
				}

				// macbre: RT #19150
				if ( window.wgEnableAjaxLogin == true && $('#ImageUploadLoginMsg').exists() ) {
					$('#ImageUploadLoginMsg').click(openLogin).css('cursor', 'pointer').log('WMU: ajax login enabled');
				}
		}
	}

	$.getJSON( wgScriptPath + '/index.php?action=ajax&rs=WMU&method=loadMainFromView&article=' + encodeURIComponent( wgTitle ) + '&ns=' + wgNamespaceNumber, callback);

        WMU_curSourceId = 0;
}


function WMU_show( e, gallery, box, align, thumb, size, caption, link ) {

	if(gallery === -2){
	//	if (showComboAjaxForPlaceHolder("WikiaImagePlaceholderInner" + box,true)) return false;
	}

	if(typeof gallery == "undefined") {
		if (typeof showComboAjaxForPlaceHolder == 'function') {
			if (showComboAjaxForPlaceHolder("",false, "", false, true)) return false; // show the 'login required for this action' message.
		}
	}

	WMU_refid = null;
	WMU_wysiwygStart = 1;
        WMU_gallery = -1;

        if(typeof gallery != "undefined") {
                // if in preview mode, go away
                if ($G ( 'editform' ) && !YAHOO.lang.isNumber(e) ) {
                        alert( wmu_no_preview );
                        return false;
                }
                WMU_gallery = gallery;
                WMU_box = box;
                // they only are given when the gallery is given...
                if(typeof align != "undefined") {
                        WMU_align = align;
                }

                if(typeof thumb != "undefined") {
                        WMU_thumb = thumb;
                }

                if(typeof size != "undefined") {
                        WMU_size = size;
                }

                if(typeof caption != "undefined") {
                        WMU_caption = caption;
                }

                if(typeof link != "undefined") {
                        WMU_link = link;
                }
        }

	// TODO: FCK support - to be removed after full switch to RTE
	if(YAHOO.lang.isNumber(e)) {
		WMU_refid = e;
		if(WMU_refid == -1) {
			WMU_track('open/fromWysiwyg/new');
			// go to main page
		} else {
			WMU_track('open/fromWysiwyg/existing');
			if( (typeof(FCK) != 'undefined') && FCK.wysiwygData[WMU_refid].exists) {
				// go to details page
				WMU_wysiwygStart = 2;
			} else {
				// go to main page
			}
		}

	} else if( YAHOO.lang.isObject(e) ) { // for Opera and Chrome
		// macbre: CK support
		if (typeof e.type != 'undefined' && e.type == 'rte') {
			// get image from event data
			window.WMU_RTEImage = e.data.element;
			if (window.WMU_RTEImage) {
				// edit an image
				var data = window.WMU_RTEImage.getData();

				if (e.data.isPlaceholder) {
					// image placeholder
					RTE.log('image placeholder clicked');

					WMU_gallery = -2;
				}
				else {
					// "regular" image
					data.href = 'File:' + data.title;
					data.thumb = data.params.thumbnail;

					$.extend(data, data.params);
					delete data.params;

					WMU_wysiwygStart = 2;
				}

				// FIXME: let's pretend we're FCK for now
				WMU_refid = 0;
				window.FCK = {wysiwygData: {0: {}}};
				window.FCK.wysiwygData[0] = data;

				WMU_track('open/fromWysiwyg/existing');

				RTE.log(data);
			}
			else {
				// add new image
				WMU_refid = -1;

				WMU_track('open/fromWysiwyg/new');
			}
		}
		else {
			var el = YAHOO.util.Event.getTarget(e);
			if (el.id == 'wmuLink') {
				WMU_track('open/fromLinkAboveToolbar'); //tracking
			} else if (el.id == 'wmuHelpLink') {
				WMU_track('open/fromEditTips'); //tracking
			} else if (el.id == 'mw-editbutton-wmu') {
				WMU_track('open/fromToolbar'); //tracking
			} else {
				WMU_track('open');
			}
		}
	}

	YAHOO.util.Dom.setStyle('header_ad', 'display', 'none');
	if(WMU_panel != null) {
		WMU_panel.show();
		if(WMU_refid != null && WMU_wysiwygStart == 2) {
			WMU_loadDetails();
		} else {
			if($G('ImageQuery')) $G('ImageQuery').focus();
		}
		return;
	}

	// for gallery and placeholder, load differently...
	if( -1 != WMU_gallery  ) {
		WMU_loadMainFromView();
	} else {
		var html = '';
		html += '<div class="reset" id="ImageUpload">';
		html += '	<div id="ImageUploadBorder"></div>';
		html += '	<div id="ImageUploadProgress1" class="ImageUploadProgress"></div>';
                html += '       <div id="ImageUploadBack"><img src="'+wgBlankImgUrl+'" id="fe_wmuback_img" class="sprite back" alt="' + wmu_back + '" /><a href="#">' + wmu_back + '</a></div>';
                html += '       <div id="ImageUploadClose"><img src="'+wgBlankImgUrl+'" id="fe_wmuclose_img" class="sprite close" alt="' + wmu_close + '" /><a href="#">' + wmu_close + '</a></div>';
		html += '	<div id="ImageUploadBody">';
		html += '		<div id="ImageUploadError"></div>';
		html += '		<div id="ImageUploadMain"></div>';
		html += '		<div id="ImageUploadDetails" style="display: none;"></div>';
		html += '		<div id="ImageUploadConflict" style="display: none;"></div>';
		html += '		<div id="ImageUploadSummary" style="display: none;"></div>';
		html += '	</div>';
		html += '</div>';

		var element = document.createElement('div');
		element.id = 'WMU_div';
		element.style.width = '722px';
		element.style.height = '587px';
		element.innerHTML = html;
		if( !$G( 'WMU_div' ) ) {
			document.body.appendChild(element);
		}

		WMU_panel = new YAHOO.widget.Panel('WMU_div', {
			modal: true,
			constraintoviewport: true,
			draggable: false,
			close: false,
			fixedcenter: true,
			underlay: "none",
			visible: false,
			zIndex: 900
		});
		WMU_panel.render();
		WMU_panel.show();
		if(WMU_refid != null && WMU_wysiwygStart == 2) {
			WMU_loadDetails();
		} else {
			WMU_loadMain();
		}
	}
	YAHOO.util.Event.addListener('ImageUploadBack', 'click', WMU_back);
	YAHOO.util.Event.addListener('ImageUploadClose', 'click', WMU_close);
}


$(function(){
	if ( (typeof wgComboAjaxLogin != 'undefined') && wgComboAjaxLogin ) {
		if( (window.location.href.indexOf("openwindow=WMU") > 1)
			&& (window.location.href.indexOf("action=submit") > 1)
			&& ((typeof wgIsLogin != 'undefined') && wgIsLogin ) ) {
			WMU_show(-1);
		}
	}
});

function WMU_loadMain() {
	var callback = {
		success: function(o) {
			$G('ImageUploadMain').innerHTML = o.responseText;
			WMU_indicator(1, false);
			if($G('ImageQuery') && WMU_panel.element.style.visibility == 'visible') $G('ImageQuery').focus();
			var cookieMsg = document.cookie.indexOf("wmumainmesg=");
			if (cookieMsg > -1 && document.cookie.charAt(cookieMsg + 12) == 0) {
				$G('ImageUploadTextCont').style.display = 'none';
				$G('ImageUploadMessageLink').innerHTML = '[' + wmu_show_message  + ']';
		 	}

		 	// macbre: RT #19150
		 	if ( window.wgEnableAjaxLogin == true && $('#ImageUploadLoginMsg').exists() ) {
				$('#ImageUploadLoginMsg').click(openLogin).css('cursor', 'pointer').log('WMU: ajax login enabled');
		 	}
		}
	}
	WMU_indicator(1, true);
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WMU&method=loadMain', callback);
	WMU_curSourceId = 0;
}

function WMU_loadLicense( license ) {
	var callback = {
		success: function(o) {
			$G('ImageUploadLicenseText').innerHTML = o.responseText;
			WMU_indicator(1, false);
		}
	}
	WMU_indicator(1, false);
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WMU&method=loadLicense&license='+encodeURIComponent(license), callback);
	WMU_curSourceId = 0;
}

function WMU_recentlyUploaded(param, pagination) {
	if(pagination) {
		WMU_track('pagination/' + pagination + '/src-recent'); // tracking
	}
	var callback = {
		success: function(o) {
			$G('WMU_results_0').innerHTML = o.responseText;
			WMU_indicator(2, false);
		}
	}
	WMU_indicator(2, true);
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WMU&method=recentlyUploaded&'+param, callback);
}

function WMU_changeSource(e) {
	var el = YAHOO.util.Event.getTarget(e);
	if(el.nodeName == 'A') {
		var sourceId = el.id.substring(11);
		if(WMU_curSourceId != sourceId) {
			$G('WMU_source_' + WMU_curSourceId).style.fontWeight = '';
			$G('WMU_source_' + sourceId).style.fontWeight = 'bold';

			$G('WMU_results_' + WMU_curSourceId).style.display = 'none';
			$G('WMU_results_' + sourceId).style.display = '';

			WMU_track('changeSource/src-'+sourceId); // tracking

			if($G('ImageQuery')) $G('ImageQuery').focus();

			WMU_curSourceId = sourceId;
			WMU_trySendQuery();
		}
	}
}

function WMU_trySendQuery(e) {
	if(e && e.type == "keydown") {
		if(e.keyCode != 13) {
			return;
		}
		WMU_track('find/enter/' + $G('ImageQuery').value); // tracking
	} else if(e) {
		WMU_track('find/click/' + $G('ImageQuery').value); // tracking
	}

	var query = $G('ImageQuery').value;

	if(!e && WMU_lastQuery[WMU_curSourceId] == query) {
		return;
	}

	if(query == '') {
		if(e) {
			alert(wmu_warn1);
		}
	} else {
		WMU_sendQuery(query, 1, WMU_curSourceId);
	}
}

function WMU_sendQuery(query, page, sourceId, pagination) {
	if(pagination) {
		WMU_track('pagination/' + pagination + '/src-' + sourceId); // tracking
	}
	var callback = {
		success: function(o) {
			$G('WMU_results_' + o.argument[0]).innerHTML = o.responseText;
			WMU_indicator(2, false);
		},
		argument: [sourceId]
	}
	WMU_lastQuery[sourceId] = query;
	WMU_indicator(2, true);
	YAHOO.util.Connect.abort(WMU_asyncTransaction)
	WMU_asyncTransaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WMU&method=query&' + 'query=' + query + '&page=' + page + '&sourceId=' + sourceId, callback);
}

function WMU_indicator(id, show) {
	if(show) {
		if(id == 1) {
			$G('ImageUploadProgress1').style.display = 'block';
		} else if(id == 2) {
			$G('ImageUploadProgress2').style.visibility = 'visible';
		}
	} else {
		if(id == 1) {
			$G('ImageUploadProgress1').style.display = '';
		} else if(id == 2) {
			$G('ImageUploadProgress2').style.visibility = 'hidden';
		}
	}
}

function WMU_chooseImage(sourceId, itemId) {
	WMU_track('insertImage/choose/src-' + sourceId); // tracking

	var callback = {
		success: function(o) {
			WMU_displayDetails(o.responseText);
		}
	}
	WMU_indicator(1, true);
	YAHOO.util.Connect.abort(WMU_asyncTransaction)
	WMU_asyncTransaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WMU&method=chooseImage&' + 'sourceId=' + sourceId + '&itemId=' + itemId, callback);
}

function WMU_upload(e) {
	if($G('ImageUploadFile').value == '') {
		WMU_track('upload/undefined'); // tracking
		alert(wmu_warn2);
		return false;
	} else {
		if (WMU_initialCheck( $G('ImageUploadFile').value )) {
			WMU_track('upload/defined'); // tracking
			WMU_indicator(1, true);
			return true;
		} else {
			return false;
		}
	}
}

function WMU_splitExtensions( filename ) {
	var bits = filename.split( '.' );
	var basename = bits.shift();
	return new Array( basename, bits );
}

function WMU_in_array( elem, a_array ) {
	for ( key in a_array ) {
		if ( elem == a_array[key] ) {
			return true;
		}
	}
	return false;
}

function WMU_checkFileExtension( ext, list) {
	return WMU_in_array( ext.toLowerCase(), list );
}

function WMU_checkFileExtensionList( ext, list ) {
	for ( elem in ext ) {
		if ( WMU_in_array( ext[elem].toLowerCase(), list )) {
			return true;
		}
	}
	return false;
}

function WMU_initialCheck( checkedName ) {
	var list_array = WMU_splitExtensions( checkedName );
	var partname = list_array[0];
	var ext = list_array[1];
	if (ext.length > 0) {
		var finalExt = ext[ext.length -1];
	} else {
		var finalExt = '';
	}

	if (ext.lenght > 1) {
		for (i=0; i< ext.length; i++ ) {
			partname += '.' + ext[i];
		}
	}

	if (partname.lenght < 1) {
		alert (minlength1);
		return false;
	}
	if (finalExt == '') {
		alert (filetype_missing) ;
		return false;
	} else if (WMU_checkFileExtensionList( ext, file_blacklist ) || ( check_file_extensions
			&& strict_file_extensions && !WMU_checkFileExtension( finalExt, file_extensions ) )  ) {
			alert (wmu_bad_extension);
			return false;
	}

	return true;
}

function WMU_displayDetails(responseText) {
	WMU_switchScreen('Details');
	WMU_width = null;
	$G('ImageUploadBack').style.display = 'inline';

	$G('ImageUpload' + WMU_curScreen).innerHTML = responseText;

	if($G('ImageUploadThumb')) {
		WMU_orgThumbSize = null;
		var image = $G('ImageUploadThumb').firstChild;
		if ( null == WMU_width ) {
			WMU_width = $G( 'ImageRealWidth' ).value;
			WMU_height = $G( 'ImageRealHeight' ).value;
		}
		var thumbSize = [image.width, image.height];
		WMU_orgThumbSize = null;
		WMU_slider = YAHOO.widget.Slider.getHorizSlider('ImageUploadSlider', 'ImageUploadSliderThumb', 0, 200);
		WMU_slider.initialRound = true;
		WMU_slider.getRealValue = function() {
			return Math.max(2, Math.round(this.getValue() * (thumbSize[0] / 200)));
		}
		WMU_slider.subscribe("change", function(offsetFromStart) {
				if ( 'hidden' == $G( 'ImageUploadSliderThumb' ).style.visibility ) {
				$G( 'ImageUploadSliderThumb' ).style.visibility = 'visible';
				}
				if (WMU_slider.initialRound) {
				$G('ImageUploadManualWidth').value = '';
				WMU_slider.initialRound = false;
				} else {
				$G('ImageUploadManualWidth').value = WMU_slider.getRealValue();
				}
				image.width = WMU_slider.getRealValue();
				$G('ImageUploadManualWidth').value = image.width;
				image.height = image.width / (thumbSize[0] / thumbSize[1]);
				if(WMU_orgThumbSize == null) {
				WMU_orgThumbSize = [image.width, image.height];
				WMU_ratio = WMU_width / WMU_height;
				}
				WMU_thumbSize = [image.width, image.height];
				});

		if(image.width < 250) {
			WMU_slider.setValue(200, true);
		} else {
			WMU_slider.setValue(125, true);
		}
		$G('ImageLinkRow').style.display = 'none';
	}
	if ($G( 'WMU_error_box' )) {
		alert( $G( 'WMU_error_box' ).innerHTML );
	}

        if( 0 < WMU_align ) {
		if( 1 == WMU_align ) {
			$G( 'ImageUploadLayoutLeft' ).checked = 'checked';
		} else {
			$G( 'ImageUploadLayoutRight' ).checked = 'checked';
		}
        }

        if( 0 < WMU_thumb ) {
//                $G( 'ImageSizeRow' ).style.display = 'none';
        }

	if( 0 < WMU_size ) {
		$G( 'ImageUploadWidthCheckbox' ).click();
		$G( 'ImageUploadManualWidth' ).value = WMU_size;
		WMU_manualWidthInput( $G( 'ImageUploadManualWidth' ) );
	} else {
		if ( $G( 'ImageUploadSlider' ) ) {
			$G( 'ImageUploadSlider' ).style.visibility = 'hidden';
			$G( 'ImageUploadInputWidth' ).style.visibility = 'hidden';
		}
	}
        if( '' != WMU_caption ) {
		$G( 'ImageUploadCaption' ).value = WMU_caption;
        }

        if( '' != WMU_link ) {
		$G( 'ImageUploadLink' ).value = WMU_link;
        }

	if ( $G( 'ImageUploadLicenseText' ) ) {
		var cookieMsg = document.cookie.indexOf("wmulicensemesg=");
		if (cookieMsg > -1 && document.cookie.charAt(cookieMsg + 15) == 0) {
			$G('ImageUploadLicenseText').style.display = 'none';
			$G('ImageUploadLicenseLink').innerHTML = '[' + wmu_show_license_message  + ']';
		}
	}
	$G( 'ImageColumnRow' ).style.display = 'none';
//	if( -1 != WMU_gallery ) {
		// todo gallery stuff here
//		if( -2 == WMU_gallery ) { // placeholder stuff, don't need that
			$G( 'WMU_LayoutGalleryBox' ).style.display = 'none';
//		}
//	}

	WMU_indicator(1, false);
}

function WMU_insertPlaceholder( box ) {
	var to_update = $G( 'WikiaImagePlaceholder' + box );
	to_update.innerHTML = $G( 'ImageUploadCode' ).innerHTML;
	//the class would need to be different if we had here the full-size...
	to_update.className = '';
	YAHOO.util.Connect.asyncRequest('POST', wgServer + wgScript + '?title=' + wgPageName  +'&action=purge');
}

function WMU_insertImage(e, type) {
	WMU_track('insertImage/' + type); // tracking

	YAHOO.util.Event.preventDefault(e);

	var params = Array();
	params.push('type='+type);
	params.push('mwname='+$G('ImageUploadMWname').value);
	params.push('tempid='+$G('ImageUploadTempid').value);

	if(type == 'overwrite') {
		params.push('name='+ encodeURIComponent( $G('ImageUploadExistingName').value ) );
	} else if(type == 'rename') {
			if( '' == $G( 'ImageUploadRenameName' ).value ) {
				alert( wmu_warn3 );
				return;
			}
		params.push('name='+ encodeURIComponent( $G('ImageUploadRenameName').value ) + '.' + $G( 'ImageUploadRenameExtension' ).value );
	} else {
		if($G('ImageUploadName')) {
			if( '' == $G( 'ImageUploadName' ).value ) {
				alert( wmu_warn3 );
				return;
			}
			// for RT #24050 - Bartek

			if( $G( 'ImageUploadName' ).value.indexOf( '/' ) > 0 )  {
					var parts = $G( 'ImageUploadName' ).value.split( '/' );
				        var lastname = parts.pop();
					$G( 'ImageUploadName' ).value = lastname;
					alert( badfilename.replace( '$1', lastname ) );
				return;
			}

			params.push('name='+ encodeURIComponent( $G('ImageUploadName').value ) + '.' + $G('ImageUploadExtension').value);
		}
	}

	if($G('ImageUploadLicense')) {
		params.push('ImageUploadLicense='+$G('ImageUploadLicense').value);
	}

	if($G('ImageUploadExtraId')) {
		params.push('extraId='+$G('ImageUploadExtraId').value);
	}

	if($G('ImageUploadThumb')) {
		if( $G('ImageUploadThumbOption').checked ) {
			params.push( 'size=thumb' );

			// refs RT #35575
			var width = parseInt( $G( 'ImageUploadManualWidth' ).value );
			if (width > 0) {
				params.push( 'width=' + width + 'px' );
			}
		} else {
			params.push( 'size=full' );
		}
		params.push('layout=' + ($G('ImageUploadLayoutLeft').checked ? 'left' : 'right'));
		params.push('caption=' + $G('ImageUploadCaption').value);
		params.push('slider=' + $G('ImageUploadWidthCheckbox').checked);
	}

	if( -1 != WMU_gallery ) {
		params.push( 'gallery=' + WMU_gallery );
		params.push( 'box=' + WMU_box );
		params.push( 'article='+encodeURIComponent( wgTitle ) );
		params.push( 'ns='+wgNamespaceNumber );
		if( WMU_refid != null ) {
			params.push( 'fck=true' );
		}
	}

        if( -2 == WMU_gallery ) { // placeholder magic
		if( 0 == WMU_link ) {
			if( $G('ImageUploadLink') ) {
				if( '' != $G('ImageUploadLink').value ) {
					params.push( 'link=' + encodeURIComponent( $G('ImageUploadLink').value ) );
				}
			}
		} else  {
			params.push( 'link=' + WMU_link );
		}
        }

	var callback = {
		success: function(o) {

			var screenType = o.getResponseHeader['X-screen-type'];
			if(typeof screenType == "undefined") {
				screenType = o.getResponseHeader['X-Screen-Type'];
			}

			switch(YAHOO.lang.trim(screenType)) {
				case 'error':
					o.responseText = o.responseText.replace(/<script.*script>/, "" );
					alert(o.responseText);
					break;
				case 'conflict':
					WMU_switchScreen('Conflict');
					$G('ImageUpload' + WMU_curScreen).innerHTML = o.responseText;
					break;
				case 'summary':
					WMU_switchScreen('Summary');
					$G('ImageUploadBack').style.display = 'none';
					$G('ImageUpload' + WMU_curScreen).innerHTML = o.responseText;


					if((WMU_refid == null) || (wgAction == "view") || (wgAction == "purge") ){ // not FCK
						if( -2 == WMU_gallery) {
							WMU_insertPlaceholder( WMU_box );
						} else {
							insertTags($G('ImageUploadTag').value, '', '');
						}
					} else { // FCK
						var wikitag = YAHOO.util.Dom.get('ImageUploadTag').value;
						var options = {};

						if($G('ImageUploadThumbOption').checked) {
							options.thumb = 1;
						} else {
							options.thumb = null;
						}
						if($G('ImageUploadWidthCheckbox').checked) {
							options.width = WMU_slider.getRealValue();
						} else {
							options.width = null;
						}
						if($G('ImageUploadLayoutLeft').checked) {
							options.align = 'left';
						} else {
							options.align = null;
						}
						options.caption = $G('ImageUploadCaption').value;

						// macbre: CK support
						if (typeof window.WMU_RTEImage != 'undefined') {
							var image = window.WMU_RTEImage;

							// modify options format
							options.thumbnail = options.thumb;
							delete options.thumb;

							if (image) {
								// update existing image / replace image placeholder
								RTE.mediaEditor.update(image, wikitag, options);
							}
							else {
								// add new image
								RTE.mediaEditor.addImage(wikitag, options);
							}
						}
						else  if(WMU_refid != -1) {
							if( -2 == WMU_gallery) { // updating image placeholder
//								console.dir( );
								FCK.ProtectImageAdd(wikitag, options, WMU_refid);
							} else { // updating edited image
								FCK.ProtectImageUpdate(WMU_refid, wikitag, options);
							}
						} else {
							FCK.ProtectImageAdd(wikitag, options);
						}
					}
					break;
				case 'existing':
					WMU_displayDetails(o.responseText);
					break;
			}
			WMU_indicator(1, false);
		}
	}

	WMU_indicator(1, true);
	YAHOO.util.Connect.abort(WMU_asyncTransaction);
	WMU_asyncTransaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WMU&method=insertImage&' + params.join('&'), callback);
}

function MWU_imageWidthChanged(changes) {
	var image = $G('ImageUploadThumb').firstChild;
	if( !$G( 'ImageUploadWidthCheckbox' ).checked ) {
		$G('ImageUploadManualWidth').value = '';
		$G('ImageUploadSlider').style.visibility = 'hidden';
		$G('ImageUploadSliderThumb').style.visibility = 'hidden';
		$G('ImageUploadInputWidth').style.visibility = 'hidden';
		image.width = WMU_orgThumbSize[0];
		image.height = WMU_orgThumbSize[1];
		WMU_track('slider/disable'); // tracking
	} else {
		$G('ImageUploadManualWidth').value = WMU_slider.getRealValue();
		$G('ImageUploadSlider').style.visibility = 'visible';
		$G('ImageUploadSliderThumb').style.visibility = 'visible';
		$G('ImageUploadInputWidth').style.visibility = 'visible';
		if( WMU_thumbSize ) {
			image.width = WMU_thumbSize[0];
			image.height = WMU_thumbSize[1];
		}
		WMU_track('slider/enable'); // tracking
	}
}

function MWU_imageSizeChanged(size) {
	WMU_track('size/' + size); // tracking
	YAHOO.util.Dom.setStyle(['ImageWidthRow', 'ImageLayoutRow'], 'display', size == 'thumb' ? '' : 'none');
	YAHOO.util.Dom.setStyle(['ImageColumnRow'], 'display', size == 'gallery' ? '' : 'none');

	if($G('ImageUploadThumb')) {
		var image = $G('ImageUploadThumb').firstChild;
		if(size == 'thumb') {
			image.width = WMU_thumbSize[0];
			image.height = WMU_thumbSize[1];
			$G('ImageUploadManualWidth').value = WMU_thumbSize[0];
			$G('ImageLinkRow').style.display = 'none';
		} else if (size == 'full') {
			image.width = WMU_orgThumbSize[0];
			image.height = WMU_orgThumbSize[1];
			$G('ImageUploadManualWidth').value = WMU_orgThumbSize[0];
			if( 0 == WMU_link ) {
				$G('ImageLinkRow').style.display = '';
			}
		} else {
			if( 0 == WMU_link ) {
				$G('ImageLinkRow').style.display = '';
			}
		}
	}
}

function WMU_toggleMainMesg(e) {
	YAHOO.util.Event.preventDefault(e);
	if ('none' == $G('ImageUploadTextCont').style.display) {
		$G('ImageUploadTextCont').style.display = '';
		$G('ImageUploadMessageLink').innerHTML = '[' + wmu_hide_message  + ']';
		WMU_track( 'mainMessage/show' ); // tracking
		document.cookie = "wmumainmesg=1";
	} else {
		$G('ImageUploadTextCont').style.display = 'none';
		$G('ImageUploadMessageLink').innerHTML = '[' + wmu_show_message  + ']';
		WMU_track( 'mainMessage/hide' ); // tracking
		document.cookie = "wmumainmesg=0";
	}
}

function WMU_toggleLicenseMesg(e) {
	YAHOO.util.Event.preventDefault(e);
	if ('none' == $G('ImageUploadLicenseText').style.display) {
		$G('ImageUploadLicenseText').style.display = '';
		$G('ImageUploadLicenseLink').innerHTML = '[' + wmu_hide_license_message  + ']';
		WMU_track( 'licenseText/show' ); // tracking
		document.cookie = "wmulicensemesg=1";
	} else {
		$G('ImageUploadLicenseText').style.display = 'none';
		$G('ImageUploadLicenseLink').innerHTML = '[' + wmu_show_license_message  + ']';
		WMU_track( 'licenseText/hide' ); // tracking
		document.cookie = "wmulicensemesg=0";
	}
}

function WMU_switchScreen(to) {
	WMU_prevScreen = WMU_curScreen;
	WMU_curScreen = to;
	$G('ImageUpload' + WMU_prevScreen).style.display = 'none';
	$G('ImageUpload' + WMU_curScreen).style.display = '';
	if(WMU_curScreen == 'Main') {
		$G('ImageUploadBack').style.display = 'none';
	}
	if((WMU_prevScreen == 'Details' || WMU_prevScreen == 'Conflict') && WMU_curScreen == 'Main' && $G('ImageUploadName')) {
		YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WMU&method=clean&mwname=' + $G('ImageUploadMWname').value + '&tempid=' + $G( 'ImageUploadTempid' ).value );
	}
}

function WMU_back(e) {
	YAHOO.util.Event.preventDefault(e);
	WMU_track('back/' + WMU_curScreen);
	if(WMU_curScreen == 'Details') {
		WMU_switchScreen('Main');
	} else if(WMU_curScreen == 'Conflict' && WMU_prevScreen == 'Details') {
		WMU_switchScreen('Details');
	}
}

function WMU_close(e) {
	if(e) {
		YAHOO.util.Event.preventDefault(e);
	}
	WMU_track('close/' + WMU_curScreen);
	WMU_panel.hide();
	if(typeof window.RTE == 'undefined' && $G('wpTextbox1')) $G('wpTextbox1').focus();
	WMU_switchScreen('Main');
	WMU_loadMain();
	YAHOO.util.Dom.setStyle('header_ad', 'display', 'block');
}

function WMU_track(str) {
	WET.byStr('WMU/' + str);
}

var WMU_uploadCallback = {
	onComplete: function(response) {
		WMU_displayDetails(response);
	}
}

/**
*
*  AJAX IFRAME METHOD (AIM)
*  http://www.webtoolkit.info/
*
**/
AIM = {
	frame : function(c) {
		var n = 'f' + Math.floor(Math.random() * 99999);
		var d = document.createElement('DIV');
		d.innerHTML = '<iframe style="display:none" src="about:blank" id="'+n+'" name="'+n+'" onload="AIM.loaded(\''+n+'\')"></iframe>';
		document.body.appendChild(d);
		var i = document.getElementById(n);
		if (c && typeof(c.onComplete) == 'function') {
			i.onComplete = c.onComplete;
		}
		return n;
	},
	form : function(f, name) {
		f.setAttribute('target', name);
	},
	submit : function(f, c) {

		// macbre: allow cross-domain
		if(document.domain != 'localhost' && typeof FCK != 'undefined') {
			f.action += ((f.action.indexOf('?') > 0) ? '&' : '?') + 'domain=' + escape(document.domain);
		}

		AIM.form(f, AIM.frame(c));
		if (c && typeof(c.onStart) == 'function') {
			return c.onStart();
		} else {
			return true;
		}
	},
	loaded : function(id) {
		var i = document.getElementById(id);
		if (i.contentDocument) {
			var d = i.contentDocument;
		} else if (i.contentWindow) {
			var d = i.contentWindow.document;
		} else {
			var d = window.frames[id].document;
		}
		if (d.location.href == "about:blank") {
			return;
		}

		if (typeof(i.onComplete) == 'function') {
			i.onComplete(d.body.innerHTML);
		}
	}
}
