define('ext.wikia.Flags.FlagEditForm',
	['jquery', 'mw', 'wikia.loader', 'wikia.nirvana', 'wikia.mustache', 'BannerNotification'],
	function ($, mw, loader, nirvana, mustache, BannerNotification) {

		/* Modal component configuration */
		var buttons = [{
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
		}],

		modalConfig = {
			vars: {
				id: 'FlagEditForm',
				classes: ['flags-create-form'],
				size: 'medium', // size of the modal
				buttons: buttons,
				content: '' // content
			}
		};

		function displayFormCreate(content) {
			modalConfig.vars.content = content;
			modalConfig.vars.title = mw.message('flags-special-create-form-title-new').escaped();

			buttons[0].vars.value = mw.message('flags-special-create-form-save').escaped();
			buttons[1].vars.value = mw.message('flags-special-create-form-cancel').escaped();

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
		}

		function saveCreateFlagForm(event) {
			debugger;
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

		return {
			displayFormCreate: displayFormCreate
		}
	}
);
