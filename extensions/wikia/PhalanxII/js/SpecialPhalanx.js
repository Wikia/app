require(['jquery', 'mw', 'phalanx', 'BannerNotification'], function($, mw, phalanx, notification) {
	// edit token is required by Phalanx API
	phalanx.init(mw.user.tokens.get('editToken'));

	var filter = $('#wpPhalanxFilter'),
		bulkFilter = $('#wpPhalanxFilterBulk'),
		singleModeWrapper = $('#singlemode'),
		bulkModeWrapper = $('#bulkmode');

	$('body').
		// handle blocks "unblocking" (i.e. removing blocks)
		on('click', 'button.unblock, a.unblock', function(ev) {
			var node = $(this),
				blockId = parseInt(node.data('id'), 10);

			if (!blockId) {
				return;
			}

			node.attr('disabled', true);

			phalanx.unblock(blockId).
				done(function() {
					new notification(mw.msg('phalanx-unblock-message', blockId), 'confirm').show();
					node.closest('li').addClass('removed');
				}).
				fail(function() {
					$.showModal(mw.msg('phalanx'), mw.msg('phalanx-unblock-failure'));
					node.attr('disabled', false);
				});
		}).

		// handle "bulk mode" button
		on('click', '#enterbulk', function(ev) {
			// SUS-1191: preload single filter contents into bulk mode textbox
			bulkFilter.val(filter.val());

			singleModeWrapper.slideUp();
			bulkModeWrapper.slideDown();

			// hide validation message when switching modes
			$('#validateMessage').hide();
			// clear input field when switching modes, for validation purposes
			filter.val('');
			// SUS-1191: autofocus newly revealed input field
			bulkFilter.focus();
		}).

		// handle "single mode" button
		on('click', '#entersingle', function(ev) {
			singleModeWrapper.slideDown();
			bulkModeWrapper.slideUp();

			// clear input field when switching modes, for validation purposes
			bulkFilter.val('');
			// SUS-1191: autofocus newly revealed input field
			filter.focus();
		}).

		// handle "validate regex" button
		on('click', '#validate', function(ev) {
			var regex = filter.val(),
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
		}).

		// handle custom expire field
		on('change', '#wpPhalanxExpire', function(ev) {
			var customExpireField = $('#wpPhalanxExpireCustom'),
				selectedOption = $(this).find(':selected');

			if (selectedOption.data('is-custom')) {
				customExpireField.show().focus();
			} else {
				customExpireField.hide();
			}
		});

	$('#phalanx-block-texts').focusin(function() {
		$("span[id*='formValidateMessage-filter']").hide();
	});

	$("input[name*='wpPhalanxType']").not("input[name*='Filter']").focus(function() {
		$("span[id*='formValidateMessage-type']").hide();
	});

	$('#phalanx-block').bind('submit', function (e) {
		// Disable the submit button while evaluating if the form should be submitted
		$('#wpPhalanxSubmit').attr('disabled', true);

		var validFilter = true;
		var validType = true;

		// If the filter field is empty validation will fail
		if ((singleModeWrapper.is(':visible') && filter.val() === '') || (bulkModeWrapper.is(':visible') && bulkFilter.val() === '')) {
			validFilter = false;
			$('#formValidateMessage-filter').show();
		}

		// If the type checkbox is not checked validation will fail
		$("input[name*='wpPhalanxType']").not("input[name*='Filter']").each(function() {
			validType = false;
			if ($(this).prop('checked')) {
				validType = true;
				return false;
			}
		});

		if (!validType) {
			$('#formValidateMessage-type').show();
		}

		if (!(validFilter && validType)) {
			e.preventDefault();
			$('#wpPhalanxSubmit').attr('disabled', false);
		}
	});
});
