require(
	['jquery', 'wikia.document', 'wikia.loader', 'wikia.nirvana', 'wikia.mustache', 'mw', 'wikia.tracker', 'ext.wikia.Flags.FlagEditForm'],
	function ($, document, loader, nirvana, mustache, mw, tracker, FlagEditForm)
	{
		'use strict';

		var formTemplate,
			formMessages;

		function init() {
			$.when(
				loader({
					type: loader.MULTI,
					resources: {
						messages: 'FlagsCreateForm',
						mustache: '/extensions/wikia/Flags/specials/templates/SpecialFlags_createFlagForm.mustache',
						styles: '/extensions/wikia/Flags/specials/styles/CreateForm.scss'
					}
				})
			).done(function (res) {
				loader.processStyle(res.styles);
				mw.messages.set(res.messages);
				formMessages = res.messages;
				formTemplate = res.mustache[0];
			});

			bindEvents();
		}

		function bindEvents() {
			$('.flags-special-create-button').on('click', displayCreateFlagForm);
		}

		function displayCreateFlagForm(event) {
			event.preventDefault();

			/**
			 * TODO Cache the content of an empty form
			 */
			var formParams = {
				messages: formMessages,
				class: 'new'
			},
			content = mustache.render(formTemplate, formParams);

			FlagEditForm.displayFormCreate(content);
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
