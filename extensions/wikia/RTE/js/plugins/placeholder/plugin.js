CKEDITOR.plugins.add('rte-placeholder',
{
	previews: false,

	init: function(editor) {
		var self = this;

		editor.on('instanceReady', function() {
			// add node in which template previews will be stored
			self.previews = $('<div>', {
				id: 'RTEPlaceholderPreviews',
				'class': 'rte-placeholder-previews'
			}).appendTo(RTE.overlayNode);
		});

		editor.on('wysiwygModeReady', function() {
			// clean previews up
			if (typeof self.previews == 'object') {
				self.previews.html('');
			}

			// get all placeholders (template / magic words / double underscores / broken image links)
			var placeholders = RTE.tools.getPlaceholders();

			// if placeholder does not have content, render green puzzle
			placeholders.each(function (p) {
				var $placeholder = $(placeholders.get(p));

				// to check if content of placeholder is empty we need to get rid of non-width spaces (replace does not
				// change the original string)
				if ( $.trim($placeholder.html().replace(/[\u200B]/, '')) === '') {
					// empty gif in scr
					$placeholder.html('<img class="empty-placeholder" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7">');
				}
			});

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
			preview.bind('mouseover', function(event) {
				// don't hide this preview
				self.showPreview(placeholder, event);
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
				var isEditable = false;

				// messages
				var lang = RTE.getInstance().lang.hoverPreview;

				switch(info.type) {
					case 'tpl':
						className = 'RTEPlaceholderPreviewTemplate';

						title = info.title.replace(/_/g, ' ').replace(/^Template:/, window.RTEMessages.template + ':');
						intro = info.exists ? lang.template.intro : lang.template.notExisting;

						// is this template editable?
						isEditable = (typeof info.availableParams != 'undefined' && info.availableParams.length);
						break;

					case 'comment':
						title = lang.comment.title;
						intro = lang.comment.intro;

						isEditable = true;
						break;

					case 'broken-image':
						className = 'RTEPlaceholderPreviewBrokenImage';

						// image name (just image name - no parameteres and no brackets)
						var imageName = data.wikitext.replace(/^\[\[/, '').replace(/\]\]$/, '').split('|').shift();
						title = imageName;

						intro = lang.media.notExisting;
						break;
					case 'ext':
						title = data.extName;
						intro = lang.codedElement.intro;
						break;
					default:
						title = lang.codedElement.title;
						intro = lang.codedElement.intro;
						break;
				}

				// cut text in position 1 (heading) after 40 characters, followed by an ellipsis
				if (title.length > 40) {
					title = title.substr(0, 40) + RTEMessages.ellipsis;
				}

				// render [edit] / [delete] buttons
				var tools = '',
					showEdit = true;

				if (showEdit && isEditable) {
					tools += '<img class="sprite edit" src="'+wgBlankImgUrl+'" />' +
						'<a class="RTEPlaceholderPreviewToolsEdit">' + lang.edit + '</a>';
				}

				tools += '<img class="sprite remove" src="'+wgBlankImgUrl+'" />' +
					'<a class="RTEPlaceholderPreviewToolsDelete">' +
					lang['delete'] + '</a>';

				//
				// render HTML
				//
				// preview "header"
				var html = '<div class="RTEPlaceholderPreviewInner ' + className + '">';

				html += '<div class="RTEPlaceholderPreviewTitleBar color1"><span />' + title + '</div>';

				// [edit] / [delete]
				html += '<div class="RTEPlaceholderPreviewTools">' + tools + '</div>';

				html += '</div>';

				// set HTML and type attribute
				preview.removeClass('RTEPlaceholderPreviewLoading').html(html).attr('type', info.type);

				// handle clicks on [delete] button
				preview.find('.RTEPlaceholderPreviewToolsDelete').bind('click', function(ev) {
					var trackingLabel = 'button-delete';
					if (info.templateType) {
						trackingLabel += '-' + info.templateType;
					}

					self.track( trackingLabel );

					RTE.tools.confirm(title, lang.confirmDelete, function() {
						RTE.tools.removeElement(placeholder);

						// remove preview
						preview.remove();

					}).data( 'tracking', {
						category: 'placeholder'
					});
				});

				// handle clicks on [edit] button
				if (showEdit && isEditable) {
					preview.find('.RTEPlaceholderPreviewToolsEdit').bind('click', function(ev) {
						// hide preview
						preview.hide();

						var trackingLabel = 'button-edit';
						if (info.templateType) {
							trackingLabel += '-' + info.templateType;
						}

						self.track( trackingLabel );

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
					self.track( 'button-close' );
					self.hidePreview(placeholder, true);
				});

				// store template / magic word data in placeholder data
				if (data.type == 'double-brackets') {
					placeholder.data('info', info);
				}

				// try to remove scrollbars (RT #34048)
				self.expandPlaceholder(placeholder);
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
	showPreview: function(placeholder, event) {
		var preview = this.getPreview(placeholder);

		// position preview node
		if (!preview.is(':visible')) {
			preview.css({
				'left': event.clientX + 'px',
				'top': event.clientY + 'px'
			});
		}

		// hide remaining previews
		this.previews.children().not(preview).each(function() {
			$(this).hide();
		});

		// hover preview popup delay: 150ms (cursor should be kept over an placeholder for 150ms for preview to show up)
		var self = this;
		placeholder.data('showTimeout', setTimeout(function() {

			// show preview pop-up
			if (!preview.is(':visible')) {
				preview.fadeIn();

				self.track({
					action: Wikia.Tracker.ACTIONS.HOVER,
					label: 'show'
				});
			}

			// try to remove scrollbars (RT #34048)
			self.expandPlaceholder(placeholder);
		}, 150));

		// clear timeout used to hide preview with small delay
		var timeoutId = placeholder.data('hideTimeout');
		if (timeoutId) {
			clearTimeout(timeoutId);
		}
	},

	// hide preview popup
	hidePreview: function(placeholder, hideNow) {
		var preview = this.getPreview(placeholder),
			showTimeout = placeholder.data('showTimeout')

		// clear show timeout
		if (showTimeout) {
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

		// unbind previous events
		placeholder.unbind('.placeholder');

		placeholder.bind('mouseover.placeholder', function(event) {
			self.showPreview($(this), event);
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

		// setup events once more on each drag&drop
		RTE.getEditor().unbind('dropped.placeholder').bind('dropped.placeholder', function(ev) {
			var target = $(ev.target);

			// filter out non placeholders
			target = target.filter('img.placeholder');

			self.setupPlaceholder(target);
		});

		// RT #69635
		if (RTE.config.disableDragDrop) {
			RTE.tools.disableDragDrop(placeholder);
		}
	},

	// expand placeholder preview (RT #34048)
	expandPlaceholder: function(placeholder) {
		var preview = this.getPreview(placeholder);

		// detect if scrollbar is shown
		var previewArea = preview.find('.RTEPlaceholderPreviewCode');

		if (previewArea.exists()) {
			var domNode = previewArea[0];
			var scrollBarIsShown = (domNode.scrollHeight > domNode.clientHeight) || (domNode.scrollWidth > domNode.clientWidth);

			if (scrollBarIsShown) {
				//RTE.log('expanding hover preview...');

				// initial values (remove scrollbar completely)
				var height = domNode.scrollHeight;
				var width = domNode.scrollWidth;

				//RTE.log([width, height]);

				// (x,y) of bottom right corner of preview
				var x = parseInt(preview.offset().left) + width + 16;
				var y = parseInt(preview.offset().top) + height + 100;

				//RTE.log([x, y]);

				// calculate editarea size
				var editArea = document.getElementById('cke_1_contents'),
					editAreaBounds = editArea.getBoundingClientRect();
				var maxX = editAreaBounds.x + editAreaBounds.width;
				var maxY = editAreaBounds.y + editAreaBounds.height;

				//RTE.log([maxX, maxY]);

				// limit preview expansion by edges of editarea
				if (maxX < x) {
					width -= (x - maxX);
				}

				if (maxY < y) {
					height -= (y - maxY);
				}

				//RTE.log([width, height]);

				// now let's use it (minimum size is 350x60)
				width = Math.max(width, 350);
				height = Math.max(height, 60);

				preview.children('.RTEPlaceholderPreviewInner').width(width);
				previewArea.height(height);

				previewArea.addClass('RTEPlaceholderPreviewExpanded');
			}
			else {
				previewArea.removeClass('RTEPlaceholderPreviewExpanded');
			}
		}
	},

	track: (function() {
		var	config = {
				category: 'placeholder'
			},
			slice = [].slice,
			track = WikiaEditor.track;

		return function() {
			track.apply( track, [ config ].concat( slice.call( arguments ) ) );
		};
	})()
});
