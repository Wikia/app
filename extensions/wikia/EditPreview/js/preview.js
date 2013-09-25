/**
 * Preview for the editor, this should be moved to /resources/wikia/modules once we want to use it for several skins
 */
define( 'wikia.preview', [
	'wikia.window',
	'wikia.nirvana',
	'jquery',
	'wikia.loader',
	'wikia.mustache',
	'JSMessages',
	'wikia.tracker',
	'wikia.csspropshelper'
], function(
	window,
	nirvana,
	$,
	loader,
	mustache,
	msg,
	tracker,
	cssPropHelper
) {
	'use strict';

	var	$articleWrapper,
		// current design of preview has this margins to emulate page margins
		// TODO: when we will redesign preview to meet darwin design directions - this should be done differently and refactored
		articleMargin = 11, // 10px margin + 1px border
		// values for min and max are Darwin minimum and maximum supported article width.
		// This should be abstracted and stored in one place so it's available both for SASS and JS
		previewTypes = {
			current: {
				name: 'current',
				value: null
			},
			min: {
				name: 'min',
				value: 768 - articleMargin * 2
			},
			max: {
				name:'max',
				value: 1300 - articleMargin * 2
			}
		},
		isRailDropped = false,
		FIT_SMALL_SCREEN = 80; // pixels to be removed from modal width to fit modal on small screens, won't be needed when new modals will be introduced

	// show dialog for preview / show changes and scale it to fit viewport's height
	function renderDialog(title, options, callback) {
		options = $.extend({
			callback: function() {
				var contentNode = $('#EditPageDialog .ArticlePreviewInner');

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
					parent().css({
						'height': options.height || ($(window).height() - 250),
						'overflow': 'auto',
						'overflow-x': 'hidden'
					});

				if (typeof callback == 'function') {
					callback(contentNode);
				}
			},
			id: 'EditPageDialog',
			width: 680
		}, options);

		// use loading indicator before real content will be fetched
		var content = '<div class="ArticlePreview"><div class="ArticlePreviewInner"><img src="' + stylepath + '/common/images/ajax.gif" class="loading"></div></div>';

		$.showCustomModal(title, content, options);
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

		if (options.isRailDropped) {
			isRailDropped = true;
		}

		var dialogOptions = {
			buttons: [
				{
					id: 'close',
					message: msg('back'),
					handler: function() {
						$('#EditPageDialog').closeModal();
					}
				},
				{
					id: 'publish',
					defaultButton: true,
					message: msg('savearticle'),
					handler: options.onPublishButton
				}
			],
			width: (!isRailDropped) ? options.width : options.width - FIT_SMALL_SCREEN,
			className: 'preview',
			onClose: function() {
				$(window).trigger('EditPagePreviewClosed');
			}
		};
		// allow extension to modify the preview dialog
		$(window).trigger('EditPageRenderPreview', [dialogOptions]);

		renderDialog(msg('preview'), dialogOptions, function(contentNode) {

			if (isRailDropped) {
				contentNode.width(options.width - articleMargin * 2 - 15);
			}

			options.getPreviewContent(function(content, summary) {

				contentNode.html(content);

				// move "edit" link to the right side of heading names
				contentNode.find('.editsection').each(function() {
					$(this).appendTo($(this).next());
				});

				// add summary
				if (typeof summary != 'undefined') {
					$('<div>', {id: "EditPagePreviewEditSummary"}).
						width(options.width - 150).
						appendTo(contentNode.parent()).
						html(summary);
				}

				//adding type dropdown to preview
				if ( window.wgOasisResponsive ) {
					loader({
						type: loader.MULTI,
						resources: {
							mustache: 'extensions/wikia/EditPreview/templates/preview_type_dropdown.mustache'
						}
					}).done(function(response) {
							var $dialog = $('#EditPageDialog'),
								template = response.mustache[0],
								params = {
									options: [
										{
											value: previewTypes.current.name,
											name: msg('wikia-editor-preview-current-width')
										},
										{
											value: previewTypes.min.name,
											name: msg('wikia-editor-preview-min-width')
										},
										{
											value: previewTypes.max.name,
											name: msg('wikia-editor-preview-max-width')
										}
									],
									toolTipMessage: msg('wikia-editor-preview-type-tooltip')
								},
								html = mustache.render(template, params);

							$(html).insertAfter( $dialog.find('h1:first') );

							// fire an event once preview is rendered
							$(window).trigger('EditPageAfterRenderPreview', [contentNode]);

							// cache article wrapper selector and its initial width
							$articleWrapper = $( $dialog.find('.ArticlePreviewInner') );

							previewTypes.current.value = $articleWrapper.width();

							// attach events to type dropdown
							$('#previewTypeDropdown').on('change', function(event) {
								switchPreview($(event.target).val());
							});

							var tooltipParams = { placement: 'right' };
							if( $dialog[0] && $dialog[0].style && $dialog[0].style.zIndex ) {
								// on Chrome when using $.css('z-index') / $.css('zIndex') it gave me 2e+9
								// this vanilla solution works better
								tooltipParams['z-index'] = parseInt( $dialog[0].style.zIndex, 10 );
							}

							$('.tooltip-icon').tooltip( tooltipParams );
						}
					);
				} else {
					// fire an event once preview is rendered
					$(window).trigger('EditPageAfterRenderPreview', [contentNode]);
				}

			});
		});
	}

	/**
	 * change preview type
	 *
	 * @param {string} type - type of the preview
	 */

	function switchPreview(type) {
		$articleWrapper.width(previewTypes[type].value);

		tracker.track({
			action: Wikia.Tracker.ACTIONS.CLICK,
			category: 'edit-preview',
			label: 'preview-type-changed',
			trackingMethod: 'both',
			value: type
		});

		scalePreview(type);
	}

	/**
	 * Scale articleWrapper so it fits current modal size
	 *
	 * @param {string} type - type of the preview
	 */

	function scalePreview(type) {
		var	initialPreviewWidth = previewTypes.current.value,
			selectedPreviewWidth = previewTypes[type].value,
			scaleRatio = initialPreviewWidth / selectedPreviewWidth,
			cssTransform = cssPropHelper.getSupportedProp('transform'),
			cssTransformOrigin = cssPropHelper.getSupportedProp('transform-origin');

		if (selectedPreviewWidth > initialPreviewWidth) {
			var	scaleVar = 'scale(' + scaleRatio + ')';
			$articleWrapper.css(cssTransformOrigin, 'left top');
			$articleWrapper.css(cssTransform , scaleVar);
		} else {
			$articleWrapper.css(cssTransform, '');
		}
	}

	/** @public **/
	return {
		renderPreview: renderPreview,
		renderDialog: renderDialog
	};
});
