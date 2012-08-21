var VideoHandlers = {
	init: function() {
		// Fix thumbnail overlay styles in IE8 (max-width/overflow hidden bug) (BugId:42229)
		if($.browser.msie && $.browser.version=="8.0") {
			$('#WikiaArticle').find('.info-overlay-title').each(function() {
				var $this = $(this),
					width = $this.css('max-width');
				$this.css('width', width);
			});
		}
	}
}
	
VideoHandlers.init();