/*
 * Author: Inez Korczynski, Bartek Lapinski
 */

/*
 * Variables
 */

var VET_panel = null;
var VET_curSourceId = 0;
var VET_lastQuery = new Array;
var VET_asyncTransaction = null;
var VET_curScreen = 'Main';
var VET_prevScreen = null;
var VET_slider = null;
var VET_thumbSize = null;
var VET_orgThumbSize = null;
var VET_gallery = -1;
var VET_box = -1;
var VET_width = null;
var VET_height = null;
var VET_widthChanges = 1;
var VET_refid = null;
var VET_wysiwygStart = 1;
var VET_ratio = 1;
var VET_shownMax = false;
var VET_inGalleryPosition = false;

function VET_loadDetails() {
	YAHOO.util.Dom.setStyle('VideoEmbedMain', 'display', 'none');
	VET_indicator(1, true);

	var callback = {
		success: function(o) {
			VET_displayDetails(o.responseText);

			$('VideoEmbedBack').style.display = 'none';

			setTimeout(function() {
				if(!FCK.wysiwygData[VET_refid].thumb) {
					$('VideoEmbedFullOption').click();
				}
				if(FCK.wysiwygData[VET_refid].align && FCK.wysiwygData[VET_refid].align == 'left') {
					$('VideoEmbedLayoutLeft').click();
				}
				if(FCK.wysiwygData[VET_refid].width) {
					VET_slider.setValue(FCK.wysiwygData[VET_refid].width / (VET_slider.getRealValue() / VET_slider.getValue()), true);
					VET_width = FCK.wysiwygData[VET_refid].width;
					VET_imageWidthChanged( VET_width );
					$( 'VideoEmbedSlider' ).style.visibility = 'visible';
					$( 'VideoEmbedInputWidth' ).style.visibility = 'visible';
					$( 'VideoEmbedWidthCheckbox' ).checked = true;
					$( 'VideoEmbedManualWidth' ).value = VET_width;
				}
			}, 200);

			if(FCK.wysiwygData[VET_refid].caption) {
				$('VideoEmbedCaption').value = FCK.wysiwygData[VET_refid].caption;
			}
			if( ( '-1' != VET_gallery ) || VET_inGalleryPosition ) {
				$( 'VideoEmbedSlider' ).style.visibility = 'hidden';
				$( 'VideoEmbedInputWidth' ).style.visibility = 'hidden';
				$( 'VideoEmbedWidthCheckbox' ).style.visibility = 'hidden';
				$( 'VideoEmbedManualWidth' ).style.visibility = 'hidden';
			}
		}
	}

	YAHOO.util.Connect.abort(VET_asyncTransaction)

	var params = Array();
	params.push('sourceId=0');
	params.push('itemId='+FCK.wysiwygData[VET_refid].href.split(":")[1]);

	VET_asyncTransaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=VET&method=chooseImage&' + params.join('&'), callback);
}

/*
 * Functions/methods
 */
if(mwCustomEditButtons) {
	if( '-1' == VET_gallery ) {
		mwCustomEditButtons[mwCustomEditButtons.length] = {
			"imageFile": stylepath + '/../extensions/wikia/VideoEmbedTool/images/button_vet2.png',
			"speedTip": vet_imagebutton,
			"tagOpen": "",
			"tagClose": "",
			"sampleText": "",
			"imageId": "mw-editbutton-vet"};
	}
}

if(skin == 'monaco') {
	addOnloadHook(function () {
		if(document.forms.editform) {
			VET_addHandler();
		} else if ( $( 'VideoEmbedCreate' ) && ( 400 == wgNamespaceNumber ) ) {
			VET_addCreateHandler();
		} else if ( $( 'VideoEmbedReplace' ) && ( 400 == wgNamespaceNumber ) ) {
			VET_addReplaceHandler();
		}
	});
}

function VET_addCreateHandler() {
	var btn = $( 'VideoEmbedCreate' );
  	YAHOO.util.Event.addListener(['vetLink', 'vetHelpLink', btn], 'click',  VET_showReplace);
}

function VET_addReplaceHandler() {
	var btn = $( 'VideoEmbedReplace' );
  	YAHOO.util.Event.addListener(['vetLink', 'vetHelpLink', btn], 'click',  VET_showReplace);
}

