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
			$.when(getFormResources()).done(function (dropdownOptions, formResources) {
				formResources.dropdownOptions = dropdownOptions[0];
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
			var formResources = cache.get(getResourcesCacheKey());

			/** Check formResources and formResources.resources for undefined or null **/
			if (formResources === null || !formResources.resources) {
				formResources = $.when(
					nirvana.sendRequest({
						controller: 'FlagsApiController',
						method: 'getGroupsAndTargetingAsJson'
					}),
					loader({
						type: loader.MULTI,
						resources: {
							messages: 'FlagsCreateForm',
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
			mw.messages.set(formResources.messages);

			formData = {
				messages: formResources.messages,
				template: formResources.mustache[0],
				partials: {
					createFormParam: formResources.mustache[1]
				},
				dropdownOptions: formResources.dropdownOptions
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
			var formParams,
				content = cache.get(getEmptyFormCacheKey(mw.user.options.values.language));
			/** **/
			if (content === null) {
				formParams = {
					messages: formData.messages,
					values: getDropdownOptions({})
				};
				content = mustache.to_html(formData.template, formParams, formData.partials);

				cache.set(getEmptyFormCacheKey(mw.user.options.values.language), content, cache.CACHE_LONG);
			}

			modalConfig.vars.title = mw.message('flags-special-create-form-title-new').escaped();
			initModal(content);
		}

		function displayFormEdit(prefillData) {
			var content,
				formParams = {
					messages: formData.messages,
					values: getDropdownOptions(prefillData)
				};

			content = mustache.to_html(formData.template, formParams, formData.partials);

			modalConfig.vars.title = mw.message('flags-special-create-form-title-edit').escaped();
			initModal(content);
		}

		function initModal(content) {
			modalConfig.vars.content = content;

			modalConfig.vars.buttons[0].vars.value = mw.message('flags-special-create-form-save').escaped();
			modalConfig.vars.buttons[1].vars.value = mw.message('flags-special-create-form-cancel').escaped();

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

			$('.flags-special-form')
				.on('click', '.flags-special-form-params-new-link', addNewParameterInput)
				.on('click', '.flags-special-form-param-delete-link', removeParameter)
				.on('click', '.form-template-params', getTemplateParams);
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
						showWarningNotification('flags-special-create-form-save-nochange');
					} else {
						showErrorNotification('flags-special-create-form-save-failure');
					}
				}
			});

			return true;
		}

		function getTemplateParams() {
			var param,
				template = $('#flags-special-form-template').val();

			if ( !template.length ) {
				showErrorNotification('flags-special-create-form-invalid-template');
				return false;
			}

			nirvana.sendRequest({
				controller: 'FlagsApiController',
				method: 'getFlagParamsFromTemplate',
				data: {
					'flag_view': template
				},
				callback: function (json) {
					if (json.status === true) {
						$('.flags-special-form-params-tbody').empty();

						for(var name in json.data) {
							param = {};
							param.name = name;
							param.description = '';

							addNewParameterInput(param);
						}
					} else {
						showWarningNotification('flags-special-create-form-no-parameters');
					}
				}
			});

			return true;
		}

		function collectFormData() {
			var flagName,
				flagView,
				params = {};

			flagName = $('#flags-special-form-name').val();
			if (flagName.length === 0) {
				showErrorNotification('flags-special-create-form-invalid-name');
				return false;
			}

			var oldFlagName = $('#flags-special-form-name').data('flag-name');
			if (flagName !== oldFlagName && allFlagsNames.indexOf(flagName) > -1) {
				showErrorNotification('flags-special-create-form-invalid-name-exists');
				return false;
			}

			flagView = $('#flags-special-form-template').val();
			if (flagView.length === 0) {
				showErrorNotification('flags-special-create-form-invalid-template');
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
				showErrorNotification('flags-special-create-form-invalid-param-name');
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
				$('.flags-special-list-item-name').each(function () {
					allFlagsNames.push($(this).data('flag-name'));
				});
			}
		}

		function addNewParameterInput(params) {
			var tbody = $('.flags-special-form-params-tbody'),
				partial;

			params = params || {};
			partial = mustache.to_html(formData.partials.createFormParam, params);

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
			return emptyFormCacheKey + ':' + lang + ':' + cacheVersion;
		}

		function getDropdownOptions(values) {
			var key;

			values.groups = formData.dropdownOptions.groups;
			values.targeting = formData.dropdownOptions.targeting;

			if (values.selectedGroup !== null) {
				// mark selected group
				for (key in values.groups) {
					if (values.groups[key].value === values.selectedGroup) {
						values.groups[key].selected = true;
						break;
					}
				}

			}

			if (values.selectedTargeting !== null) {
				// mark selected target
				for (key in values.targeting) {
					if (values.targeting[key].value === values.selectedTargeting) {
						values.targeting[key].selected = true;
						break;
					}
				}
			}

			return values;
		}

		function showWarningNotification(msgKey) {
			new BannerNotification(
				mw.message(msgKey).escaped(),
				'warning'
			).show();
		}

		function showErrorNotification(msgKey) {
			new BannerNotification(
				mw.message(msgKey).escaped(),
				'error'
			).show();
		}

		return {
			init: init
		};
	}
);
