$(function() {
	require(['ace/ace'], function(ace) {
		ace.config.set("workerPath", aceScriptsPath);

		var editor = ace.edit("cssEditorContainer");
		editor.setTheme("ace/theme/geshi");
		editor.getSession().setMode("ace/mode/css");

		var heightUpdateFunction = function() {

			var newHeight =
				editor.getSession().getScreenLength()
					* editor.renderer.lineHeight
					+ editor.renderer.scrollBar.getWidth();

			$('#cssEditorContainer').height(newHeight.toString() + "px");

			// This call is required for the editor to fix all of
			// its inner structure for adapting to a change in size
			editor.resize();
		};

		heightUpdateFunction();
		editor.getSession().on('change', heightUpdateFunction);
	});
});
