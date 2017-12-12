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
			});
	}

	registerPlugin();
});
