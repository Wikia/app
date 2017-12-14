require(['jquery', 'wikia.window', 'wikia.loader', 'wikia.mustache', 'wikia.location'], function ($, window, loader, mustache, location) {
	var infoboxBuilderMarkup = null,
		infoboxBuilderScripts = null;

	function registerPlugin() {
		window.CKEDITOR.plugins.add( 'rte-infobox', {
			init: onEditorInit
		});
	}

	function onEditorInit(editor) {
		editor.addCommand( 'addinfobox', {
			exec: openInfoboxModal
		});
	}

	function openInfoboxBuilder( editor ) {
		window.CKEDITOR.dialog.add( 'infoboxBuilder-dialog', function ( editor ) {
			return {
				title: 'Infobox Builder',
				buttons: [],
				minWidth: 600,
				minHeight: 400,
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
					if (infoboxBuilderMarkup) {
						$('.ckeditor-infobox-builder').html(infoboxBuilderMarkup);
						loader.processScript(infoboxBuilderScripts);
					}
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

	function openInfoboxModal( editor ) {
		$.get('/api.php?format=json&action=query&list=allinfoboxes&uselang=' + window.wgContentLanguage)
			.then(function (data) {
				window.CKEDITOR.dialog.add( 'infobox-dialog', function( editor ) {
					return {
						title: 'Select Infobox to Insert',
						buttons: [
						{
							type : 'button',
							class: 'infobox-dialog-button',
							id : 'something',
							label : '+ Add Template',
							onClick : openInfoboxBuilder
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

	function onInfoboxTemplateChosen(evt) {
		var infoboxName = $(event.target).data('infobox-name');

		if (infoboxName) {
			console.log('did');
			CKEDITOR.dialog.getCurrent().hide();
			RTE.templateEditor.createTemplateEditor(infoboxName);
		}
	}
	registerPlugin();
});
