var openid = window.openid = {
	current: 'openid',

	show: function(provider) {
		$('#provider_form_' + openid.current).attr('style', 'display:none');
		$('#provider_form_' + provider).attr('style', 'block');

		$('#openid_provider_' + openid.current +'_icon, #openid_provider_' + openid.current + '_link').removeClass('openid_selected');
		$('#openid_provider_' + provider +'_icon, #openid_provider_' + provider + '_link').addClass('openid_selected');

		openid.current = provider;
	},
	update: function() {
		// root is root of all articles (e.g. empty article name)
		var root = wgArticlePath;
		root = root.replace('$1', '');

		$.cookie('openid.provider', openid.current, { path: root, expires: 365 });

		if (openid.current !== 'openid') {
			var param = $('#openid_provider_param_' + openid.current).val();
			$.cookie('openid.param', param, { path: root, expires: 365 });

			$('#openid_url').val($('#openid_provider_url_' + openid.current).val().replace(/{.*}/, param));
		}
	},
	init: function() {
		var provider = $.cookie('openid.provider');
		if (provider !== null) {
			openid.show(provider);
			$('#openid_provider_param_' + openid.current).val($.cookie('openid.param'));
		}
	}
};

$(document).ready(openid.init);
