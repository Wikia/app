var WikiWelcome = {
	doptions: {persistent: false, width:400},
	init: function () {
		$.nirvana.sendRequest({
			controller: 'FinishCreateWiki',
			method: 'WikiWelcomeModal',
			format: 'html',
			type: 'get',
			callback: function(html) {
				WikiWelcome.d = $(html).makeModal(WikiWelcome.doptions);
				WikiWelcome.d.find('.createpage').click(function(e) {
					CreatePage.openDialog(e);
					WikiWelcome.d.closeModal();
				});
			}
		});
	}
};

$(function() {
	WikiWelcome.init();
});