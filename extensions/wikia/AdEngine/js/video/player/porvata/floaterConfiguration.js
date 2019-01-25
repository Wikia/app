/*global define*/
define('ext.wikia.adEngine.video.player.porvata.floaterConfiguration', [
	'ext.wikia.adEngine.adContext'
], function (adContext) {
	'use strict';

	var context = adContext.getContext(),
		slotsConfiguration = {
			'INCONTENT_PLAYER': {
				enableKeyword: 'enableInContentFloating',
				container: 'WikiaArticle',
				floatingRailForced: context && context.opts.incontentPlayerRail.enabled,
				configure: function (floatingContext) {
					var elements = floatingContext.elements;

					elements.viewport = elements.ad.parentElement;
					floatingContext.forceDoNotFloat();
				},
				floatLater: function (callback) {
					var floatingContext = this,
						video = this.elements.video;

					video.addEventListener('wikiaSlotExpanded', function () {
						floatingContext.preferred.width = video.container.scrollWidth;
						floatingContext.preferred.height = video.container.scrollHeight;
						floatingContext.floatAgain();
						floatingContext.fireEvent('start');

						if (floatingContext.isOutsideOfViewport()) {
							callback(floatingContext);
						}
					});
				},
				onAttach: function (floatingContext) {
					var elements = floatingContext.elements;

					elements.ad.style.maxHeight = elements.ad.scrollHeight + 'px';
					elements.viewport.style.removeProperty('height');
					elements.providerContainer.style.removeProperty('height');

					if (context.opts.incontentPlayerRail.enabled) {
						elements.viewport.style.display = 'none';
					}
				},
				onBeforeDetach: function (floatingContext) {
					var viewport = floatingContext.elements.viewport;

					if (context.opts.incontentPlayerRail.enabled) {
						viewport.style.height = '0px';
					} else {
						// Magic 14 is related to #INCONTENT_WRAPPER > #INCONTENT_PLAYER margins
						// and prevents jumping when video is going to float
						viewport.style.height = (viewport.offsetHeight - 14) + 'px';
					}
				},
				onDetach: function (floatingContext) {
					floatingContext.elements.providerContainer.style.height = floatingContext.getHeight() + 'px';
				}
			}
		};

	function configure(floatingContext, params) {
		var configuration = selectConfigurationUsing(params);

		configuration.configure(floatingContext);

		floatingContext.preferred = {};
		floatingContext.preferred.width = params.width;
		floatingContext.preferred.height = params.height;

		floatingContext.eventHandlers.onAttach = configuration.onAttach;
		floatingContext.eventHandlers.onBeforeDetach = configuration.onBeforeDetach;
		floatingContext.eventHandlers.onDetach = configuration.onDetach;
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
});
