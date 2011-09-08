var HelloWorld = {
	
	init: function() {

		// Bind click to button
		$('#HelloWorldAjax button').click(function() {
			$.get(wgScriptPath + '/wikia.php?controller=UserPreferencesStats&method=index&format=html', function(data) {
				$('#HelloWorldAjax').append(data);
			});
		});
	}
	
};

$(function() {
	HelloWorld.init();
})