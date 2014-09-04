(function (window, $) {
	'use strict';

	jQuery.event.props.push("dataTransfer");
	var $heroModuleUpload = $('#MainPageHero .upload');
	//those two are needed to cancel default behaviour
	$heroModuleUpload.on('dragover', function () {
		return false;
	});
	$heroModuleUpload.on('dragend', function () {
		return false;
	});
	$heroModuleUpload.on('drop', function (e) {
		e.preventDefault();
		console.info(e.dataTransfer.files)
		var fd = new FormData();
		fd.append('file', e.dataTransfer.files[0]);

		var client = new XMLHttpRequest();
		client.open('POST', '/wikia.php?controller=Njord&method=upload', true);
		client.onreadystatechange = function () {
			if (client.readyState == 4 && client.status == 200) {
				var data = JSON.parse(client.responseText);
				$heroModuleUpload.find('.hero-image').attr('src', data.url);
			}
		}
		client.send(fd);
	});
})(window, jQuery);
