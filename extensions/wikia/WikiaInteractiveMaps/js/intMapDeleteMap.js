define('wikia.intMaps.deleteMap', ['jquery', 'wikia.querystirng', 'wikia.ui.factory'], function($, qs, uiFactory) {
	'use strict';
	var modal,
		modalConfig = {
			vars: {
				id: 'intMapsDeleteMapModal',
				size: 'small',
				content: $.msg('wikia-interactive-maps-delete-map-client-prompt'),
				title: $.msg('wikia-interactive-maps-delete-map-client-title'),
				buttons: [
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
					},
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
					}
				]
			}
		},
		mapId = $('iframe[name=wikia-interactive-map]').data('mapid');

	/**
	 * @desc Creates a POST form with map ID in the payload and submits it
	 * to WikiaInteractiveMaps controller (method deleteMap)
	 */
	function deleteMap() {
		event.preventDefault();
		cleanUpError();
		modal.deactivate();
		$.nirvana.sendRequest({
			controller: 'WikiaInteractiveMaps',
			method: 'deleteMap',
			data: {
				mapId: mapId
			},
			callback: function(response) {
				var redirectUrl = response.redirectUrl;
				if (redirectUrl) {
					qs(redirectUrl).goto();
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
	 * @desc Opens modal with a prompt to confirm map deletion
	 */
	function init() {
		uiFactory.init( [ 'modal' ] ).then( function( uiModal ) {
			uiModal.createComponent( modalConfig, function( _modal ) {
				modal = _modal;
				modal.bind('delete', deleteMap);
				modal.show();
			});
		});
	}

	/**
	 * @desc displays error message
	 * @param {string} message - error message
	 */
	function showError() {
		modal.activate();
		modal.$errorContainer
			.html($.msg('wikia-interactive-maps-delete-map-client-error'))
			.removeClass('hidden');
	}

	/**
	 * @desc cleans up error message and hides error container
	 */
	function cleanUpError() {
		modal.$errorContainer
			.html('')
			.addClass('hidden');
	}

	return {
		init: init
	};
});
