$(function() {

var LVS = {
	init: function() {
		this.container = $('#LVSGrid');

		this.initDropDown();
		this.initCallout();
		this.initMoreSuggestions();
		this.initSwapArrow();
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
	},
	initMoreSuggestions: function() {
		this.container.on('click', '.more-link', function(e) {
			e.preventDefault();
			var $this = $(this),
				toggleDiv = $this.parent().next('.more-videos');

			if ( $this.hasClass('expanded') ) {
				$this.removeClass('expanded');
				toggleDiv.slideUp();
			} else {
				$this.addClass('expanded');
				toggleDiv.slideDown();
			}

		});
	},
	initSwapArrow: function() {
		var that = this;

		this.container.on('mouseover mouseout click', '.swap-button', function(e) {
			var parent = $(this).parent()
				arrow = parent.siblings('.swap-arrow'),
				container = parent.parent();

			if ( e.type == 'mouseover' ) {
				arrow.fadeIn(100);
			} else if ( e.type == 'mouseout' ) {
				arrow.fadeOut(100);
			} else if ( e.type == 'click' ) {
				that.handleSwap.call(that, $this, arrow, container);
			}
		});
	},
	handleSwap: function(button, arrow, container) {
		// TODO: ajax call and funky transition

		/*button.hide();
		arrow.show();
		container.find('.non-premium').fadeOut();*/
	}
};

LVS.init();

});