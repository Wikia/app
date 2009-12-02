/*
 * Author: Maciej Brencz (based on code from Inez Korczynski)
 * Mod by: Tomasz Odrobny
 */
var AjaxLogin = {
	init: function(form) {
		this.form = form;

		// move login/password/remember fields from hidden form to AjaxLogin
		var labels = this.form.find('label');
		$('#wpName1Ajax').clone().attr("id","wpName2Ajax").appendTo("#ajaxlogin_username_cell");
		$('#wpPassword1Ajax').clone().attr("id","wpPassword2Ajax").appendTo("#ajaxlogin_password_cell");
		$('#wpRemember1Ajax').clone().attr("id","wpRemember2Ajax").insertBefore(labels[2]);

		// remove hidden form
		$('#userajaxloginform').attr("id","");

		this.form.attr('id', 'userajaxloginform');

		// add submit event handler for login form
		this.form.bind('submit', this.formSubmitHandler);

		$().log('AjaxLogin: init()');

		// ask before going to register form from edit page
		$('#wpAjaxRegister').click(this.ajaxRegisterConfirm);
		// get proper returnto/returntoquery param
		$('#wpAjaxRegister').attr('href', $('#register').attr('href'));
	},
	
	doSuccess: function(openwindow) {
		// macbre: call custom function (if provided by any extension)
		if (typeof window.wgAjaxLoginOnSuccess == 'function') {
			// let's update wgUserName
			window.wgUserName = response.ajaxlogin.lgusername;

			// close AjaxLogin form
			$('#AjaxLoginBoxWrapper').closeModal();

			$().log('AjaxLogin: calling custom function');
			window.wgAjaxLoginOnSuccess();
			return;
		}

		// we're on edit page
		if($('#wpPreview').exists() && $('#wpLogin').exists()) {
			if ($('#wikiDiff').children().exists()) {  
				$('#wpDiff').click();
			} else {
				if (!$('#wikiPreview').children().exists()) {
					$('#wpLogin').attr('value', 1);
				}
				$('#wpPreview').click();
			}
		} else {
			if(wgCanonicalSpecialPageName == "Userlogout") {
				window.location.href = wgServer + wgScriptPath;
			} else {
				AjaxLogin.doReload();
			}
		}
	},
	doReload: function() {
		window.location.reload(true);
	},
	formSubmitHandler: function(ev) {
		// Prevent the default action for event (submit of form)
		if(ev) {
			ev.preventDefault();
		}
		AjaxLogin.form.log('AjaxLogin: selected action = ' + AjaxLogin.action);

		// tracking
		WET.byStr('loginActions/' + AjaxLogin.action);

		var params = [
			'action=ajaxlogin',
			'format=json',
			(AjaxLogin.action == 'password' ? 'wpMailmypassword=1' : 'wpLoginattempt=1'),

			// serialize form fields
			AjaxLogin.form.serialize()
		];

		// Let's block login form (disable buttons and input boxes)
		AjaxLogin.blockLoginForm(true);
		$.postJSON(window.wgScriptPath + '/api.php?' + params.join('&'), function(response) {
					var responseResult = response.ajaxlogin.result;
					switch(responseResult) {
					case 'Reset':
					// password reset

					// we're on edit page
					if($('#wpPreview').exists() && $('#wpLogin').exists()) {
					if(typeof(ajaxLogin1)!="undefined" && !confirm(ajaxLogin1)) {
					break;
					}
					}

					// change the action of the AjaxLogin form
					$('#userajaxloginform').attr('action', wgServer + wgScriptPath + '/index.php?title=Special:Userlogin&action=submitlogin&type=login');

					// remove AJAX functionality from login form
					AjaxLogin.form.unbind('submit', this.formSubmitHandler);

					// unblock and submit the form
					AjaxLogin.blockLoginForm(false);
					$('#userajaxloginform').submit();
					break;

					case 'Success':
					
					// Bartek: tracking
					
					if( AjaxLogin.action == 'password'  ) {
						WET.byStr('signupActions/popup/emailpassword/success');
					} else {
						WET.byStr('signupActions/popup/login/success');
					}
						AjaxLogin.doSuccess();
					break;

					case 'NotExists':
					AjaxLogin.blockLoginForm(false);
					$('#wpPassword1n').attr('value', '');
					$('#wpName1').attr('value', '').focus();

					case 'WrongPass':
					AjaxLogin.blockLoginForm(false);
					$('#wpPassword1').attr('value', '').focus();

					default:

                                        // Bartek: tracking
                                        if( AjaxLogin.action == 'password'  ) {
                                                if( responseResult == 'OK' ) {
                                                        WET.byStr('signupActions/popup/emailpassword/success');
                                                } else {
                                                        WET.byStr('signupActions/popup/emailpassword/failure');
                                                }
                                        } else {
                                                WET.byStr('signupActions/popup/login/failure');
                                        }
					
					AjaxLogin.blockLoginForm(false);
					AjaxLogin.displayReason(response.ajaxlogin.text);
					break;
				}
		});
	},
	handleFailure: function() {
		AjaxLogin.form.log('AjaxLogin: handleFailure was called');
	},
	displayReason: function(reason) {
		$('#wpError').css('display', '').html(reason + '<br/><br/>');
	},
	blockLoginForm: function(block) {
		AjaxLogin.form.find('input').attr('disabled', (block ? true : false));
	},
	ajaxRegisterConfirm: function(ev) {
		AjaxLogin.form.log('AjaxLogin: ajaxRegisterConfirm()');
        	
		if($('#wpPreview').exists() && $('#wpLogin').exists()) {
			if(typeof(ajaxLogin2)!="undefined" && !confirm(ajaxLogin2)) {
				ev.preventDefault();
			}
		}
		WET.byStr('signupActions/popup/switchtocreateaccount');
	},
	showFromDOM: function() {
		$('#AjaxLoginBox').showModal();
		$('#wpName1Ajax').focus();
		return true
	}
};

