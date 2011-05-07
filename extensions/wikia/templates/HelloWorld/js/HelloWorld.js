$(function() {
	HelloWorld.init();
})

var HelloWorld = {
	
	init: function() {

		// Bind click to button
		$('#HelloWorldAjax button').click(function() {
			$.get('/wikia.php?controller=HelloWorld&method=index&format=html', function(data) {
				$('#HelloWorldAjax').append(data);
			});
		});
	}
	
};