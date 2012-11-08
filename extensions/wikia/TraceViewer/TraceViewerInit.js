(function(window,$) {
	function openTrace() {
		mw.loader.using(['wikia.ext.traceviewer'],function(){
			setTimeout(function(){
				window.TraceViewer.openFromDom();
			},0);
		});
	}
	$(function(){
		var loc = '' + document.location;
		if ( /forcetrace=\d/.test(loc)) {
			var btn = $('<a>',{
				style: "display: inline-block; position:fixed; bottom: 0; right:0; z-index: 2000000000; "
					+ "font-weight: bold; color: red; background-color: blue;",
				href: '#',
				text: 'Browse Trace',
				click: openTrace
			});
			$('body').append(btn);
		}
	});
})(this,jQuery);