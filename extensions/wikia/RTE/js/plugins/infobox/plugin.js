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
		//ToDo unharcode lang
		$.get('/api.php?format=json&action=query&list=allinfoboxes&yselang=' + window.wgContentLanguage)
			.then(function (data) {
				console.log(data);
				window.CKEDITOR.dialog.add( 'infobox-dialog', function( editor ) {
					return {
						title: 'Abbreviation Properties',
						minWidth: 400,
						minHeight: 200,

						contents: [
							{
								id: 'tab-basic',
								label: 'Basic Settings',
								elements: [
									// UI elements of the first tab will be defined here.
								]
							},
							{
								id: 'tab-adv',
								label: 'Advanced Settings',
								elements: [
									// UI elements of the second tab will be defined here.
								]
							}
						]
					};
				});

				RTE.getInstance().openDialog('infobox-dialog');
			});
	}

	registerPlugin();
});
