var WikiWelcome = {
	doptions: {persistent: false, width:400},
	init: function () {
		$.get(wgScript, {
			action: 'ajax',
			rs: 'moduleProxy',
			moduleName: 'FinishCreateWiki',
			actionName: 'WikiWelcomeModal',
			outputType: 'html'
		}, function(html) {
			WikiWelcome.d = $(html).makeModal(WikiWelcome.doptions);
			WikiWelcome.d.find('.createpage').click(function(e) {
				CreatePage.openDialog(e);
				WikiWelcome.d.closeModal();
			});
		});
	}
};

$(function() {
	WikiWelcome.init();
});