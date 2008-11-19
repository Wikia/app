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
var WMU_widthChanges;
var WMU_refid = null;
var WMU_wysiwygStart = 1;

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
	element.style.height = '437px';
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
		}
	}
	WMU_indicator(1, true);
	YAHOO.util.Connect.asyncRequest('GET', wgScriptPath + '/index.php?action=ajax&rs=WMU&method=loadMain', callback);
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
	bits = filename.split( '.' );
	basename = bits.shift();
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
	list_array = WMU_splitExtensions( checkedName );
	partname = list_array[0];
	ext = list_array[1];
	if (ext.length > 0) {
		finalExt = ext[ext.length -1];
	} else {
		finalExt = '';
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

	$('ImageUploadBack').style.display = 'inline';

	$('ImageUpload' + WMU_curScreen).innerHTML = responseText;

	if($('ImageUploadThumb')) {
		WMU_orgThumbSize = null;
		var image = $('ImageUploadThumb').firstChild;
		var thumbSize = [image.width, image.height];
		WMU_orgThumbSize = null;
		WMU_slider = YAHOO.widget.Slider.getHorizSlider('ImageUploadSlider', 'ImageUploadSliderThumb', 0, 200);
		WMU_slider.getRealValue = function() {
			return Math.max(2, Math.round(this.getValue() * (thumbSize[0] / 200)));
		}
		WMU_slider.subscribe("change", function(offsetFromStart) {
			$('ImageSize').innerHTML = WMU_slider.getRealValue() + 'px';
			image.width = WMU_slider.getRealValue();
			image.height = image.width / (thumbSize[0] / thumbSize[1]);
			if(WMU_orgThumbSize == null) {
				WMU_orgThumbSize = [image.width, image.height];
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

	WMU_indicator(1, false);
}

function WMU_insertImage(e, type) {
	WMU_track('insertImage/' + type); // tracking

	YAHOO.util.Event.preventDefault(e);

	var params = Array();
	params.push('type='+type);
	params.push('mwname='+$('ImageUploadMWname').value);

	if(type == 'overwrite') {
		params.push('name='+$('ImageUploadExistingName').value);
	} else if(type == 'rename') {
		params.push('name='+$('ImageUploadRenameName').value);
	} else {
		if($('ImageUploadName')) {
			params.push('name='+$('ImageUploadName').value);
		}
	}

	if($('CC_license')) {
		params.push('CC_license='+$('CC_license').checked);
	}

	if($('ImageUploadExtraId')) {
		params.push('extraId='+$('ImageUploadExtraId').value);
	}

	if($('ImageUploadThumb')) {
		params.push('size=' + ($('ImageUploadThumbOption').checked ? 'thumb' : 'full'));
		params.push('width=' + $('ImageSize').innerHTML);
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
						insertTags($('ImageUploadTag').innerHTML, '', '');
					} else {
						var wikitag = YAHOO.util.Dom.get('ImageUploadTag').innerHTML;
						if(WMU_refid != -1) {
							FCK.ProtectImageUpdate(WMU_refid, wikitag);
						} else {
							FCK.ProtectImageAdd(wikitag);
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
	if(changes%2 == 0) {
		$('ImageSize').innerHTML = 'Default size';
		$('ImageUploadSlider').style.display = 'none';
		image.width = WMU_orgThumbSize[0];
		image.height = WMU_orgThumbSize[1];
		WMU_track('slider/disable'); // tracking
	} else {
		$('ImageSize').innerHTML = WMU_slider.getRealValue() + 'px';
		$('ImageUploadSlider').style.display = '';
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
		} else {
			image.width = WMU_orgThumbSize[0];
			image.height = WMU_orgThumbSize[1];
		}
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
	if($('wpTextbox1')) $('wpTextbox1').focus();
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
