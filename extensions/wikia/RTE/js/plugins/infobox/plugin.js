require([
	'jquery',
	'wikia.window',
	'wikia.loader',
	'wikia.mustache',
	'mw'
], function (
	$,
	window,
	loader,
	mustache,
	mw
) {
	var infoboxBuilderMarkup = null,
		infoboxBuilderScripts = null,
		iframeLoaded = false;

	function registerPlugin() {
		window.CKEDITOR.plugins.add('rte-infobox', {
			init: onEditorInit
		});
	}

	function onEditorInit(editor) {
		editor.ui.addButton && editor.ui.addButton( 'AddInfobox', {
			label: $.msg('rte-infobox'),
			command: 'addinfobox'
		} );

		editor.addCommand('addinfobox', {
			exec: openInfoboxModal
		});
	}

	window.CKEDITOR.on('new-infobox-created', function (event) {
		var infoboxTitle = event.data;

		CKEDITOR.dialog.getCurrent().hide();
		RTE.templateEditor.createTemplateEditor(infoboxTitle);
	});

	function openInfoboxBuilder(editor) {
		WikiaEditor.track( 'add-new-template-button' );

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
						require(['wikia.infoboxBuilder.ponto'], function (infoboxBuilderPonto) {
							var $closeButton = $('.infoboxBuilderDialog .cke_dialog_close_button');

							function reloadInfoboxBuilder() {
								infoboxBuilderPonto.getInstance().reloadInfoboxBuilder();
								$closeButton.off('click', reloadInfoboxBuilder)
							}

							$closeButton.on('click', reloadInfoboxBuilder);
						});
						iframeLoaded = true;
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
				iframeUrl: mw.config.get('wgServer') + mw.config.get('wgScriptPath') + '/infobox-builder/',
				classes: 'ck-ui-infobox-builder'
			});
			infoboxBuilderScripts = assets.scripts;

			RTE.getInstance().openDialog('infoboxBuilder-dialog');
		});
	}

	function openInfoboxModal(editor) {
		window.CKEDITOR.dialog.add('infobox-dialog', function (editor) {

			//checking if user has rights to create new template
			var buttons = window.wgEnablePortableInfoboxBuilderInVE
				? [{
						type: 'button',
						class: 'infobox-dialog-button',
						label: $.msg('rte-add-template'),
						onClick: openInfoboxBuilder
					}]
				: [];

			return {
				title: $.msg('rte-select-infobox-title'),
				buttons: buttons,
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
								html: '<ul class="infobox-templates-list"><div class="wikiaThrobber"></div></ul>'
							}
						]
					}
				],
				onShow: function () {
					var infoboxTemplateList = $('.infobox-templates-list');

					$.get(mw.util.wikiScript('api') + '?format=json&action=query&list=allinfoboxes&uselang=' + window.wgContentLanguage).done(function(data) {
						infoboxTemplateList.html(getInfoboxListMarkup(data));
					});

					infoboxTemplateList.on('click', 'a', onInfoboxTemplateChosen);
				},
				onHide: function () {
					$('.infobox-templates-list').off('click', 'a', onInfoboxTemplateChosen);
				}
			};
		});

		RTE.getInstance().openDialog('infobox-dialog');
	}

	function getInfoboxListMarkup(data) {
		if (!data || !data.query || !data.query.allinfoboxes || !data.query.allinfoboxes.length) {
			return '';
		}

		var markup = '';

		data.query.allinfoboxes.forEach(function (infoboxData) {
			markup += '<li><a data-infobox-name="' + encodeURI(infoboxData.title) + '">' + encodeURI(infoboxData.title) + '</a></li>';
		});

		return markup;
	}

	function onInfoboxTemplateChosen(event) {
		WikiaEditor.track({label: 'infobox-template-insert-from-plain-list', action: 'add'});

		var infoboxName = decodeURI($(event.target).data('infobox-name'));

		if (infoboxName) {
			CKEDITOR.dialog.getCurrent().hide();
			RTE.templateEditor.createTemplateEditor(infoboxName);
		}
	}

	registerPlugin();
});
