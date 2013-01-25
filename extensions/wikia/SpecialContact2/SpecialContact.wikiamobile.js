(function(d){
	var form = d.getElementById('wkContactForm'),
		submit = d.getElementById('contactSub'),
		inputs = d.querySelectorAll('#wpConctactDesc, #wpEmail, #wpCaptchaWord'),
		captcha = d.querySelector('.captcha img'),
		inputsLength = inputs.length,
		errReg = /\s*inpErr/gi,
		input,
		fileUploadImpossible = (function(d) {
			var el = d.createElement("input");
			el.setAttribute("type", "file");
			return el.disabled;
		})(d);

	//hide file upload for devices that do not support it
	if(fileUploadImpossible) {
		d.querySelector('.filesUpload').style.display = 'none';
	}

	for(var i = 0; i < inputsLength; i++) {
		input = inputs[i];

		if(input) {
			input.addEventListener('focus', function(){
				this.className = this.className.replace(errReg, '');
			})
		}
	}

	function scrollToErr(){
		var elem = d.getElementsByClassName('inpErr')[0];

		if(elem) {
			(elem.previousElementSibling || elem).scrollIntoView();
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
					if(!~input.className.indexOf(' inpErr')) {
						input.className += ' inpErr';
					}
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
			if(!checkInputs()) {
				scrollToErr();
				ev.preventDefault();
			}
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

	scrollToErr();

})(document);