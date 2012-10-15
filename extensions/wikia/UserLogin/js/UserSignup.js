var UserSignup = {
	inputsToValidate: ['username', 'email', 'password', 'birthday'],
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
		
		UserSignup.wikiaForm = new WikiaForm('#WikiaSignupForm');
		UserSignup.signupAjaxForm = new UserSignupAjaxForm(UserSignup.wikiaForm, UserSignup.inputsToValidate, UserSignup.wikiaForm.inputs['submit']); 
		UserSignup.wikiaForm.el
			.find('input[name=username], input[name=email], input[name=password]')
			.bind('blur.UserSignup', $.proxy(UserSignup.signupAjaxForm.validateInput, UserSignup.signupAjaxForm));
		UserSignup.wikiaForm.el
			.find('select[name=birthday], select[name=birthmonth], select[name=birthyear]')
			.bind('change.UserSignup', UserSignup.validateBirthdate);
			
		// dom pre-cache
		UserSignup.submitButton = UserSignup.wikiaForm.inputs['submit'];
	},
	validateBirthdate: function(e) {
		var el = $(e.target);
		var proxyObj = {'paramName':el.attr('name'), 'form':UserSignup.signupAjaxForm};
		if(UserSignup.deferred && typeof UserSignup.deferred.reject === 'function') {
			UserSignup.deferred.reject();
		}
		UserSignup.deferred = $.post(wgScriptPath + '/wikia.php', {
			controller: 'UserSignupSpecial',
			method: 'formValidation',
			format: 'json',
			field: 'birthdate',
			birthyear: UserSignup.wikiaForm.inputs['birthyear'].val(),
			birthmonth: UserSignup.wikiaForm.inputs['birthmonth'].val(),
			birthday: UserSignup.wikiaForm.inputs['birthday'].val()
		}, $.proxy(UserSignup.signupAjaxForm.validationHandler, proxyObj));
	}
};

$(function() {
	UserSignup.init();
});