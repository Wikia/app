var ConfirmEmail = {
	init: function() {
		ConfirmEmail.emailForm = $('.ConfirmEmail .email-form');
		ConfirmEmail.username = ConfirmEmail.emailForm.find('input[name=username]');
		ConfirmEmail.emailInput = ConfirmEmail.emailForm.find('input[name=email]');
		
		ConfirmEmail.wikiaForm = new WikiaForm(ConfirmEmail.emailForm);
		ConfirmEmail.generalMessagingForm = new WikiaForm('#ResendConfirmation');
		
		$('.ConfirmEmail .change-email-link').click(function(e) {
			e.preventDefault();
			if(ConfirmEmail.emailForm.is(':visible')) {
				ConfirmEmail.emailForm.slideUp(100);
			} else {
				ConfirmEmail.emailForm.slideDown(100);
			}
		});
		
		$('.ConfirmEmail .email-tooltip').tooltip();
	}
};

$(function() {
	ConfirmEmail.init();
});