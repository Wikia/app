define('ext.wikia.curatedTour.editBox',
	[
		'jquery',
		'mw',
		'wikia.cache',
		'wikia.cookies',
		'wikia.loader',
		'wikia.mustache',

	],
	function($, mw, cache, cookies, loader, mustache) {

		var	resources,
			resourcesCacheKey = 'curatedTourEditBox',
			cacheVersion = '1.0',
			editModeCookieName = 'curatedTourEditBoxEditMode',
			wikiId = mw.config.get('wgCityId'),
			currentTourCacheKey = 'currentCuratedTour:' + wikiId;

		function init() {
			enterEditMode();
			//resources = cache.get(getResourcesCacheKey());
			resources = null;
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

			$.when(getCurrentTour).done(function (currentTour) {
				var templateData = {
					title: mw.message('curated-tour-edit-box-title').escaped(),
					currentTour: currentTour
				}

				$('body').append(mustache.to_html(
					resources.mustache[0],
					templateData,
					{
						editBoxItem: resources.mustache[1]
					}
				));
			});
		}

		function getCurrentTour() {
			var currentTour = cache.get(currentTourCacheKey);

			if (currentTour === null) {
				nirvana.sendRequest({
					controller: 'CuratedTourController',
					method: 'getCuratedTourData',
					callback: function (json) {
						currentTour = json;
					}
				});
			}

			return currentTour;
		}

		function setCurrentTour(json) {
			cache.set(currentTourCacheKey, json, cache.CACHE_SHORT);
		}

		function isInEditMode() {
			return !!cookies.get(editModeCookieName);
		}

		function enterEditMode() {
			cookies.set(editModeCookieName, '1', {expires: cache.CACHE_SHORT});
		}

		function exitEditMode() {
			cookies.set(editModeCookieName);
		}

		function getResourcesCacheKey() {
			return resourcesCacheKey + ':' + cacheVersion;
		}

		return {
			init: init
		}
	}
)
