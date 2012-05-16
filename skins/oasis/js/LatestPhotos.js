var UploadPhotos = {
	d: false,
	destfile: false,
	filepath: false,
	doptions: {persistent: false, width:600},
	status: false,
	libinit: false,
	init: function() {
		if(!($(".upphotoslogin").exists())) {
			$(".upphotos").click(UploadPhotos.showDialog);
		}
	},
	showDialog: function(evt) {
		if(evt) {
			evt.preventDefault();
		}

		$.get(wgScript, {
			action: 'ajax',
			rs: 'moduleProxy',
			moduleName: 'UploadPhotos',
			actionName: 'Index',
			outputType: 'html',
			title: wgPageName,
			cb: wgCurRevisionId,
			uselang: wgUserLanguage
		}, function(html) {
			// pre-cache dom elements
			UploadPhotos.d = $(html).makeModal(UploadPhotos.doptions);
			UploadPhotos.destfile = UploadPhotos.d.find("input[name=wpDestFile]");
			UploadPhotos.filepath = UploadPhotos.d.find("input[name=wpUploadFile]");
			UploadPhotos.status = UploadPhotos.d.find("div.status");
			UploadPhotos.advanced = UploadPhotos.d.find(".advanced a");
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
			UploadPhotos.advanced.click(function(evt) {
				evt.preventDefault();

				//set correct text for link and arrow direction
				if (UploadPhotos.options.is(":visible")) {
					UploadPhotos.advanced.text(UploadPhotos.advanced.data("more"));
					UploadPhotos.advancedChevron.removeClass("up");
				} else {
					UploadPhotos.advanced.text(UploadPhotos.advanced.data("fewer"));
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

				var url = wgScriptPath + '/api' + wgScriptExtension
					+ '?action=parse&text={{' + encodeURIComponent( license ) + '}}'
					+ '&title=' + encodeURIComponent( title.replace(/\./g, "%2E") )
					+ '&prop=text&pst&format=json';

				$.get(url, function(data) {
					UploadPhotos.wpLicenseTarget.html(data.parse.text['*']);
				}, "json");
			});

			$.tracker.byStr('action/uploadphoto/dialog');
		});
		if (!UploadPhotos.libinit) {
			$.getScript(wgExtensionsPath + "/wikia/ThemeDesigner/js/aim.js");	// TODO: find a permanent place for aim
			UploadPhotos.libinit = true;
		}
	},
	uploadCallback: {
		onComplete: function(res) {
			res = $("<div/>").html(res).text();
			var json = JSON.parse(res);
			if(json) {
				if(json['status'] == 0) {	// 0 is success...
					$.tracker.byStr('action/uploadphoto/upload');
					window.location = wgArticlePath.replace('$1', 'Special:NewFiles');
				} else if(json['status'] == -2) {	// show conflict dialog
					UploadPhotos.step1.hide(400, function() {
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
				$.get(wgScript, {
					wpDestFile: UploadPhotos.destfile.val(),
					action: 'ajax',
					rs: 'moduleProxy',
					moduleName: 'UploadPhotos',
					actionName: 'ExistsWarning',
					outputType: 'html',
					title: wgPageName,
					cb: wgCurRevisionId,
					uselang: wgUserLanguage
				}, function(html) {
					UploadPhotos.dfcache[df] = html;
					UploadPhotos.destFileInputSet(html);
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

var LatestPhotos = {
	init: function() {
		this.carousel = $('.LatestPhotosModule').find('.carousel-container');
		this.carousel.carousel({attachBlindImages: true});
		LatestPhotos.addLightboxTracking();
		$('.timeago').timeago();
	},
	// add extra tracking for lightbox shown for image from latest photos module (RT #74852)
	addLightboxTracking: function() {
		this.carousel.bind('lightbox', function(ev, lightbox) {
			$().log('lightbox shown', 'LatestPhotos');

			var fakeUrl = 'module/latestphotos/';
			var lightboxCaptionLinks = $('#lightbox-caption-content').find('a');

			// user name
			lightboxCaptionLinks.eq(0).trackClick(fakeUrl + 'lightboxusername');

			// page name
			lightboxCaptionLinks.filter('.wikia-gallery-item-posted').trackClick(fakeUrl + 'lightboxlink');

			// "more"
			lightboxCaptionLinks.filter('.wikia-gallery-item-more').trackClick(fakeUrl + 'lightboxmore');
		});
	}
};

$(function() {
    LatestPhotos.init();
    UploadPhotos.init();
});
