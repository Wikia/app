require(['jquery', 'wikia.window', 'wikia.loader', 'wikia.mustache', 'wikia.location'], function ($, window, loader, mustache, location) {
	var infoboxBuilderMarkup = null,
		infoboxBuilderScripts = null,
		iframeLoaded = false;

	function registerPlugin() {
		window.CKEDITOR.plugins.add('rte-infobox', {
			init: onEditorInit
		});
	}

	function onEditorInit(editor) {
		editor.addCommand('addinfobox', {
			exec: openInfoboxModal
		});
	}

	function openInfoboxBuilder(editor) {
		window.CKEDITOR.dialog.add('infoboxBuilder-dialog', function (editor) {
			return {
				title: $.msg('rte-infobox-builder'),
				buttons: [],
				minWidth: 800,
				minHeight: 700,
				contents: [
					{
						id: 'infoboxBuilderDialog',
						label: '',
						title: '',
						elements: [
							{
								type: 'html',
								html: '<div class="ckeditor-infobox-builder"></div>'
							}
						]
					}
				],
				onShow: function () {
					//hide footer
					this._.element.addClass('infoboxBuilderDialog');
					$('.infoboxBuilderDialog').find('.cke_dialog_footer').hide();

					if (infoboxBuilderMarkup && !iframeLoaded) {
						// needs to be inserted only once, see comment bellow.
						$('.ckeditor-infobox-builder').html(infoboxBuilderMarkup);

						// this script needs to be executed only once, otherwise ponto stops working on second and
						// further infobox-builder dialog appearences, which in fact causes blank dialogs without
						// infobox builder. Because of that, the iFrame html needs to be inserted only once too.
						loader.processScript(infoboxBuilderScripts);
						iframeLoaded = true;
					}

					window.CKEDITOR.on('new-infobox-created', function (event) {
						var infoboxTitle = event.data;

						CKEDITOR.dialog.getCurrent().hide();
						RTE.templateEditor.createTemplateEditor(infoboxTitle);
					});
				}
			}
		});

		CKEDITOR.dialog.getCurrent().hide();

		loader({
			type: loader.MULTI,
			resources: {
				mustache: 'extensions/wikia/PortableInfoboxBuilder/templates/PortableInfoboxBuilderSpecialController_builder.mustache',
				scripts: 'portable_infobox_builder_js'
			}
		}).done(function (assets) {
			infoboxBuilderMarkup = mustache.render(assets.mustache[0], {
				iframeUrl: location.origin + '/infobox-builder/',
				classes: 've-ui-infobox-builder'
			});
			infoboxBuilderScripts = assets.scripts;

			RTE.getInstance().openDialog('infoboxBuilder-dialog');
		});
	}

	function openInfoboxModal(editor) {
		var api = new window.mw.Api();
		api.get({
				format: 'json',
				action: 'query',
				list: 'allinfoboxes',
				uselang: window.wgContentLanguage
			},
			function (data) {
				window.CKEDITOR.dialog.add('infobox-dialog', function (editor) {
					return {
						title: $.msg('rte-select-infobox-title'),
						buttons: [
							{
								type: 'button',
								class: 'infobox-dialog-button',
								label: '+rte-add-template',
								onClick: openInfoboxBuilder
							}
						],
						minWidth: 250,
						minHeight: 300,
						contents: [
							{
								id: 'ckeditorInfoboxPickDialog',
								label: '',
								title: '',
								elements: [
									{
										type: 'html',
										html: getInfoboxListMarkup(data)
									}
								]
							}
						],
						onShow: function () {
							$('.infobox-templates-list').on('click', onInfoboxTemplateChosen);
						},
						onHide: function () {
							$('.infobox-templates-list').off('click', onInfoboxTemplateChosen);
						}
					};
				});

				RTE.getInstance().openDialog('infobox-dialog');
			});
	}

	function getInfoboxListMarkup(data) {
		if (!data || !data.query || !data.query.allinfoboxes || !data.query.allinfoboxes.length) {
			return '';
		}

		var markup = '<ul class="infobox-templates-list">';

		data.query.allinfoboxes.forEach(function (infoboxData) {
			markup += '<li><a data-infobox-name="' + infoboxData.title + '">' + infoboxData.title + '</a></li>';
		});

		markup += '</ul>';

		return markup;
	}

	function onInfoboxTemplateChosen(event) {
		var infoboxName = $(event.target).data('infobox-name');

		if (infoboxName) {
			CKEDITOR.dialog.getCurrent().hide();
			RTE.templateEditor.createTemplateEditor(infoboxName);
		}
	}

	registerPlugin();
});
