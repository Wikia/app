/**
 * AJAX IFRAME METHOD (AIM) rewritten for jQuery
 * @see http://www.webtoolkit.info/
 *
 */
(function($) {

	// handle upload completed event
	function onIFrameLoaded(id) {
		var i = document.getElementById(id),
			d;

		if (i.contentDocument) {
			d = i.contentDocument;
		} else if (i.contentWindow) {
			d = i.contentWindow.document;
		} else {
			d = window.frames[id].document;
		}

		if (d.location.href == "about:blank") {
			return;
		}

		if (typeof(i.onComplete) == 'function') {
			var response = null;

			$().log('upload into "' + id + '" completed', 'AIM');

			if(typeof(d.responseContent) != "undefined") {
				response = d.responseContent;
			} else {
				response = d.body.innerHTML;
			}

			i.onComplete(response);
		}
	}

	// create iframe to handle uploads and return value of its "name" attribute
	function createIFrame(options) {
		var self = this,
			name = 'aim' + Math.floor(Math.random() * 99999),
			iframe = $('<iframe id="' + name + '" name="' + name + '" src="about:blank" style="display:none" />');

		// function to be fired when upload is done
		iframe.bind('load', function() {
			onIFrameLoaded($(this).attr('name'));
		});

		// wrap iframe inside <div> and it to <body>
		$('<div>').
			append(iframe).
			appendTo('body');

		// add custom callback to be fired when upload is completed
		if (options && typeof(options.onComplete) == 'function') {
			iframe[0].onComplete = options.onComplete;
		}
		return name;
	}

	// AIM entry point - used to handle submit event of upload forms
	function submit(form, options) {
		var iframeName = createIFrame(options);

		// upload "into" iframe
		$(form).
			attr('target', iframeName).
			log('uploading into "' + iframeName + '"', 'AIM');

		return (options && (typeof options.onStart === 'function')) ? options.onStart() : true;
	}

	// export
	$.AIM = {
		submit: submit
	};

})(jQuery);
