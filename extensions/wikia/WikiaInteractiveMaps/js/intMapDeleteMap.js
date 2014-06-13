define('wikia.intMaps.deleteMap',
	['jquery', 'wikia.querystring', 'wikia.window', 'wikia.ui.factory', 'wikia.intMap.createMap.utils'],
	function($, qs, w, uiFactory, utils) {
	'use strict';
	var modal,
		modalConfig = {
			vars: {
				id: 'intMapsDeleteMapModal',
				size: 'small',
				title: $.msg('wikia-interactive-maps-delete-map-client-title'),
				buttons: [
					{
						vars: {
							value: $.msg('wikia-interactive-maps-delete-map-client-confirm-button'),
							classes: ['normal', 'primary'],
							data: [
								{
									key: 'event',
									value: 'delete'
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
		if (!modalConfig.vars.content) {
			modalConfig.vars.content = utils.render(templates[0]);
		}
		uiFactory.init( [ 'modal' ] ).then( function( uiModal ) {
			uiModal.createComponent( modalConfig, function( _modal ) {
				modal = _modal;
				utils.bindEvents(modal, events);
				modal.$element.find('#intMapInnerContent')
					.html($.msg('wikia-interactive-maps-delete-map-client-prompt'));
				modal.$error = modal.$element.find('.map-modal-error');
				modal.show();
			});
		});
	}

	/**
	 * @desc Makes an AJAX request to delete a map
	 */
	function deleteMap() {
		modal.deactivate();
		closeError();
		$.nirvana.sendRequest({
			controller: 'WikiaInteractiveMaps',
			method: 'deleteMap',
			type: 'POST',
			data: {
				mapId: mapId
			},
			callback: function(response) {
				var redirectUrl = response.redirectUrl;
				if (redirectUrl) {
					qs(redirectUrl).goTo();
				} else {
					showError();
				}
			},
			onErrorCallback: function() {
				showError();
			}
		});
	}

	/**
	 * @desc Displays error message
	 */
	function showError() {
		modal.activate();
		modal.$error
			.html($.msg('wikia-interactive-maps-delete-map-client-error'))
			.removeClass('hidden');
	}

	/**
	 * @desc Hides error container
	 */
	function closeError() {
		modal.$error
			.html('')
			.addClass('hidden');
	}

	return {
		init: init
	};
});
