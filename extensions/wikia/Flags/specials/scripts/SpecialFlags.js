require(
	['jquery', 'wikia.document', 'wikia.loader', 'wikia.nirvana', 'wikia.mustache', 'mw', 'wikia.tracker'],
	function ($, document, loader, nirvana, mustache, mw, tracker)
	{
		'use strict';

		var createForm,
			createFormMessages;

		function init() {
			$('.flags-special-create-button').on('click', displayCreateFlagForm);

			$.when(
				loader({
					type: loader.MULTI,
					resources: {
						messages: 'FlagsCreateForm',
						mustache: '/extensions/wikia/Flags/specials/templates/SpecialFlags_createFlagForm.mustache'
					}
				})
			).done(function (res) {
				createFormMessages = res.messages;
				createForm = mustache.render(res.mustache[0], createFormMessages);
			});
		}

		function displayCreateFlagForm() {
			if ($('.flags-special-item-new').length === 0){
				var $flagsListTable = $('.flags-special-list').find('tbody');

				$flagsListTable.prepend(createForm);
			}
		}

		/**
		 * Track clicks within modal form
		 * (links and checkboxes)
		 */
		function trackModalFormClicks(e) {
			var $target = $(e.target),
				$targetLinkDataId;

			/* Track checkbox toggling */
			if ($target.is('input[type=checkbox]')) {
				if ($target[0].checked) {
					track({
						action: tracker.ACTIONS.CLICK,
						label: 'checkbox-checked'
					});
				} else {
					track({
						action: tracker.ACTIONS.CLICK,
						label: 'checkbox-unchecked'
					});
				}
				return;
			}

			/* Track links clicks */
			if ($target.is('a')) {
				$targetLinkDataId = $target.data('id');
				if ($targetLinkDataId) {
					track({
						action: tracker.ACTIONS.CLICK_LINK_TEXT,
						label: $targetLinkDataId
					});
				}
			}
		}

		/**
		 * Adds edit flags button before and after generated flags in view
		 */
		function addFlagsButton() {
			var $a = $(document.createElement('a'))
					.addClass('flags-icon')
					.html(mw.message('flags-edit-flags-button-text').escaped())
					.click(showModal),
				$div = $(document.createElement('div'))
					.addClass('flags-edit')
					.html($a);
			$('.portable-flags').prepend($div).append($div.clone(true));
		}

		// Run initialization method on DOM ready
		$(init);
	});
