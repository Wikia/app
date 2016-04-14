define(
	'wikia.maps.pontoBridge',
	[
		'wikia.window',
		'ponto',
		//FIXME: Temporary P2 fix for DAT-2546, proper fix - ADEN-1784
		//require.optional('ext.wikia.adEngine.adContext'),
		//require.optional('ext.wikia.adEngine.adLogicPageParams')
	],
	function (w, ponto, adContext, adParams) {

	'use strict';

	// configuration for Wikia Maps modals triggered by Ponto
	// TODO: maybe we could move all actions config to external file?
	var actions = {
			poi: {
				source: {
					messages: ['WikiaMapsPoi'],
					scripts: ['wikia_maps_poi_js'],
					styles: ['extensions/wikia/WikiaMaps/css/WikiaMapsModal.scss'],
					mustache: [
						'extensions/wikia/WikiaMaps/templates/WikiaMapsPoi.mustache',
						'extensions/wikia/WikiaMaps/templates/WikiaMapsArticleSuggestion.mustache'
					]
				},
				cacheKey: 'wikia_maps_poi',
				module: 'wikia.maps.poi',
				origin: 'wikia-maps-poi'
			},
			poiCategories: {
				source: {
					messages: ['WikiaMapsPoiCategories'],
					scripts: ['wikia_maps_poi_categories_js'],
					styles: [
						'extensions/wikia/WikiaMaps/css/WikiaMapsIcons.scss',
						'extensions/wikia/WikiaMaps/css/WikiaMapsModal.scss'
					],
					mustache: [
						'extensions/wikia/WikiaMaps/templates/WikiaMapsPoiCategories.mustache',
						'extensions/wikia/WikiaMaps/templates/WikiaMapsPoiCategory.mustache',
						'extensions/wikia/WikiaMaps/templates/WikiaMapsParentPoiCategory.mustache'
					]
				},
				origin: 'wikia-maps-poi-categories',
				module: 'wikia.maps.poiCategories',
				cacheKey: 'wikia_maps_poi_categories'
			},
			embedMapCode: {
				noLoginRequired: true,
				source: {
					messages: ['WikiaMapsEmbedMapCode'],
					scripts: ['wikia_maps_embed_map_code'],
					styles: ['extensions/wikia/WikiaMaps/css/WikiaMapsModal.scss'],
					mustache: ['extensions/wikia/WikiaMaps/templates/WikiaMapsEmbedMapCode.mustache']
				},
				cacheKey: 'wikia_maps_embed_map_code',
				module: 'wikia.maps.embedMapCode'
			}
		};

	/**
	 * @desc Ponto scope object required for communication between iframe and window
	 * @constructor
	 */
	function PontoBridge() {
		/**
		 * @desc triggers different modals in Wikia Maps client
		 * @param {{action: {string}, data: {}}} params - action to be triggered by client, data to be sent to this action
		 * @param {number} callbackId - required by iframe to figure out the origin of response from the client
		 */
		this.processData = function(params, callbackId) {
			var actionConfig = actions[params.action],
				data = params.data;

			require(['wikia.maps.utils'], function(utils) {
				if (actionConfig.hasOwnProperty('noLoginRequired') || utils.isUserLoggedIn()) {
					utils.loadModal(actionConfig, data, function(response) {
						ponto.respond(response, callbackId);
					});
				} else {
					utils.showForceLoginModal(actionConfig.origin, function() {
						utils.loadModal(actionConfig, data, function(response) {
							Ponto.respond(response, callbackId);
						});
					});
				}
			});
		};

		/**
		 * @desc returns Wikia settings to the map in iframe
		 */
		this.getWikiaSettings = function() {
			var settings = {
				cityId: parseInt(w.wgCityId, 10),
				mobile: w.skin === 'wikiamobile',
				skin: w.skin,
				// Temporary change required for ad purpose - https://wikia-inc.atlassian.net/browse/DAT-4051.
				// We need to limit contribution options on protected maps related to the ad campaign only to stuff
				// users.
				// TODO: remove this as a part of https://wikia-inc.atlassian.net/browse/DAT-4055
				isUserStaff: w.wgUserGroups.indexOf('staff') !== -1
			};

			if (adContext && adContext.getContext().opts.enableAdsInMaps && adParams) {
				settings.adOpts = {
					jsUrl: w.wgCdnRootUrl + w.wgAssetsManagerQuery.
						replace('%1$s', 'groups').
						replace('%2$s', 'interactivemaps_ads_js').
						replace('%3$s', '-').
						replace('%4$d', w.wgStyleVersion),
					params: adParams.getPageLevelParams()
				};
			}

			return settings;
		};
	}

	// PontoBaseHandler extension pattern - check Ponto documentation for details
	ponto.PontoBaseHandler.derive(PontoBridge);
	PontoBridge.getInstance = function() {
		return new PontoBridge();
	};

	/**
	 * @desc sets target for ponto and inits iframe
	 * @param {Element} iframe - target iframe
	 */
	PontoBridge.init = function(iframe) {
		ponto.setTarget(Ponto.TARGET_IFRAME, '*', iframe.contentWindow);
		iframe.src = iframe.getAttribute('data-url');
	}

	return PontoBridge;
});