if ( (typeof wgComboAjaxLogin != 'undefined') && wgComboAjaxLogin ) {
	/* clear repted names */ 
	
	/* expend AjaxLogin object for combo ajax login */
	$.extend(AjaxLogin,{
				clicked : 0,
				placeholderID : null,
				getNewTop: function(newHeight){
					var modalTop = (($(window).height() - newHeight) / 2) + $(window).scrollTop();
					if (modalTop < $(window).scrollTop() + 20) {
						return $(window).scrollTop() + 20;
					} else {
						return modalTop;
					}
				},
				getNewMarginLeft: function(newWidth){
					return  -newWidth / 2;
				},
				showRegister: function() {
					$('#wpGoRegister').addClass('ajaxregister_button_enable');
					$('#wpGoLogina').removeClass('ajaxregister_button_enable');
					$('#AjaxLoginLoginForm').hide();
			        $("#AjaxLoginBoxWrapper").animate({ 
			        	'width': "700px",
			        	'marginLeft': parseInt(this.getNewMarginLeft(709))+"px",  
			        	'top':  parseInt(this.getNewTop(390))+"px"
			        }, 500 );
					$('#AjaxLoginRegisterForm').show("fast");
				},
				showLogin : function() {
					$('#wpGoLogina').addClass('ajaxregister_button_enable');
					$('#wpGoRegister').removeClass('ajaxregister_button_enable');
					$('#AjaxLoginRegisterForm').hide();
					$("#AjaxLoginBoxWrapper").animate({ 
				          'width': "320px",
				          'marginLeft': parseInt(this.getNewMarginLeft(329))+"px",
				          'top':  parseInt(this.getNewTop(240))+"px"    
						}, 500 );
					$('#AjaxLoginLoginForm').show("fast");
				},
				showFromDOM: function() {	
					if ($('#AjaxLoginButtons').length > 0)
					{
						$('#AjaxLoginBoxWrapper').remove();
						return false;
					}
					$('#AjaxLoginBox').showModal();
					$('#wpName1Ajax').focus();
					return true;
				},
				showComboFromDOM: function() {
					if ($('#AjaxLoginButtons').length > 0)
					{
						$('#AjaxLoginBox').showModal();
						$('#wpName1Ajax').focus();
						return true;						
					}
					/* remove normal ajax login to show combo (id)*/
					$('#AjaxLoginBoxWrapper').remove();
					return false;
				},
				setPlaceHolder: function(id) {
					AjaxLogin.placeholderID = id;
				},
				doReload: function(){
					params = "";
					if( AjaxLogin.placeholderID !== null){
						params = "placeholder=" + AjaxLogin.placeholderID;
					}
					
					if (window.location.href.indexOf("?") > 0) {
						window.location.href = window.location.href.replace("#","") + ("&" + params);
						return;
					}
					window.location.href = window.location.href.replace("#","") + ("?" + params);
					
				}
			}); 
	//override submitForm for submitForm
	if (typeof UserRegistration != 'undefined') 
	{
		UserRegistration.submitForm = function() {
			if (UserRegistration.checkForm()) {
				$("#userloginErrorBox").hide();
				 $.ajax({
					   type: "POST",
					   dataType: "json",
					   url: window.wgScriptPath  + "/index.php",
					   data: $("#userajaxregisterform").serialize() + "&action=ajax&rs=createUserLogin",
					   success: function(msg){
					 		/* post data to normal form if age < 13 */
					 		if (msg.type === "redirectQuery") {
					 			$('#userajaxregisterform').submit();
					 			return ;
					 		}
					 
					 		if( msg.type != "error" ) {
					 			AjaxLogin.doSuccess();
					 			return ;
					 		}
					 		
					 		$('#userloginInnerErrorBox').empty().append(msg.msg);
					 		$("#userloginErrorBox").show();
					 		$(".captcha img").attr("src",msg.captchaUrl);
					 		$("#wpCaptchaId").val(msg.captcha);
					   }
					 });
			} else {
				$("#userloginErrorBox").show();
				WET.byStr('signupActions/signup/createaccount/failure');
			}
		}
	}
}


