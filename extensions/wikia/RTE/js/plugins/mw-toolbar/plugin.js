CKEDITOR.plugins.add('rte-mw-toolbar',
{
	editorContainer: false,

	init: function(editor) {
		var self = this;

		editor.on('instanceReady', function() {
			var toolbar = $('#cke_top_wpTextbox1').children('div').eq(0);
			var sourceButton = toolbar.find('.cke_button_source').parent().parent().parent();

			// mark source button wrapper
			sourceButton.attr('id', 'cke_source_button');

			// move MW toolbar inside CK
			$('#toolbar').appendTo(toolbar);

			// reference to editor container (wrapping element for iframe / textarea)
			self.editorContainer = $(RTE.instance.container.$).find('.cke_contents');
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
