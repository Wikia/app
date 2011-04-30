(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable);

	WE.plugins.pagecontrols = $.createClass(WE.plugin,{

		hiddenFields: false,
		callbackFields: false,
		titleNode: false,

		textarea: false,

		beforeInit: function() {
			this.editor.controls = this;
		},

		// init page controls widget
		init: function() {
			var pageControls = $('#EditPageRail .module_page_controls'),
				menu = pageControls.find('nav');

			this.textarea = pageControls.find('textarea');

			// set up the caption of summary field
			this.textarea.placeholder();

			// pressing enter in edit summary should initiate publish button
			this.textarea.bind('keypress', this.proxy(this.onSummaryKeypress));

			// attach events
			$('#wpPreview').bind('click', this.proxy(this.onPreview));
			$('#wpDiff').bind('click', this.proxy(this.onDiff));

			// remove placeholder text when user submits the form without providing the summary
			$('#editform').bind('submit', this.proxy(this.onSave));

			// hidden form fields / page title in the header
			this.hiddenFields = $('#EditPageHiddenFields');
			this.callbackFields = $('#EditPageCallbackFields');
			this.titleNode = $('#EditPageHeader > h1');

			// show "Edit title" button and attach handler for it (when we have custom fields attached to this edit form)
			if ($('#EditPageHiddenFields').children().exists()) {
				$('#EditPageTitle').
					show().
					bind('click', function(ev) {
						self.renderHiddenFieldsDialog();
					});
			}

			// check whether there are required fields with no value - show dialog
			if (this.checkForEmptyFields(this.hiddenFields)) {
				this.renderHiddenFieldsDialog();

				// keep focus inside the dialog
				if (typeof RTE == 'object') {
					RTE.config.startupFocus = false;
				}
			} else if ($('#EditPageHiddenFields [name=wpTitle]').exists()) { // page name is editable
				this.updateEditedTitle();
			}

			// show form rendered by edit form callback (e.g. captcha)
			if (this.callbackFields.exists()) {
				this.renderCallbackFieldsDialog();

				// keep focus inside the dialog
				if (typeof RTE == 'object') {
					RTE.config.startupFocus = false;
				}
			}
		},

		// handle "Preview" button
		onPreview: function() {
			this.renderPreview({});
			this.editor.track('visualMode', 'pageControls', 'preview', this.editor.getTrackerMode());
		},

		// handle "Show changes" button
		onDiff: function() {
			this.renderChanges({});
			this.editor.track('visualMode', 'pageControls', 'diff', this.editor.getTrackerMode());
		},

		// handle "Save" button
		onSave: function() {
			if (this.textarea.val() == this.textarea.attr('placeholder')) {
				this.textarea.val('');
			}

			this.editor.setState(this.editor.states.SAVING);

			this.editor.track('visualMode', 'pageControls', 'save', this.editor.getTrackerMode(), 'button');

			// block "Publish" button
			$('#wpSave').attr('disabled', true);
		},

		// handle keypressing in "Edit summary" field
		onSummaryKeypress: function(ev) {
			if (ev.keyCode == 13 /* enter */) {
				this.editor.track('visualMode', 'pageControls', 'save', this.editor.getTrackerMode(), 'enter');

				// submit the form
				var form = this.textarea.closest('form');
				form.submit();
			}
		},

		// send AJAX request
		ajax: function(method, params, callback) {
			var editor = typeof RTE == 'object'? RTE.instance : false,
				mode = editor ? editor.mode : 'mw';

			params = $.extend(params, {
				method: method,
				mode: editor.mode
			});

			var url = window.wgEditPageHandler.replace('$1', encodeURIComponent(window.wgEditedTitle));

			jQuery.post(url, params, function(data) {
				if (typeof callback == 'function') {
					callback(data);
				}
			}, 'json');
		},

		// get value of wpTitle field and update wgEditedTitle JS variable and page header title
		updateEditedTitle: function() {
			var title = $('[name=wpTitle]');

			if(title.exists()) {
				window.wgEditedTitle = title.val();
			}

			var prefix = '';

			if(wgEditedTitleNS.length > 0) {
				prefix = wgEditedTitleNS + ':';
			}

			if(wgEditedTitlePrefix.length > 0) {
				prefix = prefix + wgEditedTitlePrefix + ':';
			}

			window.wgEditedTitle = prefix + window.wgEditedTitle;

			this.titleNode.children('a').
				attr('href', wgArticlePath.replace('$1', window.wgEditedTitle)).
				text(window.wgEditedTitle);
		},

		// return true if any of the required fields has no value
		checkForEmptyFields: function(fields) {
			var emptyRequiredFields = fields.find('label > *[data-required="1"]'),
				emptyCounter = 0;

			emptyRequiredFields.each(function() {
				if ($(this).val() == '') {
					emptyCounter++;
				}
			});

			return emptyCounter > 0;
		},

		// show dialog for providing required data (e.g. page title)
		renderHiddenFieldsDialog: function() {
			var self = this,
				dialogTitle = document.title;

			$.showCustomModal(dialogTitle, '<div class="fields"></div>', {
				id: 'HiddenFieldsDialog',
				width: 400,
				buttons: [
					{
						id: 'ok',
						defaultButton: true,
						message: $.msg('ok'),
						handler: function() {
							var dialog = $('#HiddenFieldsDialog');

							// required data is provided - proceed by closing the dialog
							if (!self.checkForEmptyFields(dialog)) {
								self.hiddenFields.append(dialog.find('label'));
								self.updateEditedTitle();

								dialog.closeModal();

								if (typeof RTE == 'object') {
									RTE.instance.focus();
								}
							}
						}
					}
				],

				// before showing the dialog move hidden fields from edit form to the dialog
				callback: function() {
					self.hiddenFields.children('label').appendTo($('#HiddenFieldsDialog .fields'));

					// set focus on the first field
					$('#HiddenFieldsDialog label').children().focus();
				},
				// don't show close button, user has to click "Ok" and fields have to be validated
				showCloseButton: false,
				onClose: function() {
					return false;
				}
			});
		},

		// render dialog for callback form (eg. captcha)
		renderCallbackFieldsDialog: function() {
			var self = this,
				dialogTitle = document.title;

			// update modal's title when showing a captcha
			if ($('#wpCaptchaWord').exists()) {
				dialogTitle = $.msg('editpagelayout-captcha-title');
			}

			$.showCustomModal(dialogTitle, '<div class="fields"></div>', {
				id: 'HiddenFieldsDialog',
				width: 400,
				buttons: [
					{
						id: 'ok',
						defaultButton: true,
						message: $.msg('savearticle'),
						handler: function() {
							var dialog = $('#HiddenFieldsDialog');

							// move fields back to edit form
							self.callbackFields.append(dialog.find('.fields'));

							// publish the page
							$('#wpSave').click();

							dialog.closeModal();
						}
					}
				],

				// before showing the dialog move hidden fields from edit form to the dialog
				callback: function() {
					self.callbackFields.children().appendTo($('#HiddenFieldsDialog .fields'));

					// set focus on the first field
					$('#HiddenFieldsDialog input[type!="hidden"]').focus();
				}
			});
		},

		// show dialog for preview / show changes and scale it to fit viewport's height
		renderDialog: function(title, options, callback) {
			options = $.extend({
				callback: function() {
					var contentNode = $('#EditPageDialog .WikiaArticle');

					// block all clicks
					contentNode.
						bind('click', function(ev) {
							ev.preventDefault();
						}).
						css({
							height: $.getViewportHeight() - 250,
							overflow: 'auto'
						});

					if (typeof callback == 'function') {
						callback(contentNode);
					}
				},
				id: 'EditPageDialog',
				width: 680
			}, options);

			// use loading indicator before real content will be fetched
			var content = '<div class="WikiaArticle"><img src="' + stylepath + '/common/images/ajax.gif" class="loading"></div>';

			$.showCustomModal(title, content, options);
		},

		// render "Preview" modal
		renderPreview: function(extraData) {
			var self = this;
			this.renderDialog($.msg('preview'), {
				buttons: [
					{
						id: 'close',
						message: $.msg('back'),
						handler: function() {
							$('#EditPageDialog').closeModal();
						}
					},
					{
						id: 'publish',
						defaultButton: true,
						message: $.msg('savearticle'),
						handler: function() {
							// click "Publish" button
							$('#wpSave').click();
						}
					}
				],
				className: 'preview'
			}, function(contentNode) {
				self.getContent(function(content) {
					extraData.content = content;
					self.ajax('preview',
						extraData,
						function(data) {
							// wrap article's HTML inside .WikiaArticle
							var html = '<h1 class="pagetitle">' + window.wgEditedTitle + '</h1>' + data.html;
							contentNode.html(html);

							// move "edit" link to the right side of heading names
							contentNode.find('.editsection').each(function() {
								$(this).appendTo($(this).next());
							});
						});
				});
			});
		},

		// render "show diff" modal
		renderChanges: function(extraData) {
			var self = this;
			this.renderDialog('Changes', {}, function(contentNode) {
				self.getContent(function(content) {
					extraData.content = content;
					extraData.section = parseInt($.getUrlVar('section') || 0);
					self.ajax('diff',
						extraData,
						function(data) {
							var html = '<h1 class="pagetitle">' + window.wgEditedTitle + '</h1>' + data.html;
							contentNode.html(html);
					});
				});
			});

			// load diff.css
			var self = this;
			if (!this.diffCssLoaded) {
				$.getCSS(stylepath + '/common/diff.css', function() {
					self.diffCssLoaded = true;
				});
			}
		},

		// get editor's content (either wikitext or HTML)
		// and call provided callback with wikitext as its parameter
		getContent: function(callback) {
			var editor = typeof RTE == 'object'? RTE.instance : false,
				mode = editor ? editor.mode : 'mw';

			callback = callback || function() {};

			switch(mode) {
				case 'mw':
					callback($('#wpTextbox1').val());
					return;
				case 'source':
				case 'wysiwyg':
					callback(editor.getData());
					return;
			}
		}

	});

})(this,jQuery);
