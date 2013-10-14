/*
 * Author: Inez Korczynski, Bartek Lapinski
 * Converted from YUI to jQuery by Hyun
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
 * @deprecated - used by WMU and VET only
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

var WMU_modal = null,
	WMU_curSourceId = 0,
	WMU_lastQuery = [],
	WMU_jqXHR = {
		abort: function() {
			// empty placeholder function
		}
	},
	WMU_curScreen = 'Main',
	WMU_prevScreen = null,
	WMU_slider = null,
	WMU_thumbSize = null,
	WMU_orgThumbSize = null,
	WMU_width = null, // real width of full sized image
	WMU_height = null,
	WMU_exactWidth = null,    // Constrain search and upload > than this width
	WMU_exactHeight = null,   // Constrain search and upload > than this height
	WMU_aspectRatio = null, // Constrain searchand upload == this aspect ratio
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
	WMU_skipDetails = false,
	WMU_openedInEditor = true;

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

// Returns the DOM element for the RTE textarea
function WMU_getRTETxtarea(){
	return WikiaEditor.getInstance().getEditbox()[0];
}

function WMU_loadDetails() {

	$('#ImageUploadMain').hide();
	WMU_indicator(1, true);

	var callback = function(o) {
		WMU_displayDetails(o.responseText);

		$('#ImageUploadBack').hide();

		setTimeout(function() {
			// FIXME: FCK is mocked here so this code would still work even though we're not using FCK anymore
			if(!FCK.wysiwygData[WMU_refid].thumb) {
				$('#ImageUploadThumbOption').prop('checked', false);
				$('#ImageUploadFullOption').prop('checked', true);
			}
			if(FCK.wysiwygData[WMU_refid].align && FCK.wysiwygData[WMU_refid].align == 'left') {
				$('#ImageUploadLayoutLeft').prop('checked', true);
				$('#ImageUploadLayoutRight').prop('checked', false);
			}

			/*
			 * This is run if modifying an existing image in the article
			 * with a precise width set.
			 */
			if(FCK.wysiwygData[WMU_refid].width) {
				WMU_slider.setValue(FCK.wysiwygData[WMU_refid].width / (WMU_slider.getRealValue() / WMU_slider.getValue()), true);
				MWU_imageWidthChanged();
				$( '#ImageUploadSlider' ).css('visibility', 'visible');
				$( '#ImageUploadInputWidth' ).css('visibility', 'visible');
				$( '#ImageUploadSliderThumb' ).css('visibility', 'visible');
				$( '#ImageUploadWidthCheckbox' ).attr('checked', true);

				$('#ImageUploadManualWidth').val(WMU_slider.getRealValue());
				if( WMU_thumbSize ) {
					$('#ImageUploadThumb').children(':first')
						.width(WMU_thumbSize[0])
						.height(WMU_thumbSize[1]);
				}

				$( '#ImageUploadManualWidth' ).val(FCK.wysiwygData[WMU_refid].width);
				WMU_manualWidthInput();
			}
		}, 100);

		if(FCK.wysiwygData[WMU_refid].caption) {
			$('#ImageUploadCaption').val(FCK.wysiwygData[WMU_refid].caption);
		}

		if(FCK.wysiwygData[WMU_refid].link) {
			$('#ImageUploadLink').val(FCK.wysiwygData[WMU_refid].link);
		}
	};

	WMU_jqXHR.abort();

	var params = new Array();
	params.push('sourceId=0');
	params.push('itemId=' + encodeURIComponent(FCK.wysiwygData[WMU_refid].href.split(":")[1]));

	WMU_jqXHR = $.ajax(wgScriptPath + '/index.php?action=ajax&rs=WMU&method=chooseImage&' + params.join('&'), {
		method: 'get',
		complete: callback
	});
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
	var image = $( '#ImageUploadThumb' ).children(':first');
	var val = parseInt( $( '#ImageUploadManualWidth' ).val() );
	if ( isNaN( val ) ) {
		return false;
	}

	if(!window.WMU_orgThumbSize) {
		WMU_orgThumbSize = [image.width, image.height];
	}
	WMU_ratio = WMU_width / WMU_height;
	if ( val > WMU_width ) {
		if (!WMU_shownMax) {
			image.width(WMU_width);
			image.height(WMU_width / WMU_ratio);
			WMU_thumbSize = [image.width(), image.height()];
			$( '#ImageUploadManualWidth' ).val(image.width());
			WMU_readjustSlider( image.width() );
			WMU_shownMax = true;
		}
	} else {
		image.height(val / WMU_ratio);
		image.width(val);
		WMU_thumbSize = [image.width(), image.height()];
		$( '#ImageUploadManualWidth' ).val(val);
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
		$( '#ImageUploadSliderThumb' ).css('visibility', 'hidden');
		WMU_slider.setValue( 200, true, true, true );
	} else {
		$( '#ImageUploadSliderThumb' ).css('visibility', 'visible');
		// get slider's max value
		var fixed_width = Math.min( 400, WMU_width );
		value = Math.max(2, Math.round( ( value * 200 ) / fixed_width ) );
		WMU_slider.setValue( value, true, true, true );
	}
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
		element.style.width = '722px';
		element.style.height = '587px';

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

			if( !$( '#WMU_div' ).length ) {
				document.body.appendChild(element);
			}

			WMU_modal = $(element).makeModal({
				onAfterClose: function() {
					WMU_switchScreen('Main');
				},
				persistent: true,
				width: 722
			});
			$('#WMU_div').html(unescape( data.html ));

			WMU_indicator(1, false);

			WMU_indicator(1, false);
			if($('#ImageQuery').length) {
				$('#ImageQuery').focusNoScroll();
			}
			var cookieMsg = document.cookie.indexOf("wmumainmesg=");
			if (cookieMsg > -1 && document.cookie.charAt(cookieMsg + 12) == 0) {
				$('#ImageUploadTextCont').hide();
				$('#ImageUploadMessageLink').html('[' + wmu_show_message  + ']');
			}

			// macbre: RT #19150
			if ( window.wgEnableAjaxLogin == true && $('#ImageUploadLoginMsg').length ) {
				$('#ImageUploadLoginMsg').click(openLogin).css('cursor', 'pointer').log('WMU: ajax login enabled');
			}
		}
	}

	$.getJSON( wgScriptPath + '/index.php?action=ajax&rs=WMU&method=loadMainFromView&article=' + encodeURIComponent( wgTitle ) + '&ns=' + wgNamespaceNumber, callback);

	WMU_curSourceId = 0;
}


