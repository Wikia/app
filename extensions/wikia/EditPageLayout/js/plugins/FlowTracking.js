(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	var editorName = function(mode) {
		var RTE = (window.RTE === undefined);

		if (!RTE) {
			return 'rte-' + mode;
		} else if (mode === 'source') {
			return 'sourceedit';
		}

		return mode;
	};

	WE.plugins.flowtracking = $.createClass(WE.plugin,{

		initEditor: function(editor) {
			require(['wikia.flowTracking.createPage'], function(flowTrackingCreatePage) {
				flowTrackingCreatePage.trackOnEditPageLoad(editorName(editor.mode));
			});
		}
	});
})(this,jQuery);
