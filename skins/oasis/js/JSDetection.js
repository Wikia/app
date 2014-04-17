$(function() {
	$(document).on(
		'mouseover click', 
		'[href*="beforejs=1"]',
		function() {
			var uri = new mw.Uri( this.href );
			if ( uri.query.beforejs ) {
				delete uri.query.beforejs;
				this.href = uri.toString();
			}
		}
	);
});