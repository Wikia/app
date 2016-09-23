$(function () {
	'use strict';

	function getParamsFromUrl() {
		var params = {},
			paramVal,
			qs = Wikia.Querystring(),
			i = 0,
			paramsToPreserve = ['noexternals', 'noads', 'uselang', 'mcache', 'rebuildmessages'],
			paramsToPreserveLength = paramsToPreserve.length;

		for (i = 0; i < paramsToPreserveLength; i++) {
			paramVal = qs.getVal(paramsToPreserve[i]);
			if (paramVal !== undefined) {
				params[paramsToPreserve[i]] = paramVal;
			}
		}
		return params;
	}

	var rail = $('#WikiaRail'),
		LAZY_LOADING_SAMPLING_RATIO = 10, // integer (0-100): 0 - no tracking, 100 - track everything */
		params = {},
		lazyLoadingTime;

	// Add lifecycle event for beginning lazy load
	rail.trigger('beginLoad.rail');

	if (rail.find('.loading').exists()) {
		params = {
			'articleTitle': window.wgTitle,
			'namespace': window.wgNamespaceNumber,
			'cb': window.wgStyleVersion
		};

		if (typeof wgSassLoadedScss !== 'undefined') {
			params.excludeScss = window.wgSassLoadedScss;
		}

		$.extend(params, getParamsFromUrl());

		$.nirvana.sendRequest({
			controller: 'RailController',
			method: (window.wgUserName) ? 'lazy' : 'lazyForAnons',
			data: params,
			type: 'get',
			format: 'json',
			callback: function (data) {
				var loadRailContents = function (data) {
					rail.addClass('loaded')
						.find('.loading')
						.remove()
						.end()
						.append(data.railLazyContent + data.js);

					if (LAZY_LOADING_SAMPLING_RATIO >= Math.floor((Math.random() * 100 + 1))) {
						lazyLoadingTime = (new Date()) - (window.wgNow || 0);

						Wikia.Tracker.track({
							action: Wikia.Tracker.ACTIONS.IMPRESSION,
							category: 'right-rail',
							label: 'lazy-loaded',
							trackingMethod: 'analytics',
							value: lazyLoadingTime
						});
					}

					if (window.ChatWidget && typeof window.wgWikiaChatUsers !== 'undefined') {
						window.ChatWidget.init();
					}

					// Fix any rail modules that use jQuery timeago (DAR-2344)
					if (typeof $.fn.timeago !== 'undefined') {
						rail.find('.timeago')
							.timeago();
					}

					if (window.Wikia && window.Wikia.initRailTracking) {
						Wikia.initRailTracking();
					}

					require([
						'ext.wikia.adEngine.slot.floatingMedrec',
						'wikia.window'
					], function (floatingMedrec, win) {
						win.wgAfterContentAndJS.push(floatingMedrec.init);
					});

					if (window.wgEnableLightboxExt) {
						window.LightboxLoader.init();
					}

					// Lifecycle event for once all content has been loaded
					rail.trigger('afterLoad.rail');
				};

				if (data.css.length === 0) {
					loadRailContents(data);
				} else {
					// TODO: This seems like an unnessary use of require, this whole module should
					// be converted into an AMD module and loader should just be added as a dependency
					// to the define() deps array
					require(['wikia.loader'], function (loader) {
						loader({
							type: loader.CSS,
							resources: data.css
						})
							.done(function () {
								loadRailContents(data);
							});
					});
				}
			}
		});
	}
});
