/*global define, require*/
define('ext.wikia.adEngine.video.player.porvata.floaterConfiguration', [
		'wikia.window'
	], function (win) {
		'use strict';

		var slotsConfiguration = {
			'INCONTENT_PLAYER': {
				enableKeyword: 'enableInContentFloating',
				container: 'WikiaArticle',
				configure: function (floatingContext) {
					var elements = floatingContext.elements;

					elements.viewport = elements.ad.parentElement;
					floatingContext.forceDoNotFloat();
				},
				calculateViewportHeight: function (viewport) {
					return viewport.offsetHeight + 'px';
				},
				floatLater: function () {
					var floatingContext = this,
						video = this.elements.video;

					video.addEventListener('wikiaSlotExpanded', function () {
						var body = video.container.ownerDocument.body;

						floatingContext.preferred.width = body.scrollWidth;
						floatingContext.preferred.height = body.scrollHeight;
						floatingContext.floatAgain();
					});

				},
				onAttach: function (floatingContext) {
					var elements =floatingContext.elements;

					elements.ad.style.maxHeight = elements.ad.scrollHeight + 'px';
					elements.viewport.style.removeProperty('height');
				}
			},
			'TOP_LEADERBOARD': {
				enableKeyword: 'enableLeaderboardFloating',
				container: 'WikiaTopAds',
				configure: function (floatingContext) {
					var elements = floatingContext.elements;

					elements.viewport = elements.adContainer;
				},
				calculateViewportHeight: function (viewport) {
					return win.getComputedStyle(viewport).height;
				},
				floatLater: function (callback) {
					if (this.isOutsideOfViewport()) {
						callback(this);
						this.fireEvent('start');
					}
				},
				onAttach: function (floatingContext) {
					floatingContext.elements.viewport.style.removeProperty('height');
				}
			}
		};

		function onBeforeDetach(floatingContext, configuration) {
			var viewport = floatingContext.elements.viewport,
				height = configuration.calculateViewportHeight(viewport);

			viewport.style.height = height;
		}

		function configure(floatingContext, params) {
			var configuration = selectConfigurationUsing(params);

			configuration.configure(floatingContext);

			floatingContext.preferred = {};
			floatingContext.preferred.width = params.width;
			floatingContext.preferred.height = params.height;

			floatingContext.eventHandlers.onBeforeDetach = function (context) {
				onBeforeDetach(context, configuration);
			};
			floatingContext.eventHandlers.onAttach = configuration.onAttach;
			floatingContext.floatLater = configuration.floatLater;
		}

		function selectConfigurationUsing(params) {
			return slotsConfiguration[params.slotName];
		}

		function canFloat(params) {
			var configuration = selectConfigurationUsing(params);

			return Boolean(configuration && params[configuration.enableKeyword]);
		}

		return {
			canFloat: canFloat,
			configure: configure,
			selectConfigurationUsing: selectConfigurationUsing
		};
	}
);
