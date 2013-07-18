require(['jquery', 'mw', 'phalanx'], function($, mw, phalanx) {
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
					$.showModal(mw.msg('phalanx'), mw.msg('phalanx-unblock-failure'));
					node.attr('disabled', false);
				});
		}).

		// handle "bulk mode" button
		on('click', '#enterbulk', function(ev) {
			var singleModeWrapper = $('#singlemode'),
				bulkModeWrapper = $('#bulkmode');

			singleModeWrapper.slideUp();
			bulkModeWrapper.slideDown();
		}).

		// handle "single mode" button
		on('click', '#entersingle', function(ev) {
			var singleModeWrapper = $('#singlemode'),
				bulkModeWrapper = $('#bulkmode');

			singleModeWrapper.slideDown();
			bulkModeWrapper.slideUp();
		}).

		// handle "validate regex" button
		on('click', '#validate', function(ev) {
			var regex = $('#wpPhalanxFilter').val(),
				buttonNode = $(this),
				msgNode = $('#validateMessage').hide();

			buttonNode.attr('disabled', true);

			phalanx.validate(regex).
				done(function(isValid) {
					msgNode.
						text(isValid ? mw.msg('phalanx-validate-regexp-valid') : mw.msg('phalanx-validate-regexp-invalid')).
						slideDown();

					buttonNode.attr('disabled', false);
				}).
				fail(function() {
					buttonNode.attr('disabled', false);
				});
		});
});
