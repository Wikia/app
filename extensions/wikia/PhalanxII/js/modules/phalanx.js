define('phalanx', ['jquery', 'wikia.nirvana'], function($, nirvana) {
	var TOKEN;

	function init(token) {
		TOKEN = token;
	}

	function unblock(blockId) {
		var dfd = new $.Deferred();

		nirvana.postJson('PhalanxSpecial', 'unblock', {
			blockId: blockId,
			token: TOKEN
		}, function(resp) {
			if (resp && resp.success) {
				dfd.resolve(true);
			}
			else {
				dfd.reject();
			}
		}, function() {
			dfd.reject();
		});

		return dfd.promise();
	}

	// API
	return {
		init: init,
		unblock: unblock
	}
});
