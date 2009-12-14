CKEDITOR.plugins.add('rte-track',
{
	init: function(editor) {
		var self = this;

		// track style applies
		editor.on('wysiwygModeReady', function() {
			editor.document.removeListener(self.trackApplyStyle);
			editor.document.on('applyStyle', self.trackApplyStyle);
		});

		// track context menu
		editor.on('contextMenuOnOpen', self.trackContextMenuOpen);
		editor.on('contextMenuOnClick', self.trackContextMenuItem);

		// track loading time
		editor.on('RTEready', function() {
			self.trackLoadTime(editor);
		});
	},

	trackApplyStyle: function(ev) {
		var style = ev.data.style;
		var remove = ev.data.remove;

		// only track when style is applied
		if (style && !remove) {
			RTE.track('toolbar', 'format', style);
		}
	},

	trackContextMenuOpen: function(ev) {
		RTE.track('contextMenu', 'open');
	},

	trackContextMenuItem: function(ev) {
		var name = ev.data.item.command;

		// group events which name starts with...
		var g, groups = ['cell', 'row', 'column'];

		for(g=0; g<groups.length; g++) {
			var group = groups[g];

			if (name.indexOf(group) == 0) {
				RTE.track('contextMenu', 'action', group, name);
				return;
			}
		}

		RTE.track('contextMenu', 'action', name);
	},

	trackLoadTime: function(editor) {
		// load time in ms (3.141 s will be reported as .../3100)
		var trackingLoadTime = parseInt(RTE.loadTime * 10) * 100;

		// tracking
		switch (editor.mode) {
			case 'source':
				RTE.track('init', 'sourceMode', trackingLoadTime);

				// add edgecase name (if any)
				if (window.RTEEdgeCase) {
					RTE.track('init', 'edgecase',  window.RTEEdgeCase);
				}

				break;

			case 'wysiwyg':
				RTE.track('init', 'wysiwygMode', trackingLoadTime);
				break;
		}
	}
});
