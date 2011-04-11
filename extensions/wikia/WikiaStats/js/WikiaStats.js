var OneDot = {
	ajaxUrl: wgServer + wgScript + '?action=ajax',
	baseUrl: wgOneDotURL,

	track: function(event, version) {
		var url = OneDot.baseUrl + "&cb="+(new Date).valueOf();

		if (typeof document.referrer != "undefined") url = url + "&r="+escape(document.referrer);
		if (event) url = url + "&event=" + event;
		if (version) url = url + "&version=" + version;

		$().log("OneDot track: " + url);

		$.get(url);

		return true;
	}
}