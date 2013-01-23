(function(d){
	var form = d.getElementById('wkContactForm'),
		submit = d.getElementById('contactSub'),
		inputs = d.querySelectorAll('#wpSubject, #wpConctactDesc, #wpUserName, #wpEmail, #wpCaptchaWord'),
		captcha = d.querySelector('.captcha img'),
		inputsLength = inputs.length,
		input;

	for(var i = 0; i < inputsLength; i++) {
		input = inputs[i];

		if(input) {
			input.addEventListener('focus', function(){
				this.className = this.className.replace(' inpErr', '');
			})
		}
	}

	function checkInputs(){
		var result = true,
			i = 0;

		while(i < inputsLength) {
			input = inputs[i++];

			if(input) {
				input.value = input.value.trim();

				if(input.value == '') {
					~input.className.indexOf(' inpErr') || (input.className += ' inpErr');
					result = false;
				} else{
					input.className = input.className.replace(' inpErr', '');
				}
			}
		}

		return result;
	}

	if(form) {
		form.addEventListener('submit', function(ev){
			/*if(!checkInputs()) {
				d.getElementsByClassName('inpErr')[0].previousElementSibling.scrollIntoView();
				ev.preventDefault();
			}*/
		})
	}

	if(captcha) {
		captcha.addEventListener('click', function(){
			if(~this.className.indexOf('large')) {
				this.className = this.className.replace(' large', '');
			} else {
				this.className += ' large';
			}
		});
	}
})(document);