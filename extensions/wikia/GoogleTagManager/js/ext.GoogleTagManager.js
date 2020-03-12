require(['jquery'], function ($) {
	'use strict';

	// console.log('google tag manager is in the house');

	$('head').prepend(
		'<!-- Google Tag Manager -->' +
		'<script type="text/javascript">' +
		'console.log("GoogleTagManager");' +
		'(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({"gtm.start": new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!="dataLayer"?"&l="+l:"";j.async=true;j.src="https://www.googletagmanager.com/gtm.js?id="+i+dl;f.parentNode.insertBefore(j,f);})(window,document,"script","dataLayer","GTM-MDPTN53");' +
		'</script>' +
		'<!-- Google Tag Manager (noscript) -->' +
		'<noscript>' +
		'<iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MDPTN53" height="0" width="0" style="display:none;visibility:hidden"></iframe>' +
		'</noscript>' +
		'<!-- End Google Tag Manager (noscript) -->' +
		'<!-- End Google Tag Manager -->'
	);

	$('body').append('<script type="text/javascript">console.log("loaded into the body");</script>');
	


	
});
