(function(){
	ContentWarning = {
		init: function() {
			if(ContentWarning.needWarning()) {
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
		needWarning: function() {
			if(typeof wgContentWarningApproved == "undefined") {
				return false;
			}
		
			if(ContentWarning.isLogedin() && wgContentWarningApproved) {
				return true;
			}
			
			if(!ContentWarning.isLogedin() && $.cookies.get('ContentWarningApproved') != "1" ) {
				return true;
			}
		},
		
		approveWarning: function(callback) {
			if(this.isLogedin()) {
				callback();
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
					$('#WikiaMainContent').hide();
					$('#WikiaRail').hide();
					var body = $(data);
					$(data).insertBefore($('#WikiaMainContent'));
					$('#ContentWarningApprove').click(ok);
					$('#ContentWarningCancel').click(goback);
				}
			});
		}, 
		
		hideWarning: function() {
			$('#ContentWarning').hide();
			$('#WikiaMainContent').show();
			$('#WikiaRail').show();
		}
	};

	ContentWarning.init();
})();