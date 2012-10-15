$(function(){
	$('#failover-from').submit(function() {
		if($('#failover-from #reason').val() == "") {
			alert($.msg('chat-failover-reason-empty'));
			return false;	
		}

		var r=confirm($.msg('chat-failover-mode-areyousure'));
		if (r !== true) {
			return false;
		}
	});
});