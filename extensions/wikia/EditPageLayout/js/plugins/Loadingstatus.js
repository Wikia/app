(function(window, $) {
	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	/**
	 * Loading status indicator
	 */
	WE.plugins.loadingstatus = $.createClass(WE.plugin, {

		requires: ['spaces'],

		MESSAGE_PREFIX: 'loadingStates-',

		extraStates: {},
		extraStatesCount: 0,

		init: function() {
			if ((this.el = this.editor.getSpace('loading-status'))) {
				this.textEl = this.el.find('.loading-text');

				// Only bind if needed
				this.editor.on('state',this.proxy(this.stateChanged));
				this.editor.on('extraState',this.proxy(this.extraStateChanged));

				// overlay just an edit area (BugId:6349)
				if ((this.editarea = this.editor.getSpace('editarea'))) {
					this.set('loading');
				}
			}
		},

		extraStateChanged: function( editor, name, state ) {
			var states = editor.states;

			if (state == states.INITIALIZING) {
				if (!this.extraStates[name]) {
					this.extraStates[name] = 1;
					this.extraStatesCount++;
					this.stateChanged(editor,editor.state);
				}
			} else {
				if (this.extraStates[name]) {
					delete this.extraStates[name];
					this.extraStatesCount--;
					this.stateChanged(editor,editor.state);
				}
			}
		},

		stateChanged: function( editor, state ) {
			var states = editor.states, value = false;

			if (state == states.INITIALIZING) {
				value = 'loading';

			} else if (state == states.LOADING_SOURCE) {
				value = 'toSource';

			} else if (state == states.LOADING_VISUAL) {
				value = 'toVisual';

			} else if (state == states.SAVING) {
				value = 'saving';
			}

			if (value == false && this.extraStatesCount > 0) {
				return;
			}

			this.set(value);
		},

		set: function( state ) {
			this.editor.log('loading-status: ', state);
			
			// Don't allow typing while mode switching (BugId:23061)
			var editArea = this.editor.config.body; // this.editor.textarea may not be available yet
			// If the editor is fully initialized, we will have a getEditbox method.
			try {
				editArea = editArea.add(this.editor.getEditbox());
			} catch (e) {}

			if ((this.state = state)) {
				var text = this.editor.msg(this.MESSAGE_PREFIX + state);

				// allow edit pages to override message shown to the user when saving the page (BugId:7123)
				if (state === 'saving' && window.wgSavingMessage) {
					text = window.wgSavingMessage;
				}

				this.textEl.text(text);

				// Don't allow typing while mode switching (BugId:23061)
				editArea.bind('keydown.LoadingStatus', function(e) {
					e.preventDefault();
				});
				this.el.show();
			} else {
				editArea.unbind('keydown.LoadingStatus');
				this.el.hide();
				this.editor.fire('afterLoadingStatus');
			}
		}
	});

})(this, jQuery);