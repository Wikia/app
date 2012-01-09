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
			// (BugId:16836) 
			var editor = this.editor;
			// Tabs are in place - hide them. 
			editor.on('editboxReady', function() {
				editor.getSpace('tabs').hide();
			});
			// Editor is loaded - show tabs. 
			editor.on('editorReady', function() {
				editor.getSpace('tabs').show();				
			})

		}

	});

})(this);