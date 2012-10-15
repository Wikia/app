$(function() {
	CacheTool.init();
});

var CacheTool = {
	init: function() {
		$('#CacheToolGatherButton').click(function(e) {
			CacheTool.sendRequest('startGathering');
		});
		$('#CacheToolStopButton').click(function(e) {
			CacheTool.sendRequest('stopGathering');
		});
		$('#CacheToolClearButton').click(function(e) {
			CacheTool.sendRequest('clearStats');
		});
		$('.CacheToolContentsButton').click(function(e) {
			keyname = $(e.target).data('key');
			CacheTool.showContents(keyname);
		});
		$('.CacheToolDeleteButton').click(function(e) {
			keyname = $(e.target).data('key');
			CacheTool.deleteKey(keyname);
		});		
	},
	sendRequest: function(method) {
		$.nirvana.sendRequest({controller: 'CacheTool', method: method});
	},
	deleteKey: function(keyName) {
		$.nirvana.sendRequest({controller: 'CacheTool', method: 'deleteKey', data: {'key': keyName}})
		var x = '<pre>key ' + keyName + ' deleted</pre>';
		$(x).makeModal({width: 300});
	},
	showModal: function(data) {
		$(data.key).makeModal({width: 600});
	},
	showContents: function(keyName) {
		$.nirvana.sendRequest({controller: 'CacheTool', method: 'showContents', data: {'key': keyName}, callback: CacheTool.showModal})
	}
	
};
