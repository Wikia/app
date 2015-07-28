define ('ext.wikia.Flags.FlagEditForm',
	['jquery', 'mw', 'wikia.loader', 'wikia.cache', 'wikia.nirvana', 'wikia.mustache', 'BannerNotification'],
	function ($, mw, loader, cache, nirvana, mustache, BannerNotification) {
		/* In order of appearance */
		var formData,
			modalConfig,
			resourcesCacheKey = 'flagEditFormResources',
			emptyFormCacheKey = 'flagEditFormEmpty',
			cacheVersion = '1.0';

		function init(prefillData) {
			$.when(getFormResources()).done(function (formResources) {
				setupForm(formResources);

				/** Check prefillData for undefined or null **/
				if (prefillData == null) {
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
			if (formResources == null || formResources.resources == null) {
				formResources = loader({
					type: loader.MULTI,
					resources: {
						messages: 'FlagsCreateForm',
						mustache: '/extensions/wikia/Flags/specials/templates/SpecialFlags_createFlagForm.mustache,/extensions/wikia/Flags/specials/templates/createFormParam.mustache',
						styles: '/extensions/wikia/Flags/specials/styles/CreateForm.scss'
					}
				});

				cache.set(getResourcesCacheKey(), formResources, cache.CACHE_LONG);
			}

			return formResources;
		}

		function setupForm(formResources) {
			loader.processStyle(formResources.styles);
			mw.messages.set(formResources.messages);

			formData = {
				/* TODO - Do something with the damn messages */
				messages: formResources.messages,
				template: formResources.mustache[0],
				partials: {
					createFormParam: formResources.mustache[1]
				}
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
			/* TODO - We can get a half-rendered template to avoid escaping messages in front-end */
			var content = cache.get(getEmptyFormCacheKey());
			/** **/
			if (content == null) {
				var formParams = {
					messages: formData.messages,
					values: getDropdownOptions({})
				};
				content = mustache.to_html(formData.template, formParams, formData.partials);

				cache.set(getEmptyFormCacheKey(), content, cache.CACHE_LONG);
			}

			modalConfig.vars.content = content;

			modalConfig.vars.title = mw.message('flags-special-create-form-title-new').escaped();
			modalConfig.vars.buttons[0].vars.value = mw.message('flags-special-create-form-save').escaped();
			modalConfig.vars.buttons[1].vars.value = mw.message('flags-special-create-form-cancel').escaped();

			displayModal();
		}

		function displayFormEdit(prefillData) {
			var formParams = {
				messages: formData.messages,
				values: getDropdownOptions(prefillData)
			};

			modalConfig.vars.content = mustache.to_html(formData.template, formParams, formData.partials);

			modalConfig.vars.title = mw.message('flags-special-create-form-title-edit').escaped();
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
			$('.flags-special-form-params-new-link').on('click', addNewParameterInput);
		}

		function saveEditForm() {
			var data = collectFormData(),
				method;

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
				controller: 'SpecialFlagsController',
				method: method,
				data: data,
				callback: function (json) {
					if (json.status) {
						location.reload(true);
					} else {
						new BannerNotification(
							mw.message('flags-special-create-form-save-failure').escaped(),
							'error'
						).show();
					}
				}
			});
		}

		function collectFormData() {
			var params = {};

			$('.flags-special-form-param').each(function () {
				var name = $(this).find('.flags-special-form-param-name-input').val(),
					description = $(this).find('.flags-special-form-param-description-input').val();
				params[name] = description;
			});

			return {
				edit_token: mw.user.tokens.get('editToken'),
				flag_name: $('#flags-special-form-name').val(),
				flag_view: $('#flags-special-form-template').val(),
				flag_group: $('#flags-special-form-group option:selected').val(),
				flag_targeting: $('#flags-special-form-targeting option:selected').val(),
				flag_params_names: JSON.stringify(params)
			}
		}

		function addNewParameterInput( param ) {
			param = param || {};

			var tbody = $('.flags-special-form-params-tbody'),
				partial = mustache.to_html(formData.partials.createFormParam, param );

			tbody.append(partial);
		}

		function getResourcesCacheKey() {
			return resourcesCacheKey + ':' + cacheVersion;
		}

		function getEmptyFormCacheKey() {
			return emptyFormCacheKey + ':' + cacheVersion;
		}

		function getDropdownOptions(values) {
			/* TODO - i18n and move it from here right now! */
			values.groups = [
				{
					name: 'Spoiler',
					value: 1
				},
				{
					name: 'Disambiguation',
					value: 2
				},
				{
					name: 'Canon',
					value: 3
				},
				{
					name: 'Stub',
					value: 4
				},
				{
					name: 'Delete',
					value: 5
				},
				{
					name: 'Improvements',
					value: 6
				},
				{
					name: 'Status',
					value: 7
				},
				{
					name: 'Other',
					value: 8
				},
			];
			values.targeting = [
				{
					name: 'Readers',
					value: 1
				},
				{
					name: 'Contributors',
					value: 2
				},
			];

			if (values.selectedGroup != null) {
				for (var key in values.groups) {
					if (values.groups[key].value === values.selectedGroup) {
						values.groups[key].selected = true;
						break;
					}
				}
			}

			if (values.selectedTargeting != null) {
				for (var key in values.targeting) {
					if (values.targeting[key].value === values.selectedTargeting) {
						values.targeting[key].selected = true;
						break;
					}
				}
			}

			return values;
		}

		return {
			init: init
		}
	}
);
