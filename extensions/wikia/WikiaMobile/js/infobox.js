require(['jquery', 'wikia.window'], function($, window){
	'use strict';

	var SHORT_CLASS = 'short',
		$infoboxes = $('table[class*="infobox"] tbody'),
		body = window.document.body,
		scrollTo = body.scrollIntoViewIfNeeded || body.scrollIntoView;

	if($infoboxes.length) {
		$infoboxes
			.filter(function(){
				return this.rows.length > 10;
			})
			.addClass(SHORT_CLASS)
			.append('<tr class=infobox-expand><td colspan=2><span class=chevron></span></td></tr>')
			.on('click', function(event){
				var $target = $(event.target),
					$this = $(this);

				if(!$target.is('a') && $this.toggleClass(SHORT_CLASS).hasClass(SHORT_CLASS)) {
					scrollTo.apply($this.find('.infobox-expand')[0]);
				}
			});
	}

	/**
	 * @desc handle portable infoboxes - logic copied from mercury
	 * @todo Should be refactored or removed ones articles on Mercury are served to logged in users
	 */
	function handlePortableInfoboxes() {
		var collapsedClass = 'collapsed',
			expandButtonClass = 'portable-infobox-expand-button',
			minimumHeight = 450,
			$infoboxes = $('#wkMainCnt .portable-infobox'),
			body = window.document.body,
			scrollTo = body.scrollIntoViewIfNeeded || body.scrollIntoView,
			expandButton = '<div class="' + expandButtonClass + '"><span class=chevron></span></div>'

		if ($infoboxes.length) {
			$infoboxes.filter( function (index, element) {
					return $(element).outerHeight() > minimumHeight;
				})
				.addClass(collapsedClass)
				.append(expandButton)
				.on('click', function (event) {
					var $target = $(event.target),
						$this = $(this);

					if (!$target.is('a') && $this.toggleClass(collapsedClass).hasClass(collapsedClass)) {
						scrollTo.apply($this.find('.' + expandButtonClass)[0]);
					}
				});
		}
	}

	handlePortableInfoboxes();
});
