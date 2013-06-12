$(function() {
	require(['ace/ace'], function(ace) {
		ace.config.set("workerPath", aceScriptsPath);

		var editor = ace.edit("cssEditorTextarea");
		editor.setTheme("ace/theme/geshi");
		editor.getSession().setMode("ace/mode/css");
	});
});
