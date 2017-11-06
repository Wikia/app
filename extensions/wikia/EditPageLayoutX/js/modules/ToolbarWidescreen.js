(function(window){

	var WE = window.WikiaEditor;

	WE.modules.ToolbarWidescreen = $.createClass(WE.modules.Container,{

		modes: true,
		
		containerClass: 'cke_toolbar_widescreen',
		items: [
		    'ToolbarInsert',
		    {cls:'right right-top',items:['ToolbarCategories','ToolbarTemplates']},
		    {cls:'right right-bottom',items:['ToolbarLicense']}
		]
	
	});

})(this);