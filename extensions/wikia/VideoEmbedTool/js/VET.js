/*global UserLogin, WikiaEditor*/

/*
 * Author: Inez Korczynski, Bartek Lapinski
 */


/*
 * Variables
 */

var VET_panel = null;
var VET_curSourceId = 0;
var VET_lastQuery = new Array();
var VET_asyncTransaction = null;
var VET_curScreen = 'Main';
var VET_prevScreen = null;
var VET_slider = null;
var VET_thumbSize = null;
var VET_orgThumbSize = null;
var VET_placeholder = -1;
var VET_align = 0;
var VET_thumb = 0;
var VET_size = 0;
var VET_caption = 0;
var VET_box = -1;
var VET_width = null;
var VET_height = null;
var VET_widthChanges = 1;
var VET_refid = null;
var VET_wysiwygStart = 1;
var VET_ratio = 1;
var VET_shownMax = false;
var VET_notificationTimout = 4000;
var VET_isOnSpecialPage = false;

// Returns the DOM element for the RTE textarea
function VET_getTextarea() {
	return WikiaEditor.getInstance().getEditbox()[0];
}

function VET_getTextareaValue() {
	var ckeditor = WikiaEditor.getInstance().ck;
	if(ckeditor) {
		return ckeditor.getData();
	} else {
		return VET_getTextarea().value;
	}
}

// macbre: show edit video screen (wysiwyg edit)
function VET_editVideo() {
	YAHOO.util.Dom.setStyle('VideoEmbedMain', 'display', 'none');
	VET_indicator(1, true);

	var callback = {
		success: function(o) {
			var data = FCK.wysiwygData[VET_refid];

			VET_displayDetails(o.responseText, data);

			$G('VideoEmbedBack').style.display = 'none';

			setTimeout(function() {

				if ( (typeof (data.thumbnail) != "undefined" && data.thumbnail ) ||
		             (typeof (data.thumb) != "undefined" && data.thumb ) ) {
		
		             $("#VideoEmbedThumbOption").attr('checked', 'checked');
		             $('#VET_StyleThumb').addClass('selected');
		        }  else {
		        	 $('#VideoEmbedSizeRow > div').children('input').removeClass('show');
					 $('#VideoEmbedSizeRow > div').children('p').addClass('show');
		        	 $("#VideoEmbedThumbOption").attr('checked', '');
		             $("#VideoEmbedNoThumbOption").attr('checked', 'checked');
		             $('#VET_StyleThumb').removeClass('selected');
		             $('#VET_StyleNoThumb').addClass('selected');     
		        }

				if(data.align && data.align == 'left') {
					$('#VideoEmbedLayoutLeft').attr('checked', 'checked').parent().addClass('selected');
				} else if (data.align && data.align == 'center') {
					$('#VideoEmbedLayoutCenter').attr('checked', 'checked').parent().addClass('selected');
				} else {
					$('#VideoEmbedLayoutRight').attr('checked', 'checked').parent().addClass('selected');
				}
				
				if(data.width) {
					VET_readjustSlider( data.width );
					VET_width = data.width;
					$('#VideoEmbedManualWidth').val(VET_width);
				}
				
			}, 200);
			if(data.caption) {
				$G('VideoEmbedCaption').value = data.caption;
			}

			// show width slider
			VET_toggleSizing(true);

			// show alignment row
			$G( 'VideoEmbedLayoutRow' ).style.display = '';

			// make replace video link to open in new window / tab
			$G('VideoReplaceLink').getElementsByTagName('a')[0].setAttribute('target', '_blank');
		}
	};

	YAHOO.util.Connect.abort(VET_asyncTransaction);
	var params = [];
	var escTitle = "";
	if ( typeof(FCK.wysiwygData[VET_refid].href) == "undefined" ) {
		escTitle = FCK.wysiwygData[VET_refid].title;
	} else {
		escTitle = FCK.wysiwygData[VET_refid].href;
	}
	escTitle = encodeURIComponent(escTitle);
	params.push( 'itemTitle='+escTitle );

	YAHOO.util.Connect.initHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8')
	VET_asyncTransaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=VET&method=editVideo&' + params.join('&'), callback);
}

// macbre: update video in wysiwyg mode
function VET_doEditVideo() {

	YAHOO.util.Event.preventDefault( YAHOO.util.Event.getEvent() );

	// setup metadata
	var extraData = {};

	extraData.href = $G('VideoEmbedHref').value;
	extraData.width= $G('VideoEmbedManualWidth').value;

	if ($G('VideoEmbedThumbOption').checked) {
		extraData.thumb = 1;
	}

	//if (extraData.thumb) { // bugId:26619
		if( $G('VideoEmbedLayoutLeft').checked ) {
			extraData.align = 'left';
		} else if ($G('VideoEmbedLayoutCenter').checked ) {
			extraData.align = 'center';
		} else {
			extraData.align = 'right';
		}
	//}

	if ($G('VideoEmbedCaption').value) {
		 extraData.caption = $G('VideoEmbedCaption').value;
	}

	// generate wikitext
	var wikitext = '[[' + extraData.href;

	if (extraData.thumb) {
		wikitext += '|thumb';
	}

	if (extraData.align) {
		wikitext += '|' + extraData.align;
	}

	if (extraData.width) {
		wikitext += '|' + extraData.width + 'px';
	}

	if (extraData.caption) {
		wikitext += '|' + extraData.caption;
	}

	wikitext += ']]';

	// macbre: CK support
	if (typeof window.VET_RTEVideo != 'undefined') {
		if (window.VET_RTEVideo) {
			// update existing video
			RTE.mediaEditor.update(window.VET_RTEVideo, wikitext, extraData);
		}
		else {
			// add new video
			RTE.mediaEditor.addVideo(wikitext, extraData);
		}
	}
	else {
		// update FCK
		FCK.VideoUpdate(VET_refid, wikitext, extraData);
	}

	// close dialog
	VET_close();
}

