var JSMemcBridgeUrl = 'http://dev-adi:8080/';

$(function() {
	var cnt = $('#searchedKeywords');
	var tdata = false;
	var updateCloud = function() {
		if (!tdata) return;
		var data = tdata;
		cnt.empty();
		var ts = (new Date()).getTime() / 1000;
		$.each(data.keywords,function(i,v){
			var h = 100 - (ts - v.ts) * 5;
			$('<li>').text(v.k).attr('value',v.c).attr("hot",h).appendTo(cnt);
		});
		cnt.tagcloud({
			type:'sphere',
//			colormin: '00F',
			colormax: 'F00'
		});
	}
	$.memcached.watch('SearchedKeywords',function(data){
		console.log(data);
		tdata = data;
		updateCloud();
	});
	setInterval(function(){
		updateCloud();
	},1000);
});