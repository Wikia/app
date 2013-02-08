var UserSignup = {
	inputsToValidate: ['username', 'email', 'password', 'birthday'],
	notEmptyFields: ['username', 'email', 'password', 'birthday', 'birthmonth', 'birthyear'],
	captchaField: 'wpCaptchaWord',
	invalidInputs: {},
	init: function() {
		$('.extiw').click(function(e) {
			e.preventDefault();
			$.getJSON('http://www.wikia.com/api.php?callback=?', {
				'action': 'parse',           
				'format': 'json',           
				'page': 'Terms_of_Use'       
			}, function(data) { 
				var modal = $(data.parse.text['*']).makeModal({
					persistent: false, 
					width: 800 });
				modal.addClass('WikiaArticle').find('.editsection').hide();
			});
		});
		
		this.wikiaForm = new WikiaForm('#WikiaSignupForm');
		this.signupAjaxForm = new UserSignupAjaxForm(
			this.wikiaForm,
			this.inputsToValidate,
			this.wikiaForm.inputs['submit'],
			this.notEmptyFields,
			this.captchaField
		);
		this.wikiaForm.el
			.find('input[name=username], input[name=email], input[name=password]')
			.bind('blur.UserSignup', $.proxy(UserSignup.signupAjaxForm.validateInput, this.signupAjaxForm));
		this.wikiaForm.el
			.find('select[name=birthday], select[name=birthmonth], select[name=birthyear]')
			.bind('change.UserSignup', $.proxy(UserSignup.signupAjaxForm.validateBirthdate, this.signupAjaxForm));
			
		// dom pre-cache
		this.submitButton = this.wikiaForm.inputs['submit'];
		this.wikiaForm.inputs['wpCaptchaWord'].bind('keyup.UserSignup', $.proxy(UserSignup.signupAjaxForm.activateSubmit, this.signupAjaxForm));
	}
};

$(function() {
	UserSignup.init();
});