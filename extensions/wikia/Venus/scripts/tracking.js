require(['jquery', 'wikia.window', 'wikia.tracker'], function ($, win, tracker) {
	'use strict';

	var track, trackEditorComponent;

	// skip special pages
	if (win.wgNamespaceNumber === -1) {
		return;
	}

	// setup tracking functions
	track = tracker.buildTrackingFunction({
		action: tracker.ACTIONS.CLICK,
		trackingMethod: 'analytics'
	});

	function trackWithEventData(e) {
		// Primary mouse button only
		if (e.type === 'mousedown' && e.which !== 1) {
			return;
		}

		track({
			browserEvent: e
		}, e.data);
	}

	// For tracking components which are used inside and outside of the editor.
	trackEditorComponent = (function() {
		var slice = Array.prototype.slice;

		return function() {
			var wikiaEditor = window.WikiaEditor && WikiaEditor.getInstance(),
				track = Wikia.Tracker.track;

			// Determine whether or not to track through the editor tracking method:
			// - If an editor is present on the page and is not a MiniEditor, then it must be the main editor.
			// - If an editor is present on the page and is a MiniEditor, make sure it currently has focus.
			// - Otherwise, assume that we are not tracking through the editor.
			if ( wikiaEditor && ( !wikiaEditor.config.isMiniEditor || wikiaEditor.plugins.MiniEditor.hasFocus ) ) {
				track = WikiaEditor.track;
			}

			track.apply( track, slice.call( arguments ) );
		};
	})();

	// bind tracker on DOMready
	$(function () {
		var $article = $('#mw-content-text'),
			$alliance = $('.alliance-module', $article),
			categoryArticle = 'article',
			categoryAlliance = 'Alliance';

		$article.on('mousedown', 'a', function (e) {
			var label,
				el = $(e.currentTarget);

			// Primary mouse button only
			if (e.which !== 1) {
				return;
			}

			if (el.hasClass('video')) {
				label = 'video';
			} else if (el.hasClass('image')) {
				label = 'image';
			} else if (el.parents('.infobox, .wikia-infobox').length > 0) {
				label = 'infobox';
			} else if (el.hasClass('external')) {
				label = 'link-external';
			} else if (el.hasClass('wikia-photogallery-add')) {
				label = 'add-photo-to-gallery';
			} else if (el.prop('className') == '') {
				label = 'link-internal';
			}

			if (typeof label !== 'undefined') {
				track({
					browserEvent: e,
					category: categoryArticle,
					label: label
				});
			}
		}).on('mousedown', '.editsection a', {
			category: categoryArticle,
			label: 'section-edit'
		}, trackWithEventData);

		if ($alliance.length) {
			$alliance.on('mousedown', 'a', function(e){
				var label,
					suffix;

				suffix = '-click';
				if ($(this).attr('href').indexOf('www.wikia.com/Alliance') !== -1) {
					suffix = '-logo-click';
				}
				label = $(e.delegateTarget).attr('data-label');

				if (label !== undefined) {
					label += suffix;
					track({
						category: categoryAlliance,
						label: label
					});
				}
			});

			$alliance.each(function(){
				var label,
					suffix;

				suffix = '-impression';
				label = $(this).attr('data-label');

				if (label !== undefined) {
					label += suffix;
					track({
						action: tracker.ACTIONS.IMPRESSION,
						category: categoryAlliance,
						label: label
					});
				}
			});
		}
	});

	Wikia.trackEditorComponent = trackEditorComponent;
});
