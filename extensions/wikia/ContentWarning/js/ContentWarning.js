$(function(){
	ContentWarning = {
		init: function() {
			if(window.wgNeedContentWarning) {
				ContentWarning.showWarning( 
				function() {
					ContentWarning.approveWarning(function() {
						ContentWarning.hideWarning();
					});
					return false;
				}, function() {
					window.location = "http://wikia.com";
					return false;
				});
			}
		},
		isLogedin: function() {
			if(window.wgUserName) {
				return true;
			}
			return false;
		},
		
		approveWarning: function(callback) {
			if(this.isLogedin()) {
				$.nirvana.sendRequest({
					controller: 'ContentWarningController',
					method: 'approveContentWarning',
					data: {},
					type: "POST",
					format: 'json',
					callback: function(data) {
						callback();
					}
				});
			} else {
				var option = {
					hoursToLive: 24,		
					domain: wgServer.split('/')[2]
				};
				$.cookies.set('ContentWarningApproved', "1", option);
				callback();
			}
		},
		
		showWarning: function(ok, goback) {
			$.nirvana.sendRequest({
				controller: 'ContentWarningController',
				method: 'index',
				data: {},
				format: 'html',
				callback: function(data) {
					var body = $(data);
					$(data).insertBefore($('#WikiaMainContent'));
					$('#ContentWarningApprove').click(ok);
					$('#ContentWarningCancel').click(goback);
				}
			});
		}, 
		
		hideWarning: function() {
			
		}
	};

	ContentWarning.init();
});