define('ext.wikia.curatedTour.editBox',
	[
		'jquery',
		'mw',
		'wikia.cache',
		'wikia.cookies',
		'wikia.loader',
		'wikia.mustache',
		'wikia.nirvana',
		'BannerNotification'
	],
	function($, mw, cache, cookies, loader, mustache, nirvana, BannerNotification) {

		var	resources,
			resourcesCacheKey = 'curatedTourEditBox',
			cacheVersion = '1.0',
			editModeCookieName = 'curatedTourEditBoxEditMode',
			wikiId = mw.config.get('wgCityId'),
			currentTourCacheKey = 'currentCuratedTour:' + wikiId;

		function init() {
			//resources = cache.get(getResourcesCacheKey());
			enterEditMode();
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
					setupEditBox(res);
				});
			} else {
				setupEditBox(resources);
			}
		}

		function setupEditBox(res) {
			if (resources === null) {
				resources = res;
				cache.set(getResourcesCacheKey(), res, cache.CACHE_LONG);
			}

			console.log(res);

			loader.processStyle(res.styles);
			mw.messages.set(res.messages);

			getCurrentTourAndRenderEditBox();
		}

		function getCurrentTourAndRenderEditBox() {
			var currentTour = cache.get(currentTourCacheKey);

			if (currentTour === null) {
				nirvana.sendRequest({
					controller: 'CuratedTourController',
					method: 'getCuratedTourData',
					type: 'GET',
					callback: function (json) {
						renderEditBox(json.data);
					}
				});
			} else {
				renderEditBox(currentTour);
			}
		}

		function renderEditBox(currentTour) {
			var templateData = {
				title: mw.message('curated-tour-edit-box-title').escaped(),
				currentTour: currentTour,
				addNewStepText: mw.message('curated-tour-edit-box-add-new').escaped(),
				exitEditModeText: mw.message('curated-tour-edit-box-exit').escaped(),
				saveCurrentTourText: mw.message('curated-tour-edit-box-save').escaped()
			}

			$.when($('body').append(mustache.to_html(
				resources.mustache[0],
				templateData,
				{
					editBoxItem: resources.mustache[1]
				}
			))).done(bindEventsToEditBox);
		}

		function bindEventsToEditBox() {
			$('.ct-edit-box-controls-exit').on('click', exitEditMode);
			$('.ct-edit-box-controls-save').on('click', saveCurrentTour);
		}

		function saveCurrentTour(event) {
			event.preventDefault();

			nirvana.sendRequest({
				controller: 'CuratedTourController',
				method: 'setCuratedTourData',
				data: {
					edit_token: mw.user.tokens.get('editToken'),
					currentTourData: collectCurrentTour()
				},
				callback: function (json) {
					if (json.status) {
						new BannerNotification(
							mw.message('curated-tour-edit-box-save-success').escaped(),
							'confirm'
						).show();
					} else {
						new BannerNotification(
							mw.message('curated-tour-edit-box-save-failure').escaped(),
							'error'
						).show();
					}
				}
			});
		}

		function collectCurrentTour() {

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

		function exitEditMode(event) {
			event.preventDefault();

			$('#ct-edit-box').remove();
			cache.del(getCurrentTourAndRenderEditBox());
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
