define ('ext.wikia.Flags.FlagEditForm',
	['jquery', 'mw', 'wikia.loader', 'wikia.cache', 'wikia.nirvana', 'wikia.mustache', 'BannerNotification'],
	function ($, mw, loader, cache, nirvana, mustache, BannerNotification) {
		'use strict';

		/* In order of appearance */
		var formData,
			modalConfig,
			resourcesCacheKey = 'flagEditFormResources',
			emptyFormCacheKey = 'flagEditFormEmpty',
			cacheVersion = '1.0',
			allFlagsNames = [];

		function init(prefillData) {
			$.when(getFormResources()).done(function(formValues, formResources) {
				formResources.formValues = $.extend( {}, prefillData, formValues[0] );
				getAllFlagNames();
				setupForm(formResources);

				/** Check prefillData for undefined or null **/
				if (!prefillData) {
					modalConfig.vars.type = 'create';
					displayFormCreate();
				} else {
					modalConfig.vars.type = 'edit';
					displayFormEdit(prefillData);
				}
			});
		}

		function getFormResources() {
			var formResources = null;//cache.get(getResourcesCacheKey());

			/** Check formResources and formResources.resources for undefined or null **/
			if (formResources === null || !formResources.resources ) {
				formResources = $.when(
					nirvana.sendRequest({
						controller: 'SpecialFlags',
						method: 'createFlagForm'
					}),
					loader({
						type: loader.MULTI,
						resources: {
							mustache: '/extensions/wikia/Flags/specials/templates/SpecialFlags_createFlagForm.mustache,/extensions/wikia/Flags/specials/templates/createFormParam.mustache',
							styles: '/extensions/wikia/Flags/specials/styles/CreateForm.scss'
						}
					})
				);
				cache.set(getResourcesCacheKey(), formResources, cache.CACHE_LONG);
			}
			return formResources;
		}

		function setupForm(formResources) {
			loader.processStyle(formResources.styles);

			formData = {
				template: formResources.mustache[0],
				partials: {
					createFormParam: formResources.mustache[1]
				},
				values: formResources.formValues
			};

			modalConfig = {
				vars: {
					id: 'FlagEditForm',
					classes: ['flag-edit-form'],
					size: 'medium', // size of the modal
					buttons: getButtons(),
					content: '' // content
				}
			};
		}

		function getButtons() {
			return [
				{
					vars: {
						classes: ['normal', 'primary'],
						data: [
							{
								key: 'event',
								value: 'done'
							}
						]
					}
				},
				{
					vars: {
						data: [
							{
								key: 'event',
								value: 'close'
							}
						]
					}
				}
			];
		}

		function displayFormCreate() {
			var content = cache.get(getEmptyFormCacheKey(mw.user.options.values.language));

			if (content === null) {
				prepareDropdownOptions({});

				content = mustache.to_html(formData.template, formData.values, formData.partials);

				cache.set(getEmptyFormCacheKey(mw.user.options.values.language), content, cache.CACHE_LONG);
			}

			modalConfig.vars.title = formData.values.messages.titleNew;
			initModal(content);
		}

		function displayFormEdit(prefillData) {
			var content;

			prepareDropdownOptions(prefillData);

			content = mustache.to_html(formData.template, formData.values, formData.partials);

			modalConfig.vars.title = formData.values.messages.titleEdit;
			initModal(content);
		}

		function initModal(content) {
			modalConfig.vars.content = content;

			modalConfig.vars.buttons[0].vars.value = formData.values.messages.save;
			modalConfig.vars.buttons[1].vars.value = formData.values.messages.cancel;

			displayModal();
		}

		function displayModal() {
			require(['wikia.ui.factory'], function (uiFactory) {
				/* Initialize the modal component */
				uiFactory.init(['modal']).then(function (uiModal) {
					uiModal.createComponent(modalConfig, processInstance);
				});
			});
		}

		function processInstance(modalInstance) {
			modalInstance.show();
			modalInstance.bind('done', saveEditForm);
			$('.flags-special-form-params-new-link').on('click', addNewParameterInput);
			$('.flags-special-form-param-delete-link').on('click', removeParameter);
		}

		function saveEditForm() {
			var data = collectFormData(),
				method;

			if (data === false) {
				return false;
			}

			if (modalConfig.vars.type === 'create') {
				method = 'addFlagType';
			} else if (modalConfig.vars.type === 'edit') {
				method = 'updateFlagType';

				data.flag_type_id = $('.flags-special-form').data('flag-type-id');
				if (data.flag_type_id <= 0) {
					return false;
				}
			}

			nirvana.sendRequest({
				controller: 'FlagsApiController',
				method: method,
				data: data,
				callback: function (json) {
					if (json.status === true) {
						location.reload(true);
					} else if (json.status === false && json.data === false) {
						showWarningNotification('saveNochange');
					} else {
						showErrorNotification('saveFailure');
					}
				}
			});
		}

		function collectFormData() {
			var flagName,
				flagView,
				params = {};

			flagName = $('#flags-special-form-name').val();
			if (flagName.length === 0) {
				showErrorNotification('invalidName');
				return false;
			}

			var oldFlagName = $('#flags-special-form-name').data('flag-name');
			if (flagName !== oldFlagName && allFlagsNames.indexOf(flagName) > -1) {
				showErrorNotification('invalidNameExists');
				return false;
			}

			flagView = $('#flags-special-form-template').val();
			if (flagView.length === 0) {
				showErrorNotification('invalidTemplate');
				return false;
			}

			var paramsStatus = true;
			$('.flags-special-form-param').each(function () {
				var name = $(this).find('.flags-special-form-param-name-input').val();
				if (name.length === 0) {
					paramsStatus = false;
					return false;
				} else {
					params[name] = $(this).find('.flags-special-form-param-description-input').val();
				}
			});

			if (!paramsStatus) {
				showErrorNotification('invalidParamName');
				return false;
			}

			return {
				edit_token: mw.user.tokens.get('editToken'),
				flag_name: flagName,
				flag_view: flagView,
				flag_group: $('#flags-special-form-group option:selected').val(),
				flag_targeting: $('#flags-special-form-targeting option:selected').val(),
				flag_params_names: JSON.stringify(params),
				fetch_params: 1
			};
		}

		function getAllFlagNames() {
			if (allFlagsNames.length === 0) {
				$('.flags-special-list-item-name').each( function() {
					allFlagsNames.push($(this).data('flag-name'));
				});
			}
		}

		function addNewParameterInput() {
			var tbody = $('.flags-special-form-params-tbody'),
				partial = mustache.to_html(formData.partials.createFormParam, {} );

			tbody.append(partial);
			$('.flags-special-form-param-delete-link').on('click', removeParameter);
		}

		function removeParameter(event) {
			event.preventDefault();
			$(event.target).closest('tr').remove();
		}

		function getResourcesCacheKey() {
			return resourcesCacheKey + ':' + cacheVersion;
		}

		function getEmptyFormCacheKey(lang) {
			return emptyFormCacheKey + ':' + lang +':' + cacheVersion;
		}

		function prepareDropdownOptions(values) {
			var key;

			if (values.selectedGroup !== null) {
				// mark selected group
				for (key in formData.values.groups) {
					if (formData.values.groups[key].value === values.selectedGroup) {
						formData.values.groups[key].selected = true;
						break;
					}
				}

			}

			if (values.selectedTargeting !== null) {
				// mark selected target
				for (key in formData.values.targeting) {
					if (formData.values.targeting[key].value === values.selectedTargeting) {
						formData.values.targeting[key].selected = true;
						break;
					}
				}
			}
		}

		function showWarningNotification(msgKey) {
			new BannerNotification(
				formData.values.messages[msgKey],
				'warning'
			).show();
		}

		function showErrorNotification(msgKey) {
			new BannerNotification(
				formData.values.messages[msgKey],
				'error'
			).show();
		}

		return {
			init: init
		};
	}
);
