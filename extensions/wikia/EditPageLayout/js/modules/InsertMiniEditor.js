(function(window){

	var WE = window.WikiaEditor;

	WE.modules.InsertMiniEditor = $.createClass(WE.modules.Insert, {
		items: [
			'InsertImage',
			// add video button
			'InsertVideo'
		],
		init: function() {
			WE.modules.InsertMiniEditor.superclass.init.call(this);
		}
	});

})(this);
