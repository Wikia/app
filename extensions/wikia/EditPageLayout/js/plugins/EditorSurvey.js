(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	WE.plugins.editorsurvey = $.createClass(WE.plugin,{

		init: function() {
			if ( EditorSurvey ) {
				EditorSurvey.bindUnload( 'ck-fail' );
				this.editor.on('state', this.proxy(this.stateChanged));
			}
		},
		stateChanged: function( editor, state ) {
			if ( state == editor.states.SAVING ) {
				EditorSurvey.unbindUnload();
				EditorSurvey.set( 'ck-success' );
			}
		}
	});
})(this,jQuery);
