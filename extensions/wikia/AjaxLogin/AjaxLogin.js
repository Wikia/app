/*
 * Author: Maciej Brencz (based on code from Inez Korczynski)
 * Mod by: Tomasz Odrobny, Sean Colombo.
 */
var AjaxLogin = {
	WET_str : 'signupActions/popup',
	init: function(form) {
		this.form = form;

		// move login/password/remember fields from hidden form to AjaxLogin
		// changes to tabindex - see RT#41245
		if(($('#wpName1Ajax').length == 0) && ($('#wpName2Ajax').length < 1) && ($('#wpPassword2Ajax').length < 1)  ){
			// Copy for comboajax's login form
			$("#ajaxlogin_username_cell").append('<input type="text" size="20" tabindex="201" id="wpName2Ajax" name="wpName">');
			$("#ajaxlogin_password_cell").append('<input type="password" size="20" tabindex="202" id="wpPassword2Ajax" name="wpPassword">');

			// Copy for (login & facebook connect) form
			$("#ajaxlogin_username_cell").append('<input type="text" size="20" tabindex="201" id="wpName3Ajax" name="wpName">');
			$("#ajaxlogin_password_cell").append('<input type="password" size="20" tabindex="202" id="wpPassword3Ajax" name="wpPassword">');
		} else {
			if($('#wpName2Ajax').length < 1) {
				$('#wpName1Ajax')
				//copy for login form
				.clone()
				.attr({
					"id": "wpName2Ajax",
					'tabindex': parseInt($('#wpName1Ajax').attr('tabindex')) + 100
				})
				.appendTo("#ajaxlogin_username_cell");
			}
			//copy for facebook connect form
			$('#wpName1Ajax').clone()
			.attr({
				"id": "wpName3Ajax",
				'tabindex': -1 
			})
			.appendTo("#ajaxlogin_username_cell2");
			if($('#wpPassword2Ajax').length < 1) {
				$('#wpPassword1Ajax')
				.clone()
				.attr({
					"id": "wpPassword2Ajax",
					'tabindex': parseInt($('#wpPassword1Ajax').attr('tabindex')) + 100
				})
				.appendTo("#ajaxlogin_password_cell");
			}
			$('#wpPassword1Ajax').clone()
			.attr({
				"id": "wpPassword3Ajax",
				'tabindex': -1
			})
			.appendTo("#ajaxlogin_password_cell2");
		}
		
		if ($('#wpRemember2Ajax').length < 1) {
			if( $('#wpRemember1Ajax').length > 0 ) {
				var labels = this.form.find('label');		
				$('#wpRemember1Ajax')
					.clone()
					.attr({
						"id": "wpRemember2Ajax",
						'tabindex': parseInt($('#wpRemember1Ajax').attr('tabindex')) + 100
					})
					.insertBefore(labels[2]);
			} else {
				$("#labelFor_wpRemember2Ajax").before('<input type="checkbox" value="1" tabindex="204" id="wpRemember2Ajax" name="wpRemember">');
			}
		}
		// remove hidden form
		//$('#userajaxloginform').attr("id","");

		//this.form.attr('id', 'userajaxloginform');

		// add submit event handler for login form
		this.form.bind('submit', this.formSubmitHandler);
		$('#wpLoginattemptAjax').attr('tabindex', parseInt($('#wpRemember1Ajax').attr('tabindex')) + 101).click( this.clickLogIn );

		$().log('AjaxLogin: init()');

		// ask before going to register form from edit page
		$('#wpAjaxRegister').click(this.ajaxRegisterConfirm);
		// get proper returnto/returntoquery param
		$('#wpAjaxRegister').attr('href', $('#register').attr('href'));

		//setup slider
		$("#AjaxLoginConnectMarketing a").click(this.slider);
	},
	slider: function(e) {
		e.preventDefault();

		// Split into diff functions so that they can be called from elsewhere.
		if ($(this).hasClass("forward")) {
			AjaxLogin.slideToLoginAndConnect(this);
		} else {
			AjaxLogin.slideToNormalLogin(this);
		}
	},
	slideToNormalLogin: function(el){
		var firstSliderCell = $("#AjaxLoginSlider div:first");
		var slideto = 0;
		$(el).hide();
		$("#AjaxLoginConnectMarketing a.forward").show();
		firstSliderCell.animate({
			marginLeft: slideto
		}, function(){$('#fbLoginAndConnect').hide();});
	},
	slideToLoginAndConnect: function(el){
		$('#fbLoginAndConnect').show();
		var firstSliderCell = $("#AjaxLoginSlider div:first");
		var slideto = -351;
		$(el).hide();
		$("#AjaxLoginConnectMarketing a.back").show();
		firstSliderCell.animate({
			marginLeft: slideto
		});
	},
	close: function()
	{
		$('#AjaxLoginBoxWrapper').closeModal();
	},
	doSuccess: function(openwindow) {

		if( (typeof isAutoCreateWiki != 'undefined') && isAutoCreateWiki ) {
			realoadAutoCreateForm();
			return ;
		}

		// macbre: call custom function (if provided by any extension)
		if (typeof window.wgAjaxLoginOnSuccess == 'function') {
			// let's update wgUserName
			if(typeof response != 'undefined'){
				window.wgUserName = response.ajaxlogin.lgusername;
			}

			// close AjaxLogin form
			$('#AjaxLoginBoxWrapper').closeModal();

			$().log('AjaxLogin: calling custom function');
			window.wgAjaxLoginOnSuccess();
			return;
		}

		// we're on edit page
		if($('#wpPreview').exists() && $('#wpLogin').exists()) {
			$('#editform').append('<input value="1" name="wpIsReload" ></input>');
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
			} else if((wgCanonicalSpecialPageName == "Signup") || (wgCanonicalSpecialPageName == "Connect")){
				// If we just registered from a whole registration page (not a popup), head back to where we came from.
				
				var destUrl = wgServer + wgScript ;
				if (wgReturnTo.length > 0 ) {
					destUrl += "?title=" + wgReturnTo; 
				}	
				
				if((typeof wgReturnToQuery != 'undefined') && (wgReturnToQuery.length > 0)){
					destUrl += "&" + wgReturnToQuery
				}
				window.location.href = destUrl;
			} else {
				AjaxLogin.doReload();
			}
		}
	},
	doReload: function() {
		window.location.reload(true);
	},
	clickLogIn: function( ev ) {
		// Prevent the default action for event (click)
		if(ev) {
			ev.preventDefault();
		}

		AjaxLogin.action = 'login';
		AjaxLogin.form.submit();
	},
	formSubmitHandler: function(ev) {
		// Prevent the default action for event (submit of form)
		if( (typeof wgEnableLoginAPI == 'undefined') || !wgEnableLoginAPI ) {
			return true;
		}
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
		];

		var POSTparams = AjaxLogin.form.serialize();

		// Let's block login form (disable buttons and input boxes)
		AjaxLogin.blockLoginForm(true);
		
		// This function is used to submit login form and the login and connect form, so we have to store which one it is.
		var formId = AjaxLogin.form.id;

		$.postJSON(window.wgScriptPath + '/api.php?' + params.join('&'), POSTparams, function(response) {
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
				$('#'+ formId).attr('action', wgServer + wgScriptPath + '/index.php?title=Special:Userlogin&action=submitlogin&type=login');

				// remove AJAX functionality from login form
				AjaxLogin.form.unbind('submit', this.formSubmitHandler);

				// unblock and submit the form
				AjaxLogin.blockLoginForm(false);
				$('#' + formId).submit();
				break;

			case 'Success':
				// Bartek: tracking
				if( AjaxLogin.action == 'password'  ) {
					WET.byStr(AjaxLogin.WET_str + '/emailpassword/success');
				} else {
					WET.byStr(AjaxLogin.WET_str + '/login/success');
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
						WET.byStr(AjaxLogin.WET_str + '/emailpassword/success');
					} else {
						WET.byStr(AjaxLogin.WET_str + '/emailpassword/failure');
					}
				} else {
						WET.byStr(AjaxLogin.WET_str + '/login/failure');
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
		$('#wpError').css('display', '').html(reason);
		$('#userloginErrorBox3').show();
	},
	blockLoginForm: function(block) {
		AjaxLogin.form.find('input').attr('disabled', (block ? true : false));
	},
	injectMailMyPassword: function(el) {
		$(el).parents('form').prepend('<input type="hidden" name="wpMailmypassword" value="1"/>');
	},
	ajaxRegisterConfirm: function(ev) {
		AjaxLogin.form.log('AjaxLogin: ajaxRegisterConfirm()');

		if($('#wpPreview').exists() && $('#wpLogin').exists()) {
			if(typeof(ajaxLogin2)!="undefined" && !confirm(ajaxLogin2)) {
				ev.preventDefault();
			}
		}
		WET.byStr(AjaxLogin.WET_str + '/switchtocreateaccount');
	},
	showFromDOM: function() {
		$('#AjaxLoginBoxWrapper').showModal();
		$('#wpName1Ajax').focus();
		return true
	}
};


