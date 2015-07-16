define('ext.wikia.Flags.FlagEditForm',
	['jquery', 'mw', 'wikia.loader', 'wikia.cache', 'wikia.nirvana', 'wikia.mustache', 'BannerNotification'],
	function ($, mw, loader, cache, nirvana, mustache, BannerNotification) {
		/* In order of appearance */
		var formData,
			modalConfig,
			resourcesCacheKey = 'flagEditFormResources',
			emptyFormCacheKey = 'flagEditFormEmpty',
			cacheVersion = '1.0';

		/* Modal component configuration */
		function init(prefillData) {
			/**
			 * FOR DEVELOPMENT ONLY
			 */
			//cache.del(getResourcesCacheKey());
			//cache.del(getEmptyFormCacheKey());

			$.when(getFormResources()).done(function (formResources) {
				setupForm(formResources);

				if (prefillData === undefined || prefillData.values === undefined) {
					displayFormCreate();
				} else {
					displayFormEdit(prefillData);
				}
			});
		}

		function getFormResources() {
			var formResources = cache.get(getResourcesCacheKey());

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
				partialParam: formResources.mustache[1]
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
			if (content === null) {
				var formParams = {
					messages: formData.messages,
					values: getDropdownOptions({})
				};
				content = mustache.to_html(formData.template, formParams);

				cache.set(getEmptyFormCacheKey(), content, cache.CACHE_LONG);
			}

			modalConfig.vars.content = content;

			modalConfig.vars.title = mw.message('flags-special-create-form-title-new').escaped();
			modalConfig.vars.buttons[0].vars.value = mw.message('flags-special-create-form-save').escaped();
			modalConfig.vars.buttons[1].vars.value = mw.message('flags-special-create-form-cancel').escaped();

			displayModal();
		}

		function displayFormEdit(content) {
			modalConfig.vars.content = content;
			modalConfig.vars.title = mw.message('flags-special-create-form-title-edit').escaped();

			displayModal();
		}

		function displayModal() {
			require(['wikia.ui.factory'], function (uiFactory) {
				/* Initialize the modal component */
				uiFactory.init(['modal']).then(createComponent);
			});
		}

		function createComponent(uiModal) {
			uiModal.createComponent(modalConfig, processInstance);
		}

		function processInstance(modalInstance) {
			modalInstance.show();
			modalInstance.bind('done', saveCreateFlagForm);
			$('.flags-special-form-params-new').on('click', addNewParameterInput);
		}

		function saveCreateFlagForm() {
			var data = collectFormData();

			nirvana.sendRequest({
				controller: 'FlagsApiController',
				method: 'addFlagType',
				data: data,
				callback: function(json) {
					var notification;

					if (json.status) {
						notification = new BannerNotification(
							mw.message('flags-special-create-form-save-success').escaped(),
							'confirm'
						);
					} else {
						notification = new BannerNotification(
							mw.message('flags-special-create-form-save-failure').escaped(),
							'error'
						);
					}

					modalInstance.close();
					notification.show();
				}
			});
		}

		function collectFormData() {
			return {
				edit_token: mw.user.tokens.get('editToken'),
				flag_name: $('#flags-special-item-new-name').val(),
				flag_view: $('#flags-special-item-new-template').val(),
				flag_group: $('#flags-special-item-new-group option:selected').val(),
				flag_targeting: $('#flags-special-item-new-targeting option:selected').val()
			}
		}

		function addNewParameterInput() {
			var tbody = $('.flags-special-form-params-tbody'),
				partial = mustache.to_html(formData.partialParam, {
					id: 1
				});

			tbody.append(partial);
		}

		function getResourcesCacheKey() {
			return resourcesCacheKey + ':' + cacheVersion;
		}

		function getEmptyFormCacheKey() {
			return emptyFormCacheKey + ':' + cacheVersion;
		}

		function getDropdownOptions(values, selectedGroup, selectedTargeting) {
			/* TODO - i18n and move it from here right now! */
			values.groups = [
				{
					name: 'Spoiler',
					value: 1
				},
				{
					name: 'Disambig',
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

			if ( selectedGroup !== undefined && values.groups.selectedGroup !== undefined ) {
				values.groups[selectedGroup].selected = true;
			} else {
				values.groups[0].selected = true;
			}

			if ( selectedTargeting !== undefined && values.groups.selectedTargeting !== undefined ) {
				values.groups[selectedTargeting].selected = true;
			} else {
				values.groups[0].selected = true;
			}

			return values;
		}

		function getExampleValues() {
			return {
				name: 'Test Name',
				template: 'Test Template',
				groups: [
					{
						name: 'Stub',
						value: '3'
					},
					{
						name: 'Spoiler',
						value: '2',
						selected: true
					}
				],
				targeting: [
					{
						name: 'Readers',
						value: 1,
						selected: true
					},
					{
						name: 'Contributors',
						value: 2
					}
				],
				params: [
					{
						id: 1,
						name: '1',
						description: 'Test description'
					}
				]
			}
		}

		return {
			init: init
		}
	}
);
