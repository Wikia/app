require(['jquery', 'wikia.window', 'wikia.tracker'], function($, win, tracker) {
	var track;

	// skip special pages
	if (win.wgNamespaceNumber === -1) {
		return;
	}

	// setup tracking functions
	track = tracker.buildTrackingFunction({
		action: tracker.ACTIONS.CLICK,
		trackingMethod: 'ga'
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

	// bind tracker on DOMready
	$(function() {
		var $article = $('#mw-content-text'),
			category = 'article';

		$article.on('mousedown', 'a', function(e) {
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
					category: category,
					label: label
				});
			}
		}).on('mousedown', '.editsection a', {
			category: category,
			label: 'section-edit'
		}, trackWithEventData);
	});
});
