// hover.js
$j( function() {
	$j('.mw-tooltip-text').tooltip({
		bodyHandler: function() {
			var content = $j(this).find('.mw-tooltip');
			return content.html();
		},
		showURL : false
	});
} );
