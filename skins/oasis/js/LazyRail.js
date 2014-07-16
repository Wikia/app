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
		params = {};

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

					if (window.ChatEntryPoint && typeof window.wgWikiaChatUsers !== 'undefined') {
						window.ChatEntryPoint.init();
					}

					// Fix any rail modules that use jQuery timeago (DAR-2344)
					if (typeof $.fn.timeago !== 'undefined') {
						rail.find('.timeago')
							.timeago();
					}

					if (window.Wikia && window.Wikia.initRailTracking) {
						Wikia.initRailTracking();
					}

					if (window.AIC2) {
						window.AIC2.init();
					}

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
