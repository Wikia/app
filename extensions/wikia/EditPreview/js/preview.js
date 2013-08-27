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

	/**
	 * Display a dialog with article preview. Options passed in the object are:
	 *  - 'width' - dialog width in pixels
	 *  - 'onPublishButton' - callback function launched when user presses the 'Publish' button on the dialog
	 *  - 'getPreviewContent' - callback function called when the dialog tries to fetch the current article content from
	 *    the editor. this function takes a callback as a parameter and is supposed to call it with two parameters. the
	 *    first parameter is the article markup, the second is the edit summary markup
	 *  Additionally the preview dialog triggers the EditPagePreviewClosed event when the dialog is closed.
	 *
	 * @param options object containing dialog options, see method description for details
	 */
	function renderPreview(options) {
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

			options.getPreviewContent(function(content, summary) {

				contentNode.html(content);

				// move "edit" link to the right side of heading names
				contentNode.find('.editsection').each(function() {
					jquery(this).appendTo(jquery(this).next());
				});

				// add summary
				if (typeof summary != 'undefined') {
					jquery('<div>', {id: "EditPagePreviewEditSummary"}).
						width(options.width - 150).
						appendTo(contentNode.parent()).
						html(summary);
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

			});
		});
	}

	/** @public **/
	return {
		renderPreview: renderPreview
	};
});
