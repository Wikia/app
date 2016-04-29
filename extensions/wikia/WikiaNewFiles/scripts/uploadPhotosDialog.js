var UploadPhotos = {
	d: false,
	destfile: false,
	filepath: false,
	doptions: {persistent: false, width:600},
	status: false,
	libinit: false,
	init: function() {
		$(".mw-special-Images").on('click', '.upphotos', $.proxy(this.loginBeforeShowDialog, this));
		if (Wikia.Querystring().getVal('modal') === 'UploadImage') {
			this.loginBeforeShowDialog();
		}
	},
	loginBeforeShowDialog: function(evt) {
		var UserLoginModal = window.UserLoginModal;
		if (( wgUserName == null ) && ( !UserLogin.forceLoggedIn )) {
			require(['AuthModal'], function (authModal) {
				authModal.load({
					forceLogin: true,
					url: '/signin?redirect=' + encodeURIComponent(window.location.href),
					origin: 'latest-photos',
					onAuthSuccess: $.proxy(function() {
						UserLogin.forceLoggedIn = true;
						this.showDialog(evt);
					}, this)
				});
			}.bind(this));
		}
		else {
			this.showDialog(evt);
		}
		evt.preventDefault();
	},
	showDialog: function(evt) {
		if(evt) {
			evt.preventDefault();
		}

		$.nirvana.sendRequest({
			controller: 'UploadPhotos',
			method: 'Index',
			format: 'html',
			data: {
				title: wgPageName,
				cb: wgCurRevisionId,
				uselang: wgUserLanguage
			},
			type: 'get',
			callback: function(html) {
				// pre-cache dom elements
				var extendedOptions = $.extend(UploadPhotos.doptions, {
					onClose: function() {UserLogin.refreshIfAfterForceLogin()}
				});
				UploadPhotos.d = $(html).makeModal(extendedOptions);
				UploadPhotos.destfile = UploadPhotos.d.find("input[name=wpDestFile]");
				UploadPhotos.filepath = UploadPhotos.d.find("input[name=wpUploadFile]");
				UploadPhotos.status = UploadPhotos.d.find("div.status");
				UploadPhotos.advanced = UploadPhotos.d.find(".advanced");
				UploadPhotos.advancedA = UploadPhotos.d.find(".advanced a");
				UploadPhotos.advancedChevron = UploadPhotos.d.find(".advanced .chevron");
				UploadPhotos.options = UploadPhotos.d.find(".options");
				UploadPhotos.uploadbutton = UploadPhotos.d.find("input[type=submit]");
				UploadPhotos.step1 = UploadPhotos.d.find(".step-1");
				UploadPhotos.step2 = UploadPhotos.d.find(".step-2");
				UploadPhotos.conflict = UploadPhotos.d.find(".conflict");
				UploadPhotos.ignore = UploadPhotos.d.find("input[name=wpIgnoreWarning]");
				UploadPhotos.override = UploadPhotos.d.find(".override");
				UploadPhotos.overrideinput = UploadPhotos.override.find("input");
				UploadPhotos.ajaxwait = UploadPhotos.d.find(".ajaxwait");
				UploadPhotos.dfcache = {};
				UploadPhotos.wpLicense = $('#wpLicense');
				UploadPhotos.wpLicenseTarget = $('#mw-license-preview');

				// event handlers
				UploadPhotos.filepath.change(UploadPhotos.filePathSet);
				UploadPhotos.destfile.blur(UploadPhotos.destFileSet);
				UploadPhotos.d.find('form').submit(function() {
					$.AIM.submit(this, UploadPhotos.uploadCallback);
				});
				UploadPhotos.advancedA.click(function(evt) {
					evt.preventDefault();

					//set correct text for link and arrow direction
					if (UploadPhotos.options.is(":visible")) {
						UploadPhotos.advancedA.text(UploadPhotos.advancedA.data("more"));
						UploadPhotos.advancedChevron.removeClass("up");
					} else {
						UploadPhotos.advancedA.text(UploadPhotos.advancedA.data("fewer"));
						UploadPhotos.advancedChevron.addClass("up");
					}

					UploadPhotos.options.slideToggle("fast");
				});
				UploadPhotos.destfile.keyup(function() {
					if(UploadPhotos.dftimer) {
						clearTimeout(UploadPhotos.dftimer);
					}
					UploadPhotos.dftimer = setTimeout(UploadPhotos.destFileSet, 500);
				});
				UploadPhotos.wpLicense.change(function() {

					var license = $(this).val();
					if(license == ""){
						// user selected first option or a disabled option
						$(this).attr('selectedIndex', 0);
						UploadPhotos.wpLicenseTarget.html("");
						return;
					}

					var title = UploadPhotos.destfile.val() || 'File:Sample.jpg';

					$.get(
						mw.util.wikiScript('api'),
						{
							action: 'parse',
							text: '{{' + license + '}}',
							title: title,
							prop: 'text',
							format: 'json'
						},
						function(data) {
							UploadPhotos.wpLicenseTarget.html(data.parse.text['*']);
						},
						"json"
					);
				});
			}
		});

		if (!UploadPhotos.libinit) {
			$.loadJQueryAIM();
			UploadPhotos.libinit = true;
		}
	},
	uploadCallback: {
		onComplete: function(res) {
			res = $("<div/>").html(res).text();
			var json = JSON.parse(res);
			if(json) {
				if(json['status'] == 0) {	// 0 is success...
					window.location = wgArticlePath.replace('$1', 'Special:Images');
				} else if(json['status'] == -2) {	// show conflict dialog
					UploadPhotos.step1.hide(400, function() {
						UploadPhotos.advanced.hide();
						UploadPhotos.conflict.html(json['statusMessage']);
						UploadPhotos.step2.show(400, function() {
							UploadPhotos.uploadbutton.removeAttr("disabled").show();
							UploadPhotos.ajaxwait.hide();
						});
					});
					UploadPhotos.ignore.attr("checked", true);
				} else {
					UploadPhotos.status.addClass("error").show(400).html(json['statusMessage']);
					UploadPhotos.uploadbutton.removeAttr("disabled").show();
					UploadPhotos.ajaxwait.hide();
				}
			}
		},
		onStart: function() {
			UploadPhotos.uploadbutton.attr("disabled", "true").hide();
			UploadPhotos.ajaxwait.show();
			UploadPhotos.status.hide("fast", function() {
				$(this).removeClass("error");
			});
		}
	},
	filePathSet: function() {
		if (UploadPhotos.filepath.val()) {
			var filename = UploadPhotos.filepath.val().replace(/^.*\\/, '');
			UploadPhotos.destfile.val(filename);
			UploadPhotos.destFileSet();
		}
	},
	destFileSet: function() {
		if (UploadPhotos.destfile.val()) {
			var df = UploadPhotos.destfile.val();
			if (UploadPhotos.dfcache[df]) {
				UploadPhotos.destFileInputSet(UploadPhotos.dfcache[df]);
			} else {
				$.nirvana.sendRequest({
					controller: 'UploadPhotos',
					method: 'ExistsWarning',
					format: 'html',
					type: 'get',
					data: {
						title: wgPageName,
						cb: wgCurRevisionId,
						uselang: wgUserLanguage,
						wpDestFile: UploadPhotos.destfile.val()
					},
					callback: function(html) {
						UploadPhotos.dfcache[df] = html;
						UploadPhotos.destFileInputSet(html);
					}
				});
			}
		}
	},
	destFileInputSet: function(html) {
		if(html && $.trim(html)) {
			UploadPhotos.override.fadeIn(400);
			UploadPhotos.status.removeClass("error").html(html).show(400);
		} else {
			UploadPhotos.override.fadeOut(400);
			UploadPhotos.overrideinput.attr("checked", false);
			UploadPhotos.status.removeClass("error").hide(400);
		}
	}
};

$(function () {
	UploadPhotos.init();
});
