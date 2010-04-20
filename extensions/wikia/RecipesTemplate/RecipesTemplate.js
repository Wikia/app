var RecipesTemplate = {
	// send AJAX request to extension's ajax dispatcher in MW
	ajax: function(method, params, callback) {
		$.post(wgScript + '?action=ajax&rs=RecipesTemplateAjax&method=' + method, params, callback, 'json');
	},

	// track events
	track: function(fakeUrl) {
		window.jQuery.tracker.byStr(this.formType + fakeUrl);
	},

	// console logging
	log: function(msg) {
		$().log(msg, 'RecipesTemplate');
	},

	messages: {},

	// create form type: ingredient / recipe
	formType: false,

	init: function() {
		var self = this;
		var form = $('.recipes-template-form');

		// move messages inside this object
		this.messages = window.RecipesTemplateMessages;

		// detect create form type
		this.formType = form.parent().attr('action').match('Special:Create(.*)$').pop().toLowerCase() + 'form';

		// setup each multifield area
		form.find('.recipes-template-multifield-wrapper').each(function() {
			self.setupMultifield($(this));
		});

		// setup hours/minutes fields
		form.find('.recipes-template-time').each(function() {
			self.setupTimeField($(this));
		});

		// setup photo uploads
		form.find('.recipes-template-upload').each(function() {
			self.setupUpload($(this));
		});

		// setup category chooser
		form.find('select').each(function(i) {
			self.setupCategoryChooser($(this), i);
		});

		// setup title checks
		this.setupTitleCheck($('#wpTitle'));

		// setup hideable hints
		form.find('.recipes-template-hint-hideable').each(function(i) {
			self.setupHideableHint($(this));
		});

		// setup mini MW toolbars for each textarea
		form.find('.recipes-template-textarea-wrapper').children().each(function() {
			self.setupTextarea($(this));
		});

		// setup input field with mini MW toolbar disabled
		form.find('.recipes-template-simple-input').children().bind('focus', function() {
			self.track('/' + self.getTrackingId($(this)));
		});

		// block form submit using ENTER key
		form.keypress(function(ev) {
			if (ev.keyCode == 13 && $(ev.target).is('input')) {
				ev.preventDefault();
				self.log('form submit blocked');
			}
		});

		// setup click tracking
		this.setupClickTracking(form);

		this.log('init() - ' + this.formType);
	},

	// setup click tracking
	setupClickTracking: function(form) {
		var self = this;

		// create forms toggle
		$('.recipes-template-toggle').find('a').
			unbind('.tracking').
			bind('click.tracking',function(ev) {
				self.track('/' + $(this).attr('ref'));
			});

		// time form fields focus
		form.
			find('.recipes-template-time').children('input').
			unbind('.tracking').
			bind('focus.tracking', function(ev) {
				self.track('/' + self.getTrackingId($(this)));
			});

		// publish
		$('#wpSubmit').
			unbind('.tracking').
			bind('click.tracking', function(ev) {
				self.track('/publish');
			});

		// preview
		$('#wpPreview').
			unbind('.tracking').
			bind('click.tracking', function(ev) {
				self.track('/preview');
			});
	},

	// get tracking ID for given node
	getTrackingId: function(node) {
		var fieldId = $(node).attr('id') || $(node).attr('name');

		// remove wp prefix and various suffixes
		return fieldId.
			replace(/^wp/, '').
			replace(/\-(.*)$/, '').
			replace(/\[\]$/, '').
			toLowerCase();
	},

	// setup dynamic rows for multifield area
	setupMultifield: function(area) {
		var self = this;

		var checkForEmptyFields = function() {
			var fields = area.find('input');

			var emptyFields = 0;
			fields.each(function() {
				if ($(this).val() == '') {
					emptyFields++;
				}
			});

			// we have two (or less) empty fields - add new one
			if (emptyFields <= 2) {
				// let's "create" (by cloning) new node to be added as new field
				var newField = fields.last().clone().
					unbind('.focus').
					val('').
					css('opacity', '').
					hide().
					bind('focus.focus', checkForEmptyFields);

				// add wrapper for mini MW-toolbar...
				newField.wrap( $('<div>').addClass('recipes-template-textarea-wrapper') );

				// ...and setup mini MW-toolbar
				self.setupTextarea(newField);

				// and field to DOM (together with textarea)
				newField.parent().show().appendTo(area);

				newField.fadeIn();

				// setup hideable hint
				var hint = area.parent().next('td').children();
				self.setupHideableHint(hint);
			}
		};

		var fields = area.find('input');

		fields.
			unbind('.focus').
			bind('focus.focus', checkForEmptyFields);
	},

	// setup hours/minutes fields
	setupTimeField: function(area) {
		var fields = area.children('input');

		// only allow numbers to be typed inside time fields
		fields.keydown(function(ev) {
			var key = ev.keyCode || 0;

			// allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
			var valid = (
				key == 8 ||
				key == 9 ||
				key == 46 ||
				(key >= 37 && key <= 40) ||
				(key >= 48 && key <= 57) ||
				(key >= 96 && key <= 105));

			if (!valid) {
				ev.preventDefault();
			}
		});

		// highlight the content of input on focus
		fields.focus(function(ev) {
			$(this).select();
		});
	},

	// setup hours/minutes fields
	setupUpload: function(area) {
		var self = this;
		var uploadButton = area.children('.wikia-button');
		var uploadPreview = area.children('.recipes-template-upload-preview');

		uploadButton.click(function(ev) {
			ev.preventDefault();

			if (typeof WMU_show == 'function') {
				self.log('opening WMU');
				WMU_show();
			}
			else {
				self.log('WMU not loaded!');
			}

			self.track('/photo-browse');
		});
	},

	// setup category chooser
	setupCategoryChooser: function(chooser, i) {
		var self = this;

		var otherFieldId = 'recipes-template-other-' + i;
		var otherFieldWrapper = chooser.next();
		var otherField = otherFieldWrapper.children('input');

		chooser.bind('change', function(ev) {
			self.track('/menu' + (i+1));

			// show other field if needed
			if ($(this).val() == 'other') {
				otherFieldWrapper.show();
				otherField.focus();
			}
			else {
				otherFieldWrapper.hide();
			}
		});

		// setup autosuggest
		otherField.autocomplete({
			serviceUrl: wgScript + '?action=ajax&rs=RecipesTemplateAjax&method=suggest',
			selectedClass: 'navigation-hover',
			deferRequestBy: 1000,
			appendTo: otherFieldWrapper
		});
	},

	// setup title checks
	setupTitleCheck: function(field) {
		// check title each time:
		//  - focus is moved outside field
		//  - one second elapsed since last keypress
		var self = this;
		var checkTimeout;

		// CreateRecipe / CreateIngredient
		var formType = field.closest('form').attr('action').match('Special:(.*)$').pop();

		var formRow = field.closest('tr');
		var hintCell = formRow.children('td').last();

		// perform check
		function checkTitle() {
			clearTimeout(checkTimeout);

			var title = field.val();
			if (title == '') {
				return;
			}

			self.ajax('pageExists', {
				'formType': formType,
				'pageName': title
			},
			function(data) {
				if (data.exists) {
					formRow.addClass('recipes-template-error-row');

					// show error message
					hintCell.html(data.msg);
				}
				else {
					formRow.removeClass('recipes-template-error-row');

					// remove any errors
					if (hintCell.children().hasClass('recipes-template-error')) {
						hintCell.html('');
					}
				}
			});
		}

		// bind events
		field.
			blur(checkTitle).
			keypress(function(ev) {
				clearTimeout(checkTimeout);

				checkTimeout = setTimeout(checkTitle, 1000);
			});
	},

	// setup hideable hint - show it when related input field gains focus
	setupHideableHint: function(hint) {
		// setup hideable hints only
		if (!hint.hasClass('recipes-template-hint-hideable')) {
			return;
		}

		// <td> node with related input(s)
		var inputsCell = hint.parent().prev('td');

		inputsCell.
			find('input').
			add( inputsCell.find('textarea') ).
			unbind('.hints').
			bind('focus.hints', function() {
				hint.show();
			}).
			bind('blur.hints', function() {
				hint.hide();
			});
	},

	//
	// code above handles mini MW toolbar for textarea / input fields
	//

	// apply tagOpen/tagClose to selection in textarea,
	// use sampleText instead of selection if there is none
	// taken from /skins/common/edit.js
	insertTags: function(txtarea, tagOpen, tagClose, sampleText) {
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
	},

	// add mini MW toolbar to single textarea node
	setupTextarea: function(node) {
		// add textarea toolbar node
		var toolbar = $('<div>').
			addClass('recipes-template-toolbar').
			insertBefore(node).
			hide();

		// show toolbar on focus / hide on blur
		var toolbarHideTimeout = false;

		node.unbind('.editor').
			bind('focus.editor', function(ev) {
				clearTimeout(toolbarHideTimeout);
				toolbar.show();

				self.track('/' + self.getTrackingId($(this)));
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
			self.log(tagOpen + 'foo' + tagClose);

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
					"class": 'recipes-template-toolbar-' + data.image,
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
};

$(function() {
	RecipesTemplate.init();
});

// catch wikitext added by WMU and get image name from it
function insertTags(wikitext) {
	var self = window.RecipesTemplate;
	var imageName = false;

	// remove [[
	wikitext = wikitext.substring(2);

	// get image name (part of wikitext before |)
	if (wikitext.indexOf('|') > -1) {
		// [[Image:foo.png|thumb]]
		imageName = wikitext.substring(0, wikitext.indexOf('|'));
	}
	else {
		// [[Image:foo.png]]
		imageName = wikitext.substring(0, wikitext.length - 2);
	}

	self.log('image choosen: ' + imageName);

	// let's asume here that we only have one upload field per form
	var uploadForm = $('.recipes-template-upload');

	var uploadField = uploadForm.children('input');
	var uploadPreview = uploadForm.children('.recipes-template-upload-preview');

	uploadField.val(imageName);

	self.ajax('makeThumb', {imageName: imageName}, function(data) {
		uploadPreview.css('backgroundImage', 'url(' + data.thumb + ')').show();
	});

	self.track('/photo-upload');
}
