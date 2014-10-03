define(
	'wikia-interactive-embed-map-code',
	[
		'jquery',
		'wikia.maps.utils'
	], function($, utils) {
	'use strict';

	// modal configuration
	var modalConfig = {
			vars: {
				id: 'intMapEmbedMap',
				classes: ['int-map-modal'],
				size: 'medium',
				content: '',
				title: $.msg('wikia-interactive-maps-embed-map-code-header'),
				buttons: []
			}
		},
		events = {
			switchSize: [
				switchSize
			]
		},
		templateData = {
			infoMessage: $.msg('wikia-interactive-maps-embed-map-code-info'),
			sizeLabel:  $.msg('wikia-interactive-maps-embed-map-code-size-label'),
			uselang: '?uselang=' + window.wgUserLanguage,
			sizes: [
				{
					size: 'small',
					height: 315,
					width: 560,
					defaultSize: true
				}, {
					size: 'medium',
					height: 360,
					width: 640
				},
				{
					size: 'large',
					height: 720,
					width: 1280
				}
			]
		},
		$codeSamples,
		$sizeButtons;

	/**
	 * @desc Entry point for  modal
	 * @param {array} templates - mustache templates
	 * @param {object} params - params from iframe (ponto)
	 */
	function init(templates, params) {
		modalConfig.vars.content = utils.render(templates[0], $.extend({}, templateData, params));

		utils.createModal(modalConfig, function (modal) {
			var $modalContent = modal.$content;

			$codeSamples = $modalContent.children('.code-sample');
			$sizeButtons = $modalContent.children('.size-button');

			utils.bindEvents(modal, events);
			modal.show();
			utils.track(utils.trackerActions.IMPRESSION, 'embed-map-modal-shown', params.mapId);
		});
	}

	/**
	 * @desc switches embed code sample
	 * @param {Event} event
	 */
	function switchSize(event) {
		var $target = $(event.target),
			$codeSample = $codeSamples.filter('.' + $target.data('size'));

		$codeSamples.addClass('hidden');
		$sizeButtons.addClass('secondary');

		$target.removeClass('secondary');
		$codeSample.removeClass('hidden');
	}

	return {
		init: init
	};
});
