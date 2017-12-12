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
		$.get('/api.php?format=json&action=query&list=allinfoboxes&yselang=' + window.wgContentLanguage)
			.then(function (data) {
				window.CKEDITOR.dialog.add( 'infobox-dialog', function( editor ) {
					return {
						title: 'Select Infobox to Insert',
						minWidth: 400,
						minHeight: 200,
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
						]
					};
				});

				RTE.getInstance().openDialog('infobox-dialog');
			});
	}

	function getInfoboxListMarkup(data) {
		if (!data || !data.query || !data.query.allinfoboxes || !data.query.allinfoboxes.length) {
			return '';
		}

		var markup = '<ul>';

		data.query.allinfoboxes.forEach(function (infoboxData) {
			markup += '<li><a>' + infoboxData.title + '</a></li>';
		});

		markup += '</ul>';

		return markup;
	}

	registerPlugin();
});
