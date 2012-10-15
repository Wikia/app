CKEDITOR.plugins.add('rte-track',
{
	stats: {},

	// increase stats entry value (default by 1)
	statsInc: function(key, val) {
		val = parseInt(val) || 1;

		if (this.stats[key]) {
			this.stats[key] += val;
		}
		else {
			this.stats[key] = val;
		}
	},

	// get value of given stats entry
	statsGet: function(key) {
		return this.stats[key] || 0;
	},

	// pass tracking events to RTE.track
	track: function() {
		RTE.track.apply(RTE, Array.prototype.slice.call(arguments));
	},

	init: function(editor) {
		// track style applies
		editor.on('wysiwygModeReady', function() {
			editor.document.removeListener(this.onApplyStyle);
			editor.document.on('applyStyle', this.onApplyStyle, this);
		}, this /* scope */);

		// track context menu
		editor.on('contextMenuOnOpen', this.onContextMenuOpen, this /* scope */);
		editor.on('contextMenuOnClick', this.onContextMenuItem, this);

		// track list creation
		editor.on('listCreated', this.onListCreated, this);

		// tracking for CK toolbar buttons
		editor.on('buttonClick', this.onButtonClick, this);

		// insert media / templates
		editor.on('afterCommandExec', this.onAfterCommandExec, this);

		// tracking for CK toolbar rich combos (dropdowns)
		editor.on('panelShow', this.onPanelShow, this);
		editor.on('panelClick', this.onPanelClick, this);

		editor.on('submit', this.onSubmit, this);
	},

	onApplyStyle: function(ev) {
		var style = ev.data.style,
			remove = ev.data.remove;

		// only track when style is applied
		if (style && !remove) {
			this.track('visualMode', 'applyFormat', style);
		}
	},

	onContextMenuOpen: function(ev) {
		this.track('visualMode', 'contextMenu', 'open');
	},

	onContextMenuItem: function(ev) {
		var name = ev.data.item.command;

		// group events which name starts with...
		var g, groups = ['cell', 'row', 'column'];

		for(g=0; g<groups.length; g++) {
			var group = groups[g];

			if (name.indexOf(group) == 0) {
				this.track('visualMode', 'contextMenu', 'action', group, name);
				return;
			}
		}

		this.track('visualMode', 'contextMenu', 'action', name);
	},

	onListCreated: function(ev) {
		var listNode = ev.data.listNode,
			listType = (listNode.getName() == 'ul') ? 'unorderedList' : 'orderedList';

		this.track('format', listType);
	},

	onButtonClick: function(ev) {
		var buttonClicked = ev.data.button;

		this.track('toolbar', buttonClicked.command);
		this.statsInc('toolbarButtonsClicked');
	},

	onAfterCommandExec: function(ev) {
		var commandName = ev.data.name || '';

		if(commandName.substring(0, 3) == 'add') {
			this.statsInc('addButtonsClicked');
		}
	},

	onPanelShow: function(ev) {
		var me = ev.data.me,
			id = me.trackingName || me.className.split('_').pop();

		// track combo panel open
		this.track('toolbar', id + 'Menu', 'open');
	},

	onPanelClick: function(ev) {
		var me = ev.data.me,
			value = ev.data.value,
			id = me.trackingName || me.className.split('_').pop();

		this.track('toolbar', id + 'Menu', value);
	},

	onSubmit: function() {
		// count number of click on toolbar and "Add media" buttons (BugId:2947)
		var buttonsClicked = this.statsGet('toolbarButtonsClicked') + this.statsGet('addButtonsClicked');

		if (buttonsClicked > 0) {
			this.track('buttonsClicked', buttonsClicked);
		}
	}
});
