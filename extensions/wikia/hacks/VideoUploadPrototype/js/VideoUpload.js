var VideoUpload = {
	// editor state
	editor: {
		id: 'VideoUploadEditor',
//		from: false,
//		msg: {},
		source: false,
		timer: false,
		height: false,
		width: false
	},

	// console logging
	log: function(msg) {
		$().log(msg, 'VideoUpload');
	},

	// send AJAX request to extension's ajax dispatcher in MW
	ajax: function(method, params, callback) {
		$.post(wgScript + '?action=ajax&rs=VideoUpload&method=' + method, params, callback, 'json');
	},

	// add MW toolbar button (don't add it when using Monobook)
	addToolbarButton: function() {
		if ( (skin != 'monobook') && (typeof mwCustomEditButtons != 'undefined') ) {
			mwCustomEditButtons.push({
				'imageFile': window.wgExtensionsPath + '/wikia/hacks/VideoUploadPrototype/images/film_add.png',
				'speedTip': 'Add video',
				'tagOpen': '',
				'tagClose': '',
				'sampleText': '',
				'imageId': 'mw-editbutton-vu',
				'onclick': function() {
					VideoUpload.showEditor({
						from: 'source'
					});
				}
			});
		}
	},

	// fetch and show gallery editor -- this is an entry point
	showEditor: function(params) {
		VideoUpload.log('showEditor');

		// for anons show ComboAjaxLogin
		if (typeof showComboAjaxForPlaceHolder == 'function') {
			if (showComboAjaxForPlaceHolder('', false, '', false, true)) { // last true shows the 'login required for this action' message.
				VideoUpload.log('please login to use this feature');
				return;
			}
		}

		// check lock to catch double-clicks on toolbar button
		if (VideoUpload.lockEditor) {
			VideoUpload.log('lock detected - please wait for dialog to load');
			return;
		}

		VideoUpload.lockEditor = true;

		// make params always be an object
		params = params || {};

		// get width of article to be used for editor
		var width = parseInt($('#WikiaPage').width() - 75);
		width = Math.min($(window).width() - 75, width);
		width = Math.max(670, width);
		width = Math.min(1300, width);

		var height = 300;

		VideoUpload.log('showEditor() - ' + width + 'x' + height + 'px');
		VideoUpload.log(params);

		VideoUpload.editor.width = width;
		VideoUpload.editor.height = height;

		$('#VideoUploadEditor').remove();

		// load CSS for editor popup, wikia-tabs and jQuery UI library (if not loaded yet) via loader function
		$.getResources([
			$.getSassCommonURL('/extensions/wikia/hacks/VideoUploadPrototype/css/VideoUpload.editor.scss')
		], function() {
			VideoUpload.ajax('getEditorDialog', {title: wgPageName}, function(data) {
				// store messages
//				VideoUpload.editor.msg = data.msg;

				// render editor popup
				$.showModal('', data.html, {
					callbackBefore: function() {
						// change height of the editor popup before it's shown (RT #55203)
						$('#VideoUploadEditorPagesWrapper').height(height);
					},
					callback: function() {
						// remove loading indicator
						$('#VideoUploadEditorLoader').remove();

						// mark editor dialog title node
						$('#VideoUploadEditor').children('h1').attr('id', 'VideoUploadEditorTitle');

						VideoUpload.setupEditor(params);
					},
					onClose: function(type) {
						VideoUpload.log('onClose');

						// prevent close event triggered by ESCAPE key
						if (type.keypress) {
							return false;
						}
					},
					id: VideoUpload.editor.id,
//					persistent: false, // don't remove popup when user clicks X
					width: VideoUpload.editor.width
				});
			});
		});
	},

	// setup gallery editor content (select proper page, register event handlers)
	setupEditor: function(params) {
		VideoUpload.log('setupEditor');
		VideoUpload.log(params);
		// remove lock
		delete VideoUpload.lockEditor;

		VideoUpload.editor.from = params.from;

		// add handlers to buttons
		$('#VideoUploadFormSubmit').unbind('.upload').bind('click.upload', function() {VideoUpload.onUpload()});
	},

	onUpload: function() {
		VideoUpload.log('onUpload');

		// show throbber
		$('#VideoUploadEditorPagesWrapper .throbber').show();

		//grab info from 1st form
		//TODO: add validation
		var formData = $('#VideoUploadFormData');
		var data = {
			title: wgPageName,
			videoTitle: formData.find('input[name=videoTitle]').val(),
			tags: formData.find('input[name=tags]').val(),
			description: formData.find('textarea[name=description]').val()
		};
		VideoUpload.log(data);

		VideoUpload.ajax('getDataForUpload', data, function(json) {
			if (json.success) {
				var formFile = $('#VideoUploadFormFile');
				formFile.attr('action', json.postUrl);
				formFile.submit(function() {return AIMV.submit(formFile.get(0));});
				if (formFile.find('input[name=file]').val()) {
					VideoUpload.log('submitting file to ' + json.postUrl);
					formFile.submit();
					VideoUpload.editor.timer = setTimeout('VideoUpload.checkProgressOfUpload("' + json.token + '")', 1000);
				} else {
					// show throbber
					$('#VideoUploadEditorPagesWrapper .throbber').hide();
					$.showModal('Error', 'Pick a file!');
				}
			} else {
				// show throbber
				$('#VideoUploadEditorPagesWrapper .throbber').hide();
				$.showModal('Error', json.errorMsg);
			}
		});

	},

	checkProgressOfUpload: function(token) {
		VideoUpload.log('checkProgressOfUpload, token: ' + token);
		$.getJSON('http://upload.bitsontherun.com/progress?token=' + token + '&callback=?',
			function(json) {
				VideoUpload.log('checkProgressOfUpload, state: ' + json.state);
				switch (json.state) {
					case 'uploading':
						var progress = Math.round(parseInt(json.received) / parseInt(json.size) * 100);
						VideoUpload.log('checkProgressOfUpload size: ' + json.size + ', received: ' + json.received + ', overall: ' + progress + '%');
						$('#progressInner').css('width', progress + '%');
						//no break here
					case 'starting':
						VideoUpload.editor.timer = setTimeout('VideoUpload.checkProgressOfUpload("' + token + '")', 1000);
						break;
					case 'done':
						$('#progressInner').css('width', '100%');
						break;
					case 'error':
						VideoUpload.log('checkProgressOfUpload, error (200 and 302 is OK): ' + json.status);
						break;
				}
			}
		);
	},

	// called from Special:VideoUploadHelper
	uploadFinished: function(videoKey) {
		clearTimeout(VideoUpload.editor.timer);
		VideoUpload.log('Upload finished, videoKey:' + videoKey);
		VideoUpload.insertWikitext(videoKey);
		$('#' + VideoUpload.editor.id).closeModal();
	},


	// get DOM node of editarea (either of MW editor or RTE source mode)
	getEditarea: function() {
		if (typeof window.RTE == 'undefined') {
			// MW editor
			var control = document.getElementById('wpTextbox1');
		} else {
			// RTE
			var control = window.RTE.instance.textarea.$;
		}

		return control;
	},

	// get cursor position (source mode / MW editor)
	getCaretPosition: function() {
		var control = VideoUpload.getEditarea();
		var caretPos = 0;

		// IE
		if(jQuery.browser.msie) {
			control.focus();
			var sel = document.selection.createRange();
			var sel2 = sel.duplicate();
			sel2.moveToElementText(control);
			var caretPos = -1;
			while(sel2.inRange(sel)) {
				sel2.moveStart('character');
				caretPos++;
			}
		}
		// Firefox
		else if (control.selectionStart || control.selectionStart == '0') {
			caretPos = control.selectionStart;
		}

		return caretPos;
	},

	insertWikitext: function(videoKey) {
		switch (VideoUpload.editor.from) {
			case 'wysiwyg':
				break;

			case 'source':
				var cursorPos = this.getCaretPosition();

				var textarea = this.getEditarea();
				var value = textarea.value;

				value = value.substring(0, cursorPos) + '<longtail vid="' + videoKey + '">' + value.substring(cursorPos);

				textarea.value = value;
				break;

			case 'view':
				break;
		}
	}
};

