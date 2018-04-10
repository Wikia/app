require(['jquery'],
	function ($) {
		if ($.cookie('useskin') === 'oasis')  {
			$('.mobile-site-link')
				.click(mobileSiteLinkClicked)
				.addClass("mobile-site-link--active");
		}

		function mobileSiteLinkClicked(){
			$.cookie("useskin", null, {path: '/', domain: wgCookieDomain});
		}
	}
);
