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
			$('.flags-special-list-item-actions-edit').on('click', editFlagType);
		}

		function displayCreateFlagForm(event) {
			event.preventDefault();

			FlagEditForm.init();
		}

		function deleteFlagType(event) {
			event.preventDefault();

			/* TODO - Collect a # of articles using this flag - has to wait for CE-1817 */
			if (confirm(mw.message('flags-special-autoload-delete-confirm').escaped())) {
				var flagTypeId = getFlagTypeId(event);
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

		function editFlagType(event) {
			event.preventDefault();

			var flagTypeId = getFlagTypeId(event),
				row = $('#flags-special-list-item-' + flagTypeId),
				flagTypeData = getValuesFromTableRow(row);

			FlagEditForm.init(flagTypeData);
		}

		function getValuesFromTableRow(row) {
			var data = {};

			data.name = row.find('.flags-special-list-item-name').data('flag-name');
			data.template = row.find('.flags-special-list-item-template').data('flag-template');

			data.group = row.find('.flags-special-list-item-group').data('flag-group');
			data.targeting = row.find('.flags-special-list-item-targeting').data('flag-targeting');

			data.params = row.find('.flags-special-list-item-params').data('flag-params-names');

			return data;
		}

		function getFlagTypeId(event) {
			var $target;

			if ($(event.target).is('a')) {
				$target = $(event.target);
			} else {
				$target = $(event.target).parent();
			}

			return $target.data('flag-type-id');
		}

		function removeHighlightingFromRow(row) {
			if (row.lenght > 0) {
				$('td').removeClass('hightlight-green');
				$('td').removeClass('hightlight-red');
			}
		}

		function hightlightTableRowGreen(row) {
			if (row.length > 0) {
				$('td').addClass('highlight-green');
			}
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
