var SelfServiceAdvertisingSplash = {
	init:function () {
		SelfServiceAdvertisingSplash.trackClick('ssa-splash', WikiaTracker.ACTIONS.IMPRESSION, null, null, null);
		SelfServiceAdvertisingSplash.el = $('#SelfServiceAdvertising');
		SelfServiceAdvertisingSplash.el.click(SelfServiceAdvertisingSplash.clickTrackingHandler);
		$('#SelfServiceAdvertising .get-coupon').click(function (e) {
			SelfServiceAdvertisingSplash.sendEmails();
			e.preventDefault();
		});
	},

	trackClick:function (category, action, label, value, params) {
		var trackingObj = {
			ga_category:category,
			ga_action:action,
			ga_label:label,
			tracking_method:'internal'
		};
		if (value) {
			trackingObj['ga_value'] = value;
		}
		if (params) {
			trackingObj['internal_params'] = params;
		}
		WikiaTracker.trackEvent(trackingObj);
	},

	clickTrackingHandler:function (e) {
		var node = $(e.target);

		if (node.hasClass('get-coupon')) {
			SelfServiceAdvertisingSplash.trackClick('ssa-splash', WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'getcoupon', null, null);
		} else if (node.hasClass('get-started')) {
			SelfServiceAdvertisingSplash.trackClick('ssa-splash', WikiaTracker.ACTIONS.CLICK_LINK_BUTTON, 'getstarted', null, null);
		}
	},

	sendEmails:function () {
		$('.error-code').remove();
		var formData = {};
		$('#SelfServiceAdvertising input[type=text]').each(function() {
			formData[this.name] = this.value;
		});
		$.nirvana.sendRequest({
			controller:'SelfServiceAdvertisingSplashController',
			method: 'sendEmails',
			format: 'json',
			data: formData,
			callback: $.proxy(function(data) {
				if (data.validationResult) {
					SelfServiceAdvertisingSplash.showCouponModal();
				}
				else {
					SelfServiceAdvertisingSplash.showErrors(data.validationMessages);
				}
			}, this)
		});
	},
	
	showCouponModal:function () {
		$.showCustomModal(
			$.msg('ssa-splash-modal-title'),
			$.msg('ssa-splash-modal-content'),
			{
				id: 'couponModal',
				buttons: [
					{
						id: 'ok',
						defaultButton: true,
						message: $.msg('ssa-splash-modal-ok'),
						handler: function(){
							var dialog = $('#couponModal');
							dialog.closeModal();
						}
					}
				]
			}
		);
	},

	showErrors:function (messages) {
		if (messages.name) {
			$('#SelfServiceAdvertising input[name=name]')
				.parent()
				.append("<span class='error-code'>"+messages.name+"</span>");
		}
		if (messages.email) {
			$('#SelfServiceAdvertising input[name=email]')
				.parent()
				.append("<span class='error-code'>"+messages.email+"</span>");
		}
	}

};

$(function () {
	SelfServiceAdvertisingSplash.init();
});