// macbre: move back button inside dialog content and add before provided selector (Oasis changes)
function VET_moveBackButton(selector) {
	if (window.skin != 'oasis') {
		return;
	}

	// store back button
	if (typeof window.VETbackButton == 'undefined') {
		var backButtonOriginal = $('#VideoEmbedBack');
		var backButton = backButtonOriginal.clone();

		// keep the original one, but force it to be hidden
		backButtonOriginal.css('visibility', 'hidden');

		// remove an image and add button class
		backButton.removeAttr('id').remove();

		// keep reference to <a> tag
		backButton = backButton.children('a').addClass('wikia-button yui-back secondary v-float-right');
		window.VETbackButton = backButton;
	}

	// remove previous instances of .yui-back
	$('.yui-back').remove();

	// move button
	window.VETbackButton.clone().
		click(VET_back).
		insertAfter(selector);
}

/*
 * Functions/methods
 */

function VET_toggleSizing( enable ) {
	if( enable ) {
		$G( 'VideoEmbedThumbOption' ).disabled = false;
		$G( 'VideoEmbedNoThumbOption' ).disabled = false;
		$G( 'VideoEmbedWidthRow' ).style.display = '';
		$G( 'VideoEmbedSizeRow' ).style.display = '';
	} else {
		$G( 'VideoEmbedThumbOption' ).disabled = true;
		$G( 'VideoEmbedNoThumbOption' ).disabled = true;
		$G( 'VideoEmbedWidthRow' ).style.display = 'none';
		$G( 'VideoEmbedSizeRow' ).style.display = 'none';
	}
}

function VET_manualWidthInput( elem ) {
    var val = parseInt( elem.value );
    if ( isNaN( val ) ) {
		$G( 'VideoEmbedManualWidth' ).value = 335;
		VET_readjustSlider( 335 );
		return false;
    }
	$G( 'VideoEmbedManualWidth' ).value = val;
	VET_readjustSlider( val );
}

function VET_readjustSlider( value ) {
		if ( 670 < value ) { // too big, hide slider
			if ( $('#VideoEmbedSlider .ui-slider-handle').is(':visible') ) {
				$('#VideoEmbedSlider .ui-slider-handle').hide();
				$('#VideoEmbedSlider').slider && $('#VideoEmbedSlider').slider({
					value: 335
				});
			}
		} else {
			if ( !$('#VideoEmbedSlider .ui-slider-handle').is(':visible') ) {
				$('#VideoEmbedSlider .ui-slider-handle' ).show();
			}

			$('#VideoEmbedSlider').slider && $('#VideoEmbedSlider').slider({
				value: value
			});
		}
}

function VET_showPreview(e) { // note for refactory - doesn't seem to be getting called anywhere
	YAHOO.util.Dom.setStyle('header_ad', 'display', 'none');

	var html = '';
	html += '<div class="reset" id="VideoEmbedPreview">';
	html += '	<div id="VideoEmbedBorder"></div>';
	html += '	<div id="VideoEmbedPreviewClose"><img src="'+wgBlankImgUrl+'" id="fe_vetpreviewclose_img" class="sprite close" alt="' + $.msg('vet-close') + '" /><a href="#">' + $.msg('vet-close') + '</a></div>';
	html += '	<div id="VideoEmbedPreviewBody">';
	html += '		<div id="VideoEmbedPreviewContent" style="display: none;"></div>';
	html += '	</div>';
	html += '</div>';

	var element = document.createElement('div');
	element.id = 'VET_previewDiv';
	element.style.width = '600px';
	element.style.height = '300px';
	element.innerHTML = html;

	document.body.appendChild(element);

	VET_previewPanel = new YAHOO.widget.Panel('VET_previewDiv', {
		modal: true,
		constraintoviewport: true,
		draggable: false,
		close: false,
		underlay: "none",
		visible: false,
		zIndex: 1600
	});
	VET_previewPanel.render();
	VET_previewPanel.show();
	VET_panel.center();
	if(VET_refid != null && ( VET_wysiwygStart == 2 || VET_placeholder == -2 ) ) {
		VET_editVideo();
	} else {
		VET_loadMain();
	}

	YAHOO.util.Event.addListener('VideoEmbedPreviewClose', 'click', VET_previewClose);
}

