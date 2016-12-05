/**
 * Modal containing settings for the Discussions Module
 */
define('DiscussionsSettingsModal',
	['jquery', 'wikia.loader', 'mw', 'wikia.mustache', 'wikia.tracker', 'wikia.nirvana'],
	function ($, loader, mw, mustache, tracker, nirvana) {
		'use strict';
		var modalConfig = {
				vars: {
					id: 'DiscussionsSettingsModal',
					classes: ['embeddable-discussions-settings-modal'],
					size: 'small'
				}
			},
			track = tracker.buildTrackingFunction({
				action: tracker.ACTIONS.CLICK,
				category: 'community-page-discussions-settings-modal',
				trackingMethod: 'analytics'
			}),
			config;

		function saveSettings() {
			var $selectedCategories = $('.embeddable-discussions-filter-by-list input:checked');

			// Update selected categories before sending request
			config.selectedCategories = [];

			if (!$('#embeddable-discussions-settingsmodal-filter-by-all-checkbox').is(':checked')) {
				// All not checked, populate with selected items in list
				$selectedCategories.each(function() {
					config.selectedCategories.push({ id: $(this).val() });
				});
			}

			nirvana.sendRequest({
				controller: 'EmbeddableDiscussionsApi',
				method: 'saveCommunityPageSettings',
				type: 'post',
				format: 'json',
				data: config,
			});
		}

		function isSelected(id, selectedCategories) {
			for (var i = 0; i < selectedCategories.length; i++) {
				if (selectedCategories[i].id === id) {
					return true;
				}
			}

			return false;
		}

		function setSort(latest) {
			if (latest) {
				config.sortBy = 'latest';

				$('#embeddable-discussions-settingsmodal-sort-latest').addClass(
					'embeddable-discussions-settingsmodal-sort-selected'
				);

				$('#embeddable-discussions-settingsmodal-sort-trending').removeClass(
					'embeddable-discussions-settingsmodal-sort-selected'
				);

			} else {
				config.sortBy = 'trending';

				$('#embeddable-discussions-settingsmodal-sort-trending').addClass(
					'embeddable-discussions-settingsmodal-sort-selected'
				);

				$('#embeddable-discussions-settingsmodal-sort-latest').removeClass(
					'embeddable-discussions-settingsmodal-sort-selected'
				);
			}
		}

		function openModal() {
			$.when(
				loader({
					type: loader.MULTI,
					resources: {
						mustache: 'extensions/wikia/EmbeddableDiscussions/templates/SettingsModal.mustache',
					}
				}),
				nirvana.sendRequest({
					controller: 'EmbeddableDiscussionsApi',
					method: 'getCommunityPageSettings',
					type: 'get',
					format: 'json'
				})
			).then(handleRequestsForModal);
		}

		/**
		 * Handle messages, render modal and call createComponent
		 * One of sub-tasks for getting modal shown
		 * @param {Object} loaderRes
		 * @param {Object} nirvanaRes
		 */
		function handleRequestsForModal(loaderRes, nirvanaRes) {
			var categories, i;

			config = nirvanaRes[0];

			categories = config.allCategories;

			// Pre-check all selected categories
			for (i = 0; i < categories.length; i++) {
				if (isSelected(categories[i].id, config.selectedCategories)) {
					categories[i].checked = true;
				}
			}

			modalConfig.vars.content = mustache.render(loaderRes.mustache[0], {
				heading: $.msg('embeddable-discussions-heading'),
				description: $.msg('embeddable-discussions-description'),
				sortBy: $.msg('embeddable-discussions-sort-by'),
				filterBy: $.msg('embeddable-discussions-filter-by'),
				filterByAll: $.msg('embeddable-discussions-filter-by-all'),
				latest: $.msg('embeddable-discussions-show-latest-short'),
				trending: $.msg('embeddable-discussions-show-trending-short'),
				cancel: $.msg('embeddable-discussions-cancel-button'),
				done: $.msg('embeddable-discussions-done-button'),
				categories: categories,
				allChecked: (config.selectedCategories.length === 0),
			});

			require(['wikia.ui.factory'], function (uiFactory) {
				uiFactory.init(['modal']).then(createComponent);
			});
		}

		/**
		 * Check/unceck the 'All' categories input box
		 * @param value
		 */
		function checkAll(value) {
			$('#embeddable-discussions-settingsmodal-filter-by-all-checkbox').prop('checked', value);
		}

		function checkOthers(value) {
			$('.embeddable-discussions-filter-by-list :checkbox').each(function() {
				if (this.id !== 'embeddable-discussions-settingsmodal-filter-by-all-checkbox') {
					$(this).prop('checked', value)
				}
			});
		}

		/**
		 * Creates modal UI component
		 * One of sub-tasks for getting modal shown
		 */
		function createComponent(uiModal) {
			/* Create the wrapping JS Object using the modalConfig */
			uiModal.createComponent(modalConfig, processInstance);
		}

		/**
		 * CreateComponent callback that finally shows modal.
		 * Bind tracking events.
		 * One of sub-tasks for getting modal shown.
		 */
		function processInstance(modalInstance) {
			modalInstance.show();

			// Send tracking event for modal shown
			track({
				action: tracker.ACTIONS.IMPRESSION,
				label: 'discussions-edit-modal-shown'
			});

			// Bind tracking on modal on mousedown action
			modalInstance.$element.on('mousedown', function(e) {
				track({
					label: $(e.target).data('track') || 'modal-area'
				});
			});

			// Bind tracking modal close
			modalInstance.bind('close', function () {
				track({
					action: tracker.ACTIONS.CLOSE,
					label: 'modal-closed'
				});
			});

			// Set UI elements according to current config
			setSort(config.sortBy === 'latest');

			$('#embeddable-discussions-settingsmodal-done').on('click', function(event) {
				saveSettings();
				modalInstance.trigger('close', event);
				event.preventDefault();
			});

			$('#embeddable-discussions-settingsmodal-cancel').on('click', function(event) {
				modalInstance.trigger('close', event);
				event.preventDefault();
			});

			$('#embeddable-discussions-settingsmodal-sort-trending').on('click', function(event) {
				setSort(false);
				event.preventDefault();
			});

			$('#embeddable-discussions-settingsmodal-sort-latest').on('click', function(event) {
				setSort(true);
				event.preventDefault();
			});

			// Categories checkbox handler
			$('.embeddable-discussions-filter-by-list :checkbox').each(function() {
				$(this).on('change', function() {
					// 'All' categories check, uncheck all others
					if (this.id === 'embeddable-discussions-settingsmodal-filter-by-all-checkbox' && this.checked) {
						checkOthers(false);
					// Other category checked, make sure 'All' is unchecked
					} else if (this.checked) {
						checkAll(false);
					} else {
						// No category left checked, make sure 'All' is checked
						if ($('.embeddable-discussions-filter-by-list :checked').length === 0) {
							checkAll(true);
						}
					}
				});
			});
		}

		return {
			open: openModal
		};
	}
);
