var ActivityFeedTag = {};

ActivityFeedTag.loadFreshData = function(id, params, timestamp) {
	params = params.replace(/&amp;/g, '&');
	var uselang = $.getUrlVar('uselang');
	if (uselang) params += '&uselang=' + uselang;
	$.getJSON(wgScript + '?action=ajax&rs=ActivityFeedAjax', {params: params}, function(json){
		if (json.timestamp > timestamp) {
			var tmpDiv = document.createElement('div');
			tmpDiv.innerHTML = json.data;
			$('#' + id).html($(tmpDiv).find('ul').html());
		}
	});
}

ActivityFeedTag.initActivityTag = function(obj) {
	ActivityFeedTag.loadFreshData(obj.tagid, obj.jsParams, obj.timestamp);
}