function VET_showReplace(e) {
	YAHOO.util.Event.preventDefault(e);
	VET_show(e);
}

function VET_addHandler() {
	var btn = $('mw-editbutton-vet');
	if(btn == null) {
 		setTimeout('VET_addHandler()', 250);
  		return;
  	}
  	YAHOO.util.Event.addListener(['vetLink', 'vetHelpLink', btn], 'click',  VET_show);
}

function VET_toggleSizing( enable ) {
	if( enable ) {
		$( 'VideoEmbedThumbOption' ).disabled = false;
	} else {
		$( 'VideoEmbedThumbOption' ).disabled = true;
	}
}

function VET_manualWidthInput( elem ) {
        var val = parseInt( elem.value );
        if ( isNaN( val ) ) {
		$( 'VideoEmbedManualWidth' ).value = 300;
		VET_readjustSlider( 300 );
		return false;
        }
	$( 'VideoEmbedManualWidth' ).value = val;
	VET_readjustSlider( val );
}


function VET_readjustSlider( value ) {
		if ( 500 < value ) { // too big, hide slider
			if ( 'hidden' != $( 'VideoEmbedSliderThumb' ).style.visibility ) {
				$( 'VideoEmbedSliderThumb' ).style.visibility = 'hidden';
				VET_slider.setValue( 200, true, true, true );
			}
		} else {
			if ( 'hidden' == $( 'VideoEmbedSliderThumb' ).style.visibility ) {
				$( 'VideoEmbedSliderThumb' ).style.visibility = 'visible';
			}

			var fixed_width = value - 98;
			value = Math.max(2, Math.round( ( fixed_width * 200 ) / 400 ) );
			VET_slider.setValue( value, true, true, true );
		}
}

function VET_showPreview(e) {
	YAHOO.util.Dom.setStyle('header_ad', 'display', 'none');

	var html = '';
	html += '<div class="reset" id="VideoEmbedPreview">';
	html += '	<div id="VideoEmbedBorder"></div>';
	html += '	<div id="VideoEmbedPreviewClose"><div></div><a href="#">' + vet_close + '</a></div>';
	html += '	<div id="VideoEmbedPreviewBody">';
	html += '		<div id="VideoEmbedPreviewContent" style="display: none;"></div>';
	html += '	</div>';
	html += '</div>';

	var element = document.createElement('div');
	element.id = 'VET_previewDiv';
	element.style.width = '600px';
	element.style.height = '500px';
	element.innerHTML = html;

	document.body.appendChild(element);

	VET_previewPanel = new YAHOO.widget.Panel('VET_previewDiv', {
		modal: true,
		constraintoviewport: true,
		draggable: false,
		close: false,
		fixedcenter: true,
		underlay: "none",
		visible: false,
		zIndex: 1600
	});
	VET_previewPanel.render();
	VET_previewPanel.show();
	if(VET_refid != null && VET_wysiwygStart == 2) {
		VET_loadDetails();
	} else {
		VET_loadMain();
	}

	YAHOO.util.Event.addListener('VideoEmbedPreviewClose', 'click', VET_previewClose);
}

