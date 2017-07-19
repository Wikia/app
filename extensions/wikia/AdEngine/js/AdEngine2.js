/*global define*/
define('ext.wikia.adEngine.adEngine', [
	'ext.wikia.adEngine.adDecoratorLegacyParamFormat',
	'ext.wikia.adEngine.utils.eventDispatcher',
	'ext.wikia.adEngine.slot.adSlot',
	'ext.wikia.adEngine.slot.service.slotRegistry',
	'ext.wikia.adEngine.slotTracker',
	'ext.wikia.adEngine.slotTweaker',
	'ext.wikia.adEngine.utils.hooks',
	'wikia.document',
	'wikia.lazyqueue',
	'wikia.log'
], function (
	adDecoratorLegacyParamFormat,
	eventDispatcher,
	adSlot,
	slotRegistry,
	slotTracker,
	slotTweaker,
	registerHooks,
	doc,
	lazyQueue,
	log
) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.adEngine';

	function decorate(func, decorators) {
		log(['decorate', func, decorators], log.levels.debug, logGroup);

		var i, len;

		if (decorators && decorators.length) {
			for (i = 0, len = decorators.length; i < len; i += 1) {
				func = decorators[i](func);
			}
		}

		return func;
	}

	function cleanProviderContainers(slotName) {
		var slotContainer = doc.getElementById(slotName),
			containers,
			i;

		if (!slotContainer) {
			return;
		}

		containers = slotContainer.childNodes;

		for (i = containers.length - 1; i >= 0; i -= 1) {
			if (containers[i].tagName !== 'SCRIPT') { // keep the adslots2.push script
				slotContainer.removeChild(containers[i]);
			}
		}
	}

	function prepareAdProviderContainer(providerName, slotName) {
		// TODO: remove after Liftium-era
		var providerContainerId = providerName + '_' + slotName.split('.')[0],
			adContainer = doc.getElementById(slotName),
			providerContainer = doc.getElementById(providerContainerId);

		if (!providerContainer && adContainer) {
			providerContainer = doc.createElement('div');
			providerContainer.classList.add('provider-container');
			providerContainer.id = providerContainerId;
			adContainer.appendChild(providerContainer);
		}

		log(['prepareAdProviderContainer', providerName, slotName, providerContainer], log.levels.debug, logGroup);
		return providerContainer;
	}

	/**
	 * Initialize the provider before the first use
	 * Build the queue for fillInSlot and call initialize (if present)
	 *
	 * !! If initialize method is present in a provider it MUST accept a callback param
	 * and call it back once it is initialized !!
	 *
	 * TODO (if useful): support error param, so initialize can cause a provider to always hop?
	 */
	function initializeProviderOnce(provider) {
		if (!provider.fillInSlotQueue) {
			provider.fillInSlotQueue = [];
			lazyQueue.makeQueue(provider.fillInSlotQueue, function (args) {
				provider.fillInSlot.apply(provider, args);
			});

			if (provider.initialize) {
				// Only start flushing the fillInSlot queue once the provider is initialized
				provider.initialize(provider.fillInSlotQueue.start);
			} else {
				// No initialize function, let's fill in the slots immediately
				provider.fillInSlotQueue.start();
			}
		}
	}

	function createSlot(queuedSlot, container, callbacks) {
		var slot = adSlot.create(queuedSlot.slotName, container, callbacks);

		registerHooks(slot, ['success', 'collapse', 'hop', 'renderEnded', 'viewed']);
		slot.post('success', queuedSlot.onSuccess);

		return slot;
	}

	function run(adConfig, adslots, queueName) {
		log(['run', adslots, queueName], log.levels.debug, logGroup);

		function fillInSlotUsingProvider(queuedSlot, provider, nextProvider) {
			log(['fillInSlotUsingProvider', provider.name, queuedSlot], log.levels.debug, logGroup);

			var slotName = queuedSlot.slotName,
				container = prepareAdProviderContainer(provider.name, slotName),
				tracker = slotTracker(provider.name, slotName, queueName),
				slot = createSlot(queuedSlot, container, {
					success: function (adInfo) {
						log(['success', provider.name, slotName, adInfo], log.levels.debug, logGroup);
						slotTweaker.show(slotName);
						eventDispatcher.dispatch('adengine.slot.status', {
							slot: slot,
							status: 'success',
							adInfo: adInfo
						});
						tracker.track('success', adInfo);
						slot.container.setAttribute('data-slot-result', 'success');
					},
					collapse: function (adInfo) {
						log(['collapse', provider.name, slotName, adInfo], log.levels.debug, logGroup);
						slotTweaker.hide(slotName);
						eventDispatcher.dispatch('adengine.slot.status', {
							slot: slot,
							status: 'collapse',
							adInfo: adInfo
						});
						tracker.track('collapse', adInfo);
						slot.container.setAttribute('data-slot-result', 'collapse');
					},
					hop: function (adInfo) {
						log(['hop', provider.name, slotName, adInfo], log.levels.debug, logGroup);
						slotTweaker.hide(container.id);
						eventDispatcher.dispatch('adengine.slot.status', {
							slot: slot,
							status: 'hop',
							adInfo: adInfo
						});
						tracker.track('hop', adInfo);
						slot.container.setAttribute('data-slot-result', 'hop');
						nextProvider();
					},
					renderEnded: function () {
						log(['renderEnded', provider.name, slotName], log.levels.debug, logGroup);
						slot.container.setAttribute('data-slot-result', 'loading');
					},
					viewed: function () {
						log(['viewed', provider.name, slotName], log.levels.debug, logGroup);
						slot.container.setAttribute('data-slot-viewed', 'true');
					}
				});

			slot.post('viewed', function () {
				slot.isViewed = true;
			});

			if (slotTweaker.isTopLeaderboard(slotName)) {
				slot.pre('collapse', function () {
					slotTweaker.hide('TOP_BUTTON_WIDE');
				});
			}

			slotRegistry.add(slot, provider.name);
			initializeProviderOnce(provider);

			provider.fillInSlotQueue.push([slot]);
		}

		function fillInSlot(slot) {
			log(['fillInSlot', slot], log.levels.debug, logGroup);

			var slotName = slot.slotName,
				providerList = adConfig.getProviderList(slotName).slice(); // Get a copy of the array

			log(['fillInSlot', slot, 'provider list', JSON.stringify(providerList)], log.levels.debug, logGroup);

			function handleNoAd() {
				log(['handleNoAd', slot], log.levels.debug, logGroup);
				slotTweaker.hide(slotName);
				if (typeof slot.onError === 'function') {
					slot.onError(slot);
				}
			}

			function nextProvider() {
				var provider;

				do {
					provider = providerList.shift();

					if (!provider) {
						handleNoAd();
						return;
					}

					if (provider.canHandleSlot(slotName)) {
						fillInSlotUsingProvider(slot, provider, nextProvider);
						return;
					}

					log(['fillInSlot', slot, 'skipping provider, cannot handle slot', provider], log.levels.debug, logGroup);
				} while (provider);
			}

			slotRegistry.reset(slotName);
			cleanProviderContainers(slotName);
			nextProvider();
		}

		var decorators = adConfig.getDecorators() || [];
		if (adDecoratorLegacyParamFormat) {
			decorators.push(adDecoratorLegacyParamFormat);
		}

		log(['run', 'initializing lazyQueue on the queue'], log.levels.debug, logGroup);
		lazyQueue.makeQueue(adslots, decorate(fillInSlot, decorators));

		log(['run', 'launching queue on adslots (' + adslots.length + ')'], log.levels.debug, logGroup);
		adslots.start();

		log(['run', 'initial queue handled'], log.levels.debug, logGroup);


		var slot = slotRegistry.get('TOP_LEADERBOARD');

		function leaderboardMagic() {
			var adHeight = $('.WikiaTopAdsInner').height(),
				outherAdHeight = adHeight + 20;

			function revertMagic() {
				$('#globalNavigation').css({top: 0})
				$('.WikiaTopAdsInner').css({top: -outherAdHeight + 'px'});

				setTimeout(function(){
					$('.WikiaTopAdsInner').css({position: '', background: '', padding: '', width: '', top: '', left: ''});
				}, 1000);
			}

			$('.WikiaTopAds').css({height: adHeight, 'z-index': 50000});
			$('.WikiaTopAdsInner').css({position: 'fixed', top: -outherAdHeight + 'px', width: '100%', left: 0, padding: '10px 0', background: 'white'});
			setTimeout(function() {
				$('.WikiaTopAdsInner').css({top: 0, transition: 'top 1s'});
				$('#globalNavigation').css({top: outherAdHeight + 'px', transition: 'top 1s'});
			}, 0);

			var viewabilityCheckCount = 0,
				viewabilityInterval = setInterval(function() {
					if ($('.WikiaTopAdsInner .provider-container:last').data('slot-viewed') || viewabilityCheckCount++ > 50) {
						clearInterval(viewabilityInterval);

						var revertMagicTimeout = setTimeout(function() {
							$(window).off('scroll.leaderboard');
							revertMagic();
						}, 10000);

						$(window).on('scroll.leaderboard', function () {
							clearTimeout(revertMagicTimeout);
							$(window).off('scroll.leaderboard');

							revertMagic();
						});
					}
				}, 100);
		}

		slot.post('success', function() {
			var magicTimeout = setTimeout(function() {
				$(window).off('scroll.preleaderboard');

				if (!$('.WikiaTopAdsInner .provider-container:last').data('slot-viewed')) {
					leaderboardMagic();
				}
			}, 10000);

			$(window).on('scroll.preleaderboard', function () {
				$(window).off('scroll.preleaderboard');
				clearTimeout(magicTimeout);

				if (!$('.WikiaTopAdsInner .provider-container:last').data('slot-viewed')) {
					leaderboardMagic();
				}

			});

		});



	}

	return {run: run};
});
