
var trackSpecialCssClick = function (action, label, value, params, event) {
	Wikia.Tracker.track({
		category: 'special-css',
		action: action,
		browserEvent: event,
		label: label,
		trackingMethod: 'both',
		value: value
	}, params);
};

$(function() {
	// impressions
	Wikia.Tracker.buildTrackingFunction({
		category: "special-css",
		trackingMethod: "both",
		action: Wikia.Tracker.ACTIONS.IMPRESSION
	});

	// click on update-items and educational modules
	$("#cssEditorForm").on("click", "a[data-tracking]", function(e) {
		var t = $(this);
		trackSpecialCssClick(Wikia.Tracker.ACTIONS.CLICK, t.data('tracking'), null, {href: t.attr('href')}, e);
	});

	// history and show changes
	$(".wikia-menu-button-submit a").on("click", function(e) {
		var t = $(this);
		switch (t.data('id')) {
			case 0:
				trackSpecialCssClick(Wikia.Tracker.ACTIONS.CLICK, 'history', null, {href: t.attr('href')}, e);
				return;
			case 1:
				trackSpecialCssClick(Wikia.Tracker.ACTIONS.OPEN, 'changes', null, {}, e);
				return;
		}
	});

	require(['ace/ace'], function(ace) {
		var disableBeforeUnload = false;
		var EDITOR_BOTTOM_MARGIN = 10;

		// aceScriptsPath is set in PHP controller SpecialCssController.class.php:99
		ace.config.set("workerPath", aceScriptsPath); /* JSlint ignore */

		var editor = ace.edit("cssEditorContainer");
		editor.setTheme("ace/theme/geshi");
		editor.setShowPrintMargin(false);
		var editorSession = editor.getSession();
		editorSession.setMode("ace/mode/css");

		var editorInitContent = editorSession.getValue();

		var heightUpdateFunction = function() {
			var editorContainer = $('#cssEditorContainer'),
			newHeight = $('.css-side-bar').height()
				- $('.editor-changes-info-wrapper').children().outerHeight(true)
				- EDITOR_BOTTOM_MARGIN;

			editorContainer.outerHeight(newHeight);

			// This call is required for the editor to fix all of
			// its inner structure for adapting to a change in size
			editor.resize();
		};

		heightUpdateFunction();

		$('#cssEditorForm').submit(function(e) {
			disableBeforeUnload = true;
			var form = $(this);

			trackSpecialCssClick(Wikia.Tracker.ACTIONS.SUBMIT, 'publish', null, {}, e);

			var hiddenInput = $('<input/>')
				.attr('type', 'hidden')
				.attr('name', 'cssContent')
				.val(editorSession.getValue());
			form.append(hiddenInput);

			// prevent submitting immediately so we can track this event
			e.preventDefault();
			form.unbind('submit');
			setTimeout(function() {form.submit();}, 100, form);
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

		//noinspection FunctionWithInconsistentReturnsJS,JSUnusedLocalSymbols
		$(window).bind('beforeunload', function(e) {
			if (!disableBeforeUnload && editorInitContent != editorSession.getValue()) {
				return $.msg('special-css-leaveconfirm-message');
			}
		});
	});
});
