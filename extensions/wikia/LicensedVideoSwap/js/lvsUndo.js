define('lvs.undo', [
	'wikia.querystring',
	'lvs.commonajax',
	'lvs.videocontrols',
	'wikia.nirvana',
	'jquery',
	'lvs.tracker'
], function (QueryString, commonAjax, videoControls, nirvana, $, tracker) {
	'use strict';

	var $container,
		videoTitle,
		newTitle,
		title,
		msg,
		qs,
		sort,
		page,
		wasSwap;

	function doRequest() {
		commonAjax.startLoadingGraphic();

		nirvana.sendRequest({
			controller: 'LicensedVideoSwapSpecialController',
			method: 'restoreVideo',
			data: {
				videoTitle: videoTitle,
				newTitle: newTitle,
				sort: sort,
				currentPage: page
			},
			callback: function (data) {
				// send info to common success method: response data and tracking label
				commonAjax.success(data, tracker.labels.UNDO);
			},
			onErrorCallback: function () {
				commonAjax.failure();
			}
		});
	}

	function init($elem) {
		$container = $elem;

		$('body').on('click', '.banner-notification .undo', function (e) {
			e.preventDefault();

			videoControls.reset();

			var $this = $(this);

			videoTitle = $this.attr('data-video-title');
			newTitle = $this.attr('data-new-title') || '';
			qs = new QueryString();
			sort = qs.getVal('sort', 'recent');
			page = qs.getVal('currentPage', 1);
			wasSwap = !! newTitle;

			if (wasSwap) {
				title = $.msg('lvs-confirm-undo-swap-title');
				msg = $.msg('lvs-confirm-undo-swap-message');
			} else {
				title = $.msg('lvs-confirm-undo-keep-title');
				msg = $.msg('lvs-confirm-undo-keep-message');
			}

			$.confirm({
				title: title,
				content: msg,
				onOk: function () {
					doRequest();

					// Track click on okay button
					tracker.track({
						action: tracker.actions.CONFIRM,
						label: tracker.labels.UNDO
					});
				},
				width: 700
			});

			tracker.track({
				action: tracker.actions.CLICK,
				label: tracker.labels.UNDO
			});
		});
	}

	return {
		init: init
	};
});
