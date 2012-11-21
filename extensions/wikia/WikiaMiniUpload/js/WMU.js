/*
 * Author: Inez Korczynski, Bartek Lapinski
 * $G = YAHOO.util.Dom.get
 */

/**
 * Finds the event in the window object, the caller's arguments, or
 * in the arguments of another method in the callstack.  This is
 * executed automatically for events registered through the event
 * manager, so the implementer should not normally need to execute
 * this function at all.
 * @method getEvent
 * @param {Event} e the event parameter from the handler
 * @param {HTMLElement} boundEl the element the listener is attached to
 * @return {Event} the event
 * @static
 *
 * @deprecated - used by WMU only
 */
$.getEvent = function(e, boundEl) {
	var ev = e || window.event;

	if (!ev) {
		var c = this.getEvent.caller;
		while (c) {
			ev = c.arguments[0];
			if (ev && Event == ev.constructor) {
				break;
			}
			c = c.caller;
		}
	}

	return ev;
};

/*
 * Variables
 */

var WMU_panel = null,
	WMU_curSourceId = 0,
	WMU_lastQuery = [],
	WMU_asyncTransaction = null,
	WMU_curScreen = 'Main',
	WMU_prevScreen = null,
	WMU_slider = null,
	WMU_thumbSize = null,
	WMU_orgThumbSize = null,
	WMU_width = null, // real width of full sized image
	WMU_height = null,
	WMU_widthChanges = 1,
	WMU_refid = null,
	WMU_wysiwygStart = 1,
	WMU_ratio = 1,
	WMU_shownMax = false,
	WMU_gallery = -1,
	WMU_align = 0,
	WMU_thumb = 0,
	WMU_size = 0,
	WMU_caption = 0,
	WMU_link = 0,
	WMU_box = -1,
	WMU_width_par = null,
	WMU_height_par = null,
	WMU_skipDetails = false,
	WMU_isOnSpecialPage = false;

if (typeof WMU_box_filled == 'undefined') {
	WMU_box_filled = [];
}

if( 'view' == wgAction ) {
	window.wmu_back = '',
	window.wmu_imagebutton = '',
	window.wmu_close = '',
	window.wmu_warn1 = '',
	window.wmu_warn2 = '',
	window.wmu_warn3 = '',
	window.wmu_bad_extension = '',
	window.wmu_show_message = '',
	window.wmu_hide_message = '',
	window.wmu_title = '',
	window.wmu_max_thumb = '',
	window.wmu_no_protect = '',
	window.wmu_no_rights = '',
	window.badfilename = '',
	window.file_extensions = '',
	window.file_blacklist = '',
	window.check_file_extensions = '',
	window.strict_file_extensions = '',
	window.user_blocked = false,
	window.user_disallowed = false,
	window.user_protected = false;
}

function WMU_setSkip(){
	WMU_skipDetails = true;
}

function WMU_getRTETxtarea(){
	// return dom element, not jquery object
	return WikiaEditor.getInstance().getEditbox()[0];
}


function WMU_loadDetails() {

	YAHOO.util.Dom.setStyle('ImageUploadMain', 'display', 'none');
	WMU_indicator(1, true);

	var callback = {
		success: function(o) {
			WMU_displayDetails(o.responseText);

			$G('ImageUploadBack').style.display = 'none';

			setTimeout(function() {
				// FIXME: FCK is mocked here so this code would still work even though we're not using FCK anymore
				if(!FCK.wysiwygData[WMU_refid].thumb) {
					$G('ImageUploadFullOption').click();
				}
				if(FCK.wysiwygData[WMU_refid].align && FCK.wysiwygData[WMU_refid].align == 'left') {
					$G('ImageUploadLayoutLeft').click();
				}
				if(FCK.wysiwygData[WMU_refid].width) {
					WMU_slider.setValue(FCK.wysiwygData[WMU_refid].width / (WMU_slider.getRealValue() / WMU_slider.getValue()), true);
					MWU_imageWidthChanged();
					$G( 'ImageUploadSlider' ).style.visibility = 'visible';
					$G( 'ImageUploadInputWidth' ).style.visibility = 'visible';
					$G( 'ImageUploadWidthCheckbox' ).checked = true;
					$G( 'ImageUploadManualWidth' ).value = FCK.wysiwygData[WMU_refid].width;
					WMU_manualWidthInput();
				}
			}, 100);

			if(FCK.wysiwygData[WMU_refid].caption) {
				$G('ImageUploadCaption').value = FCK.wysiwygData[WMU_refid].caption;
			}

			if(FCK.wysiwygData[WMU_refid].link) {
				$G('ImageUploadLink').value = FCK.wysiwygData[WMU_refid].link;
			}
		}
	}

	YAHOO.util.Connect.abort(WMU_asyncTransaction);

	var params = new Array();
	params.push('sourceId=0');
	params.push('itemId=' + encodeURIComponent(FCK.wysiwygData[WMU_refid].href.split(":")[1]));

	WMU_asyncTransaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WMU&method=chooseImage&' + params.join('&'), callback);
}

