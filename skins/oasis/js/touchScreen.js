$(function(){
	var captcha = document.getElementById('wpCaptchaWord');
	if(captcha) {
		captcha.setAttribute('autocorrect', 'off');
		captcha.setAttribute('autocapitalize', 'off');
	}
});

