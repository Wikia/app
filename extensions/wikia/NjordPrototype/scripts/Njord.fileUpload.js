(function (window, $) {
	'use strict';

	jQuery.event.props.push('dataTransfer');

	var $heroModule = $('#MainPageHero'),
		$heroModuleUpload = $('#MainPageHero .upload'),
		$heroModuleImage = $('#MainPageHero .hero-image');

	//those two are needed to cancel default behaviour
	$heroModuleUpload.on('dragover', function () {
		return false;
	});
	$heroModuleUpload.on('dragend', function () {
		return false;
	});
	$heroModuleUpload.on('drop', function (e) {
		e.preventDefault();
		var fd = new FormData();
		if (e.dataTransfer.files.length) {
			//if file is uploaded
			fd.append('file', e.dataTransfer.files[0]);
		} else if (e.dataTransfer.getData('text/html')) {
			//if url
			var $img = $(e.dataTransfer.getData('text/html'));
			fd.append('url', $img.attr('src'));
		}
		var client = new XMLHttpRequest();
		client.open('POST', '/wikia.php?controller=Njord&method=upload', true);
		client.onreadystatechange = function () {
			if (client.readyState === 4 && client.status === 200) {
				var data = JSON.parse(client.responseText);
				$heroModuleImage.attr('src', data.url);
				$heroModule.trigger('change', [data.url, data.filename]);
			}
		};
		client.send(fd);
	});
})(window, jQuery);
