var HelloWorld = {
	init: function() {
		// Bind click to button
		$('#HelloWorldAjax button').click(function() {
			$.nirvana.sendRequest({
				controller: 'HelloWorld',
				method: 'index',
				format: 'html',
				type: 'get',
				callback: function(html) {
					$('#HelloWorldAjax').append(html);
				}
			});
		});
	}
};

$(function() {
	HelloWorld.init();
});
