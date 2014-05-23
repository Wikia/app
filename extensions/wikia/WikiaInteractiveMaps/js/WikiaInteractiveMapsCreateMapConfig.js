define('wikia.intMaps.createMap.config', ['jquery'], function($) {
	'use strict';

	return {
		// class used for hiding elements
		hiddenClass: 'hidden',

		// image upload entry point
		uploadEntryPoint: '/wikia.php?controller=WikiaInteractiveMaps&method=uploadMap&format=json',

		// holds config for each step
		// TODO: maybe it would be better to use object instead of array
		steps: [
			{
				id: '#intMapsChooseType'
			},
			{
				id: '#intMapsChooseTileSet',
				buttons: {
					'#intMapBack': true
				}
			},
			{
				id: '#intMapsAddTitle',
				buttons: {
					'#intMapBack': true,
					'#intMapNext': true
				},
				errorMsgKeys: {
					invalidTitle: 'wikia-interactive-maps-create-map-error-invalid-map-title',
					notImplemented: 'This part is not implemented yet.'
				}
			}
		],

		// modal configuration
		modalConfig: {
			vars: {
				id: 'intMapCreateMapModal',
				classes: ['intMapCreateMapModal'],
				size: 'medium',
				content: '',
				title: $.msg('wikia-interactive-maps-create-map-header'),
				buttons: [
					{
						vars: {
							value: $.msg('wikia-interactive-maps-create-map-next-btn'),
							classes: ['normal', 'primary'],
							id: 'intMapNext',
							data: [
								{
									key: 'event',
									value: 'next'
								}
							]
						}
					},
					{
						vars: {
							value:  $.msg('wikia-interactive-maps-create-map-back-btn'),
							id: 'intMapBack',
							data: [
								{
									key: 'event',
									value: 'back'
								}
							]
						}
					}
				]
			}
		},

		// data for mustache template
		templateData: {
			mapType: [
				{
					type: 'Geo',
					name: $.msg('wikia-interactive-maps-create-map-choose-type-geo')
				},
				{
					type: 'Custom',
					name: $.msg('wikia-interactive-maps-create-map-choose-type-custom')
				}
			],
			uploadFileBtn: $.msg('wikia-interactive-maps-create-map-upload-file')
		}
	}
});