function VET_getCaret() {
  var control = document.getElementById('wpTextbox1');
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

function VET_inGallery() {
	var originalCaretPosition = VET_getCaret();
	var originalText = document.getElementById('wpTextbox1').value;
	var lastIndexOfvideogallery = originalText.substring(0, originalCaretPosition).lastIndexOf('<videogallery>');

	if(lastIndexOfvideogallery > 0) {
	  var indexOfvideogallery = originalText.substring(originalCaretPosition).indexOf('</videogallery>');
	  if(indexOfvideogallery > 0) {
	    var textInTag = originalText.substring(lastIndexOfvideogallery + 15, indexOfvideogallery + originalCaretPosition);
	    if(textInTag.indexOf('<') == -1 && textInTag.indexOf('>') == -1) {
		    return textInTag.lastIndexOf("\n") + lastIndexOfvideogallery + 15;
	    }
	  }
	}
	return false;
}

function VET_show(e, gallery, box) {
	VET_refid = null;
	VET_wysiwygStart = 1;

	if(typeof gallery != "undefined") {
		VET_gallery = gallery;
		VET_box = box;
	}

	if(YAHOO.lang.isNumber(e)) {
		VET_refid = e;
		if(VET_refid == -1) {
			VET_track('open/fromWysiwyg/new');
			// go to main page
		} else {
			VET_track('open/fromWysiwyg/existing');
			if(FCK.wysiwygData[VET_refid].exists) {
				// go to details page
				VET_wysiwygStart = 2;
			} else {
				// go to main page
			}
		}
	} else {
		var el = YAHOO.util.Event.getTarget(e);
		if (el.id == 'vetLink') {
			VET_track('open/fromLinkAboveToolbar'); //tracking
		} else if (el.id == 'vetHelpLink') {
			VET_track('open/fromEditTips'); //tracking
		} else if (el.id == 'mw-editbutton-vet') {
			VET_inGalleryPosition = VET_inGallery();
			VET_track('open/fromToolbar'); //tracking
		} else {
			VET_track('open');
		}
	}

	YAHOO.util.Dom.setStyle('header_ad', 'display', 'none');
	if(VET_panel != null) {
		if ( 400 == wgNamespaceNumber ) {
			if( $( 'VideoEmbedPageWindow' ) ) {
				$( 'VideoEmbedPageWindow' ).style.visibility = 'hidden';
			}
		}

		VET_panel.show();
		if(VET_refid != null && VET_wysiwygStart == 2) {
			VET_loadDetails();
		} else {
			if($('VideoQuery')) $('VideoQuery').focus();
		}
		return;
	}

	var html = '';
	html += '<div class="reset" id="VideoEmbed">';
	html += '	<div id="VideoEmbedBorder"></div>';
	html += '	<div id="VideoEmbedProgress1" class="VideoEmbedProgress"></div>';
	html += '	<div id="VideoEmbedBack"><div></div><a href="#">' + vet_back + '</a></div>';
	html += '	<div id="VideoEmbedClose"><div></div><a href="#">' + vet_close + '</a></div>';
	html += '	<div id="VideoEmbedBody">';
	html += '		<div id="VideoEmbedError"></div>';
	html += '		<div id="VideoEmbedMain"></div>';
	html += '		<div id="VideoEmbedDetails" style="display: none;"></div>';
	html += '		<div id="VideoEmbedConflict" style="display: none;"></div>';
	html += '		<div id="VideoEmbedSummary" style="display: none;"></div>';
	html += '	</div>';
	html += '</div>';

	var element = document.createElement('div');
	element.id = 'VET_div';
	element.style.width = '812px';
	element.style.height = '587px';
	element.innerHTML = html;

	document.body.appendChild(element);

	VET_panel = new YAHOO.widget.Panel('VET_div', {
		modal: true,
		constraintoviewport: true,
		draggable: false,
		close: false,
		fixedcenter: true,
		underlay: "none",
		visible: false,
		zIndex: 1500
	});
	VET_panel.render();
	VET_panel.show();
	if(VET_refid != null && VET_wysiwygStart == 2) {
		VET_loadDetails();
	} else {
		VET_loadMain();
	}

	YAHOO.util.Event.addListener('VideoEmbedBack', 'click', VET_back);
	YAHOO.util.Event.addListener('VideoEmbedClose', 'click', VET_close);

	if ( 400 == wgNamespaceNumber ) {
		if( $( 'VideoEmbedPageWindow' ) ) {
			$( 'VideoEmbedPageWindow' ).style.visibility = 'hidden';
		}
	}
}

function VET_loadMain() {
	var callback = {
		success: function(o) {
			$('VideoEmbedMain').innerHTML = o.responseText;
			VET_indicator(1, false);
			if($('VideoQuery') && VET_panel.element.style.visibility == 'visible') $('VideoQuery').focus();
		}
	}
	VET_indicator(1, true);
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=VET&method=loadMain', callback);
	VET_curSourceId = 0;
}

function VET_recentlyUploaded(param, pagination) {
	if(pagination) {
		VET_track('pagination/' + pagination + '/src-recent'); // tracking
	}
	var callback = {
		success: function(o) {
			$('VET_results_0').innerHTML = o.responseText;
			VET_indicator(1, false);
		}
	}
	VET_indicator(1, true);
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=VET&method=recentlyUploaded&'+param, callback);
}

function VET_changeSource(e) {
	var el = YAHOO.util.Event.getTarget(e);
	if(el.nodeName == 'A') {
		var sourceId = el.id.substring(11);
		if(VET_curSourceId != sourceId) {
			$('VET_source_' + VET_curSourceId).style.fontWeight = '';
			$('VET_source_' + sourceId).style.fontWeight = 'bold';

			$('VET_results_' + VET_curSourceId).style.display = 'none';
			$('VET_results_' + sourceId).style.display = '';

			VET_track('changeSource/src-'+sourceId); // tracking

			if($('VideoQuery')) $('VideoQuery').focus();

			VET_curSourceId = sourceId;
			VET_trySendQuery();
		}
	}
}

function VET_trySendQuery(e) {
	if(e && e.type == "keydown") {
		if(e.keyCode != 13) {
			return;
		}
		VET_track('find/enter/' + $('VideoQuery').value); // tracking
	} else if(e) {
		VET_track('find/click/' + $('VideoQuery').value); // tracking
	}

	var query = $('VideoQuery').value;

	if(!e && VET_lastQuery[VET_curSourceId] == query) {
		return;
	}

	if(query == '') {
		if(e) {
			alert(vet_warn1);
		}
	} else {
		VET_sendQuery(query, 1, VET_curSourceId);
	}
}

function VET_sendQuery(query, page, sourceId, pagination) {
	if(pagination) {
		VET_track('pagination/' + pagination + '/src-' + sourceId); // tracking
	}
	var callback = {
		success: function(o) {
			$('VET_results_' + o.argument[0]).innerHTML = o.responseText;
			VET_indicator(1, false);
		},
		argument: [sourceId]
	}
	VET_lastQuery[sourceId] = query;
	VET_indicator(1, true);
	YAHOO.util.Connect.abort(VET_asyncTransaction)
	VET_asyncTransaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=VET&method=query&' + 'query=' + query + '&page=' + page + '&sourceId=' + sourceId, callback);
}

function VET_indicator(id, show) {
	if(show) {
		if(id == 1) {
			$('VideoEmbedProgress1').style.display = 'block';
		} else if(id == 2) {
			$('VideoEmbedProgress2').style.visibility = 'visible';
		}
	} else {
		if(id == 1) {
			$('VideoEmbedProgress1').style.display = '';
		} else if(id == 2) {
			$('VideoEmbedProgress2').style.visibility = 'hidden';
		}
	}
}

function VET_chooseImage(sourceId, itemId, itemLink, itemTitle) {
	VET_track('insertVideo/choose/src-' + sourceId); // tracking

	var callback = {
		success: function(o) {
			VET_displayDetails(o.responseText);
		}
	}
	VET_indicator(1, true);
	YAHOO.util.Connect.abort(VET_asyncTransaction)
	VET_asyncTransaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=VET&method=chooseImage&' + 'sourceId=' + sourceId + '&itemId=' + itemId + '&itemLink=' + itemLink + '&itemTitle=' + itemTitle, callback);
}

function VET_upload(e) {
	if($('VideoEmbedUrl').value == '') {
		VET_track('insert/undefined'); // tracking
		alert(vet_warn2);
		return false;
	} else {
		var query = $('VideoEmbedUrl').value;

		if ( !( query.match( 'http://' ) || query.match( 'www.' ) ) ) {
			VET_sendQuery(query, 1, VET_curSourceId);
			return false;
		} else {
			VET_track('insert/defined'); // tracking
			VET_indicator(1, true);
			return true;
		}
	}
}

function VET_displayDetails(responseText) {
	VET_switchScreen('Details');
	VET_width = null;
	$('VideoEmbedBack').style.display = 'inline';

	$('VideoEmbed' + VET_curScreen).innerHTML = responseText;

	if($('VideoEmbedThumb')) {
		VET_orgThumbSize = null;
		var image = $('VideoEmbedThumb').firstChild;
		var thumbSize = [image.width, image.height];
		VET_orgThumbSize = null;
	}

                VET_slider = YAHOO.widget.Slider.getHorizSlider('VideoEmbedSlider', 'VideoEmbedSliderThumb', 0, 201);
                VET_slider.initialRound = true;
                VET_slider.getRealValue = function() {
                        return ( Math.max( 2, Math.round( this.getValue() * 2 ) ) + 98 );
                }
                VET_slider.subscribe("change", function(offsetFromStart) {
                        if (VET_slider.initialRound) {
                                $('VideoEmbedManualWidth').value = 300;
                                VET_slider.initialRound = false;
                        } else {
                                $('VideoEmbedManualWidth').value = VET_slider.getRealValue();
                        }
                });

                VET_slider.setValue(100, true);

	if ($( 'VET_error_box' )) {
		alert( $( 'VET_error_box' ).innerHTML );
	}

	if ( ( '-1' != VET_gallery ) || VET_inGalleryPosition ) {
		$( 'ImageWidthRow' ).style.visibility = 'hidden';
		$( 'ImageLayoutRow' ).style.display = 'none';
		$( 'VideoEmbedThumbOption' ).style.visibility = 'hidden';
	}

	if ( ( 400 == wgNamespaceNumber ) ) {
		if( $( 'VideoEmbedName' ) ) {
			$( 'VideoEmbedName' ).value = wgTitle;
			$( 'VideoEmbedNameRow' ).style.display = 'none';
		}
	}

	VET_indicator(1, false);
}

function VET_insertFinalVideo(e, type) {
	VET_track('insertVideo/' + type); // tracking

	YAHOO.util.Event.preventDefault(e);

	var params = Array();
	params.push('type='+type);

	if(!$('VideoEmbedName')) {
		if ($( 'VideoEmbedOname' ) ) {
			if ('' == $( 'VideoEmbedOname' ).value)	 {
				alert( vet_warn3 );
				return false;
			}
		} else {
			alert( vet_warn3 );
			return false;
		}
	} else if ('' == $( 'VideoEmbedName' ).value ) {
		alert( vet_warn3 );
		return false;
	}

	params.push('id='+$('VideoEmbedId').value);
	params.push('provider='+$('VideoEmbedProvider').value);

	if( $( 'VideoEmbedMetadata' ) ) {
		var metadata = Array();
		metadata = $( 'VideoEmbedMetadata' ).value.split( "," );
		for( var i=0; i < metadata.length; i++ ) {
			params.push( 'metadata' + i  + '=' + metadata[i] );
		}
	}

	if( VET_inGalleryPosition ) {
		params.push( 'mwgalpos=' + VET_inGalleryPosition );
	}

	if( '-1' != VET_gallery ) {
		params.push( 'gallery=' + VET_gallery );
		params.push( 'box=' + VET_box );
		params.push( 'article='+encodeURIComponent( wgTitle ) );
		params.push( 'ns='+wgNamespaceNumber );
		if( VET_refid != null ) {
			params.push( 'fck=true' );
		}
	}

	params.push('oname='+encodeURIComponent( $('VideoEmbedOname').value ) );

	if(type == 'overwrite') {
		params.push('name='+encodeURIComponent( $('VideoEmbedExistingName').value ) );
	} else if(type == 'rename') {
		params.push('name='+encodeURIComponent( $('VideoEmbedRenameName').value ) );
	} else {
		if ($( 'VideoEmbedName' )) {
			params.push('name='+encodeURIComponent( $('VideoEmbedName').value) );
		}
	}

	if($('VideoEmbedThumb')) {
		params.push('size=' + ($('VideoEmbedThumbOption').checked ? 'thumb' : 'full'));
		params.push( 'width=' + $( 'VideoEmbedManualWidth' ).value + 'px' );
		if( $('VideoEmbedLayoutLeft').checked ) {
			params.push( 'layout=left' );
		} else if( $('VideoEmbedLayoutGallery').checked ) {
			params.push( 'layout=gallery' );
		} else {
			params.push( 'layout=right' );
		}
		params.push('caption=' + encodeURIComponent( $('VideoEmbedCaption').value ) );
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
					VET_switchScreen('Conflict');
					$('VideoEmbed' + VET_curScreen).innerHTML = o.responseText;
					break;
				case 'summary':
					VET_switchScreen('Summary');
					$('VideoEmbedBack').style.display = 'none';
					$('VideoEmbed' + VET_curScreen).innerHTML = o.responseText;
					if ( !$( 'VideoEmbedCreate'  ) && !$( 'VideoEmbedReplace' ) ) {
						if(VET_refid == null) {
							if ('-1' == VET_gallery) {
								if (!VET_inGalleryPosition) { 
									insertTags($('VideoEmbedTag').innerHTML, '', '');
								} else {
									var txtarea = $( 'wpTextbox1' );	
									txtarea.value = txtarea.value.substring(0, VET_inGalleryPosition)
						                        + $( 'VideoEmbedTag' ).innerHTML
						                        + txtarea.value.substring(VET_inGalleryPosition + 1, txtarea.value.length);
								}
							} else {
								if( $( 'WikiaVideoGalleryPlaceholder' + VET_gallery + 'x' + VET_box ) ) {
									var to_update = $( 'WikiaVideoGalleryPlaceholder' + VET_gallery + 'x' + VET_box );
									to_update.parentNode.innerHTML = $('VideoEmbedCode').innerHTML;
									YAHOO.util.Connect.asyncRequest('POST', wgServer + wgScript + '?title=' + wgPageName  +'&action=purge');
								}
							}
						} else {
							var wikitag = YAHOO.util.Dom.get('VideoEmbedTag').innerHTML;
							var options = {};

							if($('VideoEmbedThumbOption').checked) {
								options.thumb = 1;
							} else {
								options.thumb = null;
							}
							if($('VideoEmbedLayoutLeft').checked) {
								options.align = 'left';
							} else {
								options.align = null;
							}
							options.caption = $('VideoEmbedCaption').value;

							if(VET_refid != -1) {
								FCK.VideoGalleryUpdate( VET_refid, wikitag );
							} else {
								FCK.VideoAdd(wikitag, options);
							}
						}
					} else {
						$( 'VideoEmbedSuccess' ).style.display = 'none';
						$( 'VideoEmbedTag' ).style.display = 'none';
						$( 'VideoEmbedPageSuccess' ).style.display = 'block';
					}
					break;
				case 'existing':
					VET_displayDetails(o.responseText);
					break;
			}
			VET_indicator(1, false);
		}
	}

	VET_indicator(1, true);
	YAHOO.util.Connect.abort(VET_asyncTransaction);
	VET_asyncTransaction = YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=VET&method=insertFinalVideo&' + params.join('&'), callback);
}

