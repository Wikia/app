require(['jquery'],
	function ($) {
		if ( $.cookie('useskin') === 'oasis' ) {
			$('.mobile-site-link').click(mobileSiteLinkClicked);
			$('.mobile-site-link').css("display", "inline-block");
		}
		function mobileSiteLinkClicked(){
			$.cookie("useskin", null, {path: '/', domain: wgCookieDomain});
		}
	}
);
