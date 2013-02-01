require(['jquery', 'mw', 'phalanx', 'wikia.log'], function($, mw, phalanx, log) {
	// edit token is required by Phalanx API
	phalanx.init(mw.config.get('wgPhalanxToken'));

	$('body').
		// handle blocks "unblocking" (i.e. removing blocks)
		on('click', 'button.unblock', function(ev) {
			var node = $(this),
				blockId = parseInt(node.data('id'), 10);

			if (!blockId) {
				return;
			}

			node.attr('disabled', true);

			phalanx.unblock(blockId).
				done(function() {
					// hide
					node.closest('li').addClass('removed');
				}).
				fail(function() {
					node.attr('disabled', false);

					log('block #' + blockId + ' not removed', log.levels.error, 'Phalanx');
				});
		}).

		// handle "bulk mode" button
		on('click', '#enterbulk', function(ev) {
			var singleModeWrapper = $('#singlemode'),
				bulkModeWrapper = $('#bulkmode');

			singleModeWrapper.slideUp();
			bulkModeWrapper.slideDown();
		});
});
