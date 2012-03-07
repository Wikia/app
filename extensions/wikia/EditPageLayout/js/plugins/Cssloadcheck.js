(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	WE.plugins.cssloadcheck = $.createClass(WE.plugin,{

		CSS_STATE_NAME: 'ck-stylesheets',

		pollStylesheetsTimer: false,
		pollStylesheetsTimerDelay: 100,

		currentDelay: 0,
		maxAllowedDelay: 10000,

		lastAnnounced: false,

		enabled: false,

		beforeInit: function() {
			// enable this plugin only for Firefox 4.0+ (BugId:5654)
			this.enabled = !!$.browser.mozilla && (parseInt($.browser.version) >= 2 /* '2.0.1' = Fx 4.0.1 */);

			if (this.enabled) {
				this.pollStylesheetsTimer = new Timer(this.proxy(this.pollStylesheets),this.pollStylesheetsTimerDelay);
				this.editor.on('state',this.proxy(this.stateChanged));

				// hide loading indicator when fallback occurs (BugId:6823)
				this.editor.on('editorReady', this.proxy(function() {
					if (this.editor.ck) {
						this.editor.ck.on('modeSwitchCancelled', this.proxy(function() {
							this.fireState(this.editor.states.IDLE);
						}));
					}
				}));
			}
		},

		init: function() {
			if (this.enabled) {
				this.stateChanged(this.editor,this.editor.state);
			}
		},

		stateChanged: function( editor, state ) {
			var states = this.editor.states;

			this.pollStylesheetsTimer.stop();
			if ((state == states.INITIALIZING && this.editor.mode == 'wysiwyg') || state == states.LOADING_VISUAL) {
				// when wysiwyg mode is loading
				this.fireState(states.INITIALIZING);
			} else if (state == states.IDLE && this.lastAnnounced == states.INITIALIZING) {
				this.currentDelay = 0;
				this.pollStylesheets();
			} else {
				this.fireState(states.IDLE);
			}
		},

		pollStylesheets: function() {
			this.pollStylesheetsTimer.stop();

			var ed = this.editor.element;

			if (ed) {
				var iframe = ed.find('iframe');
				if (iframe.exists()) {
					var doc = iframe.get(0).contentDocument,
						head = doc && $('head',$(doc)),
						headColor = head && head.css('color');
					if ( (typeof headColor == 'string') && $.inArray(headColor.toLowerCase(), ['transparent','rgb(0, 0, 0)','white','#ffffff','#fff']) == -1 ) {
						this.fireState(this.editor.states.IDLE);
						return;
					}
				}
			}

			this.currentDelay += this.pollStylesheetsTimerDelay;
			if (this.currentDelay > this.maxAllowedDelay) {
				this.fireState(this.editor.states.IDLE);
				return;
			}

			this.pollStylesheetsTimer.start();
		},

		fireState: function( state ) {
			if (this.lastAnnounced !== state) {
				this.editor.fire('extraState',this.editor,this.CSS_STATE_NAME,state);
				this.lastAnnounced = state;
			}
		}

	});

})(this,jQuery);
