require(['wikia.pageShare', 'wikia.ui.factory', 'jquery'], function (pageShare, uiFactory, $) {
	'use strict';

	$('#ShareEntryPoint').click(function() {
		$.when(uiFactory.init( [ 'modal' ] ), pageShare.loadShareIcons()).then(function(uiModal, modalData) {
			uiModal.createComponent( {
				vars: {
					id: 'PageShareModalDialog',
					classes: ['page-share-modal-dialog'],
					size: 'small',
					title: modalData.modalTitle,
					content: modalData.socialIcons,
				}
			}, function( pageShareModal ) {
				pageShareModal.$element.find('#PageShareToolbar').on('click', 'a', pageShare.shareLinkClickHandler);

				pageShareModal.show();
			});
		});
	});
});
