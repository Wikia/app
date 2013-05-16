$(function() {

var LVS = {
	init: function() {
		this.initDropDown();
		this.initCallout();
	},
	initDropDown: function() {
		$('.WikiaDropdown').wikiaDropdown({
			onChange: function(e, $target) {
				console.log('changed');
			}
		});
	},
	initCallout: function() {
		var callout = $('#WikiaArticle').find('.lvs-callout'),
			closeBtn = callout.find('.close');

		callout.show();

		closeBtn.on('click', function(e) {
			e.preventDefault();
			callout.slideUp();
			// TODO: implement cookie to not open again.
		});
	}
}

LVS.init();

});