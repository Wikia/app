'use strict';

require(['wikia.querystring', 'jquery', 'wikia.ui.factory'], function (queryString, $, uiFactory) {
	var initBuilderUIqueryStringParam = 'portableInfoboxBuilder',
		initBuilderUIEventName = 'initPortableInfoboxBuilder',
		builderUIModalEntryPointId = 'portableInfoboxBuilderModalEntryPoint',
		builderUIModalEntryPointParams = {
			vars: {
				id: builderUIModalEntryPointId,
				size: 'small',
				title: $.msg('portable-infobox-builder-entry-point-modal-title'),
				content: $.msg('portable-infobox-builder-entry-point-modal-message'),
				buttons: [
					{
						vars: {
							value: $.msg('portable-infobox-builder-entry-point-modal-ok-button'),
							classes: ['normal', 'primary'],
							data: [
								{
									key: 'event',
									value: initBuilderUIEventName
								}
							]
						}
					},
					{
						vars: {
							value: $.msg('portable-infobox-builder-entry-point-modal-cancel-button'),
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
		};

	/**
	 * adds query string param to URL and reloads the page to init Portable Infobox Builder UI
	 */
	function initPortableInfoboxBuilder() {
		queryString()
			.setVal(initBuilderUIqueryStringParam, true)
			.goTo();
	}

	uiFactory.init(['modal']).then(function (modalComponent) {
		modalComponent.createComponent(builderUIModalEntryPointParams, function (modal) {
			modal.bind(initBuilderUIEventName, initPortableInfoboxBuilder);
			modal.show();
		});
	});
});
