define('ext.wikia.curatedTour.editBox',
	[
		'jquery',
		'mw',
		'wikia.loader',
		'wikia.cache',
		'wikia.mustache'
	],
	function($, mw, loader, cache, mustache) {

		var
			resources,
			resourcesCacheKey = 'curatedTourEditBox',
			cacheVersion = '1.0';

		function init() {
			resources = cache.get(getResourcesCacheKey());
			if (resources === null) {
				$.when(loader({
					type: loader.MULTI,
					resources: {
						messages: 'CuratedTourEditBox',
						mustache: '/extensions/wikia/CuratedTour/templates/editBox.mustache,/extensions/wikia/CuratedTour/templates/editBoxItem.mustache',
						styles: '/extensions/wikia/CuratedTour/styles/editBox.scss'
					}
				})).done(function (res) {
					resources = res;
					cache.set(getResourcesCacheKey(), res, cache.CACHE_LONG);

					renderEditBox();
				});
			} else {
				renderEditBox();
			}
		}

		function renderEditBox() {
			loader.processStyle(resources.styles);
			mw.messages.set(resources.messages);

			$('body').append(mustache.to_html(resources.mustache[0], {}, {
				editBoxItem: resources.mustache[1]
			}));
		}

		function getResourcesCacheKey() {
			return resourcesCacheKey + ':' + cacheVersion;
		}

		return {
			init: init
		}
	}
)
