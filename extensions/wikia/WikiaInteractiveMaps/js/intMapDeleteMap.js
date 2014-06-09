define('wikia.intMaps.deleteMap', ['jquery'], function($) {
	'use strict';
	var modal,
		modalConfig = {
			vars: {
				id: 'intMapsDeleteMapModal',
				size: 'small',
				content: $.msg('wikia-interactive-maps-delete-map-prompt'),
				title: $.msg('wikia-interactive-maps-delete-map-title'),
				buttons: [
					{
						vars: {
							value: 'Delete',
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
							value: $.msg('wikia-interactive-maps-delete-map-confirm-button'),
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
		$mapId = $('iframe[name=wikia-interactive-map]').data('mapid'),
		url = 'wikia.php?controller=WikiaInteractiveMaps&method=deleteMap';

	/**
	 * @desc Creates a POST form with map ID in the payload and submits it
	 * to WikiaInteractiveMaps controller (method deleteMap)
	 */
	function deleteMap() {
		event.preventDefault();
		modal.deactivate();
		var $form = $('<form method="post" action="'+ url + '"></form>');
		$('<input type="hidden" name="mapId">')
			.val($mapId)
			.appendTo($form);
		$form.submit();
	}

	/**
	 * @desc Opens modal with a prompt to confirm map deletion
	 */
	function init() {
		require( [ 'wikia.ui.factory' ], function( uiFactory ) {
			uiFactory.init( [ 'modal' ] ).then( function( uiModal ) {
				uiModal.createComponent( modalConfig, function( _modal ) {
					modal = _modal;
					modal.bind('delete', deleteMap);
					modal.show();
				});
			});
		});
	}

	return {
		init: init
	};
});