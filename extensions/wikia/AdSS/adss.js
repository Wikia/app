var AdSS = {
	sponsormsg: null,
	siteAds: [],
	heightThreshold: 600,

	init: function() {
		AdSS.sponsormsg = $("div.sponsormsg > ul");
		// if div exists
		if(AdSS.sponsormsg.length) {
			// show ads only if important content on page is long enough
			var importantContentHeight = $('#WikiaArticle').height();
			importantContentHeight += $('#WikiaArticleComments').height();
			if (importantContentHeight >= AdSS.heightThreshold) {
				// display page ads
				if(typeof(wgAdSS_pageAds) !== 'undefined') {
					$.each( wgAdSS_pageAds, function(i,v) { AdSS.sponsormsg.append(v); } );
				}

				// display a self ads
				if(typeof(wgAdSS_selfAd) !== 'undefined') {
					$(wgAdSS_selfAd).appendTo(AdSS.sponsormsg)
						.find("a").bind( "click", { adId: 0 }, AdSS.onClick );
					$.tracker.byStr( "adss/publisher/view/0" );
				}

				// fetch site ads
				$.getJSON( wgScript, {'action':'ajax', 'rs':'AdSS_Publisher::getSiteAdsAjax', 'cb':'3.1'}, AdSS.onGetSiteAds );
			}
		}
	},

	onGetSiteAds: function(response) {
		// create a flat array for prev/next navigation
		var i;
		for (i=0; i<response.length; i++) {
			// only add real ads
			if (response[i].id > 0) {
				// ignore weight
				if (AdSS.siteAds.length == 0 
				 || AdSS.siteAds[AdSS.siteAds.length-1].id != response[i].id) {
					AdSS.siteAds.push(response[i]);
				}
				// add a back reference
				response[i].idx = AdSS.siteAds.length-1;
			}
		}

		var slot;
		var showedAds = [];
		for (slot=1; slot < response.length/50 + 1; slot++) {
			var rand_no = Math.random() * response.length;
			rand_no = Math.floor(rand_no+1);
			var rand_ad = response[rand_no-1];

			if (rand_ad.id > 0 // only real ads
			   && $.inArray(rand_ad.hash, showedAds) == -1) { // and only these that were not showed yet
				showedAds.push(rand_ad.hash);
				AdSS.replaceAd(
					$("<li></li>").insertBefore( AdSS.sponsormsg.find("li").last() ),
					rand_ad.idx
				);
			}
		}
		AdSS.sponsormsg.parents('.sponsorwrapper').show();
	},

	replaceAd: function(oldAd, adIdx) {
		var adId = AdSS.siteAds[adIdx].id;
		var ad = $(AdSS.siteAds[adIdx].html);

		ad.find("a").bind( "click", {adId: adId}, AdSS.onClick ).before(AdSS.getPrevNext(adIdx));
		ad.css({"position": "relative"});
		
		oldAd.replaceWith(ad);
		
		$.tracker.byStr( "adss/publisher/view/"+adId );
	},

	getPrevNext: function(idx) {
		var prevIdx = idx-1;
		var nextIdx = idx+1;
		if (prevIdx<0) {
			prevIdx = AdSS.siteAds.length-1;
		}
		if (nextIdx==AdSS.siteAds.length) {
			nextIdx = 0;
		}

		var prevnext = $('<div class="prevnext"><a href="#" class="prev" rel="'+prevIdx+'">&lt;</a>&nbsp;<a href="#" class="next" rel="'+nextIdx+'">&gt;</a></div>');
		prevnext.css({"float":"right", "font-size":"80%"});
		prevnext.find("a").css({"border":"1px solid", "padding":"1px"}).click( function(e) {
			e.preventDefault();
			AdSS.replaceAd( $(this).closest("li"), parseInt($(this).attr("rel")) );
		} );

		return prevnext;
	},

	onClick: function(event) {
		$.tracker.byStr( "adss/publisher/click/"+event.data.adId );
	},

	displayForm: function() {
		$(function() {
			// tracking code
			$.tracker.byStr("adss/form/view");
			if( $("#wpType").val() == "site-premium" ) {
				$("#wpSelectSitePremium").parent().addClass("selected");
				$("#wpWeight").val("4").attr("disabled", true);
			}
			else if( $("#wpType").val() == "site" ) {
				$("#wpSelectSite").parent().addClass("selected");
			}
			else if( $("#wpType").val() == "hub" ) {
				$("#wpSelectHub").parent().addClass("selected");
			}
			if( location.href.indexOf("#") == -1 ) {
				location.href = location.href + "#form";
			}
		} );
		$("#wpSelectSite").click( function() {
			$(".SponsoredLinkDesc section").removeClass("selected");
			$(this).parent().addClass("selected");
			$("#wpType").val("site");
			$("#wpWeight").val("1").removeAttr("disabled").parent().show();
			$('.box .corner-right, .box .corner-left').show();
			$('#wpSelectHub').parents('.box').find('.corner-left').hide();
		} );
		$("#wpSelectSitePremium").click( function() {
			$(".SponsoredLinkDesc section").removeClass("selected");
			$(this).parent().addClass("selected");
			$("#wpType").val("site-premium");
			$("#wpWeight").val("4").attr("disabled", true).parent().show();
			$('.box .corner-right, .box .corner-left').show();
		} );
		$("#wpSelectHub").click( function() {
			$(".SponsoredLinkDesc section").removeClass("selected");
			$(this).parent().addClass("selected");
			$("#wpType").val("hub");
			$("#wpWeight").val("1").removeAttr("disabled").parent().show();
			$('.box .corner-right, .box .corner-left').show();
			$('#wpSelectSitePremium').parents('.box').find('.corner-left').hide();
		} );
		$("#adssLoginAction > a").click( function(e) {
			e.preventDefault();
			$("#adssLoginAction").hide();
			$("#wpPassword").parent().show();
		} );
		$("#wpUrl").keyup( function() {
			$("div.sponsormsg-preview > ul > li > a").attr( "href", "http://"+$("#wpUrl").val() );
		} );
		$("#wpText").keyup( function() {
			$("div.sponsormsg-preview > ul > li > a").html( $("#wpText").val() );
		} );
		$("#wpDesc").keyup( function() {
			$("div.sponsormsg-preview > ul > li > p").html( $("#wpDesc").val() );
		} );

		var tooltipNode;
		$(".form-questionmark").mouseover(function() {
			tooltipNode = $('<div id="sponsoredlink-tooltip">'+$(this).attr('data-tooltip')+'</div>')
				.appendTo('.SponsoredLinkForm')
				.css('top', $(this).offset().top-250-$("#sponsoredlink-tooltip").height()+'px')
				.css('left', '81px');
		}).mouseout(function(){
			tooltipNode.remove();
		});

		var animationEnabled = false;
		var modalHtml = '<div id="loading-modal"><h2>'+$.msg('adss-form-modal-title')+'</h2><div id="indicator"><div id="green-dot"></div></div></div>';
		var dotSpeed = 300;
		function dotMove(leftPosition) {
			$('div#green-dot').fadeOut(dotSpeed, function() {
				$(this).css('left', leftPosition+'px');
				$('div#green-dot').fadeIn(dotSpeed, function() {
					leftPosition = leftPosition + 24;
					if (leftPosition == 249) { leftPosition = 129; }
					dotMove(leftPosition);
				});
			});
		}
		$('.paypal-pay .wikia-button').click(function(event) {
			$.ajax({
				type: "POST",
				dataType: "json",
				url: window.wgScriptPath  + "/index.php?title=Special:AdSS&method=process&format=json",
				data: 'wpUrl='+$('.SponsoredLinkForm #wpUrl').val()
					+'&wpText='+$('.SponsoredLinkForm #wpText').val()
					+'&wpDesc='+$('.SponsoredLinkForm #wpDesc').val()
					+'&wpToken='+$('.SponsoredLinkForm #wpToken').val()
					+'&wpType='+$('.SponsoredLinkForm #wpType').val()
					+'&wpEmail='+$('.SponsoredLinkForm #wpEmail').val()
					+'&wpWeight='+$('.SponsoredLinkForm #wpWeight').val(),
				beforeSend: function(){
					$.showModal(
						'',
						modalHtml,
						{
							id: 'paypalModal',
							width: 434,
							showCloseButton: false,
							callback: function() {
								$('#paypay-error').text();
								if (!animationEnabled) {
									animationEnabled = true;
									dotMove(153);
								}
							}
						}
					);
				},
				success: function(data) {
					$('.paypal-error').text('');
					if (data.status == 'error') {
						for(var property in data.form.errors) {
							$('.paypal-error.error-'+property).text(data.form.errors[property]);
						}
						$('#paypalModal').closeModal();
						$('#wpToken').val(data.formToken);
						$.tracker.byStr("adss/form/view/errors");
					}
					else if (data.status == 'ok') {
						window.location = data.paypalUrl;
					}
				}
			});
			event.preventDefault();
		});
	}
}

$(AdSS.init);
