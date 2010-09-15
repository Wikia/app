/**
*
* AJAX IFRAME METHOD (AIM) rewritten for jQuery
* http://www.webtoolkit.info/
*
**/
jQuery.AIM = {
	// AIM entry point - used to handle submit event of upload forms
	submit : function(form, options) {
		var iframeName = jQuery.AIM.createIFrame(options);
		
		// upload "into" iframe
		$(form).
		attr('target', iframeName).
		log('AIM: uploading into "' + iframeName + '"');
		
		if (options && typeof(options.onStart) == 'function')
			return options.onStart();
		else
			return true;
	},
	
	// create iframe to handle uploads and return value of its "name" attribute
	createIFrame : function(options) {
		var name = 'aim' + Math.floor(Math.random() * 99999);
		var iframe = $('<iframe id="' + name + '" name="' + name + '" src="about:blank" style="display:none" />');
		
		// function to be fired when upload is done
		iframe.bind('load', function() {
			jQuery.AIM.loaded($(this).attr('name'));
		});
		
		// wrap iframe inside <div> and it to <body>
		$('<div>').
		append(iframe).
		appendTo('body');
		
		// add custom callback to be fired when upload is completed
		if (options && typeof(options.onComplete) == 'function')
			iframe[0].onComplete = options.onComplete;
		
		return name;
	},
	
	// handle upload completed event
	loaded : function(id) {
		$().log('AIM: upload into "' + id + '" completed');
		var i = document.getElementById(id);
		
		if (i.contentDocument)
			var d = i.contentDocument;
		else if (i.contentWindow)
			var d = i.contentWindow.document;
		else
			var d = window.frames[id].document;
		
		if (d.location.href == "about:blank")
			return;
		
		if (typeof(i.onComplete) == 'function') {
			var response = null;
			
			if(typeof(d.responseContent) != "undefined")
				response = d.responseContent;
			else {
				//in Chrome/safari an empty div is appended to the JSON data in case of upload issues (e.g. already existing image)
				//the solution was to append a new line at the end of the JSON string and split it here.
				response = d.body.innerHTML.split("\n")[0];
			}
			
			i.onComplete(response);
		}
	}
}