(function(window){

		var WE = window.WikiaEditor,
				items;

		items = [
			'InsertImage',
			'InsertVideo'
		];

		// hide add video button if is true and user does not have apppropriate rights
		if (window.hideAddVideoBtn) {
			// using ES5 Array.indexOf -- current browser support includes ES5 support, but be aware for future bug reports
			items.splice( items.indexOf('InsertVideo'), 1 );
		}


		WE.modules.InsertMiniEditor = $.createClass(WE.modules.Insert, {
				items: items,
				init: function() {
					WE.modules.InsertMiniEditor.superclass.init.call(this);
				}
		});

})(this);