function VET_getCaret() {
  var caretPos = 0, control = VET_getTextarea();
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

function VET_show( e, placeholder, box, align, thumb, size, caption ) {
	if (wgUserName == null && wgAction == 'edit') {
		// handle login on edit page
		UserLogin.rteForceLogin();
		return;
	} else if (UserLogin.isForceLogIn()) {
		// handle login on article page
		return;
	}

	var errorDiv = $('#VideoEmbedError')
	// Handle MiniEditor focus
	// (BugId:18713)
	if (window.WikiaEditor) {
		var wikiaEditor = WikiaEditor.getInstance();
		if(wikiaEditor.config.isMiniEditor) {
			wikiaEditor.plugins.MiniEditor.hasFocus = true;
		}
	}

	VET_isOnSpecialPage = wgNamespaceNumber === -1;

	VET_refid = null;
	VET_wysiwygStart = 1;
	VET_placeholder = -1;

	if(typeof placeholder != 'undefined') {
		VET_placeholder = placeholder;
		VET_box = box;
		// they only are given when the placeholder is given...
		if(typeof align != "undefined") {
			VET_align = align;
		}

		if(typeof thumb != "undefined") {
			VET_thumb = thumb;
		}

		if(typeof size != "undefined") {
			VET_size = size;
		}

		if(typeof caption != "undefined") {
			VET_caption = caption;
		}
	}

	// TODO: FCK support - to be removed after full switch to RTE
	if(YAHOO.lang.isNumber(e)) {
		if( typeof FCK != "undefined" ){
			VET_refid = e;
			if(VET_refid != -1) {
				if(FCK.wysiwygData[VET_refid].href) {
					// go to details page
					VET_wysiwygStart = 2;
				} else {
					// go to main page
				}
			}
		}
	} else {
		// macbre: CK support
		if (e && e.type === 'rte') {
			// get video from event data
			window.VET_RTEVideo = e.data.element;
			if (window.VET_RTEVideo) {
				// edit a video
				var data = window.VET_RTEVideo.getData();
				if (e.data.isPlaceholder) {
					// video placeholder
					RTE.log('video placeholder clicked');

					VET_placeholder = -1;
				}
				else {
					// "regular" video
					$.extend(data, data.params);
					delete data.params;

					VET_wysiwygStart = 2;
				}

				// FIXME: let's pretend we're FCK for now
				VET_refid = 0;
				window.FCK = {wysiwygData: {0: {}}};
				window.FCK.wysiwygData[0] = data;
			}
			else {
				// add new video
				VET_refid = -1;
			}
		}
	}

	VET_tracking(WikiaTracker.ACTIONS.CLICK, 'open');

	YAHOO.util.Dom.setStyle('header_ad', 'display', 'none');
	if(VET_panel != null) {
		if ( 400 == wgNamespaceNumber ) {
			if( $G( 'VideoEmbedPageWindow' ) ) {
				$G( 'VideoEmbedPageWindow' ).style.visibility = 'hidden';
			}
		}

		VET_panel.show();
		// Recenter each time for different instances of RTE. (BugId:15589)
		VET_panel.center();
			if(VET_refid != null && VET_wysiwygStart == 2) {
			VET_editVideo();
		} else if($G('VideoEmbedUrl')) {
			$G('VideoEmbedUrl').focus();
		}
		return;
	}

	var html = '';
	html += '<div class="reset" id="VideoEmbed">';
	html += '	<div id="VideoEmbedError"></div>';
	html += '	<div id="VideoEmbedBorder"></div>';
	html += '	<div id="VideoEmbedProgress1" class="VideoEmbedProgress"></div>';
	html += '	<div id="VideoEmbedBack"><img src="'+wgBlankImgUrl+'" id="fe_vetback_img" class="sprite back" alt="' + $.msg('vet-back') + '" /><a href="#">' + $.msg('vet-back') + '</a></div>';
	html += '	<div id="VideoEmbedBody">';
	html += '		<div id="VideoEmbedClose"><img src="'+wgBlankImgUrl+'" id="fe_vetclose_img" class="sprite close" alt="' + $.msg('vet-close') + '" /><a href="#">' + $.msg('vet-close') + '</a></div>';
	html += '		<div id="VideoEmbedMain"></div>';
	html += '		<div id="VideoEmbedDetails" style="display: none;"></div>';
	html += '		<div id="VideoEmbedConflict" style="display: none;"></div>';
	html += '		<div id="VideoEmbedSummary" style="display: none;"></div>';
	html += '	</div>';
	html += '</div>';

	var element = document.createElement('div');
	element.id = 'VET_div';
	element.style.width = '970px';
	element.style.height = '487px';
	element.innerHTML = html;

	document.body.appendChild(element);

	VET_panel = new YAHOO.widget.Panel('VET_div', {
		modal: true,
		constraintoviewport: true,
		draggable: false,
		close: false,
		underlay: "none",
		visible: false,
		zIndex: 900
	});

	// use display: block/none for YUI panels (BugId:8825)
	VET_panel.showEvent.subscribe(function() {
		YAHOO.util.Dom.setStyle(this.element, "display", "block");
	});
	VET_panel.hideEvent.subscribe(function() {
		YAHOO.util.Dom.setStyle(this.element, "display", "none");
	});

	VET_panel.render();
	VET_panel.show();
	VET_panel.center();
	
	if(VET_refid != null && VET_wysiwygStart == 2) {
		VET_editVideo();
	} else {
		VET_loadMain();
	}

	YAHOO.util.Event.addListener('VideoEmbedBack', 'click', VET_back);
	YAHOO.util.Event.addListener('VideoEmbedClose', 'click', VET_close);

	if ( 400 == wgNamespaceNumber ) {
		if( $G( 'VideoEmbedPageWindow' ) ) {
			$G( 'VideoEmbedPageWindow' ).style.visibility = 'hidden';
		}
	}
}

function VET_loadMain() {
	var callback = {
		success: function(o) {
			$G('VideoEmbedMain').innerHTML = o.responseText;
			VET_indicator(1, false);
			if($G('VideoEmbedUrl') && VET_panel.element.style.visibility == 'visible') {
				$G('VideoEmbedUrl').focus();
			}

			// macbre: RT #19150
			if ( window.wgEnableAjaxLogin == true && $('#VideoEmbedLoginMsg').exists() ) {
				$('#VideoEmbedLoginMsg').click(openLogin).css('cursor', 'pointer').log('VET: ajax login enabled');
			}
			
			// Add suggestions and search to VET
			VETExtended.init();
		}
	}
	VET_indicator(1, true);
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=VET&method=loadMain', callback);
	VET_curSourceId = 0;
}

function VET_recentlyUploaded(param, pagination) {
	var callback = {
		success: function(o) {
			$G('VET_results_0').innerHTML = o.responseText;
			VET_indicator(1, false);
		}
	}
	VET_indicator(1, true);
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=VET&method=recentlyUploaded&'+param, callback);
}

function VET_sendQuery(query, page, sourceId, pagination) {
	var callback = {
		success: function(o) {
			$G('VET_results_' + o.argument[0]).innerHTML = o.responseText;
			VET_indicator(1, false);
		},
		argument: [sourceId]
	}
	VET_lastQuery[sourceId] = query;
	VET_indicator(1, true);
	YAHOO.util.Connect.abort(VET_asyncTransaction);
	VET_asyncTransaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=VET&method=query&' + 'query=' + query + '&page=' + page + '&sourceId=' + sourceId, callback);
}

function VET_indicator(id, show) {
	if(show) {
		if(id == 1) {
			$G('VideoEmbedProgress1').style.display = 'block';
		} else if(id == 2) {
			$G('VideoEmbedProgress2').style.visibility = 'visible';
		}
	} else {
		if(id == 1) {
			$G('VideoEmbedProgress1').style.display = '';
		} else if(id == 2) {
			$G('VideoEmbedProgress2').style.visibility = 'hidden';
		}
	}
}

function VET_chooseImage(sourceId, itemId, itemLink, itemTitle) {
	var callback = {
		success: function(o) {
			VET_displayDetails(o.responseText);
		}
	}
	VET_indicator(1, true);
	YAHOO.util.Connect.abort(VET_asyncTransaction);
	VET_asyncTransaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=VET&method=chooseImage&' + 'sourceId=' + sourceId + '&itemId=' + itemId + '&itemLink=' + itemLink + '&itemTitle=' + itemTitle, callback);
}

function VET_onVideoEmbedUrlKeypress(e) {
	var event = YAHOO.util.Event.getEvent();
	if (YAHOO.util.Event.getCharCode(event) == 13){
		YAHOO.util.Event.preventDefault( event );
		VET_preQuery(null);
		return false;
	}

}

function VET_preQuery(e) {
	var errorDiv = $('#VideoEmbedError');
	if($G('VideoEmbedUrl').value == '') {
		GlobalNotification.show( $.msg('vet-warn2'), 'error', errorDiv, VET_notificationTimout );
		return false;
	} else {
		errorDiv.hide();
		var query = $G('VideoEmbedUrl').value;
		VET_indicator(1, true);
		VET_sendQueryEmbed( query );
		return false;
	}
}

function VET_displayDetails(responseText, dataFromEditMode) {
	var errorDiv = $('#VideoEmbedError');

	VET_switchScreen('Details');
	VET_width = null;
	$G('VideoEmbedBack').style.display = 'inline';

	// wlee: responseText could include <script>. Use jQuery to parse
	// and execute this script
	$('#VideoEmbed' + VET_curScreen).html(responseText);

	if($G('VideoEmbedThumb')) {
		VET_orgThumbSize = null;
		var image = $G('VideoEmbedThumb').firstChild;
		var thumbSize = [image.width, image.height];
		VET_orgThumbSize = null;
	}
	
	var value = 335;
	
	if (dataFromEditMode && dataFromEditMode.width) {
		value = dataFromEditMode.width;
	}
	
	function initSlider() {	
			
		$('.WikiaSlider').slider({
			min: 100,
			max: 670,
			value: value,
			slide: function(event, ui) {
				$('#VideoEmbedManualWidth').val(ui.value);
			},
			create: function(event, ui) {
				$('#VideoEmbedManualWidth').val(value);
			}
		});
	}

	// VET uses jquery ui slider, lazy load it if needed
	if (!$.fn.slider) {
		$.when(
			$.getResources([
				wgResourceBasePath + '/resources/jquery.ui/jquery.ui.widget.js',
				wgResourceBasePath + '/resources/jquery.ui/jquery.ui.mouse.js',
				wgResourceBasePath + '/resources/jquery.ui/jquery.ui.slider.js'
			])
		).done(initSlider);
	} else {
		initSlider();
	}

	if ($G( 'VET_error_box' )) {
		GlobalNotification.show( $G( 'VET_error_box' ).innerHTML, 'error', errorDiv, VET_notificationTimout );
	}

	if( 0 < VET_align ) {
		$G( 'VideoEmbedLayoutRow' ).style.display = 'none';
	}

	if( 0 < VET_thumb ) {
		$G( 'VideoEmbedSizeRow' ).style.display = 'none';
	}

	if( 0 < VET_size ) {
		$G( 'VideoEmbedWidthRow' ).style.display = 'none';
	}

	if( '' != VET_caption ) {
		$G('VideoEmbedCaptionRow').style.display = 'none';
	}

	if ( VET_placeholder != -1 ) {
		$G( 'VET_LayoutGalleryBox' ).style.display = 'none';

	}

	if ( ( 400 == wgNamespaceNumber ) ) {
		if( $G( 'VideoEmbedName' ) ) {
			$G( 'VideoEmbedName' ).value = wgTitle;
			$G( 'VideoEmbedNameRow' ).style.display = 'none';
		}
	}

	if ( $G('VideoEmbedMain').innerHTML == '' ) {
		VET_loadMain();
	}

	VET_indicator(1, false);
	$('#VideoEmbedCaption').placeholder();
}

function VET_insertFinalVideo(e, type) {
	var errorDiv = $('#VideoEmbedError');

	VET_tracking(WikiaTracker.ACTIONS.CLICK, 'complete');

	YAHOO.util.Event.preventDefault(e);

	var params = new Array();
	params.push('type='+type);

	if(!$G('VideoEmbedName')) {
		if ($G( 'VideoEmbedOname' ) ) {
			if ('' == $G( 'VideoEmbedOname' ).value) {
				GlobalNotification.show( $.msg('vet-warn3'), 'error', errorDiv, VET_notificationTimout );
				return false;
			}
		} else {
			GlobalNotification.show( $.msg('vet-warn3'), 'error', errorDiv, VET_notificationTimout );
			return false;
		}
	} else if ('' == $G( 'VideoEmbedName' ).value ) {
		GlobalNotification.show( $.msg('vet-warn3'), 'error', errorDiv, VET_notificationTimout );
		return false;
	}

	params.push('id='+$G('VideoEmbedId').value);
	params.push('provider='+$G('VideoEmbedProvider').value);

	if( $G( 'VideoEmbedMetadata' ) ) {
		var metadata = new Array();
		metadata = $G( 'VideoEmbedMetadata' ).value.split( "," );
		for( var i=0; i < metadata.length; i++ ) {
			params.push( 'metadata' + i  + '=' + metadata[i] );
		}
	}

	if( VET_placeholder != -1 ) {
		params.push( 'placeholder=' + VET_placeholder );
		params.push( 'box=' + VET_box );
		params.push( 'article='+encodeURIComponent( wgTitle ) );
		params.push( 'ns='+wgNamespaceNumber );
		if( VET_refid != null ) {
			params.push( 'fck=true' );
		}
	}

	params.push('oname='+encodeURIComponent( $G('VideoEmbedOname').value ) );

	if(type == 'overwrite') {
		params.push('name='+encodeURIComponent( $G('VideoEmbedExistingName').value ) );
	} else if(type == 'rename') {
		params.push('name='+encodeURIComponent( $G('VideoEmbedRenameName').value ) );
	} else {
		if ($G( 'VideoEmbedName' )) {
			params.push('name='+encodeURIComponent( $G('VideoEmbedName').value) );
		}
	}

	if($G('VideoEmbedThumb')) {
		params.push('size=' + ($G('VideoEmbedThumbOption').checked ? 'thumb' : 'full'));
		params.push( 'width=' + $G( 'VideoEmbedManualWidth' ).value );
		if( $G('VideoEmbedLayoutLeft').checked ) {
			params.push( 'layout=left' );
		} else if( $G('VideoEmbedLayoutGallery').checked ) {
			params.push( 'layout=gallery' );
		} else if ( $G('VideoEmbedLayoutCenter').checked ) {
			params.push( 'layout=center' )
		} else {
			params.push( 'layout=right' );
		}
		params.push('caption=' + encodeURIComponent( $G('VideoEmbedCaption').value ) );
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
					GlobalNotification.show( o.responseText, 'error', errorDiv, VET_notificationTimout );
					break;
				case 'conflict':
					VET_switchScreen('Conflict');
					$G('VideoEmbed' + VET_curScreen).innerHTML = o.responseText;
					break;
				case 'summary':
					VET_switchScreen('Summary');
					$G('VideoEmbedBack').style.display = 'none';
					$G('VideoEmbed' + VET_curScreen).innerHTML = o.responseText;

					if (VET_isOnSpecialPage) {
						var $responseHTML = $(o.responseText),
							vetData = {
								videoTitle: 'missing',
								videoWikiText: $responseHTML.find('#VideoEmbedTag').val()
							};
						$(window).trigger('VET_addFromSpecialPage', [vetData]);
						return false;
					}

					if ( !$G( 'VideoEmbedCreate'  ) && !$G( 'VideoEmbedReplace' ) ) {
						if(VET_refid == null) {
							if (typeof RTE !== 'undefined') {
								RTE.getInstanceEditor().getEditbox().focus();
							}
							if ( VET_placeholder == -1) {
								VET_getTextarea().focus();
								insertTags( $G('VideoEmbedTag').value, '', '', VET_getTextarea());
							} else if( VET_placeholder == -2 ) {
								// handle article view - replace video placeholders with video
								var placeholders = $('#WikiaArticle').find('.wikiaVideoPlaceholder a'),
									to_update = placeholders.filter('[data-id='+VET_box+']'),
									// get thumbnail code from hidden div in success modal
									html = $('#VideoEmbedCode').html();

								to_update.parent().parent().replaceWith(html);

								// update data id so we can match DOM placeholders to parsed wikitext placeholders
								placeholders.each(function() {
									var $this = $(this),
										id = $this.attr('data-id');

									if(id > VET_box) {
										$this.attr('data-id', id-1);
									}
								});

								// purge cache of article so video will show up on reload
								$.post(wgServer + wgScript + '?title=' + wgPageName  +'&action=purge');
							}
						} else { 
							var wikitag = YAHOO.util.Dom.get('VideoEmbedTag').value;
							var options = {};

							if($G('VideoEmbedThumbOption').checked) {
								options.thumb = 1;
							} else {
								options.thumb = null;
							}
							if($G('VideoEmbedLayoutLeft').checked) {
								options.align = 'left';
							} else if ($G('VideoEmbedLayoutCenter').checked) {
								options.align = 'center';
							} else {
								options.align = null;
							}
							options.caption = $G('VideoEmbedCaption').value;

							// macbre: CK support
							if (typeof window.VET_RTEVideo != 'undefined') {
								if (window.VET_RTEVideo && window.VET_RTEVideo.hasClass('media-placeholder')) {
									// replace "Add Video" placeholder
									RTE.mediaEditor.update(window.VET_RTEVideo, wikitag, options);
								}
								else {
									RTE.mediaEditor.addVideo(wikitag, options);
								}
							}
							else if(VET_refid != -1) {
								if( VET_placeholder != -1 ) {
									FCK.VideoGalleryUpdate( VET_refid, wikitag );
								} else { // placeholder
									FCK.VideoAdd(wikitag, options, VET_refid);
								}
							} else {
								FCK.VideoAdd(wikitag, options);
							}
						}
					} else {
						$G( 'VideoEmbedSuccess' ).style.display = 'none';
						$G( 'VideoEmbedTag' ).style.display = 'none';
						$G( 'VideoEmbedPageSuccess' ).style.display = 'block';
					}
					break;
				case 'existing':
					VET_displayDetails(o.responseText);
					break;
			}
			VET_indicator(1, false);
		},
		failure: function(o) {
			GlobalNotification.show( $.msg('vet-insert-error'), 'error', errorDiv, VET_notificationTimout );
		}
	}

	VET_indicator(1, true);
	YAHOO.util.Connect.abort(VET_asyncTransaction);
	VET_asyncTransaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=VET&method=insertFinalVideo&' + params.join('&'), callback);
}

