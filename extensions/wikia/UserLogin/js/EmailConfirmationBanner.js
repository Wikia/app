$(function() {
	var $emailConfirmationBannerStatus = $.cookie('emailConfirmationBannerStatus');

	if ($emailConfirmationBannerStatus === '1') {
		new BannerNotification().setType('confirm').setContent('').show();
	} else if ($emailConfirmationBannerStatus === '0') {
		new BannerNotification().setType('error').setContent('').show();
	}
});