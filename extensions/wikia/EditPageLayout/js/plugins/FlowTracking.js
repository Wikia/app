(function (window,$) {

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable()),
		editorName = function (mode) {
			var RTE = (window.RTE === undefined);

			if (!RTE) {
				return 'rte-' + mode;
			} else if (mode === 'source') {
				return 'sourceedit';
			}

			return mode;
		};

	WE.plugins.flowtracking = $.createClass(WE.plugin,{

		initEditor: function (editor) {
			var namespace = window.mw.config.get('wgNamespaceNumber');

			if (namespace === 0) {
				require(['ext.wikia.flowTracking.createPageTracking'], function (flowTrackingCreatePage) {
					flowTrackingCreatePage.trackOnEditPageLoad(editorName(editor.mode));
				});
			} else if (namespace === -1) {
				editor.on('changeTitle', this.proxy(this.onChangeTitle));
			}
		},

		onChangeTitle: function (oldTitle, newTitle) {
			var editor = this.editor;

			require(['ext.wikia.flowTracking.createPageTracking'], function (flowTrackingCreatePage) {
				// Check if title is provided first time and has valid namespace
				if (oldTitle === '' && flowTrackingCreatePage.isTitleInMainNamespace(newTitle)) {
					flowTrackingCreatePage.trackOnSpecialCreatePageLoad(editorName(editor.mode));
				}
			});
		}
	});
})(this,jQuery);