function VET_switchScreen(to) {

	VET_prevScreen = VET_curScreen;
	VET_curScreen = to;
	$G('VideoEmbed' + VET_prevScreen).style.display = 'none';
	$G('VideoEmbed' + VET_curScreen).style.display = '';
	// this is called in both cases - when hitting 'back' and when closing the dialog.
	// in any case we want to stop the video
	$('#VideoEmbedThumb').children().remove();
	if(VET_curScreen == 'Main') {
		$G('VideoEmbedBack').style.display = 'none';
	}

	// macbre: move back button on Oasis
	if (window.skin == 'oasis') {
		setTimeout(function() {
			$().log(to, 'VET_switchScreen');

			switch(to) {
				case 'Details':
					VET_moveBackButton($('.VideoEmbedNoBorder.addVideoDetailsFormControls').find('input'));
					break;

				case 'Conflict':
					VET_moveBackButton($('#VideoEmbedConflictOverwriteButton'));
					break;
			}
		}, 50);
	}
}

function VET_back(e) {

	YAHOO.util.Event.preventDefault(e);

	if(VET_curScreen == 'Details') {
		VET_switchScreen('Main');
	} else if(VET_curScreen == 'Conflict' && VET_prevScreen == 'Details') {
		VET_switchScreen('Details');
	}
}

