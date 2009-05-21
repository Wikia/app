//@see http://jamazon.co.uk/web/2008/07/21/jquerygetscript-does-not-cache 
$.ajaxSetup({cache: true});

jQuery.fn.log = function (msg, group) {
	if (typeof console != 'undefined') {
		if (group) {
			// nice formatting of objects with group prefix
			console.log((typeof msg != 'object' ? '%s: %s' : '%s: %o'), group, msg);
		}
		else {
			console.log(msg);
		}
	}
	else if (typeof opera != 'undefined') {
		opera.postError((group ? (group + ': ') : '') + msg);
	}
	return this;
};

jQuery.fn.getModal = function(url, id, options) {
	// get modal plugin
	$.getScript(stylepath + '/common/jquery/jquery.wikia.modal.js?' + wgStyleVersion, function() {
		$().log('getModal: plugin loaded');

		// get modal content via AJAX
		$.get(url, function(html) {
			$("#positioned_elements").append(html);

			// fire callbackBefore if provided
			if (typeof options == 'object' && typeof options.callbackBefore == 'function') {
				options.callbackBefore();
			}

			// makeModal() if requested
			if (typeof id == 'string') {
				$(id).makeModal(options);
				$().log('getModal: ' + id + ' modal made');
			}

			// fire callback if provided
			if (typeof options == 'object' && typeof options.callback == 'function') {
				options.callback();
			}
		});
	});
}
