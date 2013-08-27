/**
 * Preview for the editor, this should be moved to /resources/wikia/modules once we want to use it for several skins
 */
define('wikia.preview', ['wikia.window','wikia.nirvana','wikia.deferred','jquery', 'wikia.loader', 'wikia.mustache', 'JSMessages'],
	function(window, nirvana, deferred, jquery, loader, mustache, msg) {
	'use strict';

	// show dialog for preview / show changes and scale it to fit viewport's height
	function renderDialog(title, options, callback) {
		options = jquery.extend({
			callback: function() {
				var contentNode = jquery('#EditPageDialog .ArticlePreview');

				// block all clicks
				contentNode.
					bind('click', function(ev) {
						var target = $(ev.target);

						target.attr('target','_blank');
						// don't block links opening in new tab
						if (target.attr('target') !== '_blank') {
							ev.preventDefault();
						}
					}).
					css({
						'height': options.height || (jquery(window).height() - 250),
						'overflow': 'auto'
					});

				if (typeof callback == 'function') {
					callback(contentNode);
				}
			},
			id: 'EditPageDialog',
			width: 680
		}, options);

		// use loading indicator before real content will be fetched
		var content = '<div class="ArticlePreview"><img src="' + stylepath + '/common/images/ajax.gif" class="loading"></div>';

		jquery.showCustomModal(title, content, options);
	}

	function renderPreview(options, extraData) {
		var dialogOptions = {
			buttons: [
				{
					id: 'close',
					message: msg('back'),
					handler: function() {
						jquery('#EditPageDialog').closeModal();
					}
				},
				{
					id: 'publish',
					defaultButton: true,
					message: msg('savearticle'),
					handler: options.onPublishButton
				}
			],
			width: options.width,
			className: 'preview',
			onClose: function() {
				$(window).trigger('EditPagePreviewClosed');
			}
		};
		// allow extension to modify the preview dialog
		jquery(window).trigger('EditPageRenderPreview', [dialogOptions]);

		renderDialog(msg('preview'), dialogOptions, function(contentNode) {
			options.getEditorContent(function(content) {
				// add section name when adding new section (BugId:7658)
				if (window.wgEditPageSection == 'new') {
					content = '== ' + options.summary + ' ==\n\n' + content;
				}
				else {
					extraData.summary = options.summary;
				}

				extraData.content = content;

				if (window.wgEditPageSection !== null) {
					extraData.section = window.wgEditPageSection;
				}

				options.getPreviewContent(extraData,
					function(data) {
						contentNode.html(data.html + data.catbox + data.interlanglinks);

						// move "edit" link to the right side of heading names
						contentNode.find('.editsection').each(function() {
							jquery(this).appendTo(jquery(this).next());
						});

						// add summary
						if (typeof data.summary != 'undefined') {
							jquery('<div>', {id: "EditPagePreviewEditSummary"}).
								width(options.width - 150).
								appendTo(contentNode.parent()).
								html(data.summary);
						}

						//adding type dropdown to preview
						if ( window.wgOasisResponsive ) {
							loader({type: loader.MULTI, resources: {
								mustache: 'extensions/wikia/EditPreview/templates/preview_type_dropdown.mustache'
							}}).done(function(response) {
									var template = response.mustache[0],
										params = {
											options: [
												{
													value: 'current',
													name: msg('wikia-editor-preview-current-width')
												},
												{
													value: 'min',
													name: msg('wikia-editor-preview-min-width')
												},
												{
													value: 'max',
													name: msg('wikia-editor-preview-max-width')
												}
											],
											toolTipMessage: msg('wikia-editor-preview-type-tooltip'),
											toolTipIcon: '',
											toolTipIconAlt: 'tooltip'
										},
										html = mustache.render(template, params);

									jquery(html).insertBefore(contentNode.parent().parent());

									// fire an event once preview is rendered
									jquery(window).trigger('EditPageAfterRenderPreview', [contentNode]);
								});
						} else {
							// fire an event once preview is rendered
							jquery(window).trigger('EditPageAfterRenderPreview', [contentNode]);
						}

					}
				);
			});
		});

	}

	/** @public **/
	return {
		renderPreview: renderPreview
	};
});
