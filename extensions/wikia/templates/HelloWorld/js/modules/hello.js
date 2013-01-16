define('hello', ['nirvana'], function(nirvana) {
	function getContent(callback) {
		nirvana.sendRequest({
			controller: 'HelloWorld',
			method: 'index',
			format: 'html',
			type: 'get',
			callback: callback
		});
	}

	// module export list
	return getContent;
});
