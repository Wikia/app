define('uuid', function () {
	return function () {
		// https://stackoverflow.com/questions/105034/create-guid-uuid-in-javascript/2117523#2117523
		return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
			var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
			return v.toString(16);
		});
	};
});
