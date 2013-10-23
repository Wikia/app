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
	'wikia.csspropshelper',
	'wikia.fluidlayout'
], function(
	window,
	nirvana,
	$,
	loader,
	mustache,
	msg,
	tracker,
	cssPropHelper,
	fluidlayout
) {
	'use strict';

	var	$article,
		// current design of preview has this margins to emulate page margins
		// TODO: when we will redesign preview to meet darwin design directions - this should be done differently and refactored
		articleMargin = fluidlayout.getWidthPadding() + fluidlayout.getArticleBorderWidth(),
		// values for min and max are Darwin minimum and maximum supported article width.
		rightRailWidth = fluidlayout.getRightRailWidth(),
		isRailDropped = false,
		isWidePage = false,
		articleWrapperWidth, // width of article wrapper needed as reference for preview scaling
		FIT_SMALL_SCREEN = 80, // pixels to be removed from modal width to fit modal on small screens, won't be needed when new modals will be introduced
		previewTypes = null;

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
					closest( '.ArticlePreview' ).css({
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
		var content = '<div class="ArticlePreview"><div class="ArticlePreviewInnerWrapper"><div class="ArticlePreviewInner"><img src="' + stylepath + '/common/images/ajax.gif" class="loading"></div></div></div>';

		$.showCustomModal(title, content, options);
	}

	/**
	 * Display a dialog with article preview. Options passed in the object are:
	 *  - 'width' - dialog width in pixels
	 *  - 'isRailDropped' - flag set to true for window size 1023 and below when responsive layout is enabled
	 *  - 'scrollbarWidth' - width of the scrollbar (need do be subtracted from article wrapper width as reference for scaling)
	 *  - 'onPublishButton' - callback function launched when user presses the 'Publish' button on the dialog
	 *  - 'getPreviewContent' - callback function called when the dialog tries to fetch the current article content from
	 *    the editor. this function takes a callback as a parameter and is supposed to call it with two parameters. the
	 *    first parameter is the article markup, the second is the edit summary markup
	 *  Additionally the preview dialog triggers the EditPagePreviewClosed event when the dialog is closed.
	 *
	 * @param options object containing dialog options, see method description for details
	 */
	function renderPreview(options) {
		isRailDropped = (options.isRailDropped) ? true : false;
		isWidePage = (options.isWidePage) ? true : false;
		previewTypes = getPreviewTypes( isWidePage );

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
			// set modal width based on screen size
			width: (isRailDropped === false) ? options.width : options.width - FIT_SMALL_SCREEN,
			className: 'preview',
			onClose: function() {
				$(window).trigger('EditPagePreviewClosed');
			}
		};

		// allow extension to modify the preview dialog
		$(window).trigger('EditPageRenderPreview', [dialogOptions]);

		renderDialog(msg('preview'), dialogOptions, function(contentNode) {
			// cache selector for other functions in this module
			$article = contentNode;

			options.getPreviewContent(function(content, summary) {

				contentNode.html(content);

				if (window.wgOasisResponsive) {

					// set proper preview width for shrinken modal
					if (isRailDropped) {
						contentNode.width(options.width - articleMargin * 2);
					}

					// set current width of the article
					previewTypes.current.value = contentNode.width();

					// get width of article Wrapper
					articleWrapperWidth = contentNode.parent().width();

					// subtract scrollbar width to get correct width needed as reference point for scaling
					articleWrapperWidth -= options.scrollbarWidth;

					// initial scale of article preview
					scalePreview(previewTypes.current.name);

					// adding type dropdown to preview
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

						// attach events to type dropdown
						$('#previewTypeDropdown').on('change', function(event) {
							switchPreview($(event.target).val());
						});

						var tooltipParams = { placement: 'right' };
						if( $dialog[0] && $dialog[0].style && $dialog[0].style.zIndex ) {
							// on Chrome when using $.css('z-index') / $.css('zIndex') it returns 2e+9
							// this vanilla solution works better
							tooltipParams['z-index'] = parseInt( $dialog[0].style.zIndex, 10 );
						}

						$('.tooltip-icon').tooltip( tooltipParams );
					});
				}

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

				// fire an event once preview is rendered
				$(window).trigger('EditPageAfterRenderPreview', [contentNode]);

			});
		});
	}

	/**
	 * change preview type
	 *
	 * @param {string} type - type of the preview
	 */

	function switchPreview(type) {
		console.log(previewTypes[type].value);
		$article.width(previewTypes[type].value);

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
		var selectedPreviewWidth = previewTypes[type].value,
			scaleRatio = articleWrapperWidth / selectedPreviewWidth,
			cssTransform = cssPropHelper.getSupportedProp('transform'),
			cssTransformOrigin = cssPropHelper.getSupportedProp('transform-origin'),
			scaleVar = 'scale(' + scaleRatio + ')';

		setClassesForWidePage( type, $article );

		if (selectedPreviewWidth > articleWrapperWidth) {
			$article.css(cssTransformOrigin, 'left top');
			$article.css(cssTransform , scaleVar);
		} else {
			$article.css(cssTransform, '');
		}

		// DAR-2182
		var newHeight = $article[0].getBoundingClientRect().height;
		newHeight += articleMargin;

		// we have a wrapper with overflow: hidden not to show white space after CSS scaling
		$article.parent().height( newHeight );
	}

	/**
	 * Adds/removes id to article preview according to selected type if it's a wide page
	 *
	 * @param {string} type type of
	 * @param {jQuery} $article
	 */

	function setClassesForWidePage( type, $article ) {
		var dataSize;

		// DAR-2506 make the preview works like correctly for main pages
		switch ( type ) {
			case 'min':
				dataSize = 'min';
				break;
			case 'max':
				dataSize = 'max';
				break;
			default:
				dataSize = '';
		}

		$article.attr( 'data-size', dataSize );
	}

	/**
	 * Returns previewTypes object which depends on the type of previewing page
	 *
	 * @param {boolean} isWidePage - type of previewing article page is it mainpage/a page without right rail or not (DAR-2366)
	 */

	function getPreviewTypes( isWidePage ) {
		var articleMinWidth = fluidlayout.getMinArticleWidth(),
			articleMaxWidth = fluidlayout.getMaxArticleWidth(),
			previewTypes = {
			current: {
				name: 'current',
				value: null
			},
			min: {
				name: 'min',
				value: articleMinWidth - 2 * articleMargin
			},
			max: {
				name:'max',
				value: articleMaxWidth - 2 * articleMargin
			}
		};

		if( isWidePage ) {
			previewTypes.max.value += rightRailWidth;
		}

		return previewTypes;
	}

	/** @public **/
	return {
		renderPreview: renderPreview,
		renderDialog: renderDialog
	};
});
