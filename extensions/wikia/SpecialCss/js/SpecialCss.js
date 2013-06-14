$(function() {
	require(['ace/ace'], function(ace) {
		var EDITOR_BOTTOM_MARGIN = 10;

		ace.config.set("workerPath", aceScriptsPath);

		var editor = ace.edit("cssEditorContainer");
		editor.setTheme("ace/theme/geshi");
		editor.getSession().setMode("ace/mode/css");

		var heightUpdateFunction = function() {
			var editorContainer = $('#cssEditorContainer');
			var newHeight = $(window).height()
				- editorContainer.offset().top
				- $('#WikiaBarWrapper:not(.hidden)').height()
				- EDITOR_BOTTOM_MARGIN;

			editorContainer.height(newHeight);

			// This call is required for the editor to fix all of
			// its inner structure for adapting to a change in size
			editor.resize();
		};

		heightUpdateFunction();
	});
});
