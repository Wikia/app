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

				// overlay just an edit area (BugId:6349)
				this.editarea = this.editor.getSpace('editarea');

				this.editor.on('state', this.proxy(this.stateChanged));
				this.editor.on('extraState', this.proxy(this.extraStateChanged));
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

			if ((this.state = state)) {
				var text = this.editor.msg(this.MESSAGE_PREFIX + state);

				// allow edit pages to override message shown to the user when saving the page (BugId:7123)
				if (state === 'saving' && window.wgSavingMessage) {
					text = window.wgSavingMessage;
				}

				this.textEl.text(text);
				this.el.show();

			} else {
				this.el.hide();
				this.editor.fire('afterLoadingStatus');
			}
		}
	});

})(this, jQuery);