// macbre: move back button inside dialog content and add before provided selector (Oasis changes)
function WMU_moveBackButton(selector) {
	if (window.skin != 'oasis') {
		return;
	}

	// store back button
	if (typeof window.WMUbackButton == 'undefined') {
		var backButtonOriginal = $('#ImageUploadBack');
		var backButton = backButtonOriginal.clone();

		// keep the original one, but force it to be hidden
		backButtonOriginal.css('visibility', 'hidden');

		// remove an image and add button class
		backButton.removeAttr('id').remove();

		// keep reference to <a> tag
		backButton = backButton.children('a').addClass('wikia-button yui-back secondary');

		backDetails = $(".ImageUploadNoBorder a.backbutton");

		if(backDetails.length > 0) {
			backButton.empty().append( backDetails.text() );
		}

		window.WMUbackButton = backButton;
	}

	// remove previous instances of .yui-back
	$('.yui-back').remove();

	// move button
	window.WMUbackButton.clone().
		click(WMU_back).
		insertBefore(selector);
}

/*
 * Functions/methods
 */
if(mwCustomEditButtons) {
	if ( $("#siteSub").length == 0 ) {
		mwCustomEditButtons.push({
			"imageFile": wgExtensionsPath + '/wikia/WikiaMiniUpload/images/button_wmu.png',
			"speedTip": wmu_imagebutton,
			"tagOpen": "",
			"tagClose": "",
			"sampleText": "",
			"imageId": "mw-editbutton-wmu",
			'onclick': function(ev) {
				WMU_show(ev);
			}
		});
	}
}

$(function() {
	$.when(
		$.loadYUI(),
		$.loadJQueryAIM()
	).then(function(){
		if(skin != 'monobook') {
			if(document.forms.editform) {
				WMU_addHandler();
			}
		}
	});
});

