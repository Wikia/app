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

		$('#cssEditorForm').submit(function() {
			var hiddenInput = $('<input/>')
				.attr('type', 'hidden')
				.attr('name', 'cssContent')
				.val(editor.getSession().getValue());
			$(this).append(hiddenInput);
		});

		$('#showChanges').click(function() {
			// use loading indicator before real content will be fetched
			var content = $('#SpecialCssLoading').mustache({stylepath: stylepath});
			var options = {
				callback: function(modal) {
					$.when(
							$.nirvana.sendRequest({
								controller: 'SpecialCss',
								method: 'getDiff',
								type: 'post',
								data: {
									wikitext: editor.getSession().getValue()
								}
							}),

							// load CSS for diff
							mw.loader.use('mediawiki.action.history.diff')
						).done(function(ajaxData) {
							modal.find('.modalContent').html(ajaxData[0].diff);
						});
				}
			};
			$.showModal($.msg('special-css-diff-modal-title'), content, options);
			return false;
		});
	});
});
