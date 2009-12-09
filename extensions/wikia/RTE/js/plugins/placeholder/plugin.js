CKEDITOR.plugins.add('rte-placeholder',
{
	previews: false,

	init: function(editor) {
		var self = this;

		editor.on('instanceReady', function() {
			// add node in which template previews will be stored
			self.previews = $('<div id="RTEPlaceholderPreviews" />');
			$('#RTEStuff').append(self.previews);
		});

		editor.on('wysiwygModeReady', function() {
			// clean previews up
			if (typeof self.previews == 'object') {
				self.previews.html('');
			}

			// get all placeholders (template / magic words / double underscores / broken image links)
			var placeholders = RTE.tools.getPlaceholders();

			// regenerate preview and template info
			placeholders.removeData('preview').removeData('info');

			self.setupPlaceholder(placeholders);
		});
	},

	// get preview HTML and infomration for given placeholder
	getPreview: function(placeholder) {
		var self = this;

		if (!this.previews) {
			// we're not ready yet
			return;
		}

		// get node in which preview is / will be stored
		var preview = placeholder.data('preview');

		// generate node where preview will be stored
		if (typeof preview == 'undefined') {
			// create preview node
			preview = $('<div>').addClass('RTEPlaceholderPreview RTEPlaceholderPreviewLoading');
			preview.html('<div class="RTEPlaceholderPreviewInner">&nbsp;</div>');

			// setup events
			preview.bind('mouseover', function() {
				// don't hide this preview
				self.showPreview(placeholder);
			});

			preview.bind('mouseout', function() {
				// hide this preview
				self.hidePreview(placeholder);
			});

			// add it and store it in placeholder data
			this.previews.append(preview);
			placeholder.data('preview', preview);

			// generate preview and get template information
			var data = placeholder.getData();

			// callback for RTE.tools.resolveDoubleBrackets()
			// (will be called directly for elements not wrapped inside double brackets)
			var renderPreview = function(info) {
				// different look for different types
				var title, intro;
				var className = 'RTEPlaceholderPreviewOther';
				var preformattedCode = true;
				var isEditable = false;

				// encode HTML inside wikisyntax
				var code = data.wikitext.replace(/</g, '&lt;').replace(/>/g, '&gt;');

				switch(info.type) {
					case 'tpl':
						className = 'RTEPlaceholderPreviewTemplate';

						title = info.title.replace(/_/g, ' ').replace(/^Template:/, window.RTEMessages.template + ':');
						intro = info.exists ? 'This is a template' : 'This template does not exist!';

						// show wikitext, if template does not exist
						code = info.exists ? info.html : data.wikitext;
						preformattedCode = !info.exists;

						// is this template editable?
						isEditable = (typeof info.availableParams != 'undefined' && info.availableParams.length);
						break;

					case 'comment':
						title = 'Comment';
						intro = 'This can only be seen during editing';

						// exclude comment beginning and end markers
						code = data.wikitext.replace(/^<!--\s+/, '').replace(/\s+-->$/, '');

						isEditable = true;
						break;

					case 'broken-image':
						className = 'RTEPlaceholderPreviewBrokenImage';

						// image name (just image name - no parameteres and no brackets)
						var imageName = data.wikitext.replace(/^\[\[/, '').replace(/]]$/, '').split('|').shift();
						title = imageName;

						intro = 'This image or file does not exist!';
						break;

					default:
						title = 'Coded element';
						intro = 'Please switch to source mode to edit';
						break;
				}

				// cut text in position 1 (heading) after 40 characters, followed by an ellipsis
				if (title.length > 40) {
					title = title.substr(0, 40) + RTEMessages.ellipsis;
				}

				// for IE replace \n with <br />
				if (preformattedCode && CKEDITOR.env.ie) {
					code = code.replace(/\n/g, '<br />');
				}

				// placeholder intro
				var intro = '<div class="RTEPlaceholderPreviewIntro">' + intro + '</div>';

				// render [edit] / [delete] buttons
				var tools = '',
					showEdit = true;

				var spriteImg = '<img class="sprite" src="http://images.wikia.com/common/skins/monobook/blank.gif?1" />';

				if (showEdit) {
					tools += '<a class="RTEPlaceholderPreviewToolsEdit' +
						(!isEditable ? ' RTEPlaceholderPreviewToolsButtonDisabled' : '') +
						'">' + spriteImg + 'edit</a>';
				}

				tools += '<a class="RTEPlaceholderPreviewToolsDelete">' + spriteImg + 'delete</a>';

				//
				// render HTML
				//
				var html = '';

				// preview "header"
				html += '<div class="RTEPlaceholderPreviewInner ' + className + '">';
				html += '<div class="RTEPlaceholderPreviewTitleBar color1"><span />' + title + '</div>';

				// second line
				html += intro;

				// preview content
				html += '<div class="RTEPlaceholderPreviewCode ' +
					(preformattedCode ? 'RTEPlaceholderPreviewPreformatted ' : '') +
					'reset">' + code + '</div>';

				// [edit] / [delete]
				html += '<div class="RTEPlaceholderPreviewTools neutral">' + tools + '</div>';

				html += '</div>';

				// set HTML and type attribute
				preview.removeClass('RTEPlaceholderPreviewLoading').html(html).attr('type', info.type);

				// handle clicks on [delete] button
				preview.find('.RTEPlaceholderPreviewToolsDelete').bind('click', function(ev) {
					RTE.track(self.getTrackingType($(placeholder)), 'hover', 'delete');

					if (confirm('Are you sure?')) {
						// remove placeholder and its preview
						preview.remove();
						$(placeholder).remove();
					}
				});

				// handle clicks on [edit] button
				if (showEdit && isEditable) {
					preview.find('.RTEPlaceholderPreviewToolsEdit').bind('click', function(ev) {
						// hide preview
						preview.hide();

						// tracking code
						RTE.track(self.getTrackingType($(placeholder)), 'hover', 'edit');

						// call editor for this type of placeholder
						$(placeholder).trigger('edit');
					});
				}

				// make links in preview unclickable
				preview.find('.RTEPlaceholderPreviewCode').bind('click', function(ev) {
					ev.preventDefault();
				});

				// close button
				preview.find('.RTEPlaceholderPreviewTitleBar').children('span').bind('click', function(ev) {
					RTE.track(self.getTrackingType($(placeholder)), 'hover', 'close');

					self.hidePreview(placeholder, true);
				});

				// store template / magic word data in placeholder data
				if (data.type == 'double-brackets') {
					placeholder.data('info', info);
				}
			};

			// get info from backend (only for templates and magic words)
			switch(data.type) {
				case 'double-brackets':
					RTE.tools.resolveDoubleBrackets(data.wikitext, renderPreview);
					break;

				default:
					renderPreview({type: data.type});
			}
		}

		return preview;
	},

	// show preview popup
	showPreview: function(placeholder) {
		var preview = this.getPreview(placeholder);

		// position preview node
		var position = RTE.tools.getPlaceholderPosition(placeholder);

		preview.css({
			'left': position.left + 'px',
			'top': parseInt(position.top + placeholder.height() + 6) + 'px'
		});

		// hide remaining previews
		this.previews.children().not(preview).each(function() {
			$(this).hide();
		});

		// hover preview popup delay: 150ms (cursor should be kept over an placeholder for 150ms for preview to show up)
		placeholder.data('showTimeout', setTimeout(function() {
			// trigger custom event only when preview is about to be shown (used for tracking)
			var visible = preview.css('display') == 'block';
			if (!visible) {
				placeholder.trigger('hover');
			}

			// show preview pop-up
			preview.fadeIn();
		}, 150));

		// clear timeout used to hide preview with small delay
		if (timeoutId = placeholder.data('hideTimeout')) {
			clearTimeout(timeoutId);
		}
	},

	// hide preview popup
	hidePreview: function(placeholder, hideNow) {
		var preview = this.getPreview(placeholder);

		// clear show timeout
		if (showTimeout = placeholder.data('showTimeout')) {
			clearTimeout(showTimeout);
		}

		if (hideNow) {
			// hide preview now - "close" has been clicked
			preview.hide();
		}
		else {
			// hide preview 1 sec after mouse is out
			placeholder.data('hideTimeout', setTimeout(function() {
				preview.fadeOut();

				placeholder.removeData('hideTimeout');
			}, 1000));
		}
	},

	// setup given placeholder
	setupPlaceholder: function(placeholder) {
		var self = this;

		// ignore image / video placeholders
		placeholder = placeholder.not('.placeholder-image-placeholder').not('.placeholder-video-placeholder');

		// no placeholders to setup - leave
		if (!placeholder.exists()) {
			return;
		}

		// don't allow users to resize placeholders
		placeholder.attr('contentEditable', false);

		// unbind previous events
		placeholder.unbind('.placeholder');

		placeholder.bind('mouseover.placeholder', function() {
			self.showPreview($(this));
		});

		placeholder.bind('mouseout.placeholder', function() {
			self.hidePreview($(this));
		});

		placeholder.bind('contextmenu.placeholder', function(ev) {
			// don't show CK context menu
			ev.stopPropagation();
		});

		// make placeholder not selecteable
		RTE.tools.unselectable(placeholder);

		// this event is triggered by clicking [edit] in preview pop-up
		placeholder.bind('edit.placeholder', function(ev) {
			var data = $(this).getData();

			// call appriopriate editor for this type of placeholder
			switch (data.type) {
				case 'double-brackets':
					RTE.templateEditor.showTemplateEditor($(this));
					break;

				case 'comment':
					RTE.commentEditor.showCommentEditor($(this));
					break;
			}
		});

		// tracking code when hovered
		placeholder.bind('hover.placeholder', function(ev) {
			RTE.track(self.getTrackingType($(this)), 'hover', 'init');
		});

		// setup events once more on each drag&drop
		RTE.getEditor().unbind('dropped.placeholder').bind('dropped.placeholder', function(ev) {
                        var target = $(ev.target);

			// filter out non placeholders
			target = target.filter('img[_rte_placeholder]');

			self.setupPlaceholder(target);
		});
	},

	// get type name for tracking code
	getTrackingType: function(placeholder) {
		var type;
		var data = $(placeholder).getData();

		switch(data.type) {
			case 'double-brackets':
				type = 'template';
				break;

			case 'comment':
				type = 'comment';
				break;

			default:
				type = 'advancedCode';
		}

		return type;
	}
});
