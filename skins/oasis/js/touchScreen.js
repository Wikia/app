//global nav and menu fix: first click opens, second go to link
$(document.body).delegate('#GlobalNavigation > li > a, #AccountNavigation > li > a', 'click', function(event) {
	if(this.nextElementSibling.className.indexOf('show') === -1) {
		event.preventDefault();
		event.stopPropagation();
	}
});

$(function(){
	var captcha = document.getElementById('wpCaptchaWord');
	if(captcha) {
		captcha.setAttribute('autocorrect', 'off');
		captcha.setAttribute('autocapitalize', 'off');
	}
});

