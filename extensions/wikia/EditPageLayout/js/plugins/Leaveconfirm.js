/**
 * Prevent users from being able to accidentally leave the edit page (BugId:6969)
 *
 * @author macbre
 */

(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	/**
	 * Confirm when user wants to leave the edit page
	 */
	WE.plugins.leaveconfirm = $.createClass(WE.plugin,{

		isDirtyFlag: false,
		initialContent: false,
		dialogShown: false,
		leaveMessage: false,

		init: function() {
			this.leaveMessage = $.msg('wikia-editor-leaveconfirm-message');
			this.editor.on('editorReady', this.proxy(this.onEditorReady));

			// allow other plugins to mark content as changed
			this.editor.on('markDirty', this.proxy(this.onMarkDirty));

			// don't show confirm dialog when page is saved
			this.editor.on('state', this.proxy(this.onStateChange));

			$(window).bind('beforeunload.leaveconfirm', this.proxy(this.onBeforeUnload));
			$(window).bind('unload.leaveconfirm', this.proxy(this.onUnload));
		},

		onEditorReady: function() {
			this.initialContent = this.editor.getContent();
		},

		onMarkDirty: function() {
			this.isDirtyFlag = true;
			this.editor.log('edit page marked as dirty');
		},

		onStateChange: function(editor, state) {
			var states = editor.states;

			switch (state) {
				// page is being saved
				case states.SAVING:
				//  page is being reload
				case states.RELOADING:
					$(window).unbind('.leaveconfirm');
					break;
			}
		},

		// @see https://developer.mozilla.org/en/DOM/window.onbeforeunload
		onBeforeUnload: function(ev) {
			if (this.isDirty()) {
				this.track('init');
				this.dialogShown = true;

				if (ev) {
					ev.returnValue = this.leaveMessage;
				}

				return this.leaveMessage;
			}
		},

		// user decided to leave the page
		onUnload: function(ev) {
			if (this.dialogShown) {
				this.track('ok');
			}
		},

		track: function(ev) {
			this.editor.track('quitdialog', ev);
		},

		isEditorDirty: function() {
			if (this.editor.ck) {
				// @see http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#checkDirty
				return this.editor.ck.checkDirty();
			}
			else {
				return this.initialContent != this.editor.getContent();
			}
		},

		// was any change to the page made?
		isDirty: function() {
			return this.isDirtyFlag || this.isEditorDirty();
		}
	});
})(this,jQuery);