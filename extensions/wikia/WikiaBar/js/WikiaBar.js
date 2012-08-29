$.when(
	$.loadMustache(),
	Wikia.getMultiTypePackage({
		mustache: 'extensions/wikia/WikiaBar/templates/WikiaBar_Index.mustache'
	})
	//TODO: put $.nirvana.SendRequest or getJSON here
).done($.proxy(function(libData, templateData, jsonData) {
	var content = $.mustache(
		templateData[0].mustache[0], {
			//var: TODO: jsonData here,
		}
	);
	var wikiaBarObject = $(content);
	$('body').append(wikiaBarObject);
}, this));
