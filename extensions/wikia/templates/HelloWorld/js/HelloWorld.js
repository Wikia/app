require(['jquery', 'hello'], function($, hello) {
	function init() {
		// Bind click to button
		$('#HelloWorldAjax button').click(function() {
			hello(function(html) {
				$('#HelloWorldAjax').append(html);
			});
		});
	}

	$(function() {
		init();
	});
});
