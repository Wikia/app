CKEDITOR.plugins.add('rte-toolbar',
{
	editorContainer: false,

	init: function(editor) {
		var self = this;

		editor.on('instanceReady', function() {
			// find source button and mark it with ID
			var toolbar = $('#cke_top_wpTextbox1').children('div').eq(0);
			var sourceButton = toolbar.find('.cke_button_source').parent().parent().parent();

			sourceButton.attr('id', 'cke_source_button');

			// show toolbar - CK is fully loaded now
			toolbar.css('visibility', 'visible');

			// render MW toolbar inside CK
			var MWtoolbar = $('<div id="mw-toolbar">');
			toolbar.append(MWtoolbar);

			// add buttons
			for (var i = 0; i < mwEditButtons.length; i++) {
				mwInsertEditButton(MWtoolbar[0], mwEditButtons[i]);
			}

			for (var i = 0; i < mwCustomEditButtons.length; i++) {
				mwInsertEditButton(MWtoolbar[0], mwCustomEditButtons[i]);
			}

			// add toolbar covering div - will be used during loading state
			toolbar.append('<div id="toolbarCover" class="color1" />');

			// reference to editor container (wrapping element for iframe / textarea)
			self.editorContainer = $(RTE.instance.container.$).find('.cke_contents');

			// tracking for CK toolbar buttons
			editor.on('buttonClick', function(ev) {
				var buttonClicked = ev.data.button;
				//RTE.log(buttonClicked);

				RTE.track('toolbar', buttonClicked.command);
			});

			// tracking for CK toolbar rich combos (dropdowns)
			editor.on('panelShow', function(ev) {
				var me = ev.data.me;
				//RTE.log(me);

				var id = me.className.split('_').pop();

				// track combo panel open
				RTE.track('toolbar', id + 'Menu', 'open');
			});
			editor.on('panelClick', function(ev) {
				var me = ev.data.me;
				var value = ev.data.value;
				//RTE.log([me, value]);

				var id = me.className.split('_').pop();

				// for templates dropdown
				if (id == 'template') {
					if (value == '--other--') {
						value = 'other';
					}
					else {
						var panelItems = me._.items;
						var idx = 0;

						// iterate thru panel items and find index chosen template
						for (tpl in panelItems) {
							idx++;
							if (tpl == value) {
								value = idx;
								break;
							}
						}
					}
				}

				// track combo panel open
				RTE.track('toolbar', id + 'Menu', value);
			});

			// tracking for MW toolbar buttons
			MWtoolbar.bind('click', function(ev) {
				var target = $(ev.target).filter('img');
				//RTE.log(target);

				if (!target.exists()) {
					return;
				}

				var id = target.attr('id').split('-').pop();
				RTE.track('source', id);
			});
		});

		// override insertTags function, so it works in CK source mode

		// apply tagOpen/tagClose to selection in textarea,
		// use sampleText instead of selection if there is none
		window.insertTags = function(tagOpen, tagClose, sampleText) {
			var txtarea = self.editorContainer.children('textarea')[0];

			var selText, isSample = false;

			if (document.selection  && document.selection.createRange) { // IE/Opera

				//save window scroll position
				if (document.documentElement && document.documentElement.scrollTop)
					var winScroll = document.documentElement.scrollTop
				else if (document.body)
					var winScroll = document.body.scrollTop;
				//get current selection
				txtarea.focus();
				var range = document.selection.createRange();
				selText = range.text;
				//insert tags
				checkSelectedText();
				range.text = tagOpen + selText + tagClose;
				//mark sample text as selected
				if (isSample && range.moveStart) {
					if (window.opera)
						tagClose = tagClose.replace(/\n/g,'');
					range.moveStart('character', - tagClose.length - selText.length);
					range.moveEnd('character', - tagClose.length);
				}
				range.select();
				//restore window scroll position
				if (document.documentElement && document.documentElement.scrollTop)
					document.documentElement.scrollTop = winScroll
				else if (document.body)
					document.body.scrollTop = winScroll;

			} else if (txtarea.selectionStart || txtarea.selectionStart == '0') { // Mozilla

				//save textarea scroll position
				var textScroll = txtarea.scrollTop;
				//get current selection
				txtarea.focus();
				var startPos = txtarea.selectionStart;
				var endPos = txtarea.selectionEnd;
				selText = txtarea.value.substring(startPos, endPos);
				//insert tags
				checkSelectedText();
				txtarea.value = txtarea.value.substring(0, startPos)
					+ tagOpen + selText + tagClose
					+ txtarea.value.substring(endPos, txtarea.value.length);
				//set new selection
				if (isSample) {
					txtarea.selectionStart = startPos + tagOpen.length;
					txtarea.selectionEnd = startPos + tagOpen.length + selText.length;
				} else {
					txtarea.selectionStart = startPos + tagOpen.length + selText.length + tagClose.length;
					txtarea.selectionEnd = txtarea.selectionStart;
				}
				//restore textarea scroll position
				txtarea.scrollTop = textScroll;
			}

			function checkSelectedText(){
				if (!selText) {
					selText = sampleText;
					isSample = true;
				} else if (selText.charAt(selText.length - 1) == ' ') { //exclude ending space char
					selText = selText.substring(0, selText.length - 1);
					tagClose += ' '
				}
			}
		};
	}
});
