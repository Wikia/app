(function(window){

	var WE = window.WikiaEditor;

	WE.modules.ModeSwitch = $.createClass(WE.modules.ButtonsList,{
		modes: true,

		headerClass: 'mode_switch',

		items: [
			'ModeSource',
			'ModeWysiwyg',
			'|'
		]
	});

})(this);