(function(window){

	var WE = window.WikiaEditor;

	WE.modules.ModeSwitch = $.createClass(WE.modules.ButtonsList,{
		modes: true,

		headerClass: 'mode_switch',

		items: [
			'ModeSource',
			'ModeWysiwyg'
		],

		init: function() {
			var editor = this.editor,
				tabs = editor.getSpace('tabs');

			if (tabs) {
				// Tabs are in place - hide them. 
				editor.on('editboxReady', function() {
					tabs.hide();
				});

				// Page is fully loaded - show tabs (BugId:16836)  
				$(window).bind('load', function() {
					tabs.show();			
				});
			}
		}
	});

})(this);