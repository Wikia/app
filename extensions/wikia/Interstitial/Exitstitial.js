$(window).load(function() {
	/*ExitstitialOutboundScreen set in Interstitial.php*/
	if (window.ExitstitialOutboundScreen) {
		Exitstitial.init();
	}
});

var Exitstitial = {

	settings: {
		destinationURL: '',
		adUrl: ''
	},

	init: function() {
		Exitstitial.attachEventListeners();
	},

	attachEventListeners: function() {
		var externalLinks = $('.WikiaArticle a.external.exitstitial');

		$(externalLinks).click(function () {
			Exitstitial.settings.destinationURL = $(this).attr("href");
			Exitstitial.settings.adUrl = ExitstitialOutboundScreen + "&u=" + Exitstitial.settings.destinationURL;

			Exitstitial.showInfobox();
			return false;
		});
	},

	showInfobox: function() {
		var header = wgExitstitialTitle,
			body = "<div id='ExitstitialInfobox'><div class='wikia-ad'></div></div>";

		$.showModal(header, body, {
			id: 'ExitstitialInfoboxWrapper',
			width: $(window).width() - 250,
			height: $(window).height() - 250
		});

		/*** Make some changes to the modal ***/
		//Remove close button
		$('#ExitstitialInfoboxWrapper').find(".close").hide();
		//Add 'skip ad' button
		$('#ExitstitialInfoboxWrapper').prepend('<a href="' + Exitstitial.settings.destinationURL + '" class="wikia-button close-exitstitial-ad" id="skip_ad">' + wgExitstitialButton + '</a>');
		//Add intro paragraph
		$('#ExitstitialInfoboxWrapper').find("h1:first").after('<p class="exitstitial-intro">' + wgExitstitialRegister + '</p>');
		//Make login and register links in the intro paragraph open the login and register modal dialogs
		$('.exitstitial-intro a').click(function(event) {
			event.preventDefault();
			$('#ExitstitialInfoboxWrapper').closeModal();
			if ($(this).hasClass("register")) {
				openRegister();
			} else if ($(this).hasClass("login")) {
				openLogin();
			}
		});

		//Show ad
		$("#ExitstitialInfobox .wikia-ad").css('visibility', 'visible');

		Exitstitial.ajaxLoadAd();
	},

	ajaxLoadAd: function() {
		$.get(Exitstitial.settings.adUrl, function(data) {
			$("#ExitstitialInfobox").html(data);
		});
	}
};