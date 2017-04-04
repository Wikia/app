function getAdMix() {
	var search = location.search;
	if(search && search.split('?')[1]) {
		var params = search.split('?')[1].split('&');
		for(var i = 0; i < params.length; i++) {
			var paramSplitted = params[i].split('=');
			if(paramSplitted[0] === 'admix') {
				return paramSplitted[1];
			}
		}
	}
	return null;
}