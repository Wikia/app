$(function() {
	if (window.wgShowIE6PhaseOutMessage) {
		// check cookie - show notice only when cookie is NOT set
		var cookie = $.cookies.get('ie6phaseout');

		if (!cookie) {
			$().log('IEPhaseOut6: cookie not set');

			// show notice
			$.get(wgScript + '?action=ajax&rs=IE6PhaseOut::getNotice&uselang='+ wgUserLanguage, function(msg) {
				$(msg).	prependTo('#article').slideDown();

				// set cookie
				$.cookies.set('ie6phaseout', 1, {domain: wgCookieDomain, path: wgCookiePath});
			});
		}
		else {
			$().log('IEPhaseOut6: cookie already set in this session');
		}
	}
});
