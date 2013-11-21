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
	'wikia.fluidlayout',
	'wikia.throbber'
], function(
	window,
	nirvana,
	$,
	loader,
	mustache,
	msg,
	tracker,
	cssPropHelper,
	fluidlayout,
	throbber
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
		previewTypes = null,
		currentType,
		options;

	// show dialog for preview / show changes and scale it to fit viewport's height
	function renderDialog(title, options, callback) {
		options = $.extend({
			callback: function() {
				var contentNode = $('#EditPageDialog .ArticlePreviewInner');

				// block all clicks
				contentNode.
					bind('click', function(ev) {
						var target = $(ev.target);

						//links to other pages should be open in new windows
						target.closest( 'a' ).not( '[href^="#"]' ).attr( 'target', '_blank' );
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
		var content = '<div class="ArticlePreview"><div class="ArticlePreviewInner"><img src="' + stylepath + '/common/images/ajax.gif" class="loading"></div></div>';

		$.showCustomModal(title, content, options);
	}


	function loadPreview( opening ){
		if ( !opening ) {
			$article.parent().startThrobbing();
		}

		options.getPreviewContent(function(content, summary) {
			$article.html( content ).parent().stopThrobbing();

			if (window.wgOasisResponsive) {
				if ( !opening ) {
					$article.width( previewTypes[currentType].value );
				} else if (isRailDropped || isWidePage) {
					// set proper preview width for shrinken modal
					$article.width(options.width - articleMargin * 2);

					// set current width of the article
					previewTypes.current.value = $article.width();

					// get width of article Wrapper
					articleWrapperWidth = $article.parent().width();

					// subtract scrollbar width to get correct width needed as reference point for scaling
					articleWrapperWidth -= options.scrollbarWidth;
				}

				// initial scale of article preview
				scalePreview( currentType );
			}

			// move "edit" link to the right side of heading names
			$article.find('.editsection').each(function() {
				$(this).appendTo($(this).next());
			});

			addEditSummary( $article, options.width, summary );

			// fire an event once preview is rendered
			$(window).trigger('EditPageAfterRenderPreview', [$article]);
		});
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
	function renderPreview(option) {
		isRailDropped = (option.isRailDropped) ? true : false;
		isWidePage = (option.isWidePage) ? true : false;
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
					handler: option.onPublishButton
				}
			],
			// set modal width based on screen size
			width: ( (isRailDropped === false && isWidePage === false) || !window.wgOasisResponsive ) ? option.width : option.width - FIT_SMALL_SCREEN,
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
			options = option;

			loadPreview( true );

			// adding type dropdown to preview
			loader({
				type: loader.MULTI,
				resources: {
					mustache: 'extensions/wikia/EditPreview/templates/preview_type_dropdown.mustache'
				}
			}).done(function(response) {
				var $dialog = $('#EditPageDialog'),
					template = response.mustache[0],
					tooltipParams = { placement: 'right' },
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
							},
							{
								value: previewTypes.mobile.name,
								name: msg('wikia-editor-preview-mobile-width')
							}
						],
						toolTipMessage: msg('wikia-editor-preview-type-tooltip')
					},
					html = mustache.render(template, params);

				$(html).insertAfter( $dialog.find('h1:first') );

				// fire an event once preview is rendered
				$(window).trigger('EditPageAfterRenderPreview', [$article]);

				// attach events to type dropdown
				$('#previewTypeDropdown').on('change', function(event) {
					switchPreview($(event.target).val());
				});

				if( $dialog[0] && $dialog[0].style && $dialog[0].style.zIndex ) {
					// on Chrome when using $.css('z-index') / $.css('zIndex') it returns 2e+9
					// this vanilla solution works better
					tooltipParams['z-index'] = parseInt( $dialog[0].style.zIndex, 10 );
				}

				$('.tooltip-icon').tooltip( tooltipParams );
			});
		});
	}

	/**
	 * If summary parameter's type isn't undefined adds summary (new DOM element) and change height of article preview
	 *
	 * @param {object} contentNode article's wrapper
	 * @param {int} width
	 * @param {string} summary Summary text in HTML (parsed wikitext)
	 */

	function addEditSummary( contentNode, width, summary ) {
		if (typeof summary !== 'undefined') {
			var $editPagePreviewEditSummary = $('<div>', {id: 'EditPagePreviewEditSummary'}),
				$articlePreview = contentNode.closest('.ArticlePreview'),
				articleHeight = $articlePreview.height(),
				minArticleHeight = 200;

			$editPagePreviewEditSummary .
				width( width ) .
				appendTo( $articlePreview.parent() ) .
				html(summary);

			var editSummaryHeight = $editPagePreviewEditSummary.height(),
				newArticleHeight = articleHeight - editSummaryHeight;

			if( newArticleHeight > minArticleHeight ) {
				$articlePreview.height( newArticleHeight );
			}
		}
	}

	/**
	 * change preview type
	 *
	 * @param {string} type - type of the preview
	 */

	function switchPreview( type ) {
		if ( type === previewTypes.mobile.name ) {
			loadMobilePreview();
		} else {
			if ( currentType === previewTypes.mobile.name ) {
				loadPreview();
			}else {
				$article.width( previewTypes[type].value );
				scalePreview( type );
			}
		}

		tracker.track({
			action: Wikia.Tracker.ACTIONS.CLICK,
			category: 'edit-preview',
			label: 'preview-type-changed',
			trackingMethod: 'both',
			value: type
		});

		currentType = type;
	}

	function loadMobilePreview() {
		$article.parent().startThrobbing();

		options.getPreviewContent( function(content, summary, data) {
			$article
				.width( previewTypes.current.value )
				.parent()
				.stopThrobbing();

			scalePreview( 'current' );

			var iframe = $article.html( '<iframe class="mobile-preview"></iframe>' ).find( 'iframe' )[0],
				doc = iframe.document;

			if ( iframe.contentDocument ) {
				doc = iframe.contentDocument;
			}else if ( iframe.contentWindow ) {
				doc = iframe.contentWindow.document;
			}

			doc.open();
			doc.writeln( data.html );
			doc.close();

		}, previewTypes.mobile.skin );
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
			$article
				.css(cssTransformOrigin, 'left top')
				.css(cssTransform , scaleVar);
		} else {
			$article.css(cssTransform, '');
		}

		// Force browser to redraw/repaint - http://stackoverflow.com/questions/3485365/how-can-i-force-webkit-to-redraw-repaint-to-propagate-style-changes
		$article.hide();
		$article.height();
		$article.show();
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
			},
			mobile: {
				name: 'mobile',
				skin: 'wikiamobile',
				value: null
			}
		};

		if( isWidePage ) {
			previewTypes.max.value += rightRailWidth;
		}

		currentType = previewTypes.current.name;

		return previewTypes;
	}

	/** @public **/
	return {
		renderPreview: renderPreview,
		renderDialog: renderDialog
	};
});
