(function () {
	var $ = require('jquery'),
		hello = require('hello');

	function init() {
		// Bind click to button
		$('#HelloWorldAjax button').click(function () {
			hello(function (html) {
				$('#HelloWorldAjax').append(html);
			});
		});
	}

	$(function () {
		init();
	});
})();
