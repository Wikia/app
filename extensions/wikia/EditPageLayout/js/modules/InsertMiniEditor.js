(function(window){

		var WE = window.WikiaEditor,
				items;

		items = [
			'InsertImage'
		];

		// hide add video button if is true and user does not have apppropriate rights
		if (window.showAddVideoBtn) {
			// using ES5 Array.indexOf -- current browser support includes ES5 support, but be aware for future bug reports
			items.splice( 1, 0, "InsertVideo" );
		}


		WE.modules.InsertMiniEditor = $.createClass(WE.modules.Insert, {
				items: items,
				init: function() {
					WE.modules.InsertMiniEditor.superclass.init.call(this);
				}
		});

})(this);
