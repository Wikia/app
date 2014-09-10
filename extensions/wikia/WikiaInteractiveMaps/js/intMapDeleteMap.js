define('wikia.intMaps.deleteMap',
	['jquery', 'wikia.querystring', 'wikia.window', 'wikia.intMap.utils'],
	function ($, qs, w, utils) {
	'use strict';
	var modal,
		modalConfig = {
			vars: {
				id: 'intMapsDeleteMapModal',
				size: 'small',
				title: $.msg('wikia-interactive-maps-delete-map-client-title'),
				content: '',
				buttons: [
					{
						vars: {
							value: $.msg('wikia-interactive-maps-delete-map-client-confirm-button'),
							classes: ['normal', 'primary'],
							data: [
								{
									key: 'event',
									value: 'deleteMap'
								}
							]
						}
					},
					{
						vars: {
							value: $.msg('wikia-interactive-maps-delete-map-client-cancel-button'),
							data: [
								{
									key: 'event',
									value: 'close'
								}
							]
						}
					}
				]
			}
		},
		events = {
			deleteMap: [
				deleteMap
			],
			beforeClose: [
				function () {
					w.UserLogin.refreshIfAfterForceLogin();
				}
			]
		},
		mapId = $('iframe[name=wikia-interactive-map]').data('mapid');

	/**
	 * @desc Opens modal with a prompt to confirm map deletion
	 */
	function init(templates) {
		modalConfig.vars.content = utils.render(templates[0]);

		utils.createModal(modalConfig, function (_modal) {
			modal = _modal;
			utils.bindEvents(modal, events);

			modal.$errorContainer = modal.$element.find('.map-modal-error');

			modal.$element
				.find('#intMapInnerContent')
				.html($.msg('wikia-interactive-maps-delete-map-client-prompt'));

			modal.show();
		});
	}

	/**
	 * @desc Makes an AJAX request to delete a map
	 */
	function deleteMap() {
		modal.deactivate();
		closeError();
		$.nirvana.sendRequest({
			controller: 'WikiaInteractiveMapsMap',
			method: 'updateMapDeletionStatus',
			type: 'POST',
			data: {
				mapId: mapId,
				deleted: utils.mapDeleted.mapDeleted
			},
			callback: function (response) {
				var redirectUrl = response.redirectUrl;
				if (redirectUrl) {
					qs(redirectUrl).goTo();
				} else {
					showError();
				}
			},
			onErrorCallback: function (response) {
				modal.activate();
				utils.handleNirvanaException(modal, response);
			}
		});
	}

	/**
	 * @desc Displays error message
	 */
	function showError() {
		modal.activate();
		modal.$errorContainer
			.html($.msg('wikia-interactive-maps-delete-map-client-error'))
			.removeClass('hidden');
	}

	/**
	 * @desc Hides error container
	 */
	function closeError() {
		modal.$errorContainer
			.html('')
			.addClass('hidden');
	}

	return {
		init: init
	};
});
