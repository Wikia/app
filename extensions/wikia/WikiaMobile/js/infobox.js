require(['jquery'], function($){
	'use strict';

	var SHORT_CLASS = 'short',
		$infoboxes = $('table[class*="infobox"] tbody');

	if($infoboxes.length) {
		$infoboxes
			.filter(function(){
				return this.rows.length > 10;
			})
			.addClass(SHORT_CLASS)
			.append('<tr class=infobox-expand><td colspan=2><span>V</span></td></tr>')
			.on('click', function(event){
				var $target = $(event.target),
					$this = $(this);

				if(!$target.is('a') && $this.toggleClass(SHORT_CLASS).hasClass(SHORT_CLASS)) {
					$this.find('.infobox-expand')[0].scrollIntoViewIfNeeded();
				}
			});
	}

});