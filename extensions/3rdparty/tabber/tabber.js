(function($) {
	$.fn.tabber = function() {
		return this.each(function() {
			// create tabs
			var $this = $(this),
				tabContent = $this.children('.tabbertab'),
				nav = $('<ul>').addClass('tabbernav');
			tabContent.each(function() {
				var anchor = $('<a>').text(this.title).attr('title', this.title).attr('href', '#');
				$('<li>').append(anchor).appendTo(nav);

				// SUS-2997: Manually insert word break point after each tab
				nav.append($('<wbr>'));
			});
			$this.prepend(nav);

			/**
			 * Internal helper function for showing content
			 * @param  string title to show, matching only 1 tab
			 * @return true if matching tab could be shown
			 */
			function showContent(title) {
				var content = tabContent.filter('[title="' + title + '"]');
				if (content.length !== 1) return false;
				tabContent.hide();
				content.show();
				nav.find('.tabberactive').removeClass('tabberactive');
				nav.find('a[title="' + title + '"]').parent().addClass('tabberactive');

				// Wikia change begin - trigger scroll event to lazy load any new images
				var scrollEvent = new CustomEvent('scroll');
				window.dispatchEvent(scrollEvent);
				// Wikia change end

				return true;
			}
			// setup initial state
			var loc = location.hash.replace('#', '');
			if ( loc == '' || !showContent(loc) ) {
				showContent(tabContent.first().attr('title'));
			}

			// Repond to clicks on the nav tabs
			nav.on('click', 'a', function(e) {
				var title = $(this).attr('title');
				e.preventDefault();
				location.hash = '#' + title;
				showContent( title );
			});

			$this.addClass('tabberlive');
		});
	};
})(jQuery);

$(document).ready(function() {
	$('.tabber:not(.tabberlive)').tabber();
});

mw.hook('wikipage.content').add(function ($content) {
	$content.find('.tabber:not(.tabberlive)').tabber();
});