function WMU_show( e, gallery, box, align, thumb, size, caption, link ) {
	WMU_track({
		action: Wikia.Tracker.ACTIONS.OPEN
	});

	// reset mode to support normal editor usage
	WMU_openedInEditor = true;

	if (wgUserName == null && wgAction == 'edit') {
		// handle login on edit page
		UserLogin.rteForceLogin();
		return;
	} else if (UserLogin.isForceLogIn()) {
		// handle login on article page
		return;
	}

	// Handle MiniEditor focus
	// (BugId:18713)
	if (window.WikiaEditor) {
		var wikiaEditor = WikiaEditor.getInstance();
		if(wikiaEditor.config.isMiniEditor) {
			wikiaEditor.plugins.MiniEditor.hasFocus = true;
		}
	}

	WMU_refid = null;
	WMU_wysiwygStart = 1;
	WMU_gallery = -1;

	if(typeof gallery != "undefined") {
		// if in preview mode, go away
		if ($( '#editform' ).length && (typeof e != 'number') ) {
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
	if(typeof e == 'number') {
		WMU_refid = e;
		if(WMU_refid != -1) {
			if( (typeof(FCK) != 'undefined') && FCK.wysiwygData[WMU_refid].exists) {
				// go to details page
				WMU_wysiwygStart = 2;
			} else {
				// go to main page
			}
		}

	} else if( typeof e == 'object' ) { // for Opera and Chrome
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

	$('#header_ad').css('display', 'none');
	if(WMU_modal != null) {
		WMU_modal.showModal();
		if(WMU_refid != null && WMU_wysiwygStart == 2) {
			WMU_loadDetails();
		} else {
			if( $('#ImageQuery').length) {
				$('#ImageQuery').focusNoScroll();
			}
		}
		return;
	}

	// for gallery and placeholder, load differently...
	if( -1 != WMU_gallery  ) {
		WMU_loadMainFromView();
	} else {
		var html = '<div id="WMU_div" style="width:722px;height:587px;">';
		html += '<div class="reset" id="ImageUpload">';
		html += '	<div id="ImageUploadBorder"></div>';
		html += '	<div id="ImageUploadProgress1" class="ImageUploadProgress"></div>';
		html += '       <div id="ImageUploadBack"><img src="'+wgBlankImgUrl+'" id="fe_wmuback_img" class="sprite back" alt="' + wmu_back + '" /><a href="#">' + wmu_back + '</a></div>';
		html += '	<div id="ImageUploadBody">';
		html += '		<div id="ImageUploadError"></div>';
		html += '		<div id="ImageUploadMain"></div>';
		html += '		<div id="ImageUploadDetails" style="display: none;"></div>';
		html += '		<div id="ImageUploadConflict" style="display: none;"></div>';
		html += '		<div id="ImageUploadSummary" style="display: none;"></div>';
		html += '	</div>';
		html += '</div>';
		html += '</div>';

		WMU_modal = $(html).makeModal({
			onAfterClose: function() {
				WMU_switchScreen('Main');
			},
			persistent: true,
			width: 722
		});

		if(WMU_refid != null && WMU_wysiwygStart == 2) {
			WMU_loadDetails();
		} else {
			WMU_loadMain();
		}
	}
	$('#ImageUploadBack').click(WMU_back);
}

function WMU_loadMain() {
	var callback = function(html) {
		$('#ImageUploadMain').html(html);
		WMU_indicator(1, false);
		if( $('#ImageQuery').length && $('#ImageQuery').is(':visible') ) {
			$('#ImageQuery').focusNoScroll();
		}
		var cookieMsg = document.cookie.indexOf("wmumainmesg=");
		if (cookieMsg > -1 && document.cookie.charAt(cookieMsg + 12) == 0) {
			$('#ImageUploadTextCont').hide();
			$('#ImageUploadMessageLink').html('[' + wmu_show_message  + ']');
		}

		// macbre: RT #19150
		if ( window.wgEnableAjaxLogin == true && $('#ImageUploadLoginMsg').exists() ) {
			$('#ImageUploadLoginMsg').click(openLogin).css('cursor', 'pointer').log('WMU: ajax login enabled');
		}
	}
	WMU_indicator(1, true);

	baseUrl = wgScriptPath + '/index.php?action=ajax&rs=WMU&method=loadMain';
	if ( WMU_exactHeight != null ) {
		baseUrl = baseUrl + '&exactHeight=' + WMU_exactHeight;
	}
	if ( WMU_exactWidth != null ) {
		baseUrl = baseUrl + '&exactWidth=' + WMU_exactWidth;
	}
	if ( WMU_aspectRatio != null ) {
		baseUrl = baseUrl + '&aspectRatio=' + WMU_aspectRatio;
	}

	$.get(baseUrl, callback);
	WMU_curSourceId = 0;
}

function WMU_loadLicense( license ) {
	if ( license == "" ) {
		$('#ImageUploadLicenseText').html("");
	} else {
		var title = 'File:Sample.jpg';
		var url = wgScriptPath + '/api' + wgScriptExtension
			+ '?action=parse&text={{' + encodeURIComponent( license ) + '}}'
			+ '&title=' + encodeURIComponent( title )
			+ '&prop=text&pst&format=json';

		var callback = function(o) {
			var o = eval( '(' + o.responseText + ')' );
			$('#ImageUploadLicenseText').html(o['parse']['text']['*']);
			WMU_indicator(1, false);
		}

		WMU_track({
			label: 'upload-licensing-dropdown'
		});

		WMU_indicator(1, true);
		$.ajax(url, {
			method: 'get',
			complete: callback
		});
	}
	WMU_curSourceId = 0;
}

function WMU_recentlyUploaded(param, pagination) {
	var callback = function(html) {
		$('#WMU_results_0').html(html);
		WMU_indicator(2, false);
	};

	WMU_track({
		label: 'paginate-' + pagination
	});

	if(WMU_exactHeight) {
		param = (param.length > 0 ? param + '&' : '') + 'exactHeight='+WMU_exactHeight;
	}
	if(WMU_exactWidth) {
		param = (param.length > 0 ? param + '&' : '') + 'exactWidth='+WMU_exactWidth;
	}

	WMU_indicator(2, true);
	$.get(wgScriptPath + '/index.php?action=ajax&rs=WMU&method=recentlyUploaded&'+param, callback);
}

function WMU_changeSource(e) {
	e.preventDefault();
	var el = e.target;
	if(el.nodeName == 'A') {
		var sourceId = el.id.substring(11);
		if(WMU_curSourceId != sourceId) {
			$('#WMU_source_' + WMU_curSourceId).css('fontWeight', '');
			$('#WMU_source_' + sourceId).css('fontWeight', 'bold');

			$('#WMU_results_' + WMU_curSourceId).hide();
			$('#WMU_results_' + sourceId).show();

			if($('#ImageQuery').length) {
				$('#ImageQuery').focusNoScroll();
			}

			WMU_track({
				label: sourceId == 0 ? 'find-this-wiki' : 'find-flickr'
			});

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

	var query = $('#ImageQuery').val();

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
	var callback = function(o) {
		$('#WMU_results_' + sourceId).html(o.responseText);
		WMU_indicator(2, false);
	};

	WMU_track({
		label: 'button-find'
	});

	WMU_lastQuery[sourceId] = query;
	WMU_indicator(2, true);
	WMU_jqXHR.abort();
	WMU_jqXHR = $.ajax(wgScriptPath + '/index.php?action=ajax&rs=WMU&method=query&' + 'query=' + query + '&page=' + page + '&sourceId=' + sourceId, {
		method: 'get',
		complete: callback
	});
}

function WMU_indicator(id, show) {
	if(show) {
		if(id == 1) {
			$('#ImageUploadProgress1').show();
		} else if(id == 2) {
			$('#ImageUploadProgress2').css('visibility', 'visible');
		}
	} else {
		if(id == 1) {
			$('#ImageUploadProgress1').hide();
		} else if(id == 2) {
			$('#ImageUploadProgress2').css('visibility', 'hidden');
		}
	}
}

function WMU_chooseImage(sourceId, itemId) {
	var callback = function(o) {
		WMU_displayDetails(o.responseText);
	};

	WMU_track({
		label: 'add-recent-photo'
	});

	WMU_indicator(1, true);
	WMU_jqXHR.abort();
	WMU_jqXHR = $.ajax(wgScriptPath + '/index.php?action=ajax&rs=WMU&method=chooseImage&' + 'sourceId=' + sourceId + '&itemId=' + itemId, {
		method: 'get',
		complete: callback
	});
}

function WMU_upload(e) {
	if($('#ImageUploadFile').val() == '') {
		alert(wmu_warn2);
		return false;
	} else {
		if (WMU_initialCheck( $('#ImageUploadFile').val() )) {
			WMU_track({
				label: 'button-upload'
			});

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

	$('#ImageUploadBack').css('display', 'inline');

	$('#ImageUpload' + WMU_curScreen).html(responseText);

	$('#ImageUploadLicense').bind('change', WMU_licenseSelectorCheck);

	$('#ImageUploadLayoutLeft').on('click', function() {
		WMU_track({
			label: 'checkbox-alignment-left'
		});
	});

	$('#ImageUploadLayoutRight').on('click', function() {
		WMU_track({
			label: 'checkbox-alignment-right'
		});
	});

	// If Details view and showhide link exists, adjust the height of the right sidebar
	$('#WMU_showhide').click(function(event) {
		event.preventDefault();
		if ($(".advanced").is(":visible")) {
			WMU_track({
				label: 'upload-fewer-options'
			});

			$(".ImageUploadRight .chevron").removeClass("up");
			$(this).text($(this).data("more"));
		}	else {
			WMU_track({
				label: 'upload-more-options'
			});

			$(".ImageUploadRight .chevron").addClass("up");
			$(this).text($(this).data("fewer"));
		}
		$(".ImageUploadRight .advanced").slideToggle("fast");
	});

	if( WMU_skipDetails ){
		$('#ImageUpload' + WMU_curScreen).hide();
		$('#ImageUploadLayoutLeft').attr('checked', true);
		$('#ImageUploadFullOption').attr('checked', true);

		WMU_insertImage('skip');
	}else if($('#ImageUploadThumb').length) {
		WMU_orgThumbSize = null;
		var image = $('#ImageUploadThumb').children(':first');
		if ( null == WMU_width ) {
			WMU_width = $( '#ImageRealWidth' ).val();
			WMU_height = $( '#ImageRealHeight' ).val();
		}
		var thumbSize = [image.width(), image.height()];
		WMU_orgThumbSize = null;
		WMU_slider = YAHOO.widget.Slider.getHorizSlider('ImageUploadSlider', 'ImageUploadSliderThumb', 0, 200);
		WMU_slider.initialRound = true;
		WMU_slider.getRealValue = function() {
			return Math.max(2, Math.round(this.getValue() * (thumbSize[0] / 200)));
		}
		WMU_slider.subscribe("change", function(offsetFromStart) {
			$( '#ImageUploadSliderThumb' ).css('visibility', 'visible');
			if (WMU_slider.initialRound) {
				$('#ImageUploadManualWidth').val('');
				WMU_slider.initialRound = false;
			} else {
				$('#ImageUploadManualWidth').val(WMU_slider.getRealValue());

				if ($("#ImageUploadWidthCheckbox").val() == "false") {
					$("#ImageUploadWidthCheckbox").val("true").attr('checked', true);
				}
			}
			image.width(WMU_slider.getRealValue());
			$('#ImageUploadManualWidth').val(image.width());
			image.height(image.width() / (thumbSize[0] / thumbSize[1]));
			if(WMU_orgThumbSize == null) {
				WMU_orgThumbSize = [image.width(), image.height()];
				WMU_ratio = WMU_width / WMU_height;
			}
			WMU_thumbSize = [image.width(), image.height()];
		});

		if(image.width() < 250) {
			WMU_slider.setValue(200, true);
		} else {
			WMU_slider.setValue(125, true);
		}
		$('#ImageLinkRow').hide();

	}
	if ($( '#WMU_error_box' ).html()) {
		alert( $( '#WMU_error_box' ).html() );
	}

	if( 0 < WMU_align ) {
		if( 1 == WMU_align ) {
			$( '#ImageUploadLayoutLeft' ).attr('checked', true);
		} else {
			$( '#ImageUploadLayoutRight' ).attr('checked', true);
		}
	}

	if( 0 < WMU_size ) {
		$( '#ImageUploadWidthCheckbox' ).click();
		$( '#ImageUploadManualWidth' ).val(WMU_size);
		WMU_manualWidthInput();
	}

	if( '' != WMU_caption ) {
		$( '#ImageUploadCaption' ).val(WMU_caption);
	}

	if( '' != WMU_link ) {
		$( '#ImageUploadLink' ).val(WMU_link);
	}

	if ( $( '#ImageUploadLicenseText' ).length ) {
		var cookieMsg = document.cookie.indexOf("wmulicensemesg=");
		if (cookieMsg > -1 && document.cookie.charAt(cookieMsg + 15) == 0) {
			$('#ImageUploadLicenseText').hide();
			$('#ImageUploadLicenseLink').html('[' + wmu_show_license_message  + ']');
		}
	}

	if(typeof(WMU_Event_OnLoadDetails) == "function") {
		setTimeout(function() {
			WMU_Event_OnLoadDetails();
		},100);
	}
	WMU_indicator(1, false);
}

function WMU_insertPlaceholder( box ) {
	WMU_box_filled.push(box);
	var to_update = $( '#WikiaImagePlaceholder' + box );
	to_update.html($( '#ImageUploadCode' ).html());
	//the class would need to be different if we had here the full-size...
	to_update.className = '';
	$.post(wgServer + wgScript + '?title=' + wgPageName  +'&action=purge');
}

function WMU_insertImage(type) {
	var params = [];
	params.push('type='+type);
	params.push('mwname='+$('#ImageUploadMWname').val());
	params.push('tempid='+$('#ImageUploadTempid').val());

	if(WMU_exactHeight) {
		params.push('exactHeight='+WMU_exactHeight);
	}
	if(WMU_exactWidth) {
		params.push('exactWidth='+WMU_exactWidth);
	}
	if(WMU_aspectRatio) {
		params.push('aspectRatio='+WMU_aspectRatio);
	}

	var captionUpdateInput = $('#ImageUploadReplaceDefault');
	if (captionUpdateInput.is(':hidden')) {
		params.push('update_caption=' + captionUpdateInput.val());
	} else {
		var isCaptionUpdate = (captionUpdateInput.is(':checked')) ? 'on' : '';
		params.push('update_caption=' + isCaptionUpdate );
	}

	if(type == 'overwrite') {
		params.push('name='+ encodeURIComponent( $('#ImageUploadExistingName').val() ) );
	} else if(type == 'rename') {
		if( '' == $( '#ImageUploadRenameName' ).val() ) {
			alert( wmu_warn3 );
			return;
		}
		params.push('name='+ encodeURIComponent( $('#ImageUploadRenameName').val() ) + '.' + $( '#ImageUploadRenameExtension' ).val() );
	} else {
		if($('#ImageUploadName').length) {
			if( '' == $( '#ImageUploadName' ).val() ) {
				alert( wmu_warn3 );
				return;
			}
			// for RT #24050 - Bartek
			var uploadName = $( '#ImageUploadName' ).val();
			if( uploadName && uploadName.indexOf( '/' ) > 0 )  {
				var parts = $( '#ImageUploadName' ).val().split( '/' );
				var lastname = parts.pop();
				$( '#ImageUploadName' ).val(lastname);
				alert( badfilename.replace( '$1', lastname ) );
				return;
			}

			params.push('name='+ encodeURIComponent( $('#ImageUploadName').val() ) + '.' + $('#ImageUploadExtension').val());
		}
	}

	if($('#ImageUploadLicense').length) {
		params.push('ImageUploadLicense='+$('#ImageUploadLicense').val());
	}

	if($('#ImageUploadExtraId').length) {
		params.push('extraId='+$('#ImageUploadExtraId').val());
	}

	if($('#ImageUploadThumb').length) {
		if( $('#ImageUploadThumbOption').is(':checked') ) {
			params.push( 'size=thumb' );

			// refs RT #35575
			var width = parseInt( $( '#ImageUploadManualWidth' ).val() );
			if (width > 0) {
				params.push( 'width=' + width + 'px' );
			}
		} else {
			params.push( 'size=full' );
		}
		params.push('layout=' + ($('#ImageUploadLayoutLeft').is(':checked') ? 'left' : 'right'));
		params.push('caption=' + encodeURIComponent( $('#ImageUploadCaption').val() ) );
		params.push('slider=' + $('#ImageUploadWidthCheckbox').val());
	}

	// support links (BugId:6506)
	var link = $('#ImageUploadLink').val();
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
			if( $('#ImageUploadLink').length ) {
				if( '' != $('#ImageUploadLink').val() ) {
					params.push( 'link=' + encodeURIComponent( $('#ImageUploadLink').val() ) );
				}
			}
		} else  {
			params.push( 'link=' + WMU_link );
		}
	}

	var callback = function(o) {
		var screenType = WMU_jqXHR.getResponseHeader('X-screen-type');
		if(typeof screenType == "undefined") {
			screenType = WMU_jqXHR.getResponseHeader('X-Screen-Type');
		}

		switch($.trim(screenType)) {
			case 'error':
				o.responseText = o.responseText.replace(/<script.*script>/, "" );
				alert(o.responseText);
				WMU_switchScreen('Summary');
				break;
			case 'conflict':
				WMU_switchScreen('Conflict');
				$('#ImageUpload' + WMU_curScreen).html(o.responseText);
				break;
			case 'summary':
				WMU_switchScreen('Summary');
				if (typeof RTE !== 'undefined') {
					RTE.getInstanceEditor().getEditbox().focus();
				}

				$('#ImageUploadBack').hide();
				$('#ImageUpload' + WMU_curScreen).html(o.responseText);

				var event = jQuery.Event("imageUploadSummary");
				$("body").trigger(event, [$('#ImageUpload' + WMU_curScreen)]);
				if ( event.isDefaultPrevented() ) {
					return false;
				}

				// Special Case for using WMU in SDSObject Special Page - returns the file name of chosen image
				var $responseHTML = $(o.responseText),
					wmuData = {
					imageTitle: $responseHTML.find('#ImageUploadFileName').val(),
					imageWikiText: $responseHTML.find('#ImageUploadTag').val()
				};
				$(window).trigger('WMU_addFromSpecialPage', [wmuData]);

				// prevent checking for editor if WMU used outside of the editor context
				if(!WMU_openedInEditor) {
					return false;
				}

				if((WMU_refid == null) || (wgAction == "view") || (wgAction == "purge") ){ // not FCK
					if( -2 == WMU_gallery) {
						WMU_insertPlaceholder( WMU_box );
					} else {
						// insert image in source mode
						insertTags($('#ImageUploadTag').val(), '', '', WMU_getRTETxtarea());
					}
				} else { // FCK
					var wikitag = $('#ImageUploadTag').val();
					var options = {};

					if($('#ImageUploadThumbOption').is(':checked')) {
						options.thumb = 1;
					} else {
						options.thumb = null;
					}
					if($('#ImageUploadWidthCheckbox').is(':checked')) {
						options.width = WMU_slider.getRealValue();
					} else {
						options.width = null;
					}
					if($('#ImageUploadLayoutLeft').is(':checked')) {
						options.align = 'left';
					} else {
						options.align = null;
					}
					options.caption = $('#ImageUploadCaption').val();

					// handle links (BugId:6506)
					if (!options.thumb) {
						options.link = $('#ImageUploadLink').val();
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
	};

	if ( type == 'details' ) {
		WMU_track({
			label: 'button-add-photo'
		});
	}

	WMU_indicator(1, true);
	WMU_jqXHR.abort();
	WMU_jqXHR = $.ajax(wgScriptPath + '/index.php?action=ajax&rs=WMU&method=insertImage&' + params.join('&'), {
		method: 'get',
		complete: callback
	});
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

}

function MWU_imageSizeChanged(size) {
	$('#ImageWidthRow').css('display', size == 'thumb' ? '' : 'none');

	if($('#ImageUploadThumb').length) {
		var image = $('#ImageUploadThumb').children(':first');

		WMU_track({
			label: 'checkbox-size-' + size
		});

		if(size == 'thumb') {
			image.width(WMU_thumbSize[0]);
			image.height(WMU_thumbSize[1]);
			$('#ImageUploadManualWidth').val(WMU_thumbSize[0]);
			$('#ImageLinkRow').hide();
		} else if (size == 'full') {
			image.width(WMU_orgThumbSize[0]);
			image.height(WMU_orgThumbSize[1]);
			$('#ImageUploadManualWidth').val(WMU_orgThumbSize[0]);
			if( 0 == WMU_link ) {
				$('#ImageLinkRow').show();
			}
		} else {
			if( 0 == WMU_link ) {
				$('#ImageLinkRow').show();
			}
		}
	}
}

function WMU_toggleLicenseMesg(e) {
	e.preventDefault();
	if ('none' == $('#ImageUploadLicenseText').css('display') ) {
		WMU_track({
			label: 'upload-licensing-show'
		});

		$('#ImageUploadLicenseText').show();
		$('#ImageUploadLicenseLink').html('[' + wmu_hide_license_message  + ']');
		document.cookie = "wmulicensemesg=1";
	} else {
		WMU_track({
			label: 'upload-licensing-hide'
		});

		$('#ImageUploadLicenseText').hide();
		$('#ImageUploadLicenseLink').html('[' + wmu_show_license_message  + ']');
		document.cookie = "wmulicensemesg=0";
	}
}

function WMU_switchScreen(to) {
	WMU_prevScreen = WMU_curScreen;
	WMU_curScreen = to;
	$('#ImageUpload' + WMU_prevScreen).hide();
	$('#ImageUpload' + WMU_curScreen).show();
	if(WMU_curScreen == 'Main') {
		$('#ImageUploadBack').hide();
		WMU_loadMain();
	}
	if((WMU_prevScreen == 'Details' || WMU_prevScreen == 'Conflict') && WMU_curScreen == 'Main' && $('#ImageUploadName').length) {
		$.get('GET', wgScriptPath + '/index.php?action=ajax&rs=WMU&method=clean&mwname=' + $('#ImageUploadMWname').val() + '&tempid=' + $( '#ImageUploadTempid' ).val());
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
	e.preventDefault();

	WMU_track({
		label: 'button-back'
	});

	if(WMU_curScreen == 'Details') {
		WMU_switchScreen('Main');
	} else if(WMU_curScreen == 'Conflict' && WMU_prevScreen == 'Details') {
		WMU_switchScreen('Details');
	}
}

function WMU_close(e) {
	if(e) {
		e.preventDefault();
	}

	WMU_track({
		action: Wikia.Tracker.ACTIONS.CLOSE
	});

	WMU_modal.hideModal();
	if(typeof window.RTE == 'undefined' && $('#wpTextbox1').length) $('#wpTextbox1').focus();
	WMU_switchScreen('Main');
	WMU_loadMain();
	$('#header_ad').css('display', 'block');

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

var WMU_track = Wikia.Tracker.buildTrackingFunction( Wikia.trackEditorComponent, {
	action: Wikia.Tracker.ACTIONS.CLICK,
	category: 'photo-tool',
	trackingMethod: 'both'
});
