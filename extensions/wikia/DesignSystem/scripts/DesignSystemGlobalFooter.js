
require(['jquery'],
	function ($) {
		$('.mobile-site-link').click(mobileSiteLinkClicked);
		function mobileSiteLinkClicked(){
			document.cookie = 'useskin=; expires=Thu, 01 Jan 1970 00:00:01 GMT; path=/; domain=' + wgCookieDomain;
		}
	}
);
