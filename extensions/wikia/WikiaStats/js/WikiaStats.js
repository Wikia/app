var OneDot = {
	ajaxUrl: wgServer + wgScript + '?action=ajax',
	baseUrl: wgOneDotURL,
	cookieName: wgOneDotCookie,
	uuid: '',
	requesting: 0,

	init: function() {
		if (OneDot.uuid) return;
		if (OneDot.requesting) return;

		OneDot.uuid = $.cookies.get(OneDot.cookieName);
		if (OneDot.uuid) {
			$().log("Found uuid " + OneDot.uuid);
		} else {
			$().log("Requesting new uuid");
			OneDot.requestUUID();
		}
	},

	requestUUID: function () {
		OneDot.requesting = 1;
		$.get(OneDot.ajaxUrl, { rs: "WikiaUUID::getUUID" },
			  function(data) {
				if (data.error !== undefined) {
					// NOK
				} else {
					// OK
					$().log("Assigned new uuid " + data.uuid);
					$.cookies.set(OneDot.cookieName, data.uuid);
					OneDot.uuid = data.uuid;
				}
				OneDot.requesting = 0;

				return true;
			},
			"json"
		);
	},

	track: function(event, version) {
		OneDot.init();

		url = OneDot.baseUrl + "&cb="+(new Date).valueOf();

		if (typeof document.referrer != "undefined") url = url + "&r="+escape(document.referrer);
		if (OneDot.uuid) url = url +  "&uuid=" + OneDot.uuid;
		if (event) url = url + "&event=" + event;
		if (version) url = url + "&version=" + version;

		$().log("OneDot track: " + url);

		$.get(url);

		return true;
	}
}