function VET_imageWidthChanged(changes) {
	var image = $('VideoEmbedThumb').firstChild;
	if( !$( 'VideoEmbedWidthCheckbox' ).checked ) {
		$('VideoEmbedManualWidth').value = '';
		image.width = VET_orgThumbSize[0];
		image.height = VET_orgThumbSize[1];
		VET_track('slider/disable'); // tracking
	} else {
		$('VideoEmbedManualWidth').value = VET_slider.getRealValue();
		image.width = VET_thumbSize[0];
		image.height = VET_thumbSize[1];
		VET_track('slider/enable'); // tracking
	}
}

function VET_switchScreen(to) {
	VET_prevScreen = VET_curScreen;
	VET_curScreen = to;
	$('VideoEmbed' + VET_prevScreen).style.display = 'none';
	$('VideoEmbed' + VET_curScreen).style.display = '';
	if(VET_curScreen == 'Main') {
		$('VideoEmbedBack').style.display = 'none';
	}
}

function VET_back(e) {
	YAHOO.util.Event.preventDefault(e);
	VET_track('back/' + VET_curScreen);
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
	VET_track('closePreview/' + VET_curScreen);
	VET_previewPanel.hide();
}

function VET_close(e) {
	if(e) {
		YAHOO.util.Event.preventDefault(e);
	}
	VET_track('close/' + VET_curScreen);
	VET_panel.hide();
	if ( 400 == wgNamespaceNumber ) {
		if( $( 'VideoEmbedPageWindow' ) ) {
			$( 'VideoEmbedPageWindow' ).style.visibility = '';
		}
	}
	if(typeof FCK == 'undefined' && $('wpTextbox1')) $('wpTextbox1').focus();
	VET_switchScreen('Main');
	VET_loadMain();
	YAHOO.util.Dom.setStyle('header_ad', 'display', 'block');
}

function VET_track(str) {
	YAHOO.Wikia.Tracker.track('VET/' + str);
}

var VET_uploadCallback = {
	onComplete: function(response) {
		VET_displayDetails(response);
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
