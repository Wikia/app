(function (window, $) {

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	WE.plugins.pagecontrols = $.createClass(WE.plugin, {

		hiddenFields: false,
		callbackFields: false,
		titleNode: false,

		textarea: false,
		minorEditCheck: false,

		beforeInit: function () {
			this.editor.controls = this;

			// Disable the 'Publish' button.
			$('#wpSave').attr('disabled', true);

			// Re-enable the 'Publish' button when the editor is ready.
			this.editor.on('editorReady', this.proxy(this.onEditorReady));
		},

		// init page controls widget
		init: function () {
			var $pageControls = $('#EditPageRail .module_page_controls'),
				self = this;

			this.categories = $('#categories');
			this.textarea = $pageControls.find('textarea');

			// set up the caption of summary field
			this.textarea.placeholder();

			// pressing enter in edit summary should initiate publish button
			this.textarea.on('keypress', this.proxy(this.onSummaryKeypress));

			this.minorEditCheck = $pageControls.find('#wpMinoredit');

			// pressing enter on minor edit checkbox should not save the edition
			this.minorEditCheck.on( 'keypress', this.proxy( this.onMinorEditKeypress ) );

			this.minorEditCheck.on('change', this.proxy(function () {
				this.editor.track('minor-edit');
			}));

			// attach events
			require(['editpage.events'], function (editpageEvents) {
				editpageEvents.attachDesktopPreview('wpPreview', self.editor);
				editpageEvents.attachMobilePreview('wpPreviewMobile', self.editor);
				editpageEvents.attachDiff('wpDiff', self.editor);
			});

			// remove placeholder text when user submits the form without providing the summary
			this.editform = $('#editform').on('submit', this.proxy(this.onSave));

			// hidden form fields / page title in the header
			this.hiddenFields = $('#EditPageHiddenFields');
			this.callbackFields = $('#EditPageCallbackFields');
			this.titleNode = $('#EditPageHeader > h1');

			// show "Edit title" button and attach handler for it (when we have custom fields attached to this edit form)
			if ($('#EditPageHiddenFields input[type="text"]').exists()) {
				$('#EditPageTitle').// show it only when hovering over #EditPageHeader
					addClass('enabled').on('click', this.proxy(function () {
						this.renderHiddenFieldsDialog();
					}));

				// update the tooltip if there are two or more fields (BugId:6726)
				var noFields = $('#EditPageHiddenFields').find('input[type!="hidden"]').length;
				if (noFields >= 2) {
					$('#EditPageTitle').attr('title', $.msg('editpagelayout-edit-info'));
				}
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

		// Enable 'Publish' button when the editor is ready (BugId:13957)
		onEditorReady: function () {
			$('#wpSave').removeAttr('disabled');
		},

		// handle "Save" button
		onSave: function (event) {
			event.preventDefault();

			if (this.editor.fire('save') === false) {
				return;
			}

			if (this.textarea.val() == this.textarea.attr('placeholder')) {
				this.textarea.val('');
			}

			this.editor.setState(this.editor.states.SAVING);
			if (window.veTrack) {
				veTrack({
					action: 'ck-save-button-click',
					isDirty: (typeof this.editor.plugins.leaveconfirm === 'undefined' || this.editor.plugins.leaveconfirm.isDirty()) ? 'yes' : 'no'
				});
			}
			this.editor.track({
				action: Wikia.Tracker.ACTIONS.SUBMIT,
				label: 'publish'
			});

			// prevent submitting immediately so we can track this event
			this.editform.off('submit');
			setTimeout(this.proxy(function () {
				this.editform.submit();
			}), 100);

			// block "Publish" button
			$('#wpSave').attr('disabled', true);
		},

		// handle keypressing in "Edit summary" field
		onSummaryKeypress: function (ev) {
			if (ev.keyCode == 13 /* enter */) {
				this.editor.track({
					action: Wikia.Tracker.ACTIONS.SUBMIT,
					label: 'summary-enter'
				});

				this.editform.submit();
			}
		},

		// handle keypressing on "Minor edit" checkbox
		onMinorEditKeypress: function (ev) {
			if (ev.keyCode == 13 /* enter */) {
				ev.preventDefault();
				return;
			}
		},

		// send AJAX request
		ajax: function (method, params, callback, skin) {
			var editor = typeof RTE == 'object' ? RTE.getInstance() : false;

			params = $.extend({
				page: window.wgEditPageClass ? window.wgEditPageClass : "",
				method: method,
				mode: editor.mode
			}, params);

			var url = window.wgEditPageHandler.replace('$1', encodeURIComponent(window.wgEditedTitle));

			if (skin) {
				url += '&type=full&skin=' + encodeURIComponent(skin);
			}

			return jQuery.post(url, params, function (data) {
				if (typeof callback == 'function') {
					callback(data);
				}
			}, 'json');
		},

		// get value of wpTitle field and update wgEditedTitle JS variable and page header title
		updateEditedTitle: function () {
			var title = $('[name=wpTitle]');

			if (title.exists()) {
				window.wgEditedTitle = title.val();
			}

			var prefix = '';

			if (wgEditedTitleNS !== '') {
				prefix = wgEditedTitleNS + ':';
			}

			if (wgEditedTitlePrefix !== '') {
				prefix += wgEditedTitlePrefix;
			}

			window.wgEditedTitle = prefix + window.wgEditedTitle;

			// BugId:2823
			$(window).trigger('editTitleUpdated', [window.wgEditedTitle]);

			this.titleNode.children('a').attr('href', wgArticlePath.replace('$1', window.wgEditedTitle)).attr('title', $.htmlentities(window.wgEditedTitle)).text(window.wgEditedTitle);

			$('#EditPageHeader').find('.hiddenTitle').show();
		},

		// return true if any of the required fields has no value
		checkForEmptyFields: function (fields) {
			var emptyRequiredFields = fields.find('label > *[data-required="1"]'), emptyCounter = 0;

			emptyRequiredFields.each(function () {
				if ($(this).val() == '') {
					emptyCounter++;
				}
			});

			return emptyCounter > 0;
		},

		// show dialog for providing required data (e.g. page title)
		renderHiddenFieldsDialog: function () {
			var self = this, dialogTitle = document.title;

			$.showCustomModal(dialogTitle, '<div class="fields"></div>', {
				id: 'HiddenFieldsDialog',
				width: 400,
				buttons: [
					{
						id: 'ok',
						defaultButton: true,
						message: $.htmlentities($.msg('ok')),
						handler: function () {
							var dialog = $('#HiddenFieldsDialog');

							// required data is provided - proceed by closing the dialog
							if (!self.checkForEmptyFields(dialog)) {
								self.hiddenFields.append(dialog.find('label'));
								self.updateEditedTitle();

								dialog.closeModal();

								if (typeof RTE == 'object') {
									self.editor.ck.config.startupFocus = true;
								}
								self.editor.editorFocus();
							}
						}
					}
				],

				// before showing the dialog move hidden fields from edit form to the dialog
				callback: function () {
					self.hiddenFields.children('label').appendTo($('#HiddenFieldsDialog .fields'));

					// set focus on the first field
					$('#HiddenFieldsDialog label').children().focus();

					//add press "Enter" = submit form functionality - BugId: 38480
					$('#HiddenFieldsDialog input[name="wpTitle"]').keypress(function (event) {
						if (event.keyCode == 13) {
							$('#ok').click();
						}
					});
				},
				// don't show close button, user has to click "Ok" and fields have to be validated
				showCloseButton: false,
				onClose: function () {
					return false;
				}
			});
		},

		// render dialog for callback form (eg. captcha)
		renderCallbackFieldsDialog: function () {
			var self = this, dialogTitle = document.title;

			// update modal's title when showing a captcha
			if ( $('#wpCaptchaWord').exists() ) {
				dialogTitle = $.htmlentities($.msg('editpagelayout-captcha-title'));
			}

			$.showCustomModal(dialogTitle, '<div class="fields"></div>', {
				id: 'HiddenFieldsDialog',
				width: 400,
				buttons: [
					{
						id: 'ok',
						defaultButton: true,
						message: $.htmlentities($.msg('savearticle')),
						handler: function () {
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
				callback: function () {
					self.callbackFields.children().appendTo($('#HiddenFieldsDialog .fields'));

					// set focus on the first field
					$('#HiddenFieldsDialog input[type!="hidden"]').focus();
				}
			});
		},

		// internal method, based on the editor content and some extraData, prepare a preview markup for the
		// preview dialog and pass it to the callback
		getPreviewContent: function (content, extraData, callback, skin) {
			// add section name when adding new section (BugId:7658)
			if (window.wgEditPageSection === 'new') {
				content = '== ' + this.getSummary() + ' ==\n\n' + content;
			} else {
				extraData.summary = this.getSummary();
			}

			extraData.content = content;

			if (window.wgEditPageSection !== null) {
				extraData.section = window.wgEditPageSection;
			}

			if (this.categories.length) {
				extraData.categories = this.categories.val();
			}

			this.ajax('preview', extraData, function (data) {
				callback(data);
			}, skin);
		},

		// render "Preview" modal
		// TODO: it would be nice if there weren't any hardcoded values in here.
		// Any changes to the article page or modal will break here. Also, get rid
		// of any widthType/gridLayout settings when the responsive layout goes out
		// for a global release.
		renderPreview: function (extraData, type) {
			var self = this;

			require([ 'wikia.breakpointsLayout' ], function (breakpointsLayout) {
				var previewPadding = 22, // + 2px for borders
					articleWidth = 660,
					width = articleWidth + (self.isGridLayout ? 30 : 0),
					config = self.editor.config;

				//See logic: \EditPageLayoutHelper::isWidePage
				if (config.isWidePage) {
					width += breakpointsLayout.getRailWidthWithSpacing() + (self.isGridLayout ? 20 : 0);
				}

				if (config.extraPageWidth) {
					// wide wikis
					width += config.extraPageWidth;
				}

				if (window.wgOasisResponsive || window.wgOasisBreakpoints) {
					var pageWidth = $('#WikiaPage').width(),
						minWidth = breakpointsLayout.getArticleMinWidth();

					// don't go below minimum width
					if (pageWidth <= minWidth) {
						pageWidth = minWidth;
					}

					width = pageWidth - breakpointsLayout.getArticlePadding();
				}

				// add article preview padding width
				width += previewPadding;

				var previewOptions = {
					width: width,
					//Most browsers have 17px wide scrollbars, 20px here is for safty net and round number
					//ie: http://www.textfixer.com/tutorials/browser-scrollbar-width.php
					//No need to run extra fancy JS to return value between 17 and 20
					scrollbarWidth: 20,
					onPublishButton: function () {
						$('#wpSave').click();
					},
					getPreviewContent: function (callback, skin) {
						self.getContent(function (content) {
							self.getPreviewContent(content, extraData, callback, skin);
						});
					}
				};

				// pass info about if it's a wide page (main page or page without right rail)
				previewOptions.isWidePage = config.isWidePage;
				previewOptions.currentTypeName = type;

				require(['wikia.preview'], function (preview) {
					preview.renderPreview(previewOptions);
				});
			});
		},

		// render "show diff" modal
		renderChanges: function () {
			var self = this;
			require([ 'wikia.ui.factory' ], function(uiFactory){
				uiFactory.init([ 'modal' ]).then(function(uiModal) {
					var previewModalConfig = {
						vars: {
							id: 'EditPageDialog',
							title: $.htmlentities($.msg('editpagelayout-pageControls-changes')),
							content: '<div class="ArticlePreview modalContent"><div class="ArticlePreviewInner">' +
								'</div></div>',
							size: 'large'
						}
					};
					uiModal.createComponent(previewModalConfig, function(previewModal) {
						previewModal.deactivate();

						previewModal.$content.on('click', function(event) {
							var target = $(event.target);
							target.closest('a').not('[href^="#"]').attr('target', '_blank');
						});

						self.getContent(function(content) {
							var section = $.getUrlVar('section') || 0,
								extraData = {
									content: content,
									section: parseInt(section, 10)
								};

							if (self.categories.length) {
								extraData.categories = self.categories.val();
							}

							$.when(
								// get wikitext diff
								self.ajax('diff' , extraData),

								// load CSS for diff
								mw.loader.using('mediawiki.action.history.diff')
							).done(function(ajaxData) {
								var data = ajaxData[ 0 ],
									html = '<h1 class="pagetitle">' + window.wgEditedTitle + '</h1>' + data.html;
								previewModal.$content.find('.ArticlePreview .ArticlePreviewInner').html(html);
								previewModal.activate();
							});
						});

						previewModal.show();
					});
				});
			});
		},

		getSummary: function () {
			var $wpSummary = $('#wpSummary'),
				summary = $wpSummary.val();

			// bugid-93498: IE fakes placeholder functionality by setting a real val
			if (summary === $wpSummary.attr('placeholder')) {
				summary = '';
			}

			return summary;

		},

		// get editor's content (either wikitext or HTML)
		// and call provided callback with wikitext as its parameter
		getContent: function (callback) {
			var editor = typeof RTE == 'object' ? RTE.getInstance() : false, mode = editor ? editor.mode : 'mw';

			callback = callback || function () {};

			switch (mode) {
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

})(this, jQuery);
