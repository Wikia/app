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

		// track list creation
		editor.on('listCreated', self.trackListCreated);

		// toolbar tracking

		// tracking for CK toolbar buttons
		editor.on('buttonClick', function(ev) {
			var buttonClicked = ev.data.button;
			//RTE.log(buttonClicked);

			RTE.track('toolbar', buttonClicked.command);
		});

		// tracking for CK toolbar rich combos (dropdowns)
		editor.on('panelShow', function(ev) {
			var me = ev.data.me;
			//RTE.log(me);

			var id = me.trackingName || me.className.split('_').pop();

			// track combo panel open
			RTE.track('toolbar', id + 'Menu', 'open');
		});
		editor.on('panelClick', function(ev) {
			var me = ev.data.me;
			var value = ev.data.value;
			//RTE.log([me, value]);

			var id = me.trackingName || me.className.split('_').pop();

			// for templates dropdown
			if (id == 'template') {
				if (value == '--other--') {
					value = 'other';
				}
				else {
					var panelItems = me._.items;
					var idx = 0;

					// iterate thru panel items and find index chosen template
					for (tpl in panelItems) {
						idx++;
						if (tpl == value) {
							value = idx;
							break;
						}
					}
				}
			}

			// track combo panel open
			RTE.track('toolbar', id + 'Menu', value);
		});

		// tracking for MW toolbar buttons
		editor.on('instanceReady', function() {
			$('#mw-toolbar').bind('click', function(ev) {
				var target = $(ev.target).filter('img');
				//RTE.log(target);

				if (!target.exists()) {
					return;
				}

				var id = target.attr('id').split('-').pop();
				RTE.track('source', id);
			});
		});
	},

	trackApplyStyle: function(ev) {
		var style = ev.data.style;
		var remove = ev.data.remove;

		// only track when style is applied
		if (style && !remove) {
			RTE.track('visualMode', 'applyFormat', style);
		}
	},

	trackContextMenuOpen: function(ev) {
		RTE.track('visualMode', 'contextMenu', 'open');
	},

	trackContextMenuItem: function(ev) {
		var name = ev.data.item.command;

		// group events which name starts with...
		var g, groups = ['cell', 'row', 'column'];

		for(g=0; g<groups.length; g++) {
			var group = groups[g];

			if (name.indexOf(group) == 0) {
				RTE.track('visualMode', 'contextMenu', 'action', group, name);
				return;
			}
		}

		RTE.track('visualMode', 'contextMenu', 'action', name);
	},

	trackListCreated: function(ev) {
		var listNode = ev.data.listNode;
		var listType = (listNode.getName() == 'ul') ? 'unorderedList' : 'orderedList';

		RTE.track('format', listType);
	}
});
