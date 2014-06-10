define('wikia.intMaps.deleteMap', ['jquery', 'wikia.querystring', 'wikia.ui.factory'], function($, qs, uiFactory) {
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
		modal.setContent($.msg('wikia-interactive-maps-delete-map-client-error'));
	}

	return {
		init: init
	};
});
