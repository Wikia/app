$(window).load(function() {
	Exitstital.init();
});

var Exitstital = {
	destinationURL: '',
	adUrl: '',

	init: function() {
		Exitstital.attachEventListeners();
	},
	
	attachEventListeners: function() {
		var externalLinks = $('.WikiaArticle a.external');

		$(externalLinks).click(function () { 
			Exitstital.destinationURL = $(this).attr("href");
			Exitstital.adUrl = $(this).attr("ref");

			Exitstital.showInfobox();
			return false;
		});
	},
	
	showInfobox: function() {
		var header = wgExitstitialTitle;
		header += "<a class='wikia-button close-exitstitial-ad'>" + wgExitstitialButton + "</a>";
		header += "<p>" + wgExitstitialRegister + "</p>";
		
		body = "<div class='wikia-ad'>" + Exitstital.loadAd() + "</div>";
		
		html = '<div id="exitstitalInfobox" title="' + header + '"><div>' + body + '</div></div>';
		$("body").append(html);
		$("#exitstitalInfobox").makeModal({width: 600, height: 400});
		$("#exitstitalInfobox .wikia-ad").css('visibility', 'visible');
	
		Exitstital.resizeInfobox();
		Exitstital.addCloseEventListener();
	},
	
	addCloseEventListener: function() {
		if ($('#exitstitalInfoboxWrapper a.wikia-button').exists()) {
			$('#exitstitalInfoboxWrapper a.wikia-button').click(Exitstital.closeInfobox);
		}
	},
	
	// @TODO: add click tracking
	closeInfobox: function() {
		$('.modalWrapper').closeModal();
		window.location.href = Exitstital.destinationURL;
	},
	
	//** Wills magical ad creation will go in here
	loadAd: function() {	
		var ad = '<iframe id="EXITSTITIALIFRAMEAD" scrolling="no" height="250" frameborder="0" width="300" style="border: medium none;" marginwidth="0" marginheight="0" src="' + Exitstital.adUrl + '" noresize="true"></iframe>';
		return ad;
	},
	
	resizeInfobox: function() {
		$('#EXITSTITIALIFRAMEAD').load(function() {
			var iframeHeight = $(this).contents().find("body").height();
			//$('#exitstitalInfoboxWrapper .wikia-ad').css('height', iframeHeight);
			
			$('#exitstitalInfoboxWrapper .wikia-ad').animate({ 
				height: iframeHeight
			}, 200 );
		});
	}
}