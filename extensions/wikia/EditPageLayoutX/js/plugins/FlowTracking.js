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

		init: function (editor) {
					var namespace = window.mw.config.get('wgNamespaceNumber');

			if (namespace === 0) {
				require(['ext.wikia.flowTracking.createPageTracking'], function (flowTrackingCreatePage) {
					flowTrackingCreatePage.trackOnEditPageLoad(editorName(editor.mode));
				});
			} else if (namespace === -1) {
				editor.on('changeTitle', function (oldTitle, newTitle) {
					if (oldTitle === '') {
						require(['ext.wikia.flowTracking.createPageTracking'], function (flowTrackingCreatePage) {
							flowTrackingCreatePage.trackOnSpecialCreatePageLoad(editorName(editor.mode), newTitle);
						});
					}
				});
			}
		}
	});
})(this,jQuery);
