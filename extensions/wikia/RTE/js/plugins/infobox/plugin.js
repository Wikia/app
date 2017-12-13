require(['jquery', 'wikia.window'], function ($, window) {
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

	function openInfoboxModal(editor) {

		buttonStyle = "width:100%;background-image: none;background-color: white; text-align:center; color:black !important; border-radius:0px; border-color: black; border-style: dashed;";

		$.get('/api.php?format=json&action=query&list=allinfoboxes&uselang=' + window.wgContentLanguage)
			.then(function (data) {
				window.CKEDITOR.dialog.add( 'infobox-dialog', function( editor ) {
					return {
						title: 'Select Infobox to Insert',
						buttons: [
						{
							type : 'button',
							id : 'something',
							label : '+ Add Template',
							style : buttonStyle,
							onClick : onInfoboxTemplateChosen
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

		var markup = '<ul class="infobox-templates-list" style="height:300px;overflow:hidden;overflow-y:scroll;">';

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