// add toolbar button
VideoUpload.addToolbarButton();

/*
 * AJAX IFRAME METHOD (AIM)
 * http://www.webtoolkit.info/
 *
 * this is exact copy of AIM from WikiaMiniUpload - for testing purpose - this should be moved into common location to be usable from both extensions
 */
AIMV = {
	frame: function(c) {
		var n = 'f' + Math.floor(Math.random() * 99999);
		var d = document.createElement('DIV');
		d.innerHTML = '<iframe style="display:none" src="about:blank" id="'+n+'" name="'+n+'" onload="AIMV.loaded(\''+n+'\')"></iframe>';
		document.body.appendChild(d);
		var i = document.getElementById(n);
		if (c && typeof(c.onComplete) == 'function') {
			i.onComplete = c.onComplete;
		}
		return n;
	},
	form: function(f, name) {
		f.setAttribute('target', name);
	},
	submit: function(f, c) {

		// macbre: allow cross-domain
		if (document.domain != 'localhost' && typeof FCK != 'undefined') {
			f.action += ((f.action.indexOf('?') > 0) ? '&' : '?') + 'domain=' + escape(document.domain);
		}

		AIMV.form(f, AIMV.frame(c));
		if (c && typeof(c.onStart) == 'function') {
			return c.onStart();
		} else {
			return true;
		}
	},
	loaded: function(id) {
		var i = document.getElementById(id);
		if (i.contentDocument) {
			var d = i.contentDocument;
		} else if (i.contentWindow) {
			var d = i.contentWindow.document;
		} else {
			var d = window.frames[id].document;
		}
//		if (d.location.href == "about:blank") {
//			return;
//		}

		if (typeof(i.onComplete) == 'function') {
			i.onComplete(d.body.innerHTML);
		}
	}
}
