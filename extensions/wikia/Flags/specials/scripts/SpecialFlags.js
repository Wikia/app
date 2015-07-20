require(
	['jquery', 'mw', 'wikia.nirvana', 'wikia.loader', 'ext.wikia.Flags.FlagEditForm'],
	function ($, mw, nirvana, loader, FlagEditForm) {
		'use strict';

		var currentRow;

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

			var flagTypeId = getFlagTypeId(event);
			if (flagTypeId == null) {
				return false;
			}

			currentRow = $('#flags-special-list-item-' + flagTypeId);
			if (currentRow.length === 0) {
				return false;
			}

			/* TODO - Collect a # of articles using this flag - has to wait for CE-1817 */
			var flagName = currentRow.find('.flags-special-list-item-name').data('flag-name'),
				confirmMessage = mw.message('flags-special-autoload-delete-confirm', flagName);

			if (confirm(confirmMessage.escaped())) {
				hideTableRow(currentRow);
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
						removeTableRow(currentRow);
						notification = new BannerNotification(
							mw.message('flags-special-autoload-delete-success').escaped(),
							'confirm'
						);
					} else {
						removeHighlightingFromRow(currentRow);
						showTableRow(currentRow);
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

			data.selectedGroup = row.find('.flags-special-list-item-group').data('flag-group');
			data.selectedTargeting = row.find('.flags-special-list-item-targeting').data('flag-targeting');

			data.params = [];

			var flagParams = row.find('.flags-special-list-item-params').data('flag-params-names');
			for (var name in flagParams) {
				data.params.push({
					name: name,
					description: flagParams[name]
				});
			}

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

		function hideTableRow(row) {
			row.hide();
		}

		function removeTableRow(row) {
			row.remove();
			row = null;
		}

		function showTableRow(row) {
			row.show();
			row = null;
		}

		function scrollPage() {
			$(window).scrollTop($(window).scrollTop() + 1);
		}

		// Run initialization method on DOM ready
		$(init);
	});
