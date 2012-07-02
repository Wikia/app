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

ActivityFeedTag.addTracking = function(id) {
	$('#' + id).find('li').each(function(n) {
		$(this).find('strong').find('a').click( function(e) {
			WET.byStr('activityfeedtag/title');
		});
		$(this).find('cite').find('a').eq(0).click( function(e) {
			WET.byStr('activityfeedtag/user');
		});
		$(this).find('cite').find('a').eq(1).click( function(e) {
			WET.byStr('activityfeedtag/diff');
		});
	});
}

ActivityFeedTag.initActivityTag = function(obj) {
	ActivityFeedTag.loadFreshData(obj.tagid, obj.jsParams, obj.timestamp);
	ActivityFeedTag.addTracking(obj.tagid);
}