function WMU_addHandler() {
	$.loadYUI(function(){
		YAHOO.util.Event.addListener(['wmuLink', 'wmuHelpLink'], 'click',  WMU_show);
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
	WMU_loadLicense( selection );
}

function WMU_manualWidthInput() {
	var image = $G( 'ImageUploadThumb' ).firstChild;
	var val = parseInt( $G( 'ImageUploadManualWidth' ).value );
	if ( isNaN( val ) ) {
		return false;
	}

	if(!window.WMU_orgThumbSize) {
		WMU_orgThumbSize = [image.width, image.height];
	}
	if ( val > WMU_width ) {
		if (!WMU_shownMax) {
			image.width = WMU_width;
			image.height = WMU_width / WMU_ratio;
			WMU_thumbSize = [image.width, image.height];
			$G( 'ImageUploadManualWidth' ).value = image.width;
			WMU_readjustSlider( image.width );
			WMU_shownMax = true;
		}
	} else {
		image.height = val / WMU_ratio;
		image.width = val;
		WMU_thumbSize = [image.width, image.height];
		$G( 'ImageUploadManualWidth' ).value = val;
		WMU_readjustSlider( val );
		WMU_shownMax = false;
	}

	// BugId:4471
	if ($("#ImageUploadWidthCheckbox").val() == "false") {
		$("#ImageUploadWidthCheckbox").val("true").attr('checked', true);
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
		// get slider's max value
		var fixed_width = Math.min( 400, WMU_width );
		value = Math.max(2, Math.round( ( value * 200 ) / fixed_width ) );
		WMU_slider.setValue( value, true, true, true );
	}
}

function WMU_getCaret() {
	if (typeof FCK == 'undefined') {
		var control = document.getElementById(WikiaEditor.instanceId);
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
		var originalText = document.getElementById(WikiaEditor.instanceId).value;
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
	for (var i=box; i >= 0; i--) {
		if ( ! $G( 'WikiaImageGalleryPlaceholder' + gallery + 'x' + i ) ) {
			return i + 1;
		}
	}
	return box;
}

function WMU_loadMainFromView() {
	if (wgUserName == null) {
		UserLogin.rteForceLogin();
		return;
	}
	
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

		WMU_isOnSpecialPage = (wgNamespaceNumber === -1) ? true : false;

		// Special Case for using WMU in on Special Pages - used for SDSObject Special Page
		if (WMU_isOnSpecialPage) {
			user_protected = false;
			user_disallowed = false;
			WMU_skipDetails = true;
		}

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
			if($G('ImageQuery') && WMU_panel.element.style.visibility == 'visible') {
				$G('ImageQuery').focus();
			}
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
	// Handle MiniEditor focus
	// (BugId:18713)
	if (window.WikiaEditor) {
		var wikiaEditor = WikiaEditor.getInstance();
		if(wikiaEditor.config.isMiniEditor) {
			wikiaEditor.plugins.MiniEditor.hasFocus = true;
		}
	}

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
		if(WMU_refid != -1) {
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
			}
			else {
				// add new image
				WMU_refid = -1;
			}
		}
	}

	YAHOO.util.Dom.setStyle('header_ad', 'display', 'none');
	if(WMU_panel != null) {
		WMU_panel.show();
		// Recenter each time for different instances of RTE. (BugId:15589)
		WMU_panel.center();
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

		// @see http://developer.yahoo.com/yui/container/panel/#config
		WMU_panel = new YAHOO.widget.Panel('WMU_div', {
			modal: true,
			constraintoviewport: true,
			draggable: false,
			close: false,
			underlay: "none",
			visible: false,
			zIndex: 900
		});

		// use display: block/none for YUI panels (BugId:8825)
		WMU_panel.showEvent.subscribe(function() {
			YAHOO.util.Dom.setStyle(this.element, "display", "block");
		});
		WMU_panel.hideEvent.subscribe(function() {
			YAHOO.util.Dom.setStyle(this.element, "display", "none");
		});

		WMU_panel.render();
		WMU_panel.show();
		WMU_panel.center();
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
	if ( window.wgComboAjaxLogin ) {
		if( (window.location.href.indexOf("openwindow=WMU") > 1)
			&& (window.location.href.indexOf("action=submit") > 1)
			&& (wgUserName !== null) ) {
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
	var title = 'File:Sample.jpg';
	var url = wgScriptPath + '/api' + wgScriptExtension
		+ '?action=parse&text={{' + encodeURIComponent( license ) + '}}'
		+ '&title=' + encodeURIComponent( title )
		+ '&prop=text&pst&format=json';

	var callback = {
		success: function(o) {
			var o = eval( '(' + o.responseText + ')' );
			$G('ImageUploadLicenseText').innerHTML = o['parse']['text']['*'];
			//$G('ImageUploadLicenseText').innerHTML = o.responseText;
			WMU_indicator(1, false);
		}
	}
	WMU_indicator(1, false);
	YAHOO.util.Connect.asyncRequest('GET', url, callback);
	WMU_curSourceId = 0;
}

function WMU_recentlyUploaded(param, pagination) {
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
	e.preventDefault();
	var el = YAHOO.util.Event.getTarget(e);
	if(el.nodeName == 'A') {
		var sourceId = el.id.substring(11);
		if(WMU_curSourceId != sourceId) {
			$G('WMU_source_' + WMU_curSourceId).style.fontWeight = '';
			$G('WMU_source_' + sourceId).style.fontWeight = 'bold';

			$G('WMU_results_' + WMU_curSourceId).style.display = 'none';
			$G('WMU_results_' + sourceId).style.display = '';

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
		alert(wmu_warn2);
		return false;
	} else {
		if (WMU_initialCheck( $G('ImageUploadFile').value )) {
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

	$('#ImageUploadLicense').bind('change', WMU_licenseSelectorCheck);

	// If Details view and showhide link exists, adjust the height of the right sidebar
	$('#WMU_showhide').click(function(event) {
		event.preventDefault();
		if ($(".advanced").is(":visible")) {
			$(".ImageUploadRight .chevron").removeClass("up");
			$(this).text($(this).data("more"));
		}	else {
			$(".ImageUploadRight .chevron").addClass("up");
			$(this).text($(this).data("fewer"));
		}
		$(".ImageUploadRight .advanced").slideToggle("fast");
	});

	if( WMU_skipDetails ){
		$G('ImageUpload' + WMU_curScreen).style.display = 'none';
		$G('ImageUploadLayoutLeft').checked = 'checked';
		$G('ImageUploadFullOption').checked = 'checked';

		WMU_insertImage($.getEvent(),'skip');
	}else if($G('ImageUploadThumb')) {
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

				if ($("#ImageUploadWidthCheckbox").val() == "false") {
					$("#ImageUploadWidthCheckbox").val("true").attr('checked', true);
				}
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
		WMU_manualWidthInput();
	} else {
		if ( $G( 'ImageUploadSlider' ) ) {
			//$G( 'ImageUploadSlider' ).style.visibility = 'hidden';
			//$G( 'ImageUploadInputWidth' ).style.visibility = 'hidden';
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
	//$G( 'ImageColumnRow' ).style.display = 'none';
//	if( -1 != WMU_gallery ) {
	// todo gallery stuff here
//		if( -2 == WMU_gallery ) { // placeholder stuff, don't need that
	//$G( 'WMU_LayoutGalleryBox' ).style.display = 'none';
//		}
//	}

	if(typeof(WMU_Event_OnLoadDetails) == "function") {
		setTimeout(function() {
			WMU_Event_OnLoadDetails();
		},100);
	}
	WMU_indicator(1, false);
}

function WMU_insertPlaceholder( box ) {
	WMU_box_filled.push(box);
	var to_update = $G( 'WikiaImagePlaceholder' + box );
	to_update.innerHTML = $G( 'ImageUploadCode' ).innerHTML;
	//the class would need to be different if we had here the full-size...
	to_update.className = '';
	YAHOO.util.Connect.asyncRequest('POST', wgServer + wgScript + '?title=' + wgPageName  +'&action=purge');
}

function WMU_insertImage(e, type) {
	if (!WMU_isOnSpecialPage) {
		YAHOO.util.Event.preventDefault(e);
	}
	var params = Array();
	params.push('type='+type);
	params.push('mwname='+$G('ImageUploadMWname').value);
	params.push('tempid='+$G('ImageUploadTempid').value);

	var captionUpdateInput = $('#ImageUploadReplaceDefault');
	if (captionUpdateInput.is(':hidden')) {
		params.push('update_caption=' + captionUpdateInput.val());
	} else {
		var isCaptionUpdate = (captionUpdateInput.is(':checked')) ? 'on' : '';
		params.push('update_caption=' + isCaptionUpdate );
	}

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
		params.push('caption=' + encodeURIComponent( $G('ImageUploadCaption').value ) );
		params.push('slider=' + $('#ImageUploadWidthCheckbox').val());
	}

	// support links (BugId:6506)
	var link = $G('ImageUploadLink').value;
	if (link != '') {
		params.push( 'link=' + link );
	}

	if( -1 != WMU_gallery ) {
		params.push( 'gallery=' + WMU_gallery );
		params.push( 'box=' + WMU_box_in_article() );
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
					break;
				case 'conflict':
					WMU_switchScreen('Conflict');
					$G('ImageUpload' + WMU_curScreen).innerHTML = o.responseText;
					break;
				case 'summary':

					WMU_switchScreen('Summary');
					if (typeof RTE !== 'undefined') {
						RTE.getInstanceEditor().getEditbox().focus();
					}

					$G('ImageUploadBack').style.display = 'none';
					$G('ImageUpload' + WMU_curScreen).innerHTML = o.responseText;

					var event = jQuery.Event("imageUploadSummary");
					$("body").trigger(event, [$G('ImageUpload' + WMU_curScreen)]);
					if ( event.isDefaultPrevented() ) {
						return false;
					}

					if((WMU_refid == null) || (wgAction == "view") || (wgAction == "purge") ){ // not FCK
						if( -2 == WMU_gallery) {
							WMU_insertPlaceholder( WMU_box );
						} else {
							// insert image in source mode
							insertTags($G('ImageUploadTag').value, '', '', WMU_getRTETxtarea());
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

						// handle links (BugId:6506)
						if (!options.thumb) {
							options.link = $G('ImageUploadLink').value;
						}

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
							// Handle MiniEditor focus
							// (BugId:18713)
							var wikiaEditor = WikiaEditor.getInstance();
							if(wikiaEditor.config.isMiniEditor) {
								wikiaEditor.plugins.MiniEditor.hasFocus = false;
							}

						}
						else  if(WMU_refid != -1) {
							if( -2 == WMU_gallery) { // updating image placeholder
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
	// Special Case for using WMU in SDSObject Special Page
	if (WMU_isOnSpecialPage) {
		var filePageUrl = 'File:';
		filePageUrl += $('#ImageUploadMWname').val();
		$(window).trigger('WMU_addFromSpecialPage', [filePageUrl]);
		WMU_switchScreen('Summary');
		return;
	}
	WMU_indicator(1, true);
	YAHOO.util.Connect.abort(WMU_asyncTransaction);
	WMU_asyncTransaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WMU&method=insertImage&' + params.join('&'), callback);
}

function WMU_box_in_article() {
	var box = WMU_box;
	for (var i=0;i<WMU_box_filled.length;i++) {
		if (WMU_box>WMU_box_filled[i])
			box--;
	}
	return box;
}

/**
 * @brief Adjusts UI for specifically-sized images
 * @details With a recent UI change, the ImageUploadWidthCheckbox is always checked (and hidden)
 This function is run if modifying an existing image in the article
 with a precise width set.
 */
function MWU_imageWidthChanged() {

	var image = $G('ImageUploadThumb').firstChild;
	if( !$G( 'ImageUploadWidthCheckbox' ).checked ) {
		// This will never be run
		$G('ImageUploadManualWidth').value = '';
		$G('ImageUploadSlider').style.visibility = 'hidden';
		$G('ImageUploadSliderThumb').style.visibility = 'hidden';
		$G('ImageUploadInputWidth').style.visibility = 'hidden';
		image.width = WMU_orgThumbSize[0];
		image.height = WMU_orgThumbSize[1];
	} else {
		$G('ImageUploadManualWidth').value = WMU_slider.getRealValue();
		$G('ImageUploadSlider').style.visibility = 'visible';
		$G('ImageUploadSliderThumb').style.visibility = 'visible';
		$G('ImageUploadInputWidth').style.visibility = 'visible';
		if( WMU_thumbSize ) {
			image.width = WMU_thumbSize[0];
			image.height = WMU_thumbSize[1];
		}
	}
}

function MWU_imageSizeChanged(size) {
	YAHOO.util.Dom.setStyle(['ImageWidthRow'], 'display', size == 'thumb' ? '' : 'none');

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

function WMU_toggleLicenseMesg(e) {
	YAHOO.util.Event.preventDefault(e);
	if ('none' == $G('ImageUploadLicenseText').style.display) {
		$G('ImageUploadLicenseText').style.display = '';
		$G('ImageUploadLicenseLink').innerHTML = '[' + wmu_hide_license_message  + ']';
		document.cookie = "wmulicensemesg=1";
	} else {
		$G('ImageUploadLicenseText').style.display = 'none';
		$G('ImageUploadLicenseLink').innerHTML = '[' + wmu_show_license_message  + ']';
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
		WMU_loadMain();
	}
	if((WMU_prevScreen == 'Details' || WMU_prevScreen == 'Conflict') && WMU_curScreen == 'Main' && $G('ImageUploadName')) {
		YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WMU&method=clean&mwname=' + $G('ImageUploadMWname').value + '&tempid=' + $G( 'ImageUploadTempid' ).value );
	}

	// macbre: move back button on Oasis
	if (window.skin == 'oasis') {
		setTimeout(function() {
			$().log(to, 'WMU_switchScreen');

			switch(to) {
				case 'Details':
					WMU_moveBackButton($(".ImageUploadLeft").find('input:last'));
					break;

				case 'Conflict':
					WMU_moveBackButton($('#ImageUploadConflict').children('h1'));
					break;
			}
		}, 50);
	}
	// Don't show summary screen - just close the WMU
	if (WMU_curScreen == "Summary") {
		WMU_close();
	}
}

function WMU_back(e) {
	YAHOO.util.Event.preventDefault(e);
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
	WMU_panel.hide();
	if(typeof window.RTE == 'undefined' && $G('wpTextbox1')) $G('wpTextbox1').focus();
	WMU_switchScreen('Main');
	WMU_loadMain();
	YAHOO.util.Dom.setStyle('header_ad', 'display', 'block');

	// Handle MiniEditor focus
	// (BugId:18713)
	if (window.WikiaEditor) {
		var wikiaEditor = WikiaEditor.getInstance();
		if(wikiaEditor.config.isMiniEditor) {
			wikiaEditor.editorFocus();
			wikiaEditor.plugins.MiniEditor.hasFocus = false;
		}
	}
}

var WMU_uploadCallback = {
	onComplete: function(response) {
		WMU_displayDetails(response);
	}
}