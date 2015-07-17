require (
	['jquery', 'mw', 'wikia.nirvana', 'wikia.loader', 'ext.wikia.Flags.FlagEditForm'],
	function ($, mw, nirvana, loader, FlagEditForm) {
		'use strict';

		function init() {
			autoload();
			bindEvents();
		}

		function autoload() {
			$.when(loader({
				type: loader.MULTI,
				resources: {
					messages: 'FlagsSpecialAutoload'
				}
			})).done(function (res) {
				mw.messages.set(res.messages);
			});
		}

		function bindEvents() {
			$('.flags-special-create-button').on('click', displayCreateFlagForm);
			$('.flags-special-list-item-actions-delete').on('click', deleteFlagType);
		}

		function displayCreateFlagForm(event) {
			event.preventDefault();

			FlagEditForm.init();
		}

		function deleteFlagType(event) {
			event.preventDefault();

			/* TODO - Collect a # of articles using this flag - has to wait for CE-1817 */
			if (confirm(mw.message('flags-special-autoload-delete-confirm').escaped())) {
				var $target;

				if ($(event.target).is('a')) {
					$target = $(event.target);
				} else {
					$target = $(event.target).parent();
				}

				var flagTypeId = $target.data('flag-type-id');
				if (flagTypeId == null) {
					return false;
				}
				hideTableRow(flagTypeId);
				sendRequestDelete(flagTypeId);
			}
		}

		function sendRequestDelete(flagTypeId) {
			var data = {
				edit_token: mw.user.tokens.get('editToken'),
				flag_type_id: flagTypeId
			};

			nirvana.sendRequest({
				controller: 'FlagsApiController',
				method: 'removeFlagType',
				data: data,
				callback: function (json) {
					var notification;

					if (json.status) {
						removeTableRow(flagTypeId);
						notification = new BannerNotification(
							mw.message('flags-special-autoload-delete-success').escaped(),
							'confirm'
						);
					} else {
						showTableRow(flagTypeId);
						notification = new BannerNotification(
							mw.message('flags-special-autoload-delete-error').escaped(),
							'error'
						);
					}

					notification.show();
					/**
					 * Because of a Banner Notification bug - scroll window 1px down
					 * for a notification to appear at the top of a screen.
					 */
					scrollPage();
				}
			});
		}

		function hideTableRow(id) {
			var row = $('#flags-special-list-item-' + id);
			if (row.length > 0) {
				row.hide();
			}
		}

		function removeTableRow(id) {
			var row = $('#flags-special-list-item-' + id);
			if (row.length > 0) {
				row.remove();
			}
		}

		function showTableRow(id) {
			var row = $('#flags-special-list-item-' + id);
			if (row.length > 0) {
				row.show();
			}
		}

		function scrollPage() {
			$(window).scrollTop($(window).scrollTop() + 1);
		}

		// Run initialization method on DOM ready
		$(init);
	});
