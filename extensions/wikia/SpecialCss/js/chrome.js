$(function() {
	require(['ace/ace'], function(ace) {
		// TODO extract this path from PHP
		var path = "/__cb1371064522//resources/Ace";
		ace.config.set("workerPath", path);

		var editor = ace.edit("cssEditorTextarea");
		editor.setTheme("ace/theme/geshi");
		editor.getSession().setMode("ace/mode/css");
	});
});