function VET_previewClose(e) {
	if(e) {
		YAHOO.util.Event.preventDefault(e);
	}

	VET_previewPanel.hide();
}

function VET_close(e) {
	var errorDiv = $('#VideoEmbedError');

	if(e) {
		YAHOO.util.Event.preventDefault(e);
	}
	
	errorDiv.hide();

	VET_panel.hide();
	if ( 400 == wgNamespaceNumber ) {
		if( $G( 'VideoEmbedPageWindow' ) ) {
			$G( 'VideoEmbedPageWindow' ).style.visibility = '';
		}
	}

	VET_switchScreen('Main');
	VET_loadMain();
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

function VET_tracking(action, label, value) {
	WikiaTracker.trackEvent(null, {
		ga_category: 'vet',
		ga_action: action,
		ga_label: label || ''
	}, 'internal');
}

function VET_sendQueryEmbed(query) {
	var errorDiv = $('#VideoEmbedError')
	var callback = {
		success: function(o) {
			var screenType = o.getResponseHeader['X-screen-type'];
			if(typeof screenType == "undefined") {
				screenType = o.getResponseHeader['X-Screen-Type'];
			}

			if( 'error' == YAHOO.lang.trim(screenType) ) {
				GlobalNotification.show( o.responseText, 'error', errorDiv, VET_notificationTimout );
			} else {
				// attach handlers - close preview on VET modal close (IE bug fix)
				VETExtended.cachedSelectors.closePreviewBtn.click();
				VET_displayDetails(o.responseText);
			}
			VET_indicator(1, false);
			
			
			
		}
	}
	VET_indicator(1, true);
	YAHOO.util.Connect.abort(VET_asyncTransaction);
	VET_asyncTransaction = YAHOO.util.Connect.asyncRequest('POST', wgScriptPath + '/index.php', callback, 'action=ajax&rs=VET&method=insertVideo&url=' + escape(query));
}

//***********************************************
//
// New Features to VET - suggestions, search, preview etc.
//
// author: Rafal Leszczynski, Jacek Jursza
//
//***********************************************

var VETExtended = {

	canFatch: true, // flag for blocking fetching if it's in progress or no more items to fetch
	
	// object for caching stuff for suggestions 
	suggestionsCachedStuff: {
		
		cashedSuggestions: [], 
		fetchedResoultsCount: 0
	},
	
	// object for caching stuff for search 
	searchCachedStuff: {
		
		inSearchMode: false,
		currentKeywords: '',
		fetchedResoultsCount: 0,
		searchType: 'premium'
	},
	
	track: function(action, label, data) {
		window.WikiaTracker.trackEvent('trackingevent', $.extend({
			ga_category: 'vet',
			ga_action: action,
			ga_label: label
		}, data || {}), 'internal');
	},

	init: function() {

		var that = this;
		
		// reset cached stuff on init if some old values preserved
		this.searchCachedStuff.currentKeywords = '';
		this.searchCachedStuff.inSearchMode = false;
		this.suggestionsCachedStuff.cashedSuggestions = [];
		this.suggestionsCachedStuff.fetchedResoultsCount = 0;
		
		// load mustache as deferred object and then make request for suggestions 
		$.when(
			$.loadMustache()
		).done($.proxy(this.fetchSuggestions, this));
		
		// cache selectors
		this.cachedSelectors = {
			carousel: $('#VET-suggestions'),
			carouselWrapper: $('#VET-carousel-wrapper'),
			suggestionsWrapper: $('#VET-suggestions-wrapper'),
			previewWrapper: $('#VET-preview'),
			videoWrapper: $('#VET-video-wrapper'),
			searchForm: $('#VET-search-form'),
			resultCaption: $('#VET-carousel-wrapper > p.results strong'),
			backToSuggestions: $('#VET-carousel-wrapper > a.back-link'),
			closePreviewBtn: $('#VET-preview-close'),
			positionOptions: $('#VideoEmbedLayoutRow'),
			searchDropDown: $('#VET-search-dropdown')
		};
		
		// set search type to local if premium disabled
		if (this.cachedSelectors.searchDropDown.attr('data-selected') === 'local') {
			this.searchCachedStuff.searchType = 'local';
		} else {
			this.searchCachedStuff.searchType = 'premium';
		}

		// attach handlers - add video button
		this.cachedSelectors.carousel.on('click', 'li > a', function(event) {
			event.preventDefault();
			VET_sendQueryEmbed($(this).attr('href'));
			
			// track event
			var label = that.carouselMode === 'search' ? 'add-video' : 'add-video-suggested';
			that.track(window.WikiaTracker.ACTIONS.CLICK, label);
		});

		// attach handlers - play button (open video preview)
		this.cachedSelectors.carousel.on('click', 'li a.video', function(event){
			event.preventDefault();
			var videoTitle = $("img", this).attr("data-video");
			that.fetchVideoPlayer(videoTitle);
			
			// remove in-preview class from previously check item if exists
			that.removeInPreview();
			
			// cache current in preview element in carousel
			that.cachedSelectors.inPreview = $(this).parents('li').addClass('in-preview');
		});
		
		// attach handlers - close preview
		this.cachedSelectors.previewWrapper.on('click', '#VET-preview-close', function(event) {
			event.preventDefault();	
			that.cachedSelectors.previewWrapper.stop().slideUp('slow', function() {
				that.cachedSelectors.videoWrapper.children().remove();
				that.removeInPreview();
			});	
		});
		
		// attach handlers - add video button from preview
		this.cachedSelectors.previewWrapper.on('click', '#VET-add-from-preview', function(event) {
			event.preventDefault();
			that.cachedSelectors.inPreview.children('a').click();
		});

		// attach handlers - back to suggestions
		this.cachedSelectors.backToSuggestions.on('click', function(e) {

            that.searchCachedStuff.inSearchMode = false;

            if(that.requestInProgress) {
                that.requestInProgress.abort();
            }
            that.searchCachedStuff.currentKeywords = '';
            that.cachedSelectors.backToSuggestions.removeClass('show');
            that.cachedSelectors.carousel.find('p').removeClass('show');
            that.updateResultCaption();
			that.cachedSelectors.closePreviewBtn.click();
            that.cachedSelectors.carousel.find('li').remove();
            that.addSuggestions({items: that.suggestionsCachedStuff.cashedSuggestions});
            if (that.cachedSelectors.carousel.resetPosition) that.cachedSelectors.carousel.resetPosition();

            that.isCarouselCheck();
		});

		// attach handlers - search
		this.cachedSelectors.searchForm.submit(function(event) {
			event.preventDefault();
			var keywords = $(this).find('#VET-search-field').val();
			if(keywords !== '' && that.searchCachedStuff.currentKeywords !== keywords) {

				// switch fetch more handler to fetch search mode; 
				that.searchCachedStuff.inSearchMode = true;
				
				// stop proccesing previous fetching request (exp. using search when still loading suggestions on init)
				if(that.requestInProgress) {
					that.requestInProgress.abort();
				}

				// reset cached properties for new search query
				that.searchCachedStuff.fetchedResoultsCount = 0;
				that.searchCachedStuff.currentKeywords = keywords;
				that.canFatch = true;
				
				// cleanup carousel if new search phrase
				that.cachedSelectors.closePreviewBtn.click();
				that.cachedSelectors.carousel.find('li').remove();
				that.cachedSelectors.carousel.find('p').removeClass('show');
				
				that.cachedSelectors.suggestionsWrapper.startThrobbing();
				
				that.fetchSearch();
				
				// tracking
				var label = that.searchCachedStuff.searchType === 'local' ? 'find-local' : 'find-wikia-library';
				that.track(window.WikiaTracker.ACTIONS.CLICK, label);
			}
		});
		
		// attach handlers - close preview on VET modal close (IE bug fix)
		$('#VideoEmbedClose').click(function(){
			that.cachedSelectors.closePreviewBtn.click();
		});
		
		// attach handlers - bottom close modal button
		$('#bottom-close-button').click(function(event){
			event.preventDefault();
			VET_close();
		});
		
		// attach handlers - selection border around position options in video display options tab
		$('#VideoEmbedDetails').on('click', '#VideoEmbedLayoutRow span, #VideoEmbedSizeRow span', function() {
			
			var parent = $(this).parent();
			parent.find('span').removeClass('selected');
			$(this).addClass('selected');
			
			// show/hide caption input for "Style" option
			if ($(this).is('#VET_StyleThumb')) {
				parent.children('p').removeClass('show');
				parent.children('input').addClass('show');
			} else {
				parent.children('input').removeClass('show');
				parent.children('p').addClass('show');
			}
		});
		
		// attach handler - submit display options tab
		$('#VideoEmbedDetails').on('submit', '#VET-display-options', function(event) {
			event.preventDefault();
			VET_insertFinalVideo(event, 'details');
		});
		$('#VideoEmbedDetails').on('submit', '#VET-display-options-update', function(event) {
			event.preventDefault();
			VET_doEditVideo();
		});
		 
		
		// create dropdown for search filters
		this.cachedSelectors.searchDropDown.wikiaDropdown({
			onChange: function(e, $target) {
				var currSort = this.$selectedItemsList.text(),
					newSort = $target.text();

				if(currSort != newSort) {
					var sort = $target.data('sort');
					that.searchCachedStuff.searchType = sort;
					that.searchCachedStuff.currentKeywords = '';
					that.cachedSelectors.closePreviewBtn.click();
					$('#VET-search-submit').click();
				}
			}
		});
		
	},
	
	// METHOD: Remove selected state from in-preview thumbnail
	removeInPreview: function() {
	
		if (this.cachedSelectors.inPreview) {
			this.cachedSelectors.inPreview.removeClass('in-preview');
		}
		
	},

	// METHOD: Trim titles
	trimTitles: function(data) {
	
		var item;
		
		// trim video titles to two lines
		for ( var i in data.items ) {
			item = data.items[i];
			if (item.title) {
				item.trimTitle = item.title.substr(0, 35);
				if ( item.trimTitle.length < item.title.length ) {
					item.trimTitle += "...";
				}
			}
		}
		
	},
	
	// METHOD: add items to carousel
	addSuggestions: function(data) {
		
		var html,
			template = '{{#items}}<li><figure>{{{thumbnail}}}<figcaption><strong>{{trimTitle}}</strong></figcaption></figure><a href="{{url}}" title="{{title}}">Add video</a></li>{{/items}}';
		
		html = $.mustache(template, data);
		this.cachedSelectors.carousel.find('ul').append(html);
		
	},
	
	// METHOD: create carousel instance
	createCarousel: function() {
	
		var that = this,
			itemsShown = 5; // items displayed per carousel slide
		
		// show carousel if suggestions returned
		this.cachedSelectors.carouselWrapper.addClass('show');
		
		// create carousel instance
		this.carouselInstance = this.cachedSelectors.carousel.carousel({
			transitionSpeed: 500,
			itemsShown: itemsShown,
			nextClass: "scrollright",
			prevClass: "scrollleft",
			trackProgress: function(indexStart, indexEnd, totalItems) {
				if (itemsShown * 2 > totalItems - indexEnd) {
					// depends on fetch mode send request to different controller
					if (!that.searchCachedStuff.inSearchMode) {
						that.fetchSuggestions();
					} else {
						that.fetchSearch();
					}	
				}
			}
		});
		
	},
	
	// METHOD: Update carousel after adding new items
	updateCarousel: function() {
		this.carouselInstance.updateCarouselItems();
		this.carouselInstance.updateCarouselWidth();
		this.carouselInstance.updateCarouselArrows();
	},
	
	// METHOD: update carousel after adding new items or create one if not already created
	isCarouselCheck: function() {
	
		if (this.cachedSelectors.carouselWrapper.hasClass('show')) {
			this.updateCarousel();
		} else {
			this.createCarousel();	
		}
		
	},
	

	// METHOD: show preview of the selected video
	showVideoPreview: function(data) {
		var previewWrapper = this.cachedSelectors.previewWrapper,
			videoWrapper = this.cachedSelectors.videoWrapper;
		if ( data.playerAsset && data.playerAsset.length > 0 ) { // screenplay special case
			$.getScript(data.playerAsset, function() {
				videoWrapper.html( '<div id="'+data.videoEmbedCode.id+'" class="Wikia-video-enabledEmbedCode"></div>');
				$('body').append('<script>' + data.videoEmbedCode.script + ' loadJWPlayer(); </script>');
			});
		} else {
			videoWrapper.html('<div class="Wikia-video-enabledEmbedCode">'+data.videoEmbedCode+'</div>');
		}
		
		// expand preview is hidden
		if (!previewWrapper.is(':visible')) {
			previewWrapper.stop().slideDown('slow');
		}
		
	},
	
	// METHOD: fech player embed code
	fetchVideoPlayer: function(title) {
		
		var that = this;

		$.nirvana.sendRequest({
			controller: 'VideoEmbedToolController',
			method: 'getEmbedCode',
			type: 'get',
			data: {
				fileTitle: title
			},
			callback: function(data) {
				that.showVideoPreview(data);
				
				// video play tracking
				window.WikiaTracker.trackEvent('trackingevent', {
					ga_category: 'Lightbox',	// yeah, Lightbox so we can roll up all the data
					ga_action: window.WikiaTracker.ACTIONS.VIEW,
					ga_label: 'video-inline',
					title: title,
					provider: data.providerName,
					clickSource: (that.carouselMode === 'suggestion' ? 'VET-Suggestion' : 'VET-Search')
				}, 'internal');
			}
		});

	},

	// METHOD: update caption
	updateResultCaption: function( txt ) {
	      if (!this.cachedResultCaption) this.cachedResultCaption = this.cachedSelectors.resultCaption.text();
	      if ( txt ) this.cachedSelectors.resultCaption.text( txt );
	      else this.cachedSelectors.resultCaption.text( this.cachedResultCaption );
	},

	// METHOD: fetch part of suggestions
	fetchSuggestions: function() {
	
		var that = this,
			svStart = this.suggestionsCachedStuff.fetchedResoultsCount, // index - start fetching from item number... 
			svSize = 20; // number of requested items
			
		if (this.canFatch === true) {
			this.canFatch = false; // fetching in progress
			
			this.carouselMode = 'suggestion';
		
			this.requestInProgress = $.nirvana.sendRequest({
				controller: 'VideoEmbedToolController',
				method: 'getSuggestedVideos',
				type: 'get',
				data: {
					svStart: svStart,  
					svSize: svSize, 
					articleId: wgArticleId	
				},
				callback: function(data) {
					var i,
						items = data.items,
						length = items.length;
					
					if (length > 0) {
						
						that.trimTitles(data);
						that.addSuggestions(data);
						
						// update results counter
						that.suggestionsCachedStuff.fetchedResoultsCount = data.nextStartFrom;
						
						// cache fetched items
						for (i = 0; i < length; i += 1) {
							that.suggestionsCachedStuff.cashedSuggestions.push(items[i]);
						}
						
						that.isCarouselCheck();
						that.canFatch = true;
					} 
				}
			});
		}
		
	},
				
	// METHOD: fetch part of search results
	fetchSearch: function() {
		
		var that = this,
			svStart = this.searchCachedStuff.fetchedResoultsCount,
			svSize = 20; // number of requested items
			phrase = this.searchCachedStuff.currentKeywords;
			
		if (this.canFatch === true) {
			this.canFatch = false; // fetching in progress
			
			this.carouselMode = 'search';
		
			this.requestInProgress = $.nirvana.sendRequest({
				controller: 'VideoEmbedToolController',
				method: 'search',
				type: 'get',
				data: {
					svStart: svStart,
					svSize: svSize,
					phrase: phrase,
					type: that.searchCachedStuff.searchType
				},
				callback: function(data) {
					
					var i,
						items = data.items,
						length = items.length;
					
					// show results count
					that.updateResultCaption( data.caption );
										
					if (length > 0) {
						
						// update results counter
						that.searchCachedStuff.fetchedResoultsCount = data.nextStartFrom;
						
						that.trimTitles(data);
						that.addSuggestions(data);
						
						// reset carousel container to the first slide position
						if (svStart === 0) {
							if (that.cachedSelectors.carousel.resetPosition) that.cachedSelectors.carousel.resetPosition();
						}
						
					} else if (that.searchCachedStuff.fetchedResoultsCount === 0) {
						// show no results found for new search with not results returned from controller
						that.cachedSelectors.carousel.find('p').addClass('show');	
					}

					if (that.suggestionsCachedStuff.cashedSuggestions.length > 0)
						that.cachedSelectors.backToSuggestions.addClass('show');
					
					that.isCarouselCheck();						
					that.canFatch = true;
					that.cachedSelectors.suggestionsWrapper.stopThrobbing();
					
				}
			});
		}
		
	}
	
};
