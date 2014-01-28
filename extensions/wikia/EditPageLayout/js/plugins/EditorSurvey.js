(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	WE.plugins.editorsurvey = $.createClass(WE.plugin,{

		init: function() {
			if ( EditorSurvey ) {
				EditorSurvey.unload( true, 'ck-fail' );
				this.editor.on('state', this.proxy(this.stateChanged));
			}
		},
		stateChanged: function( editor, state ) {
			if ( state == editor.states.SAVING ) {
				EditorSurvey.unload( false );
				EditorSurvey.set( 'ck-success' );
			}
		}
	});
})(this,jQuery);