/* over load for ajaxComboLogin */

if ( (typeof wgComboAjaxLogin != 'undefined') && wgComboAjaxLogin ) {
	/* clear repted names */

	/* extend AjaxLogin object for combo ajax login */
	$.extend(AjaxLogin,{
				clicked : 0,
				placeholderID : null,
				isShow : false,
				topPos : "130px",
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
					AjaxLogin.isShow = true;
					$('#wpGoRegister').addClass('selected');
					$('#wpGoLogin').removeClass('selected');
					$('#AjaxLoginLoginForm').hide();
			       		$('#AjaxLoginRegisterForm').show();

			        	WET.byStr(AjaxLogin.WET_str + '/choosecreateaccount');
				},
				showLogin : function() {
					AjaxLogin.isShow = true;
					$('#wpGoLogin').addClass('selected');
					$('#wpGoRegister').removeClass('selected');
					$('#AjaxLoginRegisterForm').hide();
					$('#AjaxLoginLoginForm').show();

					WET.byStr(AjaxLogin.WET_str + '/chooselogin');
				},
				close: function()
				{
					WET.byStr(AjaxLogin.WET_str + '/close');

					// If this is in ajax-mode hide the box, otherwise return to the source page.
					if($('#AjaxLoginBoxWrapper').length > 0){
						$('#AjaxLoginBoxWrapper').hideModal();
						AjaxLogin.isShow = false;
					} else {
						var destUrl = wgServer + wgScriptPath + wgScript + "?title=" + wgReturnTo;
						if((typeof wgReturnToQuery != 'undefined') && (wgReturnToQuery.length > 0)){
							destUrl += "&" + wgReturnToQuery
						}
						window.location.href = destUrl;
					}
				},
				showFromDOM: function() {
					if ($('#AjaxLoginButtons').length > 0)
					{
						$('#AjaxLoginBoxWrapper').remove();
						return false;
					}
					$('#AjaxLoginBoxWrapper').showModal();
					$('#wpName1Ajax').focus();
					return true;
				},
				showComboFromDOM: function() {
					if ($('#AjaxLoginButtons').length > 0)
					{
						$('#AjaxLoginBoxWrapper').showModal();
						$('#wpName1Ajax').focus();
						$('#AjaxLoginBoxWrapper').css({'top' : AjaxLogin.topPos});
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
					} else {
        	                                 window.location.reload(true);
						return;
					}

					var reload_loc = '';
				       	if( window.location.href.indexOf("#") > 0 ) {
						reload_loc = window.location.href.substring( 0, window.location.href.indexOf("#") );
					} else {
						reload_loc = window.location.href;
					}
					if( "" != params ) {
						if (window.location.href.indexOf("?") > 0) {
							window.location.href = reload_loc + ("&" + params);
						} else {
							window.location.href = reload_loc + ("?" + params);
						}
					} else {
						window.location.href = reload_loc;
					}
				},
				show: function() {
					AjaxLogin.WET_str = 'signupActions/combopopup';
					if (typeof UserRegistration != 'undefined'){
						UserRegistration.WET_str = AjaxLogin.WET_str;
					}
					$('#AjaxLoginBox').makeModal({width: 700, persistent: true, onClose: function(){ WET.byStr(AjaxLogin.WET_str + '/close'); } });
					setTimeout(function() {
									$('#AjaxLoginBoxWrapper').css({ 'top' : AjaxLogin.topPos});
									$('#wpName2Ajax').focus();
								},100);
					WET.byStr(AjaxLogin.WET_str + '/open');
				}
			});
	//override submitForm for submitForm
	if (typeof UserRegistration != 'undefined')
	{
		UserRegistration.submitForm2 = function() {
			if( typeof UserRegistration.submitForm.statusAjax == 'undefined' ) { // java script static var
				UserRegistration.submitForm.statusAjax = false;
		    }

			if(UserRegistration.submitForm.statusAjax)
			{
				return false;
			}
			UserRegistration.submitForm.statusAjax = true;
			if (UserRegistration.checkForm()) {
				$("#userloginErrorBox").hide();
				$.ajax({
					type: "POST",
					dataType: "json",
					url: window.wgScriptPath  + "/index.php",
					data: $("#userajaxregisterform").serialize() + "&action=ajax&rs=createUserLogin&ajax=1",
					beforeSend: function(){
						$("#userRegisterAjax").find("input,select").attr("disabled",true);
					},
					success: function(msg){
						$("#userRegisterAjax").find("input,select").removeAttr("disabled");
					 	$("#wpCaptchaWord").val("");
					 	/* post data to normal form if age < 13 */
					 	if (msg.type === "redirectQuery") {
					 		WET.byStr(UserRegistration.WET_str + '/createaccount/failure');
					 		$('#userajaxregisterform').submit();
					 		return ;
					 	}

					 	if( msg.status == "OK" ) {
							if($('#AjaxLoginBoxWrapper').length > 0){
								$('#AjaxLoginBoxWrapper').closeModal();
							}
					 		WET.byStr(UserRegistration.WET_str + '/createaccount/success');
			 				AjaxLogin.doSuccess();
					 		return ;
					 	}

					 	WET.byStr(UserRegistration.WET_str + '/createaccount/failure');
					 	$('#userloginInnerErrorBox').empty().append(msg.msg);
					 	$("#userloginErrorBox").show();
					 	$(".captcha img").attr("src",msg.captchaUrl);
					 	$("#wpCaptchaId").val(msg.captcha);
					 	UserRegistration.submitForm.statusAjax = false;
					}
				});
			} else {
				$("#userloginErrorBox").show();
				WET.byStr(UserRegistration.WET_str + '/createaccount/failure');
				UserRegistration.submitForm.statusAjax = false;
			}
		}
	}
}


