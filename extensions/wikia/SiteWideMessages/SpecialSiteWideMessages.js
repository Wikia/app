$(document).ready(function(){
	$("span.SWM_dismiss a").each(function(){
		var rxId = new RegExp(/&mID=(\d+)/);
		var id = rxId.exec($(this).attr('href'))[1];
		if (id) {
			$(this).bind('click', {id: id}, SWMAjaxDismiss);
		}
	});
});

function SWMAjaxDismiss(e) {
	e.preventDefault();
	var id = e.data.id;
	var ajaxUrl = wgServer + wgScript + "?title=" + wgPageName + "&action=ajax&rs=SiteWideMessagesAjaxDismiss&rsargs=" + id;
	var request = $.get(ajaxUrl,function(data){
		$("#msg_"+id).remove();
	});
}
