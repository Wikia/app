require([
	'jquery',
	'templates.pyrkon',
	'wikia.mustache'
], function (
	$,
	templates,
	mustache
) {
	'use strict';

	function showResults() {
		$.ajaxSetup({
			crossDomain: true,
			xhrFields: {
				withCredentials: true
			},
			contentType: 'application/json; charset=utf-8'
		});

		return $.get('https://services.wikia.com/pyrkon-scavenger-hunt/games')
			.then(function (data) {
				if (!data) {
					// no results
				}

				var markup = mustache.render(templates['results'], {
					data: getNormalizedData(data)
				});

				$('.pyrkon-results tbody').html(markup);
			})
			.fail(function () {
				new window.BannerNotification('Could not fetch results.')
					.setType('error')
					.show();
			});
	}

	function getNormalizedData(data) {
		return data.map(function (each, index) {
			return Object.assign(each, {index: index + 1});
		});
	}

	showResults();
});
