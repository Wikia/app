/*
 * Author: Inez Korczynski
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

function WMU_loadDetails() {
	YAHOO.util.Dom.setStyle('ImageUploadMain', 'display', 'none');
	WMU_indicator(1, true);

	var callback = {
		success: function(o) {
			WMU_displayDetails(o.responseText);

			$('ImageUploadBack').style.display = 'none';

			setTimeout(function() {
				if(!FCK.wysiwygData[WMU_refid].thumb) {
					$('ImageUploadFullOption').click();
				}
				if(FCK.wysiwygData[WMU_refid].align && FCK.wysiwygData[WMU_refid].align == 'left') {
					$('ImageUploadLayoutLeft').click();
				}
				if(FCK.wysiwygData[WMU_refid].width) {
					WMU_slider.setValue(FCK.wysiwygData[WMU_refid].width / (WMU_slider.getRealValue() / WMU_slider.getValue()), true);
					WMU_width = FCK.wysiwygData[WMU_refid].width;
					MWU_imageWidthChanged( WMU_width );
					$( 'ImageUploadSlider' ).style.visibility = 'visible';
					$( 'ImageUploadInputWidth' ).style.visibility = 'visible';
					$( 'ImageUploadWidthCheckbox' ).checked = true;
					$( 'ImageUploadManualWidth' ).value = WMU_width;
					WMU_manualWidthInput( $( 'ImageUploadManualWidth' ) );
				}
			}, 200);

			if(FCK.wysiwygData[WMU_refid].caption) {
				$('ImageUploadCaption').value = FCK.wysiwygData[WMU_refid].caption;
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
	mwCustomEditButtons[mwCustomEditButtons.length] = {
		"imageFile": stylepath + '/../extensions/wikia/WikiaMiniUpload/images/button_wmu.png',
		"speedTip": wmu_imagebutton,
		"tagOpen": "",
		"tagClose": "",
		"sampleText": "",
		"imageId": "mw-editbutton-wmu"};
}

if(skin == 'monaco') {
	addOnloadHook(function () {
		if(document.forms.editform) {
			WMU_addHandler();
		}
	});
}

function WMU_addHandler() {
	var btn = $('mw-editbutton-wmu');
	if(btn == null) {
		setTimeout('WMU_addHandler()', 250);
		return;
	}
	YAHOO.util.Event.addListener(['wmuLink', 'wmuHelpLink', btn], 'click',  WMU_show);
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
	var image = $( 'ImageUploadThumb' ).firstChild;
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
			$( 'ImageUploadManualWidth' ).value = image.width;
			WMU_readjustSlider( image.width );
			WMU_shownMax = true;
			alert (wmu_max_thumb);
		}
	} else {
		image.height = val / WMU_ratio;
		image.width = val;
		WMU_thumbSize = [image.width, image.height];
		$( 'ImageUploadManualWidth' ).value = val;
		WMU_readjustSlider( val );
		WMU_shownMax = false;
	}
}

function WMU_readjustSlider( value ) {
	if ( 400 < value ) { // too big, hide slider
		if ( 'hidden' != $( 'ImageUploadSliderThumb' ).style.visibility ) {
			$( 'ImageUploadSliderThumb' ).style.visibility = 'hidden';
			WMU_slider.setValue( 200, true, true, true );
		}
	} else {
		if ( 'hidden' == $( 'ImageUploadSliderThumb' ).style.visibility ) {
			$( 'ImageUploadSliderThumb' ).style.visibility = 'visible';
		}
		var fixed_width = Math.min( 400, WMU_width );
		value = Math.max(2, Math.round( ( value * 200 ) / fixed_width ) );
		WMU_slider.setValue( value, true, true, true );
	}
}

function WMU_show(e) {
	WMU_refid = null;
	WMU_wysiwygStart = 1;
	if(YAHOO.lang.isNumber(e)) {
		WMU_refid = e;
		if(WMU_refid == -1) {
			WMU_track('open/fromWysiwyg/new');
			// go to main page
		} else {
			WMU_track('open/fromWysiwyg/existing');
			if(FCK.wysiwygData[WMU_refid].exists) {
				// go to details page
				WMU_wysiwygStart = 2;
			} else {
				// go to main page
			}
		}

	} else {
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

	YAHOO.util.Dom.setStyle('header_ad', 'display', 'none');
	if(WMU_panel != null) {
		WMU_panel.show();
		if(WMU_refid != null && WMU_wysiwygStart == 2) {
			WMU_loadDetails();
		} else {
			if($('ImageQuery')) $('ImageQuery').focus();
		}
		return;
	}

	var html = '';
	html += '<div class="reset" id="ImageUpload">';
	html += '	<div id="ImageUploadBorder"></div>';
	html += '	<div id="ImageUploadProgress1" class="ImageUploadProgress"></div>';
	html += '	<div id="ImageUploadBack"><div></div><a href="#">' + wmu_back + '</a></div>';
	html += '	<div id="ImageUploadClose"><div></div><a href="#">' + wmu_close + '</a></div>';
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

	document.body.appendChild(element);

	WMU_panel = new YAHOO.widget.Panel('WMU_div', {
		modal: true,
		constraintoviewport: true,
		draggable: false,
		close: false,
		fixedcenter: true,
		underlay: "none",
		visible: false,
		zIndex: 1500
	});
	WMU_panel.render();
	WMU_panel.show();
	if(WMU_refid != null && WMU_wysiwygStart == 2) {
		WMU_loadDetails();
	} else {
		WMU_loadMain();
	}

	YAHOO.util.Event.addListener('ImageUploadBack', 'click', WMU_back);
	YAHOO.util.Event.addListener('ImageUploadClose', 'click', WMU_close);
}

function WMU_loadMain() {
	var callback = {
		success: function(o) {
			$('ImageUploadMain').innerHTML = o.responseText;
			WMU_indicator(1, false);
			if($('ImageQuery') && WMU_panel.element.style.visibility == 'visible') $('ImageQuery').focus();
			var cookieMsg = document.cookie.indexOf("wmumainmesg=");
			if (cookieMsg > -1 && document.cookie.charAt(cookieMsg + 12) == 0) {
				$('ImageUploadTextCont').style.display = 'none';
				$('ImageUploadMessageLink').innerHTML = '[' + wmu_show_message  + ']';
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
			$('ImageUploadLicenseText').innerHTML = o.responseText;
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
			$('WMU_results_0').innerHTML = o.responseText;
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
			$('WMU_source_' + WMU_curSourceId).style.fontWeight = '';
			$('WMU_source_' + sourceId).style.fontWeight = 'bold';

			$('WMU_results_' + WMU_curSourceId).style.display = 'none';
			$('WMU_results_' + sourceId).style.display = '';

			WMU_track('changeSource/src-'+sourceId); // tracking

			if($('ImageQuery')) $('ImageQuery').focus();

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
		WMU_track('find/enter/' + $('ImageQuery').value); // tracking
	} else if(e) {
		WMU_track('find/click/' + $('ImageQuery').value); // tracking
	}

	var query = $('ImageQuery').value;

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
			$('WMU_results_' + o.argument[0]).innerHTML = o.responseText;
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
			$('ImageUploadProgress1').style.display = 'block';
		} else if(id == 2) {
			$('ImageUploadProgress2').style.visibility = 'visible';
		}
	} else {
		if(id == 1) {
			$('ImageUploadProgress1').style.display = '';
		} else if(id == 2) {
			$('ImageUploadProgress2').style.visibility = 'hidden';
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
	if($('ImageUploadFile').value == '') {
		WMU_track('upload/undefined'); // tracking
		alert(wmu_warn2);
		return false;
	} else {
		if (WMU_initialCheck( $('ImageUploadFile').value )) {
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
	$('ImageUploadBack').style.display = 'inline';

	$('ImageUpload' + WMU_curScreen).innerHTML = responseText;

	if($('ImageUploadThumb')) {
		WMU_orgThumbSize = null;
		var image = $('ImageUploadThumb').firstChild;
		if ( null == WMU_width ) {
			WMU_width = $( 'ImageRealWidth' ).value;
			WMU_height = $( 'ImageRealHeight' ).value;
		}
		var thumbSize = [image.width, image.height];
		WMU_orgThumbSize = null;
		WMU_slider = YAHOO.widget.Slider.getHorizSlider('ImageUploadSlider', 'ImageUploadSliderThumb', 0, 200);
		WMU_slider.initialRound = true;
		WMU_slider.getRealValue = function() {
			return Math.max(2, Math.round(this.getValue() * (thumbSize[0] / 200)));
		}
		WMU_slider.subscribe("change", function(offsetFromStart) {
			if ( 'hidden' == $( 'ImageUploadSliderThumb' ).style.visibility ) {
				$( 'ImageUploadSliderThumb' ).style.visibility = 'visible';
			}
			if (WMU_slider.initialRound) {
				$('ImageUploadManualWidth').value = '';
				WMU_slider.initialRound = false;
			} else {
				$('ImageUploadManualWidth').value = WMU_slider.getRealValue();
			}
			image.width = WMU_slider.getRealValue();
			$('ImageUploadManualWidth').value = image.width;
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
	}
	if ($( 'WMU_error_box' )) {
		alert( $( 'WMU_error_box' ).innerHTML );
	}
	if ( $( 'ImageUploadSlider' ) ) {
		$( 'ImageUploadSlider' ).style.visibility = 'hidden';
		$( 'ImageUploadInputWidth' ).style.visibility = 'hidden';
	}
	if ( $( 'ImageUploadLicenseText' ) ) {
		var cookieMsg = document.cookie.indexOf("wmulicensemesg=");
		if (cookieMsg > -1 && document.cookie.charAt(cookieMsg + 15) == 0) {
			$('ImageUploadLicenseText').style.display = 'none';
			$('ImageUploadLicenseLink').innerHTML = '[' + wmu_show_license_message  + ']';
		}
	}
	WMU_indicator(1, false);
}

function WMU_insertImage(e, type) {
	WMU_track('insertImage/' + type); // tracking

	YAHOO.util.Event.preventDefault(e);

	var params = Array();
	params.push('type='+type);
	params.push('mwname='+$('ImageUploadMWname').value);

	if(type == 'overwrite') {
		params.push('name='+ encodeURIComponent( $('ImageUploadExistingName').value ) );
	} else if(type == 'rename') {
		params.push('name='+ encodeURIComponent( $('ImageUploadRenameName').value ) );
	} else {
		if($('ImageUploadName')) {
			params.push('name='+ encodeURIComponent( $('ImageUploadName').value ) + '.' + $('ImageUploadExtension').value);
		}
	}

	if($('ImageUploadLicense')) {
		params.push('ImageUploadLicense='+$('ImageUploadLicense').value);
	}

	if($('ImageUploadExtraId')) {
		params.push('extraId='+$('ImageUploadExtraId').value);
	}

	if($('ImageUploadThumb')) {
		params.push('size=' + ($('ImageUploadThumbOption').checked ? 'thumb' : 'full'));
		params.push( 'width=' + $( 'ImageUploadManualWidth' ).value + 'px' );
		params.push('layout=' + ($('ImageUploadLayoutLeft').checked ? 'left' : 'right'));
		params.push('caption=' + $('ImageUploadCaption').value);
		params.push('slider=' + $('ImageUploadWidthCheckbox').checked);
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
					$('ImageUpload' + WMU_curScreen).innerHTML = o.responseText;
					break;
				case 'summary':
					WMU_switchScreen('Summary');
					$('ImageUploadBack').style.display = 'none';
					$('ImageUpload' + WMU_curScreen).innerHTML = o.responseText;
					if(WMU_refid == null) {
						insertTags($('ImageUploadTag').value, '', '');
					} else {
						var wikitag = YAHOO.util.Dom.get('ImageUploadTag').value;
						var options = {};

						if($('ImageUploadThumbOption').checked) {
							options.thumb = 1;
						} else {
							options.thumb = null;
						}
						if($('ImageUploadWidthCheckbox').checked) {
							options.width = WMU_slider.getRealValue();
						} else {
							options.width = null;
						}
						if($('ImageUploadLayoutLeft').checked) {
							options.align = 'left';
						} else {
							options.align = null;
						}
						options.caption = $('ImageUploadCaption').value;

						if(WMU_refid != -1) {
							FCK.ProtectImageUpdate(WMU_refid, wikitag, options);
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
	var image = $('ImageUploadThumb').firstChild;
	if( !$( 'ImageUploadWidthCheckbox' ).checked ) {
		$('ImageUploadManualWidth').value = '';
		$('ImageUploadSlider').style.visibility = 'hidden';
		$('ImageUploadSliderThumb').style.visibility = 'hidden';
		$('ImageUploadInputWidth').style.visibility = 'hidden';
		image.width = WMU_orgThumbSize[0];
		image.height = WMU_orgThumbSize[1];
		WMU_track('slider/disable'); // tracking
	} else {
		$('ImageUploadManualWidth').value = WMU_slider.getRealValue();
		$('ImageUploadSlider').style.visibility = 'visible';
		$('ImageUploadSliderThumb').style.visibility = 'visible';
		$('ImageUploadInputWidth').style.visibility = 'visible';
		image.width = WMU_thumbSize[0];
		image.height = WMU_thumbSize[1];
		WMU_track('slider/enable'); // tracking
	}
}

function MWU_imageSizeChanged(size) {
	WMU_track('size/' + size); // tracking
	YAHOO.util.Dom.setStyle(['ImageWidthRow', 'ImageLayoutRow'], 'display', size == 'thumb' ? '' : 'none');
	if($('ImageUploadThumb')) {
		var image = $('ImageUploadThumb').firstChild;
		if(size == 'thumb') {
			image.width = WMU_thumbSize[0];
			image.height = WMU_thumbSize[1];
			$('ImageUploadManualWidth').value = WMU_thumbSize[0];
		} else {
			image.width = WMU_orgThumbSize[0];
			image.height = WMU_orgThumbSize[1];
			$('ImageUploadManualWidth').value = WMU_orgThumbSize[0];
		}
	}
}

function WMU_toggleMainMesg(e) {
	YAHOO.util.Event.preventDefault(e);
	if ('none' == $('ImageUploadTextCont').style.display) {
		$('ImageUploadTextCont').style.display = '';
		$('ImageUploadMessageLink').innerHTML = '[' + wmu_hide_message  + ']';
		WMU_track( 'mainMessage/show' ); // tracking
		document.cookie = "wmumainmesg=1";
	} else {
		$('ImageUploadTextCont').style.display = 'none';
		$('ImageUploadMessageLink').innerHTML = '[' + wmu_show_message  + ']';
		WMU_track( 'mainMessage/hide' ); // tracking
		document.cookie = "wmumainmesg=0";
	}
}

function WMU_toggleLicenseMesg(e) {
	YAHOO.util.Event.preventDefault(e);
	if ('none' == $('ImageUploadLicenseText').style.display) {
		$('ImageUploadLicenseText').style.display = '';
		$('ImageUploadLicenseLink').innerHTML = '[' + wmu_hide_license_message  + ']';
		WMU_track( 'licenseText/show' ); // tracking
		document.cookie = "wmulicensemesg=1";
	} else {
		$('ImageUploadLicenseText').style.display = 'none';
		$('ImageUploadLicenseLink').innerHTML = '[' + wmu_show_license_message  + ']';
		WMU_track( 'licenseText/hide' ); // tracking
		document.cookie = "wmulicensemesg=0";
	}
}

function WMU_switchScreen(to) {
	WMU_prevScreen = WMU_curScreen;
	WMU_curScreen = to;
	$('ImageUpload' + WMU_prevScreen).style.display = 'none';
	$('ImageUpload' + WMU_curScreen).style.display = '';
	if(WMU_curScreen == 'Main') {
		$('ImageUploadBack').style.display = 'none';
	}
	if((WMU_prevScreen == 'Details' || WMU_prevScreen == 'Conflict') && WMU_curScreen == 'Main' && $('ImageUploadName')) {
		YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WMU&method=clean&mwname=' + $('ImageUploadMWname').value);
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
	if(typeof FCK == 'undefined' && $('wpTextbox1')) $('wpTextbox1').focus();
	WMU_switchScreen('Main');
	WMU_loadMain();
	YAHOO.util.Dom.setStyle('header_ad', 'display', 'block');
}

function WMU_track(str) {
	YAHOO.Wikia.Tracker.track('WMU/' + str);
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
