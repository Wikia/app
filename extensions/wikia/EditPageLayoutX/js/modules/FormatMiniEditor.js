(function(window){

	var WE = window.WikiaEditor;

	WE.modules.FormatMiniEditor = $.createClass(WE.modules.ButtonsList, {
		headerClass: 'formatmini',
		items: [
			'Bold',
			'Italic',
			'Link'
		]
	});

})(this);