//* IMAGE *//

window.PageLayoutBuilder = window.PageLayoutBuilder || {};

PageLayoutBuilder.inputEmpty = function (e) {
	$(e.target).unbind('focus', PageLayoutBuilder.inputEmpty).val("").removeClass("plb-empty-input");
}

$(function() {
	$('.plb-empty-input').focus(PageLayoutBuilder.inputEmpty);

	$("#plbForm").submit(function() {
		$("input.plb-empty-input, textarea.plb-empty-input ").val("");
	});
});

PageLayoutBuilder.uploadImage = function (size, name) {
	$.loadYUI( function() {
		importStylesheetURI( wgExtensionsPath+ '/wikia/WikiaMiniUpload/css/WMU.css?'+wgStyleVersion );
		$.getScript(wgExtensionsPath+ '/wikia/WikiaMiniUpload/js/WMU.js?'+wgStyleVersion, function() {
			WMU_show();
			
			WMU_Event_OnLoadDetails = function() {
				$('#ImageColumnRow,#ImageSizeRow,#ImageWidthRow,#ImageLayoutRow').hide();
			};			

			WMU_insertImage = function() {
				$.ajax({
				  url: wgScript + '?action=ajax&rs=layoutWidgetImage::getUrlImageAjax&name=' + $("#ImageUploadMWname").val() + "&size=" + size,
				  dataType: "json",
				  method: "get",
				  success: function(data) {
					if(data.status == "ok") {
						$("#imageboxdiv_" + name).css("width", (parseInt( data.size.width ) + 4) + "px");
						$("#imagediv_" + name).css("width", data.size.width + "px")
						.css("line-height", data.size.height + "px")
						.css('background-image', 'url("' +  data.url +'")');
						$("#" + name).val( $("#ImageUploadMWname").val()  + " | " + $("#ImageUploadCaption").val() );
						$("#thumbcaption").val($("#ImageUploadCaption").val());
					}
					WMU_close();
				  }
				});
			}
		});
	});
	return false;
}
//* END IMAGE *//

//* MULTILINE *//

PageLayoutBuilder.messages = {},

PageLayoutBuilder.setupTextarea = function(node) {
	// add textarea toolbar node
	var toolbar = $('<div>').
		addClass('plb-form-template-toolbar').
		insertBefore(node).
		hide().css('top', parseInt($(node).position().top - 25) + "px" );
	
	// show toolbar on focus / hide on blur
	var toolbarHideTimeout = false;

	node.unbind('.editor').
		bind('focus.editor', function(ev) {
			clearTimeout(toolbarHideTimeout);
			toolbar.show();
		}).
		bind('blur.editor', function(ev) {
			toolbarHideTimeout = setTimeout(function() {
				toolbar.hide();
			}, 250);
		});

	// toolbar buttons
	var toolbarButtons = [
		{
			image: 'bold',
			tagOpen: "'''",
			tagClose: "'''",
			title: this.messages['bold_tip']
		},
		{
			image: 'italic',
			tagOpen: "''",
			tagClose: "''",
			title: this.messages['italic_tip']
		},
		{
			image: 'link',
			tagOpen: "[[",
			tagClose: "]]",
			title: this.messages['link_tip']
		}
	];

	// handle clicks on toolbar buttons
	var self = this;
	var toolbarButtonOnClick = function(tagOpen, tagClose, sampleText) {
		self.insertTags(node[0], tagOpen, tagClose, sampleText);

		// don't hide toolbar and bring focus back
		clearTimeout(toolbarHideTimeout);
		node.focus();
	};

	// add buttons
	for (var i=0; i < toolbarButtons.length; i++) {
		var data = toolbarButtons[i];

		$('<img />').
			appendTo(toolbar).
			attr({
				alt: '',
				"class": 'toolbar-' + data.image,
				height: 24,
				src: window.wgBlankImgUrl,
				tagClose: data.tagClose,
				tagOpen: data.tagOpen,
				title: data.title,
				width: 24
			}).
			click(function() {
				var button = $(this);
				toolbarButtonOnClick(button.attr('tagOpen'), button.attr('tagClose'), button.attr('title'));
			});
	}
}

PageLayoutBuilder.insertTags = function(txtarea, tagOpen, tagClose, sampleText) {
	var selText, isSample = false;

	// get pure DOM node
	txtarea = $(txtarea)[0];

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
}


$(function() {
	var elements = $(".plb-mlinput-textarea");
	for( var i = 0; i < elements.length; i ++ ) {
		PageLayoutBuilder.setupTextarea($(elements[i]));
	}
});

//* END MULTILINE *//
